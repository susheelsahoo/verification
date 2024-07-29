@extends('backend.layouts.master')

@section('title')
Create Case Create - Admin Panel
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .form-check-label {
        text-transform: capitalize;
    }
</style>
@endsection


@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Create Case Create</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.fitypes.index') }}">All Create Case</a></li>
                    <li><span>Create Create Case</span></li>
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
        <!-- data table start -->

        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Create Case</h4>
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.fitypes.store') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Bank</label>
                                <select class="custom-select selectBank" name="bankname" id="selectBank">
                                    <option value="">--Select Option--</option>
                                    @foreach ($banks as $bank)
                                    <option value="{{ $bank['id'] }}">{{ $bank['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">

                                <label for="name">Product</label>
                                <input type="text" class="form-control" id="applicant_name" name="applicant_name" placeholder="Enter FI Name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Application Type</label>
                                <input type="text" class="form-control" id="applicant_name" name="applicant_name" placeholder="Enter FI Name">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Source Channel</label>
                                <input type="text" class="form-control" id="applicant_name" name="applicant_name" placeholder="Enter FI Name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">FI Type</label>
                                <input type="text" class="form-control" id="applicant_name" name="applicant_name" placeholder="Enter FI Name">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Applicant Name</label>
                                <input type="text" class="form-control" id="applicant_name" name="applicant_name" placeholder="Enter FI Name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Amount</label>
                                <input type="text" class="form-control" id="applicant_name" name="applicant_name" placeholder="Enter FI Name">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Vehicle</label>
                                <input type="text" class="form-control" id="applicant_name" name="applicant_name" placeholder="Enter FI Name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Co-Applicant Name</label>
                                <input type="text" class="form-control" id="applicant_name" name="applicant_name" placeholder="Enter FI Name">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Guarantee Name</label>
                                <input type="text" class="form-control" id="applicant_name" name="applicant_name" placeholder="Enter FI Name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Single Agent</label>
                                <input type="text" class="form-control" id="applicant_name" name="applicant_name" placeholder="Enter FI Name">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Agent</label>
                                <input type="text" class="form-control" id="applicant_name" name="applicant_name" placeholder="Enter FI Name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Geo Limit *</label>
                                <input type="text" class="form-control" id="applicant_name" name="applicant_name" placeholder="Enter FI Name">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">TAT Time</label>
                                <input type="text" class="form-control" id="applicant_name" name="applicant_name" placeholder="Enter FI Name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Remarks</label>
                                <textarea name="case_remarks" rows="2" cols="20" id="case_remarks" class="form-control" placeholder="Remarks"></textarea>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save Case</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- data table end -->

    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // var baseUrl = "{{ url('/') }}";

        $('#selectBank').on('change', function(e) {
            var bankId = $(this).val();
            $.ajax({
                url: "{{ route('admin.cases.getProducts')}}",
                type: 'GET',
                data: {
                    bankId: bankId,
                    _token: '{{ csrf_token() }}' // Add CSRF token fsor security
                },
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        alert('Request successful: ' + JSON.stringify(response));
                    }
                },
                error: function() {
                    alert('Request failed');
                }
            });
        });
    });
</script>
<!-- <script>
    $(document).ready(function() {
        var baseUrl = "{{ url('/') }}";
        $('#selectBank').on('change', function(e) {
            var bankId = $(this).val(); // Get the selected bank ID
            // alert(bankId);
            $.ajax({
                url: baseUrl + "/admin/cases/getProducts",
                type: 'GET',
                data: {
                    bankId: bankId, // Use the selected bank ID
                    // _token: $('meta[name="csrf-token"]').attr('content') // Add CSRF token for security
                },
                success: function(response) {
                    if (response.success) {
                        alert('Request successful');
                    }
                },
                error: function() {
                    alert('Request failed');
                }
            });
        });
    }); 
</script>-->
@endsection