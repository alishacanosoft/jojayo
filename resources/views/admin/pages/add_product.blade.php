@extends('admin.layouts.master')
@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-header">
                        <div class="row align-items-end">
                            <div class="col-lg-8">
                                <div class="page-header-title">
                                    <div class="d-inline">
                                        <h4>{{ !empty($data) ? 'Update' : 'Add' }} Product</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">

                            </div>
                        </div>
                    </div>

                    <div class="page-body">
                        @if(empty($data))
                        <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        @else
                        {{ Form::open(['url'=>route('products.update', $data->id), 'class'=>'form', 'id'=>'product_update', 'files'=>true,'method'=>'patch']) }}
                        @endif
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>What you're selling</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <div class="col-md-4 col-lg-2">
                                                            <label for="name" class="block">Product Name *</label>
                                                        </div>
                                                        <div class="col-md-8 col-lg-10">
                                                            <input name="name" type="text" class="required form-control" id="name" value="{{ @$data->name }}">
                                                            @if($errors->has('name'))
                                                                <span class='validation-errors text-danger'>{{ $errors->first('name') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-4 col-lg-2">
                                                            <label for="slug" class="block">Product Slug *</label>
                                                        </div>
                                                        <div class="col-md-8 col-lg-10">
                                                            <input name="slug" type="text" class="required form-control" id="slug" value="{{ @$data->slug }}">
                                                            @if($errors->has('slug'))
                                                                <span class='validation-errors text-danger'>{{ $errors->first('slug') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-4 col-lg-2">
                                                            <label for="slug" class="block">Product SKU *</label>
                                                        </div>
                                                        <div class="col-md-8 col-lg-10">
                                                            <input name="sku" type="text" class="required form-control" id="sku" value="{{ @$data->sku }}">
                                                            @if($errors->has('sku'))
                                                                <span class='validation-errors text-danger'>{{ $errors->first('sku') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-4 col-lg-2">
                                                            <label for="category-2" class="block">Category *</label>
                                                        </div>
                                                        <div class="col-md-8 col-lg-10">
                                                            <select name="category_id" id="category_id" class="requires form-control">
                                                                <option selected disabled>--Product Category--</option>
                                                                @if(!empty($category))
                                                                    @foreach($category as $category_list)
                                                                        <option value="{{ $category_list->id }}" {{ @$data->category_id == $category_list->id ? 'selected' : '' }}>{{ $category_list->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            @if($errors->has('category_id'))
                                                                <span class='validation-errors text-danger'>At least one category should be selected to add a product.</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-4 col-lg-2">
                                                            <label for="brand-2" class="block">Brand *</label>
                                                        </div>
                                                        <div class="col-md-8 col-lg-10">
                                                            <select name="brand_id" id="brand_id" class="requires form-control">
                                                                <option selected disabled>--Product Brand--</option>
                                                                @if(!empty($brands))
                                                                    @foreach($brands as $brand_list)
                                                                        <option value="{{ $brand_list->id }}" {{ @$data->brand_id == $brand_list->id ? 'selected' : '' }}>{{ $brand_list->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-md-4 col-lg-2">
                                                            <label for="brand-2" class="block">Vendor *</label>
                                                        </div>
                                                        <div class="col-md-8 col-lg-10">
                                                            <select name="vendor_id" id="vendor_id" class="requires form-control">
                                                                <option selected disabled>--Vendor Name--</option>
                                                                @if(!empty($vendor_list) && (Auth::user()->roles == 'admin'))
                                                                    @foreach($vendor_list as $vendors_list)
                                                                        <option value="{{ $vendors_list->id }}" {{ @$data->vendor_id == $vendors_list->id ? 'selected' : '' }}>{{ $vendors_list->company }}</option>
                                                                    @endforeach
                                                                    @else
                                                                    @foreach($vendor_list as $vendors_list)
                                                                        <option value="{{ $vendors_list->id }}" {{ (Auth::user()->id) == $vendors_list->user_id ? 'selected' : '' }}>{{ $vendors_list->company }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>General Information</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <div class="col-md-4 col-lg-2">
                                                            <label for="description-2" class="block">Product description *</label>
                                                        </div>
                                                        <div class="col-md-8 col-lg-10">
                                                            <textarea name="description" id="description" rows="10" class="form-control editor">{{ @$data->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-4 col-lg-2">
                                                            <label for="description-2" class="block">Video URL </label>
                                                        </div>
                                                        <div class="col-md-8 col-lg-10">
                                                            <input type="url" name="video" placeholder="video url" class="form-control" value="{{ @$data->video }}">
                                                        </div>
                                                    </div>
                                                    <div id="warranty_data">
                                                    <div class="form-group row">
    <div class="col-md-4 col-lg-2">
        <label for="description-2" class="block">Warranty </label>
    </div>
    <div class="col-md-8 col-lg-10">
        <input type="text" name="warranty" placeholder="Warranty period" class="form-control" value="{{ @$data->warranty }}">
    </div>
</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Product Images</h5><br>
                                            <span class="hint">Click on the plus button to add the images according to the colors</span>
                                        </div>
                                        <div class="card-block">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div id="colors">
                                                        @if(!empty($image_data))
                                                            @foreach($image_data as $key => $img_data)
                                                            @php
                                                            $image = App\Models\productImages::select('image')->where('product_id', $data->id)->where('color_id', $img_data['color_id'])->get()->toArray();
                                                            $image = array_column($image, 'image');
                                                            $image = implode(',', $image); //dd($image)
                                                            @endphp
                                                            <div class="form-group row image">
                                                                <div class="col-md-3 col-lg-3 col-sm-12">
                                                                    <select name="imageColor[]" id="colorsData'+num+'" class="form-control selectebox">
                                                                        <option>--Select any One--</option>
                                                                        @if(!empty($colors))
                                                                            @foreach($colors as $colorList)
                                                                                <option value="{{ $colorList->id }}" {{ $img_data['color_id'] == $colorList->id ? 'selected' : '' }}>{{ $colorList->name }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-9 col-lg-9 col-sm-12" style="display:inherit"><a href="/vendor/filemanager/dialog.php?type=4&amp;field_id=thumbnail{{ $key }}&amp;descending=1&amp;sort_by=date&amp;lang=undefined&amp;akey=061e0de5b8d667cbb7548b551420eb821075e7a6" class="btn iframe-btn btn-primary" type="button"><i class="fa fa-picture-o"></i> Choose</a>
                                                                    <input id="thumbnail{{ $key }}" class="form-control h-100" value="{{ $image }}" type="text" name="image[]">
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <div class="form-group text-center">
                                                        <button type="button" class="btn btn-primary" id="add_color"><span class="icofont icofont-ui-add"></span></button>
                                                        <button type="button" class="btn btn-danger" id="delete_color"><span class="icofont icofont-ui-delete"></span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Product Inventory</h5><br>
                                            <span class="hint">Click on the plus button to add the SKU of the product.</span>
                                        </div>
                                        <div class="card-block">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div id="append">
                                                        @if(!empty($size_data))
                                                            @foreach($size_data as $key => $inven)
                                                            <div class="form-group row div">
                                                                <div class="col-md-2 col-lg-2">
                                                                    <select name="color[]" id="colorsData'+num+'" class="form-control selectebox">
                                                                        <option>--Select any One--</option>
                                                                        @if(!empty($colors))
                                                                            @foreach($colors as $colorList)
                                                                                <option value="{{ $colorList->id }}" {{ $inven['color_id'] == $colorList->id ? 'selected' : '' }}>{{ $colorList->name }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2 col-lg-2">
                                                                    <select class="select2 form-control" name="size[]" multiple="multiple" {{--id="sizesData{{ $key }}"--}}>
                                                                        @if(!empty($product_sizes))
                                                                            @foreach($product_sizes as $sizeList)
                                                                                <option value="{{ $sizeList->id }}" {{ $inven['size_id'] == $sizeList->id ? 'selected' : '' }}>{{ $sizeList->name }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2 col-lg-2">
                                                                    <input type="number" value="{{ @$inven['stock'] }}" placeholder="availability" name="stock[]" class="form-control h-100">
                                                                </div>
                                                                <div class="col-md-2 col-lg-2">
                                                                    <input class="form-control h-100" value="{{ @$inven['selling_price'] }}" type="text" name="price[]" placeholder="Selling price">
                                                                </div>
                                                                <div class="col-md-2 col-lg-2">
                                                                    <input class="form-control h-100" value="{{ @$inven['purchase_price'] }}" type="text" name="purchase[]" placeholder="Purchase price">
                                                                </div>
                                                                <div class="col-md-2 col-lg-2">
                                                                    <input class="form-control h-100" value="{{ @$inven['discount'] ? $inven['discount'] : 0 }}" type="text" name="discount[]" placeholder="discount">
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <div class="form-group text-center">
                                                        <button type="button" class="btn btn-primary" id="addnew"><span class="icofont icofont-ui-add"></span></button>
                                                        <button type="button" class="btn btn-danger" id="delete"><span class="icofont icofont-ui-delete"></span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row text-right">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary" name="status" value="active">{{ !empty($data) ? 'Update' : 'Add' }} Product</button>
                                    <button type="submit" class="btn btn-danger" name="status" value="inactive">Draft</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php if(!empty(@$data)){ $edit = 'yes'; } else { $edit = 'no'; } @endphp
@endsection
@section('scripts')
    <script>
        let edit = "{{ $edit }}";
        let product_id = "{{ @$data->id }}";
        $('#warranty_data').hide();
        $("#name").keyup(function (){
            let Slug = $('#name').val();
            document.getElementById("slug").value = convertToSlug(Slug);
        });

        if(edit == 'yes'){
            $(document).ready(function(){
            mycat = $('#category_id :selected').val();
            checkWarranty();
        });
        }

        function checkWarranty(){
            $.ajax({
                method: "POST",
                url:"{{ route('warranty_check') }}",
                dataType: 'json',
                data: { _token:"{{ csrf_token() }}", _method:"POST", mycat: mycat},
                success: function(response) {
                    if(response == "Yes"){
                        $('#warranty_data').show(1000);
                    } else {
                        $('#warranty_data').hide(1000);
                    }
                },
            });
        }

        $('#category_id').on('change', function(){

        if(edit == 'yes'){
              let r = confirm("Changing category will remove information about product images, sizes, color. This action cannot be undone.");
              if (r == true) {
                $('#append .div').remove();
                $('#colors .image').remove();

                $.ajax({
                    method: "DELETE",
                    url:"{{ route('delete_product_images') }}",
                    dataType: 'json',
                    data: { _token:"{{ csrf_token() }}", _method:"DELETE", id: product_id},
                });

                $.ajax({
                    method: "DELETE",
                    url:"{{ route('delete_product_sizes') }}",
                    dataType: 'json',
                    data: { _token:"{{ csrf_token() }}", _method:"DELETE", id: product_id},
                });

              } else {
                alert('Cancelled!');
                $(this).val(mycat);
                return;
              }
        }
            mycat = this.value;
            checkWarranty();
        });

      function MarketSizes(id){
      let cat_id = $('#category_id :selected').val();
            $.ajax({
                method: "POST",
                url:"{{ route('getsize') }}",
                dataType: 'json',
                data: { _token:"{{ csrf_token() }}", _method:"POST", cat_id: cat_id},
                success: function(response) {
                    $.each(response, function(key, value) {
                        $('#'+id).append('<option value="'+response[key]['id']+'">'+response[key]['name']+'</option>');
                    });
                },
            });
        }


    </script>
    <script>
        //multipleSelect('select2', 'Select sizes');
        let num = {{ !empty($count) ? $count : 0 }};
        $('#addnew').on('click', function(){
            num = num+1;
            prev = num-1;
            let html = '';
            html = '<div class="form-group row div"><div class="col-md-2 col-lg-2"><select name="color[]" id="colorsData'+num+'" class="form-control selectebox"><option>--Select any One--</option></select></div><div class="col-md-2 col-lg-2"><select class="form-control" name="size[]" id="sizesData'+num+'"><option>--Select size--</option></select></div><div class="col-md-2 col-lg-2"><input type="number" placeholder="availability" name="stock[]" class="form-control h-100"></div><div class="col-md-2 col-lg-2"><input class="form-control h-100" value="" type="text" name="price[]" placeholder="Selling price"></div><div class="col-md-2 col-lg-2"><input class="form-control h-100" value="" type="text" name="purchase[]" placeholder="purchase price"></div><div class="col-md-2 col-lg-2"><input class="form-control h-100" value="" type="text" name="discount[]" placeholder="discount"></div></div>';
            $('#append').append(html);
            callFancyBox();
            MarketColors('colorsData'+num);
            MarketSizes('sizesData'+num);
            //multipleSelect('select2', 'Select sizes');
        });

        $('#delete').on('click', function(){
            $('#append .div').last().remove();
        });

        $('#add_color').on('click', function(){
            let html = '';
            num = num+1;
            html = '<div class="form-group row image"><div class="col-md-3 col-lg-3 col-sm-12"><select name="imageColor[]" id="colorsData'+num+'" class="form-control selectebox"><option>--Select any One--</option></select></div><div class="col-md-9 col-lg-9 col-sm-12" style="display:inherit"><a href="/vendor/filemanager/dialog.php?type=4&amp;field_id=thumbnail'+num+'&amp;descending=1&amp;sort_by=date&amp;lang=undefined&amp;akey=061e0de5b8d667cbb7548b551420eb821075e7a6" class="btn iframe-btn btn-primary" type="button"><i class="fa fa-picture-o"></i> Choose</a><input id="thumbnail'+num+'" class="form-control h-100" value="" type="text" name="image[]"></div></div>';
            $('#colors').append(html);
            callFancyBox();
            MarketColors('colorsData'+num);
        });

        $('#delete_color').on('click', function(){
            $('#colors .image').last().remove();
        });
    </script>
@endsection
