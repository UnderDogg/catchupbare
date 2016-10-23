@extends('email::maillayouts.mailmaster')

@section('Mailboxes')
    class="active"
@stop

@section('emails-bar')
    active
@stop

@section('diagnostics')
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

@stop
            <!-- /breadcrumbs -->
    <!-- content -->
    @section('content')
            <!-- check whether success or not -->
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <b>Success!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
    @endif
                <!-- failure message -->
     @if(Session::has('fails'))
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <b>Fail!</b>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{Session::get('fails')}}
            </div>
     @endif




        {!! Form::open(['method'=>'post' , 'action'=>'\Modules\Email\Http\Controllers\MailTemplatesController@postDiagno']) !!}

        <div class="box box-primary">
            <div class="box-header">
                <h4 class="box-title">{{Lang::get('email::lang.diagnostics')}}</h4> {!! Form::submit(Lang::get('email::lang.send'),['class'=>'form-group btn btn-primary pull-right'])!!}
                <div class="">Diagnose sending emails to other email addresses</div>
            </div>
            <div class="box-body">
                <!-- To : define To Address : Text form : Required -->
                <div class="form-group">
                    {!! Form::label('to',Lang::get('email::lang.to')) !!}
                    {!! Form::text('to',null,['class' => 'form-control']) !!}
                </div>
            </div>
        </div>



@stop
