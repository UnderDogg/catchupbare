@extends('tickets::ticketlayouts.ticketmaster')

@section('Tickets')
class="active"
@stop

@section('ticket-bar')
active
@stop

@section('inbox')
class="active"
@stop

@section('heading')
    <h1>All tickets</h1>
@stop

@section('PageHeader')
<h1>{{Lang::get('tickets::lang.tickets')}}</h1>
@stop



@section('content')

            <?php
            //$date_time_format = UTC::getDateTimeFormat();
            if (Auth::guard('staff')->user()->role == 'agent') {
                $dept = Modules\Core\Models\Department::where('id', '=', Auth::guard('staff')->user()->primary_dpt)->first();
                $tickets = Modules\Tickets\Models\Ticket::where('ticketstatus_id', '=', 1)->where('dept_id', '=', $dept->id)->orderBy('id', 'DESC')->paginate(20);
            } else {
                $tickets = Modules\Tickets\Models\Ticket::where('ticketstatus_id', '=', 1)->orderBy('id', 'DESC')->paginate(20);
            }
            ?>
<!-- Main content -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('tickets::lang.inbox') !!} </h3> <small id="title_refresh">{!! $tickets->total() !!} {!! Lang::get('tickets::lang.tickets') !!}</small>
    </div><!-- /.box-header -->

    <div class="box-body ">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"> </i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"> </i> <b> {!! Lang::get('tickets::lang.alert') !!}! </b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
        {!! Form::open(['id'=>'modalpopup', 'route'=>'select_all','method'=>'post']) !!}
        <!--<div class="mailbox-controls">-->
            <!-- Check all button -->
            <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
            {{-- <a class="btn btn-default btn-sm" id="click"><i class="fa fa-refresh"></i></a> --}}
            <input type="submit" class="submit btn btn-default text-orange btn-sm" id="delete" name="submit" value="{!! Lang::get('tickets::lang.delete') !!}">
            <input type="submit" class="submit btn btn-default text-yellow btn-sm" id="close" name="submit" value="{!! Lang::get('tickets::lang.close') !!}">
            <button type="button" class="btn btn-sm btn-default text-green" id="Edit_Ticket" data-toggle="modal" data-target="#MergeTickets"><i class="fa fa-code-fork"> </i> {!! Lang::get('tickets::lang.merge') !!}</button>
        <!--</div>-->
        <p><p/>
        <div class="mailbox-messages" id="refresh">
            <!--datatable-->


    <table class="table table-hover table-bordered table-striped" id="tickets-table">
        <thead>
        <tr>

            <th>{{Lang::get('tickets::lang.ticketnr')}}</th>
            <th>{{Lang::get('tickets::lang.ticketsubject')}}</th>
            <th>{{Lang::get('tickets::lang.ticketpriority')}}</th>
            <th>{{Lang::get('tickets::lang.customer')}}</th>
            <th>{{Lang::get('tickets::lang.assigned_to')}}</th>
            <th>{{Lang::get('tickets::lang.last_activity')}}</th>
            <th>{{Lang::get('tickets::lang.created_at')}}</th>
            <th>{{Lang::get('tickets::lang.ticketdeadline')}}</th>

        </tr>
        </thead>


        <tfoot>
        <tr>

            <th>{{Lang::get('tickets::lang.ticketnr')}}</th>
            <th>{{Lang::get('tickets::lang.ticketsubject')}}</th>
            <th>{{Lang::get('tickets::lang.ticketpriority')}}</th>
            <th>{{Lang::get('tickets::lang.customer')}}</th>
            <th>{{Lang::get('tickets::lang.assigned_to')}}</th>
            <th>{{Lang::get('tickets::lang.last_activity')}}</th>
            <th>{{Lang::get('tickets::lang.created_at')}}</th>
            <th>{{Lang::get('tickets::lang.ticketdeadline')}}</th>


        </tr>
        </tfoot>
    </table>




        </div><!-- /.mail-box-messages -->
        {!! Form::close() !!}
    </div><!-- /.box-body -->
</div><!-- /. box -->









<!-- merge tickets modal -->
<div class="modal fade" id="MergeTickets">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="merge-close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{!! Lang::get('tickets::lang.merge-ticket') !!} </h4>
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
                                    <!--<button id="dismiss-merge" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>-->
                                    <h4><i class="icon fa fa-check"></i>{!! Lang::get('tickets::lang.alert') !!}!</h4>
                                    <div id="message-merge-succ"></div>
                                </div>
                                <div id="merge-err-alert" class="alert alert-danger alert-dismissable" style="display:none;">
                                    <!--<button id="dismiss-merge2" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>-->
                                    <h4><i class="icon fa fa-ban"></i>{!! Lang::get('tickets::lang.alert') !!}!</h4>
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
                                <input type="text" name='title' class="form-control" value="" placeholder="Optional" />
                            </div>
                            <div class="col-md-6">
                                <label>{!! Lang::get('tickets::lang.select-pparent-ticket') !!}</label>
                                <select class="form-control" id="select-merge-parent"  name='p_id' data-placeholder="{!! Lang::get('tickets::lang.select_tickets') !!}" style="width: 100%;"><option value=""></option></select>
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

<!-- Modal -->   
<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; padding-right: 15px;background-color: rgba(0, 0, 0, 0.7);">
    <div class="modal-dialog" role="document">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close closemodal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body" id="custom-alert-body" >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary pull-left yes" data-dismiss="modal">{{Lang::get('tickets::lang.ok')}}</button>
                    <button type="button" class="btn btn-default no">{{Lang::get('tickets::lang.cancel')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var t_id = [];
    var option = null;
    $(function() {
        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function() {
            var clicks = $(this).data('clicks');
            if (clicks) {
                //Uncheck all checkboxes
                $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
            } else {
                //Check all checkboxes
                $(".mailbox-messages input[type='checkbox']").iCheck("check");
                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
            }
            $(this).data("clicks", !clicks);
        });
    });

    $(function() {
        // Enable check and uncheck all functionality

        $(".checkbox-toggle").click(function() {
            var clicks = $(this).data('clicks');
            if (clicks) {
                //Uncheck all checkboxes
                $("input[type='checkbox']", ".mailbox-messages").iCheck("uncheck");
                // alert($("input[type='checkbox']").val());
                t_id = $('.selectval').map(function() {
                    return $(this).val();
                }).get();
                // alert(checkboxValues);
            } else {
                //Check all checkboxes
                $("input[type='checkbox']", ".mailbox-messages").iCheck("check");
                // alert('Hallo');
                t_id = [];
            }
            $(this).data("clicks", !clicks);

        });


    });


    $(document).ready(function() { /// Wait till page is loaded
        $('#click').click(function() {
            $('#refresh').load('inbox #refresh');
            $('#title_refresh').load('inbox #title_refresh');
            $('#count_refresh').load('inbox #count_refresh');
            $("#show").show();
        });

        $(".select2").select2();

        $('#delete').on('click', function() {
            option = 0;
            $('#myModalLabel').html("{{Lang::get('tickets::lang.delete-tickets')}}");
        });

        $('#close').on('click', function() {
            option = 1;
            $('#myModalLabel').html("{{Lang::get('tickets::lang.close-tickets')}}");
        });

        $("#modalpopup").on('submit', function(e) {
            e.preventDefault();
            var msg = "{{Lang::get('tickets::lang.confirm')}}";
            var values = getValues();
            if (values == "") {
                msg = "{{Lang::get('tickets::lang.select-ticket')}}";
                $('.yes').html("{{Lang::get('tickets::lang.ok')}}");
                $('#myModalLabel').html("{{Lang::get('tickets::lang.alert')}}");
            } else {
                $('.yes').html("Yes");
            }
            $('#custom-alert-body').html(msg);
            $("#myModal").css("display", "block");
        });

        $(".closemodal, .no").click(function() {
            $("#myModal").css("display", "none");
        });

        $(".closemodal, .no").click(function() {
            $("#myModal").css("display", "none");
        });

        $('.yes').click(function() {
            var values = getValues();
            if (values == "") {
                $("#myModal").css("display", "none");
            } else {
                $("#myModal").css("display", "none");
                $("#modalpopup").unbind('submit');
                if (option == 0) {
                    //alert('delete');
                    $('#delete').click();
                } else {
                    //alert('close');
                    $('#close').click();
                }
            }
        });

        function getValues() {
            var values = $('.selectval:checked').map(function() {
                return $(this).val();
            }).get();
            return values;
        }

        //checking merging tickets
        $('#MergeTickets').on('show.bs.modal', function() {

            // alert("hi");
            $.ajax({
                type: "GET",
                url: "{{route('check.merge.tickets',0)}}",
                dataType: "html",
                data: {data1: t_id},
                beforeSend: function() {
                    $("#merge_body").hide();
                    $("#merge_loader").show();
                },
                success: function(response) {
                    if (response == 0) {
                        $("#merge_body").show();
                        $("#merge-succ-alert").hide();
                        $("#merge-body-alert").show();
                        $("#merge-body-form").hide();
                        $("#merge_loader").hide();
                        $("#merge-btn").attr('disabled', true);
                        var message = "{{Lang::get('tickets::lang.select-tickets-to-merge')}}";
                        $("#merge-err-alert").show();
                        $('#message-merge-err').html(message);

                    } else if (response == 2) {
                        $("#merge_body").show();
                        $("#merge-succ-alert").hide();
                        $("#merge-body-alert").show();
                        $("#merge-body-form").hide();
                        $("#merge_loader").hide();
                        $("#merge-btn").attr('disabled', true);
                        var message = "{{Lang::get('tickets::lang.different-users')}}";
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
                            url: "{{ route('get.merge.tickets',0) }}",
                            dataType: "html",
                            data: {data1: t_id},
                            success: function(data) {
                                $('#select-merge-parent').html(data);
                            }
                            // return false;
                        });
                    }
                }
            });
        });

        //submit merging form
        $('#merge-form').on('submit', function() {
            $.ajax({
                type: "POST",
                url: "{!! url('merge-tickets/') !!}/" + t_id,
                dataType: "json",
                data: $(this).serialize(),
                beforeSend: function() {
                    $("#merge_body").hide();
                    $("#merge_loader").show();
                },
                success: function(response) {
                    if (response == 0) {
                        $("#merge_body").show();
                        $("#merge-succ-alert").hide();
                        $("#merge-body-alert").show();
                        $("#merge-body-form").hide();
                        $("#merge_loader").hide();
                        $("#merge-btn").attr('disabled', true);
                        var message = "{{Lang::get('tickets::lang.merge-error')}}";
                        $("#merge-err-alert").show();
                        $('#message-merge-err').html(message);
                    } else {
                        $("#merge_body").show();
                        $("#merge-err-alert").hide();
                        $("#merge-body-alert").show();
                        $("#merge-body-form").hide();
                        $("#merge_loader").hide();
                        $("#merge-btn").attr('disabled', true);
                        var message = "{{Lang::get('tickets::lang.merge-success')}}";
                        $("#merge-succ-alert").show();
                        $('#message-merge-succ').html(message);
                        setInterval(function() {
                            $("#alert11").hide();
                            setTimeout(function() {
                                var link = document.querySelector('#load-inbox');
                                if (link) {
                                    link.click();
                                }
                            }, 100);
                        }, 1000);
                    }
                }
            })
            return false;
        });
    });

    function someFunction(id) {
        if (document.getElementById(id).checked) {
            t_id.push(id);
            // alert(t_id);
        } else if(document.getElementById(id).checked === undefined){
            var index = t_id.indexOf(id);
            if (index === -1){
                t_id.push(id);
            } else{
                t_id.splice(index, 1);
            }
        } else {
            var index = t_id.indexOf(id);
            t_id.splice(index, 1);
            // alert(t_id);
        }
    }
</script>
@stop

@push('scripts')
<script>
    $(function () {
        $('#tickets-table').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 50,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax: '{!! route('get.inbox.ticket') !!}',
            columns: [
                {data: 'ticketnumber', name: 'ticket_number'},
                {data: 'ticketsubjectlink', name: 'subject'},
                {data: 'priority_id', name: 'priority_id'},
                {data: 'relation_id', name: 'relation_id'},
                {data: 'assigned_to', name: 'assigned_to'},
                {data: 'last_activity', name: 'last_activity'},
                {data: 'created_at', name: 'created_at'},
                {data: 'deadline', name: 'deadline'},

            ]
        });
    });
</script>
@endpush