@extends('admin.layout.app')

@push('css-top')
	<link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('order_update') !!}
@endpush

@push('page-title')
	<h3 class="page-title"> 
		Update {{ strtolower(str_singular($title)) }} details
	</h3>
@endpush

@section('main-content')
	<div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.order.update', $order->custom_id) }}" role="form" id="frmUpdateOrder" name="frmUpdateOrder" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="{{ $icon }} font-dark"></i>
                            <span class="caption-subject bold uppercase"> Order Details  </span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table border="1" class="table table-striped table-bordered table-hover table-checkable" id="franchiserequestList">
                        <thead>
                            <th style="width: 25%;">TITLE</th>
                            <th>DETAILS</th>
                        </thead>
                        <tr> 
                            <td> USER NAME </td>
                            @if($order->user != null)
                                <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                            @else
                                <td>Guest User</td>
                            @endif
                        </tr>
                        @if($order->product != null)
                       <tr> 
                            <td> PRODUCT </td>
                            <td>{{ $order->product->getEnglishTItle() }}</td>
                        </tr>
                        @endif
                      
                        @if($order->color_name != null)
                        <tr> 
                            <td> Color </td>
                            <td>{{ $order->color_name }}</td>
                        </tr>
                        @endif
                        <tr> 
                            <td> QUANTITY </td>
                            <td>{{ $order->quantity }}</td>
                        </tr>
                        @if($order->transaction != null)
                        <tr> 
                            <td> DELIVERY PERSON NAME </td>
                            <td>{{ $order->transaction->billing_fname }} {{ $order->transaction->billing_sname }}</td>
                        </tr>
                        <tr> 
                            <td> DELIVERY EMAIL </td>
                            <td>{{ $order->transaction->billing_email }}</td>
                        </tr>
                        <tr> 
                            <td> DELIVERY ADDRESS </td>
                            <td>{{ $order->transaction->billing_address_1 }}</td>
                        </tr>
                        <tr> 
                            <td> DELIVERY CITY </td>
                            <td>{{ $order->transaction->billing_city }}</td>
                        </tr>
                        <tr> 
                            <td> DELIVERY ZIP </td>
                            <td>{{ $order->transaction->billing_zip }}</td>
                        </tr>
                        <tr> 
                            <td> BILLING DETAILS </td>
                            <td>{{ $order->transaction->billing_address_2 }}</td>
                        </tr>
                        <tr> 
                            <td> APPROVED </td>
                            @if($order->transaction->approved == 1)
                                <td>YES</td>
                            @else
                                <td>NO</td>
                            @endif
                        </tr>
                        @endif
                        <tr> 
                            <td> PRODUCT PRICE </td>
                            <td>{{ $order->price }}</td>
                        </tr>
                        <tr> 
                            <td> DELIVERY CHARGE </td>
                            <td>{{ $order->delivery_charge }}</td>
                        </tr>
                        <tr> 
                            <td> BILLING AMOUNT </td>
                            <td>{{ $order->billing_amount }} ( {{ $order->total_amount }} + {{ $order->vat_amount }} ) (Total + Vat)</td>
                        </tr>
                        <tr> 
                            <td> ORDER DATE </td>
                            <td>{{ $order->order_date }}</td>
                        </tr>
                        <tr> 
                            <td> DELIVERY DATE </td>
                            <td>{{ $order->delivery_date }}</td>
                        </tr>
                        <tr> 
                            <td> DELIVERY TIME </td>
                            <td>{{ $order->delivery_time }}</td>
                        </tr>
                        <tr> 
                            <td> STATUS </td>
                            <td>
                                <div class="col-md-4">
                                    <select class="form-control" name="status">
                                        @if($order->status == "Ordered")
                                            <option value="Ordered" selected>Ordered</option>
                                            <option value="Processing">Processing</option>
                                            <option value="Under Processing">Under Processing</option>
                                            <option value="On The Way">On The Way</option>
                                            <option value="Delivered">Delivered</option>
                                            <option value="Cancelled">Cancelled</option>
                                            <option value="Refunded">Refunded</option>
                                        @elseif($order->status == "Processing")
                                            <option value="Ordered">Ordered</option>
                                            <option value="Processing" selected>Processing</option>
                                            <option value="Under Processing">Under Processing</option>
                                            <option value="On The Way">On The Way</option>
                                            <option value="Delivered">Delivered</option>
                                            <option value="Cancelled">Cancelled</option>
                                            <option value="Refunded">Refunded</option>
                                        @elseif($order->status == "Under Processing")
                                            <option value="Ordered">Ordered</option>
                                            <option value="Processing">Processing</option>
                                            <option value="Under Processing" selected>Under Processing</option>
                                            <option value="On The Way">On The Way</option>
                                            <option value="Delivered">Delivered</option>
                                            <option value="Cancelled">Cancelled</option>
                                            <option value="Refunded">Refunded</option>
                                        @elseif($order->status == "On The Way")
                                            <option value="Ordered">Ordered</option>
                                            <option value="Processing">Processing</option>
                                            <option value="Under Processing">Under Processing</option>
                                            <option value="On The Way" selected>On The Way</option>
                                            <option value="Delivered">Delivered</option>
                                            <option value="Cancelled">Cancelled</option>
                                            <option value="Refunded">Refunded</option>
                                        @elseif($order->status == "Delivered")
                                            <option value="Ordered">Ordered</option>
                                            <option value="Processing">Processing</option>
                                            <option value="Under Processing">Under Processing</option>
                                            <option value="On The Way">On The Way</option>
                                            <option value="Delivered" selected>Delivered</option>
                                            <option value="Cancelled">Cancelled</option>
                                            <option value="Refunded">Refunded</option>
                                        @elseif($order->status == "Cancelled")
                                            <option value="Ordered">Ordered</option>
                                            <option value="Processing">Processing</option>
                                            <option value="Under Processing">Under Processing</option>
                                            <option value="On The Way">On The Way</option>
                                            <option value="Delivered">Delivered</option>
                                            <option value="Cancelled" selected>Cancelled</option>
                                            <option value="Refunded">Refunded</option>
                                        @elseif($order->status == "Refunded")
                                            <option value="Ordered">Ordered</option>
                                            <option value="Processing">Processing</option>
                                            <option value="Under Processing">Under Processing</option>
                                            <option value="On The Way">On The Way</option>
                                            <option value="Delivered">Delivered</option>
                                            <option value="Cancelled">Cancelled</option>
                                            <option value="Refunded" selected>Refunded</option>
                                        @endif
                                    </select>
                                </div>
                            </td>
                        </tr>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
                 <div class="col-md-12">
                    <div class="row">
                        <div class="col-xs-6 text-right">
                            <input type="submit" value="Save Changes" class="btn green">
                        </div>
                        <div class="col-xs-6">
                            <a href="{{ route('admin.order.index') }}" class="btn default">Cancel</a>
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
@endpush
@push('extra-js')
    {{-- <script src="{{ asset('admin/js/datatable.min.js') }}" type="text/javascript"></script> 
    --}}<script src="{{ asset('admin/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script> 
    {{-- <script src="{{ asset('admin/js/table-datatables-managed.min.js') }}" type="text/javascript"></script> --}}
@endpush
