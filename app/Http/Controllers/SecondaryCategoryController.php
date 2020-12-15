<?php

namespace App\Http\Controllers;

use App\Models\PrimaryCategory;
use App\Models\SecondaryCategory;
use Illuminate\Http\Request;

class SecondaryCategoryController extends Controller
{

    protected $secondary_category = null;
    protected $primary_category = null;

    public function __construct(SecondaryCategory $secondary_category, PrimaryCategory $primary_category)
    {
        //$this->authorizeResource(SecondaryCategory::class, 'secondarycategory');
        $this->secondary_category = $secondary_category;
        $this->primary_category = $primary_category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allCategories = $this->secondary_category->orderBy('created_at', 'desc')->get();
        return view('admin.pages.secondary', compact('allCategories'));
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
        $rules = $this->secondary_category->getRules();
        $request->validate($rules);
        $data = $request->all();
        $data['name'] = $request->name;
        $data['primary_category_id'] = $request->primary_category_id;
        $this->secondary_category->fill($data);
        $status = $this->secondary_category->save();
        if($status){
            $notification = array(
                'message' => 'Secondary category created successfully.',
                'alert_type' => 'success'
            );
            return response()->json($notification);
        } else {
            $notification = array(
                'message' => 'Problem creating secondary category.',
                'alert_type' => 'error'
            );
            return response()->json($notification);
            // return response()->json(['status'=>false,'data'=>null]);
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
        $lastData = $this->secondary_category->orderBy('id', 'desc')->first();
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
        $data = $this->secondary_category->where('id', $id)->first();
        if(!$data){
            $notification = array(
                'message' => 'Secondary category not found.',
                'alert-type' => 'error'
            );
            return redirect()->route('secondary_categories.index')->with($notification);
        }
        $parent = $this->primary_category->get();
        return view('admin.pages.secondary_category_edit', compact('data', 'parent'));
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
        $this->secondary_category = $this->secondary_category->find($id);
        if(!$this->secondary_category) {
            $notification = array(
                'message' => 'Secondary category not found.',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        $rules = $this->secondary_category->getRules('update');
        $request->validate($rules);
        $data = $request->all();
        $this->secondary_category->fill($data);
        $success = $this->secondary_category->save();
        if($success){
            $notification = array(
                'message' => 'Secondary category updated successfully.',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Problem while updating secondary category.',
                'alert-type' => 'error'
            );
        }
        return redirect()->route('secondary_categories.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->secondary_category = $this->secondary_category->find($id);
        if(!$this->secondary_category){
            $notification = array(
                'message' => 'Secondary category not found.',
                'alert_type' => 'error'
            );
            return redirect()->route('secondary_categories.index')->with($notification);
        }
        $success = $this->secondary_category->delete();
        if($success){
            $notification = array(
                'message' => 'Secondary category deleted successfully.',
                'alert_type' => 'success'
            );
            return response()->json($notification);
        } else {
            $notification = array(
                'message' => 'Secondary category cannot be deleted.',
                'alert_type' => 'error'
            );
            return response()->json($notificaton);
        }
    }
}
