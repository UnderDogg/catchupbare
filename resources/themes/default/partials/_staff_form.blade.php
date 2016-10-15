<!-- Custom Tabs -->
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_profile" data-toggle="tab" aria-expanded="true">{!! trans('general.tabs.profile') !!}</a></li>
        <li class=""><a href="#tab_settings" data-toggle="tab" aria-expanded="false">{!! trans('general.tabs.settings') !!}</a></li>
        <li class=""><a href="#tab_roles" data-toggle="tab" aria-expanded="false">{!! trans('general.tabs.roles') !!}</a></li>
        <li class=""><a href="#tab_perms" data-toggle="tab" aria-expanded="false">{!! trans('general.tabs.perms') !!}</a></li>
    </ul>
    <div class="tab-content">

        <div class="tab-pane active" id="tab_profile">
            <div class="form-group">
                {!! Form::label('first_name', trans('admin/staff/general.columns.first_name')) !!}
                @if ( $staff->isRoot() )
                    {!! Form::text('first_name', null, ['class' => 'form-control', 'readonly']) !!}
                @else
                    {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
                @endif
            </div>

            <div class="form-group">
                {!! Form::label('last_name', trans('admin/staff/general.columns.last_name')) !!}
                @if ( $staff->isRoot() )
                    {!! Form::text('last_name', null, ['class' => 'form-control', 'readonly']) !!}
                @else
                    {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
                @endif
            </div>

            <div class="form-group">
                {!! Form::label('username', trans('admin/staff/general.columns.username')) !!}
                @if ( $staff->isRoot() )
                    {!! Form::text('username', null, ['class' => 'form-control', 'readonly']) !!}
                @else
                    {!! Form::text('username', null, ['class' => 'form-control']) !!}
                @endif
            </div>

            <div class="form-group">
                {!! Form::label('email', trans('admin/staff/general.columns.email')) !!}
                {!! Form::text('email', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('password', trans('admin/staff/general.columns.password')) !!}
                {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('password_confirmation', trans('admin/staff/general.columns.password_confirmation')) !!}
                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('auth_type', trans('admin/staff/general.columns.type')) !!}
                {!! Form::text('auth_type', null, ['class' => 'form-control', 'readonly']) !!}
            </div>
        </div><!-- /.tab-pane -->

        <div class="tab-pane" id="tab_settings">

            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <!-- Trick to force cleared checkbox to being posted in form! It will be posted as zero unless checked then posted again as 1 and since only last one count! -->
                        {!! '<input type="hidden" name="enabled" value="0">' !!}
                        @if ( $staff->isRoot() )
                            {!! Form::checkbox('enabled', '1', $staff->enabled, ['disabled']) !!} {!! trans('general.status.enabled') !!}
                        @else
                            {!! Form::checkbox('enabled', '1', $staff->enabled) !!} {!! trans('general.status.enabled') !!}
                        @endif
                    </label>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('theme', trans('admin/staff/general.columns.theme')) !!}
                {!! Form::select( 'theme', $themes, $theme, [ 'class' => 'select-theme', 'placeholder' => trans('admin/staff/general.placeholder.select-theme') ] ) !!}</td>
            </div>

            <div class="form-group">
                {!! Form::label('time_zone', trans('admin/staff/general.columns.time_zone')) !!}
                {!! Form::select( 'time_zone', $time_zones, $tzKey, [ 'class' => 'select-time_zone', 'placeholder' => trans('admin/staff/general.placeholder.select-time_zone') ] ) !!}</td>
            </div>

            <div class="form-group">
                {!! '<input type="hidden" name="time_format" value="">' !!}
                {!! Form::label('time_format', trans('admin/staff/general.columns.time_format')) !!}&nbsp;
                <label class="radio-inline"><input type="radio" name="time_format" value="12" {{("12"==$time_format)?'checked="checked"':''}}>{{trans('admin/staff/general.options.12_hours')}}</label>
                <label class="radio-inline"><input type="radio" name="time_format" value="24" {{("24"==$time_format)?'checked="checked"':''}}>{{trans('admin/staff/general.options.24_hours')}}</label>
            </div>

            <div class="form-group">
                {!! Form::label('locale', trans('admin/staff/general.columns.locale')) !!}
                {!! Form::select( 'locale', $locales, $locale, [ 'class' => 'select-locale', 'placeholder' => trans('admin/staff/general.placeholder.select-locale') ] ) !!}</td>
            </div>

        </div><!-- /.tab-pane -->

        <div class="tab-pane" id="tab_roles">
            <div class="form-group">
                {!! Form::hidden('selected_roles', null, [ 'id' => 'selected_roles']) !!}
                <div class="input-group select2-bootstrap-append">
                    @if ( $staff->isRoot() )
                        {!! Form::select('role_search', [], null, ['class' => 'form-control', 'id' => 'role_search', 'disabled' => 'disabled',  'style' => "width: 100%"]) !!}
                    @else
                        {!! Form::select('role_search', [], null, ['class' => 'form-control', 'id' => 'role_search',  'style' => "width: 100%"]) !!}
                    @endif
                    <span class="input-group-btn">
                        <button class="btn btn-default"  id="btn-add-role" type="button">
                            <span class="fa fa-plus-square"></span>
                        </button>
                    </span>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover" id="tbl-roles">
                        <tbody>
                        <tr>
                            <th class="hidden" rowname="id">{!! trans('admin/roles/general.columns.id')  !!}</th>
                            <th>{!! trans('admin/roles/general.columns.name')  !!}</th>
                            <th>{!! trans('admin/roles/general.columns.description')  !!}</th>
                            <th>{!! trans('admin/roles/general.columns.enabled')  !!}</th>
                            <th style="text-align: right">{!! trans('admin/roles/general.columns.actions')  !!}</th>
                        </tr>
                        @foreach($staff->roles as $role)
                            <tr>
                                <td class="hidden" rowname="id">{!! $role->id !!}</td>
                                <td>{!! link_to_route('admin.roles.show', $role->display_name, [$role->id], []) !!}</td>
                                <td>{!! link_to_route('admin.roles.show', $role->description, [$role->id], []) !!}</td>
                                <td>
                                    @if($role->enabled)
                                        <i class="fa fa-check text-green"></i>
                                    @else
                                        <i class="fa fa-close text-red"></i>
                                    @endif
                                </td>
                                <td style="text-align: right">
                                    @if ( $staff->isRoot() )
                                        <i class="fa fa-trash-o text-muted"></i>
                                    @else
                                        <a class="btn-remove-role" href="#" title="{{ trans('general.button.remove-role') }}"><i class="fa fa-trash-o deletable"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div><!-- /.tab-pane -->

        <div class="tab-pane" id="tab_perms">
            <div class="form-group">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>{!! trans('admin/staff/general.columns.name')  !!}</th>
                            <th>{!! trans('admin/staff/general.columns.assigned')  !!}</th>
                            <th>{!! trans('admin/staff/general.columns.effective')  !!}</th>
                        </tr>
                        @foreach($perms as $perm)
                            <tr>
                                <td>{!! link_to_route('admin.permissions.show', $perm->display_name, [$perm->id], []) !!}</td>
                                <td>
                                    @if ( $staff->isRoot() )
                                        {!! Form::checkbox('perms[]', $perm->id, $staff->hasPermission($perm->name), ['disabled']) !!}
                                    @else
                                        {!! Form::checkbox('perms[]', $perm->id, $staff->hasPermission($perm->name)) !!}
                                    @endif

                                </td>
                                <td>
                                    @if($staff->can($perm->name))
                                        <i class="fa fa-check text-green"></i>
                                    @else
                                        <i class="fa fa-close text-red"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.tab-pane -->

    </div><!-- /.tab-content -->
</div>
