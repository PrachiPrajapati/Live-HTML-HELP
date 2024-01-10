@extends('admin.layout.app')

@push('page-title')
	<h3 class="page-title"> Dashboard
	    {{-- <small>dashboard & statistics</small> --}}
	</h3>
@endpush

@section('main-content')
    
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a href="{{ route('admin.users.index') }}">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="{{ $data['users'] }}">{{ $data['users'] }}</span>
                                <small class="font-green-sharp"></small>
                            </h3>
                            <small>Total Users</small>
                        </div>
                        <div class="icon">
                            <i class="icon-users"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success green-sharp">
                                <span class="sr-only">76% progress</span>
                            </span>
                        </div>
                        {{-- <div class="status">
                            <div class="status-title"> progress </div>
                            <div class="status-number"> 76% </div>
                        </div> --}}
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a href="{{ route('admin.product.index') }}">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="{{ $data['products'] }}">{{ $data['products'] }}</span>
                                <small class="font-green-sharp"></small>
                            </h3>
                            <small>Total Products</small>
                        </div>
                        <div class="icon">
                            <i class="fa fa-list"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success green-sharp">
                                <span class="sr-only">76% progress</span>
                            </span>
                        </div>
                        {{-- <div class="status">
                            <div class="status-title"> progress </div>
                            <div class="status-number"> 76% </div>
                        </div> --}}
                    </div>
                </div>
            </a>
        </div>

@endsection
@push('extra-js')
    <script src="{{ asset('admin/plugins/counterup/jquery.waypoints.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/plugins/counterup/jquery.counterup.min.js') }}" type="text/javascript"></script>
@endpush