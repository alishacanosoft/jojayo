<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
  protected $fillable = ['name', 'city_id','delivery_charge', 'express_charge'];

  public function getRules(){
    $rules = [
      'name' => 'required|string',
      'city_id' => 'required|exists:cities,id',
      'delivery_charge' => 'required|string',
      'express_charge' => 'required|string',
    ];
    return $rules;
  }

  public function City(){
    return $this->belongsTo('App\Models\City');
  }
}
