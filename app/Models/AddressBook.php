<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressBook extends Model
{
  protected $fillable = ['user_id', 'name', 'phone', 'location', 'region_id', 'city', 'area', 'address', 'location'];

  public function getRules(){
    $rules = [
      'name' => 'required|string',
      'phone' => 'required|numeric',
      'location' => 'required|string',
      'region_id' => 'required|exists:regions,id',
      'city' => 'required|exists:cities,id',
      'area' => 'required|exists:areas,id',
      'address' => 'required|string',
      'location' => 'required|in:office,home',
    ];
    return $rules;
  }

  public function Region(){
    return $this->belongsTo('App\Models\Region');
  }

  public function City(){
    return $this->belongsTo('App\Models\City');
  }

  public function Area(){
    return $this->belongsTo('App\Models\Area');
  }

  public function AreaDetail(){
    return $this->belongsTo('App\Models\Area', 'area');
  }

  public function CityDetail(){
    return $this->belongsTo('App\Models\City', 'city');
  }

}
