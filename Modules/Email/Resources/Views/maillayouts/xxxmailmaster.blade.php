<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8" ng-app="myApp">
    <title>Mail Master Layout</title>
    <!-- Tell the browser to be responsive to screen width -->
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta name="_token" content="{!! csrf_token() !!}"/>
        <!-- faveo favicon -->
        <link href="{{asset("lb-faveo/media/images/favicon.ico")}}" rel="shortcut icon">
        <!-- Bootstrap 3.3.2 -->
        <link href="{{asset("lb-faveo/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="{{asset("lb-faveo/css/font-awesome.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="{{asset("lb-faveo/css/ionicons.min.css")}}" rel="stylesheet"  type="text/css" />
        <!-- Theme style -->
        <link href="{{asset("lb-faveo/css/AdminLTE.css")}}" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link href="{{asset("lb-faveo/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="{{asset("lb-faveo/plugins/iCheck/flat/blue.css")}}" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <link href="{{asset("lb-faveo/css/tabby.css")}}" rel="stylesheet" type="text/css"/>
        
        <link href="{{asset("lb-faveo/css/jquerysctipttop.css")}}" rel="stylesheet" type="text/css"/>
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->


        <link href="{{asset("lb-faveo/css/jquery.ui.css")}}" rel="stylesheet" rel="stylesheet"/>
        
        <link href="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.css")}}" rel="stylesheet"  type="text/css"/>
        


        <link href="{{asset("lb-faveo/css/faveo-css.css")}}" rel="stylesheet" type="text/css" />
        
        <link href="{{asset("lb-faveo/css/notification-style.css")}}" rel="stylesheet" type="text/css" >
        

        <!-- Select2 -->
        <link href="{{asset("lb-faveo/plugins/select2/select2.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- autocomplete -->
        <link href="{{asset("lb-faveo/css/autocomplete.css")}}" rel="stylesheet" type="text/css" />
    <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
        <link href='https://fonts.googleapis.com/css?family=Lato:400,700, 300' rel='stylesheet' type='text/css'>
        <script src="{{asset("lb-faveo/js/jquery-2.1.4.js")}}" type="text/javascript"></script>
        
        <script src="{{asset("lb-faveo/js/jquery2.1.1.min.js")}}" type="text/javascript"></script>
        @yield('HeadInclude')
</head>
















    <body class="skin-green fixed">

<div class="wrapper">

    <header class="main-header">

        <!-- Logo -->
        <a href="http://www.faveohelpdesk.com" class="logo"><img src="{{ asset('lb-faveo/media/images/logo.png')}}" width="100px;"></a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="collapse navbar-collapse" id="navbar-collapse">

                <ul class="tabs tabs-horizontal nav navbar-nav navbar-left">
                    <li @yield('Dashboard')><a data-target="#tabA" href="#">{!! Lang::get('core::lang.dashboard') !!}</a></li>
                    <li @yield('Users')><a data-target="#tabB" href="#">{!! Lang::get('core::lang.users') !!}</a></li>
                    <li @yield('Tickets')><a data-target="#tabC" href="#">{!! Lang::get('core::lang.tickets') !!}</a></li>
                    <li @yield('Tools')><a data-target="#tabD" href="#">{!! Lang::get('core::lang.tools') !!}</a></li>

                </ul>


                <ul class="nav navbar-nav navbar-right">
                    @if(Auth::guard('staff')->user()->role == 'admin')
                    <li><a href="{{url('admin')}}">{!! Lang::get('core::lang.admin_panel') !!}</a></li>
                    @include('themes.default1.update.notification')
                    @endif
                    <!-- User Account: style can be found in dropdown.less -->


                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                @if(Auth::guard('staff')->user())
                                <img src="{{Auth::guard('staff')->user()->profile_pic}}"class="user-image" alt="User Image"/>
                                <span class="hidden-xs">{{Auth::guard('staff')->user()->first_name." ".Auth::guard('staff')->user()->last_name}}</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header" style="background-color:#343F44;">
                                    <img src="{{Auth::guard('staff')->user()->profile_pic}}" class="img-circle" alt="User Image" />
                                    <p>
                                        {{Auth::guard('staff')->user()->first_name." ".Auth::guard('staff')->user()->last_name}} - {{Auth::guard('staff')->user()->role}}
                                        <small></small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer" style="background-color:#1a2226;">
                                    <div class="pull-left">
                                        <a href="{{URL::route('staff.profile')}}" class="btn btn-info btn-sm"><b>{!! Lang::get('core::lang.staffprofile') !!}</b></a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{url('staff/logout')}}" class="btn btn-danger btn-sm"><b>{!! Lang::get('core::lang.sign_out') !!}</b></a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                </ul>
            </div>
        </nav>
    </header><!-- <header class="main-header"> -->
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar" style="height: auto;">

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
                        <li @yield('mailtemplate')><a href="{{ url('/mailpanel/mailtemplates') }}"><i
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
                        <li @yield('mailparser')><a href="{{ url('/mailpanel/mailparser') }}"><i
                                        class="fa fa-envelope"></i>{!! Lang::get('email::lang.mailparser') !!}</a></li>
                        <li @yield('mailboxes')><a href="{{ url('/mailpanel/mailboxes') }}"><i
                                        class="fa fa-mail-forward"></i>{!! Lang::get('email::lang.mailboxes') !!}</a></li>
                        <li @yield('mailrules')><a href="{{ url('/mailpanel/mailrules') }}"><i
                                        class="fa fa-ban"></i>{!! Lang::get('email::lang.mailrules') !!}</a></li>
                        <li @yield('mailbans')><a href="{{ url('/mailpanel/mailbanlist') }}"><i
                                        class="fa fa-ban"></i>{!! Lang::get('email::lang.mailbans') !!}</a></li>
                        <li @yield('mailcatch-all')><a href="{{ url('/mailpanel/mailcatch-all') }}"><i
                                        class="fa fa-mail-forward"></i>{!! Lang::get('email::lang.mailcatch-all') !!}</a>
                        </li>
                        <li @yield('maildiagnostics')><a href="{{ url('/mailpanel/getmaildiagno') }}"><i
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
                        <li @yield('mailtemplategroups')><a href="{{ url('/mailpanel/mailtemplategroups') }}"><i
                                        class="fa fa-envelope"></i>{!! Lang::get('email::lang.mailtemplategroups') !!}</a>
                        </li>
                        <li @yield('mailtemplates')><a href="{{ url('/mailpanel/mailtemplates') }}"><i
                                        class="fa fa-mail-forward"></i>{!! Lang::get('email::lang.mailtemplates') !!}</a>
                        </li>
                        <li @yield('maillogos')><a href="{{ url('/mailpanel/maillogos') }}"><i
                                        class="fa fa-ban"></i>{!! Lang::get('email::lang.maillogos') !!}</a></li>
                        <li @yield('templateimport')><a href="{{ url('/mailpanel/templateimport') }}"><i
                                        class="fa fa-mail-forward"></i>{!! Lang::get('email::lang.templateimport') !!}</a>
                        </li>
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

        </section><!-- /.sidebar -->

    </aside>

    <!-- Right side column. Contains the navbar and content of the page -->
    <div class="content-wrapper" style="min-height: 916px;">
        <!-- Content Header (Page header) -->
        <div class="tab-content" style="background-color: white;padding: 0 20px 0 20px">
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <div class="tabs-content">
                    <div class="tabs-pane @yield('dashboard-bar')" id="tabA">
                        <ul class="nav navbar-nav">
                            <li id="bar" @yield('dashboard') ><a
                                        href="{{url('/adminpanel/')}}">{!! Lang::get('core::lang.dashboard') !!}</a></li>
                            <li id="bar" @yield('profile') ><a
                                        href="{{url('/staff/profile')}}">{!! Lang::get('employees::lang.profile') !!}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tabs-pane @yield('mailpanel-bar')" id="tabA">
                        <ul class="nav navbar-nav">
                            <li id="bar" @yield('dashboard') ><a
                                        href="{{url('/mailpanel/')}}">{!! Lang::get('email::lang.mailpanel') !!}</a></li>
                            <li id="bar" @yield('allmailboxes') ><a
                                        href="{{url('/mailpanel/mailboxes/manage')}}">{!! Lang::get('email::lang.mailboxes') !!}</a>
                            </li>
                            <li id="bar" @yield('mailrules') ><a
                                        href="{{url('/mailpanel/mailrules')}}">{!! Lang::get('email::lang.mailrules') !!}</a>
                            </li>
                        </ul>
                    </div>


                    <div class="tabs-pane @yield('user-bar')" id="tabB">
                        <ul class="nav navbar-nav">
                            <li id="bar" @yield('user')><a
                                        href="{{ url('/adminpanel/users/manage') }}">{!! Lang::get('core::lang.user_directory') !!}</a>
                            </li>
                            </a></li>
                            <li id="bar" @yield('relations')><a href="{{ url('/relationspanel/') }}">{!! Lang::get('relations::lang.relations')
              !!}</a></li>
                            </a></li>
                        </ul>
                    </div>
                    <div class="tabs-pane @yield('mailboxes-bar')" id="tabC">
                        <ul class="nav navbar-nav">
                            <li id="bar" @yield('templates')><a href="{{ url('/mailpanel/mailtemplates') }}"
                                                                id="load-open">{!! Lang::get('email::lang.mailtemplates') !!}</a>
                            </li>
                            <li id="bar" @yield('newtemplate')><a
                                        href="{{ url('/tickets/newticket') }}">{!! Lang::get('tickets::lang.create_ticket') !!}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tabs-pane @yield('templates-bar')" id="tabD">
                        <ul class="nav navbar-nav">
                            <li id="bar" @yield('mailtemplate')><a href="{{ url('/mailpanel/mailtemplates') }}"
                                                                   id="load-open">{!! Lang::get('email::lang.mailtemplates') !!}</a>
                            </li>
                            <li id="bar" @yield('newtemplate')><a
                                        href="{{ url('/tickets/newticket') }}">{!! Lang::get('tickets::lang.create_ticket') !!}</a>
                            </li>
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
        </section>
        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> {!! Config::get('core::app.version') !!}
        </div>
        <strong>{!! Lang::get('core::lang.copyright') !!} &copy; {!! date('Y') !!}  <a href="#" target="_blank">CompanyName</a>.</strong> {!! Lang::get('core::lang.all_rights_reserved') !!}. {!! Lang::get('core::lang.powered_by') !!} <a href="http://www.faveohelpdesk.com/" target="_blank">Faveo</a>
    </footer>


</div><!-- ./wrapper -->

    <script src="{{asset("lb-faveo/js/ajax-jquery.min.js")}}" type="text/javascript"></script>


<!-- Bootstrap 3.3.2 JS -->
<script src="{{asset("lb-faveo/js/bootstrap.min.js")}}" type="text/javascript"></script>
<!-- Slimscroll -->
<script src="{{asset("lb-faveo/plugins/slimScroll/jquery.slimscroll.min.js")}}" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="{{asset("lb-faveo/js/app.min.js")}}" type="text/javascript"></script>


        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
<!-- jquery ui -->
<script src="{{asset("lb-faveo/js/jquery.ui.js")}}" type="text/javascript"></script>

<script src="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>

<script src="{{asset("lb-faveo/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
<!-- Page Script -->
<script src="{{asset("lb-faveo/js/jquery.dataTables1.10.10.min.js")}}" type="text/javascript" ></script>

<script type="text/javascript" src="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")}}"  type="text/javascript"></script>
        <script src="{{ asset('js/handlebars.js') }}"></script>

<script src="{{asset("lb-faveo/plugins/select2/select2.full.min.js")}}" type="text/javascript"></script>


        @stack('scripts')

<!-- AdminLTE App -->
<script src="/lb-faveo/js/app.min.js"></script>

<script src="/lb-faveo/js/tabby.js"></script>
    <script src="{{asset("lb-faveo/plugins/select2/select2.full.min.js")}}" type="text/javascript"></script>

    <script src="{{asset("lb-faveo/plugins/moment/moment.js")}}" type="text/javascript"></script>


    <script>
                $(function() {
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

<script src="{{asset("lb-faveo/js/tabby.js")}}" type="text/javascript"></script>

<script src="{{asset("lb-faveo/plugins/filebrowser/plugin.js")}}" type="text/javascript"></script>

<script src="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}" type="text/javascript"></script>

<script type="text/javascript">
            $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
            });
</script>
<script type="text/javascript">
    function clickDashboard() {
        window.location = "{{URL::route('dashboard')}}";
    }
</script>
@yield('FooterInclude')
</body>
</html>