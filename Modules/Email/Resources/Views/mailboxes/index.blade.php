@extends('email::maillayouts.mailmaster')


@section('Mailboxes')
    active
@stop

@section('mailboxes-bar')
    active
@stop

@section('Mailboxes')
    class="active"
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
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h2 class="box-title">{{Lang::get('email::lang.banlists')}}</h2><a href="{{route('banlist.create')}}"
                                                                                      class="pull-right btn btn-primary">{{Lang::get('email::lang.ban_email')}}</a>
                </div>

                <!-- check whether success or not -->

                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissable">
                        <i class="fa  fa-check-circle"></i>
                        <b>Success!</b>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{Session::get('success')}}
                    </div>
                @endif
                            <!-- failure message -->
                @if(Session::has('fails'))
                        <div class="alert alert-danger alert-dismissable">
                            <i class="fa fa-ban"></i>
                            <b>Fail!</b>
                            <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                            {{Session::get('fails')}}
                        </div>
                @endif


                <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped dataTable" style="overflow:hidden;">
                            <tr>
                                <th width="100px">{{Lang::get('email::lang.email_address')}}</th>
                                <th width="100px">{{Lang::get('email::lang.last_updated')}}</th>
                                <th width="100px">{{Lang::get('email::lang.action')}}</th>
                            </tr>
                            <tr>
                                <th width="100px">{{Lang::get('email::lang.email_address')}}</th>
                                <th width="100px">{{Lang::get('email::lang.last_updated')}}</th>
                                <th width="100px">{{Lang::get('email::lang.action')}}</th>
                            </tr>
                        </table>
                </div>
            </div>
        </div>
    </div>


    <h2>{!! Lang::get('email::lang.mailboxes') !!}<a href="{{route('admin.mailboxes.mailbox.create')}}" class="btn btn-primary pull-right">{{Lang::get('email::lang.create_mailbox')}}</a></h2>

    <table class="table table-hover table-bordered table-striped" id="mailboxes-table">
        <thead>
        <tr>
            <th>Mailbox</th>
            <th>Email Address</th>
            <th>Mailbox Type</th>

            <th>Active?</th>
            <th>Fetching Status</th>
            <th>Sending Status</th>


            <th>Department</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Mailbox</th>
            <th>Email Address</th>
            <th>Mailbox Type</th>

            <th>Active?</th>
            <th>Fetching Status</th>
            <th>Sending Status</th>

            <th>Department</th>
            <th>Actions</th>
        </tr>
        </tfoot>
    </table>
@stop

@push('scripts')
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

                {data: 'isactive', name: 'isactive'},
                {data: 'fetching_status', name: 'fetching_status'},
                {data: 'sending_status', name: 'sending_status'},


                {data: 'department', name: 'department_id'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endpush
