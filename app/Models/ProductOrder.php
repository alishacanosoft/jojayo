<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Color;
use App\Models\Size;
use App\Models\User;

class ProductOrder extends Model
{
    protected $fillable = ['product_id','color_id','size_id','user_id','price','discount','order_id','quantity','status', 'return'];    

    public function products(){
        return $this->belongsTo('App\Models\Product','product_id');
    }
    
    public function userDetail(){
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function colorInfo()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function sizeInfo()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }
}
