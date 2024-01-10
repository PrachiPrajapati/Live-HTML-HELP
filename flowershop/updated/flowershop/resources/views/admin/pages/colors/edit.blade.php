@extends('admin.layout.app')

@push('css-top')
	<link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('color_update') !!}
@endpush

@push('page-title')
	<h3 class="page-title"> 
		Update {{ strtolower(str_singular($title)) }} details
	</h3>
@endpush

@section('main-content')             
<div class="row">
    <form action="{{ route('admin.color.update',$color->custom_id) }}" role="form" id="frmEditColor" name="frmEditColor" method="POST" enctype="multipart/form-data" novalidate="novalidate">
        @csrf
        @method('PUT')
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
                                    <label class="control-label"><span class="mendatory">*</span>Color Title</label>
                                    <input type="text" placeholder="Enter Color Title" value="{{ old('title', $color->title) }}" class="form-control" name="en_title" maxlength="50" autocomplete="off">
                                    @if($errors->has('en_title'))
                                        <span class="help-block">
                                            {{ $errors->first('en_title') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group  col-md-12">
                                    <label class="control-label"><span class="mendatory">*</span>Color Image</label>
                                    <div class="upload">
                                        <input type="file" name="image" class="file-upload color" accept="image/*">
                                    </div>
                                    @if($errors->has('image'))
                                        <span class="help-block">
                                            {{ $errors->first('image') }}
                                        </span>
                                    @endif
                                </div>

                                @php $exists = false @endphp
                                @if ($color->image && Storage::exists($color->image))
                                    @php $exists = true @endphp
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Current Image</label>
                                        <div class="show-image">
                                            <img class="img img-thumbnail" style="height: 80px; width: 80px;" src="{{ generateURL($color->image)}}" alt="image-not-found">
                                        </div>
                                    </div>
                                @endif
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
                                    <label class="control-label"><span class="mendatory">*</span>Color Title</label>
                                    <input type="text" placeholder="Enter Color Title" value="{{ old('ar_title',$color->ar_title) }}" class="form-control" name="ar_title" maxlength="50" autocomplete="off">
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
                        <a href="{{ route('admin.color.index') }}" class="btn default">Cancel</a>
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

        // filepond
        $(function () {

            // First register any plugins
            $.fn.filepond.registerPlugin(FilePondPluginImagePreview);
            $.fn.filepond.registerPlugin(FilePondPluginFileValidateType);

            // Turn input element into a pond
            $('.file-upload').filepond({
                allowReorder: true,
                imagePreviewHeight: 130
            });

            FilePond.setOptions({
                server: {
                    url: '{{ route("admin.color.store") }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                }
            });
        });

        // filepond
        $(function () {

            // First register any plugins
            $.fn.filepond.registerPlugin(FilePondPluginImagePreview);
            $.fn.filepond.registerPlugin(FilePondPluginFileValidateType);

            // Turn input element into a pond
            $('.file-upload').filepond({
                allowReorder: true,
                imagePreviewHeight: 130
            });

            FilePond.setOptions({
                server: {
                    url: '{{ route("admin.color.store") }}',
                    method: 'POST',
                    process: {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',        
                        },
                        ondata: (formData) => {
                            var en_title = $("input[name='en_title']").val();
                            var ar_title = $("input[name='ar_title']").val();                       
                            
                            formData.append('filepond_request',true);
                            formData.append('en_title_filepond',en_title);
                            formData.append('ar_title_filepond',ar_title);
                            return formData;
                        },
                  },
                }
            });
        });

        $(document).ready(function() {
            $("#frmEditColor").validate({
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
                    image:{
                        required: true,
                        not_empty: true,
                        extension: "jpg|jpeg|png",
                    }, 
                },
                messages: {
                    en_title :{
                        required:"@lang('validation.required',['attribute'=>'color title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'color title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'color title','max'=>255])",
                    },
                    ar_title :{
                        required:"@lang('validation.required',['attribute'=>'color title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'color title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'color title','max'=>255])",
                    },
                    image:{
                        required:"@lang('validation.required',['attribute'=>'color image'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'color image'])",
                        extension:"@lang('validation.mimetypes',['attribute'=>'color image','value'=>'jpg,png,jpeg'])"
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

            $('#frmEditColor').submit(function(){
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