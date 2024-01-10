@extends('frontend.layouts.app')
    
@push('banner-section')
<div class="banner banner-content-white services-inner-banner d-flex align-items-center" style="background-image: url('{{ generateURL($service->getBannerImage())}}')">
        <div class="gradient-overlay"></div>
        <div class="container pos-rel">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <h1>{{ $service->getTitle() }}</h1>
                    <p>{{ $service->getDescription() }}</p>
                    <a href="{{ route('service.inquiry.form') }}" class="common-white-btn-outline">Request a Callback</a>
                </div>
            </div>
        </div>
    </div>
@endpush

@section('main-content')
<!-- Info blocks section -->
<section class="info-blocks common-spacing">
    <article class="container">  
            <div class="info-blocks_item">    
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <img src="{{ generateURL($service->getFirstSectionImage())}}" alt="info-block-image">
                    </div>
                    <div class="col-lg-6">
                        <div class="info-blocks_item-content">
                            <h1>{{ $service->getFirstSectionTitle() }}</h1>
                            <p>{{ $service->getFirstSectionDescription() }}</p>
                        </div>
                    </div>
                </div> 
            </div> 
            <div class="info-blocks_item inverse">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="info-blocks_item-content">
                            <h1>{{ $service->getSecondSectionTitle() }}</h1>
                            <p>{{ $service->getSecondSectionDescription() }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <img src="{{ generateURL($service->getSecondSectionImage()) }}" alt="info-block-image">
                    </div>
                </div>
            </div>
    </article>
</section>

<!-- services inner slider section --> 
@if( count($showcases) != 0 )
<section class="services-overview-slider-section service-inner">
    <article>
        <div class="title-block">
            <h2>Event Showcase</h2>
        </div>
        
        <div class="services-overview-slider">
            @foreach($showcases as $showcase )
            <div class="item dyn-img" style="background-image: url('{{ generateURL($showcase->getImage()) }}') ">
                <div class="slider-caption">
                    <h2>{{ $showcase->getTitle() }}</h2>
                    <a href="#" class="view-btn">View Collection <img src="{{asset('images/arrow-right-white.svg')}}" alt="arrow"> </a>
                </div>
            </div>
            @endforeach
        </div>
    </article>
</section> 
@endif

<!-- request callback section -->
<section class="request-callback">
    <article class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <h1>Request a Callback</h1>
                <h5>Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.</h5>
                <form id="frmCallback" name="frmCallback" action="{{ route('callback.store') }}" method="POST" class="form-inline align-items-start justify-content-center">
                    @csrf
                    <div class="form-group">
                        <input type="text" placeholder="Name" name="name" class="form-control">
                         @if($errors->has('name'))
                        <span class="help-block" >
                            {{ $errors->first('name') }}
                        </span>
                    @endif
                    </div>
                    <div class="form-group">
                        <input type="text" name="contact" placeholder="Phone Number" class="form-control">
                         @if($errors->has('contact'))
                        <span class="help-block" >
                            {{ $errors->first('contact') }}
                        </span>
                    @endif
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
<script src="{{ asset('admin/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('admin/js/custom_validations.js') }}"></script>
<script type="text/javascript">

    //Request a callback function
    $("#frmCallback").validate({
        rules: {
            name:{
                    required:true,
                    not_empty:true,
                    maxlength:150,
                },
            contact:{
                required:true,
                not_empty:true,
                pattern: /^(\d+)(?: ?\d+)*$/,
                minlength:8,
                maxlength:16,
            },
        },
        messages: {
            name:{
                required:"@lang('validation.required',['attribute'=>'name'])",
                not_empty:"@lang('validation.not_empty',['attribute'=>'name'])",
                maxlength:"@lang('validation.max.string',['attribute'=>'name','max'=>150])",
            },
            contact:{
                required:"@lang('validation.required',['attribute'=>'phone'])",
                not_empty:"@lang('validation.not_empty',['attribute'=>'phone'])",
                maxlength:"@lang('validation.max.string',['attribute'=>'phone','max'=>16])",
                minlength:"@lang('validation.min.string',['attribute'=>'phone','min'=>8])",
                pattern:"@lang('validation.numeric',['attribute'=>'phone'])",
                pattern:"phone must be a number.",
            },
        },
        errorClass: 'help-block',
        errorElement: 'span',

        highlight: function(element) {
           $(element).closest('.form-group').addClass('has-error').css('color','red');
        },
        unhighlight: function(element) {
           $(element).closest('.form-group').removeClass('has-error');
        },
        errorPlacement: function(error, element) {
            if (element.attr("data-error-container")) {
                error.appendTo(element.attr("data-error-container"));
            } else {
                error.insertAfter(element);
            }
        }
    });


    // services slider 
    $('.services-overview-slider').slick({
        arrows: false,
        dots: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        centerMode: false,
        centerPadding: '10',
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

