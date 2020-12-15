<?php


namespace App\Http\ViewComposer;

use Illuminate\View\View;
use App\Models\SensitiveData;
use App\Models\ProductCategory;
use App\Models\PrimaryCategory;

class SensitiveComposer
{
    public function compose(View $view){
        $sensitive_data = SensitiveData::first();
        $primary_categories = PrimaryCategory::with('secondaryCategories')->get(); //dd($primary_categories);
        $category = ProductCategory::get();
        $view
        ->with('sensitive_data', $sensitive_data)
        ->with('primary_categories', $primary_categories)
        ->with('category', $category);
    }
}
