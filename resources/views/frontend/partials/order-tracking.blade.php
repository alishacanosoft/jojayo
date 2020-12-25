<div class="container order-details-container">
    <div class="ps-section__header order-tracking">
    <h3>Your Order Details</h3>
    </div>

    <div class="ps-section__header order-number">
            <h5>{{ $order_data->order_no }}</h5>
    </div>

    <div class="container">
        <div class="row order-detail">
                    
            <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                <div class="tcontent-left">
                    <p>Order Placed</p>
                    <p class="order-detail-date">{{ date('F d, Y H:i', strtotime($order_data->created_at)) }}</p>
                    <hr class="break-line">
                    <p>{{ $delivery_charge->name }}</p>
                </div>
            </div>

            <div class="col-lg-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="tcontent-middle">
                    <div class="track">
                        <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order confirmed</span> </div>
                        <div class="step active"> <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text"> Picked by courier</span> </div>
                        <div class="step"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> On the way </span> </div>
                        <div class="step active"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Ready for pickup</span> </div>
                    </div>       
                </div>
                <div class="clearfix"></div>
                <!-- <div class="transit">
                    <h4> Order Status </h4>
                </div> -->
            </div>

            <div class="col-lg-3 col-lg-3 col-md-3 col-sm-12 col-12">
                <div class="tcontent-right">
                    <?php
                    $order_created = date('F d, Y H:i', strtotime($order_data->created_at));
                    $estimated = date('Y-m-d',strtotime($order_data->created_at));
                    $expected = date($estimated, strtotime("+3 day"));
                    $days = abs(strtotime($expected) - strtotime($estimated));
                    ?>
                    <p>Estimated delivery</p>
                    <p class="order-detail-date">Estimated delivery within {{ $days }} days </p>
                    <hr class="break-line">
                    <p>{{ $delivery_charge->City->name }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="ps-section__content">
        <div class="ps-block--vendor-dashboard">
            <div class="ps-block__header">
            <h3>Travel History</h3>
            </div>
            <div class="ps-block__content">
            <div class="table-responsive">
                <table class="table ps-table ps-table--vendor">
                <thead>
                    <tr> 
                    <th>Order Created</th>
                    <th>Status</th>
                    <th>Action taken</th>
                    </tr>
                </thead>
                <tbody>                    
                @if(!empty($order_data->verified_at))
                <tr >               
                <td>
                    {{$order_data->created_at}}
                </td>
                
                <td>                  
                    Verified
                </td>
                <td>
                    {{$order_data->verified_at}}
                </td>
                </tr> 
                @endif
                @if(!empty($order_data->packed_at))
                <tr >               
                <td>
                    {{$order_data->created_at}}
                </td>
                
                <td>                  
                    Packed
                </td>
                <td>
                    {{$order_data->packed_at}}
                </td>
                </tr> 
                @endif
                @if(!empty($order_data->shipped_at))
                <tr >               
                <td>
                    {{$order_data->created_at}}
                </td>
                
                <td>                  
                    Sent for shipping
                </td>
                <td>
                    {{$order_data->shipped_at}}
                </td>
                </tr> 
                @endif
                @if(!empty($order_data->delivered_at))
                <tr >               
                <td>
                    {{$order_data->created_at}}
                </td>
               
                <td>                  
                    Delivered
                </td>
                <td>
                    {{$order_data->delivered_at}}
                </td>
                </tr> 
                @endif  
                </tbody>
                </table>
            </div>
            </div>
        </div>

        <div class="ps-block--vendor-dashboard">
            <div class="ps-block__header">
            <h3>Shipment Facts</h3>
            </div>
            <div class="ps-block__content">
            <div class="row">
                <div class="col">
                <div class="table-responsive">
                    <table class="table shipment ps-table ps-table--vendor">
                    <thead>
                        <tr> 
                        <th>Order ID</th>
                        <td>{{ $order_data->order_no }}</td>
                        </tr>
                        
                        <tr> 
                        <th>Total Price</th>
                        <td>NPR {{ number_format($order_data->total_amount) }}.00</td>
                        </tr>
                    </thead>
                    
                    </table>
                </div>
                </div>

                <div class="col">
                <div class="table-responsive">
                    <table class="table shipment ps-table ps-table--vendor">
                    <thead>                        
                        
                        <th>Mode of Delivery</th>
                        <td>{{ ucfirst($order_data->payment_method) }}</td>
                        </tr>
                        <tr> 
                        <th>Delivery Type</th>
                        <td>{{ ucfirst($order_data->delivery_type) }} delivery</td>
                        </tr>
                        <tr>
                        <tr> 
                        <th>Delivery Charge</th>
                        <td>{{ $charge }}.00</td>
                        </tr>
                        <tr> 
                    </thead>                    
                    </table>
                </div>
                </div>

            </div>
            </div>
        </div>

    </div>
</div>