<?php

namespace App\Http\Controllers;

use App\Officecategory;
use App\Officevoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfficeVouchersController extends Controller
{

    protected $Officevoucher = null;
    protected $category = null;

    public function __construct(Officevoucher $Officevoucher , Officecategory $category)
    {
        $this->Officevoucher = $Officevoucher;
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $allvoucher =  $this->Officevoucher->get();
        $active_tab = 'manage';
        $categories = $this->category->get();
        return view('admin.pages.officevoucher', compact('active_tab', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->Officevoucher->getRules('adds');
        $request->validate($rules);
        $data = [
            'category_id' => $request->input('category_id'),
            'price'       => $request->input('price'),
            'description' => $request->input('description'),
            'narrative'   => $request->input('narrative'),
            'created_at'  => date('Y-m-d')
        ];
        $status = Officevoucher::create($data);

        //taking last inserted ID after inserting data
        $lastinsertedID = $status->id;
        $updatedata            = Officevoucher::find($lastinsertedID);
        //creating the voucher ID with string pad function and keeping last inserted ID as main core count
        $updatedata->voucherid = "JOJ". date('Y') .'-' . str_pad($lastinsertedID, '5', '0', STR_PAD_LEFT);
        //updating the created voucher ID to the same last inserted data.
        $updatestat = $updatedata->update();

        if($updatestat){
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Voucher created successfully.'
            );
        } else {
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Problem while creating Voucher.'
            );
        }
        return redirect()->route('office_voucher.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //code here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Officevoucher::find($id);
        $active_tab = 'create';
        $categories = $this->category->get();
        if(!$data) {
            request()->session()->flash('error','Voucher not found');
            return redirect()->back();
        }
        return view('admin.pages.officevoucher', compact('categories','data','active_tab'));
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
        $data  = $this->Officevoucher->find($id);

        if(!$data) {
            request()->session()->flash('error','Voucher not found');
            return redirect()->back();
        }

        $data->voucherid       = $request->input('voucherid');
        $data->category_id     = $request->input('category_id');
        $data->price           = $request->input('price');
        $data->description     = $request->input('description');
        $data->narrative       = $request->input('narrative');

        $rules = $this->Officevoucher->getRules('adds');
        $request->validate($rules);

        $status         = $data->update();
        if($status){
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Voucher updated successfully.'
            );
        } else {
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Problem while updating Voucher.'
            );
        }
        return redirect()->route('office_voucher.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Officevoucher::find($id);
        if(!$delete){
            request()->session()->flash('error','Voucher Not found');
            return redirect()->route('office_voucher.index');
        }
        $status        = $delete->delete();
        if($status){
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Voucher deleted successfully.'
            );
        } else {
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Sorry! Voucher could not be deleted at this moment.'
            );
        }
        return redirect()->route('office_voucher.index')->with($notification);
    }

}
