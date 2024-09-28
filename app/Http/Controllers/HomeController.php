<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\casesFiType;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function redirectAdmin()
    {
        return redirect()->route('admin.dashboard');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function caseDetail($id=null){
        $case = casesFiType::with(['getUser', 'getCase', 'getCaseFiType', 'getFiType', 'getCaseStatus'])->where('id', $id)->firstOrFail();
        $assign = true;
        return view('view', compact('case', 'assign'));
    }
}
