@extends('frontend.layouts.master')
@section('styles')
<link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

@endsection
@section('content')
<div class="ps-page--simple">
      <div class="ps-breadcrumb">
        <div class="container">
          <ul class="breadcrumb">
            <li><a href="{{url('/')}}">Home</a></li>
            <li><a href="{{url('/shop')}}">Shop</a></li>
            <li> Order Tracking</li>
          </ul>
        </div>
      </div>
      <div class="ps-order-tracking">
        <div class="container">
          <div class="ps-section__header">
            <h3>Order Tracking</h3>
            <p>To track your order please enter your Order ID in the box below and press the "Track Order" button.</p>
          </div>
          <div class="ps-section__content">
            <form class="ps-form--order-tracking" action="#" method="get">
              <div class="form-group">
                <label>Order ID</label>
                <input class="form-control" type="text" name="orderid" placeholder="Enter Your Order ID"/>
              </div>
              <div class="form-group">
                <button class="ps-btn ps-btn--fullwidth">Track Your Order</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="container order-details-container">

          <div class="container order-not-found">
              <div class="ps-section__content"><img src="{{asset('/frontend/images/order-not-found.png')}}" alt="jojayo-404-order-not-found">
                <h3>Opps! Order Not Found</h3>
              
          </div>
          </div>

          <div class="ps-section__header order-tracking">
            <h3>Your Order Details</h3>
          </div>

          <div class="ps-section__header order-number">
                  <h5>Order ID Goes Here</h5>
          </div>


          <div class="container">
              <div class="row order-detail">
                          
                  <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                      <div class="tcontent-left">
                          <p>Order Placed</p>
                          <p class="order-detail-date">Dec 22, 2020 15:49</p>
                          <hr class="break-line">
                          <p>Indrachowk</p>
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
                          <p>Estimated delivery</p>
                          <p class="order-detail-date">Estimated delivery within 2 days </p>
                          <hr class="break-line">
                          <p>itahari</p>
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
                        <th>Date/Time</th>
                        <th>Activity</th>
                        <th>Location</th>
                        <th>Remarks</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Nov 4, 2020</td>
                        <td>Order Placed</td>
                        <td>Kathmandu</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Nov 5, 2020</td>
                        <td>Order Confirmed</td>
                        <td>Kathmandu</td>
                        <td>Done</td>
                      </tr>
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
                            <td>A747KTH201222P104</td>
                          </tr>
                          <tr> 
                            <th>Weight</th>
                            <td>2 KG</td>
                          </tr>
                          <tr> 
                            <th>Product Price</th>
                            <td>NPR 3000</td>
                          </tr>
                        </thead>
                      
                      </table>
                    </div>
                  </div>

                  <div class="col">
                    <div class="table-responsive">
                      <table class="table shipment ps-table ps-table--vendor">
                        <thead>
                          <tr> 
                            <th>Dimension</th>
                            <td>200 * 14</td>
                          </tr>
                          <tr> 
                            <th>Payment Type</th>
                            <td>Cash On Delivery</td>
                          </tr>
                          <tr> 
                            <th>Mode of Delivery</th>
                            <td>Regular Delivery</td>
                          </tr>
                        </thead>
                      
                      </table>
                    </div>
                  </div>

                </div>
              </div>
            </div>

        </div>
      </div>



</div>
@endsection