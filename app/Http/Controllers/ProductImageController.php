<?php

namespace App\Http\Controllers;

use App\Models\productImages;
use DB;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{

    protected $product_images = null;

    public function __construct(productImages $product_images){
        $this->product_images = $product_images;
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
        //
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

    public function destroyProductImages(Request $request){
        $users_to_delete = $this->product_images->where('product_id', $request->id)->get()-> toArray();
        $ids_to_delete = array_map(function($item) {
            return $item['id'];
        }, $users_to_delete);
        $status = DB::table('product_images')->whereIn('id', $ids_to_delete)->delete();
        if($status){
            return response()->json('Product image deleted');
        }
    }
}
