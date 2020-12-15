@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-sm-12">
            <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
                  <li class="@if($active_tab == 'manage') active @endif"><a href="#manage" data-toggle="tab">All Categories</a></li>
                  <li class="@if($active_tab == 'create') active @endif"><a href="#create" data-toggle="tab">New Category</a></li>
                  <input type="hidden" id="base" value="{{ route('ajax.categories') }}">
               </ul>
               <div class="tab-content bg-white">
                  <div class="tab-pane @if($active_tab == 'manage') active @endif" id="manage">
                     <div class="table-responsive">
                     <table class="table table-striped datatable_action table-bordered nowrap dataTable" role="grid" aria-describedby="basic-col-reorder_info">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="check">
                            @if(!empty($allcategory))
                            @foreach($allcategory as $key => $cat_list)
                            <tr id="{{ $cat_list->id }}">
                                <input type="hidden" value="{{ $cat_list->id }}">
                                <td><input type="checkbox" name="delete_items" value="{{ $cat_list->id }}"></td>
                                <td>{{ $cat_list->name }}</td>
                                <td>{{ $cat_list->created_at }}</td>
                                <td>
                                    <a href="{{ route('office_category.edit', $cat_list->id) }}" class="btn btn-primary btn-xs" style="margin-right: 5px">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    <a style="display:inline-block" onclick="return confirm('Are you sure you want to delete this Category?')">
                                        <form method="POST" action="{{ route('office_category.destroy', $cat_list->id) }}" accept-charset="UTF-8">
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
                    {{ Form::open(['url'=>route('office_category.update', $data->id), 'class'=>'form-horizontal', 'id'=>'category_add','method'=>'patch']) }}
                    @else
                    <form action="{{ route('office_category.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Name</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ @$data->name }}" name="name" id="name" placeholder=" Enter the Category Name">
                                @if($errors->has('name'))
                                <span class='validation-errors text-danger'>{{ $errors->first('name') }}</span>
                            @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-8">
                                <button type="submit" id="add" class="btn btn-primary m-b-0 m-r-5" name="status" value="active">
                                    {{ (!empty($data)) ? ' Update Category' : ' Add Category' }}
                            </button>
                                <button type="reset" id="discard" class="btn btn-danger m-r-15" name="status" value="inactive">Discard</button>
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
