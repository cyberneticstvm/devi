<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AjaxController extends Controller
{

    function __construct(){
        // 
    }
    
    public function getAppointmentTime(Request $request){
        $arr = getAppointmentTimeList($request->date, $request->doctor_id, $request->branch_id);
        return response()->json($arr);
    }
}
