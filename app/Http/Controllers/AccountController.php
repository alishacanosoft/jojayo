<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Account;

class AccountController extends Controller
{

    protected $payment = null;
    protected $account = null;

    public function __construct(Payment $payment, Account $account){
        //$this->authorizeResource(Account::class, 'account');
        $this->payment = $payment;
        $this->account = $account;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $active_tab = 'manage';
        $allAccount = $this->account->get();
        $methods = $this->payment->get();
        return view('admin.pages.accounts', compact('allAccount', 'active_tab', 'methods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active_tab = 'create';
        $methods = $this->payment->get();
        $allAccount = $this->account->get();
        return view('admin.pages.add_account', compact('methods', 'active_tab', 'allAccount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $rules = $this->account->getRules();
      $request->validate($rules);
      $data = $request->all();
      $data['name'] = $request->name;
      $data['account_holder'] = $request->account_holder;
      $data['account_number'] = $request->account_number;
      $data['payment_id'] = $request->payment_id;
      $data['status'] = $request->status;
      $this->account->fill($data);
      $status = $this->account->save();
      if($status){
          $request->session()->flash('success','Account created successfully.');
      } else {
          $request->session()->flash('error','Problem while creating account.');
      }
      return redirect()->route('accounts.index');
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
      $active_tab = 'create';
      $data = $this->account->find($id);
      if(!$data) {
          request()->session()->flash('error','Account not found');
          return redirect()->back();
      }
      $methods = $this->payment->get();
      $allAccount = $this->account->get();
      return view('admin.pages.add_account', compact('data','methods', 'active_tab', 'allAccount'));
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
      $this->account = $this->account->find($id);
      if(!$this->account) {
          request()->session()->flash('error','Account not found');
          return redirect()->back();
      }
      $rules = $this->account->getRules('update');
      $request->validate($rules);
      $data = $request->all();
      $this->account->fill($data);
      $success = $this->account->save();
      if($success){
          $request->session()->flash('success','Account updated successfully.');
      } else {
          $request->session()->flash('error','Problem while updating account.');
      }
      return redirect()->route('accounts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $this->account = $this->account->find($id);
      if(!$this->account){
          request()->session()->flash('error','Account Not found');
          return redirect()->route('accounts.index');
      }

      $success = $this->account->delete();
      if($success){
          request()->session()->flash('success','Account deleted successfully.');
      } else {
          request()->session()->flash('error','Sorry! Account could not be deleted at this moment.');
      }
      return redirect()->route('accounts.index');
    }

    public function getAccounts(Request $request){
        $accounts = $this->account->where('payment_id', $request->payment_id)->get();
        if(!empty($accounts)){
            return response()->json($accounts);
        } else {
          return response()->json('No account found!');
        }

    }
}
