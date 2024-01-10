@extends('admin.layout.app')

@push('css-top')
	<link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('faqs_create') !!}
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
                <form action="{{ route('admin.faqs.store') }}" role="form" id="frmAddNewFaqs" name="frmAddNewFaqs" method="POST" enctype="multipart/form-data">
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
                                    {{-- Question --}}
                                    <div class="form-group {{ $errors->has('en_question') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Question</label>
                                        <input type="text" placeholder="Enter Question Here" class="form-control" id="en_question" name="en_question" maxlength="255" autocomplete="off" />
                                        @if($errors->has('en_question'))
                                            <span class="help-block">
                                                {{ $errors->first('en_question') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Answer --}}
                                    <div class="form-group {{ $errors->has('en_answer') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Answer</label>
                                        <textarea rows="5" placeholder="Enter Answer Here" class="form-control" id="en_answer" name="en_answer"  autocomplete="off"></textarea>
                                        @if($errors->has('en_answer'))
                                            <span class="help-block">
                                                {{ $errors->first('en_answer') }}
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
                                    {{-- Question --}}
                                    <div class="form-group {{ $errors->has('ar_question') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Question</label>
                                        <input type="text" placeholder="Enter Question Here" class="form-control" id="ar_question" name="ar_question" maxlength="255" autocomplete="off" />
                                        @if($errors->has('ar_question'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_question') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Answer --}}
                                    <div class="form-group {{ $errors->has('ar_answer') ? 'has-error' : '' }}">
                                        <label class="control-label">{!! $mend_sign !!}Answer</label>
                                        <textarea rows="5" placeholder="Enter Answer Here" class="form-control" id="ar_answer" name="ar_answer"  autocomplete="off"></textarea>
                                        @if($errors->has('ar_answer'))
                                            <span class="help-block">
                                                {{ $errors->first('ar_answer') }}
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
                                <a href="{{ route('admin.faqs.index') }}" class="btn default">Cancel</a>
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
        CKEDITOR.replace("en_answer", {
            filebrowserUploadMethod: 'form',
            uiColor: '#e1e1e1',
        });
        CKEDITOR.replace("ar_answer", {
            filebrowserUploadMethod: 'form',
            uiColor: '#e1e1e1',
        });

        $(document).ready(function() {
            $("#frmAddNewFaqs").validate({
                rules: {
                    en_question: {
                    	required: true,
                    	not_empty: true,
                    	maxlength: 255,
                    },
                    ar_question: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    en_answer: {
                        required: function() {
                            return CKEDITOR.instances.en_answer.updateElement();
                        },
                    },
                    ar_answer: {
                        required: function() {
                            return CKEDITOR.instances.ar_answer.updateElement();
                        },
                    },
                },
                messages: {
                    en_question:{
                        required:"@lang('validation.required',['attribute'=>'question'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'question'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'question','max'=>255])",
                    },
                    ar_question:{
                        required:"@lang('validation.required',['attribute'=>'question'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'question'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'question','max'=>255])",
                    },
                    en_answer:{
                        required:"@lang('validation.required',['attribute'=>'answer'])",
                    },
                    ar_answer:{
                        required:"@lang('validation.required',['attribute'=>'answer'])",
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

            $('#frmAddNewFaqs').submit(function(){
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