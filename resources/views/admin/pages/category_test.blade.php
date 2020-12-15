@extends('admin.layouts.master') @section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="page-header-title">
                        <h4>{{ @$data !== null ? 'Update' : 'Add' }} category</h4>
                    </div>
                </div>
                @if(!empty(@$data)) {{ Form::open(['url'=>route('product_categories.update', @$data->id), 'class'=>'form', 'id'=>'user_add', 'files'=>true,'method'=>'patch']) }}
                <input name="_method" type="hidden" value="PATCH"> @else
                <form action="{{ route('product_categories.store') }}" method="POST">
                    @endif @csrf
                    <div class="page-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{--{{ @$data !== null ? 'Update' : 'Add' }} user--}}</h5>
                                        <div class="card-header-right">
                                            <i class="icofont icofont-rounded-down"></i>
                                            <i class="icofont icofont-refresh"></i>
                                            <i class="icofont icofont-close-circled"></i>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label for="">Name</label>
                                            </div>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" value="{{ @$data->name }}" name="name" id="name" placeholder="Enter title for the user">
                                                <span class="messages"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label for="">Slug</label>
                                            </div>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" value="{{ @$data->slug }}" name="slug" id="slug" placeholder="Category slug">
                                                <span class="messages"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label for="">Secondary Category</label>
                                            </div>
                                            <div class="col-sm-10">
                                                <select name="secondary_category_id" id="role" class="form-control">
                                                    @if(!empty($all_categories))
                                                    <option selected disabled>--Select parent category--</option>
                                                    @foreach($all_categories as $category_list)
                                                    <option value="{{ $category_list->id }}" {{ $category_list->id == @$data->secondary_category_id ? 'selected' : '' }}>{{ $category_list->name }}</option>
                                                    @endforeach @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label for="">Has Warranty ?</label>
                                            </div>
                                            <div class="col-sm-10">
                                                <input type="radio" value="1" name="warranty" {{ @$data->warranty == 1 ? 'checked' : '' }}> Yes
                                                <input type="radio" value="0" name="warranty" {{ @$data->warranty == 0 ? 'checked' : '' }}> No
                                                <span class="messages"></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label for="">Available sizes</label>
                                            </div>
                                            <div class="col-sm-10">
                                            @php @$list = implode(',', @$size_list); @endphp
                                                <input type="text" class="form-control" value="{{ @$list }}" name="size" id="size" placeholder="Enter sizes to be displayed under this category separated by comma (,)">
                                                <span class="messages"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2"></label>
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-primary m-b-0 pull-right ml-2">{{ @$data !== null ? 'Update' : 'Add' }} Category</button>
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
@endsection @section('scripts')
<script>
    $("#name").keyup(function() {
        let Slug = $('#name').val();
        document.getElementById("slug").value = convertToSlug(Slug);
    });
</script>
@endsection
