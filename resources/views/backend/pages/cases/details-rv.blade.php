<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <span align="right" height="30px;">
        <a href="javascript:void()" onclick="printformFunction()">Click here to print</a>
    </span>
    <table class="table table-bordered" id="outprint">
        <tbody>
            <tr>
                <td style="border:none;font-size:22px;color:#0094ff" align="center" colspan="1">
                    <img alt="State Bank of India" src="{{ asset('images/sbi.jpg') }}">
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
                <td colspan="3" class="BVstyle ng-binding">{{ $case->no_of_residents_in_house ?? '0000' }}</td>
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
                    Residence Verification Format
                </td>
            </tr>
            <tr>
                <td>Address Confirmed </td>
                <td colspan="3" class="BVstyle ng-binding">{{ $case->address_confirmed ?? 'NO' }} &nbsp; </td>
            </tr>
            <tr>
                <td>Address Confirmed By</td>
                <td colspan="3" class="BVstyle ng-binding ng-hide">{{ $case->address_confirmed_by ?? 'NA' }} </td>
            </tr>
            <tr>
                <td colspan="4" class="subheading" style="text-align: center">The following information should be obtained if the applicant/colleagues are contacted in the office </td>
            </tr>
            <tr>
                <td>Applicant Name</td>
                <td class="BVstyle ng-binding">{{ $case->applicant_name ?? 'NA' }} </td>
                <td>Date Of Birth</td>
                <td class="BVstyle ng-binding">{{ $case->date_of_birth ?? 'NA' }} </td>
            </tr>
            <tr>
                <td>Person Met</td>
                <td class="BVstyle ng-binding">{{ $case->person_met ?? 'NA' }} </td>
                <td>Relationship</td>
                <td class="BVstyle ng-binding">{{ $case->relationship ?? 'NA' }} </td>
            </tr>
            <tr>
                <td>No of Residents in the House</td>
                <td class="BVstyle ng-binding">{{ $case->no_of_residents_in_house ?? 'NA' }}</td>
                <td>Years at current Residence</td>
                <td class="BVstyle ng-binding">{{ $case->years_lived_at_this_residence ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>No of Earning Family Members</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->no_of_earning_family_members ?? 'NA' }}</td>
                <td>Residence Status</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->residence_status ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Name of Employer</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->name_of_employer ?? 'NA' }}</td>
                <td>Employer Address</td>
                <td class="BVstyle">{{ $case->employer_address ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Telephone No. Residence</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->telephone_no_residence ?? 'NA' }}</td>
                <td>Office</td>
                <td class="BVstyle ng-binding">{{ $case->office ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Designation</td>
                <td colspan="3" class="BVstyle ng-binding">{{ $case->designation ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Approx Rent</td>
                <td class="BVstyle ng-binding">{{ $case->approx_rent ?? 'NA' }}</td>
                <td>Approx Value(If Owned)</td>
                <td class="BVstyle ng-binding">{{ $case->approx_value ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Bank Name</td>
                <td class="BVstyle ng-binding">{{ $case->bank_name ?? 'NA' }}</td>
                <td>Branch</td>
                <td class="BVstyle ng-binding">{{ $case->branch ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Permanent Address/Phone</td>
                <td colspan="3" class="BVstyle ng-binding">{{ $case->permanent_address ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Vehicles</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->vehicles ?? 'NA' }} </td>
                <td>Make and Type</td>
                <td class="BVstyle ng-binding">{{ $case->make_and_type ?? 'NA' }}</td>
            </tr>
            <tr>
                <td colspan="4" class="subheading" style="text-align: center">Verifier's Observations</td>
            </tr>
            <tr>
                <td>Location </td>
                <td class="BVstyle ng-binding">{{ $case->location ?? 'NA' }} </td>
                <td>Locality</td>
                <td class="BVstyle ng-binding">{{ $case->locality ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Accomodation Type</td>
                <td class="BVstyle ng-binding">{{ $case->accommodation_type ?? 'NA' }} </td>
                <td>Interior Conditions</td>
                <td class="BVstyle ng-binding">{{ $case->interior_conditions ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Assets Seen</td>
                <td colspan="3" class="BVstyle ng-binding ng-hide"> {{ $case->assets_seen ?? 'NA' }}</td>

            </tr>
            <tr>
                <td>Area</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->area ?? 'NA' }}</td>
                <td>Standard of Living</td>
                <td>{{ $case->standard_of_living ?? 'NA' }}</td>
            </tr>

            <tr>
                <td>Nearest Landmark</td>
                <td colspan="3" class="BVstyle ng-binding">{{ $case->nearest_landmark ?? 'NA' }} </td>
            </tr>
            <tr>
                <td colspan="4" class="subheading" style="text-align: center">If the house is locked,the following information needs to be obtained from the Neighbour/Third Party.</td>
            </tr>
            <tr>
                <td>Applicant Name</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->applicant_name ?? 'NA' }}</td>
                <td>Person Met</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->person_met ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Relationship</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->relationship_others ?? 'NA' }}</td>
                <td>Applicant Age(Approx)</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->applicant_age ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>No. of Residents in House</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->residence_status_others ?? 'NA' }}</td>
                <td>Years Lived at this Residence</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->years_at_current_residence_others ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Occupation</td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->occupation ?? '0000' }}</td>
            </tr>
            <tr>
                <td colspan="4" class="subheading" style="text-align: center">If the address is not confirmed then the following information needs to be filled.</td>
            </tr>
            <tr>
                <td>Untraceable</td>
                <td>Reason</td>
                <td colspan="2" class="BVstyle ng-binding ng-hide">0000</td>
            </tr>
            <tr>
                <td></td>
                <td>Result of Calling</td>
                <td colspan="2" class="BVstyle ng-binding ng-hide">'0000'</td>
            </tr>
            <tr>
                <td><b>Mismatch in Residence Address</b></td>
                <td>Is Applicant Known to the person</td>
                <td colspan="2" class="BVstyle ng-binding ng-hide"> '0000' </td>
            </tr>

            <tr>
                <td></td>
                <td>To Whom Does Address Belong ?</td>
                <td colspan="2" class="BVstyle ng-binding ng-hide">0000</td>
            </tr>
            <tr ng-hide="BVCase.StatusID==217" class="">
                <td colspan="4" class="subheading" style="text-align: center">The following is based on Verifier Observations</td>
            </tr>
            <tr>
                <td>Verifier's Name</td>
                <td colspan="3">{{ $case->verifiers_name ?? 'NA' }}</td>

            </tr>

            <tr>
                <td>Verification Conducted at</td>
                <td colspan="3">{{ $case->verification_conducted_at ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Proof attached</td>
                <td colspan="3">{{ $case->proof_attached ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Type of Proof</td>
                <td colspan="3">{{ $case->type_of_proof ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Date of Visit</td>
                <td>{{ $case->date_of_visit ?? 'NA' }}</td>
                <td>Time of Visit</td>
                <td>{{ $case->time_of_visit ?? 'NA' }}</td>
            </tr>

            <tr>
                <td colspan="4" class="subheading" style="text-align: center">Updations</td>
            </tr>
            <tr>
                <td>Address</td>
                <td colspan="3"></td>
            </tr>

            <tr>
                <td colspan="4" class="subheading" style="text-align: center">Supervisor Remarks</td>
            </tr>
            <tr>
                <td colspan="4">{{ $case->supervisor_remarks ?? 'NA' }}</td>
            </tr>
            <tr class="">
                <td colspan="4" class="subheading" style="text-align: center">NEGATIVE FEATURES</td>
            </tr>
            <tr class="ng-hide">
                <td colspan="4" class="ng-binding"></td>
            </tr>
            <tr class="">
                <td>Visit Conducted </td>
                <td colspan="3" class="ng-binding">{{ $case->no_of_residents_in_house ?? '0000' }}</td>
            </tr>
            <tr>
                <td colspan="4" class="subheading" style="text-align: center">Applicant Photos </td>
            </tr>
            <tr>
                <td colspan="4">
                    <div class="row">
                        @if(!empty($case->image_1))
                        <div class="col-sm image_1">
                            <img title='' style='width:100px;float:left; height:100px;margin-bottom:5px; margin-left:5px;border:2px solid #b06c1c;border-radius:10px;' src="{{ asset($case->image_1) }}" />
                        </div>
                        @endif
                        @if(!empty($case->image_2))
                        <div class="col-sm image_2">
                            <img title='' style='width:100px;float:left; height:100px;margin-bottom:5px; margin-left:5px;border:2px solid #b06c1c;border-radius:10px;' src="{{ asset($case->image_2) }}" />
                        </div>
                        @endif
                        @if(!empty($case->image_3))
                        <div class="col-sm image_3">
                            <img title='' style='width:100px;float:left; height:100px;margin-bottom:5px; margin-left:5px;border:2px solid #b06c1c;border-radius:10px;' src="{{ asset($case->image_3) }}" />
                        </div>
                        @endif
                        @if(!empty($case->image_4))
                        <div class="col-sm image_4">
                            <img title='' style='width:100px;float:left; height:100px;margin-bottom:5px; margin-left:5px;border:2px solid #b06c1c;border-radius:10px;' src="{{ asset($case->image_4) }}" />
                        </div>
                        @endif
                        @if(!empty($case->image_5))
                        <div class="col-sm image_5">
                            <img title='' style='width:100px;float:left; height:100px;margin-bottom:5px; margin-left:5px;border:2px solid #b06c1c;border-radius:10px;' src="{{ asset($case->image_5) }}" />
                        </div>
                        @endif
                        @if(!empty($case->image_6))
                        <div class="col-sm image_6">
                            <img title='' style='width:100px;float:left; height:100px;margin-bottom:5px; margin-left:5px;border:2px solid #b06c1c;border-radius:10px;' src="{{ asset($case->image_6) }}" />
                        </div>
                        @endif
                        @if(!empty($case->image_7))
                        <div class="col-sm image_7">
                            <img title='' style='width:100px;float:left; height:100px;margin-bottom:5px; margin-left:5px;border:2px solid #b06c1c;border-radius:10px;' src="{{ asset($case->image_7) }}" />
                        </div>
                        @endif
                        @if(!empty($case->image_8))
                        <div class="col-sm image_8">
                            <img title='' style='width:100px;float:left; height:100px;margin-bottom:5px; margin-left:5px;border:2px solid #b06c1c;border-radius:10px;' src="{{ asset($case->image_8) }}" />
                        </div>
                        @endif
                        @if(!empty($case->image_9))
                        <div class="col-sm image_9">
                            <img title='' style='width:100px;float:left; height:100px;margin-bottom:5px; margin-left:5px;border:2px solid #b06c1c;border-radius:10px;' src="{{ asset($case->image_9) }}" />
                        </div>
                        @endif

                    </div>
                </td>
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
                <td colspan="4">
                    @if(!empty($case->latitude) && !empty($case->longitude))
                    <iframe id="BV_Map" src="https://maps.google.com/maps?q={{ $case->latitude }},{{ $case->longitude }}&z=15&output=embed" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                    @endif
                </td>
            </tr>
            <tr>
                <td colspan="4" class="subheading" style="text-align: center">Cross Verification Info</td>
            </tr>
            <tr>
                <td>Neighbour Check 1</td>
                <td class="BVstyle ng-binding">{{ $case->tcp1_name ?? 'NA' }} </td>
                <td>Neighbour1 Checked With</td>
                <td class="BVstyle ng-binding">{{ $case->tcp1_checked_with ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>TCP1 Negative Comments</td>
                <td colspan="3">{{ $case->tcp1_negative_comments ?? 'NA' }} </td>
            </tr>
            <tr>
                <td>Neighbour Check 2</td>
                <td class="BVstyle ng-binding">{{ $case->tcp2_name ?? 'NA' }} </td>
                <td>Neighbour2 Checked With</td>
                <td class="BVstyle ng-binding">{{ $case->tcp2_checked_with ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>TCP2 Negative Comments</td>
                <td colspan="3">{{ $case->tcp2_negative_comments ?? 'NA' }} </td>
            </tr>

            <tr>
                <td>Visited By </td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->visited_by ?? 'NA' }}</td>
                <td>Verified By </td>
                <td class="BVstyle ng-binding ng-hide">{{ $case->verified_by ?? 'NA' }}</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center">
                    <!-- <img src="http://verification.mobileforce.in/Data/CaseLogos/" height="100" width="200"> -->
                    {{ $case->signature_of_agency_supervisor ?? 'NA' }}
                    <br>
                    Signature of Agency Supervisor (With agency Seal)
                </td>
                <td colspan="2" style="text-align:center">
                    <!-- <img src="http://verification.mobileforce.in/Data/CaseLogos/" height="100" width="200"> -->
                    {{ $case->audit_check_remarks_by_agency_with_stamp ?? 'NA' }}
                    <br>
                    Audit Check Remarks by Agency With Stamp &amp; Sign
                </td>
            </tr>
        </tbody>
    </table>
    <br>
</div>