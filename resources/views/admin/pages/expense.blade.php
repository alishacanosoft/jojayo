@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-sm-12">
            <div class="panel panel-custom ">
                <header class="panel-heading">Purchase Detail</header>
                <div class="panel-body">
                    <table id="exporter-table" class="datatable_action display table table-striped table-bordered dataTable" role="grid" aria-describedby="basic-col-reorder_info">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Supplier</th>
                                <th>Purchased Qty</th>
                                <th>Total Amount</th>
                                <th>Paid Amount</th>
                                <th>Purchased Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($allProducts)) 
                            @foreach($allProducts as $productLists)
                            @php
                            $purchase_quantity = \App\Models\ProductSize::where('product_id', $productLists->id)->sum('quantity');
                            $price_data = \App\Models\ProductExpense::where('product_id', $productLists->id)->first();//dd($price_data);
                            @endphp
                            <tr>
                                <td style="max-width:200px"><a href="{{ route('expense_edit', $productLists->id) }}" style="margin-right: 5px">
                                        {{ $productLists->name }}
                                    </a>
                                </td>
                                <td>{{ @$productLists->VendorName->company }}</td>
                                <td>{{ $purchase_quantity }}</td>
                                <td>{{ $price_data['total_amount'] }}</td>
                                <td>{{ $price_data['amount_paid'] }}</td>
                                <td>{{ date('d/m/Y', strtotime($productLists->created_at)) }}</td>
                            </tr>
                            @endforeach @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
