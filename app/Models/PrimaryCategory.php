<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SecondaryCategory;

class PrimaryCategory extends Model
{
    protected $fillable = ['name','icon'];

    public function getRules(){
        $rules = [
            'name' => 'required|string|max:255',
            'icon' => 'required|string'
        ];
        return $rules;
    }

    public function secondaryCategories(){
        return $this->hasMany('App\Models\SecondaryCategory')->with('FinalCategory');
    }

    public function secondaryCategory(){
        return $this->hasMany(App\Models\SecondaryCategory::class, 'primary_category_id', 'id');
     }
}
