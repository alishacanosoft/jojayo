<?php

namespace App\Http\Controllers;

use App\Models\ProductSize;
use DB;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{

    protected $product_sizes = null;

    public function __construct(ProductSize $product_sizes)
    {
        $this->product_sizes = $product_sizes;
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

    public function destroyProductSizes(Request $request)
    {
        $users_to_delete = $this->product_sizes->where('product_id', $request->id)->get()->toArray();
        $ids_to_delete = array_map(function ($item) {
            return $item['id'];
        }, $users_to_delete);
        $status = DB::table('product_sizes')->whereIn('id', $ids_to_delete)->delete();
        if ($status) {
            return response()->json('Product size deleted');
        }
    }

    public function GetAvailableSize(Request $request, $id)
    {
        $size_data = $this->product_sizes->select('size_id', 'color_id')->where('product_id', $id)->where('color_id', $request->color_id)->where('status', 1)->get()->toArray();
        $sizename = [];
        if (!empty($size_data)) {
            foreach ($size_data as $key => $data) {
                $getname = \App\Models\Size::where('id', $data['size_id'])->first();
                $sizename[$key]['id'] = $getname['id'];
                $sizename[$key]['color_id'] = $data['color_id'];
                $sizename[$key]['name'] = $getname['name'];
            }
        }
        return response()->json($sizename);
    }

    public function GetAvailableColor($id)
    {
        $color_data = $this->product_sizes->select('color_id')->where('product_id', $id)->groupBy('color_id')->get()->toArray();
        if (!empty($color_data)) {
            $colorname = [];
            foreach ($color_data as $key => $data) {
                $getname = \App\Models\Color::where('id', $data['color_id'])->first();
                $colorname[$key]['id'] = $getname->id;
                $colorname[$key]['name'] = $getname->name;
            }
        }
        return response()->json($colorname);
    }

    public function getstock(Request $request)
    {
        $stock = $this->product_sizes->select('stock', 'selling_price', 'discount')->where('product_id', $request->product_id)->where('size_id', $request->size_id)->where('color_id', $request->color_id)->get();
        return response()->json($stock);
    }

    public function ProductAvailSize(Request $request){
        $product_sizes = $this->product_sizes->with(['colorInfo','sizeInfo'])->where('product_id', $request->id)->groupBy('size_id')->get();
        return response()->json($product_sizes);
    }
}
