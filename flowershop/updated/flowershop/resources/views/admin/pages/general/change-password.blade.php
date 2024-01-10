@extends('admin.layout.app')

@push('css-top')
	<link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('page-title')
	<h3 class="page-title"> 
		Change Password
	</h3>
@endpush

@section('main-content')
<div class="row">
	<div class="col-md-12">

		{{-- Change Password --}}
		<div class="profile-content">
            <form action="{{ route('admin.change-password') }}" role="form" id="frmChangePassword" name="frmChangePassword" method="POST">
                @csrf
			        <div class="row">
			            <div class="col-md-12">
			                <div class="portlet light ">
			                    <div class="portlet-title tabbable-line">
			                        <div class="caption caption-md">
			                            <i class="icon-globe theme-font hide"></i>
			                            <span class="caption-subject font-blue-madison bold uppercase">Change Account Credentials</span>
			                        </div>
			                    </div>
			                    <div class="portlet-body">
	                                    <div class="form-group {{ $errors->has('old_password') ? 'has-error' : '' }}">
	                                        <label class="control-label">{!! $mend_sign !!}Old Password</label>
	                                        <input type="password" placeholder="Enter Old Password" class="form-control" id="old_password" name="old_password" autocomplete="off" />
	                                    	@if($errors->has('old_password'))
	                                    		<span class="help-block">
	                                    			{{ $errors->first('old_password') }}
	                                    		</span>
                                    		@endif
	                                    </div>

	                                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
	                                        <label class="control-label">{!! $mend_sign !!}Enter New Password</label>
	                                        <input type="password" placeholder="Enter New Password" class="form-control" id="password" name="password" autocomplete="off" />
	                                    	@if($errors->has('contact'))
	                                    		<span class="help-block">
	                                    			{{ $errors->first('password') }}
	                                    		</span>
                                    		@endif
	                                    </div>

	                                    <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
	                                        <label class="control-label">{!! $mend_sign !!}Confirm New Passowrd</label>
	                                        <input type="password" placeholder="Re-enter New Passowrd" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="off" />
	                                    	@if($errors->has('password_confirmation'))
	                                    		<span class="help-block">
	                                    			{{ $errors->first('password_confirmation') }}
	                                    		</span>
                                    		@endif
	                                    </div>
			                    </div>
			                </div>
			            </div>
			        </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-xs-6 text-right">
                                <input type="submit" value="Save Changes" class="btn green">
                            </div>
                            <div class="col-xs-6">
                                <a href="{{ route('admin.dashboard.index') }}" class="btn default">Cancel</a>
                            </div>
                        </div>
                    </div>
            </form>
		</div>
	</div>
</div>
@endsection
@push('extra-js')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#frmChangePassword").validate({
                rules: {
                    old_password: {
                    	required: true,
                    	not_empty: true,
                    	maxlength: 16,
                    	minlength: 8,
                    },
                    password:{
                        required:true,
                        not_empty:true,
                        maxlength:16,
                        minlength:8,
                    },
                    password_confirmation:{
                        required:true,
                        not_empty:true,
                        maxlength:16,
                        minlength:8,
                        equalTo: "#password",
                    },
	                profile:{
	                    extension: "jpg|jpeg|png",
	                },
                },
                messages: {
                    old_password:{
                        required:"@lang('validation.required',['attribute'=>'old password'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'old password'])",
                        minlength:"@lang('validation.min.string',['attribute'=>'old password','min'=>8])",
                    },
                    password:{
                        required:"@lang('validation.required',['attribute'=>'password'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'password'])",
                        minlength:"@lang('validation.min.string',['attribute'=>'password','min'=>8])",
                    },
                    password_confirmation:{
                        required:"@lang('validation.required',['attribute'=>'confirm password'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'confirm password'])",
                        minlength:"@lang('validation.min.string',['attribute'=>'confirm password','min'=>8])",
                        equalTo:"@lang('validation.equal_to',['attribute'=>'confirm password','other'=>'password'])",
                    },
                },
                errorClass: 'help-block',
                errorElement: 'span',
                highlight: function (element) {
                   $(element).closest('.form-group').addClass('has-error');
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

            $('#frmChangePassword').submit(function(){
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