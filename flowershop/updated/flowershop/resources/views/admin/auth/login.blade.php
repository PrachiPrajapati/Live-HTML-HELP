@extends('admin.layout.auth')


@section('content')
    <form class="login-form" action="{{ route('admin.login') }}" method="POST" id="frmLoginForm" name="frmLoginForm">
        @csrf

        <h3 class="form-title font-green">Sign In</h3>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        
        @if ($errors->has('email'))
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button>
                <span>{{ $errors->first('email') }}</span>
            </div>
        @endif
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Email</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="email" autocomplete="off" placeholder="Enter You Email Address" name="email" id="email" />
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Enter Your Password" name="password" id="password" />
        </div>
        <div class="form-actions">
            <input class="btn green uppercase" type="submit" value="Login">
            <label class="rememberme check">
                <input type="checkbox" name="remember" value="1" />Remember</label>
            <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>
        </div>
    </form>
    
    <form class="forget-form" action="{{ route('admin.password.request') }}" method="post">
        @csrf
        
        <h3 class="font-green">Forget Password ?</h3>
        <p> Enter your e-mail address below to reset your password. </p>
        <div class="form-group">
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" />
        </div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn btn-default">Back</button>
            <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
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

            $("#frmLoginForm").validate({
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

            $('#frmLoginForm').submit(function(){
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