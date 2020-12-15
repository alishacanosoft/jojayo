<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryAttribute extends Model
{
    protected $fillable = ['category_id', 'attribute_id'];

    public function getRules(){
        $rules = array(
            'category_id' => 'required|numeric|exists:product_categories.id',
            'attribute_id' => 'required|numeric|exists:attributes.id'
        );
        return $rules;
    }

    public function attributeDetail(){
        return $this->belongsTo('App\Models\Attribute','attribute_id')->with('attributeValue');
    }
}
