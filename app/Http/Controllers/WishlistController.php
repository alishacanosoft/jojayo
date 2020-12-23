<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;
use App\Models\Wishlist;
use App\Models\ProductImages;
use Gloudemans\Shoppingcart\Facades\Cart;

class WishlistController extends Controller
{

    public function __construct(Product $products, ProductImages $product_images, Image $image, Wishlist $wish){
        $this->products = $products;
        $this->product_images = $product_images;
        $this->image = $image;
        $this->wish = $wish;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $cart_data = Cart::instance('wishlist')->add($product_data->id, $product_data->name, 1, $price, ['discount' => $discount, 'image' => $prodimage, 'slug' => $product_data->slug, 'color_id' => $selected_color, 'size_id' => $selected_size])->associate('App\Models\Product');
        if(auth()->user() !== null && auth()->user()->roles == 'customers'){
            $data = array(
                'product_id' => $request->id,
                'color_id'   => $selected_color,
                'size_id'    => $selected_size,
                'user_id'    => auth()->user()->id
            );
            $this->wish->fill($data);
            $this->wish->save();
        }
        return response()->json(['rowId' => $cart_data->rowId, 'message'=>'Product added to wishlist!']);
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
    public function wishlistCount(){
        $cart_count = Cart::instance('wishlist')->content()->count();
        $total = Cart::instance('wishlist')->total();
        return response()->json(['count' => $cart_count, 'total' => $total]);
    }


    public function destroy($id)
    {
        $find = Cart::instance('wishlist')->get($id);
        // $this->wish = $this->wish->find($id);
        if($find){
            $status = Cart::instance('wishlist')->remove($id);
        }
        if($status == null){
            return response()->json(['status'=>true,'data'=>'Product removed from wishlist.']);
        } else {
            return response()->json(['status'=>false,'data'=>'Something went wrong!']);
        }
        
    }

    public function remove($id)
    {
        $this->wish = $this->wish->find($id);
        if (!$this->wish) {
            $notification = array(
                'message' => 'Product Not found.',
                'alert-type' => 'error'
            );
            return redirect()->back0
            +++0
            45;mk;()->with($notification);
        }

        $success = $this->wish->delete();
        if ($success) {
            $notification = array(
                'message' => 'Product removed from wishlist.',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Sorry! Product could not be removed at this moment.',
                'alert-type' => 'error'
            );
        }
        return redirect()->back()->with($notification);        
    }
}
