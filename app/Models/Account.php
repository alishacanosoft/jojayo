<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
  protected $fillable = ['name','account_holder','account_number','payment_id','status'];

  public function getRules(){
      $rules = array(
          'name' => 'required|string',
          'account_holder' => 'required|string',
          'account_holder' => 'required|string',
          'payment_id' => 'required|exists:payments,id',
          'status' => 'required|in:active,inactive'
      );
      return $rules;
  }
}
