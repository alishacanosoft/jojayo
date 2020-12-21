<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSize extends Model
{
    use SoftDeletes;
    protected $fillable = ['product_id', 'size_id', 'selling_price', 'special_price', 'discount', 'stock', 'color_id', 'quantity', 'total_price', 'from', 'to'];

    public function getRules()
    {
        $rules = [
            'product_id' => 'required|exists:products,id',
            'size_id' => 'required|exists:sizes,id',
            'color_id' => 'required|exists:colors,id',
            'selling_price' => 'required|string',
            'special_price' => 'nullable|string',
            'quantity' => 'required|string',
            'total_price' => 'required|string',
            'discount' => 'nullable|string',
            'stock' => 'required|string',
            'from' => 'nullable|string',
            'to' => 'nullable|string',
        ];
        return $rules;
    }

    public function colorInfo()
    {
        return $this->belongsTo('App\Models\Color', 'color_id');
    }

    public function sizeInfo()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function sizes()
    {
        return $this->morphMany(ColorSize::class, 'sizeable');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // public function products(){
    //     return $this->hasMany(\App\Models\Product::class, 'category_id', 'id');
    // }
    
}
