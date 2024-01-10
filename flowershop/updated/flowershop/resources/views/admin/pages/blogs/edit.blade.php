@extends('admin.layout.app')

@push('css-top')
    <link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('blogs_update') !!}
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
                <form action="{{ route('admin.blogs.update', $blog->id) }}" role="form" id="frmAddNewUser" name="frmAddNewUser" method="POST" enctype="multipart/form-data">
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
                                        <input type="text" placeholder="Enter Blog Title Here" class="form-control" id="en_title" name="en_title" maxlength="50" autocomplete="off" value="{{ old('en_title', $blog->en_title) }}" />
                                        @if($errors->has('en_title'))
                                            <span class="help-block">
                                                {{ $errors->first('en_title') }}
                                            </span>
                                        @endif
                                    </div>
                                    {{-- Short Description --}}
                                    <div class="form-group {{ $errors->has('en_short_description') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Short Description</label>
                                        <textarea placeholder="Enter Short Description Here" class="form-control" id="en_short_description" name="en_short_description"  autocomplete="off">{{ old('en_short_description', $blog->en_short_description) }}</textarea>
                                        @if($errors->has('en_short_description'))
                                            <span class="help-block">
                                                {{ $errors->first('en_short_description') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Banner Image --}}
                                    <div class="form-group {{ $errors->has('en_banner') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! ($blog->en_banner && Storage::exists($blog->en_banner)) ? '' : $mend_sign !!}Banner Image</label>
                                        <input type="file" placeholder="Select Banner Image" class="form-control" id="en_banner" name="en_banner" accept=".jpg,.jpeg,.png" />
                                        <label class="info-note">*Upload image in ratio of 12:5 and use SVG for better results. (Width : 1920px &amp; Height : 800px)</label>
                                        @if($errors->has('en_banner'))
                                            <span class="help-block">
                                                {{ $errors->first('en_banner') }}
                                            </span>
                                        @endif
                                    </div>
                                    @php $exists = false @endphp
                                    @if ($blog->en_banner && Storage::exists($blog->en_banner))
                                        @php $exists = true @endphp
                                        <div class="form-group">
                                            <label class="control-label">Current Image</label>
                                            <div class="show-image">
                                                <img class="img img-thumbnail" style="height: 100px; width: 100px;" src="{{ generateURL($blog->en_banner) }}" alt="image-not-found">
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Short Description --}}
                                    <div class="form-group {{ $errors->has('en_description') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Description</label>
                                        <textarea placeholder="Enter Short Description Here" class="form-control" id="en_description" name="en_description"  autocomplete="off" data-error-container="#error-en-description">{{ old('en_description', $blog->en_description) }}</textarea>
                                        <span id="error-en-description"></span>
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
                                        <input type="text" placeholder="Enter Blog Title Here" class="form-control" id="ar_title" name="ar_title" maxlength="50" autocomplete="off" value="{{ old('ar_title', $blog->ar_title) }}" />
                                        @if($errors->has('ar_title'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_title') }}
                                            </span>
                                        @endif
                                    </div>
                                    {{-- Short Description --}}
                                    <div class="form-group {{ $errors->has('ar_short_description') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Short Description</label>
                                        <textarea placeholder="Enter Short Description Here" class="form-control" id="ar_short_description" name="ar_short_description"  autocomplete="off">{{ old('ar_short_description', $blog->ar_short_description) }}</textarea>
                                        @if($errors->has('ar_short_description'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_short_description') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Banner Image --}}
                                    <div class="form-group {{ $errors->has('ar_banner') ? 'has-error' : '' }}">
                                        <label class="control-label">Banner Image</label>
                                        <input type="file" placeholder="Select Banner Image" class="form-control" id="ar_banner" name="ar_banner" accept=".jpg,.jpeg,.png" />
                                        <label class="info-note">*Add image if you want to show different image in arabic version of site otherwise it'll show english version' image.</label>
                                        @if($errors->has('ar_banner'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_banner') }}
                                            </span>
                                        @endif
                                    </div>

                                    @if ($blog->ar_banner && Storage::exists($blog->ar_banner))
                                        <div class="form-group">
                                            <label class="control-label">Current Image</label>
                                            <div class="show-image">
                                                <img class="img img-thumbnail" style="height: 100px; width: 100px;" src="{{ generateURL($blog->ar_banner) }}" alt="image-not-found">
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Short Description --}}
                                    <div class="form-group {{ $errors->has('ar_description') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Description</label>
                                        <textarea placeholder="Enter Short Description Here" class="form-control" id="ar_description" name="ar_description" autocomplete="off" data-error-container="#error-ar-description">{{ old('ar_description', $blog->ar_description) }}</textarea>
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
                                <a href="{{ route('admin.blogs.index') }}" class="btn default">Cancel</a>
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
            $("#frmAddNewUser").validate({
                ignore: [],
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
                    en_short_description: {
                        required: true,
                        not_empty: true,
                        maxlength: 150,
                    },
                    ar_short_description: {
                        required: true,
                        not_empty: true,
                        maxlength: 150,
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
                    en_banner:{
                        required: true,
                        extension: "jpg|jpeg|png",
                    },
                    ar_banner:{
                        required: false,
                        extension: "jpg|jpeg|png",
                    },
                },
                messages: {
                    en_title:{
                        required:"@lang('validation.required',['attribute'=>'blog title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'blog title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'blog title','max'=>50])",
                    },
                    ar_title:{
                        required:"@lang('validation.required',['attribute'=>'blog title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'blog title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'blog title','max'=>50])",
                    },
                    en_short_description:{
                        required:"@lang('validation.required',['attribute'=>'short description'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'short description'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'short description','max'=>150])",
                    },
                    ar_short_description:{
                        required:"@lang('validation.required',['attribute'=>'short description'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'short description'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'short description','max'=>150])",
                    },
                    en_banner:{
                        required:"@lang('validation.required',['attribute'=>'banner image'])",
                        extension:"@lang('validation.mimetypes',['attribute'=>'banner image','value'=>'jpg,png,jpeg'])"
                    },
                    ar_banner:{
                        required:"@lang('validation.required',['attribute'=>'banner image'])",
                        extension:"@lang('validation.mimetypes',['attribute'=>'banner image','value'=>'jpg,png,jpeg'])"
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

            $('#frmAddNewUser').submit(function(){
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