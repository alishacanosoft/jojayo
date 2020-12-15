@extends('admin.layouts.master') @section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Add sale</h4>
                                    <span class="text-danger">Click the button next to your company logo on the left to see the full columns of the table.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Add sale</h5>
                                    <div class="card-header-right">
                                        <i class="icofont icofont-rounded-down"></i>
                                    </div>
                                </div>

                                @if(!empty($data))
                                    {{ Form::open(['url'=>route('sales.update', $data->id), 'class'=>'form', 'id'=>'sales_add', 'files'=>true,'method'=>'patch']) }}
                                @else
                                <form action="{{ route('sales.store') }}" method="POST">
                                    @endif
                                    @csrf
                                    <div class="card-block">
                                      <div class="row">
                                          <div class="col-12">
                                              <div class="form-group row">
                                                  <div class="col-md-4 col-lg-2">
                                                      <label for="name" class="block">Product Name *</label>
                                                  </div>
                                                  <div class="col-md-8 col-lg-10">
                                                      <select class="product" name="product_id" id="product_id">
                                                          @if(!empty($product_list))
                                                              <option>--Select product--</option>
                                                              @foreach($product_list as $lists)
                                                                  <option value="{{ $lists['id'] }}">{{ $lists['name'] }}</option>
                                                              @endforeach
                                                          @endif
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="form-group row">
                                                  <div class="col-md-4 col-lg-2">
                                                      <label for="size" class="block">Color</label>
                                                  </div>
                                                  <div class="col-md-8 col-lg-10">
                                                      <select class="product" name="color_id" id="color_id">
                                                          <option>--Select Color--</option>
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="form-group row">
                                                  <div class="col-md-4 col-lg-2">
                                                      <label for="size" class="block">Size</label>
                                                  </div>
                                                  <div class="col-md-8 col-lg-10">
                                                      <select class="product" name="size_id" id="size_id">
                                                          <option>--Select Size--</option>
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="form-group row">
                                                  <div class="col-md-4 col-lg-2">
                                                      <label for="slug" class="block">Stock available</label>
                                                  </div>
                                                  <div class="col-md-8 col-lg-10">
                                                      <input type="text" class="form-control" readonly id="stock" value="">
                                                  </div>
                                              </div>

                                              <div id="product-unavailable">
                                                  <div class="form-group row">
                                                      <div class="col-md-4 col-lg-2">
                                                          <label for="slug" class="block">Price per piece</label>
                                                      </div>
                                                      <div class="col-md-8 col-lg-10">
                                                          <input type="text" class="form-control" id="selling_price" readonly value="">
                                                      </div>
                                                  </div>

                                                  <div class="form-group row">
                                                      <div class="col-md-4 col-lg-2">
                                                          <label for="slug" class="block">Sales quantity</label>
                                                      </div>
                                                      <div class="col-md-8 col-lg-10">
                                                          <input type="text" class="form-control" id="sales_quantity" name="quantity" value="">
                                                      </div>
                                                  </div>

                                                  <div class="form-group row">
                                                      <div class="col-md-4 col-lg-2">
                                                          <label for="slug" class="block">Price</label>
                                                      </div>
                                                      <div class="col-md-8 col-lg-10">
                                                          <input type="text" class="form-control" id="price" readonly name="price" value="">
                                                      </div>
                                                  </div>

                                                  <div class="discount-row">
                                                      <div class="form-group row">
                                                          <div class="col-md-4 col-lg-2">
                                                              <label for="discount" class="block">Discount</label>
                                                          </div>
                                                          <div class="col-md-8 col-lg-10">
                                                              <input type="text" class="form-control" id="discount" readonly name="discount" value="">
                                                          </div>
                                                      </div>

                                                      <div class="form-group row">
                                                          <div class="col-md-4 col-lg-2">
                                                              <label for="slug" class="block">Discounted price</label>
                                                          </div>
                                                          <div class="col-md-8 col-lg-10">
                                                              <input type="text" class="form-control" id="discounted_price" readonly name="price" value="">
                                                          </div>
                                                      </div>
                                                  </div>

                                                  <div class="form-group row">
                                                      <div class="col-md-4 col-lg-2">
                                                          <label for="slug" class="block">Method of payment</label>
                                                      </div>
                                                      <div class="col-md-8 col-lg-10">
                                                          <select class="form-control" name="payment_method" id="payment_method">
                                                              <option>--Select Payment Method--</option>
                                                              @if(!empty($methods))
                                                                  @foreach($methods as $methodList)
                                                                      <option value="{{ $methodList->id }}">{{ $methodList->name }}</option>
                                                                  @endforeach
                                                              @endif
                                                          </select>
                                                      </div>
                                                  </div>

                                                  <div class="form-group row">
                                                      <div class="col-md-4 col-lg-2">
                                                          <label for="slug" class="block">Payment Account</label>
                                                      </div>
                                                      <div class="col-md-8 col-lg-10">
                                                          <select class="form-control" id="account_id" name="account_id">
                                                              <option>--Select Account--</option>
                                                          </select>
                                                      </div>
                                                  </div>

                                                  <div class="form-group row">
                                                      <div class="col-md-4 col-lg-2">
                                                          <label for="slug" class="block">Sales date</label>
                                                      </div>
                                                      <div class="col-md-8 col-lg-10">
                                                          <input type="datetime-local" class="form-control" name="sales_date">
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
</div>
@endsection @section('scripts')
<script>
    $('.discount-row').fadeOut();
    $('#reload').fadeOut();
    $(document).ready(function() {
        $('.product').select2();
    });
    $('#product_id').on('change', function(){
        var product_id = $('#product_id').val();
        $.ajax({
        method: "POST",
        url: "/admin/product-available-color/"+product_id,
        data: {_token: "{{ csrf_token() }}", _method:"POST"},
        success: function(response){
            $.each(response, function(key, value) {
                $('#color_id').append('<option value="'+response[key]['id']+'">'+response[key]['name']+'</option>');
            });
            $('#color_id').on('change', function(){
            let color_id = $('#color_id').val();
                $.ajax({
                    method: "POST",
                    url: "/admin/product-available-size/"+product_id,
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
                                product_id: product_id
                            },
                            success: function(response) {
                                if(response[0]['stock'] > 0){
                                  $('#stock').val(response[0]['stock']);
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
