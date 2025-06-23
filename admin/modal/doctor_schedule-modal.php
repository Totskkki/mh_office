<!-- add start -->
<div class="modal fade" id="add_schedule" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="scheduleForm" method="POST" enctype="multipart/form-data" onsubmit="checkFormData(event)" novalidate>

                    <div class="mb-3 row">
                        <label for="text" class="col-sm-3 col-form-label text-center">Select Doctor <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select name="doctor" id="doctor_add" class="form-select" required>
                                <?php echo $doctors; ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select a Doctor.
                            </div>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="text" class="form-label">Weekly Working Hours</label>
                        <div id="dayErrorMessage" class="text-danger mt-2" style="display: none;">Please select at least one weekday.</div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="checkAll" onchange="toggleAllDays(this)">
                            <label class="form-check-label" for="checkAll">Check All</label>
                        </div>
                        <ul class="list-group">
                            <?php
                            $days = ["SUNDAY", "MONDAY", "TUESDAY", "WEDNESDAY", "THURSDAY", "FRIDAY", "SATURDAY"];
                            foreach ($days as $day) { ?>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <input class="form-check-input me-2 day-checkbox" type="checkbox" name="day[]" value="<?php echo $day; ?>" onchange="toggleAvailability(this)" >
                                        <label class="form-check-label me-3"><?php echo substr($day, 0, 3); ?></label>
                                        <div class="time-rows"></div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>

                    </div>
                      <div class="mb-3">
                        
                        <small for="text" class="form-label me-5"> <span class="text-danger">* Ensure to have Repeat Schedule for Doctors.</span></small>
                      
                    </div>


                    <div class="mb-3">
                        
                        <label for="text" class="form-label me-5">Repeat <span class="text-danger">*</span></label>
                        <input class="form-check-input me-2 day-radio" type="radio" name="repeat" value="Weekly">
                        <label class="form-check-label me-3" for="Weekly">Weekly</label>

                        <input class="form-check-input me-2 day-radio" type="radio" name="repeat" value="Monthly">
                        <label class="form-check-label me-3" for="Monthly">Monthly</label>

                        <input class="form-check-input me-2 day-radio" type="radio" name="repeat" value="Yearly">
                        <label class="form-check-label me-3" for="Yearly">Yearly</label>
                        <input class="form-check-input me-2 day-radio" type="radio" name="repeat" value="">
                        <label class="form-check-label me-3" for="Yearly">Never</label>
                    </div>

            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="add_schedule_btn" name="add_schedule" class="btn btn-info">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>



<!-- <div class="modal fade" id="add_schedule" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="scheduleForm" method="POST" enctype="multipart/form-data" novalidate>

                    <div class="mb-3 row">
                        <label for="text" class="col-sm-3 col-form-label text-center">Select Doctor</label>
                        <div class="col-sm-8">
                            <select name="doctor" id="doctor_add" class="form-select" required>
                                <?php echo $doctors; ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select a Doctor.
                            </div>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="text" class="form-label">Weekly Working Hours</label>
                        <div id="dayErrorMessage" class="text-danger mt-2" style="display: none;">
                            Please select at least one weekday.
                        </div>
                        <ul class="list-group">
                    
                            <li class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <input class="form-check-input me-2 day-checkbox" type="checkbox" name="day[]" value="SUNDAY" onchange="toggleAvailability(this)">
                                    <label class="form-check-label me-3" for="sundayCheck" style="width: 50px;">SUN</label>

                                  
                                    <div class="time-rows">
                                        <div class="d-flex align-items-center time-row">
                                            <input type="text" name="worklength[SUNDAY][]" class="form-control me-2 worklength-input" style="width: 120px;" placeholder="Hours" disabled>
                                            <input type="time" name="fromtime[SUNDAY][]" class="form-control me-2 time-input from-time" style="width: 120px;" placeholder="From" required disabled onchange="calculateWorkHours(this)">
                                            <input type="time" name="totime[SUNDAY][]" class="form-control me-2 time-input to-time" style="width: 120px;" placeholder="To" required disabled onchange="calculateWorkHours(this)">
                                            <button type="button" class="btn btn-info btn-sm ms-2" onclick="addRow(this)" disabled>+</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <input class="form-check-input me-2 day-checkbox" type="checkbox" name="day[]" value="MONDAY" onchange="toggleAvailability(this)">
                                    <label class="form-check-label me-3" for="sundayCheck" style="width: 50px;">MON</label>

                               
                                    <div class="time-rows">
                                        <div class="d-flex align-items-center time-row">
                                            <input type="text" name="worklength[MONDAY][]" class="form-control me-2 worklength-input" style="width: 120px;" placeholder="Hours" disabled>
                                            <input type="time" name="fromtime[MONDAY][]" class="form-control me-2 time-input from-time" style="width: 120px;" required placeholder="From" disabled onchange="calculateWorkHours(this)">
                                            <input type="time" name="totime[MONDAY][]" class="form-control me-2 time-input to-time" style="width: 120px;" required placeholder="To" disabled onchange="calculateWorkHours(this)">
                                            <button type="button" class="btn btn-info btn-sm ms-2" onclick="addRow(this)" disabled>+</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <input class="form-check-input me-2 day-checkbox" type="checkbox" name="day[]" value="TUESDAY" onchange="toggleAvailability(this)">
                                    <label class="form-check-label me-3" for="sundayCheck" style="width: 50px;">TUE</label>

                                    <div class="time-rows">
                                        <div class="d-flex align-items-center time-row">
                                            <input type="text" name="worklength[TUESDAY][]" class="form-control me-2 worklength-input" style="width: 120px;" placeholder="Hours" disabled>
                                            <input type="time" name="fromtime[TUESDAY][]"class="form-control me-2 time-input from-time" style="width: 120px;" required placeholder="From" disabled onchange="calculateWorkHours(this)">
                                            <input type="time" name="totime[TUESDAY][]"class="form-control me-2 time-input to-time" style="width: 120px;" required placeholder="To" disabled onchange="calculateWorkHours(this)">
                                            <button type="button" class="btn btn-info btn-sm ms-2" onclick="addRow(this)" disabled>+</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <input class="form-check-input me-2 day-checkbox" type="checkbox" name="day[]" value="WEDNESDAY" onchange="toggleAvailability(this)">
                                    <label class="form-check-label me-3" for="sundayCheck" style="width: 50px;">WED</label>

                                 
                                    <div class="time-rows">
                                        <div class="d-flex align-items-center time-row">
                                            <input type="text"  name="worklength[WEDNESDAY][]"class="form-control me-2 worklength-input" style="width: 120px;" placeholder="Hours" disabled>
                                            <input type="time" name="fromtime[WEDNESDAY][]"class="form-control me-2 time-input from-time" style="width: 120px;" required placeholder="From" disabled onchange="calculateWorkHours(this)">
                                            <input type="time"  name="totime[WEDNESDAY][]"class="form-control me-2 time-input to-time" style="width: 120px;" required placeholder="To" disabled onchange="calculateWorkHours(this)">
                                            <button type="button" class="btn btn-info btn-sm ms-2" onclick="addRow(this)" disabled>+</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <input class="form-check-input me-2 day-checkbox" type="checkbox" name="day[]" value="THURSDAY" onchange="toggleAvailability(this)">
                                    <label class="form-check-label me-3" for="sundayCheck" style="width: 50px;">THU</label>

                            
                                    <div class="time-rows">
                                        <div class="d-flex align-items-center time-row">
                                            <input type="text"  name="worklength[THURSDAY][]"class="form-control me-2 worklength-input" style="width: 120px;" placeholder="Hours" disabled>
                                            <input type="time"  name="fromtime[THURSDAY][]"class="form-control me-2 time-input from-time" style="width: 120px;" required placeholder="From" disabled onchange="calculateWorkHours(this)">
                                            <input type="time"name="totime[THURSDAY][]" class="form-control me-2 time-input to-time" style="width: 120px;" required placeholder="To" disabled onchange="calculateWorkHours(this)">
                                            <button type="button" class="btn btn-info btn-sm ms-2" onclick="addRow(this)" disabled>+</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <input class="form-check-input me-2 day-checkbox" type="checkbox" name="day[]" value="FRIDAY" onchange="toggleAvailability(this)">
                                    <label class="form-check-label me-3" for="sundayCheck" style="width: 50px;">FRI</label>

                                
                                    <div class="time-rows">
                                        <div class="d-flex align-items-center time-row">
                                            <input type="text"name="worklength[FRIDAY][]" class="form-control me-2 worklength-input" style="width: 120px;" placeholder="Hours" disabled>
                                            <input type="time"name="fromtime[FRIDAY][]" class="form-control me-2 time-input from-time" style="width: 120px;" required placeholder="From" disabled onchange="calculateWorkHours(this)">
                                            <input type="time"name="totime[FRIDAY][]"class="form-control me-2 time-input to-time" style="width: 120px;" required placeholder="To" disabled onchange="calculateWorkHours(this)">
                                            <button type="button" class="btn btn-info btn-sm ms-2" onclick="addRow(this)" disabled>+</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <input class="form-check-input me-2 day-checkbox" type="checkbox" name="day[]" value="SATURDAY" onchange="toggleAvailability(this)">
                                    <label class="form-check-label me-3" for="sundayCheck" style="width: 50px;">SAT</label>

                                    <div class="time-rows">
                                        <div class="d-flex align-items-center time-row">
                                            <input type="text" name="worklength[SATURDAY][]" class="form-control me-2 worklength-input" style="width: 120px;" placeholder="Hours" disabled>
                                            <input type="time" name="fromtime[SATURDAY][]"class="form-control me-2 time-input from-time" style="width: 120px;" required placeholder="From" disabled onchange="calculateWorkHours(this)">
                                            <input type="time"  name="totime[SATURDAY][]"class="form-control me-2 time-input to-time" style="width: 120px;" required placeholder="To" disabled onchange="calculateWorkHours(this)">
                                            <button type="button" class="btn btn-info btn-sm ms-2" onclick="addRow(this)" disabled>+</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>


                    <div class="mb-3">
                        <label for="text" class="form-label me-5">Repeat</label>
                        <input class="form-check-input me-2 day-radio" type="radio" name="repeat" value="Weekly">
                        <label class="form-check-label me-3" for="Weekly">Weekly</label>

                        <input class="form-check-input me-2 day-radio" type="radio" name="repeat" value="Monthly">
                        <label class="form-check-label me-3" for="Monthly">Monthly</label>

                        <input class="form-check-input me-2 day-radio" type="radio" name="repeat" value="Yearly">
                        <label class="form-check-label me-3" for="Yearly">Yearly</label>
                        <input class="form-check-input me-2 day-radio" type="radio" name="repeat" value="">
                        <label class="form-check-label me-3" for="Yearly">Never</label>
                    </div>

            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="add_schedule_btn" name="add_schedule" class="btn btn-info">Save</button>
            </div>
            </form>
        </div>
    </div>
</div> -->







<!-- edit start -->


<div class="modal fade" id="edit_schedule" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="update_schedule_form" method="POST" novalidate>
                    <input type="hidden" id="doc_scheduleID" name="doc_scheduleID">
                    <div class="mb-3 row">
                        <label for="doctor_update" class="col-sm-3 col-form-label text-center">Select Doctor <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select name="doctor" id="doctor" class="form-select" required>
                                <?php echo $doctors; ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select a Doctor.
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="text" class="form-label">Weekly Working Hours</label>
                        <div id="dayErrorMessage" class="text-danger mt-2" style="display: none;">
                            Please select at least one weekday.
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="checkAlls" onchange="toggleAllDays(this)">
                            <label class="form-check-label" for="checkAll">Check All</label>
                        </div>
                        <ul class="list-group">
                            <!-- Example list item for Sunday -->
                            <li class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <input class="form-check-input me-2 day-checkbox" type="checkbox" name="day[]" id="sundayCheck" value="SUNDAY" onchange="toggleAvailability(this)">
                                    <label class="form-check-label me-3" for="sundayCheck" style="width: 50px;">SUN</label>

                                    <!-- Container for time rows -->
                                    <div class="time-rows" id="sundayTimeRows">
                                        <div class="d-flex align-items-center time-row">
                                            <input type="text" name="worklength[]" class="form-control me-2 worklength-input" style="width: 120px;" placeholder="Hours">
                                            <input type="time" name="fromtime[]" class="form-control me-2 time-input from-time" style="width: 120px;" placeholder="From" required onchange="calculateWorkHours(this)">
                                            <input type="time" name="totime[]" class="form-control me-2 time-input to-time" style="width: 120px;" placeholder="To" required onchange="calculateWorkHours(this)">
                                            <button type="button" class="btn btn-info btn-sm ms-2" onclick="addRow(this)">+</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <input class="form-check-input me-2 day-checkbox" type="checkbox" name="day[]" id="mondayCheck" value="MONDAY" onchange="toggleAvailability(this)">
                                    <label class="form-check-label me-3" for="sundayCheck" style="width: 50px;">MON</label>

                                    <!-- Container for time rows -->
                                    <div class="time-rows" id="mondayTimeRows">
                                        <div class="d-flex align-items-center time-row">
                                            <input type="text" name="worklength[]" class="form-control me-2 worklength-input" style="width: 120px;" placeholder="Hours">
                                            <input type="time" name="fromtime[]" class="form-control me-2 time-input from-time" style="width: 120px;" required placeholder="From" onchange="calculateWorkHours(this)">
                                            <input type="time" name="totime[]" class="form-control me-2 time-input to-time" style="width: 120px;" required placeholder="To" onchange="calculateWorkHours(this)">
                                            <button type="button" class="btn btn-info btn-sm ms-2" onclick="addRow(this)" disabled>+</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <input class="form-check-input me-2 day-checkbox" type="checkbox" name="day[]" id="tuesdayCheck" value="TUESDAY" onchange="toggleAvailability(this)">
                                    <label class="form-check-label me-3" for="sundayCheck" style="width: 50px;">TUE</label>

                                    <!-- Container for time rows -->
                                    <div class="time-rows" id="tuesdayTimeRows">
                                        <div class="d-flex align-items-center time-row">
                                            <input type="text" name="worklength[]" class="form-control me-2 worklength-input" style="width: 120px;" placeholder="Hours">
                                            <input type="time" name="fromtime[]" class="form-control me-2 time-input from-time" style="width: 120px;" required placeholder="From" onchange="calculateWorkHours(this)">
                                            <input type="time" name="totime[]" class="form-control me-2 time-input to-time" style="width: 120px;" required placeholder="To" onchange="calculateWorkHours(this)">
                                            <button type="button" class="btn btn-info btn-sm ms-2" onclick="addRow(this)" disabled>+</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <input class="form-check-input me-2 day-checkbox" type="checkbox" name="day[]" id="wednesdayCheck" value="WEDNESDAY" onchange="toggleAvailability(this)">
                                    <label class="form-check-label me-3" for="sundayCheck" style="width: 50px;">WED</label>

                                    <!-- Container for time rows -->
                                    <div class="time-rows" id="wednesdayTimeRows">
                                        <div class="d-flex align-items-center time-row">
                                            <input type="text" name="worklength[]" class="form-control me-2 worklength-input" style="width: 120px;" placeholder="Hours">
                                            <input type="time" name="fromtime[]" class="form-control me-2 time-input from-time" style="width: 120px;" required placeholder="From" onchange="calculateWorkHours(this)">
                                            <input type="time" name="totime[]" class="form-control me-2 time-input to-time" style="width: 120px;" required placeholder="To" onchange="calculateWorkHours(this)">
                                            <button type="button" class="btn btn-info btn-sm ms-2" onclick="addRow(this)" disabled>+</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <input class="form-check-input me-2 day-checkbox" type="checkbox" name="day[]" id="thursdayCheck" value="THURSDAY" onchange="toggleAvailability(this)">
                                    <label class="form-check-label me-3" for="sundayCheck" style="width: 50px;">THU</label>

                                    <!-- Container for time rows -->
                                    <div class="time-rows" id="thursdayTimeRows">
                                        <div class="d-flex align-items-center time-row">
                                            <input type="text" name="worklength[]" class="form-control me-2 worklength-input" style="width: 120px;" placeholder="Hours">
                                            <input type="time" name="fromtime[]" class="form-control me-2 time-input from-time" style="width: 120px;" required placeholder="From" onchange="calculateWorkHours(this)">
                                            <input type="time" name="totime[]" class="form-control me-2 time-input to-time" style="width: 120px;" required placeholder="To" onchange="calculateWorkHours(this)">
                                            <button type="button" class="btn btn-info btn-sm ms-2" onclick="addRow(this)" disabled>+</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <input class="form-check-input me-2 day-checkbox" type="checkbox" name="day[]" id="fridayCheck" value="FRIDAY" onchange="toggleAvailability(this)">
                                    <label class="form-check-label me-3" for="sundayCheck" style="width: 50px;">FRI</label>

                                    <!-- Container for time rows -->
                                    <div class="time-rows" id="fridayTimeRows">
                                        <div class="d-flex align-items-center time-row">
                                            <input type="text" name="worklength[]" class="form-control me-2 worklength-input" style="width: 120px;" placeholder="Hours">
                                            <input type="time" name="fromtime[]" class="form-control me-2 time-input from-time" style="width: 120px;" required placeholder="From" onchange="calculateWorkHours(this)">
                                            <input type="time" name="totime[]" class="form-control me-2 time-input to-time" style="width: 120px;" required placeholder="To" onchange="calculateWorkHours(this)">
                                            <button type="button" class="btn btn-info btn-sm ms-2" onclick="addRow(this)" disabled>+</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <input class="form-check-input me-2 day-checkbox" type="checkbox" name="day[]" id="saturdayCheck" value="SATURDAY" onchange="toggleAvailability(this)">
                                    <label class="form-check-label me-3" for="sundayCheck" style="width: 50px;">SAT</label>

                                    <!-- Container for time rows -->
                                    <div class="time-rows" id="saturdayTimeRows">
                                        <div class="d-flex align-items-center time-row">
                                            <input type="text" name="worklength[]" class="form-control me-2 worklength-input" style="width: 120px;" placeholder="Hours">
                                            <input type="time" name="fromtime[]" class="form-control me-2 time-input from-time" style="width: 120px;" required placeholder="From" onchange="calculateWorkHours(this)">
                                            <input type="time" name="totime[]" class="form-control me-2 time-input to-time" style="width: 120px;" required placeholder="To" onchange="calculateWorkHours(this)">
                                            <button type="button" class="btn btn-info btn-sm ms-2" onclick="addRow(this)" disabled>+</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>


                    <div class="mb-3">
                        <label for="text" class="form-label me-5">Repeat <span class="text-danger">*</span></label>
                        <input class="form-check-input me-2 day-radio" type="radio" id="Weekly" name="repeat" value="Weekly">
                        <label class="form-check-label me-3" for="Weekly">Weekly</label>

                        <input class="form-check-input me-2 day-radio" type="radio" id="Monthly" name="repeat" value="Monthly">
                        <label class="form-check-label me-3" for="Monthly">Monthly</label>

                        <input class="form-check-input me-2 day-radio" type="radio" id="Yearly" name="repeat" value="Yearly">
                        <label class="form-check-label me-3" for="Yearly">Yearly</label>
                        <input class="form-check-input me-2 day-radio" type="radio" id="Never" name="repeat" value="">
                        <label class="form-check-label me-3" for="Yearly">Never</label>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="update_schedule_btn" name="update_schedule" class="btn btn-info">Update</button>
            </div>
            <input type="hidden" name="schedule_id" id="schedule_id">
            </form>
        </div>
    </div>
</div>


<!-- edit end -->

<!-- delete start -->
<div class="modal fade" id="delete_doctor_schedule" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete_doctor_schedule"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="controller/delete_doctor_schedule.php">
                    <input type="hidden" id="deleteid" name="deleteid">

                    <h4>Are you sure you want to delete the doctor schedule?</h4>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-sm" data-bs-dismiss="modal">Close</button>

                        <button type="submit" class="btn btn-primary btn-sm">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- delete end -->