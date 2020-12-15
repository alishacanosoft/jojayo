<?php

namespace App\Http\Controllers;

use App\Models\SensitiveData;
use Illuminate\Http\Request;

class SensitiveDataController extends Controller
{

    protected $sensitive = null;

    public function __construct(SensitiveData $sensitive)
    {
        $this->sensitive = $sensitive;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->sensitive->first();
        return view('admin.pages.settings', compact('data'));
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
      $rules = $this->sensitive->getRules();
      $request->validate($rules);
      $data = $request->all();
      $data['web_title'] = $request->web_title;
      $data['keywords'] = $request->keywords;
      $data['meta_description'] = $request->meta_description;
      $data['company'] = $request->company;
      $data['registration'] = $request->registration;
      $data['vat'] = $request->vat;
      $data['pobox'] = $request->pobox;
      $data['facebook'] = $request->facebook;
      $data['twitter'] = $request->twitter;
      $data['linkedin'] = $request->linkedin;
      $data['instagram'] = $request->instagram;
      $data['youtube'] = $request->youtube;
      $data['landline'] = $request->landline;
      $data['landline1'] = $request->landline1;
      $data['landline2'] = $request->landline2;
      $data['mobile'] = $request->mobile;
      $data['mobile1'] = $request->mobile1;
      $data['email'] = $request->email;
      $data['email1'] = $request->email1;
      $data['location'] = $request->location;
      $data['map'] = $request->map;
      $data['g_analytics'] = $request->g_analytics;
      $data['logo'] = $request->logo;
      $this->sensitive->fill($data);
      $status = $this->sensitive->save();
      if($status){
          $request->session()->flash('success','Data created successfully.');
      } else {
          $request->session()->flash('error','Problem while adding data.');
      }
      return redirect()->route('settings.index');
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
        //
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
      $this->sensitive = $this->sensitive->find($id);
      if(!$this->sensitive) {
          request()->session()->flash('error','Data not found');
          return redirect()->back();
      }
      $rules = $this->sensitive->getRules('update');
      $request->validate($rules);
      $data = $request->all();
      $this->sensitive->fill($data);
      $success = $this->sensitive->save();
      if($success){
          $request->session()->flash('success','Data updated successfully.');
      } else {
          $request->session()->flash('error','Problem while updating data.');
      }
      return redirect()->route('settings.index');
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
