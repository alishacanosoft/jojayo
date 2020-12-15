<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorCommission extends Model
{
    protected $fillable = ['commission_id','vendor_id','percent'];

    public function vendor_details(){
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function commission_details(){
        return $this->belongsTo(Commission::class, 'commission_id');
    }
}
