@extends('frontend.layouts.app')

@section('main-content')
	 <!-- careers section -->
        <section class="careers common-spacing">
            <article class="container">
                <div class="row">
                    <div class="col-md-8 col-xl-4">
                        <h1 class="mb-3">Careers</h1>
                        <p>We are very happy that you are interested in joining your team. Below you can find positions that you can apply.</p>
                    </div>
                </div>
                <form>
                    <div class="careers-list">
                        <div class="row">
                        	@foreach($careers as $career)
                            <div class="col-md-6 col-xl-4">
                                <div class="careers-list_item">
                                    <h2>{{ $career->getTitle() }}</h2>
                                    <p>{!! $career->getSortDescription() !!}</p>
                                    <a href="{{ $career->getUrl() }}"> <button type="button" class="btn-outline">View More</button> </a>
                                </div>
                            </div>
                        	@endforeach
                        </div>
                    </div>
                </form>
            </article>
        </section>
@endsection('main-content')

@push('extra-js')
    <script>
        $(document).ready(function () {
            // select 
            $(function () {
                var customSelect = $('select');
                // Options for custom Select
                jcf.setOptions('Select', {
                    wrapNative: false,
                    wrapNativeOnMobile: false,
                    fakeDropInBody: false
                });
                jcf.replace(customSelect);
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

            // dropdown
            // $('.dropdown').on('mouseover', function () {
            //     var drp = document.querySelector(".dropdown");
            //     if (HorizontallyBound($("header"), $(this).children('.dropdown-menu'))) {
            //         $(this).addClass('out')
            //     }

            // }).on('mouseout', function () {
            //     $(this).removeClass('out')
            // });
            // function HorizontallyBound(parentDiv, childDiv) {
            //     console.log(childDiv)
            //     var parentRect = parentDiv.offset();
            //     var childRect = childDiv.offset();
            //     console.log(parentRect)
            //     console.log(childRect)
            //     // return parentRect.left <= childRect.left && parentRect.right >= childRect.right;
            // }

            // mmenu 
            var menu = new MmenuLight(
                document.querySelector('#menu'),
                '(max-width: 1199px)'
            );

            var navigator = menu.navigation({
                // selectedClass: 'Selected',
                slidingSubmenus: true,
                // theme: 'dark',
                title: ''
            });

            var drawer = menu.offcanvas({
                // position: 'left'
            });

            //  Open the menu.
            document.querySelector('a[href="#menu"]')
                .addEventListener('click', evnt => {
                    evnt.preventDefault();
                    drawer.open();
                });

            // add to wishlist
            $('.add-to-wishlist').click(function () {
                $(this).toggleClass('active');
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
        });
    </script>
@endpush