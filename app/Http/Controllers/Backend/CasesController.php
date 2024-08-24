<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
// use App\Models\Fitype;
use App\Models\Cases;
use App\Models\Bank;
use App\Models\Product;
use App\Models\FiType;
use App\Models\ApplicationType;
use App\Models\User;
use App\Models\casesFiType;
use App\Imports\CasesImport;
use App\Models\CaseStatus;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
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
        $roles              = Role::all();
        $banks              = Bank::all();
        $fitypes            = FiType::all();
        $ApplicationTypes   = ApplicationType::all();
        $session_id         = Auth::guard('admin')->user()->id;
        $users              = User::where('admin_id', $session_id)->get();


        $fitypesFeild = '';
        $AgentsFeild = '';
        foreach ($fitypes as $key => $fitype) {
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="Address' . $fitype['id'] . '">' . $fitype['name'] . ' Address</label>';
            $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][address]" placeholder="Address">';

            $fitypesFeild .= '</div>';
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="Pincode' . $fitype['id'] . '">' . $fitype['name'] . ' Pincode</label>';
            $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][pincode]" placeholder="Pincode">';

            $fitypesFeild .= '</div>';
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="phone number' . $fitype['id'] . '">' . $fitype['name'] . ' Phone Number</label>';
            $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][phone_number]" placeholder="Phone Number">';

            $fitypesFeild .= '</div>';
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="landmark' . $fitype['id'] . '">' . $fitype['name'] . ' Land Mark</label>';
            $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][landmark]" placeholder="landmark">';

            $fitypesFeild .= '</div>';
        }

        return view('backend.pages.cases.create', compact('banks', 'roles', 'fitypes', 'fitypesFeild', 'ApplicationTypes'));
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
            'applicant_name' => 'required|max:50|',
        ]);
        // Create New cases
        $cases = new Cases();
        $cases->bank_id             = $request->bank_id;
        $cases->product_id          = $request->product_id;
        $cases->application_type    = $request->application_type;
        if ($request->application_type == '1') {
            $cases->applicant_name      = $request->applicant_name;
        } elseif ($request->application_type == '2') {
            $cases->applicant_name      = $request->applicant_name;
            $cases->co_applicant_name   = $request->co_applicant_name;
        } elseif ($request->application_type == '3') {
            $cases->applicant_name      = $request->guarantee_name;
        } elseif ($request->application_type == '4') {
            $cases->applicant_name      = $request->seller_name;
        }
        $cases->refrence_number     = $request->refrence_number;
        $cases->amount              = $request->amount;
        $cases->vehicle             = $request->vehicle;
        $cases->geo_limit           = $request->geo_limit;
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
                $casesFiType->user_id       = '0';
                $casesFiType->save();
            }
        }

        session()->flash('success', 'Case has been created !!');
        return redirect()->route('admin.case.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cases = Cases::where('id', $id)->with('getCaseFiType')->firstOrFail();
        $roles              = Role::all();
        $banks              = Bank::all();
        $fitypes            = FiType::all();
        $ApplicationTypes   = ApplicationType::all();
        $users              = User::where('admin_id', Auth::guard('admin')->user()->id)->get();

        $fi_type_ids = $fi_type_value = [];
        if ($cases->getCaseFiType()) {
            $fi_type_ids = $cases->getCaseFiType()->pluck('fi_type_id')->toArray();
            foreach ($cases->getCaseFiType as $value) {
                $fi_type_value[$value->fi_type_id] = $value;
            }
        }

        $AvailbleProduct = [];
        if ($cases->bank_id) {
            $AvailbleProduct = Product::select('bpm.id', 'bpm.bank_id', 'bpm.product_id', 'products.name', 'products.product_code')
                ->leftJoin('bank_product_mappings as bpm', 'bpm.product_id', '=', 'products.id')
                ->where('bpm.bank_id', $cases->bank_id)
                ->where('products.status', '1')
                ->get()
                ->toArray();
        }

        $fitypesFeild = '';
        $AgentsFeild = '';
        foreach ($fitypes as $key => $fitype) {
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="Address' . $fitype['id'] . '">' . $fitype['name'] . ' Address</label>';

            if (isset($fi_type_value[$fitype['id']])) {
                $address = $fi_type_value[$fitype['id']]['address'];
                $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][address]" value="' . $address . '" placeholder="Address">';
            } else {
                $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][address]" value="" placeholder="Address">';
            }

            $fitypesFeild .= '</div>';
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="Pincode' . $fitype['id'] . '">' . $fitype['name'] . ' Pincode</label>';

            if (isset($fi_type_value[$fitype['id']])) {
                $pincode = $fi_type_value[$fitype['id']]['pincode'];
                $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][pincode]" value="' . $pincode . '" placeholder="Pincode">';
            } else {
                $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][pincode]" value="" placeholder="Pincode">';
            }

            $fitypesFeild .= '</div>';
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="phone number' . $fitype['id'] . '">' . $fitype['name'] . ' Phone Number</label>';

            if (isset($fi_type_value[$fitype['id']])) {
                $phone = $fi_type_value[$fitype['id']]['mobile'];
                $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][phone_number]" value="' . $phone . '" placeholder="Phone Number">';
            } else {
                $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][phone_number]" value="" placeholder="Phone Number">';
            }

            $fitypesFeild .= '</div>';
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="landmark' . $fitype['id'] . '">' . $fitype['name'] . ' Land Mark</label>';

            if (isset($fi_type_value[$fitype['id']])) {
                $landmark = $fi_type_value[$fitype['id']]['land_mark'];
                $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][landmark]" value="' . $landmark . '" placeholder="landmark">';
            } else {
                $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][landmark]" value="" placeholder="landmark">';
            }

            $fitypesFeild .= '</div>';
        }

        return view('backend.pages.cases.show', compact('cases', 'banks', 'roles', 'fitypes', 'fitypesFeild', 'ApplicationTypes', 'fi_type_ids', 'AvailbleProduct'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cases = Cases::where('id', $id)->with('getCaseFiType')->firstOrFail();
        $roles              = Role::all();
        $banks              = Bank::all();
        $fitypes            = FiType::all();
        $ApplicationTypes   = ApplicationType::all();
        $users              = User::where('admin_id', Auth::guard('admin')->user()->id)->get();

        $fi_type_ids = $fi_type_value = [];
        if ($cases->getCaseFiType()) {
            $fi_type_ids = $cases->getCaseFiType()->pluck('fi_type_id')->toArray();
            foreach ($cases->getCaseFiType as $value) {
                $fi_type_value[$value->fi_type_id] = $value;
            }
        }

        $AvailbleProduct = [];
        if ($cases->bank_id) {
            $AvailbleProduct = Product::select('bpm.id', 'bpm.bank_id', 'bpm.product_id', 'products.name', 'products.product_code')
                ->leftJoin('bank_product_mappings as bpm', 'bpm.product_id', '=', 'products.id')
                ->where('bpm.bank_id', $cases->bank_id)
                ->where('products.status', '1')
                ->get()
                ->toArray();
        }

        $fitypesFeild = '';
        $AgentsFeild = '';
        foreach ($fitypes as $key => $fitype) {
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="Address' . $fitype['id'] . '">' . $fitype['name'] . ' Address</label>';

            if (isset($fi_type_value[$fitype['id']])) {
                $address = $fi_type_value[$fitype['id']]['address'];
                $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][address]" value="' . $address . '" placeholder="Address">';
            } else {
                $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][address]" value="" placeholder="Address">';
            }

            $fitypesFeild .= '</div>';
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="Pincode' . $fitype['id'] . '">' . $fitype['name'] . ' Pincode</label>';

            if (isset($fi_type_value[$fitype['id']])) {
                $pincode = $fi_type_value[$fitype['id']]['pincode'];
                $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][pincode]" value="' . $pincode . '" placeholder="Pincode">';
            } else {
                $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][pincode]" value="" placeholder="Pincode">';
            }

            $fitypesFeild .= '</div>';
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="phone number' . $fitype['id'] . '">' . $fitype['name'] . ' Phone Number</label>';

            if (isset($fi_type_value[$fitype['id']])) {
                $phone = $fi_type_value[$fitype['id']]['mobile'];
                $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][phone_number]" value="' . $phone . '" placeholder="Phone Number">';
            } else {
                $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][phone_number]" value="" placeholder="Phone Number">';
            }

            $fitypesFeild .= '</div>';
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="landmark' . $fitype['id'] . '">' . $fitype['name'] . ' Land Mark</label>';

            if (isset($fi_type_value[$fitype['id']])) {
                $landmark = $fi_type_value[$fitype['id']]['land_mark'];
                $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][landmark]" value="' . $landmark . '" placeholder="landmark">';
            } else {
                $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][landmark]" value="" placeholder="landmark">';
            }

            $fitypesFeild .= '</div>';
        }

        return view('backend.pages.cases.edit', compact('cases', 'banks', 'roles', 'fitypes', 'fitypesFeild', 'ApplicationTypes', 'fi_type_ids', 'AvailbleProduct'));
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
        $cases = Cases::findOrFail($id);
        $cases->bank_id             = $request->bank_id ??  $cases->bank_id;
        $cases->product_id          = $request->product_id ??   $cases->product_id;
        $cases->application_type    = $request->application_type ??  $cases->application_type;
        if ($request->application_type == '1') {
            $cases->applicant_name      = $request->applicant_name ?? $cases->applicant_name;
        } elseif ($request->application_type == '2') {
            $cases->applicant_name      = $request->applicant_name ?? $cases->applicant_name;
            $cases->co_applicant_name   = $request->co_applicant_name ?? $cases->co_applicant_name;
        } elseif ($request->application_type == '3') {
            $cases->applicant_name      = $request->guarantee_name ?? $cases->applicant_name;
        } elseif ($request->application_type == '4') {
            $cases->applicant_name      = $request->seller_name ??  $cases->applicant_name;
        }
        $cases->refrence_number     = $request->refrence_number ??  $cases->refrence_number;
        $cases->amount              = $request->amount ??   $cases->amount;
        $cases->vehicle             = $request->vehicle ??  $cases->vehicle;
        $cases->geo_limit           = $request->geo_limit ??   $cases->geo_limit;
        $cases->remarks             = $request->remarks ??   $cases->remarks;
        $cases->updated_by          = Auth::guard('admin')->user()->id;
        $cases->save();
        foreach ($request->fi_type_id as $fi_type_id) {
            if (!empty($fi_type_id['id'])) {
                casesFiType::updateOrInsert(
                    ['case_id' => $cases->id, 'fi_type_id' => $fi_type_id['id']],
                    ['mobile' => $fi_type_id['phone_number'], 'address' => $fi_type_id['address'], 'pincode' => $fi_type_id['pincode'], 'land_mark' => $fi_type_id['landmark'], 'user_id' => 0]
                );
            }
        }

        session()->flash('success', 'Case has been updated !!');
        return redirect()->route('admin.case.index');
    }
    public function reinitatiateCase($id)
    {
        $cases = Cases::where('id', $id)->with('getCaseFiType')->firstOrFail();
        $roles              = Role::all();
        $banks              = Bank::all();
        $fitypes            = FiType::all();
        $ApplicationTypes   = ApplicationType::all();
        $users              = User::where('admin_id', Auth::guard('admin')->user()->id)->get();

        $fi_type_ids = $fi_type_value = [];
        if ($cases->getCaseFiType()) {
            $fi_type_ids = $cases->getCaseFiType()->pluck('fi_type_id')->toArray();
            foreach ($cases->getCaseFiType as $value) {
                $fi_type_value[$value->fi_type_id] = $value;
            }
        }

        $AvailbleProduct = [];
        if ($cases->bank_id) {
            $AvailbleProduct = Product::select('bpm.id', 'bpm.bank_id', 'bpm.product_id', 'products.name', 'products.product_code')
                ->leftJoin('bank_product_mappings as bpm', 'bpm.product_id', '=', 'products.id')
                ->where('bpm.bank_id', $cases->bank_id)
                ->where('products.status', '1')
                ->get()
                ->toArray();
        }

        $fitypesFeild = '';
        $AgentsFeild = '';
        foreach ($fitypes as $key => $fitype) {
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="Address' . $fitype['id'] . '">' . $fitype['name'] . ' Address</label>';

            if (isset($fi_type_value[$fitype['id']])) {
                $address = $fi_type_value[$fitype['id']]['address'];
                $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][address]" value="' . $address . '" placeholder="Address">';
            } else {
                $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][address]" value="" placeholder="Address">';
            }

            $fitypesFeild .= '</div>';
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="Pincode' . $fitype['id'] . '">' . $fitype['name'] . ' Pincode</label>';

            if (isset($fi_type_value[$fitype['id']])) {
                $pincode = $fi_type_value[$fitype['id']]['pincode'];
                $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][pincode]" value="' . $pincode . '" placeholder="Pincode">';
            } else {
                $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][pincode]" value="" placeholder="Pincode">';
            }

            $fitypesFeild .= '</div>';
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="phone number' . $fitype['id'] . '">' . $fitype['name'] . ' Phone Number</label>';

            if (isset($fi_type_value[$fitype['id']])) {
                $phone = $fi_type_value[$fitype['id']]['mobile'];
                $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][phone_number]" value="' . $phone . '" placeholder="Phone Number">';
            } else {
                $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][phone_number]" value="" placeholder="Phone Number">';
            }

            $fitypesFeild .= '</div>';
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="landmark' . $fitype['id'] . '">' . $fitype['name'] . ' Land Mark</label>';

            if (isset($fi_type_value[$fitype['id']])) {
                $landmark = $fi_type_value[$fitype['id']]['land_mark'];
                $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][landmark]" value="' . $landmark . '" placeholder="landmark">';
            } else {
                $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][landmark]" value="" placeholder="landmark">';
            }

            $fitypesFeild .= '</div>';
        }

        return view('backend.pages.cases.reinitatiate', compact('cases', 'banks', 'roles', 'fitypes', 'fitypesFeild', 'ApplicationTypes', 'fi_type_ids', 'AvailbleProduct'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reinitatiate(Request $request)
    {
        // dd($request->all());
        // Validation Data
        $request->validate([
            'applicant_name' => 'required|max:50|',
        ]);
        // Create New cases
        $cases = new Cases();
        $cases->bank_id             = $request->bank_id;
        $cases->product_id          = $request->product_id;
        $cases->application_type    = $request->application_type;
        if ($request->application_type == '1') {
            $cases->applicant_name      = $request->applicant_name;
        } elseif ($request->application_type == '2') {
            $cases->applicant_name      = $request->applicant_name;
            $cases->co_applicant_name   = $request->co_applicant_name;
        } elseif ($request->application_type == '3') {
            $cases->applicant_name      = $request->guarantee_name;
        } elseif ($request->application_type == '4') {
            $cases->applicant_name      = $request->seller_name;
        }
        $cases->refrence_number     = $request->refrence_number;
        $cases->amount              = $request->amount;
        $cases->vehicle             = $request->vehicle;
        $cases->geo_limit           = $request->geo_limit;
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
                $casesFiType->user_id       = '0';
                $casesFiType->save();
            }
        }

        session()->flash('success', 'Case has been created !!');
        return redirect()->route('admin.case.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function viewCaseByCftId($id)
    {

        $cases              = casesFiType::where('id', $id)->with('getCase')->firstOrFail();
        $roles              = Role::all();
        $banks              = Bank::all();
        $fitypes            = FiType::all();
        $ApplicationTypes   = ApplicationType::all();
        $users              = User::where('admin_id', Auth::guard('admin')->user()->id)->get();

        $fi_type_ids = $fi_type_value = [];
        if ($cases->getCase()) {
            // dd($cases->getCase());
            // $fi_type_ids = $cases->getCase()->pluck('fi_type_id')->toArray();
            // foreach ($cases->getCaseFiType as $value) {
            //     $fi_type_value[$value->fi_type_id] = $value;
            // }
        }

        $AvailbleProduct = [];
        if ($cases->bank_id) {
            $AvailbleProduct = Product::select('bpm.id', 'bpm.bank_id', 'bpm.product_id', 'products.name', 'products.product_code')
                ->leftJoin('bank_product_mappings as bpm', 'bpm.product_id', '=', 'products.id')
                ->where('bpm.bank_id', $cases->bank_id)
                ->where('products.status', '1')
                ->get()
                ->toArray();
        }

        $fitypesFeild = '';
        $AgentsFeild = '';
        foreach ($fitypes as $key => $fitype) {
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="Address' . $fitype['id'] . '">' . $fitype['name'] . ' Address</label>';

            if (isset($fi_type_value[$fitype['id']])) {
                $address = $fi_type_value[$fitype['id']]['address'];
                $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][address]" value="' . $address . '" placeholder="Address">';
            } else {
                $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][address]" value="" placeholder="Address">';
            }

            $fitypesFeild .= '</div>';
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="Pincode' . $fitype['id'] . '">' . $fitype['name'] . ' Pincode</label>';

            if (isset($fi_type_value[$fitype['id']])) {
                $pincode = $fi_type_value[$fitype['id']]['pincode'];
                $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][pincode]" value="' . $pincode . '" placeholder="Pincode">';
            } else {
                $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][pincode]" value="" placeholder="Pincode">';
            }

            $fitypesFeild .= '</div>';
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="phone number' . $fitype['id'] . '">' . $fitype['name'] . ' Phone Number</label>';

            if (isset($fi_type_value[$fitype['id']])) {
                $phone = $fi_type_value[$fitype['id']]['mobile'];
                $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][phone_number]" value="' . $phone . '" placeholder="Phone Number">';
            } else {
                $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][phone_number]" value="" placeholder="Phone Number">';
            }

            $fitypesFeild .= '</div>';
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="landmark' . $fitype['id'] . '">' . $fitype['name'] . ' Land Mark</label>';

            if (isset($fi_type_value[$fitype['id']])) {
                $landmark = $fi_type_value[$fitype['id']]['land_mark'];
                $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][landmark]" value="' . $landmark . '" placeholder="landmark">';
            } else {
                $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][landmark]" value="" placeholder="landmark">';
            }

            $fitypesFeild .= '</div>';
        }

        return view('backend.pages.cases.show', compact('cases', 'banks', 'roles', 'fitypes', 'fitypesFeild', 'ApplicationTypes', 'fi_type_ids', 'AvailbleProduct'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function editCase($id)
    // {
    //     $cases = casesFiType::where('id', $id)->with('getCase')->firstOrFail();
    //     $roles              = Role::all();
    //     $banks              = Bank::all();
    //     $fitypes            = FiType::all();
    //     $ApplicationTypes   = ApplicationType::all();
    //     $users              = User::where('admin_id', Auth::guard('admin')->user()->id)->get();

    //     $fi_type_ids = $fi_type_value = [];
    //     if ($cases->getCase()) {
    //         // dd($cases->getCase());
    //         // $fi_type_ids = $cases->getCase()->pluck('fi_type_id')->toArray();
    //         // foreach ($cases->getCaseFiType as $value) {
    //         //     $fi_type_value[$value->fi_type_id] = $value;
    //         // }
    //     }

    //     $AvailbleProduct = [];
    //     if ($cases->bank_id) {
    //         $AvailbleProduct = Product::select('bpm.id', 'bpm.bank_id', 'bpm.product_id', 'products.name', 'products.product_code')
    //             ->leftJoin('bank_product_mappings as bpm', 'bpm.product_id', '=', 'products.id')
    //             ->where('bpm.bank_id', $cases->bank_id)
    //             ->where('products.status', '1')
    //             ->get()
    //             ->toArray();
    //     }

    //     $fitypesFeild = '';
    //     $AgentsFeild = '';
    //     foreach ($fitypes as $key => $fitype) {
    //         $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
    //         $fitypesFeild .= '<label for="Address' . $fitype['id'] . '">' . $fitype['name'] . ' Address</label>';

    //         if (isset($fi_type_value[$fitype['id']])) {
    //             $address = $fi_type_value[$fitype['id']]['address'];
    //             $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][address]" value="' . $address . '" placeholder="Address">';
    //         } else {
    //             $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][address]" value="" placeholder="Address">';
    //         }

    //         $fitypesFeild .= '</div>';
    //         $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
    //         $fitypesFeild .= '<label for="Pincode' . $fitype['id'] . '">' . $fitype['name'] . ' Pincode</label>';

    //         if (isset($fi_type_value[$fitype['id']])) {
    //             $pincode = $fi_type_value[$fitype['id']]['pincode'];
    //             $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][pincode]" value="' . $pincode . '" placeholder="Pincode">';
    //         } else {
    //             $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][pincode]" value="" placeholder="Pincode">';
    //         }

    //         $fitypesFeild .= '</div>';
    //         $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
    //         $fitypesFeild .= '<label for="phone number' . $fitype['id'] . '">' . $fitype['name'] . ' Phone Number</label>';

    //         if (isset($fi_type_value[$fitype['id']])) {
    //             $phone = $fi_type_value[$fitype['id']]['mobile'];
    //             $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][phone_number]" value="' . $phone . '" placeholder="Phone Number">';
    //         } else {
    //             $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][phone_number]" value="" placeholder="Phone Number">';
    //         }

    //         $fitypesFeild .= '</div>';
    //         $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
    //         $fitypesFeild .= '<label for="landmark' . $fitype['id'] . '">' . $fitype['name'] . ' Land Mark</label>';

    //         if (isset($fi_type_value[$fitype['id']])) {
    //             $landmark = $fi_type_value[$fitype['id']]['land_mark'];
    //             $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][landmark]" value="' . $landmark . '" placeholder="landmark">';
    //         } else {
    //             $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][landmark]" value="" placeholder="landmark">';
    //         }

    //         $fitypesFeild .= '</div>';
    //     }

    //     return view('backend.pages.cases.view', compact('cases', 'banks', 'roles', 'fitypes', 'fitypesFeild', 'ApplicationTypes', 'fi_type_ids', 'AvailbleProduct'));
    // }
    public function getCase($case_fi_type_id = null)
    {
        $case_fi_type = casesFiType::findOrFail($case_fi_type_id);

        if ($case_fi_type !== null) {
            return response()->json(['case_fi_type' => $case_fi_type]);
        } else {
            return response()->json(['error' => 'Bank ID not provided.'], 400);
        }
    }
    public function editCase($id)
    {
        $case = casesFiType::with(['getUser', 'getCase', 'getCaseFiType', 'getFiType', 'getCaseStatus'])->where('id', $id)->firstOrFail();
        $assign = false;
        return view('backend.pages.cases.view', compact('case', 'assign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCase(Request $request, $id)
    {
        $cases = Cases::findOrFail($id);
        $cases->bank_id             = $request->bank_id ??  $cases->bank_id;
        $cases->product_id          = $request->product_id ??   $cases->product_id;
        $cases->application_type    = $request->application_type ??  $cases->application_type;
        if ($request->application_type == '1') {
            $cases->applicant_name      = $request->applicant_name ?? $cases->applicant_name;
        } elseif ($request->application_type == '2') {
            $cases->applicant_name      = $request->applicant_name ?? $cases->applicant_name;
            $cases->co_applicant_name   = $request->co_applicant_name ?? $cases->co_applicant_name;
        } elseif ($request->application_type == '3') {
            $cases->applicant_name      = $request->guarantee_name ?? $cases->applicant_name;
        } elseif ($request->application_type == '4') {
            $cases->applicant_name      = $request->seller_name ??  $cases->applicant_name;
        }
        $cases->refrence_number     = $request->refrence_number ??  $cases->refrence_number;
        $cases->amount              = $request->amount ??   $cases->amount;
        $cases->vehicle             = $request->vehicle ??  $cases->vehicle;
        $cases->geo_limit           = $request->geo_limit ??   $cases->geo_limit;
        $cases->remarks             = $request->remarks ??   $cases->remarks;
        $cases->updated_by          = Auth::guard('admin')->user()->id;
        $cases->save();
        foreach ($request->fi_type_id as $fi_type_id) {
            if (!empty($fi_type_id['id'])) {
                casesFiType::updateOrInsert(
                    ['case_id' => $cases->id, 'fi_type_id' => $fi_type_id['id']],
                    ['mobile' => $fi_type_id['phone_number'], 'address' => $fi_type_id['address'], 'pincode' => $fi_type_id['pincode'], 'land_mark' => $fi_type_id['landmark'], 'user_id' => 0]
                );
            }
        }

        session()->flash('success', 'Case has been updated !!');
        return redirect()->route('admin.case.index');
    }
    public function uploadCaseImage($case_fi_type_id)
    {
        $case_img = CasesFiType::findOrFail($case_fi_type_id);
        return view('backend.pages.cases.uploadImage', compact('case_img', 'case_fi_type_id'));
    }

    public function uploadImage(Request $request, $case_fi_type_id)
    {


        // Validate the uploaded files
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048', // max size 2MB per image
        ]);

        // Find the record by ID
        $case = CasesFiType::findOrFail($case_fi_type_id);

        $year = date('Y');
        $month = date('m');
        $path = "images/cases/{$year}/{$month}";

        // Ensure the directory exists
        if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 0777, true);
        }

        // Handle each uploaded file
        foreach ($request->file('images') as $file) {
            // Get the first available image slot
            $imgField = $this->getAvailableImageField($case);

            if ($imgField) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path($path), $filename);

                // Save the filename to the current image field
                $case->$imgField = "{$path}/{$filename}";
                $case->save();

                session()->flash('success', 'Image uploaded successfully');
            } else {
                session()->flash('error', 'All image slots are filled');
                break;
            }
        }

        return back();
    }


    private function getAvailableImageField($case)
    {
        for ($i = 1; $i <= 9; $i++) {
            $imgField = 'image_' . $i;
            if (is_null($case->$imgField)) {
                return $imgField;
            }
        }
        return null;
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

    public function getItem($bankId = null)
    {
        $AvailbleProduct = Product::select('bpm.id', 'bpm.bank_id', 'bpm.product_id', 'products.name', 'products.product_code')
            ->leftJoin('bank_product_mappings as bpm', 'bpm.product_id', '=', 'products.id')
            ->where('bpm.bank_id', $bankId)
            ->where('products.status', '1')
            ->get()->toArray();


        if ($bankId !== null) {
            return response()->json(['AvailbleProduct' => $AvailbleProduct]);
        } else {
            return response()->json(['error' => 'Bank ID not provided.'], 400);
        }
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function importExportView($bankId = 1)
    {
        $banks  = Bank::all();
        return view('backend.pages.cases.import', compact('banks'));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        $params = $request->all();
        $rows = Excel::toArray([], $request->file('file'));

        foreach ($rows[0] as $key => $row) {
            if ($key > 0 && !empty($row[0])) {
                $cases = new Cases();
                $cases->bank_id             = $params['bank_id'];
                $cases->product_id          = $params['product_id'];
                $cases->application_type    = '3';
                $cases->refrence_number     = $row['4'];
                $cases->applicant_name      = $row['5'];
                $cases->amount              = '0';
                $cases->created_by          = '0';
                $cases->updated_by          = '0';
                $cases->save();
                $cases_id = $cases->id;

                $fitype_data = $row[6];
                $fitype_details = FiType::where('name', '=', $fitype_data)->first();

                if ($fitype_details) {
                    $fitype_id = $fitype_details['id'];
                } else {
                    $fitype = new FiType();
                    $fitype->name         = $fitype_data;
                    $fitype->created_by   = '0';
                    $fitype->updated_by   = '0';
                    $fitype->save();
                    $fitype_id = $fitype->id;
                }
                $casesFiType = new casesFiType;
                $casesFiType->case_id       = $cases_id;
                $casesFiType->fi_type_id    = $fitype_id;
                $casesFiType->mobile        = $row['13'];
                $casesFiType->address       = $row['8'];
                $casesFiType->pincode       = $row['11'];
                $casesFiType->land_mark     = $row['12'];
                $casesFiType->status        = 0;
                $casesFiType->user_id       = 1;
                $casesFiType->save();
            }
        }
        session()->flash('success', 'File imported successfully.');
        return redirect()->route('admin.case.index');
    }


    public function caseStatus($status, $user_id = Null)
    {
        $user_id = $user_id ?? 0;
        $query = DB::table('cases_fi_types as cft')
            ->select(
                'cft.id',
                'c.refrence_number',
                'c.applicant_name',
                'c.co_applicant_name',
                'cft.mobile',
                'cft.address',
                'b.name as bank_name',
                'p.name as product_name',
                'ft.name as fi_type_name',
                'cft.scheduled_visit_date',
                'cft.status',
                'u.name as agent_name'
            )
            ->join('cases as c', 'c.id', '=', 'cft.case_id')
            ->join('fi_types as ft', 'ft.id', '=', 'cft.fi_type_id')
            ->join('banks as b', 'b.id', '=', 'c.bank_id')
            ->join('products as p', 'p.id', '=', 'c.product_id')
            ->leftJoin('users as u', 'u.id', '=', 'cft.user_id')
            ->where('cft.user_id', $user_id)
            ->where('cft.status', '!=', '7');
        if ($status != 'aaa') {
            $query->where('cft.status', $status);
        }
        $cases = $query->get();
        $assign = false;

        return view('backend.pages.cases.caseList', compact('cases', 'assign'));
    }

    public function assigned($status, $user_id = null)
    {

        $cases  = DB::table('cases_fi_types as cft')
            ->join('cases as c', 'c.id', '=', 'cft.case_id')
            ->join('fi_types as ft', 'ft.id', '=', 'cft.fi_type_id')
            ->leftJoin('users as u', 'u.id', '=', 'cft.user_id')
            ->where('cft.user_id', '0')
            ->select('cft.id', 'c.refrence_number', 'c.applicant_name',  'c.co_applicant_name', 'cft.mobile', 'cft.address', 'ft.name',  'cft.scheduled_visit_date', 'cft.status', 'u.name as agent_name')
            ->get();

        return view('backend.pages.cases.caseList', compact('cases'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assignAgent(Request $request)
    {
        // Validation Data
        $request->validate([
            'user_id' => 'required|max:50|',
        ]);
        $user_id                = $request['user_id'];
        $scheduled_visit_date   = $request['ScheduledVisitDate'];
        $case_fi_type_ids       = $request['case_fi_type_id'];

        $case_fi_type_ids = json_decode($case_fi_type_ids, true);
        foreach ($case_fi_type_ids as $case_fi_type_id) {
            $case_fi_type_id = (int) $case_fi_type_id;

            $cases = casesFiType::find($case_fi_type_id);
            $cases->user_id                 = $user_id;
            $cases->scheduled_visit_date    = $scheduled_visit_date;
            $cases->status                  = '1';
            $cases->save();
        }
        session()->flash('success', 'User assign successfully !!');
        return back();
    }


    public function resolveCase(Request $request)
    {
        $case_fi_type_id                = $request['case_fi_type_id'];
        $status                         = '2';
        $sub_status                     = $request['sub_status'];
        $consolidated_remarks           = $request['consolidated_remarks'];
        $cases                          = casesFiType::find($case_fi_type_id);
        $cases->status                  = $status;
        $cases->sub_status              = $sub_status;
        $cases->consolidated_remarks    = $consolidated_remarks;
        $cases->save();
        session()->flash('success', 'Case Resolve successfully !!');
        return redirect()->route('admin.dashboard');
    }
    public function verifiedCase(Request $request)
    {

        $case_fi_type_id                = $request['case_fi_type_id'];
        $status                         = '4';
        $sub_status                     = $request['sub_status'];
        $consolidated_remarks           = $request['consolidated_remarks'];
        $cases                          = casesFiType::find($case_fi_type_id);
        $cases->status                  = $status;
        $cases->sub_status              = $sub_status;
        $cases->consolidated_remarks    = $consolidated_remarks;
        $cases->save();
        session()->flash('success', 'Case Resolve successfully !!');
        return redirect()->route('admin.dashboard');
    }


    public function updateConsolidated(Request $request)
    {

        $case_fi_type_id                = $request['case_fi_type_id'];
        $consolidated_remarks           = $request['consolidated_remarks'];
        $cases                          = casesFiType::find($case_fi_type_id);
        $cases->consolidated_remarks    = $consolidated_remarks;
        $cases->save();
        session()->flash('success', 'Remark Update successfully !!');
        return redirect()->route('admin.dashboard');
    }

    public function closeCase($case_fi_type_id)
    {

        $cases             = casesFiType::find($case_fi_type_id);
        $cases->status     = '7';
        $cases->save();
        return response()->json(['success' => 'Case Close successfully.'], 200);
    }

    public function deleteImage(Request $request, $image_number)
    {

        $case_fi_type_id = $request['case_fi_type_id'];
        $imgNumber = 'image_' . $image_number;

        $cases = casesFiType::findOrFail($case_fi_type_id);
        $cases->$imgNumber     = NULL;
        // $cases->updated_by     = Auth::guard('admin')->user()->id;
        $cases->save();

        // session()->flash('success', 'Image uploaded successfully');
        return response()->json(['success' => 'Image delete successfully.'], 200);
    }

    private function importCSV($file)
    {
        if (($handle = fopen($file->getRealPath(), 'r')) !== FALSE) {
            $header = fgetcsv($handle, 1000, ',');
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $row = array_combine($header, $data);
                DB::table('your_table')->insert([
                    'column1' => $row['Header1'],
                    'column2' => $row['Header2'],
                    // more columns...
                ]);
            }
            fclose($handle);
        }
    }


    private function importExcel($file)
    {
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $header = $sheetData[1];
        unset($sheetData[1]); // Remove header row

        foreach ($sheetData as $row) {
            $data = array_combine($header, $row);
            DB::table('your_table')->insert([
                'column1' => $data['A'], // Adjust based on your Excel columns
                'column2' => $data['B'],
                // more columns...
            ]);
        }
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function export()
    {
        dd('sssssssssssssssssssssssssssssss');

        // Excel::import(new UsersImport, request()->file('file'));

        return back();
    }

    public function viewCase($id)
    {
        $case = casesFiType::with(['getUser', 'getCase', 'getCaseFiType', 'getFiType', 'getCaseStatus'])->where('id', $id)->firstOrFail();
        $assign = false;
        return view('backend.pages.cases.view', compact('case', 'assign'));
    }
    public function viewCaseAssign($id)
    {
        $case = casesFiType::with(['getUser', 'getCase', 'getCaseFiType', 'getFiType', 'getCaseStatus'])->where('id', $id)->firstOrFail();
        $assign = true;
        return view('backend.pages.cases.view', compact('case', 'assign'));
    }
}
