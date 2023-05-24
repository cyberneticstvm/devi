<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Branch;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $settings;

    function __construct(){
        $this->middleware('permission:appointment-list|appointment-create|appointment-edit|appointment-delete', ['only' => ['index','store']]);
        $this->middleware('permission:appointment-create', ['only' => ['create','store']]);
        $this->middleware('permission:appointment-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:appointment-delete', ['only' => ['destroy']]);

        $this->settings = DB::table('settings')->selectRaw("TIME_FORMAT(appointment_from_time, '%h:%i %p') AS from_time, TIME_FORMAT(appointment_to_time, '%h:%i %p') AS to_time, appointment_interval AS ti")->where('id', 1)->first();
    }

    public function index()
    {
        $appointments = Appointment::whereDate('appointment_date', Carbon::today())->orderByDesc('id')->get();
        return view('appointment.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = User::whereHas(
            'roles', function($q){
                $q->where('name', 'Doctor');
            }
        )->pluck('name', 'id');
        $branches = Branch::pluck('name', 'id');
        return view('appointment.create', compact('doctors', 'branches'));
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
            'mobile' => 'required|digits:10',
            'appointment_date' => 'required',
            'branch_id' => 'required',
            'doctor_id' => 'required',
        ]);
        $input = $request->all();
        $input['created_by'] = $request->user()->id;
        $input['updated_by'] = $request->user()->id;        
        if($request->app_time):
            $input['appointment_time'] = Carbon::createFromFormat('h:i A', $request->app_time)->format('H:i:s');
            Appointment::create($input);
            return redirect()->back()->with('success', 'Appointment registered successfully.');
        else:
            $stime = number_format(date('H', strtotime($this->settings->from_time)), 0); $etime = number_format(date('H', strtotime($this->settings->to_time)), 0);
            $stime = ($request->appointment_date > Carbon::today()) ? $stime : number_format(date('H', strtotime('+1 hours')), 0);
            $apps = Appointment::whereDate('appointment_date', $request->appointment_date)->where('branch_id', $request->branch_id)->where('doctor_id', $request->doctor_id)->get();
            return redirect()->back()->with(['stime' => $stime, 'etime' => $etime, 'ctime' => $this->settings->ti, 'apps' => $apps])->with('error', 'Please select a slot')->withInput($request->all());
        endif;
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Appointment::find($id)->delete();
        return redirect()->route('appointment')->with('success', 'Appointment deleted successfully');
    }
}
