<div class="page-header navbar navbar-fixed-top">
    <div class="page-header-inner ">
        {{-- Page Logo --}}
            <div class="page-logo">
                <a href="{{ route('admin.dashboard.index') }}">
                    <img class="logo-default" src="{{ asset('admin/images/logo.svg') }}" alt="{{ config('app.name') }}" height="40" />
                </a>
                <div class="menu-toggler sidebar-toggler"> </div>
            </div>
        {{-- Toggler For Menu --}}
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>
        
        {{-- User Right Side Menu --}}
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <span class="username username-hide-on-mobile"> {{ Auth::user()->full_name }} </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="{{ route('admin.profile-show') }}">
                                <i class="icon-user"></i> My Profile </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.change-password') }}">
                                <i class="icon-lock"></i> Change Password </a>
                        </li>
                        <li class="divider"> </li>
                        <li>
                            <a href="{{ route('admin.logout') }}">
                                <i class="icon-logout"></i> Logout </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>