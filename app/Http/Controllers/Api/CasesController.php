<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\casesFiType;
use App\Models\FiType;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            ->get();


        if ($cases !== null) {
            return response()->json(['ShowCaseCountWise' => $cases]);
        } else {
            return response()->json(['error' => 'Bank ID not provided.'], 400);
        }
    }

    public function showCasebyProductId($fi_type, $product_id)
    {
        // dd($fi_type);
        // SELECT p.id as product_id, p.name as product_name, c.applicant_name, c.created_at, c.refrence_number, cft.address, cft.pincode
        // FROM products p 
        // INNER JOIN cases as c ON c.product_id = p.id
        // INNER JOIN cases_fi_types as cft ON cft.case_id = c.id
        // INNER JOIN fi_types ft on ft.id = cft.fi_type_id
        // WHERE p.id = 1 AND ft.name = 'BV'
        $cases = DB::table('products as p')
            ->join('cases as c', 'c.product_id', '=', 'p.id')
            ->join('cases_fi_types as cft', 'cft.case_id', '=', 'c.id')
            ->join('fi_types as ft', 'ft.id', '=', 'cft.fi_type_id')
            ->select(
                'p.id as product_id',
                'c.id as case_id',
                'cft.id as case_fi_type_id',
                'p.name as product_name',
                'c.applicant_name',
                'c.created_at',
                'c.refrence_number',
                'cft.address',
                'cft.pincode'
            )
            ->where('p.id', $product_id)
            ->where('ft.name', $fi_type)
            ->get();

        if ($cases !== null) {
            return response()->json(['CaseList' => $cases]);
        } else {
            return response()->json(['error' => 'Bank ID not provided.'], 400);
        }
    }

    public function showCasebyId($cft_id)
    {

        //SELECT c.* , cft.mobile, cft.address, cft.pincode, cft.land_mark, a.name as created_by
        // FROM cases_fi_types as cft
        // INNER JOIN cases as c ON c.id = cft.case_id
        // INNER JOIN admins as a ON a.id = c.created_by
        // WHERE cft.id = 2
        $cases = DB::table('cases_fi_types as cft')
            ->join('cases as c', 'c.id', '=', 'cft.case_id')
            ->join('admins as a', 'a.id', '=', 'c.created_by')
            ->select(
                'cft.id as case_fi_type_id',
                'c.*',
                'cft.mobile',
                'cft.address',
                'cft.pincode',
                'cft.land_mark',
                'a.name as created_by'
            )
            ->where('cft.id', $cft_id)
            ->first();

        if ($cases !== null) {
            return response()->json(['CaseList' => $cases]);
        } else {
            return response()->json(['error' => 'Bank ID not provided.'], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Create New Cases
        $data = $request->all();

        $validator = Validator::make(
            request()->all(),
            array(
                'case_fi_type_id'  =>       'required',
            )
        );
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 400]);
        }
        // Get the current year and month
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');

        // Create the path to store the image
        $image_1 = $image_2 = $image_3 = $image_4 = $image_5 = $image_6 = $image_7 = $image_8 = $image_9 = NULL;
        if ($request->hasFile('image_1')) {
            $image_1 = $request->file('image_1')->store("images/cases/{$year}/{$month}", 'public');
        }
        if ($request->hasFile('image_2')) {
            $image_2 = $request->file('image_2')->store("images/cases/{$year}/{$month}", 'public');
        }
        if ($request->hasFile('image_3')) {
            $image_3 = $request->file('image_3')->store("images/cases/{$year}/{$month}", 'public');
        }
        if ($request->hasFile('image_4')) {
            $image_4 = $request->file('image_4')->store("images/cases/{$year}/{$month}", 'public');
        }
        if ($request->hasFile('image_4')) {
            $image_4 = $request->file('image_4')->store("images/cases/{$year}/{$month}", 'public');
        }
        if ($request->hasFile('image_5')) {
            $image_5 = $request->file('image_5')->store("images/cases/{$year}/{$month}", 'public');
        }
        if ($request->hasFile('image_6')) {
            $image_6 = $request->file('image_6')->store("images/cases/{$year}/{$month}", 'public');
        }
        if ($request->hasFile('image_7')) {
            $image_7 = $request->file('image_7')->store("images/cases/{$year}/{$month}", 'public');
        }
        if ($request->hasFile('image_8')) {
            $image_8 = $request->file('image_8')->store("images/cases/{$year}/{$month}", 'public');
        }
        if ($request->hasFile('image_9')) {
            $image_9 = $request->file('image_9')->store("images/cases/{$year}/{$month}", 'public');
        }
        $case_fi_type_id = $data['case_fi_type_id'];


        $cases = casesFiType::find($case_fi_type_id);
        $cases->image_1 = $image_1;
        $cases->image_2 = $image_2;
        $cases->image_3 = $image_3;
        $cases->image_4 = $image_4;
        $cases->image_5 = $image_5;
        $cases->image_6 = $image_6;
        $cases->image_7 = $image_7;
        $cases->image_8 = $image_8;
        $cases->image_9 = $image_9;
        $cases->save();
        return response()->json(['message' => 'Image uploaded successfully'], 200);
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
