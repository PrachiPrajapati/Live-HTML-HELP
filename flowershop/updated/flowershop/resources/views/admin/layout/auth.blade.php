<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <title>{{ $title ?? "" }} | {{ config('app.name') }}</title>

         {{-- Favicon Included --}}
        @include('frontend.layouts.includes.favicon')

        @include('admin.layout.includes.meta')
        {{-- Global Level CSS --}}
            @stack('extra-low-priority-css')
                @include('admin.layout.includes.css')
            @stack('extra-hig-priority-css')
        <link href="{{ asset('admin/css/login.min.css') }}" rel="stylesheet" type="text/css" />

        {{-- Add Favicon Icons --}}
    </head>

    <body class="login">
        <div class="logo">
                <a href="{{ route('admin.login') }}">
                    <img class="" src="{{ asset('admin/images/logo.svg') }}" alt="{{ config('app.name') }}" style="background-color: #364150 " height="100" />
                </a>
        </div>
        
        <div class="content">
            @yield('content')
        </div>
        <div class="copyright"> {{ \Carbon\Carbon::now()->format('F, Y') }} © {{ config('app.name') }}. </div>

        <!-- BEGIN CORE PLUGINS -->
            @include('admin.layout.includes.js')
            @stack('extra-js')
    </body>

</html>