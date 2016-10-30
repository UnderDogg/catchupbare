<div class="wrapper">

    <!-- Header -->
    @include('core::partials._body_header')

    <!-- Sidebar -->
    @include('core::partials._body_left_sidebar')

    <!-- Content Wrapper. Contains page content -->
    <!-- Right side column. Contains the navbar and content of the page -->
    <div class="content-wrapper">


      <!-- Content Header (Page header) -->
      <div class="tab-content" style="background-color: white;padding: 0 20px 0 20px">
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <div class="tabs-content">

                    <div class="tabs-pane @yield('adminpanel-bar')" id="tabAdminPanel">
                        <ul class="nav navbar-nav">
                            <li id="bar" @yield('adminpanel') ><a href="{{url('/adminpanel/')}}">{!! Lang::get('core::lang.dashboard') !!}</a></li>
                            <li id="bar" @yield('staff')><a href="{{ url('/adminpanel/staff/manage') }}">{!! Lang::get('core::lang.staffmembers') !!}</a></li>
                            <li id="bar" @yield('departments')><a href="{{ url('/adminpanel/departments/manage') }}">{!! Lang::get('core::lang.departments') !!}</a></li>
                            <li id="bar" @yield('teams')><a href="{{ url('/adminpanel/teams/manage') }}">{!! Lang::get('core::lang.teams') !!}</a></li>
                            <li id="bar" @yield('roles')><a href="{{ url('/adminpanel/roles/manage') }}">{!! Lang::get('core::lang.roles') !!}</a></li>
                            <li id="bar" @yield('relations')><a href="{{ url('relations') }}">{!! Lang::get('relations::lang.relationspanel')!!}</a></li>
                        </ul>
                    </div>

                    <div class="tabs-pane @yield('staffpanel-bar')" id="tabStaffPanel">
                        <ul class="nav navbar-nav">
                            <li id="bar" @yield('staff')><a href="{{ url('/adminpanel/staff/manage') }}">{!! Lang::get('core::lang.staffmembers') !!}</a></li>
                            <li id="bar" @yield('relations')><a href="{{ url('relations') }}">{!! Lang::get('relations::lang.relationspanel')!!}</a></li>
                        </ul>
                    </div>
                    <div class="tabs-pane @yield('ticketspanel-bar')" id="tabTicketsPanel">
                        <ul class="nav navbar-nav">
                            <li id="bar" @yield('open')><a href="{{ url('/tickets/open') }}" id="load-open">{!! Lang::get('tickets::lang.open') !!}</a></li>
                            <li id="bar" @yield('answered')><a href="{{ url('/tickets/answered') }}" id="load-answered">{!! Lang::get('tickets::lang.answered')!!}</a></li>
                            <li id="bar" @yield('myticket')><a href="{{ url('/tickets/mytickets') }}">{!! Lang::get('tickets::lang.my_tickets') !!}</a></li>
                            <li id="bar" @yield('ticket')><a href="{{ url('/tickets/') }}">Ticket</a></li>
                            <li id="bar" @yield('overdue')><a href="{{ url('/tickets/overdue') }}">Overdue</a></li>
                            <li id="bar" @yield('assigned')><a href="{{ url('/tickets/assigned') }}" id="load-assigned">{!! Lang::get('tickets::lang.assigned')!!}</a></li>
                            <li id="bar" @yield('closed')><a href="{{ url('/tickets/closed') }}">{!! Lang::get('tickets::lang.closed') !!}</a></li>
                            <li id="bar" @yield('newticket')><a href="{{ url('/tickets/newticket') }}">{!! Lang::get('tickets::lang.create_ticket') !!}</a></li>
                        </ul>
                    </div>

                    <div class="tabs-pane @yield('mailpanel-bar')" id="tabMailPanel">
                        <ul class="nav navbar-nav">
                            <li id="bar" @yield('tools')><a href="{{ url('/tickets/canned/list') }}">{!! Lang::get('tickets::lang.canned_response') !!}</a></li>
                            <li id="bar" @yield('kb')><a href="{{ url('/kbpanel/comments') }}">{!! Lang::get('knowledgebase::lang.knowledge_base') !!}</a></li>
                        </ul>
                    </div>
                    <div class="tabs-pane @yield('relationspanel-bar')" id="tabRelPanel">
                        <ul class="nav navbar-nav">
                            <li id="bar" @yield('tools')><a href="{{ url('/tickets/canned/list') }}">{!! Lang::get('tickets::lang.canned_response') !!}</a></li>
                            <li id="bar" @yield('kb')><a href="{{ url('/kbpanel/comments') }}">{!! Lang::get('knowledgebase::lang.knowledge_base') !!}</a></li>
                        </ul>
                    </div>
                    <div class="tabs-pane @yield('kbpanel-bar')" id="tabKbPanel">
                        <ul class="nav navbar-nav">
                            <li id="bar" @yield('tools')><a href="{{ url('/tickets/canned/list') }}">{!! Lang::get('tickets::lang.canned_response') !!}</a></li>
                            <li id="bar" @yield('kb')><a href="{{ url('/kbpanel/comments') }}">{!! Lang::get('knowledgebase::lang.knowledge_base') !!}</a></li>
                        </ul>
                    </div>


                    <div class="tabs-pane @yield('dashboard-bar')" id="tabA">
                        <ul class="nav navbar-nav">
                            <li id="bar" @yield('dashboard') ><a href="{{url('dashboard')}}">{!! Lang::get('core::lang.dashboard') !!}</a></li>
                            <li id="bar" @yield('profile') ><a href="{{url('profile')}}">{!! Lang::get('employees::lang.profile') !!}</a></li>
                        </ul>
                    </div>

                    <div class="tabs-pane @yield('ticket-bar')" id="tabC">
                        <ul class="nav navbar-nav">
                            <li id="bar" @yield('open')><a href="{{ url('/tickets/open') }}" id="load-open">{!! Lang::get('tickets::lang.open') !!}</a></li>
                            <li id="bar" @yield('answered')><a href="{{ url('/ticket/answered') }}" id="load-answered">{!! Lang::get('tickets::lang.answered')
                        !!}</a></li>
                            <li id="bar" @yield('myticket')><a href="{{ url('/ticket/myticket') }}">{!! Lang::get('tickets::lang.my_tickets') !!}</a></li>

                            <li id="bar" @yield('assigned')><a href="{{ url('/ticket/assigned') }}" id="load-assigned">{!! Lang::get('tickets::lang.assigned')
                        !!}</a></li>
                            <li id="bar" @yield('closed')><a href="{{ url('/ticket/closed') }}">{!! Lang::get('tickets::lang.closed') !!}</a></li>
                            <li id="bar" @yield('newticket')><a href="{{ url('/newticket') }}">{!! Lang::get('tickets::lang.create_ticket') !!}</a></li>
                        </ul>
                    </div>
                    <div class="tabs-pane @yield('tools-bar')" id="tabD">
                        <ul class="nav navbar-nav">
                            <li id="bar" @yield('tools')><a href="{{ url('/canned/list') }}">{!! Lang::get('tickets::lang.canned_response') !!}</a></li>
                            <li id="bar" @yield('kb')><a href="{{ url('/comment') }}">{!! Lang::get('knowledgebase::lang.knowledge_base') !!}</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>


        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ $page_title or "Page Title" }}
                <small>{{ $page_description or "Page description" }}</small>
            </h1>
            {!! MenuBuilder::renderBreadcrumbTrail(null, 'root', false)  !!}
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="box-body">
                @include('flash::message')
                @include('partials._errors')
            </div>

            <!-- Your Page Content Here -->
            @yield('content')

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Body Footer -->
    @include('core::partials._body_footer')

    @if ( config('app.right_sidebar') )
        <!-- Body right sidebar -->
        @include('core::partials._body_right_sidebar')
    @endif

</div><!-- ./wrapper -->

