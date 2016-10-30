@extends('tickets::ticketlayouts.ticketmaster')

@section('Dashboard')
    class="active"
@stop

@section('dashboard-bar')
    active
@stop

@section('dashboard')
    class="active"
@stop

@section('heading')
    <h1>All tickets</h1>
@stop

@section('content')
    <table class="table table-hover table-bordered table-striped" id="tickets-table">
        <thead>
        <tr>

            <th>Ticket NR</th>
            <th>Subject</th>
            <th>fk_relation_id</th>
            <th>priority_id</th>
            <th>Created at</th>
            <th>DEdline</th>
            <th>Assigned</th>

        </tr>
        </thead>


        <tfoot>
        <tr>

            <th>Ticket NR</th>
            <th>Subject</th>
            <th>fk_relation_id</th>
            <th>priority_id</th>
            <th>Created at</th>
            <th>DEdline</th>
            <th>Assigned</th>


        </tr>
        </tfoot>
    </table>
@stop

@push('scripts')
<script>
    $(function () {
        $('#tickets-table').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 50,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax: '{!! route('tickets.data') !!}',
            columns: [
                {data: 'ticketnumber', name: 'ticket_number'},
                {data: 'ticketsubjectlink', name: 'subject'},
                {data: 'relation_id', name: 'relation_id'},
                {data: 'priority_id', name: 'priority_id'},
                {data: 'created_at', name: 'created_at'},
                {data: 'deadline', name: 'deadline'},
                {data: 'assigned_to', name: 'assigned_to'},
            ]
        });
    });
</script>
@endpush