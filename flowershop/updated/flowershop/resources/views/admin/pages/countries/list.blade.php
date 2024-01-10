@extends('admin.layout.app')


@push('css-top')
	<link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('country_list') !!}
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
                        <span class="caption-subject bold uppercase"> Total Countries : <span id="totalCount">{{ $count ?? 0 }}</span> </span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided">
                            @if (in_array('delete', $permissions))
                            <a href="{{ route('admin.countries.destroy',0) }}" name="del_select" id="del_select" class="btn btn-sm btn-danger delete_all_link"><i class="fa fa-trash"></i> Delete Selected {{ $title }}</a>
                            @endif
                            @if (in_array('add', $permissions))
                            <a href="{{ route('admin.countries.create') }}" class="btn btn-info">
                                Add New {{ str_singular($title) }}
                            </a>
                            <a href="javascript:;"  data-toggle="modal" data-target="#replyModal" class="btn btn-sm btn-info">CSV Upload</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover table-checkable" id="usersList">
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>


    {{-- Pop Up --}}
        <div class="modal fade" id="replyModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Upload Multiple Countries</h4>
                    </div>
                    <div class="modal-body">
                        <form id="frmUploadCsv" class="form-horizontal" role="form" method="POST" action="{{ route('admin.countries.csv-upload') }}" enctype="multipart/form-data">
                            @csrf 
                            <div class="row">
                                <div class="col-md-10">
                                        {{-- Select File --}}
                                        <div class="form-group margin-0">
                                            <label class="control-label">{!! $mend_sign !!}Select CSV File</label>
                                            <input type="file" placeholder="Select CSV File" class="form-control" id="csvFile" name="csvFile" accept=".csv" data-error-container="#error-csv-file"/>
                                            <span id="error-csv-file"></span>
                                        </div>

                                        {{-- Sample CSV Download --}}
                                        <a href="{{ route('admin.countries.csv-download') }}">Download sample CSV</a>

                                        {{-- Submit and Cancel Button --}}
                                        <div class="form-group">
                                            <div class="col-md-offset-4 col-md-8">
                                                <button type="submit" class="btn green">Submit</button>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
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
    {{-- <script src="{{ asset('admin/js/datatable.min.js') }}" type="text/javascript"></script> --}}
    <script src="{{ asset('admin/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ asset('admin/js/table-datatables-managed.min.js') }}" type="text/javascript"></script> --}}
@endpush

@push('extra-js')
    <script type="text/javascript">
        $(function(){
            var table = $('#usersList');

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
                    { "title": "Name (English)" ,"data": "en_name", render: $.fn.dataTable.render.text(),},
                    { "title": "Name (Arabic)" ,"data": "ar_name", render: $.fn.dataTable.render.text(),},

                    @if (in_array('edit', $permissions))
                        { "title": "Status" ,"data": "is_active", searchble: false, sortable: true},
                    @endif
                    
                    @if (in_array('view', $permissions) || in_array('edit', $permissions) || in_array('delete', $permissions))
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
                    "url": "{{route('admin.countries.listing')}}", // ajax source
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


@push('extra-js')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#frmUploadCsv").validate({
                rules: {
                    csvFile: {
                        required: true,
                        not_empty: true,
                        extension: "csv",
                    },
                },
                messages: {
                    csvFile:{
                        required:"@lang('validation.required',['attribute'=>'CSV file'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'CSV file'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'CSV file','max'=>50])",
                        extension:"@lang('validation.mimetypes',['attribute'=>'image','value'=>'csv'])"
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

            $('#frmUploadCsv').submit(function(){
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