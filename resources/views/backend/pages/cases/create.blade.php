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

                    <form action="{{ route('admin.cases.store') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Bank</label>
                                <select class="custom-select selectBank" name="bank_id" id="selectBank">
                                    <option value="">--Select Option--</option>
                                    @foreach ($banks as $bank)
                                    <option value="{{ $bank['id'] }}">{{ $bank['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Product</label>
                                <select id="productSelect" name="product_id" class="custom-select">
                                    <option value="">--Select Option--</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">FI Type</label>
                                @foreach ($fitypes as $fitype)
                                <div class="form-check">
                                    <input class="form-check-input fytpe_checkbox" type="checkbox" name="fi_type_id[][id]" value="{{ $fitype['id'] }}" rel-name="{{ $fitype['name'] }}">
                                    <label class="form-check-label" for="fitype{{ $fitype['id'] }}">
                                        {{ $fitype['name'] }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            {!! $fitypesFeild !!}
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="application_type">Application Type</label>
                                <select class="custom-select application_type" name="application_type" id="application_type">
                                    <option value="">--Select Option--</option>
                                    @foreach ($ApplicationTypes as $ApplicationType)
                                    <option value="{{ $ApplicationType['id'] }}">{{ $ApplicationType['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Reference Number</label>
                                <input type="text" class="form-control" id="refrence_number" value="EP01010" name="refrence_number" placeholder="Enter Reference Number">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Applicant Name</label>
                                <input type="text" class="form-control" id="applicant_name" value="Susheel Sahoo" name="applicant_name" placeholder="Enter Applicant Name">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Amount</label>
                                <input type="number" class="form-control" id="amount" value="100000" name="amount" placeholder="Enter Amount">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Vehicle</label>
                                <input type="text" class="form-control" id="vehicle" value="Honda" name="vehicle" placeholder="Enter Vehicle">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Co-Applicant Name</label>
                                <input type="text" class="form-control" id="co_applicant_name" value="Joyti Sahu" name="co_applicant_name" placeholder="Enter Co-Applicant Name">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Guarantee Name</label>
                                <input type="text" class="form-control" id="guarantee_name" value="Ankit Sahu" name="guarantee_name" placeholder="Enter Guarantee Name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <div class="form-check">
                                    <input class="form-check-input singleAgentCheckBox" type="checkbox" name="singleAgentCheckBox" value="1">
                                    <label class="form-check-label" for="singleAgentCheckBox"> Single Agent</label>
                                </div>
                            </div>

                            {!! $singleAgent !!}
                        </div>
                        <div class="form-row">
                            {!! $AgentsFeild !!}
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="geo_limit">Geo Limit *</label>
                                <select id="geo_limit" name="geo_limit" class="custom-select">
                                    <option value="">--Select Option--</option>
                                    <option value="Local">Local</option>
                                    <option value="Outstation">Outstation</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6 col-sm-12">
                                <label for="tat_time">TAT Time</label>
                                <select id="tat_time" name="tat_time" class="custom-select">
                                    <option value="">--Select Option--</option>
                                    <?php
                                    $start = new DateTime('00:00');
                                    $end = new DateTime('24:00');

                                    $interval = new DateInterval('PT05M'); // 10 minutes interval
                                    $period = new DatePeriod($start, $interval, $end);
                                    ?>
                                    @foreach ($period as $time)
                                    <option value="{{ $time->format('H:i') }}">{{ $time->format('H:i') }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Remarks</label>
                                <textarea name="remarks" rows="2" cols="20" id="remarks" class="form-control" placeholder="Remarks">Test Remark</textarea>
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
        var baseUrl = "{{ url('/') }}";
        $('#selectBank').on('change', function(e) {
            var bankId = $(this).val();
            var customGetPath = "{{ route('admin.case.item','ID')}}";
            customGetPath = customGetPath.replace('ID', bankId);
            $.ajax({
                url: customGetPath,
                type: 'GET',
                success: function(response) {
                    var select = $('#productSelect');
                    select.empty(); // Clear any existing options
                    select.append('<option value="">--Select Option--</option>'); // Add default option

                    $.each(response, function(key, products) {
                        $.each(products, function(index, product) {
                            console.log(product);
                            var option = $('<option></option>')
<<<<<<< HEAD
                                .attr('value', product.product_id)
=======
                                .attr('value', product.bank_id)
>>>>>>> 6645489 (server)
                                .text(product.name + ' (' + product.product_code + ')');
                            select.append(option);
                        });
                    });
                },
                error: function() {
                    alert('Request failed');
                }
            });
        });


        $(document).on('click', '.fytpe_checkbox', function() {
            var isChecked = $(this).prop('checked');
            var relName = $(this).attr('rel-name');
            if (isChecked) {
                console.log();
                $('.' + relName + "_section").removeClass('d-none');
            } else {
                $('.' + relName + "_section").addClass('d-none');
            }
        });
        singleAgentCheckBox();

        $(document).on('click', '.singleAgentCheckBox', function() {
            singleAgentCheckBox();
        });


        function singleAgentCheckBox() {
            $(".singleAgentSection").addClass('d-none');
            var isChecked = $(".singleAgentCheckBox").prop('checked');
            var relName = $(".fytpe_checkbox").attr('rel-name');
            // debugger
            if (isChecked) {
                $(".singleAgentSection").removeClass('d-none');
                $(".multiAgentSection").addClass('d-none');
            } else {
                $(".singleAgentSection").addClass('d-none');
                // $(".multiAgentSection").removeClass('d-none');
            }
        }
    });
</script>
@endsection