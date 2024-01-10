@extends('admin.layout.app')

@push('css-top')
    <link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('home_create') !!}
@endpush

@push('page-title')
    <h3 class="page-title"> 
        {{ $title }} Management Details
    </h3>
@endpush

@section('main-content')             
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold uppercase"> Home Management </span>
        </div>
    </div>
    <div class="profile-content">
        <div class="row">
            <form action="{{ route('admin.home.everyoccasion') }}" role="form" method="POST" id="frmOccasion" name="frmOccasion" enctype="multipart/form-data" novalidate="novalidate">
                @csrf
                <div class="col-md-12">
                    <div class="portlet-title">
                        <div class="caption font-dark my-15">
                            <span class="caption-subject bold uppercase"> For Every Occassion </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="control-label"><span class="mendatory">*</span>Select Category</label>
                                <select class="form-control" id="occassion_category" name="occassion_category">
                                @if($categories != null)   
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                @endif    
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="dd reorder-list">
                                    <ol class="dd-list" id="nestable_list_1">
                                        @if($occassions_category != null)
                                            @foreach($occassions_category as $category)
                                                @if($category->category != null)
                                                <li class="dd-item dd3-item" data-id="16">
                                                    <div class="dd-handle dd3-handle"></div>
                                                    <div class="dd3-content"> {{ $category->category->title }} </div>
                                                    <a class="remove"><img src="{{ asset('admin/images/close.png') }}" alt="close"></a>
                                                    <input type="hidden" name="occassion_category[]" class="form-control" value="{{ $category->category_id }}">
                                                </li>
                                                @endif
                                            @endforeach
                                        @endif
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="button" value="Add" id="btnAddOccasionCategory" class="btn grey">
                            <input type="submit" value="Update" id="update_1" class="btn grey">
                        </div>
                    </div>
                </div>
            </form>
            
            <div class="col-md-12">
                <br/><br/>
            </div>

            <form action="{{ route('admin.home.shopbycolor') }}" role="form" method="POST" id="frmColors" name="frmColors" enctype="multipart/form-data" novalidate="novalidate">
                @csrf    
                <div class="col-md-12">
                    <div class="portlet-title">
                        <div class="caption font-dark my-15">
                            <span class="caption-subject bold uppercase"> Shop By Color </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="control-label"><span class="mendatory">*</span>Select Color</label>
                            <select class="form-control" id="color">
                                @if($colors != null)
                                    @foreach($colors as $color)
                                        <option value="{{ $color->id }}">{{ $color->getTitle() }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label"><span class="mendatory">*</span>Select Category</label>
                            <select class="form-control" id="color_category">
                                @if($categories != null)   
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                @endif 
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="dd reorder-list">
                                            <ol class="dd-list" id="nestable_list_2">
                                                @if($colors_category != null)
                                                    @foreach($colors_category as $color_data)
                                                        @if($color_data->color != null && $color_data->category != null)
                                                        <li class="dd-item dd3-item" data-id="16">
                                                            <div class="dd-handle dd3-handle"></div>
                                                            <div class="dd3-content">{{ $color_data->color->title }} - {{ $color_data->category->title  }} </div>
                                                            <a class="remove"><img src="{{ asset('admin/images/close.png') }}" alt="close"></a>
                                                            <input type="hidden" name="color[]" class="form-control" value="{{ $color_data->color_id }}"/>
                                                            <input type="hidden" name="colors_category[]" class="form-control" value="{{ $color_data->category_id }}"/>
                                                        </li>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="button" value="Add" id="btnAddColor" class="btn grey">
                            <input type="submit" value="Update" id="update_2" class="btn grey">
                        </div>
                    </div>
                </div>
            </form>
            
            <div class="col-md-12">
                <br /><br />
            </div>

            <form action="{{ route('admin.home.services') }}" role="form" method="POST" id="frmServices" name="frmServices" enctype="multipart/form-data" novalidate="novalidate">
                @csrf    
                <div class="col-md-12">
                    <div class="portlet-title">
                        <div class="caption font-dark my-15">
                            <span class="caption-subject bold uppercase"> Services </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <div class="dd reorder-list">
                                <ol class="dd-list" id="nestable_list_3">
                                    @if($services != null)
                                        @foreach($services as $service)
                                        <li class="dd-item dd3-item" data-id="16">
                                            <div class="dd-handle dd3-handle"></div>
                                            <div class="dd3-content"> {{ $service->getTitle() }} </div>
                                            <input type="hidden" name="service[]" value="{{ $service->id }}">
                                        </li>
                                        @endforeach
                                    @else
                                        @if($manage_services != null)
                                            @foreach($manage_services as $service)
                                                @if($service->service != null)
                                                <li class="dd-item dd3-item" data-id="16">
                                                    <div class="dd-handle dd3-handle"></div>
                                                    <div class="dd3-content"> {{ $service->service->getTitle() }} </div>
                                                    <input type="hidden" name="service[]" value="{{ $service->service->id }}">
                                                </li>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endif
                                </ol>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="submit" value="Update" class="btn grey">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('css-top')
    <link href="{{ asset('admin/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/jquery.nestable.css') }}" rel="stylesheet" type="text/css" />

@endpush

@push('extra-js')
    <script src="{{ asset('admin/js/Sortable.min.js') }}" type="text/javascript"></script> 

    <script type="text/javascript">
     $(document).ready(function(){
        // $('.reorder-list').sortable();
        // UINestable.init();
        var el1 = document.getElementById('nestable_list_1');
        var sortable = Sortable.create(el1);
        var el2 = document.getElementById('nestable_list_2');
        var sortable = Sortable.create(el2);
        var el3 = document.getElementById('nestable_list_3');
        var sortable = Sortable.create(el3);
    });

     //console.log($("#products").val());
     // var products = $("#products").val();

     // foreach(products as product){
     //    console.log("products ::",product);
     // }

    $(".remove").on('click',function(){
        $(this).parent().remove();
    });

    //FOR EVERY OCCASSION
    $("#btnAddOccasionCategory").on('click', function(){ 
        var value =  $("#occassion_category").val();
        var text  =  $("#occassion_category option:selected").text();

        $("#nestable_list_1").append(
            '<li class="dd-item dd3-item" data-id="16">'+
                '<div class="dd-handle dd3-handle"></div>'+
                '<div class="dd3-content">'+text+'</div>'+
                '<a class="remove"><img src="{{ asset("admin/images/close.png") }}" alt="close"></a>'+
                '<input type="hidden" name="occassion_category[]" class="form-control" value="'+value+'"/>'+
            '</li>');

        $(".remove").on('click',function(){
            $(this).parent().remove();
        });
    });


    //SHOP BY COLOR
    $("#btnAddColor").on('click', function(){
        var color_value = $("#color").val();
        var color_text  = $("#color option:selected").text();

        var color_product_value = $("#color_category").val();
        var color_product_text  = $("#color_category option:selected").text(); 

        $("#nestable_list_2").append(
             '<li class="dd-item dd3-item" data-id="16">'+
                '<div class="dd-handle dd3-handle"></div>'+
                '<div class="dd3-content">'+color_text+'-'+color_product_text+'</div>'+
                '<a class="remove"><img src="{{ asset("admin/images/close.png") }}" alt="close"></a>'+
                '<input type="hidden" name="color[]" class="form-control" value="'+color_value+'"/>'+
                '<input type="hidden" name="colors_category[]" class="form-control" value="'+color_product_value+'"/>'+
            '</li>');
        
        $(".remove").on('click',function(){
            $(this).parent().remove();
        });
    });

 </script>

@endpush