@extends('frontend.layouts.app')

@push('banner-section')
<!--******************* Banner Section Start ******************-->
<div class="banner home-banner d-flex align-items-center" style="background-image: url('{{ asset('frontend/images/home-banner.png') }}')">
    <div class="gradient-overlay"></div>
    <div class="container pos-rel">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <h1>When you think of flowers, think of ours.</h1>
                <p>Millions of people around the world have already made the place where their work happens</p>
                <a href="{{ route('search') }}" class="btn-outline">Discover</a>
            </div>
        </div>
    </div>
</div>
<!--******************* Banner Section End ******************-->
@endpush

@section('main-content')

@if(Session::has('message'))
    <p id="subscribeMessage" class="alert alert-info">{{ Session::get('message') }}</p>
@endif

<!-- Occassion section -->
@if($occasions != null && $occasions != '[]')
<section class="occassion-section common-spacing pos-rel">
    <div class="has-btm-border">
        <div class="container">
            <div class="border-div"></div>
        </div>
    </div>
    <article class="container">
        <div class="title-block">
            <h2>For Every Occassion</h2>
        </div>
        <div class="occassion-cat">
            <div class="row">
            @foreach($occasions as $data)
                @if($data->category != null)
                <div class="col-md-6 col-lg-3 col-6">
                    <div class="occassion-cat-box common-cat-box">
                        <a href="{{ route('category',$data->category->slug) }}" class="occassion-cat-box_link"></a>
                        <div class="occassion-cat-box_image">
                            <img src="{{ generateURL($data->category->image) }}" alt="occassion-mixed-flowers">
                        </div>
                        <h3>{{ $data->category->getTitle() }}</h3>
                    </div>
                </div>
                @endif
            @endforeach 
            </div>
        </div>
    </article>
</section>
@endif

@if($colors != null && $colors != '[]')
<!--Shop by color section -->
<section class="shop-by-color-section common-spacing pos-rel">
    <div class="has-btm-border">
        <div class="container">
            <div class="border-div"></div>
        </div>
    </div>
    <article class="container">
        <div class="title-block">
            <h2>Shop By Color</h2>
        </div>
        <ul class="shop-by-color-list">
        @foreach($colors as $data)
            @if($data->color != null && $data->category != null)
            <li>
                <a href="{{ route('category',[$data->category->slug,'color_id' => $data->color->id]) }}"><img src="{{ generateURL($data->category->image)  }}" alt="color-image" class="img-fluid"></a>
                <div class="common_image-box">
               {{-- <!--      <div class="dyn-img common_image"
                        style="background-image: url('');"></div>
                    <a href="">  -->  --}}
                </div>
                <div class="shop-by-color-list_details">
                    <div class="cat-name">
                        <a href="{{ route('category',[$data->category->slug,'color_id' => $data->color->id]) }}" class="view-btn">
                            <span>{{ $data->category->getTitle() }}</span>
                            <img src="{{ asset('frontend/images/arrow-right-dark.svg') }}" alt="arrow">
                        </a>
                    </div>
                    <h2><a href="{{ route('category',[$data->category->slug,'color_id' => $data->color->id]) }}">{{ $data->color->getTitle() }}</a></h2>
                </div>
            </li>
            @endif
        @endforeach
        </ul>
    </article>
</section>
@endif

<!-- Shop our new products section -->
@if($products != null && $products != '[]')
<section class="shop-new-section common-spacing pos-rel">
    <div class="has-btm-border">
        <div class="container">
            <div class="border-div"></div>
        </div>
    </div>
    <article class="container">
        <div class="title-block">
            <h2>Shop Our New Products</h2>
        </div>
        <div class="shop-new-cat">
            <div class="row">
                @foreach($products as $product)
                <div class="col-md-6 col-lg-3 col-6">
                    <div class="shop-new-cat-box">
                        <div class="shop-new-cat-box_image common-cat-box">
                            <a href="{{ route('product.show',$product->slug) }}" class="shop-new-cat-box_link">
                                <img src="{{ generateURL($product->image) }}" alt="mixed-flowers">
                            </a>
                        </div>
                        <div class="shop-new-cat-box_details">
                            <h6><a href="{{ route('product.show',$product->slug) }}">{{ $product->getEnglishTitle() }}</a></h6>
                            <p>AED {{ $product->order_amount }}.00</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </article>
</section>
@endif

<!--Weddings and corporate events section -->
@if($services != null && $services != "[]")
<section class="weddings-events-section common-spacing">
    <article class="container">
        <div class="title-block has-subtitle">
            <h2>Services</h2>
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

<!-- Featured product banner -->
<section class="featured-product-banner">
    <article class="container">
        <div class="banner-inner dyn-img" style="background-image: url('{{ asset('frontend/images/featured-product-banner-bg.jpg') }} ');">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-11">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <h1>Franchise Request</h1>
                            <p>Millions of people around the world have already made the place where their work
                                happens</p>
                            <a href="{{ route('franchisesrequests.index') }}" class="link-btn">Request Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
</section>

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
@if($categories != null && $categories != '[]')
<section class="shop-by-category-section common-spacing">
    <article class="container">
        <div class="title-block has-subtitle">
            <h2>Shop by Category</h2>
            <!-- <a href="#">View All Products</a> -->
        </div>
        <ul class="shop-by-cat-list">
            @foreach($categories as $category)
                @if($category->image != null)
                <li>
                    <div class="common_image-box">
                        <div class="dyn-img common_image"
                            style="background-image: url('{{ generateURL($category->image) }}');">
                            <a href="{{ route('category',$category->slug) }}"></a>
                            <div class="shop-by-cat-list_details">
                                <h2 class="text-white"><a href="{{ route('category',$category->slug) }}">{{ $category->getTitle() }}</a></h2>
                                <a href="{{ route('category',$category->slug) }}" class="view-btn text-white">View More <img
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
    <script type="text/javascript">
        $("#subscribeMessage").delay(4000).slideUp(300);
    </script>
@endpush