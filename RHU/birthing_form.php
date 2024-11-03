<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinical Cover Sheet</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .col {
            flex: 1;
            padding: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        input[type="time"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            resize: vertical;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>CLINICAL COVER SHEET</h1>
        <form>
            <div class="row">
                <div class="col">
                    <small> Last Name:</small>
                    <input type="text" id="lastName" name="lastName" placeholder="Last Name">
                </div>
                <div class="col"> <small> First Name:</small>
                    <input type="text" id="firstName" name="firstName" placeholder="First Name">
                </div>
                <div class="col"> <small>Middle Name:</small>
                    <input type="text" id="middleName" name="middleName" placeholder="Middle Name">
                </div>
                <div class="col"> <small> Name Ext.:</small>
                    <input type="text" id="nameExt" name="nameExt" placeholder="Name Ext.">
                </div>

                <div class="col">
                    <small> Case No.:</small>
                    <input type="text" id="caseNo" name="caseNo">

                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="permanentAddress">Permanent Address:</label>
                    <input type="text" id="permanentAddress" name="permanentAddress">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob">
                </div>
                <div class="col">
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age">
                </div>
                <div class="col">
                    <label for="sex">Sex:</label>
                    <input type="text" id="sex" name="sex">
                </div>
                <div class="col">
                    <label for="placeOfBirth">Place of Birth:</label>
                    <input type="text" id="placeOfBirth" name="placeOfBirth">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="nationality">Nationality:</label>
                    <input type="text" id="nationality" name="nationality">
                </div>
                <div class="col">
                    <label for="occupation">Occupation:</label>
                    <input type="text" id="occupation" name="occupation">
                </div>
                <div class="col">
                    <label for="civilStatus">Civil Status:</label>
                    <select id="civilStatus" name="civilStatus">
                        <option value="single">Single</option>
                        <option value="married">Married</option>
                        <option value="separated">Separated</option>
                        <option value="widow">Widow</option>
                    </select>
                </div>
                <div class="col">
                    <label for="religion">Religion:</label>
                    <input type="text" id="religion" name="religion">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="employer">Employer:</label>
                    <input type="text" id="employer" name="employer">
                </div>
                <div class="col">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="fatherName">Name of Father / Guardian:</label>
                    <input type="text" id="fatherName" name="fatherName">
                </div>
                <div class="col">
                    <label for="fatherAddress">Address:</label>
                    <input type="text" id="fatherAddress" name="fatherAddress">
                </div>
                <div class="col">
                    <label for="fatherContact">Telephone/Cell No.:</label>
                    <input type="text" id="fatherContact" name="fatherContact">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="motherName">Name of Mother (Maiden Name):</label>
                    <input type="text" id="motherName" name="motherName">
                </div>
                <div class="col">
                    <label for="motherAddress">Address:</label>
                    <input type="text" id="motherAddress" name="motherAddress">
                </div>
                <div class="col">
                    <label for="motherContact">Telephone/Cell No.:</label>
                    <input type="text" id="motherContact" name="motherContact">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="admissionDate">Admission Date:</label>
                    <input type="date" id="admissionDate" name="admissionDate">
                </div>
                <div class="col">
                    <label for="admissionTime">Time:</label>
                    <input type="time" id="admissionTime" name="admissionTime">
                </div>
                <div class="col">
                    <label for="dischargeDate">Discharge Date:</label>
                    <input type="date" id="dischargeDate" name="dischargeDate">
                </div>
                <div class="col">
                    <label for="dischargeTime">Time:</label>
                    <input type="time" id="dischargeTime" name="dischargeTime">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="typeOfAdmission">Type of Admission:</label>
                    <select id="typeOfAdmission" name="typeOfAdmission">
                        <option value="new">New</option>
                        <option value="old">Old</option>
                    </select>
                </div>
                <div class="col">
                    <label for="philHealthNo">PhilHealth No.:</label>
                    <input type="text" id="philHealthNo" name="philHealthNo">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="membership">Membership:</label>
                    <select id="membership" name="membership">
                        <option value="member">Member</option>
                        <option value="dependent">Dependent</option>
                        <option value="none">None Member</option>
                    </select>
                </div>
                <div class="col">
                    <label for="membershipCategory">Membership Category:</label>
                    <select id="membershipCategory" name="membershipCategory">
                        <option value="nhts">NHTS</option>
                        <option value="4ps">4PS</option>
                        <option value="lgu">LGU</option>
                        <option value="private">Private</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="referredBy">Referred By:</label>
                    <input type="text" id="referredBy" name="referredBy">
                </div>
                <div class="col">
                    <label for="admittingMidwife">Admitting Midwife/Nurse:</label>
                    <input type="text" id="admittingMidwife" name="admittingMidwife">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="admittingDiagnosis">Admitting Diagnosis:</label>
                    <textarea id="admittingDiagnosis" name="admittingDiagnosis"></textarea>
                </div>
                <div class="col">
                    <label for="finalDiagnosis">Final Diagnosis:</label>
                    <textarea id="finalDiagnosis" name="finalDiagnosis"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="procedureDone">Procedure Done:</label>
                    <textarea id="procedureDone" name="procedureDone"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="disposition">Disposition:</label>
                    <select id="disposition" name="disposition">
                        <option value="discharged">Discharged</option>
                        <option value="improved">Improved</option>
                        <option value="unimproved">Unimproved</option>
                        <option value="transferred">Transferred</option>
                        <option value="hama">HAMA</option>
                        <option value="died">Died</option>
                        <option value="absconded">Absconded</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <button type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>