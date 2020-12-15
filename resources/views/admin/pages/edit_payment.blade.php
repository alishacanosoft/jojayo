@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-sm-12">
            <div class="panel panel-custom ">
                <header class="panel-heading">Edit payment method</header>
                <div class="panel-body">
                    {{ Form::open(['url'=>route('payments.update', $data->id), 'class'=>'form-horizontal', 'id'=>'update_payment', 'files'=>true,'method'=>'patch']) }}
                    @if(!empty($data))
                        <div class="form-group">
                            <div class="row">
                                <label class="col-lg-2 control-label"><strong>Name</strong> <span class="text-danger">*</span></label>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    <input class="form-control" type="text" value="{{ $data->name }}" name="name" required="" id="name">
                                    <span class="hint">The name is how it appears on your site.</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-lg-2 control-label"></label>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    <input type="submit" name="submit" value="Save Changes" class="btn btn-success" id="submit">
                                </div>
                            </div>                            
                        </div>
                    @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
