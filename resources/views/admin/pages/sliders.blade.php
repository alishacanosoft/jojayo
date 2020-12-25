@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-sm-12">
            <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
                  <li class="@if($active_tab == 'manage') active @endif"><a href="#manage" data-toggle="tab">All Sliders</a></li>
                  <li class="@if($active_tab == 'create') active @endif"><a href="#create" data-toggle="tab">New Slider</a></li>
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
                                <th>Url</th>
                                <th>View Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="check">
                            @if(!empty($all_slider)) 
                            @foreach($all_slider as $key => $slider_list)
                            <tr id="{{ $slider_list->id }}">
                                <input type="hidden" value="{{ $slider_list->id }}">
                                <td><input type="checkbox" name="delete_items" value="{{ $slider_list->id }}"></td>
                                <td>{{ $slider_list->name }}</td>
                                <td>{{ $slider_list->url }}</td>
                                <td>{{ $slider_list->image }}</td>
                                <td>{{ $slider_list->status }}</td>
                                <td>
                                    <a href="{{ route('sliders.edit', $slider_list->id) }}" class="btn btn-primary btn-xs" style="margin-right: 5px">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    <a style="display:inline-block" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <form method="POST" action="{{ route('sliders.destroy', $slider_list->id) }}" accept-charset="UTF-8">
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
                    {{ Form::open(['url'=>route('sliders.update', $data->id), 'class'=>'form-horizontal', 'id'=>'slider_add', 'files'=>true,'method'=>'patch']) }}
                    @else
                    <form action="{{ route('sliders.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @endif                    
                    <div class="row">                        
                        <div class="col-sm-12"> 
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Name</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ @$data->name }}" name="name" id="name" placeholder="Paste the redirect link">
                            </div>
                        </div>                       
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Link</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ @$data->url }}" name="url" id="url" placeholder="Paste the redirect link">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Slider Location</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <select name="location" id="location" class="form-control">
                                    <option selected disabled>--Select slider location--</option>
                                    <option value="main" @if(@$data->location == 'main') selected @endif>Main page</option>
                                    <option value="shop" @if(@$data->location == 'shop') selected @endif>Shop page</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group medium-image">
                            <label class="col-sm-2 control-label"><strong>Image</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <div class="mt-0">
                                    <input type="file" id="files" name="image" style="opacity:1">
                                </div>
                                @if(!empty($data->image))
                                <span class="pip">
                                    <img class="imageThumb" src="{{ asset('/uploads/slider/Thumb-'.$data->image) }}">                      
                                </span>
                                @endif
                            </div>
                            @if ($errors->has('image'))
                            <div class="col-lg-12">
                                <span class="validation-errors text-danger">{{ $errors->first('image') }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-8">
                                <button type="submit" id="add" class="btn btn-primary m-b-0 m-r-5" name="status" value="active">Add Slider</button>
                                <button type="reset" id="discard" class="btn btn-danger m-r-15" name="status" value="inactive">Discart</button>
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
