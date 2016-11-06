@extends('tickets::ticketlayouts.ticketmaster')

@section('TicketsPanel')
   active
@stop


@section('TicketsPanel')
    class="active"
@stop

@section('tickets-bar')
    active
@stop

@section('ticketcategories')
    class="active"
@stop

@section('HeadInclude')
@stop
            <!-- header -->
@section('PageHeader')
    <h1>{{Lang::get('tickets::lang.ticketcategories')}}</h1>

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

    <h2>{!! Lang::get('tickets::lang.ticketcategories') !!}</h2><a href="{{route('ticketcategories.create')}}"
                                                          class="btn btn-primary pull-right">{{Lang::get('tickets::lang.create_ticketcategory')}}</a></h2>

    <table class="table table-hover table-bordered table-striped" id="ticketcategories-table">
        <thead>
        <tr>
            <th>Category</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Category</th>
            <th>Actions</th>
        </tr>
        </tfoot>
    </table>
@stop

@push('scripts')
<script>
    $(function () {
        $('#ticketcategories-table').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 50,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax: '{!! route('ticketcategories.data') !!}',
            columns: [
                {data: 'ticketcatlink', name: 'name'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endpush
