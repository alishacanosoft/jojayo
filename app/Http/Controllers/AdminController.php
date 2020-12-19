<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Middleware\vendor;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendor     = User::where('roles','vendor')->count();
        $customer   = User::where('roles','customers')->count();
        $admin      = User::where('roles','admin')->count();
//
        $delivered  = Order::where('status','delivered')->count();
        $shipped    = Order::where('status','shipped')->count();
        $verified   = Order::where('status','verified')->count();
        $packed     = Order::where('status','packed')->count();

        $allorders = array();
        $alldelivered = array();
        for ($i=1; $i<=12; $i++){
            if($i < 12){
                $allorders[$i] = Order::whereMonth('created_at', $i)->count(). ',' ;
            }else{
                $allorders[$i] = Order::whereMonth('created_at', $i)->count();
            }
        }
        for ($i=1; $i<=12; $i++){
            if($i < 12){
                $alldelivered[$i] = Order::where('status','delivered')->whereMonth('created_at', $i)->count(). ',' ;
            }else{
                $alldelivered[$i] = Order::where('status','delivered')->whereMonth('created_at', $i)->count();
            }
        }
        return view('admin.pages.index', compact('vendor','customer','admin','allorders', 'alldelivered','delivered','shipped','verified','packed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
