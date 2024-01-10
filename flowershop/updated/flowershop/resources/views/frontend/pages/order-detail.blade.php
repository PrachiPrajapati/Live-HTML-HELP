@extends('frontend.layouts.app')

@section('main-content')

<!-- order detail -->
<section class="order-detail-section order-history-section common-spacing">
    <article class="container">
            <div class="back">
                <a href="{{ route('order.history') }}"><strong>Back</strong></a>
            </div>
            <div class="title-block">
                <h1>Order Summary</h1>
            </div>
            <div class="order-summary_detail">
                <div class="order-summary_detail-left">
                    <ul>
                        @if($product->transaction != null)
                        <li><strong>Order Number:</strong> {{ $product->custom_id }} </li>
                        @endif

                        @if($product->cart_id != null && $product->transaction != null)
                            <li><strong>Address:</strong> {{ $product->transaction->billing_address_1 }} </li>
                        @else
                            <li><strong>Address:</strong> - </li>
                        @endif

                        @if($product->transaction != null)
                            <li><strong>Email:</strong> {{ $product->transaction->billing_email }} </li>
                        @endif
                        <li><strong>Phone:</strong> {{ Auth::user()->contact }} </li>
                    </ul>
                </div>
                <div class="order-summary_detail-right">
                    <ul>
                        <li><strong>Status:</strong> {{ $product->status }} </li>
                        <li><strong>Order Date:</strong> {{ $product->order_date }} </li>
                        <li><strong>Delivery Date:</strong> {{ $product->delivery_date }} </li>
                        <li><strong>Delivery Time:</strong> {{ $product->delivery_time }}</li>
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
                                            @if($product->color_id != null && $product->color != null)
                                                <div class="cart-single-item_image" style="background-image: url('{{ generateURL($product->color->image) }}');">
                                                </div>
                                            @else
                                                <div class="cart-single-item_image" style="background-image: url('{{ generateURL( $product->product->image) }}');">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="order-name">
                                        <p>{{ $product->product->getEnglishTitle() }}</p>
                                        <p class="order-id">{{ $product->product->sku }}</p>
                                    </div>
                                </td>
                                @if($product->color != null)
                                    <td valign="top">{{ $product->color->color->getTitle() }}</td>
                                @else
                                    <td valign="top">Default</td>
                                @endif
                                <td valign="top">{{ $product->quantity }}pcs</td>
                                <td valign="top"> ${{ $product->price }} </td>
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
                                            <td>${{ $product->total_amount - $product->delivery_charge }}</td>
                                        </tr>
                                        <tr>
                                            <td>SHIPPING</td>
                                            <td>${{ $product->delivery_charge }}</td>
                                        </tr>
                                        <tr>
                                            <td>TAX</td>
                                            <td>${{ $product->vat_amount }}</td>
                                        </tr>
                                        <tr>
                                            <td><span>ORDER TOTAL</span></td>
                                            <td>${{ $product->billing_amount }}</td>
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
