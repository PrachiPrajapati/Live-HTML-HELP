@extends('admin.layout.app')

@push('css-top')
	<link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('FranchiseRequest_view') !!}
@endpush

@push('page-title')
	<h3 class="page-title"> 
		View {{ strtolower($title) }}
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
                        <span class="caption-subject bold uppercase"> Franchise Request Details  </span>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover table-checkable" id="franchiserequestList">
                    <tr> 
                        <td> NAME </td>
                        <td>{{ $FranchiseRequest->name }}</td>
                    </tr>
                   <tr> 
                        <td> COMPANY NAME </td>
                        <td>{{ $FranchiseRequest->company_name }}</td>
                    </tr>
                    <tr> 
                        <td> COMPANY ADDRESS </td>
                        <td>{{ $FranchiseRequest->company_address }}</td>
                    </tr>
                    <tr> 
                        <td> EMAIL </td>
                        <td>{{ $FranchiseRequest->email }}</td>
                    </tr>
                    <tr> 
                        <td> PHONE </td>
                        <td>{{ $FranchiseRequest->phone }}</td>
                    </tr>
                    <tr> 
                        <td> SECTOR </td>
                        <td>{{ $FranchiseRequest->sector }}</td>
                    </tr>
                    <tr> 
                        <td> COMPANY ACTIVITY </td>
                        <td>{{ $FranchiseRequest->company_activity }}</td>
                    </tr>
                    <tr> 
                        <td> EXPERIENCE </td>
                        <td>{{ $FranchiseRequest->experience }}</td>
                    </tr>
                    <tr> 
                        <td> LOCATION </td>
                        <td>{{ $FranchiseRequest->location }}</td>
                    </tr>
                    <tr> 
                        <td> COMMENT </td>
                        <td>{{ $FranchiseRequest->comment }}</td>
                    </tr>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    <div>
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
