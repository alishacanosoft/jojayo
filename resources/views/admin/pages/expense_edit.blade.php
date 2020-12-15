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
                                    <h4>Update detail</h4>
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
                                    <h5>Expense detail</h5>
                                    <div class="card-header-right">
                                        <i class="icofont icofont-rounded-down"></i>
                                    </div>
                                </div>
                                <div class="card-block">
                                    {{ Form::open(['url'=>route('expense_update', $product_size_data->id), 'class'=>'form', 'id'=>'expense_update', 'files'=>true,'method'=>'patch']) }}
                                    <div class="form-group row">
                                        <div class="col-md-4 col-lg-2">
                                            <label for="name" class="block">Product Name </label>
                                        </div>
                                        <div class="col-md-8 col-lg-10">
                                            <input name="name" type="text" readonly class="required form-control" id="name" value="{{ @$product_data->name }}"> @if($errors->has('name'))
                                            <span class='validation-errors text-danger'>{{ $errors->first('name') }}</span> @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-4 col-lg-2">
                                            <label for="name" class="block">Total Amount </label>
                                        </div>
                                        <div class="col-md-8 col-lg-10">
                                            <input name="total_amount" type="text" readonly class="required form-control" id="total" value="{{ @$product_size_data->total_amount }}"> @if($errors->has('name'))
                                            <span class='validation-errors text-danger'>{{ $errors->first('name') }}</span> @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-4 col-lg-2">
                                            <label for="name" class="block">Paid Amount </label>
                                        </div>
                                        <div class="col-md-8 col-lg-10">
                                            <input name="amount_paid" type="text" class="required form-control" id="paid" value="{{ @$product_size_data->amount_paid }}"> @if($errors->has('name'))
                                            <span class='validation-errors text-danger'>{{ $errors->first('name') }}</span> @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-4 col-lg-2">
                                            <label for="name" class="block">Remaining Amount </label>
                                        </div>
                                        <div class="col-md-8 col-lg-10">
                                            <input name="credit" type="text" readonly class="required form-control" id="remaining" value="{{ @$product_size_data->credit }}"> @if($errors->has('name'))
                                            <span class='validation-errors text-danger'>{{ $errors->first('name') }}</span> @endif
                                        </div>
                                    </div>

                                    <div class="row text-right mb-10">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary" name="product_id" value="{{ @$product_size_data->product_id }}">Update</button>
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
</div>
@endsection
@section('scripts')
<script>
    $("#paid").keyup(function (){
        let Total = $('#total').val();
        let Paid = $('#paid').val();
        document.getElementById("remaining").value = Total - Paid;
    });
</script>
@endsection
