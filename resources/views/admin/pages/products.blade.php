@extends('admin.layouts.master')
@section('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
   .slow  .toggle-group { transition: left 0.7s; -webkit-transition: left 0.7s; }
   .toggle, .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20rem; }
   .toggle, .toggle.ios .toggle-handle { border-radius: 20rem; }

   .flash{
       list-style: none; float: right; display: flex;
   }
   .ui-widget.ui-widget-content{
    left:50% !important;
    top: 1350px !important;
   }
   .ui-dialog-titlebar-close span{
      position: absolute;
      top: -2px;
      left: 3px;
   }

   .child_row tr:nth-child(even){background-color: #f2f2f2;}
   .child_row tr:hover {background-color: #ddd;}
   .child_row th {
      padding-top: 5px !important;
      background-color: #e8e8e8;

   }

   td.details-control {
       text-align:center;
       color:forestgreen;
       cursor: pointer;
   }
   tr.shown td.details-control {
       text-align:center;
       color:red;
   }
    .btn-dark {
        color: #fff;
        background-color: #343a40;
        border-color: #343a40;
    }

   .btn-dark:hover{
       color: #fff;
       background-color: #474e55;
   }
   .action-buttons .popover{
      background-color: #000;
      color: #fff;
      border-color: #000;
   }
   .action-buttons .popover.top .arrow:after {
      border-top-color: black;
   }
   .action-buttons .popover .popover-title{
      background-color: red;
   }

</style>
@endsection
@section('content')
@php
$active_tab = session()->get('active_tab');
@endphp
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
                        <table class="table table-striped table-bordered nowrap dataTable" role="grid"
                            id="product-tables" aria-describedby="basic-col-reorder_info" style="width:100%">
                              <thead>
                                 <tr>
                                    <th class="sorting_disabled"><input type="checkbox" id="all"></th>
                                    <th class="details-control"></th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>status</th>
                                    <th>created at</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                           </table>
                     </div>
                  </div>
                  <div class="tab-pane @if($active_tab == 'create') active @endif" id="create">
                     @if(empty($data))
                     <form action="{{ route('products.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
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
                                                <!--<a href="#" id="my_test" class="my_test" data-type="address" data-pk="1" data-title="Price" class="editable editable-click" data-original-title="" title="">Price</a>-->
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
                                          <div class="row text-center" style="margin-bottom:6px"><strong>General</strong></div>
                                          <div class="form-group row">
                                             <label class="col-sm-2 control-label">Slug<span class="text-danger">*</span></label>
                                             <div class="col-md-8 col-lg-10">
                                                <input name="slug" type="text" class="form-control" id="slug" required value="{{ old('slug', @$data->slug) }}">
                                                @if($errors->has('slug'))
                                                <span class='validation-errors text-danger'>{{ $errors->first('slug') }}</span>
                                                @endif
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-sm-2 control-label">Video</label>
                                             <div class="col-md-8 col-lg-10">
                                                <input type="url" name="video" placeholder="video url" class="form-control" value="{{ old('video', @$data->video) }}">
                                                @if($errors->has('video'))
                                                <span class='validation-errors text-danger'>{{ $errors->first('video') }}</span>
                                                @endif
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-sm-2 control-label">Brand<span class="text-danger">*</span></label>
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
                                             <label class="col-sm-2 control-label">Vendor<span class="text-danger">*</span></label>
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
                                          <div class="form-group row">
                                             <label class="col-sm-2 control-label">Vendor SKU<span class="text-danger">*</span></label>
                                             <div class="col-md-8 col-lg-10">
                                                <input name="sku" type="text" class="form-control" id="sku" required value="{{ old('sku', @$data->sku) }}">
                                                @if($errors->has('sku'))
                                                <span class='validation-errors text-danger'>{{ $errors->first('sku') }}</span>
                                                @endif
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-sm-2 control-label">Jojayo SKU</label>
                                             <div class="col-md-8 col-lg-10">
                                                <input name="jojayo_sku" type="text" readonly class="form-control" id="jojayo_sku" required value="@if(isset($data->jojayo_sku)) {{$data->jojayo_sku}} @else {{ date('Y').'-'.str_pad(time() + 1, 4, "0", STR_PAD_LEFT) }} @endif">
                                                @if($errors->has('jojayo_sku'))
                                                <span class='validation-errors text-danger'>{{ $errors->first('jojayo_sku') }}</span>
                                                @endif
                                             </div>
                                          </div>
                                          <div class="row text-center attribute hidden" style="margin-bottom:6px"><strong>Product Attributes</strong></div>
                                          <div id="attribute">
                                             @if(!empty($product_attr))
                                             @foreach($product_attr as $att_list)
                                             @foreach($att_list->attributes as $key => $value)
                                             <div class="form-group row">
                                                <label class="col-sm-2 control-label">{{$value->attributeDetail->name}}
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
                                          <div class="form-group row">
                                             <label class="col-sm-2 control-label">Similar Products<span class="text-danger">*</span></label>
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
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row text-center attribute" style="margin-bottom:6px"><strong>Other Details</strong></div>
                        <div class="row">
                           <div class="col-sm-12">
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
                                       <div class="col-md-12 col-lg-12 col-sm-12">
                                          <div id="colors">
                                             @if(!empty($image_data))
                                             @foreach($image_data as $key => $img_data)
                                             @php

                                             $image = App\Models\productImages::where('color_id', $img_data['color_id'])->where('product_id', $data->id)->get();
                                             @endphp
                                             <div class="form-group row image">
                                                <div class="col-md-6 col-lg-6 col-sm-12">
                                                   <select name="imageColor[]" id="colorsData{{$key}}" class="form-control selectebox colorSelectBox">
                                                      <option>--Select any One--</option>
                                                      @if(!empty($colors))
                                                      @foreach($colors as $colorList)
                                                      <option value="{{ $colorList->id }}" {{ (collect(old('color_id'))->contains($colorList->id)) ? 'selected':'' }} {{ $img_data['color_id'] == $colorList->id ? 'selected' : '' }}>{{ $colorList->name }}</option>
                                                      @endforeach
                                                      @endif
                                                   </select>
                                                </div>
                                                <div class="col-md-6 col-lg-6 col-sm-12" style="display:inherit">
                                                    <select id="sizesData{{$key}}" data-updkey="{{$key}}" class="form-control selectebox select_multi updsizedata" name="demosize[]" multiple="" tabindex="-1" aria-hidden="true">
                                                        @foreach ($product_sizes as $product_size)
                                                            <option value="{{$product_size->id}}"
                                                                @foreach($selected_sizes as $sel_size)
                                                                @foreach ($sel_size['size_id'] as $s_id)
                                                                @if ($sel_size['color_id']==$img_data['color_id']&&$product_size->id==$s_id)
                                                                selected
                                                                @endif
                                                                @endforeach
                                                                @endforeach
                                                                >{{$product_size->name}}</option>
                                                            {{-- <option value="{{$product_size->id}}" {{(($img_data['color_id']==$size['color_id'])&&($product_size->id==$size['size_id']))?'selected':''}}>{{$product_size->name}}</option> --}}
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-12 col-lg-12 col-sm-12" style="display:inherit;margin-top:10px">
                                                   <div class="media-gallery dropzone">
                                                      <div class="drop-upload" aria-disabled="false">
                                                         <div class="input-group"><span class="input-group-btn"><a id="lfm" data-input="thumbnail" data-preview="holder{{$key}}" style="border: 1px dashed rgb(196, 198, 207); border-radius: 2px; width: 140px; height: 45px; background-color: rgb(255, 255, 255); text-align: center; cursor: pointer; transition: border-color 0.3s ease 0s; display: inline-block; vertical-align: top;"><img src="//laz-g-cdn.alicdn.com/lazada/lib/0.0.81/image/publish/IC_MediaCenter.png" style="position: relative;"><span class="upload-text" data-spm-anchor-id="0.0.p-30129.i2.81e84edfnX8IMm" style="font-size: 14px; position: relative; top: 10px; color: rgb(102, 102, 102); width: 96px; display: inline-block; text-align: left; margin-left: 10px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Media Center</span></a></span><input id="thumbnail" class="form-control hidden" type="text" name="image[]">
                                                             <span id="holder{{$key}}" style="margin-top:15px;max-height:100px;margin-left:10px;display:flex">
                                                                <!--image loop code -->
                                                                @foreach ($image as $dimg)
                                                                @php
                                                                $pro_img = App\Models\Image::where('imageable_id',$dimg->id)->where('imageable_type','App\Models\ProductImages')->first()->toArray();
                                                                @endphp
                                                                <img src="{{asset('uploads/products/'.$pro_img['image'])}}" style="height:5rem;" alt="">
                                                                @endforeach
                                                                <!--image loop code -->
                                                             </span>
                                                         </div>
                                                         <div class="medi">
                                                            <div class="file-upload"><input type="file" class="files" name="images[]" multiple=""><img src="//laz-g-cdn.alicdn.com/lazada/lib/0.0.81/image/publish/IC_upload.png" style="position: relative;top: 11px;height: 16px;width: 16px;margin-left: 8px;"><span class="upload-text">Upload</span></div>
                                                         </div>

                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             @endforeach
                                             @endif
                                          </div>
                                       </div>
                                       <!-- <button id="addSku" type="button">Add</button> -->
                                       <div class="form-group text-center">
                                          <button type="button" class="btn btn-xs btn-primary" id="add_color"><span class="fa fa-plus"></span></button>
                                          <button type="button" class="btn btn-xs btn-danger" id="delete_color"><span class="fa fa-trash-o"></span></button>
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
                                                 <div class="col-md-1 col-lg-1">
                                                   <input type="hidden" value="{{$inven['status']}}" name="stockstatus[]" id="inv{{$inven['id']}}">
                                                   <input type="checkbox" class="stockupd" data-selid="{{$inven['id']}}" {{$inven['status']==1?'checked':''}} data-size="mini" data-toggle="toggle" name="stock_test[]" data-style="slow" value="{{$inven['status']}}">
                                                </div>
                                                <div class="col-md-1 col-lg-2">
                                                   <select name="color[]" id="colorsDatas{{$key}}" class="form-control">
                                                      {{-- @if(!empty($color_data)) --}}
                                                      {{-- @foreach($color_data as $color_list) --}}
                                                      <option value="{{ $inven['color_id'] }}">{{ $inven['color_info']['name'] }}</option>
                                                      {{-- @endforeach --}}
                                                      {{-- @endif    --}}
                                                   </select>
                                                </div>

                                                <div class="col-md-2 col-lg-2">
                                                   <select class="select2 form-control" name="size[]" id="sizesData{{ $key }}">
                                                      @if(!empty($product_sizes))
                                                      {{-- @foreach($product_sizes as $sizeList) --}}
                                                      <option value="{{ $inven['size_id'] }}">{{ $inven['size_info']['name'] }}</option>
                                                      {{-- @endforeach --}}
                                                      @endif
                                                   </select>
                                                </div>
                                                <div class="col-md-2 col-lg-2">
                                                   <input type="number" value="{{ @$inven['stock'] }}" placeholder="availability" name="stock[]" class="form-control h-100">
                                                </div>
                                                <div class="col-md-2 col-lg-2">
                                                   <input class="form-control h-100" value="{{ @$inven['selling_price'] }}" type="text" name="price[]" placeholder="Selling price">
                                                </div>

                                                <div class="col-md-1 col-lg-1 text-center" id="pop_class{{ $inven['size_info']['name'] }}">
                                                    <input name="flash_price[]" type="hidden" value="{{ @$inven['flash_price'] }}"/>
                                                    <input name="from[]" type="hidden" value="{{ @$inven['from_date'] }}"/>
                                                    <input name="to[]" type="hidden" value="{{ @$inven['to_date'] }}"/>
                                                    <ul class="flash">
                                                        <li>
                                                            <button type="button" id="my" class="btn btn-secondary btn-sm" data-container="body" data-toggle="popover" data-placement="top" data-content="<div class='form-group row pop_class{{ $inven['size_info']['name'] }}' data-ref='pop_class{{ $inven['size_info']['name'] }}'><label class='col-sm-2 control-label'>Price<span class='text-danger'>*</span></label><div class='col-md-8 col-lg-10'><input name='special_price' type='number' class='form-control'></div></div><p>This product shall be displayed on the Flash sale. Creating flash sales increases the chance of product being sold.</p><div class='form-group row pop_class{{ $inven['size_info']['name'] }}'> <label class='col-sm-2 control-label'>From<span class='text-danger'>*</span></label> <div class='col-md-8 col-lg-10'> <input name='starting_date' type='datetime-local' class='form-control' required value></div></div><div class='form-group row pop_class{{ $inven['size_info']['name'] }}'><label class='col-sm-2 control-label'>To<span class='text-danger'>*</span></label> <div class='col-md-8 col-lg-10'> <input name='ending_date' type='datetime-local' class='form-control' required value></div></div><a id='optBtn' class='btn btn-primary input-group-addon'>OK</a>" title="" data-html="true" data-original-title="Flash Sales Price">
                                                             <i class="fa fa-edit"></i>
                                                            </button>
                                                        </li>
                                                        @if(!empty(@$inven['flash_price']) && !empty(@$inven['from_date']) && !empty(@$inven['to_date']))
                                                        <li><button data-toggle="tooltip" title="Price: {{ @$inven['flash_price'] }}, From: {{ @$inven['from_date'] }}, To: {{ @$inven['to_date'] }}" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i></button></li>
                                                        @else
                                                        <li><button type="button" data-toggle="tooltip" title="Size not kept for flash sales" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i></button></li>
                                                        @endif
                                                    </ul>

                                                </div>

                                                <div class="col-md-2 col-lg-2">
                                                   <input class="form-control h-100" value="{{ @$inven['discount'] ? $inven['discount'] : 0 }}" type="text" name="discount[]" placeholder="discount">
                                                </div>
                                             </div>
                                             @endforeach
                                             @endif
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="row text-right">
                           <div class="col-12 action-buttons">
                              <span class="d-inline-block" data-toggle="popover" data-placement="top" data-title="Missing Properties" data-content="Please click the plus button to add product related images and sizes.">
                              <button class="btn btn-primary" type="submit" name="status" value="active" type="button">{{ !empty($data) ? 'Update' : 'Add' }} Product</button>
                              </span>
                              <span class="d-inline-block" data-toggle="popover" data-placement="top" data-title="Missing Properties" data-content="Please click the plus button to add product related images and sizes.">
                              <button type="submit" class="btn btn-danger" name="status" value="inactive">Draft</button>
                              </span>                                                            
                              @if(\Auth::user()->roles == 'admin')
                              @php $class = 'btn-dark' @endphp
                              @if(@$data->status == 'verified')
                                       @php $class = 'btn-success' @endphp
                              @endif
                                <button type="submit" class="btn {{$class}}" name="status" value="verified">Verified</button>
                            @endif
                           </div>
                        </div>
                     </form>
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
   $('button[type=submit]').prop('disabled', true);
   $('button[type=submit]').css('pointer-events','none');
   $('[data-toggle="popover"]').popover();
   let edit = '';
   if("{{ @$data->id }}" > 0){
      let edit = 'yes';
   }
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
   $('#delete').on('click', function(){
       $('#append .div').last().remove();
   });

   $('#add_color').on('click', function(){
       $('button[type=submit]').prop('disabled', false);
       $('button[type=submit]').css('pointer-events','');
       let html = '';
       num = num+1;
       html = '<div class="form-group row image afterappend"><div class="col-md-6 col-lg-6 col-sm-12"><select name="imageColor[]" id="colorsData'+num+'" data-num="'+num+'" class="form-control color_select" data="sizesData'+num+'"><option>--Select any One--</option></select></div><div class="col-md-6 col-lg-6 col-sm-12"><select id="sizesData'+num+'" class="form-control selectebox" name="demosize[]" multiple></select></div><div class="col-md-12 col-lg-12 col-sm-12" style="display:inherit;margin-top:10px"><div class="dropzone"><div class="drop-upload" aria-disabled="false"><div class="input-group"><span class="input-group-btn"><a id="lfm" data-input="thumbnail'+num+'" data-preview="holder'+num+'" style="border: 1px dashed rgb(196, 198, 207); border-radius: 2px; width: 140px; height: 45px; background-color: rgb(255, 255, 255); text-align: center; cursor: pointer; transition: border-color 0.3s ease 0s; display: inline-block; vertical-align: top;"><img src="//laz-g-cdn.alicdn.com/lazada/lib/0.0.81/image/publish/IC_MediaCenter.png" style="position: relative;"><span class="upload-text" data-spm-anchor-id="0.0.p-30129.i2.81e84edfnX8IMm" style="font-size: 14px; position: relative; top: 10px; color: rgb(102, 102, 102); width: 96px; display: inline-block; text-align: left; margin-left: 10px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Media Center</span></a></span><input id="thumbnail'+num+'" class="form-control hidden" type="text" name="image[]"><span id="holder'+num+'" style="max-height:100px;margin-left:10px;display:flex"></span></div><div class="medi"><div class="file-upload"><input type="file" class="files" name="images[]" multiple=""><img src="//laz-g-cdn.alicdn.com/lazada/lib/0.0.81/image/publish/IC_upload.png" style="position: relative;top: 11px;height: 16px;width: 16px;margin-left: 8px;"><span class="upload-text">Upload</span></div></div></div></div></div></div>';
       $('#colors').append(html);
       MarketSizes('sizesData'+num);
       MarketColors('colorsData'+num);
       multiSelect('colorsData'+num);
       multiSelect('sizesData'+num);
   });

   $(document).on("select2:unselecting", "select[name='demosize[]']", function(e) {
      var unselect_id = $(this).attr('id');
      var delete_val = e.params.args.data.text;
      $("."+unselect_id+"."+delete_val).remove();

   })

   $(document).on("change", "input[name='stock_test[]']", function(e) {
      var value = $(this).prop('checked');
      $(this).attr('value', value);
   });
   var selectedColors = [];
   $(document).on("select2:select", "select[name='imageColor[]']", function(e) {
      var exists = $(this).find(':selected').val();

      if(selectedColors.indexOf(exists) == -1) {
         if($.trim(exists)){
            selectedColors.push(exists.trim());
         } console.log(selectedColors);
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
            $(document).on("select2:select", '#sizesData'+num, function(e) {
               var selected_color = $('#'+my_id).find(":selected").text(); console.log(selected_color);
               var selected_color_id = $('#'+my_id).find(':selected').val();
               var selected_color_size = $(this).find(':selected').val();
               var key = e.params.data.id;
               var value = e.params.data.text;
               insert = '<div class="form-group row div sizesData'+row_num+' '+value+' colorsData'+row_num+'" ><div class="col-md-1 col-lg-1 text-center"><input type="hidden" id="htoggle'+row_num+''+value+'" value="1" name="stockstatus[]"><input id="toggle'+row_num+''+value+'" data-style="slow" checked name="stock_test[]" data-size="mini" type="checkbox"></div><div class="col-md-2 col-lg-2"><select name="color[]" class="form-control selectebox"><option selected value="'+selected_color_id+'">'+selected_color+'</option></select></div><div class="col-md-2 col-lg-2"><select class="form-control" name="size[]" id="sizesData'+num+'">';
               insert += '<option value="'+key+'">'+value+'</option>';
               insert += '</select></div><div class="col-md-2 col-lg-2"><input type="number" placeholder="availability" name="stock[]" class="form-control h-100"></div><div class="col-md-2 col-lg-2"><input class="form-control h-100" value="" type="number" name="price[]" placeholder="Selling price"></div><div class="col-md-1 col-lg-1 text-center" id="pop_class'+value+'"><input name="flash_price[]" type="hidden" value><input name="from[]" type="hidden" value><input name="to[]" type="hidden" value><button type="button" id="my" class="btn btn-secondary" data-container="body" data-toggle="popover" data-placement="top" data-content="<div class=\'form-group row pop_class'+value+'\' data-ref=\'pop_class'+value+'\'><label class=\'col-sm-2 control-label\'>Price<span class=\'text-danger\'>*</span></label><div class=\'col-md-8 col-lg-10\'><input name=\'special_price\' type=\'number\' class=\'form-control\'></div></div><p>This product shall be displayed on the Flash sale. Creating flash sales increases the chance of product being sold.</p><div class=\'form-group row pop_class'+value+'\'> <label class=\'col-sm-2 control-label\'>From<span class=\'text-danger\'>*</span></label> <div class=\'col-md-8 col-lg-10\'> <input name=\'starting_date\' type=\'datetime-local\' class=\'form-control\' required value></div></div><div class=\'form-group row pop_class'+value+'\'><label class=\'col-sm-2 control-label\'>To<span class=\'text-danger\'>*</span></label> <div class=\'col-md-8 col-lg-10\'> <input name=\'ending_date\' type=\'datetime-local\' class=\'form-control\' required value></div></div><a id=\'optBtn\' class=\'btn btn-primary input-group-addon\'>OK</a>" title="Flash Sales Price" data-html="true"><i class="fa fa-edit"></i></button></div><div class="col-md-2 col-lg-2"><input class="form-control h-100" value="" type="text" name="discount[]" placeholder="discount"></div></div>';
               $('#append').append(insert);
               initPopup();
               $('#toggle'+row_num+value).bootstrapToggle('on');
               $('#toggle'+row_num+value).change(function() {
                  var selected_val = $(this).prop('checked') == true ? 1 : 0;
                  $('#htoggle'+row_num+value).val(selected_val)
               })
            });
         }
      } else {
         openDialog('Duplicate Entry', 'You have selected this color previously, please choose different color.');
         $('#colors .image').last().remove();
      }

   })


   function multiSelect(id){
       $('#'+id).select2();
   }

//    $('.stockupd').bootstrapToggle('on');
//   $('.stockupd'),change(function(){
//       console.log('hi');
//   })

$('.stockupd').change(function(){
    var selVal = $(this).data('selid');
    // console.log('checked',$(this).prop('checked'));
    var selected_val = $(this).prop('checked') == true ? 1 : 0;
    // console.log(selected_val);
    // debugger;
    $('#inv'+selVal).val(selected_val);
})

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
                                 select = $('#attribute').append('<div class="form-group row"><label class="col-sm-2 control-label">'+value.name+'<span class="text-danger">*</span></label><div class="col-md-8 col-lg-10"><select name="attr['+value.id+']" id="'+value.id+'" class="form-control select_box" stye="width:100%"></select></div></div>');
                                 initSelect(value.id);
                                 $("#"+value.id).select2({
                                    placeholder: "Select "+value.name,
                                 });
                                 $.ajax({
                                    method: "GET",
                                    url:"/auth/get_attribute_value/"+value.id,
                                    dataType: 'json',
                                    success: function(response) {
                                       $('.attribute').removeClass('hidden');
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
    });

     $(document).on("select2:select", '.updsizedata', function(e) {
        //  alert($(this).data('updkey'));
        //  alert($('#colorsData'+$(this).data('updkey')).find(':selected').val());
        var updkey=$(this).data('updkey');
            var selected_color =  $('#colorsData'+$(this).data('updkey')).find(":selected").text();
            var selected_color_id =$('#colorsData'+$(this).data('updkey')).find(':selected').val();
            var selected_color_size = $(this).find(':selected').val();
            // alert(selected_color_size);
            var key = e.params.data.id;
            var value = e.params.data.text;
            insert = '<div class="form-group row div sizesData'+updkey+' '+value+' colorsData'+updkey+'" ><div class="col-md-1 col-lg-1"><input type="hidden" id="htoggle'+updkey+''+value+'" value="1" name="stockstatus[]"><input id="toggle'+updkey+''+value+'" data-style="slow" checked name="stock_test[]" data-size="mini" type="checkbox"></div><div class="col-md-2 col-lg-2"><select name="color[]" class="form-control selectebox"><option value="'+selected_color_id+'">'+selected_color+'</option></select></div><div class="col-md-2 col-lg-2"><select class="form-control" name="size[]" id="sizesData'+updkey+'">';
            insert += '<option value="'+key+'">'+value+'</option>';
            insert += '</select></div><div class="col-md-2 col-lg-2"><input type="number" placeholder="availability" name="stock[]" class="form-control h-100"></div><div class="col-md-2 col-lg-2"><input class="form-control h-100" value="" type="text" name="price[]" placeholder="Selling price"></div><div class="col-md-2 col-lg-2"><input class="form-control h-100" value="" type="text" name="purchase[]" placeholder="purchase price"></div><div class="col-md-1 col-lg-1"><input class="form-control h-100" value="" type="number" name="discount[]" placeholder="discount"></div></div>';
            $('#append').append(insert);
            $('#toggle'+updkey+value).bootstrapToggle('on');
             $('#toggle'+updkey+value).change(function() {
                 var selected_val = $(this).prop('checked') == 'true' ? 1 : 0;
                 $('#htoggle'+updkey+value).val(selected_val)
            })
         })



    function initPopup(){
        $('[data-toggle="popover"]').popover();
    }
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
    });

    // $(document).on("keyup", 'input[name=special_price]', function() {
    //     $(this).attr('value', $(this).val());
    // });
    $(document).on('click','#optBtn',function() {
        let my_var = $(this).parent('.popover-content').find('div').attr('data-ref');
        $('#'+my_var).find('input[name ="flash_price[]"]').val($('.'+my_var).find('input[name=special_price]').val());
        $('#'+my_var).find('input[name ="from[]"]').val($('.'+my_var).find('input[name=starting_date]').val());
        $('#'+my_var).find('input[name ="to[]"]').val($('.'+my_var).find('input[name=ending_date]').val());
        $('.popover').hide();
    })

    function format ( d ) {
      var inner_table = '<table class="child_row table table-striped table-bordered nowrap"><thead><tr><th>Size</th><th>Color</th><th>Price</th><th>Stock</th><th>Flash Sales</th><th>Discount</th><th>Status</th></tr></thead><tbody>'
         $.each(d.sizes, function( index, value ) {
            if(value.flash_price == null){
               var flash = 'Not available';
            } else {
               var flash = value.flash_price;
            }
            if(value.status == 1){
               var status = "Active";
            } else {
               var status = "Inactive";
            }
            inner_table += '<tr><td>'+value.size_info.name+'</td><td>'+value.color_info.name+'</td><td>'+value.selling_price+'</td><td>'+value.stock+'</td><td>'+flash+'</td><td>'+value.discount+'</td><td>'+status+'</td>';
         });
      inner_table += '</tbody></table>';
      return inner_table;
   }

        $(document).ready(function() {
         load_product();
         function load_product( ) {
            $(document).ready(function () {
                $.extend($.fn.dataTable.defaults, {
                    columnDefs: [
                        { orderable: false, targets: '_all' }
                    ],
                    'dom': 'lBfrtip',
                    buttons: [
                        // {
                        //     extend: 'print',
                        //     text: "<i class='fa fa-print'> </i>",
                        //     className: 'btn btn-danger btn-xs ml mr',
                        // },
                        // {
                        //     extend: 'excel',
                        //     text: '<i class="fa fa-file-excel-o"> </i>',
                        //     className: 'btn btn-purple mr btn-xs',
                        // },
                        // {
                        //     extend: 'csv',
                        //     text: '<i class="fa fa-file-excel-o"> </i>',
                        //     className: 'btn btn-primary mr btn-xs',
                        // },
                        // {
                        //     extend: 'pdf',
                        //     text: '<i class="fa fa-file-pdf-o"> </i>',
                        //     className: 'btn btn-info mr btn-xs',
                        // },
                        // {
                        //     text: "Bulk Delete",
                        //     className: 'btn btn-danger bulk-delete btn-xs mr',
                        //     action: function ( e, dt, node, config ) {
                        //         var ids = [];
                        //         var count = '';
                        //         var url = $('#base').val();
                        //         $.each($("input[name='delete_items']:checked"), function(){
                        //             ids.push($(this).val());
                        //         });
                        //         count = ids.length;
                        //         if(confirm("You are about to delete "+count+" record(s). This cannot be undone. Are you sure?"))
                        //         {
                        //             var before = ids;
                        //             ids = ids.toString();
                        //             $.ajax(
                        //                 {
                        //                     method: "POST",
                        //                     url: url,
                        //                     dataType: 'json',
                        //                     data: { _token:"{{ csrf_token() }}", _method:"DELETE", ids: ids},
                        //                     success: function (response)
                        //                     {
                        //                         $.each(before, function(key, value){
                        //                             $('#'+value).remove();
                        //                         });
                        //                         toastr.success(response);
                        //                     }
                        //                 });
                        //         }
                        //     }
                        // }

                    ],
                });

                // DataTable
                var table = $('#product-tables').DataTable({
                    processing: true,
                    paging: true,
                    searching: true,
                    ordering: true,
                    stateSave: true,
                    autoWidth: true,
                    serverSide: false,
                    ajax: {
                        url: "{{route('ajaxRequest.products')}}"},
                    columns: [
                        {data: 'id', name:'id'},
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": '',
                            "render": function () {
                                return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
                            },
                        },
                        {data: 'title', name:'title'},
                        {data: 'category_id', name:'category_id'},
                        {data: 'brand', name:'brand'},
                        {data: 'status', name:'status'},
                        {data: 'created_at', name:'created_at'},
                        {data: 'action', name:'action'},
                    ],
                    "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "All"]],
                });

                $('#product-tables tbody').on('click', 'td.details-control', function () {
                  var tr = $(this).closest('tr');
                  var tdi = tr.find("i.fa");
                  //var prod_id = $(this).closest('tr').find("input[name='delete_items']").val();
                  var row = table.row( tr );
                  console.log(row.data());
                        if ( row.child.isShown() ) {
                            row.child.hide();
                            tr.removeClass('shown');
                            tdi.first().removeClass('fa-minus-square');
                            tdi.first().addClass('fa-plus-square');
                        }
                        else {
                            row.child(format(row.data())).show();
                            tr.addClass('shown');
                            tdi.first().removeClass('fa-plus-square');
                            tdi.first().addClass('fa-minus-square');
                        }
                  });
               } );
        }
        });
</script>

@endsection
