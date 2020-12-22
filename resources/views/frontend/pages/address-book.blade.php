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

                    @if(!empty($data))
                        {{ Form::open(['url'=>route('address.update', $data->id), 'class'=>'ps-form--account-setting', 'id'=>'address_update', 'files'=>true,'method'=>'patch']) }}
                    @else
                    <form class="ps-form--account-setting" action="{{ route('address.store') }}" method="POST">
                    @endif
                    @csrf

                        <div class="ps-form__header">
                        <h3> Add New Address</h3>
                        </div>

                        <div class="ps-form__content">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group required-field">
                                                <label for="acc-name">Full Name</label>
                                                <input type="text" value="{{ @$data->name }}" placeholder="Please enter your name..." class="form-control" name="name" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group required-field">
                                                <label for="region">Region</label>
                                                <select class="form-control" name="region_id" id="region_id">
                                                <option selected disabled>Please select your region</option>
                                                @if(!empty($region_data))
                                                    @foreach($region_data as $data_region)
                                                        <option value="{{ $data_region->id }}" @if(@$data->region_id == $data_region->id) selected @endif>{{ $data_region->name }}</option>
                                                    @endforeach
                                                @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group required-field">
                                                <label for="acc-name">Contact Number</label>
                                                <input type="text" value="{{ @$data->phone }}" class="form-control" placeholder="Please enter phone number..." name="phone" required>
                                                @if($errors->has('phone'))
                                                    <span class="text-danger small">{{ $errors->first('phone') }}</span><br>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group required-field">
                                                <label for="acc-name">City</label>
                                                <select class="form-control" name="city" id="city" disabled>
                                                <option selected disabled>Please select your city</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group required-field">
                                                <label for="acc-name">Address</label>
                                                <input type="text" value="{{ @$data->address }}" class="form-control" placeholder="Please enter address..." name="address" required>
                                                @if($errors->has('address'))
                                                    <span class="text-danger small">{{ $errors->first('address') }}</span><br>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group required-field">
                                                <label for="acc-name">Area</label>
                                                <select class="form-control" name="area" id="area" disabled>
                                                <option selected disabled>Please select your area</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6">
                                    <div class="row mt-1">
                                        <div class="col-md-12">
                                            <div class="form-group required-field">
                                            <input type="hidden" name="location" value="{{ @$data->location }}" id="location">
                                            @php
                                            $office_class = '';
                                            $home_class = '';
                                            if(@$data->location == 'office'){
                                                $office_class = 'location_clicked';
                                            } elseif(@$data->location == 'home'){
                                                $home_class = 'location_clicked';
                                            }
                                            @endphp
                                            <button type="button" value="office" class="location_title office mr-1 {{ $office_class }}"><span ><i class="icon-company"></i> Office</span></button>
                                            <button type="button" value="home" class="location_title home ml-1 {{ $home_class }}"><span ><i class="icon-home"></i> Home</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2"></div><!-- margin -->

                            <div class="required text-right">* Required Field</div>
                            
                            <div class="form-footer">
                                <div class="form-group submit">
                                    <button type="submit" class="ps-btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
</main>
@section('scripts')
<script type="text/javascript" src="{{ asset('frontend/js/jojayo.js') }}"></script>
<script type="text/javascript">
    let edit = "{{ @$data }}";
    let region = '';
    let city = '';
    if(edit !== ''){
      region = $('#region_id').val();
      if(region != 'undefined'){
        region = $('#region_id').val();
        $.ajax({
            method: "GET",
            url:"/get-city/"+region,
            dataType: 'json',
            success: function(response) {
                $.each(response, function(key, value) {
                  let selected_data = '';
                  if(edit != ''){
                    let city_data = "{{ @$data->region_id }}";
                    if(city_data != 'undefined'){
                      selected_data = 'selected';
                    }
                  }
                    $('#city').html('<option selected disabled>Please select your city</option>');
                    $('#city').append('<option value="'+response[key]['id']+'" '+selected_data+'>'+response[key]['name']+'</option>');
                    $('#city').removeAttr('disabled');
                });
                city = "{{ @$data->city }}";
                $.ajax({
                    method: "GET",
                    url:"/get-area/"+city,
                    dataType: 'json',
                    success: function(response) {
                        $.each(response, function(key, value) {
                          let selected_data = '';
                            if(edit != ''){
                              let area_data = "{{ @$data->area }}";
                              if(area_data != 'undefined'){
                                selected_data = 'selected';
                              }
                            }
                            $('#area').html('<option selected disabled>Please select your area</option>');
                            $('#area').append('<option value="'+response[key]['id']+'" '+selected_data+'>'+response[key]['name']+'</option>');
                            $('#area').removeAttr('disabled');
                        });

                      }
                });
            },
        });
      }
    }


  $('#region_id').on('change', function(){
    let region = $(this).val();
    $('#area').html('<option selected disabled>Please select your area</option>');
    $('#city').html('<option selected disabled>Please select your city</option>');
    $('#area').attr('disabled', true);
    $.ajax({
        method: "GET",
        url:"/get-city/"+region,
        dataType: 'json',
        success: function(response) {
            $.each(response, function(key, value) {
                $('#city').append('<option value="'+response[key]['id']+'">'+response[key]['name']+'</option>');
                $('#city').removeAttr('disabled');
            });
            $('#city').on('change', function(){
              city = $(this).val();
              $.ajax({
                  method: "GET",
                  url:"/get-area/"+city,
                  dataType: 'json',
                  success: function(response) {
                      $.each(response, function(key, value) {
                          $('#area').append('<option value="'+response[key]['id']+'">'+response[key]['name']+'</option>');
                          $('#area').removeAttr('disabled');
                      });

                    }
              });
            })
        },
    });
  })
</script>
@endsection
@endsection
