@extends('frontend.layouts.app')

@section('main-content')
        <!-- reset section -->
        <section class="reset-section common-spacing">
            <article class="container">
                <form class="common-form" id="frmAddNewPasword" method="POST" action="{{ route('change.password') }}">
                    @csrf
                    @method('PUT')
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                           	<div class="text-center">
                                <img src="{{ asset('images/flower.png') }}" alt="flower">
                                <h2>Add a new password</h2>
                                <input type="hidden" name="email" value="{{ $email }}">
                                <div class="form-group ">
                                    <label>New Password</label>
                                    <input type="password" name="password" value="{{ old('password') }}" class="form-control" >
                                    @if($errors->has('password'))
                                        <span class="help-block">
                                            {{ $errors->first('password') }}
                                        </span>
                                    @endif                              
                                </div>
                                <div class="form-group ">
                                    <label>Confirm Password</label>
                                    <input type="password" name="confirm_password" value="{{ old('cpassword') }}" class="form-control" >
                                    @if($errors->has('confirm_password'))
                                        <span class="help-block">
                                            {{ $errors->first('confirm_password') }}
                                        </span>
                                    @endif 
                                </div>
                                <button type="submit" class="common-black-btn hello">Save & Login</button>
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
            $("#frmAddNewPasword").validate({
                rules: {
                    password: {
                    	required: true,
                    	not_empty: true,
                    	minlength: 8,
                    	maxlength: 16,
                        pattern:/^(?=.{8,16}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/,
                    },
                    confirm_password: {
                        required: true,
                        not_empty: true,
                        minlength: 8,
                        maxlength: 16,
                    },
                },
                messages: {
                    password:{
                        required:"@lang('validation.required',['attribute'=>'password'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'password'])",
                        minlength:"@lang('validation.min.string',['attribute'=>'password','min'=>8])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'password','max'=>16])",
                        pattern:"The password must be a stong password",
                    },
                    confirm_password:{
                        required:"@lang('validation.required',['attribute'=>'confirm password'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'confirm password'])",
                        minlength:"@lang('validation.min.string',['attribute'=>'confirm password','min'=>8])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'confirm password','max'=>16])",
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

            $('#frmAddNewPasword').submit(function(){
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
