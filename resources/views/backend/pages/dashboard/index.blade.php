@extends('backend.layouts.master')

@section('title')
Dashboard Page - Admin Panel
@endsection


@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Dashboard</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="index.html">Home</a></li>
                    <li><span>Dashboard</span></li>
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
    {{-- <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-md-6 mt-5 mb-3">
                    <div class="card">
                        <div class="seo-fact sbg1">
                            <a href="{{ route('admin.cases.caseStatus', ['id' => '1']) }}">
    <div class="p-4 d-flex justify-content-between align-items-center">
        <div class="seofct-icon"><i class="fa fa-users"></i> Total Unassigned</div>
        <h2>{{ $total_Unassigned }}</h2>
    </div>
    </a>
</div>
</div>
</div>
<div class="col-md-6 mt-md-5 mb-3">
    <div class="card">
        <div class="seo-fact sbg2">
            <a href="{{ route('admin.admins.index') }}">
                <div class="p-4 d-flex justify-content-between align-items-center">
                    <div class="seofct-icon"><i class="fa fa-user"></i> Admins</div>
                    <h2>{{ $total_admins }}</h2>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="col-md-6 mb-3 mb-lg-0">
    <div class="card">
        <div class="seo-fact sbg3">
            <div class="p-4 d-flex justify-content-between align-items-center">
                <div class="seofct-icon">Permissions</div>
                <h2>{{ $total_permissions }}</h2>
            </div>
        </div>
    </div> --}}

    {{-- <div class="row mt-4">
        <div class="col-lg-10 col-md-10">
            <form method="" action="" id="filterForm">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="Organisation">Organisation</label>
                        <select name="Organisation" id="Organisation" class="form-control">
                            <option selected="selected" value="">--Select--</option>
                            <option value="3021006">D2I-ISB-Maha</option>
                            <option value="3021007">D2I-ISB-PUNE</option>
                            <option value="3021010">D2I-ISB-PUNENEW</option>
                            <option value="3021011">D2I-ISB-PUNEN2</option>
                            <option value="3021008">D2I-ISB-NASIK</option>
                            <option value="3021009">D2I-ISB-Nagpur</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="casetype">Case Type</label>
                        <select name="casetype" id="casetype" class="form-control">
                            <option selected="selected" value="">--Select--</option>
                            <option value="300701">SBI AUTOLOAN RV</option>
                            <option value="300702">SBI AUTOLOAN BV</option>
                            <option value="300703">SBI EDUCATION LOAN RV</option>
                            <option value="300704">SBI EDUCATION LOAN BV</option>
                            <option value="300705">SBI HOUSING LOAN RV</option>
                            <option value="300706">SBI HOUSING LOAN BV</option>
                            <option value="300707">SBI Personal Loan RV</option>
                            <option value="300708">SBI Personal Loan BV</option>
                            <option value="300709">SBI Seller-FI RV</option>
                            <option value="300710">SBI Seller-FI BV</option>
                            <option value="300711">SBI BSV RV</option>
                            <option value="300712">SBI BSV BV</option>
                            <option value="300713">SBI ITR RV</option>
                            <option value="300714">SBI ITR BV</option>
                            <option value="300715">SBI Post-Verification BV</option>
                            <option value="300716">SBI Post-Verification RV</option>
                            <option value="20010104">SBI ITR</option>
                            <option value="20010105">SBI ITR</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="agent">Agent</label>
                        <select name="agent" id="agent" class="form-control">
                            <option selected="selected" value="">--Select--</option>
                            @if($agentLists)
                                @foreach ($agentLists as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
    @endforeach
    @endif
    </select>
</div>
<div class="form-group col-md-2">
    <label for="FromDate">From Date</label>
    <input type="date" class="form-control" id="FromDate" name="FromDate">
</div>
<div class="form-group col-md-2">
    <label for="ToDate">To Date</label>
    <input type="date" class="form-control" id="ToDate" name="ToDate">
</div>
<div class="form-group col-md-2">
    <input type="submit" class="form-control btn btn-sm btn-primary mt-4" id="submit" name="submit" value="Filter">
</div>
</div>
</form>
</div>
<div class="col-lg-2 col-md-2">
    <p class="mt-3"><strong>Unassigned Cases</strong>: <a href="{{ route('admin.case.unassigned', ['id' => $total_Unassigned]) }}">{{ $total_Unassigned }} </a> </p>
    <p><strong>Dedup Cases</strong>: {{ $total_Unassigned }} </p>
</div>
</div>
<div class="row mt-4">
    <div class="col-md-12 col-lg-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th valign="middle">Agent</th>
                    <th valign="middle">Total</th>
                    <th valign="middle">Inprogress</th>
                    <th valign="middle">Positive Resolved</th>
                    <th valign="middle">Negative Resolved</th>
                    <th valign="middle">Positive Verified</th>
                    <th valign="middle">Negetive Verified</th>
                    <th valign="middle">Hold</th>
                    <th valign="middle">First Time</th>
                    <th valign="middle">Last Time</th>
                    <th valign="middle">#Visit Count</th>
                    <th valign="middle">Location</th>
                </tr>
            </thead>
            <tbody>
                <tr style="color: #0000FF ! Important;background-color: #00F000;">
                    <td>Total</td>
                    <td>0</td>
                    <td>{{ $totalSum['inprogressTotal'] ?? 0 }}</td>
                    <td>{{ $totalSum['resolveTotal'] ?? 0 }}</td>
                    <td>0</td>
                    <td>{{ $totalSum['verifiedTotal'] ?? 0 }}</td>
                    <td>0</td>
                    <td>{{ $totalSum['rejectedTotal'] ?? 0 }}</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td><i class='fa fa-map-marker fa-2x' style='color:#9b479f;'></i></td>
                </tr>

                @if($userCount)
                @foreach ($userCount as $value)
                <tr>
                    <td>{{ $value->getCreatedBy->name ?? '' }}</td>
                    <td>0</td>
                    <td>{{ $value['inprogress'] ?? 0 }}</td>
                    <td>{{ $value['resolve'] ?? 0 }}</td>
                    <td>0</td>
                    <td>{{ $value['verified'] ?? 0 }}</td>
                    <td>0</td>
                    <td>{{ $value['rejected'] ?? 0 }}</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td><i class='fa fa-map-marker fa-2x' style='color:#9b479f;'></i></td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
</div>
</div> --}}

<div class="row mt-4">
    <div class="col-lg-10 col-md-10">
        <form method="" action="" id="filterForm">
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="Organisation">Organisation</label>
                    <select name="Organisation" id="Organisation" class="form-control">
                        <option selected="selected" value="">--Select--</option>
                        <option value="3021006">D2I-ISB-Maha</option>
                        <option value="3021007">D2I-ISB-PUNE</option>
                        <option value="3021010">D2I-ISB-PUNENEW</option>
                        <option value="3021011">D2I-ISB-PUNEN2</option>
                        <option value="3021008">D2I-ISB-NASIK</option>
                        <option value="3021009">D2I-ISB-Nagpur</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="casetype">Case Type</label>
                    <select name="casetype" id="casetype" class="form-control">
                        <option selected="selected" value="">--Select--</option>
                        <option value="300701">SBI AUTOLOAN RV</option>
                        <option value="300702">SBI AUTOLOAN BV</option>
                        <option value="300703">SBI EDUCATION LOAN RV</option>
                        <option value="300704">SBI EDUCATION LOAN BV</option>
                        <option value="300705">SBI HOUSING LOAN RV</option>
                        <option value="300706">SBI HOUSING LOAN BV</option>
                        <option value="300707">SBI Personal Loan RV</option>
                        <option value="300708">SBI Personal Loan BV</option>
                        <option value="300709">SBI Seller-FI RV</option>
                        <option value="300710">SBI Seller-FI BV</option>
                        <option value="300711">SBI BSV RV</option>
                        <option value="300712">SBI BSV BV</option>
                        <option value="300713">SBI ITR RV</option>
                        <option value="300714">SBI ITR BV</option>
                        <option value="300715">SBI Post-Verification BV</option>
                        <option value="300716">SBI Post-Verification RV</option>
                        <option value="20010104">SBI ITR</option>
                        <option value="20010105">SBI ITR</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="agent">Agent</label>
                    <select name="agent" id="agent" class="form-control">
                        <option selected="selected" value="">--Select--</option>
                        @if($agentLists)
                        @foreach ($agentLists as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="FromDate">From Date</label>
                    <input type="date" class="form-control" id="FromDate" name="FromDate">
                </div>
                <div class="form-group col-md-2">
                    <label for="ToDate">To Date</label>
                    <input type="date" class="form-control" id="ToDate" name="ToDate">
                </div>
                <div class="form-group col-md-2">
                    <input type="submit" class="form-control btn btn-sm btn-primary mt-4" id="submit" name="submit" value="Filter">
                </div>
            </div>
        </form>
    </div>
    <div class="col-lg-2 col-md-2">
        <p class="mt-3"><strong>Unassigned Cases</strong>: <a href="{{ route('admin.cases.caseStatus', ['status' => '0']) }}">{{ $total_Unassigned }} </a> </p>
        <p><strong>Dedup Cases</strong>: {{ $total_Unassigned }} </p>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12 col-lg-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th valign="middle">Agent</th>
                    <th valign="middle">Total</th>
                    <th valign="middle">Inprogress</th>
                    <th valign="middle">Positive Resolved</th>
                    <th valign="middle">Negative Resolved</th>
                    <th valign="middle">Positive Verified</th>
                    <th valign="middle">Negetive Verified</th>
                    <th valign="middle">Hold</th>
                    <th valign="middle">First Time</th>
                    <th valign="middle">Last Time</th>
                    <th valign="middle">#Visit Count</th>
                    <th valign="middle">Location</th>
                </tr>
            </thead>
            <tbody>
                <tr style="color: #0000FF ! Important;background-color: #00F000;">
                    <td>Total</td>

                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 'aaa']) }}">{{ $totalSum['total'] ?? 0 }}</a></td>
                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 1]) }}">{{ $totalSum['inprogressTotal'] ?? 0 }}</a></td>
                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 2]) }}">{{ $totalSum['positive_resolvedTotal'] ?? 0 }} </a></td>
                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 3]) }}">{{ $totalSum['negative_resolvedTotal'] ?? 0 }} </a></td>
                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 4]) }}">{{ $totalSum['positive_verifiedTotal'] ?? 0 }} </a></td>
                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 5]) }}">{{ $totalSum['negative_verifiedTotal'] ?? 0 }} </a></td>
                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 6]) }}">{{ $totalSum['holdTotal'] ?? 0 }} </a></td>
                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 1]) }}">{{ 0 }} </a></td>
                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 1]) }}">{{ 0 }} </a></td>
                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 1]) }}">{{ 0 }} </a></td>
                    <td><i class='fa fa-map-marker fa-2x' style='color:#9b479f;'></i></td>
                </tr>

                @if($userCount)
                @foreach ($userCount as $userWise)
                <tr>
                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 'aaa', 'user_id' => $userWise['agentid']])  }}">{{ $userWise['agentName'] ?? '' }}</a></td>
                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 'aaa', 'user_id' => $userWise['agentid']])  }}">{{ $userWise['total'] ?? 0 }}</a></td>
                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 1, 'user_id' => $userWise['agentid']]) }}">{{ $userWise['inprogress'] ?? 0 }}</a></td>
                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 2, 'user_id' => $userWise['agentid']]) }}">{{ $userWise['positive_resolved'] ?? 0 }} </a></td>
                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 3, 'user_id' => $userWise['agentid']]) }}">{{ $userWise['negative_resolved'] ?? 0 }}</a></td>
                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 4, 'user_id' => $userWise['agentid']]) }}">{{ $userWise['positive_verified'] ?? 0 }}</a></td>
                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 5, 'user_id' => $userWise['agentid']]) }}">{{ $userWise['negative_verified'] ?? 0 }} </a></td>
                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 6, 'user_id' => $userWise['agentid']]) }}">{{ $userWise['hold'] ?? 0 }} </a></td>
                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 1, 'user_id' => $userWise['agentid']]) }}">{{ 0 }}</a></td>
                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 1]) }}">{{ 0 }} </a></td>
                    <td><a href="{{ route('admin.cases.caseStatus', ['status' => 1]) }}">{{ 0 }} </a></td>
                    <td><i class='fa fa-map-marker fa-2x' style='color:#9b479f;'></i></td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection