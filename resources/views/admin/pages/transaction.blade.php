@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-sm-12">
            <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
                  <li class=" active"><a href="#create" data-toggle="tab">Update Transaction Detail</a></li>
               </ul>
               <div class="tab-content bg-white">
                  <div class="tab-pane  active " id="create">
                      <div class="row">                        
                        <div class="col-sm-12"> 
                            <div class="box box-primary">
                                <form method="POST" id="transaction-form" accept-charset="UTF-8">
                                    @csrf
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="input-daterange">                                            
                                            <div class="col-xs-3">
                                                <div class="input-container">
                                                    <select name="vendor_id" id="vendor_id" class="input-field">
                                                        <option selected disabled>Choose Vendor</option> 
                                                        @if(!empty($all_vendor))
                                                        @foreach($all_vendor as $vendor_list) 
                                                        <option value="{{ $vendor_list->id }}" @if($vendor_list->id == @$vendor_id->id) selected @endif>{{ $vendor_list->company }}</option>
                                                        @endforeach
                                                        @endif                                                      
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xs-3">
                                                <div class="input-container">
                                                    <select name="date" id="date" class="input-field">
                                                        <option selected disabled>Select Transaction Date</option>                                                 
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xs-3">
                                                <div class="input-container">
                                                    <select name="type" id="type" class="input-field">
                                                        <option selected disabled>Select Transaction Type</option>
                                                        <option value="item-price">Item price</option>
                                                        <option value="commission">Commission</option>                                                
                                                        <option value="delivery-charge">Delivery Charge</option>                                                
                                                                                                        
                                                    </select>
                                                </div>
                                            </div>
                                                                        
                                            <div class="col-xs-2">
                                            <div class="input-container">
                                                <button type="submit" id="filter" name="filter" class="btn btn-primary m-b-0 m-r-5 filter-btn" value="active"> Search </button>                                                
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                      </div>
                      <br><br><br>                      
                      <div class="row">
                        <div class="col-md-12">
                            <div id="transaction_data"></div>
                        </div>
                      </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('scripts')
<script>
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

$("#transaction-form").on('submit', function(){
    event.preventDefault();
    var datastring = $("#transaction-form").serialize();
    $.ajax({
        type: "POST",
        url: "{{ route('transaction.detail') }}",
        data: datastring,
        success: function(data) {
            $('#transaction_data').append(data);
        },
        error: function() {
            alert('error handling here');
        }
    });
});
</script>
@endsection