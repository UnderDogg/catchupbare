@extends('tickets::ticketlayouts.ticketmaster')



@section('TicketsPanel')
class="active"
@stop

@section('ticketspanel-bar')
active
@stop

@section('alltickets')
class="active"
@stop
@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h3>
  Dashboard
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






  @if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
      <i class="fa fa-ban"></i>
      <b>Alert!</b> Success.
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      {{Session::get('success')}}
    </div>
    @endif
            <!-- fail message -->
    @if(Session::has('fails'))
      <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>Alert!</b> Failed.
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('fails')}}
      </div>
    @endif



  <script>
    $(document).ready(function () {
      $('[data-toggle="tooltip"]').tooltip(); //Tooltip on icons top

      $('.popoverOption').each(function () {
        var $this = $(this);
        $this.popover({
          trigger: 'hover',
          placement: 'left',
          container: $this,
          html: true,

        });
      });
    });
  </script>

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