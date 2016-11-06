<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ config('app.short_name') }} | {{ $page_title or "Page Title" }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, staff-scalable=no' name='viewport'>
  <!-- Set a meta reference to the CSRF token for use in AJAX request -->
  <meta name="_token" content="{!! csrf_token() !!}"/>
  <!-- faveo favicon -->
  <link rel="shortcut icon" href="{{asset("lb-faveo/media/images/favicon.ico")}}">
    <!-- Bootstrap 3.3.4 -->
  <link href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />


    <!-- Font Awesome Icons 4.4.0 -->
    <link href="{{ asset("/bower_components/admin-lte/font-awesome/css/font-awesome.min.css") }}" rel="stylesheet" type="text/css" />

  <!-- Ionicons 2.0.1 -->
    <link href="{{ asset("/bower_components/admin-lte/ionicons/css/ionicons.min.css") }}" rel="stylesheet" type="text/css" />


    <!-- Theme style -->
    <link href="{{ asset("/bower_components/admin-lte/dist/css/AdminLTE.min.css") }}" rel="stylesheet" type="text/css" />
  <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link href="{{asset("lb-faveo/css/AdminLTE.css")}}" rel="stylesheet" type="text/css" />
  <link href="{{asset("lb-faveo/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css"/>

  <!-- iCheck -->
  <link href="{{asset("lb-faveo/plugins/iCheck/flat/blue.css")}}" rel="stylesheet" type="text/css"/>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <link href="{{asset("lb-faveo/css/tabby.css")}}" type="text/css" rel="stylesheet">
    {{--<link href="{{asset('css/notification-style.css')}}" rel="stylesheet" type="text/css">--}}
  <link href="{{asset("lb-faveo/css/jquerysctipttop.css")}}" rel="stylesheet" type="text/css">
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <link type="text/css" href="{{asset("lb-faveo/css/jquery.ui.css")}}" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="{{asset("lb-faveo/css/faveo-css.css")}}">


  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset("lb-faveo/plugins/select2/select2.min.css")}}">


  {{--<link rel="stylesheet" type="text/css" href="{{asset("lb-faveo/css/notification-style.css")}}">--}}

  {{--<link href="{{ URL::asset('css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css">--}}

    <link href='https://fonts.googleapis.com/css?family=Lato:400,700,300|Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

  {{--<script type="text/javascript" src="{{ URL::asset('js/jquery-2.2.3.min.js') }}"></script>--}}




  {{--<script type="text/javascript" src="{{ URL::asset('js/bootstrap-paginator.js') }}"></script>--}}

  {{--<link href="{{ URL::asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">--}}

    <!-- Application CSS-->
    <link href="{{ asset(elixir('css/all.css')) }}" rel="stylesheet" type="text/css" />

  @yield('HeadInclude')

</head>
<body class="skin-green sidebar-mini">


<header class="main-header">

    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">{{ config('app.short_name') }}</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{!! config('app.long_name') !!}</span>
    </a>

    <!-- Header Navbar -->
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </a>


        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="tabs tabs-horizontal nav navbar-nav navbar-left">
                <li @yield('AdminPanel')><a data-target="#tabAdminPanel" href="{{url('/adminpanel')}}">{!! Lang::get('core::lang.adminpanel') !!}</a></li>
                <li @yield('StaffPanel')><a data-target="#tabStaffPanel" href="{{url('/staffpanel')}}">{!! Lang::get('core::lang.staffpanel') !!}</a></li>
                <li @yield('TicketsPanel')><a data-target="#tabTicketsPanel" href="{{url('/ticketspanel')}}">{!! Lang::get('tickets::lang.ticketspanel') !!}</a></li>
                <li @yield('EmailPanel')><a data-target="#tabMailPanel" href="{{url('/mailpanel')}}">{!! Lang::get('email::lang.mailpanel') !!}</a></li>
                <li @yield('RelationsPanel')><a data-target="#tabRelPanel" href="{{url('/relationspanel')}}">{!! Lang::get('relations::lang.relationspanel') !!}</a>
                <li @yield('KnowledgeBase')><a data-target="#tabKbPanel" href="{{url('/kbpanel')}}">{!! Lang::get('knowledgebase::lang.kbpanel') !!}</a></li>
            </ul>

            @if ( config('app.context_help_area') && (isset($context_help_area)))
                <span class="pull-right">
                {!! $context_help_area   !!}
                </span>
            @endif

            <ul class="nav navbar-nav navbar-right">
                @if ( config('app.notification_area') )
                        <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 4 messages</li>
                        <li>
                            <!-- inner menu: contains the messages -->
                            <ul class="menu">
                                <li><!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <!-- Staff Image -->
                                            <img src="{{ asset("/bower_components/admin-lte/dist/img/generic_user_160x160.jpg") }}"
                                                 class="img-circle" alt="Staff Image"/>
                                        </div>
                                        <!-- Message title and timestamp -->
                                        <h4>
                                            Support Team
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <!-- The message -->
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li><!-- end message -->
                            </ul><!-- /.menu -->
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                </li><!-- /.messages-menu -->
                <!-- Notifications Menu -->
                <li class="dropdown notifications-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 10 notifications</li>
                        <li>
                            <!-- Inner Menu: contains the notifications -->
                            <ul class="menu">
                                <li><!-- start notification -->
                                    <a href="#">
                                        <i class="fa fa-staff text-aqua"></i> 5 new members joined today
                                    </a>
                                </li><!-- end notification -->
                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>
                <!-- Tasks Menu -->
                <li class="dropdown tasks-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-danger">9</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 9 tasks</li>
                        <li>
                            <!-- Inner menu: contains the tasks -->
                            <ul class="menu">
                                <li><!-- Task item -->
                                    <a href="#">
                                        <!-- Task title and progress text -->
                                        <h3>
                                            Task Header <small class="pull-right">20%</small>
                                        </h3>
                                        <!-- The progress bar -->
                                        <div class="progress xs">
                                            <!-- Change the css width attribute to simulate progress -->
                                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">20% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li><!-- end task item -->
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#">View all tasks</a>
                        </li>
                    </ul>
                </li>
                @endif  {{--app.notification_area--}}

                        <!-- Staff Account Menu -->
                <li class="dropdown staff staff-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The staff image in the navbar-->
                        <img src="{{ Gravatar::get(Auth::user()->email , 'tiny') }}" class="staff-image"
                             alt="Staff Image"/>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ Auth::user()->username }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The staff image in the menu -->
                        <li class="staff-header">
                            <img src="{{ Gravatar::get(Auth::user()->email , 'medium') }}" class="img-circle"
                                 alt="Staff Image"/>
                            <p>
                                {{ Auth::user()->full_name }}
                                <small>Member since {{ Auth::user()->created_at->format("F, Y") }}</small>
                            </p>
                        </li>

                        @if ( config('app.extended_staff_menu') )
                                <!-- Menu Body -->
                        <li class="staff-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li>
                        @endif

                                <!-- Menu Footer-->
                        <li class="staff-footer">

                            @if ( config('app.staff_profile_link') )
                                <div class="pull-left">
                                    {!! link_to_route('staff.profile', 'Profile', [], ['class' => "btn btn-default btn-flat"]) !!}
                                </div>
                            @endif

                            <div class="pull-right">
                                {!! link_to_route('logout', 'Sign out', [], ['class' => "btn btn-default btn-flat"]) !!}
                            </div>
                        </li>
                    </ul>
                </li>

                @if ( config('app.right_sidebar') )
                        <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
                @endif
            </ul>

            <ul class="nav navbar-nav navbar-right">
              <li><a href="{{url('/kbpanel')}}">Kb Panel</a></li>
              <li><a href="{{url('/mailpanel')}}">Mail Panel</a></li>
              <li><a href="{{url('/staffpanel')}}">Staff Panel</a></li>
              <li><a href="{{url('/adminpanel')}}">Admin Panel</a></li>
            </ul>

        </div><!--  class="collapse navbar-collapse" id="navbar-collapse" -->

    </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <div class="staff-panel">
      @if (trim($__env->yieldContent('profileimg')))
        <h1>@yield('profileimg')</h1>
      @else
        <div class="row">
          <div class="col-xs-3"></div>
          <div class="col-xs-2" style="width:50%;">
            <a href="{!! url('profile') !!}">

                            <img src="#" class="img-circle" alt="Ticket Master"/>

            </a>
          </div>
        </div>
      @endif
      <div class="info" style="text-align:center;">
        @if(Auth::guard('staff')->user())
          <p>{{Auth::guard('staff')->user()->first_name." ".Auth::guard('staff')->user()->last_name}}</p>
        @endif
        @if(Auth::guard('staff')->user() && Auth::guard('staff')->user()->active==1)
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        @else
          <a href="#"><i class="fa fa-circle"></i> Offline</a>
        @endif
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul id="side-bar" class="sidebar-menu">
            @yield('sidebar')
            <li class="header">{!! Lang::get('tickets::lang.ticketspanel') !!}</li>
            <li class="treeview @yield('TicketsPanel')">
                <a href="#">
                    <i class="fa fa-envelope-o"></i>
                    <span>{!! Lang::get('tickets::lang.ticketspanel') !!}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('ticketcategories')><a href="{{ url('/ticketspanel/ticketcategories') }}"><i
                                    class="fa fa-plus"></i>{!! Lang::get('tickets::lang.ticketcategories') !!}</a></li>
                </ul>
            </li>
        </ul>
  </section>
  <!-- /.sidebar -->
</aside>

    <!-- Content Wrapper. Contains page content -->
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="tab-content" style="background-color: white;padding: 0 20px 0 20px">
    <div class="collapse navbar-collapse" id="navbar-collapse">
      <div class="tabs-content">
        <div class="tabs-pane @yield('tickets-bar')" id="tabA">
          <ul class="nav navbar-nav">
            <li id="bar" @yield('ticketcategories') ><a href="{{url('/ticketspanel/ticketcategories')}}">{!! Lang::get('tickets::lang.ticketcategories') !!}</a></li>
            <li id="bar" @yield('profile') ><a href="{{url('profile')}}">{!! Lang::get('employees::lang.profile') !!}</a></li>
          </ul>
        </div>
        <div class="tabs-pane @yield('user-bar')" id="tabB">
          <ul class="nav navbar-nav">
            <li id="bar" @yield('user')><a href="{{ url('user') }}">{!! Lang::get('core::lang.user_directory') !!}</a></li></a></li>
            <li id="bar" @yield('relations')><a href="{{ url('relations') }}">{!! Lang::get('relations::lang.relations')
              !!}</a></li></a></li>
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
  <section class="content-header">
    @yield('PageHeader')
    @yield('breadcrumbs')
  </section>
  <!-- Main content -->
  <section class="content">
    @yield('content')
  </section><!-- /.content -->
<!-- /.content-wrapper -->
</div>

<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> {!! Config::get('app.version') !!}
  </div>
      <strong>{!! Lang::get('core::lang.copyright') !!} &copy; {!! date('Y') !!}  <a href="#" target="_blank">company_name</a>.</strong> {!! Lang::get('core::lang.all_rights_reserved') !!}. {!! Lang::get('core::lang.powered_by') !!} <a href="http://www.faveohelpdesk.com/" target="_blank">Faveo</a>
</footer>





                    </div><!-- ./wrapper -->
                    {{-- // <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> --}}
                    <!-- jQuery 2.1.3 -->
                     <script src="{{asset("lb-faveo/js/ajax-jquery.min.js")}}"></script>
                    
                    {{-- // <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script> --}}

                    <script src="{{asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>
                    <!-- Bootstrap 3.3.2 JS -->
                    <script src="{{asset("lb-faveo/js/bootstrap.min.js")}}" type="text/javascript"></script>
                    <!-- Slimscroll -->
                    <script src="{{asset("lb-faveo/plugins/slimScroll/jquery.slimscroll.min.js")}}" type="text/javascript"></script>
                    <!-- FastClick -->
                    <script src="{{asset("lb-faveo/plugins/fastclick/fastclick.min.js")}}"></script>
                    <!-- AdminLTE App -->
                    <script src="{{asset("lb-faveo/js/app.min.js")}}" type="text/javascript"></script>
                    <!-- AdminLTE for demo purposes -->
                    {{-- // <script src="{{asset("dist/js/demo.js")}}" type="text/javascript"></script> --}}
                    <!-- iCheck -->
                    <script src="{{asset("lb-faveo/plugins/iCheck/icheck.min.js")}}" type="text/javascript"></script>
                    {{-- maskinput --}}
                    {{-- // <script src="js/jquery.maskedinput.min.js" type="text/javascript"></script> --}}
                    {{-- jquery ui --}}
                    <script src="{{asset("lb-faveo/js/jquery.ui.js")}}" type="text/javascript"></script>
                    <script src="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
                    <script src="{{asset("lb-faveo/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
                    <!-- Page Script -->
                    <script src="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}" type="text/javascript"></script>
                    {{-- // <script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script> --}}
                    <script type="text/javascript" src="{{asset("lb-faveo/js/jquery.dataTables1.10.10.min.js")}}"></script>
                    
                    <script type="text/javascript" src="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")}}"></script>
                    <script src="{{asset("lb-faveo/js/jquery.rating.pack.js")}}" type="text/javascript"></script>

                     <script src="{{asset("lb-faveo/plugins/select2/select2.full.min.js")}}" ></script>
                      <script src="{{asset("lb-faveo/plugins/moment/moment.js")}}" ></script>




        <script>
                $(document).ready(function () {
                    
                    $('.noti_User').click(function () {
                        var id = this.id;
                    var dataString = 'id=' + id;
                        $.ajax
                                ({
                                    type: "POST",
                                    url: "{{url('mark-read')}}" + "/" + id,
                                    data: dataString,
                                    cache: false,
                                    success: function (html)
                                    {
//$(".city").html(html);
                                    }
                                });
                    });

                });
        </script>
<script>
$(function() {
    // Enable iCheck plugin for checkboxes
    // iCheck for checkbox and radio inputs
    // $('input[type="checkbox"]').iCheck({
        // checkboxClass: 'icheckbox_flat-blue',
        // radioClass: 'iradio_flat-blue'
    // });
    // Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function() {
        var clicks = $(this).data('clicks');
        if (clicks) {
            //Uncheck all checkboxes
            $("input[type='checkbox']", ".mailbox-messages").iCheck("uncheck");
        } else {
            //Check all checkboxes
            $("input[type='checkbox']", ".mailbox-messages").iCheck("check");
        }
        $(this).data("clicks", !clicks);
    });

    //Handle starring for glyphicon and font awesome
    $(".mailbox-star").click(function(e) {
        e.preventDefault();
        //detect type
        var $this = $(this).find("a > i");
        var glyph = $this.hasClass("glyphicon");
        var fa = $this.hasClass("fa");

        //Switch states
        if (glyph) {
            $this.toggleClass("glyphicon-star");
            $this.toggleClass("glyphicon-star-empty");
        }

        if (fa) {
            $this.toggleClass("fa-star");
            $this.toggleClass("fa-star-o");
        }
    });
});
</script>
//<script type="text/javascript">
//     $(document).ready(function() {
//         $("#content").Editor();
//     });
// </script>
<!-- // <script src="../plugins/jQuery/jQuery-2.1.3.min.js"></script> -->
<script src="{{asset("lb-faveo/js/tabby.js")}}"></script>

<script type="text/javascript">
$.ajaxSetup({
headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});
</script>
@yield('FooterInclude')
<!-- /#wrapper -->
<!-- Bootstrap Core JavaScript -->
<script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->

{{--<script type="text/javascript" src="{{ URL::asset('js/jquery.dataTables.min.js') }}"></script>--}}
{{--<script type="text/javascript" src="{{ URL::asset('js/jasny-bootstrap.min.js') }}"></script>--}}

@stack('scripts')
</body>
</html>