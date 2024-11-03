<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Form</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <link rel="stylesheet" href="path/to/jquery-ui.css">
    <link rel="stylesheet" href="path/to/jquery.datetimepicker.css">
    <script src="path/to/jquery.js"></script>
    <script src="path/to/jquery.validate.js"></script>
    <script src="path/to/jquery.datetimepicker.full.js"></script>
</head>
<body>
<form method="post" id="patient_form">

    <div class="row">
        <div class="col-lg-2 col-sm-2 col-12">
            <div class="mb-3">
                <label class="form-label" for="cnic">ITR No:</label>
                <input type="text" class="form-control form-control-sm rounded-0" id="cnic" value="<?php echo $cnic ?>" name="cnic" readonly />
            </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-12">
            <div class="mb-3">
                <label class="form-label" for="household_no">Family no:</label>
                <input type="number" class="form-control form-control-sm rounded-0" value="<?php echo $newFamilyNumber; ?>" min="0" id="household_no" name="household_no" readonly />
                <span class="badge bg-info">Current Family No.</span>
            </div>
        </div>
        <hr style="width: 57%;" />

        <div class="row">
            <div class="col-lg-3 col-sm-4 col-12">
                <div class="mb-3">
                    <label class="form-label" for="patient_name">First Name: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm rounded-0" value="<?php echo htmlspecialchars($patientName); ?>" id="patient_name" name="patient_name" />
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-12">
                <div class="mb-3">
                    <label class="form-label" for="middle_name">Middle Name</label>
                    <input type="text" class="form-control form-control-sm rounded-0" id="middle_name" name="middle_name" />
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-12">
                <div class="mb-3">
                    <label class="form-label" for="last_name">Last Name: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm rounded-0" value="<?php echo htmlspecialchars($last_name); ?>" id="last_name" name="last_name" />
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-12">
                <div class="mb-3">
                    <label class="form-label" for="suffix">Suffix</label>
                    <input type="text" class="form-control form-control-sm rounded-0" id="suffix" name="suffix" />
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-12">
                <div class="mb-3">
                    <label class="form-label" for="Purok">Purok: <span class="text-danger">*</span></label>
                    <textarea class="form-control form-control-sm rounded-0" id="Purok" name="Purok" cols="30" rows="1"><?php echo htmlspecialchars($Purok); ?></textarea>
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-12">
                <div class="mb-3">
                    <label class="form-label" for="address">Address: <span class="text-danger">*</span></label>
                    <select class="form-control form-control-sm rounded-0" id="address" name="address">
                        <?php echo getbrgy(); ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-12">
                <div class="mb-3">
                    <label class="form-label" for="Province">Province: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm rounded-0" value="<?php echo htmlspecialchars($Province); ?>" id="Province" name="Province" />
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-12">
                <div class="mb-3">
                    <label class="form-label" for="date_of_birth">Date of Birth: <span class="text-danger">*</span></label>
                    <div class="input-group date" id="date_of_birth" data-target-input="nearest">
                        <input type="text" class="form-control form-control-sm rounded-0 datetimepicker-input" value="<?php echo htmlspecialchars($date_of_birth); ?>" data-target="#date_of_birth" name="date_of_birth" data-toggle="datetimepicker" autocomplete="off" />
                        <div class="input-group-append" data-target="#date_of_birth" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-12">
                <div class="mb-3">
                    <label class="form-label" for="Age">Age</label>
                    <input type="text" min="0" max="999" class="form-control form-control-sm rounded-0" value="<?php echo htmlspecialchars($Age); ?>" id="Age" name="Age" readonly />
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-12">
                <div class="mb-1">
                    <label class="form-label" for="gender">Sex: <span class="text-danger">*</span></label>
                    <div class="form-group">
                        <div class="form-check">
                            <?php echo getGender(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-12">
                <div class="mb-1">
                    <label class="form-label" for="phone_number">Contact number: <span class="text-danger">*</span></label>
                    <input type="text" inputmode="text" class="form-control form-control-sm rounded-0" id="phone_number" value="<?php echo htmlspecialchars($phoneNumber); ?>" name="phone_number" value="+639" />
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-12">
                <div class="mb-1">
                    <label class="form-label" for="Status">Civis Status: <span class="text-danger">*</span></label>
                    <select class="form-control form-control-sm rounded-0" id="Status" name="Status">
                        <?php echo getstat(); ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-12">
                <div class="mb-1">
                    <label class="form-label" for="Blood">Blood Type: <span class="text-danger">*</span></label>
                    <select class="form-control form-control-sm rounded-0" id="Blood" name="Blood">
                        <?php echo getblood(); ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-12">
                <div class="mb-3">
                    <label class="form-label" for="m_name">Mother's Name: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm rounded-0" value="<?php echo htmlspecialchars($m_name); ?>" id="m_name" name="m_name" />
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-12">
                <div class="mb-3">
                    <label class="form-label" for="f_gname">Father's Name/Guardian: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm rounded-0" value="<?php echo htmlspecialchars($f_gname); ?>" id="f_gname" name="f_gname" />
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-12">
                <div class="mb-3">
                    <label class="form-label" for="Nationality">Nationality Type: <span class="text-danger">*</span></label>
                    <select class="form-control form-control-sm rounded-0" id="Nationality" name="Nationality">
                        <?php echo getnationality(); ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-12">
                <div class="mb-3">
                    <label class="form-label" for="Occupation">Occupation: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm rounded-0" id="Occupation" value="<?php echo htmlspecialchars($Occupation); ?>" name="Occupation" />
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-12">
                <div class="mb-3">
                    <label class="form-label" for="remarks">Remarks</label>
                    <input type="text" class="form-control form-control-sm rounded-0" value="<?php echo htmlspecialchars($remarks); ?>" id="remarks" name="remarks" />
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-sm-4 col-12">
        <button type="submit" class="btn btn-primary btn-sm rounded-0">Submit</button>
    </div>

</form>

<script>
$(document).ready(function() {
    $('#date_of_birth').datetimepicker({
        format: 'Y-m-d',
        timepicker: false
    });

    $("#patient_form").validate({
        rules: {
            patient_name: {
                required: true,
                minlength: 2
            },
            last_name: {
                required: true,
                minlength: 2
            },
            Purok: {
                required: true,
                minlength: 2
            },
            address: {
                required: true
            },
            Province: {
                required: true,
                minlength: 2
            },
            date_of_birth: {
                required: true,
                date: true
            },
            gender: {
                required: true
            },
            phone_number: {
                required: true,
                phoneUS: true
            },
            Status: {
                required: true
            },
            Blood: {
                required: true
            },
            m_name: {
                required: true,
                minlength: 2
            },
            f_gname: {
                required: true,
                minlength: 2
            },
            Nationality: {
                required: true
            },
            Occupation: {
                required: true,
                minlength: 2
            }
        },
        messages: {
            patient_name: {
                required: "First name is required",
                minlength: "First name must be at least 2 characters"
            },
            last_name: {
                required: "Last name is required",
                minlength: "Last name must be at least 2 characters"
            },
            Purok: {
                required: "Purok is required",
                minlength: "Purok must be at least 2 characters"
            },
            address: {
                required: "Address is required"
            },
            Province: {
                required: "Province is required",
                minlength: "Province must be at least 2 characters"
            },
            date_of_birth: {
                required: "Date of birth is required",
                date: "Please enter a valid date"
            },
            gender: {
                required: "Gender is required"
            },
            phone_number: {
                required: "Contact number is required",
                phoneUS: "Please enter a valid phone number"
            },
            Status: {
                required: "Civil status is required"
            },
            Blood: {
                required: "Blood type is required"
            },
            m_name: {
                required: "Mother's name is required",
                minlength: "Mother's name must be at least 2 characters"
            },
            f_gname: {
                required: "Father's name/Guardian is required",
                minlength: "Father's name/Guardian must be at least 2 characters"
            },
            Nationality: {
                required: "Nationality is required"
            },
            Occupation: {
                required: "Occupation is required",
                minlength: "Occupation must be at least 2 characters"
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
</script>

</body>
</html>
