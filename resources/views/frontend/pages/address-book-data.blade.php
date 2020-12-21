@extends('frontend.layouts.master')
@section('content')
<main class="ps-page--my-account">
            @include('frontend.layouts.front-nav')
            @include('frontend.layouts.customer-nav')
            <div class="col-lg-8">
                <div class="ps-section__right">
                @if(session()->has('success'))
                    {{frontSuccess()}}
                @elseif(session()->has('warning'))
                    {{frontWarning()}}
                @elseif(session()->has('error'))
                    {{frontError()}}
                @endif
                <h3>My address(es)</h3>

                <div class="table-responsive">
                  <table class="table ps-table ps-table--vendor">
                    <thead>
                      <tr>
                      <th>Name</th>
                      <th>Address</th>
                      <th>Region</th>
                      <th>Phone</th>
                      <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if(!empty($my_address))
                        @foreach($my_address as $address_list)
                          <tr>
                          <td>{{ $address_list->name }}</td>
                          <td>{{ $address_list->address }}</td>
                          <td>{{ $address_list->Region->name }}</td>
                          <td>{{ $address_list->phone }}</td>
                          <td class="action-address">
                            <a href="{{ route('address.edit', $address_list->id) }}" class="editbutton">
                                <i class="fa fa-pencil text-danger"></i>
                            </a>
                            <a onclick="return confirm('Are you sure you want to delete this address?')">
                                <form method="POST" action="{{ route('address.destroy', $address_list->id) }}" accept-charset="UTF-8">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                    <button type="submit" class="address-delete"><i class="fa fa-trash text-danger"></i></button>
                                </form>
                            </a>
                          </td>
                          </tr>
                        @endforeach
                        @endif
                    </tbody>
                  </table>
                </div>

          
                  <div class="row text-right mt-5">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <a href="{{ route('addressList') }}" class="btn btn-primary" style="font-size:1.5rem">Add new Address</a>
                    </div>
                  </div>


                </div>
            </div>
        </div>
    </div>
</section>
</main>
@endsection

        
