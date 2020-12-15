<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $fillable = ['product_id', 'color_id', 'discount', 'user_id', 'size_id', 'price', 'quantity', 'sales_date', 'contact', 'purchased_by', 'remarks','area_id', 'delivery_address', 'delivery_charge'];

    public function getRules(){
        $rules = [
            'product_id' => 'required|exists:products,id',
            'user_id' => 'sometimes|exists:users,id',
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:sizes,id',
            'area_id' => 'required|exists:areas,id',
            'price' => 'required|string',
            'discount' => 'nullable|string',
            'contact' => 'nullable|numeric',
            'quantity' => 'required|string',
            'purchased_by' => 'required|string',
            'delivery_address' => 'required|string',
            'delivery_charge' => 'required|string',
            'remarks' => 'nullable|string',
            'sales_date' => 'required|string',
        ];

        return $rules;
    }

    public function productName(){
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function account(){
        return $this->belongsTo('App\Models\Account', 'account_id');
    }

    public function color(){
        return $this->belongsTo('App\Models\Color', 'color_id');
    }

    public function size(){
        return $this->belongsTo('App\Models\Size', 'size_id');
    }

}
