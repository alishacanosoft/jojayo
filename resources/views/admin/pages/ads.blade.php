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
                                    <button type="button" class="btn btn-primary btn-xs edit" value="{{ $ad_lists->id }}" style="float: none;"><i class="fa fa-pencil-square-o"></i></button>
                                    <button type="button" class="btn-xs btn btn-danger table-delete" style="float: none;margin: 5px;" data-target="#sign-in-modal"><i class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                            @endforeach @endif
                        </tbody>
                    </table>
                     </div>
                  </div>
                  <div class="tab-pane @if($active_tab == 'create') active @endif" id="create">
                  <form action="{{ route('ads.store') }}" method="POST" class="form-horizontal">
                    @csrf
                    <div class="row">                        
                        <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Name</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ @$data->title }}" name="title" id="name" placeholder="Enter title of the ad">                            
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Link</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ @$data->link }}" name="url" id="link" placeholder="Paste the redirect link">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Start Date</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" value="{{ @$data->start_date }}" name="start_date" id="start_date" placeholder="Enter ads starting date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>End Date</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" value="{{ @$data->end_date }}" name="end_date" id="end_date" placeholder="Enter ads ending date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Ad location</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="place">
                                    <option>Option A</option>
                                    <option>Option B</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Ad banner</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-3">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 210px;">
                                    @php
                                    $image = "http://placehold.it/350x260";
                                    if(!empty($data->image)){
                                        $image = $data->image;
                                    }
                                    @endphp
                                        <input type="hidden" id="thumbnail">
                                        <img src="{{ $image }}" id="thumbnailholder" alt="Please Connect Your Internet">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="width: 210px;"></div>
                                    <div>
                                    <span class="btn btn-default btn-file">
                                        <span class="fileinput-new">
                                            <a href="{{ url('/vendor/filemanager/dialog.php?type=4&field_id=thumbnail&descending=1&sort_by=date&lang=undefined&akey=061e0de5b8d667cbb7548b551420eb821075e7a6') }}" class="btn iframe-btn btn-primary" type="button">
                                                <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                            <!-- <input type="file" name="image" value="upload" data-buttontext="Choose File" id="myImg" data-parsley-id="26"> -->
                                            <input type="hidden" name="image" id="thumbnailthumbnail" value="{{ @$data->image }}">
                                            <span class="fileinput-exists">Change</span>
                                        </span>
                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </span>
                                    </div>
                                    <div id="valid_msg" style="color: #e11221"></div>
                                </div>
                            </div>
                            @if ($errors->has('image'))
                            <div class="col-lg-3">
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