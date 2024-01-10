@extends('admin.layout.app')

@push('css-top')
	<link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('category_create') !!}
@endpush

@push('page-title')
	<h3 class="page-title"> 
		Create a new {{ strtolower(str_singular($title)) }}
	</h3>
@endpush

@section('main-content')             
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Add Category </span>
                </div>
            </div>
            <div class="profile-content">
                <form action="{{ route('admin.category.store') }}" role="form" id="frmAddNewCategory" name="frmAddNewCategory" method="POST" novalidate="novalidate">
                    @csrf
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory">*</span>Category Title In English</label>
                                <input type="text" placeholder="Enter Category Title" class="form-control" name="en_title" value="{{ old('en_title') }}" maxlength="50" autocomplete="off">
                                @if($errors->has('en_title'))
                                    <span class="help-block">
                                        {{ $errors->first('en_title') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group  col-md-4">
                                <label class="control-label"><span class="mendatory">*</span>Category Title In Arabic</label>
                                <input type="text" placeholder="Enter Category Title" class="form-control" name="ar_title" value="{{ old('ar_title') }}" maxlength="50" autocomplete="off">
                                @if($errors->has('ar_title'))
                                    <span class="help-block">
                                        {{ $errors->first('ar_title') }}
                                    </span>
                                @endif
                            </div>
                        </div><br>
                        <div class="row">
                             <div class="form-group  col-md-4">
                                <label class="control-label"><span class="mendatory">*</span>Category Image</label>
                                <div class="upload">
                                    <input type="file" name="image" class="file-upload color" accept="image/*">
                                </div>
                                @if($errors->has('image'))
                                    <span class="help-block">
                                        {{ $errors->first('image') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <br><br>
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <span class="caption-subject bold uppercase"> Add Product Type And Product Shape </span>
                            </div>
                        </div>  
                        <br>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory">*</span>Select Box
                                    Type</label>
                                <select class="form-control" name="box[]">
                                    <option value="">Select Type</option>
                                    @foreach($boxes as $box)
                                        <option value="{{ $box->id }}">{{ $box->getTitle() }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('box.*'))
                                    <span class="help-block" style="color: red;">
                                        {{ $errors->first('box.*') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory">*</span>Select Product
                                    Shape</label>
                                <select class="form-control" name="shape[]">
                                    <option value="">Select Shape</option>
                                    @foreach($shapes as $shape)
                                        <option value="{{ $shape->id }}">{{ $shape->getTitle() }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('shape.*'))
                                    <span class="help-block" style="color: red;">
                                        {{ $errors->first('shape.*') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="category-add"></div>
                        
                        <div class="col-md-4">
                            <br><br>
                            <input type="button" value="Add" class="btn grey btnAddCategory">
                        </div>     
                    
                        <div class="col-md-12">
                            <br><br>
                            <div class="row">
                                <div class="col-xs-6 text-right">
                                    <input type="submit" value="Save Changes" class="btn green">
                                </div>
                                <div class="col-xs-6">
                                    <a href="{{ route('admin.category.index') }}" class="btn default">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
                    }
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
                    }
                  },
                }
            });
        });


        $(document).on("click",".btnAddCategory",function(){
            $(".category-add").append(
                '<div class="row">'+
                    '<br>'+
                    '<div class="form-group col-md-4">'+
                        '<select class="form-control" name="box[]">'+
                            '<option value="">Select Type</option>'+
                            '@foreach($boxes as $box)'+
                                '<option value="{{ $box->id }}">{{ $box->getTitle() }}</option>'+
                            '@endforeach'+
                        '</select>'+
                    '</div>'+
                    '<div class="form-group col-md-4">'+
                        '<select class="form-control" name="shape[]">'+
                            '<option value="">Select Shape</option>'+
                            '@foreach($shapes as $shape)'+
                                '<option value="{{ $shape->id }}">{{ $shape->getTitle() }}</option>'+
                            '@endforeach'+
                        '</select>'+
                    '</div>'+
                    '<div class="form-group col-md-4" >'+
                        '<button type="button" class="btn btnclose" id="addEvent">x</button></div>'+
                    '</div>'+
                '</div>');
        
            $(document).on("click",".btnclose",function(){
                $(this).parent().parent().remove();
            });

        });

        $("#frmAddNewCategory").validate({
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
                'box[]': {
                    required: true,
                    not_empty: true,
                    maxlength: 50,
                },
                'shape[]': {
                    required: true,
                    not_empty: true,
                    maxlength: 50,
                },
            },
            messages: {
                en_title :{
                    required:"@lang('validation.required',['attribute'=>'category title'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'category title'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'category title','max'=>255])",
                },
                ar_title :{
                    required:"@lang('validation.required',['attribute'=>'category title'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'category title'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'category title','max'=>255])",
                },
                image:{
                    required:"@lang('validation.required',['attribute'=>'category image'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'category image'])",
                    extension:"@lang('validation.mimetypes',['attribute'=>'category image','value'=>'jpg,png,jpeg'])"
                },
                'box[]': {
                    required:"@lang('validation.required',['attribute'=>'product type'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'product type'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'product type','max'=>50])",
                },
                'shape[]': {
                    required:"@lang('validation.required',['attribute'=>'product shape'])",
                    not_empty:"@lang('validation.not_empty',['attribute'=>'product shape'])",
                    maxlength:"@lang('validation.max.string',['attribute'=>'product shape','max'=>50])",
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

        $('#frmAddNewCategory').submit(function(){
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