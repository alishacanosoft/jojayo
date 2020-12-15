<?php

namespace App\Http\Controllers;

use App\Models\Esewa;
use App\Models\Order;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Models\AddressBook;
use App\Models\Area;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaced;
use App\Models\ProductOrder;
use Session;

/**
 * Class EsewaController
 * @package App\Http\Controllers
 */
class EsewaController extends Controller
{
    protected $order = null;
    
    public function __construct(Order $order){
        $this->order = $order;
    }

    public function checkout(Request $request)
    {
        $order = Order::findOrFail(mt_rand(1, 20));

        return view('frontend.esewa.checkout');
    }

    public function success(Request $request){
        return view('frontend.esewa.success');
    }

    /**
     * @param $order_id
     * @param Request $request
     */
    public function payment(Request $request)
    {
        $cart = Cart::content()->groupBy('id');
        $total_amount = str_replace(',','',Cart::total());
        $total_amount = str_replace('.00','',$total_amount);
        $total_amount = $total_amount + 20;
        $gateway = with(new Esewa);
        $url = 'JOJAYO-'.str_pad(time() + 1, 8, "0", STR_PAD_LEFT);
        $request->session()->put('address',$request->address);
        $request->session()->put('delivery_method',$request->delivery_method);
        $gateway = with(new Esewa);
        try {
            $response = $gateway->purchase([
                'amount' => $total_amount,
                'totalAmount' => $total_amount,
                'productCode' => $url,
                'failedUrl' => $gateway->getFailedUrl($url),
                'returnUrl' => $gateway->getReturnUrl($url),
                'merchantCode' => 'epay_payment',
            ], $request);

        } catch (Exception $e) {
            return redirect()
                ->route('checkout.payment.esewa.failed', [$url])
                ->with('message', sprintf("Your payment failed with error: %s", $e->getMessage()));
        }

        if ($response->isRedirect()) {
            $response->redirect();
        }

        return redirect()->back()->with([
            'message' => "We're unable to process your payment at the moment, please try again !",
        ]);
    }

    /**
     * @param $order_id
     * @param Request $request
     */
    public function completed($order_id, Request $request)
    {
        $gateway = with(new Esewa);
        $response = $gateway->verifyPayment([
            'amount' => $gateway->formatAmount($request->get('amt')),
            'referenceNumber' => $request->get('refId'),
            'productCode' => $request->get('oid'),
        ], $request);
        if ($response->isSuccessful()) {
        $address_key = $request->session()->get('address');
        $delivery_method = $request->session()->get('delivery_method');
        $address_bbok = AddressBook::where('id', $address_key)->first();
        $charge = Area::where('id', $address_bbok->area)->first();
        $data['total_amount'] = Cart::total();
        if($request->delivery_method == 'express'){              
            $data['total_amount'] = Cart::total() + $charge->express_charge;
        }
        $data['delivery_type'] = $delivery_method == 'express' ? $delivery_method : 'normal';
        $data['address_book_id'] = $address_key;
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
            Session::forget('address');
            Session::forget('delivery_method');
            $order_data['order_data'] = Order::with('address_detail')->where('id', $order_id)->first();
            $type = $order_data['order_data']->delivery_type == 'normal' ? 'delivery_charge' : 'express_charge';
            $order_data['shipping'] = Area::where('id', $order_data['order_data']->address_detail->area)->pluck($type)->first();
            $order_data['products'] = ProductOrder::with('products','userDetail')->where('order_id', $order_id)->get();
            //Mail::to(auth()->user()->email)->send(new OrderPlaced($order_data));
            Mail::to('lenna.incognitech@gmail.com')->send(new OrderPlaced($order_data));
            $order_detail = ProductOrder::with('products')->where('order_id', $order_id)->get();
            return view('frontend.esewa.success', compact('message', 'order_detail', 'order_id'));
        }
        return redirect()->route('checkout.payment.esewa')->with([
            'message' => 'Thank you for your shopping, However, the payment has been declined.',
        ]);
    }
    }

    /**
     * @param $order_id
     * @param Request $request
     */
    public function failed($order_id, Request $request)
    {
        $order = Order::findOrFail($order_id);

        return view('frontend.esewa.checkout', compact('order'));
    }
}
