@extends('clientlayouts.client')

@section('title')
    My Tickets -
@stop

@section('breadcrumb')

    <div class="site-hero clearfix">
        <ol class="breadcrumb breadcrumb-custom">
            <li class="text">{!! Lang::get('helpdesk::tickets.you_are_here') !!}:</li>
            <li class="active"><a
                        href="{!! URL::route('ticket2') !!}">{!! Lang::get('helpdesk::tickets.my_tickets') !!}</a></li>
        </ol>
    </div>
@stop
@section('myticket')
    class="active"
    @stop
    @section('content')
            <!-- Main content -->
    <div id="content" class="site-content col-md-12">
        <?php
        $open = Modules\Tickets\Models\Ticket::where('user_id', '=', Auth::guard('staff')->user()->id)
                ->where('status_id', '=', 1)
                ->orderBy('id', 'DESC')
                ->paginate(20);
        ?>

        <?php
        $close = Modules\Tickets\Models\Ticket::where('user_id', '=', Auth::guard('staff')->user()->id)
                ->whereIn('status_id', [99, 3])
                ->orderBy('id', 'DESC')
                ->paginate(20);
        ?>

                <!-- Client / Users / Ticket Tabs Start -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab"
                                      aria-expanded="true">{!! Lang::get('helpdesk::tickets.opened') !!}
                        <small class="label bg-orange">{!! $open->total() !!}</small>
                    </a></li>
                <li class=""><a href="#tab_2" data-toggle="tab"
                                aria-expanded="false">{!! Lang::get('helpdesk::tickets.closed') !!}
                        <small class="label bg-green">{!! $close->total() !!}</small>
                    </a></li>
            </ul>


            <div class="tab-content">
                {{-- tab_1 --}}
                <div class="tab-pane active" id="tab_1">
                    {!! Form::open(['route'=>'select_all','method'=>'post']) !!}
                    <div class="mailbox-controls">
                        <!-- Check all button -->
                        <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
                        <a class="btn btn-default btn-sm" id="click1"><i class="fa fa-refresh"></i></a>
                        <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit"
                               value="{!! Lang::get('helpdesk::tickets.close') !!}">
                        <div class="pull-right" id="refresh21">
                            {!! $open->count().'-'.$open->total(); !!}
                        </div>
                    </div>
                    <div class=" table-responsive client-tickets" id="refresh1">
                        <p style="display:none;text-align:center; position:fixed; margin-left:37%;margin-top:-80px;"
                           id="show1" class="text-red"><b>Loading...</b></p>
                        <!-- table -->
                        <table class="table table-hover table-striped">
                            <thead>
                            <th></th>
                            <th>
                                {!! Lang::get('helpdesk::tickets.subject') !!}
                            </th>
                            <th>
                                {!! Lang::get('helpdesk::tickets.ticket_id') !!}
                            </th>
                            <th>
                                {!! Lang::get('helpdesk::tickets.priority') !!}
                            </th>
                            <th>
                                {!! Lang::get('helpdesk::tickets.last_replier') !!}
                            </th>
                            <th>
                                {!! Lang::get('helpdesk::tickets.last_activity') !!}
                            </th>
                            <th>
                                {!! Lang::get('helpdesk::tickets.status') !!}
                            </th>
                            </thead>
                            <tbody id="hello">
                            @foreach ($open  as $ticket )
                                <tr <?php if ($ticket->seen_by == null) {?> style="color:green;" <?php }
                                        ?> >
                                    <td><input type="checkbox" class="icheckbox_flat-blue" name="select_all[]"
                                               value="{{$ticket->id}}"/>
                                    </td>
                                    <?php
                                    $title = Modules\Tickets\Models\TicketThread::where('ticket_id', '=', $ticket->id)->first();
                                    $string = isset($title->title) ? strip_tags($title->title) : "title missing";
                                    if (strlen($string) > 40) {
                                        $stringCut = substr($string, 0, 40);
                                        $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . ' ...';
                                    }
                                    $TicketData = Modules\Tickets\Models\TicketThread::where('ticket_id', '=', $ticket->id)->max('id');
                                    $TicketDatarow = Modules\Tickets\Models\TicketThread::where('id', '=', $TicketData)->first();

                                    if ($TicketDatarow == null) {
                                        echo "TicketDatarow is null";
                                        dd($ticket);
                                        dd($TicketDatarow);
                                    }

                                    $LastResponse = Modules\Core\Models\User::where('id', '=', $TicketDatarow->user_id)->first();

                                    if ($LastResponse == null) {
                                        $LastResponse = Modules\Employees\Models\Employee::where('id', '=', $TicketDatarow->staff_id)->first();
                                    }

                                    if ($LastResponse->userRole->role == "user" || $LastResponse->userRole->role == "client" || $LastResponse->userRole->role == "clienthead") {
                                        $rep = "#F39C12";
                                        $username = $LastResponse->user_name;
                                    } else {
                                        /*
                                         *  Staff
                                         **/
                                        $rep = "#000";
                                        $username = $LastResponse->first_name . " " . $LastResponse->last_name;
                                        if ($LastResponse->first_name == null || $LastResponse->last_name == null) {
                                            $username = $LastResponse->user_name;
                                        }
                                    }
                                    $titles = Modules\Tickets\Models\TicketThread::where('ticket_id', '=', $ticket->id)->get();

                                    $count = count($titles);
                                    foreach ($titles as $title) {
                                        //$title = $title;
                                    }   ?>
                                    <td class="mailbox-name"><a
                                                href="{!! URL('check_ticket',[Crypt::encrypt($ticket->id)]) !!}"
                                                title="{!! $title->title !!}">{{$string}}   </a> ({!! $count!!}) <i
                                                class="fa fa-comment"></i></td>
                                    <td class="mailbox-Id">#{!! $ticket->ticket_number !!}</td>
                                    <?php
                                    $priority = Modules\Tickets\Models\TicketPriority::where('id', '=', $ticket->priority_id)->first();
                                    ?>
                                    <td class="mailbox-priority">
                                        <span class="btn btn-{{$priority->priority_color}} btn-xs">{{$priority->priority}}</span>
                                    </td>
                                    <td class="mailbox-last-reply" style="color: {!! $rep !!}">{!! $username !!}</td>
                                    <td class="mailbox-last-activity">{!! $title->updated_at !!}</td>
                                    <?php $status = Modules\Tickets\Models\TicketStatus::where('id', '=', $ticket->status_id)->first(); ?>
                                    <td class="mailbox-date">{!! $status->name !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <th></th>
                            <th>
                                {!! Lang::get('helpdesk::tickets.subject') !!}
                            </th>
                            <th>
                                {!! Lang::get('helpdesk::tickets.ticket_id') !!}
                            </th>
                            <th>
                                {!! Lang::get('helpdesk::tickets.priority') !!}
                            </th>
                            <th>
                                {!! Lang::get('helpdesk::tickets.last_replier') !!}
                            </th>
                            <th>
                                {!! Lang::get('helpdesk::tickets.last_activity') !!}
                            </th>
                            <th>
                                {!! Lang::get('helpdesk::tickets.status') !!}
                            </th>
                            </tfoot>
                        </table><!-- /.table -->
                        <div class="pull-right">
                            <?php echo $open->setPath(url('mytickets'))->render();?>&nbsp;
                        </div>
                    </div><!-- /.mail-box-messages -->
                    {!! Form::close() !!}
                </div><!-- /.box-body --><!-- /"tab-pane active" id="tab_1" -->{{-- /.tab_1 --}}

                @if($close->count() > 0)
                    {{-- tab_2 --}}
                    <div class="tab-pane" id="tab_2">
                        {!! Form::open(['route'=>'select_all','method'=>'post']) !!}
                        <div class="mailbox-controls">
                            <!-- Check all button -->
                            <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
                            <a class="btn btn-default btn-sm" id="click2"><i class="fa fa-refresh"></i></a>
                            <input type="submit" class="btn btn-default text-blue btn-sm" name="submit"
                                   value="{!! Lang::get('helpdesk::tickets.open') !!}">
                            <div class="pull-right" id="refresh22">
                                {!! $close->count().'-'.$close->total(); !!}
                            </div>
                        </div>
                        <div class=" table-responsive client-tickets" id="refresh2">
                            <p style="display:none;text-align:center; position:fixed; margin-left:40%;margin-top:-70px;"
                               id="show2"
                               class="text-red"><b>Loading...</b></p>
                            <!-- table -->
                            <table class="table table-hover table-striped">
                                <thead>
                                <th></th>
                                <th>
                                    {!! Lang::get('helpdesk::tickets.subject') !!}
                                </th>
                                <th>
                                    {!! Lang::get('helpdesk::tickets.ticket_id') !!}
                                </th>
                                <th>
                                    {!! Lang::get('helpdesk::tickets.priority') !!}
                                </th>
                                <th>
                                    {!! Lang::get('helpdesk::tickets.last_replier') !!}
                                </th>
                                <th>
                                    {!! Lang::get('helpdesk::tickets.last_activity') !!}
                                </th>
                                <th>
                                    {!! Lang::get('helpdesk::tickets.status') !!}
                                </th>
                                </thead>
                                <tbody id="hello">
                                @foreach ($close  as $ticket )
                                    <tr <?php if ($ticket->seen_by == null) {?> style="color:green;" <?php }
                                            ?> >
                                        <td><input type="checkbox" class="icheckbox_flat-blue" name="select_all[]"
                                                   value="{{$ticket->id}}"/>
                                        </td>
                                        <?php $title = Modules\Tickets\Models\TicketThread::where('ticket_id', '=', $ticket->id)->first();
                                        $string = strip_tags($title->title);
                                        if (strlen($string) > 40) {
                                            $stringCut = substr($string, 0, 40);
                                            $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . ' ...';
                                        }
                                        $TicketData = Modules\Tickets\Models\TicketThread::where('ticket_id', '=', $ticket->id)->max('id');
                                        $TicketDatarow = Modules\Tickets\Models\TicketThread::where('id', '=', $TicketData)->first();
                                        $LastResponse = Modules\Core\Models\User::where('id', '=', $TicketDatarow->user_id)->first();

                                        if ($LastResponse == null) {
                                            $LastResponse = Modules\Employees\Models\Employee::where('id', '=', $TicketDatarow->staff_id)->first();
                                        }

                                        if ($LastResponse->userRole->role == "user" || $LastResponse->userRole->role == "client" || $LastResponse->userRole->role == "clienthead") {
                                            $rep = "#F39C12";
                                            $username = $LastResponse->user_name;
                                        } else {
                                            $rep = "#000";
                                            $username = $LastResponse->first_name . " " . $LastResponse->last_name;
                                            if ($LastResponse->first_name == null || $LastResponse->last_name == null) {
                                                $username = $LastResponse->user_name;
                                            }
                                        }
                                        $titles = Modules\Tickets\Models\TicketThread::where('ticket_id', '=', $ticket->id)->get();
                                        $count = count($titles);
                                        /*foreach ($titles as $title) {
                                          //$title = $title;
                                        }*/
                                        ?>
                                        <td class="mailbox-name"><a href="{!! URL('check_ticket',$ticket->id) !!}"
                                                                    title="{!! $title->title !!}">{{$string}}   </a>
                                            ({!! $count!!}) <i
                                                    class="fa fa-comment"></i></td>
                                        <td class="mailbox-Id">#{!! $ticket->ticket_number !!}</td>
                                        <?php $priority = Modules\Tickets\Models\TicketPriority::where('id', '=', $ticket->priority_id)->first();?>
                                        <td class="mailbox-priority">
                                            <span class="btn btn-{{$priority->priority_color}} btn-xs">{{$priority->priority}}</span>
                                        </td>

                                        <td class="mailbox-last-reply"
                                            style="color: {!! $rep !!}">{!! $username !!}</td>
                                        <td class="mailbox-last-activity">{!! $title->updated_at !!}</td>
                                        <?php $status = Modules\Tickets\Models\TicketStatus::where('id', '=', $ticket->status_id)->first(); ?>
                                        <td class="mailbox-date">{!! $status->name !!}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <th></th>
                                <th>
                                    {!! Lang::get('helpdesk::tickets.subject') !!}
                                </th>
                                <th>
                                    {!! Lang::get('helpdesk::tickets.ticket_id') !!}
                                </th>
                                <th>
                                    {!! Lang::get('helpdesk::tickets.priority') !!}
                                </th>
                                <th>
                                    {!! Lang::get('helpdesk::tickets.last_replier') !!}
                                </th>
                                <th>
                                    {!! Lang::get('helpdesk::tickets.last_activity') !!}
                                </th>
                                <th>
                                    {!! Lang::get('helpdesk::tickets.status') !!}
                                </th>
                                </tfoot>
                            </table><!-- /.table -->
                            <div class="pull-right">
                                <?php echo $close->setPath(url('mytickets'))->render();?>&nbsp;
                            </div>
                        </div><!-- /.mail-box-messages -->
                        {!! Form::close() !!}
                    </div><!-- /"tab-pane" id="tab_2" -->{{-- /.tab_2 --}}
                @endif
            </div><!-- /. box -->
        </div><!-- /Client Ticket Tabs Start -->
    </div>
    <script>
        $(function () {
            //Enable check and uncheck all functionality
            $(".checkbox-toggle").click(function () {
                var clicks = $(this).data('clicks');
                if (clicks) {
                    //Uncheck all checkboxes
                    $(".client-tickets input[type='checkbox']").iCheck("uncheck");
                    $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                } else {
                    //Check all checkboxes
                    $(".client-tickets input[type='checkbox']").iCheck("check");
                    $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
                }
                $(this).data("clicks", !clicks);
            });
        });

        $(function () {
            // Enable check and uncheck all functionality
            $(".checkbox-toggle").click(function () {
                var clicks = $(this).data('clicks');
                if (clicks) {
                    //Uncheck all checkboxes
                    $("input[type='checkbox']", ".client-tickets").iCheck("uncheck");
                } else {
                    //Check all checkboxes
                    $("input[type='checkbox']", ".client-tickets").iCheck("check");
                }
                $(this).data("clicks", !clicks);
            });
        });

        $(document).ready(function () { /// Wait till page is loaded
            $('#click1').click(function () {
                $('#refresh1').load('mytickets #refresh1');
                $('#refresh21').load('mytickets #refresh21');
                $("#show1").show();
            });
        });

        $(document).ready(function () { /// Wait till page is loaded
            $('#click2').click(function () {
                $('#refresh2').load('mytickets #refresh2');
                $('#refresh22').load('mytickets #refresh22');
                $("#show2").show();
            });
        });
    </script>
@stop