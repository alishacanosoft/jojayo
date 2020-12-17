<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\SecondaryCategory;
use App\Models\PrimaryCategory;
use App\Models\Product;
use App\Models\Region;
use App\Models\City;
use App\Models\Area;
use App\Models\AddressBook;
use App\Models\Page;
use App\Models\Brand;
use App\Models\CategoryBrand;
use App\Models\Size;
use App\Models\Order;
use App\Models\Slider;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\ProductImages;
use App\Models\ProductSize;
use URL;
use GuzzleHttp\Client;
use App\Service\ProductService;
use App\Service\SparrowService;
use App\Models\Vendor;
use App\Models\Statement;

class FrontController extends Controller
{

    protected $product_categories = null;
    protected $secondary_categories = null;
    protected $product = null;
    protected $product_sizes = null;
    protected $regions = null;
    protected $city = null;
    protected $page = null;
    protected $address_book = null;
    protected $category_brand = null;
    protected $brand = null;
    protected $product_image = null;
    protected $slider = null;
    protected $vendor = null;

    public function __construct(ProductSize $product_sizes, Slider $slider, ProductImages $product_image, ProductCategory $product_categories, Product $products, Region $regions, City $city, Area $area, AddressBook $address_book, Brand $brand, SecondaryCategory $secondary_categories, Page $page, CategoryBrand $category_brand, Vendor $vendor)
    {
        $this->product_categories = $product_categories;
        $this->secondary_categories = $secondary_categories;
        $this->products = $products;
        $this->product_sizes = $product_sizes;
        $this->regions = $regions;
        $this->city = $city;
        $this->page = $page;
        $this->area = $area;
        $this->category_brand = $category_brand;
        $this->brand = $brand;
        $this->address_book = $address_book;
        $this->product_image = $product_image;
        $this->slider = $slider;
        $this->vendor = $vendor;
    }

    public function index()
    {
        $latest_products = $this->products->with('colors', 'images')->orderBy('created_at', 'desc')->whereHas('colors', function ($q) {
            $q->whereNull('deleted_at')->where('status',1);
        })->take(12)->get();

        $time = '07:00:00';
        $end_time = '11:00:00';
        if (date('H') >= '11') {
            $end_time = '15:00:00';
            $time = '11:00:00';
        } elseif (date('H') >= '15') {
            $end_time = '19:00:00';
            $time = '15:00:00';
        }
        $flash = $this->product_sizes->with('product')->whereNotNull('flash_price')
            ->whereDate('from_date', '<=', date('Y-m-d'))
            ->whereTime('from_date', '<=', $time)
            //->whereDate('from_date', '>=', date('Y-m-d '))->whereTime('from_date','>=',$time)
            ->groupBy('product_id')->get();

        
        
        $men_fashion = ProductService::getProduct("Men's Fashion", 20);
        $women_fashion = ProductService::getProduct("Women's Fashion", 20); //dd($women_fashion);
        $kid_fashion = ProductService::getProduct("Kid's Fashion", 20); //dd($women_fashion);
        $available_brands = $this->brand->get();
        $all_slider = $this->slider->get();
        return view('frontend.pages.index', compact('latest_products', 'available_brands', 'women_fashion', 'kid_fashion','men_fashion', 'all_slider', 'flash', 'end_time'));
    }

    public function singleProduct($slug)
    {
        $data = $this->products->with('colors')->where('slug', $slug)->first();
        $secondary = $this->product_categories->with('Secondarycategory')->where('id', $data->category_id)->first();
        $pro_imgs = array();
        foreach ($data->images as $image) {
            foreach ($image->images as $new_img) {
                $pro_imgs[] = $new_img->image;
            }
        }
        $ids = array();
        $productId = $data->id;
        $catid = $data->category_id;
        foreach (Cart::content() as $row) {
            if ($row->id == $data->id) {
                array_push($ids, $row->rowId);
            }
        }
        $related = Product::where('category_id', '=', $catid)->where('status','verified')->with('images')
            ->where('id', '!=', $productId)
            ->take(10)->get();
        $image_id = $this->product_image->where('product_id', $data->id)->groupBy('color_id')->distinct()->get();
        return view('frontend.pages.single', compact('data', 'related', 'ids', 'image_id', 'pro_imgs','secondary'));
    }

    public function warranty(Request $request)
    {
        $data = $this->product_categories->where('id', $request->mycat)->first();
        if ($data->warranty == 1) {
            $data = "Yes";
        } else {
            $data = "No";
        }
        return response()->json($data);
    }

    public function addressBookAdd()
    {
        $region_data = $this->regions->get();
        return view('frontend.pages.address-book', compact('region_data'));
    }

    public function addressBookData()
    {
        return view('frontend.pages.address-book-data');
    }

    public function getCity(Request $request)
    {
        $data = $this->city->where('region_id', $request->id)->get();
        return response()->json($data);
    }

    public function getArea(Request $request)
    {
        $data = $this->area->where('city_id', $request->id)->get();
        return response()->json($data);
    }

    public function shipping()
    {
        $user_id = \Auth::user()->id;
        $my_location = $this->address_book->where('user_id', $user_id)->get();
        return view('frontend.pages.shipping', compact('my_location'));
    }

    public function shop(Request $request)
    {
        $requested = $this->seperateRequest();

        $all_products = $this->products->with('images', 'sizes','category')
            ->where('status', 'verified')
            ->has('sizes')
            ->sortBrand($request['selected_brands'])
            ->sortSize($request['selected_sizes'])
            ->sortPrice($request['min_price'], $request['max_price'])
            ->sortProd($request['sort'])
            ->paginate(20);

        $lastpage = $all_products->lastPage();
        if ($request->ajax()) {
            return response()->json($all_products);
        }
        $brands = $this->brand->get();
        $allcount = $this->products->count();
        return view('frontend.pages.shop', compact('all_products','allcount', 'lastpage', 'requested','brands'));
    }

    public function flash(Request $request)
    {
        $time = '07:00:00';
        $end_time = '11:00:00';
        if (date('H') >= '11') {
            $end_time = '15:00:00';
            $time = '11:00:00';
        } elseif (date('H') >= '15') {
            $end_time = '19:00:00';
            $time = '15:00:00';
        }
        $flash = ProductService::flash(date('Y-m-d'), $time);
        $three = ProductService::flash(date('Y-m-d'), '15:00:00');
        //  $three = $this->product_sizes->with('product')->whereNotNull('flash_price')
        //  ->whereDate('from_date','<=',date('Y-m-d'))
        //  ->whereTime('from_date','<=','15:00:00')
        //  comment ->whereDate('from_date', '>=', date('Y-m-d '))->whereTime('from_date','>=',$time)
        //  ->groupBy('product_id')->get();
        return view('frontend.pages.flash', compact('flash', 'three', 'end_time'));
    }

    private function seperateRequest()
    {
        $r_price = request()->has('price') ? request()->price : null;
        $min_price = 0;
        $max_price = 0;
        $sort = request()->has('sort') ? request()->sort : 'latest';

        if (isset($r_price)) {
            $splite_price = explode('-', $r_price);
            $min_price = (int)$splite_price[0];
            $max_price = (int)$splite_price[1];
        }
        $r_brands = request()->has('brands') ? request()->brands : null;
        $r_sizes = request()->has('sizes') ? request()->sizes : null;

        $selected_brands = isset($r_brands) ? $this->brand->whereIn('slug', $r_brands)->get()->pluck('id')->toArray() : [];
        $selected_sizes = isset($r_sizes) ? Size::whereIn('slug', $r_sizes)->get()->pluck('id')->toArray() : [];

        return [
            'min_price' => $min_price,
            'max_price' => $max_price,
            'selected_brands' => $selected_brands,
            'selected_sizes' => $selected_sizes,
            'sort' => $sort
        ];
    }

    public function categories($prime_slug, $slug = null, Request $request)
    {

        $requested = $this->seperateRequest();

        $category_slug = isset($slug) ? $this->product_categories->where('slug', $slug)->first() : $this->secondary_categories->where('slug', $prime_slug)->first();

        $category_product = $this->products->with('images', 'sizes', 'price', 'productCategory')
            ->when(!isset($slug), function ($q) use ($category_slug) {
                $ids = $category_slug->FinalCategory()->pluck('id')->toArray();
                return $q->whereIn('category_id', $ids);
            })
            ->when(isset($slug), function ($q) use ($category_slug) {
                return $q->where('category_id', @$category_slug->id);
            })
            ->has('sizes')
            ->sortBrand($requested['selected_brands'])
            ->sortSize($requested['selected_sizes'])
            ->sortPrice($requested['min_price'], $requested['max_price'])
            ->sortProd($requested['sort'])
            ->paginate(12);

        if ($request->ajax()) {
            return response()->json($category_product);
        }
        $lastpage = $category_product->lastPage();
        $categories = [];
        $brand_ids = [];
        $size_ids = [];


        if (!isset($slug)) {
            $array = [];
            $prod_cat = $this->product_categories->with('brands')->where('secondary_category_id', $category_slug->id)->get();
            $size_ids = $prod_cat->pluck('id')->toArray();
            foreach ($prod_cat as $brand) {
                $array = array_merge($array, $brand->brands->pluck('id')->toArray());
            }
            $brand_ids = array_unique($array);
            $categories = [
                'secondary' => false,
                'primary_slug' => $category_slug->slug,
                'cat' => $prod_cat
            ];
        } else {
            $a = $this->secondary_categories->where('slug', $prime_slug)->first();
            $prod_cat = $this->secondary_categories->where('primary_category_id', $a->primary_category_id)->get();
            $array = [];
            $get_finalCategory_ids = [];

            foreach ($prod_cat as $prod) {
                $get_finalCategory_ids = array_merge($get_finalCategory_ids, $prod->productCategories->pluck('id')->toArray());
                foreach ($prod->FinalCategory as $brand) {
                    $array = array_merge($array, $brand->brands->pluck('id')->toArray());
                }
            }
            $size_ids = array_unique($get_finalCategory_ids);
            $brand_ids = array_unique($array);

            $categories = [
                'secondary' => true,
                'primary_slug' => $a->slug,
                'cat' => $prod_cat
            ];
        };

        $brands = $this->brand->whereIn('id', $brand_ids)->get();
        $sizes = Size::whereIn('product_category_id', $size_ids)->groupBy('slug')->get();

        return view('frontend.pages.categories', compact('category_product', 'category_slug', 'categories', 'brands', 'sizes', 'requested', 'lastpage'));
        //   $category_slug = $this->product_categories->where('slug', $slug)->pluck('id')->first();
        //   $category_product = $this->products->with('images')->where('category_id', $category_slug)->paginate(12);//dd($category_product);
        //   return view('frontend.pages.categories', compact('category_product'));
    }

    
  

    public function page($slug)
    {
        $page_detail = $this->page->where('slug', $slug)->first();
        if (!$page_detail) {
            return abort(404);
        }
        return view('frontend.pages.page', compact('page_detail'));
    }

    public function eSewa()
    {
        $gateway = "esewa";
        $tAmt = "100";
        $ClientId = 'ee2c3ca1-696b-4cc5-a6be-2c40d929d453';
        date_default_timezone_set('Asia/Kathmandu');
        $date = date('y/m/d H:i:s');
        $a = str_replace("/", "", $date);
        $b = str_replace(":", "", $a);
        $c = str_replace(" ", "", $b);
        $pid = $c . "-" . $ClientId;
        $url = "";
        $base_url = URL::to('/');

        if ($gateway == "esewa") {
            $url = 'https://uat.esewa.com.np/epay/main?amt=' . $tAmt . '&pdc=0&pdc=0&psc=0&txAmt=0&tAmt=' . $tAmt . '&pid=' . $pid . '&scd=epay_payment' . '&su=' . $base_url . '/payment/esewa_success?q=su' . '&fu=' . $base_url . '/payment/esewa_failed?q=fu';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    // Set Here Your Requested Headers
                    'Content-Type: application/json',
                ),
            ));

            $response = curl_exec($curl);
            var_dump($response);
            $response = trim(strip_tags($response));
            var_dump($response);
        }
    }

    public function cartContent()
    {
        $item = Cart::content();
        return response()->json($item);
    }

    public function review()
    {
        if(\Auth::user()->roles !== 'customers'){
            return redirect('/login');
        }
        $my_address_book = $this->address_book->where('user_id', auth()->user()->id)->where('default', 1)->get();
        if(count($my_address_book) == 0){
            $notification = array(
                'alert-type' => 'warning',
                'message' => 'Please add delivery address'
            );
            return redirect('/add-address')->with($notification);
        }
        return view('frontend.pages.review', compact('my_address_book'));
    }

    public function getCategoryBrand($id)
    {
        $my_brand = $this->category_brand->with('brandDetail')->where('category_id', $id)->get();
        return response()->json($my_brand);
    }

    public function getProduct(Request $request)
    {
        $query = $request['query'];
        $category = $request['category'];
        if ($category != 'all')
            $category = $this->getCategoryFromSlug($category);
        $products = Product::where('name', 'LIKE', '%' . $query . '%')
            ->when($category != 'all', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })
            ->has('sizes')
            ->limit(20)
            ->get();
        return view('frontend.pages.search.search', compact('products'));
    }

    public function searchProduct(Request $request)
    {
        $requested = $this->seperateRequest();
        $query = $request->q;
        $category = $request->category;
        if ($category != 'all')
            $category = $this->getCategoryFromSlug($category);
        $all_products = $this->products->with('images', 'sizes')
            ->where('name', 'LIKE', '%' . $query . '%')
            ->when($category != 'all', function ($q) use ($category) {
                $q->where('category_id', $category->id);
            })
            ->where('sizes')
            ->sortBrand($request['selected_brands'])
            ->sortSize($request['selected_sizes'])
            ->sortPrice($request['min_price'], $request['max_price'])
            ->sortProd($request['sort'])
            ->paginate(12);
        $selected_category = $category == 'all' ? 'all' : $category->slug;
        return view('frontend.pages.search.index', compact('all_products', 'requested', 'selected_category', 'query'));
    }

    public function sendSms()
    {
       $http = new Client();
       $to_numbers=[9814786767];
       $message='test message';
        try {
            $response = $http->get(config('app.sparrow_url'), [
                'query' => [
                    'token' => 'cdKlsNCZZ0oSTLMMylIC',
                    'from' => 'Jojayo',
                    'to' => $to_numbers,
                    'text' => $message
                ],
                'http_errors' => false
            ]);

            return response()->json(['token' => json_decode((string) $response->getBody())]);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            return $e;
        }
        die;

        //         'query' => [
        // 				'token' => $accessToken,
        // 				'from' => $from,
        // 				'to' => $to,
        // 				'text' => $text
        // 			],
        // $http= new Client();
        // try {
        //     $params = [
        //         'query' => [
        //             'token' => 'cdKlsNCZZ0oSTLMMylIC',
        //             'from' => 'InfoSMS',
        //             'to' => '9814786767',
        //             'text' => 'test message from server'
        //       ]
        //     ];

        //     // $response = $guzzle_client->request('GET','/api.com',$params);
        //     $response = $http->request('GET','http://api.sparrowsms.com/v2/sms/',$params);
        //     dd($response->getBody());

        //     return response()->json(['token' => json_decode((string) $response->getBody(), true)]);
        // } catch (\GuzzleHttp\Exception\BadResponseException $e) {
        //     return $e;
        // }
    }
    public function ipsconnect()
    {

        $pfxCertPrivado = base_path('key/CREDITOR.pfx');
        $cert_password  = '123';
        
        if (!$cert_store = file_get_contents($pfxCertPrivado)) {
        	echo "Error: Unable to read the cert file\n";
        	exit;
        }
        
        if (openssl_pkcs12_read($cert_store, $cert_info, "123")) {
        	if($private_key = openssl_pkey_get_private($cert_info['pkey'])){
        		$array = openssl_pkey_get_details($private_key);
        	    
        	}
        } else {
        	echo "Error: Unable to read the cert store.\n";
        	exit;
        }
        
        $hash = "";
        if(openssl_sign($string, $signature , $private_key, "sha256WithRSAEncryption")){
	        $hash = base64_encode($signature);
	        openssl_free_key($private_key);
        } else {
            echo "Error: Unable openssl_sign";
            exit;
        }    
        dd($hash);

die;

        if (!file_exists($pfxCertPrivado)) {
            echo "Certificado não encontrado!! " . $pfxCertPrivado;
        }

        $pfxContent = file_get_contents($pfxCertPrivado);

        if (!openssl_pkcs12_read($pfxContent, $x509certdata, $cert_password)) {
            echo "O certificado não pode ser lido!!";
        } else {
            
            $token="MERCHANTID=487,APPID=MER-487-APP-1,APPNAME=Jojayo,TXNID=22112020,TXNDATE=22-11-2020,TXNCRNCY=NPR,TXNAMT=500,REFERENCEID=REF-22112020,REMARKS=RMKS-22112020,PARTICULARS=PART-22112020,TOKEN=TOKEN";
            $hashed = hash('sha256', $token);
            $CertPriv   = array();
            $CertPriv   = openssl_x509_parse(openssl_x509_read($x509certdata['cert']));
            // dd($x509certdata);
            $PrivateKey = $x509certdata['pkey'];
            $pub_key = openssl_pkey_get_public($x509certdata['cert']);
            $keyData = openssl_pkey_get_details($pub_key);

            $PublicKey  = $keyData['key'];

            // $sign=openssl_sign($data, $signature, $pkeyid);
            $sign = openssl_sign($hashed, $signature, $PrivateKey);
            // openssl_free_key($pfxCertPrivado);
            // dd($signature);
            $base64 = base64_encode($signature);
            echo($base64);
            die;
            return view('ipsconnect', compact('base64'));
            // dd($base64);
        }

        die;



        $pfxCertPrivado = base_path('key/CREDITOR.pfx');
        $cert_password  = '123';

        if (!file_exists($pfxCertPrivado)) {
            echo "Certificado não encontrado!! " . $pfxCertPrivado;
        }

        $pfxContent = file_get_contents($pfxCertPrivado);

        $read = openssl_pkcs12_read($pfxCertPrivado, $x509certdata, $cert_password);

        dd($read);
        // die;

        $pfxCertPrivado = base_path('key/cacert.pem');
        $certs = array();
        // $pkcs12 = file_get_contents($pfxCertPrivado);
        $pkcs12 = openssl_x509_parse($pfxCertPrivado);
        dd($pkcs12);
        dd(openssl_pkcs12_read($pkcs12, $certs, '123456789'));

        if (openssl_pkcs12_read($pkcs12, $certs, '123456789')) {

            $dados = array();
            $dados = openssl_x509_parse(openssl_x509_read($certs['cert']));

            //print_r( $dados );

            //Dados mais importantes
            echo $dados['subject']['C'] . '<br>'; //País
            echo $dados['subject']['ST'] . '<br>'; //Estado
            echo $dados['subject']['L'] . '<br>'; //Município
            echo $dados['subject']['CN'] . '<br>'; //Razão Social e CNPJ / CPF
            echo date('d/m/Y', $dados['validTo_time_t']) . '<br>'; //Validade
            echo $dados['extensions']['subjectAltName'] . '<br>';    //Emails Cadastrados separado por ,

        } else {
            dd('hi');
        }
        die;
        // dd(base_path('key/CREDITOR.pfx'));

        $hash = hash('sha256', 'jojayo.com');
        $pfxContent  = file_get_contents(base_path('key/CREDITOR.pfx'));
        if (!openssl_pkcs12_read($pfxContent, $x509certdata, $hash)) {
            echo "O certificado não pode ser lido!!";
        } else {
        }
        // $pkeyid = openssl_x509_parse(, false);
        die;
        $pkeyid = openssl_pkey_get_private(file_get_contents(base_path('key/CREDITOR.pfx')));
        if (!$pkeyid)
            var_dump(openssl_error_string());
        dd($pkeyid);
        dd($hash);
        return view('ipsconnect');
    }

    public function connectCompleted(Request $request)
    {
        echo 'complete<br>';
        dd($request->all());
    }
    public function connectFailed(Request $request)
    {
        echo 'fail<br>';
        dd($request->all());
    }
    
    public function statement(){
        $all_vendor = $this->vendor->get();
        return view('admin.pages.statement', compact('all_vendor'));
    }
    
    public function getVendorData($id){
        $data = Statement::where('vendor_id', $id)->groupBy('order_created')->get(); //dd($data);
        return view('admin.pages.ajax.date', compact('data'));
    }
    
    public function getStatement($id, $date){
        if(date('d', strtotime($date)) > 14 && date('d', strtotime($date)) <= 21){
            $end_date = date('Y-m-21',strtotime($date));
        } elseif(date('d', strtotime($date)) > 21 && date('d', strtotime($date)) <= 28){
            $end_date = date('Y-m-28',strtotime($date));
        } elseif(date('d', strtotime($date)) > 7 && date('d', strtotime($date)) <= 14){
            $end_date = date('Y-m-14',strtotime($date));
        } elseif(date('d', strtotime($date)) <= 7){
            $end_date = date('Y-m-7',strtotime($date));
        }
        $data = Statement::where('vendor_id', $id)->whereBetween('order_created', [$date, $end_date])->groupBy('order_created')->get();        
        return view('admin.pages.finance_table', compact('data','id'));        
    }

    public function printFinance(Request $request){
        $vendor_data = $this->vendor->with('user_detail')->where('id', $request->vendor_id)->first();
        $data = Statement::where('transaction_no', $request->transaction_no)->first();
        $vendor_id = $vendor_data->id;
        $order_data = \App\Models\Order::with(['vendor_products' => function($query) use ($vendor_id) {
            $query->whereHas('products', function ($query) use ($vendor_id) {
                $query->where('vendor_id', $vendor_id);
            });
        }])->where('id',$data->order_id)->get();
        return view('admin.pages.ajax.statement', compact('data','vendor_data','order_data'));
    }

    public function transaction(Request $request){
        $data = Statement::where('vendor_id', $request->vendor_id)->where('transaction_no', $request->transaction_no)->groupBy('order_created')->first();
        return view('admin.pages.transaction', compact('data'));
    }
    
    public function updateTransaction(Request $request){
        $find = Statement::where('vendor_id', $request->vendor_id)->where('transaction_no', $request->transaction_no)->groupBy('order_created')->first();
        $data['paid_amount'] = $request->paid_amount;
        $data['due_amount'] = $request->due_amount;
        $status = Statement::where('transaction_no', $request->transaction_no)->update(array('paid_amount' => $request->paid_amount, 'due_amount' => $request->due_amount, 'status' => $request->status, 'narration' => $request->narration));
        return redirect()->back();
    }

}