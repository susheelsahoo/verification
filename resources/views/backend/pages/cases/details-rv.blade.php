<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td colspan="4" align="right" height="30px;">
                    <a href="javascript:Print()">Click here to print</a>
                </td>
            </tr>

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
                <td colspan="3" class="BVstyle ng-binding">0000</td>
            </tr>
            <tr>
                <td>Product Name</td>
                <td class="BVstyle ng-binding">{{ $case->getCase->getProduct->name ?? 'NA' }}</td>
                <td>Loan Amount</td>
                <td class="BVstyle ng-binding" ng-show="BVCase.LoanAmount">{{ $case->getCase->amount ?? 'NA' }}</td>
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
                <td colspan="3" class="BVstyle ng-binding" ng-show="BVResponse.addressconfirmed">{{ $case->address_confirmed ?? 'NO' }} &nbsp; </td>
            </tr>
            <tr>
                <td>Address Confirmed By</td>
                <td colspan="3" class="BVstyle ng-binding ng-hide" ng-show="BVResponse.addressconfirmedby">{{ $case->address_confirmed_by ?? 'NA' }} </td>
            </tr>
            <tr>
                <td colspan="4" class="subheading" style="text-align: center">The following information should be obtained if the applicant/colleagues are contacted in the office </td>
            </tr>
            <tr>
                <td>Applicant Name</td>
                <td class="BVstyle ng-binding" ng-show="BVResponse.nameofemployer">{{ $case->name_of_employer ?? 'NA' }} </td>
                <td>Date Of Birth</td>
                <td class="BVstyle ng-binding" ng-show="BVResponse.personcontacted">{{ $case->person_met ?? 'NA' }} </td>
            </tr>
            <tr>
                <td>Person Met</td>
                <td class="BVstyle ng-binding" ng-show="BVResponse.personcontacted">{{ $case->person_met ?? 'NA' }} </td>
                <td>Relationship</td>
                <td class="BVstyle ng-binding" ng-show="BVResponse.personcontacted">{{ $case->person_met ?? 'NA' }} </td>
            </tr>
            <tr>
                <td>No of Residents in the House</td>
                <td class="BVstyle ng-binding" ng-show="BVResponse.websitenameofemployer">0000</td>
                <td>Years at current Residence</td>
                <td class="BVstyle ng-binding" ng-show="BVResponse.emailofemployer">0000</td>
            </tr>
            <tr>
                <td>No of Earning Family Members</td>
                <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.telephonenooffice">0000</td>
                <td>Residence Status</td>
                <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.extno">0000</td>
            </tr>
            <tr>
                <td>Name of Employer</td>
                <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.residenceno">{{ $case->telephone_no_residence ?? 'NA' }}</td>
                <td>Employer Address</td>
                <td class="BVstyle" ng-hide="BVResponse.mobileno">{{ $case->mobile ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Telephone No. Residence</td>
                <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.businessboard">0000</td>
                <td>Office</td>
                <td class="BVstyle ng-binding" ng-show="BVResponse.typeofemplyer">0000</td>
            </tr>
            <tr>
                <td>Designation</td>
                <td colspan="3" class="BVstyle ng-binding" ng-show="BVResponse.typeofindustry">0000</td>
            </tr>
            <tr>
                <td>Approx Rent</td>
                <td class="BVstyle ng-binding" ng-show="BVResponse.lineofbusiness">0000</td>
                <td>Approx Value(If Owned)</td>
                <td class="BVstyle ng-binding" ng-show="BVResponse.yearofestablishment">0000</td>
            </tr>
            <tr>
                <td>Bank Name</td>
                <td class="BVstyle ng-binding" ng-show="BVResponse.businessactivity">0000</td>
                <td>Branch</td>
                <td class="BVstyle ng-binding" ng-show="BVResponse.numberofemployees">0000</td>
            </tr>
            <tr>
                <td>Permanent Address/Phone</td>
                <td colspan="3" class="BVstyle ng-binding" ng-show="BVResponse.typeofindustry">0000</td>
            </tr>
            <tr>
                <td>Vehicles</td>
                <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.numberofbranches">0000 </td>
                <td>Make and Type</td>
                <td class="BVstyle ng-binding" ng-show="BVResponse.officelook">0000</td>
            </tr>
            <tr>
                <td colspan="4" class="subheading" style="text-align: center">Verifier's Observations</td>
            </tr>
            <tr>
                <td>Location </td>
                <td class="BVstyle ng-binding" ng-show="BVResponse.locality">0000 </td>
                <td>Locality</td>
                <td class="BVstyle ng-binding" ng-show="BVResponse.area">0000</td>
            </tr>
            <tr>
                <td>Accomodation Type</td>
                <td class="BVstyle ng-binding" ng-show="BVResponse.nearestlandmark">0000 </td>
                <td>Interior Conditions</td>
                <td class="BVstyle ng-binding" ng-show="BVResponse.easeoflocating">0000</td>
            </tr>
            <tr>
                <td>Assets Seen</td>
                <td colspan="3" class="BVstyle ng-binding ng-hide" ng-show="BVResponse.termofemployment"> 0000</td>

            </tr>
            <tr>
                <td>Area</td>
                <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.workingsinceyear">0000</td>
                <td>Standard of Living</td>
                <td>0000</td>
            </tr>

            <tr>
                <td>Nearest Landmark</td>
                <td colspan="3" class="BVstyle ng-binding" ng-show="BVResponse.nearestlandmark">0000 </td>
            </tr>
            <tr>
                <td colspan="4" class="subheading" style="text-align: center">If the house is locked,the following information needs to be obtained from the Neighbour/Third Party.</td>
            </tr>
            <tr>
                <td>Applicant Name</td>
                <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardapplicantage">{{ $case->applicant_age ?? '0' }}</td>
                <td>Person Met</td>
                <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardnameofemployer">{{ $case->applicaname_of_employernt_age ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>Relationship</td>
                <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardyearofestablishment">0000</td>
                <td>Applicant Age(Approx)</td>
                <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardapplicantdesignation">{{ $case->applicant_age ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>No. of Residents in House</td>
                <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardtelephonenooffice">0000</td>
                <td>Years Lived at this Residence</td>
                <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardextno">0000</td>
            </tr>
            <tr>
                <td>Occupation</td>
                <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardtypeofemplyer">0000</td>
            </tr>
            <tr>
                <td colspan="4" class="subheading" style="text-align: center">If the address is not confirmed then the following information needs to be filled.</td>
            </tr>
            <tr>
                <td>Untraceable</td>
                <td>Reason</td>
                <td colspan="2" class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardnumberofbranches">0000</td>
            </tr>
            <tr>
                <td></td>
                <td>Result of Calling</td>
                <td colspan="2" class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardnumberofbranches">0000</td>
            </tr>
            <tr>
                <td><b>Mismatch in Residence Address</b></td>
                <td>Is Applicant Known to the person</td>
                <td colspan="2" class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardnumberofbranches">0000</td>
            </tr>

            <tr>
                <td></td>
                <td>To Whom Does Address Belong ?</td>
                <td colspan="2" class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardnumberofbranches">0000</td>
            </tr>
            <tr ng-hide="BVCase.StatusID==217" class="">
                <td colspan="4" class="subheading" style="text-align: center">The following is based on Verifier Observations</td>
            </tr>
            <tr>
                <td>Verifier's Name</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Verification Conducted at</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Proof attached</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Type of Proof</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Date of Visit</td>
                <td></td>
                <td>Time of Visit</td>
                <td></td>
            </tr>

            <tr>
                <td colspan="4" class="subheading" style="text-align: center">Updations</td>
            </tr>
            <tr>
                <td>Address</td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td>Type of Proof</td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td>Type of Proof</td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td colspan="4" class="subheading" style="text-align: center">Supervisor Remarks</td>
            </tr>
            <tr>
                <td colspan="4">AS CLAIMED / CONFIRMED</td>
            </tr>
            <tr class="">
                <td colspan="4" class="subheading" style="text-align: center">NEGATIVE FEATURES</td>
            </tr>
            <tr class="ng-hide">
                <td colspan="4" class="ng-binding">Not Recommended - Outside geographical Limits</td>
            </tr>
            <tr class="">
                <td>Visit Conducted </td>
                <td colspan="3" class="ng-binding">0000</td>
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
                <td>Date of Visit</td>
                <td class="BVstyle ng-binding">0000</td>
                <td>Time of Visit</td>
                <td class="BVstyle ng-binding">0000</td>
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
                <td class="BVstyle ng-binding" ng-show="BVResponse.tcp1name">0000 </td>
                <td>Neighbour1 Checked With</td>
                <td class="BVstyle ng-binding" ng-show="BVResponse.tcp_1checkedwith">0000</td>
            </tr>
            <tr>
                <td>TCP1 Negative Comments</td>
                <td colspan="3">0000 </td>
            </tr>
            <tr>
                <td>Neighbour Check 2</td>
                <td class="BVstyle ng-binding" ng-show="BVResponse.tcp2name">0000 </td>
                <td>Neighbour2 Checked With</td>
                <td class="BVstyle ng-binding" ng-show="BVResponse.tcp_2checkedwith">0000</td>
            </tr>
            <tr>
                <td>TCP2 Negative Comments</td>
                <td colspan="3">0000 </td>
            </tr>

            <tr>
                <td>Visited By </td>
                <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.visitedby">0000</td>
                <td>Verified By </td>
                <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.verifiedby">0000</td>
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
        </tbody>
    </table>
    <br>
</div>