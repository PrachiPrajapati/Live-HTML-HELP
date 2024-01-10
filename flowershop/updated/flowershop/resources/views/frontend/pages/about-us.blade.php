@extends('frontend.layouts.app')

@push('banner-section')
<!--******************* Banner Section Start ******************-->
<div class="banner no-overlay small-banner d-flex align-items-center" style="background-image: url('{{ asset('frontend/images/about-us-banner.jpg') }}' );">
</div>
<!--******************* Banner Section End ******************-->
@endpush

@section('main-content')
<!-- about us section -->
<section class="about-us common-spacing">
    <article class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="about-intro">
                    <h2>Excellence is our philosophy</h2>
                    <p>At Maison des Fleurs, we strive for perfection in everything we do – from our elegant bouquets, sweet centerpieces and
                    captivating floral displays to our retail stores, corporate floral arrangements and spectacular floral displays for
                    weddings and other events.</p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="common-card">
                            <div class="common-card_image">
                                <img src="{{ asset('frontend/images/about-services-image.jpg') }}" alt="services">
                            </div>
                            <div class="common-card_title">
                                <h2>Services</h2>
                            </div>
                            <div class="common-card_body">
                                <p class="large-font">For events and weddings, Maison des Fleurs’ team of highly trained event managers and
                                    florists will help you imagine and
                                    create arrangements and settings that are truly breathtaking.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="common-card">
                            <div class="common-card_image">
                                <img src="{{ asset('frontend/images/about-products-image.jpg') }}" alt="products">
                            </div>
                            <div class="common-card_title">
                                <h2>Products</h2>
                            </div>
                            <div class="common-card_body">
                                <p class="large-font">Our unique creations, presented in our signature packaging, personify simple elegance and refined glamour. Each
                                arrangement is expertly designed to ensure it expresses the intended emotion.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
</section>
@endsection