<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    protected $slider = null;

    public function __construct(Slider $slider){
        $this->slider = $slider;
    }

    public function index()
    {
        $active_tab = 'manage';
        $all_slider = $this->slider->orderBy('created_at', 'desc')->get();
        return view('admin.pages.sliders', compact('active_tab','all_slider'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active_tab = 'create';
        $all_slider = $this->slider->orderBy('created_at', 'desc')->get();
        return view('admin.pages.sliders', compact('active_tab','all_slider'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->slider->getRules('add');
        $request->validate($rules);
        $data = $request->all();
        $data['name'] = $request->name;
        $data['url'] = $request->url;
        $data['status'] = $request->status;
        if($request->hasFile('image')){  
            $slider_image = uploadImage($request->image, 'slider', '840x395');
            $data['image'] = $slider_image;
        }
        $this->slider->fill($data);
        $status = $this->slider->save();
        if($status){
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Slider added successfully.'
            );
        } else {
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Problem while adding slider.'
            );
        }
        return redirect()->route('sliders.index')->with($notification);
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
        $data = $this->slider->find($id);
        $active_tab = 'create';
        if(!$data) {
            request()->session()->flash('error','Slider not found');
            return redirect()->back();
        }
        return view('admin.pages.sliders', compact('data','active_tab'));
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
        $this->slider = $this->slider->find($id);
        if(!$this->slider) {
            request()->session()->flash('error','Slider not found');
            return redirect()->back();
        }
        $rules = $this->slider->getRules('update');
        $request->validate($rules);
        $data = $request->all();
        if($request->hasFile('image')){  
            $slider_image = uploadImage($request->image, 'slider', '840x395');
            $data['image'] = $slider_image;            
            if(file_exists(public_path().'/uploads/slider/'.$this->slider->image))
            {
                unlink(public_path().'/uploads/slider/'.$this->slider->image);
                unlink(public_path().'/uploads/slider/Thumb-'.$this->slider->image);
            }            
        } else {
            $data['image'] = $this->slider->image; 
        }
        $this->slider->fill($data);
        $success = $this->slider->save();
        if($success){
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Slider updated successfully.'
            );
        } else {
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Problem while updating slider.'
            );
        }
        return redirect()->route('sliders.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->slider = $this->slider->find($id);
        if(!$this->slider){
            request()->session()->flash('error','Slider Not found');
            return redirect()->route('sliders.index');
        }

        $success = $this->slider->delete();
        if($success){
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Slider deleted successfully.'
            );
        } else {
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Sorry! Slider could not be deleted at this moment.'
            );
        }
        return redirect()->route('sliders.index')->with($notification);
    }
}
