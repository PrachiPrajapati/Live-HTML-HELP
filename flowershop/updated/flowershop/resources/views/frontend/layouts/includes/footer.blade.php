<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <div class="footer-links">
                    <div class="footer-links_title">
                        Small Print
                    </div>
                    <ul>
                        <li>
                            <a href="{{ route('delivery') }}">Delivery</a>
                        </li>
                        <li>
                            <a href="{{ route('faqs') }}">FAQ's</a>
                        </li>
                        <li>
                            <a href="{{ route('privacy-policy') }}">Privacy Policy </a>
                        </li>
                        <li>
                            <a href="{{ route('term-conditions') }}">Terms & Conditions</a>
                        </li>
                        <li>
                            <a href="{{ route('careers') }}">Careers</a>
                        </li>
                        <li>
                            <a href="{{ route('franchisesrequests.index') }}">Franchise Requests</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <div class="footer-links">
                    <div class="footer-links_title">
                        Company
                    </div>
                    <ul>
                        <li>
                            <a href="{{ route('about-us') }}">About Us</a>
                        </li>
                        <li>
                            <a href="{{ route('franchises.index') }}">Locations</a>
                        </li>
                        <li>
                            <a href="{{ route('news') }}">News</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-5">
                <div class="footer-links">
                    <div class="footer-links_title">
                        Contact Us
                    </div>
                    <ul class="site-info_contact-links">
                    @if($setting != null)
                        <li>
                            <span>Telephone:</span> <a href="tel:+ {{ $setting->getTelephoneValue() }}">+ {{ $setting->en_telephone_value }}</a>
                        </li>
                        <li>
                            <span>Mobile:</span> <a href="tel:+ {{ $setting->getMobileValue() }}">+ {{ $setting->en_mobile_value }}</a>
                        </li>
                        <li>
                            <span>For orders and follow-ups:</span>
                            <a href="mailto:{{ $setting->getFollowvalue() }}">{{ $setting->en_follow_value }}</a>
                        </li>
                        <li>
                            <span>For general inquiries:</span>
                                <a href="mailto:{{ $setting->getInquiriesValue() }}">{{ $setting->en_inquiries_value }}</a>
                           </li>
                    @else
                        <li>
                            <span>Telephone:</span> <a href="tel:+97142765886">+ 971 4 276 5886</a>
                        </li>
                        <li>
                            <span>Mobile:</span> <a href="tel:+971552236866">+ 971 55 223 6866</a>
                        </li>
                        <li>
                            <span>For orders and follow-ups:</span>
                            <a href="mailto:orders@maisondesfleurs.com">orders@maisondesfleurs.com</a>
                        </li>
                        <li>
                            <span>For general inquiries:</span>
                            <a href="mailto:info@maisondesfleurs.com">info@maisondesfleurs.com</a>
                        </li>
                    @endif
                    </ul>
            </div>
        </div>
        <div class="col-md-3">
                <div class="footer-links_title">
                    Connect With Us
                </div>
                <ul class="footer-social">
                @if($setting != null)
                    <li>
                        <a href="{{ $setting->getFbValue() }}" target="_blank"><img src="{{ asset('frontend/images/facebook.svg') }}"></a>
                    </li>
                    <li>
                        <a href="{{ $setting->getLinkedinValue() }}" target="_blank"><img src="{{ asset('frontend/images/linkedin.svg') }}"></a>
                    </li>
                    <li>
                        <a href="{{ $setting->getInstaValue() }}" target="_blank"><img src="{{ asset('frontend/images/instagram.svg') }}"></a>
                    </li>
                    <li>
                        <a href="{{ $setting->getPintrestValue() }}" target="_blank"><img src="{{ asset('frontend/images/pintrest.svg') }}"></a>
                    </li>
                @else
                    <li>
                        <a href="#" target="_blank"><img src="{{ asset('frontend/images/facebook.svg') }}"></a>
                    </li>
                    <li>
                        <a href="#" target="_blank"><img src="{{ asset('frontend/images/linkedin.svg') }}"></a>
                    </li>
                    <li>
                        <a href="#" target="_blank"><img src="{{ asset('frontend/images/instagram.svg') }}"></a>
                    </li>
                    <li>
                        <a href="#" target="_blank"><img src="{{ asset('frontend/images/pintrest.svg') }}"></a>
                    </li>
                @endif
                </ul>
                <div class="subscribe">
                    <p>Subscribe</p>
                    <p class="subtitle">We will only send you awesome emails.</p>
                    <form id="frmSubscription" name="frmSubscription" action="{{ route('subscribe.user') }}" method="POST">
                        @csrf
                        <div class="input-group form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email Address"
                                aria-label="Email Address" aria-describedby="email-address-addon">
                            @if($errors->has('email'))
                                <span class="help-block">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text common-black-btn"
                                    id="email-address-addon">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
          </div>
    </div>
    <div class="site-info">
        <div class="container">
            <div class="site-info_block d-md-flex align-items-center justify-content-between">
                <p>All rights reserved @ 2020 MaisonDesFleurs</p>
                <div class="cards-accepted">
                    <p>We accept</p>
                    <img src="{{ asset('frontend/images/card.png') }}" alt="images">
                </div>
            </div>
        </div>
    </div>
</footer>
