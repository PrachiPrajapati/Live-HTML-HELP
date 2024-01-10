@extends('frontend.layouts.app')

@section('main-content')

<!-- cart section -->
<section class="cart-section common-spacing">
    <article class="container">
        <div class="row">
            <div class="col-xl-9">
                <div class="step-1 form-step">
                    <div class="title-block">
                        <h2><span>1/2 Delivery Details</span></h2>
                    </div>
                    <div class="delivery-addresses saved-items" id="allAddressList">
                        <div class="saved-item">
                            <ul class="d-md-flex">
                                @if($userDefaultAddress != null)
                                    <li><img src="{{ asset('frontend/images/check-circle.png') }}" alt="selected"></li>
                                    <li id="selected-address">
                                        <div class="saved-items_detail">
                                            <strong>{{ $userDefaultAddress->first_name }} {{ $userDefaultAddress->last_name }}</strong>
                                            <address>{{ $userDefaultAddress->address }}</address>
                                            @if($userDefaultAddress->city != null)
                                                <p>{{ $userDefaultAddress->city->getCity() }},
                                                    @if($userDefaultAddress->country != null)
                                                        {{ $userDefaultAddress->country->getName() }}
                                                    @endif
                                                </p>
                                            @endif
                                            <p>{{ $userDefaultAddress->pincode }}</p>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="open-saved-items"><i class="fa fa-chevron-down"></i></a>
                                    </li>
                                @else
                                    Please Add Your Delivery Address.
                                @endif
                            </ul>

                            <div class="other-saved-items">
                                @if($userAddress != null && $userDefaultAddress != null)
                                    @foreach($userAddress as $data)
                                        @if($data->city != null && $data->country != null)
                                        <div class="other-saved-item_single">
                                            <ul class="d-md-flex justify-content-between">
                                                <li id="replaced-address">
                                                    <div class="saved-items_detail">
                                                        <strong>{{ $data->first_name }} {{ $data->last_name }}</strong>
                                                        <address>{{ $data->address }}</address>
                                                        <p>{{ $data->city->getCity() }}, {{ $data->country->getName() }}</p>
                                                        <p>{{ $data->pincode }}</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <button type="button" class="btn-outline select-address" data-id="{{ $data->id }}" data-first_name="{{ $data->first_name }}" data-last_name="{{ $data->last_name }}" data-delivery_charge = "{{ $data->city->charges }}" data-old_charge = "{{ $delivery_charge }}" data-total = "{{ $total }}" data-address="{{ $data->address }}" data-city="{{ $data->city->getCity() }}" data-country="{{ $data->country->getName() }}" data-pincode="{{ $data->pincode }}">
                                                    Select
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                        @endif
                                    @endforeach
                               @endif
                            </div>
                        </div>
                    </div>
                    <div class="child">
                        <div id="addressBtn" style="display:none;">
                            <form class="common-form" id="frmDeliveryAddress">
                            @csrf
                                <div id="eventInformation">
                                    <button type="button" class="close btnclose" id="btn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><img src="{{ asset('frontend/images/close.png') }}" alt="close"></span></button>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group"><input type="text" id="checkout_first_name" name="first_name_delivery" class="form-control" value="" placeholder="FIRST NAME"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"><input type="text" id="checkout_last_name" name="last_name_delivery" class="form-control" value="" placeholder="LAST NAME"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-focused">
                                                <select class="form-select address-select" id="checkout_country" name="country_delivery" data-error-container="#logged-in-delivery-country">
                                                    <option class="hideme" value="">SELECT EMIRATE</option>
                                                    @foreach($country as $country_data)
                                                        @if($country_data->getName() == 'UAE' || $country_data->getName() == 'Uae' || $country_data->getName() == 'الإمارات العربية المتحدة')
                                                            <option value="{{ $country_data->id }}" selected>{{ $country_data->getName() }}</option>
                                                        @else
                                                            <option value="{{ $country_data->id }}">{{ $country_data->getName() }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <span id="logged-in-delivery-country"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-focused">
                                                <select class="form-select address-select" id="checkout_city" name="city_delivery" data-error-container="#logged-in-delivery-city">
                                                    <option class="hideme" value="">SELECT CITY</option>
                                                </select>
                                                <span id="logged-in-delivery-city"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group"><input type="text" id="checkout_address" name="address_delivery" class="form-control" value="" placeholder="ADDRESS"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"><input type="text" id="checkout_pincode" name="pincode_delivery" class="form-control" value="000000" placeholder="POSTAL CODE / ZIP"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"><input type="text" id="checkout_contact" name="contact_delivery" class="form-control" value="" placeholder="PHONE NUMBER"></div>
                                        </div>
                                    </div>
                                    <div id="emaildiv" class="col-sm-11"></div>
                                </div>
                                <div class="col-md-6 savebutton">
                                    <button type="submit" id="btn-address" class="common-black-btn">Save Address</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="addAddress">
                        <a href="javascript:;" id="btnAddAddress" class="add-new address btninner">+ Add a new address</a>
                    </div>
                    <div class="log-in_btn-group">
                       {{-- <!-- <button type="button" class="common-black-btn">Confirm Delivery Address</button> --> --}}
                    </div>
                </div>

            <!-- <iframe name="nameFrame" src="payment_form.php" width="600" height="550" scrolling="no" /> -->

            <form class="common-form" id="frmCheckout" method="POST" action="{{ route('product-confirmation') }}">
                @csrf
                <div class="step-2 form-step">
                        <div class="billing-address">
                            <h4>Billing Address</h4>
                            <div class="form-check-block">
                                <div class="form-check">
                                    <div class="check-status checked">
                                        <input class="form-check-input" type="checkbox" value="" checked id="defaultCheck1">
                                    </div>
                                    <label class="form-check-label" for="defaultCheck1">
                                        Same as Delivery
                                    </label>
                                </div>
                            </div>
                            <div class="row change-delivery-address" style="display: none;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="first_name" class="form-control" placeholder="FIRST NAME">
                                        @if($errors->has('first_name'))
                                            <span class="help-block">
                                                {{ $errors->first('first_name') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="last_name" class="form-control" placeholder="LAST NAME">
                                        @if($errors->has('last_name'))
                                            <span class="help-block">
                                                {{ $errors->first('last_name') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group input-focused">
                                        <select class="form-select" id="billing_country" name="country" data-error-container="#country-error">
                                            <option class="hideme" value="">SELECT EMIRATE</option>
                                            @foreach($country as $county_data) 
                                                @if($county_data->getName() == 'UAE' || $county_data->getName() == 'Uae' || $country_data->getName() == 'الإمارات العربية المتحدة')
                                                    <option value="{{ $county_data->id }}" selected>{{ $county_data->getName() }}</option>
                                                @else
                                                    <option value="{{ $county_data->id }}">{{ $county_data->getName() }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <span id="country-error"></span>
                                       @if($errors->has('country'))
                                            <span class="help-block">
                                                {{ $errors->first('country') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group input-focused">
                                        <select class="form-select" id="billing_city" name="city" data-error-container="#city-error">
                                            <option class="hideme" value="">SELECT CITY</option>
                                        </select>
                                        <span id="city-error"></span>
                                        @if($errors->has('city'))
                                            <span class="help-block">
                                                {{ $errors->first('city') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="pincode" value="000000" class="form-control" placeholder="POSTAL CODE / ZIP">
                                       @if($errors->has('pincode'))
                                            <span class="help-block">
                                                {{ $errors->first('pincode') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="phone" class="form-control" placeholder="PHONE NUMBER">
                                       @if($errors->has('phone'))
                                            <span class="help-block">
                                                {{ $errors->first('phone') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="address" class="form-control" placeholder="ADDRESS">
                                        @if($errors->has('address'))
                                            <span class="help-block">
                                                {{ $errors->first('address') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="E-MAIL">
                                        @if($errors->has('email'))
                                            <span class="help-block">
                                                {{ $errors->first('email') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--
                        <!-- <button type="button" class="common-black-btn">Confirm Payment Details</button> -->
                        --}}
                </div>

                 @if($products != null)
                    <div class="step-3 form-step" id="paymentDiv">
                        <div class="title-block">
                            <h2><span>2/2 Confirm</span></h2>
                        </div>
                        <div class="table-responsive">
                            <table width="100%" class="checkout-list">
                                <tbody>
                                @foreach($products as $product)
                                    @if($product->product != null)
                                    <tr>
                                        <td class="cart-items" >
                                            <div class="cart-single-item">
                                                <div class="cart-single-item_image">
                                                    <a href="{{ route('product.show',$product->product->slug) }}"></a>
                                                    @if($product->color_id != null && $product->color != null)
                                                        <img src="{{ generateURL($product->color->image) }}" alt="product">
                                                    @else
                                                        <img src="{{ generateURL($product->product->image) }}" alt="product">
                                                    @endif
                                                </div>
                                                <div class="cart-single-item_detail">
                                                    <h4>
                                                        <a href="{{ route('product.show',$product->product->slug) }}">{{ $product->product->getTitle() }}</a>
                                                    </h4>
                                                    <p class="product-price">AED {{ $product->product->order_amount }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="qty" >
                                            <ul>
                                                <li>QTY</li>
                                                <li>
                                                    <div class="cart-quantity">
                                                        <span class="minus" min="{{ $product->product->minimum_qty }}" data-color_id="{{ $product->color_id }}" data-product_id="{{ $product->product->id }}" data-minqty="{{ $product->product->minimum_qty }}" data-custom_id ="{{ $product['custom_id'] }}">-</span>
                                                        
                                                        <input type="number" class="product-qty" name="quantity" min="{{ $product->product->minimum_qty }}"
                                                         max="{{ $product->product->total_stock }}" value="{{ $product->quantity }}" data-error-container="#quantity-error" style="width: 100px;" readonly="true">                                                                                                        
                                                        <span class="plus" data-custom_id="{{ $product->custom_id }}" data-color_id="{{ $product->color_id }}" data-product_id="{{ $product->product->id }}" data-maxqty="{{ $product->product->total_stock }}">+</span>
                                                    </div>
                                                    <span id="quantity-error"></span>
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="remove-prod" >
                                            <a href="javascript:;" class="remove_product" data-custom_id="{{ $product->custom_id }}" data-product_id="{{ $product->product->id }}" data-color="{{ $product->color_id }}" data-quantity="{{ $product->quantity }}">Remove</a>
                                        </td>
                                        <td class="btn-message" >
                                            @if($product->color_id != null && $product->color != null)
                                                <a href="#" class="btn-outline btn-AddGiftMessage" data-toggle="modal" data-cart_id="{{ $product->id }}" data-product_id="{{ $product->product_id }}" data-color_id="{{ $product->color_id }}" data-target="#add-message">Add Gift Message</a>
                                            @else
                                                <a href="#" class="btn-outline btn-AddGiftMessage" data-toggle="modal" data-cart_id="{{ $product->id }}" data-product_id="{{ $product->product_id }}" data-target="#add-message">Add Gift Message</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @elseif($product->addon != null)
                                    <tr>
                                        <td class="cart-items" >
                                            <div class="cart-single-item">
                                                <div class="cart-single-item_image">
                                                    <img src="{{ generateURL($product->addon->getImage()) }}" alt="addon">
                                                </div>
                                                <div class="cart-single-item_detail">
                                                    <h4>
                                                        {{ $product->addon->getTitle() }}
                                                    </h4>
                                                    <p class="product-price">AED {{ $product->addon->price }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="qty" >
                                            <ul>
                                                <li>QTY</li>
                                                <li>
                                                    <div class="cart-quantity">
                                                        <span class="minus" min="1" data-color_id="{{ $product->color_id }}" data-product_id="{{ $product->addon->id }}" data-minqty="1" data-custom_id ="{{ $product->custom_id }}">-</span>
                                                        
                                                        <input type="number" class="product-qty" name="quantity" min="1"
                                                         max="{{ $product->addon->total_stock }}" value="{{ $product->quantity }}" data-error-container="#quantity-error" style="width: 100px;" readonly="true">                                                                                                        
                                                        <span class="plus" data-custom_id="{{ $product->custom_id }}" data-color_id="{{ $product->color_id }}" data-product_id="{{ $product->addon->id }}" data-maxqty="{{ $product->addon->total_stock }}">+</span>
                                                    </div>
                                                    <span id="quantity-error"></span>
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="remove-prod" >
                                            <a href="javascript:;" class="remove_product" data-custom_id="{{ $product->custom_id }}" data-product_id="{{ $product->addon->id }}" data-color="{{ $product->color_id }}" data-quantity="{{ $product->quantity }}">Remove</a>
                                        </td>
                                        <td class="btn-message" >
                                            <a href="#" class="btn-outline btn-AddGiftMessage" data-toggle="modal" data-cart_id="{{ $product->id }}" data-product_id="{{ $product->addon->id }}" data-target="#add-message">Add Gift Message</a>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                         <div class="row">
                            <div class="col-md-6">
                                <div class="form-group input-focused">
                                    <label>Delivery Date</label>
                                    <input type="text" name="delivery_date" class="form-control datepicker">
                                    @if($errors->has('delivery_date'))
                                        <span class="error-help">{{ $errors->first('delivery_date') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group input-focused">
                                    <label>Delivery Time</label>
                                    <select class="form-select" name="delivery_time" data-error-container="#delivery_time-error">
                                        <option class="hideme" value="">Select Time</option>
                                        @if($delivery_times != null && $delivery_times != '[]')
                                            @foreach($delivery_times as $delivery_time)
                                                <option value="{{  $delivery_time->getTime() }}">{{ $delivery_time->getTime() }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span id="delivery_time-error"></span>
                                    @if($errors->has('delivery_time'))
                                        <span class="error-help">{{ $errors->first('delivery_time') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group input-focused desc" data-char="0/1000">
                                    <label>Delivery Comments</label>
                                    <textarea class="form-control" name="delivery_comment" placeholder="Delivery Message" rows="10"></textarea>
                                    @if($errors->has('delivery_comment'))
                                        <span class="error-help">{{ $errors->first('delivery_comment') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if($gift_message != null)
                            <button id="btn-show-gift" type="submit" class="common-black-btn">Place Order</button>
                        @else
                            <button id="btn-show-gift" class="common-black-btn" data-toggle="modal" data-target="#show-gift">Place Order</button>
                        @endif
                    </div>
                </form>
            @endif

            </div>
            <div class="col-xl-3">
                <div class="order-summary" id="orderSummary">
                        <div class="order-summary-inner">
                            <div class="order-summary_figure">
                                <ul>
                                    <li>
                                        <img src="{{ asset('frontend/images/order-cart-icon.svg') }}" alt="cart">
                                    </li>
                                    <li>
                                        <img src="{{ asset('frontend/images/order-delivery-icon.svg') }}" alt="delivery">
                                    </li>
                                    <li>
                                        <img src="{{ asset('frontend/images/order-checkout-icon.svg') }}" alt="checkout">
                                    </li>
                                </ul>
                            </div>
                            <div class="title-block">
                                <h4><span>Order Summary</h4>
                            </div>
                            <table width="100%">
                                <tr>
                                    <td>Subtotal</td>
                                    <td id="subTotal">AED {{ $subTotal }}</td>
                                </tr>
                                <tr>
                                    <td>Delivery</td>
                                    <td id="delivery_charge">AED {{ $delivery_charge }}</td>
                                </tr>
                                <tr>
                                    <td>VAT</td>
                                    <td id="vat">AED {{ $vat }}</td>
                                </tr>
                                <tr class="table-divider">
                                    <td height="1" colspan="2" style="background-color: rgba(112,112,112,0.34);"></td>
                                </tr>
                                <tr>
                                    <td height="20" colspan="2"></td>
                                </tr>
                                <tr class="total">
                                    <td>Total</td>
                                    <td id="total">AED {{ $total }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="notes">
                            <div class="title-block">
                                <h4>Notes:</h4>
                            </div>
                            <p>Refund Notes:
                            Our floral design team will assist you to create your bespoke floral arrangements to suit your business expectation.</p>
                            <p>Cancellation Notes:
                            Our floral design team will assist you to create your bespoke floral arrangements to suit your business expectation.</p>
                        </div>
                </div>
            </div>
        </div>
    </article>
</section>
@endsection


@push('top-css')
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap-datetimepicker.css') }}">
@endpush

@push('extra-js')
<script type="text/javascript" src="{{ asset('frontend/js/jquery.inputmask.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/moment-with-locales.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/bootstrap-datetimepicker.js') }}"></script>

<script src="{{ asset('admin/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('admin/js/custom_validations.js') }}"></script>


     <script type="text/javascript">
       $(document).ready(function () {
            var customSelect = $('select:not(.cart-select)');
            // Options for custom Select
            jcf.setOptions('Select', {
                wrapNative: false,
                wrapNativeOnMobile: false,
                fakeDropInBody: false
            });
            jcf.replace(customSelect);
            jcf.refresh();
            //checkbox
            $('.check-status .form-check-input').change(function(){
                if($(this).is(':checked')){
                    $(this).closest('.form-check-block').find('.form-check').children('.check-status').removeClass('checked');
                    $(this).parent().addClass('checked');
                }
                else{
                    $(this).parent().removeClass('checked');
                }
            });

            // datepicker and timepicker
            $('.datepicker').datetimepicker({
                format: 'L',
                icons: {
                    previous: "fa fa-chevron-left",
                    next: "fa fa-chevron-right"
                },
                minDate: new Date(),
                useCurrent: false
            }).val("Choose Date");
            // $('.datepicker').on('dp.hide', function() {
            //     $('.datepicker').val("Choose Date");
            // });
            $('.datepicker').on('dp.change', function() {
                if($('.datepicker').val() == ""){
                    $(this).parent().addClass('input-focused')
                }
            });

            $('.timepicker').datetimepicker({
                format: 'LT',
                icons: {
                    up: "fa fa-chevron-up",
                    down: "fa fa-chevron-down"
                }
            }).val("Choose Time");
            // $('.timepicker').on('dp.hide', function () {
            //     $('.timepicker').val("Choose Time");
            // });
             $('.timepicker').on('dp.change', function () {
                if ($('.timepicker').val() == "") {
                    $(this).parent().addClass('input-focused')
                }
            });

            // form select
            $('.form-select').on('focus',function () {
                $(this).parents('.form-group').addClass('input-focused');
            }).on('focusout',function(){
                if($(this).children('option').is(':selected')){
                    $(this).parents('.form-group').addClass('input-focused');
                }
                else{
                    $(this).parents('.form-group').removeClass('input-focused');
                }
            });

          // radio check
          $('.modal .form-check label').click(function(){
            $('.check-status .form-check-input').removeAttr('checked');
            $('.check-status .form-check-input').parent().removeClass('checked');
            $(this).siblings('.check-status > input').attr('checked', 'checked');
            $(this).siblings('.check-status').addClass('checked');
          });
          $('.modal .check-status .form-check-input').change(function(){
              $('.check-status .form-check-input').removeAttr('checked');
              $('.check-status .form-check-input').parent().removeClass('checked');
              $(this).attr('checked','checked');
              $(this).parent().addClass('checked');
          });

          // billing address
          var billing_checked = $('.billing-address .check-status .form-check-input').is(':checked');
          if(billing_checked == false){
              $('.change-delivery-address').show();
          }
          else{
              $('.change-delivery-address').hide();
          }
          $('.billing-address .check-status .form-check-input').change(function(){
             billing_checked = ! billing_checked;
             if (billing_checked == false) {
                  $('.change-delivery-address').show();
             }
             else {
                 $('.change-delivery-address').hide();
             }
          });

          // open saved items
          $('.open-saved-items').click(function(){
            $(this).parents('.saved-item').toggleClass('active');
            $(this).parents('ul').siblings('.other-saved-items').slideToggle();
          });

            //Select Delivery Address
            $(".select-address").on('click',function(){
                var id              =   $(this).data('id');
                var first_name      =   $(this).data('first_name');
                var last_name       =   $(this).data('last_name');
                var city            =   $(this).data('city');
                var country         =   $(this).data('country');
                var address         =   $(this).data('address');
                var pincode         =   $(this).data('pincode');

                $("#selected-address").closest(".saved-items_detail").remove();
                $("#selected-address").replaceWith(
                    '<li id="selected-address">'+
                        '<div class="saved-items_detail">'+
                            '<strong>'+first_name+' '+last_name+'</strong>'+
                            '<address>'+address+'</address>'+
                            '<p>'+city+', '+country+'</p>'+
                            '<p>'+pincode+'</p>'+
                        '</div>'+
                    '</li>'
                );
                $(this).closest(".other-saved-items").css('display','none');

                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    url: "{{ route('change.default.address') }}",
                    data: {
                            _token      : '{{ csrf_token() }}',
                            id          : id,
                        },
                        success: function(Response){
                            if(Response.success){
                                $("#subTotal").replaceWith(Response.subTotal);
                                $("#delivery_charge").replaceWith(Response.delivery_charge);
                                $("#vat").replaceWith(Response.vat);
                                $("#total").replaceWith(Response.total);
                            }
                            if(Response.fail){
                                location.reload();
                            }
                        },
                    });
                });

            $(document).on("click",".btninner",function(){
                $('#addressBtn').show();
                  jcf.refresh(customSelect);

                    //Change City Based On Country(Emirate) Selection
                    $('#checkout_country').change(function(){
                        $.ajax({
                            type: 'POST',
                            dataType: 'JSON',
                            url: "{{ route('country.getcity') }}",
                            data: {
                                _token      : '{{ csrf_token() }}',
                                country_id  : function(){
                                    return $("#checkout_country").val();
                                },
                            },
                            beforeSend: function() {
                                showLoader();
                            },
                            success: function(Response){
                                if(Response.success){
                                    var cities = JSON.parse(Response.cities);

                                    $("#checkout_city").empty();
                                    $("#checkout_city").append('<option value="" selected>SELECT CITY</option>');
  
                                    $(cities).map((id,city) => {
                                        $("#checkout_city").append('<option value='+city['id']+'>'+city['city_name']+'</option>');
                                    });
                                }
                                if(Response.fail){
                                    $("#checkout_city").empty();
                                    $("#checkout_city").append('<option value="" selected>SELECT CITY</option>');
                                }  
                            },
                            complete: function() {
                                removeLoader();
                            },
                        });
                    });
                  
              $(this).remove();
           });
        });
    </script>

    <script type="text/javascript">

    $(document).on("click",".btnclose",function(){
        $("#addressBtn").hide();        
        $("#addAddress").replaceWith('<div id="addAddress">'+
                                '<a href="javascript:;" id="btnAddAddress" class="add-new address btninner">+ Add a new address</a>'+
                            '</div>');

     });

        //Change City Based On Country(Emirate) Selection (IN BILLING ADDRESS)
        $('#billing_country').change(function(){
            $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    url: "{{ route('country.getcity') }}",
                    data: {
                            _token      : '{{ csrf_token() }}',
                            country_id  : function(){
                                return $("#billing_country").val();
                            },
                        },
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(Response){
                        if(Response.success){
                            var cities = JSON.parse(Response.cities);

                            $("#billing_city").empty();
                            $("#billing_city").append('<option value="" selected>SELECT CITY</option>');

                            $(cities).map((id,city) => {
                                $("#billing_city").append('<option value='+city['id']+'>'+city['city_name']+'</option>');
                            });
                        }
                        if(Response.fail){
                            $("#billing_city").empty();
                            $("#billing_city").append('<option value="" selected>SELECT CITY</option>');
                        }
                    },
                    complete: function() {
                        removeLoader();
                    },
            });
        });


        // Product Remove From Checkout Page
        $('.remove_product').on('click',function(){
            var element    = $(this);
            var custom_id  = $(this).data('custom_id');
            var product_id = $(this).data('product_id');
            var color      = $(this).data('color');
            var quantity   = $(this).data('quantity');

            $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    url: "{{ route('remove.checkout.product') }}",
                    data: {
                         _token: '{{ csrf_token() }}',
                         custom_id  : custom_id,
                         product_id : product_id,
                         color      : color,
                         quantity   : quantity,
                    },
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(Response){
                        if(Response.success){
                            $('#header').replaceWith(Response['header']);
                            $('#subTotal').replaceWith(Response.subTotal);
                            $('#delivery_charge').replaceWith(Response.delivery_charge);
                            $("#vat").replaceWith(Response.vat);
                            $("#total").replaceWith(Response.total);
                            element.closest('tr').remove();

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

                            $('.header-content_inner > ul > li:not(.wishlist)').click(function () {
                                $(this).toggleClass('show')
                            });
                        }
                        if(Response.fail){
                            location.reload();
                        }
                    },
                    complete: function() {
                        removeLoader();
                    },
                });
         });


        $("#frmDeliveryAddress").validate({
            rules: {
                first_name_delivery:{
                    required:true,
                    not_empty:true,
                    maxlength:255,
                },
                last_name_delivery:{
                    required:true,
                    not_empty:true,
                    maxlength:255,
                },
                country_delivery:{
                    required:true,
                    not_empty:true,
                    maxlength:255,
                },
                city_delivery:{
                    required:true,
                    not_empty:true,
                    maxlength:255,
                },
                address_delivery:{
                    required:true,
                    not_empty:true,
                    maxlength:255,
                },
                pincode_delivery:{
                    required:true,
                    not_empty:true,
                    pattern: /^(\d+)(?: ?\d+)*$/,
                    minlength:6,
                    maxlength:10,
                },
                contact_delivery:{
                    required:true,
                    not_empty:true,
                    pattern: /^(\d+)(?: ?\d+)*$/,
                    minlength:8,
                    maxlength:16,
                },
            },
            messages: {
                first_name_delivery:{
                    required:"@lang('validation.required',['attribute'=>'first name'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'first name'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'first name','max'=>255])",
                },
                last_name_delivery:{
                    required:"@lang('validation.required',['attribute'=>'last name'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'last name'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'last name','max'=>255])",
                },
                country_delivery:{
                    required:"@lang('validation.required',['attribute'=>'emirate'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'emirate'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'emirate','max'=>255])",
                },
                city_delivery:{
                    required:"@lang('validation.required',['attribute'=>'city'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'city'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'city','max'=>255])",
                },
                address_delivery:{
                    required:"@lang('validation.required',['attribute'=>'address'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'address'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'address','max'=>255])",
                },
                pincode_delivery:{
                    required:"@lang('validation.required',['attribute'=>'pincode'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'pincode'])",
                    pattern:"The pincode must be a number.",
                    minlength:"@lang('validation.min.string',['attribute'=>'pincode','min'=>6])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'pincode','max'=>10])",
                },
                contact_delivery:{
                    required:"@lang('validation.required',['attribute'=>'phone number'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'phone number'])",
                    pattern:"The phone number must be a number.",
                    minlength:"@lang('validation.min.string',['attribute'=>'phone number','min'=>8])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'phone number','max'=>16])",
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

        $("#frmCheckout").validate({
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
                address:{
                    required:true,
                    not_empty:true,
                    maxlength:255,
                },
                city:{
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
                phone:{
                    required:true,
                    not_empty:true,
                    pattern: /^(\d+)(?: ?\d+)*$/,
                    minlength:6,
                    maxlength:10,
                },
                country:{
                    required:true,
                    not_empty:true,
                    maxlength:255,
                },
                email:{
                    required:true,
                    not_empty:true,
                    email:true,
                },
                delivery_date:{
                    required:true,
                    not_empty:true,
                    date:true,
                },
                delivery_time:{
                    required:true,
                    not_empty:true,
                },
                delivery_comment:{
                    required:false,
                    not_empty:false,
                    maxlength:1000,
                },
                username:{
                    required:true,
                    not_empty:true,
                    maxlength:255,
                },
                delivery_address:{
                    required:true,
                    not_empty:true,
                    maxlength:255,
                },
                delivery_pincode:{
                    required:true,
                    not_empty:true,
                    pattern: /^(\d+)(?: ?\d+)*$/,
                    minlength:6,
                    maxlength:10,
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
                address:{
                    required:"@lang('validation.required',['attribute'=>'address'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'address'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'address','max'=>255])",
                },
                city:{
                    required:"@lang('validation.required',['attribute'=>'city'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'city'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'city','max'=>255])",
                },
                pincode:{
                    required:"@lang('validation.required',['attribute'=>'pincode'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'pincode'])",
                    pattern:"The pincode must be a number.",
                    minlength:"@lang('validation.min.string',['attribute'=>'pincode','min'=>6])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'pincode','max'=>10])",
                },
                phone:{
                    required:"@lang('validation.required',['attribute'=>'phone'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'phone'])",
                    pattern:"The phone must be a number.",
                    minlength:"@lang('validation.min.string',['attribute'=>'phone','min'=>6])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'phone','max'=>10])",
                },
                country:{
                    required:"@lang('validation.required',['attribute'=>'emirate'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'emirate'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'emirate','max'=>255])",
                },
                email:{
                    required:"@lang('validation.required',['attribute'=>'email'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'email'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'email','max'=>255])",
                },
                delivery_date:{
                    required:"@lang('validation.required',['attribute'=>'delivery date'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'delivery date'])",
                    date:"@lang('validation.date',['attribute'=>'date'])",
                },
                delivery_time:{
                    required:"@lang('validation.required',['attribute'=>'delivery time'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'delivery time'])",
                },
                delivery_comment:{
                    required:"@lang('validation.required',['attribute'=>'comment'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'comment'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'comment','max'=>1000])",
                },
                username:{
                    required:"@lang('validation.required',['attribute'=>'username'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'username'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'username','max'=>255])",
                },
                delivery_address :{
                    required:"@lang('validation.required',['attribute'=>'address'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'address'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'address','max'=>255])",
                },
                delivery_pincode:{
                    required:"@lang('validation.required',['attribute'=>'pincode'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'pincode'])",
                    pattern:"The pincode must be a number.",
                    minlength:"@lang('validation.min.string',['attribute'=>'pincode','min'=>6])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'pincode','max'=>10])",
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


        $('.minus').click(function () {
            var min_purchase_qty = $(this).data('minqty');

            if ($(this).is('[disabled=disabled]') == true) {
                return false;
            }
            var $input = $(this).parent().find('input');
            var count = parseInt($input.val()) - 1;
            if (count == 1 || count <= min_purchase_qty) {
                $(this).attr('disabled', 'disabled');
                $(this).css('cursor', 'not-allowed');
            }
            $('.plus').attr('disabled', false);
            $('.plus').css('cursor', 'pointer');

            if($input.val() > min_purchase_qty){  

                // count = count < 1 ? 1 : count;
                $input.val(count);
                $input.change();

                //Code
                var element    = $(this);
                var quantity   = $(this).siblings('.product-qty').val();
                var product_id = $(this).data('product_id');
                var color_id   = $(this).data('color_id');
                var custom_id  = $(this).data('custom_id');

                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    url: "{{ route('product.change.quantity') }}",
                    data: {
                         _token: '{{ csrf_token() }}',
                         product_id : product_id,
                         custom_id  : custom_id,   
                         color_id   : color_id,
                         quantity   : quantity,
                    },
                    success: function(Response){
                        if(Response.success){
                            $('#header').replaceWith(Response.header);
                            $('#subTotal').replaceWith(Response.subTotal);
                            $('#delivery_charge').replaceWith(Response.delivery_charge);
                            $("#vat").replaceWith(Response.vat);
                            $("#total").replaceWith(Response.total);   

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

                            $('.header-content_inner > ul > li:not(.wishlist)').click(function () {
                                $(this).toggleClass('show')
                            });
                        }
                        if(Response.fail){
                            location.reload();
                        }
                        if(Response[0]){
                            location.reload();
                        }
                    },
                });
            }
        });


        $('.plus').click(function () { 
            var max_purchase_qty    = $(this).data('maxqty'); 
            var $input              = $(this).parent().find('input');
            var count               = parseInt($input.val()) + 1;

            if (count > 1) {
                $('.minus').attr('disabled', false);
                $('.minus').css('cursor', 'pointer');
            }

            if (count > max_purchase_qty){
                $(this).attr('disabled', true);
                $(this).css('cursor', 'not-allowed');
                return false;
            }

            $input.val(count);
            $input.change();

            //Code
            var element    = $(this);
            var quantity   = $(this).siblings('.product-qty').val();
            var product_id = $(this).data('product_id');
            var color_id   = $(this).data('color_id');
            var custom_id  = $(this).data('custom_id');
            
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: "{{ route('product.change.quantity') }}",
                data: {
                     _token: '{{ csrf_token() }}',
                     product_id : product_id,
                     custom_id  : custom_id,   
                     color_id   : color_id,
                     quantity   : quantity,
                },
                success: function(Response){
                    if(Response.success){
                        $('#header').replaceWith(Response.header);
                        $('#subTotal').replaceWith(Response.subTotal);
                        $('#delivery_charge').replaceWith(Response.delivery_charge);
                        $("#vat").replaceWith(Response.vat);
                        $("#total").replaceWith(Response.total);   

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

                        $('.header-content_inner > ul > li:not(.wishlist)').click(function () {
                            $(this).toggleClass('show')
                        });
                    }
                    if(Response.fail){
                        location.reload();
                    }
                    if(Response[0]){
                        location.reload();
                    }
                },
            });

        });

        // Product qty change in Checkout Page(When User Login)
        // $('.product_qty').on('change',function(){
        //     var element     =    $(this);
        //     var quantity    =    $(this).val();
        //     var product_id  =    $(this).data('product_id');
        //     var custom_id   =    $(this).data('custom_id');
         
        //     $.ajax({
        //         type: 'POST',
        //         dataType: 'JSON',
        //         url: "{{ route('product.change.quantity') }}",
        //         data: {
        //             _token      :   '{{ csrf_token() }}',
        //             product_id  :   product_id,
        //             custom_id   :   custom_id,
        //             quantity    :   quantity,
        //         },
        //         success: function(Response){
        //             if(Response.success){
        //                 $('#header').replaceWith(Response['header']);
        //                 $('#subTotal').replaceWith(Response['subTotal']);
        //                 $('#delivery_charge').replaceWith(Response['delivery_charge']);
        //                 $("#vat").replaceWith(Response.vat);
        //                 $("#total").replaceWith(Response.total);

        //                 //Country(select)
        //                 customSelect = $('select');
        //                 // Options for custom Select
        //                 jcf.setOptions('Select', {
        //                     wrapNative: false,
        //                     wrapNativeOnMobile: false,
        //                     fakeDropInBody: false
        //                 });
        //                 jcf.replace(customSelect);
        //                 jcf.refresh();

        //                 $('.header-content_inner > ul > li:not(.wishlist)').click(function () {
        //                     $(this).toggleClass('show')
        //                 });
        //             }
        //             if(Response.fail){
        //                 location.reload();
        //             }
        //         },
        //     });
        //  });

        // Save User Address
        $('#btn-address').on('click',function(e){
            e.preventDefault();
            if( $("#frmDeliveryAddress").valid() ){
                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        url: "{{ route('user.address') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            first_name : function(){
                                return $("#checkout_first_name").val();
                            }, 
                            last_name : function(){
                                return $("#checkout_last_name").val();
                            },
                            emirate: function(){
                                return $("#checkout_country").val();
                            }, 
                            city: function(){
                                return $("#checkout_city").val();
                            },
                            address : function(){
                                return $("#checkout_address").val();
                            },
                            pincode: function(){
                                return $("#checkout_pincode").val();
                            },
                            contact: function(){
                                return $("#checkout_contact").val();
                            },
                        },
                        success: function(Response){
                            if(Response.success){
                                $(".child").remove();
                                $("#btn-address").remove();
                                location.reload();
                            }
                        },
                    });
                $("input[type=submit], input[type=button], button[type=submit]").prop("disabled", "disabled");
           }
           else{
                return false;
            }
         });

        //FOR GIFT MESSAGE
        $(".btn-AddGiftMessage").on('click',function(e){
            e.preventDefault();
            var cart_id    =  $(this).data('cart_id');
            var product_id =  $(this).data('product_id');
            var color_id   =  $(this).data('color_id');

            if(color_id == undefined){
                color_id = null;
            }

            $("#gift_message_cart_id").replaceWith('<input type="hidden" id="gift_message_cart_id" name="cart_id" value="'+cart_id+'">');
            $("#gift_message_product_id").replaceWith('<input type="hidden" id="gift_message_product_id" name="product_id" value="'+product_id+'">');
            $("#gift_message_color_id").replaceWith('<input type="hidden" id="gift_message_color_id" name="color_id" value="'+color_id+'">');

            $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('getgiftmessage') }}",
                    data: {
                         _token :   '{{ csrf_token() }}',
                        cart_id :   cart_id,
                    },
                    success: function(Response){
                        if(Response.success){
                            var cart = JSON.parse(Response.cart);
                            if(cart['message'] != null){
                                $("#gift_message").replaceWith('<textarea class="form-control" name="message" id="gift_message" placeholder="{{ __("Description") }}" rows="6">'+cart['message']+'</textarea>');
                            }else{
                                $("#gift_message").replaceWith('<textarea class="form-control" name="message" id="gift_message" placeholder="{{ __("Description") }}" rows="6"></textarea>');    
                            }
                        }
                        if(Response.fail){
                            $("#gift_message").replaceWith('<textarea class="form-control" name="message" id="gift_message" placeholder="{{ __("Description") }}" rows="6"></textarea>');
                        }
                    },
                });
        });
    </script>

@endpush
