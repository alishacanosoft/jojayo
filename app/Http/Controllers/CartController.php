<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;
use App\Models\ProductImages;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{

    protected $products = null;

    public function __construct(Product $products, ProductImages $product_images, Image $image){
      $this->products = $products;
      $this->product_images = $product_images;
      $this->image = $image;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $my_cart = Cart::content()->groupBy('id');
        return view('frontend.pages.cart', compact('my_cart'));
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
        $product_data = $this->products->with('images')->with('sizes')->where('id', $request->id)->first();
        $price = $product_data->sizes[0]->selling_price;
        $discount = $product_data->sizes[0]->discount;
        $selected_color = $request->color_id;
        $selected_size = $request->size_id;
        $productimg = $this->product_images->where('product_id', $request->id)->first();
        $prodimage = $this->image->where('imageable_id', $productimg->id)->where('imageable_type','App\Models\ProductImages')->pluck('image')->first();
        $cart_data = Cart::add($product_data->id, $product_data->name, 1, $price, ['discount' => $discount, 'image' => $prodimage, 'slug' => $product_data->slug, 'color_id' => $selected_color, 'size_id' => $selected_size])->associate('App\Models\Product');
        return response()->json(['rowId' => $cart_data->rowId, 'message'=>'Product added to cart!']);
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

    public function cartCount(){
        $cart_count = Cart::content()->count();
        $total = Cart::total();
        return response()->json(['count' => $cart_count, 'total' => $total]);
    }

    public function updateCart($id, Request $request){
        
        $status = Cart::update($id, $request->quantity);
        if($status){
            return response()->json(['status'=>true,'data'=>'Cart updated successfully.']);
        } else {
            return response()->json(['status'=>false,'data'=>null]);
        }
    }

    public function destroy($id)
    {
        $find = Cart::get($id);
        if($find){
            $status = Cart::remove($id);
        }
        if($status == null){
            return response()->json(['status'=>true,'data'=>'Product removed successfully.']);
        } else {
            return response()->json(['status'=>false,'data'=>'Something went wrong!']);
        }
    }

    public function destroyCart()
    {
        Cart::destroy();
        return redirect()->back();
    }
}
