<div id="invoice" class="tab-pane fade">
  <div class="boxspace">
    <table class="table table-hover table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Hours</th>
          <th>Total amount</th>
          <th>Invoice sent</th>
          <th>Payment received</th>
        </tr>
      </thead>
      <tbody>
        <?php $total = 0; ?>
        @foreach($invoices as $invoice)
        <tr>
          <td>
            <a href="{{route('invoices.show', $invoice->id)}}">
            {{$invoice->id}}
            </a>
          </td>
          <td>
            <?php $total = 0; ?>
            @foreach($invoice->tickettime as $tickettime)
            <?php $total += $tickettime->time; ?>
            
            @endforeach
            {{$total}}
          </td>
          <td>
            <?php $totalAmount = 0; ?>
            @foreach($invoice->tickettime as $payment)
            <?php $totalAmount += $payment->value; ?>
            @endforeach
            {{$totalAmount}},-
          </td>
          <td>
            @if($invoice->sent == 0)
            <?php $color = "red"; ?>
            @else
            <?php $color = "green"; ?>
            @endif
            <p style=" color:{{$color}}">{{$invoice->sent ? 'yes' : 'no'}}</p>
          </td>
          <td>
            @if($invoice->received == 0)
            <?php $color = "red"; ?>
            @else
            <?php $color = "green"; ?>
            @endif
            <p style=" color:{{$color}}">{{$invoice->received ? 'yes' : 'no'}}</p>
            
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>