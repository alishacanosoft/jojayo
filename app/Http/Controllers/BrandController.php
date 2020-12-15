<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    protected $brands = null;

    public function __construct(Brand $brands)
    {
        //$this->authorizeResource(BrandCategory::class, 'brand');
        $this->brands = $brands;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allBrands = $this->brands->get();
        return view('admin.pages.brands', compact('allBrands'));
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
        $rules = $this->brands->getRules();
        $request->validate($rules);
        $data = $request->all();
        $data['name'] = $request->name;
        $data['slug'] = $request->slug;
        if($request->hasFile('logo')){ 
            $logo = uploadImage($request->logo, 'brands', '100x100');
        }
        $data['logo'] = $logo;
        $this->brands->fill($data);
        $status = $this->brands->save();
        if($status){
            $notification = array(
                'message' => 'Brand added successfully.',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Brand could not be created.',
                'alert-type' => 'error'
            );            
        }
        return redirect()->route('brands.index')->with($notification);
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

    public function brandLastData(){
        $lastData = $this->brands->orderBy('id', 'desc')->first();
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
        //
    }

    public function editBrand($slug){
        $data = $this->brands->where('slug', $slug)->first();
        if(!$data){
            $notification = array(
                'message' => 'Brand Not found.',
                'alert-type' => 'error'
            );
            return redirect()->route('brands.index')->with($notification);
        }
        return view('admin.pages.brandEdit', compact('data'));
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
        $this->brands = $this->brands->find($id);
        $old_logo = $this->brands->logo;
        if(!$this->brands) {
            $notification - array(
                'message' => 'Brand not found.',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
        $request['parent'] = $request->parent == 0 ? null : $request->parent;
        $rules = $this->brands->getRules('update');
        $request->validate($rules);
        $data = $request->all();
        if($request->hasFile('logo')){ 
            $logo = uploadImage($request->logo, 'brands', '100x100');
            if(file_exists(public_path().'/uploads/brands/'.$old_logo))
            {
                unlink(public_path().'/uploads/brands/'.$old_logo);
                unlink(public_path().'/uploads/brands/Thumb-'.$old_logo);
            } 
        }
        $data['logo'] = $logo;
        $this->brands->fill($data);
        $success = $this->brands->save();
        if($success){
            $notification = array(
                'message' => 'Brand updated successfully.',
                'alert-type' => 'success'
            );
        } else {
            $notification - array(
                'message' => 'Problem while updating brand.',
                'alert-type' => 'error'
            );
        }
        return redirect()->route('brands.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->brands = $this->brands->find($id);
        if(!$this->brands){
            $notification = array(
                'message' => 'Brand not found.',
                'alert_type' => 'error'
            );
            
            return response()->json($notification);
        }

        $success = $this->brands->delete();
        if($success){
            $notification = array(
                'message' => 'Brand deleted successfully.',
                'alert_type' => 'success'
            );
            return response()->json($notification);
        } else {
            $notification = array(
                'message' => 'Brand could not be deleted.',
                'alert_type' => 'error'
            );
            return response()->json($notification);
        }
    }
}