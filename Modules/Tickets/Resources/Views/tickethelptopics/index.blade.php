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

@section('tickethelptopics')
    class="active"
@stop


@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
    <h1>{{Lang::get('tickets::lang.tickethelptopics')}}</h1>

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

        <div class="col-md-12 tickethelptopics" style="overflow:hidden;">

            <div class="box box-primary">
                <div class="form-group">
                    <div class="box-header">
                        <h2 class="box-title">{{Lang::get('tickets::lang.tickethelptopics')}}</h2><a
                                href="{{route('tickethelptopics.create')}}"
                                class="btn btn-primary pull-right">{{Lang::get('tickets::lang.create_helptopic')}}</a>
                    </div>


                    <div class="box-body table-responsive" style="overflow:hidden;">


                        <table class="table table-hover table-bordered table-striped dataTable"
                               id="tickethelptopics-table">


                            <thead>
                            <tr>
                                <th>{{Lang::get('tickets::lang.topic')}}</th>
                                <th>{{Lang::get('tickets::lang.status')}}</th>
                                <th>{{Lang::get('tickets::lang.type')}}</th>
                                <th>{{Lang::get('tickets::lang.priority')}}</th>
                                <th>{{Lang::get('tickets::lang.department')}}</th>
                                <th>{{Lang::get('tickets::lang.last_updated')}}</th>
                                <th>{{Lang::get('tickets::lang.action')}}</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th>{{Lang::get('tickets::lang.topic')}}</th>
                                <th>{{Lang::get('tickets::lang.status')}}</th>
                                <th>{{Lang::get('tickets::lang.type')}}</th>
                                <th>{{Lang::get('tickets::lang.priority')}}</th>
                                <th>{{Lang::get('tickets::lang.department')}}</th>
                                <th>{{Lang::get('tickets::lang.last_updated')}}</th>
                                <th>{{Lang::get('tickets::lang.action')}}</th>
                            </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@push('scripts')
<script>
    $(function () {
        $('#tickethelptopics-table').DataTable({
            processing: true,
            "bDeferRender": true,
            serverSide: true,
            "pageLength": 50,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax: '{!! route('tickethelptopics.data') !!}',
            columns: [
                {data: 'tickettopiclink', name: 'topic'},
                {data: 'topicstatus', name: 'ticketstatus'},
                {data: 'topictype', name: 'type'},
                {data: 'ticketpriority', name: 'ticketpriority_id'},
                {data: 'department', name: 'department_id'},
                {data: 'last_updated', name: 'updated_date'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endpush
