<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecondaryCategory extends Model
{
    protected $fillable = ['name','slug', 'primary_category_id'];

    public function getRules(){
        $rules = [
            'name' => 'required|string|max:255',
            'primary_category_id' => 'required|exists:primary_categories,id'
        ];
        return $rules;
    }

    public function PrimaryCategory(){
        return $this->belongsTo('App\Models\PrimaryCategory', 'primary_category_id');
    }

    public function FinalCategory(){
        return $this->hasMany('App\Models\ProductCategory');
    }

    public function productCategories(){
        return $this->hasMany(\App\Models\ProductCategory::class, 'secondary_category_id', 'id')->with('categoryProducts');
    }
}
