<style>
    .error {
        color: red;
    }
</style>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <form action="{{ route('admin.case.modifyCase.viewCase', $case->id) }}" method="POST">
        @csrf
        <input type="hidden" name="case_fy_id" value="{{ $case->id }}" />
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
                        <input type="text" name="refrence_number" class="form-control" value="{{ $case->getCase->refrence_number ?? '' }}">
                    </td>
                    <td>Customer Name</td>
                    <td class="BVstyle">
                        <input type="text" name="applicant_name" class="form-control" value="{{ $case->getCase->applicant_name ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td>Case Creation Login Details</td>
                    <td colspan="3" class="BVstyle">
                        <input type="text" name="created_at" class="form-control" value="{{ $case->getCase->created_at ?? 'NA' }}">
                    </td>
                </tr>
                <tr>
                    <td>Product Name</td>
                    <td class="BVstyle">
                        <input type="text" name="product_name" class="form-control" value="{{ $case->getCase->getProduct->name ?? 'NA' }}">
                    </td>
                    <td>Loan Amount</td>
                    <td class="BVstyle">
                        <input type="text" name="loan_amount" class="form-control" value="{{ $case->getCase->amount ?? 'NA' }}">
                    </td>
                </tr>
                <tr>
                    <td>Contact No.</td>
                    <td colspan="3" class="BVstyle">
                        <input type="text" name="mobile" class="form-control" value="{{ $case->mobile ?? '' }}">
                    </td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td colspan="3" class="BVstyle">
                        <input type="text" name="address" class="form-control" value="{{ $case->address ?? '' }}">
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
                        <input type="text" name="type_of_proof" class="form-control" value="{{ $case->type_of_proof ?? 'NA' }}">
                    </td>
                </tr>
                <tr>
                    <td>Address Confirmed By</td>
                    <td colspan="3" class="BVstyle">
                        <input type="text" name="address_confirmed_by" class="form-control" value="{{ $case->address_confirmed_by ?? 'NA' }}">
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
                        <input type="text" name="name_of_employer" class="form-control" value="{{ $case->name_of_employer ?? 'NA' }}">
                    </td>
                    <td>Person Met</td>
                    <td class="BVstyle">
                        <input type="text" name="person_met" class="form-control" value="{{ $case->person_met ?? 'NA' }}">
                    </td>
                </tr>
                <tr>
                    <td>Address of Employer/Co</td>
                    <td colspan="3" class="BVstyle">
                        <input type="text" name="employer_address" class="form-control" value="{{ $case->address ?? 'NA' }}">
                    </td>
                </tr>
                <tr>
                    <td>Website of Employer/Co(if available)</td>
                    <td class="BVstyle">
                        <input type="text" name="website_of_employer" class="form-control" value="{{ $case->website_of_employer ?? 'NA' }}">
                    </td>
                    <td>e-mail address of Employer/Co(if available)</td>
                    <td class="BVstyle">
                        <input type="text" name="email_of_employer" class="form-control" value="{{ $case->email_of_employer ?? 'NA' }}">
                    </td>
                </tr>
                <tr>
                    <td>Telephone Number Office</td>
                    <td class="BVstyle">
                        <input type="text" name="telephono_no_office" class="form-control" value="{{ $case->telephono_no_office ?? 'NA' }}">
                    </td>
                    <td>EXT</td>
                    <td class="BVstyle">
                        <input type="text" name="ext" class="form-control" value="{{ $case->ext ?? 'NA' }}">
                    </td>
                </tr>
                <tr>
                    <td>Telephone Number Residence</td>
                    <td class="BVstyle">
                        <input type="text" name="telephone_no_residence" class="form-control" value="{{ $case->telephone_no_residence ?? 'NA' }}">
                    </td>
                    <td>Mobile Number</td>
                    <td class="BVstyle">
                        <input type="text" name="mobile" class="form-control" value="{{ $case->mobile ?? 'NA' }}">
                    </td>
                </tr>
                <tr>
                    <td>Co. Board Outside Bldg/Office</td>
                    <td class="BVstyle">
                        <input type="text" name="co_board_outside_bldg_office" class="form-control" value="{{ $case->co_board_outside_bldg_office ?? 'NA' }}">
                    </td>
                    <td>Type of Employer/Co</td>
                    <td class="BVstyle">
                        <input type="text" name="type_of_employer" class="form-control" value="{{ $case->type_of_employer ?? 'NA' }}">
                    </td>
                </tr>
                <tr>
                    <td>Nature of Business</td>
                    <td colspan="3" class="BVstyle">
                        <input type="text" name="nature_of_employer" class="form-control" value="{{ $case->nature_of_employer ?? 'NA' }}">
                    </td>
                </tr>
                <tr>
                    <td>Line of Business (for self-employed)</td>
                    <td class="BVstyle">
                        <input type="text" name="line_of_business" class="form-control" value="{{ $case->line_of_business ?? 'NA' }}">
                    </td>
                    <td>Year of Establishment</td>
                    <td class="BVstyle">
                        <input type="text" name="year_of_establishment" class="form-control" value="{{ $case->year_of_establishment ?? 'NA' }}">
                    </td>
                </tr>
                <tr>
                    <td>Level of Business activity(for self-employed)</td>
                    <td class="BVstyle">
                        <input type="text" name="level_of_business_activity" class="form-control" value="{{ $case->level_of_business_activity ?? 'NA' }}">
                    </td>
                    <td>No. of Employees</td>
                    <td class="BVstyle">
                        <input type="text" name="no_of_employees" class="form-control" value="{{ $case->no_of_employees ?? 'NA' }}">
                    </td>
                </tr>
                <tr>
                    <td>No of Branches/Offices</td>
                    <td class="BVstyle">
                        <input type="text" name="no_of_branches" class="form-control" value="{{ $case->no_of_branches ?? 'NA' }}">
                    </td>
                    <td>Office ambience/look</td>
                    <td class="BVstyle">
                        <input type="text" name="office_ambience" class="form-control" value="{{ $case->assets_seen ?? 'NA' }}">
                    </td>
                </tr>
                <tr>
                    <td>Type of Locality</td>
                    <td class="BVstyle">
                        <input type="text" name="type_of_locality" class="form-control" value="{{ $case->type_of_locality ?? '0000' }}">
                    </td>
                    <td>Area</td>
                    <td class="BVstyle">
                        <input type="text" name="area" class="form-control" value="{{ $case->area ?? '0000' }}">
                    </td>
                </tr>
                <tr>
                    <td>Nearest Landmark</td>
                    <td class="BVstyle">
                        <input type="text" name="nearest_landmark" class="form-control" value="{{ $case->nearest_landmark ?? '0000' }}">
                    </td>
                    <td>Ease of Locating</td>
                    <td class="BVstyle">
                        <input type="text" name="ease_of_locating" class="form-control" value="{{ $case->ease_of_locating ?? '0000' }}">
                    </td>
                </tr>
                <tr>
                    <td>Terms of employment(for employees)</td>
                    <td class="BVstyle">
                        <input type="text" name="terms_of_employment" class="form-control" value="{{ $case->terms_of_employment ?? '0000' }}">
                    </td>
                    <td>Grade</td>
                    <td class="BVstyle">
                        <input type="text" name="grade" class="form-control" value="{{ $case->grade ?? '0000' }}">
                    </td>
                </tr>
                <tr>
                    <td>Years of current employment</td>
                    <td class="BVstyle">
                        <input type="text" name="years_lived_at_this_residence" class="form-control" value="{{ $case->years_lived_at_this_residence ?? '0000' }}">
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
                        <input type="text" name="applicant_age" class="form-control" value="{{ $case->applicant_age ?? '0000' }}">
                    </td>
                    <td>Name of Employer/Co</td>
                    <td class="BVstyle">
                        <input type="text" name="name_of_employer_co" class="form-control" value="{{ $case->name_of_employer_co ?? 'NA' }}">
                    </td>
                </tr>
                <tr>
                    <td>Co/Established in(Year)</td>
                    <td class="BVstyle">
                        <input type="text" name="established" class="form-control" value="{{ $case->established ?? '0000' }}">
                    </td>
                    <td>Designation</td>
                    <td class="BVstyle">
                        <input type="text" name="designation" class="form-control" value="{{ $case->designation ?? 'NA' }}">
                    </td>
                </tr>
                <tr>
                    <td>Telephono No. Office</td>
                    <td class="BVstyle">
                        <input type="text" name="telephono_no_office" class="form-control" value="{{ $case->telephono_no_office ?? '0000' }}">
                    </td>
                    <td>Ext.</td>
                    <td class="BVstyle">
                        <input type="text" name="ext" class="form-control" value="{{ $case->ext ?? '0000' }}">
                    </td>
                </tr>
                <tr>
                    <td>Type of Co/Employer</td>
                    <td class="BVstyle">
                        <input type="text" name="type_of_employer" class="form-control" value="{{ $case->type_of_employer ?? '0000' }}">
                    </td>
                    <td>Nature of Co/Employer</td>
                    <td class="BVstyle">
                        <input type="text" name="nature_of_employer" class="form-control" value="{{ $case->nature_of_employer ?? '0000' }}">
                    </td>
                </tr>
                <tr>
                    <td>No of Employees</td>
                    <td class="BVstyle">
                        <input type="text" name="no_of_employees" class="form-control" value="{{ $case->no_of_employees ?? '0000' }}">
                    </td>
                    <td>No. of Branches</td>
                    <td class="BVstyle">
                        <input type="text" name="no_of_branches" class="form-control" value="{{ $case->no_of_branches ?? '0000' }}">
                    </td>
                </tr>
                <tr>
                    <td>Area</td>
                    <td class="BVstyle">
                        <input type="text" name="area" class="form-control" value="{{ $case->area ?? '0000' }}">
                    </td>
                    <td>Nearest Landmark</td>
                    <td class="BVstyle">
                        <input type="text" name="nearest_landmark" class="form-control" value="{{ $case->nearest_landmark ?? '0000' }}">
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
                    <td colspan="3" class="ng-binding">
                        <input type="text" name="visit_conducted" class="form-control" value="{{ $case->visit_conducted ?? '0000' }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="subheading" style="text-align: center">Applicant Photos</td>
                </tr>
                <tr>
                    <td>VisitDate</td>
                    <td class="BVstyle">
                        <input type="text" name="date_of_visit" class="form-control" value="{{ $case->date_of_visit ?? '0000' }}">
                    </td>
                    <td>VisitTime</td>
                    <td class="BVstyle">
                        <input type="text" name="time_of_visit" class="form-control" value="{{ $case->time_of_visit ?? '0000' }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="subheading" style="text-align: center">Location</td>
                </tr>
                <tr>
                    <td>Latitude</td>
                    <td class="BVstyle">
                        <input type="text" name="latitude" class="form-control" value="{{ $case->latitude ?? '0000' }}">
                    </td>
                    <td>Longitude</td>
                    <td class="BVstyle">
                        <input type="text" name="longitude" class="form-control" value="{{ $case->longitude ?? '0000' }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        @if(!empty($case->latitude) && !empty($case->longitude))
                        <iframe id="BV_Map" src="https://maps.google.com/maps?q={{ $case->latitude }},{{ $case->longitude }}&z=15&output=embed" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="subheading" style="text-align: center">Third Party Check</td>
                </tr>
                <tr>
                    <td>TPC 1 Name</td>
                    <td class="BVstyle">
                        <input type="text" name="tcp1_name" class="form-control" value="{{ $case->tcp1_name ?? '0000' }}">
                    </td>
                    <td>TPC 1 (Checked with)</td>
                    <td class="BVstyle">
                        <input type="text" name="tcp1_checked_with" class="form-control" value="{{ $case->tcp1_checked_with ?? '0000' }}">
                    </td>
                </tr>

                <tr>
                    <td>TPC 2 Name</td>
                    <td class="BVstyle ng-binding">0000 </td>
                    <td>TPC 2 (Checked with)</td>
                    <td class="BVstyle ng-binding">0000</td>
                </tr>
                <tr dataclass="">
                    <td>Customer Signature</td>
                    <td colspan="2">
                        <!-- <img src="http://verification.mobileforce.in/Data/CaseImages/2315248/sign_10857_1724536951040.png" dataheight="50" width="100" class=""> -->
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Visited By </td>
                    <td class="BVstyle ng-binding ng-hide">0000</td>
                    <td>Verified By </td>
                    <td class="BVstyle ng-binding ng-hide">0000</td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center">
                        <!-- <img src="http://verification.mobileforce.in/Data/CaseLogos/" height="100" width="200"> -->
                        0000
                        <br>
                        Signature of Agency Supervisor (With agency Seal)
                    </td>
                    <td colspan="2" style="text-align:center">
                        <!-- <img src="http://verification.mobileforce.in/Data/CaseLogos/" height="100" width="200"> -->
                        0000
                        <br>
                        Audit Check Remarks by Agency With Stamp &amp; Sign
                    </td>
                </tr>

                <tr>
                    <td colspan="4" align="center"><input type="submit" value="Upate" class="btn btn-primary updateBtn btn-sm"></td>
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
            form.validate({ // initialize the validator
                rules: {
                    case_fy_id: {
                        required: true
                    },
                    refrence_number: {
                        required: true
                    },
                    applicant_name: {
                        required: true
                    },
                    product_id: {
                        required: true
                    },
                    amount: {
                        required: true
                    },
                    mobile: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    address_confirmed: {
                        required: true
                    },
                    address_confirmed_by: {
                        required: true
                    },
                    type_of_proof: {
                        required: true
                    },
                    name_of_employer: {
                        required: true
                    },
                    person_met: {
                        required: true
                    },
                    telephone_no_residence: {
                        required: true
                    },
                    applicant_age: {
                        required: true
                    },
                    designation: {
                        required: true
                    },
                    area: {
                        required: true
                    },
                    nearest_landmark: {
                        required: true
                    },
                    latitude: {
                        required: true
                    },
                    longitude: {
                        required: true
                    },
                }
            });
            let formData = form.serializeArray();
            let rowId = form.find('input[name="case_fy_id"]').val();
            let actionPath = "{{ route('admin.case.modifyCase.viewCase','ID')}}";
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
                error: function() {
                    alert('Request failed');
                }
            });
        });


    });
</script>