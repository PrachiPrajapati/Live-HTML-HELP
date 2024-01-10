@extends('frontend.layouts.app')

@push('banner-section')
    <!--******************* Banner Section Start ******************-->
<div class="banner banner-content-white services-inner-banner d-flex align-items-center" style="background-image: url('{{ asset('frontend/images/services-inner-banner.jpg') }}')">
    <div class="gradient-overlay"></div>
    <div class="container pos-rel">
        <div class="row">
            <div class="col-md-5">
                <h1>Wedding</h1>
                <p>The traditions of knowledge and elegance remain, carefully preserved and transmitted by a team of top professionals
                competing for imagination, skill and modesty. Between their fingers magically born wildest bouquets, sweetest, most
                secret and creating most prestigious events.</p>
                <a href="#" class="common-white-btn-outline">Request a Callback</a>
            </div>
        </div>
    </div>
</div>
    <!--******************* Banner Section End ******************-->
@endpush

@section('main-content')
<!-- Info blocks section -->
<section class="info-blocks common-spacing">
    <article class="container">
        <div class="info-blocks_item">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <img src="{{ asset('frontend/images/service-inner-info-block-image.jpg') }}" alt="info-block-image">
                </div>
                <div class="col-lg-6">
                    <div class="info-blocks_item-content">
                        <h1>How it works Placeholder Title</h1>
                        <p>The traditions of knowledge and elegance remain, carefully preserved and transmitted by a team of top professionals
                        competing for imagination, skill and modesty. Between their fingers magically born wildest bouquets, sweetest, most
                        secret and creating most prestigious events.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="info-blocks_item inverse">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="info-blocks_item-content">
                        <h1>Why Us Placeholder Title</h1>
                        <p>The traditions of knowledge and elegance remain, carefully preserved and transmitted by a team of top professionals
                        competing for imagination, skill and modesty. Between their fingers magically born wildest bouquets, sweetest, most
                        secret and creating most prestigious events.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('frontend/images/service-inner-info-block-image-1.jpg') }}" alt="info-block-image">
                </div>
            </div>
        </div>
    </article>
</section>

<!-- services inner slider section -->
<section class="services-overview-slider-section service-inner">
    <article>
        <div class="title-block">
            <h2>Event Showcase</h2>
        </div>
        <div class="services-overview-slider">
            <div class="item dyn-img" style="background-image: url('{{ asset('frontend/images/event-image.jpg') }}');">
                <div class="slider-caption">
                    <h2>Winter Wonderland</h2>
                    <a href="#" class="view-btn">View Collection <img src="{{ asset('frontend/images/arrow-right-white.svg') }}" alt="arrow"> </a>
                </div>
            </div>
            <div class="item dyn-img" style="background-image: url('{{ asset('frontend/images/event-image-1.jpg') }}');">
                <div class="slider-caption">
                    <h2>Winter Wonderland</h2>
                    <a href="#" class="view-btn">View Collection <img src="{{ asset('frontend/images/arrow-right-white.svg') }}" alt="arrow"> </a>
                </div>
            </div>
            <div class="item dyn-img" style="background-image: url('{{ asset('frontend/images/event-image-2.jpg') }}');">
                <div class="slider-caption">
                    <h2>Winter Wonderland</h2>
                    <a href="#" class="view-btn">View Collection <img src="{{ asset('frontend/images/arrow-right-white.svg') }}" alt="arrow"> </a>
                </div>
            </div>
            <div class="item dyn-img" style="background-image: url('{{ asset('frontend/images/event-image-3.jpg') }}');">
                <div class="slider-caption">
                    <h2>Winter Wonderland</h2>
                    <a href="#" class="view-btn">View Collection <img src="{{ asset('frontend/images/arrow-right-white.svg') }}" alt="arrow"> </a>
                </div>
            </div>
        </div>
    </article>
</section> 


<!-- request callback section -->
<section class="request-callback">
    <article class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <h1>Request a Callback</h1>
                <h5>Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.</h5>
                <form class="form-inline align-items-start justify-content-center">
                    <div class="form-group">
                        <input type="text" placeholder="Name" class="form-control">
                        <span class="error-help">Your error here</span>
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="Phone Number" class="form-control">
                        <span class="error-help">Your error here</span>
                    </div>
                    <button type="submit" class="common-black-btn">Request a Callback</button>
                </form>
            </div>
        </div>
    </article>
</section>
@endsection

@push('top-css')
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/slick-theme.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/slick.css') }}">
@endpush

@push('extra-js')
    <script type="text/javascript" src="{{ asset('frontend/js/slick.js') }}"></script>

    <script type="text/javascript">

            // services slider 
            $('.services-overview-slider').slick({
                arrows: false,
                dots: true,
                slidesToShow: 2,
                slidesToScroll: 1,
                centerMode: true,
                centerPadding: '15%',
                rows: 0,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            centerMode: false,
                            centerPadding: '0',
                        }
                    }
                ]
            });
    </script>
@endpush