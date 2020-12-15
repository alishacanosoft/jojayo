@extends('admin.layouts.master')
@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-header">
                        <div class="page-header-title">
                            <h4>Edit Product Category</h4>
                        </div>
                    </div>
                    <br>
                    <div class="page-body">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <div>
                                    <div class="card-block">
                                            {{ Form::open(['url'=>route('product_categories.update', $data->id), 'class'=>'form', 'id'=>'update_category', 'files'=>true,'method'=>'patch']) }}
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
                                                            <label>Slug</label>
                                                        </div>
                                                        <div class="col-lg-9 col-md-9 col-sm-12">
                                                            <input class="form-control" type="text" value="{{ $data->slug }}" name="slug" required="" id="slug">
                                                            <span class="hint">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                                            <label>Secondary Category</label>
                                                        </div>
                                                        <div class="col-lg-9 col-md-9 col-sm-12">
                                                            <select class="form-control" name="category_id" id="parentcategories">
                                                                <option value="0">None</option>
                                                                @if(!empty($parent))
                                                                    @foreach($parent as $parentList)
                                                                        <option value="{{ $parentList->id }}" @if($data->secondary_category_id == $parentList->id) selected @endif>{{ $parentList->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <span class="hint">Categories, unlike tags, can have a hierarchy. You might have a Jazz category, and under that have children categories for Bebop and Big Band. Totally optional.</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="submit" name="submit" value="Save Changes" class="btn btn-success" id="submit">
                                            @endif
                                        </form>
                                    </div>
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
        $("#name").keyup(function (){
            let Slug = $('#name').val();
            document.getElementById("slug").value = convertToSlug(Slug);
        });
    </script>
@endsection