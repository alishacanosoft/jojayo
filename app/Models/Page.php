<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['title', 'slug', 'excerpt', 'description', 'status'];

    public function getRules($act = 'add'){
        $rules = [
            'title' => 'required|string|unique:blogs,title',
            'slug' => 'required|string|unique:blogs,slug',
            'excerpt' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|in:active,inactive'
        ];
        if ($act !== 'add'){
            $rules['title'] = 'required|string';
            $rules['slug'] = 'required|string';
        }
        return $rules;
    }
}
