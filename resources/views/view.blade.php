@extends('layouts.app')

@section('styles')
<!-- Start datatable css -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table cellspacing="0" class="table table-bordered" width="100%">
                        <tbody>
                            <tr>
                                <td align="left" valign="middle"><strong> Organization : </strong></td>
                                <td colspan="3"></td>
                            </tr>
                            <tr>
                                <td align="left" valign="middle"><strong>Status :</strong></td>
                                <td align="left" valign="middle">
                                    {{ get_status($case->status) }}
                                </td>

                                <td align="left" valign="middle"><strong>Sub Status :</strong></td>
                                <td align="left" valign="middle">{{ $case->sub_status ?? '' }} </td>

                            </tr>
                            <tr>
                                <td align="left" valign="middle"><strong>Field Survey Status :</strong></td>
                                <td align="left" valign="middle">{{ get_status($case->status) }}</td>

                                <td align="left" valign="middle"><strong>Assign To :</strong></td>
                                <td align="left" valign="middle">{{ $case->getCase->getCreatedBy->name ?? '' }} </td>
                            </tr>
                            <tr>
                                <td align="left" valign="middle"><strong>Task Type :</strong></td>
                                <td align="left" valign="middle"> </td>

                                <td align="left" valign="middle"><strong>Created Date :</strong></td>
                                <td align="left" valign="middle">{{ $case->created_at ? date('d-m-Y h:i:s A', strtotime($case->created_at)) : '' }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table cellspacing="0" class="table table-bordered" width="100%">
                        <tbody>
                            <tr>
                                <th valign="middle" colspan="2">Case Specific Details:</th>
                            </tr>
                            <tr>
                                <td align="left" width="50%" valign="middle"><strong>Reference_Number</strong></td>
                                <td align="left" width="50%" valign="middle">{{ $case->getCase->id ?? '' }}</td>
                            </tr>
                            <tr>
                                <td align="left" valign="middle"><strong>Internal_Code</strong></td>
                                <td align="left" valign="middle">{{ $case->getCase->refrence_number ?? '' }}</td>
                            </tr>
                            <tr>
                                <td align="left" valign="middle"><strong>Applicant_Type</strong></td>
                                <td align="left" valign="middle">{{ $case->getCase->getApplicationType->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td align="left" valign="middle"><strong>Name</strong></td>
                                <td align="left" valign="middle">{{ $case->getCase->applicant_name ?? '' }}</td>
                            </tr>
                            <tr>

                                @if(isset($assign) && !$assign)
                                <td align="left" valign="middle"><strong>Res_Address</strong> </td>
                                <td align="left" valign="middle">{{ $case->address ?? '' }}</td>
                                @endif

                                @if(isset($assign) && $assign)
                                <td align="left" valign="middle"><strong>OFF_Address</strong> </td>
                                <td align="left" valign="middle"></td>
                                @endif

                            </tr>
                            <tr>
                                @if(isset($assign) && !$assign)
                                <td align="left" valign="middle"><strong>Phone_Number</strong></td>
                                <td align="left" valign="middle">{{ $case->mobile ?? '' }}</td>
                                @endif


                                @if(isset($assign) && $assign)
                                <td align="left" valign="middle"><strong>OFF_Number</strong> </td>
                                <td align="left" valign="middle"></td>
                                @endif

                            </tr>
                            <tr>
                                <td align="left" valign="middle"><strong>LoanAmount</strong></td>
                                <td align="left" valign="middle">{{ $case->getCase->amount ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td align="left" valign="middle"><strong>Status_Remark</strong></td>
                                <td align="left" valign="middle"></td>
                            </tr>
                            <tr>
                                <td align="left" valign="middle"><strong>CreatedBy </strong></td>
                                <td align="left" valign="middle"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
