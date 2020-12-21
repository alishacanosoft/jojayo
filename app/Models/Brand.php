<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name','slug', 'logo'];

    public function getRules($act = 'add'){
        $rules = [
            'name' => 'bail|required|string|unique:brands,name',
            'slug' => 'bail|required|string|unique:brands,slug',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
        if($act != 'add'){
            $rules['name'] = "required|string";
            $rules['slug'] = "required|string";
            $rules['image'] = 'required';
        }
        return $rules;
    }
}
