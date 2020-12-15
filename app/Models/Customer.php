<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Customer extends Model
{
    protected $fillable = ['user_id','billing_address', 'shipping_address', 'token', 'verified','status'];

    public function getRules(){
        $rules = [
            'user_id' => 'nullable|numeric|exists:users,id',
            'billing_address' => 'required|string',
            'shipping_address' => 'required|string',
            'token' => 'nullable|string',
            'verified' => 'required|numeric',
            'status' => 'required|in:active,inactive',
        ];
        return $rules;
    }

}
