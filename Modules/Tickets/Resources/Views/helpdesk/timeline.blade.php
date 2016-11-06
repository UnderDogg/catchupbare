@extends('tickets.ticketlayouts.ticketmaster')

@section('Tickets')
class="active"
@stop

@section('ticket-bar')
active
@stop

<?php
    $user = Modules\Core\Models\Staff::where('id', '=', $tickets->user_id)->first();
    $assignedto = Modules\Core\Models\Staff::where('id', '=', $tickets->assigned_to)->first();
    $agent_group = Auth::guard('staff')->user()->assign_group;
    $group = Modules\Core\Models\Agent\Groups::where('id', '=', $agent_group)->where('group_status', '=', '1')->first();
?>

@section('sidebar')

<li class="header">{!! Lang::get('tickets::lang.Ticket_Information') !!} </li>
<li>
    <a href="">
        <span>{!! Lang::get('tickets::lang.Ticket_Id') !!} </span>
        </br><b>#{{$tickets->ticket_number}}</b>
    </a>
</li>
<li>
    <a href="{!! URL('user/'.$user->id) !!}">
        <span>{!! Lang::get('tickets::lang.User') !!} </span>
        </br><i class="fa fa-user"></i> <b>{{$user->user_name}}</b>
    </a>
</li>
<li >
        @if($tickets->assigned_to > 0)
        <a href="{!! URL('user/'.$tickets->assigned_to) !!}">
        <span>{!! Lang::get('tickets::lang.Assigned_To') !!} </span>
        </br> {{$assignedto->first_name}}
        </a>
        @else
        <a href="">
        <span>{!! Lang::get('tickets::lang.Unassigned') !!} </span>
        </a>
        @endif
</li>

<li  class="header">
    {!! Lang::get('tickets::lang.ticket_ratings') !!}
</li>
<li> 
    <a href="#">
        Overall Rating:
        <small class="pull-right">
            <input type="radio" class="star" id="star5" name="rating" value="1"<?php echo ($tickets->rating=='1')?'checked':'' ?> />
            <input type="radio" class="star" id="star4" name="rating" value="2"<?php echo ($tickets->rating=='2')?'checked':'' ?> />
            <input type="radio" class="star" id="star3" name="rating" value="3"<?php echo ($tickets->rating=='3')?'checked':'' ?>/>
            <input type="radio" class="star" id="star2" name="rating" value="4"<?php echo ($tickets->rating=='4')?'checked':'' ?>/>
            <input type="radio" class="star" id="star1" name="rating" value="5"<?php echo ($tickets->rating=='5')?'checked':'' ?> />
        </small>
    </a>
</li>
<li>
    <a href="">Reply Rating:
        <small class="pull-right">
            
            <input type="radio" class="star" id="star5" name="rating2" value="1"<?php echo ($avg_rating=='1')?'checked':'' ?>  />
            <input type="radio" class="star" id="star4" name="rating2" value="2"<?php echo ($avg_rating=='2')?'checked':'' ?>  />
            <input type="radio" class="star" id="star3" name="rating2" value="3"<?php echo ($avg_rating=='3')?'checked':'' ?>  />
            <input type="radio" class="star" id="star2" name="rating2" value="4"<?php echo ($avg_rating=='4')?'checked':'' ?>  />
            <input type="radio" class="star" id="star1" name="rating2" value="5"<?php echo ($avg_rating=='5')?'checked':'' ?>  />
        </small>
    </a>
</li>
@stop 

@section('content')
<!-- Main content -->
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title" id="refresh2"><i class="fa fa-user"> </i> @if($thread->title){!! $thread->title !!} @endif</h3>
        <div class="pull-right">
            <!-- <button type="button" class="btn btn-default"><i class="fa fa-edit" style="color:green;"> </i> Edit</button> -->
<?php
            Event::fire(new \App\Events\TicketBoxHeader($user->id));

            if ($group->can_edit_ticket == 1) {?>
            <button type="button" class="btn btn-default" id="Edit_Ticket" data-toggle="modal" data-target="#Edit"><i class="fa fa-edit" style="color:green;"> </i> {!! Lang::get('tickets::lang.edit') !!}</button>
            <?php } ?>

            <?php if ($group->can_assign_ticket == 1) {?>
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#{{$tickets->id}}assign"><i class="fa fa-hand-o-right" style="color:orange;"> </i> {!! Lang::get('tickets::lang.assign') !!}</button>
            <?php } ?>

            @if($tickets->assigned_to == Auth::guard('staff')->user()->id)
            <button type="button" id="surrender_button" class="btn btn-default" data-toggle="modal" data-target="#surrender"> <i class="fa fa-arrows-alt" style="color:red;"> </i>  {!! Lang::get('tickets::lang.surrender') !!}</button>
            @endif

            <a href="{{url('ticket/print/'.$tickets->id)}}" target="_blank" class="btn btn-primary"><i class="fa fa-print" > </i> {!! Lang::get('tickets::lang.generate_pdf') !!}</a>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="d1"><i class="fa fa-exchange" style="color:teal;" id="hidespin"> </i><i class="fa fa-spinner fa-spin" style="color:teal; display:none;" id="spin"></i>
                    {!! Lang::get('tickets::lang.change_status') !!} <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li id="open"><a href="#"><i class="fa fa-folder-open-o" style="color:red;"> </i>{!! Lang::get('tickets::lang.open') !!}</a></li>
                    <?php if ($group->can_edit_ticket == 1) {?>
                    <li id="close"><a href="#"><i class="fa fa-check" style="color:green;"> </i>{!! Lang::get('tickets::lang.close') !!}</a></li>
                    <?php } ?>
                    <li id="resolved"><a href="#"><i class="fa fa-check-circle-o " style="color:green;"> </i>{!! Lang::get('tickets::lang.resolved') !!} </a></li>
                </ul>
            </div>
            <?php if ($group->can_delete_ticket == 1 || $group->can_ban_email == 1) {?>
            <div id="more-option" class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="d2"><i class="fa fa-cogs" style="color:teal;"> </i>
                    {!! Lang::get('tickets::lang.more') !!} <span class="caret"></span>
                </button>
                <ul  class="dropdown-menu pull-right">
                    <li data-toggle="modal" data-target="#ChangeOwner"><a href="#"><i class="fa fa-users" style="color:green;"> </i>Change Owner</a></li>
                    @if($tickets->status != 3 && $tickets->status != 2)
                     <li data-toggle="modal" data-target="#MergeTickets"><a href="#"><i class="fa fa-code-fork" style="color:teal;"> </i>{!! Lang::get('tickets::lang.merge-ticket') !!}</a></li>
                     @endif
                    <?php if ($group->can_delete_ticket == 1) {?>
                    <li id="delete"><a href="#"><i class="fa fa-trash-o" style="color:red;"> </i>{!! Lang::get('tickets::lang.delete_ticket') !!}</a></li>
                    <?php }
    ?>
                    <?php if ($group->can_ban_email == 1) {?>
                    <li data-toggle="modal" data-target="#banemail"><a href="#"><i class="fa fa-ban" style="color:red;"></i>{!! Lang::get('tickets::lang.ban_email') !!}</a></li>
                    <?php }
    ?>          </ul>
            </div>
            <?php }
?>
        </div>
    </div>
    <!-- ticket details Table -->
    <div class="box-body">
    <div id="alert11" class="alert alert-success alert-dismissable" style="display:none;">
        <button id="dismiss11" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i>Alert!</h4>
        <div id="message-success1"></div>
    </div>
    <div id="alert12" class="alert alert-warning alert-dismissable" style="display:none;">
        <button id="dismiss12" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i>Alert!</h4>
        <div id="message-warning1"></div>
    </div>
    <div id="alert13" class="alert alert-danger alert-dismissable" style="display:none;">
        <button id="dismiss13" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i>Alert!</h4>
        <div id="message-danger1"></div>
    </div>
        <div class="row">
            <section class="content"  >
                <div class="col-md-12">
                    <?php
$priority = Modules\Core\Models\Ticket\Ticket_Priority::where('priority_id', '=', $tickets->priority_id)->first();
?>
                    <div class="callout callout-{{$priority->priority_color}}">
                        <div class="row">
                            <div class="col-md-3">
                                <?php
$sla = $tickets->sla;
$SlaPlan = Modules\Tickets\Models\SlaPlan::where('id', '=', $sla)->first();
?>
                                <b>{!! Lang::get('tickets::lang.sla_plan') !!}: {{$SlaPlan->grace_period}} </b>
                            </div>
                            <div class="col-md-3">
                                <b>{!! Lang::get('tickets::lang.created_date') !!}: </b> {{ UTC::usertimezone($tickets->created_at) }}
                            </div>
                            <div class="col-md-3">
                                <b>{!! Lang::get('tickets::lang.due_date') !!}: </b>
                                <?php
$time = $tickets->created_at;
$time = date_create($time);
date_add($time, date_interval_create_from_date_string($SlaPlan->grace_period));
echo UTC::usertimezone(date_format($time, 'Y-m-d H:i:s'));
?>
                            </div>
                            <div class="col-md-3">
                                <?php $response = Modules\Core\Models\Ticket\Ticket_Thread::where('ticket_id', '=', $tickets->id)->get();?>
                                @foreach($response as $last)
                                <?php $ResponseDate = $last->created_at;?>
                                @endforeach
                                <b>{!! Lang::get('tickets::lang.last_response') !!}: </b> {{ UTC::usertimezone($ResponseDate) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div id="show2" style="display:none;">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                            <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"><br/><br/><br/>
                        </div>
                </div>
                <div id="hide2">
                <div class="col-md-6">
                    <table class="table table-hover">
                        <div id="refresh">
                            <tr><td><b>{!! Lang::get('tickets::lang.status') !!}:</b></td>       <?php $status = Modules\Core\Models\Ticket\Ticket_Status::where('id', '=', $tickets->status)->first();?><td title="{{$status->properties}}">{{$status->name}}</td></tr>
                            <tr><td><b>{!! Lang::get('tickets::lang.priority') !!}:</b></td>     <?php $priority = Modules\Core\Models\Ticket\Ticket_Priority::where('priority_id', '=', $tickets->priority_id)->first();?><td title="{{$priority->priority_desc}}">{{$priority->priority_desc}}</td></tr>
                            <tr><td><b>{!! Lang::get('tickets::lang.department') !!}:</b></td>   <?php $dept123 = Modules\Core\Models\Department::where('id', '=', $tickets->dept_id)->first();?><td title="{{$dept123->name}}">{{$dept123->name}}</td></tr>
                            <tr><td><b>{!! Lang::get('tickets::lang.email') !!}:</b></td>        <td>{{$user->email}}</td></tr>
                            @if($user->ban > 0)  <tr><td style="color:orange;"><i class="fa fa-warning"></i><b>
                            {!!  Lang::get('tickets::lang.this_ticket_is_under_banned_user')!!}</td><td></td></tr>@endif
                        </div>
                    </table>
                </div>
                <div class="col-md-6">
<?php 
    $user_phone = Modules\Core\Models\Staff::where('mobile','=',$thread->user_id)->first();
    $TicketData = Modules\Core\Models\Ticket\Ticket_Thread::where('ticket_id', '=', $thread->ticket_id)->max('id');
                        $TicketDatarow = Modules\Core\Models\Ticket\Ticket_Thread::where('id', '=', $TicketData)->first();
                        $LastResponse = Modules\Core\Models\Staff::where('id', '=', $TicketDatarow->user_id)->first();
                        if($LastResponse->role == "user") {
                            $rep = "#F39C12";
                            $username = $LastResponse->user_name;
                            } else { $rep = "#000"; $username = $LastResponse->first_name ." ". $LastResponse->last_name; 
                            if($LastResponse->first_name==null || $LastResponse->last_name==null) {
                                $username = $LastResponse->user_name;
                            }}   
                        if($tickets->source > 0)
                        {
                            $ticket_source = Modules\Core\Models\Ticket\Ticket_source::where('id','=',$tickets->source)->first();
                            $ticket_source = $ticket_source->value;
                        }   
                        else
                            $ticket_source = $tickets->source;
?>
                    <table class="table table-hover">
                        <div id="refresh3">

                            @if($user->phone_number !=null)<tr><td><b>Phone:</b></td>          <td>{{$user->phone_number}}</td></tr>@endif
                            @if($user->mobile !=null)<tr><td><b>Phone:</b></td>          <td>{{$user->ext . $user->phone_number}}</td></tr>@endif
                            <tr><td><b>{!! Lang::get('tickets::lang.source') !!}:</b></td>         <td>{{$ticket_source}}</td></tr>
                            <tr><td><b>{!! Lang::get('tickets::lang.help_topic') !!}:</b></td>     <?php $help_topic = Modules\Tickets\Models\TicketHelpTopic::where('id', '=', $tickets->help_topic_id)->first();?><td title="{{$help_topic->topic}}">{{$help_topic->topic}}</td></tr>
                            <?php Event::fire(new App\Events\TicketDetailTable($TicketData)); ?>
                            <tr><td><b>{!! Lang::get('tickets::lang.last_message') !!}:</b></td>   <td>{{$username}}</td></tr>
                            <?php Event::fire(new App\Events\TicketDetailTable($TicketData)); ?>
                        </div>
                    </table>
                </div>
                </div>
            </section>
        </div>
    </div>
</div>
{{-- Event fire --}}
<div id="resultdiv">
</div>

<div class='row'>
    <div class='col-xs-12'>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#General" data-toggle="tab" style="color:#27C116;" id="aa"><i class="fa fa-reply-all"> </i> {!! Lang::get('tickets::lang.reply') !!}</a></li>
                <li><a href="#Internal" data-toggle="tab" style="color:#0495FF;" id="bb"><i class="fa fa-file-text"> </i> {!! Lang::get('tickets::lang.internal_notes') !!}</a></li>
                <!-- <li><a href="#Reply" data-toggle="tab" style="color:orange;"><i class="fa fa-mail-forward" > </i> Forward</a></li> -->
            </ul>
            <div class="tab-content">
                <div id="alert21" class="alert alert-success alert-dismissable" style="display:none;">
                    <button id="dismiss21" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i>Alert!</h4>
                    <div id="message-success2"></div>
                </div>
                <div id="alert22" class="alert alert-warning alert-dismissable" style="display:none;">
                    <h4><i class="icon fa fa-warning"></i>Alert!</h4>
                    <div id="message-warning2"></div>
                </div>
                <div id="alert23" class="alert alert-danger alert-dismissable" style="display:none;">
                    <button id="dismiss23" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i>Alert!</h4>
                    <div id="message-danger2"></div>
                </div>
                <div class="tab-pane active" id="General">
                   
                    <!-- ticket reply -->
                    <div id="show3" style="display:none;">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                            <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"><br/><br/><br/>
                        </div>
                        </br>
                        </br>
                        </br>
                        </br>
                        </br>
                        </br>
                        </br>
                        </br>
                    </div>
                    {!! Form::model($tickets->id, ['id'=>'form3', 'name'=>'form3' ,'method' => 'PATCH', 'enctype'=>'multipart/form-data'] )!!}
                    <div id="t1">
                        <div class="form-group">
                            <div class="row">
                            <!-- to -->
                                <input type="hidden" name="ticket_ID" value="{{$tickets->id}}">
                                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                    <div class="col-md-2">
                                        {!! Form::label('To', Lang::get('tickets::lang.to').':') !!}
                                    </div>
                                    <div class="col-md-10">
                                        <div id="refreshTo">
                                            {!! Form::text('To',$user->email,['disabled'=>'disabled','id'=>'email','class'=>'form-control','style'=>'width:55%'])!!}
                                            {!! $errors->first('To', '<span class="help-block text-red">:message</span>') !!}
                                            <a href="#" data-toggle="modal" data-target="#addccc"> {!! Lang::get('tickets::lang.add_cc') !!} </a>
                                            <div id="recepients">
                                            <?php $Collaborator =  Modules\Core\Models\Ticket\Ticket_Collaborator::where('ticket_id', '=', $tickets->id)->get();
                                            $count_collaborator = count($Collaborator);?>
                                            @if($count_collaborator > 0)
                                                <a href="#" data-toggle="modal" data-target="#surrender2">({!! $count_collaborator !!}) {!! Lang::get('tickets::lang.recepients') !!} </a>
                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php Event::fire(new App\Events\TimeLineFormEvent($TicketData)); ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{!! Lang::get('tickets::lang.response') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    <select class="form-control" style="width:55%" id="select">
                                        
<?php 
$canneds = Modules\Email\Models\CannedResponse::where('user_id','=',Auth::guard('staff')->user()->id)->get();
?>                                                  
                                        <option value="zzz">{!! Lang::get('tickets::lang.select_a_canned_response') !!}</option>
                                        @foreach($canneds as $canned)
                                            <option value="{!! $canned->id !!}" >{!! $canned->title !!}</option>
                                        @endforeach
                                        {{-- <option>Last Message</option> --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                            <!-- reply content -->
                                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                    <div class="col-md-2">
                                        {!! Form::label('Reply Content', Lang::get('tickets::lang.reply_content').':') !!}
                                    </div>
                                    <div class="col-md-10">
                                        <div id="newtextarea">
                                            <textarea style="width:98%;height:20%;" name="reply_content" class="form-control" id="reply_content"></textarea>
                                        </div>
                                        {!! $errors->first('reply_content', '<span class="help-block text-red">:message</span>') !!}
                                        <br/>
                                        <div type="file" class="btn btn-default btn-file"><i class="fa fa-paperclip"> </i> {!! Lang::get('tickets::lang.attachment') !!}<input type="file" name="attachment[]" multiple/></div><br/>
                                        {!! Lang::get('tickets::lang.max') !!}. 10MB
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10">
                                        <div id="t5">
                                            <button id="replybtn" type="submit" class="btn btn-primary"><i class="fa fa-check-square-o" style="color:white;"> </i> {!! Lang::get('tickets::lang.update') !!}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!!Form::close()!!}
                    
                </div>
                <div class="tab-pane" id="Internal">
                <!-- ticket reply -->
                    <div id="show5" style="display:none;">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                            <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"><br/><br/><br/>
                        </div>
                        </br>
                        </br>
                        </br>
                        </br>
                        </br>
                        </br>
                        </br>
                        </br>
                    </div>
                    <div id="t2">
                        {!! Form::model($tickets->id, ['id'=>'form2','method' => 'PATCH'] )!!}
                        <div id="t4">
                            <div class="form-group">
                                <div class="row">
                                <!-- internal note -->
                                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                        <div class="col-md-2">
                                            <label>{!! Lang::get('tickets::lang.internal_note') !!}:</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div id="newtextarea1">
                                                <textarea class="form-control" name="InternalContent" id="InternalContent" style="width:98%; height:150px;"></textarea>
                                            </div>
                                            {!! $errors->first('InternalContent', '<span class="help-block text-red">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-10">
                                            <button type="submit"  class="btn btn-primary"><i class="fa fa-check-square-o" style="color:white;"> </i> {!! Lang::get('tickets::lang.update') !!}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!!Form::close()!!}
                    </div>
                </div>
                <!-- ticket foreward
                <div class="tab-pane" id="Reply" >
                    <div class="form-group">
                        <button type="button" class="btn btn-default"><i class="fa fa-mail-forward" style="color:green;"> </i> Send</button>
                        <button type="button" class="btn btn-default"><i class="fa fa-th-large" style="color:teal;"> </i> Option</button>
                        <button type="button" class="btn btn-default"><i class="fa fa-file-text" style="color:blue;"> </i> Internal Notes</button>
                    </div>
                    <form>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>From</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="from" id="from" style="width:40%" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>To</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="to" id="to" style="width:55%" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Subject</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="from" id="from" style="width:100%" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Response</label>
                                </div>
                                <div class="col-md-10">
                                    <select class="form-control" style="width:55%" >
                                        <option>Select a canned response</option>
                                        <option>Original Message</option>
                                        <option>Last Message</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Reply Content</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea id="txtEditor2"> </textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div> -->
            </div>
        </div>
        <!-- ticket  conversations -->
<?php
$conversations = Modules\Core\Models\Ticket\Ticket_Thread::where('ticket_id', '=', $tickets->id)->orderBy('id', 'DESC')->paginate(10);
$ij = Modules\Core\Models\Ticket\Ticket_Thread::where('ticket_id', '=', $tickets->id)->first();

?>

        <!-- row -->
        <div class="row" >

            <div id="refresh1">
            <style type="text/css">
            .pagination{
                margin-bottom: -20px;
                margin-top: 0px;
            }
            </style>
                <ul class="pull-right" style="padding-right:40px" >
                    <?php echo $conversations->setPath(url('/thread/' . $tickets->id))->render();?>
                </ul>

                <div class="col-md-12" >
                    <!-- The time line -->
                    <ul class="timeline">
                        <!-- timeline time label -->
<?php
// $ij = 0;
foreach ($conversations as $conversation) {
// $ij++;
    if($conversation == null){}else{
    ?>
                            <li class="time-label">
                                <?php
$ConvDate1 = $conversation->created_at;
    $ConvDate = explode(' ', $ConvDate1);

    $date = $ConvDate[0];
    $time = $ConvDate[1];
    $time = substr($time, 0, -3);
    if (isset($data) && $date == $data) {

    } else {
        ?> <span class="bg-green">
                                        {{date_format($conversation->created_at, 'd/m/Y')}}
                                    </span> <?php
$data = $ConvDate[0];
    }
    $role = Modules\Core\Models\Staff::where('id','=',$conversation->user_id)->first();
    ?>
                            </li>
                            <li>
                                <?php if($conversation->is_internal) { ?>
                                <i class="fa fa-tag bg-purple" title="Posted by System"></i>
                                    <?php }else{ if ($role->role == 'agent' || $role->role == 'admin') { ?>
                                    <i class="fa fa-mail-reply-all bg-yellow" title="Posted by Support Team"></i>
                                <?php } elseif ($role->role == 'user') {  ?>
                                    <i class="fa fa-user bg-aqua" title="Posted by Customer"></i>
                                <?php } else { ?>
                                    <i class="fa fa-mail-reply-all bg-purple" title="Posted by System"></i>
    <?php } }
    $attachment = Modules\Core\Models\Ticket\Ticket_attachments::where('thread_id','=',$conversation->id)->first();
    if($attachment == null ) {
        $body = $conversation->body;
    } else {
        // dd($attachment->file);
        // print $attachment->file;
        // header("Content-type: image/jpeg");
        // echo "<img src='".base64_decode($attachment->file)."' style='width:128px;height:128px'/> ";
        $body = $conversation->body;
        $attachments = Modules\Core\Models\Ticket\Ticket_attachments::where('thread_id','=',$conversation->id)->orderBy('id', 'DESC')->get();
        // $i = 0;
                    foreach($attachments as $attachment)
                    {
                        // $i++;
                        if($attachment->type == 'jpg'|| $attachment->type == 'png')
                        {
                        $image = @imagecreatefromstring($attachment->file); 
                        ob_start();
                        imagejpeg($image, null, 80);
                        $data = ob_get_contents();
                        ob_end_clean();
                        $var  =  '<img style="max-width:200px;max-height:200px;" src="data:image/'.$attachment->type.';base64,' .  base64_encode($data)  . '" />';
                        // echo $var;
                        // echo $attachment->name;
                        // $body = explode($attachment->name, $body);
                        $body = str_replace($attachment->name, "data:image/".$attachment->type.";base64," .  base64_encode($data), $body);

                            $string = $body;                        
                            $start = "<head>";
                            $end = "</head>";
                            if(strpos($string,$start) == false || strpos($string,$start) == false)
                            {
                            }
                            else
                            {
                            $ini = strpos($string,$start);
                            $ini += strlen($start);
                            $len = strpos($string,$end,$ini) - $ini;
                            $parsed = substr($string,$ini,$len);
                            $body2 = $parsed;
                            $body = str_replace($body2 ," " ,$body);
                            }
                        } else{}

                    }
                    // echo $body;

        // $body = explode($attachment->file, $body);
        // $body = $body[0];
    }
                            $string = $body;                        
                            $start = "<head>";
                            $end = "</head>";                            
                            if(strpos($string,$start) == false || strpos($string,$start) == false) {
                            } else {
                            $ini = strpos($string,$start);
                            $ini += strlen($start);
                            $len = strpos($string,$end,$ini) - $ini;
                            $parsed = substr($string,$ini,$len);
                            $body2 = $parsed;
                            $body = str_replace($body2 ," " ,$body);
                            }
                                    if($conversation->is_internal) {
                                        $color = '#A19CFF'; 
                                       // echo $color; 
                                    } else {
                                    if ($role->role == 'agent' || $role->role == 'admin') { 
                                            $color = '#F9B03B';
                                        } elseif ($role->role == 'user') { 
                                            $color = '#38D8FF';
                                        } else { 
                                            $color = '#605CA8';
                                        } 
                                    }
    ?>
                                <div class="timeline-item">
                                    <span id="date" class="time"  style="color:#fff;"><i class="fa fa-clock-o"> </i> {{UTC::usertimezone($conversation->created_at)}}</span>
                                    <h3 class="timeline-header">
                                    <?php if($role->role == "user") {
                                        $usernam = $role->user_name; 
                                            } else { 
                                        $usernam = $role->first_name . " " . $role->last_name;
                                            } ?>

                                    <div class="user-block" style="margin-bottom:-5px;margin-top:-2px;">
                                       
                                            @if($role->profile_pic != null)
                                                <img src="{{$role->profile_pic}}"class="img-circle img-bordered-sm" alt="User Image"/>
                                            @else
                                                <img src="{{ Gravatar::src($role->email) }}" class="img-circle img-bordered-sm" alt="img-circle img-bordered-sm">
                                            @endif

                                        <span class="username"  style="margin-bottom:4px;margin-top:2px;">
                                          <a href='{!! url("/user/".$role->id) !!}'>{!! $usernam !!}</a>
                                          
                                        </span>
                                        <span class="description" style="margin-bottom:4px;margin-top:4px;"><i class="fa fa-clock-o"></i> {{UTC::usertimezone($conversation->created_at)}}</span>
                                      </div><!-- /.user-block -->
                                        
                                    </h3>
                                    <div class="timeline-body" style="padding-left:30px;margin-bottom:-20px">
                                            {!! $body !!}
                                    </div>
                                    @if($conversation->id == $ij->id)
                                    <?php  $ticket_form_datas = Modules\Core\Models\Ticket\Ticket_Form_Data::where('ticket_id', '=', $tickets->id)->get();  ?>
                                        @if(isset($ticket_form_datas))
                                                    <div class="box-body col-md-9">
                                                    <br/>
                                                        <table class="table table-bordered table-striped table-hover">
                                                        <tbody>
                                                        @foreach($ticket_form_datas as $ticket_form_data)
                                                            <tr>
                                                                <td style="width: 30%">{!! $ticket_form_data->title !!}</td>
                                                                <td>{!! $ticket_form_data->content !!}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody></table>
                                                    </div>
                                        @endif
                                    @endif
                                    <br/><br/>
                                    <div class="timeline-footer" style="margin-bottom:-5px">
                                    @if(!$conversation->is_internal)
                                    <?php Event::fire(new App\Events\Timeline($conversation,$role,$user)); ?>
                                    @endif
                                        <?php 
                                        $attachments = Modules\Core\Models\Ticket\Ticket_attachments::where('thread_id','=',$conversation->id)->get();
                                        $i = 0;
                                        foreach($attachments as $attachment) {
                                        if($attachment->poster == 'ATTACHMENT') {
                                            $i++;
                                            } 
                                        }
                                        if($i>0)
                                        {
                                        echo "<hr style='border-top: 1px dotted #FFFFFF;margin-top:0px;margin-bottom:0px;background-color:#8B8C90;'><h4 class='box-title'><b>".$i." </b> Attachments</h4>";
                                        }
                                        ?>
                                        <ul class='mailbox-attachments clearfix'>
                                        <?php
                                        foreach($attachments as $attachment)
                                        {

    $size = $attachment->size;
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    $value = number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];

                                            
                                            if($attachment->poster == 'ATTACHMENT')
                                            {
                                                if($attachment->type == 'jpg'||$attachment->type == 'JPG'||$attachment->type == 'jpeg'||$attachment->type == 'JPEG'||$attachment->type == 'png'||$attachment->type == 'PNG'||$attachment->type == 'gif'||$attachment->type == 'GIF')
                                                {
                                                $image = @imagecreatefromstring($attachment->file); 
                                                ob_start();
                                                imagejpeg($image, null, 80);
                                                $data = ob_get_contents();
                                                ob_end_clean();
                                                $var = '<a href="'.URL::route('image', array('image_id' => $attachment->id)).'" target="_blank"><img style="max-width:200px;height:133px;" src="data:image/jpg;base64,' . base64_encode($data)  . '"/></a>';


                                                echo '<li style="background-color:#f4f4f4;"><span class="mailbox-attachment-icon has-img">'.$var.'</span><div class="mailbox-attachment-info"><b style="word-wrap: break-word;">'.$attachment->name.'</b><br/><p>'.$value.'</p></div></li>';
                                                }
                                                else
                                                {
                                                $var = '<a style="max-width:200px;height:133px;color:#666;" href="'.URL::route('image', array('image_id' => $attachment->id)).'" target="_blank"><span class="mailbox-attachment-icon" style="background-color:#fff;">'.strtoupper($attachment->type).'</span><div class="mailbox-attachment-info"><span ><b style="word-wrap: break-word;">'.$attachment->name.'</b><br/><p>'.$value.'</p></span></div></a>';
                                                echo '<li style="background-color:#f4f4f4;">'.$var.'</li>';   
                                                }                                            
                                            }
                                        }
                                        ?>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <?php $lastid = $conversation->id?>
<?php }}
?>
                        <li>
                            <i class="fa fa-clock-o bg-gray"></i>
                        </li>
                        <ul class="pull-right" style="padding-right:25px;padding-bottom:10px;">
<?php echo $conversations->setPath(url('/thread/' . $tickets->id))->render();?>
                        </ul>
                    </ul>
                </div><!-- /.col -->
            </div>
        </div><!-- /.row -->
    </div>
</div>
<!-- </section>/.content -->


<!-- page modals -->
<div>
    <!-- Edit Ticket modal -->
<?php if ($group->can_edit_ticket == 1) {?>
    <div class="modal fade" id="Edit">
        <div class="modal-dialog" style="width:60%;height:70%;">
            <div class="modal-content">
                {!! Form::model($tickets->id, ['id'=>'form','method' => 'PATCH'] )!!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidd en="true">&times;</span></button>
                    <h4 class="modal-title">{!! Lang::get('tickets::lang.edit') !!} <b>[#{!! $tickets->ticket_number !!}]</b>[{!! $user->user_name !!}]</h4>
                </div>
                <div class="modal-body" id="hide">
                    <div class="form-group">
                        <label>{!! Lang::get('tickets::lang.title') !!}</label>
                        <input type="text" name="subject" class="form-control" value="{{$thread->title}}" >
                        <span id="error-subject" style="display:none" class="help-block text-red">This is a required field</span>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{!! Lang::get('tickets::lang.sla_plan') !!}</label>
                                <?php $sla_plans = Modules\Tickets\Models\SlaPlan::all() ?>
                                <select class="form-control" name="sla_paln">
                                @foreach($sla_plans as $sla_plan)
                                    <option value="{!! $sla_plan->id !!}" <?php  if($SlaPlan->id == $sla_plan->id){ echo "selected"; } ?> >{!! $sla_plan->grace_period !!}</option>
                                @endforeach
                                </select>
                                <span id="error-sla" style="display:none" class="help-block text-red">This is a required field</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{!! Lang::get('tickets::lang.help_topic') !!}</label>
                                <?php $help_topics = Modules\Tickets\Models\TicketHelpTopic::all() ?>
                                <select class="form-control" name="help_topic">
                                @foreach($help_topics as $helptopic)
                                    <option value="{!! $helptopic->id !!}" <?php if($help_topic->id == $helptopic->id){echo 'selected';} ?> >{!! $helptopic->topic !!}</option>
                                @endforeach
                                </select>
                                <span id="error-help" style="display:none" class="help-block text-red">This is a required field</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{!! Lang::get('tickets::lang.ticket_source') !!}</label>
                                <?php $ticket_sources = Modules\Core\Models\Ticket\Ticket_source::all() ?>
                                <select class="form-control" name="ticket_source">
                                @foreach($ticket_sources as $ticketsource)
                                    <option value="{!! $ticketsource->id !!}" <?php  if($tickets->source == $ticketsource->id){echo "selected"; } ?> >{!! $ticketsource->value !!}</option>
                                @endforeach 
                                </select>
                                <span id="error-source" style="display:none" class="help-block text-red">This is a required field</span>
                            </div>
                        </div>
                        <?php 
                        
                        ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{!! Lang::get('tickets::lang.priority') !!}</label>
                                <?php $ticket_prioritys = Modules\Core\Models\Ticket\Ticket_Priority::all() ?>
                                <select class="form-control" name="ticket_priority">
                                @foreach($ticket_prioritys as $ticket_priority)
                                   <option value="{!! $ticket_priority->priority_id !!}" <?php if($tickets->priority_id == $ticket_priority->priority_id){echo "selected";} ?> >{!! $ticket_priority->priority_desc !!}</option>
                                @endforeach
                                </select>
                                <span id="error-priority" style="display:none" class="help-block text-red">This is a required field</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="show" style="display:none;">
                    <div class="row col-md-12">
                        <div class="col-xs-5">
                        </div>
                        <div class="col-xs-2">
                            <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"><br/><br/><br/>
                        </div>
                        <div class="col-xs-5">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis">{!! Lang::get('tickets::lang.close') !!}</button>
                    <input type="submit" class="btn btn-primary pull-right" value="{!! Lang::get('tickets::lang.update') !!}">
                </div>
                {!! Form::close() !!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php }
?>
<?php if ($group->can_ban_email == 1) {?>
    <!-- ban email modal -->
    <div class="modal fade" id="banemail">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{!! Lang::get('tickets::lang.ban_email') !!} </h4>
                </div>
                <div class="modal-body">
                    {!! Lang::get('tickets::lang.are_you_sure_to_ban') !!} {!! $user->email !!}
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis2">{!! Lang::get('tickets::lang.close') !!}</button>
                    <button id="ban" type="button" class="btn btn-warning pull-right" >{!! Lang::get('tickets::lang.ban_email') !!}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php }
?>
    <!-- Change Owner Modal -->
    <div class="modal fade" id="ChangeOwner">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['id'=>'form4','method' => 'PATCH'] )!!}
                <div class="modal-header">
                    <button type="button" class="close" id="close101" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{!! Lang::get('tickets::lang.change_owner_for_ticket') !!} <b>#{!! $tickets->ticket_number !!}</b></h4>
                </div>
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#ahah1" data-toggle="tab" style="color:green;" id="aa"><i class="fa fa-users"> </i> {!! Lang::get('tickets::lang.search_existing_users') !!}</a></li>
                        <li><a href="#haha2" data-toggle="tab" style="color:orange;"><i class="fa fa-user-plus" > </i> {!! Lang::get('tickets::lang.add_new_user') !!}</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="ahah1">
                        <div id="change_alert" class="alert alert-danger alert-dismissable" style="display:none;">
                            <button id="change_dismiss" type="button" class="close" data-dismiss="alert"  aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-check"></i>Alert!</h4>
                            <div id="message-success42"></div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-6" id="change_loader" style="display:none;">
                                    <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"><br/><br/><br/>
                                </div>
                            </div>
                            <div id="change_body">
                                <?php $users = Modules\Core\Models\Staff::where('role', '=', 'user')->get();?>
                        
                                {!! Lang::get('tickets::lang.add_another_owner') !!}

                                <input type="text" class="form-control" id="tags2" name="email" placeholder="{!! Lang::get('tickets::lang.search_user') !!}"\>
                                <input type="hidden" name="ticket_id" value="{!! $tickets->id !!}">
                                <input type="hidden" name="action" value="change-owner">
                                <div class="row">
                                    <div class="col-md-2"><span class="glyphicon glyphicon-user fa-5x"></span></div>
                                    <div id="change-refresh" class="col-md-10">
                                    <?php $user = Modules\Core\Models\Staff::where('id', '=', $tickets->user_id)->first();?>

                                        <!-- <b>{!! Lang::get('tickets::lang.user_details') !!}User Details</b><br/> -->
                                        <b>Current owner</b><br/>
                                        {!! $user->user_name !!}<br/>{!! $user->email !!}<br/>
                                        @if($user->phone != null)
                                            <b>{!! Lang::get('tickets::lang.contact_informations') !!}Contact Informations</b><br/>
                                            {!! $user->phone !!}
                                        @endif
                                    </div>
                                </div>
                       
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis42">{!! Lang::get('tickets::lang.close') !!}</button>
                            <!--<input type='checkbox' name='send-mail' class='icheckbox_flat-blue' value='".$ticket->id."'><span disabled class="btn btn-sm">Check to notify user</span></input>-->
                            <button type="submit" class="btn btn-primary pull-right" id="submt2">{!! Lang::get('tickets::lang.update') !!}</button>
                        </div>
                        {!! Form::close()!!}
                        </div><!--tab-pane active-->
                        <div class="tab-pane" id="haha2">
                            <div id="change_alert2" class="alert alert-danger alert-dismissable" style="display:none;">
                                <button id="change_dismiss" type="button" class="close" data-dismiss="alert"  aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-check"></i>Alert!</h4>
                            <div id="message-success422"></div>
                            </div>
                            <div class="modal-body" id="abc">
                            <h4 class="modal-title pull-left">{!! Lang::get('tickets::lang.add_new_user') !!}</h4>
                            <br/><br/>
                            <div id="here2"></div>
                            {!! Form::model($tickets->id, ['id'=>'change-add-owner','method' => 'PATCH'] )!!} 
                                <div id="add-change-loader" style="display:none;">
                                    <div class="row col-md-12">
                                        <div class="col-xs-5">
                                        </div>
                                        <div class="col-xs-2">
                                            <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"> 
                                        </div>
                                        <div class="col-xs-5">
                                        </div>
                                    </div>
                                    <br/><br/><br/><br/>
                                </div>
                                <div id="add-change-body">
                                    <input type="text" name="name" class="form-control" placeholder="{!! Lang::get('tickets::lang.name') !!}" required>
                                    <input type="email" name="email" class="form-control" placeholder="{!! Lang::get('tickets::lang.e-mail') !!}" required>
                                    <input type="hidden" name="ticket_id" value="{!! $tickets->id !!}">
                                    <input type="hidden" name="action" value="change-add-owner">
                                    <input type="submit" class="btn" value="{!! Lang::get('tickets::lang.submit') !!}">
                                </div>
                            {!! Form::close() !!}
                            </div>
                        </div>
                    </div><!--tab-content-->    
                </div><!--nav-tabs-custom-->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php if ($group->can_assign_ticket == 1) {?>
    <!-- Ticket Assign Modal -->
    <div class="modal fade" id="{{$tickets->id}}assign">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['id'=>'form1','method' => 'PATCH'] )!!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{!! Lang::get('tickets::lang.assign') !!}</h4>
                </div>
                <div id="assign_alert" class="alert alert-success alert-dismissable" style="display:none;">
                    <button id="assign_dismiss" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i>Alert!</h4>
                    <div id="message-success1"></div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-6" id="assign_loader" style="display:none;">
                            <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"><br/><br/><br/>
                        </div>
                    </div>
                    <div id="assign_body">
                        <p>{!! Lang::get('tickets::lang.whome_do_you_want_to_assign_ticket') !!}?</p>

                        <select id="asssign" class="form-control" name="assign_to">
<?php   
$assign = Modules\Core\Models\Staff::where('role', '!=', 'user')->get();
$count_assign = count($assign);
$teams = Modules\Core\Models\Agent\Teams::all();
$count_teams = count($teams);
?>
                            <optgroup label="Teams ( {!! $count_teams !!} )">
                                @foreach($teams as $team)
                                    <option  value="team_{{$team->id}}">{!! $team->name !!}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Agents ( {!! $count_assign !!} )">
                                @foreach($assign as $user)
                                    <option  value="user_{{$user->id}}">{{$user->first_name." ".$user->last_name}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis4">{!! Lang::get('tickets::lang.close') !!}</button>
                    <button type="submit" class="btn btn-success pull-right" id="submt2">{!! Lang::get('tickets::lang.assign') !!}</button>
                </div>
                {!! Form::close()!!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php }
?>
    <!-- Surrender Modal -->
    <div class="modal fade" id="surrender">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{!! Lang::get('tickets::lang.surrender') !!}</h4>
                </div>
                <div class="modal-body">
                    <p>{!! Lang::get('tickets::lang.are_you_sure_you_want_to_surrender_this_ticket') !!}?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis6">{!! Lang::get('tickets::lang.close') !!}</button>
                    <button type="button" class="btn btn-warning pull-right" id="Surrender">{!! Lang::get('tickets::lang.surrender') !!}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- add or search user Modal -->
    <div class="modal fade" id="addccc">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{!! Lang::get('tickets::lang.add_collaborator') !!}</h4>
                </div>
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#ahah" data-toggle="tab" style="color:green;" id="aa"><i class="fa fa-users"> </i> {!! Lang::get('tickets::lang.search_existing_users') !!}</a></li>
                        <li><a href="#haha" data-toggle="tab" style="color:orange;"><i class="fa fa-user-plus" > </i> {!! Lang::get('tickets::lang.add_new_user') !!}</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="ahah">
                            <div class="modal-body" id="def">
                                <div class="callout callout-info" id="hide1234" ><i class="icon fa fa-info"> </i>&nbsp;&nbsp;&nbsp; {!! Lang::get('tickets::lang.search_existing_users_or_add_new_users') !!}</div>
                                <div id="show7" style="display:none;">
                                    <div class="row col-md-12">
                                        <div class="col-xs-5">
                                        </div>
                                        <div class="col-xs-2">
                                            <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"> 
                                        </div>
                                        <div class="col-xs-5">
                                        </div>
                                    </div>
                                </div>
                                <div id="here"></div>
                                {!! Form::model($tickets->id, ['id'=>'search-user','method' => 'PATCH'] )!!}    
                                    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
                                    <input type="text" class="form-control" name="search" id="tags" placeholder="{!! Lang::get('tickets::lang.search_by_email') !!}">
                                    <input type="hidden" name="ticket_id" value="{!! $tickets->id !!}">
                                    <input type="submit" class="btn btn-submit" value="{!! Lang::get('tickets::lang.submit') !!}">
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="tab-pane" id="haha">
                            <div class="modal-body" id="abc">
                            <h4 class="modal-title pull-left">{!! Lang::get('tickets::lang.add_new_user') !!}</h4>
                            <br/><br/>
                            <div id="here2"></div>
                            {!! Form::model($tickets->id, ['id'=>'add-user','method' => 'PATCH'] )!!} 
                                <div id="show8" style="display:none;">
                                    <div class="row col-md-12">
                                        <div class="col-xs-5">
                                        </div>
                                        <div class="col-xs-2">
                                            <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"> 
                                        </div>
                                        <div class="col-xs-5">
                                        </div>
                                    </div>
                                    <br/><br/><br/><br/>
                                </div>
                                <div id="hide12345">
                                    <input type="text" name="name" class="form-control" placeholder="{!! Lang::get('tickets::lang.name') !!}" required>
                                    <input type="text" name="email" class="form-control" placeholder="{!! Lang::get('tickets::lang.e-mail') !!}" required>
                                    <input type="hidden" name="ticket_id" value="{!! $tickets->id !!}">
                                    <input type="submit" class="btn" value="{!! Lang::get('tickets::lang.submit') !!}">
                                </div>
                            {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="modal-footer"> --}}
                    {{-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis9" data-dismiss="alert">Close</button> --}}
                    {{-- <button type="button" class="btn btn-warning pull-right" id="Surrender">Add User</button> --}}
                {{-- </div> --}}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- Surrender Modal -->
    <div class="modal fade" id="surrender2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{!! Lang::get('tickets::lang.list_of_collaborators_of_this_ticket') !!}</h4>
                </div>
                <div class="modal-body" id="surrender22">
                    @foreach($Collaborator as $ccc)
                    <?php $collab_user_id = $ccc->user_id ;
                            $collab_user = Modules\Core\Models\Staff::where('id','=', $collab_user_id)->first();
                    ?>
                    <div id="alert11" class="alert alert-dismissable" style="background-color:#F2F2F2">
                    <meta name="_token" content="{{ csrf_token() }}"/>
                        <button id="dismiss11" type="button" class="close" data-dismiss="alert" onclick="remove_collaborator({!! $ccc->id !!})" aria-hidden="true">×</button>
                        @if($collab_user->role == 'agent' || $collab_user->role == 'admin')
                            <i class="icon fa fa-user"></i>{!! $collab_user->first_name . " " . $collab_user->last_name !!}
                        @elseif($collab_user->role == 'user')
                            <i class="icon fa fa-user"></i>{!! $collab_user->user_name !!}
                        @endif
                        <div id="message-success1">{!! $collab_user->email !!}</div>
                    </div>
                    @endforeach
                </div>
               {{--  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis6">Close</button>
                    <button type="button" class="btn btn-warning pull-right" id="Surrender">Surrender</button>
                </div> --}}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div style="display:none">
        <form id="auto-submit">
            <input type="hidden" name="now" value="1">
        </form>
    </div>
</div>



<!-- merge tickets modal -->
    <div class="modal fade" id="MergeTickets">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" id="merge-close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{!! Lang::get('tickets::lang.merge-ticket') !!} </h4>&nbsp;<b>#{!! $tickets->ticket_number !!}</b>
                </div><!-- /.modal-header-->
                <div class ="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-6" id="merge_loader"  style="display:none;">
                            <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"><br/><br/><br/>
                        </div><!-- /.merge-loader -->
                    </div>
                    <div id="merge_body">
                        <div id="merge-body-alert">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="merge-succ-alert" class="alert alert-success alert-dismissable" style="display:none;" >
                                        <!-- <button id="dismiss-merge" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                                        <h4><i class="icon fa fa-check"></i>Alert!</h4>
                                        <div id="message-merge-succ"></div>
                                    </div>
                                    <div id="merge-err-alert" class="alert alert-danger alert-dismissable" style="display:none;">
                                        <!-- <button id="dismiss-merge2" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                                        <h4><i class="icon fa fa-ban"></i>Alert!</h4>
                                        <div id="message-merge-err"></div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.merge-alert -->
                        <div id="merge-body-form">
                            <div class="row">
                                <div class="col-md-6">
                                    {!! Form::open(['id'=>'merge-form','method' => 'PATCH'] )!!}
                                    <label>{!! Lang::get('tickets::lang.title') !!}</label>
                                    <input type="text" name='title' class="form-control" value="<?php $ticket_data = Modules\Core\Models\Ticket\Ticket_Thread::select('title')->where('ticket_id', "=", $tickets->id)->first();    echo $ticket_data->title;?>"/>
                                </div>
                                <div class="col-md-6">
                                <label>{!! Lang::get('tickets::lang.select-pparent-ticket') !!}</label>
                                    <div id="parent-loader" style="display:none;">
                                        <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}" height="30px" width="30px">
                                    </div>
                                    <div id="parent-body" >
                                        
                                        <select class="form-control" id="select-merge-parent"  name='p_id' data-placeholder="{!! Lang::get('tickets::lang.select_tickets') !!}" style="width: 100%;"><option value="{{$tickets->id}}"><?php $ticket_data = Modules\Core\Models\Ticket\Ticket_Thread::select('title')->where('ticket_id', "=", $tickets->id)->first();    echo $ticket_data->title;?></option></select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8">
                            
                                    <label>{!! Lang::get('tickets::lang.select_tickets') !!}</label>
                                    <select class="form-control select2" id="select-merge-tickts" name="t_id[]" multiple="multiple" data-placeholder="{!! Lang::get('tickets::lang.select_tickets') !!}" style="width: 100%;">
                                
                                    </select>
                           
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <label>{!! Lang::get('tickets::lang.merge-reason') !!}</label>
                                    <textarea  name="reason" class="form-control"></textarea>
                                </div>
                          
                            </div>
                        </div><!-- mereg-body-form -->
                    </div><!-- merge-body -->
                </div><!-- /.modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis2">{!! Lang::get('tickets::lang.close') !!}</button>
                    <input  type="submit" id="merge-btn" class="btn btn-primary pull-right" value="{!! Lang::get('tickets::lang.merge') !!}"></input>
                    {!! Form::close() !!}
                </div><!-- /.modal-footer -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php  $var=Modules\Core\Models\Settings\Ticket::where('id', '=', 1)->first(); ?>

<!-- scripts used on page -->
<script type="text/javascript">

        $(function () {
            $("#InternalContent").wysihtml5();
        });

jQuery('.star').attr('disabled', true);
    
$(function () {
    // $('#cand').wysihtml5();
    var wysihtml5Editor = $('#reply_content').wysihtml5().data("wysihtml5").editor;

    $('#select').on('change', function (e) {

    //alert('hello2');
    var $_token = $('#token').val();
    var data = $('#select').val();

    //var data1 = $(this).children('option:selected').data('id');
    //alert('data1');
        $.ajax({
            type        :   "POST",
            cache   :   false,
            headers :   { 'X-XSRF-TOKEN' : $_token },
            url         :   "../canned/"+ data,
            dataType    :   'json',
            data        :   ({data}),
           
            success : function(response) { 

                // alert(response);
                wysihtml5Editor.setValue(response, true);
                console.log(wysihtml5Editor.getValue());
            }
        });
       
        return false;
        });
});



$(function() {
    $( "#tags, #tags2" ).autocomplete({
        source: 'auto/<?php echo $tickets->id; ?>'
    });
});

$(document).ready(function () {
    
    //Initialize Select2 Elements
    $(".select2").select2();
    
    setInterval(function(){
        $("#auto-submit").submit(function(){
            $.ajax({
                type: "POST",
                url: "{!! URL::route('lock') !!}",
            })
            return false;            
        });
    },180000);
});



jQuery(document).ready(function() {
        // Close a ticket
        $('#close').on('click', function(e) {
            $.ajax({
                type: "GET",
                url: "../ticket/close/{{$tickets->id}}",
                beforeSend: function() {
                    $("#hidespin").hide();
                    $("#spin").show();
                    $("#hide2").hide();
                    $("#show2").show();
                },
                success: function(response) {
                    $("#refresh").load("../thread/{{$tickets->id}}   #refresh");
                    $("#show2").hide();
                    $("#spin").hide();
                    $("#hide2").show();
                    $("#hidespin").show();
                    $("#d1").trigger("click");
                    var message = "Success! Your Ticket have been Closed";
                    $("#alert11").show();
                    $('#message-success1').html(message);
                    setInterval(function(){
                        $("#alert11").hide();
                        setTimeout(function() {
                            // var link = document.querySelector('#load-inbox');
                            // if(link) {
                            //     link.click();
                            // }
                            history.go(-1);
                        }, 500);
                    },2000);   
                }
            })
            return false;
        });

        // Resolved  a ticket
        $('#resolved').on('click', function(e) {
            $.ajax({
                type: "GET",
                url: "../ticket/resolve/{{$tickets->id}}",
                beforeSend: function() {
                    $("#hide2").hide();
                    $("#show2").show();
                },
                success: function(response) {
                    $("#refresh").load("../thread/{{$tickets->id}}  #refresh");
                    $("#d1").trigger("click");
                    $("#hide2").show();
                    $("#show2").hide();
                    var message = "Success! Your Ticket have been Resolved";
                    $("#alert11").show();
                    $('#message-success1').html(message);
                    setInterval(function(){$("#alert11").hide();
                        setTimeout(function() {
                            // var link = document.querySelector('#load-inbox');
                            // if(link) {
                            //     link.click();
                            // }
                            history.go(-1);
                        }, 500);
                    },2000);   
                }
            })
            return false;
        });

        // Open a ticket
        $('#open').on('click', function(e) {
            $.ajax({
                type: "GET",
                url: "../ticket/open/{{$tickets->id}}",
                beforeSend: function() {
                    $("#hide2").hide();
                    $("#show2").show();
                },
                success: function(response) {
                    $("#refresh").load("../thread/{{$tickets->id}}   #refresh");
                    $("#d1").trigger("click");
                    $("#hide2").show();
                    $("#show2").hide();
                    var message = "Success! Your Ticket have been Opened";
                    $("#alert11").show();
                    $('#message-success1').html(message);
                    setInterval(function(){$("#alert11").hide(); },4000);   

                }
            })
            return false;
        });

        // delete a ticket
        $('#delete').on('click', function(e) {
            $.ajax({
                type: "GET",
                url: "../ticket/delete/{{$tickets->id}}",
                beforeSend: function() {
                    $("#hide2").hide();
                    $("#show2").show();
                },                
                success: function(response) {
                    $("#refresh").load("../thread/{{$tickets->id}}   #refresh");
                    $("#d2").trigger("click");
                    $("#hide2").show();
                    $("#show2").hide();
                    var message = "Success! Your Ticket have been moved to Trash";
                    $("#alert11").show();
                    $('#message-success1').html(message);
                    setInterval(function(){$("#alert11").hide(); 
                        setTimeout(function() {
                            // var link = document.querySelector('#load-inbox');
                            // if(link) {
                            //     link.click();
                            // }
                            history.go(-1);
                        }, 500);
                    },2000);   
                }
            })
            return false;
        });

        // ban email
        $('#ban').on('click', function(e) {
            $.ajax({
                type: "GET",
                url: "../email/ban/{{$tickets->id}}",
                success: function(response) {
                    $("#dismis2").trigger("click");
                    $("#refresh").load("../thread/{{$tickets->id}}   #refresh");
                    var message = "Success! This Email have been banned";
                    $("#alert11").show();
                    $('#message-success1').html(message);
                    setInterval(function(){$("#alert11").hide(); },4000);   
                }
            })
            return false;
        });

        // internal note
        // $('#internal').click(function() {
        //     $('#t1').hide();
        //     $('#t2').show();
        // });

        // comment a ticket
        // $('#aa').click(function() {
        //     $('#t1').show();
        //     $('#t2').hide();
        // });

// Edit a ticket
        $('#form').on('submit', function() {
            $.ajax({
                type: "POST",
                url: "../ticket/post/edit/{{$tickets->id}}",
                dataType: "html",
                data: $(this).serialize(),
                beforeSend: function() {
                    $("#hide").hide();
                    $("#show").show();
                },
                success: function(response) {
                    $("#show").hide();
                    $("#hide").show();
                    
                    if (response == 0) {
                        message = "Ticket Updated Successfully!"
                        $("#dismis").trigger("click");
                        $("#refresh1").load("../thread/{{$tickets->id}}   #refresh1");
                        $("#refresh2").load("../thread/{{$tickets->id}}   #refresh2");
                        $("#alert11").show();
                        $('#message-success1').html(message);
                        setInterval(function(){$("#alert11").hide(); },4000);   
                    }
                    else if (response == 1) {
                        $("#error-subject").show();
                    }
                    else if (response == 2) {
                        $("#error-sla").show();
                    }
                    else if (response == 3) {
                        $("#error-help").show();
                    }
                    else if (response == 4) {
                        $("#error-source").show();
                    }
                    else if (response == 5) {
                        $("#error-priority").show();
                    }
                }
            })
            return false;
        });

// Assign a ticket
        $('#form1').on('submit', function() {
            $.ajax({
                type: "POST",
                url: "../ticket/assign/{{ $tickets->id }}",
                dataType: "html",
                data: $(this).serialize(),
                beforeSend: function() {
                    $("#assign_body").hide();
                    $("#assign_loader").show();
                },
                success: function(response) {
                    if(response == 1)
                    {
                        // $("#assign_body").show();
                        // var message = "Success";
                        // $('#message-success1').html(message);
                        // setInterval(function(){$("#alert11").hide(); },4000);   

                        var message = "Success!";
                        $("#alert11").show();
                        $('#message-success1').html(message);
                        setInterval(function(){$("#dismiss11").trigger("click"); },2000);   
                    }
                    $("#assign_body").show();
                    $("#assign_loader").hide();
                    $("#dismis4").trigger("click");
                    // $("#RefreshAssign").load( "../thread/{{$tickets->id}} #RefreshAssign");
                    // $("#General").load( "../thread/{{$tickets->id}} #General");
                }
            })
            return false;
        });


    // Change owner of a ticket
        $('#form4').on('submit', function() {
            $.ajax({
                type: "POST",
                url: "../change-owner/{{ $tickets->id }}",
                dataType: "html",
                data: $(this).serialize(),
                beforeSend: function() {
                    $("#change_body").hide();
                    $("#change_loader").show();
                },
                success: function(response) {
                    if(response != 1)
                    {
                        // $("#assign_body").show();
                         var message = "{{Lang::get('tickets::lang.user-not-found')}}";
                        $('#change_alert').show();
                        $('#message-success42').html(message);
                        setInterval(function(){$("#change_alert").hide(); },5000);
                        $("#change_body").show();
                        $("#change_loader").hide(); 

                         
                    } else {
                        $("#change_body").show();
                        $("#change_loader").hide();
                        $("#dismis42").trigger("click");
                        // $("#RefreshAssign").load( "../thread/{{$tickets->id}} #RefreshAssign");
                        // $("#General").load( "../thread/{{$tickets->id}} #General");
                        $("#hide2").load("../thread/{{$tickets->id}}  #hide2");
                        $("#refresh").load("../thread/{{$tickets->id}}  #refresh");
                        $("#refresh1").load("../thread/{{$tickets->id}}  #refresh1");
                        $("#refresh3").load("../thread/{{$tickets->id}}  #refresh3");
                        $("#refreshTo").load("../thread/{{$tickets->id}}  #refreshTo");
                        $("#change-refresh").load("../thread/{{$tickets->id}}  #change-refresh");
                        var message = "{{Lang::get('tickets::lang.change-success')}}";
                        $("#alert11").show();
                        $('#message-success1').html(message);
                        setInterval(function(){$("#alert11").hide(); },4000); 

                    }
                }
            })
            return false;
        });


// Add and change owner of a ticket
        $('#change-add-owner').on('submit',function(){
            $.ajax({
                type: "POST",
                url: "../change-owner/{{ $tickets->id }}",//url: "../add-user",
                dataType: "html",
                data: $(this).serialize(),
                beforeSend: function() {
                    $('#add-change-loader').show();
                    $('#add-change-body').hide();
                },
                success: function(response) {
                    if(response == 1){
                        $('#add-change-loader').hide();
                        $('#add-change-body').show();
                        $("#close101").trigger("click");
                        $("#hide2").load("../thread/{{$tickets->id}}  #hide2");
                        $("#refresh").load("../thread/{{$tickets->id}}  #refresh");
                        $("#refresh1").load("../thread/{{$tickets->id}}  #refresh1");
                        $("#refresh3").load("../thread/{{$tickets->id}}  #refresh3");
                        $("#refreshTo").load("../thread/{{$tickets->id}}  #refreshTo");
                        var message = "{{Lang::get('tickets::lang.change-success')}}";
                        $("#alert11").show();
                        $('#message-success1').html(message);
                        setInterval(function(){$("#alert11").hide(); },4000);
                    } else {
                        if(response == 4){ 
                            var message = "{{Lang::get('tickets::lang.user-exists')}}";
                        } else if(response == 5){
                            var message = "{{Lang::get('tickets::lang.valid-email')}}";
                        } else {
                            //var message = "Can't process your request. Try after some time.";
                        }
                        $('#change_alert2').show();
                        $('#message-success422').html(message);
                        setInterval(function(){$("#change_alert2").hide(); },8000);
                        $('#add-change-loader').hide();
                        $('#add-change-body').show();

                      
                    }
                }
            })
            return false;
        });


    // Internal Note
        $('#form2').on('submit', function() {
            $.ajax({
                type: "POST",
                url: "../internal/note/{{ $tickets->id }}",
                dataType: "html",
                data: $(this).serialize(),
                beforeSend: function() {
                    $("#t2").hide();
                    $("#show5").show();

                },
                success: function(response) {

                    if (response == 1)
                    {
                        $("#refresh1").load("../thread/{{$tickets->id}}   #refresh1");
                        // $("#t4").load("../thread/{{$tickets->id}}   #t4");
                        var message = "Success! You have successfully replied to your ticket";
                        $("#alert21").show();
                        $('#message-success2').html(message);
                        setInterval(function(){$("#alert21").hide();  },4000);   
                        
                         $("#newtextarea").empty();
                        var div = document.getElementById('newtextarea');
                        div.innerHTML = div.innerHTML + '<textarea style="width:98%;height:200px;" name="reply_content" class="form-control" id="reply_content"/></textarea>';
                        
                        $("#newtextarea1").empty();
                        var div1 = document.getElementById('newtextarea1');
                        div1.innerHTML = div1.innerHTML + '<textarea style="width:98%;height:200px;" name="InternalContent" class="form-control" id="InternalContent"/></textarea>';

                        var wysihtml5Editor = $('textarea').wysihtml5().data("wysihtml5").editor;
                    } else {
                        // alert('fail');
                        var message = "Fail! For some reason your message was not posted. Please try again later";
                        $("#alert23").show();
                        $('#message-danger2').html(message);
                        setInterval(function(){$("#alert23").hide(); },4000);   
                        // $( "#dismis4" ).trigger( "click" );
                    }
                    $("#t2").show();
                    $("#show5").hide();
                }
            })
            return false;
        });

// Ticket Reply
        $('#form3').on('submit', function() {
            var fd = new FormData(document.getElementById("form3"));
            $.ajax({
                type: "POST",
                url: "../thread/reply/{{ $tickets->id }}",
                enctype: 'multipart/form-data',
                dataType: "html",
                data: fd,
                processData: false,  // tell jQuery not to process the data
                contentType: false ,  // tell jQuery not to set contentType
                beforeSend: function() {

                    $("#t1").hide();
                    $("#show3").show();
                },

                success: function(response) {

                    if (response == 1)
                    {
                        $("#refresh1").load("../thread/{{$tickets->id}}  #refresh1");
                        // $("#t1").load("../thread/{{$tickets->id}}  #t1");
                        var message = "Success! You have successfully replied to your ticket";
                        $("#alert21").show();
                        $('#message-success2').html(message);
                        setInterval(function(){$("#alert21").hide(); },4000);   
                        // var wysihtml5Editor = $('textarea').wysihtml5().data("wysihtml5").editor;
                        $("#newtextarea").empty();
                        var div = document.getElementById('newtextarea');
                        div.innerHTML = div.innerHTML + '<textarea style="width:98%;height:200px;" name="reply_content" class="form-control" id="reply_content"/></textarea>';
                        
                        $("#newtextarea1").empty();
                        var div1 = document.getElementById('newtextarea1');
                        div1.innerHTML = div1.innerHTML + '<textarea style="width:98%;height:200px;" name="InternalContent" class="form-control" id="InternalContent"/></textarea>';

                        var wysihtml5Editor = $('textarea').wysihtml5().data("wysihtml5").editor;
                    } else {
                        // alert('fail');
                        // $( "#dismis4" ).trigger( "click" );
                        var message = "Fail! For some reason your reply was not posted. Please try again later";
                        $("#alert23").show();
                        $('#message-danger2').html(message);
                        setInterval(function(){$("#alert23").hide(); },4000);   
                    }
                    $("#show3").hide();
                    $("#t1").show();
                }
            })
            return false;
        });

// Surrender
        $('#Surrender').on('click', function() {
            $.ajax({
                type: "GET",
                url: "../ticket/surrender/{{ $tickets->id }}",
                success: function(response) {

                    if (response == 1)
                    {
                        // alert('ticket has been un assigned');
                        var message = "Success! You have Unassigned your ticket";
                        $("#alert11").show();
                        $('#message-success1').html(message);
                        setInterval(function(){$("#dismiss11").trigger("click"); },2000);   
                        // $("#refresh1").load( "http://localhost/faveo/public/thread/{{$tickets->id}}   #refresh1");
                        $('#surrender_button').hide();
                    }
                    else
                    {
                        var message = "Fail! For some reason your request failed";
                        $("#alert13").show();
                        $('#message-danger1').html(message);
                        setInterval(function(){$("#dismiss13").trigger("click"); },2000);
                        // alert('fail');
                        // $( "#dismis4" ).trigger( "click" );
                    }
                    $("#dismis6").trigger("click");
                }
            })
            return false;
        });

        $("#search-user").on('submit',function(e) {
                $.ajax({
                type: "POST",
                url: "../search-user",
                dataType: "html",
                data: $(this).serialize(),

                beforeSend: function() {
                    $('#show7').show();
                    $('#hide1234').hide();
                },
                success: function(response) {
                    $('#show7').hide();
                    $('#hide1234').show();
                    $('#here').html(response);
                    $("#recepients").load("../thread/{{$tickets->id}}   #recepients");
                    $("#surrender22").load("../thread/{{$tickets->id}}   #surrender22");
                
                }
            })
            return false;
        });


        $("#add-user").on('submit',function(e) {
                $.ajax({
                type: "POST",
                url: "../add-user",
                dataType: "html",
                data: $(this).serialize(),

                 beforeSend: function() {
                    $('#show8').show();
                    $('#hide12345').hide();
                },
                success: function(response) {
                    $('#show8').hide();
                    $('#hide12345').show();

                $('#here2').html(response);
                $("#recepients").load("../thread/{{$tickets->id}}   #recepients");
                $("#surrender22").load("../thread/{{$tickets->id}}   #surrender22");
                }
            })
            return false;
        });

        // checking merge
        $('#MergeTickets').on('show.bs.modal', function (id) {
            $.ajax({
                type: "GET",
                url: "../check-merge-ticket/{{ $tickets->id }}",
                dataType: "html",
                data:$(this).serialize(),
                beforeSend: function() {
                    $("#merge_body").hide();
                    $("#merge_loader").show();
                },
                success: function(response) {
                    if(response == 0) {
                        $("#merge_body").show();
                        $("#merge-succ-alert").hide();
                        $("#merge-body-alert").show();
                        $("#merge-body-form").hide();
                        $("#merge_loader").hide();
                        $("#merge-btn").attr('disabled', true);
                       var message = "{{Lang::get('tickets::lang.no-tickets-to-merge')}}";
                        $("#merge-err-alert").show();
                        $('#message-merge-err').html(message);  

                    } else {
                        $("#merge_body").show();
                        $("#merge-body-alert").hide();
                        $("#merge-body-form").show();
                        $("#merge_loader").hide();
                        $("#merge-btn").attr('disabled', false);
                        $("#merge_loader").hide();
                        $.ajax({
                            url: "../get-merge-tickets/{{ $tickets->id}}",
                            type: 'GET',
                            data: $(this).serialize(),
                            success: function(data) {
            
                                $('#select-merge-tickts').html(data);
                            }
                            // return false;
                        });
                    }
                }
            });
        });

    //submit merging form
        $('#merge-form').on('submit', function(){
            $.ajax({
                    type: "POST",
                    url: "../merge-tickets/{{ $tickets->id }}",
                    dataType: "html",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $("#merge_body").hide();
                        $("#merge_loader").show();
                   
                    },
                    success: function(response) {
                        if(response == 0) {
                            $("#merge_body").show();
                            $("#merge-succ-alert").hide();
                            $("#merge-body-alert").show();
                            $("#merge-body-form").hide();
                            $("#merge_loader").hide();
                            $("#merge-btn").attr('disabled', true);
                           var message = "{{Lang::get('tickets::lang.merge-error')}}";
                            $("#merge-err-alert").show();
                            $('#message-merge-err').html(message);  
                    
                        } else if(response == 2) {
                            $("#merge_body").show();
                            $("#merge-succ-alert").hide();
                            $("#merge-body-alert").show();
                            $("#merge-body-form").hide();
                            $("#merge_loader").hide();
                            $("#merge-btn").attr('disabled', true);
                            var message = "{{Lang::get('tickets::lang.merge-error2')}}";
                            $("#merge-err-alert").show();
                            $('#message-merge-err').html(message);

                        } else {
                            $("#merge_body").show();
                            $("#merge-err-alert").hide();
                            $("#merge-body-alert").show();
                            $("#merge-body-form").hide();
                            $("#merge_loader").hide();
                            $("#merge-btn").attr('disabled', true);
                            $("#hide2").load("../thread/{{$tickets->id}}  #hide2");
                            $("#refresh").load("../thread/{{$tickets->id}}  #refresh");
                            $("#refresh1").load("../thread/{{$tickets->id}}  #refresh1");
                            $("#refresh3").load("../thread/{{$tickets->id}}  #refresh3");
                            $("#refreshTo").load("../thread/{{$tickets->id}}  #refreshTo");
                            $("#more-option").load("../thread/{{$tickets->id}}  #more-option");
                            var message = "{{Lang::get('tickets::lang.merge-success')}}";
                            $("#merge-succ-alert").show();
                            $('#message-merge-succ').html(message);  

                        }
                  
                    }
                })
                return false;

        });

});



    function remove_collaborator(id) {
        var data = id;
        $.ajax({
                headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content'),
                },
                type: "POST",
                url: "../remove-user",
                dataType: "html",
                data: {data1:data},
                success: function(response) {
                    if (response == 1) {
                        $("#recepients").load("../thread/{{$tickets->id}}   #recepients");        
                    };
                // $('#here2').html(response);
                
                // $("#surrender22").load("../thread/{{$tickets->id}}   #surrender22");
                }
            })
            return false;
    }

$(document).ready(function() {

    var Vardata="";
    var count = 0;
    $(".select2").on('select2:select', function(){
        parentAjaxCall();
    });
    $(".select2").on('select2:unselect', function(){
        parentAjaxCall();
    });
    function parentAjaxCall(){
       // alert();
        var arr = $("#select-merge-tickts").val();
        if(arr == null) {
            document.getElementById("select-merge-parent").innerHTML = "<option value='{{$tickets->id}}'><?php $ticket_data = Modules\Core\Models\Ticket\Ticket_Thread::select('title')->where('ticket_id', "=", $tickets->id)->first();    echo $ticket_data->title;?></option>"
        } else {
            $.ajax({
                type: "GET",
                url: "../get-parent-tickets/{{ $tickets->id }}",
                dataType: "html",
                data:{data1:arr},
                beforeSend: function() {
                   $("#parent-loader").show();
                   $("#parent-body").hide();
                },
                success: function(data) {
                    $("#parent-loader").hide();
                    $("#parent-body").show();
                    // $("#select-merge-parent").focus();
                    $('#select-merge-parent').html(data);
                    // $( this ).off( event );
                }
            });
        }
        
    }

    var locktime = '<?php echo $var->collision_avoid;?>'*60*1000;
    lockAjaxCall(locktime);
    setInterval(function() {// to call ajax for ticket lock repeatedly after defined lock time interval
        lockAjaxCall(locktime);
        return false;
}, locktime);
});
//ajax call to check ticket and lock ticket
function lockAjaxCall(locktime){
        $.ajax({
                type: "GET",
                url: "../check/lock/{{$tickets->id}}",
                dataType: "html",
                data: $(this).serialize(),
                success: function(response) {
                    if(response == 0) {
                       var message = "{{Lang::get('tickets::lang.locked-ticket')}}";
                        $("#alert22").show();
                        $('#message-warning2').html(message);
                        $('#replybtn').attr('disabled', true);
                        //setInterval(function(){$("#alert23").hide(); },10000);
                    } else if(response == 2) {
                        // alert(response);
                        // var message = "{{Lang::get('tickets::lang.access-ticket')}}"+locktime/(60*1000)
                        // +"{{Lang::get('tickets::lang.minutes')}}";
                        $("#alert22").hide();
                        $("#hide2").load("../thread/{{$tickets->id}}  #hide2");
                        $("#refresh").load("../thread/{{$tickets->id}}  #refresh");
                        $("#refresh1").load("../thread/{{$tickets->id}}  #refresh1");
                        $("#refresh3").load("../thread/{{$tickets->id}}  #refresh3");
                        $("#t5").load("../thread/{{$tickets->id}}  #t5");
                        // $("#alert21").show();
                        // $('#message-success2').html(message);
                        $('#replybtn').attr('disabled', false); 
                        // setInterval(function(){$("#alert21").hide(); },8000);  
                    } else {
                        // alert(response);
                        // var message = "{{Lang::get('tickets::lang.access-ticket')}}"+locktime/(60*1000)
                        // +"{{Lang::get('tickets::lang.minutes')}}";
                        $("#alert22").hide();
                        $("#refresh").load("../thread/{{$tickets->id}}  #refresh");
                       // $("#refresh1").load("../thread/{{$tickets->id}}  #refresh1");
                        $("#refresh3").load("../thread/{{$tickets->id}}  #refresh3");
                        $("#t5").load("../thread/{{$tickets->id}}  #t5");
                        // $("#alert21").show();
                        // $('#message-success2').html(message);
                        $('#replybtn').attr('disabled', false); 
                        // setInterval(function(){$("#alert21").hide(); },8000); 
                    }
                }
        })
}

        $(function() {          
           
                $('h5').html('<span class="stars">'+parseFloat($('input[name=amount]').val())+'</span>');
                $('span.stars').stars();

                $('h4').html('<span class="stars2">'+parseFloat($('input[name=amt]').val())+'</span>');
                $('span.stars2').stars();

        });

        $.fn.stars = function() {
            return $(this).each(function() {
                $(this).html($('<span />').width(Math.max(0, (Math.min(5, parseFloat($(this).html())))) * 16));
            });
        }
</script>

@stop