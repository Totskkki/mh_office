<div class="modal fade" id="docnotes" tabindex="-1" aria-labelledby="exampleModalXlLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title h4" id="discharged">Doctor's Order</h5>
                
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
            
            <div class="modal-body">

                <form method="POST" novalidate id="docnotesForm">
                    <input type="hidden" name="patientid" id="docid">
                    <div class="row mb-3">
                        <div class="col-md-5 mb-2">
                            <label for="patientName" class="form-label">Patient's Name:</label>
                            <input type="text" class="form-control" name="patientName" id="dname" required>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="patientAge" class="form-label">Age:</label>
                            <input type="text" class="form-control" name="patientAge" id="dage" required>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="patientRoom" class="form-label">Room:</label>
                            <input type="text" class="form-control" name="room" id="droom" required>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Doctor</th>
                                    <th>ORDER</th>
                                    <th>Action</th>
                                   
                                </tr>
                            </thead>
                            <tbody id="docnotesTableBody">
                                
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                    <button type="button" class="btn " data-bs-dismiss="modal">Close</button>
                    <a href="#" id="printNotes" target="_blank" class="btn btn-secondary"> <i class="icon-printer"></i> Print</a>
                      
                        <button type="button" id="NewRow" class="btn btn-success">Add New Row</button>
                        <button type="submit" name="submitdocnotes" class="btn btn-info">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- 
<div class="modal fade" id="nursenotes" tabindex="-1" aria-labelledby="exampleModalXlLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title h4" id="discharged">Nurses Notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" novalidate id="nursenotesForm">

                <input type="text" name="patientid" id="pid">
                    <input type="text" name="nurseid" id="nurseid">
                    <div class="row mb-3">
                        <div class="col-md-5 mb-2">
                            <label for="patientName" class="form-label">Patient's Name:</label>
                            <input type="text" class="form-control" name="patientName" id="nname" required>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="patientAge" class="form-label">Age:</label>
                            <input type="text" class="form-control" name="patientAge" id="nage" required>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="patientRoom" class="form-label">Room:</label>
                            <input type="text" class="form-control" name="room" id="nroom" required>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>

                                    <th>Nurses Notes</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="nursenotesTableBody">
                                <tr>
                                    <td>

                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker " name="date[]" required>
                                            <span class="input-group-text">
                                                <i class="icon-calendar"></i>
                                            </span>
                                            <div class="invalid-feedback ">
                                                Date is required.
                                            </div>
                                        </div>


                                    </td>
                                    <td><input type="time" class="form-control" name="time[]" required>
                                        <div class="invalid-feedback ">
                                            Time is required.
                                        </div>
                                    </td>

                                    <td>
                                        <textarea style="resize:none;" name="docnotes[]" class="form-control" data-ms-editor="true" spellcheck="false" required></textarea>
                                        <div class="invalid-feedback ">
                                            Notes is required.
                                        </div>
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-info add"><i class="icon-plus"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="submitnursenotes" class="btn btn-primary">Submit</button>
            </div>
            </form>

        </div>
    </div>
</div> -->

<div class="modal fade" id="nursenotes" tabindex="-1" aria-labelledby="exampleModalXlLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title h4" id="discharged">Nurses Notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" novalidate id="nursenotesForm">

                    <input type="hidden" name="patientid" id="pid">
                    <input type="hidden" name="nurseid" id="nurseid">
                    <div class="row mb-3">
                        <div class="col-md-5 mb-2">
                            <label for="patientName" class="form-label">Patient's Name:</label>
                            <input type="text" class="form-control" name="patientName" id="nname" required readonly>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="patientAge" class="form-label">Age:</label>
                            <input type="text" class="form-control" name="patientAge" id="nage" required readonly>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="patientRoom" class="form-label">Room:</label>
                            <input type="text" class="form-control" name="room" id="nroom" required readonly>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Nurses Notes</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="nursenotesTableBody">
                                <!-- New rows will be appended here -->
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                <a href="#" id="printNurseNotes" target="_blank" class="btn btn-secondary"> <i class="icon-printer"></i> Print</a>
                <button type="button" id="addNewRow" class="btn btn-success">Add New Row</button>
                <button type="submit" name="submitnursenotes" class="btn btn-info" form="nursenotesForm">Submit</button>
            </div>
        </div>
    </div>
</div>
