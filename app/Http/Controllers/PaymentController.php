<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{

  protected $payments = null;

  public function __construct(Payment $payments){
    //$this->authorizeResource(Payment::class, 'payment');
    $this->payments = $payments;
  }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allmethods = $this->payments->get();
        return view('admin.pages.methods', compact('allmethods'));
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
      $rules = $this->payments->getRules();
      $request->validate($rules);
      $data = $request->all();
      $data['name'] = $request->name;
      $this->payments->fill($data);
      $status = $this->payments->save();
        if($status){
            return response()->json(['status'=>true,'data'=>'Payment method created successfully.']);
        } else {
            return response()->json(['status'=>false,'data'=>null]);
      }
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
        $data = $this->payments->find($id);
        if(!$data) {
            request()->session()->flash('error','Payment method not found');
            return redirect()->back();
        }
        return view('admin.pages.edit_payment', compact('data'));
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
         $this->payments = $this->payments->find($id);
         if(!$this->payments) {
             request()->session()->flash('error','Payment method not found');
             return redirect()->back();
         }
         $rules = $this->payments->getRules('update');
         $request->validate($rules);
         $data = $request->all();
         $this->payments->fill($data);
         $success = $this->payments->save();
         $product_id = $this->payments->id;
         if($success){
             $request->session()->flash('success','Payment method updated successfully.');
         } else {
             $request->session()->flash('error','Problem while updating payment method.');
         }
         return redirect()->route('payments.index');
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function destroy($id)
     {
         $this->payments = $this->payments->find($id);
         if(!$this->payments){
             request()->session()->flash('error','Payment method not found');
             return redirect()->route('payments.index');
         }

         $success = $this->payments->delete();
         if($success){
             return response()->json(['status'=>true,'data'=>'Payment method deleted successfully.']);
         } else {
             return response()->json(['status'=>false,'data'=>null]);
         }
     }

    public function lastPaymentData(){
        $lastData = $this->payments->orderBy('id', 'desc')->first();
        return response()->json(['lastData'=>$lastData]);
    }

}
