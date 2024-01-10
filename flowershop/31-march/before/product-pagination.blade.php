@if(!$products->isEmpty())
<div class="products-list" id="filterProducts">
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-6 col-lg-4">
                <div class="products-list_item">
                    <div class="products-list_image">
                        <a href="{{ route('product.show',$product['slug']) }}">
                            <img src="{{ generateURL($product['image']) }}" alt="product">
                        </a>
                    </div>
                    <div class="products-list_details">
                        <ul>
                            <li>
                                <h4><a href="{{ route('product.show',$product['slug']) }}">{{ $product->getTitle() }}</a></h4>
                            </li>
                            <li>
                                @if( in_array($product->id,$favourite_product) )
                                <li>
                                    <a href="javascript:;" class="add-to-wishlist active" data-product_id="{{ $product['id'] }}" data-custom_id="{{ $product['custom_id'] }}"><img src="{{ asset('frontend/images/heart-sprite.svg') }}" alt="wishlist"></a>
                                </li>
                                @else
                                <li id="product_favourite">
                                    <a href="javascript:;" class="add-to-wishlist" data-product_id="{{ $product['id'] }}" data-custom_id="{{ $product['custom_id'] }}"><img src="{{ asset('frontend/images/heart-sprite.svg') }}" alt="wishlist"></a>
                                </li>
                                @endif
                            </li>
                        </ul>
                        <h4>AED {{ $product['order_amount'] }}</h4>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $products->links() }}
</div>
@else
<div id="filterProducts">
    <center><p>0 results for your search.</p></center>
</div>
@endif