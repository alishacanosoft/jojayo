@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-sm-22">
            <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
                  <li class="@if($active_tab == 'manage') active @endif"><a href="#manage" data-toggle="tab">Percent List</a></li>
                  <li class=''><a href="#create" data-toggle="tab">Add Percent</a></li>
                  <input type="hidden" id="base" value="{{ route('ajax.users') }}">
               </ul>
               <div class="tab-content bg-white">
                  <div class="tab-pane @if($active_tab == 'manage') active @endif" id="manage">
                     <div class="table-responsive">
                     <table class="table table-striped table-bordered nowrap datatable_action" role="grid" aria-describedby="basic-col-reorder_info">
                        <thead>
                            <tr>
                                <th>Vendor</th>
                                <th>Price Range</th>                                
                                <th>Percent</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($percent_list)) @foreach($percent_list as $list)
                            <tr id="{{ $list->id }}">
                                <td>{{ $list->vendor_details->company }}</td>
                                <td>
                                    {{ $list->commission_details->price_range }}                                    
                                </td>                                
                                <td>{{ $list->percent }}</td>                                
                                <td>
                                    <a href="{{ route('vendors.percent.edit', $list->id) }}" class="btn btn-primary btn-xs" style="margin-right: 5px">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    
                                    <a style="display:inline-block" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <form method="POST" action="{{ route('users.destroy', $list->id) }}" accept-charset="UTF-8">
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
                        <form action="{{ route('user.percent') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @csrf                    
                            <div class="page-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-22">
                                        <div class="card">
                                        <div class="card-block">
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label"><strong>Price Range</strong> <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <select name="commission_id" id="commission_id" class="form-control">
                                                    <option selected disabled>--Select price range--</option>
                                                    @if(!empty($all_commission))
                                                    @foreach($all_commission as $commissionList)
                                                    <option value="{{ $commissionList->id }}" @if($commissionList->id == @$data->commission_id) selected @endif>{{ $commissionList->price_range }}</option>
                                                    @endforeach
                                                    @endif
                                                    </select>
                                                    <span class="messages"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label"><strong>Percent</strong> <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" value="{{ @$data->percent }}" name="percent" id="percent" placeholder="Percent to charge for the selected amount">
                                                    <input type="hidden" name="vendor_id" value="{{ Request::segment(3) }}">
                                                    <span class="messages"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2"></label>
                                                <div class="col-sm-8">
                                                    <button type="submit" class="btn btn-primary m-b-0 pull-right ml-2">{{ @$data !== null ? 'Update' : 'Add' }} Commission</button>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
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