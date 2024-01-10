@extends('admin.layout.app')

@push('css-top')
    <link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('careers_update') !!}
@endpush

@push('page-title')
    <h3 class="page-title"> 
        Update {{ strtolower(str_singular($title)) }} details
    </h3>
@endpush

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="profile-content">
                <form action="{{ route('admin.careers.update', $career->id) }}" role="form" id="frmUpdateCareer" name="frmUpdateCareer" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
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
                                        <input type="text" placeholder="Enter Title Here" class="form-control" id="en_title" name="en_title" maxlength="50" autocomplete="off" value="{{ old('en_title', $career->en_title) }}" />
                                        @if($errors->has('en_title'))
                                            <span class="help-block">
                                                {{ $errors->first('en_title') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Sort Description --}}
                                    <div class="form-group {{ $errors->has('en_sort_description') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Sort Description</label>
                                        <textarea placeholder="Enter Short Details Here" class="form-control" id="en_sort_description" name="en_sort_description"  autocomplete="off" data-error-container="#error-en-sort-description">{!! old('en_sort_description', $career->en_sort_description) !!}</textarea>
                                        <span id="error-en-sort-description"></span>
                                        @if($errors->has('en_sort_description'))
                                            <span class="help-block">
                                                {{ $errors->first('en_sort_description') }}
                                            </span>
                                        @endif
                                    </div>  

                                    {{-- Description --}}
                                    <div class="form-group {{ $errors->has('en_description') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Description</label>
                                        <textarea placeholder="Enter Short Details Here" class="form-control" id="en_description" name="en_description"  autocomplete="off" data-error-container="#error-en-description">{{ old('en_description', $career->en_description) }}</textarea>
                                        <span id="error-ar-details"></span>
                                        @if($errors->has('en_description'))
                                            <span class="help-block">
                                                {{ $errors->first('en_description') }}
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
                                        <input type="text" placeholder="Enter Title Here" class="form-control" id="ar_title" name="ar_title" maxlength="50" autocomplete="off" value="{{ old('ar_title', $career->ar_title) }}" />
                                        @if($errors->has('ar_title'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_title') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Sort Description --}}
                                    <div class="form-group {{ $errors->has('ar_sort_description') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Sort Description</label>
                                        <textarea placeholder="Enter Short Details Here" class="form-control" id="ar_sort_description" name="ar_sort_description"  autocomplete="off" data-error-container="#error-ar-sort-description">{!! old('ar_sort_description', $career->ar_sort_description) !!}</textarea>
                                        <span id="error-ar-sort-description"></span>
                                        @if($errors->has('ar_sort_description'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_sort_description') }}
                                            </span>
                                        @endif
                                    </div> 

                                    {{-- Description --}}
                                    <div class="form-group {{ $errors->has('ar_description') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Description</label>
                                        <textarea placeholder="Enter Short Details Here" class="form-control" id="ar_description" name="ar_description"  autocomplete="off" data-error-container="#error-ar-description">{{ old('ar_description', $career->ar_description) }}</textarea>
                                        <span id="error-ar-description"></span>
                                        @if($errors->has('ar_description'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_description') }}
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
                                <a href="{{ route('admin.careers.index') }}" class="btn default">Cancel</a>
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
        CKEDITOR.replace("en_sort_description", {
            filebrowserUploadMethod: 'form',
            uiColor: '#e1e1e1',
            filebrowserUploadUrl: "{{route('admin.image.upload', ['_token' => csrf_token() ])}}",
        });
        CKEDITOR.replace("ar_sort_description", {
            filebrowserUploadMethod: 'form',
            uiColor: '#e1e1e1',
            filebrowserUploadUrl: "{{route('admin.image.upload', ['_token' => csrf_token() ])}}",
        });
        CKEDITOR.replace("en_description", {
            filebrowserUploadMethod: 'form',
            uiColor: '#e1e1e1',
            filebrowserUploadUrl: "{{route('admin.image.upload', ['_token' => csrf_token() ])}}",
        });
        CKEDITOR.replace("ar_description", {
            filebrowserUploadMethod: 'form',
            uiColor: '#e1e1e1',
            filebrowserUploadUrl: "{{route('admin.image.upload', ['_token' => csrf_token() ])}}",
        });
        $(document).ready(function() {
            $("#frmUpdateCareer").validate({
                rules: {
                    en_title: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    ar_title: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    en_sort_description: {
                        required: function() {
                            return CKEDITOR.instances.en_sort_description.updateElement();
                        },
                    },
                    ar_sort_description: {
                        required: function() {
                            return CKEDITOR.instances.ar_sort_description.updateElement();
                        },
                    },
                    en_description: {
                        required: function() {
                            return CKEDITOR.instances.en_description.updateElement();
                        },
                    },
                    ar_description: {
                        required: function() {
                            return CKEDITOR.instances.ar_description.updateElement();
                        },
                    },
                },
                messages: {
                    en_title:{
                        required:"@lang('validation.required',['attribute'=>'career title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'career title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'career title','max'=>255])",
                    },
                    ar_title:{
                        required:"@lang('validation.required',['attribute'=>'career title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'career title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'career title','max'=>255])",
                    },
                    en_sort_description:{
                        required:"@lang('validation.required',['attribute'=>'sort description'])",
                    },
                    ar_sort_description:{
                        required:"@lang('validation.required',['attribute'=>'sort description'])",
                    },
                    en_description:{
                        required:"@lang('validation.required',['attribute'=>'description'])",
                    },
                    ar_description:{
                        required:"@lang('validation.required',['attribute'=>'description'])",
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

            $('#frmUpdateCareer').submit(function(){
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