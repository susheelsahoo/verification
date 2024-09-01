<style>
    .error{
        color: red;
    }
</style>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <form  action="{{ route('admin.case.modifyCase.viewCase', $case->id) }}" method="POST">
    @csrf
        <input type="hidden" name="case_fy_id" value="{{ $case->id }}" />
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td style="border:none;font-size:22px;color:#0094ff" align="center" colspan="1">
                        <img alt="State Bank of India" src="{{ asset('images/sbi.jpg') }}">
                    </td>
                    <td class="address_text" align="center" colspan="3"> CORE DOC2INFO SERVICES</td>
                </tr>

                <tr>
                    <td>Reference No.</td>
                    <td class="BVstyle ng-binding"><input type="text" name="refrence_number" class="form-control" value="{{ $case->getCase->refrence_number ?? '' }}" /></td>
                    <td>Customer Name</td>
                    <td class="BVstyle ng-binding"><input type="text" name="applicant_name" class="form-control" value="{{ $case->getCase->applicant_name ?? '' }}" /></td>
                </tr>
                <tr>
                    <td>Case Creation Login Details</td>
                    <td colspan="3" class="BVstyle ng-binding">0000</td>
                </tr>
                <tr>
                    <td>Product Name</td>
                    <td class="BVstyle ng-binding">
                        <select id="productSelect" name="product_id" class="custom-select">
                            <option value="">--Select Option--</option>
                            @if($AvailbleProduct)
                                @foreach ($AvailbleProduct as $product)
                                    <option value="{{ $product->id }}" @if($case->getCase->getProduct->id == $product->id) selected @endif >{{ $product->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </td>
                    <td>Loan Amount</td>
                    <td class="BVstyle ng-binding" ng-show="BVCase.LoanAmount"><input type="text" name="amount" class="form-control" value="{{ $case->getCase->amount ?? 'NA' }}" /></td>
                </tr>
                <tr>
                    <td>Contact No.</td>
                    <td colspan="3" class="BVstyle ng-binding"><input type="text" name="mobile" class="form-control" value="{{ $case->mobile ?? '' }}" /></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td colspan="3" class="BVstyle ng-binding"><input type="text" name="address" class="form-control" value="{{ $case->address ?? '' }}"/></td>
                </tr>
                <tr>
                    <td colspan="4" class="subheading" style="text-align: center">
                        Employment(Salaried)/ Business(Self-Employed) Verification Report<br>
                        (Strictly Private &amp; Confidential)
                    </td>
                </tr>
                <tr>
                    <td>Address Confirmed </td>
                    <td colspan="3" class="BVstyle ng-binding" ng-show="BVResponse.addressconfirmed"><input type="text" name="address_confirmed" class="form-control" value="{{ $case->address_confirmed ?? 'NO' }}" /> &nbsp; </td>
                </tr>
                <tr>
                    <td>Office/Business Address</td>
                    <td colspan="3" class="BVstyle ng-binding"><input type="text" name="employer_address" class="form-control" value="{{ $case->employer_address ?? '' }}" /> &nbsp; </td>
                </tr>
                <tr>
                    <td>Type of Proof</td>
                    <td colspan="3" class="BVstyle ng-binding" ng-show="BVResponse.typeofproof"><input type="text" name="type_of_proof" class="form-control" value=" {{ $case->type_of_proof ?? 'NA' }}"/> </td>
                </tr>
                <tr>
                    <td>Address Confirmed By</td>
                    <td colspan="3" class="BVstyle ng-binding ng-hide" ng-show="BVResponse.addressconfirmedby"><input type="text" name="address_confirmed_by" class="form-control" value=" {{ $case->address_confirmed_by ?? 'NA' }}"/> </td>
                </tr>
                <tr>
                    <td colspan="4" class="subheading" style="text-align: center">The following information should be obtained if the applicant/colleagues are contacted in the office </td>
                </tr>
                <tr>
                    <td>Name of Employer/Co</td>
                    <td class="BVstyle ng-binding" ng-show="BVResponse.nameofemployer"><input type="text" name="name_of_employer" class="form-control" value="{{ $case->name_of_employer ?? 'NA' }}" /> </td>
                    <td>Person Met</td>
                    <td class="BVstyle ng-binding" ng-show="BVResponse.personcontacted"><input type="text" name="person_met" class="form-control" value="{{ $case->person_met ?? 'NA' }}" /> </td>
                </tr>
                <tr>
                    <td>Address of Employer/Co</td>
                    <td colspan="3" class="BVstyle ng-binding" ng-show="BVResponse.addressofemployer"><input type="text" name="employer_address" class="form-control" value="{{ $case->employer_address ?? 'NA' }}"/></td>
                </tr>
                <tr>
                    <td>Website of Employer/Co(if available)</td>
                    <td class="BVstyle ng-binding" ng-show="BVResponse.websitenameofemployer">0000</td>
                    <td>e-mail address of Employer/Co(if available)</td>
                    <td class="BVstyle ng-binding" ng-show="BVResponse.emailofemployer">0000</td>
                </tr>
                <tr>
                    <td>Telephone Number Office</td>
                    <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.telephonenooffice">0000</td>
                    <td>EXT</td>
                    <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.extno">0000</td>
                </tr>
                <tr>
                    <td>Telephone Number Residence</td>
                    <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.residenceno"><input type="text" name="telephone_no_residence" class="form-control" value="{{ $case->telephone_no_residence ?? 'NA' }}"  /> </td>
                    <td>Mobile Number</td>
                    <td class="BVstyle" ng-hide="BVResponse.mobileno"><input type="text" name="mobile" class="form-control" value="{{ $case->mobile ?? 'NA' }}"/></td>
                </tr>
                <tr>
                    <td>Co. Board Outside Bldg/Office</td>
                    <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.businessboard">0000</td>
                    <td>Type of Employer/Co</td>
                    <td class="BVstyle ng-binding" ng-show="BVResponse.typeofemplyer">0000</td>
                </tr>
                <tr>
                    <td>Nature of Business</td>
                    <td colspan="3" class="BVstyle ng-binding" ng-show="BVResponse.typeofindustry">0000</td>
                </tr>
                <tr>
                    <td>Line of Business (for self-emplyed)</td>
                    <td class="BVstyle ng-binding" ng-show="BVResponse.lineofbusiness">0000</td>
                    <td>Year of Establishment</td>
                    <td class="BVstyle ng-binding" ng-show="BVResponse.yearofestablishment">0000</td>
                </tr>
                <tr>
                    <td>Level of Business activity(for self-employed)</td>
                    <td class="BVstyle ng-binding" ng-show="BVResponse.businessactivity">0000</td>
                    <td>No. of Employees</td>
                    <td class="BVstyle ng-binding" ng-show="BVResponse.numberofemployees">0000</td>
                </tr>
                <tr>
                    <td>No of Branches/Offices</td>
                    <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.numberofbranches">0000 </td>
                    <td>Office ambience/look</td>
                    <td class="BVstyle ng-binding" ng-show="BVResponse.officelook">0000</td>
                </tr>
                <tr>
                    <td>Type of Locality </td>
                    <td class="BVstyle ng-binding" ng-show="BVResponse.locality">0000 </td>
                    <td>Area</td>
                    <td class="BVstyle ng-binding" ng-show="BVResponse.area">0000</td>
                </tr>
                <tr>
                    <td>Nearest Landmark</td>
                    <td class="BVstyle ng-binding" ng-show="BVResponse.nearestlandmark">0000 </td>
                    <td>Ease of Locating</td>
                    <td class="BVstyle ng-binding" ng-show="BVResponse.easeoflocating">0000</td>
                </tr>
                <tr>
                    <td>Terms of employment(for employees)</td>
                    <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.termofemployment"> 0000</td>
                    <td>Grade</td>
                    <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.grade">0000</td>
                </tr>
                <tr>
                    <td>Years of current employment</td>
                    <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.workingsinceyear">0000</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4" class="subheading" style="text-align: center">If applicant is not giving information, the following information needs to be obtained from the Colleague/Guard/Neighbour </td>
                </tr>
                <tr>
                    <td>Applicant Age(Approx)</td>
                    <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardapplicantage"><input type="text" name="applicant_age" class="form-control" value="{{ $case->applicant_age ?? '0' }}"/></td>
                    <td>Name of Employer/Co</td>
                    <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardnameofemployer">{{ $case->applicaname_of_employernt_age ?? 'NA' }}</td>
                </tr>
                <tr>
                    <td>Co/Established in(Year)</td>
                    <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardyearofestablishment">0000</td>
                    <td>Designation</td>
                    <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardapplicantdesignation"><input type="text" name="designation" class="form-control" value="{{ $case->designation ?? 'NA' }}"/></td>
                </tr>
                <tr>
                    <td>Telephono No. Office</td>
                    <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardtelephonenooffice">0000</td>
                    <td>Ext.</td>
                    <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardextno">0000</td>
                </tr>
                <tr>
                    <td>Type of Co/Employer</td>
                    <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardtypeofemplyer">0000</td>
                    <td>Nature of Co/Employer</td>
                    <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardbusinessnature">0000</td>
                </tr>
                <tr>
                    <td>No of Employees</td>
                    <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardnumberofemployees">0000</td>
                    <td>No. of Branches</td>
                    <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardnumberofbranches">0000</td>
                </tr>
                <tr>
                    <td>Area</td>
                    <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardarea"><input type="text" name="area" class="form-control" value="{{ $case->area ?? 'NA' }}"/></td>
                    <td>Nearest Landmark</td>
                    <td class="BVstyle ng-binding ng-hide" ng-show="BVResponse.guardnearestlandmark"><input type="text" name="nearest_landmark" class="form-control" value="{{ $case->nearest_landmark ?? 'NA' }}"/></td>
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
                    <td>VisitDate</td>
                    <td class="BVstyle ng-binding">0000</td>
                    <td>VisitTime</td>
                    <td class="BVstyle ng-binding">0000</td>
                </tr>
                <tr>
                    <td colspan="4" class="subheading" style="text-align: center">Location</td>
                </tr>
                <tr>
                    <td>Latitude</td>
                    <td class="BVstyle ng-binding"><input type="text" name="latitude" class="form-control" value="{{ $case->latitude ?? 'NA' }}"/></td>
                    <td>Longitude</td>
                    <td class="BVstyle ng-binding"><input type="text" name="longitude" class="form-control" value="{{ $case->longitude ?? 'NA' }}"/></td>
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
                    <td colspan="4" class="subheading" style="text-align: center">Third Party Check</td>
                </tr>
                <tr>
                    <td>TPC 1 Name</td>
                    <td class="BVstyle ng-binding" ng-show="BVResponse.tcp1name">0000 </td>
                    <td>TPC 1 (Checked with)</td>
                    <td class="BVstyle ng-binding" ng-show="BVResponse.tcp_1checkedwith">0000</td>
                </tr>
                <tr>
                    <td>TPC 2 Name</td>
                    <td class="BVstyle ng-binding" ng-show="BVResponse.tcp2name">0000 </td>
                    <td>TPC 2 (Checked with)</td>
                    <td class="BVstyle ng-binding" ng-show="BVResponse.tcp_2checkedwith">0000</td>
                </tr>
                <tr data-ng-show="ShowBV_CustSign" class="">
                    <td>Customer Signature</td>
                    <td colspan="2">
                        <!-- <img src="http://verification.mobileforce.in/Data/CaseImages/2315248/sign_10857_1724536951040.png" data-ng-show="ShowBV_CustSign" height="50" width="100" class=""> -->
                    </td>
                    <td></td>
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

    $(document).ready(function(){

        $('.updateBtn').click(function(e){
            e.preventDefault();
            var form = $(this).closest('form');
            form.validate({  // initialize the validator
                rules: {
                    case_fy_id: { required: true},
                    refrence_number : { required: true},
                    applicant_name  : { required: true},
                    product_id  : { required: true},
                    amount:  { required: true},
                    mobile : { required: true},
                    address :   { required: true},
                    address_confirmed :  { required: true},
                    address_confirmed_by :  { required: true},
                    type_of_proof :  { required: true},
                    name_of_employer :    { required: true},
                    person_met : { required: true},
                    telephone_no_residence : { required: true},
                    applicant_age :  { required: true},
                    designation :  { required: true},
                    area :    { required: true},
                    nearest_landmark : { required: true},
                    latitude :{ required: true},
                    longitude :  { required: true},
                }
            });
            let formData = form.serializeArray();
            let rowId =  form.find('input[name="case_fy_id"]').val();
            let actionPath = "{{ route('admin.case.modifyCase.viewCase','ID')}}";
            actionPath = actionPath.replace('ID', rowId);
            $.ajax({
                url: actionPath,
                type: 'POST',
                data : formData,
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

