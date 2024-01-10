@extends('admin.layout.auth')
@section('content')
    <form class="login-form" action="{{ route('admin.password.email') }}" method="POST" id="frmResetPassword" name="frmResetPassword">
        @csrf

        <input type="hidden" name="token" value="{{ $token ?? "" }}">
        <h3 class="form-title font-green">Reset Password</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span>Error Goes Here</span>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Email</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Enter Your Email Address" name="email" id="email" />
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Enter Your New Passowrd" name="password" id="password" />
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Confirm Password</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Enter Your New Password Again" name="password_confirmation" id="password_confirmation" />
        </div>
        <div class="form-actions">
            <button type="submit" class="btn green uppercase">Reset & Login</button>
        </div>
    </form>
@endsection

@push('extra-js')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#forget-password").click(function() {
                $(".login-form").hide();
                $(".forget-form").show()
            });
            
            $("#back-btn").click(function() {
                $(".login-form").show(); 
                $(".forget-form").hide();
            })
            $("#frmResetPassword").validate({
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
                        minlength:6,
                        maxlength: 16,
                    },
                    password_confirmation:{
                        required:true,
                        not_empty:true,
                        equalTo:'#password',
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
                        minlength:"@lang('validation.min.string',['attribute'=>'password','min'=>6])"
                    },
                    password_confirmation:{
                        required:"@lang('validation.required',['attribute'=>'confirm password'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'confirm password'])",
                        minlength:"@lang('validation.min.string',['attribute'=>'confirm password','min'=>6])",
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

            $('#frmResetPassword').submit(function(){
                if( $(this).valid() ){
                    // addOverlay();
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