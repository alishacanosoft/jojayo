@extends('admin.layouts.master')
@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-header">
                        <div class="page-header-title">
                            <h4>Add City</h4>
                            <span>Cities where the products are delivered to. </span>
                        </div>
                    </div>
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
@endsection
