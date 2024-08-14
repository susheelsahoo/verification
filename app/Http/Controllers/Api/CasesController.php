<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Bank;
use App\Models\FiType;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

// use App\Models\Cases;
// use App\Models\Bank;
// use App\Models\Product;
// use App\Models\FiType;
// use App\Models\ApplicationType;
// use App\Models\User;
// use App\Models\casesFiType;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Hash;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;

class CasesController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ShowCaseCountWise($user_id)
    {
        // ALTER TABLE `cases`  ADD `status` ENUM('0','1','2','3') NOT NULL COMMENT '0->inprogress,1->resolve, 2->verified, 3->rejected'  AFTER `remarks`;

        $cases = DB::table('cases_fi_types as cft')
            ->join('fi_types as ft', 'ft.id', '=', 'cft.fi_type_id')
            ->join('cases as c', 'c.id', '=', 'cft.case_id')
            ->join('products as p', 'p.id', '=', 'c.product_id')
            ->join('banks as b', 'b.id', '=', 'c.bank_id')
            ->select(
                'p.id as product_id',
                'ft.name as fi_type',
                'b.name as bank_name',
                'p.name as product_name',
                DB::raw('COUNT(p.id) as total_count')
            )
            ->where('cft.user_id', $user_id)
            ->where('c.status', '0')
            ->groupBy('ft.name', 'p.id', 'b.name', 'p.name')
            ->toSql();


        if ($cases !== null) {
            return response()->json(['ShowCaseCountWise' => $cases]);
        } else {
            return response()->json(['error' => 'Bank ID not provided.'], 400);
        }
    }

    public function showCasebyProductId($product_id)
    {
        $cases = DB::table('cases')
            ->where('product_id', $product_id)
            ->get();

        if ($cases !== null) {
            return response()->json(['CaseList' => $cases]);
        } else {
            return response()->json(['error' => 'Bank ID not provided.'], 400);
        }
    }

    public function showCasebyId($case_id)
    {
        $cases = DB::table('cases')
            ->where('id', $case_id)
            ->get();

        if ($cases !== null) {
            return response()->json(['CaseList' => $cases]);
        } else {
            return response()->json(['error' => 'Bank ID not provided.'], 400);
        }
    }

    public function storeCase(Request $request)
    {
        // Validation Data
        // $request->validate([
        //     'applicant_name' => 'required|max:50|',
        // ]);
        // Create New cases
        dd(json_encode($request->all()));
        $cases = new Cases();
        $cases->bank_id             = $request->bank_id;
        $cases->product_id          = $request->product_id;
        $cases->application_type    = $request->application_type;
        $cases->refrence_number     = $request->refrence_number;
        $cases->applicant_name      = $request->applicant_name;
        $cases->source_channel      = '1';
        $cases->amount              = $request->amount;
        $cases->vehicle             = $request->vehicle;
        $cases->co_applicant_name   = $request->co_applicant_name;
        $cases->guarantee_name      = $request->guarantee_name;
        $cases->geo_limit           = $request->geo_limit;
        $cases->tat_time            = $request->tat_time;
        $cases->remarks             = $request->remarks;
        $cases->created_by          = Auth::guard('admin')->user()->id;
        $cases->updated_by          = Auth::guard('admin')->user()->id;
        // $cases->name         = $request->name;
        $cases->save();
        $cases_id = $cases->id;

        foreach ($request->fi_type_id as $fi_type_id) {

            if (!empty($fi_type_id['id'])) {
                $casesFiType = new casesFiType;
                $casesFiType->case_id       = $cases_id;
                $casesFiType->fi_type_id    = $fi_type_id['id'];
                $casesFiType->mobile        = $fi_type_id['phone_number'];
                $casesFiType->address       = $fi_type_id['address'];
                $casesFiType->pincode       = $fi_type_id['pincode'];
                $casesFiType->land_mark     = $fi_type_id['landmark'];
                $casesFiType->user_id       = $fi_type_id['agent'];
                $casesFiType->save();
            }
        }

        session()->flash('success', 'Case has been created !!');
        return redirect()->route('admin.cases.index');
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $cases = Cases::all();
    //     $products  = Bank::all();
    //     return view('backend.pages.cases.index', compact('cases'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     $roles              = Role::all();
    //     $banks              = Bank::all();
    //     $fitypes            = FiType::all();
    //     $ApplicationTypes   = ApplicationType::all();
    //     $session_id         = Auth::guard('admin')->user()->id;
    //     $users              = User::where('admin_id', $session_id)->get();
    //     $singleAgent = '';
    //     $singleAgent .= '<div class="form-group col-md-6 col-sm-12 singleAgentSection">';
    //     $singleAgent .= '<label for="singleAgent">Agent</label>';
    //     $singleAgent .= '<select class="custom-select" name="singleAgent" id="singleAgent">';
    //     $singleAgent .= '<option value="">--Select Option--</option>';
    //     foreach ($users as $user) {
    //         $singleAgent .= '<option value="' . $user['id'] . '">' . $user['name'] . '</option>';
    //     }
    //     $singleAgent .= '</select>';
    //     $singleAgent .= '</div>';


    //     $fitypesFeild = '';
    //     $AgentsFeild = '';
    //     foreach ($fitypes as $key => $fitype) {
    //         $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
    //         $fitypesFeild .= '<label for="Address' . $fitype['id'] . '">' . $fitype['name'] . ' Address</label>';
    //         $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][address]" value="Address' . $fitype['id'] . '" placeholder="Address">';
    //         //$fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[address]" value="Address' . $fitype['id'] . '" placeholder="Address">';
    //         $fitypesFeild .= '</div>';
    //         $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
    //         $fitypesFeild .= '<label for="Pincode' . $fitype['id'] . '">' . $fitype['name'] . ' Pincode</label>';
    //         $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][pincode]" value="201301' . $fitype['id'] . '" placeholder="Pincode">';
    //         //$fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[pincode]" value="201301' . $fitype['id'] . '" placeholder="Pincode">';
    //         $fitypesFeild .= '</div>';
    //         $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
    //         $fitypesFeild .= '<label for="phone number' . $fitype['id'] . '">' . $fitype['name'] . ' Phone Number</label>';
    //         $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][phone_number]" value="987654321' . $fitype['id'] . '" placeholder="Phone Number">';
    //         //$fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[phone_number]" value="987654321' . $fitype['id'] . '" placeholder="Phone Number">';
    //         $fitypesFeild .= '</div>';
    //         $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
    //         $fitypesFeild .= '<label for="landmark' . $fitype['id'] . '">' . $fitype['name'] . ' Land Mark</label>';
    //         $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][landmark]" value="Landmark' . $fitype['id'] . '" placeholder="landmark">';
    //         //$fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[landmark]" value="Landmark' . $fitype['id'] . '" placeholder="landmark">';
    //         $fitypesFeild .= '</div>';



    //         $AgentsFeild .= '<div class="form-group col-md-6 col-sm-12 multiAgentSection ' . $fitype['name'] . '_section' . ' d-none">';
    //         $AgentsFeild .= '<label for="Agent' . $fitype['id'] . '">' . $fitype['name'] . ' Agent</label>';
    //         $AgentsFeild .= '<select class="custom-select" name="fi_type_id[' . $key . '][agent]">';
    //         $AgentsFeild .= '<option value="">--Select Option--</option>';
    //         foreach ($users as $user) {
    //             $AgentsFeild .= '<option value="' . $user['id'] . '">' . $user['name'] . '</option>';
    //         }
    //         $AgentsFeild .= '</select>';
    //         $AgentsFeild .= '</div>';
    //     }

    //     return view('backend.pages.cases.create', compact('banks', 'roles', 'fitypes', 'fitypesFeild', 'ApplicationTypes', 'singleAgent', 'AgentsFeild'));
    // }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     $cases = Cases::find($id);

    //     return view('backend.pages.cases.edit', compact('cases'));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     // Create New Cases
    //     $cases = Cases::find($id);

    //     // Validation Data
    //     // $request->validate([
    //     //     'name' => 'required|max:50|unique:fi_types,name,' . $id,

    //     // ]);


    //     $cases->name = $request->name;
    //     $cases->save();

    //     session()->flash('success', 'FI Type has been updated !!');
    //     return back();
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $cases = Cases::find($id);
    //     if (!is_null($cases)) {
    //         $cases->delete();
    //     }

    //     session()->flash('success', 'Cases has been deleted !!');
    //     return back();
    // }

    // public function getItem($bankId = null)
    // {
    //     $AvailbleProduct = Product::select('bpm.id', 'bpm.bank_id', 'bpm.product_id', 'products.name', 'products.product_code')
    //         ->leftJoin('bank_product_mappings as bpm', 'bpm.product_id', '=', 'products.id')
    //         ->where('bpm.bank_id', $bankId)
    //         ->where('products.status', '1')
    //         ->get()->toArray();


    //     if ($bankId !== null) {
    //         return response()->json(['AvailbleProduct' => $AvailbleProduct]);
    //     } else {
    //         return response()->json(['error' => 'Bank ID not provided.'], 400);
    //     }
    // }
    /**
     * @return \Illuminate\Support\Collection
     */
    // public function importExportView($bankId = 1)
    // {
    //     $cases = '';
    //     return view('backend.pages.cases.import', compact('cases'));
    // }

    /**
     * @return \Illuminate\Support\Collection
     */
    // public function import()
    // {
    //     dd('aaaaaaaaaaaaaaaaaaaaaa');
    //     return "ssuheee";
    //     // return Excel::download(new UsersExport, 'users.xlsx');
    // }

    /**
     * @return \Illuminate\Support\Collection
     */
    // public function export()
    // {
    //     dd('sssssssssssssssssssssssssssssss');

    //     // Excel::import(new UsersImport, request()->file('file'));

    //     return back();
    // }
}
