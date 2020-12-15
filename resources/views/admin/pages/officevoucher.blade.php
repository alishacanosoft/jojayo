@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
       <div class="row">
         <div class="col-sm-12">
            <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
                  <li class="@if($active_tab == 'manage') active @endif"><a href="#manage" data-toggle="tab">All Vouchers</a></li>
                  <li class="@if($active_tab == 'create') active @endif"><a href="#create" data-toggle="tab">New Voucher</a></li>
                  <input type="hidden" id="base" value="{{ route('ajax.categories') }}">
               </ul>

               <div class="tab-content bg-white">
                  <div class="tab-pane @if($active_tab == 'manage') active @endif" id="manage">
                    {{--for filters--}}
                          <span class="btn btn-link-inline text-primary btn-filter collapsed" type="button" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
                              <i class="fa fa-sliders"></i>
                              <span>Show Filter</span><p>Hide Filter</p>
                          </span>
                      <div class="collapse table-responsive " id="collapseFilter">
                          <div class="card card-body">
                            {{--start--}}
                              <div class="row">
                                  <div class="col-md-12">
                                      <!-- left column -->
                                      <div class="box box-primary">
                                          {!! Form::open(['route' => 'ajaxRequest.getmonthPdf','method'=>'post',"id"=>"pdfdownloadForm","target"=>""]) !!}
                                          <div class="box-body">
                                              <div class="row">
                                                  <div class="input-daterange">
                                                      <div class="col-xs-2">
                                                          <div class="input-container">
                                                              <input class="input-field" id="start" type="text" placeholder="Start date" name="start" required>
                                                              <i class="fa fa-calendar icon"></i>
                                                          </div>
                                                      </div>
                                                      <div class="col-xs-2">
                                                          <div class="input-container">
                                                              <input class="input-field" type="text" id="end" placeholder="End date" name="end" required>
                                                              <i class="fa fa-calendar icon"></i>
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <div class="col-xs-2">
                                                      <div class="input-container">
                                                          <select name="categoryheader_id" id="categoryheader_id" class="input-field">
                                                              <option value="">Expense Category</option>
                                                              @if(!empty($categories))
                                                                  @foreach($categories as $categoryList)
                                                                      <option value="{{ $categoryList->id }}" @if($categoryList->id == @$data->category_id) selected @endif>{{ $categoryList->name }}</option>
                                                                  @endforeach
                                                              @endif
                                                          </select>
                                                      </div>
                                                  </div>
                                                  <div class="col-xs-2">
                                                      <div class="input-container">
                                                            <button type="button" id="filter" name="filter" class="btn btn-primary m-b-0 m-r-5 filter-btn" value="active"> Search </button>
                                                            <button type="button" id="refresh" name="refresh" class="btn btn-info m-b-0 m-r-5 filter-btn" value="active"> Refresh </button>
                                                            <button type="submit" id="getallPdf" name="getallPdf" class="btn btn-purple m-b-0 m-r-5 filter-btn" value="active"> Generate PDF </button>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      {!! Form::close() !!}
                                      </div>
                                  </div>
                              </div>
                            {{--end--}}
                          </div>
                      </div>
                      <br/>
                      {{--for filters--}}
                     <div class="table-responsive">
                     <table class="table table-striped table-bordered nowrap dataTable" role="grid"
                            id="voucherdata" aria-describedby="basic-col-reorder_info">
                        <thead>
                            <tr>
                                <th class="sorting_disabled"><input type="checkbox" id="all"></th>
                                <th>Voucer Number</th>
                                <th>Voucher for</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Voucher date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        {{-- Tbody loads via ajax--}}
                     </table>
                     </div>
                  </div>
                   <div class="tab-pane @if($active_tab == 'create') active @endif" id="create">
                       @if(!empty($data))
                           {{ Form::open(['url'=>route('office_voucher.update', $data->id), 'class'=>'form-horizontal', 'id'=>'voucher_add','method'=>'PUT']) }}
                       @else
                           <form action="{{ route('office_voucher.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                               @csrf
                               @endif
                               <div class="row">
                                   <div class="col-sm-12">
                                       <div class="form-group">
                                           <label class="col-sm-2 control-label"><strong>Name</strong> <span class="text-danger">*</span></label>
                                           <div class="col-sm-8">
                                               <input type="hidden" class="form-control" value="{{ @$data->voucherid }}" name="voucherid" id="voucherid">
                                               <select name="category_id" id="category_id" class="form-control">
                                                   <option value="">Select Expense Category</option>
                                                   @if(!empty($categories))
                                                       @foreach($categories as $categoryList)
                                                           <option value="{{ $categoryList->id }}" @if($categoryList->id == @$data->category_id) selected @endif>{{ $categoryList->name }}</option>
                                                       @endforeach
                                                   @endif
                                               </select>
                                               @if($errors->has('category_id'))
                                                   <span class='validation-errors text-danger'>Please select the category for input</span>
                                               @endif
                                           </div>
                                       </div>
                                       <div class="form-group">
                                           <label class="col-sm-2 control-label"><strong>Price</strong> <span class="text-danger">*</span></label>
                                           <div class="col-sm-8">
                                               <input type="text" class="form-control" value="{{ @$data->price }}" name="price" id="price" placeholder="Enter the Expense Price">
                                               @if($errors->has('price'))
                                                   <span class='validation-errors text-danger'>{{ $errors->first('price') }}</span>
                                               @endif
                                           </div>
                                       </div>
                                       <div class="form-group">
                                           <label class="col-sm-2 control-label"><strong>Expense Description</strong> <span class="text-danger">*</span></label>
                                           <div class="col-sm-8">
                                               <textarea class="form-control editor" value="{{ @$data->description }}" name="description" id="description"> {{ old('description', @$data->description) }}</textarea>
                                               @if($errors->has('description'))
                                                   <span class='validation-errors text-danger'>{{ $errors->first('description') }}</span>
                                               @endif
                                               <span class="hint">Provide necessary Description for the purchase such as: <br/>
                                               for stationary items: pencil 10pcs -cost Rs120, paper 2bundle - cost Rs 310
                                               </span>
                                           </div>
                                       </div>
                                       <div class="form-group">
                                           <label class="col-sm-2 control-label"><strong>Expense Narrative</strong> <span class="text-danger">*</span></label>
                                           <div class="col-sm-8">
                                               <textarea class="form-control editor" value="{{ @$data->narrative }}" name="narrative" id="narrative"> {{ old('narrative', @$data->narrative) }}</textarea>
                                               @if($errors->has('narrative'))
                                                   <span class='validation-errors text-danger'>{{ $errors->first('narrative') }}</span>
                                               @endif
                                               <span class="hint">Provide necessary expense narrative for purchase such as: <br/>
                                               Bought 2 bundles of paper for the printer from Hamro stationary.
                                               </span>
                                           </div>
                                       </div>
                                       <div class="form-group">
                                           <label class="col-sm-2 control-label"><strong>Voucher Date</strong> <span class="text-danger">*</span></label>
                                           <div class="col-sm-8">
                                               <input type="text" class="form-control datepicker" value="{{ @$data->created_at }}" name="created_at" id="created_at" placeholder="Enter the Expense voucher date">
                                               @if($errors->has('created_at'))
                                                   <span class='validation-errors text-danger'>{{ $errors->first('created_at') }}</span>
                                               @endif
                                           </div>
                                       </div>
                                       <div class="form-group">
                                           <label class="col-sm-2 control-label"></label>
                                           <div class="col-sm-8">
                                               <button type="submit" id="add" class="btn btn-primary m-b-0 m-r-5" name="status" value="active">
                                                   {{ (!empty($data)) ? ' Update Voucher' : ' Add Voucher' }}
                                               </button>
                                               <button type="reset" id="discard" class="btn btn-danger m-r-15" name="status" value="inactive">Discard</button>
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
    <script type="text/javascript">$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('.input-daterange').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                calendarWeeks: true,
                clearBtn: true,
                disableTouchKeyboard: true,
            });
        });


        load_data();
        function load_data(start , end , cat ) {
            $(document).ready(function () {
                $.extend($.fn.dataTable.defaults, {
                    columnDefs: [
                        { orderable: false, targets: '_all' }
                    ],
                    'dom': 'lBfrtip',
                    buttons: [
                        {
                            extend: 'print',
                            text: "<i class='fa fa-print'> </i>",
                            className: 'btn btn-danger btn-xs ml mr',
                        },
                        {
                            extend: 'excel',
                            text: '<i class="fa fa-file-excel-o"> </i>',
                            className: 'btn btn-purple mr btn-xs',
                        },
                        {
                            extend: 'csv',
                            text: '<i class="fa fa-file-excel-o"> </i>',
                            className: 'btn btn-primary mr btn-xs',
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="fa fa-file-pdf-o"> </i>',
                            className: 'btn btn-info mr btn-xs',
                        },
                        {
                            text: "Bulk Delete",
                            className: 'btn btn-danger bulk-delete btn-xs mr',
                            action: function ( e, dt, node, config ) {
                                var ids = [];
                                var count = '';
                                var url = $('#base').val();
                                $.each($("input[name='delete_items']:checked"), function(){
                                    ids.push($(this).val());
                                });
                                count = ids.length;
                                if(confirm("You are about to delete "+count+" record(s). This cannot be undone. Are you sure?"))
                                {
                                    var before = ids;
                                    ids = ids.toString();
                                    $.ajax(
                                        {
                                            method: "POST",
                                            url: url,
                                            dataType: 'json',
                                            data: { _token:"{{ csrf_token() }}", _method:"DELETE", ids: ids},
                                            success: function (response)
                                            {
                                                $.each(before, function(key, value){
                                                    $('#'+value).remove();
                                                });
                                                toastr.success(response);
                                            }
                                        });
                                }
                            }
                        }

                    ],
                });
                // DataTable
                $('#voucherdata').DataTable({
                    processing: true,
                    paging: true,
                    serverSide: true,
                    ajax: {
                        url: "{{route('ajaxRequest.post')}}",
                        data: {start:start,end:end,cat:cat}
                    },
                    columns: [
                        {data: 'id', name:'id'},
                        {data: 'voucherid', name:'voucherid'},
                        {data: 'category_id', name:'category_id'},
                        {data: 'price', name:'price'},
                        {data: 'description', name:'description'},
                        {data: 'created_at', name:'created_at'},
                        {data: 'action', name:'action'},
                    ],
                    "lengthMenu": [[5, 10, 50, 100, -1], [5, 10, 50, 100, "All"]],
                });
            });
        }


        $("#filter").click(function(e){
            e.preventDefault();
            var start = $("input[name=start]").val();
            var end = $("input[name=end]").val();
            var cat = $("select[name=categoryheader_id]").val();
            if(start !== '' && end !=='' && cat !==''){
                $('#voucherdata').DataTable().destroy();
                load_data(start,end,cat);
            }else if(start !== '' && end !=='') {
                $('#voucherdata').DataTable().destroy();
                load_data(start,end);
            }else{
                alert("Please select the date fields to filter data");
            }
        });

        $('#refresh').click(function(){
            $('#start').val('');
            $('#end').val('');
            $('#categoryheader_id').val('');
            $('#voucherdata').DataTable().destroy();
            load_data();
        });

        $(document).ready(function(){
            $('#pdfdownloadForm input[name="end"]').blur(function(){
                if(!$(this).val()){
                    $('#pdfdownloadForm').attr("target","_blank");
                } else{
                    $('#pdfdownloadForm').attr("target","");
                }
            });
        });
    </script>
@endsection
