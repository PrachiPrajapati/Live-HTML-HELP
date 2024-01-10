@extends('frontend.layouts.app')

@section('main-content')

<!-- cart section -->
<section class="cart-section common-spacing">
    <article class="container">
        <form class="common-form" id="formUserDetails" method="POST" action="{{ route('product-confirmation') }}">
        @csrf
            <div class="row">
                <div class="col-xl-9">
                    <div class="step-1 form-step">
                        <div class="title-block">
                            <h2><span>1/2 Delivery</span><a href="javascript:;"><i class="fa fa-chevron-right"></i></a></h2>
                        </div>
                            <div class="before-fill">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}">
                                            @if($errors->has('first_name'))
                                                <span class="error-help">{{ $errors->first('first_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}">
                                            @if($errors->has('last_name'))
                                                <span class="error-help">{{ $errors->first('last_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
                                            @if($errors->has('address'))
                                                <span class="error-help">{{ $errors->first('address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Postal Code / Zip</label>
                                            <input type="text" name="pincode" id="pincode" class="form-control" value="{{ old('pincode') }}">
                                            @if($errors->has('pincode'))
                                                <span class="error-help">{{ $errors->first('pincode') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input type="text" name="contact" id="contact" class="form-control" value="{{ old('contact') }}">
                                            @if($errors->has('contact'))
                                                <span class="error-help">{{ $errors->first('contact') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>E-mail</label>
                                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                                            @if($errors->has('email'))
                                                <span class="error-help">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Emirate</label>
                                            <select class="form-select" id="guest_checkout_country" name="emirate" data-error-container="#guest-emirate-error">
                                                <option value="">SELECT EMIRATE</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->getName() }}</option>
                                                @endforeach
                                                </select>
                                            <span id="guest-emirate-error"></span>
                                            @if($errors->has('emirate'))
                                                <span class="error-help">{{ $errors->first('emirate') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>City</label>
                                            <select class="form-select" id="guest_chechout_city" name="city" data-error-container="#city-error"> 
                                                <option value="">SELECT CITY</option>
                                            </select>
                                            <span id="city-error"></span>
                                            @if($errors->has('city'))
                                                <span class="error-help">{{ $errors->first('city') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                {{-- <!-- <button type="button" id="btn-address" class="common-black-btn">Confirm Delivery Address</button> --> --}}
                            </div>
                            <div class="after-fill">
                                <p><strong>Name</strong> <strong>Surname</strong>, Address, City, Postal Code</p>
                            </div>
                    </div>

                    @if($products != null)
                        <div class="step-3 form-step">
                            <div class="title-block">
                                <h2><span>2/2 Message</span></h2>
                            </div>
                            <div class="table-responsive">
                                <table width="100%" class="checkout-list">
                                    <tbody>
                                        @foreach($products as $product)
                                        <tr>
                                            <td width="45%">
                                                <div class="cart-single-item">
                                                    <div class="cart-single-item_image">
                                                        <a href="{{ route('product.show',$product->slug) }}"></a>
                                                        <img src="{{ generateURL($product->image) }}" alt="product">
                                                    </div>
                                                    <div class="cart-single-item_detail">
                                                        <h4>
                                                            <a href="{{ route('product.show',$product->slug) }}">{{ $product->getEnglishTitle() }}</a>
                                                        </h4>
                                                        <p class="product-price">AED {{ $product->order_amount }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td width="20%">
                                                <ul>
                                                    <li>QTY</li>
                                                    <li>
                                                        @if($product->color_id != null)
                                                        <select class="form-select cart-select product_qty" name="quantity" data-custom_id="{{ $product->custom_id }}" data-color_id="{{ $product->color_id }}" data-product_id="{{ $product->id }}">
                                                        @else
                                                        <select class="form-select cart-select product_qty" name="quantity" data-custom_id="{{ $product->custom_id }}" data-product_id="{{ $product->id }}">
                                                        @endif
                                                            @for($i = $product->minimum_qty; $i <= $product->total_stock; $i++)
                                                                @if($i == $product->quantity)
                                                                    <option value="{{ $i }}" selected>{{ $i }}</option>
                                                                @else
                                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                                @endif
                                                            @endfor
                                                        </select>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td width="10%">
                                                @if($product->color_id != null)
                                                    <a href="javascript:;" class="remove_product" data-product_id="{{ $product->id }}" data-color_id="{{ $product->color_id }}" data-custom_id="{{ $product->custom_id }}">Remove</a>
                                                @else
                                                    <a href="javascript:;" class="remove_product" data-product_id="{{ $product->id }}" data-custom_id="{{ $product->custom_id }}">Remove</a>
                                                @endif
                                            </td>
                                            <td width="20%">
                                                @if($product->color_id != null)
                                                    <a href="#" class="btn-outline btn-AddGiftMessage" data-toggle="modal" data-custom_id="{{ $product->custom_id }}" data-product_id="{{ $product->id }}" data-quantity="{{ $product->quantity }}" data-color_id="{{ $product->color_id }}" data-target="#add-message">Add Gift Message</a>
                                                @else
                                                    <a href="#" class="btn-outline btn-AddGiftMessage" data-toggle="modal" data-custom_id="{{ $product->custom_id }}" data-product_id="{{ $product->id }}" data-quantity="{{ $product->quantity }}" data-target="#add-message">Add Gift Message</a>
                                                @endif
                                            </td>
                                        </tr>
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
                                            <option hidden selected disabled>Select Time</option>
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
                                    <div class="form-group input-focused desc" data-char="0/500">
                                        <label>Delivery Comments</label>
                                        <textarea class="form-control" name="delivery_comment" placeholder="Delivery Message" rows="8"></textarea>
                                        @if($errors->has('delivery_comment'))
                                            <span class="error-help">{{ $errors->first('delivery_comment') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="common-black-btn">Place Order</button>
                        </div>
                    @endif
                </div>   
                <div class="col-xl-3">
                    <div class="order-summary">
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
                                    <h4>Order Summary</h4>
                                </div>
                                <table width="100%">
                                    <tr>
                                        <td>Subtotal</td>
                                        <td id="subTotal">AED {{ $subTotal }}</td>
                                    </tr>
                                    <tr>
                                        <td>Delivery</td>
                                        <td id="charges">AED 0.00</td>
                                    </tr>
                                    <tr>
                                        <td>VAT</td>
                                        <td id="vat">{{ $vat }} %</td>
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
        </form>
    </article>
</section>
@endsection

@push('top-css')
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap-datetimepicker.css') }}">
@endpush

@push('extra-js')
<script type="text/javascript" src="{{ asset('frontend/js/jquery.inputmask.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/jcf.scrollable.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/moment-with-locales.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/bootstrap-datetimepicker.js') }}"></script>
<script>
    $(document).ready(function () {

        // select 
        $(function () {
            var customSelect = $('select:not(.cart-select)');
            // Options for custom Select
            jcf.setOptions('Select', {
                wrapNative: false,
                wrapNativeOnMobile: false,
                fakeDropInBody: false
            });
            jcf.replace(customSelect);
            jcf.refresh();

            // checkout list select
            var cartSelect = $('.checkout-list select');
            // Options for custom Select
            jcf.setOptions('Select', {
                wrapNative: false,
                wrapNativeOnMobile: false,
                fakeDropInBody: true
            });
            jcf.replace(cartSelect);
            jcf.refresh();
        });
      
        // form step filled
        $('.form-step:not(.step-3) .common-black-btn').click(function(){
            $(this).parent('.before-fill').slideToggle('slow');
            $(this).parent('.before-fill').siblings('.after-fill').slideToggle('slow');
            $(this).parent('.before-fill').siblings('.title-block').find('a').fadeIn();
            $('html,body').animate({ scrollTop: $(this).closest('.form-step').offset().top }, 'slow');
            return false; 
        });
        $('.form-step .title-block h2 a').click(function(){
            $(this).closest('.title-block').siblings('.before-fill,.after-fill').slideToggle('slow');
            $(this).hide();
        });
        //checkbox
        $('.check-status .form-check-input').change(function(){
            if($(this).is(':checked')){
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
        $(".step-1 .form-select").prepend("<option value='' selected='selected'></option>");
        $('.form-select').focus(function () {
            $(this).parents('.form-group').addClass('input-focused');
        }).blur(function(){
            if(!$(this)[0].selectedIndex == 0){
                $(this).parents('.form-group').addClass('input-focused');
            }
            else{
                $(this).parents('.form-group').removeClass('input-focused');
            }
        });

    });
   
</script>

<script src="{{ asset('admin/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('admin/js/custom_validations.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        //Login
        $("#formUserDetails").validate({
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
                contact:{
                    required:true,
                    not_empty:true,
                    pattern: /^(\d+)(?: ?\d+)*$/,
                    minlength:8,
                    maxlength:16,
                },
                delivery_date:{
                    required:true,
                    not_empty:true,
                    date:true,
                },
                emirate:{
                    required:true,
                    not_empty:true,
                    maxlength:255,
                },
                email:{
                    required:true,
                    not_empty:true,
                    email:true,
                },
                delivery_time:{
                    required:true,
                    not_empty:true,
                },
                delivery_comment:{
                    required:true,
                    not_empty:true,
                    maxlength:255,
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
                contact:{
                    required:"@lang('validation.required',['attribute'=>'phone number'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'phone number'])",
                    pattern:"The phone number must be a number.",
                    minlength:"@lang('validation.min.string',['attribute'=>'phone number','min'=>6])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'phone number','max'=>10])",
                },
                emirate:{
                    required:"@lang('validation.required',['attribute'=>'emirate'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'emirate'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'emirate','max'=>255])",
                },
                email:{
                    required:"@lang('validation.required',['attribute'=>'email'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'email'])",
                    email:"@lang('validation.email',['attribute'=>'email'])",
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
                    maxlength:"@lang('validation.max.string',['attribute'=>'comment','max'=>255])",
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

      
        //Change City Based On Country(emirate) Selection
        $('#guest_checkout_country').change(function(){

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: "{{ route('country.getcity') }}",
                data: {
                    _token      : '{{ csrf_token() }}',
                    country_id  : function(){
                        return $("#guest_checkout_country").val();
                    },
                },
                success: function(Response){
                    if(Response.success){
                        var cities = JSON.parse(Response.cities);
                        $("#guest_chechout_city").empty();
                        $("#guest_chechout_city").append('<option value="" selected>SELECT CITY</option>');

                        $(cities).map((id,city) => {
                            $("#guest_chechout_city").append('<option value='+city['id']+'>'+city['city_name']+'</option>');
                        });
                    }
                    if(Response.fail){
                        $("#guest_chechout_city").empty();
                        $("#guest_chechout_city").append('<option value="" selected>SELECT CITY</option>');
                    }
                },
            });
        });


        // City change in Checkout Page(When User Not Login)
        $('#guest_chechout_city').on('change',function(){
            var element    = $(this);
            var city       = $(this).val();
              $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        url: "{{ route('user.getcity') }}",
                        data: {
                             _token: '{{ csrf_token() }}',
                             city : city,
                        },
                        success: function(Response){
                            if(Response.success){
                                $('#subTotal').replaceWith(Response.subTotal);
                                $("#vat").replaceWith(Response.vat);
                                $("#total").replaceWith(Response.total);
                                $("#charges").replaceWith(Response.charges);
                            }
                            if(Response.fail){
                                location.reload();
                            }
                        },
                    });
         });

        // Product Qty change in Checkout Page(When User Not Login)
        $('.product_qty').on('change',function(){
            var element    = $(this);
            var quantity   = $(this).val();
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
                             color_id   : color_id,
                             custom_id  : custom_id,   
                             quantity   : quantity,
                        },
                        success: function(Response){
                            if(Response[0]){
                                location.reload();
                            }
                        },
                    });
         });


        // Product Remove From Checkout Page(When User Not Login)
        $('.remove_product').on('click',function(){
            var element    = $(this);
            var product_id = $(this).data('product_id');
            var color_id   = $(this).data('color_id');
            var custom_id  = $(this).data('custom_id');
              $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        url: "{{ route('remove-from-cart') }}",
                        data: {
                             _token: '{{ csrf_token() }}',
                             product_id : product_id,
                             color_id   : color_id,
                             custom_id  : custom_id,   
                        },
                        success: function(Response){
                            if(Response.success){
                                $('#header').replaceWith(Response['header']);
                                $('#subTotal').replaceWith(Response['subTotal']);
                                $("#vat").replaceWith(Response.vat);
                                $("#total").replaceWith(Response.total);
                                element.closest('tr').remove();
                            }
                            if(Response.cartEmpty)
                            {
                                $('#header').replaceWith(Response['header']);
                                $('#main_cart').replaceWith(Response['cartEmpty']);
                                $('#subTotal').replaceWith(Response['subTotal']);
                                $("#paymentDiv").remove();
                                element.closest('tr').remove();
                            }
                            if(Response.fail){
                                $('#product_error').replaceWith(Response['fail']);
                                location.reload();
                            }
                            if(Response[0]){
                                $('#header').replaceWith(Response[1]);
                                element.closest('tr').remove();
                                location.reload();
                            }
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
                        },
                    });
         });


        $('#formUserDetails').on('submit',function(){    
            if( $(this).valid() ) {
                $('.error-help').remove();
                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        url: "{{ route('payment') }}",
                        data: {
                             _token: '{{ csrf_token() }}',
                            first_name : function(){
                                return $("#first_name").val();
                            },
                            last_name: function(){
                                return $("#last_name").val();
                            },
                            address : function(){
                                return $("#address").val();
                            },
                            city: function(){
                                return $("#guest_chechout_city").val();
                            },
                            pincode: function(){
                                return $("#pincode").val();
                            },
                            contact : function(){
                                return $("#contact").val();
                            },
                            emirate: function(){
                                return $("#guest_checkout_country").val();
                            },
                            email : function(){
                                return $("#email").val();
                            },
                        },
                        success: function(Response){
                            if(Response.success){
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
        $(".btn-AddGiftMessage").on('click',function(){
            var custom_id   =  $(this).data('custom_id');
            var product_id  =  $(this).data('product_id');
            var quantity    =  $(this).data('quantity');
            var color_id    =  $(this).data('color_id');


            $("#gift_message_custom_id").replaceWith('<input type="hidden" id="gift_message_custom_id" name="custom_id" value="'+custom_id+'">');
            $("#gift_message_product_id").replaceWith('<input type="hidden" id="gift_message_product_id" name="product_id" value="'+product_id+'">');
            $("#gift_message_quantity").replaceWith('<input type="hidden" id="gift_message_quantity" name="quantity" value="'+quantity+'">');
            if(color_id != undefined){
                $("#gift_message_color_id").replaceWith('<input type="hidden" id="gift_message_color_id" name="color_id" value="'+color_id+'">');
            }else{
                $("#gift_message_color_id").replaceWith('<input type="hidden" id="gift_message_color_id" name="color_id" value="">');
            }
           
            $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('getgiftmessage') }}",
                    data: {
                        _token      :   '{{ csrf_token() }}',
                        product_id  :   product_id,
                        custom_id   :   custom_id,
                        color_id    :   color_id,
                    },
                    success: function(Response){
                        if(Response.success){
                            var message = JSON.parse(Response.message);
                            if(message['message'] != undefined){
                                $("#gift_message").replaceWith('<textarea class="form-control" name="message" id="gift_message" placeholder="{{ __("Description") }}" rows="6">'+message['message']+'</textarea>');
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
    }); 
</script>
@endpush