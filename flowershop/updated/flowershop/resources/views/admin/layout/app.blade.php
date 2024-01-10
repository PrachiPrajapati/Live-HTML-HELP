<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <title>{{ $title ?? "" }} | {{ config('app.name') }}</title>

         {{-- Favicon Included --}}
        @include('frontend.layouts.includes.favicon')

        @include('admin.layout.includes.meta')
        
        @stack('css-top')
            @include('admin.layout.includes.css')
        @stack('css-bottom')
        
    <!-- END HEAD -->

    {{-- <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white"> --}}
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white">
        

        @include('admin.layout.includes.header')
        <div class="clearfix"> </div>


        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            @include('admin.layout.includes.side-bar')
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    
                    @stack('breadcrumb')

                    @include('flash::message')

                    @stack('page-title')
                    
                    @yield('main-content')

                    <div class="clearfix"></div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        @include('admin.layout.includes.footer')
        <!-- END FOOTER -->
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
        {{-- <script src="../assets/pages/scripts/dashboard.min.js" type="text/javascript"></script> --}}
        @include('admin.layout.includes.js')

        @stack('extra-js')
    </body>

</html>