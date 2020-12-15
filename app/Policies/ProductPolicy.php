<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\Vendor;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability){
        if($user->roles == 'admin' || $user->roles == 'employee'){
            return true;
        }
    }
    
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Product $product)
    {
        $vendor_id = Vendor::where('user_id', $user->id)->pluck('id');
        return $vendor_id[0] === $product->vendor_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Product $product)
    {
        $vendor_id = Vendor::where('user_id', $user->id)->pluck('id')->first();
        return $vendor_id === $product->vendor_id;
    }

    public function delete(User $user, Product $product)
    {
        $vendor_id = Vendor::where('user_id', $user->id)->pluck('id')->first();
        return $vendor_id === $product->vendor_id;
    }

    public function restore(User $user, Product $product)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the product.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $product
     * @return mixed
     */
    public function forceDelete(User $user, Product $product)
    {
        return false;
    }
}
