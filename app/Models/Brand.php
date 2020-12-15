<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name','slug', 'logo'];

    public function getRules(){
        $rules = [
            'name' => 'bail|required|string|unique:brands,name',
            'slug' => 'bail|required|string|unique:brands,slug',
            'logo' => 'required'
        ];
        if($rules != 'add'){
            $rules['name'] = "required|string";
            $rules['slug'] = "required|string";
        }
        return $rules;
    }
}
