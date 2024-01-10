@extends('frontend.layouts.app')

@section('main-content')
<!-- error section -->
<section class="error-section common-spacing d-flex align-items-center">
    <article class="container">
        <div class="row justify-content-center text-center">
            <div class="col-md-4">
                <div class="error-content">
                    <h1>503</h1>
                    <h2 class="font-weight-bold">The flowers are being prepared</h2>
                    <p>Don’t worry, the page is loading, we’ll be back soon :)</p>
                    <img src="{{ asset('frontend/images/flower-box.png') }}" alt="flower">
                </div>
            </div>
        </div>
    </article>
</section>
@endsection('main-content')