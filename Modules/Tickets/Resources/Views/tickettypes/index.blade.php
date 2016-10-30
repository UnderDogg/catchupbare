@extends('core::adminlayouts.adminmaster')


@section('Dashboard')
    active
@stop

@section('dashboard-bar')
    active
@stop

@section('Dashboard')
    class="active"
@stop

@section('HeadInclude')
@stop
            <!-- header -->
@section('PageHeader')
    <h1>{{Lang::get('tickets::lang.tickettypes')}}</h1>

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

    <h2>{!! Lang::get('tickets::lang.tickettypes') !!}</h2><a href="{{route('tickettypes.create')}}"
                                                          class="btn btn-primary pull-right">{{Lang::get('tickets::lang.create_tickettype')}}</a></h2>

    <table class="table table-hover table-bordered table-striped" id="tickettypes-table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Department</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Name</th>
            <th>Department</th>
            <th>Actions</th>
        </tr>
        </tfoot>
    </table>
@stop

@push('scripts')
<script>
    $(function () {
        $('#tickettypes-table').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 50,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax: '{!! route('tickettypes.data') !!}',
            columns: [
                {data: 'tickettypelink', name: 'name'},
                {data: 'tickettypedepartment', name: 'departmentid'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endpush
