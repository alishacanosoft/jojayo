@extends('admin.layouts.master') @section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Add Account Details</h4>
                                    <span class="text-danger">Click the button next to your company logo on the left to see the full columns of the table.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <div class="card">
                              <div class="card-header">
                                  <h5>Add new account</h5>
                                  <div class="card-header-right">
                                      <i class="icofont icofont-rounded-down"></i>
                                  </div>
                              </div>
                              <div class="card-block">
                                  <div class="row">
                                      <div class="col-12">
                                        @if(!empty($data))
                                            {{ Form::open(['url'=>route('accounts.update', $data->id), 'class'=>'form', 'id'=>'post_add', 'files'=>true,'method'=>'patch']) }}
                                        @else
                                            <form action="{{ route('accounts.store') }}" method="POST">
                                                @endif
                                                @csrf
                                              <div class="form-group row">
                                                  <div class="col-md-4 col-lg-2">
                                                      <label for="slug" class="block">Name of the account</label>
                                                  </div>
                                                  <div class="col-md-8 col-lg-10">
                                                      <input type="text" class="form-control" name="name" id="name" value="{{ @$data->name }}">
                                                  </div>
                                              </div>

                                              <div class="form-group row">
                                                  <div class="col-md-4 col-lg-2">
                                                      <label for="slug" class="block">Account holder</label>
                                                  </div>
                                                  <div class="col-md-8 col-lg-10">
                                                      <input type="text" class="form-control" id="account_holder" name="account_holder" value="{{ @$data->account_holder }}">
                                                  </div>
                                              </div>

                                              <div class="form-group row">
                                                  <div class="col-md-4 col-lg-2">
                                                      <label for="account number" class="block">Account number</label>
                                                  </div>
                                                  <div class="col-md-8 col-lg-10">
                                                      <input type="text" class="form-control" id="account_number" name="account_number" value="{{ @$data->account_number }}">
                                                  </div>
                                              </div>

                                              <div class="form-group row">
                                                  <div class="col-md-4 col-lg-2">
                                                      <label for="slug" class="block">Account type</label>
                                                  </div>
                                                  <div class="col-md-8 col-lg-10">
                                                      <select class="form-control" name="payment_id">
                                                          <option>--Select Account Type--</option>
                                                          @if($methods)
                                                              @foreach($methods as $allmethods)
                                                                  <option value="{{ $allmethods->id }}" @if($allmethods->id == @$data->payment_id) selected @endif>{{ $allmethods->name }}</option>
                                                              @endforeach
                                                          @endif
                                                      </select>
                                                  </div>
                                              </div>

                                              <div class="form-group row">
                                                  <div class="col-md-4 col-lg-2">
                                                      <label for="slug" class="block">Account status</label>
                                                  </div>
                                                  <div class="col-md-8 col-lg-10">
                                                      <select class="form-control" name="status">
                                                          <option>--Select Status--</option>
                                                          <option value="active" @if(@$data->status == 'active') selected @endif>Active</option>
                                                          <option value="inactive" @if(@$data->status == 'inactive') selected @endif>Inactive</option>
                                                      </select>
                                                  </div>
                                              </div>

                                              <div class="form-group row">
                                                  <div class="col-md-4 col-lg-2">
                                                      <label for="brand-2" class="block"></label>
                                                  </div>
                                                  <div class="col-md-8 col-lg-10">
                                                  <button type="submit" class="btn btn-primary">Save</button>
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
    </div>
</div>
@endsection
