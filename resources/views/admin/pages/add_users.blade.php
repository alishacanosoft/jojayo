@extends('admin.layouts.master')
@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-header">
                        <div class="page-header-title">
                            <h4>{{ @$data !== null ? 'Update' : 'Add' }} user</h4>
                        </div>
                    </div>
                    @if(!empty(@$data))
                        {{ Form::open(['url'=>route('users.update', @$data->id), 'class'=>'form', 'id'=>'user_add', 'files'=>true,'method'=>'patch']) }}
                        <input name="_method" type="hidden" value="PATCH">
                    @else
                        <form action="{{ route('users.store') }}" method="POST">
                            @endif
                            @csrf
                            <div class="page-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{--{{ @$data !== null ? 'Update' : 'Add' }} user--}}</h5>
                                                <div class="card-header-right">
                                                    <i class="icofont icofont-rounded-down"></i>
                                                    <i class="icofont icofont-refresh"></i>
                                                    <i class="icofont icofont-close-circled"></i>
                                                </div>
                                            </div>
                                            <div class="card-block">
                                                <div class="form-group row">
                                                    <div class="col-sm-1">
                                                        <label for="">Fullname</label>
                                                    </div>
                                                    <div class="col-sm-11">
                                                        <input type="text" class="form-control" value="{{ @$data->name }}" name="name" id="name" placeholder="Enter title for the user">
                                                        <input type="hidden" class="form-control" value="{{ @$employee_detail->slug }}" name="slug" id="slug">
                                                        <span class="messages"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-1">
                                                        <label for="">Email</label>
                                                    </div>
                                                    <div class="col-sm-11">
                                                        <input type="email" class="form-control" value="{{ @$data->email }}" name="email" id="email" placeholder="Unique email address">
                                                        <span class="messages"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-1">
                                                        <label for="">Password</label>
                                                    </div>
                                                    <div class="col-sm-11">
                                                        <input type="password" class="form-control" value="" name="password" id="password" placeholder="Type here only if you want to change the password">
                                                        <span class="messages"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-1">
                                                        <label for="">Contact</label>
                                                    </div>
                                                    <div class="col-sm-11">
                                                        <input type="number" class="form-control" value="{{ @$data->contact }}" name="contact" id="contact" placeholder="Contact number">
                                                        <span class="messages"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-1">
                                                        <label for="">Role</label>
                                                    </div>
                                                    <div class="col-sm-11">
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
                                                        <div class="col-sm-1">
                                                            <label for="">Company</label>
                                                        </div>
                                                        <div class="col-sm-11">
                                                            <input type="text" class="form-control" value="{{ @$vendor_data->company }}" name="company" id="company" placeholder="Name of the company">
                                                            <span class="messages"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-1">
                                                            <label for="">Address</label>
                                                        </div>
                                                        <div class="col-sm-11">
                                                            <input type="text" class="form-control" value="{{ @$vendor_data->vendor_address }}" name="vendor_address" id="address" placeholder="Addresss">
                                                            <span class="messages"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-1">
                                                            <label for="">C.Address</label>
                                                        </div>
                                                        <div class="col-sm-11">
                                                            <input type="text" class="form-control" value="{{ @$vendor_data->company_address }}" name="company_address" id="address" placeholder="Addresss">
                                                            <span class="messages"></span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group row">
                                                        <div class="col-sm-1">
                                                            <label for="">Categories</label>
                                                        </div>
                                                        <div class="col-sm-11"> 
                                                            <select class="select2 form-control" name="categories[]" multiple="multiple">
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
                                                        <div class="col-sm-1">
                                                            <label for="">Status</label>
                                                        </div>
                                                        <div class="col-sm-11">
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
                                                        <div class="col-sm-1">
                                                            <label for="">Address</label>
                                                        </div>
                                                        <div class="col-sm-11">
                                                            <input type="text" class="form-control" value="{{ @$employee_data->address }}" name="address" id="address" placeholder="Addresss">
                                                            <span class="messages"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-1">
                                                            <label for="">Salary</label>
                                                        </div>
                                                        <div class="col-sm-11">
                                                            <input type="number" class="form-control" value="{{ @$employee_data->salary }}" name="salary" id="salary" placeholder="Salary for the employee">
                                                            <span class="messages"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-1">
                                                            <label for="">DOB</label>
                                                        </div>
                                                        <div class="col-sm-11">
                                                            <input type="date" class="form-control" value="{{ @$employee_data->DOB }}" name="DOB" id="DOB" placeholder="Date of birth">
                                                            <span class="messages"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-1">
                                                            <label for="">Status</label>
                                                        </div>
                                                        <div class="col-sm-11">
                                                            <select name="status" id="status" class="form-control">
                                                                <option selected disabled>--Select user status--</option>
                                                                <option value="active" {{  @$employee_data->status == 'active' ? 'selected' : ''}}>Active</option>
                                                                <option value="inactive" {{  @$employee_data->status == 'inactive' ? 'selected' : ''}}>Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>                                                
                                                <div class="form-group row">
                                                    <div class="col-sm-1">
                                                        <label for="">Image</label>
                                                    </div>
                                                    <div class="col-sm-11">
                                                        <div class="row">
                                                            <a style="margin-left:10px" href="{{ url('/vendor/filemanager/dialog.php?type=4&field_id=thumbnail&descending=1&sort_by=date&lang=undefined&akey=061e0de5b8d667cbb7548b551420eb821075e7a6') }}" class="btn iframe-btn btn-primary" type="button">
                                                                <i class="fa fa-picture-o"></i> Choose
                                                            </a>
                                                            <input id="thumbnail" class="form-control" value="{{ @$data->image }}" type="text" name="image" style="width: 88%;">
                                                        </div>
                                                        @if(!empty(@$data->image))
                                                            <img id="holder" src="{{ @$data->image }}" class="img-responsive img-thumbnail" style="margin-top:15px;max-height:240px;margin-bottom:10px">
                                                        @else
                                                            <img id="holder" class="img-responsive img-thumbnail" style="margin-top:15px;max-height:240px;margin-bottom:10px">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-1"></label>
                                                    <div class="col-sm-11">
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
