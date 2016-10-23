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


@section('head_extra')
{{-- Here we can add extra stylesheets (and javascripts, when necessary --}}
@endsection

@section('content')
    <div class='row'>
        <div class='col-md-8'>
            <!-- SERVER HEALTH REPORT -->
            <!-- MAP & BOX PANE -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Location Report</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="row">
                        <div class="col-md-9 col-sm-8">
                            <div class="pad">
                                <!-- Map will be created here -->
                                <div id="world-map-markers" style="height: 325px;"></div>
                            </div>
                        </div><!-- /.col -->
                        <div class="col-md-3 col-sm-4">
                            <div class="pad box-pane-right bg-green" style="min-height: 280px">
                                <div class="description-block margin-bottom">
                                    <span id="mousespeed">Loading..</span>
                                    <h5 class="description-header">1024</h5>
                                    <span class="description-text">Avg. requests /s</span>
                                </div><!-- /.description-block -->
                                <div class="description-block margin-bottom">
                                    <div class="sparkbar pad" data-color="#fff">14,97,87,91,23,9,98</div>
                                    <h5 class="description-header">30%</h5>
                                    <span class="description-text">Bandwith</span>
                                </div><!-- /.description-block -->
                                <div class="description-block">
                                    <div class="sparkbar pad" data-color="#fff">82,66,40,89,21,53,78,28,62,54</div>
                                    <h5 class="description-header">70%</h5>
                                    <span class="description-text">Unique staff</span>
                                </div><!-- /.description-block -->
                            </div>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.box-body -->
            </div><!-- /.box -->


            <!-- PROJECT STATUS -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Project status</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i
                                    class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                        <h5>TaskName<small class="label label-red pull-right">20%</small></h5>
                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-red" style="width: 20%"></div>
                        </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <form action='#'>
                        <input type='text' placeholder='New task' class='form-control input-sm'/>
                    </form>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->

        </div><!-- /.col -->
        <div class='col-md-4'>
            <!-- USERS LIST -->
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Online Staff</h3>
                    <div class="box-tools pull-right">
                        <span class="label label-danger">15 staff online</span>
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <ul class="staff-list clearfix">
                        <li>
                            <img src="{{ asset ("/bower_components/admin-lte/dist/img/user1-128x128.jpg") }}"
                                 alt="Staff Image">
                            <a class="staff-list-name" href="#">Alexander Pierce</a>
                            <span class="staff-list-date">Today</span>
                        </li>
                        <li>
                            <img src="{{ asset ("/bower_components/admin-lte/dist/img/user8-128x128.jpg") }}"
                                 alt="Staff Image">
                            <a class="staff-list-name" href="#">Norman</a>
                            <span class="staff-list-date">Yesterday</span>
                        </li>
                        <li>
                            <img src="{{ asset ("/bower_components/admin-lte/dist/img/user7-128x128.jpg") }}"
                                 alt="Staff Image">
                            <a class="staff-list-name" href="#">Jane</a>
                            <span class="staff-list-date">12 Jan</span>
                        </li>
                        <li>
                            <img src="{{ asset ("/bower_components/admin-lte/dist/img/user6-128x128.jpg") }}"
                                 alt="Staff Image">
                            <a class="staff-list-name" href="#">John</a>
                            <span class="staff-list-date">12 Jan</span>
                        </li>
                        <li>
                            <img src="{{ asset ("/bower_components/admin-lte/dist/img/user2-160x160.jpg") }}"
                                 alt="Staff Image">
                            <a class="staff-list-name" href="#">Alexander</a>
                            <span class="staff-list-date">13 Jan</span>
                        </li>
                        <li>
                            <img src="{{ asset ("/bower_components/admin-lte/dist/img/user5-128x128.jpg") }}"
                                 alt="Staff Image">
                            <a class="staff-list-name" href="#">Sarah</a>
                            <span class="staff-list-date">14 Jan</span>
                        </li>
                        <li>
                            <img src="{{ asset ("/bower_components/admin-lte/dist/img/user4-128x128.jpg") }}"
                                 alt="Staff Image">
                            <a class="staff-list-name" href="#">Nora</a>
                            <span class="staff-list-date">15 Jan</span>
                        </li>
                        <li>
                            <img src="{{ asset ("/bower_components/admin-lte/dist/img/user3-128x128.jpg") }}"
                                 alt="Staff Image">
                            <a class="staff-list-name" href="#">Nadia</a>
                            <span class="staff-list-date">15 Jan</span>
                        </li>
                    </ul><!-- /.staff-list -->
                </div><!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="javascript::" class="uppercase">View All Staff</a>
                </div><!-- /.box-footer -->
            </div>

            <!-- BROWSER USAGE -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Browser Usage</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="chart-responsive">
                                <canvas id="pieChart" height="150"></canvas>
                            </div><!-- ./chart-responsive -->
                        </div><!-- /.col -->
                        <div class="col-md-4">
                            <ul class="chart-legend clearfix">
                                <li><i class="fa fa-circle-o text-red"></i> Chrome</li>
                                <li><i class="fa fa-circle-o text-green"></i> IE</li>
                                <li><i class="fa fa-circle-o text-yellow"></i> FireFox</li>
                                <li><i class="fa fa-circle-o text-aqua"></i> Safari</li>
                                <li><i class="fa fa-circle-o text-light-blue"></i> Opera</li>
                                <li><i class="fa fa-circle-o text-gray"></i> Navigator</li>
                            </ul>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.box-body -->
                <div class="box-footer no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="#">United States of America <span class="pull-right text-red"><i
                                            class="fa fa-angle-down"></i> 12%</span></a></li>
                        <li><a href="#">India <span class="pull-right text-green"><i
                                            class="fa fa-angle-up"></i> 4%</span></a></li>
                        <li><a href="#">China <span class="pull-right text-yellow"><i
                                            class="fa fa-angle-left"></i> 0%</span></a></li>
                    </ul>
                </div><!-- /.footer -->
            </div>
        </div><!-- /.col -->

    </div><!-- /.row -->
    @endsection


@section('body_bottom')
{{--Javascriopt scripts and files--}}
@endsection
