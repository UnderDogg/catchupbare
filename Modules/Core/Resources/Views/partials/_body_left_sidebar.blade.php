<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar staff panel (optional) -->
        <div class="staff-panel">
            @if (Auth::guard('staff')->check())
                <div class="pull-left image">
                    <img src="{{ Gravatar::get(Auth::guard('staff')->user()->email , 'small') }}" class="img-circle"
                         alt="Staff Image"/>
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

            <li class="treeview @yield('AdminPanel')">
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


            <li class="treeview @yield('Settings')">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{!! Lang::get('core::lang.settings') !!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('staff')><a href="{{ url('/adminpanel/settings/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::lang.settings') !!}</a></li>
                </ul>
            </li>
            <li class="treeview @yield('Tickets')">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{!! Lang::get('tickets::lang.ticketspanel') !!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('tickettypes')><a href="{{ url('/ticketspanel/tickettypes') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('tickets::lang.tickettypes.manage') !!}</a></li>
                    <li @yield('ticketstatuses')><a href="{{ url('/ticketspanel/ticketstatuses') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('tickets::lang.ticketstatuses.manage') !!}</a></li>
                    <li @yield('ticketpriorities')><a href="{{ url('/ticketspanel/ticketpriorities') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('tickets::lang.ticketpriorities.manage') !!}</a></li>

                    <li @yield('ticketmaintenance')><a href="{{ url('/ticketspanel/ticketmaintenance') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('tickets::lang.ticketmaintenance') !!}</a></li>

                    <li @yield('ticketsources')><a href="{{ url('/ticketspanel/ticketsources') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('tickets::lang.ticketsources.manage') !!}</a></li>
                    <li @yield('ticketautoclose')><a href="{{ url('/ticketspanel/ticketautoclose') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('tickets::lang.ticketautoclose.manage') !!}</a></li>
                    <li @yield('ticketlinks')><a href="{{ url('/ticketspanel/ticketlinks') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('tickets::lang.ticketlinks.manage') !!}</a></li>
                    <li @yield('ticketsettings')><a href="{{ url('/ticketspanel/settings') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('tickets::lang.settings.manage') !!}</a></li>
                </ul>
            </li>
            <li class="treeview @yield('SLA')">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{!! Lang::get('core::lang.slasettings') !!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('slaplans')><a href="{{ url('/adminpanel/slaplans/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::lang.slaplans.manage') !!}</a></li>
                    <li @yield('slasettings')><a href="{{ url('/adminpanel/slasettings/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::lang.slasettings.manage') !!}</a></li>
                    <li @yield('slaschedules')><a href="{{ url('/adminpanel/slaschedules/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::lang.slaschedules.manage') !!}</a></li>
                    <li @yield('slaholidays')><a href="{{ url('/adminpanel/slaholidays/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::lang.slaholidays.manage') !!}</a></li>
                    <li @yield('slaholidayimpex')><a href="{{ url('/adminpanel/slaholidayimpex/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::lang.slaholidayimpex.manage') !!}</a></li>
                </ul>
            </li>



            <li class="treeview @yield('KnowledgeBase')">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{!! Lang::get('knowledgebase::lang.kbpanel') !!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('kbmaintenance')><a href="{{ url('/kbpanel/kbmaintenance') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('knowledgebase::lang.kbmaintenance') !!}</a></li>
                    <li @yield('kbsettings')><a href="{{ url('/kbpanel/settings/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('knowledgebase::lang.settings.manage') !!}</a></li>
                </ul>
            </li>

            <li class="treeview @yield('Troubleshooter')">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{!! Lang::get('knowledgebase::lang.troubleshooter') !!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('troubleshooter')><a href="{{ url('/kbpanel/troubleshooter') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('knowledgebase::lang.troubleshooter') !!}</a></li>
                    <li @yield('troubleshootersettings')><a href="{{ url('/kbpanel/troubleshooter/settings') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('knowledgebase::lang.troubleshootersettings') !!}</a></li>
                </ul>
            </li>

            <li class="treeview @yield('Logs')">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{!! Lang::get('core::lang.logs') !!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('errorlogs')><a href="{{ url('/adminpanel/errorlogs') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::lang.errorlogs') !!}</a></li>

                    <li @yield('activitytasklogs')><a href="{{ url('/adminpanel/activitytasklogs') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::lang.activitytasklogs') !!}</a></li>
                    <li @yield('loginlogs')><a href="{{ url('/adminpanel/loginlogs') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::lang.loginlogs') !!}</a></li>
                </ul>
            </li>


            <li class="treeview @yield('ScheduledTasks')">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{!! Lang::get('core::lang.scheduledtasks') !!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('scheduledtasks')><a href="{{ url('/adminpanel/scheduledtasks/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::lang.scheduledtasks.manage') !!}</a></li>
                    <li @yield('scheduledtasklogs')><a href="{{ url('/adminpanel/scheduledtasklogs') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::lang.scheduledtasks.logs') !!}</a></li>
                </ul>
            </li>

            <li class="treeview @yield('ImportExport')">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{!! Lang::get('core::lang.importexport') !!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('importexport')><a href="{{ url('/adminpanel/importexport/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::lang.importexport.manage') !!}</a></li>
                    <li @yield('importexportlogs')><a href="{{ url('/adminpanel/importexportlogs') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::lang.importexport.logs') !!}</a></li>
                </ul>
            </li>

            <li class="treeview @yield('Diagnostics')">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{!! Lang::get('core::lang.diagnostics') !!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('diagnosticssessions')><a href="{{ url('/adminpanel/activesessions/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::lang.activesessions.manage') !!}</a></li>
                    <li @yield('cacheinfo')><a href="{{ url('/adminpanel/cacheinfo/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::lang.cacheinfo') !!}</a></li>
                    <li @yield('rebuildcache')><a href="{{ url('/adminpanel/rebuildcache') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::lang.rebuildcache') !!}</a></li>

                </ul>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
