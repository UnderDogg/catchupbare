@extends('core::adminlayouts.adminmaster')

@section('Manage')
active
@stop

@section('manage-bar')
active
@stop

@section('sla')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')

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

		{!! Form::model($slas,['url' => 'sla/'.$slas->id, 'method' => 'PATCH']) !!}

	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
               <div class="box-body">


                       <div class="box-header">
                        <h2 class="box-title">{{Lang::get('tickets::lang.edit')}}</h2>{!! Form::submit(Lang::get('tickets::lang.save'),['class'=>'pull-right btn btn-primary'])!!}</div>


                 <!-- Name text form Required -->
                       <div class="box-body table-responsive no-padding"style="overflow:hidden;">
                       <!-- <table class="table table-hover" style="overflow:hidden;"> -->
                        <div class="row">
                          <div class="col-md-6">
                          <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">

		                     {!! Form::label('name',Lang::get('tickets::lang.name')) !!}
			                 {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
			                 {!! Form::text('name',null,['class' => 'form-control']) !!}
			             </div>
		              </div>

                <!-- Grace Period text form Required -->
                         <div class="col-md-6">
		              <div class="form-group {{ $errors->has('grace_period') ? 'has-error' : '' }}">

			           {!! Form::label('grace_period',Lang::get('tickets::lang.grace_period')) !!}
		               {!! $errors->first('grace_period', '<span class="help-block">:message</span>') !!}
			            {!! Form::select('grace_period',['6 Hours'=>'6 Hours', '12 Hours'=>'12 Hours', '18 Hours'=>'18 Hours', '24 Hours'=>'24 Hours', '36 Hours'=>'36 Hours', '48 Hours'=>'48 Hours'],null,['class' => 'form-control']) !!}
			          </div>
		            </div>

<!-- status radio: required: Active|Dissable -->
                     <div class="col-md-6">
		          <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">

			       {!! Form::label('status',Lang::get('tickets::lang.status')) !!}&nbsp;
			       {!! $errors->first('status', '<span class="help-block">:message</span>') !!}&nbsp;&nbsp;
			       {!! Form::radio('status','1',true) !!} &nbsp; {{Lang::get('tickets::lang.active')}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			       {!! Form::radio('status','0') !!} &nbsp; {{Lang::get('tickets::lang.inactive')}}
			</div>

	</div>
</div>

<!-- Admin Note  : Textarea :  -->
         <div class="row">
            <div class="col-md-12">
		    <div class="form-group">

			{!! Form::label('admin_note',Lang::get('tickets::lang.admin_notes')) !!}
			{!! Form::textarea('admin_note',null,['class' => 'form-control','size' => '30x5']) !!}
		     </div>
		</div>
		</div>

</div>
</div>
</div>
</div>
</div>
</div>

<!-- close form -->

{!! Form::close() !!}

@stop
