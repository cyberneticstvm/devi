<?php

namespace App\Http\Controllers;

use App\Exports\AppointmentExport;
use App\Exports\CampPatientExport;
use App\Exports\ProductPharmacyExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:export-today-appointments-excel', ['only' => ['exportTodayAppointments']]);
    }

    public function exportTodayAppointments(Request $request)
    {
        return Excel::download(new AppointmentExport($request), 'appointments_' . Carbon::today()->format('d-M-Y') . '.xlsx');
    }

    public function exportCampPatientList(Request $request, $id)
    {
        return Excel::download(new CampPatientExport($request, $id), 'patient_list.xlsx');
    }

    public function exportProductPharmacy(Request $request)
    {
        return Excel::download(new ProductPharmacyExport($request), 'pharmacy_products.xlsx');
    }
}
