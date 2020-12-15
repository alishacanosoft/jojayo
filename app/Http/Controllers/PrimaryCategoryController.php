<?php

namespace App\Http\Controllers;

use App\Models\PrimaryCategory;
use Illuminate\Http\Request;

class PrimaryCategoryController extends Controller
{

    protected $primary_category = null;

    public function __construct(PrimaryCategory $primary_category)
    {
        //$this->authorizeResource(PrimaryCategory::class, 'primarycategory');
        $this->primary_category = $primary_category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allCategories = $this->primary_category->orderBy('created_at', 'desc')->get();
        $active_tab = "primary";
        return view('admin.pages.primary', compact('allCategories','active_tab'));
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
        $rules = $this->primary_category->getRules();
        $request->validate($rules);
        $data = $request->all();
        $data['name'] = $request->name;
        $data['icon'] = $request->icon;
        $this->primary_category->fill($data);
        $status = $this->primary_category->save();
        if($status){
            $notification = array(
              'message' => 'Primary category created successfully.',
              'alert_type' => 'success'
            );
            return response()->json($notification);
        } else {
            $notification = array(
              'message' => 'Problem creating primary category.',
              'alert_type' => 'error'
            );
            return response()->json($notification);
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

    public function lastData(){
        $lastData = $this->primary_category->orderBy('id', 'desc')->first();
        return response()->json(['lastData'=>$lastData]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->primary_category->where('id', $id)->first();
        if(!$data){
            request()->session()->flash('error','Primary category Not found');
            return redirect()->route('product_categories.index');
        }
        return view('admin.pages.primary_category_edit', compact('data'));

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
        $this->primary_category = $this->primary_category->find($id);
        if(!$this->primary_category) {
            request()->session()->flash('error','Primary category not found');
            return redirect()->back();
        }
        $rules = $this->primary_category->getRules('update');
        $request->validate($rules);
        $data = $request->all();
        $this->primary_category->fill($data);
        $success = $this->primary_category->save();
        if($success){
            $notification = array(
              'message' => 'Primary category updated successfully.',
              'alert-type' => 'success'
            );
        } else {
            $notification = array(
              'message' => 'Problem while updating primary category.',
              'alert-type' => 'error'
            );
        }
        return redirect()->route('primary_categories.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->primary_category = $this->primary_category->find($id);
        if(!$this->primary_category){
            $notification = array(
              'message' => 'Primary category Not found.',
              'alert_type' => 'error'
            );
            return redirect()->route('primary_categories.index')->with($notification);
        }

        $success = $this->primary_category->delete();
        if($success){
            $notification = array(
              'message' => 'Primary category deleted successfully.',
              'alert_type' => 'success'
            );
            return response()->json($notification);
        } else {
            $notification = array(
              'message' => 'Problem deleting primary category.',
              'alert_type' => 'error'
            );
            return response()->json($notification);
        }
    }

    public function getPrimaryController(){
        $parent = $this->primary_category->get();
        return response()->json($parent);
    }
}
