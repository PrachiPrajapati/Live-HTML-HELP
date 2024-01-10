<script src="{{ asset('frontend/js/lib/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/js/modernizr.js') }}"></script>

<!-- <script src="{{ asset('frontend/js/bootstrap.bundle.js') }}"></script> -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>

{{-- original js files --}}
{{-- 
<!-- <script src="{{ asset('frontend/js/bootstrap.js') }}"></script>
<script src="{{ asset('frontend/js/mmenu.js') }}"></script>
<script src="{{ asset('frontend/js/jcf.js') }}"></script>
<script src="{{ asset('frontend/js/jcf.select.js') }}"></script> -->
--}}

<script src="{{ asset('frontend/js/bootstrap.js') }}"></script>

{{-- minify js --}}
<script type="text/javascript" src="{{ asset('js/frontend/mmenu.js') }}"></script>
<script src="{{ asset('js/frontend/jcf.js') }}"></script>
<script src="{{ asset('js/frontend/jcf.select.js') }}"></script>
{{-- end minify js --}}
<!-- custom scrollbar  -->
{{-- minify js --}}
<script src="{{ asset('frontend/js/jquery.mCustomScrollbar.min.js') }}"></script>
{{-- end minify js --}}

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="js/html5shiv.min.js"></script>
  <script src="js/respond.min.js"></script>
<![endif]-->

<script>
    var customSelect;
    var checkLogin = "{{{ (Auth::user()) ? "true" : "false" }}}";

    $(document).ready(function () {

        /* search popup focus */
        $(".header-form .input-group input").focus(function() {
            $(".search-popup").css("display", "block");
        }).blur(function() {
            $(document).on('click', function(e) {
                var element = $('.header-form');
                if (!element.is(e.target) && element.has(e.target).length === 0) {
                    $(".search-popup").css("display", "none");
                }
            });
        });

        // select 
        var customScroll = $('.has-custom-scroll');
            // Options for custom Select
            jcf.setOptions('Select', {
                wrapNative: false,
                wrapNativeOnMobile: false,
                fakeDropInBody: false,
                useCustomScroll:false
            });
            jcf.replace(customScroll);
            jcf.refresh();
            
          
        // $(function () {
           var customSelect = $('select');
            // Options for custom Select
            jcf.setOptions('Select', {
                wrapNative: false,
                wrapNativeOnMobile: false,
                fakeDropInBody: false
            });
            jcf.replace(customSelect);
            jcf.refresh();
        // });
        (function($){
        $(".has-custom-scroll").on("focus",function(){
            $(".has-custom-scroll .jcf-list-content").mCustomScrollbar();
        });
    })(jQuery);

        // navbar toggle
        var $navbartoggle = $("body");
        $('.navbar-toggler').click(function () {
            $navbartoggle.toggleClass("menu-open");
        });
        $('.navbar-nav .nav-link').click(function () {
            $('body').removeClass('menu-open');
        });
         // show dropdown
        $('.header-content_inner > ul > li:not(.wishlist)').click(function () {
            $(this).toggleClass('show')
        });
        // modal open 
        $(document).on('hidden.bs.modal', function () {
            if ($('.modal.show').length) {
                $('body').addClass('modal-open');
            }
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
        $('.navbar .nav-item:not(:last-child) > a').click(function(e){
            e.preventDefault();
            e.stopPropagation();
        });        
    });
    
    if(checkLogin == 'true'){
        $('body').addClass('logged-in');
    }
    else{
        $('body').removeClass('logged-in');
    }

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
                                api.closeAllPanels();
                               
                                if(checkLogin == 'true'){
                                    document.body.classList.add("mm-wrapper","logged-in");
                                }
                                else{
                                    document.body.classList.add("mm-wrapper");
                                }
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