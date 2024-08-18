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
            $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][address]" value="Address' . $fitype['id'] . '" placeholder="Address">';
            //$fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[address]" value="Address' . $fitype['id'] . '" placeholder="Address">';
            $fitypesFeild .= '</div>';
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="Pincode' . $fitype['id'] . '">' . $fitype['name'] . ' Pincode</label>';
            $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][pincode]" value="201301' . $fitype['id'] . '" placeholder="Pincode">';
            //$fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[pincode]" value="201301' . $fitype['id'] . '" placeholder="Pincode">';
            $fitypesFeild .= '</div>';
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="phone number' . $fitype['id'] . '">' . $fitype['name'] . ' Phone Number</label>';
            $fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[' . $key . '][phone_number]" value="987654321' . $fitype['id'] . '" placeholder="Phone Number">';
            //$fitypesFeild .= '<input type="number" class="form-control" name="fi_type_id[phone_number]" value="987654321' . $fitype['id'] . '" placeholder="Phone Number">';
            $fitypesFeild .= '</div>';
            $fitypesFeild .= '<div class="form-group col-md-6 col-sm-12 ' . $fitype['name'] . '_section' . ' d-none">';
            $fitypesFeild .= '<label for="landmark' . $fitype['id'] . '">' . $fitype['name'] . ' Land Mark</label>';
            $fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[' . $key . '][landmark]" value="Landmark' . $fitype['id'] . '" placeholder="landmark">';
            //$fitypesFeild .= '<input type="text" class="form-control" name="fi_type_id[landmark]" value="Landmark' . $fitype['id'] . '" placeholder="landmark">';
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
        return redirect()->route('admin.cases.index');
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
        // $request->validate([
        //     'name' => 'required|max:50|unique:fi_types,name,' . $id,

        // ]);


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
        return redirect()->route('admin.cases.index');
    }


    public function unassigned()
    {

        $cases  = DB::table('cases_fi_types as cft')
            ->join('cases as c', 'c.id', '=', 'cft.case_id')
            ->join('fi_types as ft', 'ft.id', '=', 'cft.fi_type_id')
            ->leftJoin('users as u', 'u.id', '=', 'cft.user_id')
            ->where('cft.user_id', '0')
            ->select('cft.id', 'c.refrence_number', 'c.applicant_name',  'c.co_applicant_name', 'cft.mobile', 'cft.address', 'ft.name',  'cft.scheduled_visit_date', 'cft.status', 'u.name as agent_name')
            ->get();

        return view('backend.pages.cases.unassigned', compact('cases'));
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
}
