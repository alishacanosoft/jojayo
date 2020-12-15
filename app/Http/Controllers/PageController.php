<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    protected $page = null;

    public function __construct(Page $page)
    {
        $this->page = $page;
        //$this->authorizeResource(Page::class, 'page');
    }

    public function index()
    {
        $active_tab = "manage";
        $all_pages = $this->page->get();
        return view('admin.pages.pages', compact('active_tab','all_pages'));
    }

   
    public function create()
    {
        $active_tab = "create";
        $all_pages = $this->page->get();
        return view('admin.pages.pages', compact('active_tab', 'all_pages'));
    }

   
    public function store(Request $request)
    {
        $rules = $this->page->getRules();
        $request->validate($rules);
        $data = $request->all();
        $data['title'] = $request->title;
        $data['excerpt'] = $request->excerpt;
        $data['description'] = $request->description;
        $data['slug'] = $request->slug;
        $data['status'] = $request->status;
        $this->page->fill($data);
        $status = $this->page->save();
        if($status){
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Blog created successfully.'
            );
        } else {
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Problem while creating blog.'
            );
        }
        return redirect()->route('page.index')->with($notification);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = $this->page->find($id);
        $active_tab = "create";
        $all_pages = $this->page->get();
        if(!$data) {
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Page not found.'
            );
            return redirect()->back()->with($notification);
        }
        return view('admin.pages.pages', compact('data','active_tab','all_pages'));
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
        $this->page = $this->page->find($id);
        if(!$this->page) {
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Page not found.'
            );
            return redirect()->back()->with('notification');
        }
        $rules = $this->page->getRules('update');
        $request->validate($rules);
        $data = $request->all();
        $this->page->fill($data);
        $success = $this->page->save();
        if($success){
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Page updated successfully.'
            );
        } else {
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Problem while updating page.'
            );
        }
        return redirect()->route('page.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->page = $this->page->find($id);
        if(!$this->page){
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Page Not found.'
            );
            return redirect()->route('page.index')->with('notification');
        }

        $success = $this->page->delete();
        if($success){
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Page deleted successfully.'
            );
        } else {
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Sorry! Page could not be deleted at this moment.'
            );
        }
        return redirect()->route('page.index')->with('notification');
    }
}
