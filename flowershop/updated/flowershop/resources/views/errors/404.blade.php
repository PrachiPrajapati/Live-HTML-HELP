@extends('frontend.layouts.app')

@section('main-content')
<!-- error section -->
<section class="error-section common-spacing d-flex align-items-center">
    <article class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-4">
                    <div class="error-content">
                        <h1>404</h1>
                        <p>Oooops, we can’t find the page you’re looking for :(</p>
                        <a href="{{ route('en'.'.home') }}" class="btn-outline">Go Back Home</a>
                        <img src="{{ asset('frontend/images/flower-box-1.png') }}" alt="flower">
                    </div>              
                </div>
            </div>
    </article>
</section>
@endsection('main-content')
