@extends('frontend.layouts.app')

@push('banner-section')
<!--******************* Banner Section Start ******************-->
<div class="banner small-banner d-flex align-items-center" style="background-image: url({{ generateURL( $banner->getBannerImage() ) }});">
    <div class="gradient-overlay"></div>
    <div class="container pos-rel">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <h1>{{ $banner->getTitle() }}</h1>
                <p>{!! $banner->getDescription() !!}</p>
            </div>
        </div>
    </div>
</div>
<!--******************* Banner Section End ******************-->
@endpush

@section('main-content')

<!-- Category list section -->
<section class="category-list-section">
    <article class="container">
        <div class="cat-filter">
            <form>
                <div class="form-fields">
                    <ul>
                        <li>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <img src="{{ asset('frontend/images/icon-search.svg') }}" alt="search">
                                    </div>
                                    @if($search != null)
                                        <input type="text" id="search" class="form-control" value="{{ $search }}" placeholder="Search by name...">
                                    @else
                                        <input type="text" id="search" class="form-control" placeholder="Search by name...">
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="form-group">
                                <select name="box" id="filter_box">
                                    <option hidden selected disabled>Box Shape</option>
                                    @if($shapes != null && $shapes != '[]')
                                        @foreach($shapes as $shape_value)
                                            @if($shape != null && $shape->custom_id == $shape_value->custom_id)
                                                <option value="{{ $shape_value->id }}" selected>{{ $shape_value->getTitle() }}</option>
                                            @else
                                                <option value="{{ $shape_value->id }}">{{ $shape_value->getTitle() }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </li>
                        <li>
                            <div class="form-group  ">
                                <select name="color" id="filter_color">
                                    <option hidden selected disabled>Color</option>
                                    @if($colors != null && $colors != '[]')
                                        @foreach($colors as $color_value)                                            
                                            @if($color_value->image != null)
                                                @if($color != null && $color->id == $color_value->id)
                                                    <option data-image="{{ generateURL($color_value->image) }}" value="{{ $color_value->id }}" selected>{{ $color_value->getTitle() }}</option>
                                                @else
                                                    <option data-image="{{ generateURL($color_value->image) }}" value="{{ $color_value->id }}">{{ $color_value->getTitle() }}</option>
                                                @endif
                                            @else
                                                @if($color != null && $color->id == $color_value->id)
                                                    <option value="{{ $color_value->id }}" selected>{{ $color_value->getTitle() }}</option>
                                                @else
                                                    <option value="{{ $color_value->id }}">{{ $color_value->getTitle() }}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </li>
                        <li>
                            <div class="form-group">
                                <select name="price" id="filter_price">
                                    <option hidden selected disabled>Price</option>
                                    @if($product_prices != '[]' && $product_prices != null)
                                        @if( $price != null &&  $price == intval( array_sum($product_prices) / count($product_prices)) )
                                            <option value="{{ intval( array_sum($product_prices) / count($product_prices) ) }}" selected>{{ min($product_prices) }}-{{ intval( array_sum($product_prices) / count($product_prices) ) }}</option>
                                            <option value="{{ max($product_prices) }}">{{ intval( array_sum($product_prices) / count($product_prices) ) }}-{{ max($product_prices) }}</option>
                                        @elseif( $price != null && $price ==  max($product_prices) )
                                            <option value="{{ intval( array_sum($product_prices) / count($product_prices) ) }}">{{ min($product_prices) }}-{{ intval( array_sum($product_prices) / count($product_prices) ) }}</option>
                                            <option value="{{ max($product_prices) }}" selected>{{ intval( array_sum($product_prices) / count($product_prices) ) }}-{{ max($product_prices) }}</option>
                                        @else
                                            <option value="{{ intval( array_sum($product_prices) / count($product_prices) ) }}">{{ min($product_prices) }}-{{ intval( array_sum($product_prices) / count($product_prices) ) }}</option>
                                            <option value="{{ max($product_prices) }}">{{ intval( array_sum($product_prices) / count($product_prices) ) }}-{{ max($product_prices) }}</option>
                                        @endif
                                    @endif
                                </select>
                            </div>
                        </li>
                        <li>
                            <div class="form-group">
                                <select name="category" id="filter_category">
                                    <option hidden selected disabled>Categories </option>
                                    @if($categories != null && $categories != '[]')
                                        @foreach($categories as $value)

                                            @if($category != null && $category->custom_id == $value->custom_id)
                                                <option value="{{ $value->id }}" selected>{{ $value->getTitle() }}</option>
                                            @else
                                                <option value="{{ $value->id }}">{{ $value->getTitle() }}</option>
                                            @endif

                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="other-fields">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb" id="breadcrumb">
                            @if($breadcumb_category != null && $box == null)
                                <li class="breadcrumb-item active" aria-current="page">{{ $breadcumb_category }}
                                </li>
                            @elseif($breadcumb_category != null && $box != null)
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="{{ route('category',[$breadcumb_category_slug,$box->slug]) }}">{{ $breadcumb_category }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    {{ $box->getTitle() }}
                                </li>
                            @endif
                        </ol>
                    </nav>
                    <div class="filter">
                        <ul>
                            <li>
                                <a href="{{ route('category',$category->slug) }}" style="cursor: pointer;">Clear Filter</a>
                            </li>
                            <li>
                                <span>Sort By</span>
                                <select class="common-select" name="extra" id="filter_extra">
                                    <option hidden selected disabled>Popularity</option>
                                    @if($extra != null)
                                        @if($extra == "new")
                                            <option value="new" selected>New Products</option>
                                            <option value="low">Price: Low to High</option>
                                            <option value="high">Price: High to Low</option>
                                        @elseif($extra == "low")
                                            <option value="new">New Products</option>
                                            <option value="low" selected>Price: Low to High</option>
                                            <option value="high">Price: High to Low</option>
                                        @elseif($extra == "high")
                                            <option value="new">New Products</option>
                                            <option value="low">Price: Low to High</option>
                                            <option value="high" selected>Price: High to Low</option>
                                        @endif
                                    @else
                                        <option value="new">New Products</option>
                                        <option value="low">Price: Low to High</option>
                                        <option value="high">Price: High to Low</option>
                                    @endif
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
        @if(!$products->isEmpty())
        <div id="filterProducts">
            <div class="products-list" id="products-list">
                <div class="row" id="allProducts"> 
                    @foreach($products as $product)
                    <div class="col-md-6 col-lg-4">
                        <div class="products-list_item">
                            <div class="products-list_image">
                                <a href="{{ route('product.show',$product->slug) }}">
                                    <img src="{{ generateURL($product->image) }}" alt="product">
                                </a>
                            </div>
                            <div class="products-list_details">
                                <ul>
                                    <li>
                                        <h4><a href="{{ route('product.show',$product->slug) }}">{{ $product->getEnglishTitle() }}</a></h4>
                                    </li>
                                    <li>
                                        @if( in_array($product->id,$favourite_product) )
                                        <li>
                                            <a href="javascript:;" class="add-to-wishlist active" data-product_id="{{ $product->id }}" data-custom_id="{{ $product->custom_id }}"><img src="{{ asset('frontend/images/heart-sprite.svg') }}" alt="wishlist"></a>
                                        </li>
                                        @else
                                        <li id="product_favourite">
                                            <a href="javascript:;" class="add-to-wishlist" data-product_id="{{ $product->id }}" data-custom_id="{{ $product->custom_id }}"><img src="{{ asset('frontend/images/heart-sprite.svg') }}" alt="wishlist"></a>
                                        </li>
                                        @endif
                                    </li>
                                </ul>
                                <h4>AED {{ $product->order_amount }}</h4>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{ $products->links() }}
            </div>
        </div>
        @else
        <div id="filterProducts">
            <center><p>No Products Found.</p></center>
        </div>
        @endif
    </article>
</section>      
@endsection

@push('extra-js')
<script type="text/javascript" src="{{ asset('frontend/js/jcf.scrollable.js') }}"></script>
  <script>
        $(document).ready(function () {
            var url             =   new URL(window.location.href);
            var search_params   =   url.searchParams;
            url.search          =   search_params.toString();

            $(document).on('click', '.pagination a',function(e){
                e.preventDefault();
                $('li').removeClass('active');
                $(this).parent('li').addClass('active');

                var url             =   new URL(window.location.href);
                var search_params   =   url.searchParams;
                var page            =   $(this).attr('href').split('page=')[1];
                search_params.delete('page');
                search_params.append('page',page);

                window.location.replace(url);
            });

            // Add & Remove Product From Wishlist
            $(document).on('click', '.add-to-wishlist',function(){
            // $('.add-to-wishlist').click(function() {                
                var element       = $(this);
                var product_id    = $(this).data('product_id');
                var custom_id     = $(this).attr('data-custom_id');
                var color_id      = $(this).data('color_id');
            
                if( $(this).hasClass("active") ){
                    $(this).toggleClass('active');
                    $.ajax({
                        type: 'DELETE',
                        dataType: 'JSON',
                        url: "{{ route('remove-from-wishlist') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            product_id : product_id,
                            custom_id  : custom_id,
                            color_id   : color_id,
                        },
                        success: function(Response){
                            if(Response.success){
                                $(this).removeClass('active');
                            }
                        },
                    });   
                } 
                else{
                    $(this).toggleClass('active');
                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        url: "{{ route('add-to-wishlist') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            product_id : product_id,
                            custom_id  : custom_id,
                            color_id   : color_id,
                        },
                        success: function(Response){
                            if(Response.success){
                                $(this).addClass('active');
                            }
                        },
                    });
                }
            });

            //Search Products
            $("#search").keyup(function(){

                // When 3 or more character are entered then search 
                if( $(this).val().length >= 3 ){
                    var search = $(this).val();

                    $.ajax({
                        type: 'GET',
                        dataType: 'JSON',
                        url: "{{ route('category',$category->slug) }}",
                        data: {
                            search : search,
                        },
                        success: function(Response){
                            if(Response.products){
                                // set search property to blank
                                url.search = '';

                                // add search property
                                search_params.append('search',search);

                                //Change Url
                                window.history.pushState("data","Title",url.toString());

                                $("#filterProducts").empty();
                                $("#filterProducts").append(Response.products);
                            }
                        },
                    });   
                }
            });

            // Filter Box
            $("#filter_box").change(function(){
                $('#search').val(''); 
                var shape_id    =   $(this).val();
                var price       =   $("#filter_price").val();                
                var box         =   $("#filter_box option:selected").text();
                var color       =   $("#filter_color option:selected").text();
                var category    =   $("#filter_category option:selected").text();

                //Replace Breadcumb
                $("#breadcrumb").replaceWith(
                    '<ol class="breadcrumb" id="breadcrumb">'+
                        '<li class="breadcrumb-item"><a>'+box+'</a></li>'+
                        '<li class="breadcrumb-item"><a>'+color+'</a></li>'+
                        '<li class="breadcrumb-item"><a>'+category+'</a></li>'+
                    '</ol>');

                // Ajax Call To Fetch Products
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('category',$category->slug) }}",
                    data: {
                        shape_id    :   shape_id,
                        shape_price     :   price,
                    },
                    success: function(Response){
                        if(Response.success){
                            // set search property to blank
                            url.search = '';

                            // add search property
                            search_params.append('shape_id',shape_id);
                            if(price != null){ search_params.append('shape_price',price); }

                            // Change Url
                            window.history.pushState("data","Title",url.toString());

                            $("#filterProducts").empty();
                            $("#filterProducts").append(Response.products);      
                        }
                    },
                });
            });


            //Filter By Color
            $("#filter_color").change(function(){
                $('#search').val(''); 
                var color_id    =   $(this).val();
                var shape_id    =   $("#filter_box").val();
                var box         =   $("#filter_box option:selected").text();
                var color       =   $("#filter_color option:selected").text();
                var category    =   $("#filter_category option:selected").text();

                //Replace Breadcumb
                $("#breadcrumb").replaceWith(
                    '<ol class="breadcrumb" id="breadcrumb">'+
                        '<li class="breadcrumb-item"><a>'+box+'</a></li>'+
                        '<li class="breadcrumb-item"><a>'+color+'</a></li>'+
                        '<li class="breadcrumb-item"><a>'+category+'</a></li>'+
                    '</ol>');


                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('category',$category->slug) }}",
                    data: {
                        color_id        :   color_id,
                        color_shape_id  :   shape_id,
                    },
                    success: function(Response){
                        if(Response.success){
                            // set search property to blank
                            url.search = '';

                            // add search property
                            search_params.append('color_id',color_id);
                            if(shape_id != null){ search_params.append('color_shape_id',shape_id); }

                            //Change Url
                            window.history.pushState("data","Title",url.toString());

                            $("#filterProducts").empty();
                            $("#filterProducts").append(Response.products);
                        }
                    },
                });
            });

            //Filter By Category
            $("#filter_category ").change(function(){
                $('#search').val(''); 
                var category_id =   $(this).val();
                var box         =   $("#filter_box option:selected").text();
                var color       =   $("#filter_color option:selected").text();
                var category    =   $("#filter_category option:selected").text();

                //Replace Breadcumb
                $("#breadcrumb").replaceWith(
                    '<ol class="breadcrumb" id="breadcrumb">'+
                        '<li class="breadcrumb-item"><a>'+box+'</a></li>'+
                        '<li class="breadcrumb-item"><a>'+color+'</a></li>'+
                        '<li class="breadcrumb-item"><a>'+category+'</a></li>'+
                    '</ol>');

                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('category',$category->slug) }}",
                    data: {
                        category_id     :   category_id,
                    },
                    success: function(Response){
                        if(Response.success){
                            $("#filterProducts").empty();
                            $("#filterProducts").append(Response.products);

                            // set search property to blank
                            url.search = '';

                            // add search property
                            search_params.append('category_id',category_id);

                            //Change Url
                            window.history.pushState("data","Title",url.toString());
                        }
                    },
                });
            });

            // Filter By Price
            $("#filter_price").change(function(){
                $('#search').val(''); 
                var price       =   $(this).val();
                var shape_id    =   $("#filter_box").val();
                var color_id    =   $("#filter_color").val();
                var category_id =   $("#filter_category").val();

                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('category',$category->slug) }}",
                    data: {
                        price               :   price,
                        price_shape_id      :   shape_id,
                        price_color_id      :   color_id,
                        price_category_id   :   category_id,
                    },
                    success: function(Response){
                        if(Response.success){
                            // set search property to blank
                            url.search = '';

                            // add search property
                            search_params.append('price',price);
                            if(shape_id != null){ search_params.append('price_shape_id',shape_id); }
                            if(color_id != null){ search_params.append('price_color_id',color_id); }
                            if(category_id != null){ search_params.append('price_category_id',category_id); }

                            //Change Url
                            window.history.pushState("data","Title",url.toString());

                            $("#filterProducts").empty();
                            $("#filterProducts").append(Response.products);
                        }
                    },
                });
            });


            // Sort New Products, Price: Low TO High, High To Low
            $("#filter_extra").change(function(){
                var extra           =   $(this).val();
                var shape_id        =   $("#filter_box").val();
                var color_id        =   $("#filter_color").val();
                var price           =   $("#filter_price").val();
                var category_id     =   $("#filter_category").val();
                var search          =   $("#search").val();

                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('category',$category->slug) }}",
                    data: {
                        extra               :   extra,
                        sort_shape_id       :   shape_id,
                        sort_color_id       :   color_id,
                        sort_price          :   price,
                        sort_category_id    :   category_id,
                        sort_search         :   search,
                    },
                    success: function(Response){
                        if(Response.success){           
                            // set search property to blank
                            url.search = '';

                            // add search property
                            search_params.append('extra',extra);
                            if(shape_id != null){ search_params.append('sort_shape_id',shape_id); }
                            if(color_id != null){ search_params.append('sort_color_id',color_id); }
                            if(price != null){ search_params.append('sort_price',price); }
                            if(category_id != null){ search_params.append('sort_category_id',category_id); }
                            if(search != ''){ search_params.append('sort_search',search); }

                            //Change Url
                            window.history.pushState("data","Title",url.toString());

                            $("#filterProducts").empty();
                            $("#filterProducts").append(Response.products);
                        }
                    },
                });
            });

            // add to wishlist
            // $('.add-to-wishlist').click(function () {
            //     $(this).toggleClass('active');
            // });
        });

    </script>
@endpush