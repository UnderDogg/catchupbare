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
    <h1>{{Lang::get('core::lang.roles')}}</h1>

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
    <div class='row'>




        <div class='col-md-12'>

    <h2>{!! Lang::get('core::lang.roles') !!}</h2><a href="{{route('admin.roles.create')}}"
                                                          class="btn btn-primary pull-right">{{Lang::get('core::lang.create_role')}}</a></h2>


            <!-- Box -->
            {!! Form::open( array('route' => 'admin.roles.enable-selected', 'id' => 'frmRolesList') ) !!}
                <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('core::admin/roles/general.page.index.table-title') }}</h3>
                    &nbsp;
                    <a class="btn btn-default btn-sm" href="{!! route('admin.roles.create') !!}" title="{{ trans('core::admin/roles/general.button.create') }}">
                        <i class="fa fa-plus-square"></i>
                    </a>
                    &nbsp;
                    <a class="btn btn-default btn-sm" href="#" onclick="document.forms['frmRoleList'].action = '{!! route('admin.roles.enable-selected') !!}';  document.forms['frmRolesList'].submit(); return false;" title="{{ trans('core::general.button.enable') }}">
                        <i class="fa fa-check-circle-o"></i>
                    </a>
                    &nbsp;
                    <a class="btn btn-default btn-sm" href="#" onclick="document.forms['frmRoleList'].action = '{!! route('admin.roles.disable-selected') !!}';  document.forms['frmRolesList'].submit(); return false;" title="{{ trans('core::general.button.disable') }}">
                        <i class="fa fa-ban"></i>
                    </a>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">

                    {{--
                    Name	User Name	Role	Status	Group	Department	Created	Action
                    --}}


                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped" id="roles-table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Permissions</th>
                                <th>Staff</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Permissions</th>
                                <th>Staff</th>
                                <th>Actions</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div> <!-- table-responsive -->

                </div><!-- /.box-body -->
            </div><!-- /.box -->
            {!! Form::close() !!}
        </div><!-- /.col -->

    </div><!-- /.row -->

    <script type="text/javascript">
        $(document).ready(function() {
            oTable = $('#roles-table').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 50,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "ajax": '{!! route('api.roles.data') !!}',
                columns: [
                    {data: 'rolenamelink', name: 'name'},
                    {data: 'permissionslink', name: 'display_name'},
                    {data: 'stafflink', name: 'display_name'},

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
            checkboxes = document.getElementsByName('chkRoles[]');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = !checkboxes[i].checked;
            }
        }
    </script>
@endsection
