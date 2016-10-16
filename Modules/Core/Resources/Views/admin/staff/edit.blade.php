@extends('core::layouts.adminmaster')

@section('head_extra')
    <!-- Select2 css -->
    @include('partials._head_extra_select2_css')
@endsection

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <div class="box-body">

                {!! Form::model( $staff, ['route' => ['admin.staff.update', $staff->id], 'method' => 'PATCH', 'id' => 'form_edit_staff'] ) !!}

                @include('partials._staff_form')

                <div class="form-group">
                    {!! Form::button( trans('general.button.update'), ['class' => 'btn btn-primary', 'id' => 'btn-submit-edit'] ) !!}
                    <a href="{!! route('admin.staff.index') !!}" title="{{ trans('general.button.cancel') }}" class='btn btn-default'>{{ trans('general.button.cancel') }}</a>
                </div>

                {!! Form::close() !!}

            </div><!-- /.box-body -->
        </div><!-- /.col -->

    </div><!-- /.row -->
@endsection

@section('body_bottom')
    <!-- Select2 4.0.0 -->
    <script src="{{ asset ("/bower_components/admin-lte/select2/js/select2.min.js") }}" type="text/javascript"></script>

    <!-- Select2 js -->
    @include('partials._body_bottom_select2_js_role_search')
    @include('partials._body_bottom_select2_js_staff_settings')
    @include('partials._body_bottom_submit_staff_edit_form_js')
@endsection
