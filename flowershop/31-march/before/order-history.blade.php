@extends('frontend.layouts.app')

@section('main-content')
<!-- order history -->
<section class="order-history-section common-spacing">
    <article class="container">
        <div class="cart-list">
            <div class="title-block">
                <h1>Order History</h1>
            </div>
            @if(!$orders->isEmpty())
                <div class="table-responsive">
                    <table width="100%">
                        <thead>
                            <tr>
                                <th width="40%">Product</th>
                                <th>Status</th>
                                <th>Color</th>
                                <th>QTY</th>
                                <th>Price</th>
                                <th>Order Number</th>
                                <th width="8%"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            @if($order->orderdetails != null)
                                @foreach($order->orderdetails as $order_detail)
                                    @if($order_detail->product != null)
                                        <tr>
                                            <td valign="top">{{ $order_detail->product->getTitle() }}</p>
                                                <p class="order-id">{{ $order_detail->product->sku }}</p>
                                                <div class="cart-items multiple">
                                                    <div class="cart-single-item">
                                                        <div class="cart-single-item_image" style="background-image: url('{{ generateURL($order_detail->product->image) }} ');">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td valign="top">
                                                @if($order->status == "Ordered")
                                                    <span class="badge badge-pill badge-primary">{{ $order->status }}</span>
                                                @elseif($order->status == "Processing")
                                                    <span class="badge badge-pill badge-info">{{ $order->status }}</span>
                                                @elseif($order->status == "Under Processing")
                                                    <span class="badge badge-pill badge-info">{{ $order->status }}</span>
                                                @elseif($order->status == "On The Way")
                                                    <span class="badge badge-pill badge-info">{{ $order->status }}</span>
                                                @elseif($order->status == "Delivered")
                                                    <span class="badge badge-pill badge-success">{{ $order->status }}</span>
                                                @elseif($order->status == "Cancelled")
                                                    <span class="badge badge-pill badge-warning">{{ $order->status }}</span>
                                                @elseif($order->status == "Refunded")
                                                    <span class="badge badge-pill badge-danger">{{ $order->status }}</span>
                                                @endif
                                            </td>
                                            @if($order_detail->product->color_id != null)
                                                <td valign="top">{{ $order_detail->product->color_id }}</td>
                                            @else
                                                <td valign="top">Default</td>
                                            @endif
                                            <td valign="top">{{ $order_detail->quantity }}</td>
                                            <td valign="top">AED {{ $order_detail->product->order_amount }} </td>
                                            <td valign="top">{{ $order_detail->custom_id }}</td>
                                            <td valign="top"><a href="{{ route('order.detail',$order_detail->custom_id) }}">View order detail</a></td>
                                        </tr>
                                    @elseif($order_detail->addon != null)
                                          <tr>
                                            <td valign="top">{{ $order_detail->addon->getTitle() }}</p>
                                                <p class="order-id">{{ $order_detail->addon->sku }}</p>
                                                <div class="cart-items multiple">
                                                    <div class="cart-single-item">
                                                        <div class="cart-single-item_image" style="background-image: url('{{ generateURL($order_detail->addon->getImage()) }} ');">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td valign="top">
                                                @if($order->status == "Ordered")
                                                    <span class="badge badge-pill badge-primary">{{ $order->status }}</span>
                                                @elseif($order->status == "Processing")
                                                    <span class="badge badge-pill badge-info">{{ $order->status }}</span>
                                                @elseif($order->status == "Under Processing")
                                                    <span class="badge badge-pill badge-info">{{ $order->status }}</span>
                                                @elseif($order->status == "On The Way")
                                                    <span class="badge badge-pill badge-info">{{ $order->status }}</span>
                                                @elseif($order->status == "Delivered")
                                                    <span class="badge badge-pill badge-success">{{ $order->status }}</span>
                                                @elseif($order->status == "Cancelled")
                                                    <span class="badge badge-pill badge-warning">{{ $order->status }}</span>
                                                @elseif($order->status == "Refunded")
                                                    <span class="badge badge-pill badge-danger">{{ $order->status }}</span>
                                                @endif
                                            </td>
                                            <td valign="top">Default</td>
                                            <td valign="top">{{ $order_detail->quantity }}</td>
                                            <td valign="top">AED {{ $order_detail->addon->price }} </td>
                                            <td valign="top">{{ $order_detail->custom_id }}</td>
                                            <td valign="top"><a href="{{ route('order.detail',$order_detail->custom_id) }}">View order detail</a></td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                         @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>Order Our Products.</p>
            @endif
        </div>
    </article>
</section>
@endsection
