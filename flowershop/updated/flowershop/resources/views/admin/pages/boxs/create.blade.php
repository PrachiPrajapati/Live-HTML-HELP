@extends('admin.layout.app')

@push('css-top')
    <link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('box_create') !!}
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
                    <span class="caption-subject bold uppercase"> Add Box </span>
                </div>
            </div>
            <div class="profile-content">
                <form action="{{ route('admin.box.store') }}" role="form" id="frmAddNewBox" name="frmAddNewBox" method="POST" enctype="multipart/form-data" novalidate="novalidate">
                    @csrf
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group  col-md-4">
                                <label class="control-label"><span class="mendatory">*</span>Box Type Title In English</label>
                                <input type="text" placeholder="Enter Box Title" class="form-control" name="en_title" value="{{ old('en_title') }}" maxlength="50" autocomplete="off">
                                @if($errors->has('en_title'))
                                    <span class="help-block">
                                        {{ $errors->first('en_title') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group  col-md-4">
                                <label class="control-label"><span class="mendatory">*</span>Box Type Title In Arabic</label>
                                <input type="text" placeholder="Enter Box Title" class="form-control" name="ar_title" value="{{ old('ar_title') }}" maxlength="50" autocomplete="off">
                                @if($errors->has('ar_title'))
                                    <span class="help-block">
                                        {{ $errors->first('ar_title') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <br>
    
                        <div class="col-md-12">
                            <div class="col-md-2">
                                <label class="control-label"><span class="mendatory">*</span>Add Box Shapes</label>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-4">
                                <input type="button" value="Add" class="btn grey btnAddBox">
                            </div> 
                        </div>
                        <br><br><br>
                        <div class="box-add"></div>

                        <div class="row">
                            <div class="form-group col-md-12">
                            </div>
                            <div class="form-group  col-md-4">
                                <select class="form-control shape_title" name="shape_title[0]">
                                    <option value="">Select Shape title</option>
                                    @foreach($shapes as $shape)
                                        <option value="{{ $shape->id }}">{{ $shape->getTitle() }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('shape_title.*'))
                                    <span class="help-block" style="color: red;">
                                        {{ $errors->first('shape_title.*') }}
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-md-4" >
                                <div class="upload">
                                    <input type="file" name="image[0]" class="file-upload">
                                </div>
                            </div> 
                        </div>                        
                    </div>
                    <div class="col-md-12">
                        <br><br>
                        <div class="row">
                            <div class="col-xs-6 text-right">
                                <input type="submit" value="Save Changes" class="btn green">
                            </div>
                            <div class="col-xs-6">
                                <a href="{{ route('admin.box.index') }}" class="btn default">Cancel</a>
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
        // First register any plugins
        $.fn.filepond.registerPlugin(FilePondPluginImagePreview);
        $.fn.filepond.registerPlugin(FilePondPluginFileValidateType);

        // Turn input element into a pond
        $('.file-upload').filepond({
            allowReorder: true,
            imagePreviewHeight: 130
        });

        

        $(function(){
            // First register any plugins
            $.fn.filepond.registerPlugin(
                FilePondPluginImagePreview
            );

            var count = 1;

            $(document).on('click', '.btnAddBox', function(e) {

                $(".box-add").prepend(
                         '<div class="row">'+
                            '<div class="form-group col-md-4">'+
                                '<select class="form-control shape_title" name="shape_title['+count+']">'+
                                    '<option value="">Select Shape title</option>'+
                                    '@foreach($shapes as $shape)'+
                                        '<option value="{{ $shape->id }}">{{ $shape->getTitle() }}</option>'+
                                    '@endforeach'+
                                '</select>'+
                                '@if($errors->has("shape_title.'+count+'"))'+
                                    '<span class="help-block">'+
                                        '{{ $errors->first("shape_title.'+count+'") }}'+
                                    '</span>'+
                                '@endif'+
                            '</div>'+
                            '<div class="form-group col-md-4" >'+
                                '<div class="upload">'+
                                    '<input type="file" id="'+count+'" class="filepond" name="image[]" data-allow-image-edit="false" >'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group col-md-4" >'+
                                 '<button type="button" class="btn btnclose" id="addEvent">x</button></div>'+
                            '</div>'+
                        '</div>');

                 $(document).on("click",".btnclose",function(){
                    $(this).parent().parent().remove();
                 });

                loadFilePond(count);

                count = count + 1;
            });


            // Turn input element into a pond
            function loadFilePond(clickedFP) {

                var shape_id = "";

                $("select[name='shape_title["+clickedFP+"]']").on('change',function(){
                   shape_id = $(this).val(); 
                });

                $('#'+clickedFP).filepond({
                     server: {
                            url: '{{ route("admin.box.store") }}',
                            method: 'POST',
                            process: {
                              headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',        
                              },
                              ondata: (formData) => {
                                formData.append('shape_id',shape_id);
                                return formData;
                            }
                          },
                        }
                });

                // Listen for addfile event
                $('#'+clickedFP).on('FilePond:addfile', function(e) {
                    console.log('file added event', e);
                });
            }

        });


        $(function () {

            // First register any plugins
            $.fn.filepond.registerPlugin(FilePondPluginImagePreview);
            $.fn.filepond.registerPlugin(FilePondPluginFileValidateType);

            // Turn input element into a pond
            $('.file-upload').filepond({
                allowReorder: true,
                imagePreviewHeight: 130
            });
      
            $("select[name='shape_title[0]']").on('change',function(){

               shape_title = $(this).val();

                FilePond.setOptions({
                    server: {
                        url: '{{ route("admin.box.store") }}',
                        method: 'POST',
                        process: {
                          headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',        
                          },
                          ondata: (formData) => {
                            formData.append('shape_id',shape_title);
                            return formData;
                        }
                      },
                    }
                });
            });

        });

        $(document).ready(function() {
            $("#frmAddNewBox").validate({
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
                    'shape_title[0]': {
                        required: true,
                        not_empty: true,
                        maxlength: 50,
                    },
                    'image[0]':{
                        required: true,
                        extension: "jpg|jpeg|png",
                     }, 
                },
                messages: {
                    en_title :{
                        required:"@lang('validation.required',['attribute'=>'box title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'box title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'box title','max'=>50])",
                    },
                    ar_title :{
                        required:"@lang('validation.required',['attribute'=>'box title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'box title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'box title','max'=>50])",
                    },
                    'shape_title[0]':{
                        required:"@lang('validation.required',['attribute'=>'box shape'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'box shape'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'box shape','max'=>50])",
                    },
                    'image[0]':{
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

            $('#frmAddNewBox').submit(function(){
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