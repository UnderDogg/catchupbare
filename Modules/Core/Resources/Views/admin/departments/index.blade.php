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

  <div class="col-lg-12 departments">

    <h2>{!! Lang::get('core::lang.departments') !!}</h2><a href="{{route('admin.departments.create')}}"
                                                          class="btn btn-primary pull-right">{{Lang::get('core::lang.create_department')}}</a></h2>

{{--
Name	Type	SLA Plan	Department Manager	Action
--}}
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped" id="departments-table">
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