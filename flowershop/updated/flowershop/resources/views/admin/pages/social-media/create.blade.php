@extends('admin.layout.app')

@push('css-top')
	<link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('social_media_create') !!}
@endpush

@push('page-title')
	<h3 class="page-title"> 
		Add {{ strtolower(str_singular($title)) }} details
	</h3>
@endpush

@section('main-content')
	<div class="row">
        <div class="col-md-12">
            <div class="profile-content">
                <form action="{{ route('admin.social.update',1) }}" role="form" id="frmAddSocialMedia" name="frmAddSocialMedia" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-md-6">
                        <div class="portlet light ">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">Enter information in English</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                    {{-- Facebook --}}
                                    <div class="form-group {{ $errors->has('en_fb_value') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Facebook</label>
                                        @if($setting != null)
                                            <input type="text" placeholder="Enter Facebook Link Here" class="form-control" id="en_fb_value" name="en_fb_value" maxlength="50" autocomplete="off" value="{{ $setting->en_fb_value }}" />
                                        @else
                                        <input type="text" placeholder="Enter Facebook Link Here" class="form-control" id="en_fb_value" name="en_fb_value" maxlength="50" autocomplete="off" />
                                        @endif

                                        @if($errors->has('en_fb_value'))
                                            <span class="help-block">
                                                {{ $errors->first('en_fb_value') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Linkedin --}}
                                    <div class="form-group {{ $errors->has('en_linkedin_value') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Linkedin</label>
                                        @if($setting != null)
                                        <input type="text" placeholder="Enter Linkedin Link Here" class="form-control" id="en_linkedin_value" name="en_linkedin_value" maxlength="50" autocomplete="off"  value="{{ $setting->en_linkedin_value }}" />
                                        @else
                                        <input type="text" placeholder="Enter Linkedin Link Here" class="form-control" id="en_linkedin_value" name="en_linkedin_value" maxlength="50" autocomplete="off" />
                                        @endif
                                        @if($errors->has('en_linkedin_value'))
                                            <span class="help-block">
                                                {{ $errors->first('en_linkedin_value') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Insta --}}
                                    <div class="form-group {{ $errors->has('en_insta_value') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Instagram</label>
                                        @if($setting != null)
                                        <input type="text" placeholder="Enter Insta Link Here" class="form-control" id="en_insta_value" name="en_insta_value" maxlength="50" autocomplete="off"  value="{{ $setting->en_insta_value }}" />
                                        @else
                                        <input type="text" placeholder="Enter Insta Link Here" class="form-control" id="en_insta_value" name="en_insta_value" maxlength="50" autocomplete="off"  />
                                        @endif
                                        @if($errors->has('en_insta_value'))
                                            <span class="help-block">
                                                {{ $errors->first('en_insta_value') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Pintrest --}}
                                    <div class="form-group {{ $errors->has('en_pintrest_value') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Pintrest</label>
                                        @if($setting != null)
                                        <input type="text" placeholder="Enter Pintrest Link Here" class="form-control" id="en_pintrest_value" name="en_pintrest_value" maxlength="50" autocomplete="off"  value="{{ $setting->en_pintrest_value }}"  />
                                        @else
                                        <input type="text" placeholder="Enter Pintrest Link Here" class="form-control" id="en_pintrest_value" name="en_pintrest_value" maxlength="50" autocomplete="off"/>
                                        @endif
                                        @if($errors->has('en_pintrest_value'))
                                            <span class="help-block">
                                                {{ $errors->first('en_pintrest_value') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Telephone --}}
                                    <div class="form-group {{ $errors->has('en_telephone_value') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Telephone</label>
                                        @if($setting != null)
                                        <input type="text" placeholder="Enter Telephone Here" class="form-control" id="en_telephone_value" name="en_telephone_value" maxlength="50" autocomplete="off" value="{{ $setting->en_telephone_value }}"  />
                                        @else
                                        <input type="text" placeholder="Enter Telephone Here" class="form-control" id="en_telephone_value" name="en_telephone_value" maxlength="50" autocomplete="off"  />
                                        @endif
                                        @if($errors->has('en_telephone_value'))
                                            <span class="help-block">
                                                {{ $errors->first('en_telephone_value') }}
                                            </span>
                                        @endif
                                    </div>


                                    {{-- Mobile --}}
                                    <div class="form-group {{ $errors->has('en_mobile_value') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Mobile</label>
                                        @if($setting != null)
                                        <input type="text" placeholder="Enter Mobile Here" class="form-control" id="en_mobile_value" name="en_mobile_value" maxlength="50" autocomplete="off"  value="{{ $setting->en_mobile_value }}"  />
                                        @else
                                        <input type="text" placeholder="Enter Mobile Here" class="form-control" id="en_mobile_value" name="en_mobile_value" maxlength="50" autocomplete="off"/>
                                        @endif
                                        @if($errors->has('en_mobile_value'))
                                            <span class="help-block">
                                                {{ $errors->first('en_mobile_value') }}
                                            </span>
                                        @endif
                                    </div>      


                                    {{-- General Inquiries --}}
                                    <div class="form-group {{ $errors->has('en_inquiries_value') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}General Inquiries</label>
                                        @if($setting != null)
                                        <input type="text" placeholder="Enter General Inquiries Link Here" class="form-control" id="en_inquiries_value" name="en_inquiries_value" maxlength="50" autocomplete="off"  value="{{ $setting->en_inquiries_value }}"  />
                                        @else
                                        <input type="text" placeholder="Enter General Inquiries Link Here" class="form-control" id="en_inquiries_value" name="en_inquiries_value" maxlength="50" autocomplete="off"/>
                                        @endif
                                        @if($errors->has('en_inquiries_value'))
                                            <span class="help-block">
                                                {{ $errors->first('en_inquiries_value') }}
                                            </span>
                                        @endif
                                    </div>   

                                    {{-- Follow-Ups --}}
                                    <div class="form-group {{ $errors->has('en_follow_value') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Follow Ups</label>
                                        @if($setting != null)
                                        <input type="text" placeholder="Enter Follow Ups Link Here" class="form-control" id="en_follow_value" name="en_follow_value" maxlength="50" autocomplete="off"  value="{{ $setting->en_follow_value }}"  />
                                        @else
                                        <input type="text" placeholder="Enter Follow Ups Link Here" class="form-control" id="en_follow_value" name="en_follow_value" maxlength="50" autocomplete="off"/>
                                        @endif
                                        @if($errors->has('en_follow_value'))
                                            <span class="help-block">
                                                {{ $errors->first('en_follow_value') }}
                                            </span>
                                        @endif
                                    </div>       


                                    {{-- Vat --}}
                                    <div class="form-group {{ $errors->has('en_vat') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Vat</label>
                                        @if($setting != null)
                                        <input type="text" placeholder="Enter Vat Here" class="form-control" id="en_vat" name="en_vat" maxlength="50" autocomplete="off"  value="{{ $setting->en_vat }}" />
                                        @else
                                        <input type="text" placeholder="Enter Vat Here" class="form-control" id="en_vat" name="en_vat" maxlength="50" autocomplete="off"/>
                                        @endif
                                        @if($errors->has('en_vat'))
                                            <span class="help-block">
                                                {{ $errors->first('en_vat') }}
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
                                    {{-- Facebook --}}
                                    <div class="form-group {{ $errors->has('ar_fb_value') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Facebook</label>
                                        @if($setting != null)
                                            <input type="text" placeholder="Enter Facebook Link Here" class="form-control" id="ar_fb_value" name="ar_fb_value" maxlength="50" autocomplete="off" value="{{ $setting->ar_fb_value }}" />
                                        @else
                                        <input type="text" placeholder="Enter Facebook Link Here" class="form-control" id="ar_fb_value" name="ar_fb_value" maxlength="50" autocomplete="off" />
                                        @endif

                                        @if($errors->has('ar_fb_value'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_fb_value') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Linkedin --}}
                                    <div class="form-group {{ $errors->has('ar_linkedin_value') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Linkedin</label>
                                        @if($setting != null)
                                        <input type="text" placeholder="Enter Linkedin Link Here" class="form-control" id="ar_linkedin_value" name="ar_linkedin_value" maxlength="50" autocomplete="off"  value="{{ $setting->ar_linkedin_value }}" />
                                        @else
                                        <input type="text" placeholder="Enter Linkedin Link Here" class="form-control" id="ar_linkedin_value" name="ar_linkedin_value" maxlength="50" autocomplete="off" />
                                        @endif
                                        @if($errors->has('ar_linkedin_value'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_linkedin_value') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Insta --}}
                                    <div class="form-group {{ $errors->has('ar_insta_value') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Instagram</label>
                                        @if($setting != null)
                                        <input type="text" placeholder="Enter Insta Link Here" class="form-control" id="ar_insta_value" name="ar_insta_value" maxlength="50" autocomplete="off"  value="{{ $setting->ar_insta_value }}" />
                                        @else
                                        <input type="text" placeholder="Enter Insta Link Here" class="form-control" id="ar_insta_value" name="ar_insta_value" maxlength="50" autocomplete="off"  />
                                        @endif
                                        @if($errors->has('ar_insta_value'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_insta_value') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Pintrest --}}
                                    <div class="form-group {{ $errors->has('ar_pintrest_value') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Pintrest</label>
                                        @if($setting != null)
                                        <input type="text" placeholder="Enter Pintrest Link Here" class="form-control" id="ar_pintrest_value" name="ar_pintrest_value" maxlength="50" autocomplete="off"  value="{{ $setting->ar_pintrest_value }}"  />
                                        @else
                                        <input type="text" placeholder="Enter Pintrest Link Here" class="form-control" id="ar_pintrest_value" name="ar_pintrest_value" maxlength="50" autocomplete="off"/>
                                        @endif
                                        @if($errors->has('ar_pintrest_value'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_pintrest_value') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Telephone --}}
                                    <div class="form-group {{ $errors->has('ar_telephone_value') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Telephone</label>
                                        @if($setting != null)
                                        <input type="text" placeholder="Enter Telephone Here" class="form-control" id="ar_telephone_value" name="ar_telephone_value" maxlength="50" autocomplete="off" value="{{ $setting->ar_telephone_value }}"  />
                                        @else
                                        <input type="text" placeholder="Enter Telephone Here" class="form-control" id="ar_telephone_value" name="ar_telephone_value" maxlength="50" autocomplete="off"  />
                                        @endif
                                        @if($errors->has('ar_telephone_value'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_telephone_value') }}
                                            </span>
                                        @endif
                                    </div>


                                    {{-- Mobile --}}
                                    <div class="form-group {{ $errors->has('ar_mobile_value') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Mobile</label>
                                        @if($setting != null)
                                        <input type="text" placeholder="Enter Mobile Here" class="form-control" id="ar_mobile_value" name="ar_mobile_value" maxlength="50" autocomplete="off"  value="{{ $setting->ar_mobile_value }}"  />
                                        @else
                                        <input type="text" placeholder="Enter Mobile Here" class="form-control" id="ar_mobile_value" name="ar_mobile_value" maxlength="50" autocomplete="off"/>
                                        @endif
                                        @if($errors->has('ar_mobile_value'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_mobile_value') }}
                                            </span>
                                        @endif
                                    </div>      


                                    {{-- General Inquiries --}}
                                    <div class="form-group {{ $errors->has('ar_inquiries_value') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}General Inquiries</label>
                                        @if($setting != null)
                                        <input type="text" placeholder="Enter General Inquiries Link Here" class="form-control" id="ar_inquiries_value" name="ar_inquiries_value" maxlength="50" autocomplete="off"  value="{{ $setting->ar_inquiries_value }}"  />
                                        @else
                                        <input type="text" placeholder="Enter General Inquiries Link Here" class="form-control" id="ar_inquiries_value" name="ar_inquiries_value" maxlength="50" autocomplete="off"/>
                                        @endif
                                        @if($errors->has('ar_inquiries_value'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_inquiries_value') }}
                                            </span>
                                        @endif
                                    </div>   

                                    {{-- Follow-Ups --}}
                                    <div class="form-group {{ $errors->has('ar_follow_value') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Follow Ups</label>
                                        @if($setting != null)
                                        <input type="text" placeholder="Enter Follow Ups Link Here" class="form-control" id="ar_follow_value" name="ar_follow_value" maxlength="50" autocomplete="off"  value="{{ $setting->ar_follow_value }}"  />
                                        @else
                                        <input type="text" placeholder="Enter Follow Ups Link Here" class="form-control" id="ar_follow_value" name="ar_follow_value" maxlength="50" autocomplete="off"/>
                                        @endif
                                        @if($errors->has('ar_follow_value'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_follow_value') }}
                                            </span>
                                        @endif
                                    </div>       


                                    {{-- Vat --}}
                                    <div class="form-group {{ $errors->has('ar_vat') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Vat</label>
                                        @if($setting != null)
                                        <input type="text" placeholder="Enter Vat Here" class="form-control" id="ar_vat" name="ar_vat" maxlength="50" autocomplete="off"  value="{{ $setting->ar_vat }}" />
                                        @else
                                        <input type="text" placeholder="Enter Vat Here" class="form-control" id="ar_vat" name="ar_vat" maxlength="50" autocomplete="off"/>
                                        @endif
                                        @if($errors->has('ar_vat'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_vat') }}
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
                                <a href="{{ route('admin.social.index') }}" class="btn default">Cancel</a>
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
            $("#frmAddSocialMedia").validate({
                rules: {
                    en_fb_value: {
                    	required: true,
                    	not_empty: true,
                    	maxlength: 255,
                    },
                    ar_fb_value: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    en_linkedin_value: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    ar_linkedin_value: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    en_insta_value: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    ar_insta_value: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    en_pintrest_value: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    ar_pintrest_value: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    en_telephone_value: {
                        required: true,
                        not_empty: true,
                        minlength:6,
                        maxlength:16,
                        pattern: /^(\d+)(?: ?\d+)*$/,
                    },
                    ar_telephone_value: {
                        required: true,
                        not_empty: true,
                        minlength:6,
                        maxlength:16,
                        pattern: /^(\d+)(?: ?\d+)*$/,
                    },
                    en_mobile_value: {
                        required: true,
                        not_empty: true,
                        minlength:6,
                        maxlength:16,
                        pattern: /^(\d+)(?: ?\d+)*$/,
                    },
                    ar_mobile_value: {
                        required: true,
                        not_empty: true,
                        minlength:6,
                        maxlength:16,
                        pattern: /^(\d+)(?: ?\d+)*$/,
                    },
                    en_inquiries_value: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    ar_inquiries_value: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    en_follow_value: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    ar_follow_value: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    en_vat: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                        pattern: /^\d*\.?\d*$/,
                    },
                    ar_vat: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                        pattern: /^\d*\.?\d*$/,
                    },
                },
                messages: {
                    en_fb_value:{
                        required:"@lang('validation.required',['attribute'=>'Facebook'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Facebook'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'Facebook','max'=>255])",
                    },
                    ar_fb_value:{
                        required:"@lang('validation.required',['attribute'=>'Facebook'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Facebook'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'Facebook','max'=>255])",
                    },
                    en_linkedin_value:{
                        required:"@lang('validation.required',['attribute'=>'Linkedin'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Linkedin'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'Linkedin','max'=>255])",
                    },
                    ar_linkedin_value:{
                        required:"@lang('validation.required',['attribute'=>'Linkedin'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Linkedin'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'Linkedin','max'=>255])",
                    },
                    en_insta_value:{
                        required:"@lang('validation.required',['attribute'=>'Instagram'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Instagram'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'Instagram','max'=>255])",
                    },
                    ar_insta_value:{
                        required:"@lang('validation.required',['attribute'=>'Instagram'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Instagram'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'Instagram','max'=>255])",
                    },
                    en_pintrest_value:{
                        required:"@lang('validation.required',['attribute'=>'Pintrest'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Pintrest'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'Pintrest','max'=>255])",
                    },
                    ar_pintrest_value:{
                        required:"@lang('validation.required',['attribute'=>'Pintrest'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Pintrest'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'Pintrest','max'=>255])",
                    },
                    en_telephone_value:{
                        required:"@lang('validation.required',['attribute'=>'Telephone'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Telephone'])",
                        minlength:"@lang('validation.min.string',['attribute'=>'Telephone','min'=>6])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'Telephone','max'=>16])",
                        pattern:"@lang('validation.numeric',['attribute'=>'Telephone'])",
                    },
                    ar_telephone_value:{
                        required:"@lang('validation.required',['attribute'=>'Telephone'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Telephone'])",
                        minlength:"@lang('validation.min.string',['attribute'=>'Telephone','min'=>6])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'Telephone','max'=>16])",
                        pattern:"@lang('validation.numeric',['attribute'=>'Telephone'])",
                    },
                    en_mobile_value:{
                        required:"@lang('validation.required',['attribute'=>'Mobile'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Mobile'])",
                        minlength:"@lang('validation.min.string',['attribute'=>'Mobile','min'=>6])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'Mobile','max'=>16])",
                        pattern:"@lang('validation.numeric',['attribute'=>'Mobile Number'])",
                    },
                    ar_mobile_value:{
                        required:"@lang('validation.required',['attribute'=>'Mobile'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Mobile'])",
                        minlength:"@lang('validation.min.string',['attribute'=>'Mobile','min'=>6])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'Mobile','max'=>16])",
                        pattern:"@lang('validation.numeric',['attribute'=>'Mobile Number'])",
                    },
                    en_inquiries_value:{
                        required:"@lang('validation.required',['attribute'=>'General Inquiries'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'General Inquiries'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'General Inquiries','max'=>255])",
                    },
                    ar_inquiries_value:{
                        required:"@lang('validation.required',['attribute'=>'General Inquiries'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'General Inquiries'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'General Inquiries','max'=>255])",
                    },
                    en_follow_value:{
                        required:"@lang('validation.required',['attribute'=>'Follow Ups'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Follow Ups'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'Follow Ups','max'=>255])",
                    },
                    ar_follow_value:{
                        required:"@lang('validation.required',['attribute'=>'Follow Ups'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Follow Ups'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'Follow Ups','max'=>255])",
                    },
                    en_vat:{
                        required:"@lang('validation.required',['attribute'=>'Vat'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Vat'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'Vat','max'=>255])",
                        pattern:"@lang('validation.numeric',['attribute'=>'Vat'])",
                    },
                    ar_vat:{
                        required:"@lang('validation.required',['attribute'=>'Vat'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'Vat'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'Vat','max'=>255])",
                        pattern:"@lang('validation.numeric',['attribute'=>'Vat'])",
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

            $('#frmAddSocialMedia').submit(function(){
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