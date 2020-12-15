<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\City;

class AreaController extends Controller
{

    protected $city = null;
    protected $area = null;

    public function __construct(City $city, Area $area){
      $this->city = $city;
      $this->area = $area;
    }

    public function index()
    {
      $area_lists = $this->area->get();
      $all_cities = $this->city->get();
      $active_tab = "manage";
      return view('admin.pages.areas', compact('area_lists', 'all_cities', 'active_tab'));
    }


    public function create()
    {
      $all_cities = $this->city->get();
      $area_lists = $this->area->get();
      $active_tab = "create";
      return view('admin.pages.areas', compact('all_cities', 'area_lists', 'active_tab'));
    }


    public function store(Request $request)
    {
      $rules = $this->area->getRules();
      $request->validate($rules);
      $data = $request->all();
      $data['city_id'] = $request->city_id;
      $data['name'] = $request->name;
      $data['delivery_charge'] = $request->delivery_charge;
      $data['express_charge'] = $request->express_charge;
      $this->area->fill($data);
      $status = $this->area->save();
      if($status){
          $notification = array(
            'alert-type' => 'success',
            'message' => 'Area added successfully.'
          );
      } else {
          $notification = array(
            'alert-type' => 'error',
            'message' => 'Problem while adding area.'
          );
      }
      return redirect()->route('areas.index')->with($notification);
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request, $id)
    {
      $data = $this->area->find($id);
      if(!$data) {
          $notification = array(
            'alert-type' => 'error',
            'message' => 'Area not found.'
          );
          return redirect()->back()->with($notification);
      }
      $all_cities = $this->city->get();
      $area_lists = $this->area->get();
      $active_tab = "create";
      if($request->ajax()){
          return response()->json($data);
      }
      return view('admin.pages.areas', compact('all_cities','data','area_lists','active_tab'));
    }

    public function update(Request $request, $id)
    {
      $this->area = $this->area->find($id);
      if(!$this->area) {
          $notification = array(
            'alert-type' => 'error',
            'message' => 'Area not found.'
          );
          return redirect()->back()->with($notification);
      }
      $rules = $this->area->getRules('update');
      $request->validate($rules);
      $data = $request->all();
      $this->area->fill($data);
      $success = $this->area->save();
      if($success){
          $notification = array(
            'alert-type' => 'success',
            'message' => 'Area updated successfully.'
          );
      } else {
          $notification = array(
            'alert-type' => 'error',
            'message' => 'Problem while updating area.'
          );
      }
      return redirect()->route('areas.index')->with($notification);
    }

    public function destroy($id)
    {
      $this->area = $this->area->find($id);
      if(!$this->area){
          $notification = array(
            'alert-type' => 'error',
            'message' => 'Area Not found.'
          );
          return redirect()->route('areas.index')->with($notification);
      }
      $success = $this->area->delete();
      if($success){
          $notification = array(
            'alert-type' => 'success',
            'message' => 'Area deleted successfully.'
          );
      } else {
          $notification = array(
            'alert-type' => 'error',
            'message' => 'Sorry! Area could not be deleted at this moment.'
          );
      }
      return redirect()->route('areas.index');
    }
    
    public function getArea(Request $request){
        $all_areas = $this->area->where('city_id', $request->id)->get();
        return response()->json($all_areas);
    }
}
