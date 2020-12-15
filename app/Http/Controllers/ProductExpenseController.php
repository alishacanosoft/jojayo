<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductExpense;
use App\Models\ProductSize;

class ProductExpenseController extends Controller
{
    protected $product = null;
    protected $expense = null;
    protected $product_size = null;

    public function __construct(Product $product, ProductExpense $expense, ProductSize $product_size){
        $this->product = $product;
        $this->expense = $expense;
        $this->product_size = $product_size;
    }

    public function index(){
        $allProducts = $this->product->get();
        return view('admin.pages.expense', compact('allProducts'));
    }

    public function edit($id){
        $this->expense = $this->expense->where('product_id', $id)->first(); 
        if(!$this->expense) {
            request()->session()->flash('error','Record not found');
            return redirect()->back();
        }
        $product_data = $this->product->select('name')->where('id', $id)->first();
        $product_size_data = $this->expense->where('product_id', $id)->first();
        return view('admin.pages.expense_edit', compact('product_data','product_size_data'));
    }

    public function update(Request $request, $id){
        $this->expense = $this->expense->where('id', $id)->first();
        if(!$this->expense) {
            request()->session()->flash('error','Record not found');
            return redirect()->back();
        }
        $data = $request->all();
        $this->expense->fill($data);
        $success = $this->expense->save();
        if($success){
            request()->session()->flash('success','Record edited successfully.');
        } else {
            request()->session()->flash('error','Sorry! Record could not be edited at this moment.');
        }
        return redirect()->route('record-list');
    }
}
