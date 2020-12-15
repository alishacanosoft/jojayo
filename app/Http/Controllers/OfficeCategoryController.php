<?php

namespace App\Http\Controllers;

use App\Officecategory;
use Illuminate\Http\Request;

class OfficeCategoryController extends Controller
{

    protected $Officecategory = null;

    public function __construct(Officecategory $Officecategory)
    {
        $this->Officecategory = $Officecategory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $allcategory =  $this->Officecategory->get();
            $active_tab = 'manage';
            return view('admin.pages.officecategory', compact('allcategory','active_tab'));
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
        $rules = $this->Officecategory->getRules();
        $request->validate($rules);
        $data = [
            'name' => $request->input('name'),
        ];
        $status = Officecategory::create($data);
        if($status){
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Office category added successfully.'
            );
        } else {
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Problem while adding Office category.'
            );
        }
        return redirect()->route('office_category.index')->with($notification);
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
        $data = Officecategory::find($id);
        $active_tab = 'create';
        if(!$data) {
            request()->session()->flash('error','Category not found');
            return redirect()->back();
        }
        return view('admin.pages.officecategory', compact('data', 'active_tab'));
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
        $data           = Officecategory::find($id);
        if(!$data) {
            request()->session()->flash('error','Office category not found');
            return redirect()->back();
        }
        $rules = $this->Officecategory->getRules('update');
        $request->validate($rules);
        $data->name     = $request->input('name');
        $status         = $data->update();
        if($status){
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Category updated successfully.'
            );
        } else {
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Problem while updating Category.'
            );
        }
        return redirect()->route('office_category.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deletecat = Officecategory::find($id);
        if(!$deletecat){
            request()->session()->flash('error','Category Not found');
            return redirect()->route('office_category.index');
        }
        $status        = $deletecat->delete();
        if($status){
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Office category deleted successfully.'
            );
        } else {
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Sorry! Office category could not be deleted at this moment.'
            );
        }
        return redirect()->route('office_category.index')->with($notification);
    }
}
