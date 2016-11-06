@extends('core::adminlayouts.adminmaster')

@section('AdminPanel')
    class="active"
@stop
@section('adminpanel-bar')
    active
@stop
@section('departments')
    class="active"
@stop

@section('HeadInclude')
@stop
            <!-- header -->
@section('PageHeader')
    <h1>{{Lang::get('core::lang.departments')}}</h1>

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



  <div class="col-md-12 departments">
            <div class="box box-primary">
                <div class="box-header">
    <h2 class="box-title">{!! Lang::get('core::lang.departments') !!}</h2><a href="{{route('admin.departments.create')}}"
                                                          class="btn btn-primary pull-right">{{Lang::get('core::lang.create_department')}}</a></h2>
                </div>

{{--
Name	Type	SLA Plan	Department Manager	Action
--}}
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-bordered table-striped dataTable" style="overflow:hidden;" id="departments-table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>SLA Plan</th>
                                <th>Department Manager</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>SLA Plan</th>
                                <th>Department Manager</th>
                                <th>Actions</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
  </div>

    <script type="text/javascript">
        $(document).ready(function() {
            oTable = $('#departments-table').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 50,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "ajax": '{!! route('api.departments.data') !!}',
                columns: [
                    {data: 'departmentsnamelink', name: 'name'},
                    {data: 'departmentstypelink', name: 'department_type'},
                    {data: 'slaplanlink', name: 'slaplan_id'},

                    {data: 'departmentmanagerlink', name: 'manager_id'},

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
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = !checkboxes[i].checked;
            }
        }
    </script>
@endsection