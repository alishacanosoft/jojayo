<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use Illuminate\Http\Request;

class AdsController extends Controller
{

    protected $ads = null;

    public function __construct(Ads $ads){
        $this->ads = $ads;
        //$this->authorizeResource(Ads::class, 'ads');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_ads = $this->ads->get();
        $active_tab = "manage";
        return view('admin.pages.ads', compact('all_ads', 'active_tab'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_ads = $this->ads->get();
        $active_tab = "create";
        return view('admin.pages.ads', compact('all_ads', 'active_tab'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->ads->getRules();
        $request->validate($rules);
        $data = $request->all();
        $data['title'] = $request->title;
        $data['url'] = $request->url;
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;
        $data['place'] = $request->place;
        if($request->hasFile('image')){
            $dimension = '390x193';
            if($request->place !== 'slider-first' || $request->place !== 'slider-second'){
                $dimension = '1170x245';
            }
            $ads_image = uploadImage($request->image, 'ads', $dimension);
            $data['image'] = $ads_image;
        }
        $this->ads->fill($data);
        $status = $this->ads->save();
        if($status){
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Ad created successfully.'
            );            
        } else {
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Problem while creating ad.'
            );
        }
        return redirect()->back()->with($notification);
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
        $data = $this->ads->find($id);
        if(!$data) {
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Ad not found!'
            );
            return redirect()->back()->with($notification);
        }
        return view('admin.pages.ads', compact('data','active_tab'));
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
        $this->ads = $this->ads->find($id);
        if(!$this->ads) {
            request()->session()->flash('error','Post not found');
            return redirect()->back();
        }
        $rules = $this->ads->getRules('update');
        $request->validate($rules);
        if($request->hasFile('image')){  
            $ads_image = uploadImage($request->image, 'ads', '840x395');
            $data['image'] = $ads_image;            
            if(file_exists(public_path().'/uploads/ads/'.$this->ads->image))
            {
                unlink(public_path().'/uploads/ads/'.$this->ads->image);
                unlink(public_path().'/uploads/ads/Thumb-'.$this->ads->image);
            }            
        } else {
            $data['image'] = $this->ads->image; 
        }
        $data = $request->all();
        $this->ads->fill($data);
        $success = $this->ads->save();
        if($success){
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Ad updated successfully.'
            );            
        } else {
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Problem while updating ad.'
            );            
        }
        return redirect()->route('ads.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->ads = $this->ads->find($id);
        $old_image = $this->ads->image;
        if(!$this->ads){
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Ad not found.'
            ); 
            return redirect()->route('ads.index')->with($notification);
        }
        $success = $this->ads->delete();
        if($success){
            if(file_exists(public_path().'/uploads/ads/'.$old_image))
            {
                unlink(public_path().'/uploads/ads/'.$old_image);
                unlink(public_path().'/uploads/ads/Thumb-'.$old_image);
            }  
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Ad deleted successfully.'
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
