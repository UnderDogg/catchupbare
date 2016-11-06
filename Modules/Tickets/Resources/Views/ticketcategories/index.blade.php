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
    <div class="box box-primary">
        <div class="form-group">
            <div class="box-header">
    <h2 class="box-title">{!! Lang::get('tickets::lang.ticketcategories') !!}</h2><a href="{{route('ticketcategories.create')}}" class="btn btn-primary pull-right">{{Lang::get('tickets::lang.create_ticketcategory')}}</a></h2>



            <div class="box-body table-responsive">

                <!-- check whether success or not -->

                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissable">
                        <i class="fa  fa-check-circle"></i>
                        <b>Success!</b>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!! Session::get('success') !!}
                    </div>
                    @endif
                            <!-- failure message -->
                    @if(Session::has('fails'))
                        <div class="alert alert-danger alert-dismissable">
                            <i class="fa fa-ban"></i>
                            <b>Fail!</b>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {!! Session::get('fails') !!}
                        </div>
                    @endif

    <table class="table table-bordered table-hover table-striped dataTable" style="overflow:hidden;" id="ticketcategories-table">




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
