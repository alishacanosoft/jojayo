@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-custom ">
                <header class="panel-heading">Add Category</header>
                <div class="panel-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" type="text" name="name" required="" id="name">
                        <span class="hint">The name is how it appears on your site.</span>
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input class="form-control" type="text" name="slug" required="" id="slug">
                        <span class="hint">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</span>
                    </div>
                    <div class="form-group">
                        <label>Parent Category</label>
                        <select class="form-control" name="parentcategories" id="parentcategories">
                        </select>
                        <span class="hint">Categories, unlike tags, can have a hierarchy. You might have a Jazz category, and under that have children categories for Bebop and Big Band. Totally optional.</span>
                    </div>
                    <input type="submit" name="submit" value="Add New Category" class="btn btn-primary" id="submit" style="margin-bottom: 20px">
                </div>
            </div>
        </div>
                                    
        <div class="col-sm-8">
            <div class="panel panel-custom ">
                <header class="panel-heading">All Categories</header>
                <div class="panel-body">
                <table class="datatable_action display">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Parent</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="check">
                        @if($allCategories)
                            @foreach($allCategories as $key => $categoryList)
                                <tr id="{{ $categoryList->id }}">
                                    <input type="hidden" value="{{ $categoryList->id }}">
                                    <td><input type="checkbox" name="delete_items" value="{{ $categoryList->id }}"></td>
                                    <td>{{ $categoryList->name }}</td>
                                    <td>{{ $categoryList->slug }}</td>
                                    <td>  @if(!empty($categoryList->parent)) {{ $categoryList->categoryName['name']}} @else - @endif</td>
                                    <td><a href="{{ route('editPostCategory', $categoryList->slug) }}"><button type="button" class="btn btn-primary btn-xs" style="float: none;"><i class="fa fa-pencil-square-o"></i></button></a><button type="button" class="btn-xs btn btn-danger table-delete" style="float: none;margin: 5px;" data-target="#sign-in-modal"><i class="fa fa-trash-o"></i></button></td>
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
    <script>
        $("#name").keyup(function (){
            let Slug = $('#name').val();
            document.getElementById("slug").value = convertToSlug(Slug);
        });
    </script>
@include('admin.scripts.post_category')
@endsection
