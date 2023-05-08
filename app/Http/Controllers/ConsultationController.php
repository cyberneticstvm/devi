<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\ConsultationType;
use App\Models\Patient;
use App\Models\PaymentMode;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct(){
        $this->middleware('permission:consultation-list|consultation-create|consultation-edit|consultation-delete', ['only' => ['index','store']]);
        $this->middleware('permission:consultation-create', ['only' => ['create','store']]);
        $this->middleware('permission:consultation-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:consultation-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $consultations = Consultation::orderByDesc('id')->get();
        return view('consultation.index', compact('consultations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'purpose_of_visit' => 'required',
            'doctor_id' => 'required',
            'appointment_id' => 'required',
            'patient_id' => 'required',
        ]);
        $input = $request->all();
        $input['mrn'] = mrn();
        $input['mrid'] = Consultation::max('mrid')+1;
        $input['branch_id'] = $request->session()->get('branch');
        $input['created_by'] = $request->user()->id;
        $input['updated_by'] = $request->user()->id;
        $input['doctor_fee'] = getDocFee($request->doctor_id, $request->patient_id);
        Consultation::create($input);
        return redirect()->route('consultation')->with('success','Consultation created successfully');
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
        $con = Consultation::find(decrypt($id)); $doctors = User::role('Doctor')->get();
        $ctypes = ConsultationType::all(); $pmodes = PaymentMode::all();
        return view('consultation.edit', compact('con', 'doctors', 'ctypes', 'pmodes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'purpose_of_visit' => 'required',
            'doctor_id' => 'required',
        ]);
        $input = $request->all();
        $input['updated_by'] = $request->user()->id;
        $input['doctor_fee'] = getDocFee($request->doctor_id, $request->patient_id);
        $con = Consultation::find($id);
        $con->update($input);
        return redirect()->route('consultation')->with('success','Consultation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Consultation::find($id)->delete();
        return redirect()->route('consultation')->with('success','Consultation deleted successfully');
    }
}
