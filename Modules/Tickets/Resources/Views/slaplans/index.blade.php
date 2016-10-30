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
    <table class="table table-hover table-bordered table-striped" id="slaplans-table">
        <thead>
        <tr>

            <th>{{Lang::get('tickets::lang.name')}}</th>
            <th>{{Lang::get('tickets::lang.status')}}</th>
            <th>{{Lang::get('tickets::lang.grace_period')}}</th>
            <th>Actions</th>
        </tr>
        </thead>


        <tfoot>
        <tr>
            <th>{{Lang::get('tickets::lang.name')}}</th>
            <th>{{Lang::get('tickets::lang.status')}}</th>
            <th>{{Lang::get('tickets::lang.grace_period')}}</th>
            <th>Actions</th>
        </tr>
        </tfoot>
    </table>
@stop

@push('scripts')
<script>
    $(function () {
        $('#slaplans-table').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 50,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax: '{!! route('slaplans.data') !!}',
            columns: [
                {data: 'slaplanname', name: 'name'},
                {data: 'slaplanstatus', name: 'status'},
                {data: 'grace_period', name: 'grace_period'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endpush