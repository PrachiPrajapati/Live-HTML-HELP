@extends('frontend.layouts.app')

@section('main-content')

<!-- Product single section -->
<section class="product-single-section">
    <article>
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb common-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><img src="{{ asset('frontend/images/home-icon.svg') }}"></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li id="breadcrumb-product-title" class="breadcrumb-item active" aria-current="page">{{ $product->getTitle() }}</li>
                </ol>
            </nav>
            <div class="product-single-detail">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="product-single_slider"> 
                            <div class="product-single_nav">
                                <ul id="showColors">
                                @if($product_main_images != null && $product_main_images != '[]')
                                    @foreach($product_main_images as $product_main_image)
                                    <li>
                                        <span class="product_color getColors" data-product_id="{{ $product->id }}" data-color_id="null"></span>
                                        <div class="thumb-box d-flex justify-content-center align-items-center">
                                            <img src="{{ generateURL($product_main_image->image) }}" alt="thumb" />
                                        </div>
                                    </li>
                                    @endforeach
                                @endif
                                </ul>
                            </div>
                            <div class="product-single_for" id="productMainImage">
                                <ul id="productMainUl">
                                @if($product_main_images != null && $product_main_images != '[]')
                                    @foreach($product_main_images as $product_main_image)
                                    <li class="img-zoom">
                                        <a href="{{ generateURL($product_main_image->image) }}" data-image="{{ generateURL($product_main_image->image) }}"><img src="{{ generateURL($product_main_image->image) }}"  alt="product"></a>
                                    </li>
                                    @endforeach
                                @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="product-single-info">
                            <div class="product-single-info_social">
                                <ul>
                                    <li class="sharing-icons">
                                        <a href="https://{{ $setting->getFbValue() }}" target="_blank"><i class="fa fa-facebook-f"></i></a>
                                    </li>
                                    <li class="sharing-icons">
                                        <a href="https://{{ $setting->getPintrestValue() }}" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                                    </li>
                                        @if( in_array($product->id,$favourite_product) )
                                        <li class="wishlist">
                                            <a href="javascript:;" id="removeFromWishlist" class="add-to-wishlist active" data-product_id="{{ $product->id }}" data-custom_id="{{ $product->custom_id }}"><img src="{{ asset('frontend/images/heart-sprite.svg') }}" alt="wishlist"></a>
                                        </li>
                                        @else
                                        <li id="product_favourite" class="wishlist">
                                            <a href="javascript:;" id="addToWishlist" class="add-to-wishlist" data-product_id="{{ $product->id }}" data-custom_id="{{ $product->custom_id }}"><img src="{{ asset('frontend/images/heart-sprite.svg') }}" alt="wishlist"></a>
                                        </li>
                                        @endif
                                </ul>
                            </div>
                            <div class="product-single-info_summary">
                                <h2 id="productTitle">{{ $product->getTitle() }}</h2>
                                <p id="productSku">{{ __("Product Code") }} {{ $product->sku }}</p>
                                <div class="prod-description" id="productDescription">
                                    @if($product->getEnglishDescription() != null)
                                        <label class="font-weight-bold">{{ __("Product Description") }}</label>
                                        {{ $product->getEnglishDescription() }}
                                    @endif
                                </div>
                                <form id="frmAddToCart" method="post" action="{{ route('add-to-cart') }}">
                                    @csrf
                                    <h4 id="productPrice">{{ __("AED") }} {{ $product->order_amount }}.00</h4>
                                    <input type="hidden" name="custom_id" value="{{ $product->custom_id }}">
                                    <input type="hidden" id="color_id" name="color_id">
                                    <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
                                    
                                    @if($product['total_stock'] > 0)   
                                    <div class="form-group">
                                        {{-- BOX DATA --}}
                                        {{--
                                        <!-- @if(!$product_boxes->isEmpty())
                                        <label class="font-weight-bold mb-3">Box Color</label>
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            @foreach($product_boxes as $product_box)
                                                @if($product_box->box != null)
                                                    @if($box_id == $product_box->box_id)
                                                        <label class="btn active">
                                                             <input type="radio" class="getBoxes" data-product_id="{{ $product_box->product_id }}" data-box_id="{{ $product_box->box_id }}" checked>
                                                            <img src="{{ generateURL($product_box->box->image) }}" alt="flower">
                                                        </label>
                                                    @else
                                                        <label class="btn">
                                                            <input type="radio" class="getBoxes" data-product_id="{{ $product_box->product_id }}" data-box_id="{{ $product_box->box_id }}">
                                                            <img src="{{ generateURL($product_box->box->image) }}" alt="flower">
                                                        </label>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                        @endif  -->
                                        --}}

                                        {{-- SHAPE DATA --}}

                                        @if(!$product_shapes->isEmpty())
                                        <label class="font-weight-bold mb-3">Box Color</label>
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            @foreach($product_shapes as $product_shape)
                                                @if($product_shape->shape != null)
                                                    @if($shape_id == $product_shape->shape_id)
                                                        <label class="btn active">
                                                             <input type="radio" class="getShapes" data-product_id="{{ $product_shape->product_id }}" data-shape_id="{{ $product_shape->shape_id }}" checked>
                                                            <img src="{{ generateURL($product_shape->shape->image) }}" alt="flower">
                                                        </label>
                                                    @else
                                                        <label class="btn">
                                                            <input type="radio" class="getShapes" data-product_id="{{ $product_shape->product_id }}" data-shape_id="{{ $product_shape->shape_id }}">
                                                            <img src="{{ generateURL($product_shape->shape->image) }}" alt="flower">
                                                        </label>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                        @endif 
                                        
                                        @if(!$product_colors->isEmpty())
                                        <label class="font-weight-bold mb-3">Flower Color</label>
                                        <div class="btn-group btn-group-toggle" id="colors_list" data-toggle="buttons">
                                            @foreach($product_colors as $product_color)
                                                @if($color_id == $product_color->id)
                                                    <label class="btn active">
                                                        <input type="radio" class="getColors" data-product_id="{{ $product->id }}" data-color_id="{{ $product_color->id }}" checked>
                                                        <img src="{{ generateURL($product_color->image) }}" alt="flower">
                                                    </label>
                                                @else
                                                    <label class="btn {{ $loop->first ? 'active' : '' }} ">
                                                        <input type="radio" class="getColors" data-product_id="{{ $product->id }}" data-color_id="{{ $product_color->id }}">
                                                        <img src="{{ generateURL($product_color->image) }}" alt="flower">
                                                    </label>
                                                @endif
                                            @endforeach
                                        </div>
                                        @endif                                        
                                        <ul>
                                            <li>
                                                <label class="font-weight-bold">Quantity</label>
                                            </li>
                                            
                                            <li>
                                                <div class="cart-quantity">
                                                    <span class="minus" min="{{ $product->minimum_qty }}" data-product_id="{{ $product->id }}" data-minqty="{{ $product->minimum_qty }}" data-custom_id ="{{ $product['custom_id'] }}" disabled>-</span>
                                                    
                                                    <input type="number" id="quantity" name="quantity" min="{{ $product->minimum_qty }}"
                                                     max="{{ $product->total_stock }}" value="{{ $product->minimum_qty }}" data-error-container="#quantity-error" readonly="true">                                                                                                        
                                                    <span class="plus" data-custom_id="{{ $product->custom_id }}" data-maxqty="{{ $product->total_stock }}">+</span>
                                                </div>
                                                <span id="quantity-error"></span>
                                            </li>
                                        </ul>
                                        @if($errors->has('quantity'))
                                            <span class="error-help">{{ $errors->first('quantity') }}</span>
                                        @endif
                                        @if($product_in_cart != null)
                                            @if(Auth::check())
                                                <button type="button" id="btnAddToCart" class="common-black-btn full" disabled>Already In Cart</button>  
                                            @else
                                                @if($product->custom_id == $product_in_cart->custom_id)
                                                    <button type="button" id="btnAddToCart" class="common-black-btn full" disabled>Already In Cart</button>  
                                                @else
                                                    <button type="button" id="btnAddToCart" class="common-black-btn full">Add to Cart</button>   
                                                @endif
                                            @endif    
                                        @else
                                            <button type="button" id="btnAddToCart" class="common-black-btn full">Add to Cart</button>   
                                        @endif
                                    </div>
                                    @else
                                        <div class="form-group">
                                            <button type="button" class="common-black-btn full">Product Not Available</button>
                                        </div>    
                                    @endif
                                    <p class="mt-4">Please note that due to the seasonality of some flowers, they may not be available all year round. If any flowers are not available due to seasonality, they will be replaced with similar flowers.</p>
                                </form>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Addon Not Used Currently --}}
        {{--
<!--         <div class="container">
            <div class="add-more-items combo">
                <div class="row justify-content-center">
                    <div class="col-md-7" id="addon_header">
                        <div class="title-block">
                            <div class="text-center">
                                <h4 id="addon_header_title">
                                @if($product->addonProducts != null && $product->addonProducts != '[]')
                                    Buy it with...
                                @endif
                                </h4>
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('addtocart.multipleproducts') }}">
                        @csrf
                        <div class="products-list"> 
                            <div class="row" id="addon_list">
                            @if($product->addonProducts != null && $product->addonProducts != '[]')

                                @foreach($product->addonProducts as $addon_product)

                                    @if($addon_product->addon != null)

                                    <div class="col-md-4">
                                        <div class="products-list_item">
                                            <div class="products-list_image">
                                                <img src="{{ generateURL($addon_product->addon->getImage()) }}" alt="addon">
                                            </div>
                                            <div class="products-list_details">
                                                <ul>
                                                    <li>
                                                        <h4>{{ $addon_product->addon->getTitle() }}</h4>
                                                    </li>
                                                    <li>
                                                        <h4>AED {{ $addon_product->addon->getPrice() }}</h4>
                                                    </li>
                                                </ul>
                                                <label class="btn-outline">
                                                    <input type="checkbox" name="add-on" data-product_id="{{ $addon_product->addon->id }}" data-minqty="1" data-title="{{ $addon_product->addon->getTitle() }}" data-price="{{ $addon_product->addon->getPrice() }}" data-custom_id ="{{ $addon_product->addon->custom_id }}"> <span>Select</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                @endforeach

                            @endif
                            </div>
                        </div>
                        <div class="total-price mt-3" id="combo_list">
                            <div class="row">
                                <div class="col-md-9" id="multiple_products">
                                    <h3 id="combo_title"><span class="font-weight-bold">Small Festive Faux Flowers Arrangement</span> + 3 addons <br /> Total Price:
                                        <span class="font-weight-bold total-amt">AED 400</span></h3>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" id="btnAddToCartCombo">Add Combo to Cart</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>                       
            </div>
        </div> -->
        --}}

        <div class="container">
            <div class="related-products" id="related-products-div">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="text-center" id="related_header">
                            <h4 class="mb-4" id="related_header_title">
                                @if(!$relatedProducts->isEmpty())
                                    Related Products
                                @endif
                            </h4>
                        </div>
                        <div class="products-list">
                            <div class="row" id="related_list"> 
                            @if(!$relatedProducts->isEmpty())

                                @foreach($relatedProducts as $related_product)
                                    <div class="col-md-4">
                                        <div class="products-list_item">
                                            <div class="products-list_image">
                                                <a href="{{ route('product.show',$related_product->slug) }}">
                                                    <img src="{{ generateURL($related_product->image) }}" alt="product">
                                                </a>
                                            </div>
                                            <div class="products-list_details">
                                                <ul>
                                                    <li>
                                                        <h4><a href="{{ route('product.show',$related_product->slug) }}">{{ $related_product->getTitle() }}</a></h4>
                                                    </li>
                                                    <li>
                                                        @if($related_product->like == true )
                                                            <a href="javascript:;" class="add-to-wishlist active" data-product_id="{{ $related_product->id }}" data-custom_id="{{ $related_product->custom_id }}"><img src="{{ asset('frontend/images/heart-sprite.svg') }}" alt="wishlist"></a>
                                                        @else
                                                            <a href="javascript:;" class="add-to-wishlist" data-product_id="{{ $related_product->id }}" data-custom_id="{{ $related_product->custom_id }}"><img src="{{ asset('frontend/images/heart-sprite.svg') }}" alt="wishlist"></a>
                                                        @endif
                                                    </li>
                                                </ul>
                                                <h4>AED {{ $related_product->order_amount }}.00</h4>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach  
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
</section>
@endsection

@push('top-css')
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/mmenu.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/mmenu.positioning.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/slick-theme.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/slick.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/jquery.ez-plus.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/jquery.fancybox.css') }}">
@endpush

@push('extra-js')
<script src="{{ asset('admin/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('admin/js/custom_validations.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/jcf.scrollable.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/mmenu.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/slick.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/jquery.ez-plus.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/jquery.fancybox.js') }}"></script>

<script type="text/javascript">
$(document).ready(function () {

     // cart quantity
    $('.minus').attr('disabled', true);

    if ($('#quantity').val() == 1) {
        $('.minus').attr('disabled', true);
        $('.minus').css('cursor', 'not-allowed');
    }
    $('.minus').click(function () {
        
        var min_purchase_qty = $(this).data('minqty');

        if ($(this).is('[disabled=disabled]') == true) {
            return false;
        }
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        if (count == 1 || count <= min_purchase_qty) {
            $(this).attr('disabled', 'disabled');
            $(this).css('cursor', 'not-allowed');
        }
        $('.plus').attr('disabled', false);
        $('.plus').css('cursor', 'pointer');

        // count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
    });

    $('.plus').click(function () {
        var max_purchase_qty    = $(this).data('maxqty'); 
        var $input              = $(this).parent().find('input');
        var count               = parseInt($input.val()) + 1;
        
        if (count > 1) {
            $('.minus').attr('disabled', false);
            $('.minus').css('cursor', 'pointer');
        }

        if (count > max_purchase_qty){
            $(this).attr('disabled', true);
            $(this).css('cursor', 'not-allowed');
            return false;
        }

        $input.val(count);
        $input.change();
    });


    // select 
    $(function () {
        var customSelect = $('select');
        // Options for custom Select
        jcf.setOptions('Select', {
            wrapNative: false,
            wrapNativeOnMobile: false,
            fakeDropInBody: false
        });
        jcf.replace(customSelect);
        jcf.refresh();
    });

    // navbar toggle
    var $navbartoggle = $("body");
    $('.navbar-toggler').click(function () {
        $navbartoggle.toggleClass("menu-open");
    });
    $('.navbar-nav .nav-link').click(function () {
        $('body').removeClass('menu-open');
    });
  
    // add to wishlist
    // $('.add-to-wishlist').click(function () {
    //     $(this).toggleClass('active');
    // });

    // product single slider
    const for_settings = {
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        dots: false,
        infinite: false,
        rows: 0,
        asNavFor: '.product-single_nav ul'
    }
    const nav_settings = {
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.product-single_for ul',
        dots: false,
        arrows: true,
        vertical: true,
        verticalSwiping: true,
        focusOnSelect: true,
        infinite: false,
        rows: 0,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    vertical: false,
                    verticalSwiping: false,
                }
            }
        ]
    }           
    $('.product-single_for ul').slick(for_settings);
    $('.product-single_nav ul').slick(nav_settings);


    // image zoom 
    var zoomOptions = {
        zoomType: 'inner',
        cursor: 'crosshair',
    }
    $(".slick-current.img-zoom img").ezPlus(zoomOptions);
    $(".product-single_for ul").on("beforeChange", function ( event, slick, currentSlide, nextSlide ) {
        $.removeData(currentSlide, "elevateZoom");
        $(".ZoomContainer").remove();
    });
    $(".product-single_for ul").on("afterChange", function ( event, slick, currentSlide, nextSlide) {
        $.removeData(currentSlide, "elevateZoom");
        $(".slick-current.img-zoom img").ezPlus(zoomOptions);
    });
    $(document).on('click','.slick-current .img-zoom', function (e) {
        var ez = $('.slick-current .img-zoom a');
        $.fancybox.open(ez);
        return false;
    });

    // modal form style
    $('.common-form .form-control').focus(function () {
        $(this).parent().addClass('input-focused');
    }).blur(function () {
        var inputLength = $(this).val();
        if (inputLength.length > 0 || $(this).is('[placeholder]') == true) {
            $(this).parent().addClass('input-focused');
        } else {
            $(this).parent().removeClass('input-focused');
        }
    });
    
    // modal open 
    $(document).on('hidden.bs.modal', function () {
        if ($('.modal.show').length) {
            $('body').addClass('modal-open');
        }
    });

    // modal form style
    $('.common-form .form-control').focus(function () {
        $(this).parent().addClass('input-focused');
    }).blur(function () {
        var inputLength = $(this).val();
        if (inputLength.length > 0 || $(this).is('[placeholder]') == true) {
            $(this).parent().addClass('input-focused');
        } else {
            $(this).parent().removeClass('input-focused');
        }
    });


    // mmenu 
    var width = $(window).width();
    if (width < 1200) {
        document.addEventListener(
            "DOMContentLoaded", () => {
                const menu = new Mmenu("#menu", {
                    navbar: {
                        sticky: false
                    },
                    offCanvas: {
                        blockUI: false
                    },
                    "extensions": [
                        "position-front"
                    ]

                }, {
                    offCanvas: {
                        menu: {
                            insertSelector: 'header'
                        }
                    }
                });
                const api = menu.API;
                document.querySelector(".navbar-toggler")
                    .addEventListener(
                        "click", (evnt) => {
                            if (document.body.classList.contains('mm-wrapper_opened')) {
                                api.close();
                                document.body.classList.add("mm-wrapper"); /* replace this script when logged in 
    document.body.classList.add("mm-wrapper","logged-in");*/
                            }
                            else {
                                evnt.preventDefault();
                                api.open();
                            }
                        }
                    );
            }
        );
    }

    var total = 0;
    var count = 0;

    $(document).ready(function () {
        var url = new URL(window.location.href);


    // Set Slider Images When Flower Shape Selects   
    $(document).on('click', '.getShapes', function() {

        var product_id = $(this).data('product_id');
        var shape_id   = $(this).data('shape_id');
        var checkLogin = "{{{ (Auth::user()) ? "true" : "false" }}}";

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: "{{ route('getproduct.shapes') }}",
            data: {
                    _token      :   '{{ csrf_token() }}',
                    product_id  :   product_id,
                    shape_id    :   shape_id,
            },
            beforeSend: function() {
                showLoader();
            },
            success: function(Response){
                if(Response.success){
                    var shapes = JSON.parse(Response.shapes);
                    var colors = JSON.parse(Response.colors);

                    var slickIndex =  $("#showColors").find('li').last().data('slick-index');
                    for($i=slickIndex; $i>=0; $i--){
                        $('.product-single_nav ul').slick('slickRemove',$i);
                        $('.product-single_for ul').slick('slickRemove',$i);
                    }

                    $(shapes).map((id,shape) => {

                        //When First Product Image Is Selected ByDefault Then Set Values
                        if(id == 0){
                            $("#color_id").replaceWith('<input type="hidden" id="color_id" name="color_id" value="'+shape["color_id"]+'">');
                            $("#product_id").replaceWith('<input type="hidden" id="product_id" name="product_id" value="'+shape["product_id"]+'">');
                            $("#addToWishlist").attr('data-product_id',shape['product_id']);
                            $("#addToWishlist").attr('data-color_id',shape['color_id']);
                            $("#removeFromWishlist").attr('data-product_id',shape['product_id']);
                            $("#removeFromWishlist").attr('data-color_id',shape['color_id']);

                            //Change Add To Cart Button
                            $("#btnAddToCart").replaceWith(shape['cart_status']);

                            //Product Data
                            $("#productTitle").replaceWith("<h2 id='productTitle'>"+shape['product']['getTitle']+"</h2>");
                            $("#productSku").replaceWith("<p id='productSku'>{{ __('Product Code') }} "+shape['product']['sku']+"</p>");
                            if(shape['product']['getDescription'] != null){
                                $("#productDescription").replaceWith("<div class='prod-description' id='productDescription'>"+
                                                                "<label class='font-weight-bold'>{{ __('Product Description') }}</label>"+
                                                                ""+shape['product']['getDescription']+"</div>");
                            }else{
                                $("#productDescription").empty();
                            }

                            $("#productPrice").replaceWith("<h4 id='productPrice'>{{ __('AED') }} "+shape['product']['order_amount']+".00</h4>");

                            //Breadcumb
                            $("#breadcrumb-product-title").replaceWith('<li id="breadcrumb-product-title" class="breadcrumb-item active" aria-current="page">'+shape['product']['getTitle']+'</li>');

                            const segments  =   url.pathname.split('/');
                            const last      =   segments.pop() || segments.pop(); // Handle potential trailing slash
                            var new_url     =   url.href.replace(""+last+"",""+shape['product']['slug']+"");

                            // Change Url
                            window.history.pushState("data","Title",new_url.toString());

                            // if(checkLogin == 'true'){
                                $.ajax({
                                        type: 'POST',
                                        dataType: 'JSON',
                                        url: "{{ route('check.favourite') }}",
                                        data: {
                                            _token      : '{{ csrf_token() }}',
                                            product_id  : shape['product_id'],
                                            shape_id    : shape['id'],
                                        },
                                        success: function(Response){
                                            if(Response.success){
                                                $("#addToWishlist").addClass('active');
                                                $("#removeFromWishlist").addClass('active');
                                            }else{
                                                $("#addToWishlist").removeClass('active');
                                                $("#removeFromWishlist").removeClass('active');
                                            }
                                        },
                                });
                            // }   
                        }
                        $('#showColors').slick('slickAdd',shape["showShapes"]);
                        $('#productMainUl').slick('slickAdd',shape["productMainUl"]);

                        //Product Data
                        $("#productTitle").replaceWith("<h2 id='productTitle'>"+shape['product']['getTitle']+"</h2>");
                        $("#productSku").replaceWith("<p id='productSku'>{{ __('Product Code') }} "+shape['product']['sku']+"</p>");
                        if(shape['product']['getDescription'] != null){
                            $("#productDescription").replaceWith("<div class='prod-description' id='productDescription'>"+
                                                            "<label class='font-weight-bold'>{{ __('Product Description') }}</label>"+
                                                            ""+shape['product']['getDescription']+"</div>");
                        }else{
                            $("#productDescription").empty();
                        }
                        $("#productPrice").replaceWith("<h4 id='productPrice'>{{ __('AED') }} "+shape['product']['order_amount']+".00</h4>");
                    });

                    $(colors).map((id,color) => {
                        $("#colors_list").empty();
                        $("#colors_list").append(color["showColors"]);
                    });

                    //Related Products
                    $("#related_list").empty();
                    $("#related_list").append(Response['related_product']);

                    $('.product-single_nav .slick-slider').slick('refresh');
                    $(".slick-current .img-zoom img").ezPlus(zoomOptions);
                }     
                if(Response.fail){
                    location.reload();
                }
            },
            complete: function() {
                removeLoader();
            },
        });
    });



    // Set Slider Images When Flower Color Selects   
    $(document).on('click', '.getColors', function() {

        var product_id  =   $(this).data('product_id');
        var shape_id    =   $(this).data('shape_id');
        var color_id    =   $(this).data('color_id');
        var checkLogin  =   "{{{ (Auth::user()) ? "true" : "false" }}}";

        $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: "{{ route('getproduct.colors') }}",
                data: {
                        _token      :   '{{ csrf_token() }}',
                        product_id  :   product_id,
                        shape_id    :   shape_id,
                        color_id    :   color_id,
                },
                beforeSend: function() {
                    showLoader();
                },
                success: function(Response){
                    if(Response.success){
                        var colors = JSON.parse(Response.colors);

                        //Remove Previous Slick Slides
                        var slickIndex =  $("#showColors").find('li').last().data('slick-index');
                        for($i=slickIndex; $i>=0; $i--){
                            $('.product-single_nav ul').slick('slickRemove',$i);
                            $('.product-single_for ul').slick('slickRemove',$i);
                        }
                        
                        $(colors).map((id,color) => {

                            //When First Product Image Is Selected ByDefault Then Set Values
                            if(id == 0){
                                $("#color_id").replaceWith('<input type="hidden" id="color_id" name="color_id" value="'+color["color_id"]+'">');
                                $("#product_id").replaceWith('<input type="hidden" id="product_id" name="product_id" value="'+color["product_id"]+'">');
                                $("#addToWishlist").attr('data-product_id',color['product_id']);
                                $("#addToWishlist").attr('data-color_id',color['color_id']);
                                $("#removeFromWishlist").attr('data-product_id',color['product_id']);
                                $("#removeFromWishlist").attr('data-color_id',color['color_id']);

                                //Change Add To Cart Button
                                $("#btnAddToCart").replaceWith(color['cart_status']);

                                //Product Data
                                $("#productTitle").replaceWith("<h2 id='productTitle'>"+color['product']['getTitle']+"</h2>");
                                $("#productSku").replaceWith("<p id='productSku'>{{ __('Product Code') }} "+color['product']['sku']+"</p>");
                                if(color['product']['getDescription'] != null){
                                    $("#productDescription").replaceWith("<div class='prod-description' id='productDescription'>"+
                                                                    "<label class='font-weight-bold'>{{ __('Product Description') }}</label>"+
                                                                    ""+color['product']['getDescription']+"</div>");
                                }else{
                                    $("#productDescription").empty();
                                }
                                $("#productPrice").replaceWith("<h4 id='productPrice'>{{ __('AED') }} "+color['product']['order_amount']+".00</h4>");

                                //Breadcumb
                                $("#breadcrumb-product-title").replaceWith('<li id="breadcrumb-product-title" class="breadcrumb-item active" aria-current="page">'+color['product']['getTitle']+'</li>');

                                const segments  =   url.pathname.split('/');
                                const last      =   segments.pop() || segments.pop(); // Handle potential trailing slash
                                var new_url     =   url.href.replace(""+last+"",""+color['product']['slug']+"");

                                // Change Url
                                window.history.pushState("data","Title",new_url.toString());

                                // if(checkLogin == 'true'){
                                    $.ajax({
                                            type: 'POST',
                                            dataType: 'JSON',
                                            url: "{{ route('check.favourite') }}",
                                            data: {
                                                _token: '{{ csrf_token() }}',
                                                product_id : color['product_id'],
                                                color_id   : color['id'],
                                               },
                                            success: function(Response){
                                                if(Response.success){
                                                    $("#addToWishlist").addClass('active');
                                                    $("#removeFromWishlist").addClass('active');
                                                }else{
                                                    $("#addToWishlist").removeClass('active');
                                                    $("#removeFromWishlist").removeClass('active');
                                                }
                                            },
                                    });
                                // }
                            }
                            $('#showColors').slick('slickAdd',color["showColors"]);
                            $('#productMainUl').slick('slickAdd',color["productMainUl"]);

                            //Product Data
                            $("#productTitle").replaceWith("<h2 id='productTitle'>"+color['product']['getTitle']+"</h2>");
                            $("#productSku").replaceWith("<p id='productSku'>{{ __('Product Code') }} "+color['product']['sku']+"</p>");
                            if(color['product']['getDescription'] != null){
                                $("#productDescription").replaceWith("<div class='prod-description' id='productDescription'>"+
                                                                "<label class='font-weight-bold'>{{ __('Product Description') }}</label>"+
                                                                ""+color['product']['getDescription']+"</div>");
                            }else{
                                $("#productDescription").empty();
                            }
                            $("#productPrice").replaceWith("<h4 id='productPrice'>{{ __('AED') }} "+color['product']['order_amount']+".00</h4>");

                        });
                        
                        //Related Products
                        $("#related_list").empty();
                        $("#related_list").append(Response['related_product']);

                        $('.product-single_nav .slick-slider').slick('refresh');
                        $(".slick-current .img-zoom img").ezPlus(zoomOptions);

                    }     
                    if(Response.fail){
                        location.reload();
                    }
                },
                complete: function() {
                    removeLoader();
                },
            });
        });

    // Change Color_id in Form & wishlist icon
    $(".product-single_nav ul").on("beforeChange", function ( event, slick, currentSlide, nextSlide ) {

        var product_id  = $(this).find('.slick-slide[data-slick-index='+nextSlide+']').find('span').data('product_id');
        var color_id    = $(this).find('.slick-slide[data-slick-index='+nextSlide+']').find('span').data('color_id');
        var box_id      = $(this).find('.slick-slide[data-slick-index='+nextSlide+']').find('span').data('box_id');

        var checkLogin  = "{{{ (Auth::user()) ? "true" : "false" }}}";

        $("#addToWishlist").attr('data-product_id',product_id);
        $("#addToWishlist").attr('data-color_id',color_id);
        $("#removeFromWishlist").attr('data-product_id',product_id);
        $("#removeFromWishlist").attr('data-color_id',color_id);

        $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: "{{ route('product.details') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id  : product_id,
                    color_id    : color_id,
                    box_id      : box_id,
                },
                success: function(Response){
                    if(Response.success){
                        var product = JSON.parse(Response.product)

                        const segments  =   url.pathname.split('/');
                        const last      =   segments.pop() || segments.pop(); // Handle potential trailing slash
                        var new_url     =   url.href.replace(""+last+"",""+product['slug']+"");

                        // Change Url
                        window.history.pushState("data","Title",new_url.toString());

                        //Breadcumb
                        $("#breadcrumb-product-title").replaceWith('<li id="breadcrumb-product-title" class="breadcrumb-item active" aria-current="page">'+product['getTitle']+'</li>');

                        //Form Value Change
                        $("#color_id").replaceWith('<input type="hidden" id="color_id" name="color_id" value="'+product['color_id']+'">');
                        $("#product_id").replaceWith('<input type="hidden" id="product_id" name="product_id" value="'+product['id']+'">');

                        //Change Add To Cart Button
                        $("#btnAddToCart").replaceWith(product['cart_status']);

                        //Product Data
                        $("#productTitle").replaceWith("<h2 id='productTitle'>"+product['getTitle']+"</h2>");
                        $("#productSku").replaceWith("<p id='productSku'>{{ __('Product Code') }} "+product['sku']+"</p>");
                        if(product['getDescription'] != null){
                            $("#productDescription").replaceWith("<div class='prod-description' id='productDescription'>"+
                                                            "<label class='font-weight-bold'>{{ __('Product Description') }}</label>"+
                                                            ""+product['getDescription']+"</div>");
                        }else{
                            $("#productDescription").empty();
                        }
                        $("#productPrice").replaceWith("<h4 id='productPrice'>{{ __('AED') }} "+product['order_amount']+".00</h4>");

                        //Related Products
                        $("#related_list").empty();
                        $("#related_list").append(Response['related_product']);

                    }else{
                       location.reload();
                    }
                },
        });

        $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: "{{ route('check.favourite') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id : product_id,
                    color_id   : color_id,
                   },
                success: function(Response){
                    if(Response.success){
                        $("#addToWishlist").addClass('active');
                        $("#removeFromWishlist").addClass('active');
                    }else{
                        $("#addToWishlist").removeClass('active');
                        $("#removeFromWishlist").removeClass('active');
                    }
                },
        });
    });

    });

    // add to wishlist (With Color & Qty)
    $(document).on('click','.add-to-wishlist',function(){
        var product_id    = $(this).attr('data-product_id');
        var custom_id     = $(this).attr('data-custom_id');
        var color_id      = $(this).attr('data-color_id');
        var element       = $(this);

        if( $(this).hasClass("active") ){
            $.ajax({
                type: 'DELETE',
                dataType: 'JSON',
                url: "{{ route('remove-from-wishlist') }}",
                data: {
                    _token      :   '{{ csrf_token() }}',
                    product_id  :   product_id,
                    custom_id   :   custom_id,
                    color_id    :   color_id,
                },
                success: function(Response){
                    if(Response.success){
                        element.removeClass('active');
                    }
                    else if(Response.original){
                        element.removeClass('active');
                    }
                },
            });
        } 
        else{
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
                        element.addClass('active');
                    }
                    else if(Response.original){
                        element.addClass('active');
                    }
                },
            });
        }
    });
   
    //Multiple Product Select
    $(document).on('change','.products-list_details .btn-outline input',function(){
    // $('.products-list_details .btn-outline input').change(function(){

        //Select Product
        if($(this).is(':checked')){            
            var product_id  = $(this).data('product_id');
            var custom_id   = $(this).data('custom_id');
            var minqty      = $(this).data('minqty');
            var title       = $(this).data('title');
            var price       = $(this).data('price');
            total          += price;
            

            $("#multiple_products").append('<input type="hidden" name="product_id[]" value="'+product_id+'" id="'+product_id+'">'+
                                           '<input type="hidden" name="quantity[]" value="'+minqty+'" id="'+minqty+'">'+
                                           '<input type="hidden" name="custom_id[]" value="'+custom_id+'" id="'+custom_id+'">');


            if($('.products-list_details input:checked').length == 1){
                $("#combo_title").replaceWith(
                    '<h3 id="combo_title"><span class="font-weight-bold">'+title+'</span>'+ 
                    '<br/> Total Price:'+
                    '<span class="font-weight-bold total-amt">AED '+total+'</span></h3>');
            }
            else{
                count += 1;
                if(count>0){
                    $("#combo_title").replaceWith(
                    '<h3 id="combo_title"><span class="font-weight-bold">'+title+'</span> + '+count+' addons '+ 
                    '<br/> Total Price:'+
                    '<span class="font-weight-bold total-amt">AED '+total+'</span></h3>');
                }
                else{
                    $("#combo_title").replaceWith(
                    '<h3 id="combo_title"><span class="font-weight-bold">'+title+'</span> + More '+ 
                    '<br/> Total Price:'+
                    '<span class="font-weight-bold total-amt">AED '+total+'</span></h3>');
                }
            }

            $(this).attr('checked');
            $(this).parent().addClass('active');
            $(this).parent().find('span').text('Selected');
            $('.total-price').slideDown(500);
        }

        //Deselect Product
        else{        
                $(this).removeAttr('checked');
                $(this).parent().removeClass('active');
                $(this).parent().find('span').text('Select');

                if($('.products-list_details input:checked').length == 0){
                    $('.total-price').slideUp(500);
                }

                var product_id = $(this).data('product_id');
                var custom_id  = $(this).data('custom_id');
                var minqty     = $(this).data('minqty');
                var price      = $(this).data('price');

                count -= 1;
                total -= price;

                if(count > 0){
                    if(title != undefined){
                        $("#combo_title").replaceWith(
                        '<h3 id="combo_title"><span class="font-weight-bold">'+title+'</span> + '+count+' addons '+ 
                        '<br/> Total Price:'+
                        '<span class="font-weight-bold total-amt">AED '+total+'</span></h3>');
                    }else{
                        $("#combo_title").replaceWith(
                        '<h3 id="combo_title"><span class="font-weight-bold">Products</span> + '+count+' addons '+ 
                        '<br/> Total Price:'+
                        '<span class="font-weight-bold total-amt">AED '+total+'</span></h3>');
                    }
                }
                else{
                    $("#combo_title").replaceWith(
                    '<h3 id="combo_title"><span class="font-weight-bold">Single Product</span>'+ 
                    '<br/> Total Price:'+
                    '<span class="font-weight-bold total-amt">AED '+total+'</span></h3>');
                }

                $("#"+product_id+"").remove();
                $("#"+minqty+"").remove();
                $("#"+custom_id+"").remove();
            }
    });

    $("#frmAddToCart").validate({
        rules: {
            color:{
                required:true,
                not_empty:true,
            }   
        },
        messages: {
            color:{
                required:"@lang('validation.required',['attribute'=>'color'])",
                not_empty:"@lang('validation.not_empty',['attribute'=>'color'])",
            },
        },
        errorClass: 'help-block',
        errorElement: 'span',

        highlight: function(element) {
           $(element).closest('.form-group').addClass('has-error').css('color','red');
        },
        unhighlight: function(element) {
           $(element).closest('.form-group').removeClass('has-error').css('color','black');
        },
        errorPlacement: function(error, element) {
            if (element.attr("data-error-container")) {
                error.appendTo(element.attr("data-error-container"));
            } else {
                error.insertAfter(element);
            }
        }
    });

    // Add To Cart(Single)
    $(document).on('click','#btnAddToCart',function(){
        var product_id  =   $("#product_id").val();
        var quantity    =   $("#quantity").val();
        var color_id    =   $("#color_id").val();

        $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: "{{ route('add-to-cart') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    product_single  : true,
                    product_id      : product_id,
                    quantity        : quantity,
                    color_id        : color_id,
                },
                beforeSend: function() {
                    showLoader();
                },
                success: function(Response){
                    if(Response.success){
                        $('#header').replaceWith(Response['header']);
                        $("#btnAddToCart").replaceWith('<button type="button" id="btnAddToCart" class="common-black-btn full" disabled>Added Into Cart</button>');
                    }
                    if(Response.original){
                        $('#header').replaceWith(Response.original[1]);
                        $("#btnAddToCart").replaceWith('<button type="button" id="btnAddToCart" class="common-black-btn full" disabled>Added Into Cart</button>');
                        location.reload();
                    }
                    //Country(select)
                    customSelect = $('select');
                    // Options for custom Select
                    jcf.setOptions('Select', {
                        wrapNative: false,
                        wrapNativeOnMobile: false,
                        fakeDropInBody: false
                    });
                    jcf.replace(customSelect);
                    jcf.refresh();

                    $('.header-content_inner > ul > li:not(.wishlist)').click(function () {
                        $(this).toggleClass('show')
                    });
                },
                complete: function() {
                    removeLoader();
                },
            });
    });
});

</script>
@endpush