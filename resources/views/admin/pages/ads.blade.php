@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-sm-12">
            <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
                  <li class="@if($active_tab == 'manage') active @endif"><a href="#manage" data-toggle="tab">All Ads</a></li>
                  <li class="@if($active_tab == 'create') active @endif"><a href="#create" data-toggle="tab">New Ad</a></li>
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
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="check">
                            @if(!empty($all_ads)) @foreach($all_ads as $key => $ad_lists)
                            <tr id="{{ $ad_lists->id }}">
                                <input type="hidden" value="{{ $ad_lists->id }}">
                                <td><input type="checkbox" name="delete_items" value="{{ $ad_lists->id }}"></td>
                                <td>{{ $ad_lists->title }}</td>
                                <td>{{ $ad_lists->url }}</td>
                                <td>{{ $ad_lists->start_date }}</td>
                                <td>{{ $ad_lists->end_date }}</td>
                                <td>{{ $ad_lists->status }}</td>
                                <td>
                                    <a href="{{ route('ads.edit', $ad_lists->id) }}" class="btn btn-primary btn-xs" style="margin-right: 5px">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    <a style="display:inline-block" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <form method="POST" action="{{ route('ads.destroy', $ad_lists->id) }}" accept-charset="UTF-8">
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
                    @if(!empty($data))
                    {{ Form::open(['url'=>route('ads.update', $data->id), 'class'=>'form-horizontal', 'id'=>'slider_add', 'files'=>true,'method'=>'patch']) }}
                    @else
                    <form action="{{ route('ads.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">                    
                    @endif
                    @csrf
                    <div class="row">                        
                        <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Name</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ @$data->title }}" name="title" id="name" placeholder="Enter title of the ad">
                                @if($errors->has('title'))
                                    <span class='validation-errors text-danger'>{{ $errors->first('title') }}</span>
                                @endif                       
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Link</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ @$data->url }}" name="url" id="link" placeholder="Paste the redirect link">
                                @if($errors->has('url'))
                                    <span class='validation-errors text-danger'>{{ $errors->first('url') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Start Date</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" value="{{ @$data->start_date }}" name="start_date" id="start_date" placeholder="Enter ads starting date">
                                @if($errors->has('start_date'))
                                    <span class='validation-errors text-danger'>{{ $errors->first('start_date') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>End Date</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" value="{{ @$data->end_date }}" name="end_date" id="end_date" placeholder="Enter ads ending date">
                                @if($errors->has('end_date'))
                                    <span class='validation-errors text-danger'>{{ $errors->first('end_date') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Ad location</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="place">
                                    <option value="slider-first">Slider first</option>
                                    <option value="slider-second">Slider second</option>
                                    <option value="women-section">Women section</option>
                                    <option value="men-section">Men section</option>
                                    <option value="kid-section">Kid section</option>
                                </select>
                                @if($errors->has('place'))
                                    <span class='validation-errors text-danger'>{{ $errors->first('place') }}</span>
                                @endif
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
                                    <img class="imageThumb" src="{{ asset('/uploads/ads/Thumb-'.$data->image) }}">                      
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
                                <button type="submit" id="add" class="btn btn-primary m-b-0 m-r-5">Add Ads</button>
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
@section('scripts')
<script>
    $('#add_row').hide();
    $('#new').on('click', function() {
        $('#add_row').slideDown(1000);
        $('#new').hide("slide", {
            direction: "right"
        }, 1000);
    });
    $('.edit').on('click', function() {
        let id = $(this).attr("value");
        var editurl = '{{ route("ads.edit", ":data") }}';
        var link = '{{ route("ads.update", ":data") }}';
        editurl = editurl.replace(':data', id);
        link = link.replace(':data', id);
        $.ajax({
            url: editurl,
            dataType: 'json',
            data: {
                id: id
            },
            success: function(response) {
                $('#name').val(response.title);
                $('#link').val(response.url);
                $('#start_date').val(response.start_date);
                $('#end_date').val(response.end_date);
                $('#thumbnail').val(response.image);
                $('#holder').attr('src', response.image);
                $('form').attr('action', link);
                $('#add').text('Update Ads');
                $('input:hidden').after('<input name="_method" type="hidden" value="PATCH">');
                $('#add_row').slideDown(1000);
                $('#new').hide("slide", {
                    direction: "right"
                }, 1000);
            },
        });
    });
    $('#discard').on('click', function() {
        $('#add_row').slideUp(1000);
        $('#new').show("slide", {
            direction: "right"
        }, 1000);
    })
</script>
@include('admin.scripts.post_category') @endsection