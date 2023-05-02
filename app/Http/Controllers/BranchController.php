<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Spatie\Permission\Contracts\Role;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct(){
        /*$this->middleware('permission:branch-list|branch-create|branch-edit|branch-delete', ['only' => ['index','store']]);
        $this->middleware('permission:branch-create', ['only' => ['create','store']]);
        $this->middleware('permission:branch-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:branch-delete', ['only' => ['destroy']]);*/
   }

    public function index()
    {
        $branches = Branch::all();
        return view('branch.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('branch.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:branches,name',
            'code' => 'required|unique:branches,code',
            'gstin' => 'required',
            'address' => 'required',
            'mobile' => 'required|numeric|digits:10',
        ]);
        $input = $request->all();
        $input['created_by'] = 1;
        $input['updated_by'] = 1;
        Branch::create($input);
        return redirect()->route('branch')->with('success', 'Branch created successfully');
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
        $branch = Branch::find(decrypt($id));
        return view('branch.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:branches,name,'.$id,
            'code' => 'required|unique:branches,code,'.$id,
            'gstin' => 'required',
            'address' => 'required',
            'mobile' => 'required|numeric|digits:10',
        ]);
        $input = $request->all();
        $input['updated_by'] = $request->user()->id;
        $branch = Branch::find($id);
        $branch->update($input);
        return redirect()->route('branch')->with('success', 'Branch updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Branch::find($id)->delete();
        return redirect()->route('branch')->with('success', 'Branch deleted successfully');
    }
}
