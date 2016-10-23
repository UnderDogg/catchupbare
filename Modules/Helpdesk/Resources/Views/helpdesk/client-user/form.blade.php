@extends('themes.default1.client.layout.client')

@section('title')
    Submit A Ticket -
@stop

@section('submit')
    class = "active"
    @stop
            <!-- breadcrumbs -->
@section('breadcrumb')
    <div class="site-hero clearfix">
        <ol class="breadcrumb breadcrumb-custom">
            <li class="text">{!! Lang::get('helpdesk::tickets.you_are_here') !!}:</li>
            <li><a href="{!! URL::route('form') !!}">{!! Lang::get('helpdesk::tickets.submit_a_ticket') !!}</a></li>
        </ol>
    </div>
    @stop
            <!-- /breadcrumbs -->
@section('check')
    <div class="banner-wrapper text-center clearfix">
        <h3 class="banner-title text-info h4">{!! Lang::get('helpdesk::tickets.have_a_ticket') !!}?</h3>
        <div class="banner-content">
            {!! Form::open(['url' => 'checkmyticket' , 'method' => 'POST'] )!!}

            {!! Form::label('email',Lang::get('helpdesk::tickets.email')) !!}
            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
            {!! Form::text('email',null,['class' => 'form-control']) !!}

            {!! Form::label('ticket_number',Lang::get('helpdesk::tickets.ticket_number'),['style' => 'display: block']) !!}
            {!! $errors->first('ticket_number', '<span class="help-block">:message</span>') !!}
            {!! Form::text('ticket_number',null,['class' => 'form-control']) !!}
            <br/><input type="submit" value="{!! Lang::get('helpdesk::tickets.check_ticket_status') !!}"
                        class="btn btn-info">

            {!! Form::close() !!}
        </div>
    </div>
    @stop
            <!-- content -->
@section('content')
    <div id="content" class="site-content col-md-9">
        @if(Session::has('message'))
            <div class="alert alert-success alert-dismissable">
                <i class="fa  fa-check-circle"></i>
                <b>Success!</b>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {!! Session::get('message') !!}
            </div>
            @endif

                    <!-- open a form -->
            {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script> --}}
            <script src="{{asset("lb-faveo/js/jquery2.0.2.min.js")}}" type="text/javascript"></script>
            <!--
            |====================================================
            | SELECT FROM
            |====================================================
             -->
            <?php
            $encrypter = app('Illuminate\Encryption\Encrypter');
            $encrypted_token = $encrypter->encrypt(csrf_token());
            ?>
            <input id="token" type="hidden" value="{{$encrypted_token}}">
            {!! Form::open(['action'=>'Client\helpdesk\FormController@postedForm','method'=>'post', 'enctype'=>'multipart/form-data']) !!}
            <div>
                <div class="content-header">
                    <h4>{!! Lang::get('helpdesk::tickets.ticket') !!} {!! Form::submit(Lang::get('helpdesk::tickets.send'),['class'=>'form-group btn btn-info pull-right'])!!}</h4>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-12 form-group {{ $errors->has('help_topic') ? 'has-error' : '' }}">
                        {!! Form::label('help_topic', Lang::get('helpdesk::tickets.choose_a_help_topic')) !!}
                        {!! $errors->first('help_topic', '<span class="help-block">:message</span>') !!}
                        <?php
                        $forms = Modules\Core\Models\Form\Forms::get();
                        $helptopic = Modules\Tickets\Models\TicketHelpTopic::get();
                        ?>
                        <select name="helptopic" class="form-control" id="selectid">
                            <?php
                            $system_default_department = Modules\Core\Models\Settings\System::where('id', '=', 1)->first();
                            if ($system_default_department->department) {
                                $department_relation_helptopic = Modules\Tickets\Models\TicketHelpTopic::where('department', '=', $system_default_department->department)->first();
                                $default_helptopic = $department_relation_helptopic->id;
                            } else {
                                $default_helptopic = 0;
                            }

                            ?>
                            @foreach($helptopic as $topic)
                                <option value="{!! $topic->id !!}">{!! $topic->topic !!}</option>
                            @endforeach
                            {{-- @foreach($forms as $key=>$value) --}}
                            {{-- <option value="{!! $value->id !!}">{!! ucfirst($value->formname) !!}</option> --}}
                            {{-- @endforeach --}}
                        </select>
                    </div>
                    <div class="col-md-12 form-group {{ $errors->has('Name') ? 'has-error' : '' }}">

                        {!! Form::label('Name',Lang::get('helpdesk::tickets.name')) !!}
                        {!! $errors->first('Name', '<span class="help-block">:message</span>') !!}
                        {!! Form::text('Name',null,['class' => 'form-control']) !!}

                    </div>

                    <div class="col-md-6 form-group {{ $errors->has('Email') ? 'has-error' : '' }}">

                        {!! Form::label('Email',Lang::get('helpdesk::tickets.email')) !!}
                        {!! $errors->first('Email', '<span class="help-block">:message</span>') !!}
                        {!! Form::text('Email',null,['class' => 'form-control']) !!}

                    </div>
                    <div class="col-md-6 form-group {{ $errors->has('Phone') ? 'has-error' : '' }}">

                        {!! Form::label('Phone',Lang::get('helpdesk::tickets.phone')) !!}
                        {!! $errors->first('Phone', '<span class="help-block">:message</span>') !!}
                        {!! Form::text('Phone',null,['class' => 'form-control']) !!}

                    </div>
                    <div class="col-md-12 form-group {{ $errors->has('Subject') ? 'has-error' : '' }}">

                        {!! Form::label('Subject',Lang::get('helpdesk::tickets.subject')) !!}
                        {!! $errors->first('Subject', '<span class="help-block">:message</span>') !!}
                        {!! Form::text('Subject',null,['class' => 'form-control']) !!}

                    </div>
                    <div class="col-md-12 form-group {{ $errors->has('Details') ? 'has-error' : '' }}">

                        {!! Form::label('Details',Lang::get('helpdesk::tickets.message')) !!}
                        {!! $errors->first('Details', '<span class="help-block">:message</span>') !!}
                        {!! Form::textarea('Details',null,['class' => 'form-control']) !!}

                    </div>
                    <div class="col-md-12 form-group">

                        <div class="btn btn-default btn-file"><i
                                    class="fa fa-paperclip"> </i> {!! Lang::get('helpdesk::tickets.attachment') !!}
                            <input type="file" name="attachment[]" multiple/></div>
                        <br/>
                        {!! Lang::get('helpdesk::tickets.max') !!}. 10MB
                    </div>
                    {{-- Event fire --}}
                    <?php Event::fire(new App\Events\ClientTicketForm()); ?>

                    <div class="col-md-12" id="response"></div>
                    <div id="ss" class="xs-md-6 form-group {{ $errors->has('') ? 'has-error' : '' }}"></div>
                </div>
            </div>
            {!! Form::close() !!}
    </div>
    <!--
    |====================================================
    | SELECTED FORM STORED IN SCRIPT
    |====================================================
     -->
    <script type="text/javascript">

        $('#selectid').on('change', function () {
            var value = $('#selectid').val();
            $.ajax({
                url: "postform/" + value,
                type: "post",
                data: value,
                success: function (data) {
                    $('#response').html(data);
                    //location.reload();
                }
            });
        });

        $(function () {
            //Add text editor
            $("textarea").wysihtml5();
        });

    </script>

@stop