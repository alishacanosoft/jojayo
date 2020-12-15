@extends('admin.layouts.master')
@section('content')
<div class="row">
  <div class="col-sm-12">
     <div class="panel panel-custom ">
        <header class="panel-heading">Edit Brand</header>
        <div class="page-body">
           <div class="row">
              <div class="col-lg-8 col-md-8 col-sm-12">
                 {{ Form::open(['url'=>route('brands.update', $data->id), 'class'=>'form-horizontal', 'id'=>'update_category', 'files'=>true,'method'=>'patch']) }}
                 @if(!empty($data))
                 <div class="form-group">
                    <label class="col-lg-3 control-label"><strong>Name</strong> <span class="text-danger">*</span></label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                       <input class="form-control" type="text" value="{{ $data->name }}" name="name" required="" id="name">
                       @if($errors->has('name'))
                        <span class='validation-errors text-danger'>{{ $errors->first('name') }}</span>
                        @endif
                       <span class="hint">The name is how it appears on your site.</span>
                    </div>
                 </div>
                 <div class="form-group">
                    <label class="col-lg-3 control-label"><strong>Slug</strong> <span class="text-danger">*</span></label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                       <input class="form-control" type="text" value="{{ $data->slug }}" name="slug" required="" id="slug">
                        @if($errors->has('slug'))
                        <span class='validation-errors text-danger'>{{ $errors->first('slug') }}</span>
                        @endif
                       <span class="hint">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</span>
                    </div>
                 </div>
                 <div class="form-group">
                     <label class="col-lg-3 control-label"><strong>Brand Image</strong> <span class="text-danger">*</span></label>
                     <div class="col-lg-9 col-md-9 col-sm-12">
                        <div class="file-upload no-dash">
                              <input type="file" id="files" name="logo" style="opacity:1">
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
                 </div>
                 <div class="form-group">
                    <label class="col-lg-3 control-label"></label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                       <input type="submit" name="submit" value="Save Changes" class="btn btn-success" id="submit">
                    </div>
                 </div>
                 @endif
                 </form>
              </div>
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
@endsection