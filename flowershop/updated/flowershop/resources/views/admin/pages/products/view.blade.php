@extends('admin.layout.app')

@push('css-top')
	<link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('product_view') !!}
@endpush

@push('page-title')
	<h3 class="page-title"> 
		View {{ strtolower($title) }} details
	</h3>
@endpush

@section('main-content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase">Product Detail </span>
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided">                                     
                        <a href="{{ route('admin.product.edit',$product->custom_id) }}" class="btn btn-info">
                            Edit
                        </a>
                        <a href="{{ route('admin.product.delete',$product->custom_id) }}" class="btn btn-info">
                           Delete
                        </a>
                    </div>
                </div>
            </div>
            <div class="profile-content">
                <div class="col-md-12">
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-1">
                            <img style="height: 75px; width: 70px;" src="{{ generateURL($product->image)}}" alt="image"><br><br>
                            <img style="height: 75px; width: 70px;" src="{{ generateURL($product->image)}}" alt="image"><br><br>
                            <img style="height: 75px; width: 70px;" src="{{ generateURL($product->image)}}" alt="image">
                        </div>
                        <div class="form-group col-md-4" style="border: 2px dashed black; margin:0px 20px 0px 20px;">
                            <img style="height: 263px; width: 280px;" src="{{ generateURL($product->image) }}" alt="product image"><br><br>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label"><span class="mendatory"></span>Title</label>    
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label"><span class="mendatory"></span>Category</label>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label"><span class="mendatory"></span><b> {{ $product->getEnglishTitle() }} </b></label>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label"><span class="mendatory"></span><b> {{ $product->category['title'] }} </b></label>
                        </div>
                        
                        <div class="form-group col-md-3">
                            <br>
                            <label class="control-label"><span class="mendatory"></span>SKU</label>    
                        </div>
                        <div class="form-group col-md-3">
                            <br>
                            <label class="control-label"><span class="mendatory"></span>Weight</label>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label"><span class="mendatory"></span><b> {{ $product->sku }} </b></label>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label"><span class="mendatory"></span><b> {{ $product->weight }}  </b></label>
                        </div>

                        <div class="form-group col-md-3">
                            <br>
                            <label class="control-label"><span class="mendatory"></span>Your Price</label>    
                        </div>
                        <div class="form-group col-md-3">
                            <br>
                            <label class="control-label"><span class="mendatory"></span>List Price</label>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label"><span class="mendatory"></span><b> $ {{ $product->your_price }} </b></label>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label"><span class="mendatory"></span><b> $ {{ $product->list_price }} </b></label>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <div class="form-group col-md-3">
                            <label class="control-label"><span class="mendatory" style="font-size: 20px;"></span>Total Stock</label>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label"><span class="mendatory" style="font-size: 20px;"></span>Min Order</label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label"><span class="mendatory" style="font-size: 20px;"></span>Order Amount</label>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label"><span class="mendatory"></span><b> {{ $product->total_stock }} </b></label>    
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label"><span class="mendatory"></span><b> {{ $product->minimum_qty }} </b></label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label"><span class="mendatory"></span><b> $ {{ $product->order_amount }} </b></label>    
                        </div>
                    </div>

                     <div class="form-group col-md-12">
                        <div class="form-group col-md-3">
                            <label class="control-label"><span class="mendatory" style="font-size: 20px;"></span>Product Type</label>
                        </div>
                        <div class="form-group col-md-9">
                            <label class="control-label"><span class="mendatory" style="font-size: 20px;"></span>Product Shape</label>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label"><span class="mendatory"></span><b> {{ $product->box['title'] }} </b></label>    
                        </div>
                        <div class="form-group col-md-9">
                            <label class="control-label"><span class="mendatory"></span><b> {{ $product->shape['title'] }} </b></label>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            <label class="control-label"><span class="mendatory"></span>Product Detail</label>
                            <p><b>{{ $product->getEnglishDescription() }}</b></p>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            <label class="control-label"><span class="mendatory"></span>Additional Detail</label>
                            <p><b>{{ $product->getArabicDescription() }}</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @if($product_related != null)
        <div class="portlet light bordered">
             <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase">Related Product</span>
                </div>
            </div>
            <div class="profile-content">
                @foreach($product_related as $product)
                    <div class="form-group col-md-4">
                        <img style="height: 263px; width: 280px;" src="{{ generateURL($product->image) }}" alt="image"><br><br>
                    </div>
                @endforeach   
            </div>
        </div>
        @endif

        @if($product_colors != null)
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Color Details </span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="franchisesList_wrapper" class="dataTables_wrapper no-footer">
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover table-checkable dataTable no-footer" id="franchisesList" role="grid" aria-describedby="franchisesList_info" style="width: 1043px;">
                            <thead>
                                <tr role="row">
                                    <th class="sorting" tabindex="0" aria-controls="franchisesList" rowspan="1" colspan="1" style="width: 10%;">Sr No.
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="franchisesList" rowspan="1" colspan="1" style="width: 30%;">Title
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="franchisesList" rowspan="1" colspan="1" style="width: 30%;">Image
                                    </th>
                                </tr>
                            </thead>
                            @foreach($product_colors as $color)
                            <tbody>
                                <tr role="row" class="odd">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $color->title }}</td>
                                    <td><img style="height: 50px; width: 100px;" src="{{ generateURL($color->image) }}" alt="image"></td>
                                </tr> 
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>                            
@endsection

@push('css-top')
    <link href="{{ asset('admin/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('extra-js')
    {{-- <script src="{{ asset('admin/js/datatable.min.js') }}" type="text/javascript"></script> --}}
    <script src="{{ asset('admin/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ asset('admin/js/table-datatables-managed.min.js') }}" type="text/javascript"></script> --}}
@endpush

@push('extra-js')
    <script type="text/javascript">
    </script>
@endpush
