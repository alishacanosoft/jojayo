@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-sm-12">
            <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
                  <li class="@if($active_tab == 'manage') active @endif"><a href="#manage" data-toggle="tab">All Pages</a></li>
                  <li class="@if($active_tab == 'create') active @endif"><a href="#create" data-toggle="tab">New Page</a></li>
               </ul>
               <div class="tab-content bg-white">
                  <div class="tab-pane @if($active_tab == 'manage') active @endif" id="manage">
                     <div class="table-responsive">
                     <table class="table table-striped datatable_action table-bordered dataTable" role="grid" aria-describedby="basic-col-reorder_info">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Title</th>
                                <th>Excerpt</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="check">
                            @if(!empty($all_pages)) @foreach($all_pages as $key => $page_lists)
                            <tr id="{{ $page_lists->id }}">
                                <input type="hidden" value="{{ $page_lists->id }}">
                                <td><input type="checkbox" name="delete_items" value="{{ $page_lists->id }}"></td>
                                <td>{{ $page_lists->title }}</td>
                                <td>{{ $page_lists->excerpt }}</td>
                                <td>{{ $page_lists->status }}</td>
                                <td>
                                    <a href="{{ route('page.edit', $page_lists->id) }}" class="btn btn-primary btn-xs" style="margin-right: 5px">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    <a onclick="return confirm('Are you sure you want to delete this page?')" style="display:inline-block">
                                        <form method="POST" action="{{ route('page.destroy', $page_lists->id) }}" accept-charset="UTF-8">
                                            <input name="_method" type="hidden" value="DELETE">
                                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                            <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash-o"></i></button>
                                        </form>
                                    </a>
                                </td>
                            </tr>
                            @endforeach @endif
                        </tbody>
                    </table>
                     </div>
                  </div>
                  <div class="tab-pane @if($active_tab == 'create') active @endif" id="create">
                    @if(empty($data))
                     <form action="{{ route('page.store') }}" method="POST" class="form-horizontal">
                    @csrf
                    @else
                    {{ Form::open(['url'=>route('page.update', $data->id), 'class'=>'form-horizontal', 'id'=>'product_update', 'files'=>true,'method'=>'patch']) }}
                    @endif
                    <div class="row">                        
                        <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Name</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ @$data->title }}" name="title" id="name" placeholder="Enter title for the page">
                                @if ($errors->has('title'))
                                <span class="validation-errors text-danger">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Slug</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ @$data->slug }}" name="slug" id="slug" placeholder="Paste the slug for the page">
                                @if ($errors->has('slug'))
                                <span class="validation-errors text-danger">{{ $errors->first('slug') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Excerpt</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <textarea name="excerpt" rows="5" class="form-control">{{ @$data->excerpt }}</textarea>
                                @if ($errors->has('excerpt'))
                                <span class="validation-errors text-danger">{{ $errors->first('excerpt') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Description</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <textarea name="description" class="form-control editor" id="description">{{ @$data->description }}</textarea>
                                @if ($errors->has('description'))
                                <span class="validation-errors text-danger">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Status</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                @if ($errors->has('status'))
                                <span class="validation-errors text-danger">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-8">
                                <button type="submit" id="add" class="btn btn-primary m-b-0 m-r-5">Add Page</button>
                                <button type="reset" id="discard" class="btn btn-danger m-r-15">Discart</button>
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
