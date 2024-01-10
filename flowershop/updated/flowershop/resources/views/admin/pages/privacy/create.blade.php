@extends('admin.layout.app')

@push('css-top')
	<link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('privacy_create') !!}
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
                <form action="{{ route('admin.privacy.store') }}" role="form" id="frmAddPrivacyPolicy" name="frmAddPrivacyPolicy" method="POST" enctype="multipart/form-data">
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
                                    {{-- Title --}}
                                    <div class="form-group {{ $errors->has('en_title') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Title</label>
                                        <input type="text" value="{{ old('en_title') }}" placeholder="Enter Title Here" class="form-control" id="en_title" name="en_title" maxlength="50" autocomplete="off" />
                                        @if($errors->has('en_title'))
                                            <span class="help-block">
                                                {{ $errors->first('en_title') }}
                                            </span>
                                        @endif
                                    </div>

                                     {{-- Details --}}
                                    <div class="form-group {{ $errors->has('en_details') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Details</label>
                                        <textarea placeholder="Enter Details Here" class="form-control" id="en_details" name="en_details"  autocomplete="off" data-error-container="#error-en-detail">{{ old('en_details') }}</textarea>
                                        <span id="error-en-details"></span>
                                        @if($errors->has('en_details'))
                                            <span class="help-block">
                                                {{ $errors->first('en_details') }}
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
                                    {{-- Title --}}
                                    <div class="form-group {{ $errors->has('ar_title') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Title</label>
                                        <input type="text" value="{{ old('ar_title') }}" placeholder="Enter Title Here" class="form-control" id="ar_title" name="ar_title" maxlength="50" autocomplete="off" />
                                        @if($errors->has('ar_title'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_title') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Details --}}
                                    <div class="form-group {{ $errors->has('ar_details') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Details</label>
                                        <textarea placeholder="Enter Short Details Here" class="form-control" id="ar_details" name="ar_details"  autocomplete="off" data-error-container="#error-en-description">{{ old('ar_details') }}</textarea>
                                        <span id="error-ar-details"></span>
                                        @if($errors->has('ar_details'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_details') }}
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
                                <a href="{{ route('admin.privacy.index') }}" class="btn default">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('extra-js')
    <script src="{{ asset('admin/plugins/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        CKEDITOR.replace("en_details", {
            filebrowserUploadMethod: 'form',
            uiColor: '#e1e1e1',
        });
        CKEDITOR.replace("ar_details", {
            filebrowserUploadMethod: 'form',
            uiColor: '#e1e1e1',
        });

        $(document).ready(function() {
            $("#frmAddPrivacyPolicy").validate({
                rules: {
                    en_title: {
                        required: true,
                        not_empty: true,
                        maxlength: 50,
                    },
                    ar_title: {
                        required: true,
                        not_empty: true,
                        maxlength: 50,
                    },
                    en_details: {
                        required: function() {
                            return CKEDITOR.instances.en_details.updateElement();
                        },
                    },
                    ar_details: {
                        required: function() {
                            return CKEDITOR.instances.ar_details.updateElement();
                        },
                    },
                },
                messages: {
                    en_title:{
                        required:"@lang('validation.required',['attribute'=>'cms pages title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'cms pages title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'cms pages title','max'=>50])",
                    },
                    ar_title:{
                        required:"@lang('validation.required',['attribute'=>'cms pages title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'cms pages title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'cms pages title','max'=>50])",
                    },
                    en_details:{
                        required:"@lang('validation.required',['attribute'=>'details'])",
                    },
                    ar_details:{
                        required:"@lang('validation.required',['attribute'=>'details'])",
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

            $('#frmAddPrivacyPolicy').submit(function(){
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