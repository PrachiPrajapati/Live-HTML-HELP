@extends('admin.layout.app')

@push('css-top')
    <link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('delivery_charges_update') !!}
@endpush

@push('page-title')
    <h3 class="page-title"> 
        Update {{ strtolower(str_singular($title)) }}
    </h3>
@endpush

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="profile-content">
                <form action="{{ route('admin.delivery-charges.update', $deliveryCharge->id) }}" role="form" id="frmAddNewUser" name="frmAddNewUser" method="POST" enctype="multipart/form-data">
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
                                    {{-- Country --}}
                                    <div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}City Name</label>
                                        <select class="form-control select2" name="country_id" id="country_id" data-error-container="#error-country-detail">
                                            <option></option>
                                            @foreach ($countries as $country)
                                                <option {{ $country->id == $deliveryCharge->country_id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->en_name }}</option>
                                            @endforeach
                                        </select>
                                        <span id="error-country-detail"></span>
                                        @if($errors->has('country_id'))
                                            <span class="help-block">
                                                {{ $errors->first('country_id') }}
                                            </span>
                                        @endif
                                    </div>
                                    {{-- City Name --}}
                                    <div class="form-group {{ $errors->has('en_city') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}City Name</label>
                                        <input type="text" placeholder="Enter City Name Here" class="form-control" id="en_city" name="en_city" maxlength="50" autocomplete="off" value="{{ old('en_city', $deliveryCharge->en_city) }}" />
                                        @if($errors->has('en_city'))
                                            <span class="help-block">
                                                {{ $errors->first('en_city') }}
                                            </span>
                                        @endif
                                    </div>
                                    {{-- Minimum Amount --}}
                                    <div class="form-group {{ $errors->has('minimum_amount') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Minimum Amount</label>
                                        <input type="number" placeholder="Enter Minimum Amount Here" class="form-control" id="minimum_amount" name="minimum_amount" maxlength="50" autocomplete="off" value="{{ old('minimum_amount', $deliveryCharge->minimum_amount) }}" />
                                        @if($errors->has('minimum_amount'))
                                            <span class="help-block">
                                                {{ $errors->first('minimum_amount') }}
                                            </span>
                                        @endif
                                    </div>
                                    {{-- Charges --}}
                                    <div class="form-group {{ $errors->has('charges') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Charges</label>
                                        <input type="number" placeholder="Enter Charges Details Here" class="form-control" id="charges" name="charges" maxlength="50" autocomplete="off" value="{{ old('charges', $deliveryCharge->charges) }}" />
                                        @if($errors->has('charges'))
                                            <span class="help-block">
                                                {{ $errors->first('charges') }}
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
                                    {{-- City Name --}}
                                    <div class="form-group {{ $errors->has('ar_city') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}City Name</label>
                                        <input type="text" placeholder="Enter City Name Here" class="form-control" id="ar_city" name="ar_city" maxlength="50" autocomplete="off" value="{{ old('ar_city', $deliveryCharge->ar_city) }}" />
                                        @if($errors->has('ar_city'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_city') }}
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
                                <a href="{{ route('admin.delivery-charges.index') }}" class="btn default">Cancel</a>
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
            $("#frmAddNewUser").validate({
                rules: {
                    country_id: {
                        required: true,
                        not_empty: true,
                        maxlength: 50,
                    },
                    en_city: {
                        required: true,
                        not_empty: true,
                        maxlength: 50,
                    },
                    ar_city: {
                        required: true,
                        not_empty: true,
                        maxlength: 50,
                    },
                    minimum_amount: {
                        required: true,
                        not_empty: true,
                        maxlength: 50,
                    },
                    charges: {
                        required: true,
                        not_empty: true,
                        maxlength: 50,
                    },
                },
                messages: {
                    country_id: {
                        required:"@lang('validation.required',['attribute'=>'country name'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'country name'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'country name','max'=>50])",
                    },
                    en_city: {
                        required:"@lang('validation.required',['attribute'=>'city name'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'city name'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'city name','max'=>50])",
                    },
                    ar_city: {
                        required:"@lang('validation.required',['attribute'=>'city name'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'city name'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'city name','max'=>50])",
                    },
                    minimum_amount: {
                        required:"@lang('validation.required',['attribute'=>'minimum amount'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'minimum amount'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'minimum amount','max'=>50])",
                    },
                    charges: {
                        required:"@lang('validation.required',['attribute'=>'charges'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'charges'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'charges','max'=>50])",
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

            $(".select2").select2({
                placeholder: "Select Country",
            })
        });
    </script>
@endpush