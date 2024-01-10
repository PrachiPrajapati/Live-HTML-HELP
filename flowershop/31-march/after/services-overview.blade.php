@extends('frontend.layouts.app')

@push('banner-section')
 <div class="banner no-overlay d-flex align-items-center" style="background-image: url('{{ generateURL($banner->getBannerImage()) }}')">
</div>
@endpush

@section('main-content')
<section class="services-overview-slider-section common-spacing">
    <article>
        <div class="services-overview-slider_intro">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <h5>Maison Des Fleurs supplies hotels, offices and other retail business premises. Whenever your company is looking for
                        retail or offices floral arrangements we can provide it and you can choose from a variety of weekly or monthly flower
                        services and deliveries. </h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
                    @if($sliders != null && $sliders != '[]')
                    @foreach($sliders as $slider)
                        <div class="col-md-6">
                            <div class="common-card">
                                <div class="common-card_image">
                                    <img src="{{ generateURL($slider->getBannerImage()) }}" alt="corporate">
                                </div>
                                <div class="common-card_title">
                                    <h2>{{ $slider->getTitle() }}</h2>
                                </div>
                                <div class="common-card_body">
                                    <p class="large-font">
                                        {{ $slider->getDescription() }}
                                    </p>
                                    <a href="{{ route('service.inquiry.form') }}" class="btn-outline border-brown">Get a Quote</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @endif
                </div>
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
        slidesToShow: 1,
        slidesToScroll: 1,
        centerMode: true,
        centerPadding: '15%',
        rows: 0,
        rtl: true,
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