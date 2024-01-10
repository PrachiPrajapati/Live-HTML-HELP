@if(!$products->isEmpty())
<div class="products-list" id="filterProducts">
    <div class="row" id="allProducts">
        @foreach($products as $product)
            <div class="col-md-6 col-lg-4">
                <div class="products-list_item">
                    <div class="products-list_image">
                        <a href="{{ route($local.'.product.show',$product['slug']) }}">
                            <img src="{{ generateURL($product['image']) }}" alt="product">
                        </a>
                    </div>
                    <div class="products-list_details">
                        <ul>
                            <li>
                                <h4><a href="{{ route($local.'.product.show',$product['slug']) }}">{{ $product->getTitle() }}</a></h4>
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
                        <h4>{{ __("AED") }} {{ $product['order_amount'] }}</h4>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-md-flex  justify-content-md-between justify-content-center align-items-center">
                {{ $products->links() }}
                
                {{--
                @if($count_load_more != $products->count() && $count_load_more > 0)
                <!-- <div>
                    <center><button class="input-group-text common-black-btn load-more" id="btn-load-more" data-offset="{{ $products->count() }}">{{ __("Load More") }}</button></center>
                </div> -->
                @endif
                --}}
                    <div class="cat-filter ml-md-auto  mt-md-0 mt-4 mb-0">
                        <div class="form-fields">
                            <ul>
                                <li>
                                    <div class="field limiter d-flex justify-content-center align-items-center">
                                    
                                    <label class="label" for="limiter">
                                        <span>{{ __("Show") }}</span>
                                    </label>
                                    <div class="control">
                                        <select id="limiter" data-role="limiter" class="limiter-options">
                                            @if($count_per_page != null)
                                                @if($count_per_page == 9)
                                                    <option value="9" selected="selected">9</option>
                                                    <option value="12">12</option>
                                                    <option value="15">15</option>
                                                    <option value="30">30</option>
                                                    <option value="50">50</option>
                                                    <option value="all">All</option>
                                                @elseif($count_per_page == 12)
                                                    <option value="9">9</option>
                                                    <option value="12" selected="selected">12</option>
                                                    <option value="15">15</option>
                                                    <option value="30">30</option>
                                                    <option value="50">50</option>
                                                    <option value="all">All</option>
                                                @elseif($count_per_page == 15)
                                                    <option value="9">9</option>
                                                    <option value="12">12</option>
                                                    <option value="15" selected="selected">15</option>
                                                    <option value="30">30</option>
                                                    <option value="50">50</option>
                                                    <option value="all">All</option>
                                                @elseif($count_per_page == 30)
                                                    <option value="9">9</option>
                                                    <option value="12">12</option>
                                                    <option value="15">15</option>
                                                    <option value="30" selected="selected">30</option>
                                                    <option value="50">50</option>
                                                    <option value="all">All</option>
                                                @elseif($count_per_page == 50)
                                                    <option value="9">9</option>
                                                    <option value="12">12</option>
                                                    <option value="15">15</option>
                                                    <option value="30">30</option>
                                                    <option value="50" selected="selected">50</option>
                                                    <option value="all">All</option>
                                                @elseif($count_per_page == "all")
                                                    <option value="9">9</option>
                                                    <option value="12">12</option>
                                                    <option value="15">15</option>
                                                    <option value="30">30</option>
                                                    <option value="50">50</option>
                                                    <option value="all" selected="selected">All</option>
                                                @elseif($count_per_page >= 51)
                                                    <option value="9">9</option>
                                                    <option value="12">12</option>
                                                    <option value="15">15</option>
                                                    <option value="30">30</option>
                                                    <option value="50">50</option>
                                                    <option value="all" selected="selected">All</option>
                                                @else
                                                    <option value="9">9</option>
                                                    <option value="12">12</option>
                                                    <option value="15">15</option>
                                                    <option value="30">30</option>
                                                    <option value="50">50</option>
                                                    <option value="all">All</option>
                                                @endif
                                            @endif
                                        </select>
                                    </div>
                                    <span class="limiter-text">{{ __("per page") }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
</div>
@else
<div id="filterProducts">
    <center><p>{{ __("0 results for your search.") }}</p></center>
</div>
@endif