@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
        <div class="col-lg-4">
        <div class="form-group">
            <label>Name</label>
            <input class="form-control" type="text" name="name" required="" id="name">
        </div>
        <input type="submit" name="submit" value="Add New Method" class="btn btn-primary" id="submit" style="margin-bottom: 20px">
        </div>
         <div class="col-sm-8">
            <div class="panel panel-custom ">
                <header class="panel-heading">All payment methods</header>
                <div class="panel-body">
                <table id="basic-col-reorder" class="table table-striped table-bordered nowrap dataTable" role="grid" aria-describedby="basic-col-reorder_info">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="check">
                    @if(!empty($allmethods))
                        @foreach($allmethods as $key => $paymentList)
                            <tr id="{{ $paymentList->id }}">
                                <input type="hidden" value="{{ $paymentList->id }}">
                                <td>{{ $paymentList->name }}</td>
                                <td><a href="{{ route('payments.edit', $paymentList->id) }}"><button type="button" class="btn btn-primary btn-xs waves-effect waves-light" style="float: none;"><i class="fa fa-pencil-square-o"></i></button></a><button type="button" class="btn-xs btn btn-danger waves-effect waves-light table-delete" style="float: none;margin: 5px;" data-target="#sign-in-modal"><i class="fa fa-trash-o"></i></button></td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection