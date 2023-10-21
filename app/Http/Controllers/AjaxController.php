<?php

namespace App\Http\Controllers;


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
}
