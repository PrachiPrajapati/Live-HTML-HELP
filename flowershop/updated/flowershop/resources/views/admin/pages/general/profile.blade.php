@extends('admin.layout.app')


@push('css-top')
    <link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('page-title')
    <h3 class="page-title"> 
        Edit Profile
    </h3>
@endpush

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            
            {{-- User Info --}}
                <div class="profile-sidebar">
                    <div class="portlet light profile-sidebar-portlet ">
                        <div class="profile-userpic">
                            <img src="{{ generateURL($user->profile ?? 'default/user.svg') }}" class="img-responsive" alt="{{ str_slug($user->full_name) }}"> </div>
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">{{ $user->full_name }}</div>
                            <div class="profile-usertitle-job"> {{ $user->type }} </div>
                        </div>
                        <!-- SIDEBAR MENU -->
                        <div class="profile-usermenu"></div>
                        <!-- END MENU -->
                    </div>
                </div>

            {{-- Update Details --}}
            <form role="form" id="frmUpdateProfile" name="frmUpdateProfile" action="{{ route('admin.profile-update') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="profile-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="form-group {{ $errors->has('full_name') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Full Name</label>
                                        <input type="text" placeholder="Enter Full Name" class="form-control" id="full_name" name="full_name" value="{{ $user->full_name ?? '' }}" autocomplete="off" />
                                        @if($errors->has('full_name'))
                                            <span class="help-block">
                                                {{ $errors->first('full_name') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Email Address</label>
                                        <input type="email" placeholder="Enter Email Address" class="form-control" id="email" name="email" value="{{ $user->email }}" autocomplete="off" />
                                        @if($errors->has('contact'))
                                            <span class="help-block">
                                                {{ $errors->first('email') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group {{ $errors->has('contact') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Contact Number</label>
                                        <input type="text" placeholder="Enter Contact Number" class="form-control" id="contact" name="contact" value="{{ $user->contact }}" autocomplete="off" />
                                        @if($errors->has('contact'))
                                            <span class="help-block">
                                                {{ $errors->first('contact') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Profile Picture</label>
                                        <input type="file" placeholder="Select user's Avatar" class="form-control" id="profile" name="profile" accept=".jpg,.jpeg,.png"  />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-xs-7 text-right">
                            <input type="submit" value="Save Changes" class="btn green">
                        </div>
                        <div class="col-xs-5">
                            <a href="{{ route('admin.dashboard.index') }}" class="btn default">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('extra-js')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#frmUpdateProfile").validate({
                rules: {
                    full_name: {
                        required: true,
                        not_empty: true,
                        maxlength: 100,
                    },
                    email:{
                        required:true,
                        not_empty:true,
                        maxlength:150,
                        email: true,
                        valid_email: true,
                    },
                    contact:{
                        required:true,
                        not_empty:true,
                        maxlength:16,
                        minlength:6,
                        pattern: /^(\d+)(?: ?\d+)*$/,
                    },
                    profile:{
                        extension: "jpg|jpeg|png",
                    },
                },
                messages: {
                    full_name:{
                        required:"@lang('validation.required',['attribute'=>'full name'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'full name'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'full name','max'=>100])",
                    },
                    email:{
                        required:"@lang('validation.required',['attribute'=>'email'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'email'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'email','max'=>150])",
                        email:"@lang('validation.email',['attribute'=>'email'])",
                        valid_email:"@lang('validation.email',['attribute'=>'email'])",
                    },
                    contact:{
                        required:"@lang('validation.required',['attribute'=>'contact number'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'contact number'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'contact number','max'=>16])",
                        minlength:"@lang('validation.min.string',['attribute'=>'contact number','min'=>6])",
                        pattern: "@lang('validation.numeric', ['attribute'=>'contact number'])",
                    },
                    profile:{
                        extension:"@lang('validation.mimetypes',['attribute'=>'profile photo','value'=>'jpg,png,jpeg'])"
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

            $('#frmUpdateProfile').submit(function(){
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