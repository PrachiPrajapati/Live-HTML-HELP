@extends('frontend.layouts.app')

@push('banner-section')
<!--******************* Banner Section Start ******************-->
<div class="banner d-flex align-items-center" style="background-image: url('{{ asset('frontend/images/home-banner.png') }}')">
    <div class="gradient-overlay"></div>
    <div class="container pos-rel">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <h1>Inquiry Form</h1>
                <p>Millions of people around the world have already made the place where their work happens</p>
            </div>
        </div>
    </div>
</div>
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
                        <h2><span>FORM INQUIRY {{ strtoupper($service->getTitle()) }}</span><a href="javascript:;"><i class="fa fa-chevron-right"></i></a></h2>
                    </div>
                    <p>We would like to know more about you and your plans for your big day, so that we can help make it special and unique.</p>
                    <div class="inquiry-form-sec">
                        <div class="row">
                            <input type="hidden" class="form-control" name="service_id" value="{{ $service->id }}">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>I am the</label>
                                    <select class="form-select" name="type" data-error-container="#type-error">
                                        <option value="Bridge">Bridge</option>
                                        <option value="Groom">Groom</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <span id="type-error"></span>
                                </div>
                                @if($errors->has('type'))
                                        <span class="error-help">{{ $errors->first('type') }}</span>
                                @endif
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
                                <div class="form-group">
                                    <label>Country:</label>
                                    <select class="form-select" name="country" id="inquiry_country" data-error-container="#country-error">
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
                                <div class="form-group">
                                    <label>City:</label>
                                    <select class="form-select" name="city" id="inquiry_city" data-error-container="#city-error"> 
                                        <option value="">Select City</option>
                                    </select>
                                    <span id="city-error"></span>
                                    @if($errors->has('city'))
                                        <span class="error-help">{{ $errors->first('city') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="inquiry-form-sec">
                        <h3>CEREMONY</h3>
                        <div class="form-seprator"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Date/Time:</label>
                                    <input type="text" name="date_ceremony" class="form-control event-datepicker">
                                    @if($errors->has('date_ceremony'))
                                        <span class="error-help">{{ $errors->first('date_ceremony') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Location:</label>
                                    <input type="text" name="location_ceremony" class="form-control" value="{{ old('location') }}">
                                    @if($errors->has('location_ceremony'))
                                        <span class="error-help">{{ $errors->first('location_ceremony') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="inquiry-form-sec">
                        <h3>RECEPTION</h3>
                        <div class="form-seprator"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Date/Time:</label>
                                    <input type="text" name="date_reception" class="form-control event-datepicker">
                                    @if($errors->has('date_reception'))
                                        <span class="error-help">{{ $errors->first('date_reception') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Location:</label>
                                    <input type="text" name="location_reception" class="form-control" value="{{ old('location_reception') }}">
                                    @if($errors->has('location_reception'))
                                        <span class="error-help">{{ $errors->first('location_reception') }}</span>
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
                                    <label>Number of bridesmaids?</label>
                                    <input type="text" name="bridesmaids" class="form-control" value="{{ old('bridesmaids') }}">
                                    @if($errors->has('bridesmaids'))
                                        <span class="error-help">{{ $errors->first('bridesmaids') }}</span>
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
                                    <label>Number of groomsmen?</label>
                                    <input type="text" name="groomsmen" class="form-control" value="{{ old('groomsmen') }}">
                                    @if($errors->has('groomsmen'))
                                        <span class="error-help">{{ $errors->first('groomsmen') }}</span>
                                    @endif 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>What is your allotted flower budget?</label>
                                    <textarea  rows="5" name="budget" class="form-control">{{ old('budget') }}</textarea>
                                    @if($errors->has('budget'))
                                        <span class="error-help">{{ $errors->first('budget') }}</span>
                                    @endif 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>What are your wedding colors?</label>
                                    <textarea  rows="5" name="wedding_color" class="form-control">{{ old('wedding_color') }}</textarea>
                                    @if($errors->has('wedding_color'))
                                        <span class="error-help">{{ $errors->first('wedding_color') }}</span>
                                    @endif 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>What best describes your wedding style</label>
                                    <select class="form-select" name="wedding_style" data-error-container="#wedding_style-error">
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
                                <div class="form-group">
                                    <label>What are your favorite flowers? Are there any you don’t care for?</label>
                                    <textarea  rows="5" name="favorite_flowers" class="form-control">{{ old('favorite_flowers') }}</textarea>
                                    @if($errors->has('favorite_flowers'))
                                        <span class="error-help">{{ $errors->first('favorite_flowers') }}</span>
                                    @endif 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Please select the statement you agree with:</label>
                                    <select class="form-select" name="statement" data-error-container="#statement-error">
                                        <option value="I have an idea of what I want but would like some suggestions.">I have an idea of what I want but would like some suggestions.</option>
                                        <option value="I’m not really sure what I want and am looking for help to choose what will best fit with my gown an">I’m not really sure what I want and am looking for help to choose what will best fit with my gown an</option>
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
                    <div class="preferred-options">
                        <h4 class="mb-4">Preferred Options</h4>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="preferred_options1" value="Phone only" name="preferred_options" class="custom-control-input" data-error-container="#preferred_options-error">
                            <label class="custom-control-label" for="preferred_options1">Phone only</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="preferred_options2" value="Email only" name="preferred_options" class="custom-control-input" data-error-container="#preferred_options-error">
                            <label class="custom-control-label" for="preferred_options2">Email only</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="preferred_options3" value="Phone and email" name="preferred_options" class="custom-control-input" data-error-container="#preferred_options-error">
                            <label class="custom-control-label" for="preferred_options3">Phone and email</label>
                        </div>
                        <span id="preferred_options-error" style="color: red;"></span>
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
                type: {
                    required: true,
                    not_empty: true,
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
                city: {
                    required: true,
                    not_empty: true,
                    maxlength: 255,
                },
                date_ceremony: {
                    required: true,
                    not_empty: true,
                    date : true,
                },
                location_ceremony: {
                    required: true,
                    not_empty: true,
                    maxlength: 255,
                },
                date_reception: {
                    required: true,
                    not_empty: true,
                    date : true,
                },
                location_reception: {
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
                bridesmaids: {
                    required: true,
                    not_empty: true,
                    pattern: /^(\d+)(?: ?\d+)*$/,
                    maxlength: 255,
                },
                allergies: {  
                    required: true,
                    not_empty: true,
                    maxlength: 255,
                },
                groomsmen: {
                    required: true,
                    not_empty: true,
                    pattern: /^(\d+)(?: ?\d+)*$/,
                    maxlength: 255,
                },
                budget: {
                    required: true,
                    not_empty: true,
                    pattern: /^(\d+)(?: ?\d+)*$/,
                    maxlength: 255,
                },
                wedding_color: {
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
                preferred_options: {
                    required: true,
                    not_empty: true,
                    maxlength: 255,
                },
            },
            messages: {
                type:{
                    required:"@lang('validation.required',['attribute'=>'select'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'select'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'select','max'=>255])",
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
                city:{
                    required:"@lang('validation.required',['attribute'=>'city'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'city'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'city','max'=>255])",
                },
                date_ceremony:{
                    required:"@lang('validation.required',['attribute'=>'date'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'date'])",
                    date:"@lang('validation.date',['attribute'=>'date'])",
                },
                location_ceremony:{
                    required:"@lang('validation.required',['attribute'=>'location'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'location'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'location','max'=>255])",
                },
                date_reception:{
                    required:"@lang('validation.required',['attribute'=>'date'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'date'])",
                    date:"@lang('validation.date',['attribute'=>'date'])",
                },
                location_reception:{
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
                bridesmaids:{
                    required:"@lang('validation.required',['attribute'=>'bridesmaids'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'bridesmaids'])",
                    pattern:"bridesmaids must be a number.",
                    maxlength:"@lang('validation.max.string',['attribute'=>'bridesmaids','max'=>255])",
                },
                allergies:{
                    required:"@lang('validation.required',['attribute'=>'allergies'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'allergies'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'allergies','max'=>255])",
                },
                groomsmen:{
                    required:"@lang('validation.required',['attribute'=>'groomsmen'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'groomsmen'])",
                    pattern:"groomsmen must be a number.",
                    maxlength:"@lang('validation.max.string',['attribute'=>'groomsmen','max'=>255])",
                },
                budget:{
                    required:"@lang('validation.required',['attribute'=>'budget'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'budget'])",
                    pattern:"budget must be a number.",
                    maxlength:"@lang('validation.max.string',['attribute'=>'budget','max'=>255])",
                },
                wedding_color:{
                    required:"@lang('validation.required',['attribute'=>'color'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'color'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'color','max'=>255])",
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
                preferred_options:{
                    required:"@lang('validation.required',['attribute'=>'preferred option'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'preferred option'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'preferred option','max'=>255])",
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
     </script>

@endpush