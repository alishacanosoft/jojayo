@extends('admin.layouts.master')
@section('styles')
<style>
    img.imageThumb {
        max-width: 100%;
    }
</style>
@endsection
@section('content')
<div class="row">
@if(!empty($data))
{{ Form::open(['url'=>route('blogs.update', $data->id), 'class'=>'form', 'id'=>'post_add', 'files'=>true,'method'=>'patch']) }}
@else
<form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
    @endif
    @csrf
   <div class="col-sm-9 wrap-fpanel">
      <div class="panel panel-custom" data-collapsed="0">
         <div class="panel-heading">
            <div class="panel-title">
               <strong>Add Post</strong>
            </div>
         </div>
         <div class="panel-body">
            <div class="page-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" value="{{ @$data->title }}" name="title" id="name" placeholder="Enter title for the post">
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <textarea name="excerpt" id="" rows="5" class="form-control" placeholder="Enter summary of the post">{{ @$data->excerpt }}</textarea>
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <textarea name="description" id="" rows="10" class="form-control editor" placeholder="Enter post content">{{ @$data->description }}</textarea>
                                <span class="messages"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="col-sm-3 wrap-fpanel">
        <div class="panel panel-custom" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                <strong>Post Details</strong>
                </div>
            </div>
            <div class="panel-body">
            <div class="form-group row">
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ @$data->slug }}" placeholder="url of the post">
                        <span class="messages popover-valid"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <input type="hidden" name="feature" value="0">
                        <label style="padding-right: 10px">Set as featured?</label> <br>
                        <input type="checkbox"  @if(@$data->feature == 1) checked @endif  name="feature" id="set_featured" value="1">
                        <span style="margin-left: 2px">Yes</span> <br><br>
                        <span class="messages popover-valid"></span>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-sm-12">
                        <select name="category_id" id="" class="form-control">
                            <option value="">Select Category</option>
                            @if(!empty($categories))
                                @foreach($categories as $categoryList)
                                    <option value="{{ $categoryList->id }}" @if($categoryList->id == @$data->category_id) selected @endif>{{ $categoryList->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                
                <div class="form-group small-image">
                    <div class="file-upload no-dash">
                        <input type="file" class="files" id="files" name="image" style="opacity:1">
                    </div>
                    @if(!empty($data->image))
                    <span class="pip">
                        <img class="imageThumb" src="{{ asset('/uploads/blogs/Thumb-'.$data->image) }}">                      
                    </span>
                    @endif
                    @if ($errors->has('image'))
                    <div class="col-lg-12">
                        <span class="validation-errors text-danger">{{ $errors->first('image') }}</span>
                    </div>
                    @endif
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary m-b-0 " name="status" value="draft">Draft</button>
                        <button type="submit" class="btn btn-danger m-b-0  ml-2" name="status" value="publish">Publish</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
@endsection
@section('scripts')
<script>
    $("#name").keyup(function (){
        let Slug = $('#name').val();
        document.getElementById("slug").value = convertToSlug(Slug);
    });
</script>
@endsection