<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sales;
use App\Models\Region;
use App\Models\ProductSize;
use App\Models\Product;
use App\Models\Payment;

class SalesController extends Controller
{

    protected $sales = null;
    protected $product_sizes = null;
    protected $products = null;
    protected $payments = null;
    protected $region = null;

    public function __construct(Sales $sales, ProductSize $product_sizes, Product $products, Payment $payments, Region $region){
        $this->sales = $sales;
        $this->product_sizes = $product_sizes;
        $this->products = $products;
        $this->payments = $payments;
        $this->region = $region;
        //$this->authorizeResource(Sales::class, 'sales');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales_list = $this->sales->get();
        $methods = $this->payments->get();
        $product_list = $this->products->get();
        $all_region = $this->region->get();
        $active_tab = 'manage';
        return view('admin.pages.sales', compact('sales_list', 'active_tab','product_list', 'methods','all_region'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_list = $this->products->get();
        $sales_list = $this->sales->get();
        $methods = $this->payments->get();
        $active_tab = 'create';
        $all_region = $this->region->get();
        return view('admin.pages.sales', compact('product_list','methods', 'sales_list', 'active_tab','all_region'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->sales->getRules();
        $request->validate($rules);
        $data = $request->all();
        $data['product_id'] = $request->product_id;
        $data['user_id'] = Auth::user()->id;
        $data['size_id'] = $request->size_id;
        $data['price'] = $request->price;
        $data['discount'] = $request->discount;
        $data['quantity'] = $request->quantity;
        $data['sales_date'] = $request->sales_date;
        $data['purchased_by'] = $request->purchased_by;
        $data['contact'] = $request->contact;
        $data['area_id'] = $request->area_id;
        $data['delivery_address'] = $request->delivery_address;
        $data['remarks'] = $request->remarks;
        $data['status'] = $request->status;
        $this->sales->fill($data);
        $status = $this->sales->save();
        if($status){
            $added_sales = $this->product_sizes->where('product_id', $request->product_id)->where('size_id', $request->size_id)->first();
            $prev_stock = $added_sales->stock;
            if($added_sales){
                $added_sales->stock = $prev_stock - $request->quantity;
                $added_sales->save();
            }
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Sales added successfully.'
            );
        } else {
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Sorry! Sales could not be added at this moment.'
            );
        }
        return redirect()->route('sales.index')->with($notification);
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
        $data = $this->sales->where('slug', $slug)->first();
        if(!$data){
            request()->session()->flash('error','Brand Not found');
            return redirect()->route('brands.index');
        }
        return view('admin.pages.add_sales', compact('data'));
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
        $this->sales = $this->sales->find($id);
        if(!$this->sales) {
            request()->session()->flash('error','Sales not found');
            return redirect()->back();
        }
        $rules = $this->sales->getRules('update');
        $request->validate($rules);
        $data = $request->all();
        $this->sales->fill($data);
        $success = $this->sales->save();
        if($success){
            $request->session()->flash('success','Sales updated successfully.');
        } else {
            $request->session()->flash('error','Problem while updating sales.');
        }
        return redirect()->route('sales.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->sales = $this->sales->find($id);
        if(!$this->sales){
            request()->session()->flash('error','Sales Not found');
            return redirect()->route('products.index');
        }

        $success = $this->sales->delete();
        if($success){
            request()->session()->flash('success','Sales deleted successfully.');
        } else {
            request()->session()->flash('error','Sorry! Sales could not be deleted at this moment.');
        }
        return redirect()->route('sales.index');
    }
}
