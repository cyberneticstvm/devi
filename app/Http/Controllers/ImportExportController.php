<?php

namespace App\Http\Controllers;

use App\Exports\AppointmentExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
    function __construct(){
        $this->middleware('permission:export-today-appointments-excel', ['only' => ['exportTodayAppointments']]);
    }

    public function exportTodayAppointments(Request $request){
        return Excel::download(new AppointmentExport($request), 'appointments_'.Carbon::today()->format('d-M-Y').'.xlsx');
    }
}
