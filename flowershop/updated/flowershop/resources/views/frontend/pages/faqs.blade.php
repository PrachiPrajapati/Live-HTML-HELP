@extends('frontend.layouts.app')

@section('main-content')
<section class="common-spacing">
    <article class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-title">
                    <div id="page-faq" class="active">
                        <h1>FAQ</h1>
                        <p>We strive to provide you with the best buying experience possible. If you cannot find an answer to your question here,
                        please feel free to reach out to us by phone or email.</p>
                    </div>
                    <div id="page-terms" class="policy">
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
                    <div id="page-privacy" class="policy">
                        <h1>Privacy Policy</h1>
                        <p>These terms and conditions (the "Terms and Conditions") are the terms and conditions upon which Maison Des Fleurs
                            ("we/us") make this website <a href="mailto: www.maisondesfleurs.com">www.maisondesfleurs.com</a> (the "Maison Des
                            Fleurs Service") available to you and any of our
                            services which are accessible on or via the <a href="mailto: www.maisondesfleurs.com">www.maisondesfleurs.com</a>
                            site (the "Maison Des Fleurs Service").</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                             <a class="nav-link active" href="{{ route('faqs') }}">FAQ</a>
                            <a class="nav-link" href="{{ route('term-conditions') }}">Terms & Conditions</a>
                            <a class="nav-link" href="{{ route('privacy-policy') }}" >Privacy Policy</a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-faq" role="tabpanel" aria-labelledby="v-pills-faq-tab">
                                @if($faqs != null && $faqs != '[]')

                                    {{--
                                    <!-- @for($i=0; $i< count($faqs); $i++)
                                        @if($i==0)
                                        <div class="accordion" id="accordion{{ $faqs[$i]['id'] }}">
                                            <div class="card">
                                                <div class="card-header" id="cardheading{{ $faqs[$i]['id'] }}">
                                                    <h4>
                                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="collapse{{ $faqs[$i]['id'] }}"
                                                            aria-expanded="true" aria-controls="collapse{{ $faqs[$i]['id'] }}">
                                                            {{ $faqs[$i]['en_question'] }}
                                                        </button>
                                                    </h4>
                                                </div>
                                        
                                                <div id="collapse{{ $faqs[$i]['id'] }}" class="collapse show" aria-labelledby="cardheading{{ $faqs[$i]['id'] }}" data-parent="#accordion{{ $faqs[$i]['id'] }}">
                                                    <div class="card-body">
                                                        <p>{!! $faqs[$i]['en_answer'] !!}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="accordion" id="accordion-{{ $faqs[$i]['id'] }}">
                                            <div class="card">
                                                <div class="card-header" id="cardheading-{{ $faqs[$i]['id'] }}">
                                                    <h4>
                                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="collapse-{{ $faqs[$i]['id'] }}"
                                                            aria-expanded="false" aria-controls="collapse-{{ $faqs[$i]['id'] }}">
                                                            {{ $faqs[$i]['en_question'] }}
                                                        </button>
                                                    </h4>
                                                </div>
                                        
                                                <div id="collapse-{{ $faqs[$i]['id'] }}" class="collapse" aria-labelledby="cardheading-{{ $faqs[$i]['id'] }}" data-parent="#accordion-{{ $faqs[$i]['id'] }}">
                                                    <div class="card-body">
                                                        <p>{!! $faqs[$i]['en_answer'] !!}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @endif
                                    @endfor -->
                                    --}}

                                    {{-- Currently used  --}}

                                    <div class="accordion" id="faq">
                                        @foreach($faqs as $faq)
                                            <div class="card {{ $loop->first ? 'active' : '' }}">
                                                <div class="card-header" id="heading-{{ $faq->id }}">
                                                    <h4>
                                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse-{{ $faq->id }}"
                                                            aria-expanded="true" aria-controls="collapse-{{ $faq->id }}">
                                                            {{ $faq->getQuestion() }}
                                                        </button>
                                                    </h4>
                                                </div>
                                        
                                                <div id="collapse-{{ $faq->id }}" class="collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading-{{ $faq->id }}" data-parent="#faq">
                                                    <div class="card-body">
                                                        <p>{!! $faq->getAnswer() !!}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
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
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/mmenu-light.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/jcf.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/font-awesome.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/style.css') }}">
@endpush

@push('extra-js')
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/js/lib/jquery.min.js') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/js/modernizr.js') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/js/bootstrap.js') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/js/jcf.js') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/js/jcf.select.js') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/js/mmenu-light.js') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/js/mmenu-light.polyfills.js') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/js/jquery.inputmask.js') }}"> 

<script>
        $(document).ready(function () {
            // select 
            $(function () {
                var customSelect = $('select:not(.cart-select)');
                // Options for custom Select
                jcf.setOptions('Select', {
                    wrapNative: false,
                    wrapNativeOnMobile: false,
                    fakeDropInBody: false
                });
                jcf.replace(customSelect);
                jcf.refresh();

                var cartSelect = $('.cart-list select');
                // Options for custom Select
                jcf.setOptions('Select', {
                    wrapNative: false,
                    wrapNativeOnMobile: false,
                    fakeDropInBody: true
                });
                jcf.replace(cartSelect);
                jcf.refresh();
            });

            // navbar toggle
            var $navbartoggle = $("body");
            $('.navbar-toggler').click(function () {
                $navbartoggle.toggleClass("menu-open");
            });
           $('.navbar-nav .nav-link').click(function () {
                $('body').removeClass('menu-open');
            });

            // show dropdown 
            $('.header-content_inner > ul > li:last-child').click(function () {
                $(this).toggleClass('show')
            });

           // dropdown
            $(".navbar li").on('mouseenter mouseleave', function (e) {
                if ($('.dropdown-menu', this).length) {
                    var elm = $('.dropdown-menu', this);
                    var off = elm.offset();
                    var l = off.left;
                    var r = ($(window).width() - (elm.offset().left + elm.outerWidth()));
                    var w = elm.outerWidth();
                    var docH = $(".container").height();
                    var docW = $(".container").width();
                    var wWidth = $(window).width();

                    var isEntirelyVisible = (l + w <= wWidth);
                    var isCenterVisible = (l - r + w > docW);
                    var isSndLastChild = $(this).is(':nth-last-child(2)');

                    if (!isEntirelyVisible) {
                         if (isCenterVisible && !isSndLastChild){
                                $(this).addClass('center');
                                var drpW = $('.navbar .navbar-nav .nav-item .dropdown-menu').width();
                                $('.navbar .navbar-nav .nav-item.center .dropdown-menu').css('left', 'calc(-50% - ' + drpW + 'px / 2)');
                         }
                         else{
                            $(this).addClass('out');
                         }
                    } else {
                        $(this).removeClass('out center');
                        $('.navbar .navbar-nav .nav-item.center .dropdown-menu').removeAttr('style');
                    }
                }
            });
            
           // cart quantity
           if ($('#quantity').val() == 1) {
                $('.minus').attr('disabled', true);
                $('.minus').css('cursor', 'not-allowed');
            }
            $('.minus').click(function () {
                if ($(this).is('[disabled=disabled]') == true) {
                    return false;
                }
                var $input = $(this).parent().find('input');
                var count = parseInt($input.val()) - 1;
                if (count == 1) {
                    $(this).attr('disabled', 'disabled');
                    $(this).css('cursor', 'not-allowed');
                }
                // count = count < 1 ? 1 : count;
                $input.val(count);
                $input.change();
                return false;
            });
            $('.plus').click(function () {
                var $input = $(this).parent().find('input');
                var count = parseInt($input.val()) + 1;
                if (count > 1) {
                    console.log(count);
                    $('.minus').attr('disabled', false);
                    $('.minus').css('cursor', 'pointer');
                }
                $input.val(count);
                $input.change();
                return false;
            });
            
            // modal form style
            $('.common-form .form-control').focus(function () {
                $(this).parent().addClass('input-focused');
            }).blur(function () {
                var inputLength = $(this).val();
                if (inputLength.length > 0 || $(this).is('[placeholder]') == true) {
                    $(this).parent().addClass('input-focused');
                } else {
                    $(this).parent().removeClass('input-focused');
                }
            });
             // input mask
            // $('.card-field').inputmask({ mask: ["9999 9999 9999 9999", "9999 9999 9999 9999",], keepStatic: true, "placeholder": "0000 0000 0000 0000" });
            // $('.date-field').inputmask({ mask: ["99 / 99", "99 / 99",], keepStatic: true, "placeholder": "MM / YY" });

            // modal open 
            $(document).on('hidden.bs.modal', function () {
                if ($('.modal.show').length) {
                    $('body').addClass('modal-open');
                }
            });

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
       // mmenu 
        var width = $(window).width();
        if (width < 1200) {
            document.addEventListener(
                "DOMContentLoaded", () => {
                    const menu = new Mmenu("#menu", {
                        navbar: {
                            sticky: false
                        },
                        offCanvas: {
                            blockUI: false
                        },
                        "extensions": [
                            "position-front"
                        ]

                    }, {
                        offCanvas: {
                            menu: {
                                insertSelector: 'header'
                            }
                        }
                    });
                    const api = menu.API;
                    document.querySelector(".navbar-toggler")
                        .addEventListener(
                            "click", (evnt) => {
                                if (document.body.classList.contains('mm-wrapper_opened')) {
                                    api.close();
                                    document.body.classList.add("mm-wrapper"); /* replace this script when logged in 
document.body.classList.add("mm-wrapper","logged-in");*/
                                }
                                else {
                                    evnt.preventDefault();
                                    api.open();
                                }
                            }
                        );
                }
            );
        }
    </script>
@endpush