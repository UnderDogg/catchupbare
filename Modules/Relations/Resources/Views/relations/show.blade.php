@extends('layouts.master')
@section('heading')
@stop
@section('content')
<script>
$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip(); //Tooltip on icons top
  $('.popoverOption').each(function() {
    var $this = $(this);
    $this.popover({
    trigger: 'hover',
    placement: 'left',
    container: $this,
    html: true,
    content: $this.find('#popover_content_wrapper').html()
   });
  });
});
</script>
<div class="row">
  @include('partials.relationheader')
  @include('partials.userheader')
</div>
<div class="row">
  <div class="col-md-8 currentticket">
    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#ticket">Tickets</a></li>
      <li><a data-toggle="tab" href="#lead">Leads</a></li>
      <li><a data-toggle="tab" href="#docuemnt">Documents</a></li>
      <li><a data-toggle="tab" href="#invoice">Invoices</a></li>
      
    </ul>
    <div class="tab-content">
      @include('relations.tabs.tickettab')
    </div>
    @include('relations.tabs.leadtab')
    @include('relations.tabs.documenttab')
    @include('relations.tabs.invoicetab')
  </div>
</div>
<div class="col-md-4 currentticket">
  <div class="boxspace">
    <!--Tickets stats at some point-->
  </div>
</div>
</div>
</div>
@stop