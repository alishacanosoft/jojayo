@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-custom ">
                <header class="panel-heading">Add Primary Category</header>
                <div class="panel-body">
                <div class="form-group">
                    <label>Name</label>
                    <input class="form-control" type="text" name="name" required="" id="name">
                    <span class="hint">The name is how it appears on your site.</span>
                </div>
                <div class="form-group">
                    <label>Icon</label>
                    <input class="form-control" type="text" name="icon" required="" id="icon">
                    <span class="hint">Icon to be displayed in the Primary menu</span>
                </div>
                <input type="submit" name="submit" value="Add New Category" class="btn btn-primary" id="submit">
                </div>
            </div>
        </div>
                                    
        <div class="col-sm-8">
            <div class="panel panel-custom ">
                <header class="panel-heading">All Primary Categories</header>
                <div class="panel-body">
                <table class="table table-striped table-bordered nowrap datatable_action" role="grid" aria-describedby="basic-col-reorder_info">
                    <thead class="inner">
                    <tr>
                        <th>Name</th>
                        <th>Action </th>
                    </tr>
                    </thead>
                    <tbody id="check">
                    @if(!empty($allCategories))
                        @foreach($allCategories as $key => $categoryList)
                            <tr id="{{ $categoryList->id }}">
                                <input type="hidden" value="{{ $categoryList->id }}">
                                <td>{{ $categoryList->name }}</td>
                                <td><a href="{{ route('primary_categories.edit', $categoryList->id) }}"><button type="button" class="btn btn-primary btn-xs waves-effect waves-light" style="float: none;"><i class="fa fa-pencil-square-o"></i></button></a>  <button type="button" class="btn-xs btn btn-danger waves-effect waves-light table-delete" style="float: none;margin: 5px;" data-target="#sign-in-modal"><i class="fa fa-trash-o"></i></button> </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@include('admin.scripts.primary_category')
@endsection
