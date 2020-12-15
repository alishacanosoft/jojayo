<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ColorSize extends Model
{
    protected $guarded=[];

    public function sizeable(){
        return $this->morthTo();
    }
}
