@extends('frontend.layouts.app')

@section('main-content')
    <!-- News inner section -->
    <section class="news-inner-section common-spacing">
        <article class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb common-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><img src="{{ asset('frontend/images/home-icon.svg') }}"></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('news') }}">News</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $blog->getTitle() }}</li>
                </ol>
            </nav>
            <div class="title-block has-subtitle">
                <h2>{{ $blog->getTitle() }}</h2>
                <p>{{ $blog->getShortDescription() }}</p>
            </div>
            <div class="news-inner-banner dyn-img" style="background-image: url('{{ generateURL($blog->getBanner()) }}');"></div>
            <div class="news-inner-content">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        {!! $blog->getDescription() !!}
                    </div>
                </div>
            </div>
        </article>
    </section>

    <!-- Related news section -->
    @if($related_blogs != '[]' && $related_blogs != null)
    <section class="related-news-section common-spacing">
        <article class="container">
            <div class="title-block">
                <h1>Related Articles</h1>
            </div>
            <div class="related_articles-list">
                <div class="row">
                @foreach($related_blogs as $related_blog)
                    <div class="col-md-6 col-lg-4">
                        <div class="news-articles">
                            <div class="news-article_image">
                                <div class="common_image-box">
                                    <div class="dyn-img common_image" style="background-image: url('{{ generateURL($related_blog->getBanner()) }}');">
                                    </div>
                                    <a href="{{ $related_blog->getUrl() }}"></a>
                                </div>
                            </div>
                            <div class="article_summary">
                                <h2><a href="{{ $related_blog->getUrl() }}">{{ $related_blog->getTitle() }}</a></h2>
                                <p>{{ $related_blog->getShortDescription() }}</p>
                                <a href="{{ $related_blog->getUrl() }}" class="view-btn">Read More <img src="{{ asset('frontend/images/arrow-right-dark.svg') }}"
                                        alt="arrow"></a>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </article>
    </section>
    @endif

    <!-- separator -->
    <div class="separator-img">
        <div class="container">
        </div>
    </div>

    <!-- Subscribe banner -->
    <section class="subscribe-section common-spacing">
        <article class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <h1>Be the first to know</h1>
                    <p>Sign up for emails packed with finds and inspiration</p>
                    <form class="subscribe-form" id="frmSubscriptionNews" name="frmSubscription" action="{{ route('subscribe.user') }}" method="POST">
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
                                <button type="submit" class="input-group-text" id="email-address-addon"><i
                                        class="fa fa-paper-plane" aria-hidden="true"></i> </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </article>
    </section>

    <!-- separator -->
    <div class="separator-img has-spacing">
        <div class="container">
        </div>
    </div>
@endsection

@push('extra-js')
    <script type="text/javascript"></script>
@endpush