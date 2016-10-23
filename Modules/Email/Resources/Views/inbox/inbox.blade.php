@extends('email::maillayouts.mailmaster')


@section('Mailboxes')
    class="active"
@stop

@section('mailpanel-bar')
    active
@stop

@section('allmailboxes')
    class="active"
    @stop


    @section('HeadInclude')
    @stop
            <!-- header -->
@section('PageHeader')
    <h1>{{Lang::get('email::lang.mailboxes')}}</h1>

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

    <div class="row" id="content">



        @if($errors->any())
            <div class="box-body">
                <div id="alert">
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4>{{$errors->first('msg')}}</h4>
                    </div>
                </div>
            </div>
        @endif





        <div class="box-body">
            <div class="pull-right">
            <button type="button" class="btn btn-default" onclick="getMail()">getMail</button>
            </div>
            <div id="alert" style="display:none;">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <div id="result"></div>
                </div>
            </div>
        </div>



        <div class="col-md-2">

            <ul id="tabs" class="nav nav-pills nav-stacked" data-tabs="tabs" role="tablist">
                <li class="active"><a href="#inbox" data-toggle="tab">Inbox</a></li>
                <li><a href="#sentitems" data-toggle="tab">Sent Items</a></li>
                <li><a href="#outbox" data-toggle="tab">Outbox</a></li>
                <li><a href="#recyclebin" data-toggle="tab">Recycle Bin</a></li>
                <li><a href="#folders" data-toggle="tab">Folders</a></li>
            </ul>
        </div>


        <div id="my-tab-content" class="col-md-10 tab-content">
            <div class="tab-pane active" id="inbox">
                INBOX
            </div>
            <div class="tab-pane" id="sentitems">
                <h1>Orange</h1>
                <p>orange orange orange orange orange</p>
            </div>
            <div class="tab-pane" id="outbox">
                <h1>Yellow</h1>
                <p>yellow yellow yellow yellow yellow</p>
            </div>
            <div class="tab-pane" id="recyclebin">
                <h1>Green</h1>
                <p>green green green green green</p>
            </div>
            <div class="tab-pane" id="folders">
                <h1>Blue</h1>
                <p>blue blue blue blue blue</p>
            </div>
        </div>

    </div>

@stop

@push('scripts')


<script type="text/javascript">
    function getMail() {
        if (typeof(EventSource) !== "undefined") {
            //var source = 
            $('#alert').show();
            var source = new EventSource("<?php echo route('getmail', [$mailbox->id]); ?>");

            source.addEventListener("message", function (event) {
                var myperfectdata = event.data;
                document.getElementById("result").innerHTML += event.data + "<br>";
                if (event.data == "end") {
                    source.close();
                    //$('#alert').hide().
                    console.log("closed");
                }
            }, false);

            source.addEventListener('userlogon', function (event) {
                var data = JSON.parse(event.data);
                console.log('User login:' + data.username);
            }, false);

            source.addEventListener('update', function (event) {
                var data = JSON.parse(event.data);
                console.log(data.username + ' is now ' + data.emotion);
            }, false);

            source.addEventListener('open', function (event) {
                // Connection was opened.
            }, false);

            source.addEventListener('error', function (event) {
                var txt;
                switch( event.target.readyState ){
                        // if reconnecting
                    case EventSource.CONNECTING:
                        txt = 'Reconnecting...';
                        document.getElementById("result").innerHTML += "<Hr><BR>AAARRGHHHH<br>";
                        source.close();
                        break;
                        // if error was fatal
                    case EventSource.CLOSED:
                        txt = 'break';
                        document.getElementById("result").innerHTML += "Connection failed. Will not retry." + "<br>";
                        break;
                }
                //alert(txt);

            }, false);


            var onerror = function(event){
                var txt;
                switch( event.target.readyState ){
                        // if reconnecting
                    case EventSource.CONNECTING:
                        txt = 'Reconnecting...';
                        break;
                        // if error was fatal
                    case EventSource.CLOSED:
                        txt = 'break';
                        document.getElementById("result").innerHTML += "Connection failed. Will not retry." + "<br>";
                        break;
                }
                alert(txt);
            }




        } else {
            document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
        }
    }
</script>

<script>
    $(function () {
        $('#mailboxes-table').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 50,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax: '{!! route('mailboxes.data') !!}',
            columns: [
                {data: 'mailboxlink', name: 'email_name'},
                {data: 'mailaddress', name: 'email_address'},
                {data: 'mailboxtype', name: 'mailbox_type'},
                {data: 'department', name: 'department_id'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endpush
