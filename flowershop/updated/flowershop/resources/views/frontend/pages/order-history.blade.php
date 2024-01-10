@extends('frontend.layouts.app')

@section('main-content')
<!-- order history -->
<section class="order-history-section common-spacing">
    <article class="container">
        <div class="cart-list">
            <div class="title-block">
                <h1>Order History</h1>
            </div>
            @if($products != null)
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
                        @foreach($products as $order)
                            @if($order->product != null)
                                <tr>
                                    <td valign="top">{{ $order->product->getEnglishTitle() }}</p>
                                        <p class="order-id">{{ $order->product->sku }}</p>
                                        <div class="cart-items multiple">
                                            @if($order->color_id != null && $order->color != null)
                                                <div class="cart-single-item">
                                                    <div class="cart-single-item_image" style="background-image: url('{{ generateURL($order->color->image) }} ');">
                                                    
                                                    </div>
                                                </div>
                                            @else
                                                <div class="cart-single-item">
                                                    <div class="cart-single-item_image" style="background-image: url('{{ generateURL($order->product->image) }} ');">
                                                    </div>
                                                </div>
                                            @endif
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
                                    @if($order->color != null)
                                        <td valign="top">{{ $order->color->color->getTitle() }}</td>
                                    @else
                                        <td valign="top">Default</td>
                                    @endif
                                    <td valign="top">{{ $order->quantity }}</td>
                                    <td valign="top"> ${{ $order->product->order_amount }} </td>
                                    <td valign="top">{{ $order->custom_id }}</td>
                                    <td valign="top"><a href="{{ route('order.detail',$order->custom_id) }}">View order detail</a></td>
                                </tr>
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
