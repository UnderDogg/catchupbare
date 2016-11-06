@extends('tickets.ticketlayouts.ticketmaster')

@section('Tools')
    class="active"
@stop

@section('tools-bar')
    active
@stop

@section('tools')
    class="active"
    @stop

            <!-- content -->
    @section('content')

            <!-- open a form -->
    {!! Form::open(['route'=>'canned.store','method' => 'patch']) !!}

    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">{!! Lang::get('tickets::lang.create') !!} </h3>
            <div class="pull-right">{!! Form::submit(Lang::get('tickets::lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}</div>
        </div>

        <div class="box-body">

            <div class="row">
                <!-- username -->
                <div class="col-xs-6 form-group {{ $errors->has('title') ? 'has-error' : '' }}">

                    {!! Form::label('title',Lang::get('tickets::lang.title')) !!}
                    {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                    {!! Form::text('title',null,['class' => 'form-control']) !!}

                </div>
                <!-- firstname -->
                <div class="col-xs-12 form-group {{ $errors->has('message') ? 'has-error' : '' }}">

                    {!! Form::label('message',Lang::get('tickets::lang.message')) !!}
                    {!! $errors->first('message', '<span class="help-block">:message</span>') !!}
                    {!! Form::textarea('message',null,['class' => 'form-control']) !!}

                </div>

            </div>

        </div>
        <script>
            $(function () {
                //Add text editor
                $("textarea").wysihtml5();
            });
        </script>
@stop
