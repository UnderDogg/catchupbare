<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <title> ABC SUPPORT CENTER </title>
  <!-- faveo favicon -->

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.2 -->
  <link href="./desk/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <!-- Admin LTE CSS -->
  <link href="./desk/css/AdminLTEsemi.css" rel="stylesheet" type="text/css">
  <!-- Font Awesome Icons -->
  <link href="./desk/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Ionicons -->
  <link href="./desk/css/ionicons.min.css" rel="stylesheet" type="text/css">
  <!-- fullCalendar 2.2.5-->


  <!-- Theme style -->
  <link href="./desk/css/jquery.rating.css" rel="stylesheet" type="text/css">

  <link href="./desk/css/faveo.css" rel="stylesheet" type="text/css">

  <link href="./desk/css/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css">

  <script src="./desk/js/jquery2.1.1.min.js" type="text/javascript"></script>
  <link href="./desk/css/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css">

  @yield('HeadInclude')

</head>
<body>
<div id="page" class="hfeed site">
  <header id="masthead" class="site-header" role="banner">
    <div class="container" style="">
      <div id="logo" class="site-logo text-center" style="font-size: 30px;">
        <a href="" rel="home">
          <div style="color:#7B7B7B"><b>ABC</b> SUPPORT CENTER</div>
        </a>
      </div><!-- #logo -->
      <div id="navbar" class="navbar-wrapper text-center">
        <nav class="navbar navbar-default site-navigation" role="navigation">
          <ul class="nav navbar-nav navbar-menu sf-js-enabled sf-arrows">
            <li class="active"><a href="/">Home</a></li>
            <li><a href="/create-ticket">Submit A
                Ticket</a></li>
            <li><a href="/knowledgebase"
                   class="sf-with-ul">Knowledge Base <i
                  class="sub-indicator fa fa-angle-down fa-fw text-muted"></i></a>
              <ul class="dropdown-menu sub-menu" style="display: none;">
                <li>
                  <a href="/category-list">Categories</a>
                </li>
                <li>
                  <a href="/article-list">Articles</a>
                </li>
              </ul>
            </li>
            <li><a href="/about-us">About Us (Client Logged In)</a></li>
          </ul>

          <ul class="nav navbar-nav navbar-login">

            @if(Auth::guard('staff')->user())
              <li><a href="#" class="collapsed" data-toggle="collapse" data-target="#profile-menu">
                  <i class="sub-indicator fa fa-chevron-circle-down fa-fw"></i>My Profile</a>
                <div id="profile-menu" class="login-form collapse fade clearfix">


                    <div class="banner-wrapper user-menu text-center clearfix">
                      @if(Auth::guard('staff')->user())
                      <span class="">{!! Auth::guard('staff')->user()->firstname." ".Auth::guard('staff')->user()->lastname !!}</span>
                      <div class="banner-content">
                        <a href="{{url('client/profile')}}" class="btn btn-custom btn-xs">Edit Profile</a> <a
                          href="{{url('auth/logout')}}" class="btn btn-custom btn-xs">Log out</a>
                      </div>
                      @endif
                    </div>
                </div>
              </li>
            @else


              <li><a href="#" class="collapsed" data-toggle="collapse" data-target="#login-form">Login <i
                    class="sub-indicator fa fa-chevron-circle-down fa-fw text-muted"></i></a>

                <div id="login-form" class="login-form collapse fade clearfix">
                  <form role="form" method="POST" action="{{ url('/login') }}">
                    {!! csrf_field() !!}
                    <div class="form-group has-feedback">
                      <input placeholder="E-mail" class="form-control" name="email" type="text">
                      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback   ">
                      <input placeholder="Password" class="form-control" name="password" type="password"
                             value="">
                      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <ul class="list-unstyled pull-left">
                      <li><a href="/auth/password/email">Forgot
                          Password</a><br></li>
                      <li><a href="/auth/register">Create
                          Account</a></li>
                    </ul>
                    <button type="submit" class="btn btn-custom pull-right">Login</button>
                  </form>
                </div><!-- #login-form -->
              </li>
            @endif
          </ul><!-- .navbar-login -->
      </div><!-- #navbar navbar-wrapper text-center -->
      <div id="header-search" class="site-search clearfix" style="padding-bottom:5px"><!-- #header-search -->
        <form method="GET" action="/search"
              accept-charset="UTF-8" class="search-form clearfix">
          <div class="form-border">
            <div class="form-inline ">
              <div class="form-group">
                <input type="text" name="s" id="s" class="search-field form-control input-lg"
                       title="Enter search term"
                       placeholder="Have a question? Type your search term here..." required="">
              </div>
              <button type="submit" class="search-submit btn btn-custom btn-lg pull-right check-s">
                Search
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <!-- Right side column. Contains the navbar and content of the page -->
  <div class="site-hero clearfix">
    <ol class="breadcrumb breadcrumb-custom">
      <li class="text"> You are here :</li>
      <li class="text">Home</li>
    </ol>
  </div>


  <!-- Main content -->
  <div id="main" class="site-main clearfix">
    <div class="container">
      <div class="content-area">
        <div class="row">
          @yield('content')
          <div id="sidebar" class="site-sidebar col-md-3">
            <div class="widget-area">
              <div id="sidebar" class="site-sidebar col-md-3">
                <div class="widget-area">
                  <section id="section-banner" class="section">
                    @yield('check')
                  </section><!-- #section-banner -->
                  <section id="section-categories" class="section">
                    @yield('category')
                  </section><!-- #section-categories -->
                </div>
              </div><!-- #sidebar -->
            </div><!-- /content-area -->
          </div><!-- /content-area -->
        </div><!-- /container -->
      </div><!--  id="main" class="site-main clearfix" -->
    </div>


    <footer id="colophon" class="site-footer" role="contentinfo">
      <div class="container">
        <div class="row col-md-12">
          <div class="col-md-3">
            <div class="widget-area">
              <section id="section-about" class="section">
                <h2 class="section-title h4 clearfix"><i class="line"></i>Products</h2>
                <div class="textwidget">
                  <p></p>
                  <ul>
                    <li>Men</li>
                    <li>Women</li>
                    <li>Kids</li>
                    <li>Decor</li>
                    <li>Wedding Cloth<b><br></b></li>
                  </ul>
                  <p></p>
                </div>
              </section><!-- #section-about -->
            </div>
          </div>
          <div class="col-md-3">
            <div class="widget-area">
              <section id="section-latest-news" class="section">
                <h2 class="section-title h4 clearfix"><i class="line"></i>Company</h2>
                <div class="textwidget">
                  <p></p>
                  <ul>
                    <li>About Us</li>
                    <li>Road Map</li>
                    <li>Privacy Policy</li>
                    <li>Cancellation &amp; Refund Policy<br></li>
                    <li>Term &amp; Condition</li>
                  </ul>
                  <br>
                  <p></p>
                </div>
              </section><!-- #section-latest-news -->
            </div>
          </div>
          <div class="col-md-3">
            <div class="widget-area">
              <section id="section-newsletter" class="section">
                <h2 class="section-title h4 clearfix"><i class="line"></i>Find out More</h2>
                <div class="textwidget">
                  <p></p>
                  <ul>
                    <li>Forums</li>
                    <li>News</li>
                    <li>Blog</li>
                    <li>Partner NOC Directory</li>
                  </ul>
                  <br>
                  <p></p>
                </div>
              </section><!-- #section-newsletter -->
            </div>
          </div>
          <div class="col-md-3">
            <div class="widget-area">
              <section id="section-newsletter" class="section">
                <h2 class="section-title h4 clearfix">Contact Us</h2>
                <div class="textwidget">
                  <p><i>BTM Layout, No: #28<br>9th Cross First Stage BTM Layout Near Water Tank<br></i><i>Bangalore –
                      560 029</i><br><i>Karnataka – India<br></i><i>Telephone:&nbsp;</i><i>+91 9999999999<br></i><i>Email:&nbsp;</i><a
                      target="_blank" rel="nofollow"><i>&nbsp;&nbsp;&nbsp;support@abcclothing.com</i></a></p>
                </div>
              </section>
            </div>
          </div>
        </div>


        <div class="clearfix"></div>
        <hr style="color:#E5E5E5">
        <div class="row">
          <div class="site-info col-md-6">
            <p class="text-muted">Copyright Â© 2016 <a href="http://www.faveohelpdesk.com/demo/helpdesk/public/"
                                                       target="_blank">ABC Company</a>. All right Reserved.
              Powered by <a href="http://www.faveohelpdesk.com/" target="_blank">Faveo</a></p>
          </div>
          <div class="site-social text-right col-md-6">
            <ul class="list-inline hidden-print">
              <li><a href="http://www.faveohelpdesk.com/" class="btn btn-social btn-linkedin" target="_blank"><i
                    class="fa fa-linkedin fa-fw"></i></a></li>
              <li><a href="http://www.faveohelpdesk.com/" class="btn btn-social btn-google-plus"
                     target="_blank"><i class="fa fa-google-plus fa-fw"></i></a></li>
              <li><a href="http://www.faveohelpdesk.com/" class="btn btn-social btn-flickr" target="_blank"><i
                    class="fa fa-flickr fa-fw"></i></a></li>
              <li><a href="http://www.faveohelpdesk.com/" class="btn btn-social btn-rss" target="_blank"><i
                    class="fa fa-rss fa-fw"></i></a></li>
              <li><a href="http://www.faveohelpdesk.com/" class="btn btn-social btn-twitter"
                     target="_blank"><i class="fa fa-twitter fa-fw"></i></a></li>
              <li><a href="http://www.faveohelpdesk.com/" class="btn btn-social btn-facebook" target="_blank"><i
                    class="fa fa-facebook fa-fw"></i></a></li>
              <li><a href="http://www.faveohelpdesk.com/" class="btn btn-social btn-youtube"
                     target="_blank"><i class="fa fa-youtube-play fa-fw"></i></a></li>
              <li><a href="http://www.faveohelpdesk.com/" class="btn btn-social btn-vimeo" target="_blank"><i
                    class="fa fa-vimeo-square fa-fw"></i></a></li>
              <li><a href="http://www.faveohelpdesk.com/" class="btn btn-social btn-pinterest"
                     target="_blank"><i class="fa fa-pinterest fa-fw"></i></a></li>
              <li><a href="http://www.faveohelpdesk.com/" class="btn btn-social btn-dribbble" target="_blank"><i
                    class="fa fa-dribbble fa-fw"></i></a></li>
              <li><a href="http://www.faveohelpdesk.com/" class="btn btn-social btn-instagram"
                     target="_blank"><i class="fa fa-instagram fa-fw"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </footer><!-- #colophon -->
    <!-- jQuery 2.1.1 -->

    <script src="./desk/js/jquery2.1.1.min.js" type="text/javascript"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="./desk/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Slimscroll -->
    <script src="./desk/js/superfish.js" type="text/javascript"></script>

    <script src="./desk/js/mobilemenu.js" type="text/javascript"></script>

    <script src="./desk/js/know.js" type="text/javascript"></script>

    <script src="./desk/js/jquery.rating.pack.js" type="text/javascript"></script>

    <script src="./desk/js/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>

    <script src="./desk/js/icheck.min.js" type="text/javascript"></script>

    <script>
      $(function () {
//Enable check and uncheck all functionality
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
  </div>