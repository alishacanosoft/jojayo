<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_no','total_amount','delivery_type','address_book_id','user_id','order_id','verified_at','packed_at','shipped_at','delivered_at'];

    public function area_detail(){
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function address_detail(){
        return $this->belongsTo(AddressBook::class, 'address_book_id');
    }

    public function userDetail(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function order_products(){
        return $this->hasMany(ProductOrder::class);
    }
    
    public function vendor_products(){
        return $this->hasMany(ProductOrder::class)->with('products');
    }
    
    public function products(){
        return $this->hasMany(ProductOrder::class);
    }
    
}
