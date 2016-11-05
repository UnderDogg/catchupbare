@extends('core::adminlayouts.adminmaster')

@section('Settings')
active
@stop

@section('settings-bar')
active
@stop

@section('cron')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{ Lang::get('lang.settings') }}</h1>
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
<!-- open a form -->

@if($warn!=="")
@include('core::admin.cron.cron-new')
@else 
@include('core::admin.cron.cron-new')
@endif
@stop
