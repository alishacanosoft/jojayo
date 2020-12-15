<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\Size;
use App\Models\Brand;
use App\Models\SecondaryCategory;
use App\Models\CategoryAttribute;
use App\Models\CategoryBrand;
use App\Models\Attribute;
use DB;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    protected $product_category = null;
    protected $secondary_category = null;
    protected $sizes = null;
    protected $brand = null;
    protected $category_brand = null;
    protected $attribute = null;
    protected $category_attribute = null;

    public function __construct(ProductCategory $product_category,SecondaryCategory $secondary_category, Size $sizes, Brand $brand, CategoryBrand $category_brand, Attribute $attribute, CategoryAttribute $category_attribute)
    {
        //$this->authorizeResource(ProductCategory::class, 'productcategory');        
        $this->secondary_category = $secondary_category;
        $this->product_category = $product_category;
        $this->category_brand = $category_brand;        
        $this->sizes = $sizes;
        $this->brand = $brand;
        $this->attribute = $attribute;
        $this->category_attribute = $category_attribute;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parent = $this->secondary_category->get();
        $allCategories = $this->product_category->orderBy('created_at', 'desc')->get();
        $active_tab = 'manage';
        $secondary_categories = $this->secondary_category->get();
        $all_brands = $this->brand->orderBy('name', 'desc')->get();  
        $all_attributes = $this->attribute->orderBy('name', 'ASC')->get();      
        return view('admin.pages.product_categories', compact('parent', 'secondary_categories', 'allCategories', 'active_tab','all_brands','all_attributes'));
    }

    public function getParentController(){
        $parent = $this->secondary_category->get();
        return response()->json($parent);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent = $this->secondary_category->get();
        $active_tab = 'create';
        $secondary_categories = $this->secondary_category->get();
        $allCategories = $this->product_category->orderBy('created_at', 'desc')->get();
        $all_brands = $this->brand->orderBy('name', 'desc')->get();
        $all_attributes = $this->attribute->orderBy('name', 'ASC')->get();
        return view('admin.pages.product_categories', compact('secondary_categories','parent', 'active_tab', 'allCategories','all_brands','all_attributes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->product_category->getRules();
        $request->validate($rules);
        $data = $request->all();
        $data['name'] = $request->name;
        $data['secondary_category_id'] = $request->secondary_category_id;
        $data['slug'] = $request->slug;
        $data['warranty'] = $request->warranty;
        $this->product_category->fill($data);
        $status = $this->product_category->save();
        $product_category_id = $this->product_category->id;
        if(!empty($request->size)){
        $sizes = explode(',', $request->size);
            for($i=0; $i<count($sizes); $i++){
                $this->sizes = new Size;
                $slug_data = strtolower(str_replace(' ', '-', trim($sizes[$i])));
                $sizes_data['slug'] = $slug_data;
                $sizes_data['name'] = $sizes[$i];
                $sizes_data['product_category_id'] = str_replace('-','',$product_category_id);
                $this->sizes->fill($sizes_data);
                $this->sizes->save();
            }
        }
        if(!empty($request->attribute_id)){
            for($i=0; $i<count($request->attribute_id); $i++){
                $this->category_attribute = new CategoryAttribute;
                $category_attr_data['category_id'] = $product_category_id;
                $category_attr_data['attribute_id'] = $request->attribute_id[$i];
                $this->category_attribute->fill($category_attr_data);
                $this->category_attribute->save();
            }
        }
        if(!empty($request->brand_id)){
            for($b=0; $b<count($request->brand_id); $b++){
                $this->category_brand = new CategoryBrand;
                $brand_detail['category_id'] = $product_category_id;
                $brand_detail['brand_id'] = $request->brand_id[$b];
                $this->category_brand->fill($brand_detail);
                $this->category_brand->save();
            }
        }
        if($status){
            $notification = array(
                'message' => 'Product Category created successfully.',
                'alert-type' => 'success'
            );            
        } else {
            $notification = array(
                'message' => 'Sorry! Product Category could not be created.',
                'alert-type' => 'error'
            ); 
        }
        return redirect()->route('product_categories.index')->with($notification);
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
        $active_tab = 'create';
        $data = $this->product_category->find($id);
        if(!$data){
            $notification = array(
                'message' => 'Product Category not found.',
                'alert-type' => 'error'
            );
            return redirect()->route('product_categories.index')->with($notification);
        }
        $all_attributes = $this->attribute->orderBy('name', 'ASC')->get();
        $size_list = $this->sizes->select('name')->where('product_category_id', $data->id)->get()->toArray();
        $size_list = str_replace(' ','',array_column($size_list, 'name'));
        $all_categories = $this->secondary_category->get();
        $secondary_categories = $this->secondary_category->get();
        $all_brands = $this->brand->orderBy('name', 'desc')->get();
        $selected_brands = $this->category_brand->where('category_id', $data->id)->get();
        $selected_attributes = $this->category_attribute->where('category_id', $data->id)->get();
        $allCategories = $this->product_category->orderBy('created_at', 'desc')->get();
        return view('admin.pages.product_categories', compact('all_categories', 'data','size_list', 'secondary_categories', 'active_tab','all_brands','allCategories','selected_brands','all_attributes','selected_attributes'));
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
        $this->product_category = $this->product_category->find($id);
        if(!$this->product_category) {
            $notification = array(
                'message' => 'Product Category not found.',
                'alert-type' => 'error'
            );
            return redirect()->route('product_categories.index')->with($notification);
        }
        $rules = $this->product_category->getRules('update');
        $request->validate($rules);
        $data = $request->all();
        $this->product_category->fill($data);
        $success = $this->product_category->save();
        $product_category_id = $this->product_category->id;
        if($success){
            $sizes_to_delete = $this->sizes->where('product_category_id', $id)->get()->toArray();
            $ids_to_delete = array_map(function($item){ return $item['id']; }, $sizes_to_delete);
            DB::table('sizes')->whereIn('id', $ids_to_delete)->delete();
            if(!empty($request->size)){
            $sizes = explode(',', $request->size);
                for($i=0; $i<count($sizes); $i++){
                    $this->sizes = new Size;
                    $slug_data = strtolower(str_replace(' ', '-', trim($sizes[$i])));
                    $sizes_data['slug'] = $slug_data;
                    $sizes_data['name'] = $sizes[$i];
                    $sizes_data['product_category_id'] = $product_category_id;
                    $this->sizes->fill($sizes_data);
                    $this->sizes->save();
                }
            }
            if(!empty($request->attribute_id)){
                $attributes_to_delete = $this->category_attribute->where('category_id', $id)->get()->toArray();
                $categories_to_delete = array_map(function($item){ return $item['id']; }, $attributes_to_delete);
                DB::table('category_attributes')->whereIn('id', $categories_to_delete)->delete();
                for($i=0; $i<count($request->attribute_id); $i++){
                    $this->category_attribute = new CategoryAttribute;
                    $category_attr_data['category_id'] = $product_category_id;
                    $category_attr_data['attribute_id'] = $request->attribute_id[$i];
                    $this->category_attribute->fill($category_attr_data);
                    $this->category_attribute->save();
                }
            }
            if(!empty($request->brand_id)){
                $brands_to_delete = $this->category_brand->where('category_id', $id)->get()->toArray();
                $categories_to_delete = array_map(function($item){ return $item['id']; }, $brands_to_delete);
                DB::table('category_brands')->whereIn('id', $categories_to_delete)->delete();
                for($b=0; $b<count($request->brand_id); $b++){
                    $this->category_brand = new CategoryBrand;
                    $brand_detail['category_id'] = $product_category_id;
                    $brand_detail['brand_id'] = $request->brand_id[$b];
                    $this->category_brand->fill($brand_detail);
                    $this->category_brand->save();
                }
            }
            $notification = array(
                'message' => 'Category updated successfully.',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Problem while updating category.',
                'alert-type' => 'error'
            );            
        }
        return redirect()->route('product_categories.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->product_category = $this->product_category->find($id);
        if(!$this->product_category){
            $notification = array(
                'message' => 'Product Category not found.',
                'alert-type' => 'error'
            );
            return redirect()->route('product_categories.index')->with($notification);
        }

        $success = $this->product_category->delete();
        if($success){
            $notification = array(
                'message' => 'Product Category deleted successfully.',
                'alert-type' => 'success'
            );            
        } else {
            $notification = array(
                'message' => 'Sorry! Product Category could not be deleted.',
                'alert-type' => 'error'
            ); 
        }
        return redirect()->route('product_categories.index')->with($notification);
    }

    public function lastData(){
        $lastData = $this->product_category->orderBy('id', 'desc')->first();
        $parent = $this->product_category->get();
        return response()->json(['lastData'=>$lastData, 'parent'=>$parent]);
    }

    public function editCategory($slug){
        $data = $this->product_category->where('slug', $slug)->first();
        if(!$data){
            request()->session()->flash('error','Category Not found');
            return redirect()->route('product_categories.index');
        }
        $parent = $this->secondary_category->get();
        return view('admin.pages.categoryEdit', compact('parent','data'));
    }
}
