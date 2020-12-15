<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Gloudemans\Shoppingcart\Facades\Cart;

class ConnectIpsController extends Controller
{
    public function payment()
    {
        $cart = Cart::content()->groupBy('id');
        $total_amount = str_replace(',', '', Cart::total());
        $total_amount = str_replace('.00', '', $total_amount);
        $total_amount = $total_amount + 20;

        $connect_ips = [
            'MERCHANTID' => 487,
            'APPID' => 'MER-487-APP-1',
            'APPNAME' => 'Jojayo',
            'TXNID' => 'TXN-' . time(),
            'TXNDATE' => date('d-m-Y'),
            'TXNCRNCY' => 'NPR',
            'TXNAMT' => $total_amount,
            'REFERENCEID' => 'REF-' . time(),
            'REMARKS' => 'RMK-' . time(),
            'PARTICULARS' => 1,
            'TOKEN' => 'TOKEN'
        ];
        
        $userid = auth()->user()->id;
        $created_at = $updated_at = Carbon::now();
        DB::table('transaction_detail')->insert(
            ['reference_id' => $connect_ips['REFERENCEID'], 'txnamt' => $total_amount, 'user_id' => $userid, 'created_at' => $created_at, 'updated_at' => $updated_at]
        );
        $token = $this->generateToken($connect_ips);
        $connect_ips['TOKEN'] = $token;
        $data = $connect_ips;
        return view('frontend.connectips.login', compact('data'));
    }

    // public function success(Request $request)
    // {
    //     $http = new Client();
    //     $data = [
    //         'MERCHANTID' => 487,
    //         'APPID' => 'MER-487-APP-1',
    //         'REFERENCEID' => 'REF-1606445378',
    //         'TXNAMT' => '2020',
    //         'TOKEN' => 'TOKEN'
    //     ];
    //     $token = $this->generateToken($data);
    //     $response = $http->post('https://uat.connectips.com:443/api/creditor/validatetxn', [
    //         'form_params' => [
    //             'MERCHANTID' => 487,
    //             'APPID' => 'MER-487-APP-1',
    //             'REFERENCEID' => 'REF-1606445378',
    //             'TXNAMT' => '2020',
    //             'TOKEN' => $token
    //         ],
    //     ]);
    //     dd($response->getBody());
    //     dd($request->all());
    // }

    public function success()
    {

        // $http = new Client();
        // $data = [
        //     'MERCHANTID' => 487,
        //     'APPID' => 'MER-487-APP-1',
        //     'REFERENCEID' => 'REF-1606445378',
        //     'TXNAMT' => '2020',
        //     'TOKEN' => 'TOKEN'
        // ];
        // $token = $this->ips($data);

        // $data['TOKEN'] = $token;
        // return view('success', compact('data'));


        $user = auth()->user();
        $address = $user->addressBook->where('default', 1)->first();

        if (count((array)$address) == 0)
            $address = $user->addressBook->where('default', 0)->first();
        $total_amt = 0;
        $data = [];
        foreach (Cart::content() as $row) {
            $total_amt += ($row->qty * $row->price);
            $data[] = [
                'product_id' => $row->id,
                'color_id' => $row->options->color_id,
                'size_id' => $row->options->size_id,
                'user_id' => auth()->user()->id,
                'price' => $row->price,
                'quantity' => $row->qty,
            ];
        }
        $order = $user->orders()->create([
            'order_no' => getOrderId(),
            'total_amount' => $total_amt,
            'address_book_id' => $address->id,
            'area_id' => $address->area,
            'status' => 'no_action',
        ]);
        if (count($data) > 0) {
            $order->product_orders()->createMany($data);
        }
        $message = "Thank you for your shopping, Your recent payment was successful.";
        Cart::destroy();
        return view('frontend.connectips.success', compact('message', 'order'));


        $response = $http->post('https://uat.connectips.com:443/api/creditor/validatetxn', [
            'form_params' => [
                'MERCHANTID' => 487,
                'APPID' => 'MER-487-APP-1',
                'REFERENCEID' => 'REF-1606445378',
                'TXNAMT' => '2020',
                'TOKEN' => $token
            ],
        ], false);
        dd($response->getBody());
    }

    public function failed()
    {
        echo 'something went wrong please try again';
    }
    
    
    private function generateToken($data){
        $string = '';
        foreach ($data as $key => $val) {
            $string .= $key . '=' . $val . ',';
        }
        $string = rtrim($string, ',');

        $pfxCertPrivate = base_path('key/CREDITOR.pfx');
        $cert_password  = '123';

        // Try to locate certificate file
        if (!$cert_store = file_get_contents($pfxCertPrivate)) {
            echo "Something went wrong.\n";
            exit;
        }

        // Try to read certificate file
        if (openssl_pkcs12_read($cert_store, $cert_info, "123")) {
            if ($private_key = openssl_pkey_get_private($cert_info['pkey'])) {
                $array = openssl_pkey_get_details($private_key);
            }
        } else {
            echo "Error: Something Wend wrong.\n";
            exit;
        }
        $base64 = "";
        if (openssl_sign($string, $signature, $private_key, "sha256WithRSAEncryption")) {
            $base64 = base64_encode($signature);
            openssl_free_key($private_key);
        } else {
            echo "Error: Unable sign";
            exit;
        }
        return $base64;
    }
}
