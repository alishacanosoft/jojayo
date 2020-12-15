<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $category = null;
    protected $blog = null;

    public function __construct(Blog $blog,Category $category)
    {
        //$this->authorizeResource(Blog::class, 'blog');
        $this->blog = $blog;
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allPosts = $this->blog->get();
        return view('admin.pages.blogs', compact('allPosts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->category->get();
        return view('admin.pages.add_blog', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->blog->getRules();
        $request->validate($rules);
        $data = $request->all();
        $data['title'] = $request->title;
        $data['excerpt'] = $request->excerpt;
        $data['description'] = $request->description;
        $data['slug'] = $request->slug;
        $data['feature'] = $request->feature;
        $data['status'] = $request->status;
        $data['category_id'] = $request->category_id;
        $data['image'] = $request->image;
        $this->blog->fill($data);
        $status = $this->blog->save();
        if($status){
            $request->session()->flash('success','Blog created successfully.');
        } else {
            $request->session()->flash('error','Problem while creating blog.');
        }
        return redirect()->route('blogs.index');

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
        $data = $this->blog->find($id);
        if(!$data) {
            request()->session()->flash('error','Post not found');
            return redirect()->back();
        }

        $categories = $this->category->get();
        return view('admin.pages.add_blog', compact('categories','data'));
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
        $this->blog = $this->blog->find($id);
        if(!$this->blog) {
            request()->session()->flash('error','Post not found');
            return redirect()->back();
        }
        $rules = $this->blog->getRules('update');
        $request->validate($rules);
        $data = $request->all();
        $this->blog->fill($data);
        $success = $this->blog->save();
        if($success){
            $request->session()->flash('success','Post updated successfully.');
        } else {
            $request->session()->flash('error','Problem while updating post.');
        }
        return redirect()->route('blogs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->blog = $this->blog->find($id);
        if(!$this->blog){
            request()->session()->flash('error','Post Not found');
            return redirect()->route('blogs.index');
        }

        $success = $this->blog->delete();
        if($success){
            request()->session()->flash('success','Post deleted successfully.');
        } else {
            request()->session()->flash('error','Sorry! Post could not be deleted at this moment.');
        }
        return redirect()->route('blogs.index');
    }

    public function detail($slug){
        $data = $this->blog->where('slug',$slug)->first();
        if(!$this->blog){
            request()->session()->flash('error','Post Not found');
            return redirect()->back();
        }
        return view('frontend.pages.blog_details', compact('data'));
    }
}
