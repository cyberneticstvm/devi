<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{
    protected $branches;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $br = Branch::selectRaw("id, name")->when(Auth::user()->roles->first()->id != 1, function ($q) {
                return $q->where('id', Session::get('branch'));
            })->orderBy('name');
            if (Auth::user()->roles->first()->id == 1) :
                $this->branches = Branch::selectRaw("'0' AS id, 'All Branches' AS name")->union($br)->pluck('name', 'id');
            else :
                $this->branches = $br->pluck('name', 'id');
            endif;
            return $next($request);
        });
    }
    public function daybook()
    {
        $inputs = [date('Y-m-d'), date('Y-m-d'), branch()->id];
        $branches = $this->branches;
        $data = getDayBook($inputs[0], $inputs[1], $inputs[2]);
        return view('backend.report.daybook', compact('data', 'inputs', 'branches'));
    }

    public function fetchDayBook(Request $request)
    {
        $inputs = [$request->from_date, $request->to_date, $request->branch];
        $branches = $this->branches;
        $data = getDayBook($inputs[0], $inputs[1], $inputs[2]);
        return view('backend.report.daybook', compact('data', 'inputs', 'branches'));
    }
}
