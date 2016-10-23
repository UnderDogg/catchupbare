@extends('email::maillayouts.mailmaster')

@section('Tools')
    class="active"
@stop

@section('tools-bar')
    active
@stop

@section('tools')
    class="active"
    @stop

            <!-- content -->
@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h2 class="box-title">{!! Lang::get('tickets::lang.canned_response') !!}</h2><a
                    href="{{route('autoresponses.create')}}"
                    class="btn btn-primary pull-right">{!! Lang::get('tickets::lang.create_canned_response') !!}</a>
        </div>
        <div class="box-body table-responsive">
            <?php
            //$Canneds = Modules\Email\Models\CannedResponse::where('user_id', '=', Auth::guard('staff')->user()->id)->paginate(20);
                    $Canneds = array();
            ?>
                    <!-- check whether success or not -->
            {{-- Success message --}}
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissable">
                    <i class="fa  fa-check-circle"></i>
                    <b>Success!</b>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{Session::get('success')}}
                </div>
            @endif
            {{-- failure message --}}
            @if(Session::has('fails'))
                <div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>Fail!</b>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{Session::get('fails')}}
                </div>
                @endif
                        <!-- Agent table -->
                <table class="table table-bordered table-striped table-hover" id="example1">
                    <tr>
                        <th width="100px">{{Lang::get('tickets::lang.name')}}</th>
                        <th width="100px">{{Lang::get('tickets::lang.action')}}</th>
                    </tr>

                    @forelse($Canneds as $Canned)
                        <tr>
                            <td>{{$Canned->title }}</td>
                            <td>
                                {!! Form::open(['route'=>['canned.destroy', $Canned->id],'method'=>'DELETE']) !!}
                                <a data-toggle="modal" data-target="#view{!! $Canned->id !!}" href="#"
                                   class="btn btn-info btn-xs btn-flat">{!! Lang::get('tickets::lang.view') !!}</a>
                                <a href="{!! URL::route('canned.edit',$Canned->id) !!}"
                                   class="btn btn-primary btn-xs btn-flat">{!! Lang::get('tickets::lang.edit') !!}</a>

                                {!! Form::button('<i class="fa fa-trash" style="color:black;"> </i> '.Lang::get('tickets::lang.delete'),
                                    ['type' => 'submit',
                                    'class'=> 'btn btn-warning btn-xs btn-flat',
                                    'onclick'=>'return confirm("Are you sure?")'])
                                !!}

                                {!! Form::close() !!}
                            </td>
                        </tr>

                        <!-- Surrender Modal -->
                        <div class="modal fade" id="view{!! $Canned->id !!}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">{!! Lang::get('tickets::lang.surrender') !!}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>
                                        <pre>{!! $Canned->message !!}</pre>
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"
                                                id="dismis6">{!! Lang::get('tickets::lang.close') !!}</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                    @empty
                        <td colspan="4"> Nothing </td>
                    @endforelse
                </table>
        </div>
    </div>

    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true
            });
        });
    </script>
    @stop
            <!-- /content -->