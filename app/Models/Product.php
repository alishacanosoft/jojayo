<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','slug','sku','jojayo_sku','category_id','brand_id','video','status', 'specification', 'description','warranty', 'vendor_id'];

    public function getRules(){
        $rules = [
            'name' => 'bail|required|string|unique:products,name',
            'slug' => 'bail|required|string|unique:products,slug',
            'sku' => 'bail|required|string|unique:products,sku',
            'jojayo_sku' => 'bail|required|string|unique:products,jojayo_sku',
            'specification' => 'bail|required|string',
            'description' => 'bail|required|string',
            'category_id' => 'required|exists:product_categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'video' => 'nullable|string',
            'warranty' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
        ];
        if($rules != 'add'){
            $rules['name'] = "required|string";
            $rules['slug'] = "required|string";
            $rules['sku'] = "required|string";
            $rules['jojayo_sku'] = "required|string";
        }
        return $rules;
    }
    public function category(){
        return $this->belongsTo('App\Models\ProductCategory');
    }
    
    public function brand(){
        return $this->belongsTo('App\Models\Brand');
    }

    public function VendorName(){
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }

    public function images(){
      return $this->hasMany('App\Models\ProductImages', 'product_id')->with('images');
    }

    public function sizes(){
      return $this->hasMany('App\Models\ProductSize', 'product_id');
    }

    public function colors(){
        return $this->hasMany('App\Models\ProductSize', 'product_id');
    }

    public function finalCategory(){
        return $this->belongsTo('App\Models\SecondaryCategory', 'category_id');
    }

   

    public function productCategory(){
        return $this->belongsTo('App\Models\ProductCategory', 'category_id', 'id');
    }

    public function my_attribute(){
        return $this->hasMany('App\Models\ProductAttribute', 'product_id');
    }

    public function similarProductList(){
        return $this->hasOne('App\Models\SimilarProduct', 'product_id');
    }

    public function price(){
        return $this->hasOne('App\Models\ProductSize', 'product_id');
    }

    public function scopeSortProd($query, $sort)
    {
        return $query->when(isset($sort)&&($sort == 'latest'||$sort == 'oldest'),function($q)use($sort){
            $new_sort=$sort=='latest'?'desc':'asc';
            $q->orderBy('created_at',$new_sort);
        })
        ->when(isset($sort) && ($sort == 'asc' || $sort == 'desc'), function ($q) use ($sort) {
            $q->orderBy('name', $sort);
        });
    }

    public function scopeSortPrice($query, $min_price, $max_price)
    {
        return $query->when(($min_price > 0 && $max_price > 0), function ($q) use ($min_price, $max_price) {
            $q->whereHas('sizes', function ($query) use ($min_price, $max_price) {
                $query->whereBetween('selling_price', [$min_price, $max_price]);
            });
        });
    }

    public function scopeSortSize($query,$selected_sizes)
    {
        return $query->when(count((array)$selected_sizes) > 0, function ($q) use ($selected_sizes) {
            $q->whereHas('sizes', function ($query) use ($selected_sizes) {
                $query->whereIn('size_id', $selected_sizes);
            });
        });
    }

    public function scopeSortBrand($query,$selected_brands)
    {
        return $query->when($selected_brands, function ($q) use ($selected_brands) {
          return $q->whereIn('brand_id', $selected_brands);
        });
    }
}