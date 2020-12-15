<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductExpense extends Model
{
    protected $fillable = ['product_id', 'total_amount', 'amount_paid', 'credit'];
}
