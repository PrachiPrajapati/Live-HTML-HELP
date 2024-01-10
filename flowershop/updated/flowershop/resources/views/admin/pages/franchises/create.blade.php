@extends('admin.layout.app')

@push('css-top')
	<link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('franchises_create') !!}
@endpush

@push('page-title')
	<h3 class="page-title"> 
		Create a new {{ strtolower(str_singular($title)) }}
	</h3>
@endpush

@section('main-content')
	<div class="row">
        <div class="col-md-12">
            <div class="profile-content">
                <form action="{{ route('admin.franchises.store') }}" role="form" id="frmAddNewFranchises" name="frmAddNewFranchises" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">
                        <div class="portlet light ">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">Enter information in English</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                    {{-- Name --}}
                                    <div class="form-group {{ $errors->has('en_name') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Name</label>
                                        <input type="text" placeholder="Enter Name Here" class="form-control" id="en_name" name="en_name" maxlength="50" autocomplete="off" />
                                        @if($errors->has('en_name'))
                                            <span class="help-block">
                                                {{ $errors->first('en_name') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Email --}}
                                    <div class="form-group {{ $errors->has('Email') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Email</label>
                                        <input type="text" placeholder="Enter Email Here" class="form-control" id="email" name="email" maxlength="50" autocomplete="off" />
                                        @if($errors->has('Email'))
                                            <span class="help-block">
                                                {{ $errors->first('Email') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Contact Number --}}
                                    <div class="form-group {{ $errors->has('contact_number') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Contact Number</label>
                                        <input type="text" placeholder="Enter Contact Number Here" class="form-control" id="contact_number" name="contact_number" maxlength="50" autocomplete="off" />
                                        @if($errors->has('contact_number'))
                                            <span class="help-block">
                                                {{ $errors->first('contact_number') }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                   {{-- Address --}}
                                    <div class="form-group {{ $errors->has('en_address') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Address</label>
                                        <textarea rows="5" placeholder="Enter Address Here" class="form-control" id="en_address" name="en_address"  autocomplete="off"></textarea>
                                        @if($errors->has('en_address'))
                                            <span class="help-block">
                                                {{ $errors->first('en_address') }}
                                            </span>
                                        @endif
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="portlet light ">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">Enter information in Arabic</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                    {{-- Name --}}
                                    <div class="form-group {{ $errors->has('ar_name') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Name</label>
                                        <input type="text" placeholder="Enter Name Here" class="form-control" id="ar_name" name="ar_name" maxlength="50" autocomplete="off" />
                                        @if($errors->has('ar_name'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_name') }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                   {{-- Address --}}
                                    <div class="form-group {{ $errors->has('ar_address') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Address</label>
                                        <textarea rows="5" placeholder="Enter Address Here" class="form-control" id="ar_address" name="ar_address"  autocomplete="off"></textarea>
                                        @if($errors->has('ar_address'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_address') }}
                                            </span>
                                        @endif
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
                                <a href="{{ route('admin.franchises.index') }}" class="btn default">Cancel</a>
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
            $("#frmAddNewFranchises").validate({
                rules: {
                    en_name: {
                    	required: true,
                    	not_empty: true,
                    	maxlength: 255,
                    },
                    ar_name: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
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
                                type: "franchise",
                            }
                        },
                    },
                    contact_number:{
                        required:true,
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
                                type: "franchise",
                            }
                        },
                    },
                    en_address: {
                        required: true,
                        not_empty: true,
                    },
                    ar_address: {
                        required: true,
                        not_empty: true,
                    },
                },
                messages: {
                    en_name:{
                        required:"@lang('validation.required',['attribute'=>'Franchises Name'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Franchises Name'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'Franchises Name','max'=>255])",
                    },
                    ar_name:{
                        required:"@lang('validation.required',['attribute'=>'Franchises Name'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Franchises Name'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'Franchises Name','max'=>255])",
                    },
                    email:{
                        required:"@lang('validation.required',['attribute'=>' Franchises Email'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>' Franchises Email'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'Franchises Email','max'=>150])",
                        email:"@lang('validation.email',['attribute'=>'email'])",
                        valid_email:"@lang('validation.email',['attribute'=>' Franchises Email'])",
                        remote:"@lang('validation.unique',['attribute'=>'Franchises Email'])",
                    },
                    contact_number:{
                        required:"@lang('validation.required',['attribute'=>'Contact Number'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Contact Number'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'Contact Number','max'=>16])",
                        minlength:"@lang('validation.min.string',['attribute'=>'Contact Number','min'=>6])",
                        pattern:"@lang('validation.numeric',['attribute'=>'Contact Number'])",
                        remote:"@lang('validation.unique',['attribute'=>'Contact Number'])",
                    },
                    en_address:{
                        required:"@lang('validation.required',['attribute'=>'Franchises Address'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Franchises Address'])",
                    },
                    ar_address:{
                        required:"@lang('validation.required',['attribute'=>'Franchises Address'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Franchises Address'])",
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

            $('#frmAddNewFranchises').submit(function(){
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