@extends('admin.layouts.master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-custom ">
                    <header class="panel-heading">Edit Secondary Category</header>
                    <div class="panel-body">
                        {{ Form::open(['url'=>route('secondary_categories.update', $data->id), 'class'=>'form-horizontal', 'id'=>'update_category', 'files'=>true,'method'=>'patch']) }}
                        @if(!empty($data))
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label"><strong>Name</strong> <span class="text-danger">*</span></label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <input class="form-control" type="text" value="{{ $data->name }}" name="name" required="" id="name">
                                        <span class="hint">The name is how it appears on your site.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label"><strong>Slug</strong> <span class="text-danger">*</span></label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <input class="form-control" type="text" value="{{ $data->slug }}" name="slug" required="" id="slug">
                                        <span class="hint">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label"><strong>Primary Category</strong> <span class="text-danger">*</span></label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <select class="form-control" name="primary_category_id" id="parentcategories">
                                            <option value="0">None</option>
                                            @if(!empty($parent))
                                                @foreach($parent as $parentList)
                                                    <option value="{{ $parentList->id }}" @if($data->primary_category_id == $parentList->id) selected @endif>{{ $parentList->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="hint">Categories, unlike tags, can have a hierarchy. You might have a Jazz category, and under that have children categories for Bebop and Big Band. Totally optional.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label"></label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                    <input type="submit" name="submit" value="Save Changes" class="btn btn-success" id="submit">
                                    </div>
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