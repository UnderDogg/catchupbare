@extends('themes.default1.client.layout.client')
@section('HeadInclude')
    <link href="{{asset("lb-faveo/css/AdminLTE.css")}}" rel="stylesheet" type="text/css"/>
@stop
@section('breadcrumb')

    <div class="site-hero clearfix">
        <ol class="breadcrumb breadcrumb-custom">
            <li class="text">You are here:</li>
            <li><a href="#">My Profile</a></li>
            <li class="active"><a href="{!! URL::route('client.profile') !!}">Edit Profile</a></li>
        </ol>
    </div>

@stop
@section('profile')
    class="active"
@stop
@section('content')
    <div id="content" class="site-content col-md-12">
        <section class="section-title">
            <h2>
                Profile Settings </h2>
        </section>
        <div class="row">
            <div class="col-md-6">

                {!! Form::model($user,['url'=>'client-profile-edit', 'method' => 'PATCH','files'=>true]) !!}

                <div class="box box-primary">

                    <div class="content-header">

                        <h4>
                            Profile {!! Form::submit(Lang::get('helpdesk::tickets.save'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

                    </div>

                    <div class="box-body">

                        @if(Session::has('success1'))
                            <div class="alert alert-success alert-dismissable">
                                <i class="fa fa-ban"></i>
                                <b>Alert!</b> Success.
                                <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button>
                                {{Session::get('success1')}}
                            </div>
                            @endif
                                    <!-- fail message -->
                            @if(Session::has('fails1'))
                                <div class="alert alert-danger alert-dismissable">
                                    <i class="fa fa-ban"></i>
                                    <b>Alert!</b> Failed.
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">&times;</button>
                                    {{Session::get('fails1')}}
                                </div>
                            @endif

                            <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                <!-- first name -->
                                {!! Form::label('first_name',Lang::get('helpdesk::tickets.first_name')) !!}
                                {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
                                {!! Form::text('first_name',null,['class' => 'form-control']) !!}

                            </div>

                            <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                <!-- last name -->
                                {!! Form::label('last_name',Lang::get('helpdesk::tickets.last_name')) !!}
                                {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                                {!! Form::text('last_name',null,['class' => 'form-control']) !!}

                            </div>

                            <div class="form-group">
                                <!-- gender -->
                                {!! Form::label('gender',Lang::get('helpdesk::tickets.gender')) !!}
                                <div class="row">
                                    <div class="col-xs-3">
                                        {!! Form::radio('gender','1',true) !!}{{Lang::get('helpdesk::tickets.male')}}
                                    </div>
                                    <div class="col-xs-3">
                                        {!! Form::radio('gender','0') !!}{{Lang::get('helpdesk::tickets.female')}}
                                    </div>
                                </div>
                            </div>



                            <div class="form-group">
                                <!-- email -->
                                {!! Form::label('email',Lang::get('helpdesk::tickets.email_address')) !!}
                                <div>
                                    {{$user->email}}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                                <!-- company -->
                                {!! Form::label('company',Lang::get('helpdesk::tickets.company')) !!}
                                {!! $errors->first('company', '<span class="help-block">:message</span>') !!}
                                {!! Form::text('company',null,['class' => 'form-control']) !!}

                            </div>

                            <div class="row">
                                <div class="col-xs-3 form-group {{ $errors->has('ext') ? 'has-error' : '' }}">
                                    <!-- phone extensionn -->
                                    {!! Form::label('ext',Lang::get('helpdesk::tickets.ext')) !!}
                                    {!! $errors->first('ext', '<span class="help-block">:message</span>') !!}
                                    {!! Form::text('ext',null,['class' => 'form-control']) !!}

                                </div>

                                <div class="col-xs-9 form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">
                                    <!-- phone number -->
                                    {!! Form::label('phone_number',Lang::get('helpdesk::tickets.phone')) !!}
                                    {!! $errors->first('phone_number', '<span class="help-block">:message</span>') !!}
                                    {!! Form::text('phone_number',null,['class' => 'form-control']) !!}

                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
                                <!-- mobile -->
                                {!! Form::label('mobile',Lang::get('helpdesk::tickets.mobile_number')) !!}
                                {!! $errors->first('mobile', '<span class="help-block">:message</span>') !!}
                                {!! Form::text('mobile',null,['class' => 'form-control']) !!}

                            </div>


                            <div class="form-group {{ $errors->has('profile_pic') ? 'has-error' : '' }}">
                                <!-- profile pic -->
                                {!! Form::label('profile_pic',Lang::get('helpdesk::tickets.profile_pic')) !!}
                                {!! $errors->first('profile_pic', '<span class="help-block">:message</span>') !!}
                                {!! Form::file('profile_pic') !!}

                            </div>

                            {!! Form::token() !!}
                            {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">

                {!! Form::model($user,['url'=>'client-profile-password' , 'method' => 'PATCH']) !!}

                <div class="box box-primary">

                    <div class="content-header">

                        <h4>Change
                            Password {!! Form::submit(Lang::get('helpdesk::tickets.save'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

                    </div>

                    <div class="box-body">
                        @if(Session::has('success2'))
                            <div class="alert alert-success alert-dismissable">
                                <i class="fa fa-ban"></i>
                                <b>Alert!</b> Success.
                                <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button>
                                {{Session::get('success2')}}
                            </div>
                            @endif
                                    <!-- fail message -->
                            @if(Session::has('fails2'))
                                <div class="alert alert-danger alert-dismissable">
                                    <i class="fa fa-ban"></i>
                                    <b>Alert!</b> Failed.
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">&times;</button>
                                    {{Session::get('fails2')}}
                                </div>
                                @endif
                                        <!-- old password -->
                                <div class="form-group has-feedback {{ $errors->has('old_password') ? 'has-error' : '' }}">
                                    {!! Form::label('old_password',Lang::get('helpdesk::tickets.old_password')) !!}
                                    {!! Form::password('old_password',['placeholder'=>'Password','class' => 'form-control']) !!}
                                    {!! $errors->first('old_password', '<span class="help-block">:message</span>') !!}
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                </div>
                                <!-- new password -->
                                <div class="form-group has-feedback {{ $errors->has('new_password') ? 'has-error' : '' }}">
                                    {!! Form::label('new_password',Lang::get('helpdesk::tickets.new_password')) !!}
                                    {!! Form::password('new_password',['placeholder'=>'New Password','class' => 'form-control']) !!}
                                    {!! $errors->first('new_password', '<span class="help-block">:message</span>') !!}
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                </div>
                                <!-- cofirm password -->
                                <div class="form-group has-feedback {{ $errors->has('confirm_password') ? 'has-error' : '' }}">
                                    {!! Form::label('confirm_password',Lang::get('helpdesk::tickets.confirm_password')) !!}
                                    {!! Form::password('confirm_password',['placeholder'=>'Confirm Password','class' => 'form-control']) !!}
                                    {!! $errors->first('confirm_password', '<span class="help-block">:message</span>') !!}
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                </div>

                    </div>
                </div>
            </div>
        </div>


        {!! Form::close() !!}
    </div>
@stop