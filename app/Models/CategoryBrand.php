<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryBrand extends Model
{
    protected $fillable = ['category_id', 'brand_id'];

    public function brandDetail(){
        return $this->belongsTo('App\Models\Brand','brand_id');
    }
}
