<div>
    <h1 style="3D&quot;font-size:12.8px&quot;">Whoops, looks like something went wrong.</h1>
    <b>URL:</b>&nbsp;{{$url}}<br>
    <b>Method:</b>&nbsp;{{$method}}<br>
    <b>Staff ID:</b>&nbsp;{{$staff_id}}<br>
    <b>Staff name:</b>&nbsp;{{$staff_name}}<br>
    <b>Staff first name:</b>&nbsp;{{$staff_first_name}}<br>
    <b>Staff last name:</b>&nbsp;{{$staff_last_name}}<br>
    <b>Exception type:</b>&nbsp;{{$exception_class}}<br>
    <b>Exception message:</b>&nbsp;{{$exception_message}}<br>
    <b>In file:<br/></b>&nbsp;{{$exception_file}}<br>
    <b>On line:</b>&nbsp;{{$exception_line}}<br>
    <b>Input:</b>&nbsp;<br>
    <code>{{($input)?$input:'None'}}</code>
    <div>
        <b>Stack trace:</b><br>
        <div style="3D&quot;font-size:12.8px=">
            <ol>
                @foreach($exception_trace_formatted as $trace)
                    <li style="3D&quot;margin-left:15px&quot;">{!!$trace!!}</li>
                @endforeach
            </ol>
        </div>
    </div>
</div>
