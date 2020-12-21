@extends('admin.layouts.master')
@section('content')
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
                            <form action="{{ route('updateTransaction') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><strong>Transaction No</strong> <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="" name="transaction_no" id="transaction_no">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><strong>Paid Amount</strong> <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="" name="paid_amount" id="paid_amount">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><strong>Due Amount</strong> <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="" name="due_amount" id="due_amount">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><strong>Status</strong> <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="status" class="form-control">
                                            <option value="paid" >Paid</option>
                                            <option value="paid" >Unpaid</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><strong>Narration</strong> <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="narration" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-8">
                                        <button type="submit" class="btn btn-primary m-b-0 m-r-5">Update</button>
                                    </div>
                                </div>
                            </form>
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