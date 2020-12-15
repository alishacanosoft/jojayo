<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{

    protected $color = null;

    public function __construct(Color $color)
    {
        $this->color = $color;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $active_tab = "manage";
        $all_color = $this->color->orderBy('name', 'asc')->get();
        return view('admin.pages.color', compact('active_tab','all_color'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active_tab = "create";
        $all_color = $this->color->orderBy('name', 'asc')->get();
        return view('admin.pages.color', compact('active_tab','all_color'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->color->getRules();
        $request->validate($rules);
        $data = $request->all();
        $data['title'] = $request->title;
        $data['code'] = $request->code;
        $this->color->fill($data);
        $status = $this->color->save();
        if($status){
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Color created successfully.'
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
        $data = $this->color->find($id);
        $active_tab = 'create';
        if(!$data) {
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Color not found.'
            );
            return redirect()->back()->with($notification);
        }
        return view('admin.pages.color',compact('data','active_tab'));
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
        $this->color = $this->color->find($id);
        if(!$this->color) {
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Color not found.'
            );
            return redirect()->back()->with($notification);
        }
        $rules = $this->color->getRules('update');
        $request->validate($rules);
        $data = $request->all();
        $this->color->fill($data);
        $success = $this->color->save();
        if($success){
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Color updated successfully.'
            );
        } else {
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Problem while updating color.'
            );
        }
        return redirect()->route('colors.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->color = $this->color->find($id);
        if(!$this->color){
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Color Not found.'
            );
            return redirect()->route('colors.index')->with($notification);
        }

        $success = $this->color->delete();
        if($success){
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Color deleted successfully.'
            );
        } else {
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Sorry! Color could not be deleted at this moment.'
            );
        }
        return redirect()->route('colors.index')->with($notification);
    }
    public function getColors(){
        $allColours = $this->color->get();
        return response()->json($allColours);
    }
}
