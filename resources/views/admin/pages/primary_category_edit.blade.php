@extends('admin.layouts.master')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-custom ">
            <header class="panel-heading">Edit Primary Category</header>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12">
                        <div class="card-block">
                            {{ Form::open(['url'=>route('primary_categories.update', $data->id), 'class'=>'form', 'id'=>'update_category', 'files'=>true,'method'=>'patch']) }}
                                @if(!empty($data))
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                        <label>Name</label>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-12">
                                            <input class="form-control" type="text" value="{{ $data->name }}" name="name" required="" id="name">
                                            <span class="hint">The name is how it appears on your site.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                        <label>Icon</label>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-12">
                                            <input class="form-control" type="text" value="{{ $data->icon }}" name="icon" required="" id="name">
                                            <span class="hint">Icon to be displayed in the Primary menu</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <label></label>
                                        </div>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                    <input type="submit" name="submit" value="Save Changes" class="btn btn-success" id="submit"></div>
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection