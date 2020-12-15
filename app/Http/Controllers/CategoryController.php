<?php

namespace App\Http\Controllers;


use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    protected $category = null;

    public function __construct(Category $category)
    {
        //$this->authorizeResource(Category::class, 'category');
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parent = $this->category->where('is_parent', 1)->get();
        $allCategories = $this->category->get();
        return view('admin.pages.categories', compact('parent', 'allCategories'));
    }

    public function getParentController(){
        $parent = $this->category->where('is_parent', 1)->get();
        return response()->json($parent);
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
        $rules = $this->category->getRules();
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required|string|unique:categories,name',
            'slug' => 'bail|required|string|unique:categories,slug',
            'is_parent' => 'sometimes|numeric',
            'parent' => 'nullable|exists:categories,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->getMessageBag()->toArray()], 422);
        }
        $data = $request->all();
        $data['name'] = $request->name;
        $data['is_parent'] = $request->is_parent;
        $data['parent_id'] = $request->parent_id;
        $data['slug'] = $request->slug;
        $this->category->fill($data);
        $status = $this->category->save();
        if($status){
            return response()->json(['status'=>true,'data'=>'Category created successfully.']);
        } else {
            return response()->json(['status'=>false,'data'=>null]);
        }
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
        $this->category = $this->category->find($id);
        if(!$this->category) {
            request()->session()->flash('error','Category not found');
            return redirect()->back();
        }
        $request['parent'] = $request->parent == 0 ? null : $request->parent;
        $rules = $this->category->getRules('update');
        $request->validate($rules);
        $data = $request->all();
        $data['is_parent'] = $request->parent == null ? 1 : 0;
        $this->category->fill($data);
        $success = $this->category->save();
        if($success){
            $request->session()->flash('success','Category updated successfully.');
        } else {
            $request->session()->flash('error','Problem while updating blog.');
        }
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->category = $this->category->find($id);
        if(!$this->category){
            request()->session()->flash('error','Category Not found');
            return redirect()->route('category.index');
        }

        $success = $this->category->delete();
        if($success){
            return response()->json(['status'=>true,'data'=>'Category deleted successfully.']);
        } else {
            return response()->json(['status'=>false,'data'=>null]);
        }
    }

    public function lastData(){
        $lastData = $this->category->orderBy('id', 'desc')->first();
        $parent = $this->category->where('is_parent', 1)->get();
        return response()->json(['lastData'=>$lastData, 'parent'=>$parent]);
    }

    public function editPostCategory($slug){
        $data = $this->category->where('slug', $slug)->first();
        if(!$data){
            request()->session()->flash('error','Category Not found');
            return redirect()->route('category.index');
        }
        $parent = $this->category->where('is_parent', 1)->get();
        return view('admin.pages.post_category_edit', compact('parent','data'));
    }

}
