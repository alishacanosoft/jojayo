@extends('admin.layouts.master')
@section('styles')
    <style>
        .switch-field {
            display: flex;
            margin-bottom: 36px;
            overflow: hidden;
        }

        .switch-field input {
            position: absolute !important;
            clip: rect(0, 0, 0, 0);
            height: 1px;
            width: 1px;
            border: 0;
            overflow: hidden;
        }

        .switch-field label {
            background-color: #e4e4e4;
            color: rgba(0, 0, 0, 0.6);
            font-size: 14px;
            line-height: 1;
            text-align: center;
            padding: 3px;
            margin-right: -1px;
            border: 1px solid rgba(0, 0, 0, 0.2);
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
            transition: all 0.1s ease-in-out;
        }

        .switch-field label:hover {
            cursor: pointer;
        }

        .switch-field input:checked + label {
            background-color: #a5dc86;
            box-shadow: none;
        }

        .switch-field label:first-of-type {
            border-radius: 4px 0 0 4px;
        }

        .switch-field label:last-of-type {
            border-radius: 0 4px 4px 0;
        }


    </style>
@endsection
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-sm-12">
            <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">

                  <li class="@if($active_tab == 'manage') active @endif"><a href="#manage" data-toggle="tab">All Product</a></li>
                  <li class="@if($active_tab == 'create') active @endif"><a href="#create" data-toggle="tab">New Product</a></li>
                  <input type="hidden" id="base" value="{{ route('ajax.products') }}">
               </ul>
               <div class="tab-content bg-white">
                  <div class="tab-pane @if($active_tab == 'manage') active @endif" id="manage">
                     <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable_action" role="grid" aria-describedby="basic-col-reorder_info">
                           <thead>
                              <tr>
                                 <th><input type="checkbox" id="all"></th>
                                 <th>Title</th>
                                 <th>Category</th>
                                 <th>Brand</th>
                                 <th>Status</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              @if(!empty($allProducts))
                              @foreach($allProducts as $productLists)
                              @can('view', $productLists)
                              <tr>
                                 <td><input type="checkbox" name="delete_items" value="{{ $productLists->id }}"></td>
                                 <td style="max-width:550px">{{ $productLists->name }}</td>
                                 <td style="max-width:100px">{{ @$productLists->category->name }}</td>
                                 <td>{{ @$productLists->brand->name }}</td>
                                 @php
                                 if($productLists->status == 'active'){
                                 $class = "success-tag";
                                 } else {
                                 $class = "danger-tag";
                                 }
                                 @endphp
                                 <td><span class="{{ $class }}">{{ $productLists->status }}</span></td>
                                 <td>
                                    <a href="{{ route('products.edit', $productLists->id) }}" class="btn btn-primary btn-xs pull-left" style="margin-right: 5px">
                                    <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    <a class="pull-left" onclick="return confirm('Are you sure you want to delete this product?')">
                                       <form method="POST" action="{{ route('products.destroy', $productLists->id) }}" accept-charset="UTF-8">
                                          <input name="_method" type="hidden" value="DELETE">
                                          <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                          <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash-o"></i></button>
                                       </form>
                                    </a>
                                 </td>
                              </tr>
                              @endcan
                              @endforeach @endif
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div class="tab-pane @if($active_tab == 'create') active @endif" id="create">
                    {{print_r($errors->all())}}
                     @if(empty($data))
                     <form action="{{ route('products.store') }}" method="POST" class="form-horizontal">
                        @csrf
                        @else
                        {{ Form::open(['url'=>route('products.update', $data->id), 'class'=>'form-horizontal', 'id'=>'product_update', 'files'=>true,'method'=>'patch']) }}
                        @endif
                        <div class="row">
                           <div class="col-sm-12">
                              <div class="card">
                                 <div class="card-block">
                                    <div class="row">
                                       <div class="col-12">
                                          <div class="form-group row">
                                             <label class="col-sm-2 control-label">Product Name<span class="text-danger">*</span></label>
                                             <div class="col-md-8 col-lg-10">
                                                <input name="name" type="text" required class="form-control" id="name" value="{{ old('name', @$data->name) }}">
                                                @if($errors->has('name'))
                                                <span class='validation-errors text-danger'>{{ $errors->first('name') }}</span>
                                                @endif
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-sm-2 control-label">Category<span class="text-danger">*</span></label>
                                             <div class="col-md-8 col-lg-10">
                                                <select name="category_id" id="category_id" class="requires form-control">
                                                   <option selected disabled>--Product Category--</option>
                                                   @if((Auth::user()->roles == 'admin') && !empty($category))
                                                   @foreach($category as $category_list)
                                                   <option value="18" selected>Kurtis</option>
                                                   <option value="{{ $category_list->id }}" {{ @$data->category_id == $category_list->id ? 'selected' : '' }}>{{ $category_list->name }}</option>
                                                   @endforeach
                                                   @else
                                                   @if(!empty($current_vendor->categoryAssigned))
                                                   @foreach($current_vendor->categoryAssigned as $category_list)
                                                   <option value="{{ $category_list->category_id }}" {{ @$data->category_id == $category_list->category_id ? 'selected' : '' }}>{{ $category_list->CategoryDetail->name }}</option>
                                                   @endforeach
                                                   @endif
                                                   @endif
                                                </select>
                                                @if($errors->has('category_id'))
                                                <span class='validation-errors text-danger'>At least one category should be selected to add a product.</span>
                                                @endif
                                             </div>
                                          </div>

                                          <div class="row form-group">
                                            <label class="col-sm-2 control-label">Product Attributes<span class="text-danger">*</span></label>
                                               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab-container">
                                                     <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
                                                     <div class="list-group">
                                                        <a href="#" class="list-group-item active text-center">
                                                           General
                                                        </a>
                                                        <a href="#" class="list-group-item text-center">
                                                           Inventory
                                                        </a>
                                                        <a href="#" class="list-group-item text-center">
                                                           Attributes
                                                        </a>
                                                        <a href="#" class="list-group-item text-center">
                                                           Similar products
                                                        </a>
                                                     </div>
                                                     </div>
                                                     <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                                                        <!-- flight section -->
                                                        <div class="bhoechie-tab-content active">
                                                           <center><p></p>
                                                           <div class="form-group row">
                                                              <label class="col-sm-2">Slug <span class="text-danger">*</span></label>
                                                              <div class="col-md-8 col-lg-10">
                                                                 <input name="slug" type="text" class="form-control" id="slug" required value="{{ old('slug', @$data->slug) }}">
                                                                 @if($errors->has('slug'))
                                                                 <span class='validation-errors text-danger'>{{ $errors->first('slug') }}</span>
                                                                 @endif
                                                              </div>
                                                           </div>
                                                           <div class="form-group row">
                                                              <div class="col-md-4 col-lg-2">
                                                                 <label for="description-2" class="block">Video URL </label>
                                                              </div>
                                                              <div class="col-md-8 col-lg-10">
                                                                 <input type="url" name="video" placeholder="video url" class="form-control" value="{{ old('video', @$data->video) }}">
                                                              </div>
                                                           </div>
                                                           <div class="form-group row">
                                                              <label class="col-sm-2">Brand<span class="text-danger">*</strong></label>
                                                              <div class="col-md-8 col-lg-10">
                                                                 <select name="brand_id" id="brand_id" class="requires form-control">
                                                                    <option selected disabled>--Product Brand--</option>
                                                                    @if(!empty($category_brands))
                                                                     @foreach($category_brands as $brandList)
                                                                     <option value="{{ $brandList->brand_id }}" @if($data->brand_id == $brandList->brand_id) selected @endif>{{ $brandList->brandDetail->name }}</option>
                                                                     @endforeach
                                                                    @endif
                                                                 </select>
                                                              </div>
                                                           </div>
                                                           <div class="form-group row">
                                                              <label class="col-sm-2">Vendor<span class="text-danger">*</span></label>
                                                              <div class="col-md-8 col-lg-10">
                                                                 @if(!empty($vendor_list) && (Auth::user()->roles == 'admin'))
                                                                 <select name="vendor_id" id="vendor_id" class="requires form-control">
                                                                    <option selected disabled>--Vendor Name--</option>
                                                                    @if(!empty($vendor_list) && (Auth::user()->roles == 'admin'))
                                                                    @foreach($vendor_list as $vendors_list)
                                                                    <option value="{{ $vendors_list->id }}" {{ (collect(old('vendor_id'))->contains($vendors_list->id)) ? 'selected':'' }} {{ @$data->vendor_id == $vendors_list->id ? 'selected' : '' }}>{{ $vendors_list->company }}</option>
                                                                    @endforeach
                                                                    @endif
                                                                 </select>
                                                                 @else
                                                                 <select name="vendor_id" id="vendor_id" class="requires form-control">
                                                                    <option value="{{ $current_vendor->id }}" {{ (Auth::user()->id) == $current_vendor->user_id ? 'selected' : '' }}>{{ $current_vendor->company }}</option>
                                                                 </select>
                                                                 @endif
                                                              </div>
                                                           </div>
                                                           </center>
                                                        </div>
                                                        <!-- train section -->
                                                        <div class="bhoechie-tab-content">
                                                           <center><p></p>
                                                           <div class="form-group row">
                                                              <label class="col-sm-2">SKU<span class="text-danger">*</span></label>
                                                              <div class="col-md-8 col-lg-10">
                                                                 <input name="sku" type="text" class="form-control" id="sku" required value="{{ old('sku', @$data->sku) }}">
                                                                 @if($errors->has('sku'))
                                                                 <span class='validation-errors text-danger'>{{ $errors->first('sku') }}</span>
                                                                 @endif
                                                              </div>
                                                           </div>
                                                           </center>
                                                        </div>

                                                        <!-- hotel search -->

                                                        <div class="bhoechie-tab-content">
                                                           <center><p></p>
                                                              <div id="attribute">
                                                                 @if(!empty($product_attr))
                                                                    @foreach($product_attr as $att_list)
                                                                    @foreach($att_list->attributes as $key => $value)
                                                                    <div class="form-group row">
                                                                       <label class="col-sm-2">{{$value->attributeDetail->name}}
                                                                          <span class="text-danger">*</span></label>
                                                                       <div class="col-md-8 col-lg-10">
                                                                          @if($value->attributeDetail->field == 'select')
                                                                             <select name="attr[{{$value->attributeDetail->id}}]" id="{{ $value->attributeDetail->id }}" class="form-control select_box" stye="width:100%">
                                                                              <option selected disabled>--Select Value--</option>
                                                                                @php
                                                                                $att_data = App\Models\AttributeValue::where('attribute_id', $value->attributeDetail->id)->get();
                                                                                @endphp

                                                                                @php
                                                                                foreach ($att_data as $data_lists){
                                                                                    $checked = '';
                                                                                    if(!empty($data->my_attribute)){
                                                                                       if (is_array($data->my_attribute) || is_object($data->my_attribute)) {
                                                                                       foreach ($data->my_attribute as $key => $value) {
                                                                                       if($data_lists->id == old('attribute_value_id')){
                                                                                       $checked = 'selected';
                                                                                       break;
                                                                                       }
                                                                                       elseif($data_lists->id == $value['attribute_value_id']){
                                                                                       $checked = 'selected';
                                                                                       break;
                                                                                       }
                                                                                    }
                                                                                    }
                                                                                 }
                                                                                 @endphp
                                                                                 <option value="{{ $data_lists->id }}" {{ (collect(old('attribute_value_id'))->contains($data_lists->id)) ? 'selected':'' }} {{ $checked}}>{{ $data_lists->value }}</option>
                                                                                 @php
                                                                                 }
                                                                                @endphp
                                                                             </select>
                                                                          @else
                                                                             <input type="text" name="attr[{{$value->attributeDetail->id}}]" value="{{ @$att_list->attribute_value }}" class="form-control">
                                                                          @endif
                                                                       </div>
                                                                    </div>
                                                                    @endforeach
                                                                    @endforeach
                                                                 @endif
                                                              </div>
                                                           </center>
                                                        </div>
                                                        <div class="bhoechie-tab-content">
                                                           <center><p></p>
                                                           <div class="form-group row">
                                                              <label class="col-sm-2">Similar Products<span class="text-danger">*</span></label>
                                                              <div class="col-md-8 col-lg-10">
                                                                 <select name="similar_poducts[]" class="select_2_to" id="similar_poducts" multiple="multiple">
                                                                  @php
                                                                  if(!empty($my_similar_product)){
                                                                  $similar_data = explode(",", @$data->similarProductList->ids);
                                                                  foreach ($my_similar_product as $sim_list){
                                                                     $checked = '';
                                                                     if(!empty($similar_data)){
                                                                        if (is_array($similar_data) || is_object($similar_data)) {
                                                                        foreach ($similar_data as $key => $value) {
                                                                        if($sim_list->id == old('similar_products')){
                                                                        $checked = 'selected';
                                                                        break;
                                                                        }
                                                                        elseif($sim_list->id == $value){
                                                                        $checked = 'selected';
                                                                        break;
                                                                        }
                                                                     }
                                                                     }
                                                                  }
                                                                  @endphp

                                                                  <option value="{{ $sim_list->id }}"  {{ (collect(old('similar_products'))->contains($sim_list->id)) ? 'selected':'' }} {{ $checked}}>{{ $sim_list->name }}</option>
                                                                  @php
                                                                  }
                                                                  }
                                                                  @endphp
                                                                 </select>
                                                              </div>
                                                           </div>
                                                           </center>
                                                        </div>
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
                                 <div class="card-block">
                                    <div class="row">
                                       <div class="col-12">
                                       <div class="form-group row">
                                          <label class="col-sm-2 control-label">Product Specification<span class="text-danger">*</span></label>
                                             <div class="col-md-8 col-lg-10">
                                                <textarea name="specification" id="specification" rows="10" class="form-control editor">{{ old('specification', @$data->specification) }}</textarea>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-sm-2 control-label">Product Description<span class="text-danger">*</span></label>
                                             <div class="col-md-8 col-lg-10">
                                                <textarea name="description" id="description" rows="10" class="form-control editor">{{ old('description', @$data->description) }}</textarea>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <div class="col-md-4 col-lg-2">
                                                <label for="description-2" class="block">Video URL </label>
                                             </div>
                                             <div class="col-md-8 col-lg-10">
                                                <input type="url" name="video" placeholder="video url" class="form-control" value="{{ old('video', @$data->video) }}">
                                             </div>
                                          </div>
                                          <div id="warranty_data">
                                             <div class="form-group row">
                                                <div class="col-md-4 col-lg-2">
                                                   <label for="description-2" class="block">Warranty </label>
                                                </div>
                                                <div class="col-md-8 col-lg-10">
                                                   <input type="text" name="warranty" placeholder="Warranty period" class="form-control" value="{{ old('warranty', @$data->warranty) }}">
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
                                 <div class="card-block">
                                    <div class="row text-center">
                                       <strong>Product Images</strong>
                                       <br>
                                       <span class="hint">Click on the plus button to add the images according to the colors</span>
                                    </div>
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
                                                      <option value="{{ $colorList->id }}" {{ (collect(old('color_id'))->contains($colorList->id)) ? 'selected':'' }} {{ $img_data['color_id'] == $colorList->id ? 'selected' : '' }}>{{ $colorList->name }}</option>
                                                      @endforeach
                                                      @endif
                                                   </select>
                                                </div>
                                                <div class="col-md-9 col-lg-9 col-sm-12" style="display:inherit"><a href="/vendor/filemanager/dialog.php?type=4&amp;field_id=thumbnail{{ $key }}&amp;descending=1&amp;sort_by=date&amp;lang=undefined&amp;akey=061e0de5b8d667cbb7548b551420eb821075e7a6" class="btn iframe-btn btn-primary" type="button"><i class="fa fa-picture-o"></i> Choose</a>
                                                   <input id="thumbnail{{ $key }}" class="form-control h-100" value="{{ old('image', $image) }}" type="text" name="image[]" style="display:inline-block;width:89%;margin-left:-3px">
                                                </div>
                                             </div>
                                             @endforeach
                                             @endif
                                          </div>
                                          <div class="form-group text-center">
                                             <button type="button" class="btn btn-xs btn-primary" id="add_color"><span class="fa fa-plus"></span></button>
                                             <button type="button" class="btn btn-xs btn-danger" id="delete_color"><span class="fa fa-trash-o"></span></button>
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
                                                   <select class="select2 form-control" name="size[]" {{--id="sizesData{{ $key }}"--}}>
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
                                          <!-- <div class="form-group text-center">
                                             <button type="button" class="btn btn-xs btn-primary" id="addnew"><span class="fa fa-plus"></span></button>
                                             <button type="button" class="btn btn-xs btn-danger" id="delete"><span class="fa fa-trash-o"></span></button>
                                          </div> -->
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

                        {{-- <div class="switch-field"><input type="radio" id="radio-one" name="switch-one" value="yes" checked/><label for="radio-one">Yes</label><input type="radio" id="radio-two" name="switch-one" value="no" /><label for="radio-two">No</label></div> --}}
                     </form>
                     <div class="switch-field">
                         <input type="radio" id="radio-one" name="switch-one" value="yes" checked/>
                         <label for="radio-one">Yes</label>
                         <input type="radio" id="radio-two" name="switch-one" value="no" />
                         <label for="radio-two">No</label>
                    </div>
                     <div class="switch-field">
                         <input type="radio" id="radio-one" name="switch-one" value="yes" checked/>
                         <label for="radio-one">Yes</label>
                         <input type="radio" id="radio-two" name="switch-one" value="no" />
                         <label for="radio-two">No</label>
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
   let edit = "{{ @$edit }}";
   let product_id = "{{ @$data->id }}";
   $('#warranty_data').hide();

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
   function getSimilar(){
      let cat_id = $('#category_id :selected').val();
      $.ajax({
         method: "POST",
         url:"{{ route('getSimilar') }}",
         dataType: 'json',
         data: { _token:"{{ csrf_token() }}", _method:"POST", cat_id: cat_id},
         success: function(response) {
            $.each(response, function(key, value) {
                  $('#similar_poducts').append('<option value="'+response[key]['id']+'">'+response[key]['name']+'</option>');
            });
         },
      });
   }
   let num = {{ !empty($count) ? $count : 0 }};

   // $('#addnew').on('click', function(){
   //     num = num+1;
   //     prev = num-1;
   //     let html = '';
   //     html = '<div class="form-group row div"><div class="col-md-2 col-lg-2"><select name="color[]" id="colorsData'+num+'" class="form-control selectebox"><option>--Select any One--</option></select></div><div class="col-md-2 col-lg-2"><select class="form-control" name="size[]" id="sizesData'+num+'"><option>--Select size--</option></select></div><div class="col-md-2 col-lg-2"><input type="number" placeholder="availability" name="stock[]" class="form-control h-100"></div><div class="col-md-2 col-lg-2"><input class="form-control h-100" value="" type="text" name="price[]" placeholder="Selling price"></div><div class="col-md-2 col-lg-2"><input class="form-control h-100" value="" type="text" name="purchase[]" placeholder="purchase price"></div><div class="col-md-2 col-lg-2"><input class="form-control h-100" value="" type="text" name="discount[]" placeholder="discount"></div></div>';
   //     $('#append').append(html);
   //    callFancyBox();
   //     MarketColors('colorsData'+num);
   // });

   $('#delete').on('click', function(){
       $('#append .div').last().remove();
   });



    // $("select[name=colorData]").on('change',function(){
    //     console.log('yest');
    // })

   $('#add_color').on('click', function(){
       let html = '';
       num = num+1;
       html = '<div class="form-group row image afterappend"><div class="col-md-2 col-lg-2 col-sm-12"></div><div class="col-md-4 col-lg-4 col-sm-12"><select name="imageColor[]" id="colorsData'+num+'" data-num="'+num+'" class="form-control color_select" data="sizesData'+num+'"><option>--Select any One--</option></select></div><div class="col-md-6 col-lg-6 col-sm-12"><select id="sizesData'+num+'" class="form-control selectebox" name="demosize[]" multiple></select></div><div class="col-md-2 col-lg-2 col-sm-12"></div><div class="col-md-10 col-lg-10 col-sm-12" style="display:inherit;margin-top:10px"><div class="dropzone"><div class="drop-upload" aria-disabled="false"><div class="input-group"><span class="input-group-btn"><a id="lfm" data-input="thumbnail'+num+'" data-preview="holder'+num+'" style="border: 1px dashed rgb(196, 198, 207); border-radius: 2px; width: 140px; height: 45px; background-color: rgb(255, 255, 255); text-align: center; cursor: pointer; transition: border-color 0.3s ease 0s; display: inline-block; vertical-align: top;"><img src="//laz-g-cdn.alicdn.com/lazada/lib/0.0.81/image/publish/IC_MediaCenter.png" style="position: relative;"><span class="upload-text" data-spm-anchor-id="0.0.p-30129.i2.81e84edfnX8IMm" style="font-size: 14px; position: relative; top: 10px; color: rgb(102, 102, 102); width: 96px; display: inline-block; text-align: left; margin-left: 10px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Media Center</span></a></span><input id="thumbnail" class="form-control hidden" type="text" name="image[]"><span id="holder'+num+'" style="max-height:100px;margin-left:10px;display:flex"></span></div><div class="medi"><div class="file-upload"><input type="file" class="files" name="images[]" multiple=""><img src="//laz-g-cdn.alicdn.com/lazada/lib/0.0.81/image/publish/IC_upload.png" style="position: relative;top: 11px;height: 16px;width: 16px;margin-left: 8px;"><span class="upload-text">Upload</span></div></div></div></div></div></div>';
       $('#colors').append(html);
       MarketSizes('sizesData'+num);
       MarketColors('colorsData'+num);
       multiSelect('sizesData'+num);
   });
   
   $(document).on("select2:unselecting", "select[name='demosize[]']", function(e) {      
      console.log(e.params.args.data.id);
   })
   $(document).on("change", "select[name='imageColor[]']", function() {
      var my_id = $(this).attr('id');
      var size_class = $(this).attr('data');
      var row_num = $(this).attr('data-num');
      var insert = '';
      if ($("."+my_id).length > 0) {
         if (confirm("Inventory with this color will be deleted, this action cannot be undone. Do you still want to perform this action?")) {            
            $("."+my_id).remove();
            $('#'+size_class).select2('destroy').find('option').prop('selected', false).end().select2();                               
         }
      } else {
         // $('#sizesData'+num).on('change', function(e){
         $(document).on("select2:select", '#sizesData'+num, function(e) {
            var selected_color = $('#'+my_id).find(":selected").text();
            var selected_color_id = $('#'+my_id).find(':selected').val();
            var selected_color_size = $(this).find(':selected').val();
            var key = e.params.data.id;
            var value = e.params.data.text;            
            // var data = $(this).find(":selected").get().reduce((ob, el) => {
            //    ob[el.value] = el.textContent;
            //    return ob
            // }, {});
            insert = '<div class="form-group row div sizesData'+row_num+' colorsData'+row_num+'"><div class="col-md-2 col-lg-2"><select name="color[]" class="form-control selectebox"><option value="'+selected_color_id+'">'+selected_color+'</option></select></div><div class="col-md-2 col-lg-2"><select class="form-control" name="size[]" id="sizesData'+num+'">';
            // $.each(data, function(key, value) {
               insert += '<option value="'+key+'">'+value+'</option>';
            // });
            insert += '</select></div><div class="col-md-2 col-lg-2"><input type="number" placeholder="availability" name="stock[]" class="form-control h-100"></div><div class="col-md-2 col-lg-2"><input class="form-control h-100" value="" type="text" name="price[]" placeholder="Selling price"></div><div class="col-md-2 col-lg-2"><input class="form-control h-100" value="" type="text" name="purchase[]" placeholder="purchase price"></div><div class="col-md-2 col-lg-2"><input class="form-control h-100" value="" type="text" name="discount[]" placeholder="discount"></div></div>';
            $('#append').append(insert);            
         })
      }
   })

   

   function multiSelect(id){
       $('#'+id).select2();
   }


   $('#delete_color').on('click', function(){
       $('#colors .image').last().remove();
   });

   // brands and attribute
   $('#category_id').on('change', function(){
      let cat_val = $(this).val();
      getSimilar();
      $('#brand_id').html('<option selected disabled>--Product Brand--</option>');
      $.ajax({
         method: "GET",
         url:"/auth/get_category_brand/"+cat_val,
         dataType: 'json',
         success: function(response) {
            $.each(response, function(key, value) {
               option = $('#brand_id').append("<option value="+value.brand_id+">"+value.brand_detail.name+"</option>");
            });
         },
      });
      $.ajax({
           method: "GET",
           url:"/auth/get_attribute/"+cat_val,
           dataType: 'json',
         //   data: { _token:"{{ csrf_token() }}", _method:"POST", cat_id: cat_id},
           success: function(response) {
            $('#attribute').html('');
               $.each(response, function(key, value) {
                  $.ajax({
                     method: "GET",
                     url:"/auth/get_attribute_data/"+value.attribute_id,
                     dataType: 'json',
                     success: function(response) {
                        let select = '';
                           $.each(response, function(key, value) {
                              if(value.field == 'select'){
                                 select = $('#attribute').append('<div class="form-group row"><label class="col-sm-2">'+value.name+'<span class="text-danger">*</span></label><div class="col-md-8 col-lg-10"><select name="attr['+value.id+']" id="'+value.id+'" class="form-control select_box" stye="width:100%"></select></div></div>');
                                 initSelect(value.id);
                                 $("#"+value.id).select2({
                                    placeholder: "Select "+value.name,
                                 });
                                 $.ajax({
                                    method: "GET",
                                    url:"/auth/get_attribute_value/"+value.id,
                                    dataType: 'json',
                                    success: function(response) {
                                       $.each(response, function(key, value) {
                                          if(key == 0){
                                             $('#'+value.attribute_id).append("<option><option>");
                                          }
                                          option = $('#'+value.attribute_id).append("<option value="+value.id+">"+value.value+"</option>");
                                       });
                                    },
                                 });
                              } else {
                                 select = $('#attribute').append('<div class="form-group row"><label class="col-sm-2">'+value.name+'<span class="text-danger">*</span></label><div class="col-md-8 col-lg-10"><input name="attr['+value.id+']" placeholder="input" class="form-control"></div></div>');
                              }
                           });
                     },
                  });
               });
           },
       });
   });

   $(document).on("select[name=imageColor]", function (e) {
        var thisa = $(this);
        console.log(thisa);
        // if ($this.data('datepicker')) return;
        // e.preventDefault();
        // component click requires us to explicitly show it
        // $this.datepicker('show');

    });    
    
</script>
@endsection
