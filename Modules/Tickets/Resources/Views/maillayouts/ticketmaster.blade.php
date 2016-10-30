<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket Master Layout</title>


    <meta name="_token" content="{!! csrf_token() !!}"/>
    <!-- faveo favicon -->
    <link rel="shortcut icon" href="{{asset("lb-faveo/media/images/favicon.ico")}}">
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">


    <!-- Font Awesome Icons -->
    <link href="{{asset("lb-faveo/css/font-awesome.min.css")}}" rel="stylesheet" type="text/css"/>

    <!-- <link href="{{ URL::asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"> -->
    <!---    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"> -->

    <!-- Ionicons -->
    {{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
    <link href="{{asset("lb-faveo/css/ionicons.min.css")}}" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"> -->


    <!-- Theme style -->
    <link href="{{asset("lb-faveo/css/AdminLTE.css")}}" rel="stylesheet" type="text/css"/>
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
    <link href="{{asset("lb-faveo/css/editor.css")}}" type="text/css" rel="stylesheet">
    <link href="{{asset("lb-faveo/plugins/filebrowser/plugin.js")}}" rel="stylesheet" type="text/css"/>
    <link type="text/css" href="{{asset("lb-faveo/css/jquery.ui.css")}}" rel="stylesheet">

    <link href="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")}}" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{asset("lb-faveo/css/faveo-css.css")}}">


    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset("lb-faveo/plugins/select2/select2.min.css")}}">


    <link rel="stylesheet" type="text/css" href="{{asset("lb-faveo/css/notification-style.css")}}">

    <link href="{{ URL::asset('css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css">

    <link href='https://fonts.googleapis.com/css?family=Lato:400,700, 300' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="{{ URL::asset('js/vue.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jquery-2.2.3.min.js') }}"></script>


    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/semantic.css') }}">


    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-paginator.js') }}"></script>

    <link href="{{ URL::asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">
    <!---   <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css"> -->
    <link href="{{ URL::asset('css/dropzone.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ asset(elixir('css/app.css')) }}">
    <!-- <script type="text/javascript" src="https://js.stripe.com/v2/"></script>-->
    <!---  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.min.js"> -->


    <script src="//js.pusher.com/3.0/pusher.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/Chart.min.js') }}"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.1.1/Chart.min.js"></script>-->
    <script type="text/javascript" src="{{ URL::asset('js/jquery-2.2.3.min.js') }}"></script>
    @yield('HeadInclude')

</head>
<body class="skin-green fixed">


<header class="main-header">
    <a href="http://www.faveohelpdesk.com" class="logo"><img src="{{ asset('lb-faveo/media/images/logo.png') }}"
                                                             width="100px;"></a>
    <?php
    /*  $company = Modules\Core\Models\Company::where('id', '=', '1')->first();
      if ($company != null) {
      }*/
    ?>
            <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <?php //$notifications = App\Http\Controllers\Common\NotificationController::getNotifications();
        ?>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="tabs tabs-horizontal nav navbar-nav navbar-left">
                <li @yield('Dashboard')><a data-target="#tabA" href="#">dashboard</a></li>
                <li @yield('Templates')><a data-target="#tabB" href="#">templates</a></li>
                <li @yield('Mailboxes')><a data-target="#tabC" href="#">mailboxes</a></li>
                <li @yield('Cron Jobs')><a data-target="#tabD" href="#">cronjobs</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">

                <li><a href="{{url('/kbpanel')}}">Kb Panel</a></li>
                <li><a href="{{url('/ticketspanel')}}">Tickets Panel</a></li>
                <li><a href="{{url('/staffpanel')}}">Staff Panel</a></li>
                <li><a href="{{url('/adminpanel')}}">Admin Panel</a></li>

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">


                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="myFunction()">
                      <i class="fa fa-bell-o"></i>
                      <span class="label label-warning" id="count">count $notifications</span>
                    </a>--}}


                    <ul class="dropdown-menu">
                        <li class="header">You have count($notifications) notifications</li>
                        <li>

                            <ul class="menu">
                                {{--@foreach($notifications as $notification)
                                  @if($notification->type == 'registration')
                                    <li>
                                      <a href="{!! route('user.show', $notification->model_id) !!}"
                                         id="{{$notification->notification_id}}" class='noti_User'>
                                        <i class="{!! $notification->icon_class !!}"></i> {!! $notification->message !!}
                                      </a>
                                    </li>
                                  @else
                                    <li>
                                      <a href="{!! route('ticket.thread', $notification->model_id) !!}"
                                         id='{{ $notification->notification_id}}' class='noti_User'>
                                        <i class="{!! $notification->icon_class !!}"></i> {!! $notification->message !!}
                                      </a>
                                    </li>
                                  @endif
                                @endforeach--}}

                            </ul>
                        </li>
                        <li class="footer"><a href="/notifications-list">View all</a>
                        </li>

                    </ul>
                </li>


                <li class="dropdown user user-menu">
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <p>
                                first_name last_name - role
                                <small></small>
                            </p>
                        </li>
                    </ul>
                </li>


                <!-- User Account: style can be found in dropdown.less -->
                {{-- <li class="dropdown user user-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <span class="hidden-xs">first_name last_name</span>
                  </a>
                  <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header" style="background-color:#343F44;">
                      <p>
                        first_name last_name - role
                        <small></small>
                      </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer" style="background-color:#1a2226;">
                      <div class="pull-left">
                        <a href="/staff-profile" class="btn btn-info btn-sm"><b>{!! Lang::get('core::lang.profile') !!}</b></a>
                      </div>
                      <div class="pull-right">
                        <a href="/auth/logout/" class="btn btn-danger btn-sm"><b>{!! Lang::get('core::lang.sign_out') !!}</b></a>
                      </div>
                    </li>
                  </ul>
                </li> --}}
            </ul>
        </div>

    </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <div class="user-panel">
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
        <!-- search form -->
        {{-- <form action="#" method="get" class="sidebar-form"> --}}
        {{-- <div class="input-group"> --}}
        {{-- <input type="text" name="q" class="form-control" placeholder="Search..."/> --}}
        {{-- <span class="input-group-btn"> --}}
        {{-- <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button> --}}
        {{-- </span> --}}
        {{-- </div> --}}
        {{-- </form> --}}
                <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul id="side-bar" class="sidebar-menu">
            @yield('sidebar')
            <li class="header">{!! Lang::get('email::lang.email') !!}</li>
            <li class="treeview @yield('Mailboxes')">
                <a href="#">
                    <i class="fa fa-envelope-o"></i>
                    <span>{!! Lang::get('email::lang.mailboxes') !!}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('mailboxes')><a href="{{ url('/mailpanel/mailboxes/manage') }}"><i
                                    class="fa fa-envelope"></i>{!! Lang::get('email::lang.mailboxes') !!}</a></li>
                    <li @yield('ban')><a href="{{ url('/mailpanel/mailbanlist') }}"><i
                                    class="fa fa-ban"></i>{!! Lang::get('email::lang.ban_lists') !!}</a></li>
                    <li @yield('getmail')><a href="{{url('/mailpanel/getmail')}}"><i
                                    class="fa fa-at"></i>{!! Lang::get('email::lang.getmail') !!}</a></li>
                    <li @yield('template')><a href="{{ url('/mailpanel/mailtemplates') }}"><i
                                    class="fa fa-mail-forward"></i>{!! Lang::get('email::lang.mailtemplates') !!}</a>
                    </li>
                    <li @yield('maildiagnostics')><a href="{{ url('/mailpanel/maildiagno/getmaildiagno') }}"><i
                                    class="fa fa-plus"></i>{!! Lang::get('email::lang.maildiagnostics') !!}</a></li>
                    <li @yield('autoresponses')><a href="{{ url('/mailpanel/autoresponses') }}"><i
                                    class="fa fa-plus"></i>{!! Lang::get('email::lang.autoresponses') !!}</a></li>
                    <li @yield('breaklines')><a href="{{ url('/mailpanel/breaklines') }}"><i
                                    class="fa fa-plus"></i>{!! Lang::get('email::lang.breaklines') !!}</a></li>
                    <li @yield('mailrules')><a href="{{ url('/mailpanel/mailrules') }}"><i
                                    class="fa fa-plus"></i>{!! Lang::get('email::lang.mailrules') !!}</a></li>
                </ul>
            </li>

            <li class="treeview @yield('MailParser')">
                <a href="#">
                    <i class="fa fa-envelope-o"></i>
                    <span>{!! Lang::get('email::lang.mailparser') !!}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('mailparser')><a href="{{ url('/adminpanel/mailparser') }}"><i
                                    class="fa fa-envelope"></i>{!! Lang::get('email::lang.mailparser') !!}</a></li>
                    <li @yield('mailboxes')><a href="{{ url('/mailpanel/mailboxes') }}"><i
                                    class="fa fa-mail-forward"></i>{!! Lang::get('email::lang.mailboxes') !!}</a></li>
                    <li @yield('mailrules')><a href="{{ url('/adminpanel/mailrules') }}"><i
                                    class="fa fa-ban"></i>{!! Lang::get('email::lang.mailrules') !!}</a></li>
                    <li @yield('mailbans')><a href="{{ url('/adminpanel/mailbanlist') }}"><i
                                    class="fa fa-ban"></i>{!! Lang::get('email::lang.mailbans') !!}</a></li>
                    <li @yield('mailcatch-all')><a href="{{ url('/adminpanel/mailcatch-all') }}"><i
                                    class="fa fa-mail-forward"></i>{!! Lang::get('email::lang.mailcatch-all') !!}</a>
                    </li>
                    <li @yield('maildiagnostics')><a href="{{ url('/adminpanel/getmaildiagno') }}"><i
                                    class="fa fa-plus"></i>{!! Lang::get('email::lang.diagnostics') !!}</a></li>
                </ul>
            </li>


            <li class="treeview @yield('MailTemplates')">
                <a href="#">
                    <i class="fa fa-envelope-o"></i>
                    <span>{!! Lang::get('email::lang.mailtemplates') !!}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('mailtemplategroups')><a href="{{ url('/adminpanel/mailtemplategroups') }}"><i
                                    class="fa fa-envelope"></i>{!! Lang::get('email::lang.mailtemplategroups') !!}</a>
                    </li>
                    <li @yield('mailtemplates')><a href="{{ url('/adminpanel/mailtemplates') }}"><i
                                    class="fa fa-mail-forward"></i>{!! Lang::get('email::lang.mailtemplates') !!}</a>
                    </li>
                    <li @yield('maillogos')><a href="{{ url('/adminpanel/maillogos') }}"><i
                                    class="fa fa-ban"></i>{!! Lang::get('email::lang.maillogos') !!}</a></li>
                    <li @yield('templateimport')><a href="{{ url('/adminpanel/templateimport') }}"><i
                                    class="fa fa-mail-forward"></i>{!! Lang::get('email::lang.templateimport') !!}</a>
                    </li>
                </ul>
            </li>

            <li class="treeview @yield('Logs')">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>{!! Lang::get('core::lang.logs') !!}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('errorlogs')><a href="{{ url('/adminpanel/errorlogs') }}"><i
                                    class="fa fa-list-alt"></i> {!! Lang::get('core::lang.errorlogs') !!}</a></li>
                    <li @yield('joblogs')><a href="{{ url('/adminpanel/joblogs') }}"><i
                                    class="fa fa-list-alt"></i> {!! Lang::get('core::lang.joblogs') !!}</a></li>
                    <li @yield('activitylogs')><a href="{{ url('/adminpanel/activitylogs') }}"><i
                                    class="fa fa-list-alt"></i> {!! Lang::get('core::lang.activitylogs') !!}</a></li>
                    <li @yield('loginlogs')><a href="{{ url('/adminpanel/loginlogs') }}"><i
                                    class="fa fa-list-alt"></i> {!! Lang::get('core::lang.loginlogs') !!}</a></li>
                </ul>
            </li>

            <li class="treeview @yield('Cron')">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>{!! Lang::get('core::lang.cron') !!}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li @yield('cron')><a href="{{ url('/adminpanel/cronjobs') }}"><i
                                    class="fa fa-list-alt"></i> {!! Lang::get('core::lang.cronjobs') !!}</a></li>
                    <li @yield('cron')><a href="{{url('/adminpanel/job-scheduler')}}"><i
                                    class="fa fa-hourglass"></i>{!! Lang::get('core::lang.cron') !!}</a></li>
                    <li @yield('joblogs')><a href="{{ url('/adminpanel/joblogs') }}"><i
                                    class="fa fa-list-alt"></i> {!! Lang::get('core::lang.joblogs') !!}</a></li>
                </ul>
            </li>

        </ul>
        </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="tab-content" style="background-color: white;padding: 0 20px 0 20px">
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <div class="tabs-content">
                <div class="tabs-pane @yield('dashboard-bar')" id="tabA">
                    <ul class="nav navbar-nav">
                        <li id="bar" @yield('dashboard') ><a href="{{url('/adminpanel/')}}">{!! Lang::get('core::lang.dashboard') !!}</a></li>
                        <li id="bar" @yield('profile') ><a href="{{url('/staff/profile')}}">{!! Lang::get('employees::lang.profile') !!}</a></li>
                    </ul>
                </div>
                <div class="tabs-pane @yield('user-bar')" id="tabB">
                    <ul class="nav navbar-nav">
                        <li id="bar" @yield('user')><a href="{{ url('/adminpanel/users/manage') }}">{!! Lang::get('core::lang.user_directory') !!}</a>
                        </li>
                        </a></li>
                        <li id="bar" @yield('relations')><a href="{{ url('/relationspanel/') }}">{!! Lang::get('relations::lang.relations')!!}</a></li>
                        </a></li>
                    </ul>
                </div>
                <div class="tabs-pane @yield('ticket-bar')" id="tabC">
                    <ul class="nav navbar-nav">
                        <li id="bar" @yield('open')><a href="{{ url('/tickets/open') }}" id="load-open">{!! Lang::get('tickets::lang.open') !!}</a></li>
                        <li id="bar" @yield('answered')><a href="{{ url('/tickets/answered') }}" id="load-answered">{!! Lang::get('tickets::lang.answered')!!}</a></li>
                        <li id="bar" @yield('myticket')><a href="{{ url('/tickets/mytickets') }}">{!! Lang::get('tickets::lang.my_tickets') !!}</a></li>

                        <li id="bar" @yield('ticket')><a href="{{ url('/tickets/') }}">Ticket</a></li>
                        <li id="bar" @yield('overdue')><a href="{{ url('/tickets/overdue') }}">Overdue</a></li>
                        <li id="bar" @yield('assigned')><a href="{{ url('/tickets/assigned') }}" id="load-assigned">{!! Lang::get('tickets::lang.assigned')!!}</a></li>
                        <li id="bar" @yield('closed')><a
                                    href="{{ url('/tickets/closed') }}">{!! Lang::get('tickets::lang.closed') !!}</a>
                        </li>
                        <li id="bar" @yield('newticket')><a
                                    href="{{ url('/tickets/newticket') }}">{!! Lang::get('tickets::lang.create_ticket') !!}</a>
                        </li>
                    </ul>
                </div>
                <div class="tabs-pane @yield('tools-bar')" id="tabD">
                    <ul class="nav navbar-nav">
                        <li id="bar" @yield('tools')><a
                                    href="{{ url('/tickets/canned/list') }}">{!! Lang::get('tickets::lang.canned_response') !!}</a>
                        </li>
                        <li id="bar" @yield('kb')><a
                                    href="{{ url('/kbpanel/comments') }}">{!! Lang::get('knowledgebase::lang.knowledge_base') !!}</a>
                        </li>
                    </ul>
                </div>
                <div class="tabs-pane @yield('tools-bar')" id="tabE">
                    <ul class="nav navbar-nav">
                        <li id="bar" @yield('Settings')><a
                                    href="{{ url('/adminpanel/settings') }}">{!! Lang::get('core::lang.settings') !!}</a>
                        </li>
                        <li id="bar" @yield('kb')><a
                                    href="{{ url('/kbpanel') }}">{!! Lang::get('knowledgebase::lang.knowledge_base') !!}</a>
                        </li>
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
    <strong>{!! Lang::get('core::lang.copyright') !!} &copy; {!! date('Y') !!} <a href="#"
                                                                                  target="_blank">company_name</a>.</strong> {!! Lang::get('core::lang.all_rights_reserved') !!}
    . {!! Lang::get('core::lang.powered_by') !!} <a href="http://www.faveohelpdesk.com/" target="_blank">Faveo</a>
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
<script src="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}"
        type="text/javascript"></script>
{{-- // <script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script> --}}
<script type="text/javascript" src="{{asset("lb-faveo/js/jquery.dataTables1.10.10.min.js")}}"></script>

<script type="text/javascript" src="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")}}"></script>
<script src="{{asset("lb-faveo/js/jquery.rating.pack.js")}}" type="text/javascript"></script>

<script src="{{asset("lb-faveo/plugins/select2/select2.full.min.js")}}"></script>
<script src="{{asset("lb-faveo/plugins/moment/moment.js")}}"></script>

<script>
    $(function () {
        //Add text editor
        $("textarea").wysihtml5();
    });

</script>

<script>
    function myFunction() {

        document.getElementById("count").innerHTML = "0";

    }
</script>
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
                success: function (html) {
//$(".city").html(html);
                }
            });
        });

    });
</script>
<script>
    $(function () {
        // Enable iCheck plugin for checkboxes
        // iCheck for checkbox and radio inputs
        // $('input[type="checkbox"]').iCheck({
        // checkboxClass: 'icheckbox_flat-blue',
        // radioClass: 'iradio_flat-blue'
        // });
        // Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function () {
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
        $(".mailbox-star").click(function (e) {
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

<!-- // <script src="../plugins/jQuery/jQuery-2.1.3.min.js"></script> -->
<script src="{{asset("lb-faveo/js/tabby.js")}}"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
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