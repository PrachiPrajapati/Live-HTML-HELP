@extends('frontend.layouts.app')

@section('main-content')

<!-- order-confirmation -->
<section class="order-confirmation common-spacing">
    <article class="container">
    @if($orders!= null && $orders != '[]')
        <div class="order-confirmation_header">
                <div class="order-confirmation_header-left">
                    <div class="row">
                        <div class="col-md-7 col-lg-5">
                            <h2>Your Order Is Confirmed</h2>
                            <p>Thanks for shopping! Your order has been confirmed. We will send you an email when we ship it to you.</p>
                        </div>
                    </div>
                </div>
                <div class="order-confirmation_header-right">
                    <a href="{{ route('order.history') }}" class="common-black-btn">Your Orders</a>
                </div>
        </div>
        <div class="ordered-list">
            <div class="cart-list">
                <div class="title-block">
                    @if($transaction != null)
                        <h4>Order ID: #{{ $transaction->cart_id }}</h4>
                    @endif
                </div>
                <div class="table-responsive">
                    <table width="100%">
                        <tbody>
                        @foreach($orders as $order)
                            @if($order->product != null)
                            <tr>
                                <td width="80%">
                                        <div class="cart-single-item">
                                            @if($order->color_id != null && $order->color != null)
                                                <div class="cart-single-item_image" style="background-image: url('{{ generateURL($order->color->image) }}');">
                                                    <a href="{{ route('product.show',$order->product->slug) }}"></a>
                                                </div>
                                            @else
                                                <div class="cart-single-item_image" style="background-image: url('{{ generateURL($order->product->image) }}');">
                                                    <a href="{{ route('product.show',$order->product->slug) }}"></a>
                                                </div>
                                            @endif
                                            <div class="cart-single-item_detail">
                                                <p>
                                                    <a href="{{ route('product.show',$order->product->slug) }}">{{ $order->product->getEnglishTitle() }}</a>
                                                </p>
                                                <p class="product-code">Product ID: #{{ $order->product->sku }}</p>
                                            </div>
                                        </div>
                                </td>
                                <td>
                                        <h4>{{ $order->quantity }}pcs</h4>
                                </td>
                                <td>
                                        <h4>AED {{ $order->product->order_amount }}</h4>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="confirmation-summary">
            <div class="table-responsive">
                <table width="100%">
                    <tbody>
                        <tr>
                            <td width="80%" valign="top">
                                <h4>Payment Summary</h4>
                                <p>
                                    <strong>Jetmir Haxhiavdyli</strong><br/>
                                    <strong>**** **** **** 4242</strong>
                                </p>
                            </td>
                            <td>
                                <table width="100%" class="confirmation-summary_details">
                                    <tr>
                                        <td>SUBTOTAL</td>
                                        <td>${{ $subTotal }}</td>
                                    </tr>
                                    <tr>
                                        <td>SHIPPING</td>
                                        <td>${{ $delivery_charge  }}</td>
                                    </tr>
                                    <tr>
                                        <td>TAX</td>
                                        <td>${{ $tax }}</td>
                                    </tr>
                                    <tr>
                                        <td><span>ORDER TOTAL</span></td>
                                        <td>${{ $total }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    </article>
</section>
@endsection
