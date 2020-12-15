@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-sm-12">
            <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
                  <li class="@if($active_tab == 'manage') active @endif"><a href="#manage" data-toggle="tab">All Attributes</a></li>
                  <li class="@if($active_tab == 'create') active @endif"><a href="#create" data-toggle="tab">New Attribute</a></li>
                  <input type="hidden" id="base" value="{{ route('ajax.products') }}">
               </ul>
               <div class="tab-content bg-white">
                  <div class="tab-pane @if($active_tab == 'manage') active @endif" id="manage">
                     <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable_action" role="grid" aria-describedby="basic-col-reorder_info">
                           <thead>
                              <tr>
                                 <th><input type="checkbox" id="all"></th>
                                 <th>Attribute Name</th>
                                 <th>Field Type</th>
                                 <th>Values</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              @if(!empty($all_attribute)) 
                              @foreach($all_attribute as $attributeLists)                              
                              <tr>
                                 <td><input type="checkbox" name="delete_items" value="{{ $attributeLists->id }}"></td>
                                 <td style="max-width: 150px">{{ $attributeLists->name }}</td>
                                 <td>{{ $attributeLists->field }}</td>
                                 @php
                                 $values = array();
                                 if(!empty($attributeLists->attributeValue)){
                                    foreach($attributeLists->attributeValue as $my_val){
                                    $values[] = $my_val->value;
                                 }
                                 $my_values = implode(",", $values);
                                 }                                                
                                 @endphp
                                 <td style="max-width: 600px; overflow:hidden">{{ $my_values }}</td>
                                 <td>
                                    <a href="{{ route('attributes.edit', $attributeLists->id) }}" class="btn btn-primary btn-xs pull-left" style="margin-right: 5px">
                                    <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    <a class="pull-left" onclick="return confirm('Are you sure you want to delete this attribute?')">
                                       <form method="POST" action="{{ route('attributes.destroy', $attributeLists->id) }}" accept-charset="UTF-8">
                                          <input name="_method" type="hidden" value="DELETE">
                                          <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                          <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash-o"></i></button>
                                       </form>
                                    </a>
                                 </td>                                
                              </tr>                              
                              @endforeach @endif
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div class="tab-pane @if($active_tab == 'create') active @endif" id="create">
                     @if(empty($data))
                     <form action="{{ route('attributes.store') }}" method="POST" class="form-horizontal">
                        @csrf
                        @else
                        {{ Form::open(['url'=>route('attributes.update', $data->id), 'class'=>'form-horizontal', 'id'=>'product_update', 'files'=>true,'method'=>'patch']) }}
                        @endif
                        <div class="row">
                           <div class="col-sm-12">
                              <div class="card">
                                 <div class="card-block">
                                    <div class="row">
                                       <div class="col-12">
                                          <div class="form-group row">
                                            <label class="col-lg-3 control-label">Attribute Name <span class="text-danger">*</span></label>                                            
                                            <div class="col-md-8 col-lg-8">
                                            <input name="name" type="text" required class="form-control" id="name" value="{{ @$data->name }}">
                                            @if($errors->has('name'))
                                            <span class='validation-errors text-danger'>{{ $errors->first('name') }}</span>
                                            @endif
                                            </div>
                                          </div>
                                          <div class="form-group row">                                             
                                             <label class="col-lg-3 control-label">Attribute Slug <span class="text-danger">*</span></label>  
                                             <div class="col-md-8 col-lg-8">
                                                <input name="slug" type="text" class="form-control" id="slug" required value="{{ @$data->slug }}">
                                                @if($errors->has('slug'))
                                                <span class='validation-errors text-danger'>{{ $errors->first('slug') }}</span>
                                                @endif
                                             </div>
                                          </div>
                                          <div class="form-group row">                                             
                                             <label class="col-lg-3 control-label">Field Type <span class="text-danger">*</span></label>
                                             <div class="col-md-8 col-lg-8">
                                                <input name="field" type="radio" class="class" {{ @$data->field == 'input' ? 'checked' : '' }} required value="input">&nbsp;Input
                                                <input name="field" class="class" type="radio" {{ @$data->field == 'select' ? 'checked' : '' }} required value="select">&nbsp;Select
                                                @if($errors->has('field'))
                                                <span class='validation-errors text-danger'>{{ $errors->first('field') }}</span>
                                                @endif
                                             </div>
                                          </div>
                                          <div class="form-group row" id="show">                                             
                                             <label class="col-lg-3 control-label">Values <span class="text-danger">*</span></label>
                                             <div class="col-md-8 col-lg-8">
                                                @php
                                                $values = array();
                                                $my_values = '';
                                                if(!empty($data) && !empty($data->attributeValue)){
                                                   foreach($data->attributeValue as $my_val){
                                                   $values[] = $my_val->value;
                                                }
                                                $my_values = implode(",", $values);
                                                }
                                                @endphp
                                                <input name="value" type="text" class="form-control" id="value" required value="{{ @$my_values }}" placeholder="Insert the values separated by comma (,)">
                                                @if($errors->has('value'))
                                                <span class='validation-errors text-danger'>{{ $errors->first('value') }}</span>
                                                @endif
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                            <label class="col-lg-3 control-label"></label>
                                            <div class="col-lg-8 col-md-8">
                                                <button type="submit" class="btn btn-primary">{{ !empty($data) ? 'Update' : 'Add' }} Attribute</button>
                                                <button type="submit" class="btn btn-danger">Draft</button>
                                            </div> 
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('scripts')
<script>
let yes = "{{ @$data->field }}";
if(yes !== '' && yes == 'select'){
   $('#show').slideDown();
} else {
   $('#show').hide();
}
$('.class').on('click', function(){
   let a = $(this).val();
   if(a == 'select'){
      $('#show').slideDown();
   } else {
      $('#show').slideUp();
   }   
});
</script>
@endsection