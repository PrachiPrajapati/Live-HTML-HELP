@extends('frontend.layouts.app')

@section('main-content')

<!-- Favorites section -->
<section class="cart-section favourites common-spacing">
    <article class="container">
        <form method="POST" id="frmAddToCart">
                <div class="title-block has-subtitle">
                    <h4>My Wishlist</h4>
                    @if($products != null && $products != '[]')
                        @if(count($products) > 1)
                            <a href="{{ route('addall-to-cart') }}"><button type="button" id="addAllToCart" class="common-black-btn">Add All to Cart</button></a>
                        @endif
                    @endif
                </div>
                <div class="add-more-items">
                    <div class="products-list">
                        <div class="row">
                        @if($products != null && $products != '[]') 
                            @foreach($products as $product)
                                @if($product->product != null)
                                <div class="col-md-6 col-lg-3">
                                    <div class="products-list_item">
                                        <div class="products-list_image">
                                            @if($product->color != null)
                                                <a href="{{ route('product.show',$product->product->slug) }}">
                                                    <img src="{{ generateURL($product->color->image) }}" alt="product">
                                                </a>
                                            @else
                                                <a href="{{ route('product.show',$product->product->slug) }}">
                                                    <img src="{{ generateURL($product->product->image) }}" alt="product">
                                                </a>
                                            @endif
                                            <a href="" data-product_id="{{ $product->product->id }}" class="remove-item remove-from-wishlist"><img src="{{ asset('frontend/images/close.png') }}" alt="remove"></a>
                                        </div>
                                        <div class="products-list_details">
                                            <ul>
                                                <li>
                                                    <h4><a href="{{ route('product.show',$product->product->slug) }}">{{ $product->product->getEnglishTitle() }}</a></h4>
                                                </li>
                                                <li>
                                                    <h4>AED {{ $product->product->order_amount }}.00</h4>
                                                </li>
                                            </ul>
                                            @if($product->product->total_stock >= 0)
                                                <a class="view-btn addToCartLink" data-product_id="{{ $product->product->id }}" data-color_id="{{ $product->color_id }}" data-minqty="{{ $product->product->minimum_qty }}" data-count="{{ count($products) }}" style="cursor: pointer;">Add to Cart <img src="{{ asset('frontend/images/arrow-right-dark.svg') }}" alt="arrow"></a>
                                            @else
                                                <a class="view-btn">Not Available</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        @else
                        <div class="col-md-6 col-lg-3">
                            <div class="products-list_item">        
                                <p id="noProduct">Wishlist is empty.</p>    
                            </div>
                        </div>    
                        @endif
                        </div>
                        {{ $products->links() }}
                    </div>
                </div>
        </form>
    </article>
</section>
@endsection

@push('extra-js')
    <script type="text/javascript">
        $(document).ready(function() {
            
            $(".addToCartLink").on('click',function(){
          
                var element             = $(this);
                var product_id          = $(this).data('product_id');
                var color_id            = $(this).data('color_id');
                var min_purchase_qty    = $(this).data('minqty');   
                var count               = $(this).data('count');
                
                $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        url: "{{ route('add-to-cart') }}",
                        data: {
                             _token: '{{ csrf_token() }}',
                             product_id : product_id,
                             color_id   : color_id,
                             quantity   : min_purchase_qty,
                        },
                        success: function(Response){
                            if(Response.success){
                                element.parent().parent().parent().remove();
                                $('#header').replaceWith(Response.header);
                                if(count<=2){
                                    $('#addAllToCart').remove();
                                }
                                if(count == 1){
                                    $('.products-list').replaceWith('<p id="noProduct">Wishlist is empty.</p>');
                                }
                            }
                        },
                });
                return false;
           });

           $(".remove-from-wishlist").on('click',function(){
                var element    = $(this);
                var product_id = $(this).data('product_id');
           
                $.ajax({
                        type: 'DELETE',
                        dataType: 'JSON',
                        url: "{{ route('remove-from-wishlist') }}",
                        data: {
                                _token: '{{ csrf_token() }}',
                                product_id : product_id,
                            },
                        success: function(Response){
                            if(Response.success){
                                element.parent().parent().parent().remove();
                                //$('#header').replaceWith(Response.header);
                            }
                            if(Response.noProduct){
                                $("#empty").replaceWith(Response.noProduct);
                                $("#addAllToCart").remove();
                            }
                            if(Response.fail){
                                location.reaload();
                            }
                        },
                });
                return false;
           });

        });
    </script>
@endpush  