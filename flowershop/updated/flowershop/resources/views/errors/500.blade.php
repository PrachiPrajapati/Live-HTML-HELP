@extends('frontend.layouts.app')

@section('main-content')
<!-- error section -->
<section class="error-section error-500 common-spacing d-flex align-items-center">
    <article class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-6 col-lg-4">
                   <div class="error-content">
                        <img src="{{ asset('frontend/images/flower-box-2.png') }}" alt="flower">
                        <h1>500</h1>
                        <h2 class="font-weight-bold">Sorry, it’s not you. It’s us!</h2>
                        <p>There is an internal server error, please try to refresh the page and feel free to reach out to our team if the
                            problem
                            persists</p>
                        <a onclick="location.reload()" class="btn-outline">Reload</a>
                   </div>
                </div>
            </div>
    </article>
</section>
@endsection('main-content')