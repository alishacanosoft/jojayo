<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['name'];

    public function getRules(){
      $rules = array(
        'name' => 'required|string'
      );
      return $rules;
    }
}
