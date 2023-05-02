<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct(){
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','store']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = DB::table('categories')->pluck('name', 'id');
        $subcategories = DB::table('subcategories')->pluck('name', 'id');
        return view('product.create', compact('categories', 'subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:products,name',
            'category_id' => 'required',
            'subcategory_id' => 'required',
        ]);
        $input = $request->all();
        $input['created_by'] = $request->user()->id;
        $input['updated_by'] = $request->user()->id;
        $input['code'] = productcode($request->category_id);
        Product::create($input);
        return redirect()->route('product')->with('success', 'Product created successfully');
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
        $product = Product::find(decrypt($id));
        $categories = DB::table('categories')->pluck('name', 'id');
        $subcategories = DB::table('subcategories')->pluck('name', 'id');
        return view('product.edit', compact('subcategories', 'categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:products,name,'.$id,
            'category_id' => 'required',
            'subcategory_id' => 'required',
        ]);
        $input = $request->all();
        $input['updated_by'] = $request->user()->id;
        $product = Product::find($id);
        $product->update($input);
        return redirect()->route('product')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::find($id)->delete();
        return redirect()->route('product')->with('success', 'Product deleted successfully');
    }
}
