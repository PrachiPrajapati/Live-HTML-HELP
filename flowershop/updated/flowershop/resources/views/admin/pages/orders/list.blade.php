@extends('admin.layout.app')

@push('css-top')
	<link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('order_list') !!}
@endpush

@push('page-title')
	<h3 class="page-title"> 
		Manage {{ strtolower($title) }}
	</h3>
@endpush

@section('main-content')
	<div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="{{ $icon }} font-dark"></i>
                        <span class="caption-subject bold uppercase"> Total Orders : <span id="totalCount">{{ $count ?? 0 }}</span> </span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided">
                            @if (in_array('delete', $permissions))
                            <a href="{{ route('admin.franchiserequests.destroy',0) }}" name="del_select" id="del_select" class="btn btn-sm btn-danger delete_all_link"><i class="fa fa-trash"></i> Delete Selected {{ $title }}</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover table-checkable" id="OrdersList">
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
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

@push('extra-js')
    <script type="text/javascript">
        $(function(){
            var table = $('#OrdersList');

            oTable = table.dataTable({
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                "language": {
                    "lengthMenu": "_MENU_ Entries to show",
                },
                "columns": [
                    @if (in_array('delete', $permissions))
                        { "title": "<input type='checkbox' class='all_select'>" ,"data": "checkbox","width":"3%",searchble: false, sortable:false},
                    @endif
                    
                    { "title": "Product" ,"data": "product_id", render: $.fn.dataTable.render.text(),},
                    
                    { "title": "Quantity" ,"data": "quantity", render: $.fn.dataTable.render.text(),},

                    { "title": "Billing Amount" ,"data": "billing_amount", render: $.fn.dataTable.render.text(),},

                    { "title": "Order Date" ,"data": "order_date", render: $.fn.dataTable.render.text(),},

                    { "title": "Delivery Date" ,"data": "delivery_date", render: $.fn.dataTable.render.text(),},

                    { "title": "Status" ,"data": "status", render: $.fn.dataTable.render.text(),},

                    @if (in_array('view', $permissions) || in_array('delete', $permissions))
                        { "title": "Action" ,"data": "action", searchble: false, sortable:false }
                    @endif
                ],
                responsive: false,
                "order": [
                    @if (in_array('delete', $permissions))
                        [1, 'asc']
                    @else
                        [0, 'asc']
                    @endif
                ],
                "lengthMenu": [
                    [10, 20, 50, 100],
                    [10, 20, 50, 100]
                ],
                "pageLength": 10,
                "ajax": {
                    "url": "{{route('admin.order.listing')}}", // ajax source
                },
                drawCallback: function( oSettings ) {
                  $('.status-switch').bootstrapSwitch();
                  $('.status-switch').bootstrapSwitch('onColor', 'success');
                  $('.status-switch').bootstrapSwitch('offColor', 'danger');
                  removeOverlay();
                },
                "dom": "<'row' <'col-md-12'>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
            });

            
        });
    </script>
@endpush
