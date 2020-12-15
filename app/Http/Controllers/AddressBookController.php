<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AddressBook;
use App\Models\Region;

class AddressBookController extends Controller
{

    protected $address_books = null;
    protected $region = null;

    public function __construct(AddressBook $address_books, Region $region){
        $this->address_books = $address_books;
        $this->region = $region;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $my_address = $this->address_books->where('user_id', \Auth::user()->id)->get();
        return view('frontend.pages.address-book-data', compact('my_address'));
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
      $rules = $this->address_books->getRules();
      $request->validate($rules);
      $data = $request->all();
      $data['user_id'] = \Auth::user()->id;
      $data['name'] = $request->name;
      $data['phone'] = $request->phone;
      $data['region_id'] = $request->region_id;
      $data['city'] = $request->city;
      $data['area'] = $request->area;
      $data['address'] = $request->address;
      $data['location'] = $request->location;
      $this->address_books->fill($data);
      $status = $this->address_books->save();
      if($status){
          $request->session()->flash('success','Address saved successfully!');
      } else {
          $request->session()->flash('error','Problem while adding address.');
      }
      return redirect()->route('address.index');
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
      $data = $this->address_books->find($id);
      if(!$data) {
          request()->session()->flash('error','Address not found');
          return redirect()->back();
      }
      $region_data = $this->region->get();
      return view('frontend.pages.address-book', compact('region_data','data'));
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
      $this->address_books = $this->address_books->find($id);
      if(!$this->address_books) {
          request()->session()->flash('error','Address not found');
          return redirect()->back();
      }
      $rules = $this->address_books->getRules('update');
      $request->validate($rules);
      $data = $request->all();
      $this->address_books->fill($data);
      $success = $this->address_books->save();
      if($success){
          $request->session()->flash('success','Address updated successfully.');
      } else {
          $request->session()->flash('error','Problem while updating address.');
      }
      return redirect()->route('address.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $this->address_books = $this->address_books->find($id);
      if(!$this->address_books){
          request()->session()->flash('error','Address not found.');
          return redirect()->route('blogs.index');
      }

      $success = $this->address_books->delete();
      if($success){
          request()->session()->flash('success','Address deleted successfully.');
      } else {
          request()->session()->flash('error','Sorry! Address could not be deleted at this moment.');
      }
      return redirect()->route('address.index');
    }

    public function userAddress($id){
        $user_address = $this->address_books->where('user_id', $id)->where('default', 1)->first();
        return response()->json($user_address);
    }
}
