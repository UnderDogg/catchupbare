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
    <h1>{{Lang::get('core::lang.staff')}}</h1>

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

    <h2>{!! Lang::get('core::lang.staff') !!}</h2><a href="{{route('admin.staff.create')}}"
                                                          class="btn btn-primary pull-right">{{Lang::get('core::lang.create_staffmember')}}</a></h2>


            <!-- Box -->
            {!! Form::open( array('route' => 'admin.staff.enable-selected', 'id' => 'frmStaffList') ) !!}
                <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('core::admin/staff/general.page.index.table-title') }}</h3>
                    &nbsp;
                    <a class="btn btn-default btn-sm" href="{!! route('admin.staff.create') !!}" title="{{ trans('core::admin/staff/general.button.create') }}">
                        <i class="fa fa-plus-square"></i>
                    </a>
                    &nbsp;
                    <a class="btn btn-default btn-sm" href="#" onclick="document.forms['frmStaffList'].action = '{!! route('admin.staff.enable-selected') !!}';  document.forms['frmStaffList'].submit(); return false;" title="{{ trans('core::general.button.enable') }}">
                        <i class="fa fa-check-circle-o"></i>
                    </a>
                    &nbsp;
                    <a class="btn btn-default btn-sm" href="#" onclick="document.forms['frmStaffList'].action = '{!! route('admin.staff.disable-selected') !!}';  document.forms['frmStaffList'].submit(); return false;" title="{{ trans('core::general.button.disable') }}">
                        <i class="fa fa-ban"></i>
                    </a>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped" id="staff-table">
                            <thead>
                                <tr>
                                    <th style="text-align: center">
                                        <a class="btn" href="#" onclick="toggleCheckbox(); return false;" title="{{ trans('core::general.button.toggle-select') }}">
                                            <i class="fa fa-check-square-o"></i>
                                        </a>
                                    </th>
                                    <th>{{ trans('core::admin/staff/general.columns.gravatar') }}</th>
                                    <th>{{ trans('core::admin/staff/general.columns.username') }}</th>
                                    <th>{{ trans('core::admin/staff/general.columns.name') }}</th>
                                    <th>{{ trans('core::admin/staff/general.columns.roles') }}</th>
                                    <th>{{ trans('core::admin/staff/general.columns.email') }}</th>
                                    <th>{{ trans('core::admin/staff/general.columns.type') }}</th>
                                    <th>{{ trans('core::admin/staff/general.columns.actions') }}</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style="text-align: center">
                                        <a class="btn" href="#" onclick="toggleCheckbox(); return false;" title="{{ trans('core::general.button.toggle-select') }}">
                                            <i class="fa fa-check-square-o"></i>
                                        </a>
                                    </th>
                                    <th>{{ trans('core::admin/staff/general.columns.gravatar') }}</th>
                                    <th>{{ trans('core::admin/staff/general.columns.username') }}</th>
                                    <th>{{ trans('core::admin/staff/general.columns.name') }}</th>
                                    <th>{{ trans('core::admin/staff/general.columns.roles') }}</th>
                                    <th>{{ trans('core::admin/staff/general.columns.email') }}</th>
                                    <th>{{ trans('core::admin/staff/general.columns.type') }}</th>
                                    <th>{{ trans('core::admin/staff/general.columns.actions') }}</th>
                                </tr>
                            </tfoot>

                        </table>
                    </div> <!-- table-responsive -->

                </div><!-- /.box-body -->
            </div><!-- /.box -->
            {!! Form::close() !!}
        </div><!-- /.col -->

    </div><!-- /.row -->
@endsection


@push('scripts-footer')
<script>
    $(function () {
        $('#staff-table').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 50,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax: '{!! route('api.staff.data') !!}',
            columns: [
                {data: 'staffnamelink', name: 'name'},
                {data: 'staffemaillink', name: 'email'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endpush


<!-- Optional bottom section for modals etc... -->
@section('body_bottom')
    <script language="JavaScript">
        function toggleCheckbox() {
            checkboxes = document.getElementsByName('chkStaff[]');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = !checkboxes[i].checked;
            }
        }
    </script>
@endsection
