@extends('admin.layout.app')

@push('css-top')
	<link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('events_create') !!}
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
                <form action="{{ route('admin.services.store') }}" role="form" id="frmAddNewService" name="frmAddNewService" method="POST" enctype="multipart/form-data">
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
                                        <input type="text" placeholder="Enter Event Title Here" class="form-control" id="en_title" name="en_title" maxlength="50" autocomplete="off" value="{{ old('en_title','') }}" />
                                        @if($errors->has('en_title'))
                                            <span class="help-block">
                                                {{ $errors->first('en_title') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Banner Image --}}
                                    <div class="form-group {{ $errors->has('en_banner') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Banner Image</label>
                                        <input type="file" placeholder="Select Banner Image" class="form-control" id="en_banner" name="en_banner" accept=".jpg,.jpeg,.png" />
                                        <label class="info-note">*Upload image in ratio of 12:5 and use SVG for better results. (Width : 1920px &amp; Height : 800px)</label>
                                        @if($errors->has('en_banner'))
                                            <span class="help-block">
                                                {{ $errors->first('en_banner') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Short Description --}}
                                    <div class="form-group {{ $errors->has('en_description') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Description</label>
                                        <textarea placeholder="Enter Short Description Here" rows="3" class="form-control" id="en_description" name="en_description"  autocomplete="off" data-error-container="#error-en-description">{!! old('en_description', '') !!}</textarea>
                                        <span id="error-en-description"></span>
                                        @if($errors->has('en_description'))
                                            <span class="help-block">
                                                {{ $errors->first('en_description') }}
                                            </span>
                                        @endif
                                    </div>
                            </div>
                        </div>

                    {{--Section 1 --}}
                        <div class="portlet light ">    
                        
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">First Section Information</span>
                                </div>
                            </div>
                                    {{-- Title --}}
                                    <div class="form-group {{ $errors->has('en_section_1_title') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Title</label>
                                        <input type="text" placeholder="Enter Event Title Here" class="form-control" id="en_section_1_title" name="en_section_1_title" maxlength="50" autocomplete="off" value="{{ old('en_section_1_title', '') }}" />
                                        @if($errors->has('en_section_1_title'))
                                            <span class="help-block">
                                                {{ $errors->first('en_section_1_title') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Banner Image --}}
                                    <div class="form-group {{ $errors->has('en_section_1_image') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Banner Image</label>
                                        <input type="file" placeholder="Select Banner Image" class="form-control" id="en_section_1_image" name="en_section_1_image" accept=".jpg,.jpeg,.png" />
                                        <label class="info-note">*Upload image in ratio of 12:5 and use SVG for better results. (Width : 1920px &amp; Height : 800px)</label>
                                        @if($errors->has('en_section_1_image'))
                                            <span class="help-block">
                                                {{ $errors->first('en_section_1_image') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Short Description --}}
                                    <div class="form-group {{ $errors->has('en_section_1_description') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Description</label>
                                        <textarea placeholder="Enter Short Description Here" rows="3" class="form-control" id="en_section_1_description" name="en_section_1_description"  autocomplete="off" data-error-container="#error-en-section-1-description">{!! old('en_section_1_description', '') !!}</textarea>
                                        <span id="error-en-section-1-description"></span>
                                        @if($errors->has('en_section_1_description'))
                                            <span class="help-block">
                                                {{ $errors->first('en_section_1_description') }}
                                            </span>
                                        @endif
                                    </div>
                        </div>    

                    {{--Section 2 --}}
                        <div class="portlet light ">    
                        
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">Second Section Information</span>
                                </div>
                            </div>
                                    {{-- Title --}}
                                    <div class="form-group {{ $errors->has('en_section_2_title') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Title</label>
                                        <input type="text" placeholder="Enter Event Title Here" class="form-control" id="en_section_2_title" name="en_section_2_title" maxlength="50" autocomplete="off" value="{{ old('en_section_2_title', '') }}" />
                                        @if($errors->has('en_section_2_title'))
                                            <span class="help-block">
                                                {{ $errors->first('en_section_2_title') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Banner Image --}}
                                    <div class="form-group {{ $errors->has('en_section_2_image') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Banner Image</label>
                                        <input type="file" placeholder="Select Banner Image" class="form-control" id="en_section_2_image" name="en_section_2_image" accept=".jpg,.jpeg,.png" />
                                        <label class="info-note">*Upload image in ratio of 12:5 and use SVG for better results. (Width : 1920px &amp; Height : 800px)</label>
                                        @if($errors->has('en_section_2_image'))
                                            <span class="help-block">
                                                {{ $errors->first('en_section_2_image') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Short Description --}}
                                    <div class="form-group {{ $errors->has('en_section_2_description') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Description</label>
                                        <textarea placeholder="Enter Short Description Here" rows="3" class="form-control" id="en_section_2_description" name="en_section_2_description"  autocomplete="off" data-error-container="#error-en-section-2-description">{!! old('en_section_2_description', '') !!}</textarea>
                                        <span id="error-en-section-2-description"></span>
                                        @if($errors->has('en_section_2_description'))
                                            <span class="help-block">
                                                {{ $errors->first('en_section_2_description') }}
                                            </span>
                                        @endif
                                    </div>
                        </div>       
                    </div>


        {{-- Arabic  --}}
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
                                        <input type="text" placeholder="Enter Event Title Here" class="form-control" id="ar_title" name="ar_title" maxlength="50" autocomplete="off" value="{{ old('ar_title', '') }}" />
                                        @if($errors->has('ar_title'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_title') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Banner Image --}}
                                    <div class="form-group {{ $errors->has('ar_banner') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Banner Image</label>
                                        <input type="file" placeholder="Select Banner Image" class="form-control" id="ar_banner" name="ar_banner" accept=".jpg,.jpeg,.png" />
                                        <label class="info-note">*Add image if you want to show in arabic language otherwise it'll show english version' image.</label>
                                        @if($errors->has('ar_banner'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_banner') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Description --}}
                                    <div class="form-group {{ $errors->has('ar_description') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Description</label>
                                        <textarea placeholder="Enter Short Description Here" rows="3" class="form-control" id="ar_description" name="ar_description"  autocomplete="off" data-error-container="#error-ar-description">{!! old('ar_description', '') !!}</textarea>
                                        <span id="error-ar-description"></span>
                                        @if($errors->has('ar_description'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_description') }}
                                            </span>
                                        @endif
                                    </div>
                            </div>
                        </div>

                          {{--Section 1 --}}
                        <div class="portlet light ">    
                        
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">First Section Information</span>
                                </div>
                            </div>
                                    {{-- Title --}}
                                    <div class="form-group {{ $errors->has('ar_section_1_title') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Title</label>
                                        <input type="text" placeholder="Enter Event Title Here" class="form-control" id="ar_section_1_title" name="ar_section_1_title" maxlength="50" autocomplete="off" value="{{ old('ar_section_1_title', '') }}" />
                                        @if($errors->has('ar_section_1_title'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_section_1_title') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Banner Image --}}
                                    <div class="form-group {{ $errors->has('ar_section_1_image') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Banner Image</label>
                                        <input type="file" placeholder="Select Banner Image" class="form-control" id="ar_section_1_image" name="ar_section_1_image" accept=".jpg,.jpeg,.png" />
                                        <label class="info-note">*Upload image in ratio of 12:5 and use SVG for better results. (Width : 1920px &amp; Height : 800px)</label>
                                        @if($errors->has('ar_section_1_image'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_section_1_image') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Short Description --}}
                                    <div class="form-group {{ $errors->has('ar_section_1_description') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Description</label>
                                        <textarea placeholder="Enter Short Description Here" rows="3" class="form-control" id="ar_section_1_description" name="ar_section_1_description"  autocomplete="off" data-error-container="#error-ar-section-1-description">{!! old('ar_section_1_description', '') !!}</textarea>
                                        <span id="error-ar-section-1-description"></span>
                                        @if($errors->has('ar_section_1_description'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_section_1_description') }}
                                            </span>
                                        @endif
                                    </div>
                        </div>  

                    {{--Section 2 --}}
                        <div class="portlet light ">    
                        
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">Second Section Information</span>
                                </div>
                            </div>
                                    {{-- Title --}}
                                    <div class="form-group {{ $errors->has('ar_section_2_title') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Title</label>
                                        <input type="text" placeholder="Enter Event Title Here" class="form-control" id="ar_section_2_title" name="ar_section_2_title" maxlength="50" autocomplete="off" value="{{ old('ar_section_2_title', '') }}" />
                                        @if($errors->has('ar_section_2_title'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_section_2_title') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Banner Image --}}
                                    <div class="form-group {{ $errors->has('ar_section_2_image') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Banner Image</label>
                                        <input type="file" placeholder="Select Banner Image" class="form-control" id="ar_section_2_image" name="ar_section_2_image" accept=".jpg,.jpeg,.png" />
                                        <label class="info-note">*Upload image in ratio of 12:5 and use SVG for better results. (Width : 1920px &amp; Height : 800px)</label>
                                        @if($errors->has('ar_section_2_image'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_section_2_image') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Short Description --}}
                                    <div class="form-group {{ $errors->has('ar_section_2_description') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Description</label>
                                        <textarea placeholder="Enter Short Description Here" rows="3" class="form-control" id="ar_section_2_description" name="ar_section_2_description"  autocomplete="off" data-error-container="#error-ar-section-2-description">{!! old('ar_section_2_description', '') !!}</textarea>
                                        <span id="error-ar-section-2-description"></span>
                                        @if($errors->has('ar_section_2_description'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_section_2_description') }}
                                            </span>
                                        @endif
                                    </div>
                        </div>       
                    </div>

            {{-- Showcase Section  --}}
                    <div class="col-md-12">
                        <div class="portlet light ">
                                <h2 align="center">Showcase Information</h2>  
                          
                                <div class="row">
                                 <div class="col-sm-12 col-sm-offset-0">
                                        <div class="target">
                                        <div class="parent">
                                            
                                        </div>
                                        <div id="eventInformation">  
                                                
                                        <div id="EventGroup">
                                            <div class="child"></div>
                                            <div id="eventInformation">
                                                
                                                <div id=emaildiv class="col-sm-10" ></div>
                                                <button type="button" class="btn btn-success btninner" id="addEvent">+</button>

                                                {{-- Title English --}}
                                                <div class="form-group">
                                                    <label class="control-label">{!! $mend_sign !!}Title In English</label>

                                                    <input type="text" placeholder="Enter Event Title Here" class="form-control" id="en_title_showcase" name="en_title_showcase[]" maxlength="50" autocomplete="off" value="{{ old('en_title_showcase[]', '') }}" />

                                                    @if($errors->has('en_title_showcase[]'))
                                                    <span class="help-block">
                                                        {{ $errors->first('en_title_showcase[]') }}
                                                    </span>
                                                    @endif
                                                    @if($errors->has('en_title_showcase.*'))
                                                        <span class="help-block" style="color: red;">
                                                            {{ $errors->first('en_title_showcase.*') }}
                                                        </span>
                                                    @endif
                                                </div>


                                                {{-- Title Arabic --}}
                                                <div class="form-group">
                                                    <label class="control-label">{!! $mend_sign !!}Title In Arabic</label>

                                                    <input type="text" placeholder="Enter Event Title Here" class="form-control" id="ar_title_showcase" name="ar_title_showcase[]" maxlength="50" autocomplete="off" value="{{ old('ar_title_showcase[]', '') }}" />

                                                    @if($errors->has('ar_title_showcase[]'))
                                                    <span class="help-block">
                                                        {{ $errors->first('ar_title_showcase[]') }}
                                                    </span>
                                                    @endif
                                                    @if($errors->has('ar_title_showcase.*'))
                                                        <span class="help-block" style="color: red;">
                                                            {{ $errors->first('ar_title_showcase.*') }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <div id="namediv"></div>

                                              {{-- Banner Image --}}
                                                <div class="form-group {{ $errors->has('image_showcase') ? 'has-error' : '' }}">
                                                    <label class="control-label">{!! $mend_sign !!}Showcase Image</label>
                                                    <input type="file" placeholder="Select Showcase Image"  class="form-control" id="image_showcase" name="image_showcase[]" accept=".jpg,.jpeg,.png" />
                                                    <label class="info-note">*Upload image in ratio of 12:5 and use SVG for better results. (Width : 1920px &amp; Height : 800px)</label>
                                                    @if($errors->has('image_showcase[]'))
                                                        <span class="help-block">
                                                            {{ $errors->first('image_showcase[]') }}
                                                        </span>
                                                    @endif
                                                    @if($errors->has('image_showcase.*'))
                                                        <span class="help-block" style="color: red;">
                                                            {{ $errors->first('image_showcase.*') }}
                                                        </span>
                                                    @endif
                                                </div>  
                                            </div>
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
                                <a href="{{ route('admin.services.index') }}" class="btn default">Cancel</a>
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

            $("#frmAddNewService").validate({
                ignore: [],
                rules: {
                    en_title: {
                    	required: true,
                    	not_empty: true,
                    	maxlength: 50,
                    },
                    en_banner: {
                        required: true,
                        extension: "jpg|jpeg|png",
                    },
                    en_description: {
                        required: true,
                        not_empty: true,
                    },
                    ar_title: {
                        required: true,
                        not_empty: true,
                        maxlength: 50,
                    },
                    ar_banner:{
                        required: true,
                        extension: "jpg|jpeg|png",
                    },
                    ar_description: {
                        required: true,
                        not_empty: true,
                    },
                    en_section_1_title: {
                        required: true,
                        not_empty: true,
                        maxlength: 50,
                    },
                    en_section_1_image:{
                        required: true,
                        extension: "jpg|jpeg|png",
                    },
                    en_section_1_description: {
                        required: true,
                        not_empty: true,
                    },
                    ar_section_1_title: {
                        required: true,
                        not_empty: true,
                        maxlength: 50,
                    },
                    ar_section_1_image:{
                        required: true,
                        extension: "jpg|jpeg|png",
                    },
                    ar_section_1_description: {
                        required: true,
                        not_empty: true,
                    },
                    en_section_2_title: {
                        required: true,
                        not_empty: true,
                        maxlength: 50,
                    },
                    en_section_2_image:{
                        required: true,
                        extension: "jpg|jpeg|png",
                    },
                    en_section_2_description: {
                        required: true,
                        not_empty: true,
                    },
                    ar_section_2_title: {
                        required: true,
                        not_empty: true,
                        maxlength: 50,
                    },
                    ar_section_2_image:{
                        required: true,
                        extension: "jpg|jpeg|png",
                    },
                    ar_section_2_description: {
                        required: true,
                        not_empty: true,
                    },
                    'en_title_showcase[]': {
                        required: true,
                        not_empty: true,
                        maxlength: 50,
                    },
                    'ar_title_showcase[]': {
                        required: true,
                        not_empty: true,
                        maxlength: 50,
                    },
                    'image_showcase[]':{
                        required: true,
                        extension: "jpg|jpeg|png",
                    },   
                },             
                messages: {
                    en_title: {
                        required:"@lang('validation.required',['attribute'=>'event title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'event title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'event title','max'=>50])",
                    },
                    en_banner: {
                        required:"@lang('validation.required',['attribute'=>'banner image'])",
                        extension:"@lang('validation.mimetypes',['attribute'=>'banner image','value'=>'jpg,png,jpeg'])"
                    },
                    en_description: {
                        required:"@lang('validation.required',['attribute'=>'event description'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'event description'])", 
                    },
                    ar_title:{
                        required:"@lang('validation.required',['attribute'=>'event title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'event title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'event title','max'=>50])",
                    },
                    ar_banner:{
                        required:"@lang('validation.required',['attribute'=>'banner image'])",
                        extension:"@lang('validation.mimetypes',['attribute'=>'banner image','value'=>'jpg,png,jpeg'])"
                    },
                    ar_description:{
                        required:"@lang('validation.required',['attribute'=>'event description'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'event description'])", 
                    },
                    en_section_1_title:{
                        required:"@lang('validation.required',['attribute'=>'event title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'event title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'event title','max'=>50])",
                    },
                    en_section_1_image:{
                        required:"@lang('validation.required',['attribute'=>'banner image'])",
                        extension:"@lang('validation.mimetypes',['attribute'=>'banner image','value'=>'jpg,png,jpeg'])"
                    },
                    en_section_1_description:{
                        required:"@lang('validation.required',['attribute'=>'section description'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'section description'])", 
                    },
                    ar_section_1_title:{
                        required:"@lang('validation.required',['attribute'=>'event title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'event title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'event title','max'=>50])",
                    },
                    ar_section_1_image:{
                        required:"@lang('validation.required',['attribute'=>'banner image'])",
                        extension:"@lang('validation.mimetypes',['attribute'=>'banner image','value'=>'jpg,png,jpeg'])"
                    },
                    ar_section_1_description:{
                        required:"@lang('validation.required',['attribute'=>'section description'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'section description'])", 
                    },
                    en_section_2_title:{
                        required:"@lang('validation.required',['attribute'=>'event title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'event title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'event title','max'=>50])",
                    },
                    en_section_2_image:{
                        required:"@lang('validation.required',['attribute'=>'banner image'])",
                        extension:"@lang('validation.mimetypes',['attribute'=>'banner image','value'=>'jpg,png,jpeg'])"
                    },
                    en_section_2_description:{
                        required:"@lang('validation.required',['attribute'=>'section description'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'section description'])", 
                    },
                    ar_section_2_title:{
                        required:"@lang('validation.required',['attribute'=>'event title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'event title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'event title','max'=>50])",
                    },
                    ar_section_2_image:{
                        required:"@lang('validation.required',['attribute'=>'banner image'])",
                        extension:"@lang('validation.mimetypes',['attribute'=>'banner image','value'=>'jpg,png,jpeg'])"
                    },
                    ar_section_2_description:{
                        required:"@lang('validation.required',['attribute'=>'section description'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'section description'])", 
                    },
                    'en_title_showcase[]':{
                        required:"@lang('validation.required',['attribute'=>'title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'title','max'=>50])",
                    },
                    'ar_title_showcase[]':{
                        required:"@lang('validation.required',['attribute'=>'title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'title','max'=>50])",
                    },
                    'image_showcase[]':{
                        required:"@lang('validation.required',['attribute'=>'image'])",
                        extension:"@lang('validation.mimetypes',['attribute'=>'image','value'=>'jpg,png,jpeg'])"
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

            $('#frmAddNewService').submit(function(){
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
    
    //parent
</script>

<script type="text/javascript">

     $(document).on("click",".btninner",function(){

        $(".child").append(
            '<div id="eventInformation">'+
                '<div class="form-group">'+
                    '<label class="control-label">{!! $mend_sign !!}Title In English</label>'+
                        '<input type="text" placeholder="Enter Event Title Here" class="form-control" name="en_title_showcase[]" maxlength="50" autocomplete="off" value="{{ old("en_title_showcase[]", '') }}" />'+
                            '@if($errors->has("en_title_showcase[]"))'+
                                '<span class="help-block">'+
                                    '{{ $errors->first("en_title_showcase[]") }}'+
                                '</span>'+
                            '@endif'+
                '</div>'+

                '<div class="form-group">'+
                    '<label class="control-label">{!! $mend_sign !!}Title In Arabic</label>'+
                        '<input type="text" placeholder="Enter Event Title Here" class="form-control" name="ar_title_showcase[]" maxlength="50" autocomplete="off" value="{{ old("ar_title_showcase[]", '') }}" />'+
                                '@if($errors->has("ar_title_showcase[]"))'+
                                    '<span class="help-block">'+
                                        '{{ $errors->first("ar_title_showcase[]") }}'+
                                    '</span>'+
                                '@endif'+
                '</div>'+
                
                '<div id="namediv"></div>'+
                
                '<div class="form-group {{ $errors->has("image_showcase") ? "has-error" : '' }}">'+
                    '<label class="control-label">{!! $mend_sign !!}Showcase Image</label>'+
                    '<input type="file" placeholder="Select Showcase Image" class="form-control" name="image_showcase[]" accept=".jpg,.jpeg,.png" />'+
                    '<label class="info-note">*Upload image in ratio of 12:5 and use SVG for better results. (Width : 1920px &amp; Height : 800px)</label>'+
                    '@if($errors->has("image_showcase[]"))'+
                        '<span class="help-block">'+
                            '{{ $errors->first("image_showcase[]") }}'+
                        '</span>'+
                    '@endif'+
                '</div>'+  
                    
                '<div id=emaildiv class="col-sm-11"></div>'+
                '<button type="button" class="btn btn-danger btnclose" id="addEvent">x</button></div>');
     });

     $(document).on("click",".btnclose",function(){
        $(this).parent().remove();
     });

</script>

@endpush
