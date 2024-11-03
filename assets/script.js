document.addEventListener('DOMContentLoaded', function () {
    // Function to initialize datepicker on date fields
    function initializeDatepicker() {
        $(".datepicker").daterangepicker({
            singleDatePicker: true,
            startDate: moment().startOf("hour"),
            endDate: moment().startOf("hour").add(32, "hour"),
            maxDate: moment(), // Set max date to today
            locale: {
                format: "DD/MM/YYYY",
            },
        });
    }

    // Initialize datepicker for existing date fields
    initializeDatepicker();

    // Event listener for add and remove row buttons
    document.getElementById('IVFluid-body').addEventListener('click', function (event) {
        if (event.target.classList.contains('add-btn') || event.target.closest('.add-btn')) {
            event.preventDefault(); // Prevent default behavior

            var tableBody = document.getElementById('IVFluid-body');
            var newRow = document.createElement('tr');

            newRow.innerHTML = `
                 <input type="hidden" name="row_fluids[]" value="new">
                <td>
                    <div class="input-group">
                        <input type="text" class="form-control datepicker " name="Date[]">
                        <span class="input-group-text">
                            <i class="icon-calendar"></i>
                        </span>
                        <div class="invalid-feedback">
                        Date  is required.
                    </div>
                    </div>
                </td>
                <td>
                <input type="time" class="form-control" name="timeStarted[]" required>
                    
                    
                    <div class="invalid-feedback">
                    TIME STARTED  is required.
                    </div>
                </td>
                <td>
                    <input type="time" class="form-control" name="timeconsumed[]" required>
                    <div class="invalid-feedback">
                    Time consumed  is required.
                    </div>
                </td>
                <td>
                    <input type="number" min="0" max="999" class="form-control" name="bottleno[]" required>
                    <div class="invalid-feedback">
                        Bottle no. is required.
                    </div>
                </td>
                <td>
                    <input type="text" class="form-control" name="solution[]" required>
                    <div class="invalid-feedback">
                        Type of solution is required.
                    </div>
                </td>

                <td>
                    <input type="text" class="form-control" name="signature_remarks[]" required>

                        <div class="invalid-feedback">
                         Signature / Remarks is required.
                    
                    </div>

                </td>
            <td>
                                
                <button type="button" class="btn btn-danger remove-btn" ><i class="fas fa-minus"></i></button>
            </td>
            `;

            tableBody.appendChild(newRow);

            // Re-initialize the datepicker for the new row
            initializeDatepicker();

        } else if (event.target.classList.contains('remove-btn') || event.target.closest('.remove-btn')) {
            event.preventDefault(); // Prevent default behavior

            var row = event.target.closest('tr');
            row.parentNode.removeChild(row);

            // Hide remove button if only one row remains
            var rows = document.querySelectorAll('#IVFluid-body tr');
            if (rows.length === 1) {
                rows[0].querySelector('.remove-btn').style.display = 'none';
            }
        }
    });


});

document.addEventListener('DOMContentLoaded', function () {


    var form3 = document.getElementById('IVFluidsForm');
    var submitButton3 = document.getElementById('submitFluids');
    // Add validation on form submission

    form3.addEventListener('submit', function (event) {
        var isValid = false;

        // Check if there are rows
        var rows = form3.querySelectorAll('#IVFluid-body tr');
        if (rows.length > 0) {
            // Validate at least one row
            rows.forEach(function (row) {
                var inputs = row.querySelectorAll('input, select');
                if (Array.from(inputs).every(input => input.checkValidity())) {
                    isValid = true;
                }
            });
        }

        // Check built-in HTML5 form validation
        if (!form3.checkValidity() || !isValid) {
            event.preventDefault();
            event.stopPropagation();
            form3.classList.add('was-validated');
        } else {
            form3.classList.remove('was-validated');
        }
    }, false);

});

