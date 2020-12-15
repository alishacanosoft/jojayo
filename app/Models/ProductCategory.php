<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = ['name','slug','secondary_category_id','warranty'];

    public function getRules($act = 'add'){
        $rules = [
            'name' => 'bail|required|string|unique:product_categories,name',
            'slug' => 'bail|required|string|unique:product_categories,slug',
            'secondary_category_id' => 'nullable|exists:secondary_categories,id',
            'warranty' => 'required|boolean'
        ];
        if($act != 'add'){
            $rules['name'] = "required|string";
            $rules['slug'] = "required|string";
        }
        return $rules;
    }

    public function Secondarycategory(){
        return $this->belongsTo('App\Models\SecondaryCategory', 'secondary_category_id');
    }

    public function productCategory(){
        return $this->belongsTo('App\Models\ProductCategory', 'category_id', 'id');
    }

    public function categoryProducts(){
        return $this->hasMany('App\Models\Product', 'category_id')->with('images');
    }

    public function secondaryCategories(){
        return $this->belongsTo(\App\Models\SecondaryCategory::class, 'secondary_category_id', 'id');
     }
     
     public function products(){
         return $this->hasMany(\App\Models\Product::class, 'category_id', 'id');
     }

     public function attributes(){
        return $this->hasMany('App\Models\CategoryAttribute', 'category_id');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'category_brands', 'category_id', 'brand_id');
    }
}
