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


@section('ban')
    class="active"
@stop


    @section('HeadInclude')
    @stop
            <!-- header -->
@section('PageHeader')
    <h1>{{Lang::get('email::lang.banlists')}}</h1>

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

            <div class="box box-primary">
                <div class="box-header">
                    <h2 class="box-title">{{Lang::get('email::lang.banlists')}}</h2><a
                            href="{{route('banlist.create')}}"
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
                        <table class="table table-hover table-bordered table-striped dataTable" id="banlist-table" style="overflow:hidden;">
                                <thead>
                                <tr>
                                    <th width="100px">{{Lang::get('email::lang.email_address')}}</th>
                                    <th width="100px">{{Lang::get('email::lang.last_updated')}}</th>
                                    <th width="100px">{{Lang::get('email::lang.action')}}</th>
                                </tr>
                                </thead>


                                <tfoot>
                                    <tr>
                                        <th width="100px">{{Lang::get('email::lang.email_address')}}</th>
                                        <th width="100px">{{Lang::get('email::lang.last_updated')}}</th>
                                        <th width="100px">{{Lang::get('email::lang.action')}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                    </div>
            </div>


@stop

@push('scripts')
<script>
    $(function () {
        $('#banlist-table').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 50,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax: '{!! route('banlist.data') !!}',
            columns: [
                {data: 'email_address', name: 'email_address'},
                {data: 'last_updated', name: 'last_updated'},

                {data: 'actions', name: 'actions', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endpush
