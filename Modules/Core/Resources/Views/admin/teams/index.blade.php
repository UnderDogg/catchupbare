@extends('core::adminlayouts.adminmaster')

@section('AdminPanel')
    class="active"
@stop
@section('adminpanel-bar')
    active
@stop

@section('teams')
    class="active"
    @stop

    @section('HeadInclude')
    @stop
            <!-- header -->
    @section('PageHeader')

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
        <div class="col-md-12 teams">
            <div class="box box-primary">
                <div class="box-header">
                    <h2 class="box-title">{{Lang::get('core::lang.teams')}}</h2><a href="{{route('admin.teams.create')}}"
                                                                                   class="btn btn-primary pull-right">{{Lang::get('core::lang.create_team')}}</a>
                </div>

                <div class="box-body table-responsive">

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

                        <h2>{!! Lang::get('core::lang.departments') !!}</h2><a
                                href="{{route('admin.departments.create')}}"
                                class="btn btn-primary pull-right">{{Lang::get('core::lang.create_department')}}</a></h2>
                        <table class="table table-hover table-bordered table-striped" id="teams-table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th>TeamLead</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th>TeamLead</th>
                                <th>Actions</th>
                            </tr>
                            </tfoot>
                        </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            oTable = $('#teams-table').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 50,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "ajax": '{!! route('api.teams.data') !!}',

                columns: [
                    {data: 'teamnamelink', name: 'name'},
                    {data: 'teamsstatuslink', name: 'status'},
                    {data: 'teamleadlink', name: 'team_lead'},

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