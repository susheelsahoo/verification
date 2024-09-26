@extends('backend.layouts.master')

@section('title')
Cases - Admin Panel
@endsection

@section('styles')
<!-- Start datatable css -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
@endsection

@section('admin-content')
<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Cases</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>All Cases</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner">

    <div class="row">
        <form action="{{ route('admin.case.modifyCase',$case->id)}}" method="POST" name="caseEdit" id="editCase">
            @csrf
            <input type="hidden" name="case_fi_id" value="{{  $case->id ?? ''  }}" />
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table cellspacing="0" class="table table-bordered" width="100%">
                            <tbody>
                                <tr>
                                    <td align="left" valign="middle"><strong> Application Number : </strong></td>
                                    <td align="left" valign="middle">{{ $case->getCase->refrence_number ?? '' }}</td>
                                    <td align="left" valign="middle"><strong> Organization : </strong></td>
                                    <td align="left" valign="middle"></td>
                                </tr>

                                <tr>

                                    <td align="left" valign="middle"><strong> Assign To : </strong></td>
                                    <td align="left" valign="middle">{{ $case->getCase->getCreatedBy->name ?? '' }}</td>
                                    <td align="left" valign="middle"><strong>Type of FI :</strong></td>
                                    <td align="left" valign="middle"> {{ $case->getFiType->name }} </td>
                                </tr>

                                <tr>
                                    <td align="left" valign="middle"><strong> Address : </strong></td>
                                    <td align="left" valign="middle"><textarea class="form-control" name="address">{{ $case->address ?? '' }}</textarea></td>
                                    <td align="left" valign="middle"><strong> Pincode : </strong></td>
                                    <td align="left" valign="middle"><input type="text" class="form-control" name="pincode" value="{{ $case->pincode ??  '' }}" /> </td>


                                </tr>

                                <tr>
                                    <td align="left" valign="middle"><strong> Company Name : </strong></td>
                                    <td align="left" valign="middle"><input type="text" class="form-control" name="company_name" value="" /> </td>
                                    <td align="left" valign="middle"><strong>Created Date :</strong></td>
                                    <td align="left" valign="middle">{{ $case->created_at ? date('d-m-Y', strtotime($case->created_at)) : '' }} </td>


                                </tr>

                                <tr>
                                    <td align="left" valign="middle"><strong>Status :</strong></td>
                                    <td align="left" valign="middle">{{ get_status($case->status) }}</td>

                                    <td align="left" valign="middle"><strong>Sub Status :</strong></td>
                                    <td align="left" valign="middle">{{ $case->sub_status }} </td>

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
                                    <th valign="middle" colspan="2"></th>
                                </tr>
                                <tr>
                                    <td align="left" valign="middle"><strong> Applicant Name : </strong></td>
                                    <td align="left" valign="middle">
                                        <input type="text" class="form-control" name="name" value="{{ $case->getCase->applicant_name ?? '' }}" />

                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="50%" valign="middle"><strong>Reference_Number</strong></td>
                                    <td align="left" width="50%" valign="middle"><input type="text" class="form-control" name="reference_number" value="{{ $case->getCase->refrence_number ?? '' }}" /></td>
                                </tr>
                                <!--  <tr>
                                    <td align="left" valign="middle"><strong>Internal_Code</strong></td>
                                    <td align="left" valign="middle"><input type="text" class="form-control" name="internal_code" value="{{ $case->getCase->refrence_number ?? '' }}" /></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="middle"><strong>Applicant_Type</strong></td>
                                    <td align="left" valign="middle">
                                        <select class="custom-select application_type" name="application_type" id="application_type">
                                            <option value="">--Select Option--</option>
                                            @foreach ($ApplicationTypes as $ApplicationType)
                                            <option value="{{ $ApplicationType['id'] }}" @if($case->getCase->getApplicationType->id == $ApplicationType['id']) selected @endif>{{ $ApplicationType['name'] }}</option>
                                            @endforeach
                                        </select>

                                    </td>
                                </tr> -->
                                <tr>

                                    @if(isset($assign) && !$assign)
                                    <td align="left" valign="middle"><strong>Res_Address</strong> </td>
                                    <td align="left" valign="middle"><input type="text" class="form-control" name="address" value="{{ $case->address ?? '' }}" /> </td>
                                    @endif

                                    @if(isset($assign) && $assign)
                                    <td align="left" valign="middle"><strong>Off_Address</strong> </td>
                                    <td align="left" valign="middle"><input type="text" class="form-control" name="address" value="{{ $case->address ?? '' }}" /> </td>
                                    @endif

                                </tr>
                                <tr>
                                    @if(isset($assign) && !$assign)
                                    <td align="left" valign="middle"><strong>Phone_Number</strong></td>
                                    <td align="left" valign="middle"><input type="text" class="form-control" name="mobile" value="{{ $case->mobile ?? '' }}" /></td>
                                    @endif


                                    @if(isset($assign) && $assign)
                                    <td align="left" valign="middle"><strong>Off_Number</strong> </td>
                                    <td align="left" valign="middle"><input type="text" class="form-control" name="mobile" value="" /></td>
                                    @endif

                                </tr>

                                <tr>
                                    <td align="left" valign="middle"><strong>Alternate_Number</strong></td>
                                    <td align="left" valign="middle"><input type="text" class="form-control" name="alternate_number" value="" /> </td>
                                </tr>


                                <tr>
                                    <td align="left" valign="middle"><strong>LoanAmount</strong></td>
                                    <td align="left" valign="middle"><input type="text" class="form-control" name="loan_amont" value="{{ $case->getCase->amount ?? 0 }}" /> </td>
                                </tr>

                                <tr>
                                    <td align="left" valign="middle"><strong>Status_Remark</strong></td>
                                    <td align="left" valign="middle"><input type="text" class="form-control" name="status_remark" value="" /></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="middle"><strong>Assigned </strong></td>
                                    <td align="left" valign="middle">

                                        <select class="custom-select created_by" name="created_by" id="created_by">
                                            <option value="">--Select Option--</option>
                                            @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @if($case->getUser->id == $user->id) selected @endif>{{ $user->name }}</option>
                                            @endforeach
                                        </select>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12 d-flex justify-content-center mt-2 gap-5">
                <a href="javascript:history.back()" class="btn btn-sm btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>

                <button class="btn btn-sm btn-success ml-2 updateCase" type="submit" name="submit"> Update </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        $('.updateCase').click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            var formData = form.serializeArray();
            let rowId = form.find('input[name="case_fi_id"]').val();
            let actionPath = "{{ route('admin.case.modifyCase','ID')}}";
            actionPath = actionPath.replace('ID', rowId);
            $.ajax({
                url: actionPath,
                type: 'POST',
                data: formData,
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Request failed');
                }
            });
        });
    });
</script>

@endsection