<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = ['name','slug','field'];

    public function getRules(){
        $rules = array(
            'name' => 'required|string',
            'slug' => 'required|string',
            'field' => 'required|string',
        );
        return $rules;
    }

    public function attributeValue(){
        return $this->hasMany('App\Models\AttributeValue', 'attribute_id');
    }
}
