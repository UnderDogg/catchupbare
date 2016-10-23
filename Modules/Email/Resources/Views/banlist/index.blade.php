@extends('email::maillayouts.mailmaster')


@section('Dashboard')
    class="active"
@stop

@section('dashboard-bar')
    {{--active --}}
@stop

@section('ban')
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
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h2 class="box-title">{{Lang::get('core::lang.banlists')}}</h2><a href="{{route('banlist.create')}}"
                                                                                      class="pull-right btn btn-primary">{{Lang::get('core::lang.ban_email')}}</a>
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
                        <table class="table table-bordered table-striped dataTable" style="overflow:hidden;">
                            <tr>
                                <th width="100px">{{Lang::get('core::lang.email_address')}}</th>
                                <th width="100px">{{Lang::get('core::lang.last_updated')}}</th>
                                <th width="100px">{{Lang::get('core::lang.action')}}</th>
                            </tr>
                            <!-- Foreach @var bans as @var ban -->
                            @foreach($bans as $ban)
                                <tr>

                                    <!-- Email Address with Link to Edit page along Id -->
                                    <td><a href="{{route('banlist.edit',$ban->id)}}">{!! $ban->email !!}</a></td>
                                    <!-- Last Updated -->
                                    <td> {!! $ban->updated_at !!} </td>
                                    <!-- Deleting Fields -->
                                    <td>
                                        <a href="{{route('banlist.edit',$ban->id)}}"
                                           class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit"
                                                                                   style="color:black;"> </i> Edit</a>
                                    </td>
                                    @endforeach
                                </tr>
                                <!-- Set a link to Create Page -->
                        </table>
                </div>
            </div>
        </div>
    </div>

@stop
