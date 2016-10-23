@extends('core::guestlayouts.guest')

@section('home')
    class = "active"
@stop

@section('HeadInclude')
    <link href="./desk/css/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css">
    <link href="./desk/css/widgetbox.css" rel="stylesheet" type="text/css">
    <link href="./desk/css/blue.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <link href="./desk/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
@stop

@section('breadcrumb')
    <div class="site-hero clearfix">
        <ol class="breadcrumb breadcrumb-custom">
            <li class="text"> You are here :</li>
            <li class="text">Home</li>
        </ol>

    </div>

    @stop

    @section('content')
            <!-- Main content -->
    <div id="main" class="site-main clearfix">
        <div class="container">
            <div class="content-area">
                <div class="row">
                    <!-- failure message -->
                    <div id="content" class="site-content col-md-12">
                        <div id="corewidgetbox">
                            <div class="widgetrow text-center">
                                @if(Auth::guard('staff')->user())
                                @else
                                    <span onclick="javascript: window.location.href='{{url('/register')}}';">
                  <a href="{{url('/register')}}" class="widgetrowitem defaultwidget"
                     style="background-image: URL('/desk/media/images/register.png');">
                      <span class="widgetitemtitle">Register</span>
                  </a>
                  </span>
                                @endif
                                <span>
                    <a href="#"
                       class="widgetrowitem defaultwidget"
                       style="background-image: URL('/desk/media/images/submitticket.png');">
                        <span class="widgetitemtitle">Submit A Ticket</span>
                    </a>
                </span>
                <span>
                <a href="#" class="widgetrowitem defaultwidget"
                   style="background-image: URL('/desk/media/images/news.png');">
                    <span class="widgetitemtitle">My Tickets</span>
                </a>
                </span>
                <span>
                    <a href="#" class="widgetrowitem defaultwidget"
                       style="background-image: URL('/desk/media/images/knowledgebase.png');">
                        <span class="widgetitemtitle">Knowledge Base</span>
                    </a>
                </span>
                            </div>
                        </div>
                        <script type="text/javascript"> $(function () {
                                $('.dialogerror, .dialoginfo, .dialogalert').fadeIn('slow');
                                $("form").bind("submit", function (e) {
                                    $(this).find("input:submit").attr("disabled", "disabled");
                                });
                            });</script>
                    </div><!-- /site-content col-md-12 -->
                    <div id="sidebar" class="site-sidebar col-md-3">
                        <div class="widget-area">
                            <section id="section-banner" class="section">
                            </section><!-- #section-banner -->
                            <section id="section-categories" class="section">
                            </section><!-- #section-categories -->
                        </div>
                    </div><!-- #sidebar -->
                </div><!-- /row -->
            </div><!-- /content-area -->
        </div><!-- /container -->
    </div><!-- /.content-wrapper -->
@stop
