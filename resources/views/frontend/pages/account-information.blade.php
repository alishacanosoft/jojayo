@extends('frontend.layouts.master')
@section('styles')
<style>
    .form-control{
        height:40px;
    }
    #account-chage-pass{
        display:none;
    }
    .ps-checkbox{
        margin:0 0 15px 0;
    }
</style>

<style>
     /****** CODE ******/

    
    .file-upload .file-select {
        display: block;
        border: 2px solid #dce4ec;
        color: #34495e;
        cursor: pointer;
        height: 42px;
        line-height: 40px;
        text-align: left;
        background: #ffffff;
        overflow: hidden;
        position: relative;
    }
    .file-upload .file-select .file-select-button {
        background: #dce4ec;
        padding: 0 10px;
        display: inline-block;
        height: 40px;
        line-height: 40px;
    }
    .file-upload .file-select .file-select-name {
        line-height: 40px;
        display: inline-block;
        padding: 0 10px;
    }
    .file-upload .file-select:hover {
        border-color: #34495ee8;
        transition: all 0.2s ease-in-out;
        -moz-transition: all 0.2s ease-in-out;
        -webkit-transition: all 0.2s ease-in-out;
        -o-transition: all 0.2s ease-in-out;
    }
    .file-upload .file-select:hover .file-select-button {
        background: #34495ee8;
        color: #ffffff;
        transition: all 0.2s ease-in-out;
        -moz-transition: all 0.2s ease-in-out;
        -webkit-transition: all 0.2s ease-in-out;
        -o-transition: all 0.2s ease-in-out;
    }
    .file-upload.active .file-select {
        border-color: #8aabda;
        transition: all 0.2s ease-in-out;
        -moz-transition: all 0.2s ease-in-out;
        -webkit-transition: all 0.2s ease-in-out;
        -o-transition: all 0.2s ease-in-out;
    }
    .file-upload.active .file-select .file-select-button {
        background: #8aabda;
        color: #ffffff;
        transition: all 0.2s ease-in-out;
        -moz-transition: all 0.2s ease-in-out;
        -webkit-transition: all 0.2s ease-in-out;
        -o-transition: all 0.2s ease-in-out;
    }
    .file-upload .file-select input[type="file"] {
        z-index: 100;
        cursor: pointer;
        position: absolute;
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        filter: alpha(opacity=0);
    }
    .file-upload .file-select.file-select-disabled {
        opacity: 0.65;
    }
    .file-upload .file-select.file-select-disabled:hover {
        display: block;
        border: 2px solid #dce4ec;
        color: #34495e;
        cursor: pointer;
        height: 40px;
        line-height: 40px;
        margin-top: 5px;
        text-align: left;
        background: #ffffff;
        overflow: hidden;
        position: relative;
    }
    .file-upload .file-select.file-select-disabled:hover .file-select-button {
        background: #dce4ec;
        color: #666666;
        padding: 0 10px;
        display: inline-block;
        height: 40px;
        line-height: 40px;
    }
    .file-upload .file-select.file-select-disabled:hover .file-select-name {
        line-height: 40px;
        display: inline-block;
        padding: 0 10px;
    }
</style>
@endsection


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
                    <form class="ps-form--account-setting" method="POST" action="{{ route('update_user', Auth::user()->id) }}" accept-charset="UTF-8"  id="address_update" enctype="multipart/form-data">
                        <input name="_method" type="hidden" value="PATCH">
                        @csrf 
                            <div class="ps-form__header">
                            <h3> User Information</h3>
                            </div>
                        <div class="ps-form__content">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" value="{{ Auth::user()->name }}" class="form-control" placeholder="Please enter your name..." name="name" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" value="{{ Auth::user()->contact }}" class="form-control" placeholder="Please enter phone number..." name="contact" required>

                                    </div>
                                </div>

                            </div>


                            <div class="row">
                            
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Email</label>
                                <input type="email" value="{{ Auth::user()->email }}" placeholder="Please enter your email..." class="form-control"  name="email" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group file-upload">
                                    <label>Profile Image</label>
                                    <div class="file-select">
                                        <div class="file-select-button" id="fileName">Choose</div>
                                        <div class="file-select-name" id="noFile">Customer Profile...</div>
                                        <input type="file" name="image" id="chooseFile">
                                        @if ($errors->has('image'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('image') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-sm-6">
                                <div class="form-group">
                                <label>Birthday</label>
                                <input class="form-control" type="text" name="birthday" placeholder="Please enter your birthday...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                    <option value="3">Other</option>
                                </select>
                                </div>
                            </div> -->

                            <div class="col-sm-6">
                                <div class="form-group"> 
                                    <div class="ps-checkbox">
                                        <input class="form-control" type="checkbox" name="change_password" id="change-pass-checkbox">
                                        <label for="change-pass-checkbox">Change the current Password</label>
                                    </div>
                                </div>
                            </div>
                            </div>

                            <span id="account-chage-pass">
                            
                            <div div class="row">
                            <div class="col-sm-6">
                                <div class="form-group required-field">
                                    <label for="acc-pass2">Current Password</label>
                                    <input type="password" class="form-control" id="acc-pass2" name="old_password">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group required-field">
                                    <label for="acc-pass3">New Password</label>
                                    <input type="password" class="form-control" id="acc-pass3" name="password">
                                </div>
                            </div>
                        
                            </div>
                        </span>

                            <div class="required text-right text-danger">* Required Field</div>

                        </div>
                        
                        <div class="form-group submit">
                            <button type="submit" class="ps-btn">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
</main>
@endsection
@section('scripts')
<script>
    $('#change-pass-checkbox').on('click', function(){
        $('#account-chage-pass').toggle();
        
    });
</script>
@endsection



 