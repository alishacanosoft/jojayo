<?php

namespace App\Service;
use App\Models\Product;

class ProductService{

    public static function getProduct($name, $limit)
    {
        $products=Product::where('deleted_at', null)->where('status', 'verified')->whereHas('productCategory',function($query) use($name){
            $query->whereHas('secondaryCategory',function($query) use($name){
                $query->whereHas('primaryCategory',function($query)use($name){
                    $query->where('name',$name);
                });
            });
        })
        ->with(['productCategory'=>function($query)use($name){
            $query->whereHas('secondaryCategory',function($query)use($name){
                $query->whereHas('primaryCategory',function($query)use($name){
                    $query->where('name',$name);
                });
            });
        },
        'productCategory.secondaryCategory'=>function($query)use($name){
            $query->whereHas('primaryCategory',function($query)use ($name){
                $query->where('name',$name);
            });
        },
        'productCategory.secondaryCategory.primaryCategory'=>function($query)use($name){
            $query->where('name',$name);
        }
        ])->take($limit)->get();
        return $products;
    }

    public static function flash($date, $time, $endtime){
        $flash = \App\Models\ProductSize::with('product')
        ->whereHas('product', function ($query) {
            $query->where('status', 'verified');
        })
        ->whereNotNull('flash_price')
        ->whereDate('to_date', '<=', $date)
        ->whereTime('from_date', '>=', $time)
        ->whereTime('from_date', '<=', $endtime)
        ->groupBy('product_id')->get();
        return $flash;
    }
}
