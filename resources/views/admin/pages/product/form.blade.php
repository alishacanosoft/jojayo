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
                           <option value="18" selected>Kurti selected</option>
                              <option  disabled>--Product Category--</option>
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
                                            @if($errors->has('video'))
                                            <span class='validation-errors text-danger'>{{ $errors->first('video') }}</span>
                                            @endif
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
                                            @if($errors->has('brand_id'))
                                            <span class='validation-errors text-danger'>{{ $errors->first('brand_id') }}</span>
                                            @endif
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
                                          @if($errors->has('vendor_id'))
                                            <span class='validation-errors text-danger'>{{ $errors->first('vendor_id') }}</span>
                                          @endif
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
                                            @if($errors->has('similar_poducts'))
                                            <span class='validation-errors text-danger'>{{ $errors->first('similar_poducts') }}</span>
                                            @endif
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
                           @if($errors->has('specification'))
                              <span class='validation-errors text-danger'>{{ $errors->first('specification') }}</span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-2 control-label">Product Description<span class="text-danger">*</span></label>
                        <div class="col-md-8 col-lg-10">
                           <textarea name="description" id="description" rows="10" class="form-control editor">{{ old('description', @$data->description) }}</textarea>
                           @if($errors->has('description'))
                              <span class='validation-errors text-danger'>{{ $errors->first('description') }}</span>
                           @endif
                        </div>
                     </div>
                     <div id="warranty_data">
                        <div class="form-group row">
                           <label class="col-sm-2 control-label">Warranty</label>
                           <div class="col-md-8 col-lg-10">
                              <input type="text" name="warranty" placeholder="Warranty period" class="form-control" value="{{ old('warranty', @$data->warranty) }}">
                              @if($errors->has('warranty'))
                                 <span class='validation-errors text-danger'>{{ $errors->first('warranty') }}</span>
                              @endif
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   @if(!empty($image_data))
   @foreach($image_data as $pey => $img_data)
   <div class="form-group">
      <div class="row ">
         <label class="col-sm-2 control-label">Color Family<span class="text-danger">*</span></label>
         <div class="col-md-10 col-lg-10 col-sm-12">
            <select name="imageColor[]" id="colorsData'+num+'" class="form-control selectebox">
               <option>--Select any One--</option>
               @if(!empty($all_colors))
               @foreach($all_colors as $colorList)
               <option value="{{ $colorList->id }}" @if($colorList->id == $img_data['color_id']) selected @endif {{ (collect(old('color_id'))->contains($colorList->id)) ? 'selected':'' }}>{{ $colorList->name }}</option>
               @endforeach
               @endif

            </select>
            @if($errors->has('imageColor'))
               <span class='validation-errors text-danger'>{{ $errors->first('imageColor') }}</span>
            @endif
         </div>
      </div>
      <p></p>
      <div class="row">
         <label class="col-sm-2 control-label"></label>
         <div class="col-md-10 col-lg-10 col-sm-12">
            <div class="dropzone">
               <div class="drop-upload" aria-disabled="false">
                  <div class="input-group">
                     <span class="input-group-btn">
                     <a id="lfm" data-input="thumbnail" data-preview="holder" style="border: 1px dashed rgb(196, 198, 207); border-radius: 2px; width: 140px; height: 45px; background-color: rgb(255, 255, 255); text-align: center; cursor: pointer; transition: border-color 0.3s ease 0s; display: inline-block; vertical-align: top;">
                     <img src="//laz-g-cdn.alicdn.com/lazada/lib/0.0.81/image/publish/IC_MediaCenter.png" style="position: relative;">
                     <span class="upload-text" data-spm-anchor-id="0.0.p-30129.i2.81e84edfnX8IMm" style="font-size: 14px; position: relative; top: 10px; color: rgb(102, 102, 102); width: 96px; display: inline-block; text-align: left; margin-left: 10px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Media Center</span>
                     </a>
                     </span>
                     <input id="thumbnail" class="form-control hidden" type="text" name="image[]">
                     <span id="holder" style="max-height:100px;margin-left:10px;display:flex">
                     </span>
                  </div>
                  <div class="medi">
                     <div class="file-upload">
                        <input type="file" class="files" name="images[]" multiple="">
                        <img src="//laz-g-cdn.alicdn.com/lazada/lib/0.0.81/image/publish/IC_upload.png" style="position: relative;top: 11px;height: 16px;width: 16px;margin-left: 8px;">
                        <span class="upload-text">Upload</span>
                     </div>
                     @if(!empty($img_data))
                     @foreach($img_data['images'] as $color_images)
                     <span class="pip">
                        <img class="imageThumb" src="{{$color_images['image']}}">
                     </span>
                     @endforeach
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div><p></p>
      <div class="form-group row div">
         <div class="col-md-2 col-lg-2"></div>
         <div class="col-md-2 col-lg-2">
            <select class="form-control select_2_to" name="size[]" id="sizesData" multiple="multiple">
               @php
               if(!empty($product_sizes)){
                  foreach ($product_sizes as $sizeList){
                        $checked = '';
                        if(!empty($sizes_available)){
                           if (is_array($sizes_available) || is_object($sizes_available)) {
                           foreach ($sizes_available as $key => $value) {
                           if($sizeList->id == old('size_id')){
                           $checked = 'selected';
                           break;
                           }
                           elseif($sizeList->id == $value['size_id']){
                           $checked = 'selected';
                           break;
                           }
                        }
                     }
                  }
                  @endphp
                  <option value="{{ $sizeList->id }}" {{ (collect(old('size_id'))->contains($sizeList->id)) ? 'selected':'' }} {{ $checked}}>{{ $sizeList->name }}</option>
                  @php
                  }
               }
               @endphp
            </select>
            @if($errors->has('size'))
               <span class='validation-errors text-danger'>{{ $errors->first('size') }}</span>
            @endif
         </div>
         <div class="col-md-2 col-lg-2">
            <input type="number" value="{{ @$inven['stock'] }}" placeholder="availability" name="stock[]" class="form-control h-100">
            @if($errors->has('stock'))
               <span class='validation-errors text-danger'>{{ $errors->first('stock') }}</span>
            @endif
         </div>
         <div class="col-md-2 col-lg-2">
            <input class="form-control h-100" value="{{ @$inven['selling_price'] }}" type="text" name="price[]" placeholder="Selling price">
            @if($errors->has('price'))
               <span class='validation-errors text-danger'>{{ $errors->first('price') }}</span>
            @endif
         </div>
         <div class="col-md-2 col-lg-2">
            <input class="form-control h-100" value="{{ @$inven['purchase_price'] }}" type="text" name="purchase[]" placeholder="Purchase price">
            @if($errors->has('purchase'))
               <span class='validation-errors text-danger'>{{ $errors->first('purchase') }}</span>
            @endif
         </div>
         <div class="col-md-2 col-lg-2">
            <input class="form-control h-100" value="{{ @$inven['discount'] ? $inven['discount'] : 0 }}" type="text" name="discount[]" placeholder="discount">
            @if($errors->has('discount'))
               <span class='validation-errors text-danger'>{{ $errors->first('discount') }}</span>
            @endif
         </div>
      </div>
   </div>
   @endforeach
   @endif
   <div class="form-group div" id="appendDiv">
        <label class="col-sm-2 control-label"></label>
        <div class="col-md-10 col-lg-10 col-sm-12" style="margin-bottom: 10px; padding: 2px;">
            <select name="imageColor[]" id="colorsData" class="form-control selectebox">
                   <option>--Select any One--</option>
                   <option value="15">Aqua</option>
                   <option value="4">Black</option>
                   <option value="3">Blue</option>
                   <option value="22">Bubblegum Pink</option>
                   <option value="29">Capri Blue</option>
                   <option value="28">Cobalt</option>
                   <option value="19">Coral</option>
                   <option value="18">Coral rose</option>
                   <option value="26">Fuchsia</option>
                   <option value="34">Grape</option>
                   <option value="13">Green</option>
                   <option value="23">Hot Pink</option>
                   <option value="30">Jade</option>
                   <option value="33">Lavender</option>
                   <option value="32">Light Orchid</option>
                   <option value="20">Light Pink</option>
                   <option value="12">Lime</option>
                   <option value="7">Maroon</option>
                   <option value="35">Mint</option>
                   <option value="10">Navy blue</option>
                   <option value="14">Ocean blue</option>
                   <option value="6">Orange</option>
                   <option value="21">Pearl Pink</option>
                   <option value="8">Pink</option>
                   <option value="16">Plum</option>
                   <option value="17">Poppy red</option>
                   <option value="11">Purple</option>
                   <option value="1">Red</option>
                   <option value="9">Royal blue</option>
                   <option value="24">Shocking Pink</option>
                   <option value="31">Teal</option>
                   <option value="27">Tropic</option>
                   <option value="5">White</option>
                   <option value="25">Wine</option>
                   <option value="2">Yellow</option>
               </select>
        </div>             
        <div class="row">
            <label class="col-sm-2 control-label"></label>
            <div class="col-md-10 col-lg-10 col-sm-12">
                <select name="" id="demosize" class="form-control select_box select2-hidden-accessible" multiple="multiple">
                    <option value="">This is size one</option>
                    <option value="">This is size two</option>
                </select>
            </div>
        </div>
        <p></p>
       <div class="row" id="firstFileUploader">
            <label class="col-sm-2 control-label"></label>
            <div class="col-md-10 col-lg-10 col-sm-12">
                <div class="dropzone">
                    <div class="drop-upload" aria-disabled="false">
                        <div class="input-group">
                           <span class="input-group-btn">
                               <a id="lfm" data-input="thumbnail'+num+'" data-preview="holder'+num+'" style="border: 1px dashed rgb(196, 198, 207); border-radius: 2px; width: 140px; height: 45px; background-color: rgb(255, 255, 255); text-align: center; cursor: pointer; transition: border-color 0.3s ease 0s; display: inline-block; vertical-align: top;">
                                   <img src="//laz-g-cdn.alicdn.com/lazada/lib/0.0.81/image/publish/IC_MediaCenter.png" style="position: relative;">
                                   <span class="upload-text" data-spm-anchor-id="0.0.p-30129.i2.81e84edfnX8IMm" style="font-size: 14px; position: relative; top: 10px; color: rgb(102, 102, 102); width: 96px; display: inline-block; text-align: left; margin-left: 10px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Media Center</span>
                               </a>
                           </span>
                           <input id="thumbnail'+num+'" class="form-control hidden" type="text" name="image[]">
                           <span class="lfmholder" id="holder'+num+'" style="max-height:100px;margin-left:10px;display:flex"> </span>
                        </div>
                        <div class="medi">
                            <div class="file-upload">
                                <input type="file" class="files" name="images[]" multiple="">
                                <img src="//laz-g-cdn.alicdn.com/lazada/lib/0.0.81/image/publish/IC_upload.png" style="position: relative;top: 11px;height: 16px;width: 16px;margin-left: 8px;">
                                <span class="upload-text">Upload</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row" style="margin-top: 5px;">
            <label class="col-sm-2 control-label"></label>
            <div class="col-md-2 col-lg-2">
                <select class="form-control" name="size[]" id="sizesData">
                {{-- @foreach($allSizes as $size)
                    <option value="{{$size->id}}">{{$size->name}}</option>
                @endforeach --}}
                </select>
            </div>
            <div class="col-md-2 col-lg-2">
                <input type="number" placeholder="availability" name="stock[]" class="form-control h-100">
            </div>

            <div class="col-md-2 col-lg-2">
                <input class="form-control h-100" value="" type="text" name="price[]" placeholder="Selling price">
            </div>

            {{-- <div class="col-md-1 col-lg-1">
                <input class="form-control h-100" value="" type="text" name="purchase[]" placeholder="purchase price">
            </div> --}}

            <div class="col-md-2 col-lg-2">
                <input class="form-control h-100" value="" type="text" name="discount[]" placeholder="discount">
            </div>

            <div class="col-md-2 col-lg-2">
                <button type="button" class="btn btn-xs btn-primary addNew"><span class="fa fa-plus"></span></button>
                <button type="button" class="btn btn-xs btn-primary removeCurrent"><span class="fa fa-minus"></span></button>
            </div>
        </div>

    </div>
   <div id="append">
   </div>
</form>

<script>
    var num = 0;
    $('#colorsData').on('change',function(){
        var selected_color = $(this).find(":selected").val();
        var selected_c_name = $(this).find(":selected").text();
        var cat_id = $('#category_id :selected').val();
        $.ajax({
            url: "{{ route('getsize') }}",
            method: 'POST',
            data: { _token:"{{ csrf_token() }}", _method:"POST", cat_id: cat_id, num: num},
            success:function(response){
               $('#append').append(response);               
                $('#demosize'+num).select2({placeholder: 'Select available sizes for this color'});
                $('#demosize'+num).on('change', function(){
                var selected_size = $(this).find(":selected").get().reduce((ob, el) => {
                    ob[el.value] = el.textContent;
                    return ob
                }, {});
                $.ajax({
                  url: "{{ route('getrecent') }}",
                  method: 'POST',
                  data: { _token:"{{ csrf_token() }}", _method:"POST", selected_size: selected_size, num: num,selected_color:selected_color,selected_c_name:selected_c_name},
                  success:function(response){
                     $('#appendDiv'+(num-2)).append(response);
                  }
                });
               //  html = '<div class="row size-row" style="margin-top: 5px;"><label class="col-sm-2 control-label"></label><div class="col-md-2 col-lg-2"><select class="form-control" name="color[]" id="sizesData"><option value="'+selected_color+'">'+selected_c_name+'</option></select></div><div class="col-md-1 col-lg-1"><select class="form-control" name="size[]" id="sizesData'+num+'">';
               //  $.each(selected_size, function(key, value) {
               //      html += '<option value="'+key+'">'+value+'</option>';
               //  });
               //  html += '</select></div><div class="col-md-2 col-lg-2"><input type="number" placeholder="availability" name="stock[]" class="form-control h-100"></div><div class="col-md-2 col-lg-2"><input class="form-control h-100" value="" type="text" name="price[]" placeholder="Selling price"></div><div class="col-md-2 col-lg-2"><input class="form-control h-100" value="" type="text" name="discount[]" placeholder="discount"></div><div class="col-md-1 col-lg-1"><span class="btn btn-xs text-danger removeCurrent"><i class="fa fa-trash"></i></span></div></div>';                
                
                })                 
                num++;
            }
        })
    })
    $(document).on("click", ".removeCurrent", function() {
        $(this).closest('.size-row').remove();
    })
</script>
