@extends('themes.default1.admin.layout.admin')

@section('Settings')
active
@stop

@section('status')
class="active"
@stop

@section('PageHeader')
<h1>{!! Lang::get('lang.settings') !!}</h1>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.list_of_status') !!}</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-toggle="modal" data-target="#2create" id="create" title="{!! Lang::get('lang.create') !!}"><i class="fa fa-plus-circle fa-2x"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">

        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        @if(Session::has('failed'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!} !</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>{{Session::get('failed')}}</p>                
        </div>
        @endif
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{!! Lang::get('lang.name') !!}</th>
                    <th>{!! Lang::get('lang.display_order') !!}</th>
                    <th>{!! Lang::get('lang.action') !!}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statuss as $status)
                <?php if ($status->name == 'Deleted') continue; ?>
                <tr>
                    <td>{!! $status->name !!}</td>
                    <td>{!! $status->sort !!}</td>
                    <td>
                        <a href="{!! route('status.edit',$status->id) !!}"><button class="btn btn-info btn-sm">{!! Lang::get('lang.edit_details') !!}</button></a>
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#{{$status->id}}delete">{!! Lang::get('lang.delete') !!}</button>
                        <div class="modal fade" id="{{$status->id}}delete">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">{!! Lang::get('lang.delete') !!}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>{!! Lang::get('lang.are_you_sure_you_want_to_delete') !!} ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                        {!! link_to_route('statuss.delete',Lang::get('lang.delete'),[$status->id],['id'=>'delete','class'=>'btn btn-danger btn-sm']) !!}
                                    </div>
                                </div> 
                            </div>
                        </div> 
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div><!-- /.box-body -->
</div>

<!-- create modal -->
<div class="modal fade" id="2create">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['route'=>'statuss.create']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{!! Lang::get('lang.create') !!}</h4>
            </div>
            <div class="modal-body">
                @if(Session::has('errors'))
                <script type="text/javascript">
                    $(document).ready(function() {
                        $("#create").click();
                    });
                </script>
                <div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>{!! Lang::get('lang.alert') !!}!</b>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <br/>
                    @foreach ($errors->all() as $error)
                    <li class="error-message-padding">{{ $error }}</li>
                    @endforeach 
                </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="title">{!! Lang::get('lang.name') !!}: <span class="text-red"> *</span></label><br>
                            {!! Form::text('name',null,['class'=>'form-control'])!!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('sort') ? 'has-error' : '' }}">
                            <label for="title">{!! Lang::get('lang.display_order') !!}: <span class="text-red"> *</span></label><br>
                            {!! Form::text('sort',null,['class'=>'form-control'])!!}
                        </div>  
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('icon_class') ? 'has-error' : '' }}">
                            <label for="title">{!! Lang::get('lang.icon_class') !!}: <span class="text-red"> *</span></label><br>
                            {!! Form::text('icon_class',null,['class'=>'form-control'])!!}
                        </div> 
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('gender',Lang::get('lang.resolved_status')) !!}
                    <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.status_msg3') !!}</div>
                    <div class="row">
                        <div class="col-xs-3">
                            {!! Form::radio('state','closed') !!} {{Lang::get('lang.yes')}}
                        </div>
                        <div class="col-xs-3">
                            {!! Form::radio('state','open') !!} {{Lang::get('lang.no')}}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('gender',Lang::get('lang.deleted_status')) !!}
                    <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.status_msg2') !!}</div>
                    <div class="row">
                        <div class="col-xs-3">
                            {!! Form::radio('delete','yes') !!} {{Lang::get('lang.yes')}}
                        </div>
                        <div class="col-xs-3">
                            {!! Form::radio('delete','no') !!} {{Lang::get('lang.no')}}
                        </div>
                    </div>        
                </div>
                <div class="form-group">
                    {!! Form::label('gender',Lang::get('lang.notify_user')) !!}
                    <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.status_msg1') !!}</div>
                    <div class="row">
                        <div class="col-xs-3">
                            {!! Form::radio('email_user','yes') !!} {{Lang::get('lang.yes')}}
                        </div>
                        <div class="col-xs-3">
                            {!! Form::radio('email_user','no') !!} {{Lang::get('lang.no')}}
                        </div>
                    </div>        
                </div>
            </div>
            <div class="modal-footer">
                {!! Form::submit(Lang::get('lang.create_status'),['class'=>'btn btn-primary'])!!}
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{!! Lang::get('lang.close') !!}</button>
            </div>
            {!! Form::close() !!}
        </div> 
    </div>
</div>
@stop