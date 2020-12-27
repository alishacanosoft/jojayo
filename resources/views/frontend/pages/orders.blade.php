@extends('frontend.layouts.master')
@section('styles')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
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
                    <h3>My Order's</h3>

                    <div class="table-responsive">
                    <table id="all-orders" class="table table-striped table-bordered  responsive" role="grid" aria-describedby="basic-col-reorder_info">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Order No</th>
                                <th>Total Amount</th>
                                <th>Order Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                    </table>
                    </div>
                    <div id="my_image" class="hidden"></div>
                </div>
            </div>
        </div>
    </div>
</section>
</main>
        
@endsection
@section('scripts')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#all-orders').DataTable();
        
    })
    
    function formats ( d ) {
        
        console.log(d);
        var inner_table = '<table class="child_row-verified  table table-striped table-bordered nowrap"><thead><tr><th>Product</th><th>Order Detail</th><th>Product Image</th></tr></thead><tbody>'
        inner_table += '' ;
        $.each(d.product_orders, function( index, value ) {            
            var color = value.color_info.name;
            var size = value.size_info.name;
            var imagename = '';   
            var return_image = ''; 
            
            var tmp ='';
            var return_first = (function () {
                var tmp = $.ajax({
                    'type': "POST",
                    'url': "get/product/size/data/"+value.color_info.id+"/"+value.products.id,                    
                    'success': function (data) {
                        tmp = data;
                        console.log(tmp);
                    }
                }).done(function(data){
                        return data;
                });
            return tmp;
            });
            imagename = '<a class="thumbnail-order" href="#thumb">' +
                        '<img src="/uploads/products/'+tmp+'" style="height:10rem;" alt=""/>' +
                        '' +
                        '</a>';
            inner_table += '<td>'+value.products.name+'</td><td>Color: '+ color +
                ' Size: '+ size + ",<br/>Quantity: "+ value.quantity
                +'</td><td style=" text-align: center;">'
                + imagename +'</td></tr>'
            ;
        });
        inner_table += '</tbody></table>';
        return inner_table;
    }
    var table = $('#all-orders').DataTable( {
            processing: true,
            paging: true,
            ajax: {
                url: "{{route('ajaxRequest.customerOrder')}}",
            },
            "columns": [
                {
                    "className": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": '',
                    "render": function () {
                        return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
                    },
                },
                { "data": "order_no" },
                { "data": "total_amount" },
                { "data": "created_at" },
                {
                    "data":"status"
                },
            ],
            "lengthMenu": [[10, -1], [10, "All"]],
        } );

        // Add event listener for opening and closing details
        $('#all-orders tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var tdi = tr.find("i.fa");
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
                tdi.first().removeClass('fa-minus-square');
                tdi.first().addClass('fa-plus-square');
            }
            else {
                // Open this row
                row.child(formats(row.data())).show();
                tr.addClass('shown');
                tdi.first().removeClass('fa-plus-square');
                tdi.first().addClass('fa-minus-square');
            }
        });

    $('#change-pass-checkbox').on('click', function(){
        $('#account-chage-pass').toggle();
    });
</script>
@endsection
