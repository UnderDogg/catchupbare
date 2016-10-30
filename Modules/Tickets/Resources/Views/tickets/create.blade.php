@extends('layouts.master')
@section('heading')
    <h1>Create ticket</h1>
@stop

@section('content')

    {!! Form::open([
            'route' => 'tickets.store'
            ]) !!}

    <div class="form-group">
        {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-inline">
        <div class="form-group col-sm-6 removeleft ">
            {!! Form::label('deadline', 'Deadline:', ['class' => 'control-label']) !!}
            {!! Form::date('deadline', \Carbon\Carbon::now()->addDays(3), ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-sm-6 removeleft removeright">
            {!! Form::label('status_id', 'Status:', ['class' => 'control-label']) !!}
            {!! Form::select('status_id', array(
            '1' => 'Open', '2' => 'Completed'), null, ['class' => 'form-control'] )
         !!}
        </div>

    </div>
    <div class="form-group form-inline">
        {!! Form::label('assigned_to_staff_id', ' Assign User:', ['class' => 'control-label']) !!}
        {!! Form::select('assigned_to_staff_id', $users, null, ['class' => 'form-control']) !!}
        @if(Request::get('relation') != "")
            {!! Form::hidden('fk_relation_id', Request::get('relation')) !!}
        @else
            {!! Form::label('fk_relation_id', 'Assign Relation:', ['class' => 'control-label']) !!}
            {!! Form::select('fk_relation_id', $relations, null, ['class' => 'form-control']) !!}
        @endif
    </div>




    </div>

    {!! Form::submit('Create New Ticket', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}





@stop