@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-sm-22">
            <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
                  <li class=""><a href="#manage" data-toggle="tab">User Info</a></li>
                  <li class='active'><a href="#purchaseTab" data-toggle="tab">Purchase</a></li>
               </ul>
               <div class="tab-content bg-white">
                  <div class="tab-pane" id="manage">
                        <div class="page-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-22">
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label"><strong>Fullname</strong> <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" value="{{ @$user->name }}" disabled>
                                                    <span class="messages"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label"><strong>Email</strong> <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" value="{{ @$user->email }}" disabled>
                                                    <span class="messages"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label"><strong>Contact</strong> <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" value="{{ @$user->contact }}" disabled>
                                                    <span class="messages"></span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                  </div>

                  <div class="tab-pane active" id="purchaseTab">
                     <div class="table-responsive">
                     <table class="table table-striped table-bordered nowrap datatable_action" role="grid" aria-describedby="basic-col-reorder_info">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Brand</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($user->vendor->products as $product)
                                <tr>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->category->name}}</td>
                                    <td>{{$product->brand->name}}</td>
                                </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                     </div>
                  </div>

                  <div class="tab-pane" id="salesTab">
                     <div class="table-responsive">
                     <table class="table table-striped table-bordered nowrap datatable_action" role="grid" aria-describedby="basic-col-reorder_info">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Brand</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                     </div>
                  </div>

               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
