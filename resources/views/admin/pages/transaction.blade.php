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
                            <form action="{{ route('updateTransaction') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><strong>Transaction No</strong> <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="{{ @$data->transaction_no }}" name="transaction_no" id="transaction_no">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><strong>Paid Amount</strong> <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="{{ @$data->paid_amount }}" name="paid_amount" id="paid_amount">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><strong>Due Amount</strong> <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="{{ @$data->due_amount }}" name="due_amount" id="due_amount">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><strong>Status</strong> <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="status" class="form-control">
                                            <option value="paid" @if($data->status == 'Paid') selected @endif>Paid</option>
                                            <option value="paid" @if($data->status == 'Unpaid') selected @endif>Unpaid</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><strong>Narration</strong> <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="narration" rows="3">{{ $data->narration }}</textarea>
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