<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = ['name','url','image','status'];

    public function getRules($act = 'add'){
        $rules = [
            'name' => 'required|string',
            'url' => 'required|string',
            'status' => 'required|string|in:active,inactive',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
        return $rules;
    }
}
