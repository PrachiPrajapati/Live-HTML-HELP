<header id="header">
    <div class="header-content">
        <a class="navbar-brand" href="{{ route('home') }}"><img src="{{asset('frontend/images/logo.svg')}}" alt="logo"></a>
        <div class="visible-tab mobile-toggle">
            <a class="navbar-toggler" href="#menu">
                <span></span>
                <span></span>
                <span></span>
            </a>
        </div>
        <div class="header-content_inner">
            <div class="selection-links">
                <ul>
                    <li>
                        <select class="country" id="dropdown-country-redirect" onChange="CountryRedirect();">
                            <option selected disabled hidden>COUNTRY</option>
                            @if($countries != null)
                                @foreach($countries as $country)
                                <option value="{{ $country->url }}">{{ $country->getName() }}</option>
                                @endforeach
                            @endif
                        </select>
                    </li>
                    <li class="currency">
                        <select>
                            <option>EN</option>
                            <option>AR</option>
                        </select>
                    </li>
                </ul>
            </div>
            <ul>
                @if(Auth::check() == "true")
                    <li class="nav-item">
                        <a href="https://www.google.com/" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('frontend/images/icon-user.svg') }}" alt="user"></a>
                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('account.settings') }}"><i class="fa fa-cog"></i>Account Settings</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('order.history') }}"><i class="fa fa-history"></i>Order History</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="" data-target="#logout" data-toggle="modal"><i class="fa fa-sign-out"></i>Logout</a>
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('favourites') }}"><img src="{{ asset('frontend/images/icon-heart.svg') }}" alt="wishlist"></a>
                    </li>
                @else
                    <li>
                        <a href="#" data-toggle="modal" data-target="#login"><img src="{{asset('frontend/images/icon-user.svg')}}" alt="user"></a>
                    </li>
                @endif
                <li>
                    <a href="javascript:;">
                        <img src="{{ asset('frontend/images/icon-cart.svg') }}" alt="cart">
                        <span class="badge">{{ $productCount }}</span>
                    </a>
                    @if($productCount > 0)
                    <div class="cart-list link-dropdown">
                        <ul class="cart-list-items">
                        @if(Auth::check() == "true")
                           
                            @foreach($header_products as $product)
                                @if($product->product != null)
                                <li>
                                    <div class="cart-single-item">
                                        @if($product->color_id != null && $product->color != null)
                                            <div class="cart-single-item_image"
                                                style="background-image: url('{{ generateURL($product->color->image) }}');">
                                                <a href="{{ route('product.show',$product->product->slug)}}"></a>
                                            </div>
                                        @else
                                            <div class="cart-single-item_image"
                                                style="background-image: url('{{ generateURL($product->product->image) }}');">
                                                <a href="{{ route('product.show',$product->product->slug)}}"></a>
                                            </div>
                                        @endif
                                        <div class="cart-single-item_detail">
                                            <h4>
                                                <a href="{{ route('product.show',$product->product->slug) }}">{{ $product->product->getEnglishTitle() }} </a>
                                            </h4>
                                            <ul>
                                                <li>
                                                    QTY: {{ $product->quantity }}
                                                </li>
                                                <li>
                                                    AED {{ $product->product->order_amount }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                @endif
                            @endforeach

                        @else

                            @if($header_products != null)
                                @foreach($header_products as $product)
                                <li>
                                    <div class="cart-single-item">                                       
                                        <div class="cart-single-item_image"
                                            style="background-image: url('{{ generateURL($product->image) }}');">
                                            <a href="{{ route('product.show',$product->slug)}}"></a>
                                        </div>
                                        <div class="cart-single-item_detail">
                                            <h4>
                                                <a href="{{ route('product.show',$product->slug) }}">{{ $product->getEnglishTitle() }} </a>
                                            </h4>
                                            <ul>
                                                <li>
                                                    QTY: {{ $product->quantity }}
                                                </li>
                                                <li>
                                                    AED {{ $product->order_amount }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            @endif

                        @endif
                        </ul>
                        <div class="divider"></div>
                        <div class="cart-footer">
                            <ul>
                                <li>SUBTOTAL: AED {{ $header_subTotal }}</li>
                                <li>
                                    <a href="{{ route('cart') }}" class="view-btn">View Cart <img src="{{ asset('frontend/images/arrow-right.svg') }}" alt="arrow">
                                    </a>
                                </li>
                            </ul>
                            @if(Auth::check())
                                <a href="{{ route('logged-in-checkout') }}" class="common-black-btn full">Checkout</a>
                            @else
                                <a href="{{ route('checkout') }}" class="common-black-btn full">Checkout</a>
                            @endif
                        </div>
                    </div>
                   @endif
                </li>
            </ul>
            <form class="header-form" method="GET" action="{{ route('search') }}">
                <div class="input-group">
                    <input type="text" class="form-control" id="global_search" name="search" value="{{ old('search') }}" placeholder="Search" aria-label="Search"
                        aria-describedby="search-button">
                    <div class="input-group-append">
                        <button type="submit" class="input-group-text" id="search-button">
                            <img src="{{ asset('frontend/images/icon-search.svg') }}" alt="search">
                        </button>
                    </div>
                    <div class="search-popup" id="global_search_div">
                       <div class="search-content">
                          <div class="popup-category">
                             <div class="category-pop-title" id="global_search_product_all" style="display: none;">
                                <h5>Products</h5>
                               <!--  <a type="submit" class="common-black-btn"> -->
                                    <button type="submit" class="common-black-btn" id="search-button">View All</button>
                                <!-- </a> -->
                             </div>
                             <ul class="search-list product-list" id="global_search_product">
                             </ul>
                          </div>
                          <div class="popup-category">
                             <div class="category-pop-title" id="global_search_service_all" style="display: none;">
                                <h5>Services</h5>
                                <a href="{{ route('services-overview') }}" class="common-black-btn">View All</a>
                             </div>
                             <ul class="search-list service-list" id="global_search_service">
                             </ul>
                          </div>
                          <div class="popup-category">
                             <div class="category-pop-title" id="global_search_blog_all" style="display: none;">
                                <h5>News</h5>
                                <a href="{{ route('news') }}" class="common-black-btn">View All</a>
                             </div>
                             <ul class="search-list news-list service-list" id="global_search_blog">
                             </ul>
                          </div>
                       </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{--  DESKTOP VIEW --}}
    <nav class="navbar navbar-expand-lg">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav">
                @if($categories != null && $categories != '[]')
                
                @foreach($categories as $category)
                
                <li class="nav-item">
                            <a  href="https://www.google.com">{{ $category->getTitle() }}</a>
                    <div class="dropdown-menu" aria-labelledby="freshFlowers">
                        <div class="dropdown-menu-links">
                            <h1>{{ $category->getTitle() }}</h1>
                            <div class="dropdown-categories">
                                @if( $category_titles != null )

                                    @foreach($category_titles as $sub_category)

                                        @if($sub_category->category_id == $category->id)

                                            @if($boxes != null)

                                                @foreach($boxes as $box)

                                                    @if($sub_category->box_id == $box->id)
                                                    <div class="dropdown-cat-1 cat-box">
                                                        <a href="{{ route('category',[$category->slug,$box->slug]) }}" class="cat-link">{{ $box->getTitle() }} </a>
                                                        <ul>
                                                            @if($shapes != null)
                                                                
                                                                @foreach($shapes as $shape)

                                                                    @if($sub_categories != null)

                                                                        @foreach($sub_categories as $sub_cat)
                                                                           
                                                                            @if($sub_cat->category_id == $sub_category->category_id && $sub_cat->box_id == $box->id && $sub_cat->shape_id == $shape->id)
                                                                            <li>
                                                                                <a href="{{ route('category',[$category->slug,$box->slug,$shape->slug]) }}">{{ $shape->getTitle() }}</a>
                                                                            </li>
                                                                            @endif
                                                                        
                                                                        @endforeach

                                                                    @endif

                                                                @endforeach
                                                           
                                                            @endif
                                                        </ul>
                                                    </div>
                                                    @endif

                                                @endforeach

                                            @endif

                                        @endif

                                    @endforeach

                                @endif
                            </div>
                            <a href="{{ route('category',$category->slug) }}" class="view-btn">View All <img src="{{asset('frontend/images/arrow-right.svg')}}"
                                    alt="arrow"></a>
                        </div>
                        <div class="dropdown-menu-image"
                            style="background-image: url('{{ generateURL($category->image) }}');"></div>
                    </div>
                </li>
                @endforeach

                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('services-overview') }}">Services</a>
                </li>
            </ul>
        </div>
    </nav>

    {{-- MOBILE VIEW --}}
    <nav id="menu">
        <ul>
            <li>
                <div class="selection-links mm-custom-div mm-panel">
                    <select class="country" id="dropdown-country-mobile" onChange="CountryRedirectForMobile();">
                        <option selected disabled hidden>COUNTRY</option>
                        @if($countries != null)
                            @foreach($countries as $country)
                            <option value="{{ $country->url }}">{{ $country->getName() }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </li>
            @if($categories != null && $categories != '[]')
                
                @foreach($categories as $category)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="freshFlowers1" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">{{ $category->getTitle() }}</a>
                        <div class="dropdown-menu" aria-labelledby="freshFlowers1">
                            <div class="dropdown-menu-image" style="background-image: url('{{ generateURL($category->image) }}');">
                                <a href="{{ route('category',$category->slug) }}"></a>
                            </div>
                            <div class="dropdown-menu-links">
                                <h1>{{ $category->getTitle() }}</h1>
                                <div class="dropdown-categories">
                                @if( $category_titles != null )

                                    @foreach($category_titles as $sub_category)

                                        @if($sub_category->category_id == $category->id)

                                            @if($boxes != null)

                                                @foreach($boxes as $box)

                                                    @if($sub_category->box_id == $box->id)
                                                    <div class="dropdown-cat-1 cat-box">
                                                        <a href="{{ route('category',[$category->slug,$box->slug]) }}" class="cat-link">{{ $box->getTitle() }} </a>
                                                        <ul>
                                                            @if($shapes != null)
                                                                
                                                                @foreach($shapes as $shape)

                                                                    @if($sub_categories != null)

                                                                        @foreach($sub_categories as $sub_cat)
                                                                           
                                                                            @if($sub_cat->category_id == $sub_category->category_id && $sub_cat->box_id == $box->id && $sub_cat->shape_id == $shape->id)
                                                                            <li>
                                                                                <a href="{{ route('category',[$category->slug,$box->slug,$shape->slug]) }}">{{ $shape->getTitle() }}</a>
                                                                            </li>
                                                                            @endif
                                                                        
                                                                        @endforeach

                                                                    @endif

                                                                @endforeach
                                                           
                                                            @endif
                                                        </ul>
                                                    </div>
                                                    @endif

                                                @endforeach

                                            @endif

                                        @endif
                                        
                                    @endforeach

                                @endif
                                </div>
                                <a href="{{ route('category',$category->slug) }}" class="view-btn">View All <img src="{{asset('frontend/images/arrow-right.svg')}}" alt="arrow"></a>
                            </div>
                        </div>
                    </li>
                @endforeach

            @endif

            <li class="nav-item">
                <a class="nav-link" href="{{ route('services-overview') }}">Services</a>
            </li>
            
            @if(Auth::check() == "true")
            
            <li class="nav-item order-history">
                <a class="nav-link" href="{{ route('order.history') }}">Order History</a>
            </li>
            
            @endif
        </ul>
    </nav>
</header>