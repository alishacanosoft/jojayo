<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Statement extends Model
{
    protected $fillable = ['vendor_id', 'transaction_no', 'paid_amount', 'due_amount', 'narration'];
    
    public function orders()
    {
        return $this->hasMany(Order::class,'id');
    }
}