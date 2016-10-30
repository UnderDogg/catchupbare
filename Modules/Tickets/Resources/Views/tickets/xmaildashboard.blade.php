@extends('email::maillayouts.mailmaster')
@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h3>
  Email Dashboard
  <!-- <small>Add</small> -->
</h3>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">

</ol>
@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')



  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">{!! Lang::get('core::lang.settings') !!}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <!--/.col-md-2-->
          <div class="col-md-2 col-sm-6">
            <div class="settingiconblue">
              <div class="settingdivblue">
                <a href="{{url('/adminpanel/companies/getcompany')}}"><span class="fa-stack fa-2x">

                 <i class="fa fa-building-o fa-stack-1x"></i>
               </span></a>
              </div>
              <center class="box-title" >{!! Lang::get('core::lang.company') !!}</center>
            </div>
          </div>
          <!--/.col-md-2-->
          <!--/.col-md-2-->
          <div class="col-md-2 col-sm-6">
            <div class="settingiconblue">
              <div class="settingdivblue">
                <a href="{{url('/adminpanel/getsystem')}}"><span class="fa-stack fa-2x">

                 <i class="fa fa-laptop fa-stack-1x"></i>
                 </span></a>
              </div>
              <center class="box-title" >{!! Lang::get('core::lang.system') !!}</center>
            </div>
          </div>
          <!--/.col-md-2-->

          <!--/.col-md-2-->
          <div class="col-md-2 col-sm-6">
            <div class="settingiconblue">
              <div class="settingdivblue">
                <a href="{{url('/mailpanel/getmail')}}"><span class="fa-stack fa-2x">

                 <i class="fa fa-at fa-stack-1x"></i>
                 </span></a>
              </div>
              <center class="box-title" >{!! Lang::get('email::lang.mailboxes') !!}</center>
            </div>
          </div>
          <!--/.col-md-2-->

          <!--/.col-md-2-->
          <div class="col-md-2 col-sm-6">
            <div class="settingiconblue">
              <div class="settingdivblue">
                <a href="{{url('/ticketspanel/gettickets')}}"><span class="fa-stack fa-2x">

                 <i class="fa fa-file-text-o fa-stack-1x"></i>
                 </span></a>
              </div>
              <center class="box-title" >{!! Lang::get('tickets::lang.ticket') !!}</center>
            </div>
          </div>
          <!--/.col-md-2-->

          <!--/.col-md-2-->
          <div class="col-md-2 col-sm-6">
            <div class="settingiconblue">
              <div class="settingdivblue">
                <a href="{{url('/mailpanel/getresponder')}}"><span class="fa-stack fa-2x">

                 <i class="fa fa-reply-all fa-stack-1x"></i>
                 </span></a>
              </div>
              <center class="box-title" >{!! Lang::get('tickets::lang.auto_response') !!}</center>
            </div>
          </div>
          <!--/.col-md-2-->

          <!--/.col-md-2-->
          <div class="col-md-2 col-sm-6">
            <div class="settingiconblue">
              <div class="settingdivblue">
                <a href="{{url('/adminpanel/getalert')}}"><span class="fa-stack fa-2x">
                 <i class="fa fa-bell-o fa-stack-1x"></i>
                 </span></a>
              </div>
              <center class="box-title" >{!! Lang::get('core::lang.alert_notices') !!}</center>
            </div>
          </div>
          <!--/.col-md-2-->

          <!--/.col-md-2-->
          <div class="col-md-2 col-sm-6">
            <div class="settingiconblue">
              <div class="settingdivblue">
                <a href="{{url('/adminpanel/languages')}}"><span class="fa-stack fa-2x">
                 <i class="fa fa-language fa-stack-1x"></i>
                 </span></a>
              </div>
              <center class="box-title">{!! Lang::get('core::lang.language') !!}</center>
            </div>
          </div>
          <!--/.col-md-2-->
          <div class="col-md-2 col-sm-6">
            <div class="settingiconblue">
              <div class="settingdivblue">
                <a href="{{url('/adminpanel/job-scheduler')}}"><span class="fa-stack fa-2x">

                 <i class="fa fa-hourglass-o fa-stack-1x"></i>
                 </span></a>
              </div>
              <center class="box-title" >{!! Lang::get('core::lang.cron') !!}</center>
            </div>
          </div>
          <!--/.col-md-2-->

        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- ./box-body -->
  </div><!-- /.box -->



 <div class="box">
   <div class="box-header with-border">
     <h3 class="box-title">{!! Lang::get('employees::lang.staff') !!}</h3>
   </div>
   <!-- /.box-header -->
   <div class="box-body">
     <div class="row">
       <div class="col-md-12">
         <!--/.col-md-2-->
         <div class="col-md-2 col-sm-6">
           <div class="settingiconblue">
             <div class="settingdivblue">
               <a href="{{ url('/adminpanel/staff/manage/') }}"><span class="fa-stack fa-2x">
                 <i class="fa fa-user fa-stack-1x"></i>
               </span></a>
             </div>
             <center class="box-title" >{!! Lang::get('core::lang.staff') !!}</center>
           </div>
         </div>
         <!--/.col-md-2-->
         <!--/.col-md-2-->
         <div class="col-md-2 col-sm-6">
           <div class="settingiconblue">
             <div class="settingdivblue">
               <a href="{{ url('/adminpanel/departments/manage') }}"><span class="fa-stack fa-2x">
                 <i class="fa fa-sitemap fa-stack-1x"></i>
                 </span></a>
             </div>
             <center class="box-title" >{!! Lang::get('core::lang.departments') !!}</center>
           </div>
         </div>
         <!--/.col-md-2-->

         <!--/.col-md-2-->
         <div class="col-md-2 col-sm-6">
           <div class="settingiconblue">
             <div class="settingdivblue">
               <a href="{{ url('/adminpanel/teams/manage') }}"><span class="fa-stack fa-2x">
                 <i class="fa fa-users fa-stack-1x"></i>
                 </span></a>
             </div>
             <center class="box-title" >{!! Lang::get('core::lang.teams') !!}</center>
           </div>
         </div>
         <!--/.col-md-2-->
         <!--/.col-md-2-->
         <div class="col-md-2 col-sm-6">
           <div class="settingiconblue">
             <div class="settingdivblue">
               <a href="{{ url('/adminpanel/roles/manage') }}"><span class="fa-stack fa-2x">

                 <i class="fa fa-group fa-stack-1x"></i>
                 </span></a>
             </div>
             <center class="box-title" >{!! Lang::get('core::lang.roles') !!}</center>
           </div>
         </div>
         <!--/.col-md-2-->
       </div>
     </div>
     <!-- /.row -->
   </div>
   <!-- ./box-body -->
 </div>
 <!-- /.box -->



 <div class="box">
   <div class="box-header with-border">
     <h3 class="box-title">{!! Lang::get('email::lang.mailboxes') !!}</h3>
   </div>
   <!-- /.box-header -->
   <div class="box-body">
     <div class="row">
       <div class="col-md-12">
         <!--/.col-md-2-->
         <div class="col-md-2 col-sm-6">
           <div class="settingiconblue">
             <div class="settingdivblue">
               <a href="{{ url('/mailpanel/mailboxes/manage') }}"><span class="fa-stack fa-2x">
               <i class="fa fa-envelope-o fa-stack-1x"></i>
               </span></a>
             </div>
             <center class="box-title" >{!! Lang::get('email::lang.mailboxes') !!}</center>
           </div>
         </div>
         <!--/.col-md-2-->

         <!--/.col-md-2-->
         <div class="col-md-2 col-sm-6">
           <div class="settingiconblue">
             <div class="settingdivblue">
               <a href="{{ url('/mailpanel/mailbanlist') }}"><span class="fa-stack fa-2x">
                 <i class="fa fa-ban fa-stack-1x"></i>
                 </span></a>
             </div>
             <center class="box-title" >{!! Lang::get('email::lang.ban_lists') !!}</center>
           </div>
         </div>
         <!--/.col-md-2-->

         <!--/.col-md-2-->
         <div class="col-md-2 col-sm-6">
           <div class="settingiconblue">
             <div class="settingdivblue">
               <a href="{{ url('/mailpanel/mailtemplates/') }}"><span class="fa-stack fa-2x">

                 <i class="fa fa-mail-forward fa-stack-1x"></i>
                 </span></a>
             </div>
             <center class="box-title" >{!! Lang::get('email::lang.mailtemplates') !!}</center>
           </div>
         </div>
         <!--/.col-md-2-->

         <!--/.col-md-2-->
         <div class="col-md-2 col-sm-6">
           <div class="settingiconblue">
             <div class="settingdivblue">
               <a href="{{ url('/mailpanel/maildiagno/getmaildiagno') }}"><span class="fa-stack fa-2x">

                 <i class="fa fa-plus fa-stack-1x"></i>
                 </span></a>
             </div>
             <center class="box-title" >{!! Lang::get('email::lang.diagnostics') !!}</center>
           </div>
         </div>
         <!--/.col-md-2-->

       </div>
     </div>
     <!-- /.row -->
   </div>
   <!-- ./box-body -->
 </div>




 <div class="box">
   <div class="box-header with-border">
     <h3 class="box-title">{!! Lang::get('tickets::lang.tickets') !!}</h3>
   </div>
   <!-- /.box-header -->
   <div class="box-body">
     <div class="row">
       <div class="col-md-12">
         <!--/.col-md-2-->
         <div class="col-md-2 col-sm-6">
           <div class="settingiconblue">
             <div class="settingdivblue">
               <a href="{{url('/ticketspanel/helptopics')}}"><span class="fa-stack fa-2x">

                 <i class="fa fa-file-text-o fa-stack-1x"></i>
               </span></a>
             </div>
             <center class="box-title" >{!! Lang::get('tickets::lang.help_topics') !!}</center>
           </div>
         </div>
         <!--/.col-md-2-->
         <!--/.col-md-2-->
         <div class="col-md-2 col-sm-6">
           <div class="settingiconblue">
             <div class="settingdivblue">
               <a href="{{url('/ticketspanel/slaplans')}}"><span class="fa-stack fa-2x">

                 <i class="fa fa-clock-o fa-stack-1x"></i>
                 </span></a>
             </div>
             <center class="box-title" >{!! Lang::get('tickets::lang.sla_plans') !!}</center>
           </div>
         </div>
         <!--/.col-md-2-->

         <!--/.col-md-2-->
         <div class="col-md-2 col-sm-6">
           <div class="settingiconblue">
             <div class="settingdivblue">
               <a href="{{url('/ticketspanel/forms')}}"><span class="fa-stack fa-2x">

                 <i class="fa fa-file-text fa-stack-1x"></i>
                 </span></a>
             </div>
             <center class="box-title" >{!! Lang::get('tickets::lang.forms') !!}</center>
           </div>
         </div>
         <!--/.col-md-2-->
         <!--/.col-md-2-->
         <div class="col-md-2 col-sm-6">
           <div class="settingiconblue">
             <div class="settingdivblue">
               <a href="{{url('/ticketspanel/workflows')}}"><span class="fa-stack fa-2x">

                 <i class="fa fa-sitemap fa-stack-1x"></i>
                 </span></a>
             </div>
             <center class="box-title" >{!! Lang::get('tickets::lang.workflows') !!}</center>
           </div>
         </div>
         <!--/.col-md-2-->

       </div>
     </div>
     <!-- /.row -->
   </div>
   <!-- ./box-body -->
 </div>

@section('FooterInclude')

@stop
@stop
<!-- /content -->