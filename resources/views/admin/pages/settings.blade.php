@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-sm-12">
            <div class="panel panel-custom ">
               <header class="panel-heading">Sensitive Information</header>
               <div class="panel-body">
                  @if(!empty($data))
                  {{ Form::open(['url'=>route('settings.update', $data->id), 'class'=>'form', 'id'=>'settings_update', 'files'=>true,'method'=>'patch']) }}
                  @else
                  <form action="{{ route('settings.store') }}" method="POST">
                     @endif
                     @csrf
                    <div class="form-group row">
                       <div class="col-sm-12">
                          <label><strong>Website Title</strong></label>
                          <input type="text" class="form-control" value="{{ @$data->web_title }}" name="web_title" id="web_title" placeholder="Enter the website title">
                           @if ($errors->has('web_title'))
                              <span class="validation-errors text-danger">{{ $errors->first('web_title') }}</span>
                           @endif
                       </div>
                    </div>
                    <div class="form-group row">
                       <div class="col-sm-12">
                          <label><strong>Meta Keywords</strong></label>
                          <textarea class="form-control" name="keywords" rows="5" style="resize:none">{{ @$data->keywords }}</textarea>
                          @if ($errors->has('keywords'))
                              <span class="validation-errors text-danger">{{ $errors->first('keywords') }}</span>
                           @endif
                       </div>
                    </div>
                    <div class="form-group row">
                       <div class="col-sm-12">
                          <label><strong>Meta Description</strong></label>
                          <textarea class="form-control" name="meta_description" rows="5" style="resize:none">{{ @$data->meta_description }}</textarea>
                          @if ($errors->has('meta_description'))
                              <span class="validation-errors text-danger">{{ $errors->first('meta_description') }}</span>
                           @endif
                       </div>
                    </div>
                    <div class="form-group row">
                       <div class="col-sm-6">
                          <label><strong>Company name</strong></label>
                          <input type="text" class="form-control" name="company" value="{{ @$data->company }}">
                          @if ($errors->has('company'))
                              <span class="validation-errors text-danger">{{ $errors->first('company') }}</span>
                           @endif
                       </div>
                       <div class="col-sm-6">
                          <label><strong>Registration No.</strong></label>
                          <input type="text" class="form-control" name="registration" value="{{ @$data->registration }}">
                          @if ($errors->has('registration'))
                              <span class="validation-errors text-danger">{{ $errors->first('registration') }}</span>
                           @endif
                       </div>
                    </div>
                    <div class="form-group row">
                       <div class="col-sm-6">
                          <label><strong>VAT number</strong></label>
                          <input type="text" class="form-control" name="vat" value="{{ @$data->vat }}">
                          @if ($errors->has('vat'))
                              <span class="validation-errors text-danger">{{ $errors->first('vat') }}</span>
                           @endif
                       </div>
                       <div class="col-sm-6">
                          <label><strong>PO.BOX No.</strong></label>
                          <input type="text" class="form-control" name="pobox" value="{{ @$data->pobox }}">
                          @if ($errors->has('pobox'))
                              <span class="validation-errors text-danger">{{ $errors->first('pobox') }}</span>
                           @endif
                       </div>
                    </div>
                    <div class="form-group row">
                       <div class="col-sm-6">
                          <label><strong>Facebook URL</strong></label>
                          <input type="text" class="form-control" name="facebook" value="{{ @$data->facebook }}">
                          @if ($errors->has('facebook'))
                              <span class="validation-errors text-danger">{{ $errors->first('facebook') }}</span>
                           @endif
                       </div>
                       <div class="col-sm-6">
                          <label><strong>Twitter URL</strong></label>
                          <input type="text" class="form-control" name="twitter" value="{{ @$data->twitter }}">
                          @if ($errors->has('twitter'))
                              <span class="validation-errors text-danger">{{ $errors->first('twitter') }}</span>
                           @endif
                       </div>
                    </div>
                    <div class="form-group row">
                       <div class="col-sm-6">
                          <label><strong>Linkedin URL</strong></label>
                          <input type="text" class="form-control" name="linkedin" value="{{ @$data->linkedin }}">
                          @if ($errors->has('linkedin'))
                              <span class="validation-errors text-danger">{{ $errors->first('linkedin') }}</span>
                           @endif
                       </div>
                       <div class="col-sm-6">
                          <label><strong>Instagram URL</strong></label>
                          <input type="text" class="form-control" name="instagram" value="{{ @$data->instagram }}">
                          @if ($errors->has('instagram'))
                              <span class="validation-errors text-danger">{{ $errors->first('instagram') }}</span>
                           @endif
                       </div>
                    </div>
                    <div class="form-group row">
                       <div class="col-sm-6">
                          <label><strong>YouTube URL</strong></label>
                          <input type="text" class="form-control" name="youtube" value="{{ @$data->youtube }}">
                          @if ($errors->has('youtube'))
                              <span class="validation-errors text-danger">{{ $errors->first('youtube') }}</span>
                           @endif
                       </div>
                       <div class="col-sm-6">
                          <label><strong>Primary Landline</strong></label>
                          <input type="text" class="form-control" name="landline" value="{{ @$data->landline }}">
                          @if ($errors->has('landline'))
                              <span class="validation-errors text-danger">{{ $errors->first('landline') }}</span>
                           @endif
                       </div>
                    </div>
                    <div class="form-group row">
                       <div class="col-sm-6">
                          <label><strong>Landline 1</strong></label>
                          <input type="text" class="form-control" name="landline1" value="{{ @$data->landline1 }}">
                          @if ($errors->has('landline1'))
                              <span class="validation-errors text-danger">{{ $errors->first('landline1') }}</span>
                           @endif
                       </div>
                       <div class="col-sm-6">
                          <label><strong>Landline 2</strong></label>
                          <input type="text" class="form-control" name="landline2" value="{{ @$data->landline2 }}">
                          @if ($errors->has('landline2'))
                              <span class="validation-errors text-danger">{{ $errors->first('landline2') }}</span>
                           @endif
                       </div>
                    </div>
                    <div class="form-group row">
                       <div class="col-sm-6">
                          <label><strong>Primary mobile</strong></label>
                          <input type="text" class="form-control" name="mobile" value="{{ @$data->mobile }}">
                          @if ($errors->has('mobile'))
                              <span class="validation-errors text-danger">{{ $errors->first('mobile') }}</span>
                           @endif
                       </div>
                       <div class="col-sm-6">
                          <label><strong>Mobile 1</strong></label>
                          <input type="text" class="form-control" name="mobile1" value="{{ @$data->mobile1 }}">
                          @if ($errors->has('mobile1'))
                              <span class="validation-errors text-danger">{{ $errors->first('mobile1') }}</span>
                           @endif
                       </div>
                    </div>
                    <div class="form-group row">
                       <div class="col-sm-6">
                          <label><strong>Primary email</strong></label>
                          <input type="text" class="form-control" name="email" value="{{ @$data->email }}">
                          @if ($errors->has('email'))
                              <span class="validation-errors text-danger">{{ $errors->first('email') }}</span>
                           @endif
                       </div>
                       <div class="col-sm-6">
                          <label><strong>Secondary email</strong></label>
                          <input type="text" class="form-control" name="email1" value="{{ @$data->email1 }}">
                          @if ($errors->has('email1'))
                              <span class="validation-errors text-danger">{{ $errors->first('email1') }}</span>
                           @endif
                       </div>
                    </div>
                    <div class="form-group row">
                       <div class="col-sm-6">
                          <label><strong>Location</strong></label>
                          <textarea name="location" rows="5" class="form-control" style="resize:none">{{ @$data->location }}</textarea>
                          @if ($errors->has('location'))
                              <span class="validation-errors text-danger">{{ $errors->first('location') }}</span>
                           @endif
                       </div>
                       <div class="col-sm-6">
                          <label><strong>Location on map</strong></label>
                          <textarea name="map" rows="5" class="form-control" style="resize:none">{{ @$data->map }}</textarea>
                          @if ($errors->has('map'))
                              <span class="validation-errors text-danger">{{ $errors->first('map') }}</span>
                           @endif
                       </div>
                    </div>
                    <div class="form-group row">
                       <div class="col-sm-12">
                          <label><strong>Google Analytics</strong></label>
                          <textarea name="g_analytics" rows="5" class="form-control" style="resize:none">{{ @$data->g_analytics }}</textarea>
                          @if ($errors->has('g_analytics'))
                              <span class="validation-errors text-danger">{{ $errors->first('g_analytics') }}</span>
                           @endif
                       </div>
                    </div>
                    <div class="form-group">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 210px;">
                            @php
                            $image = "http://placehold.it/350x260";
                            if(!empty($data->logo)){
                                $image = $data->logo;
                            }
                            @endphp
                                <input type="hidden" id="thumbnail">
                                <img src="{{ $image }}" id="thumbnailholder" alt="Please Connect Your Internet">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="width: 210px;"></div>
                            <div>
                            <span class="btn btn-default btn-file">
                                <span class="fileinput-new">
                                    <a href="{{ url('/vendor/filemanager/dialog.php?type=4&field_id=thumbnail&descending=1&sort_by=date&lang=undefined&akey=061e0de5b8d667cbb7548b551420eb821075e7a6') }}" class="btn iframe-btn btn-primary" type="button">
                                        <i class="fa fa-picture-o"></i> Choose
                                    </a>
                                    <input type="hidden" name="logo" id="thumbnailthumbnail" value="{{ $image }}">
                                    <span class="fileinput-exists">Change</span>
                                </span>
                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </span>
                            </div>
                            <div id="valid_msg" style="color: #e11221"></div>
                        </div>
                        @if ($errors->has('image'))
                        <div class="col-lg-3">
                            <span class="validation-errors text-danger">{{ $errors->first('image') }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="form-group row">
                       <label class="col-sm-2"></label>
                       <div class="col-sm-10">
                          <button type="submit" class="btn btn-primary m-b-0 pull-right ml-2">Save</button>
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