<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'region_id'];

    public function getRules(){
      $rules = [
        'name' => 'required|string',
        'region_id' => 'required|exists:regions,id'
      ];
      return $rules;
    }

    public function Region(){
      return $this->belongsTo('App\Models\Region');
    }
}
