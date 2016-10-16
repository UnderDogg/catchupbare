<div id="ticket" class="tab-pane fade in active">
  <div class="boxspace">
    <table class="table table-hover table-bordered table-striped">
      <h4>All Tickets</h4>
      <thead>
        <thead>
          <tr>
            <th>Title</th>
            <th>Assigned user</th>
            <th>Created date</th>
            <th>Deadline</th>
            <th><a href="{{ route('tickets.create', ['relation' => $relation->id])}}"><button class="btn btn-success">Add new ticket</button> </a></th>
            
          </tr>
        </thead>
        <tbody>
          <?php  $tr =""; ?>
          @foreach($relation->alltickets as $ticket)
          @if($ticket->status_id == 1)
          <?php  $tr = '#adebad'; ?>
          @elseif($ticket->status_id == 2)
          <?php $tr = '#ff6666'; ?>
          @endif
          <tr style="background-color:<?php echo $tr ;?>">
            
            <td > <a href="{{ route('tickets.show', $ticket->id) }}">{{$ticket->title}} </a></td>
            <td > <div class="popoverOption"
              rel="popover"
              data-placement="left"
              data-html="true"
              data-original-title="<span class='glyphicon glyphicon-user' aria-hidden='true'> </span> {{$ticket->assignee->name}}">
              <div id="popover_content_wrapper" style="display:none; width:250px;">
                <img src='http://placehold.it/350x150' height='80px' width='80px' style="float:left; margin-bottom:5px;"/>
                <p class="popovertext">
                  <span class="glyphicon glyphicon-envelope" aria-hidden="true"> </span>
                  <a href="mailto:{{$ticket->assignee->email}}">
                    {{$ticket->assignee->email}}<br />
                  </a>
                  <span class="glyphicon glyphicon-headphones" aria-hidden="true"> </span>
                  <a href="mailto:{{$ticket->assignee->work_number}}">
                  {{$ticket->assignee->work_number}}</p>
                </a>
                
              </div>
              <a href="{{route('staff.show', $ticket->assignee->id)}}"> {{$ticket->assignee->name}}</a>
              
              </div> <!--Shows users assigned to ticket -->
            </td>
            <td>{{date('d, M Y, H:i', strTotime($ticket->created_at))}}  </td>
            <td>{{date('d, M Y', strTotime($ticket->deadline))}}
            @if($ticket->status_id == 1)({{ $ticket->days_until_deadline }}) @endif</td>
            <td></td>
          </tr>
          
          @endforeach
          
        </tbody>
      </table>
    </div>