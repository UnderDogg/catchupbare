<div class="wrapper">

    <!-- Header -->
    @include('core::partials._body_header')

    <!-- Sidebar -->
    @include('core::partials._body_left_sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <div class="tab-content" style="background-color: white;padding: 0 20px 0 20px">
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <div class="tabs-content">
                    <div class="tabs-pane @yield('dashboard-bar')" id="tabAdminPanel">
                        <ul class="nav navbar-nav">
                            <li id="bar" @yield('dashboard') ><a href="{{url('/adminpanel/')}}">{!! Lang::get('core::lang.dashboard') !!}</a></li>
                            <li id="bar" @yield('profile') ><a href="{{url('/staff/profile')}}">{!! Lang::get('employees::lang.profile') !!}</a></li>
                        </ul>
                    </div>
                    <div class="tabs-pane @yield('staff-bar')" id="tabStaffPanel">
                        <ul class="nav navbar-nav">
                            <li id="bar" @yield('staff')><a href="{{ url('/adminpanel/staff/manage') }}">{!! Lang::get('core::lang.user_directory') !!}</a></li></a></li>
                        </ul>
                    </div>
                    <div class="tabs-pane @yield('tickets-bar')" id="tabTicketsPanel">
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
                    <div class="tabs-pane @yield('kb-bar')" id="tabKbPanel">
                        <ul class="nav navbar-nav">
                            <li id="bar" @yield('tools')><a href="{{ url('/tickets/canned/list') }}">{!! Lang::get('tickets::lang.canned_response') !!}</a></li>
                            <li id="bar" @yield('kb')><a href="{{ url('/kbpanel/comments') }}">{!! Lang::get('knowledgebase::lang.knowledge_base') !!}</a></li>
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

