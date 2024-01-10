@extends('frontend.layouts.app')

@section('main-content')
<section class="common-spacing">
    <article class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-title">
                    <div id="page-terms" class="active">
                        <h1>Terms & Conditions</h1>
                        <p>These terms and conditions (the "Terms and Conditions") are the terms and conditions upon which Maison Des Fleurs
                        ("we/us") make this website www.maisondesfleurs.com (the "Maison Des Fleurs Service") available to you and any of our
                        services which are accessible on or via the www.maisondesfleurs.com site (the "Maison Des Fleurs Service").</p>
                        <h5><strong>These terms and conditions govern your use of the www.Maisondesfleurs.Com site and the maison des fleurs
                                service: </strong></h5>
                        <ul>
                            <li>Products</li>
                            <li>Prices</li>
                            <li>Orders / Payment </li>
                            <li>Delivery</li>
                            <li>Cancellation</li>
                            <li>Maison Des Fleurs</li>
                            <li>Customer Contact Centre </li>
                            <li>Disclaimer</li>
                            <li>Terms and Conditions</li>
                            <li>Social Media Terms of Use Policy </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link" href="{{ route('faqs') }}">FAQ</a>
                            <a class="nav-link active" href="{{ route('term-conditions') }}">Terms & Conditions</a>
                            <a class="nav-link" href="{{ route('privacy-policy') }}" >Privacy Policy</a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-terms" role="tabpanel" aria-labelledby="v-pills-terms-tab">
                                <div class="accordion" id="terms">
                                @if($terms != null && $terms != '[]')
                                    @foreach($terms as $term)
                                    <div class="card {{ $loop->first ? 'active' : '' }}">
                                        <div class="card-header" id="heading-{{ $term->id }}">
                                            <h4>
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse-{{ $term->id }}"
                                                    aria-expanded="true" aria-controls="collapse-{{ $term->id }}">
                                                    {{ $term->getTitle() }}
                                                </button>
                                            </h4>
                                        </div>
                                
                                        <div id="collapse-{{ $term->id }}" class="collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading-{{ $term->id }}" data-parent="#terms">
                                            <div class="card-body">
                                                <p>{!! $term->getDetails() !!}</p>
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
        </div>
    </article>
</section>       
@endsection('main-content')

@push('top-css')
@endpush

@push('extra-js')
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/js/jquery.inputmask.js') }}"> 

 <script>
        $(document).ready(function () {
            // faq 
            $('.nav-pills .nav-link').click(function(){
                var open = $(this).attr('data-open');
                $('.page-title > div').each(function(){
                    if (open == $(this).attr('id')) {
                        $('.page-title > div').removeClass('active');
                        $(this).addClass('active');
                    }
                });
            });
            $('.accordion .card-header .btn.btn-link').click(function(){
                var thisParent = $(this).parents('.card');
                 if (thisParent.hasClass('active')) {
                    $(this).parents('.card').removeClass('active');
                } else {
                    $('.accordion .card').removeClass('active');
                    $(this).parents('.card').addClass('active');
                }
            })
        });
    </script>
@endpush