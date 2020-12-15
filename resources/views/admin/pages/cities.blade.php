@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-sm-12">
            <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
                  <li class="@if($active_tab == 'manage') active @endif"><a href="#manage" data-toggle="tab">All Cities</a></li>
                  <li class="@if($active_tab == 'create') active @endif"><a href="#create" data-toggle="tab">New City</a></li>
                  <input type="hidden" id="base" value="{{ route('ajax.categories') }}">
               </ul>
               <div class="tab-content bg-white">
                  <div class="tab-pane @if($active_tab == 'manage') active @endif" id="manage">
                     <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap datatable_action" role="grid" aria-describedby="basic-col-reorder_info">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Region</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($city_lists)) @foreach($city_lists as $all_cities)
                                <tr>
                                    <td>{{ $all_cities->name }}</td>
                                    <td>{{ $all_cities->Region->name }}</td>
                                    <td>
                                        <a href="{{ route('cities.edit', $all_cities->id) }}" class="btn btn-primary btn-xs pull-left" style="margin-right: 5px">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        <a class="pull-left" onclick="return confirm('Are you sure you want to delete this user?')">
                                            <form method="POST" action="{{ route('cities.destroy', $all_cities->id) }}" accept-charset="UTF-8">
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
                        {{ Form::open(['url'=>route('cities.update', $data->id), 'class'=>'form', 'id'=>'city_add', 'files'=>true,'method'=>'patch']) }}
                    @else
                        <form action="{{ route('cities.store') }}" method="POST">
                            @endif
                            @csrf
                            <div class="page-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Add City</h5>
                                                <div class="card-header-right">
                                                    <i class="icofont icofont-rounded-down"></i>
                                                    <i class="icofont icofont-refresh"></i>
                                                    <i class="icofont icofont-close-circled"></i>
                                                </div>
                                            </div>
                                            <div class="card-block">
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control" value="{{ @$data->name }}" name="name" id="name" placeholder="Name of the city">
                                                        <span class="messages"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <select class="form-control" name="region_id">
                                                          <option selected disabled>--Select Region--</option>
                                                          @if(!empty($all_regions))
                                                              @foreach($all_regions as $region_list)
                                                                  <option value="{{ $region_list->id }}" @if(@$data->region_id == $region_list->id) selected @endif>{{ $region_list->name }}</option>
                                                              @endforeach
                                                          @endif
                                                        </select>
                                                        <span class="messages"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                      <button type="submit" class="btn btn-danger m-b-0 pull-right ml-2">Save</button>
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