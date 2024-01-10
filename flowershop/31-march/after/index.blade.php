@extends('frontend.layouts.app')

@push('top-css')
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/slick-theme.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/slick.css') }}">
@endpush

@push('banner-section')
<!--******************* Banner Section Start ******************-->
@if(!$home_banners->isEmpty())
<div class="banner home-banner no-overlay">
    @foreach($home_banners as $home_banner)
    <div class="item">
        <div class="item-inner d-flex align-items-center" style="background-image: url('{{ generateURL( $home_banner->getBannerImage() ) }}')">
            <div class="gradient-overlay"></div>
            <div class="container pos-rel">
                <div class="row">
                    <div class="col-md-5 col-lg-3">
                        <h1>{{ $home_banner->getTitle() }}</h1>
                        <p>{!! $home_banner->getDescription() !!}</p>
                        <a href="{{ $home_banner->getUrl() }}" class="btn-outline">Discover</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach        
</div>
@endif
<!--******************* Banner Section End ******************-->
@endpush

@section('main-content')

@if(Session::has('message'))
    <p id="subscribeMessage" class="alert alert-info">{{ Session::get('message') }}</p>
@endif

@if(!$home_sections->isEmpty())

{{-- Section 1 --}}
@if($home_sections[0]->block_show != null && $home_sections[0]->block_show != '[]')
<section class="occassion-section common-spacing pos-rel">
    <div class="has-btm-border">
        <div class="container">
            <div class="border-div"></div>
        </div>
    </div>
    <article class="container">
        <div class="title-block">
            <h2>{{ $home_sections[0]->getTitle() }}</h2>
        </div>
        <div class="occassion-cat slider">
            @foreach($home_sections[0]->block_show as $occasion_block)
                @if($occasion_block->is_show == 'y' && $occasion_block->is_active == 'y')
                <div class="occassion-cat_item">
                    <div class="occassion-cat-box common-cat-box">
                        <a href="{{ route('section.product',$occasion_block->slug) }}" class="occassion-cat-box_link"></a>
                        <div class="occassion-cat-box_image">
                            <img src="{{ generateURL($occasion_block->getImage()) }}" alt="occassion-mixed-flowers">
                        </div>
                        <h3>{{ $occasion_block->getTitle() }}</h3>
                    </div>
                </div>
                @endif
            @endforeach 
        </div>
    </article>
</section>
@endif

{{-- Section 2 --}}
@if($home_sections[1]->block_show != null && $home_sections[1]->block_show != '[]')
<section class="shop-by-color-section common-spacing pos-rel">
    <div class="has-btm-border">
        <div class="container">
            <div class="border-div"></div>
        </div>
    </div>
    <article class="container">
        <div class="title-block">
            <h2>{{ $home_sections[1]->getTitle() }}</h2>
        </div>
        <ul class="shop-by-color-list">
         @foreach($home_sections[1]->block_show as $color_block)
            @if($color_block->is_show == 'y' && $color_block->is_active == 'y')
            <li>
                <a href="{{ route('section.product',$color_block->slug) }}"><img src="{{ generateURL($color_block->getImage()) }}" alt="color-image" class="img-fluid"></a>
                <div class="common_image-box">
                </div>
                <div class="shop-by-color-list_details">
                    <div class="cat-name">
                        <a href="{{ route('section.product',$color_block->slug) }}" class="view-btn">
                            <span>{{ $color_block->getTitle() }}</span>
                            <img src="{{ asset('frontend/images/arrow-right-dark.svg') }}" alt="arrow">
                        </a>
                    </div>
                    <h2><a href="{{ route('section.product',$color_block->slug) }}">{{ $color_block->getTitle() }}</a></h2>
                </div>
            </li>
            @endif
        @endforeach
        </ul>
    </article>
</section>
@endif

{{-- Section 3 --}}
@if($home_sections[2]->block_show != null && $home_sections[2]->block_show != '[]')
<section class="shop-new-section common-spacing pos-rel">
    <div class="has-btm-border">
        <div class="container">
            <div class="border-div"></div>
        </div>
    </div>
    <article class="container">
        <div class="title-block">
            <h2>{{ $home_sections[2]->getTitle() }}</h2>
        </div>
        <div class="shop-new-cat slider">
             @foreach($home_sections[2]->block_show as $occasion_block)
                @if($occasion_block->is_show == 'y' && $occasion_block->is_active == 'y')
                <div class="shop-new-cat-box_item">
                    <div class="shop-new-cat-box">
                        <div class="shop-new-cat-box_image common-cat-box">
                            <a href="{{ route('section.product',$occasion_block->slug) }}" class="shop-new-cat-box_link"></a>
                            <img src="{{ generateURL($occasion_block->getImage()) }}" alt="mixed-flowers">
                        </div>
                        <div class="shop-new-cat-box_details">
                            <h6><a href="{{ route('section.product',$occasion_block->slug) }}">{{ $occasion_block->getTitle() }}</a></h6>
                            {{-- <p>AED 475.00</p> --}}
                        </div>
                    </div>
                </div>
                @endif
            @endforeach 
        </div>
    </article>
</section>
@endif

@endif

<!--Weddings and corporate events section -->
@if($services != null && $services != "[]")
<section class="weddings-events-section common-spacing">
    <article class="container">
        <div class="title-block has-subtitle">
            <h2>{{ $setting->getServiceValue() }}</h2>
            <!-- <p>Millions of people around the world have already made the place where their work happens.</p> -->
        </div>
        <div class="row weddings-events">
        @foreach($services as $service)
            @if($service->service != null)
            <div class="col-md-6 col-lg-4">
                <div class="common_image-box">
                    <div class="dyn-img common_image"
                        style="background-image: url('{{ generateURL($service->service->getBannerImage())}}');">
                    </div>
                    <a href="{{ route('services-inner',$service->service->slug) }}"></a>
                </div>
                <div class="weddings-events_details">
                     <div class="cat-name">
                        <a href="#"></a>
                    </div>
                    <h2><a href="{{ route('services-inner',$service->service->slug) }}">{{ $service->service->getTitle() }}</a></h2>
                    <a href="{{ route('services-inner',$service->service->slug) }}" class="view-btn">Get In Touch <img src="{{ asset('frontend/images/arrow-right-dark.svg') }}"
                            alt="arrow"></a>
                </div>
            </div>
            @endif
        @endforeach
        </div>
    </article>
</section>
@endif

@if($banner != null)
<!-- Featured product banner -->
<section class="featured-product-banner">
    <article class="container">
        <div class="banner-inner dyn-img" style="background-image: url('{{ generateURL( $banner->getBannerImage() ) }} ');">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-11">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <h1>{{ $banner->getTitle() }}</h1>
                            <p>{!! $banner->getDescription() !!}</p>
                            <a href="{{ route('franchisesrequests.index') }}" class="link-btn">Request Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
</section>
@endif

<!-- separator -->
<div class="separator-img">
    <div class="container">
    </div>
</div>


<!-- Subscribe banner -->
<section class="subscribe-section common-spacing">
    <article class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <h1>Be the first to know</h1>
                <p>Sign up for emails packed with finds and inspiration</p>
                <form class="subscribe-form" id="frmSubscriptionIndex" name="frmSubscription" action="{{ route('subscribe.user') }}" method="POST">
                    @csrf
                    <div class="input-group form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email Address" aria-label="Email Address"
                            aria-describedby="email-address-addon">
                        @if($errors->has('email'))
                            <span class="help-block">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                        <div class="input-group-append">
                            <button type="submit" class="input-group-text common-black-btn">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </article>
</section>

<!-- separator -->
<div class="separator-img">
    <div class="container">
    </div>
</div>

<!-- Shop by category section -->
@if($sequenceCategories != null && $sequenceCategories != '[]')
<section class="shop-by-category-section common-spacing">
    <article class="container">
        <div class="title-block has-subtitle">
            <h2>{{ $setting->getShopCategoryValue() }}</h2>
            <!-- <a href="#">View All Products</a> -->
        </div>
        <ul class="shop-by-cat-list">
            @foreach($sequenceCategories as $sequenceCategory)
                @if($sequenceCategory->category != null && $sequenceCategory->category->is_active == 'y')
                <li>
                    <div class="common_image-box">
                        <div class="dyn-img common_image"
                            style="background-image: url('{{ generateURL($sequenceCategory->image) }}');">
                            <a href="{{ route('category',$sequenceCategory->category->slug) }}"></a>
                            <div class="shop-by-cat-list_details">
                                <h2 class="text-white"><a href="{{ route('category',$sequenceCategory->category->slug) }}">{{ $sequenceCategory->getTitle() }}</a></h2>
                                <a href="{{ route('category',$sequenceCategory->category->slug) }}" class="view-btn text-white">View More <img
                                src="{{ asset('frontend/images/arrow-right-white.svg') }}" alt="arrow"></a>
                            </div>
                        </div>
                    </div>
                </li>
                @endif
            @endforeach
        </ul>
    </article>
</section>
@endif

@endsection

@push('extra-js')
    <script src="{{ asset('frontend/js/slick.js') }}"></script>
    <script type="text/javascript">
        $("#subscribeMessage").delay(4000).slideUp(300);
        $(document).ready(function(){
            $('.home-banner').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                rows: 0,
                arrows: false,
                autoplay: true,
                rtl: true,
                autoplaySpeed: 5000
            });
            $('.occassion-cat.slider').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                dots: false,
                rows: 0,
                rtl: true,
                infinite: false,
                responsive: [
                    {
                        breakpoint: 1199,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                ]
            });
            $('.shop-new-cat.slider').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                dots: false,
                rows: 0,
                rtl: true,
                infinite: false,
                responsive: [
                    {
                        breakpoint: 1199,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                ]
            });
        })
    </script>
@endpush