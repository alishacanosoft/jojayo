<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = ['user_id', 'company', 'company_address', 'vendor_address', 'status'];

    public function categoryAssigned(){
        return $this->hasMany('App\Models\CategoryPermitted');
    }

    public function categories(){
        return $this->belongsToMany(ProductCategory::class,'category_permitteds','vendor_id','category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    public function commission_detail(){
        return $this->hasMany(VendorCommission::class);
    }
    
    public function user_detail(){
        return $this->belongsTo(User::class,'user_id');
    }
}
