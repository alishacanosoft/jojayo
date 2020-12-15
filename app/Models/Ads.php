<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    protected $fillable = ['title', 'url', 'start_date', 'end_date', 'place', 'image', 'status'];

    public function getRules($act = 'add'){
        $rules = [
            'title' => 'required|string|unique:ads,title',
            'url' => 'required|string',
            'start_date' => 'required|string',
            'end_date' => 'required|string',
            'place' => 'required|string',
            'status' => 'sometimes|in:draft,publish',
            'image' => 'required|string'
        ];
        if ($act !== 'add'){
            $rules['title'] = 'required|string';
        }
        return $rules;
    }
}
