@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-sm-12">
            <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
                  <li class="@if($active_tab == 'manage') active @endif"><a href="#manage" data-toggle="tab">All Colors</a></li>
                  <li class="@if($active_tab == 'create') active @endif"><a href="#create" data-toggle="tab">New Color</a></li>
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
                                <th>Color Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="check">
                            @if(!empty($all_color)) @foreach($all_color as $key => $color_lists)
                            <tr id="{{ $color_lists->id }}">
                                <input type="hidden" value="{{ $color_lists->id }}">
                                <td><input type="checkbox" name="delete_items" value="{{ $color_lists->id }}"></td>
                                <td>{{ $color_lists->name }}</td>
                                <td>{{ $color_lists->code }}</td>
                                <td>
                                    <a href="{{ route('colors.edit', $color_lists->id) }}" class="btn btn-primary btn-xs pull-left" style="margin-right: 5px">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    <a class="pull-left" onclick="return confirm('Are you sure you want to delete this color?')">
                                        <form method="POST" action="{{ route('colors.destroy', $color_lists->id) }}" accept-charset="UTF-8">
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
                        {{ Form::open(['url'=>route('colors.update', $data->id), 'class'=>'form-horizontal', 'id'=>'color_add', 'files'=>true,'method'=>'patch']) }}
                    @else
                    <form action="{{ route('colors.store') }}" method="POST" enctype="multipart/form-data" class='form-horizontal'>
                        @endif
                        @csrf
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Name</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ @$data->name }}" name="name" id="name" placeholder="Enter title of the code">
                                @if($errors->has('name'))
                                    <span class='validation-errors text-danger'>{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Color Code</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="color" style="height: 100px; width:100px" class="form-control" value="{{ @$data->code }}" name="code" id="code" placeholder="Paste the color code">
                                @if($errors->has('code'))
                                    <span class='validation-errors text-danger'>{{ $errors->first('code') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-8">
                                <button type="submit" id="add" class="btn btn-primary m-b-0 m-r-5">Add Color</button>
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
