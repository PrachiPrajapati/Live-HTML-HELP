@extends('frontend.layouts.app')

@section('main-content')
<section class="franchise common-spacing">
    <article class="container">
        <div class="row">
            <div class="col-md-8 col-xl-5">
                <h1>Interested in joining the Maison Des Fleurs family as a franchise?</h1>
                <p>Please fill out the information below and we will get in touch with you.</p>
            </div>
        </div>
        <form class="common-form" id="frmFranchiseRequest" method="POST" action="{{ route('franchisesrequests.store') }}" style="margin-top: 60px;">
        	@csrf
            <div class="contact-details franchise-form-blocks" style="margin-bottom: 40px;">
                <h4 style="margin-bottom: 20px; font-family: Freight;">Contact Details</h4>
                <div class="row">
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="NAME" value="{{ old('name') }}">
                            @if($errors->has('name'))
                            	<span class="error-help">{{ $errors->first('name') }}</span>
                        	@endif
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group">
                            <input type="text" name="company_name" class="form-control" placeholder="COMPANY NAME" value="{{ old('company_name') }}">
                            @if($errors->has('company_name'))
                            	<span class="error-help">{{ $errors->first('company_name') }}</span>
                        	@endif
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group">
                            <input type="text" name="company_address" class="form-control" placeholder="COMPANY ADDRESS" value="{{ old('company_address') }}">
                            @if($errors->has('company_address'))
                            	<span class="error-help">{{ $errors->first('company_address') }}</span>
                        	@endif
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="EMAIL" value="{{ old('email') }}">
                            @if($errors->has('company_address'))
                            	<span class="error-help">{{ $errors->first('email') }}</span>
                        	@endif
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group">
                            <input type="text" name="phone" class="form-control" placeholder="PHONE" value="{{ old('phone') }}">
                            @if($errors->has('phone'))
                            	<span class="error-help">{{ $errors->first('phone') }}</span>
                        	@endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="business-details franchise-form-blocks" style="margin-bottom: 40px;">
                <h4 style="margin-bottom: 20px;font-family: Freight;">Your Business</h4>    
                <div class="row">
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group">
                            <input type="text" name="sector" class="form-control" placeholder="SECTOR" value="{{ old('sector') }}">
                            @if($errors->has('sector'))
                            	<span class="error-help">{{ $errors->first('sector') }}</span>
                        	@endif
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group">
                            <input type="text" name="company_activity" class="form-control" placeholder="COMPANY'S MAIN ACTIVITIES" value="{{ old('company_activity') }}">
                            @if($errors->has('company_activity'))
                            	<span class="error-help">{{ $errors->first('company_activity') }}</span>
                        	@endif
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group">
                        	<input type="text" name="experience" class="form-control" placeholder="OTHER FRANCHISES HELD/EXPERIENCE" value="{{ old('experience') }}">
                            @if($errors->has('experience'))
                            	<span class="error-help">{{ $errors->first('experience') }}</span>
                        	@endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="franchise">
                <h4 style="margin-bottom: 20px;font-family: Freight;">Your Business</h4>
                <div class="row">
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group">
                            <input type="text" name="location" class="form-control" placeholder="LOCATION/COUNTRY OF INTEREST" value="{{ old('location') }}">
                            @if($errors->has('location'))
                            	<span class="error-help">{{ $errors->first('location') }}</span>
                        	@endif
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group">
                            <input type="text" name="comment" class="form-control" placeholder="COMMENTS" value="{{ old('comment') }}">
                            @if($errors->has('comment'))
                            	<span class="error-help">{{ $errors->first('comment') }}</span>
                        	@endif
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-outline">Submit Request</button>
        </form>
    </article>
</section>
@endsection('main-content')

@push('extra-js')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#frmFranchiseRequest").validate({
                rules: {
                    name: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    company_name: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    company_address: {
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
                                type: "franchise_request",
                            }
                        },
                    },
                    phone:{
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
                                type: "franchise_request",
                            }
                        },
                    },
                    sector: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    company_activity: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    experience: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    location: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    comment: {
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
                    company_name:{
                        required:"@lang('validation.required',['attribute'=>'comapany name'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'comapany name'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'comapany name','max'=>255])",
                    },
                    company_address:{
                        required:"@lang('validation.required',['attribute'=>'company address'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'company address'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'company address','max'=>255])",
                    },
                    email:{
                        required:"@lang('validation.required',['attribute'=>'email'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'email'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'email','max'=>255])",
                        email:"@lang('validation.email',['attribute'=>'email'])",
                        valid_email:"@lang('validation.email',['attribute'=>'email'])",
                        remote:"@lang('validation.unique',['attribute'=>'email'])",
                    },
                    phone:{
                        required:"@lang('validation.required',['attribute'=>'phone'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>''])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'phone','max'=>16])",
                        minlength:"@lang('validation.min.string',['attribute'=>'phone','min'=>8])",
                        pattern:"@lang('validation.numeric',['attribute'=>'phone'])",
                        pattern:"phone must be a number.",
                        remote:"@lang('validation.unique',['attribute'=>'phone'])",
                    },
                    sector:{
                        required:"@lang('validation.required',['attribute'=>'sector'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'sector'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'sector','max'=>255])",
                    },
                    company_activity:{
                        required:"@lang('validation.required',['attribute'=>'company activity'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'company activity'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'company activity','max'=>255])",
                    },
                    experience:{
                        required:"@lang('validation.required',['attribute'=>'experience'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'experience'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'experience','max'=>255])",
                    },
                    location:{
                        required:"@lang('validation.required',['attribute'=>'location'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'location'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'location','max'=>255])",
                    },
                    comment:{
                        required:"@lang('validation.required',['attribute'=>'comment'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'comment'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'comment','max'=>255])",
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

            $('#frmFranchiseRequest').submit(function(){
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