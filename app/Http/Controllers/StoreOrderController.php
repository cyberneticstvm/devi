<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\MedicalRecord;
use App\Models\Order;
use App\Models\PaymentMode;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Faker\Provider\Medical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StoreOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $orders, $products, $pmodes, $padvisers;

    public function __construct()
    {
        /*$this->middleware('permission:store-order-list|store-order-create|store-order-edit|store-order-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:store-order-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:store-order-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:store-order-delete', ['only' => ['destroy']]);*/

        $this->middleware(function ($request, $next) {
            $this->orders = Order::where('category', 'store')->when(Auth::user()->roles->first()->id != 1, function ($q) {
                return $q->where('branch_id', Session::get('branch'));
            })->whereDate('created_at', Carbon::today())->withTrashed()->latest()->get();
            return $next($request);
        });

        $this->products = Product::whereIn('category', ['lens', 'frame', 'service'])->orderBy('name')->get();
        $this->pmodes = PaymentMode::orderBy('name')->get();
        $this->padvisers = User::orderBy('name')->get();
    }
    public function index()
    {
        $orders = $this->orders;
        return view('backend.order.store.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $products = $this->products;
        $pmodes = $this->pmodes;
        $padvisers = $this->padvisers;
        $consultation = Consultation::with('patient')->find(decrypt($id));
        $mrecord = MedicalRecord::with('vision')->where('consultation_id', $consultation->id)->first();
        return view('backend.order.store.create', compact('products', 'consultation', 'pmodes', 'padvisers', 'mrecord'));
    }

    public function fetch(Request $request)
    {
        $this->validate($request, [
            'medical_record_number' => 'required',
        ]);
        $consultation = Consultation::with('patient')->findOrFail($request->medical_record_number);
        return view('backend.order.store.proceed', compact('consultation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }
}
