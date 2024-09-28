<form action="{{ route('admin.case.telecaller.submit',$case->id) }}" method="POST">
    @csrf
    <div class="container">
        <!-- Application Ref. Number -->
        <div class="form-group">
            <label for="appRefNo">Application Ref. Number:</label>
            <input type="text" id="appRefNo" name="refrence_number" class="form-control" value="{{ old('refrence_number', $case->getCase->refrence_number ?? '') }}">
        </div>

        <!-- Name of Applicant -->
        <div class="form-group">
            <label for="nameOfApplicant">Name of Applicant:</label>
            <input type="text" id="nameOfApplicant" name="applicant_name" class="form-control" value="{{ old('applicant_name', $case->getCase->applicant_name ?? '') }}">
        </div>

        <!-- Type of Verification (Checkboxes) -->
        <div class="form-group">
            <label for="typeOfVerification">Type of Verification:</label>
            <div class="form-check">
                <input type="checkbox" id="businessPhone" name="typeOfVerification[]" value="Business Phone" class="form-check-input" {{ old('typeOfVerification.0') ? 'checked' : '' }}>
                <label class="form-check-label" for="businessPhone">Business Phone</label>
            </div>
            <div class="form-check">
                <input type="checkbox" id="residencePhone" name="typeOfVerification[]" value="Residence Phone" class="form-check-input" {{ old('typeOfVerification.1') ? 'checked' : '' }}>
                <label class="form-check-label" for="residencePhone">Residence Phone</label>
            </div>
        </div>

        <!-- Address of Applicant -->
        <div class="form-group">
            <label for="address">Address of Applicant:</label>
            <textarea id="address" name="address" class="form-control">{{ old('address', $case->address ?? '') }}</textarea>
        </div>

        <!-- Contact Telephone No. -->
        <div class="form-group">
            <label for="telephone">Contact Telephone No.:</label>
            <input type="text" id="telephone" name="mobile" class="form-control" value="{{ old('mobile', $case->mobile ?? '') }}">
        </div>

        <!-- Person Spoken to -->
        <div class="form-group">
            <label for="personSpokenTo">Person Spoken to:</label>
            <input type="text" id="personSpokenTo" name="person_met" class="form-control" value="{{ old('person_met', $case->person_met ?? '') }}" >
        </div>

        <!-- Relationship with Applicant -->
        <div class="form-group">
            <label for="relation">Relationship with Applicant:</label>
            <input type="text" id="relation" name="relationship" class="form-control" value="{{ old('relationship', $case->relationship ?? '') }}">
        </div>

        <!-- Employer's Name and Address -->
        <div class="form-group">
            <label for="employerDetails">Employer's Name and Address:</label>
            <textarea id="employerDetails" name="employerDetails" class="form-control"></textarea>
        </div>

        <!-- Designation of the Applicant -->
        <div class="form-group">
            <label for="designation">Designation of the Applicant:</label>
            <input type="text" id="designation" name="designation" class="form-control" value="{{ old('designation', $case->designation ?? '') }}">
        </div>

        <!-- Nature of Business/Company -->
        <div class="form-group">
            <label for="natureOfBusiness">Nature of Business/Company:</label>
            <input type="text" id="natureOfBusiness" name="natureOfBusiness" class="form-control">
        </div>

        <!-- No. of Years at Present Employment -->
        <div class="form-group">
            <label for="yearsAtEmployment">No. of Years at Present Employment:</label>
            <input type="number" id="yearsAtEmployment" name="yearsAtEmployment" class="form-control">
        </div>

        <!-- Residence Address -->
        <div class="form-group">
            <label for="residenceAddress">Residence Address:</label>
            <textarea id="residenceAddress" name="residenceAddress" class="form-control"></textarea>
        </div>

        <!-- Applicant's Date of Birth/Approx Age -->
        <div class="form-group">
            <label for="age">Applicant's Date of Birth/Approx Age:</label>
            <input type="text" id="age" name="applicant_age" class="form-control" value="{{ old('applicant_age', $case->applicant_age ?? '') }}">
        </div>

        <!-- Name of Applicant Confirmed (Radio buttons) -->
        <div class="form-group">
            <label for="nameConfirmed">Name of Applicant Confirmed:</label>
            <div class="form-check">
                <input type="radio" id="confirmedYes" name="nameConfirmed" value="Yes" class="form-check-input">
                <label class="form-check-label" for="confirmedYes">Yes</label>
            </div>
            <div class="form-check">
                <input type="radio" id="confirmedNo" name="nameConfirmed" value="No" class="form-check-input">
                <label class="form-check-label" for="confirmedNo">No</label>
            </div>
        </div>

        <!-- Mismatch In (Checkboxes) -->
        <div class="form-group">
            <label for="mismatch">Mismatch In:</label>
            <div class="form-check">
                <input type="checkbox" id="mismatchEmployerName" name="mismatch[]" value="Employer Name" class="form-check-input">
                <label class="form-check-label" for="mismatchEmployerName">Employer Name</label>
            </div>
            <div class="form-check">
                <input type="checkbox" id="mismatchResidenceAddress" name="mismatch[]" value="Residence Address" class="form-check-input">
                <label class="form-check-label" for="mismatchResidenceAddress">Residence Address</label>
            </div>
            <div class="form-check">
                <input type="checkbox" id="mismatchOfficeAddress" name="mismatch[]" value="Office Address" class="form-check-input">
                <label class="form-check-label" for="mismatchOfficeAddress">Office Address</label>
            </div>
        </div>

        <!-- Remarks -->
        <div class="form-group">
            <label for="remarks">Remarks:</label>
            <textarea id="remarks" name="remarks" class="form-control">{{ old('remarks',$case->remarks ?? '') }}</textarea>
        </div>

        <!-- Proprietor Recommendation (Radio buttons) -->
        <div class="form-group">
            <label for="proprietorRecommendation">Proprietor Recommendation:</label>
            <div class="form-check">
                <input type="radio" id="recommendationPositive" name="proprietorRecommendation" value="Positive" class="form-check-input">
                <label class="form-check-label" for="recommendationPositive">Positive</label>
            </div>
            <div class="form-check">
                <input type="radio" id="recommendationNegative" name="proprietorRecommendation" value="Negative" class="form-check-input">
                <label class="form-check-label" for="recommendationNegative">Negative</label>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
