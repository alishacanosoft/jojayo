<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Officevoucher extends Model
{
    protected $table ='offficevoucher';
    protected $fillable =['id','voucherid','category_id','price','description','narrative' , 'created_at'];
    public $timestamps = false;


    public function getRules(){
        $rules = [
            'category_id' => 'required|exists:officemgmcategory,id',
            'price' => 'bail|required|string',
            'description' => 'bail|required|string',
            'narrative' => 'bail|required|string',
            'created_at' => 'required|date',

        ];
        if($rules != 'add'){
            $rules['category_id'] = "required|string";
        }
        return $rules;
    }

    public function category()
    {
        return $this->belongsTo('App\Officecategory');
    }

}
