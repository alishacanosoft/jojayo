<?php

namespace App\Http\Controllers;

use App\Mail\OrderDelivered;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaced;
use App\Mail\OrderShipped;
use App\Models\Order;
use App\Models\AddressBook;
use App\Models\ProductOrder;
use App\Models\Area;
use App\Models\Region;
use App\Models\Color;
use App\Models\Vendor;
use App\Models\Size;
use App\Models\ProductImages;
use App\Models\Image;
use App\Models\User;
use App\Models\City;
use App\Models\Statement;
use Carbon\Carbon;
use App\Service\SparrowService;

class OrderController extends Controller
{
    protected $order = null;
    protected $area = null;
    protected $address_book = null;

    public function __construct(Order $order, Area $area, AddressBook $address_book){
        $this->order = $order;
        $this->area = $area;
        $this->address_book = $address_book;
    }

    public function index()
    {
        $active_tab = 'manage';
        if(\Auth::user()->roles == 'admin'){
            $all_orders = $this->order->orderBy('created_at', 'desc')->get();
        } else {
            $vendor_id = Vendor::where('user_id', \Auth::user()->id)->pluck('id')->first();
            $all_orders = Order::with(['vendor_products' => function($query) use ($vendor_id) {
                $query->whereHas('products', function ($query) use ($vendor_id) {
                    $query->where('vendor_id', $vendor_id);
                });
            }])->first();
        }
        $verified_orders = $this->order->where('status', 'verified')->get();
        $packed_orders = $this->order->where('status', 'packed')->get();
        $shipped_orders = $this->order->where('status', 'shipped')->get();
        $delivered_orders = $this->order->where('status', 'delivered')->get();
        return view('admin.pages.orders', compact('active_tab','all_orders','verified_orders','packed_orders','shipped_orders','delivered_orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $address_bbok = $this->address_book->where('id', $request->address)->first();
        $charge = $this->area->where('id', $address_bbok->area)->first();
        $data['total_amount'] = Cart::total();
        if($request->delivery_method == 'express'){              
            $data['total_amount'] = Cart::total() + $charge->express_charge;
        }
        $data['delivery_type'] = $request->delivery_method ? $request->delivery_method : 'normal';
        $data['address_book_id'] = $request->address;
        $data['status'] = 'no_action';
        $data['user_id'] = auth()->user()->id;
        $data['order_no'] = getOrderId();
        $this->order->fill($data);
        $status = $this->order->save();
        $order_id = $this->order->id;
        if($status){
            foreach(Cart::content() as $row){
                $order_table = new ProductOrder();
                $data['product_id'] = $row->id;
                $data['color_id'] = $row->options->color_id;
                $data['size_id'] = $row->options->size_id;
                $data['user_id'] = auth()->user()->id;
                $data['price'] = $row->price;
                $data['discount'] = $row->discount;
                $data['quantity'] = $row->qty;
                $data['order_id'] = $this->order->id;
                $data['status'] = 'no_action';
                $order_table->fill($data);
                $order_table->save();
            }
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Order submitted successfully. Please make your payment at the time of delivery.'
            );
            Cart::destroy();            
            $order_data['order_data'] = Order::with('address_detail')->where('id', $order_id)->first();
            $type = $order_data['order_data']->delivery_type == 'normal' ? 'delivery_charge' : 'express_charge';
            $order_data['shipping'] = Area::where('id', $order_data['order_data']->address_detail->area)->pluck($type)->first();
            $order_data['products'] = ProductOrder::with('products','userDetail')->where('order_id', $order_id)->get();
            //Mail::to(auth()->user()->email)->send(new OrderPlaced($order_data));
            Mail::to('lenna.incognitech@gmail.com')->send(new OrderPlaced($order_data));
            $order_detail = ProductOrder::with('products')->where('order_id', $order_id)->get();
            return view('frontend.cod.success',compact('order_detail','notification','order_id'));           
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateStatus(Request $request){
        $time = Carbon::now();
        if(strtolower($request->status) == 'verified'){
            $action = 'verified_at';
        } elseif(strtolower($request->status) == 'packed') {
            $action = 'packed_at';
        } elseif(strtolower($request->status) == 'shipped'){
            $action = 'shipped_at'; 
        } elseif(strtolower($request->status) == 'delivered'){
            $action = 'delivered_at';
        }
        $status = $this->order->where('id', $request->id)->update(array($action => $time,'status' => strtolower($request->status)));        
        if($status){
            if($request->status == 'Shipped'){
                $order_data['order_data'] = Order::with('address_detail')->where('id', $request->id)->first();
                $type = $order_data['order_data']->delivery_type == 'normal' ? 'delivery_charge' : 'express_charge';
                $order_data['shipping'] = Area::where('id', $order_data['order_data']->address_detail->area)->pluck($type)->first();
                $order_data['products'] = ProductOrder::with('products','userDetail')->where('order_id', $request->id)->get();
                Mail::to('lenna.incognitech@gmail.com')->send(new OrderShipped($order_data));
                $notification = array(
                    'message' => 'Order status updated to Shipped.',
                    'alert_type' => 'success'
                );
                SparrowService::sendSms(['9843244368'], 'Your order with order no '.$order_data['order_data']->order_no.' for shipping');
            } elseif($request->status == 'Delivered'){
                
                $order_data['order_data'] = Order::with('address_detail')->where('id', $request->id)->first();
                $type = $order_data['order_data']->delivery_type == 'normal' ? 'delivery_charge' : 'express_charge';
                $order_data['shipping'] = Area::where('id', $order_data['order_data']->address_detail->area)->pluck($type)->first();
                $order_data['products'] = ProductOrder::with('products','userDetail')->where('order_id', $request->id)->get();
                
                $new_vendor_data = array();
                foreach($order_data['products'] as $row){
                    $new_vendor_data[] = $row->products->vendor_id;
                }
                $my_data = array_unique($new_vendor_data);
                // foreach($my_data as $row){
                    
                //     $product_trans = new Statement();
                //     $transaction_data['transaction_no'] = getTransactionId(substr(strtoupper(str_replace(' ', '', @$row->products->VendorName->company)),0, 5));
                //     // $transaction_data['order_id'] = $request->id;
                //     // $transaction_data['status'] = 'Unpaid';
                //     //$transaction_data['statement'] = $account_statement;
                //     $transaction_data['vendor_id'] = $row;
                //     $transaction_data['order_created'] = $order_data['order_data']->created_at;
                //     $product_trans->fill($transaction_data);
                //     Statement::updateOrCreate($transaction_data);
                //     //$product_trans->save();
                // }
                
                //Mail::to('lenna.incognitech@gmail.com')->send(new OrderDelivered($order_data));
                $notification = array(
                    'message' => 'Order status updated to Delivered.',
                    'alert_type' => 'success'
                );
                //SparrowService::sendSms(['9843244368'], 'Your order with order no '.$order_data['order_data']->order_no.' has been delivered!');
            } elseif($request->status == 'Packed'){
                $notification = array(
                    'message' => 'Order status updated to Packed.',
                    'alert_type' => 'success'
                );            
            } elseif($request->status == 'Verified'){
                $notification = array(
                    'message' => 'Order status updated to Verified.',
                    'alert_type' => 'success'
                );
            }
            return response()->json($notification);
        }   
        return response()->json('Success');
    }

    public function orderDetail(Request $request){
        if(!isset($request->order_no)){
            $notification = array(
                'message' => 'Order number not specified!',
                'alert-type' => 'warning'
            );
            return redirect()->route('orders.index')->with($notification);
        }
        $vendor_id = \App\Models\Vendor::where('user_id', auth()->user()->id)->pluck('id')->first();
        if(auth()->user()->roles == 'vendor'){
            $order_data = \App\Models\Order::with(['order_products' => function($query) use ($vendor_id) {
                $query->whereHas('products', function ($query) use ($vendor_id) {
                    $query->where('vendor_id', $vendor_id);
                });
            }])->where('order_no',$request->order_no)->first();
        } else {
            $order_data = $this->order->with('order_products')->where('order_no', $request->order_no)->first();
        }        
        $area_id = AddressBook::where('id', $order_data->address_book_id)->first();
        $delivery_charge = Area::where('id', $area_id->area)->first();
        $normal_charge = '';
        if($order_data->delivery_type == 'express'){
            $charge = $delivery_charge->express_charge;
        } else {
            $charge = $delivery_charge->delivery_charge;            
        }
        $normal_charge = $delivery_charge->delivery_charge;
        return view('admin.pages.order_details',compact('order_data','charge','area_id','delivery_charge','normal_charge'));
    }
    
    public function VendorOrderDetail(Request $request){
        $vendor_id = $request->vendor_id;
        $data= Order::with(['vendor_products' => function($query) use ($vendor_id) {
            $query->whereHas('products', function ($query) use ($vendor_id) {
                $query->where('vendor_id', $vendor_id);
            });
        }])->where('order_no',$request->order_no)->first();
        return view('admin.pages.vendor_order', compact('data'));
    }
    
    public function myOrders(){
        
            $records = Order::where('user_id', \Auth::user()->id);
            $data_arr = array();

            foreach ($records as $record) {
                $id = $record->id;
                $area_detail = @Area::where('id', $record->address_detail->area)->first();
                if($record->delivery_type == 'express'){
                    $deliver_charge = @$area_detail->express_charge;
                } else {
                    $deliver_charge = @$area_detail->delivery_charge;
                }
                $order_no = $record->order_no;
                $user_id = $record->user_id;
                $area_id = $record->area_id;
                $status = ucfirst(str_replace('_', ' ' ,$record->status));
                $delivery_type = $record->delivery_type;
                $total_amount = $record->total_amount;
                $created_at = $record->created_at->format('Y-m-d - H:i:s');
                $useraddress = @$record->address_detail->address;
                $region = @Region::find($record->address_detail->region_id)->name;
                $city = @City::find($record->address_detail->city)->name;
                $area = @Area::find($record->address_detail->area)->name;
                $colors = Color::all();
                $size = Size::all();
                $image_data = ProductImages::all();
                $images = Image::all();
                $order_detail = ProductOrder::with('products')->where('order_id', $id)->get();
                $data_arr[] = array(
                    "order_no" =>$order_no,
                    "user_id" => User::find($user_id)->name,
                    "user_address" => $useraddress,
                    "user_d" => $order_detail,
                    "colors" => $colors,
                    "size" => $size,
                    "image_data" => $image_data,
                    "images" => $images,
                    "user_region" => $region,
                    "user_city" => $city,
                    "user_area" => $area,
                    "area_id" =>  @Area::find($area_id)->name,
                    "delivery_type" => $delivery_type,
                    "delivery_charge" =>  $deliver_charge,
                    "total_amount" => $total_amount,
                    "status" => $status,
                    "created_at" => $created_at

                );
            }
        
        return view('frontend.pages.orders', compact('data_arr'));
    }

    public function tracking(Request $request){
        if(!isset($request->orderid)){
            $notification = array(
                'message' => 'Order number not specified!',
                'alert-type' => 'warning'
            );
            return redirect()->view('frontend.partials.tracking-not-found');
        }
        //$vendor_id = \App\Models\Vendor::where('user_id', auth()->user()->id)->pluck('id')->first();
        $order_data = $this->order->with('order_products')->where('order_no', $request->orderid)->first();
       
        $area_id = AddressBook::where('id', $order_data->address_book_id)->first();
        $delivery_charge = Area::where('id', $area_id->area)->first();
        $normal_charge = '';
        if($order_data->delivery_type == 'express'){
            $charge = $delivery_charge->express_charge;
        } else {
            $charge = $delivery_charge->delivery_charge;            
        }
        $normal_charge = $delivery_charge->delivery_charge;
        return view('frontend.partials.order-tracking', compact('order_data','delivery_charge','charge'));
    }
}