@extends('layouts.master')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            {!! Form::open( array('route' => 'admin.staff.enable-selected', 'id' => 'frmStaffList') ) !!}
                <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('admin/staff/general.page.index.table-title') }}</h3>
                    &nbsp;
                    <a class="btn btn-default btn-sm" href="{!! route('admin.staff.create') !!}" title="{{ trans('admin/staff/general.button.create') }}">
                        <i class="fa fa-plus-square"></i>
                    </a>
                    &nbsp;
                    <a class="btn btn-default btn-sm" href="#" onclick="document.forms['frmStaffList'].action = '{!! route('admin.staff.enable-selected') !!}';  document.forms['frmStaffList'].submit(); return false;" title="{{ trans('general.button.enable') }}">
                        <i class="fa fa-check-circle-o"></i>
                    </a>
                    &nbsp;
                    <a class="btn btn-default btn-sm" href="#" onclick="document.forms['frmStaffList'].action = '{!! route('admin.staff.disable-selected') !!}';  document.forms['frmStaffList'].submit(); return false;" title="{{ trans('general.button.disable') }}">
                        <i class="fa fa-ban"></i>
                    </a>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align: center">
                                        <a class="btn" href="#" onclick="toggleCheckbox(); return false;" title="{{ trans('general.button.toggle-select') }}">
                                            <i class="fa fa-check-square-o"></i>
                                        </a>
                                    </th>
                                    <th>{{ trans('admin/staff/general.columns.gravatar') }}</th>
                                    <th>{{ trans('admin/staff/general.columns.username') }}</th>
                                    <th>{{ trans('admin/staff/general.columns.name') }}</th>
                                    <th>{{ trans('admin/staff/general.columns.roles') }}</th>
                                    <th>{{ trans('admin/staff/general.columns.email') }}</th>
                                    <th>{{ trans('admin/staff/general.columns.type') }}</th>
                                    <th>{{ trans('admin/staff/general.columns.actions') }}</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style="text-align: center">
                                        <a class="btn" href="#" onclick="toggleCheckbox(); return false;" title="{{ trans('general.button.toggle-select') }}">
                                            <i class="fa fa-check-square-o"></i>
                                        </a>
                                    </th>
                                    <th>{{ trans('admin/staff/general.columns.gravatar') }}</th>
                                    <th>{{ trans('admin/staff/general.columns.username') }}</th>
                                    <th>{{ trans('admin/staff/general.columns.name') }}</th>
                                    <th>{{ trans('admin/staff/general.columns.roles') }}</th>
                                    <th>{{ trans('admin/staff/general.columns.email') }}</th>
                                    <th>{{ trans('admin/staff/general.columns.type') }}</th>
                                    <th>{{ trans('admin/staff/general.columns.actions') }}</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($staffs as $staff)
                                    <tr>
                                        <td align="center">
                                            @if ($staff->canBeDisabled())
                                                {!! Form::checkbox('chkStaff[]', $staff->id); !!}
                                            @endif
                                        </td>
                                        <td><img src="{{ Gravatar::get($staff->email , 'tiny') }}" class="staff-image" alt="Staff Image"/></td>
                                        <td>{!! link_to_route('admin.staff.show', $staff->username, [$staff->id], []) !!}</td>
                                        <td>{!! link_to_route('admin.staff.show', $staff->full_name, [$staff->id], []) !!}</td>
                                        <td>{{ $staff->roles->count() }}</td>
                                        <td>{{ $staff->email }}</td>
                                        <td>{{ $staff->auth_type }}</td>
                                        <td>
                                            <a href="{!! route('admin.staff.edit', $staff->id) !!}" title="{{ trans('general.button.edit') }}"><i class="fa fa-pencil-square-o"></i></a>

                                            @if ($staff->canBeDisabled())
                                                @if ( $staff->enabled )
                                                    <a href="{!! route('admin.staff.disable', $staff->id) !!}" title="{{ trans('general.button.disable') }}"><i class="fa fa-check-circle-o enabled"></i></a>
                                                @else
                                                    <a href="{!! route('admin.staff.enable', $staff->id) !!}" title="{{ trans('general.button.enable') }}"><i class="fa fa-ban disabled"></i></a>
                                                @endif
                                            @else
                                                    <i class="fa fa-ban text-muted" title="{{ trans('admin/staff/general.error.cant-be-disabled') }}"></i>
                                            @endif

                                            @if ( $staff->isDeletable() )
                                                <a href="{!! route('admin.staff.confirm-delete', $staff->id) !!}" data-toggle="modal" data-target="#modal_dialog" title="{{ trans('general.button.delete') }}"><i class="fa fa-trash-o deletable"></i></a>
                                            @else
                                                <i class="fa fa-trash-o text-muted" title="{{ trans('admin/staff/general.error.cant-be-deleted') }}"></i>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $staffs->render() !!}
                    </div> <!-- table-responsive -->

                </div><!-- /.box-body -->
            </div><!-- /.box -->
            {!! Form::close() !!}
        </div><!-- /.col -->

    </div><!-- /.row -->
@endsection


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
