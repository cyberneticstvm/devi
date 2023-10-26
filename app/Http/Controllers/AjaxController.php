<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Order;
use App\Models\PatientProcedure;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductSubcategory;
use App\Models\PurchaseDetail;
use Illuminate\Http\Request;

class AjaxController extends Controller
{

    function __construct()
    {
        // 
    }

    public function getAppointmentTime(Request $request)
    {
        $arr = getAppointmentTimeList($request->date, $request->doctor_id, $request->branch_id);
        return response()->json($arr);
    }

    public function getProductsByCategory($category)
    {
        $products = Product::where('category', $category)->orderBy('name')->get();
        return response()->json($products);
    }

    public function getProductsByType($type)
    {
        $products = Product::where('type_id', $type)->orderBy('name')->get();
        return response()->json($products);
    }

    public function getProductPrice($pid, $category, $batch)
    {
        if ($category == 'pharmacy') :
            $product = PurchaseDetail::selectRaw("unit_price_sales AS selling_price")->where('product_id', $pid)->where('batch_number', $batch)->firstOrFail();
        else :
            $product = Product::findOrFail($pid);
        endif;
        return response()->json($product);
    }

    public function getProductBatch($branch, $product, $category)
    {
        $stock = getInventory($branch, $product, $category);
        return response()->json($stock);
    }

    public function getProductTypes($category, $attribute)
    {
        $types = ProductSubcategory::where('category', $category)->where('attribute', $attribute)->orderBy('name')->get();
        return response()->json($types);
    }

    public function getPaymentDetailsByConsultation($cid)
    {
        $arr = json_decode(owedTotal($cid));
        $tot = $arr->registration_fee + $arr->consultation_fee + $arr->procedure_fee + $arr->pharmacy + $arr->store;
        $paid = Payment::where('consultation_id', $cid)->sum('amount');
        $bal = number_format($tot - $paid, 2);
        $op = "<table class='table table-bordered table-striped'><thead><th>Service Opted</th><th>Amount</th></thead><tbody>";
        $op .= "<tr><td>Registration Fee</td><td class='text-end fw-bold'>$arr->registration_fee</td></tr>";
        $op .= "<tr><td>Consultation Fee</td><td class='text-end fw-bold'>$arr->consultation_fee</td></tr>";
        $op .= "<tr><td>Procedure Fee</td><td class='text-end fw-bold'>$arr->procedure_fee</td></tr>";
        $op .= "<tr><td>Pharmacy</td><td class='text-end fw-bold'>$arr->pharmacy</td></tr>";
        $op .= "<tr><td>Store</td><td class='text-end fw-bold'>$arr->store</td></tr>";
        $op .= "</tbody><tfoot><tr><td class='text-end fw-bold'>Total</td><td class='text-end fw-bold'>$tot</td></tr><tr><td class='text-end fw-bold'>Paid</td><td class='text-end fw-bold'>$paid</td></tr><tr><td class='text-end fw-bold'>Balance</td><td class='text-end fw-bold'>$bal</td></tr></table>";
        echo $op;
    }
}
