@extends('admin.layout.app')

@push('css-top')
	<link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('shape_create') !!}
@endpush

@push('page-title')
	<h3 class="page-title"> 
		Add a new {{ strtolower(str_singular($title)) }}
	</h3>
@endpush

@section('main-content')
<div class="row">
        <form id="frmAddNewShape" name="frmAddNewShape" role="form"  method="POST" action="{{ route('admin.shape.store') }}" enctype="multipart/form-data" novalidate="novalidate">
        @csrf
            <div class="col-md-6">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <span class="caption-subject bold uppercase">Enter information in English</span>
                        </div>
                    </div>
                    <div class="profile-content">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="control-label"><span class="mendatory">*</span>Shape Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Enter Shape Title">
                                    @if($errors->has('title'))
                                        <span class="help-block">
                                            {{ $errors->first('title') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="control-label"><span class="mendatory">*</span>Shape Height</label>
                                    <input type="text" name="height" class="form-control" value="{{ old('height') }}" placeholder="Enter Shape Height">
                                    @if($errors->has('height'))
                                        <span class="help-block">
                                            {{ $errors->first('height') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="control-label"><span class="mendatory">*</span>Shape Width</label>
                                    <input type="text" name="width" class="form-control" value="{{ old('width') }}" placeholder="Enter Shape Width">
                                    @if($errors->has('width'))
                                        <span class="help-block">
                                            {{ $errors->first('width') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="control-label"><span class="mendatory">*</span>Shape Depth</label>
                                    <input type="text" name="depth" class="form-control" value="{{ old('depth') }}" placeholder="Enter Shape Depth">
                                    @if($errors->has('depth'))
                                        <span class="help-block">
                                            {{ $errors->first('depth') }}
                                        </span>
                                    @endif
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <span class="caption-subject bold uppercase">Enter information in Arabic</span>
                        </div>
                    </div>
                    <div class="profile-content">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="control-label"><span class="mendatory">*</span>Shape Title</label>
                                    <input type="text" name="ar_title" class="form-control" value="{{ old('ar_title') }}" placeholder="Enter Shape Title">
                                    @if($errors->has('ar_title'))
                                        <span class="help-block">
                                            {{ $errors->first('ar_title') }}
                                        </span>
                                    @endif
                                </div>
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
                        <a href="{{ route('admin.shape.index') }}" class="btn default">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>             
@endsection

@push('css-top')
    <link href="{{ asset('admin/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/filepond.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/filepond-plugin-image-preview.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('extra-js')
    <script src="{{ asset('admin/js/filepond.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/js/filepond.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/js/filepond-plugin-image-preview.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/js/filepond-plugin-file-validate-type.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#frmAddNewShape").validate({
                rules: {
                    title: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    ar_title: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    height:{
                        required: true,
                        not_empty: true,
                        maxlength:16,
                        pattern: /^\d*\.?\d*$/,
                    },
                    width:{
                        required: true,
                        not_empty: true,
                        maxlength:16,
                        pattern: /^\d*\.?\d*$/,
                    },
                    depth:{
                        required: true,
                        not_empty: true,
                        maxlength:16,
                        pattern: /^\d*\.?\d*$/,
                    },
                },
                messages: {
                    title :{
                        required:"@lang('validation.required',['attribute'=>'shape title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'shape title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'shape title','max'=>255])",
                    },
                    ar_title:{
                        required:"@lang('validation.required',['attribute'=>'shape title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'shape title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'shape title','max'=>255])",
                    },
                    height:{
                        required:"@lang('validation.required',['attribute'=>'shape height'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'shape height'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'shape height','max'=>16])",
                        pattern:"@lang('validation.numeric',['attribute'=>'shape height'])",
                    },
                    width:{
                        required:"@lang('validation.required',['attribute'=>'shape width'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'shape width'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'shape width','max'=>16])",
                        pattern:"@lang('validation.numeric',['attribute'=>'shape width'])",
                    },
                    depth:{
                        required:"@lang('validation.required',['attribute'=>'shape depth'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'shape depth'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'shape depth','max'=>16])",
                        pattern:"@lang('validation.numeric',['attribute'=>'shape depth'])",
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

            $('#frmAddNewShape').submit(function(){
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