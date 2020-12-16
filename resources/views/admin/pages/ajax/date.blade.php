<option selected disabled>--Select Transaction Date--</option>
@foreach($data as $row)
@if(date('d', strtotime($row->order_created)) > 14 && date('d', strtotime($row->order_created)) <= 21){
<option value="{{ date('Y-m-15') }}">{{ date('15 F Y',strtotime($row->order_created)).' - '.date('21 F Y',strtotime($row->order_created)) }}</option>
@elseif(date('d', strtotime($row->order_created)) > 21 && date('d', strtotime($row->order_created)) <= 28)
<option value="{{ date('Y-m-21') }}">{{ date('21 F Y',strtotime($row->order_created)).' - '.date('28 F Y',strtotime($row->order_created)) }}</option>
@elseif(date('d', strtotime($row->order_created)) > 7 && date('d', strtotime($row->order_created)) <= 14)
<option value="{{ date('Y-m-8') }}">{{ date('8 F Y',strtotime($row->order_created)).' - '.date('14 F Y',strtotime($row->order_created)) }}</option>
@elseif(date('d', strtotime($row->order_created)) <= 7)
<option value="{{ date('Y-m-7') }}">{{ date('1 F Y',strtotime($row->order_created)).' - '.date('7 F Y',strtotime($row->order_created)) }}</option>
@endif
@endforeach