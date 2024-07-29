<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
// use App\Models\Fitype;
use App\Models\Cases;
use App\Models\Bank;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cases = Cases::all();
        $products  = Bank::all();
        return view('backend.pages.cases.index', compact('cases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles  = Role::all();
        $banks  = Bank::all();
        // dd($banks);
        return view('backend.pages.cases.create', compact('banks', 'roles'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProductsList(Request $request)
    {
        $bankId = $request->query('bankId');

        if ($bankId !== null) {
            // Replace with your logic to fetch products
            // For demonstration, let's just return the bankId
            return response()->json(['bankId' => 'sssssssssssss']);
        } else {
            dd('sssssssssssssssssssssssssssssssssssssssssss');
            return response()->json(['error' => 'Bank ID not provided.'], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation Data
        $request->validate([
            'name' => 'required|max:50|unique:fi_Types,name',
        ]);
        // Create New cases
        $cases = new Cases();
        $cases->name         = $request->name;
        $cases->created_by   = Auth::guard('admin')->user()->id;
        $cases->updated_by   = Auth::guard('admin')->user()->id;
        // $cases->name         = $request->name;
        $cases->save();

        session()->flash('success', 'FI Type has been created !!');
        return redirect()->route('admin.casess.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cases = Cases::find($id);

        return view('backend.pages.cases.edit', compact('cases'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Create New Cases
        $cases = Cases::find($id);

        // Validation Data
        $request->validate([
            'name' => 'required|max:50|unique:fi_Types,name,' . $id,

        ]);


        $cases->name = $request->name;
        $cases->save();

        session()->flash('success', 'FI Type has been updated !!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cases = Cases::find($id);
        if (!is_null($cases)) {
            $cases->delete();
        }

        session()->flash('success', 'Cases has been deleted !!');
        return back();
    }
}
