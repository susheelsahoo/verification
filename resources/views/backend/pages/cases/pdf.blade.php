<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <table class="table table-bordered" border="2">
        <tbody>
            <tr>
                <td style="border:none;font-size:22px;color:#0094ff" align="center" colspan="1">
                    <img alt="State Bank of India" src="{{ public_path('images/sbi.jpg') }}">
                </td>
                <td class="address_text" align="center" colspan="3"> CORE DOC2INFO SERVICES</td>
            </tr>

            <tr>
                <td>Reference No.</td>
                <td class="BVstyle ng-binding">{{ $case->getCase->refrence_number ?? '' }}</td>
                <td>Customer Name</td>
                <td class="BVstyle ng-binding">{{ $case->getCase->applicant_name ?? '' }}</td>
            </tr>
            <tr>
                <td>Case Creation Login Details</td>
                <td colspan="3" class="BVstyle ng-binding">{{ $case->getCase->created_at ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Product Name</td>
                <td class="BVstyle ng-binding">{{ $case->getCase->getProduct->name ?? 'NA' }}</td>
                <td>Loan Amount</td>
                <td class="BVstyle ng-binding">{{ $case->getCase->amount ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Contact No.</td>
                <td colspan="3" class="BVstyle ng-binding">{{ $case->mobile ?? '' }}</td>
            </tr>
            <tr>
                <td>Address</td>
                <td colspan="3" class="BVstyle ng-binding">{{ $case->address ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="4" class="subheading" style="text-align: center">
                    Employment(Salaried)/ Business(Self-Employed) Verification Report<br>
                    (Strictly Private &amp; Confidential)
                </td>
            </tr>
            <tr>
                <td>Address Confirmed </td>
                <td colspan="3" class="BVstyle ng-binding">{{ $case->address_confirmed ?? 'NO' }} &nbsp; </td>
            </tr>
            <tr>
                <td>Office/Business Address</td>
                <td colspan="3" class="BVstyle ng-binding">{{ $case->employer_address ?? '' }} &nbsp; </td>
            </tr>
            <tr>
                <td>Type of Proof</td>
                <td colspan="3" class="BVstyle ng-binding">{{ $case->type_of_proof ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Address Confirmed By</td>
                <td colspan="3" class="BVstyle ng-binding ng-hide">{{ $case->address_confirmed_by ?? 'NA' }} </td>
            </tr>
            <tr>
                <td colspan="4" class="subheading" style="text-align: center">The following information should be obtained if the applicant/colleagues are contacted in the office </td>
            </tr>
            <tr>
                <td>Name of Employer/Co</td>
                <td class="BVstyle ng-binding">{{ $case->name_of_employer ?? 'NA' }} </td>
                <td>Person Met</td>
                <td class="BVstyle ng-binding">{{ $case->person_met ?? 'NA' }} </td>
            </tr>
            <tr>
                <td>Address of Employer/Co</td>
                <td colspan="3" class="BVstyle ng-binding">{{ $case->address ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Website of Employer/Co(if available)</td>
                <td class="BVstyle ng-binding">{{ $case->website_of_employer ?? 'NA' }}</td>
                <td>e-mail address of Employer/Co(if available)</td>
                <td class="BVstyle ng-binding">{{ $case->email_of_employer ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Telephone Number Office</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->telephono_no_office ?? 'NA' }}</td>
                <td>EXT</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->ext ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Telephone Number Residence</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->telephone_no_residence ?? 'NA' }}</td>
                <td>Mobile Number</td>
                <td class="BVstyle" ng-hide="BVResponse.mobileno">{{ $case->mobile ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Co. Board Outside Bldg/Office</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->co_board_outside_bldg_office ?? 'NA' }}</td>
                <td>Type of Employer/Co</td>
                <td class="BVstyle ng-binding">{{ $case->email_of_employer ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Nature of Business</td>
                <td colspan="3" class="BVstyle ng-binding">{{ $case->nature_of_employer ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Line of Business (for self-emplyed)</td>
                <td class="BVstyle ng-binding">{{ $case->line_of_business ?? 'NA' }}</td>
                <td>Year of Establishment</td>
                <td class="BVstyle ng-binding">{{ $case->year_of_establishment ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Level of Business activity(for self-employed)</td>
                <td class="BVstyle ng-binding">{{ $case->level_of_business_activity ?? 'NA' }}</td>
                <td>No. of Employees</td>
                <td class="BVstyle ng-binding">{{ $case->no_of_employees ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>No of Branches/Offices</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->no_of_branches ?? 'NA' }} </td>
                <td>Office ambience/look</td>
                <td class="BVstyle ng-binding">{{ $case->assets_seen ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Type of Locality </td>
                <td class="BVstyle ng-binding">{{ $case->type_of_locality ?? 'NA' }} </td>
                <td>Area</td>
                <td class="BVstyle ng-binding">{{ $case->area ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Nearest Landmark</td>
                <td class="BVstyle ng-binding">{{ $case->nearest_landmark ?? 'NA' }} </td>
                <td>Ease of Locating</td>
                <td class="BVstyle ng-binding">{{ $case->email_of_employer ?? '0000' }}</td>
            </tr>
            <tr>
                <td>Terms of employment(for employees)</td>
                <td class="BVstyle ng-binding ng-hide"> {{ $case->terms_of_employment ?? 'NA' }}</td>
                <td>Grade</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->grade ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Years of current employment</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->year_of_establishment ?? 'NA' }}</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4" class="subheading" style="text-align: center">If applicant is not giving information, the following information needs to be obtained from the Colleague/Guard/Neighbour </td>
            </tr>
            <tr>
                <td>Applicant Age(Approx)</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->applicant_age ?? '0' }}</td>
                <td>Name of Employer/Co</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->name_of_employer_co ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Co/Established in(Year)</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->established ?? 'NA' }}</td>
                <td>Designation</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->designation ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Telephono No. Office</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->telephono_no_office ?? 'NA' }}</td>
                <td>Ext.</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->ext ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Type of Co/Employer</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->type_of_employer ?? 'NA' }}</td>
                <td>Nature of Co/Employer</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->nature_of_employer ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>No of Employees</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->no_of_employees ?? 'NA' }}</td>
                <td>No. of Branches</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->no_of_branches ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Area</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->area ?? 'NA' }}</td>
                <td>Nearest Landmark</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->nearest_landmark ?? 'NA' }}</td>
            </tr>
            <tr ng-hide="BVCase.StatusID==217" class="">
                <td colspan="4" class="subheading" style="text-align: center">Office CPV COMMENTS</td>
            </tr>
            <tr ng-hide="BVCase.StatusID==217" class="">
                <td colspan="4" class="ng-binding">positive Post- cenear technician .</td>
            </tr>
            <tr>
                <td colspan="4" class="subheading" style="text-align: center">Supervisor Remarks</td>
            </tr>

            <tr ng-hide="BVCase.VerifiedType==219 || BVCase.SubStatusId!=536"=218" class="">
                <td colspan="4" class="subheading" style="text-align: center">AS CLAIMED / CONFIRMED</td>
            </tr>
            <tr ng-hide="BVCase.VerifiedType==219 || BVCase.SubStatusId!=536"=218" class="">
                <td colspan="4" class="ng-binding">Recommended - Recommended</td>
            </tr>

            <tr ng-hide="BVCase.VerifiedType==218 || BVCase.SubStatusId==536"=219" class="ng-hide">
                <td colspan="4" class="subheading" style="text-align: center">NEGATIVE FEATURES</td>
            </tr>
            <tr ng-hide="BVCase.VerifiedType==218 || BVCase.SubStatusId==536"=219" class="ng-hide">
                <td colspan="4" class="ng-binding">Not Recommended - Recommended</td>
            </tr>
            <tr ng-hide="BVCase.StatusID==220" class="">
                <td>Visit Conducted </td>
                <td colspan="2" class="ng-binding">{{ ($case->status == 2) ? 'positive' : (($case->status == 3) ? 'negative' : 'NA') }}</td>
            </tr>

            <tr>
                <td>VisitDate</td>
                <td class="BVstyle ng-binding">{{ $case->date_of_visit ?? 'NA' }}</td>
                <td>VisitTime</td>
                <td class="BVstyle ng-binding">{{ $case->time_of_visit ?? 'NA' }}</td>
            </tr>
            <tr>
                <td colspan="4" class="subheading" style="text-align: center">Location</td>
            </tr>
            <tr>
                <td>Latitude</td>
                <td class="BVstyle ng-binding">{{ $case->latitude ?? 'NA' }}</td>
                <td>Longitude</td>
                <td class="BVstyle ng-binding">{{ $case->longitude ?? 'NA' }}</td>
            </tr>
            <tr>
                <td colspan="4" class="subheading" style="text-align: center">Third Party Check</td>
            </tr>
            <tr>
                <td>TPC 1 Name</td>
                <td class="BVstyle ng-binding">{{ $case->tcp1_name ?? 'NA' }} </td>
                <td>TPC 1 (Checked with)</td>
                <td class="BVstyle ng-binding">{{ $case->tcp1_checked_with ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>TPC 2 Name</td>
                <td class="BVstyle ng-binding">{{ $case->tcp2_name ?? 'NA' }} </td>
                <td>TPC 2 (Checked with)</td>
                <td class="BVstyle ng-binding">{{ $case->tcp2_checked_with ?? 'NA' }}</td>
            </tr>

            <tr>
                <td>Visited By </td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->visited_by ?? 'NA' }}</td>
                <td>Verified By </td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->verified_by ?? 'NA' }}</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center">
                    @if(!empty($case->signature_of_agency_supervisor))
                    <img title='' style='width:100px;height:100px;margin-bottom:5px; margin-left:5px;border:2px solid #b06c1c;border-radius:10px;' src="{{ public_path(asset($case->signature_of_agency_supervisor)) }}" />
                    @endif
                    <br>
                    Signature of Agency Supervisor (With agency Seal)
                </td>
                <td colspan="2" style="text-align:center">
                    {{ $case->email_of_employer ?? '0000' }}
                    <br>
                    Audit Check Remarks by Agency With Stamp &amp; Sign
                </td>
            </tr>
        </tbody>
    </table>
    <br>
</div>