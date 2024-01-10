@extends('frontend.layouts.app')

@push('banner-section')
	<div class="banner small-banner d-flex align-items-center no-overlay" style="background-image: url(images/location-banner.jpg);">
    </div>
@endpush


@section('main-content')
	 <section class="locations common-spacing">
            <article class="container">
                <div class="contact">
                    <div class="title-block">
                        <h1>Get in touch with us</h1>
                    </div>
                    <form class="common-form" id="formFranchiseDetail" method="POST" action="{{ route('franchises.store') }}">
                    	@csrf
                        <div class="row">
                            <div class="col-md-6 col-xl-3">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="NAME" value="{{ old('name') }}">
                                    @if($errors->has('name'))
                                   		<span class="error-help">{{ $errors->first('name') }}</span>
                                	@endif
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="EMAIL" value="{{ old('email') }}">
                                     @if($errors->has('email'))
                                    	<span class="error-help">{{ $errors->first('email') }}</span>
                                	@endif
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3">
                                <div class="form-group">
                                    <input type="text" name="contact_number" class="form-control" placeholder="MOBILE" value="{{ old('contact_number') }}">
                                     @if($errors->has('contact_number'))
                                    	<span class="error-help">{{ $errors->first('contact_number') }}</span>
                                	@endif
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3">
                                <div class="form-group">
                                    <input type="text" name="address" class="form-control" placeholder="ADDRESS" value="{{ old('address') }}" >
                                     @if($errors->has('address'))
                                    	<span class="error-help">{{ $errors->first('address') }}</span>
                                	@endif
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn-outline">Send Message</button>
                    </form>
                </div>
                <div class="find-store">
                    <h1>Find a store near you</h1>
                    <div class="uae">
                        <h2>United Arab Emirates</h2>
                        <div class="row">
                        @if($franchises != '[]' && $franchises != null)
                            @foreach($franchises as $franchise)
                                <div class="col-md-6 col-xl-3">
                                <div class="find-store_address">
                                    {{ $franchise->getName() }}
                                    <address>{{ $franchise->getAddress() }}</address>
                                    <ul>
                                        <li>Mobile: <a href="tel:+{{ $franchise->contact_number }}">+{{ $franchise->contact_number }}</a></li>
                                        <li>Email: <a href="mailto:{{ $franchise->email }}">{{ $franchise->email }}</a></li>
                                        <li>Timings: 10am to 10pm</li>
                                    </ul>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        </div>
                    </div>
                </div>
                </article>
            </section>
@endsection('main-content')

@push('extra-js')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#formFranchiseDetail").validate({
                rules: {
                    name: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
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
                                type: "franchise",
                            }
                        },
                    },
                    contact_number:{
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
                                type: "franchise",
                            }
                        },
                    },
                    address: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                },
                messages: {
                    name:{
                        required:"@lang('validation.required',['attribute'=>'name'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'name'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'name','max'=>255])",
                    },
                    email:{
                        required:"@lang('validation.required',['attribute'=>'email'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'email'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'email','max'=>255])",
                        email:"@lang('validation.email',['attribute'=>'email'])",
                        valid_email:"@lang('validation.email',['attribute'=>'email'])",
                        remote:"@lang('validation.unique',['attribute'=>'email'])",
                    },
                    contact_number:{
                        required:"@lang('validation.required',['attribute'=>'mobile'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>''])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'mobile','max'=>16])",
                        minlength:"@lang('validation.min.string',['attribute'=>'mobile','min'=>8])",
                        pattern:"@lang('validation.numeric',['attribute'=>'mobile'])",
                        pattern:"mobile must be a number.",
                        remote:"@lang('validation.unique',['attribute'=>'mobile'])",
                    },
                    address:{
                        required:"@lang('validation.required',['attribute'=>'address'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'address'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'address','max'=>255])",
                    },
                },
                errorClass: 'help-block',
                errorElement: 'span',
                highlight: function (element) {
                   $(element).closest('.form-group').addClass('has-error').css('color','red');
                },
                unhighlight: function (element) {
                   $(element).closest('.form-group').removeClass('has-error');
                },
                errorPlacement: function (error, element) {
                    if (element.attr("data-error-container")) {
                        error.appendTo(element.attr("data-error-container"));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            $('#formFranchiseDetail').submit(function(){
                if( $(this).valid() ){
                    addOverlay();
                    $("input[type=submit], input[type=button], button[type=submit]").prop("disabled", "disabled");
                    return true;
                }
                else{
                    return false;
                }
            });
        });
    </script>
@endpush