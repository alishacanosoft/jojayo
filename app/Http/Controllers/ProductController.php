<?php

namespace App\Http\Controllers;

use App\Models\CategoryBrand;
use App\Models\Brand;
use App\Models\Color;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\ProductSize;
use App\Models\SecondaryCategory;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\Size;
use App\Models\Vendor;
use App\Models\AttributeValue;
use App\Models\SimilarProduct;
use App\Models\ProductExpense;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Auth;

class ProductController extends Controller
{

    protected $product = null;
    protected $size = null;
    protected $product_size = null;
    protected $product_image = null;
    protected $brand = null;
    protected $category_brand = null;
    protected $similar_products = null;
    protected $secondary_category = null;
    protected $color = null;
    protected $product_categories = null;
    protected $vendors = null;
    protected $product_expense = null;
    protected $attribute_value = null;
    protected $product_attribute = null;

    public function __construct(Product $product, Size $size, ProductSize $product_size, productImages $product_image, Brand $brand, SecondaryCategory $secondary_category, Color $color, ProductCategory $product_categories, Vendor $vendors, ProductExpense $product_expense, CategoryBrand $category_brand, AttributeValue $attribute_value, ProductAttribute $product_attribute, SimilarProduct $similar_products)
    {
        //$this->authorizeResource(Product::class, 'product');
        $this->product = $product;
        $this->size = $size;
        $this->product_size = $product_size;
        $this->product_image = $product_image;
        $this->brand = $brand;
        $this->category_brand = $category_brand;
        $this->secondary_category = $secondary_category;
        $this->similar_products = $similar_products;
        $this->color = $color;
        $this->attribute_value = $attribute_value;
        $this->vendors = $vendors;
        $this->product_categories = $product_categories;
        $this->product_expense = $product_expense;
        $this->product_attribute = $product_attribute;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd(Auth::user());
        $active_tab = "manage";
        $product_sizes = $this->size->get();
        $brands = $this->brand->get();
        $category = $this->product_categories->get();
        $vendor_list = $this->vendors->get();
        $current_vendor = $this->vendors->with('categoryAssigned')->where('user_id', auth()->user()->id)->first();

        return view('admin.pages.products', compact( 'active_tab', 'product_sizes', 'brands', 'category', 'vendor_list', 'current_vendor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $allProducts = $this->product->get();
        $allProducts = ProductSize::orderBy(
            'created_at',
            'DESC'
        )->with('product')
            ->when(auth()->user()->roles == 'vendor', function ($query) {
                $vendor_data = $this->vendors->where('user_id', auth()->user()->id)->pluck('id')->first();
                $query->whereHas('product', function ($q) use ($vendor_data) {
                    $q->where('vendor_id', $vendor_data);
                });
            })
            ->get();
        $active_tab = "create";
        $product_sizes = $this->size->get();
        $brands = $this->brand->get();
        $category = $this->product_categories->get();
        $vendor_list = $this->vendors->get();
        $current_vendor = $this->vendors->with('categoryAssigned')->where('user_id', auth()->user()->id)->first();
        return view('admin.pages.products', compact('product_sizes', 'allProducts', 'brands', 'category', 'vendor_list', 'active_tab', 'current_vendor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->product->getRules();
        $request->validate($rules);
        $data = $request->all();
        $data['name'] = $request->name;
        $data['slug'] = $request->slug . '-' . $request->sku;
        $data['sku'] = $request->sku;
        $data['jojayo_sku'] = $request->jojayo_skusku;
        $data['description'] = $request->description;
        $data['category_id'] = $request->category_id;
        $data['brand_id'] = $request->brand_id;
        $data['vendor_id'] = $request->vendor_id;
        $data['video'] = $request->video;
        $data['status'] = $request->status;
        $this->product->fill($data);
        $status = $this->product->save();
        $product_id = $this->product->id;
        if ($status) {           
            $filtered = array_filter($request->image);
            if (!empty($filtered) && isset($filtered)) {
                for ($i = 0; $i < count($request->image);) {
                    $images = $request->image[$i];
                    $images = str_replace('"', '', $images);
                    $images = str_replace(array('[', ']'), '', $images);
                    $images = explode(',', $images);
                    for ($j = 0; $j < count($images);) {
                        $extension = pathinfo($images[$j], PATHINFO_EXTENSION);
                        $path = public_path() . '/uploads/products/';
                        $name = ucfirst('Product') . '-' . date('Ymdhis') . rand(0, 999) . "." . $extension;
                        $file_name = $path . $name;
                        $validator = Validator::make($request->only(['product_id', 'image', 'imageColor']), [
                            'image' => 'required',
                        ]);
                        if ($validator->fails()) {
                            $delete_products = $this->product->find($product_id);
                            $success = $this->product->delete();
                            return redirect()->back()->withErrors($validator)->withInput();
                        }
                        $this_image = file_put_contents($file_name, file_get_contents($images[$j]));
                        if ($this_image) {
                            $thumbnail_image = resizeImage($path, $name, $file_name, '364x364');
                        }
                        $product_image = new productImages();
                        $image_data['product_id'] = $product_id;
                        $image_data['color_id'] = $request->imageColor[$i];
                        $product_image->fill($image_data);
                        $pro_save = $product_image->save();
                        if ($pro_save) {
                            $product_image->images()->create(['image' => $name]);
                        }
                        $j++;
                    }
                    $i++;
                }
            } elseif ($request->hasFile('images')) {
                for ($j = 0; $j < count($request->images);) {
                    if ($request->images[$j] !== null) {
                        $pro_image = uploadImage($request->images[$j], 'products', '364x364');
                        $product_image = new productImages();
                        $image_data['product_id'] = $product_id;
                        $image_data['color_id'] = $request->imageColor[$j];
                        $product_image->fill($image_data);
                        $pro_save = $product_image->save();
                        if ($pro_save) {
                            $product_image->images()->create(['image' => $pro_image]);
                        }
                        $j++;
                    }
                }
            } else {
                $notification = array(
                    'message' => 'Please upload images for this product.',
                    'alert-type' => 'error'
                );
                $delete_product = $this->product->find($product_id);
                $success = $this->product->delete();
                return redirect()->back()->with($notification);
            }
            if (!empty($request->color)) {
                // $product_size = new ProductSize();
                $data = array();
                foreach ($request->color as $key => $color) {
                    $data[] = [
                        'product_id' => $product_id,
                        'size_id' => $request->size[$key],
                        'color_id' => $request->color[$key],
                        'quantity' => $request->stock[$key],
                        'stock' => $request->stock[$key],
                        'selling_price' => $request->price[$key],
                        'flash_price' => $request->flash_price[$key],
                        'from_date' => $request->from[$key],
                        'to_date' => $request->to[$key],
                        'discount' => $request->discount[$key],
                        'status' => $request->stockstatus[$key]
                    ];
                    // echo 'color=>' . $color . ', size=>' . $request->size[$key] . ', stock=>' . $request->stock[$key] . ', price=>' . $request->price[$key] . ', purchase=>' . $request->purchase[$key] . ', discount=>' . $request->discount[$key] . '<br>';
                }
                $product_seze = ProductSize::insert($data);                
            } else {
                $notification = array(
                    'message' => 'Please select sizes for this product.',
                    'alert-type' => 'error'
                );
                $delete_news = $this->product->find($product_id);
                $success = $this->product->delete();
                return redirect()->back()->with($notification);
            }
            if (!empty($request->attr)) {
                foreach ($request->attr as $key => $val) {
                    $attr_data = new ProductAttribute();
                    $attr_detail['product_id'] = $product_id;
                    $attr_detail['attribute_id'] = $key;
                    if (is_numeric($val)) {
                        $attr_detail['attribute_value_id'] = $val;
                    } else {
                        $attr_detail['attribute_value_id'] = null;
                        $attr_detail['attribute_value'] = $val;
                    }
                    $attr_data->fill($attr_detail);
                    $attr_size = $attr_data->save();
                }
            }
            if (!empty($request->similar_poducts)) {
                $simi_ids = implode(",", $request->similar_poducts);
                $simi_data = new SimilarProduct();
                $simi_detail['product_id'] = $product_id;
                $simi_detail['ids'] = $simi_ids;
                $simi_data->fill($simi_detail);
                $simi_data->save();
            }
            $notification = array(
                'message' => 'Product created successfully.',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Problem while adding product.',
                'alert-type' => 'error'
            );
        }
        return redirect()->route('products.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->product_size->with(['product' => function ($q) {
            $q->withTrashed();
        }])->withTrashed()->findOrFail($id);

        return view('admin.pages.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->product->with('my_attribute')->with('similarProductList')->find($id);
        if (!$data) {
            $notification = array(
                'message' => 'Product not found.',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        $active_tab = "create";
        $colors = $this->color->get();
        $image_data = $this->product_image->with('images')->where('product_id', $id)->groupBy('color_id')->distinct()->get()->toArray();
        $sizes = $this->product_size->with('colorInfo', 'sizeInfo')->where('product_id', $id);
        $size_data = $this->product_size->with('colorInfo', 'sizeInfo')->where('product_id', $id)->distinct()->get()->toArray();
        $selected_sizes_data = $this->product_size->with('colorInfo', 'sizeInfo')->where('product_id', $id)->groupBy('color_id')->distinct()->get()->toArray();
        $selected_sizes = array();
        foreach ($selected_sizes_data as $size) {
            $ids = $this->product_size->with('colorInfo', 'sizeInfo')->where('product_id', $id)->where('color_id', $size['color_id'])->pluck('size_id')->toArray();
            // array_push($selected_sizes,[$size['color_id'],$ids]);
            $selected_sizes[] = ['color_id' => $size['color_id'], 'size_id' => $ids];
        }
        // dd($selected_sizes);
        $product_sizes = $this->size->where('product_category_id', $data->category_id)->get();
        $category_brands = $this->category_brand->where('category_id', $data->category_id)->get();
        $category = $this->product_categories->get();
        $count = count($size_data);
        $vendor_list = $this->vendors->get();
        // $allProducts = $this->product->orderBy('created_at', 'desc')->get();
        $allProducts = ProductSize::orderBy('created_at', 'DESC')->with('product')
            ->when(auth()->user()->roles == 'vendor', function ($query) {
                $vendor_data = $this->vendors->where('user_id', auth()->user()->id)->pluck('id')->first();
                $query->whereHas('product', function ($q) use ($vendor_data) {
                    $q->where('vendor_id', $vendor_data);
                });
            })
            ->get();
        $current_vendor = $this->vendors->with('categoryAssigned')->where('user_id', auth()->user()->id)->first();
        $product_attr = $this->product_categories->with('attributes')->where('id', $data->category_id)->get();
        $my_similar_product = $this->product->where('category_id', $data->category_id)->get();
        return view('admin.pages.products', compact('category', 'category_brands', 'product_sizes','colors', 'data', 'image_data', 'size_data', 'count', 'vendor_list', 'active_tab', 'allProducts', 'current_vendor', 'product_attr', 'my_similar_product', 'selected_sizes'));
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
        // $filtered = array_filter($request->image);
        // if(!empty($filtered)){
        //     dd('not empty');
        // }
        // die();
        // dd($request->all());
        $this->product = $this->product->find($id);
        if (!$this->product) {
            $notification = array(
                'message' => 'Product not found.',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        $rules = $this->product->getRules('update');
        $request->validate($rules);
        $data = $request->all();
        $this->product->fill($data);
        $success = $this->product->save();
        $product_id = $this->product->id;
        if ($success) {
            // if (!empty($request->image)) {
            //     $del_image = $this->product_image->where('product_id', $id)->delete();
            //     for ($i = 0; $i < count($request->image);) {
            //         $images = $request->image[$i];
            //         $images = str_replace('"', '', $images);
            //         $images = str_replace(array('[', ']'), '', $images);
            //         $images = explode(',', $images);
            //         for ($j = 0; $j < count($images);) {
            //             $product_image = new productImages();
            //             $image_data['product_id'] = $product_id;
            //             $image_data['color_id'] = $request->imageColor[$i];
            //             $image_data['image'] = $images[$j];
            //             $product_image->fill($image_data);
            //             $product_image->save();
            //             $j++;
            //         }
            //         $i++;
            //     }
            // }
            $filtered = array_filter($request->image);
            if (!empty($filtered) && isset($filtered)) {
                // dd('file manager');
                $images_to_delete = $this->product_image->where('product_id', $id)->get()->toArray();
                $ids_to_delete = array_map(function ($item) {
                    return $item['id'];
                }, $images_to_delete);
                // DB::table('product_images')->whereIn('id', $ids_to_delete)->delete();
                $images = $request->image;
                $images = str_replace('"', '', $images);
                $images = str_replace(array('[', ']'), '', $images);
                $images = explode(',', $images);
                dd($images);
                for ($j = 0; $j < count($images);) {
                    $extension = pathinfo($images[$j], PATHINFO_EXTENSION);
                    $path = public_path() . '/uploads/products/';
                    $name = ucfirst('Product') . '-' . date('Ymdhis') . rand(0, 999) . "." . $extension;
                    $file_name = $path . $name;
                    $validator = Validator::make($request->only(['product_id', 'image', 'imageColor']), [
                        'image' => 'required',
                    ]);
                    if ($validator->fails()) {
                        $delete_products = $this->product->find($product_id);
                        $success = $this->product->delete();
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                    $this_image = file_put_contents(
                        $file_name,
                        file_get_contents($images[$j])
                    );
                    if ($this_image) {
                        $thumbnail_image = resizeImage($path, $name, $file_name, '900x900');
                    }
                    $product_image = new ProductImages();
                    $image_data['product_id'] = $product_id;
                    $image_data['image'] = $name;
                    $product_image->fill($image_data);
                    $pro_save = $product_image->save();
                    if ($pro_save) {
                        $product_image->images()->create(['image' => $name]);
                        // $product_image = new Image();
                        // $image_data['imageable_id'] = $product_image->id;
                        // $image_data['imageable_type'] = 'App\Models\ProductImages';
                        // $image_data['image'] = $name;
                        // $product_image->fill($image_data);
                        // $product_image->save();
                    }
                    $j++;
                }
                if (!empty($this->product->images)) {
                    foreach ($this->product->images as $del_image) {
                        if (file_exists(public_path() . '/uploads/products/' . $del_image)) {
                            unlink(public_path() . '/uploads/products/' . $del_image);
                            unlink(public_path() . '/uploads/products/Thumb-' . $del_image);
                        }
                    }
                }
            } elseif ($request->hasFile('images')) {
                $images_to_delete = $this->product_image->where('product_id', $id)->get()->toArray();
                $ids_to_delete = array_map(function ($item) {
                    return $item['id'];
                }, $images_to_delete);
                // DB::table('product_images')->whereIn('id', $ids_to_delete)->delete();
                for ($j = 0; $j < count($request->images);) {
                    $pro_image = uploadImage($request->images[$j], 'products', '1920x930');
                    $product_image = new productImages();
                    $image_data['product_id'] = $product_id;
                    $image_data['image'] = $pro_image;
                    $product_image->fill($image_data);
                    $pro_save = $product_image->save();
                    if ($pro_save) {
                        $product_image->images()->create(['image' => $pro_image]);
                        // $product_image = new Image();
                        // $image_data['imageable_id'] = $product_image->id;
                        // $image_data['imageable_type'] = 'App\Models\ProductImages';
                        // $image_data['image'] = $name;
                        // $product_image->fill($image_data);
                        // $product_image->save();
                    }
                    $j++;
                }
                for ($m = 0; $m < count($this->product->images);) {
                    if (file_exists(public_path() . '/uploads/products/' . $this->product->images[$m])) {
                        unlink(public_path() . '/uploads/products/' . $this->product->images[$m]);
                        unlink(public_path() . '/uploads/products/Thumb-' . $this->product->images[$m]);
                    }
                    $m++;
                }
            }

            if (!empty($request->size)) {
                $del_size = $this->product_size->where('product_id', $id)->delete();
                $data = array();
                foreach ($request->color as $key => $color) {
                    $data[] = [
                        'product_id' => $product_id,
                        'size_id' => $request->size[$key],
                        'color_id' => $request->color[$key],
                        'quantity' => $request->stock[$key],
                        'stock' => $request->stock[$key],
                        'selling_price' => $request->price[$key],
                        'flash_price' => $request->flash_price[$key],
                        'from_date' => $request->from[$key],
                        'to_date' => $request->to[$key],
                        'discount' => $request->discount[$key],
                        'status' => $request->stockstatus[$key]
                    ];
                    // echo 'color=>' . $color . ', size=>' . $request->size[$key] . ', stock=>' . $request->stock[$key] . ', price=>' . $request->price[$key] . ', purchase=>' . $request->purchase[$key] . ', discount=>' . $request->discount[$key] . '<br>';
                }
                $product_seze = ProductSize::insert($data);
            }
            // if (!empty($request->size)) {
            //     $del_size = $this->product_size->where('product_id', $id)->delete();
            //     for ($i = 0; $i < count($request->size); $i++) {
            //         $product_size = new ProductSize();
            //         $size_data['product_id'] = $product_id;
            //         $size_data['size_id'] = $request->size[$i];
            //         $size_data['selling_price'] = $request->price[$i];
            //         $size_data['purchase_price'] = $request->purchase[$i];
            //         $size_data['total_price'] = $request->purchase[$i] * $request->stock[$i];
            //         $size_data['discount'] = $request->discount[$i];
            //         $size_data['color_id'] = $request->color[$i];
            //         $size_data['stock'] = $request->stock[$i];
            //         $size_data['quantity'] = $request->stock[$i];
            //         $product_size->fill($size_data);
            //         $product_size->save();
            //     }
            // }
            if (!empty($request->attr)) {
                $attr_to_delete = $this->product_attribute->where('product_id', $id)->get()->toArray();
                $ids_to_delete = array_map(function ($item) {
                    return $item['id'];
                }, $attr_to_delete);
                DB::table('product_attributes')->whereIn('id', $ids_to_delete)->delete();
                foreach ($request->attr as $key => $val) {
                    $attr_data = new ProductAttribute();
                    $attr_detail['product_id'] = $product_id;
                    $attr_detail['attribute_id'] = $key;
                    if (is_numeric($val)) {
                        $attr_detail['attribute_value_id'] = $val;
                    } else {
                        $attr_detail['attribute_value_id'] = null;
                        $attr_detail['attribute_value'] = $val;
                    }
                    $attr_data->fill($attr_detail);
                    $attr_size = $attr_data->save();
                }
            }
            if (!empty($request->similar_poducts)) {
                $delete_similar_products = $this->similar_products->where('product_id', $id)->first();
                $success = $this->similar_products->delete();
                $simi_ids = implode(",", $request->similar_poducts);
                $simi_data = new SimilarProduct();
                $simi_detail['product_id'] = $product_id;
                $simi_detail['ids'] = $simi_ids;
                $simi_data->fill($simi_detail);
                $simi_data->save();
            }
            $notification = array(
                'message' => 'Product updated successfully.',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Problem while updating product.',
                'alert-type' => 'error'
            );
        }
        return redirect()->route('products.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $this->product_size = $this->product_size->find($id);
        // $product = $this->product->findOrFail($this->product_size->product_id);
        // $product_count = $product->sizes->count();
        // if (!$this->product_size) {
        //     $notification = array(
        //         'message' => 'Product Not found.',
        //         'alert-type' => 'error'
        //     );
        //     return redirect()->route('products.index')->with($notification);
        // }
        // $pro_images = $this->product_image->where(['product_id' => $this->product_size->product_id, 'color_id' => $this->product_size->color_id])->get();
        // $location = './uploads/products/';
        // foreach ($pro_images as $images) {
        //     foreach ($images->images as $image) {
        //         $to_delete_image = $image->image;
        //         $exist_file = $location . $to_delete_image;
        //         if (file_exists($exist_file)) {
        //             @unlink($exist_file);
        //             $image->delete();
        //         }
        //     }
        //     $images->delete();
        // }
        // $success = $this->product_size->delete();

        // if ($product_count == 1) {
        //     $product->delete();
        // }

        // if ($success) {
        //     $notification = array(
        //         'message' => 'Product deleted successfully.',
        //         'alert-type' => 'success'
        //     );
        // } else {
        //     $notification = array(
        //         'message' => 'Sorry! Product could not be deleted at this moment.',
        //         'alert-type' => 'success'
        //     );
        // }
        // return redirect()->route('products.index')->with($notification);
        $this->product = $this->product->find($id);
        if (!$this->product) {
            $notification = array(
                'message' => 'Product Not found.',
                'alert-type' => 'error'
            );
            return redirect()->route('products.index')->with($notification);
        }

        $success = $this->product->delete();
        if ($success) {
            $notification = array(
                'message' => 'Product deleted successfully.',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Sorry! Product could not be deleted at this moment.',
                'alert-type' => 'success'
            );
        }
        return redirect()->route('products.index')->with($notification);
    }

    public function quickView($id)
    {
        $data = $this->product->with('images')->with('colors')->where('id', $id)->first();
        $starting_price = $this->product_size->where('product_id', $data->id)->first();
        if (empty($data)) {
            return abort(404);
        }
        $images = array();
        foreach ($data->images as $image) {
            foreach ($image->images as $img) {
                $images[] = product_img($img->image);
            }
        }
        return response()->json(['data' => $data, 'starting_price' => $starting_price, 'images' => $images]);
        //return view('frontend.pages.quick', compact('data'));
    }

    public function ajaxDestroy(Request $request)
    {
        $ids = $request->ids;
        $ids = explode(',', $ids);
        foreach ($ids as $id) {
            $this->product_size = $this->product_size->find($id);
            $product = $this->product->findOrFail($this->product_size->product_id);
            $product_count = $product->sizes->count();
            if (!$this->product_size) {
                $notification = array(
                    'message' => 'Product Not found.',
                    'alert-type' => 'error'
                );
                return redirect()->route('products.index')->with($notification);
            }
            // $rimages[] = $product_count;
            // $pro_images = $this->product_image->where(['product_id' => $this->product_size->product_id, 'color_id' => $this->product_size->color_id])->get();
            // $location = './uploads/products/';
            // $products_id[] = ['product_id' => $this->product_size->product_id, 'color_id' => $this->product_size->color_id];
            // foreach ($pro_images as $images) {
            //     foreach ($images->images as $image) {
            //         $to_delete_image = $image->image;
            //         $exist_file = $location . $to_delete_image;
            //         if (file_exists($exist_file)) {
            //             @unlink($exist_file);
            //             // $image->deletse();
            //         }
            //         // $rimages[] = $to_delete_image;
            //     }
            //     // $images->delete();
            // }
            $success = $this->product_size->delete();

            if ($product_count == 1) {
                $product->delete();
            }
        }
        // $ids = $request->ids;
        // $success = DB::table("products")->whereIn('id', explode(",", $ids))->delete();
        // if ($success) {
        //     return response()->json('Products deleted successfully.');
        // } else {
        //     return response()->json('Products could not be deleted at this moment.');
        // }
    }

    public function getSimilar(Request $request)
    {
        $similar = $this->product->where('category_id', $request->cat_id)->get();
        return response()->json($similar);
    }

    public function trash()
    {
        $products = $this->product_size->with(['product' => function ($q) {
            $q->withTrashed();
        }])->onlyTrashed()->get();
        return view('admin.pages.product.trash', compact('products'));
    }

    public function restore($product_id)
    {
        $product_size = $this->product_size->with(['product' => function ($q) {
            $q->withTrashed();
        }])->onlyTrashed()->find($product_id);
        $success = null;
        if (isset($product_size)) {
            $product = $this->product_size->where('product_id', $product_size->product_id)->get()->count();
            if ($product == 0) {
                $product_size->restore();
                $success = $product_size->product()->restore();
            } else {
                $success = $product_size->restore();
            }
        }
        if (isset($success)) {
            $notification = array(
                // 'message' => 'Product deleted successfully.',
                'message' => 'Products restored successfully.',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Sorry! Product could not be restored at this moment.',
                'alert-type' => 'error'
            );
        }
        return redirect()->route('products.trash');
    }


}
