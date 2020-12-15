<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryPermitted extends Model
{
    protected $fillable = ['vendor_id','category_id'];

    public function CategoryDetail(){
        return $this->belongsTo('App\Models\ProductCategory', 'category_id');
    }
}
