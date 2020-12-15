@extends('admin.layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
      <div class="row">
          <div class="col-sm-6 wrap-fpanel">
              <div class="panel panel-custom" data-collapsed="0">
                  <div class="panel-heading">
                      <div class="panel-title">
                          <strong>Update Profile</strong>
                      </div>
                  </div>
                  <div class="panel-body">
                      <form role="form" id="form" action="{{ route('users.update', \Auth::user()->id) }}" style="display: initial;" method="post" class="form-horizontal form-groups-bordered" enctype='multipart/form-data'>
                      <input name="_method" type="hidden" value="PATCH">
                      <input type="hidden" name="page" value="update_profile">
                      @csrf
                          <div class="form-group">
                              <label class="col-lg-4 control-label"><strong>Full Name</strong> <span class="text-danger">*</span></label>
                              <div class="col-lg-8">
                                  <input type="text" class="form-control" name="name" value="{{ $data->name }}" required="" />
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-lg-4 control-label"><strong>Email</strong> <span class="text-danger">*</span></label>
                              <div class="col-lg-8">
                                  <input type="text" class="form-control" name="email" value="{{ $data->email }}" required="" />
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-lg-4 control-label"><strong>Contact</strong></label>
                              <div class="col-lg-8">
                                  <input type="text" class="form-control" name="contact" value="{{ @$data->contact }}" />
                              </div>
                          </div>                          
                          
                        <div class="form-group row small-image">
                            <label class="col-sm-4 control-label"><strong>Image</strong></label>                                
                            <div class="col-sm-8">
                                <div class="file-upload no-dash" style="margin-left:0">
                                    <input type="file" class="files" id="files" name="image" style="opacity:1">
                                </div>
                                @if(!empty($data->image))
                                <span class="pip">
                                    <img class="imageThumb" src="{{ asset('/uploads/users/'.$data->image) }}">                      
                                </span>
                                @endif
                                @if ($errors->has('image'))
                                <div class="col-lg-12">
                                    <span class="validation-errors text-danger">{{ $errors->first('image') }}</span>
                                </div>
                                @endif
                            </div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-8">
                            <span class="hint">Upload image only if you want to change your current profile image.</span>
                            </div>
                        </div>
                          <div class="form-group">
                              <label class="col-lg-4 control-label"></label>
                              <div class="col-lg-8">
                                  <button type="submit" class="btn btn-sm btn-primary">Update Profile</button>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
          <div class="col-sm-6 wrap-fpanel">
              <div class="panel panel-custom" data-collapsed="0">
                  <div class="panel-heading">
                      <div class="panel-title">
                          <strong>Change Password</strong>
                      </div>
                  </div>
                  <div class="panel-body">
                      <form role="form" data-parsley-validate="" novalidate="" action="{{ route('users.password') }}" method="post" class="form-horizontal form-groups-bordered">
                      <input name="_method" type="hidden" value="PATCH">
                        @csrf
                          <div class="form-group">
                              <label for="field-1" class="col-sm-4 control-label">Current Password<span class="required"> *</span></label>
                              <div class="col-sm-7">
                                  <input type="password" id="current_password" name="current_password" value="" class="form-control" placeholder="Enter your current Password" data-parsley-id="10"/>
                                  @if ($errors->has('current_password'))
                                  <span class="validation-errors text-danger">{{ $errors->first('current_password') }}</span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="field-1" class="col-sm-4 control-label">New Password<span class="required"> *</span></label>
                              <div class="col-sm-7">
                                  <input type="password" name="password" id="password" value="" class="form-control" placeholder="Enter Your New Password"/>
                                  @if ($errors->has('password'))
                                  <span class="validation-errors text-danger">{{ $errors->first('password') }}</span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="field-1" class="col-sm-4 control-label">Confirm Password <span class="required"> *</span></label>
                              <div class="col-sm-7">
                                  <input type="password" id="confirm_password" name="confirm_password" value="" class="form-control" placeholder="Enter Your Confirm Password"/>
                                  @if ($errors->has('confirm_password'))
                                  <span class="validation-errors text-danger">{{ $errors->first('confirm_password') }}</span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group">
                              <div class="col-sm-offset-4 col-sm-5">
                                  <button id="old_password_button" type="submit" class="btn btn-primary">Change Password</button>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
    $("#files").change(function(){
        $('.small-image span').first().remove();
    });
</script>
@endsection
