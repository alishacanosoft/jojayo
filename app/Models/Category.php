<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $fillable = ['name','slug','is_parent','parent'];

    public function getRules(){
        $rules = [
            'name' => 'bail|required|string|unique:categories,name',
            'slug' => 'bail|required|string|unique:categories,slug',
            'is_parent' => 'sometimes|numeric',
            'parent' => 'nullable|exists:categories,id'
        ];
        if($rules != 'add'){
            $rules['name'] = "required|string";
            $rules['slug'] = "required|string";
        }
        return $rules;
    }

    public function categoryName(){
        return $this->belongsTo('App\Models\Category', 'parent'); 
    }

}
