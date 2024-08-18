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
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left">Cases List</h4>
                    <p class="float-right mb-2">

                        <button type="button" class="btn btn-primary text-white btn-sm" id="getSelectedIds" data-toggle="modal" data-target="#exampleModal">
                            Assign
                        </button>

                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')


                        <table class="text-center" id="exampleTable">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="8%"><input type="checkbox" id="selectAll"></th>
                                    <th width="8%">App Id</th>
                                    <th width="8%">Internal Code</th>
                                    <th width="8%">Name</th>
                                    <th width="8%">Mobile Number</th>
                                    <th width="10%">Address</th>
                                    <th width="8%">FIType</th>
                                    <th width="8%">Scheduled Date</th>
                                    <th width="8%">Agent</th>
                                    <th width="8%">Status</th>
                                    <th width="8%">SubStatus</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cases as $case)
                                <tr>
                                    <td class="text-center"><input type="checkbox" class="selectRow" value="{{ $case->id }}"></td>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $case->refrence_number }}</td>
                                    <td>{{ $case->applicant_name }}</td>
                                    <td>{{ $case->mobile }}</td>
                                    <td>{{ $case->address }}</td>
                                    <td>{{ $case->name }}</td>
                                    <td>{{ $case->scheduled_visit_date }}</td>
                                    <td>{{ $case->agent_name }}</td>
                                    <td>{{ $case->status }}</td>
                                    <td>{{ $case->agent_name }}</td>
                                    <td>
                                        <!-- <a class="btn btn-success text-white" href="{{ route('admin.cases.edit', $case->id) }}">Edit</a>

                                        <a class="btn btn-danger text-white" href="{{ route('admin.cases.edit', $case->id) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $case->id }}').submit();">
                                            Delete
                                        </a>

                                        <form id="delete-form-{{ $case->id }}" action="{{ route('admin.cases.destroy', $case->id) }}" method="POST" style="display: none;">
                                            @method('DELETE')
                                            @csrf
                                        </form> -->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->

    </div>
</div>
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.cases.assignAgent') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assign Case</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-md-12 col-sm-12">
                        <input name="case_fi_type_id" id="case_fi_type_id" type="hidden">
                        <label for="name">Assign To</label>
                        <select id="userSelect" name="user_id" class="custom-select" required>
                            <option value="">--Select Option--</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12 col-sm-12">
                        <label for="name">Assignment Time :</label>
                        <input name="ScheduledVisitDate" class="custom-select" value="{{ date('Y-m-d H:i:s') }}" id="ScheduledVisitDate" type="datetime-local">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Assign case</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<!-- Start datatable js -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<script>
    // Wait for the DOM to be ready
    $(document).ready(function() {
        // Handle the "Select All" checkbox click event
        $('#selectAll').click(function() {
            // Set the checked property for all row checkboxes based on "Select All" checkbox
            $('.selectRow').prop('checked', this.checked);
        });

        // Handle individual row checkbox click event
        $('.selectRow').click(function() {
            // If not all checkboxes are checked, uncheck "Select All"
            if ($('.selectRow:checked').length !== $('.selectRow').length) {
                $('#selectAll').prop('checked', false);
            }
            // If all checkboxes are checked, check "Select All"
            if ($('.selectRow:checked').length === $('.selectRow').length) {
                $('#selectAll').prop('checked', true);
            }
        });

        // Handle the "Get Selected IDs" button click event
        $('#getSelectedIds').click(function() {
            // Create an array to store selected IDs
            var selectedIds = [];
            // Loop through checked checkboxes and get their values (IDs)
            $('.selectRow:checked').each(function() {
                selectedIds.push($(this).val());
            });

            // Convert the array of selected IDs to JSON format
            var selectedIdsJson = JSON.stringify(selectedIds);
            if (selectedIds.length > 0) {
                $("#case_fi_type_id").val(selectedIdsJson);
                var customGetPath = "{{ route('admin.users.agent','1')}}";
                $.ajax({
                    url: customGetPath,
                    type: 'GET',
                    success: function(response) {
                        var select = $('#userSelect');
                        select.empty(); // Clear any existing options
                        select.append('<option value="">--Select Option--</option>'); // Add default option
                        $.each(response, function(key, users) {
                            $.each(users, function(index, user) {
                                console.log(user);
                                var option = $('<option></option>')
                                    .attr('value', user.id)
                                    .text(user.name);
                                select.append(option);
                            });
                        });
                    },
                    error: function() {
                        alert('Request failed');
                    }
                });

            } else {
                alert('No case selected.');
            }

        });

    });
</script>
@endsection