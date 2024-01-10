@extends('frontend.layouts.app')

@push('banner-section')
<!--******************* Banner Section Start ******************-->
<div class="banner banner-content-white d-flex align-items-center" style="background-image: url('{{ generateURL( $banners[0]->getBannerImage() ) }}')">
    <div class="gradient-overlay"></div>
        <div class="container pos-rel">
            <div class="row">
                <div class="col-md-5 col-lg-3">
                    <h1>{{ $banners[0]->getTitle() }}</h1>
                    <p>{!! $banners[0]->getDescription() !!}</p>
                </div>
            </div>
        </div>
</div>
<!--******************* Banner Section End ******************-->
@endpush

@section('main-content')
        
<!-- Delivery rates section -->
@if($delivery_charges != null && $delivery_charges != '[]')
<section class="delivery-rates common-spacing pos-rel">
    <div class="has-btm-border">
        <div class="container">
            <div class="border-div"></div>
        </div>
    </div>
    <article class="container">
        <div class="title-block has-subtitle">
            <h2>Delivery Charges</h2>
        </div>
        <div class="table-responsive">
            <table width="100%">
                <thead>
                    <tr>
                        <th class="title" width="30%">Location</th>
                        <th width="5%"></th>
                        <th class="title" width="30%">Minimum Amount</th>
                        <th width="5%"></th>
                        <th class="title" width="30%">Delivery Charges</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($delivery_charges as $delivery_charge)
                    <tr>
                        <td>{{ $delivery_charge->getCity() }}</td>
                        <td></td>
                        <td>AED {{ $delivery_charge->minimum_amount }}</td>
                        <td></td>
                        <td>AED {{ $delivery_charge->charges }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </article>
</section>
@endif

<!-- Info blocks section -->
<section class="info-blocks delivery common-spacing">
    <article class="container">
        <div class="info-blocks_item inverse">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="info-blocks_item-content">
                        <h2>{{ $banners[1]->getTitle() }}</h2>
                        <p>{!! $banners[1]->getDescription() !!}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{ generateURL( $banners[1]->getBannerImage() ) }}" alt="delivery-image">
                </div>
            </div>
        </div>
        <div class="info-blocks_item">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <img src="{{ generateURL( $banners[2]->getBannerImage() ) }}" alt="delivery-image">
                </div>
                <div class="col-lg-6">
                    <div class="info-blocks_item-content">
                        <h2>{{ $banners[2]->getTitle() }}</h2>
                        <p>{!! $banners[2]->getDescription() !!}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="info-blocks_item inverse">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="info-blocks_item-content">
                        <h2>{{ $banners[3]->getTitle() }}</h2>
                        <p>{!! $banners[3]->getDescription() !!}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{ generateURL( $banners[3]->getBannerImage() ) }}" alt="delivery-image">
                </div>
            </div>
        </div>
    </article>
</section>
@endsection