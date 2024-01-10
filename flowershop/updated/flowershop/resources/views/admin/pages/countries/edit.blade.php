@extends('admin.layout.app')

@push('css-top')
    <link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('country_update') !!}
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
                <form action="{{ route('admin.countries.update', $country->id) }}" role="form" id="frmUpdateCountry" name="frmUpdateCountry" method="POST" enctype="multipart/form-data">
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
                                    {{-- Name --}}
                                    <div class="form-group {{ $errors->has('en_name') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Name</label>
                                        <input type="text" placeholder="Enter Name Here" class="form-control" id="en_name" name="en_name" maxlength="50" autocomplete="off" value="{{ old('en_name', $country->en_name) }}" />
                                        @if($errors->has('en_name'))
                                            <span class="help-block">
                                                {{ $errors->first('en_name') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Url --}}
                                    <div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Url</label>
                                        <input type="text" placeholder="Enter Url Here" class="form-control" name="url" autocomplete="off" value="{{ old('en_name', $country->url) }}" />
                                        @if($errors->has('url'))
                                            <span class="help-block">
                                                {{ $errors->first('url') }}
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
                                        <input type="text" placeholder="Enter Name Here" class="form-control" id="ar_name" name="ar_name" maxlength="50" autocomplete="off" value="{{ old('ar_name', $country->ar_name) }}" />
                                        @if($errors->has('ar_name'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_name') }}
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
                                <a href="{{ route('admin.countries.index') }}" class="btn default">Cancel</a>
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
            $("#frmUpdateCountry").validate({
                rules: {
                    en_name: {
                        required: true,
                        not_empty: true,
                        maxlength: 50,
                    },
                    url: {
                        required: true,
                        not_empty: true,
                        maxlength: 155,
                    },
                    ar_name: {
                        required: true,
                        not_empty: true,
                        maxlength: 50,
                    },
                },
                messages: {
                    en_name:{
                        required:"@lang('validation.required',['attribute'=>'country name'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'country name'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'country name','max'=>50])",
                    },
                    url:{
                        required:"@lang('validation.required',['attribute'=>'country url'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'country url'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'country url','max'=>155])",
                    },
                    ar_name:{
                        required:"@lang('validation.required',['attribute'=>'country name'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'country name'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'country name','max'=>50])",
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

            $('#frmUpdateCountry').submit(function(){
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