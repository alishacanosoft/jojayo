@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-custom ">
                <header class="panel-heading">Add Brand</header>
                <div class="panel-body">
                <form id="data" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" type="text" name="name" required="" id="name">
                        @if($errors->has('name'))
                        <span class='validation-errors text-danger'>{{ $errors->first('name') }}</span>
                        @endif
                        <span class="hint">The name is how it appears on your site.</span>
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input class="form-control" type="text" name="slug" required="" id="slug">
                        @if($errors->has('slug'))
                        <span class='validation-errors text-danger'>{{ $errors->first('slug') }}</span>
                        @endif
                        <span class="hint">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</span>
                    </div>
                    <div class="form-group small-image">
                        <div class="file-upload no-dash">
                            <input type="file" class="files" id="files" name="logo" style="opacity:1">
                        </div>
                        @if(!empty($data->logo))
                        <span class="pip">
                            <img class="imageThumb" src="{{ asset('/uploads/brands/Thumb-'.$data->logo) }}">                      
                        </span>
                        @endif
                        @if ($errors->has('logo'))
                        <div class="col-lg-12">
                            <span class="validation-errors text-danger">{{ $errors->first('logo') }}</span>
                        </div>
                        @endif
                    </div>
                    <input type="submit" name="submit" value="Add New Brand" class="btn btn-primary" id="submit">
                </form>
                </div>
            </div>
        </div>
                                    
        <div class="col-sm-8">
            <div class="panel panel-custom ">
                <header class="panel-heading">All Brands</header>
                <div class="panel-body">
                <table class="table table-striped table-bordered nowrap datatable_action">
                    <thead class="inner">
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Logo</th>
                        <th>Action </th>
                    </tr>
                    </thead>
                    <tbody id="check">
                    @if(!empty($allBrands))
                        @foreach($allBrands as $key => $brandList)
                            <tr id="{{ $brandList->id }}">
                                <input type="hidden" value="{{ $brandList->id }}">
                                <td>{{ $brandList->name }}</td>
                                <td>{{ $brandList->slug }}</td>
                                <td><a href="{{ asset('uploads/brands/Thumb-'.$brandList->logo) }}" class="iframe-btn">View Logo</a></td>
                                <td><a href="{{ route('editBrand', $brandList->slug) }}"><button type="button" class="btn btn-primary btn-xs waves-effect waves-light" style="float: none;"><i class="fa fa-pencil-square-o"></i></button></a>  <button type="button" class="btn-xs btn btn-danger waves-effect waves-light table-delete" style="float: none;margin: 5px;" data-target="#sign-in-modal"><i class="fa fa-trash-o"></i></button> </td>
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
@include('admin.scripts.brands')
@endsection
