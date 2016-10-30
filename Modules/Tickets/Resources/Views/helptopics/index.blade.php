@extends('core::adminlayouts.adminmaster')

@section('Manage')
    active
@stop

@section('manage-bar')
    active
@stop

@section('help')
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
    <div class="box box-primary">
        <div class="form-group">
            <div class="box-header">
                <h2 class="box-title">{{Lang::get('tickets::lang.help_topic')}}</h2><a
                        href="{{route('helptopic.create')}}"
                        class="btn btn-primary pull-right">{{Lang::get('tickets::lang.create_help_topic')}}</a></div>
            <div class="box-body table-responsive">

                <!-- check whether success or not -->

                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissable">
                        <i class="fa  fa-check-circle"></i>
                        <b>Success!</b>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!! Session::get('success') !!}
                    </div>
                    @endif
                            <!-- failure message -->
                    @if(Session::has('fails'))
                        <div class="alert alert-danger alert-dismissable">
                            <i class="fa fa-ban"></i>
                            <b>Fail!</b>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {!! Session::get('fails') !!}
                        </div>
                    @endif

                    <table class="table table-bordered table-striped dataTable" style="overflow:hidden;">

                        <tr>
                            <th width="100px">{{Lang::get('tickets::lang.topic')}}</th>
                            <th width="100px">{{Lang::get('tickets::lang.status')}}</th>
                            <th width="100px">{{Lang::get('tickets::lang.type')}}</th>
                            <th width="100px">{{Lang::get('tickets::lang.priority')}}</th>
                            <th width="100px">{{Lang::get('tickets::lang.department')}}</th>
                            <th width="100px">{{Lang::get('tickets::lang.last_updated')}}</th>
                            <th width="100px">{{Lang::get('tickets::lang.action')}}</th>
                        </tr>

                        <?php

                        $default_helptopic = Modules\Core\Models\Settings\Ticket::where('id', '=', '1')->first();
                        $default_helptopic = $default_helptopic->help_topic;

                        ?>

                                <!-- Foreach @var$topics as @var topic -->
                        @foreach($topics as $topic)
                            <tr style="padding-bottom:-30px">

                                <!-- topic Name with Link to Edit page along Id -->
                                <td><a href="{{route('helptopic.edit',$topic->id)}}">{!! $topic->topic !!}
                                        @if($topic->id == $default_helptopic)
                                            ( Default )
                                            <?php
                                            $disable = 'disabled';
                                            ?>
                                        @else
                                            <?php
                                            $disable = '';
                                            ?>
                                        @endif
                                    </a></td>

                                <!-- topic Status : if status==1 active -->
                                <td>
                                    @if($topic->status=='1')
                                        <span style="color:green">Active</span>
                                    @else
                                        <span style="color:red">Disable</span>
                                    @endif
                                </td>

                                <!-- Type -->

                                <td>
                                    @if($topic->type=='1')
                                        <span style="color:green">Public</span>
                                    @else
                                        <span style="color:red">Private</span>
                                    @endif
                                </td>
                                <!-- Priority -->
                                <?php $priority = Modules\Core\Models\Ticket\Ticket_Priority::where('priority_id', '=', $topic->priority)->first(); ?>
                                <td>{!! $priority->priority_desc !!}</td>
                                <!-- Department -->
                                @if($topic->department != null)
                                    <?php $dept = Modules\Core\Models\Department::where('id', '=', $topic->department)->first();
                                    $dept = $dept->name; ?>
                                @elseif($topic->department == null)
                                    <?php   $dept = "";  ?>
                                @endif
                                <td> {!! $dept !!} </td>
                                <!-- Last Updated -->
                                <td> {!! UTC::usertimezone($topic->updated_at) !!} </td>
                                <!-- Deleting Fields -->
                                <td>
                                    {!! Form::open(['route'=>['helptopic.destroy', $topic->id],'method'=>'DELETE']) !!}
                                    <a href="{{route('helptopic.edit',$topic->id)}}"
                                       class="btn btn-info btn-xs btn-flat"><i class="fa fa-trash"
                                                                               style="color:black;"> </i> Edit</a>
                                    <!-- To pop up a confirm Message -->
                    {!! Form::button('<i class="fa fa-trash" style="color:black;"> </i> Delete',
                        ['type' => 'submit',
                        'class'=> 'btn btn-warning btn-xs btn-flat '.$disable,
                        'onclick'=>'return confirm("Are you sure?")'])
                    !!}
            </div>
            {!! Form::close() !!}
            </td>
            @endforeach
            </tr>
            <!-- Set a link to Create Page -->

            </table>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>

@stop
