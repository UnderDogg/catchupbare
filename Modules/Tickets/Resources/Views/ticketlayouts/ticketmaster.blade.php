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
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link href="{{asset("lb-faveo/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css"/>

  <!-- iCheck -->
  <link href="{{asset("lb-faveo/plugins/iCheck/flat/blue.css")}}" rel="stylesheet" type="text/css"/>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <link href="{{asset("lb-faveo/css/tabby.css")}}" type="text/css" rel="stylesheet">
    <link href="{{asset('css/notification-style.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset("lb-faveo/css/jquerysctipttop.css")}}" rel="stylesheet" type="text/css">
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <link type="text/css" href="{{asset("lb-faveo/css/jquery.ui.css")}}" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="{{asset("lb-faveo/css/faveo-css.css")}}">


  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset("lb-faveo/plugins/select2/select2.min.css")}}">


  <link rel="stylesheet" type="text/css" href="{{asset("lb-faveo/css/notification-style.css")}}">

  <link href="{{ URL::asset('css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css">

  <link href='https://fonts.googleapis.com/css?family=Lato:400,700, 300' rel='stylesheet' type='text/css'>

  <script type="text/javascript" src="{{ URL::asset('js/jquery-2.2.3.min.js') }}"></script>


  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/semantic.css') }}">


  <script type="text/javascript" src="{{ URL::asset('js/bootstrap-paginator.js') }}"></script>

  <link href="{{ URL::asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">


  <link rel="stylesheet" href="{{ asset(elixir('css/app.css')) }}">

  @yield('HeadInclude')

</head>
<body class="skin-green sidebar-mini">


<header class="main-header">
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
        <li @yield('Dashboard')><a data-target="#tabA" href="#">dashboard</a></li>
        <li @yield('Templates')><a data-target="#tabB" href="#">templates</a></li>
        <li @yield('Mailboxes')><a data-target="#tabC" href="#">mailboxes</a></li>
        <li @yield('Cron Jobs')><a data-target="#tabD" href="#">cronjobs</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
          <li><a href="{{url('/kbpanel')}}">Kb Panel</a></li>
          <li><a href="{{url('/mailpanel')}}">Mail Panel</a></li>
          <li><a href="{{url('/staffpanel')}}">Staff Panel</a></li>
          <li><a href="{{url('/adminpanel')}}">Admin Panel</a></li>
      </ul>
    </div>
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

              <img src="#" class="img-circle" alt="User Image"/>

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
      <li class="header">{!! Lang::get('tickets::lang.tickets') !!}</li>
      <li @yield('inbox')>
        <a href="{/ticket/inbox" id="load-inbox">
          <i class="fa fa-envelope"></i> <span>{!! Lang::get('tickets::lang.inbox') !!}</span>
          <small class="label pull-right bg-green">count($tickets)</small>
        </a>
      </li>
      <li @yield('myticket')>
        <a href="/ticket/myticket" id="load-myticket">
          <i class="fa fa-user"></i> <span>{!! Lang::get('tickets::lang.my_tickets') !!} </span>
          <small class="label pull-right bg-green">count($myticket)</small>
        </a>
      </li>
      <li @yield('unassigned')>
        <a href="/unassigned/" id="load-unassigned">
          <i class="fa fa-th"></i> <span>{!! Lang::get('tickets::lang.unassigned') !!}</span>
          <small class="label pull-right bg-green">count($unassigned)</small>
        </a>
      </li>
      <li @yield('overdue')>
        <a href="/ticket/overdue/" id="load-unassigned">
          <i class="fa fa-calendar-times-o"></i> <span>{!! Lang::get('tickets::lang.overdue') !!}</span>
          <small class="label pull-right bg-green">$overdue_ticket</small>
        </a>
      </li>
      <li @yield('trash')>
        <a href="/ticket/trash/">
          <i class="fa fa-trash-o"></i> <span>{!! Lang::get('tickets::lang.trash') !!}</span>
          <small class="label pull-right bg-green">count($deleted)</small>
        </a>
      </li>
      <li class="header">{!! Lang::get('core::lang.departments') !!}</li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-folder-open"></i> <span>$dept->name</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><a href="{!! url::route('dept.open.ticket','Support') !!}"><i
                class="fa fa-circle-o"></i>{!! Lang::get('tickets::lang.open') !!}
              <small class="label pull-right bg-green">$open</small>
            </a></li>
          <li><a href="{!! url::route('dept.inprogress.ticket','Support') !!}"><i
                class="fa fa-circle-o"></i>{!! Lang::get('tickets::lang.inprogress') !!}
              <small class="label pull-right bg-green">$underprocess</small>
            </a></li>
          <li><a href="{!! url::route('dept.closed.ticket','Support') !!}"><i
                class="fa fa-circle-o"></i>{!! Lang::get('tickets::lang.closed') !!}
              <small class="label pull-right bg-green">$closed</small>
            </a></li>
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
        <div class="tabs-pane @yield('dashboard-bar')" id="tabA">
          <ul class="nav navbar-nav">
            <li id="bar" @yield('dashboard') ><a href="{{url('dashboard')}}">{!! Lang::get('core::lang.dashboard') !!}</a></li>
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

<script type="text/javascript" src="{{ URL::asset('js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/jasny-bootstrap.min.js') }}"></script>

@stack('scripts')
</body>
</html>