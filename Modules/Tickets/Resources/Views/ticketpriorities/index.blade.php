@extends('tickets::maillayouts.ticketmaster')

@section('Templates')
    active
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
    <h1>{{Lang::get('tickets::lang.ticketpriorities')}}</h1>

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

    <h2>{!! Lang::get('tickets::lang.ticketpriorities') !!}</h2><a href="{{route('ticketpriorities.create')}}"
                                                          class="btn btn-primary pull-right">{{Lang::get('tickets::lang.create_ticketpriority')}}</a></h2>

    <table class="table table-hover table-bordered table-striped" id="ticketpriorities-table">
        <thead>
        <tr>
            <th>Priority</th>
            <th>Color</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Priority</th>
            <th>Color</th>
            <th>Actions</th>
        </tr>
        </tfoot>
    </table>
@stop

@push('scripts')
<script>
    $(function () {
        $('#ticketpriorities-table').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 50,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax: '{!! route('ticketpriorities.data') !!}',
            columns: [
                {data: 'ticketpriolink', name: 'priority'},
                {data: 'ticketpriocolor', name: 'priority_color'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endpush
