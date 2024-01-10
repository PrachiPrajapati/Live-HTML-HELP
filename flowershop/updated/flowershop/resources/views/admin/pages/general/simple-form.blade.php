@extends('admin.layout.app')

@push('page-title')
	<h3 class="page-title"> 
		Edit Profile
	</h3>
@endpush

@section('main-content')
	<div class="row">
		<div class="col-lg-9">
		    <!-- BEGIN SAMPLE FORM PORTLET-->
		    <div class="portlet light bordered">
		        <div class="portlet-title">
		            <div class="caption">
		                <i class="icon-user font-dark"></i>
		                <span class="caption-subject font-dark sbold uppercase">Manage Profile</span>
		            </div>
		        </div>
		        
		        <div class="portlet-body form">
		            <form class="form-horizontal" role="form">
		                <div class="form-body">
		                    <div class="form-group">
		                        <label class="col-lg-2 control-label">User Name</label>
		                        <div class="col-lg-10">
		                            <input type="text" class="form-control" placeholder="Enter text">
		                            <span class="help-block"> A block of help text. </span>
		                        </div>
		                    </div>
		                </div>
		                <div class="form-actions">
		                    <div class="row">
		                        <div class="col-lg-offset-3 col-lg-9">
		                            <button type="submit" class="btn green">Submit</button>
		                            <button type="button" class="btn default">Cancel</button>
		                        </div>
		                    </div>
		                </div>
		            </form>
		        </div>
		    </div>
		</div>
	</div>
@endsection