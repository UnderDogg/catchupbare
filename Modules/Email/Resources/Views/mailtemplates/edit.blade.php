@extends('email::maillayouts.mailmaster')

@section('MailTemplates')
    active
@stop

@section('templates-bar')
    active
@stop

@section('mailtemplates')
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

    {!! Form::model($templates,['url' => 'mailpanel/mailtemplates/'.$templates->id,'method' => 'PATCH']) !!}

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="box-header">
                        <h2 class="box-title">{{Lang::get('email::lang.edit')}}</h2>
                        <div class="pull-right">
                            {!! Form::submit(Lang::get('email::lang.save'),['class'=>'btn btn-primary'])!!}</div>
                    </div>

                    <div class="box-body table-responsive" style="overflow:hidden">
                        <div class="row">

                            <!--  Status : Type and Set : Required -->
                            <div class="col-md-6">
                                <div class="col-xs-3 form-group {{ $errors->has('set_id') ? 'has-error' : '' }}" id="mailtemplate_set">
                                    {!! Form::label('mailtemplate Set',Lang::get('email::lang.templateset')) !!}
                                    {!!Form::select('type_id',$templatesets,0,['class' => 'form-control select', 'id' => 'mailtemplate_set_id']) !!}
                                </div>
                                <div class="col-xs-3 form-group {{ $errors->has('type_id') ? 'has-error' : '' }}" id="mailtemplate_type">
                                    {!! Form::label('mailtemplate Type',Lang::get('email::lang.templatetype')) !!}
                                    {!!Form::select('type_id',$templatetypes,0,['class' => 'form-control select', 'id' => 'mailtemplate_type_id']) !!}
                                </div>
                            </div>



                            <!--  Status : Radio form : Required -->
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
                                    <div class="row col-xs-3">
                                        {!! Form::label('status',Lang::get('email::lang.status')) !!}
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3">
                                            {!! Form::radio('template_status','active',true) !!}{{Lang::get('email::lang.active')}}
                                        </div>
                                        <div class="col-xs-3">
                                            {!! Form::radio('template_status','disabled') !!}{{Lang::get('email::lang.disabled')}}
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- Name : Text form : Required -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    {!! Form::label('name',Lang::get('email::lang.name')) !!}
                                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                    {!! Form::text('name',null,['disabled'=>'disabled','class' => 'form-control']) !!}
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
                                    {!! Form::label('subject',Lang::get('email::lang.subject')) !!}
                                    {!! $errors->first('subject', '<span class="help-block">:message</span>') !!}
                                    {!! Form::text('subject',null,['class' => 'form-control']) !!}
                                </div>
                            </div>



{{--
'type_id', 'set_id' --}}


                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('message',Lang::get('email::lang.message')) !!}
                                    {!! Form::textarea('message',null,['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


@stop
