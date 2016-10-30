@extends('layouts.master')

@section('heading')

@stop

@section('content')

    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });


    </script>

    <div class="row">
        @include('partials.relationheader')
        @include('partials.userheader')


    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="ticketcase">

                <h3>{{$tickets->title}}</h3>
                <hr class="grey">
                <p>{{$tickets->description}}</p>
                <p class="smalltext">Created at:
                    {{ date('d F, Y, H:i:s', strtotime($tickets->created_at))}}
                    @if($tickets->updated_at != $tickets->created_at)
                        <br/>Modified at: {{date('d F, Y, H:i:s', strtotime($tickets->updated_at))}}
                    @endif</p>


            </div>

            <?php $count = 0;?>

            <?php $i = 1 ?>
            @foreach($tickets->comments as $comment)
                <div class="ticketcase" style="margin-top:15px; padding-top:10px;">
                    <p class="smalltext">#{{$i++}}</p>
                    <p>  {{$comment->description}}</p>
                    <p class="smalltext">Comment by: <a
                                href="{{route('staff.show', $comment->user->id)}}"> {{$comment->user->name}} </a></p>
                    <p class="smalltext">Created at:
                        {{ date('d F, Y, H:i:s', strtotime($comment->created_at))}}
                        @if($comment->updated_at != $comment->created_at)
                            <br/>Modified at: {{date('d F, Y, H:i:s', strtotime($comment->updated_at))}}
                        @endif</p>
                </div>
            @endforeach
            <br/>
            {!! Form::open(array('url' => array('/tickets/comments',$tickets->id, ))) !!}
            <div class="form-group">
                {!! Form::textarea('description', null, ['class' => 'form-control']) !!}

                {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}

        </div>
        <div class="col-md-3">
            <div class="sidebarheader">
                <p>Ticket information</p>
            </div>
            <div class="sidebarbox">
                <p>Assigned to:
                    <a href="{{route('staff.show', $tickets->assignee->id)}}">
                        {{$tickets->assignee->name}}</a></p>
                <p>Created at: {{ date('d F, Y, H:i', strtotime($tickets->created_at))}} </p>

                @if($tickets->days_until_deadline)
                    <p>Deadline: <span style="color:red;">{{date('d, F Y', strTotime($tickets->deadline))}}

                            @if($tickets->status == 1)({!! $tickets->days_until_deadline !!})@endif</span></p>
                    <!--Remove days left if tickets is completed-->

                @else
                    <p>Deadline: <span style="color:green;">{{date('d, F Y', strTotime($tickets->deadline))}}

                            @if($tickets->status == 1)({!! $tickets->days_until_deadline !!})@endif</span></p>
                    <!--Remove days left if tickets is completed-->
                @endif

                @if($tickets->status == 1)
                    Ticket status: Open
                @else
                    Ticket status: Closed
                @endif
            </div>
            @if($tickets->status == 1)

                {!! Form::model($tickets, [
               'method' => 'PATCH',
                'url' => ['tickets/updateassign', $tickets->id],
                ]) !!}
                {!! Form::select('assigned_to_staff_id', $users, null, ['class' => 'form-control ui search selection top right pointing search-select', 'id' => 'search-select']) !!}
                {!! Form::submit('Assign new user', ['class' => 'btn btn-primary form-control closebtn']) !!}
                {!! Form::close() !!}

                {!! Form::model($tickets, [
                  'method' => 'PATCH',
                  'url' => ['tickets/updatestatus', $tickets->id],
                  ]) !!}

                {!! Form::submit('Close ticket', ['class' => 'btn btn-success form-control closebtn']) !!}
                {!! Form::close() !!}

            @endif
            <div class="sidebarheader">
                <p>Time Managment</p>
            </div>
            <table class="table table_wrapper ">
                <tr>
                    <th>Title</th>
                    <th>Time</th>
                </tr>
                <tbody>
                @foreach($tickettimes as $tickettime)
                    <tr>
                        <td style="padding: 5px">{{$tickettime->title}}</td>
                        <td style="padding: 5px">{{$tickettime->time}} </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <br/>
            <button type="button" class="btn btn-primary form-control" data-toggle="modal" data-target="#ModalTimer">
                Add Time
            </button>

            <button type="button" class="btn btn-primary form-control movedown" data-toggle="modal"
                    data-target="#myModal">
                Create Invoice
            </button>

            <div class="activity-feed movedown">
                @foreach($tickets->activity as $activity)
                    <div class="feed-item">
                        <div class="activity-date">{{date('d, F Y H:i', strTotime($activity->created_at))}}</div>
                        <div class="activity-text">{{$activity->text}}</div>

                    </div>
                @endforeach
            </div>
            <div class="modal fade" id="ModalTimer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Time Managment For This Ticket
                                ({{$tickets->title}})</h4>
                        </div>

                        <div class="modal-body">

                            {!! Form::open([
                            'method' => 'post',
                            'url' => ['tickets/updatetime', $tickets->id],
                            ]) !!}

                            <div class="form-group">
                                {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
                                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Fx Consultation Meeting']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('comment', 'Description:', ['class' => 'control-label']) !!}
                                {!! Form::textarea('comment', null, ['class' => 'form-control', 'placeholder' => 'Short Comment about whats done(Will show on Invoice)']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('value', 'Hourly price(EUR / $$):', ['class' => 'control-label']) !!}
                                {!! Form::text('value', null, ['class' => 'form-control', 'placeholder' => '300']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('time', 'Time spend (Hours):', ['class' => 'control-label']) !!}
                                {!! Form::text('time', null, ['class' => 'form-control', 'placeholder' => '3']) !!}
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default col-lg-6" data-dismiss="modal">Close</button>
                            <div class="col-lg-6">
                                {!! Form::submit('Register time', ['class' => 'btn btn-success form-control closebtn']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Create Invoice</h4>
                        </div>

                        <div class="modal-body">

                            {!! Form::model($tickets, [
                       'method' => 'POST',
                       'url' => ['tickets/invoice', $tickets->id],
                       ]) !!}
                            @if($apiconnected)
                                @foreach ($contacts as $key => $contact)
                                    {!! Form::radio('invoiceContact', $contact['guid']) !!}
                                    {{$contact['name']}}
                                    <br/>
                                @endforeach
                                {!! Form::label('mail', 'Send mail with invoice to Customer?(Cheked = Yes):', ['class' => 'control-label']) !!}
                                {!! Form::checkbox('sendMail', true) !!}
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default col-lg-6" data-dismiss="modal">Close</button>
                            <div class="col-lg-6">
                                {!! Form::submit('Create Invoice', ['class' => 'btn btn-success form-control closebtn']) !!}
                            </div>
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop