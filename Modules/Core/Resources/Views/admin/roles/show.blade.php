@extends('core::adminlayouts.adminmaster')

@section('head_extra')
    <!-- Select2 css -->
    @include('partials._head_extra_select2_css')

@endsection

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
            <div class="box-body">

                {!! Form::model($role, ['route' => 'admin.roles.index', 'method' => 'GET']) !!}

                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_details" data-toggle="tab" aria-expanded="true">{!! trans('general.tabs.details') !!}</a></li>
                        <li class=""><a href="#tab_options" data-toggle="tab" aria-expanded="false">{!! trans('general.tabs.options') !!}</a></li>
                        <li class=""><a href="#tab_perms" data-toggle="tab" aria-expanded="false">{!! trans('general.tabs.perms') !!}</a></li>
                        <li class=""><a href="#tab_staffs" data-toggle="tab" aria-expanded="false">{!! trans('general.tabs.staff') !!}</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_details">
                            <div class="form-group">
                                {!! Form::label('name', trans('core::admin/roles/general.columns.name')) !!}
                                {!! Form::text('name', null, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('display_name', trans('core::admin/roles/general.columns.display_name')) !!}
                                {!! Form::text('display_name', null, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('description', trans('core::admin/roles/general.columns.description')) !!}
                                {!! Form::text('description', null, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div><!-- /.tab-pane -->

                        <div class="tab-pane" id="tab_options">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        {!! Form::checkbox('resync_on_login', '1', $role->resync_on_login, ['disabled']) !!} {!! trans('core::admin/roles/general.columns.resync_on_login') !!}
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        {!! Form::checkbox('enabled', '1', $role->enabled, ['disabled']) !!} {!! trans('general.status.enabled') !!}
                                    </label>
                                </div>
                            </div>
                        </div><!-- /.tab-pane -->

                        <div class="tab-pane" id="tab_perms">
                            <div class="form-group">
                                <div class="col-4">
                                    @foreach($perms as $perm)
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('perms[]', $perm->id, $role->hasPerm($perm), ['disabled']) !!} {{ $perm->display_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div><!-- /.tab-pane -->

                        <div class="tab-pane" id="tab_staffs">
                            <div class="form-group">
                                <div class="input-group select2-bootstrap-append">
                                    {!! Form::select('staff_search', [], null, ['class' => 'form-control', 'id' => 'staff_search', 'disabled' => 'disabled',  'style' => "width: 100%"]) !!}
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" disabled>
                                            <span class="fa fa-plus-square"></span>
                                        </button>
                                    </span>
                                </div>

                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                        <tbody>
                                        <tr>
                                            <th>{!! trans('admin/staff/general.columns.name')  !!}</th>
                                            <th>{!! trans('admin/staff/general.columns.username')  !!}</th>
                                            <th>{!! trans('admin/staff/general.columns.enabled')  !!}</th>
                                            <th style="text-align: right">{!! trans('admin/staff/general.columns.actions')  !!}</th>
                                        </tr>
                                        @foreach($role->staff as $staff)
                                            <tr>
                                                <td>{!! link_to_route('admin.staff.show', $staff->full_name, [$staff->id], []) !!}</td>
                                                <td>{!! link_to_route('admin.staff.show', $staff->username, [$staff->id], []) !!}</td>
                                                <td>
                                                    @if($staff->enabled)
                                                        <i class="fa fa-check text-green"></i>
                                                    @else
                                                        <i class="fa fa-close text-red"></i>
                                                    @endif
                                                </td>
                                                <td style="text-align: right">
                                                    <i class="fa fa-trash-o text-muted"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div><!-- /.table-responsive -->
                            </div><!-- /.form-group -->
                        </div><!-- /.tab-pane -->

                    </div><!-- /.tab-content -->
                </div>

                <div class="form-group">
                    {!! Form::submit(trans('general.button.close'), ['class' => 'btn btn-primary']) !!}
                    @if ( $role->isEditable() || $role->canChangePermissions() )
                        <a href="{!! route('admin.roles.edit', $role->id) !!}" title="{{ trans('general.button.edit') }}" class='btn btn-default'>{{ trans('general.button.edit') }}</a>
                    @endif
                </div>

                {!! Form::close() !!}

            </div><!-- /.box-body -->
        </div><!-- /.col -->

    </div><!-- /.row -->

@endsection

@section('body_bottom')
    <!-- Select2 js -->
    @include('partials._body_bottom_select2_js_staff_search')
@endsection
