@extends('admin.layouts.master')
@section('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
    .same-row{
        display:inline-flex;
    }
    .same-row label{
        margin-right: 5px;
        padding-top: 5px;
    }    
    table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
    }

    td, th {
    border-right: 1px solid #dddddd;
    border-left: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
    }

    button.transparent {
        background: transparent;
        border: none;
        cursor: pointer;
    }     
</style>

@endsection
@section('content')
<div class="container">
    <div class="col-lg-12">
        <div class="row">
            <!--<input type="text" name="daterange" value="01/01/2018 - 01/15/2018" />-->
            @php
            $vendor_id = App\Models\Vendor::where('user_id', \Auth::user()->id)->first();
            @endphp
            <div class="form-group @if (!Auth::user()->admin()) hidden @endif">
                 <div class="col-md-4 col-lg-4 same-row" style="padding-top:5px">
                    <label>Supplier</label>
                    <select name="vendor_id" id="vendor_id" class="requires form-control">
                        <option selected disabled>--Select Vendor--</option>
                        @if(!empty($all_vendor))
                        @foreach($all_vendor as $vendor_list)
                        <option value="{{ $vendor_list->id }}" @if($vendor_list->id == @$vendor_id->id) selected @endif>{{ $vendor_list->company }}</option>
                        @endforeach
                        @endif
                    </select>
                 </div>
            </div>
            
            <div class="form-group">
                 <div class="col-md-4 col-lg-4 same-row">
                    <label>Period</label>
                    <select name="date" id="date" class="requires form-control">
                        <option selected disabled>--Select Transaction Date--</option>
                    </select>
                 </div>
            </div>
            
        </div>
        <br><hr style="border-top: 1px solid #ffffff;"><br>    
    </div>
</div>
<section id="invoice"></section>
@section('scripts')
<script>
var admin = "{{ Auth::user()->roles }}";
if(admin == 'admin'){
    admin = 'yes';
} else {
    admin = 'no';
}
if (admin == 'no'){
    var vendor_id = $('#vendor_id').find(":selected").val();
    $.ajax({
        url: "/auth/get_vendor_data/"+vendor_id,
        success: function(response){
            $('#date').html(response);
        }
    })
}
$('#vendor_id').on('change', function(){
    var vendor_id = $(this).val();
    $.ajax({
        url: "/auth/get_vendor_data/"+vendor_id,
        success: function(response){
            $('#date').html(response);             
        }
    })
})

$('#date').on('change', function(){
    var vendor_id = $('#vendor_id').find(":selected").val();
    var date = $(this).val();
    $.ajax({
        url: "/auth/get_statement/"+vendor_id+"/"+date,
        success: function(response){
            $('#invoice').html(response);
        }
    })
})

$(document).on('click','.btn-default', function(){
    var icon = $(this).find('span').attr('class');
    if(icon == 'fa fa-plus'){
        $(this).find('span').attr('class', 'fa fa-minus');
    } else {
        $(this).find('span').attr('class', 'fa fa-plus');
    }
})
</script>
@endsection
@endsection