@extends('frontend.layouts.app')

@section('main-content')
<!-- Search section -->
<section class="search-section common-spacing">
    <article class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb common-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route($local.'.home') }}"><img src="{{ asset('frontend/images/home-icon.svg ')}}"></a></li>
                <li class="breadcrumb-item">{{ __("Search") }}</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $search_keyword }}</li>
            </ol>
        </nav>
        @if(!$products->isEmpty())
        <div class="products-box my-xl-4 my-md-3 my-2">
            <div class="title-block has-subtitle">
                <h2>Products</h2>
            </div>
            <div class="cat-filter">
                <form>
                    <div class="form-fields">
                        <ul>
                            <li>
                                <div class="form-group">
                                    <select name="box" id="filter_box">
                                        <option hidden selected disabled>{{ __("Box Shape") }}</option>
                                        @if($shapes != null && $shapes != '[]')
                                            @foreach($shapes as $shape_value)
                                                @if($shape != null && $shape->custom_id == $shape_value->custom_id)
                                                    <option value="{{ $shape_value->slug }}" selected>{{ $shape_value->getTitle() }}</option>
                                                @else
                                                    <option value="{{ $shape_value->slug }}">{{ $shape_value->getTitle() }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </li>
                            <li>
                                 <div class="form-group">
                                    <select name="color" id="filter_color">
                                        <option hidden selected disabled>{{ __("Color") }}</option>
                                        @if($colors != null && $colors != '[]')
                                            @foreach($colors as $color_value)                                            
                                                @if($color_value->image != null)
                                                    @if($color != null && $color->id == $color_value->id)
                                                        <option data-image="{{ generateURL($color_value->image) }}" value="{{ $color_value->slug }}" selected>{{ $color_value->getTitle() }}</option>
                                                    @else
                                                        <option data-image="{{ generateURL($color_value->image) }}" value="{{ $color_value->slug }}">{{ $color_value->getTitle() }}</option>
                                                    @endif
                                                @else
                                                    @if($color != null && $color->id == $color_value->id)
                                                        <option value="{{ $color_value->slug }}" selected>{{ $color_value->getTitle() }}</option>
                                                    @else
                                                        <option value="{{ $color_value->slug }}">{{ $color_value->getTitle() }}</option>
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
                                        <option hidden selected disabled>{{ __("Price") }}</option>
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
                                        <option hidden selected disabled>{{ __("Categories") }}</option>
                                        @if($categories != null && $categories != '[]')
                                            @foreach($categories as $value)

                                                @if($category != null && $category->custom_id == $value->custom_id)
                                                    <option value="{{ $value->slug }}" selected>{{ $value->getTitle() }}</option>
                                                @else
                                                    <option value="{{ $value->slug }}">{{ $value->getTitle() }}</option>
                                                @endif

                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </li>
                            <li>
                                <div class="other-fields">
                                    <div class="filter">
                                        <ul>
                                            <li>
                                                <span>{{ __("Sort By") }}</span>
                                                <select class="common-select" name="extra" id="filter_extra">
                                                    <option hidden selected disabled>{{ __("Popularity") }}</option>
                                                    @if($extra != null)
                                                        @if($extra == "new")
                                                            <option value="new" selected>{{ __("New Products") }}</option>
                                                            <option value="low">{{ __("Price: Low to High") }}</option>
                                                            <option value="high">{{ __("Price: High to Low") }}</option>
                                                        @elseif($extra == "low")
                                                            <option value="new">{{ __("New Products") }}</option>
                                                            <option value="low" selected>{{ __("Price: Low to High") }}</option>
                                                            <option value="high">{{ __("Price: High to Low") }}</option>
                                                        @elseif($extra == "high")
                                                            <option value="new">{{ __("New Products") }}</option>
                                                            <option value="low">{{ __("Price: Low to High") }}</option>
                                                            <option value="high" selected>{{ __("Price: High to Low") }}</option>
                                                        @endif
                                                    @else
                                                        <option value="new">{{ __("New Products") }}</option>
                                                        <option value="low">{{ __("Price: Low to High") }}</option>
                                                        <option value="high">{{ __("Price: High to Low") }}</option>
                                                    @endif
                                                </select>
                                            </li>
                                            <li>
                                                <a href="{{ route($local.'.search') }}" style="cursor: pointer;">{{ __("Clear Filter") }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
            <div class="products-list" id="filterProducts">
                <div class="row" id="allProducts">
                    @foreach($products as $product)
                    <div class="col-md-6 col-lg-4">
                        <div class="products-list_item">
                            <div class="products-list_image">
                                <a href="{{ route($local.'.product.show',$product->slug) }}">
                                    <img src="{{ generateURL($product->image) }}" alt="product">
                                </a>
                            </div>
                            <div class="products-list_details">
                                <ul>
                                    <li>
                                        <h4><a href="{{ route($local.'.product.show',$product->slug) }}">{{ $product->getTitle() }}</a></h4>
                                    </li>
                                    @if( in_array($product->id,$favourite_product) )
                                    <li>
                                        <a href="javascript:;" class="add-to-wishlist active" data-product_id="{{ $product->id }}" data-custom_id="{{ $product->custom_id }}"><img src="{{ asset('frontend/images/heart-sprite.svg') }}" alt="wishlist"></a>
                                    </li>
                                    @else
                                    <li id="product_favourite">
                                        <a href="javascript:;" class="add-to-wishlist" data-product_id="{{ $product->id }}" data-custom_id="{{ $product->custom_id }}"><img src="{{ asset('frontend/images/heart-sprite.svg') }}" alt="wishlist"></a>
                                    </li>
                                    @endif
                                </ul>
                                <h4>{{ __("AED") }} {{ $product->order_amount }}</h4>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{ $products->links() }}
                
                {{--
                @if($count_load_more != $products->count() && $count_load_more > 0)
                <!-- <div>
                    <center><button class="input-group-text common-black-btn load-more" id="btn-load-more" data-offset="{{ $products->count() }}">{{ __("Load More") }}</button></center>
                </div> -->
                @endif
                --}}
                <div class="field limiter">
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
                </div>
            </div>
        </div>
        @else
        <div id="filterProducts">
            <center><p>{{ __("0 results for your search.") }}</p></center>
        </div>
        @endif

        @if(!$services->isEmpty())
        <div class="service-box my-xl-4 my-md-3 my-2">
            <div class="title-block has-subtitle">
                <h2>Services</h2>
            </div>
            <div class="row weddings-events">
                @foreach($services as $service)
                <div class="col-md-6 col-lg-4"> 
                    <div class="common_image-box">
                        <div class="dyn-img common_image" style="background-image: url('{{ generateURL($service->getBannerImage()) }}');">
                        </div>
                        <a href="{{ route($local.'.services-inner',$service->slug) }}"></a>
                    </div>
                    <div class="weddings-events_details">
                        <h2><a href="{{ route($local.'.services-inner',$service->slug) }}">{{ $service->getTitle() }}</a></h2>
                        <a href="{{ route($local.'.service.inquiry.form') }}" class="view-btn">{{ __("Get In Touch") }}<img src="{{ asset('frontend/images/arrow-right-dark.svg') }}" alt="arrow"></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(!$blogs->isEmpty())
        <div class="news-box my-xl-4 my-md-3 my-2">
            <div class="title-block has-subtitle">
                <h2>News</h2>
            </div>
            <div class="archive-months_articles-list">
                <div class="row">
                    @foreach($blogs as $blog)
                    <div class="col-lg-8">
                        <div class="news-articles featured-article">
                            <div class="news-article_image">
                                <div class="common_image-box">
                                    <div class="dyn-img common_image" style="background-image: url('{{ generateURL($blog->getBanner()) }}');">
                                    </div>
                                    <a href="{{ route($local.'.news.details',$blog->slug) }}"></a>
                                </div>
                            </div>
                            <div class="featured-article_summary">
                                <div class="row">
                                    <div class="col-lg-8 col-xl-6">
                                        <h1><a href="{{ route($local.'.news.details',$blog->slug) }}">{{ $blog->getTitle() }}</a></h1>
                                        <p>{{ $blog->getShortDescription() }}</p>
                                        <a href="{{ route($local.'.news.details',$blog->slug) }}" class="view-btn">{{ __("Read More") }}<img src="{{ asset('frontend/images/arrow-right-white.svg') }}" alt="arrow"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </article>
</section>
@endsection

@push('top-css')
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/mmenu-light.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/slick-theme.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/slick.css') }}">
@endpush

@push('extra-js')
    <script type="text/javascript" src="{{ asset('frontend/js/jcf.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/jcf.select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/mmenu-light.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/mmenu-light.polyfills.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/slick.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {

            // Load More
            // $(document).on('click','.load-more',function(){
            //     var url             =   new URL(window.location.href);
            //     var search_params   =   url.searchParams;
            //     var element = $(this);
            //     var offset = $(this).data('offset');
            //     var products = "{{ json_encode($products) }}";

            //     var search_params = search_params.toString();
            //     var first_param = '?';
            //     search_params = first_param.concat(search_params);

            //     var route = "{{ route($local.'.search') }}";
            //     route = route.concat(search_params);

            //     $('.load-more').html('{{ __("Loading...") }}');

            //     $.ajax({
            //         type: 'GET',
            //         dataType: 'JSON',
            //         url: route,
            //         data: {
            //             _token: '{{ csrf_token() }}',
            //             loadmore : true,
            //             offset  : offset,
            //         },
            //         success: function(Response){
            //             if(Response.success){
            //                 var current_data = $('.products-list_item').length;
            //                 var current_data = current_data + Response.offset;

            //                 if(current_data < Response.count_load_more){
            //                     $("#allProducts").append(Response.products);
            //                     var new_offset = offset + Response.offset;
            //                     $('#btn-load-more').replaceWith('<button class="input-group-text common-black-btn load-more" id="btn-load-more" data-offset="'+new_offset+'">{{ __("Load More") }}</button>');
            //                 }
            //                 else if(current_data == Response.count_load_more){
            //                     $("#allProducts").append(Response.products);
            //                     $('#btn-load-more').remove();
            //                 }else{
            //                     $("#allProducts").append(Response.products);
            //                     $('#btn-load-more').remove();
            //                 }
            //             }else{
            //                 $('#btn-load-more').remove();
            //             }
            //         },
            //     }); 
            // });

            // Pagination
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
                var custom_id     = $(this).data('custom_id');
                var color_id      = $(this).data('color_id');
           
                if( $(this).hasClass("active") ){
                    $(this).toggleClass('active');
                    $.ajax({
                        type: 'DELETE',
                        dataType: 'JSON',
                        url: "{{ route($local.'.remove-from-wishlist') }}",
                        data: {
                             _token: '{{ csrf_token() }}',
                             product_id : product_id,
                             custom_id  : custom_id,
                             color_id   : color_id,
                        },
                        success: function(Response){
                            if(Response.favourite_icon){
                                $(this).addClass('active');
                            }
                        },
                    });   
                } 
                else{
                    $(this).toggleClass('active');
                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        url: "{{ route($local.'.add-to-wishlist') }}",
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
            });

            // Filter Box
            $(document).on('change', '#limiter',function(){
                var product_list_limit = $(this).val();
                var shape_id    =   $("#filter_box").val();
                var color_id    =   $("#filter_color").val();
                var price       =   $("#filter_price").val(); 
                var category_id =   $("#filter_category").val();
                var extra       =   $("#filter_extra").val();
                var search      =   $("#search").val();

                // set search property to blank
                url.search = '';

                // add search property
                search_params.append('product_list_limit',product_list_limit);
                if(search != null){ search_params.append('search',search); }
                if(shape_id != null){ search_params.append('shape_id',shape_id); }
                if(color_id != null){ search_params.append('color_id',color_id); }
                if(price != null){ search_params.append('price',price); }
                if(category_id != null){ search_params.append('category_id',category_id); }
                if(extra != null){ search_params.append('extra',extra); }

                //Change Url
                window.history.pushState("data","Title",url.toString());

                location.reload();
            });

            // Filter Box
            $("#filter_box").change(function(){
                // $('#search').val(''); 
                var shape_id    =   $(this).val();
                var color_id    =   $("#filter_color").val();
                var price       =   $("#filter_price").val(); 
                var category_id =   $("#filter_category").val();
                var extra       =   $("#filter_extra").val();
                var search      =   '{{ $search_keyword }}';
                var product_list_limit  =   $("#limiter").val();

                // Ajax Call To Fetch Products
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route($local.'.search') }}",
                    data: {
                        shape_id        :   shape_id,
                        color_id        :   color_id,
                        price           :   price,
                        category_id     :   category_id,
                        extra           :   extra,
                        search          :   search,
                        product_list_limit  :   product_list_limit,
                    },
                    success: function(Response){
                        if(Response.success){
                            // set search property to blank
                            url.search = '';

                            // add search property
                            search_params.append('shape_id',shape_id);
                            if(color_id != null){ search_params.append('color_id',color_id); }
                            if(price != null){ search_params.append('price',price); }
                            if(category_id != null){ search_params.append('category_id',category_id); }
                            if(extra != null){ search_params.append('extra',extra); }
                            if(search != ''){ search_params.append('search',search); }
                            if(product_list_limit != null){ search_params.append('product_list_limit',product_list_limit); }
                            
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
                // $('#search').val(''); 
                var shape_id    =   $("#filter_box").val();
                var color_id    =   $(this).val();
                var price       =   $("#filter_price").val(); 
                var category_id =   $("#filter_category").val();
                var extra       =   $("#filter_extra").val();
                var search      =   '{{ $search_keyword }}';
                var product_list_limit  =   $("#limiter").val();

                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route($local.'.search') }}",
                    data: {
                        shape_id        :   shape_id,
                        color_id        :   color_id,
                        price           :   price,
                        category_id     :   category_id,
                        extra           :   extra,
                        search          :   search,
                        product_list_limit  :   product_list_limit,
                    },
                    success: function(Response){
                        if(Response.success){
                            // set search property to blank
                            url.search = '';

                            // add search property
                            search_params.append('color_id',color_id);
                            if(shape_id != null){ search_params.append('shape_id',shape_id); }
                            if(price != null){ search_params.append('price',price); }
                            if(category_id != null){ search_params.append('category_id',category_id); }
                            if(extra != null){ search_params.append('extra',extra); }
                            if(search != ''){ search_params.append('search',search); }
                            if(product_list_limit != null){ search_params.append('product_list_limit',product_list_limit); }

                            //Change Url
                            window.history.pushState("data","Title",url.toString());

                            $("#filterProducts").empty();
                            $("#filterProducts").append(Response.products);
                        }
                    },
                });
            });

            //Filter By Category
            $("#filter_category").change(function(){
                // $('#search').val(''); 
                var shape_id    =   $("#filter_box").val();
                var color_id    =   $("#filter_color").val();
                var price       =   $("#filter_price").val(); 
                var category_id =   $(this).val();
                var extra       =   $("#filter_extra").val();
                var search      =   '{{ $search_keyword }}';
                var product_list_limit  =   $("#limiter").val();

                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route($local.'.search') }}",
                    data: {
                        shape_id        :   shape_id,
                        color_id        :   color_id,
                        price           :   price,
                        category_id     :   category_id,
                        extra           :   extra,
                        search          :   search,
                        product_list_limit  :   product_list_limit,
                    },
                    success: function(Response){
                        if(Response.success){
                            $("#filterProducts").empty();
                            $("#filterProducts").append(Response.products);

                            // set search property to blank
                            url.search = '';

                            // add search property
                            search_params.append('category_id',category_id);
                            if(shape_id != null){ search_params.append('shape_id',shape_id); }
                            if(color_id != null){ search_params.append('color_id',color_id); }
                            if(price != null){ search_params.append('price',price); }
                            if(extra != null){ search_params.append('extra',extra); }
                            if(search != ''){ search_params.append('search',search); }
                            if(product_list_limit != null){ search_params.append('product_list_limit',product_list_limit); }

                            //Change Url
                            window.history.pushState("data","Title",url.toString());
                        }
                    },
                });
            });

            // Filter By Price
            $("#filter_price").change(function(){
                // $('#search').val(''); 
                var shape_id    =   $("#filter_box").val();
                var color_id    =   $("#filter_color").val();
                var price       =   $(this).val();
                var category_id =   $("#filter_category").val();
                var extra       =   $("#filter_extra").val();
                var search      =   '{{ $search_keyword }}';
                var product_list_limit  =   $("#limiter").val();

                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route($local.'.search') }}",
                    data: {
                        shape_id      :   shape_id,
                        color_id      :   color_id,
                        price         :   price,
                        category_id   :   category_id,
                        extra         :   extra,
                        search        :   search,
                        product_list_limit  :   product_list_limit,
                    },
                    success: function(Response){
                        if(Response.success){
                            // set search property to blank
                            url.search = '';

                            // add search property
                            search_params.append('price',price);
                            if(shape_id != null){ search_params.append('shape_id',shape_id); }
                            if(color_id != null){ search_params.append('color_id',color_id); }
                            if(category_id != null){ search_params.append('category_id',category_id); }
                            if(extra != null){ search_params.append('extra',extra); }
                            if(search != ''){ search_params.append('search',search); }
                            if(product_list_limit != null){ search_params.append('product_list_limit',product_list_limit); }

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
                var search          =   '{{ $search_keyword }}';
                var product_list_limit  =   $("#limiter").val();

                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route($local.'.search') }}",
                    data: {
                        shape_id       :   shape_id,
                        color_id       :   color_id,
                        price          :   price,
                        category_id    :   category_id,
                        extra          :   extra,
                        search         :   search,
                        product_list_limit  :   product_list_limit,
                    },
                    success: function(Response){
                        if(Response.success){           
                            // set search property to blank
                            url.search = '';
                        
                            // add search property
                            search_params.append('extra',extra);
                            if(shape_id != null){ search_params.append('shape_id',shape_id); }
                            if(color_id != null){ search_params.append('color_id',color_id); }
                            if(price != null){ search_params.append('price',price); }
                            if(category_id != null){ search_params.append('category_id',category_id); }
                            if(search != ''){ search_params.append('search',search); }
                            if(product_list_limit != null){ search_params.append('product_list_limit',product_list_limit); }

                            //Change Url
                            window.history.pushState("data","Title",url.toString());

                            $("#filterProducts").empty();
                            $("#filterProducts").append(Response.products);
                        }
                    },
                });
            });

        });
    </script>
@endpush