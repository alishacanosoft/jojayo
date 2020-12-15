<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ['name','code'];

    public function getRules($act = 'add'){
        $rules = [
            'name' => 'required|string|unique:colors,name',
            'code' => 'required|string',
        ];
        if ($act !== 'add'){
            $rules['name'] = 'required|string';
        }
        return $rules;
    }
    
}
