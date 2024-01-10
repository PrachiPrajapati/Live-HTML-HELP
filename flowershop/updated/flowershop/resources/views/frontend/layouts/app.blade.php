<!DOCTYPE html>
@if(app()->getLocale() == 'en')
<html lang="ar">
@else
<html lang="en">
@endif
<head>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <title>Flower Shop</title>
    {{-- Favicon Included --}}
        @include('frontend.layouts.includes.favicon')

    {{-- Meta Tags --}}
        @include('frontend.layouts.includes.meta')

    {{-- CSS Details --}}

        @stack('top-css')

        @include('frontend.layouts.includes.css')

</head>

@if(app()->getLocale() == 'en')
<body class=" rtl " dir="rtl" >
@else
<body class="" dir="ltr">
@endif   
    <div id="content">
    <div id="main_loader" class="lds-ring"><div></div><div></div><div></div><div></div></div>

    <!--******************* Header Section Start *********************-->
    @include('frontend.layouts.includes.header')
    <!--******************* Header Section End *********************-->
    @if(Session::has('message'))
        <p id="subscribeMessage" class="alert alert-info">{{ Session::get('message') }}</p>
    @endif  
    <!--******************* Banner Section Start ******************-->
    @stack('banner-section')
    <!--******************* Banner Section End ******************-->
    <!--******************* Middle Section Start ******************-->
    <main>
        @yield('main-content')
    </main>
    <!--******************* Middle Section End ******************-->
    <!--******************* Footer Section Start ******************-->
        @include('frontend.layouts.includes.footer')
    <!--******************* Footer Section End ******************-->

    <!-- Login Modal -->
    <div class="modal animate__animated animate__fadeIn common-modal" id="login" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="{{asset('frontend/images/flower.png')}}" alt="flower">
                    <h2 class="modal-title" id="login">Log in to Continue</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img src="{{asset('frontend/images/close.png')}}" alt="close"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formLogin" action="javascript:;" class="common-form">
                        <p id="error-login" class="help-block" style="display: block;"></p>
                        <div class="form-group">
                            <!-- <label>Email Address</label> -->
                            <input type="email" name="email" id="email_login" class="form-control" placeholder="EMAIL ADDRESS">
                            @if($errors->has('email'))
                                <span class="help-block" >
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                            <p id="server-login-email"></p>
                        </div>

                        <div class="form-group">
                            <!-- <label>Password</label> -->
                            <input type="password" name="password" id="password_login" class="form-control" placeholder="PASSWORD">
                            @if($errors->has('password'))
                                <span class="help-block" >
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                            <p id="server-login-password"></p>
                        </div>

                        <div class="text-center">
                            <div class="forgot-link"><a href="#" data-target="#forgot" data-toggle="modal"
                                    data-dismiss="modal" class="forgot">Forgot Password?</a></div>
                            <button type="submit" id="btn-login" class="common-black-btn">Login</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="link-text">
                        New to Maison Des Fleur? <a href="#" data-toggle="modal" data-target="#signup"
                            data-dismiss="modal"><span>Sign Up!</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Account Modal -->
    <div class="modal animate__animated animate__fadeIn common-modal" id="signup" tabindex="-1" role="dialog" aria-labelledby="signup" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="{{asset('frontend/images/flower.png')}}" alt="flower">
                    <h2 class="modal-title" id="signup">Create Account</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img src="{{asset('frontend/images/close.png')}}" alt="close"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="common-form" id="signupForm" action="javascript:;" name="signupForm">
                        <div class="form-group">
                            <input type="email" name="email" id="email_signup" class="form-control checkemail"placeholder="EMAIL ADDRESS">
                            @if($errors->has('email'))
                                <span class="help-block" >
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                            <p id="server-signup-email"></p>
                        </div>

                        <div class="form-group">
                            <input type="password" name="password" id="password_signup" class="form-control" placeholder="PASSWORD">
                            <div>
                                <small id="passwordNote">Note: The password must contain uppercase, lowercase, numeric & special character.</small>
                            </div>
                            @if($errors->has('password'))
                                <span class="help-block" >
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                            <p id="server-signup-password"></p>
                        </div>

                        <div class="form-group">
                            <input type="password" name="password_confirmation" id="confirm_password_signup" class="form-control" placeholder="CONFIRM PASSWORD">
                            <span id="signup-confirm_password" class="help-block"></span>
                            <p id="server-signup-cpassword"></p>
                        </div>

                        <div class="text-center">
                            <button type="submit" id="btn-signup" class="common-black-btn">Create Account</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="link-text">
                        Have an account? <a href="#" data-toggle="modal" data-target="#login"
                            data-dismiss="modal"><span>Login</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Checkout Login Modal -->
    <div class="modal fade common-modal" id="checkout-login" tabindex="-1" role="dialog" aria-labelledby="checkoutLogin"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="{{asset('frontend/images/flower.png')}}" alt="flower">
                    <h2 class="modal-title" id="checkoutLogin">Log in to Continue</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img src="{{asset('frontend/images/close.png')}}" alt="close"></span>
                    </button>
                </div>
                <div class="modal-body">
                   <form id="formCheckoutLogin" action="javascript:;" class="common-form">
                        <p id="error-chechout-login" class="help-block" style="display: block;"></p>

                        <div class="form-group">
                            <!-- <label>Email Address</label> -->
                            <input type="email" name="email" id="email_checkout_login" class="form-control" placeholder="EMAIL ADDRESS">
                            @if($errors->has('email'))
                                <span class="help-block" >
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                            <p id="server-checkoutlogin-email"></p>
                        </div>

                        <div class="form-group">
                            <!-- <label>Password</label> -->
                            <input type="password" name="password" id="password_checkout_login" class="form-control" placeholder="PASSWORD">
                            @if($errors->has('password'))
                                <span class="help-block" >
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                            <p id="server-checkoutlogin-password"></p>
                        </div>

                        <div class="button-group">
                            <button type="submit" id="btn-checkout-login" class="common-black-btn">Login</button>
                            <a href="{{ route('checkout') }}"><button type="button" class="btn-outline">Guest Checkout</button></a>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#" data-target="#forgot" data-toggle="modal" data-dismiss="modal">Forgot Password?</a>
                    <div class="link-text">
                        Don't have an account? <a href="#" data-toggle="modal" data-target="#checkout-signup"
                            data-dismiss="modal"><span>Signin!</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Checkout Signup Modal -->
    <div class="modal fade common-modal" id="checkout-signup" tabindex="-1" role="dialog" aria-labelledby="checkout-signup" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="{{asset('frontend/images/flower.png')}}" alt="flower">
                    <h2 class="modal-title" id="signup">Create Account</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img src="{{asset('frontend/images/close.png')}}" alt="close"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="common-form" id="checkoutSignupForm" action="javascript:;" name="checkoutSignupForm">
                        <input type="hidden" id="token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <input type="email" name="email" id="email_checkout_signup" class="form-control checkemail" placeholder="EMAIL ADDRESS">
                            @if($errors->has('email'))
                                <span class="help-block" >
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                            <p id="server-checkoutsignup-email"></p>
                        </div>

                        <div class="form-group">
                            <input type="password" name="password" id="password_checkout_signup" class="form-control" placeholder="PASSWORD">
                            <div>
                                <small id="passwordNoteCheckout">Note: The password must contain uppercase, lowercase, numeric & special character.</small>
                            </div>
                            @if($errors->has('password'))
                                <span class="help-block" >
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                            <p id="server-checkoutsignup-password"></p>
                        </div>

                        <div class="form-group">
                            <input type="password" name="password_confirmation" id="confirm_password_checkout_signup" class="form-control" placeholder="CONFIRM PASSWORD">
                            <span id="signup-confirm_password" class="help-block"></span>
                            <p id="server-checkoutsignup-cpassword"></p>
                        </div>

                        <div class="text-center">
                            <button type="submit" id="btn-checkout-signup" class="common-black-btn">Create Account</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="link-text">
                        Have an account? <a href="#" data-toggle="modal" data-target="#checkout-login"
                            data-dismiss="modal"><span>Login</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Forgot Password Modal -->
    <div class="modal fade common-modal" id="forgot" tabindex="-1" role="dialog" aria-labelledby="forgot" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="{{asset('frontend/images/flower.png')}}" alt="flower">
                    <h2 class="modal-title" id="forgotpassword">Forgot Password</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img src="{{asset('frontend/images/close.png')}}" alt="close"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="common-form" action="javascript:;" id="resetForm">
                        <div class="form-group">
                            <input type="email" name="email" id="email_reset" class="form-control" placeholder="EMAIL ADDRESS">
                            <p id="reset-email" class="help-block"></p>
                            <p id="email-error" class="help-block"></p>
                            <p id="forgot-sendemail" class="help-block"></p>
                        </div>
                        <div class="text-center">
                            <button type="submit" id="btn-reset" class="common-black-btn">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Modal -->
    <div class="modal fade common-modal" id="logout" tabindex="-1" role="dialog" aria-labelledby="logout" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content logout">
                <div class="modal-header">
                    <img src="{{asset('frontend/images/flower.png')}}" alt="flower">
                    <h2 class="modal-title" id="logout">Do you want to logout?</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img src="{{asset('frontend/images/close.png')}}" alt="close"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="common-form">
                        <div class="button-group">
                            <a href="{{ route('logout') }}">
                                <button type="button" class="common-black-btn" data-dismiss="model">Yes</button>
                            </a>
                            <button type="button" class="btn-outline" data-dismiss="modal">No</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Acc Info Modal -->
        <div class="modal fade right" id="edit-info" tabindex="-1" role="dialog" aria-labelledby="editAccountInfo"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><img src="{{ asset('frontend/images/close.png') }}" alt="close"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="title-block">
                            <h2>Edit Account Information</h2>
                        </div>
                        @if(Auth::check())
                        <form class="common-form" id="editProfileForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group input-focused">
                                <label>First Name</label>
                                <input type="text" name="first_name" id="edit-first_name" class="form-control" value="{{ old('first_name',Auth::user()->first_name) }}">
                                @if($errors->has('first_name'))
                                    <span class="help-block" >
                                        {{ $errors->first('first_name') }}
                                    </span>
                                @endif
                                <p id="server-profile-first-name"></p>
                            </div>
                            <div class="form-group input-focused">
                                <label>Last Name</label>
                                <input type="text" name="last_name" id="edit-last_name" class="form-control" value="{{ old('last_name',Auth::user()->last_name) }}">
                                @if($errors->has('last_name'))
                                    <span class="help-block" >
                                        {{ $errors->first('last_name') }}
                                    </span>
                                @endif
                                <p id="server-profile-last-name"></p>
                            </div>
                            <div class="form-group input-focused">
                                <label>Contact</label>
                                <input type="text" name="contact" id="edit-contact" class="form-control" value="{{ old('contact',Auth::user()->contact) }}">
                                @if($errors->has('contact'))
                                    <span class="help-block" >
                                        {{ $errors->first('contact') }}
                                    </span>
                                @endif
                                <p id="server-profile-contact"></p>
                            </div>
                            <div class="form-group input-focused">
                                <label>Profile Image</label>
                                <input type="file" name="profile" id="edit-profile" class="form-control">
                                @if($errors->has('profile'))
                                    <span class="help-block" >
                                        {{ $errors->first('profile') }}
                                    </span>
                                @endif
                                <p id="server-profile-profile"></p>
                            </div>
                            <button type="submit" id="btn-editprofile" class="btn-outline">Save Changes</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Password Modal -->
        <div class="modal fade right" id="edit-password" tabindex="-1" role="dialog" aria-labelledby="editAccountInfo"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><img src="{{ asset('frontend/images/close.png') }}" alt="close"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="title-block">
                            <h2>Change Password</h2>
                        </div>
                        @if(Auth::check())
                        <form class="common-form" action="javascript:;" id="changePasswordForm">
                            <div class="form-group input-focused">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" readonly="true">
                                <span id="change-email" class="help-block"></span>
                            </div>
                            <div class="form-group input-focused">
                                <label>Create New Password</label>
                                <input type="password" name="password" id="password_change" class="form-control" value="{{ old('password') }}">
                                <div>
                                   <small id="passwordNoteForChangePassword">Note: The password must contain uppercase, lowercase, numeric & special character.</small>
                                </div>
                                @if($errors->has('password'))
                                    <span class="help-block" >
                                        {{ $errors->first('password') }}
                                    </span>
                                @endif
                                <p id="server-changepassword-password"></p>
                            </div>
                            <div class="form-group input-focused">
                                <label>Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="confirm_password_change" class="form-control" value="{{ old('password_confirmation') }}">
                                @if($errors->has('password_confirmation'))
                                    <span class="help-block" >
                                        {{ $errors->first('password_confirmation') }}
                                    </span>
                                @endif
                                <p id="server-changepassword-cpassword"></p>
                              </div>
                            <button type="submit" id="btn-changepassword" class="btn-outline">Save Changes</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit address Modal -->
        <div class="modal fade right" id="edit-address" tabindex="-1" role="dialog" aria-labelledby="editAddress"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><img src="{{ asset('frontend/images/close.png') }}" alt="close"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="common-form" id="addAddressForm">
                        @csrf
                            <div class="form-group input-focused">
                                <label>First Name</label>
                                <input type="text" name="first_name" id="add_firstname" class="form-control" value="{{ old('first_name') }}">
                                @if($errors->has('first_name'))
                                    <span class="help-block" >
                                        {{ $errors->first('first_name') }}
                                    </span>
                                @endif
                                <p id="server-address-first_name"></p>
                            </div>
                            <div class="form-group input-focused">
                                <label>Last Name</label>
                                <input type="text" name="last_name" id="add_lastname" class="form-control" value="{{ old('last_name') }}">
                                @if($errors->has('last_name'))
                                    <span class="help-block" >
                                        {{ $errors->first('last_name') }}
                                    </span>
                                @endif 
                                <p id="server-address-last_name"></p>
                            </div>
                            <div class="form-group input-focused">
                                <label>Emirate</label>
                                <select class="form-select" name="emirate" id="add_emirate" data-error-container="#emirate-error">
                                    <option value="">Select Emirate</option>
                                    @if($countries != null)
                                        @foreach($countries as $county) 
                                        <option value="{{ $county->id }}">{{ $county->getName() }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span id="emirate-error"></span>
                                @if($errors->has('emirate'))
                                    <span class="help-block" >
                                        {{ $errors->first('emirate') }}
                                    </span>
                                @endif
                                <p id="server-address-emirate"></p>
                            </div>
                            <div class="form-group" id="get_city">
                                <select class="form-select" name="city" id="add_city" data-error-container="#city-error"> 
                                    <option value="">Select City</option>
                                </select>
                                <span id="city-error"></span>
                                @if($errors->has('city'))
                                    <span class="error-help">{{ $errors->first('city') }}</span>
                                @endif
                                <p id="server-address-city"></p>
                            </div>
                            <div class="form-group input-focused">
                                <label>Postal Code / Zip</label>
                                <input type="text" name="pincode" id="add_pincode" class="form-control" value="{{ old('pincode') }}">
                                @if($errors->has('pincode'))
                                    <span class="help-block" >
                                        {{ $errors->first('pincode') }}
                                    </span>
                                @endif
                                <p id="server-address-pincode"></p>
                            </div>
                            <div class="form-group input-focused">
                                <label>Address</label>
                                <input type="text" name="address" id="add_address" class="form-control" value="{{ old('address') }}">
                                @if($errors->has('address'))
                                    <span class="help-block" >
                                        {{ $errors->first('address') }}
                                    </span>
                                @endif
                                <p id="server-address-address"></p>
                            </div>
                            <div class="form-group input-focused">
                                <label>Phone Number</label>
                                <input type="text" name="contact" id="add_contact" class="form-control" value="{{ old('contact') }}">
                                @if($errors->has('contact'))
                                    <span class="help-block" >
                                        {{ $errors->first('contact') }}
                                    </span>
                                @endif
                                <p id="server-address-contact"></p>
                            </div>
                            <button type="button" id="btn-addAddress" class="btn-outline">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add message Modal -->
        <div class="modal fade common-modal add-message" id="add-message" tabindex="-1" role="dialog" aria-labelledby="addMessage"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <img src="{{ asset('frontend/images/edit-icon.png') }}" alt="edit-icon">
                        <h2 class="modal-title" id="addMessage">Add Gift Message</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><img src="{{ asset('frontend/images/close.png') }}" alt="close"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="common-form" id="formAddGiftMessage">
                            <input type="hidden" id="gift_message_custom_id" name="cart_id">
                            <input type="hidden" id="gift_message_cart_id" name="cart_id">
                            <input type="hidden" id="gift_message_product_id" name="product_id">
                            <input type="hidden" id="gift_message_quantity" name="quantity">
                            <input type="hidden" id="gift_message_color_id" name="color_id">
                            <div class="form-group input-focused">
                                <label>write message</label>
                                <textarea class="form-control" name="message" id="gift_message" placeholder="Description" rows="6"></textarea>
                                @if($errors->has('message'))
                                    <span class="help-block" >
                                        {{ $errors->first('message') }}
                                    </span>
                                @endif
                                <p id="server-gift-message"></p>
                            </div>
                            <button type="button" id="btn-addGiftMessage" class="common-black-btn">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit card Modal -->
        <div class="modal fade right" id="edit-card" tabindex="-1" role="dialog" aria-labelledby="editCard"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><img src="{{ asset('frontend/images/close.png') }}" alt="close"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="common-form">
                            <div class="form-group input-focused">
                                <label>Cardholder Name</label>
                                <input type="text" class="form-control" value="Beatrice Waddle">
                                <span class="error-help">Your error here</span>
                            </div>
                            <div class="form-group input-focused">
                                <label>Card Number</label>
                                <input type="text" class="form-control card-field" placeholder="0000 0000 0000 0000">
                                <span class="error-help">Your error here</span>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group input-focused">
                                        <label>Expiration Date </label>
                                        <input type="text" class="form-control date-field" placeholder="MM / YY">
                                        <span class="error-help">Your error here</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group input-focused">
                                        <label>CVV</label>
                                        <input type="text" class="form-control" value="123">
                                        <span class="error-help">Your error here</span>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn-outline" data-dismiss="modal">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!--*********************** All End ************************-->
@include('frontend.layouts.includes.js')
@stack('extra-js')
    <script src="{{ asset('admin/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('admin/js/custom_validations.js') }}"></script>

    <script type="text/javascript">
        
        $("#subscribeMessage").delay(4000).slideUp(300);

        $(document).ready(function() { 

            //Login
            $("#formLogin").validate({
                rules: {
                    email:{
                        required:true,
                        not_empty:true,
                        maxlength:150,
                        email: true,
                        valid_email: true,
                    },
                    password:{
                        required:true,
                        not_empty:true,
                        minlength:8,
                        maxlength:16,
                    },
                },
                messages: {
                    email:{
                        required:"@lang('validation.required',['attribute'=>'email'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'email'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'email','max'=>150])",
                        email:"@lang('validation.email',['attribute'=>'email'])",
                        valid_email:"@lang('validation.email',['attribute'=>'email'])",
                    },
                    password:{
                        required:"@lang('validation.required',['attribute'=>'password'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'password'])",
                        minlength:"@lang('validation.min.string',['attribute'=>'password','min'=>8])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'password','max'=>16])",
                    },
                },
                errorClass: 'help-block',
                errorElement: 'span',

                highlight: function(element) {
                   $(element).closest('.form-group').addClass('has-error').css('color','red');
                },
                unhighlight: function(element) {
                   $(element).closest('.form-group').removeClass('has-error');
                },
                errorPlacement: function(error, element) {
                    if (element.attr("data-error-container")) {
                        error.appendTo(element.attr("data-error-container"));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });


            $('#btn-login').on('click',function(){
               if( $('#formLogin').valid() ) {
                    $('.error-help').remove();
                    $('#server-login-email').empty();
                    $("#server-login-password").empty();
                        $.ajax({
                            type: 'POST',
                            dataType: 'JSON',
                            url: "{{ route('user.login') }}",
                            data: {
                                 _token: '{{ csrf_token() }}',
                                email : function(){
                                    return $("#email_login").val();
                                },
                                password: function(){
                                    return $("#password_login").val();
                                }
                            },
                            beforeSend: function() {
                                showLoader();
                            },
                            success: function(Response){
                                if(Response.serverError){
                                    if(Response.serverError.email != undefined){
                                        $('#server-login-email').append('<span class="error-help">'+Response.serverError.email+'</span>');
                                    }
                                    if(Response.serverError.password != undefined){
                                        $('#server-login-password').append('<span class="error-help">'+Response.serverError.password+'</span>');
                                    }
                                }
                                if(Response.notregisterd){
                                    $('#error-login').append('<span class="error-help">'+Response.notregisterd+'</span>');
                                }
                                if(Response.notactive){
                                    $('#error-login').append('<span class="error-help">'+Response.notactive+'</span>');
                                }
                                if(Response.invalid){
                                    $('#error-login').append('<span class="error-help">'+Response.invalid+'</span>');
                                }
                                if(Response.success){
                                    $('#login').modal('hide');
                                    $('#header').replaceWith(Response['header']);
                                    $('body').addClass('logged-in');

                                    //Country(select)
                                    customSelect = $('select');
                                    // Options for custom Select
                                    jcf.setOptions('Select', {
                                        wrapNative: false,
                                        wrapNativeOnMobile: false,
                                        fakeDropInBody: false
                                    });
                                    jcf.replace(customSelect);
                                    jcf.refresh();

                                    //Dropdown(Cart Icon)
                                    $('.header-content_inner > ul > li:last-child').click(function () {
                                        $(this).toggleClass('show')
                                    });
                                }
                            },
                            complete: function() {
                                removeLoader();
                            },
                        });
                    //$("input[type=submit], input[type=button], button[type=submit]").prop("disabled", "disabled");
               }
               else{
                    return false;
                }
            });


            //SIGNUP
            $("#signupForm").validate({
                rules: {
                   email:{
                        required:true,
                        not_empty:true,
                        maxlength:150,
                        email: true,
                        valid_email: true,
                        remote: {
                            url: "{{ route('user.check.email') }}",
                            type: "post",
                            data: {
                                _token: function() {
                                    return "{{csrf_token()}}"
                                },
                                type: "user",
                            }
                        },
                    },
                    password:{
                        required:true,
                        not_empty:true,
                        minlength:8,
                        maxlength:16,
                        pattern:/^(?=.{8,16}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/,
                    },
                    password_confirmation:{
                        required:true,
                        not_empty:true,
                        minlength:8,
                        maxlength:16,
                        equalTo:'#password_signup',
                    },
                },
                messages: {
                    email:{
                        required:"@lang('validation.required',['attribute'=>'email'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'email'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'email','max'=>150])",
                        email:"@lang('validation.email',['attribute'=>'email'])",
                        valid_email:"@lang('validation.email',['attribute'=>'email'])",
                        remote:"@lang('validation.unique',['attribute'=>'email'])",
                    },
                    password:{
                        required:"@lang('validation.required',['attribute'=>'password'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'password'])",
                        minlength:"@lang('validation.min.string',['attribute'=>'password','min'=>8])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'password','max'=>16])",
                        pattern:"The password must be a stong password",
                    },
                    password_confirmation:{
                        required:"@lang('validation.required',['attribute'=>'confirm password'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'confirm'])",
                        minlength:"@lang('validation.min.string',['attribute'=>'confirm','min'=>8])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'confirm','max'=>16])",
                        equalTo:"password and confirm password not match.",
                    },
                },
                errorClass: 'help-block',
                errorElement: 'span',

                highlight: function(element) {
                   $(element).closest('.form-group').addClass('has-error').css('color','red');
                },
                unhighlight: function(element) {
                   $(element).closest('.form-group').removeClass('has-error');
                   $(element).closest('.form-group').removeClass('has-error');
                   $('#passwordNote').css('color','black');
                },
                errorPlacement: function(error, element) {
                    if (element.attr("data-error-container")) {
                        error.appendTo(element.attr("data-error-container"));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });


            $('#btn-signup').on('click',function(){
               if( $('#signupForm').valid() ) {
                    $('#server-signup-email').empty();
                    $("#server-signup-password").empty();
                    $("#server-signup-cpassword").empty();
                        $.ajax({
                            type: 'POST',
                            dataType: 'JSON',
                            url: "{{ route('user.signup') }}",
                            data: {
                                 _token: '{{ csrf_token() }}',
                                email : function(){
                                    return $("#email_signup").val();
                                },
                                password: function(){
                                    return $("#password_signup").val();
                                },
                                password_confirmation: function(){
                                    return $("#confirm_password_signup").val();
                                }
                            },
                            beforeSend: function() {
                                showLoader();
                            },
                            success: function(Response){
                                if(Response.serverError){
                                    if(Response.serverError.email != undefined){
                                        $('#server-signup-email').append('<span class="error-help">'+Response.serverError.email+'</span>');
                                    }
                                    if(Response.serverError.password != undefined){
                                        $('#server-signup-password').append('<span class="error-help">'+Response.serverError.password+'</span>');
                                    }
                                    if(Response.serverError.password_confirmation != undefined){
                                        $('#server-signup-cpassword').append('<span class="error-help">'+Response.serverError.password_confirmation+'</span>');
                                    }
                                }
                                if(Response.success){
                                    $('#signup').modal('hide');
                                    $('#signupCheckout').modal('hide');
                                    $('#header').replaceWith(Response['header']);
                                    $('body').addClass('logged-in');

                                    //Country(select)
                                    customSelect = $('select');
                                    // Options for custom Select
                                    jcf.setOptions('Select', {
                                        wrapNative: false,
                                        wrapNativeOnMobile: false,
                                        fakeDropInBody: false
                                    });
                                    jcf.replace(customSelect);
                                    jcf.refresh();

                                    //Dropdown(Cart Icon)
                                    $('.header-content_inner > ul > li:last-child').click(function () {
                                        $(this).toggleClass('show')
                                    });
                                }
                            },
                            complete: function() {
                                removeLoader();
                            },
                        });
                    //$("input[type=submit], input[type=button], button[type=submit]").prop("disabled", "disabled");
               }
               else{
                    return false;
                }
            });


            //CHECKOUT SIGNUP
            $("#checkoutSignupForm").validate({
                rules: {
                   email:{
                        required:true,
                        not_empty:true,
                        maxlength:150,
                        email: true,
                        valid_email: true,
                        remote: {
                            url: "{{ route('user.check.email') }}",
                            type: "post",
                            data: {
                                _token: function() {
                                    return "{{csrf_token()}}"
                                },
                                type: "user",
                            }
                        },
                    },
                    password:{
                        required:true,
                        not_empty:true,
                        minlength:8,
                        maxlength:16,
                        pattern:/^(?=.{8,16}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/,
                    },
                    password_confirmation:{
                        required:true,
                        not_empty:true,
                        minlength:8,
                        maxlength:16,
                        equalTo:'#password_checkout_signup',
                    },
                },
                messages: {
                    email:{
                        required:"@lang('validation.required',['attribute'=>'email'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'email'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'email','max'=>150])",
                        email:"@lang('validation.email',['attribute'=>'email'])",
                        valid_email:"@lang('validation.email',['attribute'=>'email'])",
                        remote:"@lang('validation.unique',['attribute'=>'email'])",
                    },
                    password:{
                        required:"@lang('validation.required',['attribute'=>'password'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'password'])",
                        minlength:"@lang('validation.min.string',['attribute'=>'password','min'=>8])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'password','max'=>16])",
                        pattern:"The password must be a stong password",
                    },
                    password_confirmation:{
                        required:"@lang('validation.required',['attribute'=>'confirm password'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'confirm'])",
                        minlength:"@lang('validation.min.string',['attribute'=>'confirm','min'=>8])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'confirm','max'=>16])",
                        equalTo:"password and confirm password not match.",
                    },
                },
                errorClass: 'help-block',
                errorElement: 'span',

                highlight: function(element) {
                   $(element).closest('.form-group').addClass('has-error').css('color','red');
                },
                unhighlight: function(element) {
                   $(element).closest('.form-group').removeClass('has-error');
                   $(element).closest('.form-group').removeClass('has-error');
                   $('#passwordNoteCheckout').css('color','black');
                },
                errorPlacement: function(error, element) {
                    if (element.attr("data-error-container")) {
                        error.appendTo(element.attr("data-error-container"));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });


            $('#btn-checkout-signup').on('click',function(){
               if( $('#checkoutSignupForm').valid() ) {
                    $("#server-checkoutsignup-email").empty();
                    $("#server-checkoutsignup-password").empty();
                    $("#server-checkoutsignup-cpassword").empty();
                        $.ajax({
                            type: 'POST',
                            dataType: 'JSON',
                            url: "{{ route('user.signup') }}",
                            data: {
                                 _token: '{{ csrf_token() }}',
                                email : function(){
                                    return $("#email_checkout_signup").val();
                                },
                                password: function(){
                                    return $("#password_checkout_signup").val();
                                },
                                password_confirmation: function(){
                                    return $("#confirm_password_checkout_signup").val();
                                }
                            },
                            beforeSend: function() {
                                showLoader();
                            },
                            success: function(Response){
                                if(Response.serverError){
                                    if(Response.serverError.email != undefined){
                                        $('#server-checkoutsignup-email').append('<span class="error-help">'+Response.serverError.email+'</span>');
                                    }
                                    if(Response.serverError.password != undefined){
                                        $('#server-checkoutsignup-password').append('<span class="error-help">'+Response.serverError.password+'</span>');
                                    }
                                    if(Response.serverError.password_confirmation != undefined){
                                        $('#server-checkoutsignup-cpassword').append('<span class="error-help">'+Response.serverError.password_confirmation+'</span>');
                                    }
                                }
                                if(Response.success){
                                    $('#signup').modal('hide');
                                    $('#checkout-signup').modal('hide');
                                    $('#header').replaceWith(Response['header']);
                                    $('body').addClass('logged-in');
                                }
                            },
                            complete: function() {
                                removeLoader();
                            },
                        });
                    //$("input[type=submit], input[type=button], button[type=submit]").prop("disabled", "disabled");
               }
               else{
                    return false;
                }
            });


            //RESET PASSWORD(FORGOT PASSWORD)
            $("#resetForm").validate({
                rules: {
                    email:{
                            required:true,
                            not_empty:true,
                            maxlength:150,
                            email: true,
                            valid_email: true,
                            remote: {
                                url: "{{ route('user.check.forgotemail') }}",
                                type: "post",
                                data: {
                                    _token: function() {
                                        return "{{csrf_token()}}"
                                    },
                                    type: "user",
                                },
                            },
                        },
                    },
                    messages: {
                       email:{
                            required:"@lang('validation.required',['attribute'=>'email'])",
                            not_empty:"@lang('validation.not_empty',['attribute'=>'email'])",
                            maxlength:"@lang('validation.max.string',['attribute'=>'email','max'=>150])",
                            email:"@lang('validation.email',['attribute'=>'email'])",
                            valid_email:"@lang('validation.email',['attribute'=>'email'])",
                            remote:"The email is not registered.",
                        },
                    },
                    errorClass: 'help-block',
                    errorElement: 'span',

                    highlight: function(element) {
                        $(element).closest('.form-group').addClass('has-error').css('color','red');;

                    },
                    unhighlight: function(element) {
                       $(element).closest('.form-group').removeClass('has-error');

                    },
                    errorPlacement: function(error, element) {
                        if (element.attr("data-error-container")) {
                            error.appendTo(element.attr("data-error-container"));
                        } else {
                            error.insertAfter(element);
                        }
                    }
            });

            $('#btn-reset').on('click',function(){               
                var formStatus = $('#resetForm').validate().form();
        
                if( $('#email_reset-error').length == 1 && formStatus == true && $("#resetForm").valid() ){    
                    $("#forgot-sendemail").replaceWith('<p id="forgot-sendemail" class="help-block"></p>');                
                    $('.error-help').remove();
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('password.email') }}",
                        data: {
                             _token: '{{ csrf_token() }}',
                             email : function(){
                                return $("#email_reset").val();
                            },
                        },
                        beforeSend: function() {
                            $("#forgot-sendemail").append('<span>Sending Email Link...</span>');
                            $("input[type=submit], input[type=button], button[type=submit]").prop("disabled", "disabled");
                            showLoader();
                        },
                        success: function(Response){
                            $("#email_reset").val('');
                            $('#forgot').modal('hide');
                        },
                        complete: function() {
                            $("#forgot-sendemail").replaceWith('<p id="forgot-sendemail" class="help-block"></p>');
                            $("#forgot-sendemail").append('<span>Please try again !!!</span>');
                            $("input[type=submit], input[type=button], button[type=submit]").prop("disabled", false);
                            removeLoader();
                        },
                    });
                }
                else{
                    $("#forgot-sendemail").replaceWith('<p id="forgot-sendemail" class="help-block"></p>');
                    $("#forgot-sendemail").append('<span style="color:red;">Please try again !!!</span>');
                    return false;
                }
            });


            //EDIT PROFILE
            $("#editProfileForm").validate({
                rules: {
                    first_name: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    last_name:{
                        required:true,
                        not_empty:true,
                        maxlength:255,
                    },
                    contact:{
                        required:true,
                        not_empty:true,
                        maxlength:16,
                        minlength:8,
                        pattern: /^(\d+)(?: ?\d+)*$/,
                        remote: {
                            url: "{{ route('user.check.contact') }}",
                            type: "post",
                            data: {
                                _token: function() {
                                    return "{{csrf_token()}}"
                                },
                                type: "user",
                                id: "{{ Auth::id() }}",
                            }
                        },
                    },
                    profile:{
                        extension: "jpg|jpeg|png",
                    },
                },
                messages: {
                    first_name:{
                        required:"@lang('validation.required',['attribute'=>'first name'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'first name'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'first name','max'=>255])",
                    },
                    last_name:{
                        required:"@lang('validation.required',['attribute'=>'last name'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'last name'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'last name','max'=>255])",
                    },
                    contact:{
                        required:"@lang('validation.required',['attribute'=>'contact number'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'contact number'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'contact number','max'=>16])",
                        minlength:"@lang('validation.min.string',['attribute'=>'contact number','min'=>8])",
                        pattern:"@lang('validation.numeric',['attribute'=>'contact number'])",
                        pattern:"contact must be a number.",
                        remote:"@lang('validation.unique',['attribute'=>'contact number'])",
                    },
                    profile:{
                        extension:"@lang('validation.mimetypes',['attribute'=>'profile photo','value'=>'jpg,png,jpeg'])"
                    },
                },
                errorClass: 'help-block',
                errorElement: 'span',

                highlight: function(element) {
                   $(element).closest('.form-group').addClass('has-error').css('color','red');
                },
                unhighlight: function(element) {
                   $(element).closest('.form-group').removeClass('has-error');
                },
                errorPlacement: function(error, element) {
                    if (element.attr("data-error-container")) {
                        error.appendTo(element.attr("data-error-container"));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            $('#editProfileForm').on('submit',function(event){
                event.preventDefault();
               if( $('#editProfileForm').valid() ) {
                    $("#server-profile-first-name").empty();
                    $("#server-profile-last-name").empty();
                    $("#server-profile-contact").empty();
                    $("#server-profile-profile").empty();
                        $.ajax({
                            type: 'POST',
                            dataType: 'JSON',
                            contentType: false,
                            cache: false,
                            processData: false,
                            url: "{{ route('edit.profile') }}",
                            data: new FormData(this),
                            beforeSend: function() {
                                showLoader();
                            },
                            success: function(Response){
                                if(Response.serverError){
                                    if(Response.serverError.first_name != undefined){
                                        $('#server-profile-first-name').append('<span class="error-help">'+Response.serverError.first_name+'</span>');
                                    }
                                    if(Response.serverError.last_name != undefined){
                                        $('#server-profile-last-name').append('<span class="error-help">'+Response.serverError.last_name+'</span>');
                                    }
                                    if(Response.serverError.contact != undefined){
                                        $('#server-profile-contact').append('<span class="error-help">'+Response.serverError.contact+'</span>');
                                    }
                                    if(Response.serverError.profile != undefined){
                                        $('#server-profile-profile').append('<span class="error-help">'+Response.serverError.profile+'</span>');
                                    }
                                }
                                if(Response.success){
                                    $('#edit-info').modal('hide');
                                    $('.modal-backdrop').remove();
                                }
                            },
                            complete: function() {
                                removeLoader();
                            },
                        });
               }
               else{
                    return false;
                }
            });

            //Change Password
            $("#changePasswordForm").validate({
                rules: {
                    password:{
                        required:true,
                        not_empty:true,
                        minlength:8,
                        maxlength:16,
                        pattern:/^(?=.{8,16}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/,
                    },
                    password_confirmation:{
                        required:true,
                        not_empty:true,
                        minlength:8,
                        maxlength:16,
                        equalTo:'#password_change',
                    },
                },
                messages: {
                    password:{
                        required:"@lang('validation.required',['attribute'=>'password'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'password'])",
                        minlength:"@lang('validation.min.string',['attribute'=>'password','min'=>8])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'password','max'=>16])",
                        pattern:"The password must be a stong password",
                    },
                    password_confirmation:{
                        required:"@lang('validation.required',['attribute'=>'confirm password'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'confirm password'])",
                        minlength:"@lang('validation.min.string',['attribute'=>'confirm password','min'=>8])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'confirm password','max'=>16])",
                        equalTo:"password and confirm password not match.",
                    },
                },
                errorClass: 'help-block',
                errorElement: 'span',

                highlight: function(element) {
                   $(element).closest('.form-group').addClass('has-error').css('color','red');
                },
                unhighlight: function(element) {
                   $(element).closest('.form-group').removeClass('has-error').css('color','black');
                    $('#passwordNoteForChangePassword').css('color','black');
                },
                errorPlacement: function(error, element) {
                    if (element.attr("data-error-container")) {
                        error.appendTo(element.attr("data-error-container"));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });


            $('#btn-changepassword').on('click',function(){
               if( $('#changePasswordForm').valid() ) {
                    $("#server-changepassword-password").empty();
                    $("#server-changepassword-cpassword").empty();
                        $.ajax({
                            type: 'POST',
                            dataType: 'JSON',
                            url: "{{ route('change.accountpassword') }}",
                            data: {
                                 _token: '{{ csrf_token() }}',
                                password : function(){
                                    return $("#password_change").val();
                                },
                                password_confirmation: function(){
                                    return $("#confirm_password_change").val();
                                }
                            },
                            beforeSend: function() {
                                $("input[type=submit], input[type=button], button[type=submit]").prop("disabled", "disabled");
                                showLoader();
                            },
                            success: function(Response){
                                if(Response.serverError){
                                    if(Response.serverError.password != undefined){
                                        $('#server-changepassword-password').append('<span class="error-help">'+Response.serverError.password+'</span>');
                                    }
                                    if(Response.serverError.password_confirmation != undefined){
                                        $('#server-changepassword-cpassword').append('<span class="error-help">'+Response.serverError.password_confirmation+'</span>');
                                    }
                                }
                                if(Response.success){
                                    $("#password_change").val('');
                                    $("#confirm_password_change").val('');
                                    $('#edit-password').modal('hide');
                                    $('.modal-backdrop').remove();
                                }
                            },
                            complete: function() {
                                $("input[type=submit], input[type=button], button[type=submit]").prop("disabled", false);
                                removeLoader();
                            },
                        });
               }
               else{
                    return false;
                }
            });


        //Add Address
        $("#addAddressForm").validate({
            rules: {
                first_name:{
                    required:true,
                    not_empty:true,
                    maxlength:255,
                },
                last_name:{
                    required:true,
                    not_empty:true,
                    maxlength:255,
                },
                city:{
                    required:true,
                    not_empty:true,
                    maxlength:255,
                },
                emirate:{
                    required:true,
                    not_empty:true,
                    maxlength:255,
                },
                pincode:{
                    required:true,
                    not_empty:true,
                    pattern: /^(\d+)(?: ?\d+)*$/,
                    minlength:6,
                    maxlength:10,
                },
                address:{
                    required:true,
                    not_empty:true,
                    maxlength:500,
                },
                contact:{
                    required:true,
                    not_empty:true,
                    pattern: /^(\d+)(?: ?\d+)*$/,
                    minlength:8,
                    maxlength:16,
                },
            },
            messages: {
                first_name:{
                    required:"@lang('validation.required',['attribute'=>'first name'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'first name'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'first name','max'=>255])",
                },
                last_name:{
                    required:"@lang('validation.required',['attribute'=>'last name'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'last name'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'last name','max'=>255])",
                },
                city:{
                    required:"@lang('validation.required',['attribute'=>'city'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'city'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'city','max'=>255])",
                },
                emirate:{
                    required:"@lang('validation.required',['attribute'=>'emirate'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'emirate'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'emirate','max'=>255])",
                },
                pincode:{
                    required:"@lang('validation.required',['attribute'=>'pincode'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'pincode'])",
                    pattern:"The pincode must be a number.",
                    minlength:"@lang('validation.min.string',['attribute'=>'pincode','min'=>6])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'pincode','max'=>10])",
                },
                address:{
                    required:"@lang('validation.required',['attribute'=>'address'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'address'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'address','max'=>500])",
                },
                contact:{
                    required:"@lang('validation.required',['attribute'=>'phone'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'phone'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'phone','max'=>16])",
                    minlength:"@lang('validation.min.string',['attribute'=>'phone','min'=>8])",
                    pattern:"@lang('validation.numeric',['attribute'=>'phone'])",
                    pattern:"phone must be a number.",
                },
            },
            errorClass: 'help-block',
            errorElement: 'span',

            highlight: function(element) {
               $(element).closest('.form-group').addClass('has-error').css('color','red');
            },
            unhighlight: function(element) {
               $(element).closest('.form-group').removeClass('has-error').css('color','black');
            },
            errorPlacement: function(error, element) {
                if (element.attr("data-error-container")) {
                    error.appendTo(element.attr("data-error-container"));
                } else {
                    error.insertAfter(element);
                }
            }
        });


        $('#btn-addAddress').on('click',function(){
            if( $("#addAddressForm").valid() ){
                $("#server-address-first_name").empty();
                $("#server-address-last_name").empty();
                $("#server-address-emirate").empty();
                $("#server-address-city").empty();
                $("#server-address-pincode").empty();
                $("#server-address-address").empty();
                $("#server-address-contact").empty();

                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    url: "{{ route('user.address') }}",
                    data: {
                             _token: '{{ csrf_token() }}',
                            first_name : function(){
                                return $("#add_firstname").val();
                            },
                            last_name : function(){
                                return $("#add_lastname").val();
                            },
                            emirate : function(){
                                return $("#add_emirate").val();
                            },
                            city: function(){
                                return $("#add_city").val();
                            },
                            pincode: function(){
                                return $("#add_pincode").val();
                            },
                            address : function(){
                                return $("#add_address").val();
                            },
                            contact : function(){
                                return $("#add_contact").val();
                            },
                        },
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(Response){
                        if(Response.serverError){
                            if(Response.serverError.first_name != undefined){
                                $('#server-address-first_name').append('<span class="error-help">'+Response.serverError.first_name+'</span>');
                            }
                            if(Response.serverError.last_name != undefined){
                                $('#server-address-last_name').append('<span class="error-help">'+Response.serverError.last_name+'</span>');
                            }
                            if(Response.serverError.emirate != undefined){
                                $('#server-address-emirate').append('<span class="error-help">'+Response.serverError.emirate+'</span>');
                            }
                            if(Response.serverError.city != undefined){
                                $('#server-address-city').append('<span class="error-help">'+Response.serverError.city+'</span>');
                            }
                            if(Response.serverError.pincode != undefined){
                                $('#server-address-pincode').append('<span class="error-help">'+Response.serverError.pincode+'</span>');
                            }
                            if(Response.serverError.address != undefined){
                                $('#server-address-address').append('<span class="error-help">'+Response.serverError.address+'</span>');
                            }
                            if(Response.serverError.contact != undefined){
                                $('#server-address-contact').append('<span class="error-help">'+Response.serverError.contact+'</span>');
                            }
                        }
                        if(Response.success){
                            $('#edit-address').modal('hide');
                            $('.modal-backdrop').remove();
                            $('#addAddress').append(
                                '<li>'+
                                    '<p><strong>'+$("#add_firstname").val()+' '+$("#add_lastname").val()+'</strong></p>'+
                                    '<address>'+$("#add_address").val()+''+
                                    '</address>'+
                                    '<p>+'+$("#add_contact").val()+'</p>'+
                                    '<div class="mark-default">'+
                                        '<a href="javascript:;" class="btn-outline">Make Default</a>'+
                                        '<input type="radio" name="default-address" data-id="'+Response.address['id']+'" data-user_id="'+Response.address['user_id']+'">'+
                                        '<p>Default Address</p>'+
                                    '</div>'+
                                '</li>');
                        }
                    },
                    complete: function() {
                        removeLoader();
                    },
                });
           }
           else{
                return false;
            }
        });
    });

                                                            //ChecKout
            //Checkout Login
            $("#formCheckoutLogin").validate({
                rules: {
                    email:{
                        required:true,
                        not_empty:true,
                        maxlength:150,
                        email: true,
                        valid_email: true,
                    },
                    password:{
                        required:true,
                        not_empty:true,
                        minlength:8,
                        maxlength:16,
                    },
                },
                messages: {
                    email:{
                        required:"@lang('validation.required',['attribute'=>'email'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'email'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'email','max'=>150])",
                        email:"@lang('validation.email',['attribute'=>'email'])",
                        valid_email:"@lang('validation.email',['attribute'=>'email'])",
                    },
                    password:{
                        required:"@lang('validation.required',['attribute'=>'password'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'password'])",
                        minlength:"@lang('validation.min.string',['attribute'=>'password','min'=>8])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'password','max'=>16])",
                    },
                },
                errorClass: 'help-block',
                errorElement: 'span',

                highlight: function(element) {
                   $(element).closest('.form-group').addClass('has-error').css('color','red');
                },
                unhighlight: function(element) {
                   $(element).closest('.form-group').removeClass('has-error');
                },
                errorPlacement: function(error, element) {
                    if (element.attr("data-error-container")) {
                        error.appendTo(element.attr("data-error-container"));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });


            $('#btn-checkout-login').on('click',function(){
               if( $('#formCheckoutLogin').valid() ) {
                    $('.error-help').remove();
                    $("#server-checkoutlogin-email").empty();
                    $("#server-checkoutlogin-password").empty();
                        $.ajax({
                            type: 'POST',
                            dataType: 'JSON',
                            url: "{{ route('user.login') }}",
                            data: {
                                 _token: '{{ csrf_token() }}',
                                email : function(){
                                    return $("#email_checkout_login").val();
                                },
                                password: function(){
                                    return $("#password_checkout_login").val();
                                },
                            },
                            beforeSend: function() {
                                showLoader();
                            },
                            success: function(Response){
                                if(Response.serverError){
                                    if(Response.serverError.email != undefined){
                                        $('#server-checkoutlogin-email').append('<span class="error-help">'+Response.serverError.email+'</span>');
                                    }
                                    if(Response.serverError.password != undefined){
                                        $('#server-checkoutlogin-password').append('<span class="error-help">'+Response.serverError.password+'</span>');
                                    }
                                }
                                if(Response.notregisterd)
                                {
                                    $('#error-chechout-login').append('<span class="error-help">'+Response.notregisterd+'</span>');
                                }
                                if(Response.notactive)
                                {
                                    $('#error-chechout-login').append('<span class="error-help">'+Response.notactive+'</span>');
                                }
                                if(Response.invalid)
                                {
                                    $('#error-chechout-login').append('<span class="error-help">'+Response.invalid+'</span>');
                                }
                                if(Response.success){
                                    window.location.href = "{{ route('logged-in-checkout') }}";
                                }
                            },
                            complete: function() {
                                removeLoader();
                            },
                        });
                    //$("input[type=submit], input[type=button], button[type=submit]").prop("disabled", "disabled");
               }
               else{
                    return false;
                }
            });


                                    //Checkout Login
            $("#formAddGiftMessage").validate({
                rules: {
                    message:{
                        required:true,
                        not_empty:true,
                        maxlength:500,
                    },
                },
                messages: {
                    message:{
                        required:"@lang('validation.required',['attribute'=>'message'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'message'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'message','max'=>500])",
                    },
                },
                errorClass: 'help-block',
                errorElement: 'span',

                highlight: function(element) {
                   $(element).closest('.form-group').addClass('has-error').css('color','red');
                },
                unhighlight: function(element) {
                   $(element).closest('.form-group').removeClass('has-error');
                },
                errorPlacement: function(error, element) {
                    if (element.attr("data-error-container")) {
                        error.appendTo(element.attr("data-error-container"));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            $('#btn-addGiftMessage').on('click',function(){
               if( $('#formAddGiftMessage').valid() ) {
                    $('.error-help').remove();
                    $("#server-gift-message").empty();
                   
                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        url: "{{ route('giftmessage') }}",
                        data: {
                             _token: '{{ csrf_token() }}',
                            custom_id : function(){
                                return $("#gift_message_custom_id").val();
                            },
                            cart_id : function(){
                                return $("#gift_message_cart_id").val();
                            },
                            product_id : function(){
                                return $("#gift_message_product_id").val();
                            },
                            quantity : function(){
                                return $("#gift_message_quantity").val();
                            },
                            color_id: function(){
                                return $("#gift_message_color_id").val();
                            },
                            message: function(){
                                return $("#gift_message").val();
                            },
                        },
                        beforeSend: function() {
                            showLoader();
                        },
                        success: function(Response){
                            if(Response.serverError){
                                if(Response.serverError.message != undefined){
                                    $('#server-gift-message').append('<span class="error-help">'+Response.serverError.message+'</span>');
                                }
                            }
                            if(Response.success){
                                $('#add-message').modal('hide');
                                $('.modal-backdrop').remove();
                            }
                            if(Response[0]){
                                $('#add-message').modal('hide');
                                $('.modal-backdrop').remove();
                            }
                        },
                        complete: function() {
                            removeLoader();
                        },
                    });
                    //$("input[type=submit], input[type=button], button[type=submit]").prop("disabled", "disabled");
               }
               else{
                    return false;
                }
            });


            //Change City Based On Country(Emirate) Selection
            $('#add_emirate').change(function(){
                $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        url: "{{ route('country.getcity') }}",
                        data: {
                                _token      : '{{ csrf_token() }}',
                                country_id  : function(){
                                    return $("#add_emirate").val();
                                },
                            },
                        success: function(Response){
                            if(Response.success){
                                var cities = JSON.parse(Response.cities);

                                $("#add_city").empty();
                                $("#add_city").append('<option value="" selected>Select City</option>');

                                $(cities).map((id,city) => {
                                    $("#add_city").append('<option value='+city['id']+'>'+city['city_name']+'</option>');
                                });
                            }
                            if(Response.fail){
                                $("#add_city").empty();
                                $("#add_city").append('<option value="" selected>Select City</option>');
                            }
                        },
                });
            });


            //Change City Based On Country(Emirate) Selection
            $('#inquiry_country').change(function(){
                $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        url: "{{ route('country.getcity') }}",
                        data: {
                                _token      : '{{ csrf_token() }}',
                                country_id  : function(){
                                    return $("#inquiry_country").val();
                                },
                            },
                        success: function(Response){
                            if(Response.success){
                                var cities = JSON.parse(Response.cities);

                                $("#inquiry_city").empty();
                                $("#inquiry_city").append('<option value="" selected>Select City</option>');

                                $(cities).map((id,city) => {
                                    $("#inquiry_city").append('<option value='+city['id']+'>'+city['city_name']+'</option>');
                                });
                            }
                            if(Response.fail){
                                $("#inquiry_city").empty();
                                $("#inquiry_city").append('<option value="" selected>Select City</option>');
                            }
                        },
                });
            });



            //Subsription Form
            $("#frmSubscription").validate({
                rules: {
                    email:{
                            required:true,
                            not_empty:true,
                            maxlength:150,
                            email: true,
                            valid_email: true,
                            remote: {
                                url: "{{ route('subscribe.checkemail') }}",
                                type: "post",
                                data: {
                                    _token: function() {
                                        return "{{csrf_token()}}"
                                    },
                                    type: "subscribe_user",
                                },
                            },
                        },
                    },
                    messages: {
                       email:{
                            required:"@lang('validation.required',['attribute'=>'email'])",
                            not_empty:"@lang('validation.not_empty',['attribute'=>'email'])",
                            maxlength:"@lang('validation.max.string',['attribute'=>'email','max'=>150])",
                            email:"@lang('validation.email',['attribute'=>'email'])",
                            valid_email:"@lang('validation.email',['attribute'=>'email'])",
                            remote:"The email is already subscribed.",
                        },
                    },
                    errorClass: 'help-block',
                    errorElement: 'span',

                    highlight: function(element) {
                       $(element).closest('.form-group').addClass('has-error').css('color','red');
                    },
                    unhighlight: function(element) {
                       $(element).closest('.form-group').removeClass('has-error');
                    },
                    errorPlacement: function(error, element) {
                        if (element.attr("data-error-container")) {
                            error.appendTo(element.attr("data-error-container"));
                        } else {
                            error.insertAfter(element);
                        }
                    }
            });


            //Subsription Form Index Page
            $("#frmSubscriptionIndex").validate({
                rules: {
                    email:{
                            required:true,
                            not_empty:true,
                            maxlength:150,
                            email: true,
                            valid_email: true,
                            remote: {
                                url: "{{ route('subscribe.checkemail') }}",
                                type: "post",
                                data: {
                                    _token: function() {
                                        return "{{csrf_token()}}"
                                    },
                                    type: "subscribe_user",
                                },
                            },
                        },
                    },
                    messages: {
                       email:{
                            required:"@lang('validation.required',['attribute'=>'email'])",
                            not_empty:"@lang('validation.not_empty',['attribute'=>'email'])",
                            maxlength:"@lang('validation.max.string',['attribute'=>'email','max'=>150])",
                            email:"@lang('validation.email',['attribute'=>'email'])",
                            valid_email:"@lang('validation.email',['attribute'=>'email'])",
                            remote:"The email is already subscribed.",
                        },
                    },
                    errorClass: 'help-block',
                    errorElement: 'span',

                    highlight: function(element) {
                       $(element).closest('.form-group').addClass('has-error').css('color','red');
                    },
                    unhighlight: function(element) {
                       $(element).closest('.form-group').removeClass('has-error');
                    },
                    errorPlacement: function(error, element) {
                        if (element.attr("data-error-container")) {
                            error.appendTo(element.attr("data-error-container"));
                        } else {
                            error.insertAfter(element);
                        }
                    }
            });


            //Subsription Form News Page
            $("#frmSubscriptionNews").validate({
                rules: {
                    email:{
                            required:true,
                            not_empty:true,
                            maxlength:150,
                            email: true,
                            valid_email: true,
                            remote: {
                                url: "{{ route('subscribe.checkemail') }}",
                                type: "post",
                                data: {
                                    _token: function() {
                                        return "{{csrf_token()}}"
                                    },
                                    type: "subscribe_user",
                                },
                            },
                        },
                    },
                    messages: {
                       email:{
                            required:"@lang('validation.required',['attribute'=>'email'])",
                            not_empty:"@lang('validation.not_empty',['attribute'=>'email'])",
                            maxlength:"@lang('validation.max.string',['attribute'=>'email','max'=>150])",
                            email:"@lang('validation.email',['attribute'=>'email'])",
                            valid_email:"@lang('validation.email',['attribute'=>'email'])",
                            remote:"The email is already subscribed.",
                        },
                    },
                    errorClass: 'help-block',
                    errorElement: 'span',

                    highlight: function(element) {
                       $(element).closest('.form-group').addClass('has-error').css('color','red');
                    },
                    unhighlight: function(element) {
                       $(element).closest('.form-group').removeClass('has-error');
                    },
                    errorPlacement: function(error, element) {
                        if (element.attr("data-error-container")) {
                            error.appendTo(element.attr("data-error-container"));
                        } else {
                            error.insertAfter(element);
                        }
                    }
            });
    </script>    
    <script type="text/javascript">
        $(document).ready(
            setTimeout(function(){
                $('#main_loader').remove(); 
            }, 500)
        );

        function showLoader() {
            $('header').prepend(' <div id="main_loader" class="lds-ring"><div></div><div></div><div></div><div></div></div>'); 
        }
       
        function removeLoader() {
            $('#main_loader').remove(); 
        }

        function CountryRedirect(){
            var http        =   "https://";
            var url         =   document.getElementById('dropdown-country-redirect').value;
            var full_url    =   http.concat(url);
            window.open(full_url, 'Flower Shop');
        }

        function CountryRedirectForMobile(){
            var http        =   "https://";
            var url         =   document.getElementById('dropdown-country-mobile').value;
            var full_url    =   http.concat(url);
            window.open(full_url, 'Flower Shop');
        }
    </script>
    </div>
</body>
</html>


