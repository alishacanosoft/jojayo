@extends('admin.layouts.master')
@section('styles')
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css"
        rel="stylesheet" />
    <style>
        .slow .toggle-group {
            transition: left 0.7s;
            -webkit-transition: left 0.7s;
        }

        .toggle,
        .toggle.ios,
        .toggle-on.ios,
        .toggle-off.ios {
            border-radius: 20rem;
        }

        .toggle,
        .toggle.ios .toggle-handle {
            border-radius: 20rem;
        }

        .editable-address {
            display: block;
            margin-bottom: 5px;
        }

        .editable-address span {
            width: 70px;
            display: inline-block;
        }

    </style>
@endsection
@section('content')
<div class="col sm-12">
    <div class="panel panel-custom">
        <header class="panel-heading">Deleted Products</header>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered datatable_action" role="grid"
                                        aria-describedby="basic-col-reorder_info">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Brand</th>
                                                <th>Trashed At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $product)
                                                {{-- @can('view', $productLists)
                                                --}}
                                                <tr>
                                                    <td style="max-width:550px">{{ @$product->product->name }}</td>
                                                    <td style="max-width:100px">{{ @$product->product->category->name }}</td>
                                                    <td>{{ @$product->product->brand->name }}</td>
                                                    <td>{{ $product->deleted_at->diffForHumans() }}</td>
                                                    <td>
                                                        <a href="{{ route('products.show', $product->id) }}"
                                                            class="btn btn-primary btn-xs pull-left" style="margin-right: 5px">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a class="pull-left"
                                                            onclick="return confirm('Are you sure you want to restore this product?')">
                                                            <form method="POST" action="{{ route('products.restore', $product->id) }}"
                                                                accept-charset="UTF-8">
                                                                <input name="_method" type="hidden" value="PATCH">
                                                                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                                                <button class="btn btn-danger btn-xs" type="submit"><i
                                                                        class="fa fa-repeat"></i></button>
                                                            </form>
                                                        </a>
                                                    </td>
                                                </tr>
                                                {{-- @endcan --}}
                                            @endforeach
                                        </tbody>
                                    </table>
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
@endsection
