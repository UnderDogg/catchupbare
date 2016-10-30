@extends('tickets::maillayouts.ticketmaster')


@section('Templates')
    class="active"
@stop

@section('dashboard-bar')
    active
@stop

@section('profile')
    class="active"
    @stop


@section('HeadInclude')
@stop
            <!-- header -->
@section('PageHeader')
    <h1>{{Lang::get('tickets::lang.ticketstatuses')}}</h1>

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

    <h2>{!! Lang::get('tickets::lang.ticketstatuses') !!}</h2><a href="{{route('ticketstatuses.create')}}"
                                                          class="btn btn-primary pull-right">{{Lang::get('tickets::lang.create_ticketstatus')}}</a></h2>







    <table class="table table-hover table-bordered table-striped" id="ticketstatuses-table">
        <thead>
        <tr>
            <th>Name</th>
            <th>State</th>
            <th>Mode</th>
            <th>Has Flags</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Name</th>
            <th>State</th>
            <th>Mode</th>
            <th>Has Flags</th>
            <th>Actions</th>
        </tr>
        </tfoot>
    </table>
@stop

@push('scripts')
<script>
    $(function () {
        $('#ticketstatuses-table').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 50,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax: '{!! route('ticketstatuses.data') !!}',
            columns: [
                {data: 'ticketstatuslink', name: 'name'},
                {data: 'ticketstatusstate', name: 'state'},
                {data: 'ticketstatusmode', name: 'mode'},
                {data: 'ticketstatusflag', name: 'hasflags'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endpush
