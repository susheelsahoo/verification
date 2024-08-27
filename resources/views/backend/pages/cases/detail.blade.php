<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <table class="table table-bordered">
        <tbody><tr>
            <td colspan="4" align="right" height="30px;">
                <a href="javascript:Print()">Click here to print</a>
            </td>
        </tr>

        <tr>
            <td style="border:none;font-size:22px;color:#0094ff" align="center" colspan="1">
                <img alt="State Bank of India" src="../../Includes/img/sbi.jpg">
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
            <td colspan="3" class="BVstyle ng-binding">SINNAR nasik</td>
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
                Employment(Salaried)/ Business(Self-Employed) Verification Report<br>
                (Strictly Private &amp; Confidential)
            </td>
        </tr>
        <tr>
            <td>Address Confirmed </td>
            <td colspan="3" class="BVstyle ng-binding" ng-show="BVResponse.addressconfirmed">{{ $case->address_confirmed ?? 'NO' }} &nbsp; </td>
        </tr>
        <tr>
            <td>Office/Business Address</td>
            <td colspan="3" class="BVstyle ng-binding">{{ $case->employer_address ?? '' }}  &nbsp; </td>
        </tr>
        <tr>
            <td>Type of Proof</td>
            <td colspan="3" class="BVstyle ng-binding" ng-show="BVResponse.typeofproof">{{ $case->type_of_proof ?? 'NA' }}</td>
        </tr>
        <tr>
            <td>Address Confirmed By</td>
            <td colspan="3" class="BVstyle ng-binding ng-hide" ng-show="BVResponse.addressconfirmedby">{{ $case->address_confirmed_by ?? 'NA' }} </td>
        </tr>
        <tr>
            <td colspan="4" class="subheading" style="text-align: center">The following information should be obtained if the applicant/colleagues are contacted in the office  </td>
        </tr>
        <tr>
            <td>Name of Employer/Co</td>
            <td class="BVstyle ng-binding" ng-show="BVResponse.nameofemployer">{{ $case->name_of_employer ?? 'NA' }} </td>
            <td>Person Met</td>
            <td class="BVstyle ng-binding" ng-show="BVResponse.personcontacted">{{ $case->person_met ?? 'NA' }} </td>
        </tr>
        <tr>
            <td>Address of Employer/Co</td>
            <td colspan="3" class="BVstyle ng-binding" ng-show="BVResponse.addressofemployer">{{ $case->employer_address ?? 'NA' }}</td>
        </tr>
        <tr>
            <td>Website of Employer/Co(if available)</td>
            <td class="BVstyle ng-binding" ng-show="BVResponse.websitenameofemployer">NA</td>
            <td>e-mail address of Employer/Co(if available)</td>
            <td class="BVstyle ng-binding" ng-show="BVResponse.emailofemployer">NA</td>
        </tr>
        <tr>
            <td>Telephone Number Office</td>
            <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.telephonenooffice">0</td>
            <td>EXT</td>
            <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.extno">0</td>
        </tr>
        <tr>
            <td>Telephone Number Residence</td>
            <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.residenceno">{{ $case->telephone_no_residence ?? 'NA' }}</td>
            <td>Mobile Number</td>
            <td class="BVstyle" ng-hide="BVResponse.mobileno">{{ $case->mobile ?? 'NA' }}</td>
        </tr>
        <tr>
            <td>Co. Board Outside Bldg/Office</td>
            <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.businessboard"></td>
            <td>Type of Employer/Co</td>
            <td class="BVstyle ng-binding" ng-show="BVResponse.typeofemplyer">Government</td>
        </tr>
        <tr>
            <td>Nature of Business</td>
            <td colspan="3" class="BVstyle ng-binding" ng-show="BVResponse.typeofindustry">Professional</td>
        </tr>
        <tr>
            <td>Line of Business (for self-emplyed)</td>
            <td class="BVstyle ng-binding" ng-show="BVResponse.lineofbusiness">na</td>
            <td>Year of Establishment</td>
            <td class="BVstyle ng-binding" ng-show="BVResponse.yearofestablishment">3</td>
        </tr>
        <tr>
            <td>Level of Business activity(for self-employed)</td>
            <td class="BVstyle ng-binding" ng-show="BVResponse.businessactivity">Normal</td>
            <td>No. of Employees</td>
            <td class="BVstyle ng-binding" ng-show="BVResponse.numberofemployees">10-20</td>
        </tr>
        <tr>
            <td>No of Branches/Offices</td>
            <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.numberofbranches">0 </td>
            <td>Office ambience/look</td>
            <td class="BVstyle ng-binding" ng-show="BVResponse.officelook">Good</td>
        </tr>
        <tr>
            <td>Type of Locality </td>
            <td class="BVstyle ng-binding" ng-show="BVResponse.locality">Commercial </td>
            <td>Area</td>
            <td class="BVstyle ng-binding" ng-show="BVResponse.area">200  Yards</td>
        </tr>
        <tr>
            <td>Nearest Landmark</td>
            <td class="BVstyle ng-binding" ng-show="BVResponse.nearestlandmark">deopur  </td>
            <td>Ease of Locating</td>
            <td class="BVstyle ng-binding" ng-show="BVResponse.easeoflocating">Easy</td>
        </tr>
        <tr>
            <td>Terms of employment(for employees)</td>
            <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.termofemployment"> </td>
            <td>Grade</td>
            <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.grade"></td>
        </tr>
        <tr>
            <td>Years of current employment</td>
            <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.workingsinceyear"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="4" class="subheading" style="text-align: center">If applicant is not giving information, the following information needs to be obtained from the Colleague/Guard/Neighbour  </td>
        </tr>
        <tr>
            <td>Applicant Age(Approx)</td>
            <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardapplicantage">{{ $case->applicant_age ?? '0' }}</td>
            <td>Name of Employer/Co</td>
            <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardnameofemployer">{{ $case->applicaname_of_employernt_age ?? 'NA' }}</td>
        </tr>
        <tr>
            <td>Co/Established in(Year)</td>
            <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardyearofestablishment"></td>
            <td>Designation</td>
            <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardapplicantdesignation">{{ $case->designation ?? 'NA' }}</td>
        </tr>
        <tr>
            <td>Telephono No. Office</td>
            <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardtelephonenooffice"></td>
            <td>Ext.</td>
            <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardextno"></td>
        </tr>
        <tr>
            <td>Type of Co/Employer</td>
            <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardtypeofemplyer"></td>
            <td>Nature of Co/Employer</td>
            <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardbusinessnature"></td>
        </tr>
        <tr>
            <td>No of Employees</td>
            <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardnumberofemployees"></td>
            <td>No. of Branches</td>
            <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardnumberofbranches"></td>
        </tr>
        <tr>
            <td>Area</td>
            <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardarea">{{ $case->area ?? 'NA' }}</td>
            <td>Nearest Landmark</td>
            <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardnearestlandmark">{{ $case->nearest_landmark ?? 'NA' }}</td>
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

        <tr ng-hide="BVCase.VerifiedType==219 || BVCase.SubStatusId!=536" ng-show="BVCase.VerifiedType==218" class="">
            <td colspan="4" class="subheading" style="text-align: center">AS CLAIMED / CONFIRMED</td>
        </tr>
        <tr ng-hide="BVCase.VerifiedType==219 || BVCase.SubStatusId!=536" ng-show="BVCase.VerifiedType==218" class="">
            <td colspan="4" class="ng-binding">Recommended - Recommended</td>
        </tr>

        <tr ng-hide="BVCase.VerifiedType==218 || BVCase.SubStatusId==536" ng-show="BVCase.VerifiedType==219" class="ng-hide">
            <td colspan="4" class="subheading" style="text-align: center">NEGATIVE FEATURES</td>
        </tr>
        <tr ng-hide="BVCase.VerifiedType==218 || BVCase.SubStatusId==536" ng-show="BVCase.VerifiedType==219" class="ng-hide">
            <td colspan="4" class="ng-binding">Not Recommended - Recommended</td>
        </tr>
        <tr ng-hide="BVCase.StatusID==220" class="">
            <td>Visit Conducted </td>
            <td colspan="3" class="ng-binding">Positive</td>
        </tr>
        <tr>
            <td colspan="4" class="subheading" style="text-align: center">Applicant Photos</td>
        </tr>
        <tr>
            <td colspan="4">
                <!-- ngRepeat: img in bv_applicant_photos -->
                <ul data-ng-repeat="img in bv_applicant_photos" style="list-style-type: none; margin-bottom: 0;" class="ng-scope">
                    <li style="display: inline; float: left; margin-left: 5px;">
                        <img alt="" src="http://verification.mobileforce.in/Data/CaseImages/2315248/1724536824000.jpg" class="imageDetail">
                    </li>
                </ul><!-- end ngRepeat: img in bv_applicant_photos -->
                <ul data-ng-repeat="img in bv_applicant_photos" style="list-style-type: none; margin-bottom: 0;" class="ng-scope">
                    <li style="display: inline; float: left; margin-left: 5px;">
                        <img alt="" src="http://verification.mobileforce.in/Data/CaseImages/2315248/1724536823000.jpg" class="imageDetail">
                    </li>
                </ul><!-- end ngRepeat: img in bv_applicant_photos -->
                <ul data-ng-repeat="img in bv_applicant_photos" style="list-style-type: none; margin-bottom: 0;" class="ng-scope">
                    <li style="display: inline; float: left; margin-left: 5px;">
                        <img alt="" src="http://verification.mobileforce.in/Data/CaseImages/2315248/1724536822000.jpg" class="imageDetail">
                    </li>
                </ul><!-- end ngRepeat: img in bv_applicant_photos -->
            </td>
        </tr>
        <tr>
            <td>VisitDate</td>
            <td class="BVstyle ng-binding">25-Aug-2024</td>
            <td>VisitTime</td>
            <td class="BVstyle ng-binding">03:33:30 AM</td>
        </tr>
        <tr>
            <td colspan="4" class="subheading" style="text-align: center">Location</td>
        </tr>
        <tr>
            <td>Latitude</td>
            <td class="BVstyle ng-binding">19.86534881591797</td>
            <td>Longitude</td>
            <td class="BVstyle ng-binding">74.15201568603516</td>
        </tr>
        <tr>
            <td colspan="4">
                <iframe id="BV_Map" ng-src="https://maps.google.com/maps?q=19.86534881591797,74.15201568603516&amp;hl=es;z=14&amp;output=embed" width="800" height="400" frameborder="0" style="border: 0" src="https://maps.google.com/maps?q=19.86534881591797,74.15201568603516&amp;hl=es;z=14&amp;output=embed"></iframe>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="subheading" style="text-align: center">Third Party Check</td>
        </tr>
        <tr>
            <td>TPC 1 Name</td>
            <td class="BVstyle ng-binding" ng-show="BVResponse.tcp1name">ravindra khule </td>
            <td>TPC 1 (Checked with)</td>
            <td class="BVstyle ng-binding" ng-show="BVResponse.tcp_1checkedwith">Positive</td>
        </tr>
        <tr>
            <td>TPC 2 Name</td>
            <td class="BVstyle ng-binding" ng-show="BVResponse.tcp2name">kiran awari </td>
            <td>TPC 2 (Checked with)</td>
            <td class="BVstyle ng-binding" ng-show="BVResponse.tcp_2checkedwith">Positive</td>
        </tr>
    <tr data-ng-show="ShowBV_CustSign" class="">
        <td>Customer Signature</td>
        <td colspan="2">
            <img src="http://verification.mobileforce.in/Data/CaseImages/2315248/sign_10857_1724536951040.png" data-ng-show="ShowBV_CustSign" height="50" width="100" class="">
        </td>
        <td></td>
    </tr>
    <tr>
        <td>Visited By </td>
        <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.visitedby"></td>
        <td>Verified By </td>
        <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.verifiedby"></td>
    </tr>
        <tr>
            <td colspan="2" style="text-align:center">
                <img src="http://verification.mobileforce.in/Data/CaseLogos/" height="100" width="200">
                <br>
                Signature of Agency Supervisor (With agency Seal)
            </td>
            <td colspan="2" style="text-align:center">
                <img src="http://verification.mobileforce.in/Data/CaseLogos/" height="100" width="200">
                <br>
                Audit Check Remarks by Agency With Stamp &amp; Sign
            </td>
        </tr>
    </tbody></table>
    <br>
</div>
