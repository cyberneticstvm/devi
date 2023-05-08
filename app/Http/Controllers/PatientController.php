<?php

namespace App\Http\Controllers;

use App\Models\ConsultationType;
use App\Models\Patient;
use App\Models\PaymentMode;
use App\Models\User;
use BaconQrCode\Renderer\Path\Path;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct(){
        $this->middleware('permission:patient-list|patient-create|patient-edit|patient-delete', ['only' => ['index','store']]);
        $this->middleware('permission:patient-create', ['only' => ['create','store']]);
        $this->middleware('permission:patient-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:patient-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $patients = Patient::whereDate('created_at', Carbon::today())->get();
        return view('patient.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($appointment_id)
    {
        return view('patient.create', compact('appointment_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'place' => 'required',
            'mobile' => 'required|numeric|digits:10',
        ]);
        $input = $request->all();
        $input['branch_id'] = $request->session()->get('branch');
        $input['created_by'] = $request->user()->id;
        $input['updated_by'] = $request->user()->id;
        $patients = Patient::where('mobile', $request->mobile)->get();
        $appointment_id = $input['appointment_id'];
        if($patients->isEmpty()):
            $patient = Patient::create($input);
            $doctors = User::role('Doctor')->get();
            $ctypes = ConsultationType::all(); $pmodes = PaymentMode::all();
            return view('consultation.create', compact('patient', 'doctors', 'ctypes', 'appointment_id', 'pmodes'));
            //return redirect()->route('patient')->with('success','Patient created successfully');
        else:
            $request->session()->put('old_patient', $input);
            return view('patient.select', compact('patients', 'appointment_id'));
        endif;
    }

    /**
     * Display the specified resource.
     */
    public function proceed(Request $request)
    {
        $pid = $request->rad;
        $input = $request->session()->get('old_patient');
        $appointment_id = $request->appointment_id;
        $doctors = User::role('Doctor')->get();
        $ctypes = ConsultationType::all(); $pmodes = PaymentMode::all();
        if($pid > 0):
            $patient = Patient::find($pid);            
            return view('consultation.create', compact('patient', 'doctors', 'ctypes', 'appointment_id', 'pmodes'));
        else:
            $patient = Patient::create($input);
            $request->session()->forget('old_patient');
            return view('consultation.create', compact('patient', 'doctors', 'ctypes', 'appointment_id', 'pmodes'));
            //return redirect()->route('patient')->with('success','Patient created successfully');
        endif;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $patient = Patient::find(decrypt($id));
        return view('patient.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'place' => 'required',
            'mobile' => 'required|numeric|digits:10|unique:patients,mobile,'.$id,
        ]);
        $input = $request->all();
        $input['updated_by'] = $request->user()->id;
        $patient = Patient::find($id);
        $patient->update($input);
        return redirect()->route('patient')->with('success','Patient updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Patient::find($id)->delete();
        return redirect()->route('patient')->with('success','Patient deleted successfully');
    }
}
