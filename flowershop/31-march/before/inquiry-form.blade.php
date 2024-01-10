@extends('frontend.layouts.app')

@push('banner-section')
<!--******************* Banner Section Start ******************-->
@if($banner != null)
<div class="banner d-flex align-items-center" style="background-image: url('{{ generateURL( $banner->getBannerImage() ) }}')">
    <div class="gradient-overlay"></div>
    <div class="container pos-rel">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <h1>{{ $banner->getTitle() }}</h1>
                <p>{!! $banner->getDescription() !!}</p>
            </div>
        </div>
    </div>
</div>
@endif
<!--******************* Banner Section End ******************-->
@endpush

@section('main-content')

<!-- Inquiry Form section -->
<section class="common-spacing">
    <article class="container">
        <form class="common-form" id="frmServiceInquiry" method="POST" action="{{ route('service.inquiry.save') }}">
            @csrf
            <div class="row">
                <div class="step-1 form-step">
                    <div class="title-block">
                        <h2><span>EVENT INQUIRY FORM</span><a href="javascript:;"><i class="fa fa-chevron-right"></i></a></h2>
                    </div>
                    <p>We would like to know more about you and your plans for your big day, so that we can help make it special and unique.</p>
                    <div class="inquiry-form-sec">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group input-focused">
                                    <label>Event Type</label>
                                    <select class="form-select" id="event_type" name="event_type" data-error-container="#event-type-error">
                                        <option class="hideme" value="">Select Event Type</option>
                                        <option value="Wedding">Wedding</option>
                                        <option value="Engagement party">Engagement party</option>
                                        <option value="Private dinner">Private dinner</option>
                                        <option value="Baby shower">Baby shower</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <span id="event-type-error"></span>
                                </div>
                                @if($errors->has('event_type'))
                                        <span class="error-help">{{ $errors->first('event_type') }}</span>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>If you selected "other",can you please specify the type of event</label>
                                    <textarea  rows="5" id="event_type_2" name="event_type_2" class="form-control">{{ old('event_type_2') }}</textarea>
                                    @if($errors->has('event_type_2'))
                                        <span class="error-help">{{ $errors->first('event_type_2') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name:</label>
                                    <input type="text" name="first_name" class="form-control"  value="{{ old('first_name') }}">
                                    @if($errors->has('first_name'))
                                        <span class="error-help">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mobile Numner:</label>
                                    <input type="text" name="contact" class="form-control" value="{{ old('contact') }}">
                                    @if($errors->has('contact'))
                                        <span class="error-help">{{ $errors->first('contact') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name:</label>
                                    <input type="text" name="last_name" class="form-control"  value="{{ old('last_name') }}">
                                    @if($errors->has('last_name'))
                                        <span class="error-help">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Home Number(Optional):</label>
                                    <input type="text" name="contact_home" class="form-control" value="{{ old('contact_home') }}">
                                    @if($errors->has('contact_home'))
                                        <span class="error-help">{{ $errors->first('contact_home') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                    @if($errors->has('email'))
                                        <span class="error-help">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group input-focused">
                                    <label>Country:</label>
                                    <select class="form-select" name="country" id="inquiry_country" data-error-container="#country-error">
                                        <option class="hideme" value="">Select Country</option>
                                        @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->getName() }}</option>
                                        @endforeach
                                    </select>
                                    <span id="country-error"></span>
                                    @if($errors->has('country'))
                                        <span class="error-help">{{ $errors->first('country') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group input-focused">
                                    <label>City:</label>
                                    <select class="form-select" name="city" id="inquiry_city" data-error-container="#city-error"> 
                                        <option class="hideme" value="">Select City</option>
                                    </select>
                                    <span id="city-error"></span>
                                    @if($errors->has('city'))
                                        <span class="error-help">{{ $errors->first('city') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group input-focused">
                                    <label>Emirate:</label>
                                    <select class="form-select" name="emirate" id="inquiry_emirate" data-error-container="#emirate-error">
                                        <option class="hideme" value="">Select Emirate</option>
                                        <option value="Dubai">Dubai</option>
                                        <option value="Abu Dhabi">Abu Dhabi</option>
                                        <option value="Sharjah">Sharjah</option>
                                        <option value="Fujairah">Fujairah</option>
                                        <option value="Ajman">Ajman</option>
                                        <option value="Umm Al Quwain">Umm Al Quwain</option>
                                        <option value="Ras Al Khaimah">Ras Al Khaimah</option>
                                    </select>
                                    <span id="emirate-error"></span>
                                    @if($errors->has('emirate'))
                                        <span class="error-help">{{ $errors->first('emirate') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="inquiry-form-sec">
                        <h3>EVENT DETAILS</h3>
                        <div class="form-seprator"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Date/Time:</label>
                                    <input type="text" name="date_event" class="form-control event-datepicker">
                                    @if($errors->has('date_event'))
                                        <span class="error-help">{{ $errors->first('date_event') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Location:</label>
                                    <input type="text" name="location_event" class="form-control" value="{{ old('location_event') }}">
                                    @if($errors->has('location_event'))
                                        <span class="error-help">{{ $errors->first('location_event') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="inquiry-form-sec">
                        <div class="form-seprator"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Estimated number of guests?</label>
                                    <input type="text" name="guests" class="form-control" value="{{ old('guests') }}">
                                    @if($errors->has('guests'))
                                        <span class="error-help">{{ $errors->first('guests') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Do you have any allergies to flowers?</label>
                                    <textarea  rows="5" name="allergies" class="form-control">{{ old('allergies') }}</textarea>
                                    @if($errors->has('allergies'))
                                        <span class="error-help">{{ $errors->first('allergies') }}</span>
                                    @endif 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>if you have selected wedding:Will you be having any bridesmaids or groomsmen and if yes, how many?</label>
                                    <textarea  rows="5" id="bridesmaids_groomsmen" name="bridesmaids_groomsmen" class="form-control">{{ old('bridesmaids_groomsmen') }}</textarea>
                                    @if($errors->has('bridesmaids_groomsmen'))
                                        <span class="error-help">{{ $errors->first('bridesmaids_groomsmen') }}</span>
                                    @endif 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>What is your allotted flower budget?</label>
                                    <input type="text" name="budget" class="form-control" value="{{ old('budget') }}">
                                    @if($errors->has('budget'))
                                        <span class="error-help">{{ $errors->first('budget') }}</span>
                                    @endif 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>What is your theme and color scheme?</label>
                                    <textarea  rows="5" name="wedding_theme" class="form-control">{{ old('wedding_theme') }}</textarea>
                                    @if($errors->has('wedding_theme'))
                                        <span class="error-help">{{ $errors->first('wedding_theme') }}</span>
                                    @endif 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>What are your favorite flowers? Are there any you don’t care for?</label>
                                    <textarea  rows="5" name="favorite_flowers" class="form-control">{{ old('favorite_flowers') }}</textarea>
                                    @if($errors->has('favorite_flowers'))
                                        <span class="error-help">{{ $errors->first('favorite_flowers') }}</span>
                                    @endif 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group input-focused">
                                    <label>What best describes your style?</label>
                                    <select class="form-select" name="wedding_style" data-error-container="#wedding_style-error">
                                        <option class="hideme" value="">Select Wedding Style</option>
                                        <option value="Romantic | Soft | Simple">Romantic | Soft | Simple</option>
                                        <option value="Vintage | Romantic |  Soft">Vintage | Romantic |  Soft</option>
                                        <option value="Artsy | Earthy | Bold">Artsy | Earthy | Bold</option>
                                        <option value="Bold | Dynamic | Eclectic">Bold | Dynamic | Eclectic</option>
                                        <option value="Traditional | Formal | Classic">Traditional | Formal | Classic</option>
                                    </select>
                                    <span id="wedding_style-error"></span>
                                    @if($errors->has('wedding_style'))
                                        <span class="error-help">{{ $errors->first('wedding_style') }}</span>
                                    @endif 
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group input-focused">
                                    <label>Please select the statement you agree with:</label>
                                    <select class="form-select" name="statement" data-error-container="#statement-error">
                                        <option class="hideme" value="">Select Statement</option>
                                        <option value="I know exactly what I want.">I know exactly what I want.</option>
                                        <option value="I have an idea of what I want but would like some suggestions.">I have an idea of what I want but would like some suggestions.</option>
                                        <option value="I’m not really sure what I want, and am looking for help to choose.">I’m not really sure what I want, and am looking for help to choose.</option>
                                    </select>
                                    <span id="statement-error"></span>
                                    @if($errors->has('statement'))
                                        <span class="error-help">{{ $errors->first('statement') }}</span>
                                    @endif 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Do you have a planner? If so, please provide their contact information below.</label>
                                    <textarea  rows="5" name="planner" class="form-control">{{ old('planner') }}</textarea>
                                    @if($errors->has('planner'))
                                        <span class="error-help">{{ $errors->first('planner') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="common-black-btn">Submit</button>
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
<script type="text/javascript" src="{{ asset('frontend/js/moment-with-locales.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/bootstrap-datetimepicker.js') }}"></script>

<script src="{{ asset('admin/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('admin/js/custom_validations.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function() {
        $("#frmServiceInquiry").validate({
            rules: {
                event_type: {
                    required: true,
                    not_empty: true,
                    maxlength: 255,
                },
                event_type_2: {
                    required: false,
                    not_empty: false,
                    maxlength: 255,
                },
                first_name: {
                    required: true,
                    not_empty: true,
                    maxlength: 255,
                },
                last_name: {
                    required: true,
                    not_empty: true,
                    maxlength: 255,
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
                            type: "service_contact",
                        }
                    },
                },
                contact_home:{
                    required:false,
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
                            type: "service_contact_home",
                        }
                    },
                },
                email:{
                    required:true,
                    not_empty:true,
                    maxlength:255,
                    email: true,
                    valid_email: true,
                    remote: {
                        url: "{{ route('user.check.email') }}",
                        type: "post",
                        data: {
                            _token: function() {
                                return "{{csrf_token()}}"
                            },
                            type: "service_inquiry_email",
                        }
                    },
                },
                country: {
                    required: true,
                    not_empty: true,
                    maxlength: 255,
                },
                emirate: {
                    required: true,
                    not_empty: true,
                    maxlength: 255,
                },
                city: {
                    required: true,
                    not_empty: true,
                    maxlength: 255,
                },
                date_event: {
                    required: true,
                    not_empty: true,
                    date : true,
                },
                location_event: {
                    required: true,
                    not_empty: true,
                    maxlength: 255,
                },
                guests: {
                    required: true,
                    not_empty: true,
                    pattern: /^(\d+)(?: ?\d+)*$/,
                    maxlength: 255,
                },
                bridesmaids_groomsmen: {
                    required: false,
                    not_empty: false,
                    maxlength: 255,
                },
                allergies: {  
                    required: true,
                    not_empty: true,
                    maxlength: 255,
                },
                budget: {
                    required: true,
                    not_empty: true,
                    pattern: /^(\d+)(?: ?\d+)*$/,
                    maxlength: 255,
                },
                wedding_theme: {
                    required: true,
                    not_empty: true,
                    maxlength: 255,
                },
                wedding_style: {
                    required: true,
                    not_empty: true,
                    maxlength: 255,
                },
                favorite_flowers: {
                    required: true,
                    not_empty: true,
                    maxlength: 255,
                },
                statement: {
                    required: true,
                    not_empty: true,
                    maxlength: 255,
                },
                planner: {
                    required: true,
                    not_empty: true,
                    maxlength: 255,
                },
            },
            messages: {
                event_type:{
                    required:"@lang('validation.required',['attribute'=>'event type'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'event type'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'event type','max'=>255])",
                },
                event_type_2:{
                    required:"@lang('validation.required',['attribute'=>'event type'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'event type'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'event type','max'=>255])",
                },
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
                    required:"@lang('validation.required',['attribute'=>'contact'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'contact'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'contact','max'=>16])",
                    minlength:"@lang('validation.min.string',['attribute'=>'contact','min'=>8])",
                    pattern:"contact must be a number.",
                    remote:"@lang('validation.unique',['attribute'=>'contact'])",
                },
                contact_home:{
                    required:"@lang('validation.required',['attribute'=>'home contact'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'home contact'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'home contact','max'=>16])",
                    minlength:"@lang('validation.min.string',['attribute'=>'home contact','min'=>8])",
                    pattern:"home contact must be a number.",
                    remote:"@lang('validation.unique',['attribute'=>'home contact'])",
                },
                email:{
                    required:"@lang('validation.required',['attribute'=>'email'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'email'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'email','max'=>255])",
                    email:"@lang('validation.email',['attribute'=>'email'])",
                    valid_email:"@lang('validation.email',['attribute'=>'email'])",
                    remote:"@lang('validation.unique',['attribute'=>'email'])",
                },
                country:{
                    required:"@lang('validation.required',['attribute'=>'country'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'country'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'country','max'=>255])",
                },
                emirate:{
                    required:"@lang('validation.required',['attribute'=>'emirate'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'emirate'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'emirate','max'=>255])",
                },
                city:{
                    required:"@lang('validation.required',['attribute'=>'city'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'city'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'city','max'=>255])",
                },
                date_event:{
                    required:"@lang('validation.required',['attribute'=>'date'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'date'])",
                    date:"@lang('validation.date',['attribute'=>'date'])",
                },
                location_event:{
                    required:"@lang('validation.required',['attribute'=>'location'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'location'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'location','max'=>255])",
                },
                guests:{
                    required:"@lang('validation.required',['attribute'=>'guest'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'guest'])",
                    pattern:"guest must be a number.",
                    maxlength:"@lang('validation.max.string',['attribute'=>'guest','max'=>255])",
                },
                bridesmaids_groomsmen:{
                    required:"@lang('validation.required',['attribute'=>'bridesmaids'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'bridesmaids'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'bridesmaids','max'=>255])",
                },
                allergies:{
                    required:"@lang('validation.required',['attribute'=>'allergies'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'allergies'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'allergies','max'=>255])",
                },
                budget:{
                    required:"@lang('validation.required',['attribute'=>'budget'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'budget'])",
                    pattern:"budget must be a number.",
                    maxlength:"@lang('validation.max.string',['attribute'=>'budget','max'=>255])",
                },
                wedding_theme:{
                    required:"@lang('validation.required',['attribute'=>'theme'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'theme'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'theme','max'=>255])",
                },
                wedding_style:{
                    required:"@lang('validation.required',['attribute'=>'style'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'style'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'style','max'=>255])",
                },
                favorite_flowers:{
                    required:"@lang('validation.required',['attribute'=>'favorite flowers'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'favorite flowers'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'favorite flowers','max'=>255])",
                },
                statement:{
                    required:"@lang('validation.required',['attribute'=>'statement'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'statement'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'statement','max'=>255])",
                },
                planner:{
                    required:"@lang('validation.required',['attribute'=>'planner'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'planner'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'planner','max'=>255])",
                },
            },
            errorClass: 'help-block',
            errorElement: 'span',
            highlight: function (element) {
               $(element).closest('.form-group').addClass('has-error').css('color','red');
            },
            unhighlight: function (element) {
               $(element).closest('.form-group').removeClass('has-error').css('color','black');
            },
            errorPlacement: function (error, element) {
                if (element.attr("data-error-container")) {
                    error.appendTo(element.attr("data-error-container"));
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $('#frmServiceInquiry').submit(function(){
            if( $(this).valid() ){
                console.log("Form Validated!!!");
                $("input[type=submit], input[type=button], button[type=submit]").prop("disabled", "disabled");
                return true;
            }
            else{
                return false;
            }
        });
    });
    </script>

     <script type="text/javascript">
            // datepicker and timepicker
            $('.event-datepicker').datetimepicker({
                format: 'L',
                icons: {
                    previous: "fa fa-chevron-left",
                    next: "fa fa-chevron-right"
                },
                minDate: new Date(),
                useCurrent: false
            });
            // $('.event-datepicker').on('dp.hide', function() {
            //     $('.event-datepicker').val("Choose Date");
            // });
            $('.event-datepicker').on('dp.change', function() {
                if($('.event-datepicker').val() == ""){
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
     </script>

     <script type="text/javascript">
         $("#event_type").on('change',function(){
            if($(this).val() == "Other"){
                $("#event_type_2").prop('required',true);
                $("#event_type_2").closest('.form-group').removeClass('has-error').css('color','black');
                $("#event-type-error").remove();
                $("#event_type_2").parent().append('<span id="event-type-error" class="help-block" style="color:red;">Please enter event type name.</span>');
                $("#event_type_2").closest('.form-group').addClass('has-error').css('color','red');
            }
            else if($(this).val() == "Wedding"){
                $("#bridesmaids_groomsmen").prop('required',true);
                $("#bridesmaids_groomsmen").closest('.form-group').removeClass('has-error').css('color','black');
                $("#bridesmaids_groomsmen-type-error").remove();
                $("#bridesmaids_groomsmen").parent().append('<span id="bridesmaids_groomsmen-type-error" class="help-block" style="color:red;">Please enter bridesmaids or groomsmen details.</span>');
                $("#bridesmaids_groomsmen").closest('.form-group').addClass('has-error').css('color','red');
            }
            else{
                $("#event_type_2").prop('required',false);
                $("#bridesmaids_groomsmen").prop('required',false);
                $("#event-type-error").remove();
                $("#bridesmaids_groomsmen-type-error").remove();
            }
         });
     </script>

@endpush