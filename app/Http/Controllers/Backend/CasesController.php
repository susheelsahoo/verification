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
use App\Models\CaseHistory;
use App\Models\CaseStatus;
use Carbon\Carbon;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use ZipArchive;
use ZipStream\File;
use Illuminate\Support\Facades\Storage;
use App\Exports\ExportCase;
use Dompdf\Dompdf;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use App\Helpers\LogHelper;
use App\Helpers\CaseHistoryHelper;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

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
            $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][pincode]" min="100000" max="999999" placeholder="Pincode">';

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
        $rules = [];
        $messages = [];

        if ($request['application_type'] == '1' || $request['application_type'] == '2') {
            // Validate applicant name for Applicant and Co-Applicant
            $rules['applicant_name'] = 'required|max:50';
            $messages['applicant_name.required'] = 'The applicant name is required.';
        } elseif ($request['application_type'] == '3') {
            // Validate guarantee name for Guarantor
            $rules['guarantee_name'] = 'required|max:50';
            $messages['guarantee_name.required'] = 'The guarantor name is required.';
        } elseif ($request['application_type'] == '4') {
            // Validate seller name for Seller
            $rules['seller_name'] = 'required|max:50';
            $messages['seller_name.required'] = 'The seller name is required.';
        }

        $request->validate($rules, $messages);



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

            if (!empty($fi_type_id['phone_number'])) {
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

        LogHelper::logActivity('Create Case', 'User created a new case.');
        CaseHistoryHelper::logHistory($cases_id, null, null, null, 'New Case', 'Case Create', 'New Case Created');

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

        LogHelper::logActivity('Show Case', 'User show case.');

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
            $cases->applicant_name      = $request->applicant_name ??  $cases->applicant_name;
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

        LogHelper::logActivity('Update Case', 'User update case.');
        CaseHistoryHelper::logHistory($id, null, null, null, 'New Case', 'Update Case', 'Update Case');

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
            $cases->applicant_name      = $request->applicant_name;
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

        LogHelper::logActivity('Reinitatiate Case', 'User reinitatiate case.');

        CaseHistoryHelper::logHistory($cases_id, null, null, null, 'Case', 'Reinitatiate Case', 'Reinitatiate Case');

        return redirect()->route('admin.case.index');
    }

    public function reinitatiateCaseNew($id)
    {

        $casesFiType = casesFiType::with('getCase')->findOrFail($id);
        $applicentHtml = '';
        if ($casesFiType->getCase['application_type'] == '1') {
            $applicentHtml = '<div class="form-group">
                            <label for="applicant_name">Applicant Name:</label>
                            <input type="text" class="form-control" id="applicant_name" name="applicant_name" value="' . $casesFiType->getCase['applicant_name'] . '">
                        </div> ';
        } elseif ($casesFiType->getCase['application_type'] == '2') {
            $applicentHtml = '<div class="form-group">
                            <label for="applicant_name">Applicant Name:</label>
                            <input type="text" class="form-control" id="applicant_name" name="applicant_name" value="' . $casesFiType->getCase['applicant_name'] . '">
                        </div>
                        <div class="form-group">
                            <label for="applicant_name">Co-Applicant Name:</label>
                            <input type="text" class="form-control" id="applicant_name" name="applicant_name" value="' . $casesFiType->getCase['applicant_name'] . '">
                        </div> ';
        } elseif ($casesFiType->getCase['application_type'] == '3') {
            $applicentHtml = '<div class="form-group">
                            <label for="applicant_name">Guranter Name:</label>
                            <input type="text" class="form-control" id="applicant_name" name="applicant_name" value="' . $casesFiType->getCase['applicant_name'] . '">
                        </div> ';
        } elseif ($casesFiType->getCase['application_type'] == '4') {
            $applicentHtml = '<div class="form-group">
                            <label for="applicant_name">Seller Name:</label>
                            <input type="text" class="form-control" id="applicant_name" name="applicant_name" value="' . $casesFiType->getCase['applicant_name'] . '">
                        </div> ';
        }

        $htmlFormReinitatiateCase = '<div class="modal-body">
                                        <div class="form-group">
                                            <label for="refrence_number">Refrence number:</label>
                                            <input type="text" class="form-control" id="refrence_number" name="refrence_number" value="' . $casesFiType->getCase->refrence_number . '">
                                        </div>
                                        ' . $applicentHtml . '
                                        <div class="form-group">
                                            <label for="address">Address:</label>
                                            <input type="text" class="form-control" id="address" name="address" value="' . $casesFiType->address . '">
                                        </div>
                                        <div class="form-group">
                                            <label for="mobile">Phone Number:</label>
                                            <input type="text" class="form-control" id="mobile" name="mobile" value="' . $casesFiType->mobile . '">
                                        </div>
                                        <div class="form-group">
                                            <label for="land_mark">Landark:</label>
                                            <input type="text" class="form-control" id="land_mark" name="land_mark" value="' . $casesFiType->land_mark . '">
                                        </div>
                                        <div class="form-group">
                                            <label for="pincode">PinCode:</label>
                                            <input type="text" class="form-control" id="pincode" name="pincode" value="' . $casesFiType->pincode . '">
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Amount:</label>
                                            <input type="text" class="form-control" id="amount" name="amount" value="' . $casesFiType->getCase['amount'] . '">
                                        </div>
                                        <div class="form-group">
                                            <label for="vehicle">Vehicle:</label>
                                            <input type="text" class="form-control" id="vehicle" name="vehicle" value="' . $casesFiType->getCase['vehicle'] . '">
                                        </div>

                                        <input type="hidden" id="case_fi_type_id" name="case_fi_type_id" value="' . $id . '">
                                    </div>
                                    ';

        if ($casesFiType !== null) {

            return response()->json(['htmlFormReinitatiateCase' => $htmlFormReinitatiateCase]);
        } else {
            return response()->json(['error' => 'Something went wrong.'], 400);
        }
    }
    public function reinitatiateNew(Request $request)
    {
        $case_fi_type_id = $request['case_fi_type_id'];
        $originalCaseFiType  = casesFiType::findOrFail($case_fi_type_id);
        $case_id = $originalCaseFiType->case_id;
        $originalCaseData  = Cases::findOrFail($case_id);
        $newCasedata = $originalCaseData->replicate();
        $newCasedata->refrence_number = $request['refrence_number'];
        $newCasedata->applicant_name = $request['applicant_name'];
        $newCasedata->amount = $request['amount'];
        $newCasedata->vehicle = $request['vehicle'];
        $newCasedata->save();

        $newCaseFiType = $originalCaseFiType->replicate();
        $newCaseFiType->address     = $request['address'];
        $newCaseFiType->mobile      = $request['mobile'];
        $newCaseFiType->land_mark   = $request['land_mark'];
        $newCaseFiType->pincode     = $request['pincode'];
        $newCaseFiType->user_id     = '0';
        $newCaseFiType->status      = '0';
        $newCaseFiType->case_id     = $newCasedata->id;
        $newCaseFiType->save();

        session()->flash('success', 'Case Reinitatiate Successfully.');
        LogHelper::logActivity('Reinitatiate Case', 'User reinitatiate case as New Case.');
        CaseHistoryHelper::logHistory($newCasedata->id, 0, null, null, 'Existing Case ' . $case_id, 'Reinitatiate Case', 'Reinitatiate Case');
        return back();
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

        LogHelper::logActivity('View Case', 'User view case.');

        return view('backend.pages.cases.show', compact('cases', 'banks', 'roles', 'fitypes', 'fitypesFeild', 'ApplicationTypes', 'fi_type_ids', 'AvailbleProduct'));
    }

    public function getCase($case_fi_type_id = null)
    {
        $case_fi_type = casesFiType::findOrFail($case_fi_type_id);

        if ($case_fi_type !== null) {
            LogHelper::logActivity('Get Case', 'User fetch case record.');
            return response()->json(['case_fi_type' => $case_fi_type]);
        } else {
            return response()->json(['error' => 'Bank ID not provided.'], 400);
        }
    }
    public function editCase($id)
    {
        $case = casesFiType::with(['getUser', 'getCase', 'getCaseFiType', 'getFiType', 'getCaseStatus'])->where('id', $id)->firstOrFail();
        $assign = false;
        $is_edit_case  = '1';
        $ApplicationTypes   = ApplicationType::all();
        $users              = User::where('admin_id', Auth::guard('admin')->user()->id)->get();
        return view('backend.pages.cases.editcase', compact('case', 'assign', 'is_edit_case', 'ApplicationTypes', 'users'));
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
            $cases->applicant_name      = $request->applicant_name;
        }
        $cases->refrence_number     = $request->refrence_number;
        $cases->amount              = $request->amount;
        $cases->vehicle             = $request->vehicle;
        $cases->geo_limit           = $request->geo_limit;
        $cases->remarks             = $request->remarks;
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
        LogHelper::logActivity('Update Case', 'User update case.');
        CaseHistoryHelper::logHistory($id, null, null, null, 'Existing Case', 'Update Case', 'Update Case');
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
        LogHelper::logActivity('Upload Document', 'User upload supported document to the case.');
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
        LogHelper::logActivity('Delete Case', 'User delete case.');
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
                $fitype_data    = $row[14];
                $user_id        = '0';
                $status         = '0';
                $agent_details = User::where('username', '=', $fitype_data)->first();
                if ($agent_details) {
                    $user_id = $agent_details['id'];
                    $status = '1';
                }
                $casesFiType = new casesFiType;
                $casesFiType->case_id       = $cases_id;
                $casesFiType->fi_type_id    = $fitype_id;
                $casesFiType->mobile        = $row['13'];
                $casesFiType->address       = $row['8'];
                $casesFiType->pincode       = $row['11'];
                $casesFiType->land_mark     = $row['12'];
                $casesFiType->status        = $status;
                $casesFiType->user_id       = $user_id;
                $casesFiType->save();
            }
        }
        session()->flash('success', 'File imported successfully.');
        LogHelper::logActivity('Import Case', 'User imprt case.');
        return redirect()->route('admin.case.index');
    }
    public function caseStatus(Request $request,  $status, $user_id = Null)
    {
        $user_id = $user_id ?? 0;

        $assign = false;
        if ($request->FromDate) {
            $FromDate = $request->FromDate;
            $ToDate = $request->ToDate;
        } else {
            $FromDate = date('Y-m-d 00:00:00');
            $ToDate = date('Y-m-d 23:59:59');
        }

        $FromDate = Carbon::now()->startOfDay(); // 2024-10-01 00:00:00
        $ToDate = Carbon::now()->endOfDay();     // 2024-10-01 23:59:59

        if ($status != 'aaa') {
            $casesQuery = casesFiType::with(['getUser', 'getCase', 'getCaseFiType', 'getFiType', 'getCaseStatus'])
                ->where('status', $status);  // Filter by user ID           
        } else {
            $casesQuery = casesFiType::with(['getUser', 'getCase', 'getCaseFiType', 'getFiType', 'getCaseStatus']);
        }
        if (!in_array($status, [0, 1, 6])) {
            $casesQuery->whereBetween('updated_at', [$FromDate, $ToDate]);
        }
        $casesQuery->where('user_id', $user_id);
        $cases = $casesQuery->get();

        return view('backend.pages.cases.caseList', compact('cases', 'assign'));
    }

    // public function caseStatussss(Request $request,  $status, $user_id = Null)
    // {
    //     $user_id = $user_id ?? 0;

    //     $assign = false;
    //     if ($request->FromDate) {
    //         $FromDate = $request->FromDate;
    //         $ToDate = $request->ToDate;
    //     } else {
    //         $FromDate = date('Y-m-d 00:00:00');
    //         $ToDate = date('Y-m-d 23:59:59');
    //     }

    //     $FromDate = Carbon::now()->startOfDay(); // 2024-10-01 00:00:00
    //     $ToDate = Carbon::now()->endOfDay();     // 2024-10-01 23:59:59

    //     if ($status != 'aaa') {
    //         $cases = casesFiType::with(['getUser', 'getCase', 'getCaseFiType', 'getFiType', 'getCaseStatus'])
    //             ->where('status', $status)
    //             ->where('user_id', $user_id)
    //             ->whereBetween('updated_at', [$FromDate, $ToDate])
    //             ->get();
    //     } else {
    //         $cases = casesFiType::with(['getUser', 'getCase', 'getCaseFiType', 'getFiType', 'getCaseStatus'])
    //             ->where('user_id', $user_id)
    //             ->whereBetween('updated_at', [$FromDate, $ToDate])
    //             ->get();
    //     }

    //     return view('backend.pages.cases.caseList', compact('cases', 'assign'));
    // }

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
            CaseHistoryHelper::logHistory($cases->case_id, 1, null, $user_id, 'New Case', 'Assign Case', 'Assign Case');
        }
        session()->flash('success', 'User assign successfully !!');
        LogHelper::logActivity('Assign Case', 'User assign case.');
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
        $cases->visited_by              = Auth::guard('admin')->user()->name;
        $cases->date_of_visit           = date('Y-m-d');
        $cases->time_of_visit           = date('H:i:s');
        $cases->save();
        session()->flash('success', 'Case Resolve successfully !!');
        CaseHistoryHelper::logHistory($cases->case_id, 2, $request['sub_status'], $cases->user_id, $consolidated_remarks, 'Resolve Case', 'Resolve Case');
        LogHelper::logActivity('Resolve Case', 'User resolve case.');
        return redirect()->route('admin.dashboard');
    }
    public function verifiedCase(Request $request)
    {
        $case_fi_type_id                = $request['case_fi_type_id'];
        $status                         = '4';
        $sub_status                     = $request['sub_status'];
        $supervisor_remarks             = $request['supervisor_remarks'];
        $cases                          = casesFiType::find($case_fi_type_id);
        $cases->status                  = $status;
        $cases->sub_status              = $sub_status;
        $cases->supervisor_remarks      = $supervisor_remarks;
        $cases->verified_by             = Auth::guard('admin')->user()->name;
        $cases->save();
        session()->flash('success', 'Case Resolve successfully !!');
        CaseHistoryHelper::logHistory($cases->case_id, $status, $sub_status, $cases->user_id, $supervisor_remarks, 'Verified Case', 'Verified Case');
        LogHelper::logActivity('Verify Case', 'User verify case.');
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
        LogHelper::logActivity('Update Remark', 'User update remark of the case.');
        CaseHistoryHelper::logHistory($cases->case_id, $cases->status, $cases->sub_status, $cases->user_id, $consolidated_remarks, 'Update Remark Case', 'Update Remark Case');
        return redirect()->route('admin.dashboard');
    }

    public function closeCase($case_fi_type_id)
    {

        $cases             = casesFiType::find($case_fi_type_id);
        $cases->status     = '7';
        $cases->save();
        LogHelper::logActivity('Close Case', 'User close case status.');
        CaseHistoryHelper::logHistory($cases->case_id, 7, $cases->sub_status, $cases->user_id, $cases->consolidated_remarks, 'Close Case', 'Close Case');
        return response()->json(['success' => 'Case Close successfully.'], 200);
    }
    public function cloneCase($case_fi_type_id)
    {
        $originalCaseFiType  = casesFiType::findOrFail($case_fi_type_id);
        $case_id = $originalCaseFiType->case_id;
        $originalCaseData  = Cases::findOrFail($case_id);
        $newCasedata = $originalCaseData->replicate();
        $newCasedata->save();

        $newCaseFiType = $originalCaseFiType->replicate();
        // $newCaseFiType->status = '0';
        $newCaseFiType->case_id = $newCasedata->id;
        $newCaseFiType->save();

        // Duplicate related case_fi_types

        LogHelper::logActivity('Clone Case', 'User create clone of the case.');
        CaseHistoryHelper::logHistory($newCasedata->id, null, null, null, 'Clone Case ' . $case_id, 'Clone Case', 'Clone Case');
        return response()->json(['success' => 'Case Clone successfully.'], 200);
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
        LogHelper::logActivity('Remove Document', 'User remove case supported document.');
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
        /*
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
        } */

        return true;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function exportCase($id = null)
    {
        LogHelper::logActivity('Export Case', 'User export case.');
        return Excel::download(new ExportCase, 'cases.xlsx');
    }

    public function viewCase($id)
    {
        $case = casesFiType::with(['getUser', 'getCase', 'getCaseFiType', 'getFiType', 'getCaseStatus'])->where('id', $id)->firstOrFail();
        $assign = false;
        $is_edit_case  = '0';
        $ApplicationTypes   = ApplicationType::all();
        $users              = User::where('admin_id', Auth::guard('admin')->user()->id)->get();
        return view('backend.pages.cases.editcase', compact('case', 'assign', 'is_edit_case', 'ApplicationTypes', 'users'));
    }
    public function viewCaseAssign($id)
    {
        $case = casesFiType::with(['getUser', 'getCase', 'getCaseFiType', 'getFiType', 'getCaseStatus'])->where('id', $id)->firstOrFail();
        $assign = true;
        return view('backend.pages.cases.view', compact('case', 'assign'));
    }

    public  function modifyCase(Request $request, $id)
    {

        $input = $request->all();
        $case_fi_type_id = $input['case_fi_id'];
        $casesFiType             = casesFiType::findOrFail($case_fi_type_id);
        $case                    = Cases::find($casesFiType->case_id);

        $casesFiType->mobile     = $input['mobile'] ?? null;
        $casesFiType->address    = $input['address'] ?? null;
        $casesFiType->pincode    = $input['pincode'] ?? null;
        $casesFiType->land_mark  = $input['land_mark'] ?? null;
        $casesFiType->save();

        $case->amount           = $input['loan_amont'] ?? null;
        $case->applicant_name   = $input['name'] ?? null;
        $case->save();

        LogHelper::logActivity('Modify Case', 'User modify case.');
        // CaseHistoryHelper::logHistory($case_fi_type_id, $status, $sub_status, $cases->user_id, $supervisor_remarks, 'Verified Case', 'Verified Case');
        return response()->json(['success' => 'Case Update successfully !!'], 200);
        // session()->flash('success', 'Case Update successfully !!');
        // return redirect()->back();

    }

    public function getForm($id = null)
    {
        $case = casesFiType::with(['getUser', 'getCase', 'getCaseFiType', 'getFiType', 'getCaseStatus'])->where('id', $id)->firstOrFail();
        $fi_type_id = $case['fi_type_id'];

        $fi_type_details = FiType::find($fi_type_id);
        if ($fi_type_details['name'] == 'BV') {
            $view = view('backend.pages.cases.details-bv', compact('case'))->render();
        } else if ($fi_type_details['name'] == 'RV') {
            $view = view('backend.pages.cases.details-rv', compact('case'))->render();
        } else if ($fi_type_details['name'] == 'ITR') {
            $caseType = 'ITR Verification Format';
            $view = view('backend.pages.cases.details-itr', compact('case', 'caseType'))->render();
        } else if ($fi_type_details['name'] == 'BSV') {
            $caseType = 'Residence Verification Format';
            $view = view('backend.pages.cases.details-itr', compact('case', 'caseType'))->render();
        } else if ($fi_type_details['name'] == 'salary ship') {
            $caseType = 'Salary sip Format';
            $view = view('backend.pages.cases.details-itr', compact('case', 'caseType'))->render();
        }
        return response()->json(['viewData' => $view]);
    }

    public function modifyForm($id = null)
    {
        $case = casesFiType::with(['getUser', 'getCase', 'getCaseFiType', 'getFiType', 'getCaseStatus'])->where('id', $id)->firstOrFail();
        $AvailbleProduct = [];
        if ($case->getCase->bank_id) {
            $AvailbleProduct = Product::select('bpm.id', 'bpm.bank_id', 'bpm.product_id', 'products.name', 'products.product_code')
                ->leftJoin('bank_product_mappings as bpm', 'bpm.product_id', '=', 'products.id')
                ->where('bpm.bank_id', $case->getCase->bank_id)
                ->where('products.status', '1')
                ->get();
        }
        $fi_type_id = $case['fi_type_id'];

        $fi_type_details = FiType::find($fi_type_id);
        if ($fi_type_details['name'] == 'BV') {
            $view = view('backend.pages.cases.modify-bv',  compact('case', 'AvailbleProduct'))->render();
        } else {
            $view = view('backend.pages.cases.modify-rv',  compact('case', 'AvailbleProduct'))->render();
        }
        return response()->json(['viewData' => $view]);
    }

    public function modifyRVCase(Request $request, $id)
    {
        $rules = [
            'case_fi_id' => 'required',
            'amount' => 'required',
        ];
        $request->validate($rules);

        $input = $request->all();
        $case_fi_type_id = $input['case_fi_id'];
        $caseFi = casesFiType::findOrFail($case_fi_type_id);
        $case =  Cases::find($caseFi->case_id);

        $case->refrence_number  = $input['refrence_number'] ?? null;
        $case->applicant_name   = $input['applicant_name'] ?? null;

        $case->amount           = $input['amount'] ?? null;
        $case->save();

        $caseFi->mobile                             = $input['mobile'] ?? null;
        $caseFi->address                            = $input['address'] ?? null;
        $caseFi->address_confirmed                  = $input['address_confirmed'] ?? null;
        $caseFi->address_confirmed_by               = $input['address_confirmed_by'] ?? null;
        $caseFi->person_met                         = $input['person_met'] ?? null;
        $caseFi->relationship                       = $input['relationship'] ?? null;
        $caseFi->no_of_residents_in_house           = $input['no_of_residents_in_house'] ?? null;
        $caseFi->year_of_establishment              = $input['year_of_establishment'] ?? null;
        $caseFi->no_of_earning_family_members       = $input['no_of_earning_family_members'] ?? null;
        $caseFi->residence_status                   = $input['residence_status'] ?? null;
        $caseFi->approx_rent                        = $input['approx_rent'] ?? null;
        $caseFi->latitude                           = $input['latitude'] ?? null;
        $caseFi->longitude                          = $input['longitude'] ?? null;
        $caseFi->permanent_address                  = $input['permanent_address'] ?? null;
        $caseFi->location                           = $input['location'] ?? null;
        $caseFi->locality                           = $input['locality'] ?? null;
        $caseFi->accommodation_type                 = $input['accommodation_type'] ?? null;
        $caseFi->interior_conditions                = $input['interior_conditions'] ?? null;
        $caseFi->assets_seen                        = $input['assets_seen'] ?? null;
        $caseFi->area                               = $input['area'] ?? null;
        $caseFi->standard_of_living                 = $input['standard_of_living'] ?? null;
        $caseFi->nearest_landmark                   = $input['nearest_landmark'] ?? null;
        $caseFi->relationship_others                = $input['relationship_others'] ?? null;
        $caseFi->applicant_age                      = $input['applicant_age'] ?? null;
        $caseFi->residence_status_others            = $input['residence_status_others'] ?? null;
        $caseFi->years_at_current_residence_others  = $input['years_at_current_residence_others'] ?? null;
        $caseFi->occupation                         = $input['occupation'] ?? null;
        $caseFi->verifiers_name                     = $input['verifiers_name'] ?? null;
        $caseFi->verification_conducted_at          = $input['verification_conducted_at'] ?? null;
        $caseFi->proof_attached                     = $input['proof_attached'] ?? null;
        $caseFi->type_of_proof                      = $input['type_of_proof'] ?? null;
        $caseFi->date_of_visit                      = $input['date_of_visit'] ?? null;
        $caseFi->time_of_visit                      = $input['time_of_visit'] ?? null;
        $caseFi->supervisor_remarks                 = $input['supervisor_remarks'] ?? null;
        // $caseFi->visit_conducted                    = $input['visit_conducted'] ?? 'NO';
        $caseFi->tcp1_name                          = $input['tcp1_name'] ?? null;
        $caseFi->tcp1_checked_with                  = $input['tcp1_checked_with'] ?? null;
        $caseFi->tcp1_negative_comments             = $input['tcp1_negative_comments'] ?? null;
        $caseFi->tcp2_name                          = $input['tcp2_name'] ?? null;
        $caseFi->tcp2_checked_with                  = $input['tcp2_checked_with'] ?? null;
        $caseFi->tcp2_negative_comments             = $input['tcp2_negative_comments'] ?? null;
        $caseFi->visited_by                         = $input['visited_by'] ?? null;
        $caseFi->verified_by                        = $input['verified_by'] ?? null;

        // Save the model
        $caseFi->save();
        session()->flash('success', 'Case Update successfully !!');
        LogHelper::logActivity('Modify RV Case', 'User modify rv case.');
        return response()->json(['success' => 'Case Update successfully !!'], 200);
    }

    public function modifyBVCase(Request $request, $id)
    {
        $input = $request->all();
        $rules = [
            'case_fi_id' => 'required',
            'amount' => 'required',

        ];
        $request->validate($rules);
        $case_fi_type_id = $input['case_fi_id'];
        $caseFi = casesFiType::findOrFail($case_fi_type_id);
        $case =  Cases::find($caseFi->case_id);

        $case->refrence_number = $input['refrence_number'] ?? null;
        $case->applicant_name = $input['applicant_name'] ?? null;
        // $case->product_id = $input['product_id'] ?? null;
        $case->amount = $input['amount'] ?? null;
        $case->save();

        $caseFi->mobile                         = $input['mobile'] ?? null;
        $caseFi->address                        = $input['address'] ?? null;
        $caseFi->address_confirmed              = $input['address_confirmed'] ?? null;
        $caseFi->employer_address               = $input['employer_address'] ?? null;
        $caseFi->type_of_proof                  = $input['type_of_proof'] ?? null;
        $caseFi->address_confirmed_by           = $input['address_confirmed_by'] ?? null;
        $caseFi->name_of_employer               = $input['name_of_employer'] ?? null;
        $caseFi->person_met                     = $input['person_met'] ?? null;
        $caseFi->type_of_employer               = $input['type_of_employer'] ?? null;
        $caseFi->nature_of_employer             = $input['nature_of_employer'] ?? null;
        $caseFi->line_of_business               = $input['line_of_business'] ?? null;
        $caseFi->year_of_establishment          = $input['year_of_establishment'] ?? null;
        $caseFi->level_of_business_activity     = $input['level_of_business_activity'] ?? null;
        $caseFi->no_of_employees                = $input['no_of_employees'] ?? null;
        $caseFi->no_of_branches                 = $input['no_of_branches'] ?? null;
        $caseFi->interior_conditions            = $input['office_ambience'] ?? null;
        $caseFi->type_of_locality               = $input['type_of_locality'] ?? null;
        $caseFi->area                           = $input['area'] ?? null;
        $caseFi->nearest_landmark               = $input['nearest_landmark'] ?? null;
        // $caseFi->ease_of_locating               = $input['ease_of_locating'] ?? null;
        $caseFi->terms_of_employment            = $input['terms_of_employment'] ?? null;
        $caseFi->grade                          = $input['grade'] ?? null;
        $caseFi->year_of_establishment          = $input['year_of_establishment'] ?? null;
        $caseFi->applicant_age                  = $input['applicant_age'] ?? null;
        $caseFi->name_of_employer_co            = $input['name_of_employer_co'] ?? null;
        $caseFi->established                    = $input['established'] ?? null;
        $caseFi->designation                    = $input['designation'] ?? null;
        // $caseFi->visit_conducted                = $input['visit_conducted'] ?? 'NO';
        $caseFi->date_of_visit                  = $input['date_of_visit'] ?? null;
        $caseFi->time_of_visit                  = $input['time_of_visit'] ?? null;
        $caseFi->latitude                       = $input['latitude'] ?? null;
        $caseFi->longitude                      = $input['longitude'] ?? null;
        $caseFi->tcp1_name                      = $input['tcp1_name'] ?? null;
        $caseFi->tcp1_checked_with              = $input['tcp1_checked_with'] ?? null;
        $caseFi->tcp2_name                      = $input['tcp2_name'] ?? null;
        $caseFi->tcp2_checked_with              = $input['tcp2_checked_with'] ?? null;
        $caseFi->visited_by                     = $input['visited_by'] ?? null;
        $caseFi->verified_by                    = $input['verified_by'] ?? null;

        $caseFi->save();

        session()->flash('success', 'Case Update successfully !!');
        LogHelper::logActivity('Modify BV Case', 'User modify bv case.');
        return response()->json(['success' => 'Case Update successfully !!'], 200);
    }

    public function zipDownload($case_fi_id = null)
    {
        if ($case_fi_id) {
            $caseFi = casesFiType::findOrFail($case_fi_id);
            $zip      = new ZipArchive;
            $path = storage_path('app/public/');
            $fileName = 'attachment' . $caseFi->id . '.zip';
            $zipFile = $path . $fileName;
            if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
                if (isset($caseFi->image_1) &&  $caseFi->image_1) {
                    if (file_exists(public_path($caseFi->image_1))) {
                        $relativeName = basename($caseFi->image_1);
                        $zip->addFile(public_path($caseFi->image_1), $relativeName);
                    }
                }
                if (isset($caseFi->image_2) &&  $caseFi->image_2) {
                    if (file_exists(public_path($caseFi->image_2))) {
                        $relativeName = basename($caseFi->image_2);
                        $zip->addFile(public_path($caseFi->image_2), $relativeName);
                    }
                }
                if (isset($caseFi->image_3) &&  $caseFi->image_3) {
                    if (file_exists(public_path($caseFi->image_3))) {
                        $relativeName = basename($caseFi->image_3);
                        $zip->addFile(public_path($caseFi->image_3), $relativeName);
                    }
                }
                if (isset($caseFi->image_4) &&  $caseFi->image_4) {
                    if (file_exists(public_path($caseFi->image_4))) {
                        $relativeName = basename($caseFi->image_4);
                        $zip->addFile(public_path($caseFi->image_4), $relativeName);
                    }
                }
                if (isset($caseFi->image_5) &&  $caseFi->image_5) {
                    if (file_exists(public_path($caseFi->image_5))) {
                        $relativeName = basename($caseFi->image_5);
                        $zip->addFile(public_path($caseFi->image_5), $relativeName);
                    }
                }
                if (isset($caseFi->image_6) &&  $caseFi->image_6) {
                    if (file_exists(public_path($caseFi->image_6))) {
                        $relativeName = basename($caseFi->image_6);
                        $zip->addFile(public_path($caseFi->image_6), $relativeName);
                    }
                }
                if (isset($caseFi->image_7) &&  $caseFi->image_7) {
                    if (file_exists(public_path($caseFi->image_7))) {
                        $relativeName = basename($caseFi->image_7);
                        $zip->addFile(public_path($caseFi->image_7), $relativeName);
                    }
                }
                if (isset($caseFi->image_8) &&  $caseFi->image_8) {
                    if (file_exists(public_path($caseFi->image_8))) {
                        $relativeName = basename($caseFi->image_8);
                        $zip->addFile(public_path($caseFi->image_8), $relativeName);
                    }
                }
                if (isset($caseFi->image_9) &&  $caseFi->image_9) {
                    if (file_exists(public_path($caseFi->image_9))) {
                        $relativeName = basename($caseFi->image_9);
                        $zip->addFile(public_path($caseFi->image_9), $relativeName);
                    }
                }
                $zip->close();
            }
            if (file_exists($zipFile)) {
                LogHelper::logActivity('Zip Download', 'User dlownload case supported documet as zip.');
                return response()->download($zipFile);
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }

    public function generatePdf($id)
    {
        $case = casesFiType::with(['getUser', 'getCase', 'getCaseFiType', 'getFiType', 'getCaseStatus'])->where('id', $id)->firstOrFail();
        $view = view('backend.pages.cases.pdf',  compact('case'))->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $fileName = 'case' . '_' . date('Y-m-d_H-i-s') . '.pdf';
        $dompdf->stream($fileName, array("Attachment" => 1));
        LogHelper::logActivity('Print Case', 'User export case as pdf.');
        return true;
    }

    public function telecallerForm($id = null)
    {
        $case = casesFiType::with(['getUser', 'getCase', 'getCaseFiType', 'getFiType', 'getCaseStatus'])->where('id', $id)->firstOrFail();
        $AvailbleProduct = [];
        if ($case->getCase->bank_id) {
            $AvailbleProduct = Product::select('bpm.id', 'bpm.bank_id', 'bpm.product_id', 'products.name', 'products.product_code')
                ->leftJoin('bank_product_mappings as bpm', 'bpm.product_id', '=', 'products.id')
                ->where('bpm.bank_id', $case->getCase->bank_id)
                ->where('products.status', '1')
                ->get();
        }
        $fi_type_id = $case['fi_type_id'];
        $fi_type_details = FiType::find($fi_type_id);
        $view = view('backend.pages.cases.caller',  compact('case', 'AvailbleProduct'))->render();
        return response()->json(['viewData' => $view]);
    }

    public function telecallerSubmit(Request $request, $id)
    {
        $input =  $request->all();
        $caseFi = casesFiType::with(['getUser', 'getCase', 'getCaseFiType', 'getFiType', 'getCaseStatus'])->where('id', $id)->firstOrFail();
        $case =  Cases::find($caseFi->case_id);
        $case->refrence_number = $input['refrence_number'] ?? null;
        $case->applicant_name = $input['applicant_name'] ?? null;
        $case->save();
        $caseFi->mobile        = $input['mobile'] ?? null;
        $caseFi->address       = $input['address'] ?? null;
        $caseFi->person_met    = $input['person_met'] ?? null;
        $caseFi->relationship  = $input['relationship'] ?? null;
        $caseFi->applicant_age = $input['applicant_age'] ?? null;
        $caseFi->designation   = $input['designation'] ?? null;
        $caseFi->remarks       = $input['remarks'] ?? null;
        $caseFi->save();
        session()->flash('success', 'Case Update successfully !!');
        LogHelper::logActivity('Telecaller Case Update', 'Telecaller Case Update.');
        return redirect()->back();
    }

    public function sendCaseNotificaton($id = null)
    {
        $case = casesFiType::with(['getUser', 'getCase', 'getCaseFiType', 'getFiType', 'getCaseStatus'])->where('id', $id)->firstOrFail();
        $AvailbleProduct = [];
        if ($case->getCase->bank_id) {
            $AvailbleProduct = Product::select('bpm.id', 'bpm.bank_id', 'bpm.product_id', 'products.name', 'products.product_code')
                ->leftJoin('bank_product_mappings as bpm', 'bpm.product_id', '=', 'products.id')
                ->where('bpm.bank_id', $case->getCase->bank_id)
                ->where('products.status', '1')
                ->get();
        }
        $fi_type_id = $case['fi_type_id'];
        $fi_type_details = FiType::find($fi_type_id);
        $view = view('backend.pages.cases.notify',  compact('case', 'AvailbleProduct'))->render();
        return response()->json(['viewData' => $view]);
    }

    public function sendCaseNotificatonSubmit(Request $request, $id)
    {
        $input =  $request->all();
        $caseFi = casesFiType::with(['getUser', 'getCase', 'getCaseFiType', 'getFiType', 'getCaseStatus'])->where('id', $id)->firstOrFail();
        $details = ['body' => 'Your Case detail ink is ' . route('home.caseDetail', $id), 'from' => 'info@intelisysweb.com', 'subject' => 'Verification Status'];
        Mail::to('susheelcs0024@gmail.com')->send(new SendMail($details));
        session()->flash('success', 'Email sent successfully !!');
        return redirect()->back();
    }
}
