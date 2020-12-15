@extends('admin.layouts.master')
@section('styles')
<style>
    .delivery-data {
      list-style-type: none;
      margin: 0;
      padding: 0;
    }
    
    .delivery-data li {
      float: left;
      margin: 0 5px 0 0;
      width: 100px;
      height: 40px;
      position: relative;
    }
    
    .delivery-data label,
    .delivery-data input {
      display: block;
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
    }
    
    .delivery-data input[type="radio"] {
      opacity: 0.01;
      z-index: 100;
    }
    
    .delivery-data input[type="radio"]:checked+label,
    .Checked+label {
      background: #1a5c67;
      color: #fff;
    }
    
    .delivery-data label {
      padding: 5px;
      border: 1px solid #CCC;
      cursor: pointer;
      z-index: 90;
      border-radius: 5px;
      background: #d4d4d4;
    }
    
    .delivery-data label:hover {
      background: #DDD;
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
                  <li class="@if($active_tab == 'manage') active @endif"><a href="#manage" data-toggle="tab">All Sales</a></li>
                  <li class="@if($active_tab == 'create') active @endif"><a href="#create" data-toggle="tab">New Sale</a></li>
                  <input type="hidden" id="base" value="{{ route('ajax.categories') }}">
               </ul>
               <div class="tab-content bg-white">
                  <div class="tab-pane @if($active_tab == 'manage') active @endif" id="manage">
                     <div class="table-responsive">
                     <table id="normal-table" class="table table-striped table-bordered nowrap datatable_action" role="grid" aria-describedby="basic-col-reorder_info">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Sales Quantity</th>
                                <th>Price</th>
                                <th>Sold At</th>
                                <th>Entry date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($sales_list)
                                @foreach($sales_list as $saleList)
                                    <tr>
                                        <td>{{ @$saleList->productName->name }}</td>
                                        <td>{{ @$saleList->color->name }}</td>
                                        <td>{{ @$saleList->size->name }}</td>
                                        <td>{{ @$saleList->quantity }}</td>
                                        <td>{{ @$saleList->price }}</td>
                                        <td>{{ @$saleList->sales_date }}</td>
                                        <td>{{ @$saleList->created_at }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                     </div>
                  </div>
                  <div class="tab-pane @if($active_tab == 'create') active @endif" id="create">
                  @if(!empty($data))
                    {{ Form::open(['url'=>route('sales.update', $data->id), 'class'=>'form form-horizontal', 'id'=>'sales_add', 'files'=>true,'method'=>'patch']) }}
                @else
                <form action="{{ route('sales.store') }}" method="POST" class="form-horizontal">
                    @endif
                    @csrf
                    <div class="card-block">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label">Product Name<span class="text-danger">*</span></label>
                                    <div class="col-md-8 col-lg-10">
                                        <select class="product form-control select_box select2-hidden-accessible" name="product_id" id="product_id">
                                            @if(!empty($product_list))
                                                <option>--Select product--</option>
                                                @foreach($product_list as $lists)
                                                    <option value="{{ $lists['id'] }}" {{ (collect(old('product_id'))->contains($lists->id)) ? 'selected':'' }} {{ @$data->product_id == $lists->id ? 'selected' : '' }}>{{ $lists['name'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if($errors->has('product_id'))
                                            <span class='validation-errors text-danger'>{{ $errors->first('product_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label">Color<span class="text-danger">*</span></label>
                                    <div class="col-md-8 col-lg-10">
                                        <select class="product form-control select_box select2-hidden-accessible" name="color_id" id="color_id">
                                            <option>--Select Color--</option>
                                        </select>
                                        @if($errors->has('color_id'))
                                            <span class='validation-errors text-danger'>{{ $errors->first('color_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label">Size<span class="text-danger">*</span></label>
                                    <div class="col-md-8 col-lg-10">
                                        <select class="product form-control select_box select2-hidden-accessible" name="size_id" id="size_id">
                                            <option>--Select Size--</option>
                                        </select>
                                        @if($errors->has('size_id'))
                                            <span class='validation-errors text-danger'>{{ $errors->first('size_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label">Stock available</label>
                                    <div class="col-md-8 col-lg-10">
                                        <input type="text" class="form-control" readonly id="stock_available">
                                    </div>
                                </div>

                                <div id="product-unavailable">
                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">Price per piece</label>
                                        <div class="col-md-8 col-lg-10">
                                            <input type="text" class="form-control" id="selling_price" readonly value="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">Sales quantity<span class="text-danger">*</span></label>
                                        <div class="col-md-8 col-lg-10">
                                            <input type="text" class="form-control" id="sales_quantity" name="quantity" value="" value="{{ old('quantity',@$data->quantity) }}">
                                            @if($errors->has('quantity'))
                                                <span class='validation-errors text-danger'>{{ $errors->first('quantity') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">Price</label>
                                        <div class="col-md-8 col-lg-10">
                                            <input type="text" class="form-control" id="price" readonly name="price" value="">
                                            @if($errors->has('price'))
                                                <span class='validation-errors text-danger'>{{ $errors->first('price') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="discount-row">
                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label">Discount</label>
                                            <div class="col-md-8 col-lg-10">
                                                <input type="text" class="form-control" id="discount" readonly name="discount" value="">
                                                @if($errors->has('discount'))
                                                    <span class='validation-errors text-danger'>{{ $errors->first('discount') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label">Discounted price<span class="text-danger">*</span></label>
                                            <div class="col-md-8 col-lg-10">
                                                <input type="text" class="form-control" id="discounted_price" readonly name="price" value="">
                                                @if($errors->has('price'))
                                                    <span class='validation-errors text-danger'>{{ $errors->first('price') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">Method of Payment<span class="text-danger">*</span></label>
                                        <div class="col-md-8 col-lg-10">
                                            <select class="form-control" name="payment_method" id="payment_method">
                                                <option>--Select Payment Method--</option>
                                                @if(!empty($methods))
                                                    @foreach($methods as $methodList)
                                                        <option value="{{ $methodList->id }}">{{ $methodList->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if($errors->has('payment_method'))
                                                <span class='validation-errors text-danger'>{{ $errors->first('payment_method') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!--<div class="form-group row">-->
                                    <!--    <div class="col-md-4 col-lg-2">-->
                                    <!--        <label for="slug" class="block">Payment Account</label>-->
                                    <!--    </div>-->
                                    <!--    <div class="col-md-8 col-lg-10">-->
                                    <!--        <select class="form-control" id="account_id" name="account_id">-->
                                    <!--            <option>--Select Account--</option>-->
                                    <!--        </select>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">Sales Date<span class="text-danger">*</span></label>
                                        <div class="col-md-8 col-lg-10">
                                            <input type="datetime-local" class="form-control" name="sales_date">
                                            @if($errors->has('sales_date'))
                                                <span class='validation-errors text-danger'>{{ $errors->first('sales_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">Purchased by<span class="text-danger">*</span></label>
                                        <div class="col-md-8 col-lg-10">
                                            <input type="text" class="form-control" name="purchased_by" value="{{ old('purchased_by',@$data->purchased_by) }}">
                                            @if($errors->has('purchased_by'))
                                                <span class='validation-errors text-danger'>{{ $errors->first('purchased_by') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">Contact<span class="text-danger">*</span></label>
                                        <div class="col-md-8 col-lg-10">
                                            <input type="text" class="form-control" name="contact" value="{{ old('contact',@$data->contact) }}">
                                            @if($errors->has('contact'))
                                                <span class='validation-errors text-danger'>{{ $errors->first('contact') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">Delivery Region<span class="text-danger">*</span></label>
                                        <div class="col-md-8 col-lg-10">
                                            <select class="form-control" id="region_id">
                                                @if(!empty($all_region))
                                                <option selected disabled>--Select Delivery Region--</option>
                                                @foreach($all_region as $regionList)
                                                <option value="{{ $regionList->id }}">{{ $regionList->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">Delivery City<span class="text-danger">*</span></label>
                                        <div class="col-md-8 col-lg-10">
                                            <select class="form-control" id="city_id">
                                                <option selected disabled>--Select Delivery City--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">Delivery Area<span class="text-danger">*</span></label>
                                        <div class="col-md-8 col-lg-10">
                                            <select class="form-control" id="area_id" name="area_id">
                                                <option selected disabled>--Select Delivery Area--</option>
                                            </select>
                                            @if($errors->has('area_id'))
                                                <span class='validation-errors text-danger'>{{ $errors->first('area_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">Delivery Address<span class="text-danger">*</span></label>
                                        <div class="col-md-8 col-lg-10">
                                            <textarea class="form-control" name="delivery_address" rows="5">{{ old('delivery_address',@$data->delivery_address) }}</textarea>
                                            @if($errors->has('delivery_address'))
                                                <span class='validation-errors text-danger'>{{ $errors->first('delivery_address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">Delivery<span class="text-danger">*</span></label>
                                        <div class="col-md-8 col-lg-10">
                                            <ul class="delivery-data">
                                              <li>
                                                <input type="radio" id="normal-charge" name="delivery_charge" value="" checked>
                                                <label for="normal-charge">Normal (<span id="normal">0</span>)</label>
                                              </li>
                                              <li>
                                                <input type="radio" id="express-charge" name="delivery_charge" value="">
                                                <label for="express-charge">Express (<span id="express">0</span>)</label>
                                              </li>
                                              
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">Remarks<span class="text-danger">*</span></label>
                                        <div class="col-md-8 col-lg-10">
                                            <textarea class="form-control" name="remarks" rows="5">{{ old('remarks',@$data->remarks) }}</textarea>
                                            @if($errors->has('remarks'))
                                                <span class='validation-errors text-danger'>{{ $errors->first('remarks') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                    <div class="col-md-4 col-lg-2">
                                        <label for="brand-2" class="block"></label>
                                    </div>
                                    <div class="col-md-8 col-lg-10">
                                    <button type="submit" class="btn btn-primary" name="status" value="active">Make sale</button>
                                    </div>
                                </div>
                                </div>
                                <div id="reload">
                                    <div class="form-group row">
                                        <div class="col-md-4 col-lg-2">
                                            <label for="brand-2" class="block"></label>
                                        </div>
                                        <div class="col-md-8 col-lg-10">
                                        <button type="refresh" class="btn btn-primary" name="status" value="active">Reload</button>
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
      </div>
   </div>
</div>
@endsection
@section('scripts')
<script>
    $('.discount-row').fadeOut();
    $('#reload').fadeOut();
    $("#region_id").on('change', function(){
        var region_id = $(this).val();
        $.ajax({
             type: "GET",
             url:"/auth/get-cities/"+region_id,
             success: function (response) {                        
                $.each(response, function(key, value){
                    $('#city_id').append("<option value="+value.id+">"+value.name+"</option>");
                });
             }
          });
    });
    $("#city_id").on('change', function(){
        var city_id = $(this).val();
        $.ajax({
             type: "GET",
             url:"/auth/get-areas/"+city_id,
             success: function (response) {
                $.each(response, function(key, value){
                    $('#area_id').append("<option value="+value.id+">"+value.name+"</option>");
                });
             }
          });
    });
    $("#area_id").on('change', function(){
        var area_id = $(this).val();
        $.ajax({
             type: "GET",
             url:"/auth/areas/"+area_id+"/edit",
             success: function (response) { console.log(response);
                $('#normal').html(response.delivery_charge);
                $('#normal-charge').val(response.delivery_charge);
                $('#express').html(response.express_charge);
                $('#express-charge').val(response.express_charge);
             }
          });
    });
    $(document).ready(function() {
        $('.product').select2();
    });
    $('#product_id').on('change', function(){
        var product_id = $('#product_id').val();
        $.ajax({
        method: "POST",
        url: "/auth/product-available-color/"+product_id,
        data: {_token: "{{ csrf_token() }}", _method:"POST"},
        success: function(response){
            $.each(response, function(key, value) {
                $('#color_id').append('<option value="'+response[key]['id']+'">'+response[key]['name']+'</option>');
            });
            $('#color_id').on('change', function(){
            let color_id = $('#color_id').val();
                $.ajax({
                    method: "POST",
                    url: "/../product-available-size/"+product_id,
                    data: {_token: "{{ csrf_token() }}", _method:"POST", color_id: color_id},
                    success: function(response){
                      $.each(response, function(key, value) {
                          $('#size_id').append('<option value="'+response[key]['id']+'">'+response[key]['name']+'</option>');
                      });
                      $('#size_id').on('change', function(){
                        let size_id = $('#size_id').val();
                          $.ajax({
                            method: "POST",
                            url: "{{ route('getstock') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                _method: "POST",
                                size_id: size_id,
                                color_id: color_id,
                                product_id: product_id
                            },
                            success: function(response) {
                                if(response[0]['stock'] > 0){
                                  $('#stock_available').val(response[0]['stock']);
                                  $('#selling_price').val(response[0]['selling_price']);
                                  let discount = '';
                                  let discounted = '';
                                  if(response[0]['discount'] !== 'undefined'){
                                      $('.discount-row').show(1000);
                                      discount = response[0]['discount'];
                                      $('#discount').val(discount);
                                  }
                                  $('#sales_quantity').keyup(function() {
                                      let sales_qty = $('#sales_quantity').val();
                                      let total = sales_qty * response[0]['selling_price'];
                                      $('#price').val(total);
                                      if(discount !== null || discount !== 'undefined'){
                                          discounted = total - discount * sales_qty;
                                          $('#discounted_price').val(discounted);
                                      }
                                  });
                                  $('#payment_method').on('click', function(){
                                      let payment_method = this.value;
                                      $.ajax({
                                        method: "POST",
                                        url: "{{ route('getaccounts') }}",
                                        data: {
                                            _token: "{{ csrf_token() }}",
                                            _method: "POST",
                                            payment_id: payment_method
                                        },
                                        success: function(response) {
                                            $.each(response, function(key, value) {
                                                $('#account_id').append('<option value="'+response[key]['id']+'">'+response[key]['name']+'</option>');
                                            });
                                        }
                                      });
                                  })
                                } else {
                                  $('#stock').val('Product unavailable!');
                                  $('#stock').addClass('text-danger');
                                  $('#reload').fadeIn();
                                  $('#product-unavailable').hide(1000);
                                }
                            }
                          });
                      })
                    }
                });
            });

        }
        });
    });
</script>
@endsection
