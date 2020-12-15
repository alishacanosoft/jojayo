@extends('frontend.layouts.master')
@section('styles')
<style>
    table {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  max-width: 100%;
}

table td, table th {
  border: 1px solid #ddd;
  padding: 8px !important;
  vertical-align: middle !important;
}

table tr:nth-child(even){background-color: #f2f2f2;}

table tr:hover {background-color: #ddd;}

table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #555555;
  color: white;
}
form{margin:0;}
</style>
@endsection
@section('content')
@include('frontend.layouts.front-nav')

            <h3 class="widget-title">My address(es)</h3>
            <table class="table table-striped">
              <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Region</th>
                <th>Phone</th>
                <th></th>
              </tr>
              @if(!empty($my_address))
                @foreach($my_address as $address_list)
                <tr>
                  <td>{{ $address_list->name }}</td>
                  <td>{{ $address_list->address }}</td>
                  <td>{{ $address_list->Region->name }}</td>
                  <td>{{ $address_list->phone }}</td>
                  <td>
                    <a href="{{ route('address.edit', $address_list->id) }}" class="pull-left" style="margin-right: 5px">
                        <i class="fa fa-pencil text-danger"></i>
                    </a>
                    <a onclick="return confirm('Are you sure you want to delete this address?')">
                        <form method="POST" action="{{ route('address.destroy', $address_list->id) }}" accept-charset="UTF-8">
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <button type="submit" class="address-delete" style="border:none"><i class="fa fa-trash text-danger"></i></button>
                        </form>
                    </a>
                  </td>
                </tr>
                @endforeach
              @endif
            </table>
            <div class="row text-right mt-5">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <a href="{{ route('addressList') }}" class="btn btn-primary" style="font-size:1.5rem">Add new Address</a>
              </div>
            </div>
        </div>
        @include('frontend.layouts.customer-nav')
    </div>
</div>

<div class="mb-5"></div><!-- margin -->
@endsection
