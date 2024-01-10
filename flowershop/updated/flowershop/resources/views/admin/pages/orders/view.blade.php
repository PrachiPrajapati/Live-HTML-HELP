@extends('admin.layout.app')

@push('css-top')
	<link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('order_view') !!}
@endpush

@push('page-title')
	<h3 class="page-title"> 
		View {{ strtolower($title) }}
	</h3>
@endpush

@section('main-content')
	<div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="{{ $icon }} font-dark"></i>
                        <span class="caption-subject bold uppercase"> Order Details  </span>
                    </div>
                </div>
                <div class="profile-content">
                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            <div class="form-group col-md-4" style="border: 2px dashed black;">
                                @if($order->color != null)
                                    <img style="height: 263px; width: 280px; padding: 15px 0px 15px 0px;" src="{{ generateURL($order->color->image)}}" alt="product image"><br><br>
                                @elseif($order->product != null)
                                    <img style="height: 263px; width: 280px; padding: 15px 0px 15px 0px;" src="{{ generateURL($order->product->image)}}" alt="product image">
                                @endif
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory"></span>Product Name</label>    
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory"></span>Product Color</label>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory"></span><b>
                                    @if($order->product != null) {{ $order->product->title }} @endif</b></label> </b></label>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory"></span><b> {{ $order->color_name }} </b></label>
                            </div>
                            <div class="form-group col-md-3">
                                <br>
                                <label class="control-label"><span class="mendatory"></span>Product Price</label>    
                            </div>
                            <div class="form-group col-md-3">
                                <br>
                                <label class="control-label"><span class="mendatory"></span>Product Quantity</label>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory"></span><b> {{ $order->price }} </b></label>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory"></span><b> {{ $order->quantity }} </b></label>
                            </div>

                            <div class="form-group col-md-6">
                                <br>
                                <label class="control-label"><span class="mendatory"></span>User Name</label>    
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label"><span class="mendatory"></span><b>
                                @if($order->user != null)
                                    {{ $order->user->first_name }} {{ $order->user->last_name }}
                                @else
                                    Guest User
                                @endif
                                </b></label>
                            </div>
                        </div>

                        @if( $order->transaction != null )
                        <div class="form-group col-md-12">
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory" style="font-size: 20px;"></span>Delivery Person Name</label>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory" style="font-size: 20px;"></span>Delivery Email</label>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory" style="font-size: 20px;"></span>Delivery City</label>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory"></span><b> {{ $order->transaction->billing_fname }} {{ $order->transaction->billing_sname }}  </b></label>    
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory"></span><b> {{ $order->transaction->billing_email }} </b></label>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory"></span><b> {{ $order->transaction->billing_city }} </b></label>    
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory" style="font-size: 20px;"></span>Delivery Zip</label>
                            </div>
                            <div class="form-group col-md-8">
                                <label class="control-label"><span class="mendatory" style="font-size: 20px;"></span>Delivery Address</label>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label"><span class="mendatory"></span><b> {{ $order->transaction->billing_zip }} </b></label>    
                            </div>
                            <div class="form-group col-md-8">
                                <label class="control-label"><span class="mendatory"></span><b> {{ $order->transaction->billing_address_1 }} </b></label>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-12">
                            <div class="form-group col-md-12">
                                <label class="control-label"><span class="mendatory"></span>Billing Details</label>
                                <p><b> {{ $order->transaction->billing_address_2 }} </b></p>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory" style="font-size: 20px;"></span>Vat Amount</label>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory" style="font-size: 20px;"></span>Delivery Charge</label>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory" style="font-size: 20px;"></span>Total Amount</label>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory" style="font-size: 20px;"></span>Billing Amount (Vat + Total)</label>
                            </div>
                            
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory"></span><b> {{ $order->vat_amount }} </b></label>    
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory"></span><b> {{ $order->delivery_charge }} </b></label>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory"></span><b> {{ $order->total_amount }} </b></label>    
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory"></span><b> {{ $order->billing_amount }} </b></label>
                            </div>
                        </div>


                        <div class="form-group col-md-12">
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory" style="font-size: 20px;"></span>Order Date</label>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory" style="font-size: 20px;"></span>Delivery Date</label>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory" style="font-size: 20px;"></span>Delivery Time</label>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory" style="font-size: 20px;"></span>Approved</label>
                            </div>
                            
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory"></span><b> {{ $order->order_date }} </b></label>    
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory"></span><b> {{ $order->delivery_date }} </b></label>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory"></span><b> {{ $order->delivery_time }} </b></label> 
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label"><span class="mendatory"></span><b> 
                                @if($order->transaction->approved == 1)
                                    YES
                                @else
                                    NO
                                @endif
                                </b></label>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="form-group col-md-12">
                                <label class="control-label"><span class="mendatory"></span>Comment</label>
                                <p><b> {{ $order->comment }} </b></p>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="form-group col-md-12">
                                <label class="control-label"><span class="mendatory"></span>Gift Message</label>
                                <p><b> {{ $order->message }} </b></p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css-top')
    <link href="{{ asset('admin/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('extra-js')
    {{-- <script src="{{ asset('admin/js/datatable.min.js') }}" type="text/javascript"></script> 
    --}}<script src="{{ asset('admin/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script> 
    {{-- <script src="{{ asset('admin/js/table-datatables-managed.min.js') }}" type="text/javascript"></script> --}}
@endpush
