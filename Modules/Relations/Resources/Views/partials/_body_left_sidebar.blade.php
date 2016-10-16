<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar staff panel (optional) -->
        <div class="staff-panel">
            @if (Auth::guard('staff')->check())
                <div class="pull-left image">
                    <img src="{{ Gravatar::get(Auth::guard('staff')->user()->email , 'small') }}" class="img-circle" alt="Staff Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->full_name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            @endif
        </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">

                <li class="treeview @yield('Staff')">
                    <a href="#">
                        <i class="fa fa-users"></i> <span>{!! Lang::get('core::lang.staff') !!}</span> <i
                                class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li @yield('staff')><a href="{{ url('/adminpanel/staff/manage') }}"><i
                                        class="fa fa-user "></i>{!! Lang::get('core::lang.staff') !!}</a></li>
                        <li @yield('departments')><a href="{{ url('/adminpanel/departments/manage') }}"><i
                                        class="fa fa-sitemap"></i>{!! Lang::get('core::lang.departments') !!}</a></li>
                        <li @yield('teams')><a href="{{ url('/adminpanel/teams/manage') }}"><i
                                        class="fa fa-users"></i>{!! Lang::get('core::lang.teams') !!}</a></li>
                        <li @yield('roles')><a href="{{ url('/adminpanel/roles/manage') }}"><i
                                        class="fa fa-users"></i>{!! Lang::get('core::lang.roles') !!}</a></li>
                    </ul>
                </li>
            </ul>
    </section>
    <!-- /.sidebar -->
</aside>
