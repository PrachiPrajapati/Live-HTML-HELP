@extends('frontend.layouts.app')

@section('main-content')

<!-- order detail -->
<section class="order-detail-section order-history-section common-spacing">
    <article class="container">
        <div class="title-block">
            <h1>Order Summary</h1>
        </div>
        <div class="order-summary_detail">
            <div class="order-summary_detail-left">
                <ul>
                    @if(Auth::check())
                        <li><strong>Name:</strong> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</li>
                    @endif
                    @if($product->order->transaction != null)
                    <li><strong>Order Number:</strong> {{ $product->custom_id }} </li>
                    @endif

                    @if($product->order->transaction != null)
                        <li><strong>Address:</strong> {{ $product->order->transaction->billing_address_1 }} </li>
                    @else
                        <li><strong>Address:</strong> - </li>
                    @endif

                    @if($product->order->transaction != null)
                        <li><strong>Email:</strong> {{ $product->order->transaction->billing_email }} </li>
                    @endif
                    <li><strong>Phone:</strong> {{ Auth::user()->contact }} </li>
                </ul>
            </div>
            <div class="order-summary_detail-right">
                <ul>
                    <li><strong>Status:</strong> {{ $product->order->status }} </li>
                    <li><strong>Order Date:</strong> {{ $product->order->order_date }} </li>
                    <li><strong>Delivery Date:</strong> {{ $product->order->delivery_date }} </li>
                    <li><strong>Delivery Time:</strong> {{ $product->order->delivery_time }}</li>
                </ul>
            </div>
        </div>
        <div class="cart-list">
            <div class="table-responsive">
                <table width="100%">
                    <thead>
                        <tr>
                            <th width="80%">Product</th>
                            <th width="8%">Color</th>
                            <th width="8%">QTY</th>
                            <th width="4%">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td valign="top">
                                <div class="cart-items">
                                    <div class="cart-single-item">
                                        @if($product->product != null)
                                        <div class="cart-single-item_image" style="background-image: url('{{ generateURL( $product->product->image) }}');">
                                        </div>
                                        @elseif($product->addon != null)
                                        <div class="cart-single-item_image" style="background-image: url('{{ generateURL( $product->addon->getImage()) }}');">
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="order-name">
                                    @if($product->product != null)
                                        <p>{{ $product->product->getTitle() }}</p>
                                    @elseif($product->addon != null)
                                        <p>{{ $product->addon->getTitle() }}</p>
                                    @endif
                                    <p class="order-id">
                                    @if($product->product != null)
                                        {{ $product->product->sku }}
                                    @elseif($product->addon != null)
                                        {{ $product->addon->sku }}
                                    @endif
                                    </p>
                                </div>
                            </td>
                            @if($color_name != null)
                                <td valign="top">{{ $color_name }}</td>
                            @else
                                <td valign="top">Default</td>
                            @endif
                            <td valign="top">{{ $product->quantity }}pcs</td>
                            <td valign="top">AED {{ $product->price }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="confirmation-summary">
            <div class="table-responsive">
                <table width="100%">
                    <tbody>
                        <tr>
                            <td width="80%" valign="top"> </td>
                            <td>
                                <table width="100%" class="confirmation-summary_details">
                                    <tr>
                                        <td>SUBTOTAL</td>
                                        <td>AED {{ $product->total_amount - $product->delivery_charge }}</td>
                                    </tr>
                                    <tr>
                                        <td>SHIPPING</td>
                                        <td>AED {{ $product->delivery_charge }}</td>
                                    </tr>
                                    <tr>
                                        <td>TAX</td>
                                        <td>AED {{ $product->vat_amount }}</td>
                                    </tr>
                                    <tr>
                                        <td><span>ORDER TOTAL</span></td>
                                        <td>AED {{ $product->billing_amount }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </article>
</section>
@endsection
