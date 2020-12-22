@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-sm-22">
            <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
                  <li class="@if($active_tab == 'manage') active @endif"><a href="#manage" data-toggle="tab">Vendor</a></li>
                  <li class=''><a href="#customersTab" data-toggle="tab">Customer</a></li>
                  <li class=''><a href="#employeeTab" data-toggle="tab">Employee</a></li>
                  <li class=''><a href="#create" data-toggle="tab">New User</a></li>
                  <input type="hidden" id="base" value="{{ route('ajax.users') }}">
               </ul>
               <div class="tab-content bg-white">
                  <div class="tab-pane @if($active_tab == 'manage') active @endif" id="manage">
                     <div class="table-responsive">
                     <table class="table table-striped table-bordered nowrap datatable_action" role="grid" aria-describedby="basic-col-reorder_info">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($vendors)) @foreach($vendors as $vendor)
                            <tr id="{{ $vendor->id }}">
                                <td><input type="checkbox" name="delete_items" value="{{ $vendor->id }}"></td>
                                <td>
                                    <a href="{{ route('user.info', $vendor->id) }}">
                                        {{ $vendor->name }}
                                    </a>
                                </td>
                                <td>{{ $vendor->email }}</td>
                                <td>{{ $vendor->roles }}</td>
                                <td><a href="{{ asset('uploads/users/'.$vendor->image) }}" class="iframe-btn">View Profile Image</a></td>
                                <td>
                                    <a href="{{ route('users.edit', $vendor->id) }}" class="btn btn-primary btn-xs" style="margin-right: 5px">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    <a href="{{ route('vendors.percent', $vendor->id) }}" class="btn btn-primary btn-xs" style="margin-right: 5px">
                                        <i class="fa fa-percent"></i>
                                    </a>
                                    <a style="display:inline-block" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <form method="POST" action="{{ route('users.destroy', $vendor->id) }}" accept-charset="UTF-8">
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

                  <div class="tab-pane" id="customersTab">
                     <div class="table-responsive">
                     <table class="table table-striped table-bordered nowrap datatable_action" role="grid" aria-describedby="basic-col-reorder_info">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($customers)) @foreach($customers as $customer)
                            <tr id="{{ $customer->id }}">
                                <td><input type="checkbox" name="delete_items" value="{{ $customer->id }}"></td>
                                <td>
                                    <a href="{{ route('user.info', $customer->id) }}">
                                        {{ $customer->name }}
                                    </a>
                                </td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->roles }}</td>
                                <td><a href="{{ asset('uploads/users/'.$customer->image) }}" class="iframe-btn">View Profile Image</a></td>
                                <td>
                                    <a href="{{ route('users.edit', $customer->id) }}" class="btn btn-primary btn-xs" style="margin-right: 5px">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    <a style="display:inline-block" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <form method="POST" action="{{ route('users.destroy', $customer->id) }}" accept-charset="UTF-8">
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

                  <div class="tab-pane" id="employeeTab">
                     <div class="table-responsive">
                     <table class="table table-striped table-bordered nowrap datatable_action" role="grid" aria-describedby="basic-col-reorder_info">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($allUsers)) @foreach($allUsers as $userLists)
                            <tr id="{{ $userLists->id }}">
                                <td><input type="checkbox" name="delete_items" value="{{ $userLists->id }}"></td>
                                <td>
                                    <a href="{{ route('user.info', $userLists->id) }}">
                                        {{ $userLists->name }}
                                    </a>
                                </td>
                                <td>{{ $userLists->email }}</td>
                                <td>{{ $userLists->roles }}</td>
                                <td><a href="{{ asset('uploads/users/'.$userLists->image) }}" class="iframe-btn">View Profile Image</a></td>
                                <td>
                                    <a href="{{ route('users.edit', $userLists->id) }}" class="btn btn-primary btn-xs" style="margin-right: 5px">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    <a style="display:inline-block" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <form method="POST" action="{{ route('users.destroy', $userLists->id) }}" accept-charset="UTF-8">
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
                  @if(!empty(@$data))
                        {{ Form::open(['url'=>route('users.update', @$data->id), 'class'=>'form-horizontal', 'id'=>'user_add', 'files'=>true,'method'=>'patch']) }}
                        <input name="_method" type="hidden" value="PATCH">
                    @else
                        <form action="{{ route('users.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                            @endif
                            @csrf
                            <div class="page-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-22">
                                        <div class="card">
                                            <div class="card-block">
                                                <div class="form-group row">
                                                    <label class="col-sm-2 control-label"><strong>Fullname</strong> <span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" value="{{ @$data->name }}" name="name" id="name" placeholder="Enter title for the user">
                                                        <input type="hidden" class="form-control" value="{{ @$employee_detail->slug }}" name="slug" id="slug">
                                                        <span class="messages"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 control-label"><strong>Email</strong> <span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="email" class="form-control" value="{{ @$data->email }}" name="email" id="email" placeholder="Unique email address">
                                                        <span class="messages"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 control-label"><strong>Password</strong> <span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="password" class="form-control" value="" name="password" id="password" placeholder="Type here only if you want to change the password">
                                                        <span class="messages"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 control-label"><strong>Contact</strong> <span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="number" class="form-control" value="{{ @$data->contact }}" name="contact" id="contact" placeholder="Contact number">
                                                        <span class="messages"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 control-label"><strong>Role</strong> <span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <select name="roles" id="role" class="form-control">
                                                            <option selected disabled>--Select user type--</option>
                                                            <option value="admin" {{  @$data->roles == 'admin' ? 'selected' : ''}}>Admin</option>
                                                            <option value="vendor" {{  @$data->roles == 'vendor' ? 'selected' : ''}}>Vendor</option>
                                                            <option value="employee" {{  @$data->roles == 'employee' ? 'selected' : ''}}>Editor</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div id="vendor">
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label"><strong>Company</strong> <span class="text-danger">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" value="{{ @$vendor_data->company }}" name="company" id="company" placeholder="Name of the company">
                                                            <span class="messages"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label"><strong>Address</strong> <span class="text-danger">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" value="{{ @$vendor_data->vendor_address }}" name="vendor_address" id="address" placeholder="Addresss">
                                                            <span class="messages"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label"><strong>C.Address</strong> <span class="text-danger">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" value="{{ @$vendor_data->company_address }}" name="company_address" id="address" placeholder="Addresss">
                                                            <span class="messages"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label"><strong>PAN</strong> <span class="text-danger">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" value="{{ @$vendor_data->pan }}" name="pan" id="address" placeholder="PAN Number">
                                                            <span class="messages"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label"><strong>Categories</strong> <span class="text-danger">*</span></label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control select_box select2-hidden-accessible" name="categories[]" multiple="multiple">
                                                                <?php
                                                                if($allCategories){
                                                                    foreach ($allCategories as $categoryList){
                                                                        $checked = '';
                                                                        if(!empty($permitted)){
                                                                            if (is_array($permitted) || is_object($permitted)) {
                                                                            foreach ($permitted as $key => $value) {
                                                                            if($categoryList->id == $value['category_id']){
                                                                            $checked = 'selected';
                                                                            break;
                                                                            }
                                                                        }
                                                                        }
                                                                        }
                                                                        ?>
                                                                        <option value="{{ $categoryList->id }}" {{ $checked}}>{{ $categoryList->name }}</option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                              </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label"><strong>Status</strong> <span class="text-danger">*</span></label>
                                                        <div class="col-sm-8">
                                                            <select name="status" id="status" class="form-control">
                                                                <option selected disabled>--Select user status--</option>
                                                                <option value="verified" {{  @$vendor_data->status == 'verified' ? 'selected' : ''}}>Verified</option>
                                                                <option value="unverified" {{  @$vendor_data->status == 'unverified' ? 'selected' : ''}}>Not verified</option>
                                                                <option value="suspended" {{  @$vendor_data->status == 'suspended' ? 'selected' : ''}}>Suspended</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="employee">
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label"><strong>Address</strong> <span class="text-danger">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" value="{{ @$employee_data->address }}" name="address" id="address" placeholder="Addresss">
                                                            <span class="messages"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label"><strong>Salary</strong> <span class="text-danger">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control" value="{{ @$employee_data->salary }}" name="salary" id="salary" placeholder="Salary for the employee">
                                                            <span class="messages"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label"><strong>DOB</strong> <span class="text-danger">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="date" class="form-control" value="{{ @$employee_data->DOB }}" name="DOB" id="DOB" placeholder="Date of birth">
                                                            <span class="messages"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label"><strong>Status</strong> <span class="text-danger">*</span></label>
                                                        <div class="col-sm-8">
                                                            <select name="status" id="status" class="form-control">
                                                                <option selected disabled>--Select user status--</option>
                                                                <option value="active" {{  @$employee_data->status == 'active' ? 'selected' : ''}}>Active</option>
                                                                <option value="inactive" {{  @$employee_data->status == 'inactive' ? 'selected' : ''}}>Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row small-image">
                                                    <label class="col-sm-2 control-label"><strong>Image</strong> <span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <div class="file-upload no-dash" style="margin-left:0">
                                                            <input type="file" id="files" name="image" style="opacity:1">
                                                        </div>
                                                        @if(!empty($data->image))
                                                        <span class="pip">
                                                            <img class="imageThumb" src="{{ asset('/uploads/users/Thumb-'.$data->image) }}">
                                                        </span>
                                                        @endif
                                                        @if ($errors->has('image'))
                                                        <div class="col-lg-12">
                                                            <span class="validation-errors text-danger">{{ $errors->first('image') }}</span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2"></label>
                                                    <div class="col-sm-8">
                                                        <button type="submit" class="btn btn-primary m-b-0 pull-right ml-2">{{ @$data !== null ? 'Update' : 'Add' }} User</button>
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
@section('scripts')
    <script>
        let data = "<?php echo isset($data) ? 'yes' : 'no' ?>";
        if(data == 'yes'){
            if('{{ @$data->roles }}' == 'vendor'){
                $('#vendor').show();
                $('#employee').hide();
            } else if('{{ @$data->roles }}' == 'employee'){
                $('#vendor').hide();
                $('#employee').show();
            }
        }else if(data == 'no') {
            $('#vendor').hide();
            $('#employee').hide();
        }

        $("#name").keyup(function (){
            let Slug = $('#name').val();
            document.getElementById("slug").value = convertToSlug(Slug);
        });
        $('#role').on('change', function(){
            let role = (this).value;
            if(role == 'vendor'){
                $('#vendor').show(1000);
                $('#employee').hide(1000);
            } else if(role == 'employee'){
                $('#employee').show(1000);
                $('#vendor').hide(1000);
            } else if(role == 'admin'){
                $('#employee').hide(1000);
                $('#vendor').hide(1000);
            }
        });
    </script>
@endsection
