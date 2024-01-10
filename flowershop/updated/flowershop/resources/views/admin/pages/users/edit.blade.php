@extends('admin.layout.app')

@push('css-top')
	<link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('users_create') !!}
@endpush

@push('page-title')
	<h3 class="page-title"> 
		Edit {{ strtolower(str_singular($title)) }} details
	</h3>
@endpush

@section('main-content')
	<div class="col-md-12">
        <div class="profile-sidebar">
            <div class="portlet light profile-sidebar-portlet ">
                <div class="profile-userpic">
                    @if($user->first_name != null && $user->last_name != null)
                        <img src='{{ generateURL($user->profile ?? "default/user.svg") }}' class="img-responsive" alt="{{ str_slug($user->first_name.' '.$user->last_name) }}"> </div>
                    @else
                        <img src='{{ generateURL($user->profile ?? "default/user.svg") }}' class="img-responsive" alt=""> </div>
                    @endif
                <div class="profile-usertitle">
                    @if($user->first_name != null && $user->last_name != null)
                        <div class="profile-usertitle-name">{{ $user->first_name }} {{ $user->last_name[0] }}</div>
                    @else
                        <div class="profile-usertitle-name"></div>
                    @endif
                    <div class="profile-usertitle-job"> User </div>
                </div>
                <div class="profile-userbuttons">
                    <button type="button" class="btn btn-circle red btn-sm">Delete Account</button>
                </div>
                <div class="profile-usermenu"></div>
            </div>
            {{-- 
                <div class="portlet light ">
                    <div class="row list-separated profile-stat">
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="uppercase profile-stat-title"> 1 </div>
                            <div class="uppercase profile-stat-text"> Subscription </div>
                        </div>
                    </div>
                </div>
            --}}
        </div>
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#personal_info" data-toggle="tab">Personal Info</a>
                                </li>
                            </ul>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">
                                <!-- PERSONAL INFO TAB -->
                                <div class="tab-pane active" id="personal_info">
                                    <form action="{{ route('admin.users.update', $user->id) }}" role="form" id="frmUpdateUser" name="frmUpdateUser" method="POST" enctype="multipart/form-data">
                                        @csrf @method('PUT')

                                        {{-- First Name --}}
                                        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                            <label class="control-label">{!! $mend_sign !!}First Name</label>
                                            <input type="text" placeholder="Enter First Name Here" class="form-control" id="first_name" name="first_name" maxlength="50" value="{{ old('first_name', $user->first_name) }}" autocomplete="off" />
                                            @if($errors->has('first_name'))
                                                <span class="help-block">
                                                    {{ $errors->first('first_name') }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                        {{-- Last Name --}}
                                        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                            <label class="control-label">{!! $mend_sign !!}Last Name</label>
                                            <input type="text" placeholder="Enter Last Name Here" class="form-control" id="last_name" name="last_name" maxlength="50" value="{{ old('last_name', $user->last_name) }}" autocomplete="off" />
                                            @if($errors->has('last_name'))
                                                <span class="help-block">
                                                    {{ $errors->first('last_name') }}
                                                </span>
                                            @endif
                                        </div>       
                                        
                                        {{-- Email --}}
                                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                            <label class="control-label">{!! $mend_sign !!}Email Address</label>
                                            <input type="email" placeholder="Enter Email Address Here" class="form-control" id="email" name="email" maxlength="150" value="{{ old('email', $user->email) }}" autocomplete="off" />
                                            @if($errors->has('email'))
                                                <span class="help-block">
                                                    {{ $errors->first('email') }}
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Email --}}
                                        <div class="form-group {{ $errors->has('contact') ? 'has-error' : '' }}">
                                            <label class="control-label">Contact Number</label>
                                            <input type="text" placeholder="Enter Contact Number Here" class="form-control" id="contact" name="contact" maxlength="150" value="{{ old('contact', $user->contact) }}" autocomplete="off" />
                                            @if($errors->has('contact'))
                                                <span class="help-block">
                                                    {{ $errors->first('contact') }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Select Avatar</label>
                                            <input type="file" placeholder="Select Avatar" class="form-control" id="profile" name="profile" accept=".jpg,.jpeg,.png" />
                                        </div>


                                        <div class="margiv-top-10">
                                            <input type="submit" value="Save Changes" class="btn green">
                                            <a href="{{ route('admin.users.index') }}" class="btn default">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('extra-js')
    @push('extra-js')
        <script type="text/javascript">
            $(document).ready(function() {
                $("#frmUpdateUser").validate({
                    rules: {
                        first_name: {
                            required: true,
                            not_empty: true,
                            maxlength: 50,
                        },
                        last_name:{
                            required:true,
                            not_empty:true,
                            maxlength:50,
                        },
                        email:{
                            required:true,
                            not_empty:true,
                            maxlength:150,
                            email: true,
                            valid_email: true,
                            remote: {
                                url: "{{ route('admin.check.email') }}",
                                type: "post",
                                data: {
                                    _token: function() {
                                        return "{{csrf_token()}}"
                                    },
                                    type: "user",
                                    id: "{{ $user->id }}",
                                }
                            },
                        },
                        contact:{
                            required:false,
                            not_empty:true,
                            maxlength:16,
                            minlength:6,
                            pattern: /^(\d+)(?: ?\d+)*$/,
                            remote: {
                                url: "{{ route('admin.check.contact') }}",
                                type: "post",
                                data: {
                                    _token: function() {
                                        return "{{csrf_token()}}"
                                    },
                                    type: "user",
                                    id: "{{ $user->id }}",
                                }
                            },
                        },
                        profile:{
                            extension: "jpg|jpeg|png",
                        },
                    },
                    messages: {
                        first_name:{
                            required:"@lang('validation.required',['attribute'=>'first name'])",
                            not_empty:"@lang('validation.not_empty',['attribute'=>'first name'])",
                            maxlength:"@lang('validation.max.string',['attribute'=>'first name','max'=>50])",
                        },
                        last_name:{
                            required:"@lang('validation.required',['attribute'=>'last name'])",
                            not_empty:"@lang('validation.not_empty',['attribute'=>'last name'])",
                            maxlength:"@lang('validation.max.string',['attribute'=>'last name','max'=>60])",
                        },
                        email:{
                            required:"@lang('validation.required',['attribute'=>'email'])",
                            not_empty:"@lang('validation.not_empty',['attribute'=>'email'])",
                            maxlength:"@lang('validation.max.string',['attribute'=>'email','max'=>150])",
                            email:"@lang('validation.email',['attribute'=>'email'])",
                            valid_email:"@lang('validation.email',['attribute'=>'email'])",
                            remote:"@lang('validation.unique',['attribute'=>'email'])",
                        },
                        contact:{
                            required:"@lang('validation.required',['attribute'=>'contact number'])",
                            not_empty:"@lang('validation.not_empty',['attribute'=>'contact number'])",
                            maxlength:"@lang('validation.max.string',['attribute'=>'contact number','max'=>16])",
                            minlength:"@lang('validation.min.string',['attribute'=>'contact number','min'=>6])",
                            pattern:"@lang('validation.numeric',['attribute'=>'contact number'])",
                            pattern: /^(\d+)(?: ?\d+)*$/,
                            remote:"@lang('validation.unique',['attribute'=>'contact number'])",
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

                $('#frmUpdateUser').submit(function(){
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
@endpush