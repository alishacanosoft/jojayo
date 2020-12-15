<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Region;

class CityController extends Controller
{
    protected $city = null;
    protected $region = null;

    public function __construct(City $city, Region $region){
      $this->city = $city;
      $this->region = $region;
    }

    public function index()
    {
      $city_lists = $this->city->get();
      $all_regions = $this->region->get();
      $active_tab = "manage";
      return view('admin.pages.cities', compact('city_lists', 'active_tab', 'all_regions'));
    }

    public function create()
    {
        $all_regions = $this->region->get();
        $city_lists = $this->city->get();
        $active_tab = "create";
        return view('admin.pages.add_city', compact('city_lists', 'active_tab', 'all_regions'));
    }

    public function store(Request $request)
    {
      $rules = $this->city->getRules();
      $request->validate($rules);
      $data = $request->all();
      $data['region_id'] = $request->region_id;
      $data['name'] = $request->name;
      $this->city->fill($data);
      $status = $this->city->save();
      if($status){
          $request->session()->flash('success','City added successfully.');
      } else {
          $request->session()->flash('error','Problem while adding city.');
      }
      return redirect()->route('cities.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
      $data = $this->city->find($id);
      if(!$data) {
          request()->session()->flash('error','City not found');
          return redirect()->back();
      }
      $all_regions = $this->region->get();
      $city_lists = $this->city->get();
      $active_tab = "create";
      return view('admin.pages.cities', compact('all_regions', 'data', 'city_lists','active_tab'));
    }

    public function update(Request $request, $id)
    {
      $this->city = $this->city->find($id);
      if(!$this->city) {
          request()->session()->flash('error','City not found');
          return redirect()->back();
      }
      $rules = $this->city->getRules('update');
      $request->validate($rules);
      $data = $request->all();
      $this->city->fill($data);
      $success = $this->city->save();
      if($success){
          $request->session()->flash('success','City updated successfully.');
      } else {
          $request->session()->flash('error','Problem while updating city.');
      }
      return redirect()->route('cities.index');
    }

    public function destroy($id)
    {
      $this->city = $this->city->find($id);
      if(!$this->city){
          request()->session()->flash('error','City Not found');
          return redirect()->route('cities.index');
      }
      $success = $this->city->delete();
      if($success){
          request()->session()->flash('success','City deleted successfully.');
      } else {
          request()->session()->flash('error','Sorry! City could not be deleted at this moment.');
      }
      return redirect()->route('cities.index');
    }
    
    public function getCity(Request $request){
        $all_cities = $this->city->where('region_id', $request->id)->get();
        return response()->json($all_cities);
    }
}
