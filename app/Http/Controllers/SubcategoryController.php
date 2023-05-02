<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use DB;
use Exception;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct(){
        $this->middleware('permission:subcategory-list|subcategory-create|subcategory-edit|subcategory-delete', ['only' => ['index','store']]);
        $this->middleware('permission:subcategory-create', ['only' => ['create','store']]);
        $this->middleware('permission:subcategory-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:subcategory-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $subcategories = Subcategory::all();
        return view('subcategory.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = DB::table('categories')->pluck('name', 'id');
        return view('subcategory.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
        ]);
        $input = $request->all();
        $input['created_by'] = $request->user()->id;
        $input['updated_by'] = $request->user()->id;
        try{
            Subcategory::create($input);
        }catch(Exception $e){
            return redirect()->back()->with('error', 'Duplicate Entry')->withInput($request->all());
        }
        return redirect()->route('subcategory')->with('success', 'Subcategory created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subcategory = Subcategory::find(decrypt($id));
        $categories = DB::table('categories')->pluck('name', 'id');
        return view('subcategory.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
        ]);
        $input = $request->all();
        $input['updated_by'] = $request->user()->id;
        $subcategory = Subcategory::find($id);
        try{
            $subcategory->update($input);
        }catch(Exception $e){
            return redirect()->back()->with('error', 'Duplicate Entry')->withInput($request->all());
        }        
        return redirect()->route('subcategory')->with('success', 'Subcategory updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Subcategory::find($id)->delete();
        return redirect()->route('subcategory')->with('success', 'Subcategory deleted successfully');
    }
}
