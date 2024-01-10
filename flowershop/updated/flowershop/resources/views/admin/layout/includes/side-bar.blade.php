<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 10px">
            @foreach ($menu as $section)
                @if( count($section['roles']) >= 2 )
                    <li class="nav-item start">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            @if( $section['icon_type'] == 'image' )
                                <img class="menu-icon" src="#" alt="{{ str_slug($section['name']) }}">
                            @else
                                <i class="{{ $section['icon'] }}"></i>
                            @endif
                            <span class="title">{{ $section['name'] }}</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            @foreach ($section['roles'] as $role)

                                <li class="nav-item start {{ $role['class'] }} {{ $role['class'] ? 'open' : '' }}">
                                    <a href="{{ (!empty($role['params'])) ? route($role['route'], $role['params']) : route($role['route']) }}" class="nav-link ">
                                        @if( $role['icon_type'] == 'image' )
                                            <img class="menu-icon" src="#" alt="{{ str_slug($role['title']) }}">
                                        @else
                                            <i class="{{ $role['icon'] }}"></i>
                                        @endif
                                        <span class="title">{{ $role['title'] }}</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    @php
                        $menu = reset($section['roles'])
                    @endphp

                    <li class="nav-item start {{ $menu['class'] }}">
                        <a href="{{ (!empty($menu['params'])) ? route($menu['route'], $menu['params']) : route($menu['route']) }}" class="nav-link ">
                            @if( $menu['icon_type'] == 'image' )
                                <img class="menu-icon" alt="{{ str_slug($menu['title']) }}">
                            @else
                                <i class="{{ $menu['icon'] }}"></i>
                            @endif
                            <span class="title">{{ $menu['title'] }}</span>
                            {{-- <span class="selected"></span> --}}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>