<style>
    .error {
        color: red;
    }
</style>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <form action="{{ route('admin.case.modifyBVCase', $case->id) }}" method="POST">
        @csrf
        <input type="hidden" name="case_fi_id" value="{{ $case->id }}" />
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td style="border:none;font-size:22px;color:#0094ff" align="center" colspan="1">
                        <img alt="State Bank of India" src="{{ asset('images/sbi.jpg') }}">
                    </td>
                    <td class="address_text" align="center" colspan="3">CORE DOC2INFO SERVICES</td>
                </tr>
                <tr>
                    <td>Reference No.</td>
                    <td class="BVstyle">
                        <input type="text" name="refrence_number" class="form-control" value="{{ $case->getCase->refrence_number ?? '' }}" readonly>
                    </td>
                    <td>Customer Name</td>
                    <td class="BVstyle">
                        <input type="text" name="applicant_name" class="form-control" value="{{ $case->getCase->applicant_name ?? '' }}" readonly>
                    </td>
                </tr>
                <tr>
                    <td>Case Creation Login Details</td>
                    <td colspan="3" class="BVstyle">
                        <input type="text" name="created_at" class="form-control" value="{{ $case->getCase->created_at ?? '' }}" readonly>
                    </td>
                </tr>
                <tr>
                    <td>Product Name</td>
                    <td class="BVstyle ng-binding">{{ $case->getCase->getProduct->name ?? 'NA' }}</td>
                    <td>Loan Amount</td>
                    <td class="BVstyle">
                        <input type="text" name="amount" class="form-control" value="{{ $case->getCase->amount ?? '' }}" readonly>
                    </td>
                </tr>
                <tr>
                    <td>Contact No.</td>
                    <td colspan="3" class="BVstyle">
                        <input type="text" name="mobile" class="form-control" value="{{ $case->mobile ?? '' }}" readonly>
                    </td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td colspan="3" class="BVstyle">
                        <input type="text" name="address" class="form-control" value="{{ $case->address ?? '' }}" readonly>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="subheading" style="text-align: center">
                        Employment(Salaried)/ Business(Self-Employed) Verification Report<br>
                        (Strictly Private & Confidential)
                    </td>
                </tr>
                <tr>
                    <td>Address Confirmed </td>
                    <td colspan="3" class="BVstyle">
                        <input type="text" name="address_confirmed" class="form-control" value="{{ $case->address_confirmed ?? 'NO' }}">
                    </td>
                </tr>
                <tr>
                    <td>Office/Business Address</td>
                    <td colspan="3" class="BVstyle">
                        <input type="text" name="employer_address" class="form-control" value="{{ $case->employer_address ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td>Type of Proof</td>
                    <td colspan="3" class="BVstyle">
                        <input type="text" name="type_of_proof" class="form-control" value="{{ $case->type_of_proof ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td>Address Confirmed By</td>
                    <td colspan="3" class="BVstyle">
                        <input type="text" name="address_confirmed_by" class="form-control" value="{{ $case->address_confirmed_by ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="subheading" style="text-align: center">
                        The following information should be obtained if the applicant/colleagues are contacted in the office
                    </td>
                </tr>
                <tr>
                    <td>Name of Employer/Co</td>
                    <td class="BVstyle">
                        <input type="text" name="name_of_employer" class="form-control" value="{{ $case->name_of_employer ?? '' }}">
                    </td>
                    <td>Person Met</td>
                    <td class="BVstyle">
                        <input type="text" name="person_met" class="form-control" value="{{ $case->person_met ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td>Address of Employer/Co</td>
                    <td colspan="3" class="BVstyle">
                        <input type="text" name="employer_address" class="form-control" value="{{ $case->address ?? '' }}">
                    </td>
                </tr>

                <tr>
                    <td>Mobile Number</td>
                    <td class="BVstyle">
                        <input type="text" name="mobile" class="form-control" value="{{ $case->mobile ?? '' }}">
                    </td>
                    <td>Type of Employer/Co</td>
                    <td class="BVstyle">
                        <input type="text" name="type_of_employer" class="form-control" value="{{ $case->type_of_employer ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td>Nature of Business</td>
                    <td colspan="3" class="BVstyle">
                        <input type="text" name="nature_of_employer" class="form-control" value="{{ $case->nature_of_employer ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td>Line of Business (for self-employed)</td>
                    <td class="BVstyle">
                        <input type="text" name="line_of_business" class="form-control" value="{{ $case->line_of_business ?? '' }}">
                    </td>
                    <td>Year of Establishment</td>
                    <td class="BVstyle">
                        <input type="text" name="year_of_establishment" class="form-control" value="{{ $case->year_of_establishment ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td>Level of Business activity(for self-employed)</td>
                    <td class="BVstyle">
                        <input type="text" name="level_of_business_activity" class="form-control" value="{{ $case->level_of_business_activity ?? '' }}">
                    </td>
                    <td>No. of Employees</td>
                    <td class="BVstyle">
                        <input type="text" name="no_of_employees" class="form-control" value="{{ $case->no_of_employees ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td>No of Branches/Offices</td>
                    <td class="BVstyle">
                        <input type="text" name="no_of_branches" class="form-control" value="{{ $case->no_of_branches ?? '' }}">
                    </td>
                    <td>Office ambience/look</td>
                    <td class="BVstyle">
                        <input type="text" name="office_ambience" class="form-control" value="{{ $case->assets_seen ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td>Type of Locality</td>
                    <td class="BVstyle">
                        <input type="text" name="type_of_locality" class="form-control" value="{{ $case->type_of_locality ?? '' }}">
                    </td>
                    <td>Area</td>
                    <td class="BVstyle">
                        <input type="text" name="area" class="form-control" value="{{ $case->area ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td>Nearest Landmark</td>
                    <td class="BVstyle">
                        <input type="text" name="nearest_landmark" class="form-control" value="{{ $case->nearest_landmark ?? '' }}">
                    </td>
                    <td>Ease of Locating</td>
                    <td class="BVstyle">
                        <input type="text" name="ease_of_locating" class="form-control" value="{{ $case->ease_of_locating ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td>Terms of employment(for employees)</td>
                    <td class="BVstyle">
                        <input type="text" name="terms_of_employment" class="form-control" value="{{ $case->terms_of_employment ?? '' }}">
                    </td>
                    <td>Grade</td>
                    <td class="BVstyle">
                        <input type="text" name="grade" class="form-control" value="{{ $case->grade ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td>Years of current employment</td>
                    <td class="BVstyle">
                        <input type="text" name="year_of_establishment" class="form-control" value="{{ $case->year_of_establishment ?? '' }}">
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4" class="subheading" style="text-align: center">If applicant is not giving information, the following information needs to be obtained from the Colleague/Guard/Neighbour</td>
                </tr>
                <tr>
                    <td>Applicant Age(Approx)</td>
                    <td class="BVstyle">
                        <input type="text" name="applicant_age" class="form-control" value="{{ $case->applicant_age ?? '' }}">
                    </td>
                    <td>Name of Employer/Co</td>
                    <td class="BVstyle">
                        <input type="text" name="name_of_employer_co" class="form-control" value="{{ $case->name_of_employer_co ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td>Co/Established in(Year)</td>
                    <td class="BVstyle">
                        <input type="text" name="established" class="form-control" value="{{ $case->established ?? '' }}">
                    </td>
                    <td>Designation</td>
                    <td class="BVstyle">
                        <input type="text" name="designation" class="form-control" value="{{ $case->designation ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td>Telephono No. Office</td>
                    <td class="BVstyle">
                        <input type="text" name="telephono_no_office" class="form-control" value="{{ $case->telephono_no_office ?? '' }}">
                    </td>
                    <td>Ext.</td>
                    <td class="BVstyle">
                        <input type="text" name="ext" class="form-control" value="{{ $case->ext ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td>Type of Co/Employer</td>
                    <td class="BVstyle">
                        <input type="text" name="type_of_employer" class="form-control" value="{{ $case->type_of_employer ?? '' }}">
                    </td>
                    <td>Nature of Co/Employer</td>
                    <td class="BVstyle">
                        <input type="text" name="nature_of_employer" class="form-control" value="{{ $case->nature_of_employer ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td>No of Employees</td>
                    <td class="BVstyle">
                        <input type="text" name="no_of_employees" class="form-control" value="{{ $case->no_of_employees ?? '' }}">
                    </td>
                    <td>No. of Branches</td>
                    <td class="BVstyle">
                        <input type="text" name="no_of_branches" class="form-control" value="{{ $case->no_of_branches ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td>Area</td>
                    <td class="BVstyle">
                        <input type="text" name="area" class="form-control" value="{{ $case->area ?? '' }}">
                    </td>
                    <td>Nearest Landmark</td>
                    <td class="BVstyle">
                        <input type="text" name="nearest_landmark" class="form-control" value="{{ $case->nearest_landmark ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="subheading" style="text-align: center">Office CPV COMMENTS</td>
                </tr>
                <tr>
                    <td colspan="4" class="ng-binding">positive Post- cenear technician .</td>
                </tr>
                <tr>
                    <td colspan="4" class="subheading" style="text-align: center">Supervisor Remarks</td>
                </tr>
                <tr>
                    <td colspan="4" class="subheading" style="text-align: center">AS CLAIMED / CONFIRMED</td>
                </tr>
                <tr>
                    <td colspan="4" class="ng-binding">Recommended - Recommended</td>
                </tr>
                <tr>
                    <td colspan="4" class="subheading" style="text-align: center">NEGATIVE FEATURES</td>
                </tr>
                <tr>
                    <td colspan="4" class="ng-binding">Not Recommended - Recommended</td>
                </tr>
                <tr>
                    <td>Visit Conducted </td>
                    <td colspan="2" class="ng-binding">
                    <td colspan="2" class="ng-binding">{{ ($case->status == 2) ? 'positive' : (($case->status == 3) ? 'negative' : 'NA') }}</td>
                    </td>
                </tr>
                <tr>
                    <td>VisitDate</td>
                    <td class="BVstyle">
                        <input type="date" name="date_of_visit" class="form-control" value="{{ $case->date_of_visit ?? '' }}">
                    </td>
                    <td>VisitTime</td>
                    <td class="BVstyle">
                        <input type="time" name="time_of_visit" class="form-control" value="{{ $case->time_of_visit ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="subheading" style="text-align: center">Location</td>
                </tr>
                <tr>
                    <td>Latitude</td>
                    <td class="BVstyle">
                        <input type=number step=0.01 name="latitude" class="form-control" value="{{ $case->latitude ?? '' }}">
                    </td>
                    <td>Longitude</td>
                    <td class="BVstyle">
                        <input type=number step=0.01 name="longitude" class="form-control" value="{{ $case->longitude ?? '' }}">
                    </td>
                </tr>

                <tr>
                    <td colspan="4" class="subheading" style="text-align: center">Third Party Check</td>
                </tr>
                <tr>
                    <td>TPC 1 Name</td>
                    <td class="BVstyle">
                        <input type="text" name="tcp1_name" class="form-control" value="{{ $case->tcp1_name ?? '' }}">
                    </td>
                    <td>TPC 1 (Checked with)</td>
                    <td class="BVstyle">
                        <input type="text" name="tcp1_checked_with" class="form-control" value="{{ $case->tcp1_checked_with ?? '' }}">
                    </td>
                </tr>

                <tr>
                    <td>TPC 2 Name</td>
                    <td class="BVstyle ng-binding">
                        <input type="text" name="tcp2_name" class="form-control" value="{{ $case->tcp2_name ?? '' }}">
                    </td>
                    <td>TPC 2 (Checked with)</td>
                    <td class="BVstyle ng-binding">
                        <input type="text" name="tcp2_checked_with" class="form-control" value="{{ $case->tcp2_checked_with ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td>Visited By </td>
                    <td class="BVstyle ng-binding ng-hide">
                        <input type="text" name="visited_by" class="form-control" value="{{ $case->visited_by ?? '' }}">
                    </td>
                    <td>Verified By </td>
                    <td class="BVstyle ng-binding ng-hide">
                        <input type="text" name="verified_by" class="form-control" value="{{ $case->verified_by ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="center"><input type="submit" value="Upate Bv Case" class="btn btn-primary updateBtn btn-sm"></td>
                </tr>
                <tr id="errors">

                </tr>
            </tbody>
        </table>
    </form>


    <br>
</div>
<script src="{{ asset('backend/assets/js/jquery.validate.min.js') }}"></script>

<script>
    $(document).ready(function() {

        $('.updateBtn').click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');

            let formData = form.serializeArray();
            let rowId = form.find('input[name="case_fi_id"]').val();
            let actionPath = "{{ route('admin.case.modifyBVCase','ID')}}";
            actionPath = actionPath.replace('ID', rowId);
            $.ajax({
                url: actionPath,
                type: 'POST',
                data: formData,
                success: function(response) {
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                },
                error: function(xhr, status, error) {
                    $.each(xhr.responseJSON.errors, function(key, item) {
                        $("#errors").append("<li class='alert alert-danger'>" + item + "</li>")
                    });
                }
            });
        });


    });
</script>