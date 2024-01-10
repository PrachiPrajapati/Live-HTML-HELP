@extends('frontend.layouts.app')

@section('main-content')
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
           <div class="news-articles featured-article">
                <div class="news-article_image">
                    <div class="common_image-box">
                        <div class="dyn-img common_image" style="background-image: url('{{ generateURL($latest_blog->getBanner()) }}');">
                        </div>
                    </div>
                </div>
                <div class="featured-article_summary">
                    <div class="row">
                        <div class="col-lg-6 col-xl-4">
                            <h1><a href="{{ $latest_blog->getUrl() }}">{{ $latest_blog->getTitle() }}</a></h1>
                            <p>{{ $latest_blog->getShortDescription() }}</p>
                            <a href="{{ $latest_blog->getUrl() }}" class="view-btn">Read More <img src="{{ asset('frontend/images/arrow-right-white.svg') }}" alt="arrow"></a>
                        </div>
                    </div>
                </div>
           </div>
        </article>
    </section> 

    <section class="archive-months-section">
        <article>
            @foreach ($blogs as $year => $blog)
                <div class="common-spacing">
                    <div class="container">
                        <div class="title-block has-subtitle">
                            <h4>{{ $year }}</h4>
                            <a href="{{ route('news.view-all') }}" class="view-btn">View All <img src="{{ asset('frontend/images/arrow-right-dark.svg') }}" alt="arrow"></a>
                        </div>
                        <div class="archive-months_articles-list">
                            <div class="row">
                                @foreach ($blog as $article)
                                    <div class="{{ $loop->first ? 'col-lg-8' : 'col-md-6 col-lg-4' }}">
                                        <div class="news-articles {{ $loop->first ? 'featured-article' : '' }}">
                                            <div class="news-article_image">
                                                <div class="common_image-box">
                                                    <div class="dyn-img common_image" style="background-image: url('{{ generateURL($article->getBanner()) }}');">
                                                    </div>
                                                    <a href="{{ $article->getUrl() }}"></a>
                                                </div>
                                            </div>
                                            <div class="{{ $loop->first ? 'featured-' : '' }}article_summary">
                                                @if ($loop->first)
                                                    <div class="row">
                                                        <div class="col-lg-8 col-xl-6">
                                                @endif
                                                        <h1><a href="{{ $article->getUrl() }}">{{ $article->getTitle() }}</a></h1>
                                                        <p>{{ $article->getShortDescription() }}</p>
                                                        <a href="{{ $article->getUrl() }}" class="view-btn">Read More <img src="{{ asset('frontend/images/arrow-right-white.svg') }}" alt="arrow"></a>
                                                    @if ($loop->first)
                                                        </div>
                                                    </div>
                                                    @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                @if ($loop->last)
                    <div class="load-more">
                        <div class="container">
                            <div class="load-more-btn">
                                <a href="" class="common-black-btn">Load More</a>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Separator --}}
                        <div class="separator-img">
                            <div class="container">
                            </div>
                        </div>  
                @endif
            @endforeach
        </article>
    </section>
@endsection
