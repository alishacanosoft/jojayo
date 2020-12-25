<option selected disabled>--Select Transaction Date--</option>
@foreach($data as $row)
@if(date('d', strtotime($row->created_at)) > 14 && date('d', strtotime($row->created_at)) <= 21){
<option value="{{ date('Y-m-15') }}">{{ date('15 F Y',strtotime($row->created_at)).' - '.date('21 F Y',strtotime($row->created_at)) }}</option>
@elseif(date('d', strtotime($row->created_at)) > 21 && date('d', strtotime($row->created_at)) <= 28)
<option value="{{ date('Y-m-21') }}">{{ date('21 F Y',strtotime($row->created_at)).' - '.date('28 F Y',strtotime($row->created_at)) }}</option>
@elseif(date('d', strtotime($row->created_at)) > 7 && date('d', strtotime($row->created_at)) <= 14)
<option value="{{ date('Y-m-8') }}">{{ date('8 F Y',strtotime($row->created_at)).' - '.date('14 F Y',strtotime($row->created_at)) }}</option>
@elseif(date('d', strtotime($row->created_at)) <= 7)
<option value="{{ date('Y-m-7') }}">{{ date('1 F Y',strtotime($row->created_at)).' - '.date('7 F Y',strtotime($row->created_at)) }}</option>
@endif
@endforeach