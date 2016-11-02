@extends('themes.default1.agent.layout.agent')

@section('Users')
class="active"
@stop

@section('user-bar')
active
@stop

@section('user')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{Lang::get('lang.user_directory')}}</h1>
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
<!-- open a form -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{Lang::get('lang.user')}}</h3><a href="{{route('user.create')}}" class="btn btn-primary pull-right">{{Lang::get('lang.create_user')}}</a>
    </div>
    <div class="box-body">
        <!-- check whether success or not -->
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('warning'))
        <div class="alert alert-warning alert-dismissable">
            <i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <b>{!! Lang::get('lang.alert') !!} !</b>            
            {{Session::get('warning')}}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <b>{!! Lang::get('lang.alert') !!} !</b>            
            {{Session::get('fails')}}
        </div>
        @endif
        <?php
        $users = App\User::where('role', '=', 'user')->orderBy('id', 'ASC')->paginate(20);
        ?>
        {!! Datatable::table()
        ->addColumn(Lang::get('lang.name'),
        Lang::get('lang.email'),
        Lang::get('lang.phone'),
        Lang::get('lang.status'),
        Lang::get('lang.ban'),
        Lang::get('lang.last_login'),
         Lang::get('lang.role'),
        Lang::get('lang.action'))  // these are the column headings to be shown
        ->setUrl(route('user.list'))  // this is the route where data will be retrieved
        ->render() !!}
    </div>
</div>
@stop
<!-- /content -->