@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-sm-12">
            <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
                  <li class="@if($active_tab == 'manage') active @endif"><a href="#manage" data-toggle="tab">All Areas</a></li>
                  <li class="@if($active_tab == 'create') active @endif"><a href="#create" data-toggle="tab">New Area</a></li>
                  <input type="hidden" id="base" value="{{ route('ajax.categories') }}">
               </ul>
               <div class="tab-content bg-white">
                  <div class="tab-pane @if($active_tab == 'manage') active @endif" id="manage">
                     <div class="table-responsive">
                     <table class="table table-striped table-bordered nowrap datatable_action" role="grid" aria-describedby="basic-col-reorder_info">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>City name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($area_lists)) @foreach($area_lists as $all_areas)
                            <tr>
                                <td>{{ $all_areas->name }}</td>
                                <td>{{ $all_areas->City->name }}</td>
                                <td>
                                    <a href="{{ route('areas.edit', $all_areas->id) }}" class="btn btn-primary btn-xs pull-left" style="margin-right: 5px">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    <a class="pull-left" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <form method="POST" action="{{ route('areas.destroy', $all_areas->id) }}" accept-charset="UTF-8">
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
                        {{ Form::open(['url'=>route('areas.update', $data->id), 'class'=>'form', 'id'=>'area_add', 'files'=>true,'method'=>'patch']) }}
                    @else
                        <form action="{{ route('areas.store') }}" method="POST">
                            @endif
                            @csrf
                            <div class="page-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Add Area</h5>
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
                                                        @if($errors->has('name'))
                                                        <span class='validation-errors text-danger'>{{ $errors->first('name') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <select class="form-control" name="city_id">
                                                          <option selected disabled>--Select Region--</option>
                                                          @if(!empty($all_cities))
                                                              @foreach($all_cities as $city_list)
                                                                  <option value="{{ $city_list->id }}" @if(@$data->city_id == $city_list->id) selected @endif>{{ $city_list->name }}</option>
                                                              @endforeach
                                                          @endif
                                                        </select>
                                                        @if($errors->has('city_id'))
                                                        <span class='validation-errors text-danger'>{{ $errors->first('city_id') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control" value="{{ @$data->delivery_charge }}" name="delivery_charge" id="delivery_charge" placeholder="Delivery charge">
                                                        @if($errors->has('delivery_charge'))
                                                        <span class='validation-errors text-danger'>{{ $errors->first('delivery_charge') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control" value="{{ @$data->express_charge }}" name="express_charge" id="express_charge" placeholder="Express delivery charge">
                                                        @if($errors->has('express_charge'))
                                                        <span class='validation-errors text-danger'>{{ $errors->first('express_charge') }}</span>
                                                        @endif
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