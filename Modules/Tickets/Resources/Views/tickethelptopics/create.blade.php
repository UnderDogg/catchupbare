@extends('tickets::ticketlayouts.ticketmaster')

@section('Manage')
active
@stop

@section('manage-bar')
active
@stop

@section('help')
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

	{!! Form::open(['action' => 'Admin\helpdesk\HelptopicController@store', 'method' => 'post']) !!}

	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
               <div class="box-body">

                      <div class="form-group">
                       <div class="box-header">
                            <h2 class="box-title">{{Lang::get('tickets::lang.create')}}</h2><div class="pull-right">
                            {!! Form::submit(Lang::get('tickets::lang.save'),['class'=>'btn btn-primary'])!!}
                            </div>
                            </div>
	 <div class="box-body table-responsive no-padding" style="overflow:hidden">

                          <!-- status radio: required: Active|Dissable -->
                          <div class="row">
               <div class="col-md-6">
		<div class="form-group {{ $errors->has('ticket_status') ? 'has-error' : '' }}">

			{!! Form::label('ticket_status',Lang::get('tickets::lang.status')) !!}&nbsp;&nbsp;
			{!! $errors->first('status', '<span class="help-block">:message</span>') !!}
			{!! Form::radio('status','1',true) !!} {{Lang::get('tickets::lang.active')}}&nbsp;&nbsp;&nbsp;
			{!! Form::radio('status','0') !!} {{Lang::get('tickets::lang.inactive')}}
			</div>
		</div>

<!-- Type : Radio : required : Public|private -->
            <div class="col-md-6">
		<div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">

			{!! Form::label('type',Lang::get('tickets::lang.type')) !!}&nbsp;&nbsp;
			{!! $errors->first('type', '<span class="help-block">:message</span>') !!}
			{!! Form::radio('type','1',true) !!} {{Lang::get('tickets::lang.public')}}&nbsp;&nbsp;&nbsp;
			{!! Form::radio('type','0') !!} {{Lang::get('tickets::lang.private')}}
		</div>
		</div>
<!-- Topic text form Required -->
          <div class="col-md-6">
		<div class="form-group {{ $errors->has('topic') ? 'has-error' : '' }}">

			{!! Form::label('topic',Lang::get('tickets::lang.topic')) !!}
			{!! $errors->first('topic', '<span class="help-block">:message</span>') !!}
			{!! Form::text('topic',null,['class' => 'form-control']) !!}
			</div>
		</div>
		        <!-- Parent Topic: Drop down: value from helptopic table -->
              <div class="col-md-6">
		<div class="form-group {{ $errors->has('parent_topic') ? 'has-error' : '' }}">

			{!! Form::label('parent_topic',Lang::get('tickets::lang.parent_topic')) !!}
			{!! $errors->first('parent_topic', '<span class="help-block">:message</span>') !!}
			{!!Form::select('parent_topic', [''=>'Select a Parent Topic','Help Topics'=>$topics->lists('topic','topic')],1,['class' => 'form-control']) !!}
			</div>
		</div>


<!-- Custom Form: Drop down: value from form table -->
           <div class="col-md-6">
		<div class="form-group {{ $errors->has('custom_form') ? 'has-error' : '' }}">

			{!! Form::label('custom_form',Lang::get('tickets::lang.Custom_form')) !!}
			{!! $errors->first('custom_form', '<span class="help-block">:message</span>') !!}
			{!!Form::select('custom_form', [''=>'Select a Form','Custom Forms'=>$forms->lists('formname','id')],1,['class' => 'form-control']) !!}
			</div>
		</div>


<!-- Department:	Drop down: value Department form table -->
            <div class="col-md-6">
		<div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">

			{!! Form::label('department',Lang::get('tickets::lang.department')) !!}
			{!! $errors->first('department', '<span class="help-block">:message</span>') !!}
			{!!Form::select('department', [''=>'Select a Department','Departments'=>$departments->lists('name','id')],1,['class' => 'form-control']) !!}
			</div>
		</div>
</div>

<!-- Priority:	Drop down: value from Priority  table -->
          <div class="row">
             <div class="col-md-4">
		<div class="form-group {{ $errors->has('priority') ? 'has-error' : '' }}">

			{!! Form::label('priority',Lang::get('tickets::lang.priority')) !!}
			{!! $errors->first('priority', '<span class="help-block">:message</span>') !!}
			{!!Form::select('priority', [''=>'Select a Proirity','Priorities'=>$priority->lists('priority_desc','priority_id')],null,['class' => 'form-control']) !!}
			</div>
		</div>


<!-- SLA Plan:	 Drop down: value SLA Plan  table-->
             <div class="col-md-4">
		<div class="form-group {{ $errors->has('sla_plan') ? 'has-error' : '' }}">

			{!! Form::label('sla_plan',Lang::get('tickets::lang.SLA_plan')) !!}
			{!! $errors->first('sla_plan', '<span class="help-block">:message</span>') !!}
			{!!Form::select('sla_plan', [''=>'Select a SLA Plan','SLA Plans'=>$slas->lists('name','id')],1,['class' => 'form-control']) !!}
			</div>
		</div>


<!-- Auto-assign To:	Drop Down: value  from Agent table   -->
          <div class="col-md-4">
		<div class="form-group {{ $errors->has('auto_assign') ? 'has-error' : '' }}">

			{!! Form::label('auto_assign',Lang::get('tickets::lang.auto_assign')) !!}
			{!! $errors->first('auto_assign', '<span class="help-block">:message</span>') !!}
			{!!Form::select('auto_assign', [''=>'Select an Agent','Agents'=>$agents->lists('first_name','id')],null,['class' => 'form-control']) !!}
			</div>
		</div>
		</div>


<!-- Auto-response:	checkbox : Disable new ticket auto-response  -->
          <div class="row">

<!-- intrnal Notes : Textarea :  -->
<div class="col-md-12">
		<div class="form-group">

			{!! Form::label('internal_notes',Lang::get('tickets::lang.internal_notes')) !!}
			{!! Form::textarea('internal_notes',null,['class' => 'form-control','size' => '10x5']) !!}
		</div>
		</div>
		</div>

<!-- Submit button -->




</div>
</div>
</div>
</div>
</div>
</div>

<!-- close form -->

{!! Form::close() !!}

@stop
