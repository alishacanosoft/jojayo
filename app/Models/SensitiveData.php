<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensitiveData extends Model
{
  protected $fillable = ['web_title', 'keywords', 'meta_description', 'company', 'registration', 'vat', 'pobox', 'facebook', 'twitter', 'linkedin', 'instagram', 'youtube', 'landline', 'landline1', 'landline2', 'mobile', 'mobile1', 'email', 'email1', 'location', 'map', 'g_analytics', 'logo'];

  public function getRules(){
      $rules = [
          'web_title' => 'required|string',
          'keywords' => 'required|string',
          'meta_description' => 'required|string',
          'company' => 'required|string',
          'registration' => 'required|string',
          'vat' => 'required|string',
          'pobox' => 'required|string',
          'facebook' => 'required|string',
          'twitter' => 'required|string',
          'linkedin' => 'required|string',
          'instagram' => 'required|string',
          'youtube' => 'required|string',
          'landline' => 'required|string',
          'landline1' => 'required|string',
          'landline2' => 'required|string',
          'mobile' => 'required|string',
          'mobile1' => 'required|string',
          'email' => 'required|string',
          'email1' => 'required|string',
          'location' => 'required|string',
          'map' => 'required|string',
          'g_analytics' => 'required|string',
          'logo' => 'required|string'
      ];
      return $rules;
  }
}
