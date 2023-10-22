<?php

use App\Models\Appointment;
use Illuminate\Support\Facades\Session;
use App\Models\Branch;
use App\Models\Consultation;
use App\Models\ConsultationType;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Setting;
use App\Models\Transfer;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


function settings()
{
    return Setting::findOrFail(1);
}

function title()
{
    return settings()->company_name;
}

function qrCodeText()
{
    return settings()->qr_code_text;
}

function branches()
{
    return Branch::all();
}

function branch()
{
    return Branch::findOrFail(Session::get('branch'));
}

function patientId()
{
    return DB::table('patients')->selectRaw("CONCAT_WS('-', 'P', LPAD(IFNULL(max(id)+1, 1), 7, '0')) AS pid")->first();
}
function camptId()
{
    return DB::table('camps')->selectRaw("CONCAT_WS('-', 'CMP', LPAD(IFNULL(max(id)+1, 1), 7, '0')) AS cid")->first();
}

function productcode($category)
{
    $key = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(strtoupper($category), 0, 2) . '-' . substr(str_shuffle($key), 0, 6);
}

function invoicenumber($category)
{
    $bcode = branch()->code;
    $cat = substr(strtoupper($category), 0, 2);
    return DB::table('orders')->selectRaw("CONCAT_WS('-', 'INV', '$cat', IFNULL(MAX(CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(invoice_number, '-', -2), '-', 1) AS INTEGER))+1, 1), '$bcode') AS ino")->where('branch_id', branch()->id)->first();
}

function purchaseId($category)
{
    $cat = substr(strtoupper($category), 0, 2);
    return DB::table('purchases')->selectRaw("CONCAT_WS('-', 'PUR', '$cat', LPAD(IFNULL(max(id)+1, 1), 7, '0')) AS pid")->first();
}

function transferId($category)
{
    $cat = substr(strtoupper($category), 0, 2);
    return DB::table('transfers')->selectRaw("CONCAT_WS('-', 'TRN', '$cat', LPAD(IFNULL(max(id)+1, 1), 7, '0')) AS tid")->first();
}

function getDocFee($doctor, $patient, $ctype)
{
    $days = settings()->consultation_fee_waived_days;
    $fee = 0;
    $date_diff = DB::table('consultations')->where('patient_id', $patient)->select(DB::raw("IFNULL(DATEDIFF(now(), created_at), 0) as days, CASE WHEN deleted_at IS NULL THEN 1 ELSE 0 END AS status"))->latest()->first();
    $diff = ($date_diff && $date_diff->days > 0) ? $date_diff->days : 0;
    $cstatus = ($date_diff && $date_diff->status > 0) ? $date_diff->status : 0;
    if ($diff == 0 || $diff > $days || ($diff < $days && $cstatus == 1)) :
        $doc = Doctor::findOrFail($doctor);
        $fee = $doc->fee;
    endif;
    $ctype = ConsultationType::findOrFail($ctype);
    $fee = ($ctype->fee == 1) ? $fee : 0;
    return $fee;
}

function mrn()
{
    $bcode = branch()->code;
    return DB::table('consultations')->selectRaw("CONCAT_WS('/', 'MRN', IFNULL(MAX(id)+1, 1), '$bcode') AS mrid")->first();
}

function getAppointmentTimeList($date, $doctor, $branch)
{
    $arr = [];
    $endtime = Carbon::parse(settings()->appointment_ends_at)->toTimeString();
    $starttime = Carbon::parse(settings()->appointment_starts_at)->toTimeString();
    $interval = settings()->per_appointment_minutes;
    if ($date && $doctor && $branch) :
        $starttime = ($starttime < Carbon::now()->toTimeString() && Carbon::parse($date)->toDate() == Carbon::today()) ? Carbon::now()->endOfHour()->addSecond()->toTimeString() : $starttime;

        $start = strtotime($starttime);

        $appointment = Appointment::select('time as atime')->whereDate('date', $date)->where('doctor_id', $doctor)->where('branch_id', $branch)->pluck('atime')->toArray();
        while ($start <= strtotime($endtime)) :
            $disabled = in_array(Carbon::parse(date('h:i A', $start))->toTimeString(), $appointment) ? 'disabled' : NULL;
            $arr[] = [
                'name' => date('h:i A', $start),
                'id' => Carbon::parse(date('h:i A', $start))->toTimeString(),
                'disabled' => $disabled,
            ];
            $start = strtotime('+' . $interval . ' minutes', $start);
        endwhile;
    endif;
    return $arr;
}

function uploadDocument($item, $path)
{
    $doc = Storage::disk('s3')->put($path, $item);
    $url = Storage::disk('s3')->url($doc);
    return $url;
}

function deleteDocument($path, $url)
{
    if (Storage::disk('s3')->exists($path . substr($url, strrpos($url, '/') + 1))) :
        Storage::disk('s3')->delete($path . substr($url, strrpos($url, '/') + 1));
    endif;
}

function orderStatuses()
{
    return array('booked' => 'Booked', 'under-process' => 'Under Process', 'pending' => 'Pending', 'ready-for-delivery' => 'Ready For Delivery', 'delivered' => 'Delivered');
}

function casetypes()
{
    return array('box' => 'Box', 'rexine' => 'Rexine', 'other' => 'Other');
}

function checkOrderedProductsAvailability($request)
{
    foreach ($request->product_id as $key => $item) :
        $stockin = Transfer::with('details')->where('to_branch_id', branch()->id)->get();
        $stockincount = $stockin->details()->where('product_id', $item)->sum('qty');
    endforeach;
}

function getInventory($branch, $product, $category)
{
    $stock = [];
    if ($category == 'pharmacy') :
        if ($branch == 0) :
            $stock = DB::select("SELECT 'Main Stock' AS branch, tblPurchase.product_id, tblPurchase.name AS product_name, tblPurchase.batch_number, tblPurchase.purchasedQty, SUM(CASE WHEN t.from_branch_id = 0 AND t.transfer_status = 1 AND t.deleted_at IS NULL THEN td.qty ELSE 0 END) AS transferredQty, tblPurchase.purchasedQty-SUM(CASE WHEN t.from_branch_id = 0 AND t.transfer_status = 1 AND t.deleted_at IS NULL THEN td.qty ELSE 0 END) AS balanceQty FROM (SELECT pd.product_id, p.name, pd.batch_number, SUM(pd.qty) AS purchasedQty FROM purchase_details pd LEFT JOIN products p ON p.id = pd.product_id WHERE IF(? > 0, pd.product_id=?, 1) GROUP BY pd.batch_number, p.name, pd.product_id) AS tblPurchase LEFT JOIN transfer_details td ON td.product_id = tblPurchase.product_id AND td.batch_number = tblPurchase.batch_number LEFT JOIN transfers t ON t.id = td.transfer_id GROUP BY branch, product_id, product_name, batch_number, purchasedQty HAVING balanceQty > 0", [$product, $product]);
        else :
            $branch = Branch::findOrFail($branch);
            $bname = $branch->name;
            $stock = DB::select("SELECT tbl1.batch_number, tbl1.product_name, tbl1.purchasedQty, tbl1.transferredQty, SUM(CASE WHEN o.branch_id = ? AND o.deleted_at IS NULL THEN od.qty ELSE 0 END) AS soldQty, tbl1.purchasedQty - (tbl1.transferredQty + SUM(CASE WHEN o.branch_id = ? AND o.deleted_at IS NULL THEN od.qty ELSE 0 END)) AS balanceQty FROM(SELECT p.id AS product_id, p.name AS product_name, td.batch_number, SUM(CASE WHEN t.to_branch_id = ? AND t.deleted_at IS null THEN td.qty ELSE 0 END) AS purchasedQty, SUM(CASE WHEN t.from_branch_id = ? AND t.deleted_at IS NULL THEN td.qty ELSE 0 END) AS transferredQty FROM transfer_details td LEFT JOIN products p ON p.id = td.product_id LEFT JOIN transfers t ON t.id = td.transfer_id WHERE IF(? > 0, td.product_id = ?, 1) AND td.batch_number IS NOT NULL GROUP BY p.id, p.name, td.batch_number) AS tbl1 LEFT JOIN order_details od ON od.product_id = tbl1.product_id AND od.batch_number = tbl1.batch_number LEFT JOIN orders o ON o.id=od.order_id GROUP BY batch_number, product_name, purchasedQty, transferredQty HAVING balanceQty > 0;", [$branch->id, $branch->id, $branch->id, $branch->id, $product, $product]);
        endif;
    else :
        if ($branch == 0) :
            $stock = DB::select("SELECT 'Main Stock' AS branch, pdct.name AS product_name, SUM(pd.qty) AS purchasedQty, SUM(CASE WHEN t.from_branch_id = 0 THEN td.qty AND t.deleted_at IS NULL ELSE 0 END) AS transferredQty, SUM(pd.qty)-SUM(CASE WHEN t.from_branch_id = 0 AND t.transfer_status = 1 THEN td.qty ELSE 0 END) AS balanceQty FROM purchase_details pd LEFT JOIN products pdct ON pd.product_id = pdct.id LEFT JOIN transfer_details td ON pd.product_id = td.product_id LEFT JOIN transfers t ON t.id = td.transfer_id WHERE IF(? > 0, pd.product_id = ?, 1) GROUP BY branch, product_name", [$product, $product]);
        else :
            $branch = Branch::findOrFail($branch);
            $bname = $branch->name;
            $stock = DB::select("SELECT '$bname' AS branch, p.name AS product_name, SUM(CASE WHEN t.to_branch_id = ? AND t.transfer_status = 1 AND t.deleted_at IS NULL THEN td.qty ELSE 0 END) AS purchasedQty, SUM(CASE WHEN t.from_branch_id = ? AND t.transfer_status = 1 AND t.deleted_at IS NULL THEN td.qty ELSE 0 END) AS transferredQty, SUM(CASE WHEN o.branch_id = ? AND o.deleted_at IS NULL THEN od.qty ELSE 0 END) AS soldQty, SUM(CASE WHEN t.to_branch_id = ? AND t.transfer_status = 1 AND t.deleted_at IS NULL THEN td.qty ELSE 0 END) - (SUM(CASE WHEN t.from_branch_id = ? AND t.transfer_status = 1 AND t.deleted_at IS NULL THEN td.qty ELSE 0 END) + SUM(CASE WHEN o.branch_id = ? AND o.deleted_at IS NULL THEN od.qty ELSE 0 END)) AS balanceQty FROM transfer_details td LEFT JOIN products p ON p.id = td.product_id LEFT JOIN transfers t ON t.id = td.transfer_id LEFT JOIN order_details od ON od.product_id = td.product_id LEFT JOIN orders o ON o.id = od.order_id WHERE IF(? > 0, td.product_id = ?, 1) GROUP BY p.name, td.product_id", [$branch->id, $branch->id, $branch->id, $branch->id, $branch->id, $branch->id, $product, $product]);
        endif;
    endif;
    return collect($stock);
}
