@extends('layouts.master')
@section('heading')
Edit Relation ({{$relation->name}})
@stop

@section('content')
{!! Form::model($relation, [
        'method' => 'PATCH',
        'route' => ['relations.update', $relation->id],
        ]) !!}

<div class="form-group">
    {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('vat', 'Vat:', ['class' => 'control-label']) !!}
    {!! Form::text('vat',  null, ['class' => 'form-control']) !!}
</div>  

<div class="form-group">
    {!! Form::label('company_name', 'Company name:', ['class' => 'control-label']) !!}
    {!! Form::text('company_name',  null, ['class' => 'form-control']) !!}
</div>  

<div class="form-group">
    {!! Form::label('email', 'Email:', ['class' => 'control-label']) !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('address', 'Address:', ['class' => 'control-label']) !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('zipcode', 'Zipcode:', ['class' => 'control-label']) !!}
    {!! Form::text('zipcode', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('city', 'City:', ['class' => 'control-label']) !!}
    {!! Form::text('city', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('primary_number', 'Primary Number:', ['class' => 'control-label']) !!}
    {!! Form::text('primary_number',  null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('secondary_number', 'Secondary Number:', ['class' => 'control-label']) !!}
    {!! Form::text('secondary_number',  null, ['class' => 'form-control']) !!}
</div>  

<div class="form-group">
    {!! Form::label('industry', 'Industry:', ['class' => 'control-label']) !!} 
{!! Form::select('industry_id', $industries, null, ['class' => 'form-control ui search selection top right pointing search-select', 'id' => 'search-select']) !!} 
</div>  


<div class="form-group">
    {!! Form::label('company_type', 'Company type:', ['class' => 'control-label']) !!}
    {!! Form::text('company_type',  null, ['class' => 'form-control']) !!}
</div>  
{!! Form::label('fk_staff_id', 'Assign user:', ['class' => 'control-label']) !!}
{!! Form::select('fk_staff_id', $users, null, ['class' => 'form-control']) !!}<br />

{!! Form::submit('Update Relation', ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}

@stop