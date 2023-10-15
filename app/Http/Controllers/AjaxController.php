<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Product;
use Carbon\Carbon;
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

    public function getProductPrice($pid)
    {
        $product = Product::findOrFail($pid);
        return response()->json($product);
    }
}
