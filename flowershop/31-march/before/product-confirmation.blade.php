@extends('frontend.layouts.app')

@push('banner-section')
@if($banner != null && $banner != '[]')
<!--******************* Banner Section Start ******************-->
<div class="banner small-banner d-flex align-items-center no-overlay" style="background-image: url({{ generateURL($banner->getBannerImage()) }});">
</div>
<!--******************* Banner Section End ******************-->
@endif
@endpush

@section('main-content')
<!--******************* Middle Section Start ******************-->
<!-- product confirmation section -->
<section class="product-confirmation common-spacing">
    <article class="container">
        <h2 class="mb-4">Product Confirmation</h2>
        <div class="row address-block">
            <div class="col-md-6">
                <h5 class="mb-3"><b>Delivery Address</b></h5>
                <ul>
                    <li><b>Name:</b> {{ $request->delivery_first_name }} {{ $request->delivery_last_name }}</li>
                    <li><b>Address:</b> {{ $request->delivery_address }}</li>
                    <li><b>Pincode:</b> {{ $request->delivery_pincode }}</li>
                    <li><b>Contact:</b> {{ $request->delivery_phone }}</li>
                    <li><b>Email:</b> {{ $request->delivery_email }}</li>
                    <li><b>City:</b> {{ $request->delivery_city }}</li>
                    <li><b>Country:</b> {{ $request->delivery_country }}</li>
                </ul>
            </div>
            @if(Auth::check())
                <div class="col-md-6">
                    <h5 class="mb-3"><b>Billing Address</b></h5>
                    <ul>
                        <li><b>Name:</b> {{ $request->billing_first_name }} {{ $request->billing_last_name }}</li>
                        <li><b>Address:</b> {{ $request->billing_address }}</li>
                        <li><b>Pincode:</b> {{ $request->billing_pincode }}</li>
                        <li><b>Contact:</b> {{ $request->billing_phone }}</li>
                        <li><b>Email:</b> {{ $request->billing_email }}</li>
                        <li><b>City:</b> {{ $request->billing_city }}</li>
                        <li><b>Country:</b> {{ $request->billing_country }}</li>
                    </ul>
                </div>
            @endif
        </div>
        <div class="order-detail">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3"><b>Order Details</b></h5>
                        <ul>
                            <li><b>Delivery Date:</b> {{ $request->delivery_date }}</li>
                            <li><b>Delivery Time:</b> {{ $request->delivery_time }}</li>
                            @if($request->delivery_comment != null)
                            <li><b>Comment:</b> {{ $request->delivery_comment }}</li>
                            @endif
                        </ul>
                </div>
            </div>
        </div>
        @if($products != null && $products != '[]')
        <form class="common-form" id="frmCheckout" method="POST" action="{{ route('payment') }}" target="telrPaymentFrame">
        @csrf
                <input type="hidden" name="vads_action_mode" value="IFRAME" />

                <input type="hidden" name="delivery_first_name" value="{{ $request->delivery_first_name }}">
                <input type="hidden" name="delivery_last_name" value="{{ $request->delivery_last_name }}">
                <input type="hidden" name="delivery_address" value="{{ $request->delivery_address }}">
                <input type="hidden" name="delivery_pincode" value="{{ $request->delivery_pincode }}">
                <input type="hidden" name="delivery_phone" value="{{ $request->delivery_phone }}">
                <input type="hidden" name="delivery_email" value="{{ $request->delivery_email }}">
                <input type="hidden" name="delivery_city" value="{{ $request->delivery_city }}">
                <input type="hidden" name="delivery_country" value="{{ $request->delivery_country }}">
                <input type="hidden" name="billing_first_name" value="{{ $request->billing_first_name }}">
                <input type="hidden" name="billing_last_name" value="{{ $request->billing_last_name }}">
                <input type="hidden" name="billing_address" value="{{ $request->billing_address }}">
                <input type="hidden" name="billing_pincode" value="{{ $request->billing_pincode }}">
                <input type="hidden" name="billing_phone" value="{{ $request->billing_phone }}">
                <input type="hidden" name="billing_email" value="{{ $request->billing_email }}">
                <input type="hidden" name="billing_city" value="{{ $request->billing_city }}">
                <input type="hidden" name="billing_country" value="{{ $request->billing_country }}">
                <input type="hidden" name="delivery_date" value="{{ $request->delivery_date }}">
                <input type="hidden" name="delivery_time" value="{{ $request->delivery_time }}">
                <input type="hidden" name="delivery_comment" value="{{ $request->delivery_comment }}">

                <input type="hidden" name="first_name" value="{{ $request->first_name }}">
                <input type="hidden" name="last_name" value="{{ $request->last_name }}">
                <input type="hidden" name="address" value="{{ $request->address }}">
                <input type="hidden" name="pincode" value="{{ $request->pincode }}">
                <input type="hidden" name="contact" value="{{ $request->contact }}">
                <input type="hidden" name="email" value="{{ $request->email }}">
                <input type="hidden" name="emirate" value="{{ $request->emirate }}">
                <input type="hidden" name="city" value="{{ $request->city }}">
                <input type="hidden" name="quantity" value="{{ $request->quantity }}">
                <br><br>
                <h5 class="mb-3"><b>Product Details</b></h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="30%">Product</th>
                                <th>Color</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(Auth::check())
                                @foreach($products as $product)
                                    @if($product->product != null)
                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="inner-table">
                                                    <tbody>
                                                        <tr>
                                                            <td>Name: {{ $product->product->getTitle() }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>SKU: {{ $product->product->sku }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td>
                                            @if($product->product->color_id != null ) 
                                                {{ $product->product->color_id }}
                                            @else
                                                Default
                                            @endif
                                            </td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>AED {{ $product->product->order_amount }}</td>
                                        </tr>
                                    @elseif($product->addon != null)
                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="inner-table">
                                                    <tbody>
                                                        <tr>
                                                            <td>Name: {{ $product->addon->getTitle() }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>SKU: {{ $product->addon->sku }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td>
                                                Default
                                            </td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>AED {{ $product->addon->price }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="inner-table">
                                                <tbody>
                                                    <tr>
                                                        <td>Name: {{ $product->getTitle() }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>SKU: {{ $product->sku }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                        @if($product->color_id != null ) 
                                           {{ $product->color_id }}
                                        @else
                                            Default
                                        @endif
                                        </td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>AED {{ $product->order_amount }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            <tr>
                                <td colspan="4" height="1" style="padding: 0; background-color: #dee2e6;"></td>
                            </tr>
                            <tr class="no-border">
                                <td colspan="3"></td>
                                <td><b>Subtotal:</b> AED {{ $subTotal }}</td>
                            </tr>
                            <tr class="no-border">
                                <td colspan="3"></td>
                                <td><b>Shipping:</b> AED {{ $delivery_charge }}</td>
                            </tr>
                            <tr class="no-border">
                                <td colspan="3"></td>
                                <td><b>Tax: </b> AED {{ $vat }}</td>
                            </tr>
                            <tr class="no-border">
                                <td colspan="3"></td>
                                <td><b>Total: </b> AED {{ $total }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" height="1" style="padding: 0; background-color: #dee2e6;"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <button type="submit" id="btn-orderNow" class="common-black-btn">Order Now</button>
                </div>
            </div>
        </form>
        @endif
    </article>
</section>
@endsection

@push('extra-js')
<script type="text/javascript">
    $("#btn-orderNow").on('click',function(){
        showLoader();
    });

    //Remove Local Storage Data(Guest User)
    localStorage.removeItem("first_name");
    localStorage.removeItem("last_name");
    localStorage.removeItem("address");
    localStorage.removeItem("contact");
    localStorage.removeItem("email");
    localStorage.removeItem("pincode");
    localStorage.removeItem("guest_checkout_country");
    localStorage.removeItem("guest_checkout_city");
    localStorage.removeItem("delivery_date");
    localStorage.removeItem("delivery_time");
    localStorage.removeItem("delivery_comment");
</script>
@endpush
<!--******************* Middle Section End ******************-->