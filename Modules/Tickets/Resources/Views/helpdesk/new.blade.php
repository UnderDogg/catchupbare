@extends('tickets.ticketlayouts.ticketmaster')

@section('Tickets')
class="active"
@stop

@section('ticket-bar')
active
@stop

@section('newticket')
class="active"
@stop

@section('content')
<!-- Main content -->
{!! Form::open(['route'=>'post.newticket','method'=>'post']) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('tickets::lang.create_ticket') !!}</h3>
        <!-- <div class="box-tools pull-right">
            <div class="has-feedback">
                <input type="text" class="form-control input-sm" placeholder="Search Mail"/>
                <span class="glyphicon glyphicon-search form-control-feedback"></span>
            </div>
        </div> --><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
        <!-- user detail -->
        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissable">
                <i class="fa  fa-check-circle"></i>
                <b>Success</b>
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
        @if(Session::has('errors'))
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <b>Alert!</b>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <br/>
                @if($errors->first('email'))
                    <li class="error-message-padding">{!! $errors->first('email', ':message') !!}</li>
                @endif
                @if($errors->first('fullname'))
                    <li class="error-message-padding">{!! $errors->first('fullname', ':message') !!}</li>
                @endif
                @if($errors->first('phone'))
                    <li class="error-message-padding">{!! $errors->first('phone', ':message') !!}</li>
                @endif
                @if($errors->first('subject'))
                    <li class="error-message-padding">{!! $errors->first('subject', ':message') !!}</li>
                @endif
                @if($errors->first('body'))
                    <li class="error-message-padding">{!! $errors->first('body', ':message') !!}</li>
                @endif
            </div>
        @endif
        <div class="form-group">
            <h4><b>{!! Lang::get('tickets::lang.user_details') !!}:<b></h4>
                {{-- <div class="row"> --}}
                    {{-- <div class="col-md-6"> --}}
                            {{-- <div class="has-feedback"> --}}
                            {{-- <input type="text" class="form-control input-ls" placeholder="Search Users"/> --}}
                                {{-- <span class="glyphicon glyphicon-search form-control-feedback"></span> --}}
                            {{-- </div> --}}
                        {{-- <input type="text" name="email" id="" class="form-control" placeholder="Search User"> --}}
                    {{-- </div> --}}
                {{-- </div> --}}
                <br/>
            <div class="row">
                <div class="col-md-4">
                <!-- email -->
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::label('email',Lang::get('tickets::lang.email')) !!}
                        {!! Form::text('email',null,['class' => 'form-control']) !!}
                    </div>
                </div>
           
                <div class="col-md-4">
                <!-- full name -->
                    <div class="form-group {{ $errors->has('fullname') ? 'has-error' : '' }}">
                        {!! Form::label('fullname',Lang::get('tickets::lang.full_name')) !!}
                        {!! Form::text('fullname',null,['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                <!-- phone -->
                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                        <label>{!! Lang::get('tickets::lang.phone') !!}:</label>
                        {!! Form::input('number','phone',null,['class' => 'form-control']) !!}
                        {!! $errors->first('phone', '<span class="help-block text-red">:message</span>') !!}
                    </div>
                </div>
                <!--  <div class="form-group">
                     <div class="col-md-2">
                         <label>Ticket Notice:</label>
                     </div>
                     <div class="col-md-6">
                         <input type="checkbox" name="notice" id=""> Send alert to User
                     </div>
                 </div> -->
            </div>
        </div>
            <!-- ticket options -->
            <div class="form-group">
                <h4><b>{!! Lang::get('tickets::lang.ticket_option') !!}<b></h4>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>{!! Lang::get('tickets::lang.help_topic') !!}:</label>
                            <!-- helptopic -->
                                <?php $helptopic = Modules\Tickets\Models\TicketHelpTopic::all();?>
                                    {!! Form::select('helptopic', ['Helptopic'=>$helptopic->lists('topic','id')],null,['class' => 'form-control select']) !!}
                                        {!! $errors->first('helptopic', '<span class="help-block text-red">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                <!-- sla plan -->
                                    <div class="form-group">
                                        <label>{!! Lang::get('tickets::lang.sla_plan') !!}:</label>
                                        <?php $sla_plan = Modules\Tickets\Models\SlaPlan::all();?>
                                        {!! Form::select('sla', ['SLA'=>$sla_plan->lists('grace_period','id')],null,['class' => 'form-control select']) !!}
                                        {!! $errors->first('sla', '<span class="help-block text-red">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                <!-- due date -->
                                    <div class="form-group">
                                        <label>{!! Lang::get('tickets::lang.due_date') !!}:</label>
                                        {{-- <input type="text" class="form-control" name="duedate" id="datemask"> --}}
                                        {!! Form::text('duedate',null,['class' => 'form-control','id'=>'datemask']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                <!-- assign to -->
                                    <div class="form-group">
                                        <label>{!! Lang::get('tickets::lang.assign_to') !!}:</label>
                                            <?php $agents = Modules\Core\Models\Staff::where('role','!=','user')->get();?>

                                            {!! Form::select('assignto', [''=>'Select an Agent','Agents'=>$agents->lists('first_name','id')],null,['class' => 'form-control select']) !!}
                                    </div>
                                </div>
                            </div>
                            </div>
                                <!-- ticket details -->
                                <div class="form-group">
                                    <h4><b>{!! Lang::get('tickets::lang.ticket_detail') !!}<b></h4>
                                        <!-- subject -->
                                                <div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label>{!! Lang::get('tickets::lang.subject') !!}:</label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            {!! Form::text('subject',null,['class' => 'form-control']) !!}
                                                         
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                                                <!-- details -->
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label>{!! Lang::get('tickets::lang.detail') !!}:</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            {!! Form::textarea('body',null,['class' => 'form-control','id' => 'body', 'style'=>"width:100%; height:150px;"]) !!}
                                                          
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                <!-- priority -->
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label>{!! Lang::get('tickets::lang.priority') !!}:</label>
                                                        </div>
                                                        <div class="col-md-3">
                                                        <?php $Priority = Modules\Core\Models\Ticket\Ticket_Priority::all();?>
                                                            {!! Form::select('priority', ['Priority'=>$Priority->lists('priority_desc','priority_id')],null,['class' => 'form-control select']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="box-footer">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-1">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="submit" value="{!! Lang::get('tickets::lang.create_ticket') !!}" class="btn btn-primary">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /. box -->
                                {!! Form::close() !!}

                                <script type="text/javascript">

                                    $(function () {
                                        $("textarea").wysihtml5();
                                    });

                                    $(function() {
                                        $('#datemask').datepicker({changeMonth: true, changeYear: true}).mask('99/99/9999');
                                    });

                                </script>

                            @stop

                            
                            
                            
