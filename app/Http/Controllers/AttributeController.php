<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\AttributeValue;
use DB;

class AttributeController extends Controller
{
    protected $attribute = null;
    protected $attribute_value = null;

    public function __construct(Attribute $attribute, AttributeValue $attribute_value){
        $this->attribute = $attribute;
        $this->attribute_value = $attribute_value;
    }

    public function index()
    {
        $active_tab = 'manage';
        $all_attribute = $this->attribute->with('attributeValue')->orderBy('name')->get();        
        return view('admin.pages.attribute', compact('active_tab','all_attribute'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active_tab = 'create';
        $all_attribute = $this->attribute->with('attributeValue')->orderBy('name')->get();
        return view('admin.pages.attribute', compact('active_tab','all_attribute'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->attribute->getRules();
        $request->validate($rules);
        $data = $request->all();
        $data['name'] = $request->name;
        $data['slug'] = $request->slug;
        $data['field'] = $request->field;
        $this->attribute->fill($data);
        $status = $this->attribute->save();
        $product_attribute_id = $this->attribute->id;
        if($status){
            if(!empty($request->value)){
            $attr = explode(',', $request->value);
                for($i=0; $i<count($attr); $i++){
                    $this->attr = new AttributeValue;
                    $slug_data = strtolower(str_replace(' ', '-', trim($attr[$i])));
                    $attr_data['slug'] = $slug_data;
                    $attr_data['value'] = $attr[$i];
                    $attr_data['attribute_id'] = $product_attribute_id;
                    $this->attr->fill($attr_data);
                    $this->attr->save();
                }
            }
            $notification = array(
                'message' => 'Attribute created successfully.',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Problem while adding attribute.',
                'alert-type' => 'error'
            );
        }
        return redirect()->route('attributes.index')->with($notification);
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
        $data = $this->attribute->with('attributeValue')->find($id);
        $all_attribute = $this->attribute->with('attributeValue')->orderBy('name')->get();
        if(!$data){
            request()->session()->flash('error','Attribute Not found');
            return redirect()->back();
        }
        return view('admin.pages.attribute', compact('active_tab', 'data','all_attribute'));
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
        $this->attribute = $this->attribute->find($id);
         if(!$this->attribute) {
             request()->session()->flash('error','Attribute not found');
             return redirect()->back();
         }
         $rules = $this->attribute->getRules('update');
         $request->validate($rules);
         $data = $request->all();
         $this->attribute->fill($data);
         $success = $this->attribute->save();
         $product_attribute_id = $this->attribute->id;
        if($success){
            if(!empty($request->value)){
            $attribute_to_delete = $this->attribute_value->where('attribute_id', $id)->get()->toArray();
            $ids_to_delete = array_map(function($item){ return $item['id']; }, $attribute_to_delete);
            DB::table('attribute_values')->whereIn('id', $ids_to_delete)->delete();
            $attr = explode(',', $request->value);
                for($i=0; $i<count($attr); $i++){
                    $this->attr = new AttributeValue;
                    $slug_data = strtolower(str_replace(' ', '-', trim($attr[$i])));
                    $attr_data['slug'] = $slug_data;
                    $attr_data['value'] = $attr[$i];
                    $attr_data['attribute_id'] = $product_attribute_id;
                    $this->attr->fill($attr_data);
                    $this->attr->save();
                }
            }
            $notification = array(
                'message' => 'Attribute updated successfully.',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Problem while updating attribute.',
                'alert-type' => 'error'
            );
        }
         return redirect()->route('attributes.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->attribute = $this->attribute->find($id);
        if(!$this->attribute){
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Attribute Not found.'
            );
            return redirect()->route('attributes.index')->with('notification');
        }

        $success = $this->attribute->delete();
        if($success){
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Attribute deleted successfully.'
            );
        } else {
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Sorry! Attribute could not be deleted at this moment.'
            );
        }
        return redirect()->route('attributes.index')->with($notification);
    }
}
