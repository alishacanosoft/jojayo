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
        $data['image'] = $request->image;
        $this->ads->fill($data);
        $status = $this->ads->save();
        if($status){
            $request->session()->flash('success','Ad created successfully.');
        } else {
            $request->session()->flash('error','Problem while creating ad.');
        }
        return redirect()->back();
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
        $data = $this->ads->find($id);
        if(!$data) {
            return response()->json('Ads not found');
        }
        return response()->json($data);
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
        $data = $request->all();
        $this->ads->fill($data);
        $success = $this->ads->save();
        if($success){
            $request->session()->flash('success','Ad updated successfully.');
        } else {
            $request->session()->flash('error','Problem while updating ad.');
        }
        return redirect()->route('ads.index');
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
