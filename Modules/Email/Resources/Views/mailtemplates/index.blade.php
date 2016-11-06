@extends('email::maillayouts.mailmaster')

@section('MailTemplates')
    active
@stop

@section('templates-bar')
    active
@stop



@section('mailtemplates')
    class="active"
@stop


    @section('HeadInclude')
    @stop
            <!-- header -->
@section('PageHeader')
    <h1>{{Lang::get('email::lang.templates')}}</h1>

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


            <div class="col-md-12 mailboxtemplates" style="overflow:hidden;">
                <div class="box box-primary">
                    <div class="box-header">
                        <h2 class="box-title">{{Lang::get('email::lang.templates')}}</h2>
                            <a href="{{route('mailpanel.mailtemplates.create')}}" class="btn btn-primary pull-right">{{Lang::get('email::lang.create_template')}}</a>
                    </div>

                    <div class="box-body table-responsive" style="overflow:hidden;">


                        <table class="table table-hover table-bordered table-striped dataTable" id="mailtemplates-table">
                            <thead>
                            <tr>
                                <th>{{Lang::get('email::lang.name')}}</th>
                                <th>{{Lang::get('email::lang.status')}}</th>
                                <th>{{Lang::get('email::lang.templatetype')}}</th>
                                <th>{{Lang::get('email::lang.subject')}}</th>
                                <th>{{Lang::get('email::lang.created')}}</th>
                                <th>{{Lang::get('email::lang.last_updated')}}</th>
                                <th>{{Lang::get('email::lang.action')}}</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>{{Lang::get('email::lang.name')}}</th>
                                <th>{{Lang::get('email::lang.status')}}</th>
                                <th>{{Lang::get('email::lang.templatetype')}}</th>
                                <th>{{Lang::get('email::lang.subject')}}</th>
                                <th>{{Lang::get('email::lang.created')}}</th>
                                <th>{{Lang::get('email::lang.last_updated')}}</th>
                                <th>{{Lang::get('email::lang.action')}}</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

{{--       {data: 'set_id', name: 'set_id'},   --}}

            <script type="text/javascript">
                $(document).ready(function () {
                    oTable = $('#mailtemplates-table').DataTable({
                        "processing": true,
                        "bDeferRender": true,
                        "serverSide": true,
                        "pageLength": 50,
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        "ajax": '{!! route('api.mailtemplates.data') !!}',
                        columns: [
                            {data: 'templatenamelink', name: 'name'},
                            {data: 'templatestatuslink', name: 'is_active'},
                            {data: 'type_id', name: 'type_id'},
                            {data: 'subject', name: 'subject'},
                            {data: 'created_at', name: 'created'},
                            {data: 'last_updated', name: 'updated_at'},
                            {data: 'actions', name: 'actions', orderable: false, searchable: false},
                        ]
                    });
                });
            </script>


            @endsection


                    <!-- Optional bottom section for modals etc... -->
        @section('body_bottom')
            <script language="JavaScript">
                function toggleCheckbox() {
                    checkboxes = document.getElementsByName('chkDepartments[]');
                    for (var i = 0, n = checkboxes.length; i < n; i++) {
                        checkboxes[i].checked = !checkboxes[i].checked;
                    }
                }
            </script>
@endsection
