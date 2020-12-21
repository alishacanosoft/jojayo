@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-sm-12">
            <div class="panel panel-custom ">
                <header class="panel-heading">All Posts</header>
                <div class="panel-body">
                <table class="datatable_action display">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($allPosts)) @foreach($allPosts as $postsLists)
                        <tr id="{{ $postsLists->id }}">
                            <td><input type="checkbox" name="delete_items" value="{{ $postsLists->id }}"></td>
                            <td>{{ $postsLists->title }}</td>
                            <td>{{ $postsLists->category['name'] }}</td>
                            <td>{{ $postsLists->status }}</td>
                            <td><a href="{{ asset('/uploads/blogs/Thumb-'.$postsLists->image) }}" target="_blank">View image</a></td>
                            <td>
                                <a href="{{ route('blogs.edit', $postsLists->id) }}" class="btn btn-primary btn-xs" style="margin-right: 5px">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                                <a onclick="return confirm('Are you sure you want to delete this post?')" style="display:inline-block">
                                    <form method="POST" action="{{ route('blogs.destroy', $postsLists->id) }}" accept-charset="UTF-8">
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
        </div>
    </div>
</div>
@endsection