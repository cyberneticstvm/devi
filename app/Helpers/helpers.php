<?php

use App\Models\Branch;
use App\Models\Category;
use App\Models\Consultation;
use App\Models\User;
use Illuminate\Support\Facades\Session;

function branches(){
    return Branch::all();
}

function productcode($category){
    $cat = Category::find($category);
    $key = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(strtoupper($cat->name), 0, 1).'-'.substr(str_shuffle($key), 0, 6);
}

function getDocFee($doctor, $patient){
    $days = 7; $fee = 0;
    $date_diff = Consultation::where('patient_id', $patient)->select(DB::raw("IFNULL(DATEDIFF(now(), created_at), 0) as days, status"))->latest()->first();
    $diff = ($date_diff && $date_diff['days'] > 0) ? $date_diff['days'] : 0;
    $cstatus = ($date_diff && $date_diff['status'] > 0) ? $date_diff['status'] : 0;
    if($diff == 0 || $diff > $days || ($diff < $days && $cstatus == 1)):
        $doctor = User::find($doctor);
        $fee = $doctor->doctor_fee;
    endif;
    return $fee;
}

function mrn(){
    $bcode = branches()->find(Session::get('branch'))->code;
    $mrn = Consultation::selectRaw("CONCAT_WS('/', 'MRN', IFNULL(MAX(mrid)+1, 1), '$bcode') AS mrn")->first();
    return $mrn->mrn;
}

?>