<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Officecategory extends Model
{
    protected $table ='officemgmcategory';
    protected $fillable =['id','name'];

    public function getRules($act = 'add'){
        $rules = [
            'name' => 'required|string|unique:officemgmcategory,name',
        ];
        if ($act !== 'add'){
            $rules['name'] = 'required|string';
        }
        return $rules;
    }
}
