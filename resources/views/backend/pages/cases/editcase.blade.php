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
<div class="main-content-inner" bis_skin_checked="1">
    <div class="row" bis_skin_checked="1">
        <!-- data table start -->
        <div class="col-12 mt-5" bis_skin_checked="1">
            <div class="card" bis_skin_checked="1">
                <div class="card-body" bis_skin_checked="1">
                    @if($is_edit_case)
                    <h4 class="header-title">Edit Case</h4>
                    @else
                    <h4 class="header-title">View Case</h4>
                    @endif



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
                                                <td align="left" valign="middle"><strong>Type of FI :</strong></td>
                                                <td align="left" valign="middle"> {{ $case->getFiType->name }} </td>
                                            </tr>
                                            <tr>
                                                <td align="left" valign="middle"><strong>Status :</strong></td>
                                                <td align="left" valign="middle">{{ get_status($case->status) }}</td>

                                                <td align="left" valign="middle"><strong>Sub Status :</strong></td>
                                                <td align="left" valign="middle">{{ $case->sub_status }} </td>
                                            </tr>

                                            <tr>

                                                <td align="left" valign="middle"><strong> Assign To : </strong></td>
                                                <td align="left" valign="middle">{{ $case->getCreatedBy->name ?? '' }}</td>

                                                <td align="left" valign="middle"><strong> Organization : </strong></td>
                                                <td align="left" valign="middle"></td>
                                            </tr>
                                            <tr>
                                                <td align="left" valign="middle"><strong>Created Date :</strong></td>
                                                <td align="left" valign="middle">{{ $case->created_at ? date('d-m-Y', strtotime($case->created_at)) : '' }} </td>


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
                                                <td align="left" valign="middle"><strong>Address</strong> </td>
                                                <td align="left" valign="middle"><input type="text" class="form-control" name="address" value="{{ $case->address ?? '' }}" /> </td>

                                            </tr>
                                            <tr>
                                                <td align="left" width="50%" valign="middle"><strong>Landmark</strong></td>
                                                <td align="left" width="50%" valign="middle"><input type="text" class="form-control" name="land_mark" value="{{ $case->land_mark ?? '' }}" /></td>
                                            </tr>
                                            <tr>
                                                <td align="left" width="50%" valign="middle"><strong>Pincode</strong></td>
                                                <td align="left" width="50%" valign="middle"><input type="text" class="form-control" name="pincode" value="{{ $case->pincode ?? '' }}" /></td>
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
                                                <td align="left" valign="middle"><strong>LoanAmount</strong></td>
                                                <td align="left" valign="middle"><input type="text" class="form-control" name="loan_amont" value="{{ $case->getCase->amount ?? 0 }}" /> </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 d-flex justify-content-center mt-2 gap-5">
                            <a href="javascript:history.back()" class="btn btn-sm btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                            @if($is_edit_case)
                            <button class="btn btn-sm btn-success ml-2 updateCase" type="submit" name="submit"> Update </button>
                            @endif

                        </div>
                    </form>


                </div>
            </div>
        </div>
        <!-- data table end -->

    </div>
</div>

<div class="main-content-inner">

    <div class="row">

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
                    alert('case update successfully');
                    //location.reload();
                },
                error: function() {
                    alert('Request failed');
                }
            });
        });
    });
</script>

@endsection