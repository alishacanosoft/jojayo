@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-sm-12">
            <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
                  <li class="@if($active_tab == 'manage') active @endif"><a href="#manage" data-toggle="tab">All Accounts</a></li>
                  <li class="@if($active_tab == 'create') active @endif"><a href="#create" data-toggle="tab">New Account</a></li>
                  <input type="hidden" id="base" value="{{ route('ajax.categories') }}">
               </ul>
               <div class="tab-content bg-white">
                  <div class="tab-pane @if($active_tab == 'manage') active @endif" id="manage">
                     <div class="table-responsive">
                     <table class="table table-striped table-bordered nowrap datatable_action" role="grid" aria-describedby="basic-col-reorder_info">
                        <thead>
                            <tr>
                                <th>Account name</th>
                                <th>Account holder</th>
                                <th>Account number</th>
                                <th>Account status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($allAccount)
                                @foreach($allAccount as $account)
                                <tr>
                                <td>{{ $account->name }}</td>
                                <td>{{ $account->account_holder }}</td>
                                <td>{{ $account->account_number }}</td>
                                <td>{{ ucfirst($account->status) }}</td>
                                <td>
                                    <a href="{{ route('accounts.edit', $account->id) }}" class="btn btn-primary btn-xs pull-left" style="margin-right: 5px">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    <a class="pull-left" onclick="return confirm('Are you sure you want to delete this account?')">
                                        <form method="POST" action="{{ route('accounts.destroy', $account->id) }}" accept-charset="UTF-8">
                                            <input name="_method" type="hidden" value="DELETE">
                                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                            <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash-o"></i></button>
                                        </form>
                                    </a>
                                </td>
                            </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                     </div>
                  </div>
                  <div class="tab-pane @if($active_tab == 'create') active @endif" id="create">
                  @if(!empty($data))
                        {{ Form::open(['url'=>route('accounts.update', $data->id), 'class'=>'form-horizontal', 'id'=>'post_add', 'files'=>true,'method'=>'patch']) }}
                    @else
                        <form action="{{ route('accounts.store') }}" method="POST" class="form-horizontal">
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
@endsection