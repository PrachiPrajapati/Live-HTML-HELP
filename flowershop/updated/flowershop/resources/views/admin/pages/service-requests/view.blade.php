@extends('admin.layout.app')

@push('css-top')
	<link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('service_request_view') !!}
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
                        <span class="caption-subject bold uppercase"> Service Request Details  </span>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover table-checkable" id="franchiserequestList">
                    <thead>
                        <tr> 
                            <th style="width: 30%;"> SERVICE TITLE </th>
                            <th> SERVICE DETAILS </th> 
                        </tr>
                    </thead>
                    @if($serviceRequest->service != null)
                    <tr> 
                        <td > SERVICE NAME </td>
                        <td>{{ $serviceRequest->service->getTitle() }}</td>
                    </tr>
                    @endif
                     <tr> 
                        <td> TYPE </td>
                        <td>{{ $serviceRequest->type  }}</td>
                    </tr>
                    <tr> 
                        <td> FIRST NAME </td>
                        <td>{{ $serviceRequest->first_name }}</td>
                    </tr>
                    <tr> 
                        <td> LAST NAME </td>
                        <td>{{ $serviceRequest->last_name }}</td>
                    </tr>
                    <tr> 
                        <td> EMAIL </td>
                        <td>{{ $serviceRequest->email }}</td>
                    </tr>
                    <tr> 
                        <td> CONTACT </td>
                        <td>{{ $serviceRequest->contact }}</td>
                    </tr>
                    @if($serviceRequest->contact_home != null)
                    <tr> 
                        <td> HOME CONTACT </td>
                        <td>{{ $serviceRequest->contact_home }}</td>
                    </tr>
                    @endif
                    <tr> 
                        <td> CITY </td>
                        <td>{{ $serviceRequest->city }}</td>
                    </tr>
                    <tr> 
                        <td> COUNTRY </td>
                        <td>{{ $serviceRequest->country }}</td>
                    </tr>
                    <tr> 
                        <td> CEREMONY  DATE</td>
                        <td>{{ $serviceRequest->date_ceremony }}</td>
                    </tr>
                    <tr> 
                        <td> CEREMONY LOCATION </td>
                        <td>{{ $serviceRequest->location_ceremony }}</td>
                    </tr>
                    <tr> 
                        <td> RECEPTION DATE </td>
                        <td>{{ $serviceRequest->date_reception }}</td>
                    </tr>
                    <tr> 
                        <td> RECEPTION LOCATION </td>
                        <td>{{ $serviceRequest->location_reception }}</td>
                    </tr>
                    <tr> 
                        <td> GUESTS </td>
                        <td>{{ $serviceRequest->guests }}</td>
                    </tr>
                    <tr> 
                        <td> BRIDSMAIDS </td>
                        <td>{{ $serviceRequest->bridesmaids }}</td>
                    </tr>
                    <tr> 
                        <td> ALLERGIES </td>
                        <td>{{ $serviceRequest->allergies }}</td>
                    </tr>
                    <tr> 
                        <td> GROOMSMEN </td>
                        <td>{{ $serviceRequest->groomsmen }}</td>
                    </tr>
                    <tr> 
                        <td> BUDGET </td>
                        <td>{{ $serviceRequest->budget }}</td>
                    </tr>
                    <tr> 
                        <td> WEDDING COLOR </td>
                        <td>{{ $serviceRequest->wedding_color }}</td>
                    </tr>
                    <tr> 
                        <td> WEDDING STYLE </td>
                        <td>{{ $serviceRequest->wedding_style }}</td>
                    </tr>
                    <tr> 
                        <td> FAVORITE FLOWERS </td>
                        <td>{{ $serviceRequest->favorite_flowers }}</td>
                    </tr>
                    <tr> 
                        <td> STATEMENT </td>
                        <td>{{ $serviceRequest->statement }}</td>
                    </tr>
                    <tr> 
                        <td> PLANNER </td>
                        <td>{{ $serviceRequest->planner }}</td>
                    </tr>
                    <tr> 
                        <td> PRFERRED OPTION </td>
                        <td>{{ $serviceRequest->preferred_options }}</td>
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
