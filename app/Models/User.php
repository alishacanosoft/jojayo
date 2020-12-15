<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'contact', 'image', 'roles'];

    public function getRules($act = 'add'){
        $rules = [
            'name' => 'sometimes|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'contact' => 'nullable|string',
            'roles'=> 'sometimes|in:admin,vendor,employee,customer',
            'image' => 'sometimes|image'
        ];
        if($act !== 'add'){
            $rules['email'] = 'required|string';
        }
        return $rules;
    }

    public function addressBook(){
        return $this->hasMany('App\Models\AddressBook');
    }

    public function scopeAdmin($q)
    {
        return $q->where('roles', 'admin')->orWhere('roles', 'employee');
    }

    public function scopeVendor($q)
    {
        return $q->where('roles', 'vendor');
    }

    public function scopeCustomer($q)
    {
        return $q->where('roles', 'customers');
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
