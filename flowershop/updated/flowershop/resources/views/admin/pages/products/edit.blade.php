@extends('admin.layout.app')

@push('css-top')
    <link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('product_update') !!}
@endpush

@push('page-title')
    <h3 class="page-title"> 
        Update {{ strtolower(str_singular($title)) }} details
    </h3>
@endpush

@section('main-content')             
<div class="row">
    <div class="col-md-12">
        <form action="{{ route('admin.product.update',$product->custom_id) }}" id="frmAddNewProduct" name="frmAddNewProduct" role="form" method="POST" enctype="multipart/form-data" novalidate="novalidate">
        @csrf
        @method('PUT')
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Product Details </span>
                </div>
            </div>
            <div class="profile-content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="portlet light bordered bg-blue-chambray bg-font-blue-chambray">
                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <span class="caption-subject bold font-white uppercase"> English </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><span class="mendatory">*</span>Product
                                        Title</label>
                                    <input type="text" name="en_title" placeholder="Enter Product Title" value="{{ old('en_title',$product->getEnglishTitle()) }}" class="form-control" maxlength="50" autocomplete="off">
                                    @if($errors->has('en_title'))
                                        <span class="help-block">
                                            {{ $errors->first('en_title') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><span class="mendatory">*</span>Product
                                        Description</label>
                                    <textarea class="form-control" name="en_description" placeholder="Enter Product Details" rows=5>{{ old('en_description',$product->getEnglishDescription()) }}</textarea>
                                    @if($errors->has('en_description'))
                                        <span class="help-block">
                                            {{ $errors->first('en_description') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="portlet light bordered bg-blue-chambray bg-font-blue-chambray">
                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <span class="caption-subject bold font-white uppercase"> Arabic </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><span class="mendatory">*</span>Product
                                        Title</label>
                                    <input type="text" name="ar_title" placeholder="Enter Product Title" value="{{ old('ar_title',$product->getArabicTitle()) }}" class="form-control" maxlength="50" autocomplete="off">
                                    @if($errors->has('ar_title'))
                                        <span class="help-block">
                                            {{ $errors->first('ar_title') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><span class="mendatory">*</span>Product
                                        Description</label>
                                    <textarea class="form-control" name="ar_description" placeholder="Enter Product Details" rows=5>{{ old('ar_description',$product->getArabicDescription()) }}</textarea>
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
                        <div class="row flex-row">
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory">*</span>Select
                                    Product Category</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="">Select Category</option>
                                    @if($categories != null && $categories != '[]')
                                        @foreach($categories as $category)
                                            @if($product->category_id == $category->id)
                                                <option value="{{ $category->id }}" selected>{{ $category->title }}</option>
                                            @else
                                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                @if($errors->has('category'))
                                    <span class="help-block">
                                        {{ $errors->first('category') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory">*</span>Select Product
                                    Type</label>
                                <select class="form-control" id="box" name="box">
                                    <option value="">Select Type</option>
                                    @if($box != null)
                                    <option value="{{ $box->id }}" selected>{{ $box->title }}</option>
                                    @endif
                                </select>
                                @if($errors->has('box'))
                                    <span class="help-block">
                                        {{ $errors->first('box') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory">*</span>Select Product
                                    Shape</label>
                                <select class="form-control" id="shape" name="shape">      
                                    <option value="">Select Shape</option>
                                    @if($shape != null)
                                    <option value="{{ $shape->id }}" selected>{{ $shape->title }}</option>
                                    @endif
                                </select>
                                @if($errors->has('shape'))
                                    <span class="help-block">
                                        {{ $errors->first('shape') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory">*</span>SKU</label>
                                <input type="text" name="sku" placeholder="Enter SKU" class="form-control"
                                    maxlength="50" autocomplete="off" value="{{ old('sku',$product->sku) }}">
                                @if($errors->has('sku'))
                                    <span class="help-block">
                                        {{ $errors->first('sku') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory">*</span>List
                                    Price</label>
                                <input type="text" name="list_price" placeholder="Enter List Price" class="form-control"
                                    maxlength="50" autocomplete="off" value="{{ old('list_price',$product->list_price) }}">
                                @if($errors->has('list_price'))
                                    <span class="help-block">
                                        {{ $errors->first('list_price') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory">*</span>Your
                                    Price</label>
                                <input type="text" name="your_price" placeholder="Enter Your Price" class="form-control"
                                    maxlength="50" autocomplete="off" value="{{ old('your_price',$product->your_price) }}">
                                @if($errors->has('your_price'))
                                    <span class="help-block">
                                        {{ $errors->first('your_price') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label"><span
                                        class="mendatory">*</span>Weight</label>
                                <input type="text" name="weight" placeholder="Enter Weight" class="form-control"
                                    maxlength="50" autocomplete="off" value="{{ old('weight',$product->weight) }}">
                                @if($errors->has('weight'))
                                    <span class="help-block">
                                        {{ $errors->first('weight') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory">*</span>Total
                                    Stock</label>
                                <input type="text" name="total_stock" placeholder="Enter Total Stock" class="form-control"
                                    maxlength="50" autocomplete="off" value="{{ old('total_stock',$product->total_stock) }}">
                                @if($errors->has('total_stock'))
                                    <span class="help-block">
                                        {{ $errors->first('total_stock') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory">*</span>Minimum
                                    Quantity</label>
                                <input type="text" name="minimum_qty" placeholder="Enter Minimum Quantity"
                                    class="form-control" maxlength="50" autocomplete="off" value="{{ old('minimum_qty',$product->minimum_qty) }}">
                                @if($errors->has('minimum_qty'))
                                    <span class="help-block">
                                        {{ $errors->first('minimum_qty') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory">*</span>Order
                                    Amount</label>
                                <input type="text" name="order_amount" placeholder="Enter Order Amount" class="form-control"
                                    maxlength="50" autocomplete="off" value="{{ old('order_amount',$product->order_amount) }}">
                                @if($errors->has('order_amount'))
                                    <span class="help-block">
                                        {{ $errors->first('order_amount') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory">*</span>Product
                                    Image</label>
                                <div class="upload mainImage">
                                    <input type="file" name="image" class="file-upload prod-image" accept="image/*">
                                </div>
                                @if($errors->has('image'))
                                    <span class="help-block">
                                        {{ $errors->first('image') }}
                                    </span>
                                @endif
                            </div>

                            @php $exists = false @endphp
                            @if ($product->image && Storage::exists($product->image))
                                @php $exists = true @endphp
                                <div class="form-group col-md-4">
                                    <label class="control-label">Current Image</label>
                                    <div class="show-image">
                                        <img class="img img-thumbnail" style="height: 80px; width: 80px;" src="{{ generateURL($product->image)}}" alt="image-not-found">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->  

        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark col-md-10">
                    <span class="caption-subject bold uppercase"> Add Colors </span>
                    <input type="hidden" id="totalNoOfColors" name="totalNoOfColors" value="{{ $no_of_colors }}">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success btnAddColor">+</button>
                </div>
            </div>
            
            <div class="color-add"></div>

            @for( $i = 0; $i < count($product_colors); $i++)
                <div class="profile-content addMoreColor">
                    <div class="col-md-12">
                        <div class="color-box">                                           
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label class="control-label"><span class="mendatory">*</span>Select
                                        Color</label>
                                    <select class="form-control" name="color_title[{{ $i }}]">
                                    @if($colors != null && $colors != '[]')
                                        @foreach($colors as $color)
                                            @if($product_colors[$i]->color_id == $color->id)
                                                <option value="{{ $color->id }}" selected>{{ $color->title }}</option>
                                            @else
                                                <option value="{{ $color->id }}">{{ $color->title }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                    </select>
                                    @if($errors->has("color_title[$i]"))
                                    <span class="help-block">
                                        {{ $errors->first("color_title[$i]") }}
                                    </span>
                                @endif
                                </div>
                                <div class="form-group col-md-6 col-lg-5">
                                    <label class="control-label"><span class="mendatory">*</span>Drop files
                                        here or click on upload</label>
                                    <div class="upload multiple addImage" id="file-{{$i}}">
                                        <input type="hidden" class="count" name="count" value="{{ $i }}">
                                        <input type="file" name="color_image[{{ $i }}]" class="file-upload color-fuschia" accept="image/*" multiple>
                                    </div>
                                    @if($errors->has("color_image[$i]"))
                                    <span class="help-block">
                                        {{ $errors->first("color_image[$i]") }}
                                    </span>
                                @endif
                                </div>
                                <div class="form-group col-md-1 col-lg-2">
                                    <div class="actions">
                                        <ul class="list-inline">
                                            <li>
                                                <button type="button" class="btn btn-danger btnclose">x</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            @foreach($product_images as $product_image)
                                @if($product_colors[$i]->color_id == $product_image->color_id)
                                    @php $exists = false @endphp
                                    @if ($product_image->image && Storage::exists($product_image->image))
                                        @php $exists = true @endphp
                                            <div class="form-group col-md-2">
                                                <label class="control-label">Current Image</label>
                                                <div class="show-image">
                                                    <img class="img img-thumbnail" style="height: 80px; width: 80px;" src="{{ generateURL($product_image->image)}}" alt="image-not-found">
                                                </div>
                                            </div>
                                    @endif
                                @endif
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->

        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="row d-flex">
            <div class="col-md-6">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <span class="caption-subject bold uppercase"> Related Products </span>
                        </div>
                    </div>
                    <div class="profile-content">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-12">                                
                                    <select class="form-control select2" name="related_products[]" multiple id="related-products">
                                    @if($product_related != null && $product_related != '[]')
                                        @foreach($product_related as $related)
                                            @if($related->select_related == "true")
                                                <option value="{{ $related->id }}" selected>{{ $related->title }}</option>
                                            @else
                                                <option value="{{ $related->id }}">{{ $related->title }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->title }}</option>
                                        @endforeach
                                    @endif
                                    </select>
                                    @if($errors->has('related_products[]'))
                                    <span class="help-block">
                                        {{ $errors->first('related_products[]') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <span class="caption-subject bold uppercase"> Add Ons </span>
                        </div>
                    </div>
                    <div class="profile-content">
                        <select class="form-control select2" name="addons_products[]" multiple id="addons-products">
                        @if($product_addons!= null && $product_addons != '[]')
                            @foreach($product_addons as $addon)
                                @if($addon->select_addons == "true")
                                    <option value="{{ $addon->id }}" selected>{{ $addon->title }}</option>
                                @else
                                    <option value="{{ $addon->id }}">{{ $addon->title }}</option>
                                @endif
                            @endforeach
                        @else
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->title }}</option>
                            @endforeach
                        @endif

                        </select>
                        @if($errors->has('addons_products[]'))
                            <span class="help-block">
                                {{ $errors->first('addons_products[]') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->

        <div class="col-md-12">
            <br>
            <div class="row">
                <div class="col-xs-6 text-right">
                    <input type="submit" value="Save Changes" class="btn green">
                </div>
                <div class="col-xs-6">
                    <a href="{{ route('admin.product.index') }}" class="btn default">Cancel</a>
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
    <link href="{{ asset('admin/css/filepond-plugin-file-poster.css') }}" rel="stylesheet" type="text/css" /> 
@endpush

@push('extra-js')
    <script src="{{ asset('admin/js/filepond.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/js/filepond.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/js/filepond-plugin-image-preview.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/js/filepond-plugin-file-validate-type.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/js/filepond-plugin-file-poster.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/plugins/select2/js/select2.full.js') }}" type="text/javascript"></script>

    <script type="text/javascript">

        $(document).on("click",".btnclose",function(){
            $(this).closest('.addMoreColor').remove();
        });

        $(function(){
            //Change Box Based On Category Selection
            $('#category').change(function(){
                var category_id = $(this).val();
                $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        url: "{{ route('admin.product.getcategorybox') }}",
                        data: {
                                _token: '{{ csrf_token() }}',
                                category_id : category_id,
                            },
                        success: function(Response){
                            if(Response.success){

                                var sub_categories = JSON.parse(Response.sub_categories);

                                $("#box").empty();
                                $("#box").append('<option value="" selected>Select Type</option>');

                                $(sub_categories).map((id,category) => {
                                    $("#box").append('<option value='+category.box['id']+'>'+category.box['title']+'</option>');
                                });
                            }
                            if(Response.fail){
                                location.reload();
                            }
                        },
                });
            });

            //Change Shape Based On Box Selection
            $('#box').on('change',function(){
                var category_id = $('#category').val();
                var box_id = $(this).val();

                $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        url: "{{ route('admin.product.getcategoryshape') }}",
                        data: {
                                _token      : '{{ csrf_token() }}',
                                category_id : category_id,
                                box_id      : box_id,
                            },
                        success: function(Response){
                            if(Response.success){
                                var sub_categories = JSON.parse(Response.sub_categories);

                                $("#shape").empty();
                                $("#shape").append('<option value="" selected>Select Shape</option>');

                                $(sub_categories).map((id,category) => {
                                    $("#shape").append('<option value='+category.shape['id']+'>'+category.shape['title']+'</option>');
                                });
                            }
                            if(Response.fail){
                                location.reload();
                            }
                        },
                });
            });
        });

                                                  // Product Single Image

        // For Main Image Of Product
        $(function () {

            // First register any plugins
            $.fn.filepond.registerPlugin(FilePondPluginImagePreview);
            $.fn.filepond.registerPlugin(FilePondPluginFileValidateType);

            // Turn input element into a pond
            $('.file-upload').filepond({
                allowReorder: true,
                imagePreviewHeight: 130
            });
            

            $(".mainImage").one('click',function(){

                FilePond.setOptions({
                    server: {
                        url: '{{ route("admin.product.store") }}',
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
        });


        // Edit Images When Already Images is Presents
        $(".addImage").one('click',function(){
            var color_id        =  $(this).parent().prev().find('.form-control').attr("selected", true).val();
            var color_id_count  =   $(this).find('.count').val();

            FilePond.setOptions({
                server: {
                    url: '{{ route("admin.product.store") }}',
                    method: 'POST',
                    process: {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',        
                        },
                        ondata: (formData) => {
                            var en_title = $("input[name='en_title']").val();
                            var ar_title = $("input[name='ar_title']").val();                       
                            
                            formData.append('filepond_color_images',true);
                            formData.append('en_title_filepond',en_title);
                            formData.append('ar_title_filepond',ar_title);
                            formData.append('color_id',color_id);
                            formData.append('count_perfect',color_id_count);

                            return formData;
                        }
                  },
                }
            });
        });
        

        //Add Dynamic Colors
        $(function(){

        var total = $("#totalNoOfColors").val();
        var count = total;
        
        $(document).on("click",".btnAddColor",function(){
            $(".color-add").prepend(
                '<div class="profile-content addMoreColor">'+
                '<div class="col-md-12">'+
                    '<div class="color-box">'+                                           
                        '<div class="row">'+
                            '<div class="form-group col-md-5">'+
                                '<label class="control-label"><span class="mendatory">*</span>Select'+
                                    ' Color</label>'+
                                '<select class="form-control" name="color_title['+count+']">'+
                                    '@if($colors != null && $colors != "[]")'+
                                        '@foreach($colors as $color)'+
                                        '<option value="{{ $color->id }}">{{ $color->title }}</option>'+
                                        '@endforeach'+
                                    '@endif'+
                                '</select>'+
                                '@if($errors->has("color_title['+count+']"))'+
                                '<span class="help-block">'+
                                    '{{ $errors->first("color_title['+count+']") }}'+
                                '</span>'+
                            '@endif'+
                            '</div>'+
                            '<div class="form-group col-md-6 col-lg-5">'+
                                '<label class="control-label"><span class="mendatory">*</span>Drop files'+
                                    ' here or click on upload</label>'+
                                '<div class="upload multiple" id="file-'+count+'">'+
                                    '<input type="file" name="color_image['+count+']" class="file-upload color-fuschia" accept="image/*" multiple>'+
                                '</div>'+
                                '@if($errors->has("color_image['+count+']"))'+
                                '<span class="help-block">'+
                                    '{{ $errors->first("color_image['+count+']") }}'+
                                '</span>'+
                            '@endif'+
                            '</div>'+
                            '<div class="form-group col-md-1 col-lg-2">'+
                                '<div class="actions">'+
                                    '<ul class="list-inline">'+
                                        '<li>'+
                                            '<button type="button" class="btn btn-danger btnclose">x</button>'+
                                        '</li>'+
                                    '</ul>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>');
            
            // Turn input element into a pond
            $('#file-'+count).find('input:file').filepond({
                allowReorder: true,
                imagePreviewHeight: 130
            });
            
            $(document).on("click",".btnclose",function(){
                $(this).closest('.addMoreColor').remove();
            });            
            

            var color_title = $("select[name='color_title["+count+"]']").val();

            if(color_title != "")
            {
                FilePond.setOptions({
                    server: {
                        url: '{{ route("admin.product.store") }}',
                        method: 'POST',
                        process: {
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',        
                            },
                            ondata: (formData) => {
                                var en_title = $("input[name='en_title']").val();
                                var ar_title = $("input[name='ar_title']").val();                       
                                
                                formData.append('filepond_color_images',true);
                                formData.append('en_title_filepond',en_title);
                                formData.append('ar_title_filepond',ar_title);
                                formData.append('color_id',color_title);
                                formData.append('count',count-1);

                                return formData;
                            }
                      },
                    }
                });

            }
            
            //If Dynamic Color Change Then Add Images Store
            $("select[name='color_title["+count+"]']").on('change',function(){
               color_title = $(this).val();

                    FilePond.setOptions({
                    server: {
                        url: '{{ route("admin.product.store") }}',
                        method: 'POST',
                        process: {
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',        
                            },
                            ondata: (formData) => {
                                var en_title = $("input[name='en_title']").val();
                                var ar_title = $("input[name='ar_title']").val();                       
                                
                                formData.append('filepond_color_images',true);
                                formData.append('en_title_filepond',en_title);
                                formData.append('ar_title_filepond',ar_title);
                                formData.append('color_id',color_title);
                                formData.append('count',count-1);

                                return formData;
                            }
                      },
                    }
                });
            });

            count = count + 1;

        });

    });

        $(document).ready(function() {
             $('#related-products').select2({
                placeholder: 'Add related products',
            });
            $('#addons-products').select2({
                placeholder: 'Add addons products',
            });
            $("#frmAddNewProduct").validate({
                rules: {
                    en_title: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    en_description:{
                        required: true,
                        not_empty: true,
                        maxlength: 500,
                    }, 
                    ar_title: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    ar_description:{
                        required: true,
                        not_empty: true,
                        maxlength: 500,
                    }, 
                    category: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    box:{
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    }, 
                    shape: {
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    sku:{
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    }, 
                    list_price: {
                        required: true,
                        not_empty: true,
                        maxlength:16,
                        pattern: /^(\d+)(?: ?\d+)*$/,
                    },
                    your_price:{
                        required: true,
                        not_empty: true,
                        maxlength:16,
                        pattern: /^(\d+)(?: ?\d+)*$/,
                    },
                    weight: {
                        required: true,
                        not_empty: true,
                        maxlength: 16,
                    },
                    total_stock:{
                        required: true,
                        not_empty: true,
                        maxlength:16,
                        pattern: /^(\d+)(?: ?\d+)*$/,
                    },
                    minimum_qty: {
                        required: true,
                        not_empty: true,
                        maxlength:16,
                        pattern: /^(\d+)(?: ?\d+)*$/,
                    },
                    order_amount:{
                        required: true,
                        not_empty: true,
                        maxlength:16,
                        pattern: /^(\d+)(?: ?\d+)*$/,
                    },   
                    image:{
                        required: false,
                        not_empty: true,
                        extension: "jpg|jpeg|png",
                    },
                    'color_title[]':{
                        required: true,
                        not_empty: true,
                        maxlength: 255,
                    },
                    'color_image[]':{
                        required: false,
                        not_empty: true,
                        extension: "jpg|jpeg|png",
                    },
                    related_products:{
                        required: false,
                        not_empty: true,
                        maxlength: 255,
                    },   
                    addons_products:{
                        required: false,
                        not_empty: true,
                        maxlength: 255,
                    },   
                },
                messages: {
                    en_title :{
                        required:"@lang('validation.required',['attribute'=>'product title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'product title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'product title','max'=>255])",
                    },
                    en_description:{
                        required:"@lang('validation.required',['attribute'=>'product description'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'product description'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'product description','max'=>500])",
                    },
                    ar_title :{
                        required:"@lang('validation.required',['attribute'=>'product title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'product title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'product title','max'=>255])",
                    },
                    ar_description:{
                        required:"@lang('validation.required',['attribute'=>'product description'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'product description'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'product description','max'=>500])",
                    },
                    category:{
                        required:"@lang('validation.required',['attribute'=>'category'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'category'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'category','max'=>255])",
                    },
                    box:{
                        required:"@lang('validation.required',['attribute'=>'box'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'box'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'box','max'=>255])",
                    },
                    shape:{
                        required:"@lang('validation.required',['attribute'=>'shape'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'shape'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'shape','max'=>255])",
                    },
                    sku:{
                        required:"@lang('validation.required',['attribute'=>'sku'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'sku'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'sku','max'=>255])",
                    },
                    list_price :{
                        required:"@lang('validation.required',['attribute'=>'list price'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'list price'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'list price','max'=>16])",
                        pattern:"@lang('validation.numeric',['attribute'=>'list price'])",
                    },
                    your_price:{
                        required:"@lang('validation.required',['attribute'=>'your price'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'your price'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'your price','max'=>16])",
                        pattern:"@lang('validation.numeric',['attribute'=>'your price'])",
                    },
                    weight :{
                        required:"@lang('validation.required',['attribute'=>'weight'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'weight'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'weight','max'=>16])",
                    },
                    total_stock:{
                        required:"@lang('validation.required',['attribute'=>'total stock'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'total stock'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'total stock','max'=>16])",
                        pattern:"@lang('validation.numeric',['attribute'=>'total stock'])",
                    },
                    minimum_qty:{
                        required:"@lang('validation.required',['attribute'=>'minimum quantity'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'minimum quantity'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'minimum quantity','max'=>16])",
                        pattern:"@lang('validation.numeric',['attribute'=>'minimum quantity'])",
                    },
                    order_amount:{
                        required:"@lang('validation.required',['attribute'=>'order amount'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'order amount'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'order amount','max'=>16])",
                        pattern:"@lang('validation.numeric',['attribute'=>'order amount'])",
                    },
                    image:{
                        required:"@lang('validation.required',['attribute'=>'product image'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'product image'])",
                        extension:"@lang('validation.mimetypes',['attribute'=>'product image','value'=>'jpg,png,jpeg'])"
                    },
                    'color_title[]':{
                        required:"@lang('validation.required',['attribute'=>'color title'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'color title'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'color title','max'=>255])",
                    },
                    'color_image[]':{
                        required:"@lang('validation.required',['attribute'=>'color image'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'color image'])",
                        extension:"@lang('validation.mimetypes',['attribute'=>'color image','value'=>'jpg,png,jpeg'])"
                    },
                    related_products:{
                        required:"@lang('validation.required',['attribute'=>'related products'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'related products'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'related products','max'=>255])",
                    },
                    addons_products:{
                        required:"@lang('validation.required',['attribute'=>'addons products'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'addons products'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'addons products','max'=>255])",
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

            $('#frmAddNewProduct').submit(function(){
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