@extends('email::maillayouts.mailmaster')


@section('Mailboxes')
    class="active"
@stop

@section('mailpanel-bar')
    active
@stop

@section('mailrules')
    class="active"
    @stop


    @section('HeadInclude')
    @stop
            <!-- header -->
@section('PageHeader')
    <h1>{{Lang::get('mail::lang.mailrules')}}</h1>

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


        <h2>{!! Lang::get('email::lang.mailrules') !!}</h2><a href="{{route('mailrules.create')}}"
                                                               class="btn btn-primary pull-right">{{Lang::get('core::lang.create_mailrule')}}</a></h2>






        <table class="table table-hover table-bordered table-striped" id="mailrules-table">
            <thead>
            <tr>
                <th>{{Lang::get('email::lang.mailrule')}}</th>
                <th>{{Lang::get('core::lang.last_updated')}}</th>
                <th>{{Lang::get('email::lang.action')}}</th>
            </tr>

            </thead>
            <tfoot>
            <tr>
                <th>{{Lang::get('email::lang.mailrule')}}</th>
                <th>{{Lang::get('core::lang.last_updated')}}</th>
                <th>{{Lang::get('email::lang.action')}}</th>
            </tr>
            </tfoot>
        </table>

@stop

@push('scripts')
<script>
    $(function () {
        $('#mailrules-table').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 50,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax: '{!! route('mailrules.data') !!}',
            columns: [
                {data: 'mailrule', name: 'mailrule'},
                {data: 'lastupdate', name: 'updated_at'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endpush
