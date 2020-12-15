<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    protected $fillable = ['product_id', 'color_id', 'image'];

    public function colors(){
      return $this->belongsTo('App\Models\Color', 'color_id');
    }
    public function images(){
      return $this->morphMany(Image::class,'imageable');
    }
}
