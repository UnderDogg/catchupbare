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


            <li class="treeview @yield('Settings')">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{!! Lang::get('core::lang.settings') !!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('staff')><a href="{{ url('/adminpanel/settings/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::settings.manage') !!}</a></li>
                </ul>
            </li>




            <li class="treeview @yield('Templates')">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{!! Lang::get('core::lang.templates') !!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('templates')><a href="{{ url('/adminpanel/templates/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::templates.manage') !!}</a></li>
                    <li @yield('templategroups')><a href="{{ url('/adminpanel/templategroups/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::templategroups.manage') !!}</a></li>
                    <li @yield('templateimpex')><a href="{{ url('/adminpanel/templateimpex') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::templateimpex') !!}</a></li>
                    <li @yield('templaterestore')><a href="{{ url('/adminpanel/templaterestore') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::templaterestore') !!}</a></li>
                    <li @yield('templatediagnostics')><a href="{{ url('/adminpanel/templatediagnostics') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::templatediagnostics') !!}</a></li>
                    <li @yield('templatediagnostics')><a href="{{ url('/adminpanel/templatediagnostics') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::templatediagnostics') !!}</a></li>
                </ul>
            </li>

            <li class="treeview @yield('EmailParser')">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{!! Lang::get('core::lang.emailparser') !!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('mailboxes')><a href="{{ url('/mailpanel/mailboxes/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('email::mailboxes.manage') !!}</a></li>
                    <li @yield('mailparser')><a href="{{ url('/mailpanel/emailparser/settings') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('email::emailparser.settings') !!}</a></li>
                    <li @yield('mailrules')><a href="{{ url('/mailpanel/emailparser/mailrules') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('email::emailparser.mailrules') !!}</a></li>
                    <li @yield('emailcatchall')><a href="{{ url('/mailpanel/emailparser/emailcatchall') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('email::emailparser.emailcatchall') !!}</a></li>
                    <li @yield('emailloopblock')><a href="{{ url('/mailpanel/emailparser/emailloopblock') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('email::emailparser.emailloopblock') !!}</a></li>
                    <li @yield('loopblockrules')><a href="{{ url('/mailpanel/emailparser/loopblockrules') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('email::emailparser.loopblockrules') !!}</a></li>
                    <li @yield('parserlog')><a href="{{ url('/mailpanel/emailparser/parserlog') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('email::emailparser.parserlog') !!}</a></li>
                    <li @yield('breaklines')><a href="{{ url('/mailpanel/emailparser/breaklines') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('email::emailparser.breaklines') !!}</a></li>
                    <li @yield('emailbans')><a href="{{ url('/mailpanel/emailparser/emailbans') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('email::emailparser.emailbans') !!}</a></li>
                    <li @yield('attachmentfiletypes')><a href="{{ url('/mailpanel/attachmentfiletypes') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('email::attachmentfiletypes') !!}</a></li>

                    <li @yield('purgeattachments')><a href="{{ url('/mailpanel/purgeattachments') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('email::purgeattachments') !!}</a></li>
                    <li @yield('moveattachments')><a href="{{ url('/mailpanel/moveattachments') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('email::moveattachments') !!}</a></li>


                </ul>
            </li>

            <li class="treeview @yield('Tickets')">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{!! Lang::get('tickets::lang.settings') !!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('tickettypes')><a href="{{ url('/ticketspanel/tickettypes/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('tickets::tickettypes.manage') !!}</a></li>
                    <li @yield('ticketstatuses')><a href="{{ url('/ticketspanel/ticketstatuses/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('tickets::ticketstatuses.manage') !!}</a></li>
                    <li @yield('ticketpriorities')><a href="{{ url('/ticketspanel/ticketpriorities/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('tickets::ticketpriorities.manage') !!}</a></li>

                    <li @yield('ticketmaintenance')><a href="{{ url('/ticketspanel/ticketmaintenance') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('tickets::ticketmaintenance') !!}</a></li>

                    <li @yield('ticketsources')><a href="{{ url('/ticketspanel/ticketsources/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('tickets::ticketsources.manage') !!}</a></li>
                    <li @yield('ticketautoclose')><a href="{{ url('/ticketspanel/ticketautoclose/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('tickets::ticketautoclose.manage') !!}</a></li>
                    <li @yield('ticketlinks')><a href="{{ url('/ticketspanel/ticketlinks/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('tickets::ticketlinks.manage') !!}</a></li>
                    <li @yield('ticketsettings')><a href="{{ url('/ticketspanel/settings/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('tickets::settings.manage') !!}</a></li>
                </ul>
            </li>


            <li class="treeview @yield('SLA')">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{!! Lang::get('core::lang.slasettings') !!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('slaplans')><a href="{{ url('/adminpanel/slaplans/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::slaplans.manage') !!}</a></li>
                    <li @yield('slasettings')><a href="{{ url('/adminpanel/slasettings/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::slasettings.manage') !!}</a></li>
                    <li @yield('slaschedules')><a href="{{ url('/adminpanel/slaschedules/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::slaschedules.manage') !!}</a></li>
                    <li @yield('slaholidays')><a href="{{ url('/adminpanel/slaholidays/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::slaholidays.manage') !!}</a></li>
                    <li @yield('slaholidayimpex')><a href="{{ url('/adminpanel/slaholidayimpex/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::slaholidayimpex.manage') !!}</a></li>
                </ul>
            </li>



            <li class="treeview @yield('KnowledgeBase')">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{!! Lang::get('kb::lang.settings') !!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('kbmaintenance')><a href="{{ url('/kbpanel/kbmaintenance') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('kb::kbmaintenance') !!}</a></li>
                    <li @yield('kbsettings')><a href="{{ url('/kbpanel/settings/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('kb::settings.manage') !!}</a></li>
                </ul>
            </li>

            <li class="treeview @yield('Troubleshooter')">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{!! Lang::get('kb::lang.troubleshooter') !!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('troubleshooter')><a href="{{ url('/kbpanel/troubleshooter') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('kb::troubleshooter') !!}</a></li>
                    <li @yield('troubleshootersettings')><a href="{{ url('/kbpanel/troubleshooter/settings') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('kb::troubleshootersettings') !!}</a></li>
                </ul>
            </li>

            <li class="treeview @yield('Logs')">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{!! Lang::get('kb::lang.troubleshooter') !!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('errorlogs')><a href="{{ url('/adminpanel/errorlogs') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::errorlogs') !!}</a></li>

                    <li @yield('activitytasklogs')><a href="{{ url('/adminpanel/activitytasklogs') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::activitytasklogs') !!}</a></li>
                    <li @yield('loginlogs')><a href="{{ url('/adminpanel/loginlogs') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::loginlogs') !!}</a></li>
                </ul>
            </li>


            <li class="treeview @yield('ScheduledTasks')">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{!! Lang::get('core::scheduledtasks') !!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('scheduledtasks')><a href="{{ url('/adminpanel/scheduledtasks/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::scheduledtasks.manage') !!}</a></li>
                    <li @yield('scheduledtasklogs')><a href="{{ url('/adminpanel/scheduledtasklogs') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::scheduledtasklogs') !!}</a></li>
                </ul>
            </li>

            <li class="treeview @yield('ImportExport')">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{!! Lang::get('core::importexport') !!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('importexport')><a href="{{ url('/adminpanel/importexport/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::scheduledtasks.manage') !!}</a></li>
                    <li @yield('importexportlogs')><a href="{{ url('/adminpanel/importexportlogs') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::importexportlogs') !!}</a></li>
                </ul>
            </li>

            <li class="treeview @yield('Diagnostics')">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{!! Lang::get('core::diagnostics') !!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('diagnosticssessions')><a href="{{ url('/adminpanel/activesessions/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::activesessions.manage') !!}</a></li>
                    <li @yield('cacheinfo')><a href="{{ url('/adminpanel/cacheinfo/manage') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::cacheinfo') !!}</a></li>
                    <li @yield('rebuildcache')><a href="{{ url('/adminpanel/rebuildcache') }}"><i
                                    class="fa fa-user "></i>{!! Lang::get('core::rebuildcache') !!}</a></li>

                </ul>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
