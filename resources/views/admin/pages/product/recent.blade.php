<div class="row size-row" style="margin-top: 5px;">
   <label class="col-sm-2 control-label"></label>
   <div class="col-md-2 col-lg-2">
      <select class="form-control" name="color[]" id="sizesData">
         <option value="{{$selected_color}}">{{$selected_c_name}}</option>
      </select>
   </div>
   <div class="col-md-1 col-lg-1">
      <select class="form-control" name="size[]" id="sizesData{{$increase_number}}">
        @foreach($selected_size as $key => $sizes)
         <option value="{{$key}}">{{$sizes}}</option>
        @endforeach
      </select>
   </div>
   <div class="col-md-2 col-lg-2"><input type="number" placeholder="availability" name="stock[]" class="form-control h-100"></div>
   <div class="col-md-2 col-lg-2"><input class="form-control h-100" value="" type="text" name="price[]" placeholder="Selling price"></div>
   <div class="col-md-2 col-lg-2"><input class="form-control h-100" value="" type="text" name="discount[]" placeholder="discount"></div>
   <div class="col-md-1 col-lg-1"><span class="btn btn-xs text-danger removeCurrent"><i class="fa fa-trash"></i></span></div>
</div>