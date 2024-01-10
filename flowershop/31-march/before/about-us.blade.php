@extends('frontend.layouts.app')

@push('banner-section')
<!--******************* Banner Section Start ******************-->
<div class="banner no-overlay small-banner d-flex align-items-center" style="background-image: url('{{ generateURL($banners[0]->getBannerImage()) }}' );">
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
                    <h2>{{ $banners[0]->getTitle() }}</h2>
                    <p>{!! $banners[0]->getDescription() !!}</p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="common-card">
                            <div class="common-card_image">
                                <img src="{{ generateURL($banners[1]->getBannerImage()) }}" alt="services">
                            </div>
                            <div class="common-card_title">
                                <h2>{{ $banners[1]->getTitle() }}</h2>
                            </div>
                            <div class="common-card_body">
                                <p class="large-font">{!! $banners[1]->getDescription() !!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="common-card">
                            <div class="common-card_image">
                                <img src="{{ generateURL($banners[2]->getBannerImage()) }}" alt="products">
                            </div>
                            <div class="common-card_title">
                                <h2>{{ $banners[2]->getTitle() }}</h2>
                            </div>
                            <div class="common-card_body">
                                <p class="large-font">{!! $banners[2]->getDescription() !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
</section>
@endsection