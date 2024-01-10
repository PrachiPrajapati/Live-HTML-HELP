@extends('frontend.layouts.app')

@section('main-content')
<!-- Latest News section -->
<section class="latest-news-section common-spacing">
    <article class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb common-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><img src="{{ asset('frontend/images/home-icon.svg') }}"></a></li>
                <li class="breadcrumb-item active" aria-current="page">News</li>
            </ol>
        </nav>
    <div class="latest-news_title-block">
            <div class="latest-news_title">
                <h1>Latest News & Blog</h1>
                <p>Sign up for emails packed with finds and inspiration</p>
            </div>
            <div class="latest-news_subscribe">
                <form class="subscribe-form" id="frmSubscriptionNews" name="frmSubscription" action="{{ route('subscribe.user') }}" method="POST">
                    @csrf 
                        <div class="input-group form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email Address" aria-label="Email Address"
                                aria-describedby="email-address-addon">
                                <div class="input-group-append">
                                    <button type="submit" class="input-group-text common-black-btn" id="email-address-addon">Submit</button>
                                </div>
                        </div>
                        @if($errors->has('email'))
                            <span class="help-block">
                                {{ $errors->first('email') }}
                            </span>
                        @endif    
                </form>
            </div>
    </div>
    <div class="text-center">
        <h4>No featured article found</h4>
    </div>
    </article>
</section>

<!-- separator -->
<div class="separator-img">
    <div class="container">
    </div>
</div>

<!-- Archive months section -->
<section class="archive-months-section">
    <article>
        <div class="common-spacing">
            <div class="container">
                <div class="archive-months_articles-list">
                    <div class="text-center">
                        <h4>No other months found</h4>
                    </div>
                </div>
            </div>
        </div>
    </article>
</section>
@endsection