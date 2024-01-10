@extends('frontend.layouts.app')

@push('banner-section')
<!--******************* Banner Section Start ******************-->
<div class="banner banner-content-white d-flex align-items-center" style="background-image: url('images/delivery-banner.jpg')">
    <div class="gradient-overlay"></div>
        <div class="container pos-rel">
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <h1>Delivery Right To Your Doorstep</h1>
                    <p>Our floral design team will assist you to create your bespoke floral arrangements to suit your business expectation.</p>
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
                        <h2>Delivery Right To Your Doorstep</h2>
                        <p>To ensure on-time delivery, please ensure that full address details are provided, along with the telephone number for the intended recipient. Please also provide your telephone number and an email address so that we can contact you to confirm delivery.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('frontend/images/delivery-image.jpg') }}" alt="delivery-image">
                </div>
            </div>
        </div>
        <div class="info-blocks_item">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <img src="{{ asset('frontend/images/delivery-image-1.jpg') }}" alt="delivery-image">
                </div>
                <div class="col-lg-6">
                    <div class="info-blocks_item-content">
                        <h2>Delivery Time and Charges</h2>
                        <p>Please select your required delivery time from the list of available slots shown when you place the order.</p>
                        <p>Delivery charges will apply depending on the Emirate you are requesting the delivery to.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="info-blocks_item inverse">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="info-blocks_item-content">
                        <h2>Payment Methods</h2>
                        <p>We accept online payments using all major credit and debit cards, including Visa and MasterCard</p>
                        <p>Please follow the steps to place your order and payment – providing us with your details, delivery address, and contact details for the recipient.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('frontend/images/delivery-image-2.jpg') }}" alt="delivery-image">
                </div>
            </div>
        </div>
    </article>
</section>
@endsection