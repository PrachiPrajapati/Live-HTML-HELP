@extends('frontend.layouts.app')

@section('main-content')

<!-- Latest News section -->
<section class="latest-news-section view-all">
    <article class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb common-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><img src="{{ asset('frontend/images/home-icon.svg') }}"></a></li>
                <li class="breadcrumb-item"><a href="{{ route('news') }}">News</a></li>
                <li class="breadcrumb-item active" aria-current="page">February 2020</li>
            </ol>
        </nav>
    <div class="latest-news_title-block">
            <div class="latest-news_title">
                <h1>Archives</h1>
                <p>Sign up for emails packed with finds and inspiration</p>
            </div>
            <div class="latest-news_subscribe">
                <form class="subscribe-form" id="frmSubscriptionNewsAll" action="{{ route('subscribe.user') }}" method="POST">
                    @csrf 
                    <div class="input-group form-group">
                        <input type="email" class="form-control" name="email" placeholder="Email Address" aria-label="Email Address"
                            aria-describedby="email-address-addon">
                        @if($errors->has('email'))
                            <span class="help-block">
                                {{ $errors->first('email') }}
                            </span>
                        @endif    
                        <div class="input-group-append">
                            <button type="submit" class="input-group-text" id="email-address-addon"><i class="fa fa-paper-plane"
                                    aria-hidden="true"></i> </button>
                        </div>
                    </div>
                </form>
            </div>
    </div>
    </article>
</section>

<!-- Archive months section -->
<section class="archive-months-section">
    <article>
        <div class="february-2020 common-spacing">
            <div class="container">
                <div class="archive-months_articles-list">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="news-articles featured-article">
                                <div class="news-article_image">
                                    <div class="common_image-box">
                                        <div class="dyn-img common_image" style="background-image: url('{{ generateURL($latest_blog->getBanner()) }}');">
                                        </div>
                                    </div>
                                </div>
                                <div class="featured-article_summary">
                                    <div class="row">
                                        <div class="col-lg-8 col-xl-6">
                                            <h1><a href="{{ $latest_blog->getUrl() }}">{{ $latest_blog->getTitle() }}</a></h1>
                                            <p>{{ $latest_blog->getShortDescription() }}</p>
                                            <a href="{{ $latest_blog->getUrl() }}" class="view-btn">Read More <img src="{{ asset('frontend/images/arrow-right-white.svg') }}"
                                                    alt="arrow"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($blogs != '[]' && $blogs != null)
                            @foreach($blogs as $blog)
                            <div class="col-md-6 col-lg-4">
                                <div class="news-articles">
                                    <div class="news-article_image">
                                        <div class="common_image-box">
                                            <div class="dyn-img common_image" style="background-image: url('{{ generateURL($blog->getBanner()) }}');">
                                            </div>
                                            <a href="{{ $blog->getUrl() }}"></a>
                                        </div>
                                    </div>
                                    <div class="article_summary">
                                        <h2><a href="{{ $blog->getUrl() }}">{{ $blog->getTitle() }}</a></h2>
                                        <p>{{ $blog->getShortDescription() }}</p>
                                        <a href="{{ $blog->getUrl() }}" class="view-btn">Read More <img src="{{ asset('frontend/images/arrow-right-dark.svg') }}"
                                                alt="arrow"></a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{--<div class="load-more">
            <div class="container">
                <div class="load-more-btn">
                    <a href="#" class="common-black-btn">Load More</a>
                </div>
            </div>
        </div>--}}
    </article>
</section>
@endsection