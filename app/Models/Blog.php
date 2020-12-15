<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'category_id', 'image', 'excerpt', 'status', 'feature'];

    public function getRules($act = 'add'){
        $rules = [
            'title' => 'required|string|unique:blogs,title',
            'slug' => 'required|string|unique:blogs,slug',
            'excerpt' => 'required|string',
            'description' => 'required|string',
            'feature' => 'required|boolean',
            'status' => 'required|in:draft,publish',
            'category_id' => 'nullable|numeric|exists:categories,id',
            'image' => 'required|string'
        ];
        if ($act !== 'add'){
            $rules['title'] = 'required|string';
            $rules['slug'] = 'required|string';
        }
        return $rules;
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
