@extends('admin.layout.app')

@push('css-top')
	<link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('box_view') !!}
@endpush

@push('page-title')
	<h3 class="page-title"> 
	</h3>
@endpush

@section('main-content')
	<div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> Box Details </span> 
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided">
                            @if (in_array('edit', $permissions))
                            <a href="{{ route('admin.box.edit',$box->id) }}" class="btn btn-info">
                                Edit {{ str_singular($title) }}
                            </a>
                            @endif
                            @if (in_array('delete', $permissions))
                            <a href="{{ route('admin.box.delete',$box->id) }}" class="btn btn-sm btn-danger">
                                 Delete {{ str_singular($title) }}</a>
                            @endif
                          
                        </div>
                    </div>
                </div>
                <div class="profile-content">
                    <div class="col-md-12">
                        <div class="form-group col-md-3">
                            <label class="control-label"><span class="mendatory"></span><strong>Box  Title</strong></label>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label"><span class="mendatory"></span><strong>Sub-Boxes</strong></label>
                        </div>
                    </div>
                            
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-3">
                            <strong><label class="control-label"><span class="mendatory" style="font-size: 20px;"></span>
                            {{ $box->title }}
                            </label></strong>
                        </div>
                        <div class="form-group col-md-3">
                            <strong><label class="control-label"><span class="mendatory"></span>{{ $subbox_count }}</label></strong>
                        </div>
                    </div>  
                </div>
            </div>

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> Sub-Boxes List </span>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover table-checkable" id="subBoxsList">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Sr No.</th>
                                <th style="width: 40%;">Title</th>
                                <th style="width: 20%;">Image</th>
                                <th style="width: 20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sub_boxes as $sub_box)  
                                <tr>
                                    <td>                            
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $sub_box->shape->getTitle() }}
                                    </td>
                                    <td>
                                        <img src="{{ generateURL($sub_box->image) }}" style="height: 40px; width: 40px;">
                                    </td>
                                    <td>
                                        <a onclick="addOverlay()" href="{{ route('admin.box.edit',$box->id) }}"  title="Edit" class="btn extra-maring btn-warning btn-sm">
                                            <img class="btn-icon-img" src="{{ asset('admin/images/action/edit.svg') }}">
                                        </a>
                                        {{-- <a title="Delete" src="{{ route('admin.subbox.delete',$sub_box->custom_id) }}" class="btn extra-maring btn-danger btn-sm act-delete">
                                            <img class="btn-icon-img" src="{{ asset('admin/images/action/delete.svg') }}">
                                        </a> --}}
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
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
            var table = $('#subBoxsList');
            table.dataTable();
        });
    </script>
@endpush
