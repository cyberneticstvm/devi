<?php

use App\Models\Appointment;
use Illuminate\Support\Facades\Session;
use App\Models\Branch;
use App\Models\Consultation;
use App\Models\ConsultationType;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


function settings(){
    return Setting::findOrFail(1);
}

function title(){
    return settings()->company_name;
}

function qrCodeText(){
    return settings()->qr_code_text;
}

function branches(){
    return Branch::all();
}

function branch(){
    return Branch::findOrFail(Session::get('branch'));
}

function patientId(){
    return DB::table('patients')->selectRaw("CONCAT_WS('-', 'P', LPAD(IFNULL(max(id)+1, 1), 7, '0')) AS pid")->first();
}
function camptId(){
    return DB::table('camps')->selectRaw("CONCAT_WS('-', 'CMP', LPAD(IFNULL(max(id)+1, 1), 7, '0')) AS cid")->first();
}

function productcode($category){
    $key = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(strtoupper($category), 0, 2).'-'.substr(str_shuffle($key), 0, 6);
}

function getDocFee($doctor, $patient, $ctype){
    $days = settings()->consultation_fee_waived_days; $fee = 0;
    $date_diff = DB::table('consultations')->where('patient_id', $patient)->select(DB::raw("IFNULL(DATEDIFF(now(), created_at), 0) as days, CASE WHEN deleted_at IS NULL THEN 1 ELSE 0 END AS status"))->latest()->first();
    $diff = ($date_diff && $date_diff->days > 0) ? $date_diff->days : 0;
    $cstatus = ($date_diff && $date_diff->status > 0) ? $date_diff->status : 0;
    if($diff == 0 || $diff > $days || ($diff < $days && $cstatus == 1)):
        $doc = Doctor::findOrFail($doctor);
        $fee = $doc->fee;
    endif;
    $ctype = ConsultationType::findOrFail($ctype);
    $fee = ($ctype->fee == 1) ? $fee : 0;
    return $fee;
}

function mrn(){
    $bcode = branch()->code;
    return DB::table('consultations')->selectRaw("CONCAT_WS('/', 'MRN', IFNULL(MAX(id)+1, 1), '$bcode') AS mrid")->first();
}

function getAppointmentTimeList($date, $doctor, $branch){
    $arr = [];  $endtime = Carbon::parse(settings()->appointment_ends_at)->toTimeString(); $starttime = Carbon::parse(settings()->	appointment_starts_at)->toTimeString(); $interval = settings()->per_appointment_minutes;    
    if($date && $doctor && $branch):
        $starttime = ($starttime < Carbon::now()->toTimeString() && Carbon::parse($date)->toDate() == Carbon::today()) ? Carbon::now()->endOfHour()->addSecond()->toTimeString() : $starttime;

        $start = strtotime($starttime);

        $appointment = Appointment::select('time as atime')->whereDate('date', $date)->where('doctor_id', $doctor)->where('branch_id', $branch)->pluck('atime')->toArray();
        while($start <= strtotime($endtime)):                
            $disabled = in_array(Carbon::parse(date('h:i A', $start))->toTimeString(), $appointment) ? 'disabled' : NULL;
            $arr [] = [
                'name' => date('h:i A', $start),
                'id' => Carbon::parse(date('h:i A', $start))->toTimeString(),
                'disabled' => $disabled,
            ];
            $start = strtotime('+'.$interval.' minutes', $start);
        endwhile;
    endif;
    return $arr;    
}

function uploadDocument($item, $path){
    $doc = Storage::disk('s3')->put($path, $item);
    $url = Storage::disk('s3')->url($doc);   
    return $url;
}

function deleteDocument($path, $url){
    if(Storage::disk('s3')->exists($path.substr($url, strrpos($url, '/')+1))):
        Storage::disk('s3')->delete($path.substr($url, strrpos($url, '/')+1));
    endif;
}
