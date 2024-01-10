@extends('frontend.layouts.app')

@section('main-content')

 <!-- reset section -->
        <section class="reset-section common-spacing">
            <article class="container">
                <form class="common-form" id="frmResetPassword" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="text-center">
                                <img src="{{ asset('frontend/images/flower.png') }}" alt="flower">
                                <h2>Add A New Password</h2>
                                    <div class="form-group">
                                        <div class="row">
                                            <label>EMAIL ADDRESS</label>
                                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" autocomplete="email" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                <div class="form-group">
                                   <div class="row">
                                        <label>NEW PASSWORD</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" >
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror       
                                    </div>                    
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label>CONFIRM PASSWORD</label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password" >
                                    </div>
                                </div>
                                <button type="submit" class="common-black-btn">Save & Login</button>
                            </div>
                        </div>
                    </div>
                </form>
            </article>
        </section>
@endsection

@push('extra-js')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#frmResetPassword").validate({
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
                            }
                        },
                    },
                    password: {
                        required: true,
                        not_empty: true,
                        minlength: 8,
                        maxlength: 16,
                        pattern:/^(?=.{8,16}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/,
                    },
                    password_confirmation: {
                        required: true,
                        not_empty: true,
                        minlength: 8,
                        maxlength: 16,
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
                        remote:"Please enter correct email address.",
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
                        not_empty:"@lang('validation.not_empty',['attribute'=>'confirm password'])",
                        minlength:"@lang('validation.min.string',['attribute'=>'confirm password','min'=>8])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'confirm password','max'=>16])",
                        equalTo:"password and confirm password not match.",
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

            $('#frmResetPassword').submit(function(){
                if( $(this).valid() ){
                    autofocus();
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