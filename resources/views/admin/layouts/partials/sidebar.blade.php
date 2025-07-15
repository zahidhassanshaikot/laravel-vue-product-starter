<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">{{__("Dashboard")}}</li>
                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect {{ Route::is('dashboard') ? 'active' : '' }}">
                        <i class="ti-dashboard"></i>
                        <span>{{__('Dashboard')}}</span>
                    </a>
                </li>
                <li class="menu-title">{{__("Main")}}</li>
                @canany(['User','Role'])
                <li class="{{ isActiveRoute(['roles', 'users']) }}">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-user-tie"></i>
                        <span>{{__('Administration')}}</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li class="{{ isActiveRoute('roles') }}">
                            <a href="{{ route('roles.index') }}">{{ __('Roles') }}</a>
                        </li>
                        <li class="{{ isActiveRoute('users') }}">
                            <a href="{{ route('users.index') }}">{{ __('Users') }}</a>
                        </li>
                    </ul>
                </li>
                @endcanany

                @can('Student')
                    <li class="{{ isActiveRoute('students') }}">
                        <a href="{{ route('students.index') }}" class="waves-effect">
                            <i class="ti-user"></i>
                            <span>{{ __('Students') }}</span>
                        </a>
                    </li>
                @endcan
                @can('Settings')
                <li class="menu-title">{{ __('Settings') }}</li>
                <li>
                    <a href="{{ route('settings.index') }}" class="waves-effect {{ Route::is('settings.index') ? 'active' : '' }}">
                        <i class="ti-settings"></i>
                        <span>{{__('Settings')}}</span>
                    </a>
                </li>
                @endcan
            </ul>
        </div>
    </div>
</div>
