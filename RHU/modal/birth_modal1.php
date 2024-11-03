

<!-- start Save Records -->
<div class="modal fade" id="labourRecord" tabindex="-1" aria-labelledby="exampleModalXlLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title h4" id="exampleModalXlLabel">
                    LABOUR RECORD
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="addEventForm" novalidate>
                    <div>
                        <div style="text-align: left; flex: 1;">
                            <label class="form-label"><b>USE THIS RECORD FOR MONITORING DURING LABOUR, DELIVERY AND POSTPARTUM</b>

                            </label><span style="margin-left: 2rem;">Case No.:</span>

                            <input type="text" id="case_no" name="case_no" class="form-input1" style="width: 20%;">
                            <input type="hidden" name="patientid" id="patientid">
                            <br>

                            <label class="form-label">Parity:</label>
                            <input type="text" name="parity" class="form-input1" required>
                            <div class="invalid-feedback">
                                Parity is required.
                            </div>
                        </div>


                        <div class="row">
                            <div>
                                <table class="styled-table">
                                    <thead>
                                        <tr>
                                            <th>During Labour</th>
                                            <th>At or After Birth - Mother</th>
                                            <th>At or After Birth - Newborn</th>
                                            <th>PLANNED NEWBORN TREATMENT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> <label>Admission Date:</label>
                                                <input type="date" name="addmissiondate" class="form-control" required>
                                                <div class="invalid-feedback">
                                                    Admission Date is required.
                                                </div>
                                            </td>
                                            <td><label>Birth Time:</label>
                                                <input type="time" name="birthTime" class="form-control" required>
                                                <div class="invalid-feedback">
                                                    Birth Time is required.
                                                </div>
                                            </td>
                                            <td>
                                                <label>Livebirth:</label>
                                                <input type="checkbox" name="Livebirth" value="Livebirth" class="form-check-input" onclick="toggleCheckbox(this)">


                                                <label>Stillbirth-Fresh:</label>
                                                <input type="checkbox" name="Livebirth" value="Stillbirth-Fresh" class="form-check-input" onclick="toggleCheckbox(this)">

                                            </td>
                                            <td> <textarea name="newbord" class="form-control" style="resize:none;" required></textarea>
                                                <div class="invalid-feedback">
                                                    PLANNED NEWBORN TREATMENT is required.
                                                </div>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td><label>Admission Time:</label>
                                                <input type="time" name="admissionTime" class="form-control" required>
                                                <div class="invalid-feedback">
                                                    Admission Time is required.
                                                </div>
                                            </td>
                                            <td> <label>Oxytocin-Time Given:</label>
                                                <input type="time" name="Oxytocin" class="form-control" required>
                                                <div class="invalid-feedback">
                                                    Oxytocin-Time Given is required.
                                                </div>
                                            </td>
                                            <td> <label>RESUSCITATION:</label><br>
                                                Yes <input type="checkbox" name="RESUSCITATION" value="Yes" class="form-check-input" onclick="toggleCheckbox(this)">
                                                No <input type="checkbox" name="RESUSCITATION" value="No" class="form-check-input" onclick="toggleCheckbox(this)"></td>

                                        </tr>
                                        <tr>
                                            <td><label>TIME ACTIVE LABOUR STARTED:</label>
                                                <input type="time" name="timeactive" class="form-control" required>
                                                <div class="invalid-feedback">
                                                    TIME ACTIVE LABOUR STARTED is required.
                                                </div>
                                            </td>
                                            <td><label>Placenta Complete:</label><br>
                                                Yes <input type="checkbox" name="placentaComplete" value="Yes" class="form-check-input" onclick="toggleCheckbox(this)">
                                                NO <input type="checkbox" name="placentaComplete" value="No" class="form-check-input" onclick="toggleCheckbox(this)"></td>
                                            <td><label>Birth Weight:</label>
                                                <input type="text" name="birthweight" class="form-control" required>
                                                <div class="invalid-feedback">
                                                    Birth Weight is required.
                                                </div>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td> <label>TIME MEMBRANES RUPTURED:</label>
                                                <input type="time" name="timeMembranes" class="form-control" required>
                                                <div class="invalid-feedback">
                                                    TIME MEMBRANES RUPTURED is required.
                                                </div>
                                            </td>
                                            <td> <label>Time Delivered:</label>
                                                <input type="time" name="timedelevered" class="form-control" required>
                                                <div class="invalid-feedback">
                                                    Time Delivered is required.
                                                </div>
                                            </td>
                                            <td><label>AOG: 36 Wks or Preterm:</label><br>
                                                Yes <input type="checkbox" name="Preterm" value="Yes" class="form-check-input" onclick="toggleCheckbox(this)">
                                                No <input type="checkbox" name="Preterm" value="No" class="form-check-input" onclick="toggleCheckbox(this)"></td>

                                        </tr>
                                        <tr>
                                            <td> <label>TIME SECOND STAGE STARTS:</label>
                                                <input type="time" name="timeSecond" class="form-control" required>
                                                <div class="invalid-feedback">
                                                    TIME SECOND STAGE STARTS is required.
                                                </div>
                                            </td>
                                            <td> <label>Estimated Blood Loss:</label>
                                                <input type="text" name="Estimated" class="form-control" required>
                                                <div class="invalid-feedback">
                                                    Estimated Blood Loss is required.
                                                </div>
                                            </td>
                                            <td> <label>Second Baby:</label>
                                                <input type="text" name="secondbaby" class="form-control" required>
                                                <div class="invalid-feedback">
                                                    Second Baby is required.
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th colspan="14">ENTRY EXAMINATION</th>
                                        </tr>
                                        <tr>
                                            <td>STAGE OF LABOUR</td>
                                            <td>NOT IN ACTIVE LABOUR
                                                <input class="form-check-input" type="checkbox" class="form-check-input" name="stage_of_labour" value="NOT IN ACTIVE LABOUR">
                                            </td>
                                            <td>ACTIVE LABOUR
                                                <input class="form-check-input" type="checkbox" class="form-check-input" name="stage_of_labour" value="ACTIVE LABOUR">
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="row">
                            <div>
                                <table class="styled-table">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">TIME</th>
                                            <th colspan="12">HOURS SINCE ARRIVAL</th>
                                            <th rowspan="3">PLANNED MATERNAL TREATMENT</th>
                                        </tr>


                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Hours Since Arrival</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>6</td>
                                            <td>7</td>
                                            <td>8</td>
                                            <td>9</td>
                                            <td>10</td>
                                            <td>11</td>
                                            <td>12</td>
                                            <td> <textarea name="maternalplan" class="form-control" style="resize:none;" required></textarea>
                                                <div class="invalid-feedback">
                                                    PLANNED MATERNAL TREATMENT is required.
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Hours Since Ruptured Membranes</td>
                                            <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="1"></td>
                                            <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="2"></td>
                                            <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="3"></td>
                                            <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="4"></td>
                                            <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="5"></td>
                                            <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="6"></td>
                                            <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="7"></td>
                                            <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="8"></td>
                                            <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="9"></td>
                                            <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="10"></td>
                                            <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="11"></td>
                                            <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="12"></td>


                                        </tr>
                                        <tr>
                                            <td>Vaginal Bleeding (0 + ++)</td>
                                            <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="1"></td>
                                            <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="2"></td>
                                            <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="3"></td>
                                            <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="4"></td>
                                            <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="5"></td>
                                            <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="6"></td>
                                            <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="7"></td>
                                            <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="8"></td>
                                            <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="9"></td>
                                            <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="10"></td>
                                            <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="11"></td>
                                            <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="12"></td>
                                        </tr>
                                        <tr>
                                            <td>Strong Contractions in 10 Minutes</td>
                                            <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="1"></td>
                                            <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="2"></td>
                                            <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="3"></td>
                                            <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="4"></td>
                                            <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="5"></td>
                                            <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="6"></td>
                                            <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="7"></td>
                                            <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="8"></td>
                                            <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="9"></td>
                                            <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="10"></td>
                                            <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="11"></td>
                                            <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="12"></td>
                                        </tr>
                                        <tr>
                                            <td>Fetal Heart Rate (Beats per Minute)</td>
                                            <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="1"></td>
                                            <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="2"></td>
                                            <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="3"></td>
                                            <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="4"></td>
                                            <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="5"></td>
                                            <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="6"></td>
                                            <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="7"></td>
                                            <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="8"></td>
                                            <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="9"></td>
                                            <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="10"></td>
                                            <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="11"></td>
                                            <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="12"></td>
                                        </tr>
                                        <tr>
                                            <td>T (Axillary)</td>
                                            <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="1"></td>
                                            <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="2"></td>
                                            <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="3"></td>
                                            <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="4"></td>
                                            <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="5"></td>
                                            <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="6"></td>
                                            <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="7"></td>
                                            <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="8"></td>
                                            <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="9"></td>
                                            <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="10"></td>
                                            <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="11"></td>
                                            <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="12"></td>
                                        </tr>
                                        <tr>
                                            <td>Pulse (Beats/Minute)</td>
                                            <td><input type="checkbox" class="form-check-input" name="pulse[]" value="1"></td>
                                            <td><input type="checkbox" class="form-check-input" name="pulse[]" value="2"></td>
                                            <td><input type="checkbox" class="form-check-input" name="pulse[]" value="3"></td>
                                            <td><input type="checkbox" class="form-check-input" name="pulse[]" value="4"></td>
                                            <td><input type="checkbox" class="form-check-input" name="pulse[]" value="5"></td>
                                            <td><input type="checkbox" class="form-check-input" name="pulse[]" value="6"></td>
                                            <td><input type="checkbox" class="form-check-input" name="pulse[]" value="7"></td>
                                            <td><input type="checkbox" class="form-check-input" name="pulse[]" value="8"></td>
                                            <td><input type="checkbox" class="form-check-input" name="pulse[]" value="9"></td>
                                            <td><input type="checkbox" class="form-check-input" name="pulse[]" value="10"></td>
                                            <td><input type="checkbox" class="form-check-input" name="pulse[]" value="11"></td>
                                            <td><input type="checkbox" class="form-check-input" name="pulse[]" value="12"></td>
                                        </tr>
                                        <tr>
                                            <td>Respiratory Rate (Cycle/Minute)</td>
                                            <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="1"></td>
                                            <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="2"></td>
                                            <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="3"></td>
                                            <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="4"></td>
                                            <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="5"></td>
                                            <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="6"></td>
                                            <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="7"></td>
                                            <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="8"></td>
                                            <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="9"></td>
                                            <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="10"></td>
                                            <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="11"></td>
                                            <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="12"></td>
                                        </tr>
                                        <tr>
                                            <td>Blood Pressure (Systolic/Diastolic)</td>
                                            <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="1"></td>
                                            <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="2"></td>
                                            <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="3"></td>
                                            <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="4"></td>
                                            <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="5"></td>
                                            <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="6"></td>
                                            <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="7"></td>
                                            <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="8"></td>
                                            <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="9"></td>
                                            <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="10"></td>
                                            <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="11"></td>
                                            <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="12"></td>
                                        </tr>
                                        <tr>
                                            <td>Urine Voided</td>
                                            <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="1"></td>
                                            <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="2"></td>
                                            <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="3"></td>
                                            <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="4"></td>
                                            <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="5"></td>
                                            <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="6"></td>
                                            <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="7"></td>
                                            <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="8"></td>
                                            <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="9"></td>
                                            <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="10"></td>
                                            <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="11"></td>
                                            <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="12"></td>
                                        </tr>
                                        <tr>
                                            <td>Cervical Dilatation (CM)</td>
                                            <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="1"></td>
                                            <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="2"></td>
                                            <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="3"></td>
                                            <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="4"></td>
                                            <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="5"></td>
                                            <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="6"></td>
                                            <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="7"></td>
                                            <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="8"></td>
                                            <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="9"></td>
                                            <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="10"></td>
                                            <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="11"></td>
                                            <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="12"></td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>




                        <label class="form-label"><b>PROBLEM</b></label>
                        <input type="text" name="problem" class="form-input1" required>
                        <div class="invalid-feedback">
                            PROBLEM is required.
                        </div>

                        <label class="form-label"><b>TIME ONSET</b></label>
                        <input type="text" name="time_onset" class="form-input1" required>
                        <div class="invalid-feedback">
                            TIME ONSET is required.
                        </div>
                        <br>
                        <label class="form-label"><b>TREATMENT OTHER THAN SUPPORT</b></label>
                        <input type="text" name="treatments" class="form-input1" required>
                        <div class="invalid-feedback">
                            TREATMENT OTHER THAN SUPPORT is required.
                        </div>

                        <label class="form-label"><b>IF MOTHER REFERRED DURING LABOUR OR DELIVERY, RECORD TIME AND EXPLAIN</b></label>
                        <input type="text" name="referral_details" class="form-input1">
                    </div>




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="submit" name="saveLabour" class="btn btn-primary">
                    Save
                </button>
            </div>
            </form>
            <!-- <div class="modal-body">
                <div id="print">
                    <div class="form-group">
                        <label><b>USE THIS RECORD FOR MONITORING DURING LABOUR, DELIVERY AND POSTPARTUM</b></label>
                        <span class="ml-4">Case No.:</span>
                        <input type="text" id="view_case_no" class="form-input">
                    </div>

                    <div class="form-group">
                        <label><b>NAME:</b></label>
                        <input type="text" id="name" class="form-input1">
                        <label><b>AGE:</b></label>
                        <input type="text" id="age" class="form-input">
                        <input type="hidden" name="patientid" id="view_patientid">
                    </div>

                    <div class="form-group">
                        <label><b>ADDRESS:</b></label>
                        <input type="text" id="address" class="form-input1">
                    </div>

                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>During Labour</th>
                                <th>At or After Birth - Mother</th>
                                <th>At or After Birth - Newborn</th>
                                <th>PLANNED NEWBORN TREATMENT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <label>Admission Date:</label>
                                    <input type="date" id="addmissiondate" class="form-control">
                                </td>
                                <td>
                                    <label>Birth Time:</label>
                                    <input type="time" id="birthTime" class="form-control">
                                </td>
                                <td>
                                    <label>Livebirth:</label>
                                    <input type="checkbox" name="livebirth" value="Livebirth" class="form-check-input" onclick="toggleCheckbox(this)">
                                    <label>Stillbirth-Fresh:</label>
                                    <input type="checkbox" name="stillbirth_fresh" value="Stillbirth-Fresh" class="form-check-input" onclick="toggleCheckbox(this)">
                                </td>
                                <td>
                                    <textarea id="newbord" class="form-control" style="resize:none;"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Admission Time:</label>
                                    <input type="time" id="admissionTime" class="form-control">
                                </td>
                                <td>
                                    <label>Oxytocin-Time Given:</label>
                                    <input type="time" id="Oxytocin" class="form-control">
                                </td>
                                <td>
                                    <label>RESUSCITATION:</label><br>
                                    Yes <input type="checkbox" name="RESUSCITATION" value="Yes" class="form-check-input" onclick="toggleCheckbox(this)">
                                    No <input type="checkbox" name="RESUSCITATION" value="No" class="form-check-input" onclick="toggleCheckbox(this)">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>TIME ACTIVE LABOUR STARTED:</label>
                                    <input type="time" id="timeactive" class="form-control">
                                </td>
                                <td>
                                    <label>Placenta Complete:</label><br>
                                    Yes <input type="checkbox" name="placentaComplete" value="Yes" class="form-check-input" onclick="toggleCheckbox(this)">
                                    NO <input type="checkbox" name="placentaComplete" value="No" class="form-check-input" onclick="toggleCheckbox(this)">
                                </td>
                                <td>
                                    <label>Birth Weight:</label>
                                    <input type="text" id="birthweight" class="form-control">
                                </td>
                            </tr>
                         
                        </tbody>
                    </table>
                </div>
            </div> -->

        </div>
    </div>
</div>
<!-- end Save Records -->

<div class="modal fade" id="viewRecord" tabindex="-1" aria-labelledby="exampleModalXlLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title h4" id="exampleModalXlLabel">
                    LABOUR RECORD
                </h5>
                <span class="btn btn-secondary mx-auto" onclick="printContent()">
                    <i class="icon-printer"></i> Print
                </span>
                <!-- <span class="btn btn-info" onclick="downlaodcontent('LABOUR_RECORD')">
                                                    <i class="icon-download"></i> download
                                                </span> -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="print">
                    <div style="text-align: left; flex: 1;">
                        <label class="form-label"><b>USE THIS RECORD FOR MONITORING DURING LABOUR, DELIVERY AND POSTPARTUM</b>

                        </label><span style="margin-left: 2rem;">Case No.:</span>


                        <input type="text" id="view_case_no" class="form-input">
                        <br>
                        <label class="form-label"><b>NAME:</b></label>
                        <input type="text" id="name" class="form-input1">
                        <label class="form-label"><b>AGE:</b></label>
                        <input type="text" id="age" class="form-input">
                        <input type="hidden" name="patientid" id="view_patientid">
                        <label class="form-label">Parity:</label>
                        <input type="text" id="parity" name="parity" class="form-input">
                        <br>
                        <label class="form-label"><b>ADDRESS:</b></label>
                        <input type="text" id="address" class="form-input1" style="width: 35%;">
                    </div>


                    <div class="row">
                        <div>
                            <table class="styled-table">
                                <thead>
                                    <tr>
                                        <th>During Labour</th>
                                        <th>At or After Birth - Mother</th>
                                        <th>At or After Birth - Newborn</th>
                                        <th>PLANNED NEWBORN TREATMENT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> <label>Admission Date:</label>
                                            <input type="date" id="addmissiondate" class="form-control">
                                        </td>
                                        <td><label>Birth Time:</label>
                                            <input type="time" id="birthTime" class="form-control">
                                        </td>
                                        <td>
                                            <label>Livebirth:</label>
                                            <input type="checkbox" id="livebirth" value="Livebirth" class="form-check-input" onclick="toggleCheckbox(this)">


                                            <label>Stillbirth-Fresh:</label>
                                            <input type="checkbox" id="stillbirth_fresh" value="Stillbirth-Fresh" class="form-check-input" onclick="toggleCheckbox(this)">

                                        </td>
                                        <td> <textarea id="newbord" class="form-control" style="resize:none;"></textarea></td>

                                    </tr>
                                    <tr>
                                        <td><label>Admission Time:</label>
                                            <input type="time" id="admissionTime" class="form-control">
                                        </td>
                                        <td> <label>Oxytocin-Time Given:</label>
                                            <input type="time" id="Oxytocin" class="form-control">
                                        </td>
                                        <td> <label>RESUSCITATION:</label><br>
                                            Yes <input type="checkbox" name="RESUSCITATION" value="Yes" class="form-check-input" onclick="toggleCheckbox(this)">
                                            No <input type="checkbox" name="RESUSCITATION" value="No" class="form-check-input" onclick="toggleCheckbox(this)"></td>

                                    </tr>
                                    <tr>
                                        <td><label>TIME ACTIVE LABOUR STARTED:</label>
                                            <input type="time" id="timeactive" class="form-control">
                                        </td>
                                        <td><label>Placenta Complete:</label><br>
                                            Yes <input type="checkbox" name="placentaComplete" value="Yes" class="form-check-input" onclick="toggleCheckbox(this)">
                                            NO <input type="checkbox" name="placentaComplete" value="No" class="form-check-input" onclick="toggleCheckbox(this)"></td>
                                        <td><label>Birth Weight:</label>
                                            <input type="text" id="birthweight" class="form-control">
                                        </td>

                                    </tr>
                                    <tr>
                                        <td> <label>TIME MEMBRANES RUPTURED:</label>
                                            <input type="time" id="timeMembranes" class="form-control">
                                        </td>
                                        <td> <label>Time Delivered:</label>
                                            <input type="time" id="timedelevered" class="form-control">
                                        </td>
                                        <td><label>AOG: 36 Wks or Preterm:</label><br>
                                            Yes <input type="checkbox" name="Preterm" value="Yes" class="form-check-input" onclick="toggleCheckbox(this)">
                                            No <input type="checkbox" name="Preterm" value="No" class="form-check-input" onclick="toggleCheckbox(this)"></td>

                                    </tr>
                                    <tr>
                                        <td> <label>TIME SECOND STAGE STARTS:</label>
                                            <input type="time" id="timeSecond" class="form-control">
                                        </td>
                                        <td> <label>Estimated Blood Loss:</label>
                                            <input type="text" id="Estimated" class="form-control">
                                        </td>
                                        <td> <label>Second Baby:</label>
                                            <input type="text" id="secondbaby" class="form-control">
                                        </td>
                                    </tr>

                                    <tr>
                                        <th colspan="14">ENTRY EXAMINATION</th>
                                    </tr>
                                    <tr>
                                        <td>STAGE OF LABOUR</td>
                                        <td>NOT IN ACTIVE LABOUR
                                            <input class="form-check-input" type="checkbox" class="form-check-input" name="stage_of_labour" value="NOT IN ACTIVE LABOUR">
                                        </td>
                                        <td>ACTIVE LABOUR
                                            <input class="form-check-input" type="checkbox" class="form-check-input" name="active_labour" value="ACTIVE LABOUR">
                                        </td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="row">
                        <div>
                            <table class="styled-table">
                                <thead>
                                    <tr>
                                        <th rowspan="2">TIME</th>
                                        <th colspan="12">HOURS SINCE ARRIVAL</th>
                                        <th rowspan="3">PLANNED MATERNAL TREATMENT</th>
                                    </tr>


                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Hours Since Arrival</td>
                                        <td>1</td>
                                        <td>2</td>
                                        <td>3</td>
                                        <td>4</td>
                                        <td>5</td>
                                        <td>6</td>
                                        <td>7</td>
                                        <td>8</td>
                                        <td>9</td>
                                        <td>10</td>
                                        <td>11</td>
                                        <td>12</td>
                                        <td> <textarea id="maternalplan" class="form-control" style="resize:none;"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Hours Since Ruptured Membranes</td>
                                        <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="1"></td>
                                        <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="2"></td>
                                        <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="3"></td>
                                        <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="4"></td>
                                        <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="5"></td>
                                        <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="6"></td>
                                        <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="7"></td>
                                        <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="8"></td>
                                        <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="9"></td>
                                        <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="10"></td>
                                        <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="11"></td>
                                        <td><input type="checkbox" class="form-check-input" name="ruptured_membranes[]" value="12"></td>


                                    </tr>
                                    <tr>
                                        <td>Vaginal Bleeding (0 + ++)</td>
                                        <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="1"></td>
                                        <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="2"></td>
                                        <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="3"></td>
                                        <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="4"></td>
                                        <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="5"></td>
                                        <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="6"></td>
                                        <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="7"></td>
                                        <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="8"></td>
                                        <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="9"></td>
                                        <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="10"></td>
                                        <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="11"></td>
                                        <td><input type="checkbox" class="form-check-input" name="vaginal_bleeding[]" value="12"></td>
                                    </tr>
                                    <tr>
                                        <td>Strong Contractions in 10 Minutes</td>
                                        <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="1"></td>
                                        <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="2"></td>
                                        <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="3"></td>
                                        <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="4"></td>
                                        <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="5"></td>
                                        <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="6"></td>
                                        <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="7"></td>
                                        <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="8"></td>
                                        <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="9"></td>
                                        <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="10"></td>
                                        <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="11"></td>
                                        <td><input type="checkbox" class="form-check-input" name="strong_contractions[]" value="12"></td>
                                    </tr>
                                    <tr>
                                        <td>Fetal Heart Rate (Beats per Minute)</td>
                                        <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="1"></td>
                                        <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="2"></td>
                                        <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="3"></td>
                                        <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="4"></td>
                                        <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="5"></td>
                                        <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="6"></td>
                                        <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="7"></td>
                                        <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="8"></td>
                                        <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="9"></td>
                                        <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="10"></td>
                                        <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="11"></td>
                                        <td><input type="checkbox" class="form-check-input" name="fetal_heart_rate[]" value="12"></td>
                                    </tr>
                                    <tr>
                                        <td>T (Axillary)</td>
                                        <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="1"></td>
                                        <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="2"></td>
                                        <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="3"></td>
                                        <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="4"></td>
                                        <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="5"></td>
                                        <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="6"></td>
                                        <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="7"></td>
                                        <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="8"></td>
                                        <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="9"></td>
                                        <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="10"></td>
                                        <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="11"></td>
                                        <td><input type="checkbox" class="form-check-input" name="temperature_axillary[]" value="12"></td>
                                    </tr>
                                    <tr>
                                        <td>Pulse (Beats/Minute)</td>
                                        <td><input type="checkbox" class="form-check-input" name="pulse[]" value="1"></td>
                                        <td><input type="checkbox" class="form-check-input" name="pulse[]" value="2"></td>
                                        <td><input type="checkbox" class="form-check-input" name="pulse[]" value="3"></td>
                                        <td><input type="checkbox" class="form-check-input" name="pulse[]" value="4"></td>
                                        <td><input type="checkbox" class="form-check-input" name="pulse[]" value="5"></td>
                                        <td><input type="checkbox" class="form-check-input" name="pulse[]" value="6"></td>
                                        <td><input type="checkbox" class="form-check-input" name="pulse[]" value="7"></td>
                                        <td><input type="checkbox" class="form-check-input" name="pulse[]" value="8"></td>
                                        <td><input type="checkbox" class="form-check-input" name="pulse[]" value="9"></td>
                                        <td><input type="checkbox" class="form-check-input" name="pulse[]" value="10"></td>
                                        <td><input type="checkbox" class="form-check-input" name="pulse[]" value="11"></td>
                                        <td><input type="checkbox" class="form-check-input" name="pulse[]" value="12"></td>
                                    </tr>
                                    <tr>
                                        <td>Respiratory Rate (Cycle/Minute)</td>
                                        <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="1"></td>
                                        <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="2"></td>
                                        <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="3"></td>
                                        <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="4"></td>
                                        <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="5"></td>
                                        <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="6"></td>
                                        <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="7"></td>
                                        <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="8"></td>
                                        <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="9"></td>
                                        <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="10"></td>
                                        <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="11"></td>
                                        <td><input type="checkbox" class="form-check-input" name="respiratory_rate[]" value="12"></td>
                                    </tr>
                                    <tr>
                                        <td>Blood Pressure (Systolic/Diastolic)</td>
                                        <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="1"></td>
                                        <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="2"></td>
                                        <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="3"></td>
                                        <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="4"></td>
                                        <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="5"></td>
                                        <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="6"></td>
                                        <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="7"></td>
                                        <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="8"></td>
                                        <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="9"></td>
                                        <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="10"></td>
                                        <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="11"></td>
                                        <td><input type="checkbox" class="form-check-input" name="blood_pressure[]" value="12"></td>
                                    </tr>
                                    <tr>
                                        <td>Urine Voided</td>
                                        <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="1"></td>
                                        <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="2"></td>
                                        <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="3"></td>
                                        <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="4"></td>
                                        <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="5"></td>
                                        <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="6"></td>
                                        <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="7"></td>
                                        <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="8"></td>
                                        <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="9"></td>
                                        <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="10"></td>
                                        <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="11"></td>
                                        <td><input type="checkbox" class="form-check-input" name="urine_voided[]" value="12"></td>
                                    </tr>
                                    <tr>
                                        <td>Cervical Dilatation (CM)</td>
                                        <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="1"></td>
                                        <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="2"></td>
                                        <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="3"></td>
                                        <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="4"></td>
                                        <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="5"></td>
                                        <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="6"></td>
                                        <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="7"></td>
                                        <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="8"></td>
                                        <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="9"></td>
                                        <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="10"></td>
                                        <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="11"></td>
                                        <td><input type="checkbox" class="form-check-input" name="cervical_dilatation[]" value="12"></td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>




                    <label class="form-label"><b>PROBLEM</b></label>
                    <input type="text" id="problem" class="form-input1">


                    <label class="form-label"><b>TIME ONSET</b></label>
                    <input type="text" id="timeonset" class="form-input1">
                    <br>
                    <label class="form-label"><b>TREATMENT OTHER THAN SUPPORT</b></label>
                    <input type="text" id="treatmentsupport" class="form-input1">


                    <label class="form-label"><b>IF MOTHER REFERRED DURING LABOUR OR DELIVERY, RECORD TIME AND EXPLAIN</b></label>
                    <input type="text" id="referralMother" class="form-input1">
                </div>




            </div>
            <!-- <div class="modal-body">
                <div id="print">
                    <div class="form-group">
                        <label><b>USE THIS RECORD FOR MONITORING DURING LABOUR, DELIVERY AND POSTPARTUM</b></label>
                        <span class="ml-4">Case No.:</span>
                        <input type="text" id="view_case_no" class="form-input">
                    </div>

                    <div class="form-group">
                        <label><b>NAME:</b></label>
                        <input type="text" id="name" class="form-input1">
                        <label><b>AGE:</b></label>
                        <input type="text" id="age" class="form-input">
                        <input type="hidden" name="patientid" id="view_patientid">
                    </div>

                    <div class="form-group">
                        <label><b>ADDRESS:</b></label>
                        <input type="text" id="address" class="form-input1">
                    </div>

                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>During Labour</th>
                                <th>At or After Birth - Mother</th>
                                <th>At or After Birth - Newborn</th>
                                <th>PLANNED NEWBORN TREATMENT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <label>Admission Date:</label>
                                    <input type="date" id="addmissiondate" class="form-control">
                                </td>
                                <td>
                                    <label>Birth Time:</label>
                                    <input type="time" id="birthTime" class="form-control">
                                </td>
                                <td>
                                    <label>Livebirth:</label>
                                    <input type="checkbox" name="livebirth" value="Livebirth" class="form-check-input" onclick="toggleCheckbox(this)">
                                    <label>Stillbirth-Fresh:</label>
                                    <input type="checkbox" name="stillbirth_fresh" value="Stillbirth-Fresh" class="form-check-input" onclick="toggleCheckbox(this)">
                                </td>
                                <td>
                                    <textarea id="newbord" class="form-control" style="resize:none;"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Admission Time:</label>
                                    <input type="time" id="admissionTime" class="form-control">
                                </td>
                                <td>
                                    <label>Oxytocin-Time Given:</label>
                                    <input type="time" id="Oxytocin" class="form-control">
                                </td>
                                <td>
                                    <label>RESUSCITATION:</label><br>
                                    Yes <input type="checkbox" name="RESUSCITATION" value="Yes" class="form-check-input" onclick="toggleCheckbox(this)">
                                    No <input type="checkbox" name="RESUSCITATION" value="No" class="form-check-input" onclick="toggleCheckbox(this)">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>TIME ACTIVE LABOUR STARTED:</label>
                                    <input type="time" id="timeactive" class="form-control">
                                </td>
                                <td>
                                    <label>Placenta Complete:</label><br>
                                    Yes <input type="checkbox" name="placentaComplete" value="Yes" class="form-check-input" onclick="toggleCheckbox(this)">
                                    NO <input type="checkbox" name="placentaComplete" value="No" class="form-check-input" onclick="toggleCheckbox(this)">
                                </td>
                                <td>
                                    <label>Birth Weight:</label>
                                    <input type="text" id="birthweight" class="form-control">
                                </td>
                            </tr>
                         
                        </tbody>
                    </table>
                </div>
            </div> -->

        </div>
    </div>
</div>

<div class="modal fade" id="deliveryRecord" tabindex="-1" aria-labelledby="exampleModalXlLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title h4" id="exampleModalXlLabel">
                    DELIVERY ROOM RECORD
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="deliveryRecordForm" novalidate>
                    <input type="hidden" name="patientid" id="patient">
                    <div class="row mb-3">
                        <!-- <div class="col-md-6">
                            <label for="patientName" class="form-label">Patient's Name:</label>
                            <input type="text" class="form-control" id="patientName" name="patientName" required>
                        </div>
                        <div class="col-md-2">
                            <label for="age" class="form-label">Age:</label>
                            <input type="text" class="form-control" id="age" name="age" required>
                        </div> -->
                        <div class="col-md-4">
                            <label for="dateAdmitted" class="form-label">Date Admitted:</label>
                            <input type="text" id="dateAdmitted" class="form-input1" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="lmp" class="form-label">LMP:</label>
                            <input type="text" class="form-input1" id="lmp" name="lmp" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="edc" class="form-label">EDC:</label>
                            <input type="text" class="form-input1" id="edc" name="edc" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="aog" class="form-label">AOG:</label>
                            <input type="text" class="form-input1" id="aog" name="aog" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="gravida" class="form-label">Gravida:</label>
                            <input type="text" class="form-input1" id="gravida" name="gravida" required>
                        </div>
                        <div class="col-md-2">
                            <label for="para" class="form-label">Para:</label>
                            <input type="text" class="form-input1" id="para" name="para" required>
                        </div>
                    </div>
                    <div class="row mb-3">


                        <div class="col-md-2">
                            <label for="fullTerm" class="form-label">Full Term:</label>
                            <input type="text" class="form-input1" id="fullTerm" name="fullTerm" required>
                        </div>
                        <div class="col-md-2">
                            <label for="premature" class="form-label">Premature:</label>
                            <input type="text" class="form-input1" id="premature" name="premature">
                        </div>
                        <div class="col-md-2">
                            <label for="abortion" class="form-label">Abortion:</label>
                            <input type="text" class="form-input1" id="abortion" name="abortion">
                        </div>
                        <div class="col-md-3">
                            <label for="noOfLiving" class="form-label">No. of Living:</label>
                            <input type="text" class="form-input1" id="noOfLiving" name="noOfLiving">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><b>LABOR</b></label>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>TIME</th>
                                        <th>DATE</th>
                                        <th>STAGE OF LABOR</th>
                                        <th class="text-center">DURATION OF LABOR</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="labor[]" value="Onset" class="form-check-input" onclick="toggleCheckbox(this)">
                                            <label> Onset</label><br>
                                            <input type="checkbox" name="labor[]" value="Spontaneous" class="form-check-input" onclick="toggleCheckbox(this)">
                                            <label> Spontaneous</label><br>
                                            <input type="checkbox" name="labor[]" value="Induced" class="form-check-input" onclick="toggleCheckbox(this)">
                                            <label> Induced</label>
                                            <div class="invalid-feedback">
                                                is required.
                                            </div>
                                        </td>
                                        <td>
                                            <input type="time" name="laborTime" class="form-control" required>
                                            <!-- 
                                            <div class="invalid-feedback">
                                                is required.
                                            </div> -->
                                        </td>

                                        <td>

                                            <input type="date" name="laborDate" class="form-control" required>


                                        </td>
                                        <td class="text-center">
                                            <!-- <input type="checkbox" name="Livebirth" value="Livebirth" class="form-check-input" onclick="toggleCheckbox(this)"> -->
                                            <label> I</label>

                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="laborHrs" placeholder="Hrs.">
                                        </td>
                                        <td>

                                            <input type="text" class="form-control" name="laborMins" placeholder="Mins.">
                                        </td>

                                    </tr>
                                    <tr>
                                        <td><label for="text">Cervix Fully Dilated</label> </td>
                                        <td><input type="time" name="CervixTime" class="form-control" required></td>
                                        <td><input type="date" name="CervixDate" class="form-control" required></td>
                                        <td class="text-center">

                                            <label> II</label>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="CervixHrs" placeholder="Hrs.">
                                        </td>
                                        <td>

                                            <input type="text" class="form-control" name="CervixMins" placeholder="Mins.">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="text">Baby Delivered</label></td>
                                        <td><input type="time" name="BabylaborTime" class="form-control" required></td>
                                        <td><input type="date" name="BabylaborDate" class="form-control" required></td>
                                        <td class="text-center">

                                            <label> III</label>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="babyHrs" placeholder="Hrs.">
                                        </td>
                                        <td>

                                            <input type="text" class="form-control" name="babyMins" placeholder="Mins.">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="text">Placenta Delivered</label></td>
                                        <td><input type="time" name="PlacentaTime" class="form-control" required></td>
                                        <td><input type="date" name="PlacentaDate" class="form-control" required></td>
                                        <td>
                                            <label for="text">Total Duration</label>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="PlacentaHrs" placeholder="Hrs.">
                                        </td>
                                        <td>

                                            <input type="text" class="form-control" name="PlacentaMins" placeholder="Mins.">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><b>PLACENTA</b></label>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>PLACENTA</th>
                                        <th>UMBILICAL CORD</th>
                                        <th>ESTIMATED BLOOD LOSS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="placentaExpelled[]" class="form-check-input" value="placentaExpelled">
                                            <label for="placentaExpelled">Expelled Completely</label><br>
                                            <input type="checkbox" name="placentaExpelled[]" class="form-check-input" value="placentaRetained">
                                            <label for="placentaRetained">Retained for Method of Expulsion</label><br>
                                            <input type="checkbox" name="placentaExpelled[]" class="form-check-input" value="placentaSpontaneous">
                                            <label for="placentaSpontaneous">Spontaneous</label><br>
                                            <input type="checkbox" name="placentaExpelled[]" class="form-check-input" value="placentaManualExtraction">
                                            <label for="placentaManualExtraction">Manual Extraction</label><br>

                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="cm" placeholder="Cm.">
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control me-2" name="no_nexk" placeholder="No. of Loops at Neck">
                                                <input type="checkbox" name="no_nexk" value="None" class="form-check-input me-1">
                                                <label> None</label>
                                            </div>
                                            <div class="d-flex align-items-center">

                                                <input type="text" class="form-control me-2" name="umbilicalCordLoops" placeholder="Other Abnormalities">
                                                <input type="checkbox" name="umbilicalCordLoops" value="None" class="form-check-input  me-1">
                                                <label> None</label>

                                            </div>
                                            <input type="text" class="form-control" name="placentaOther" placeholder="Other (Specify)">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="bloodLossAntepartum" placeholder="Antepartum">
                                            <input type="text" class="form-control" name="bloodLossIntrapartum" placeholder="Intrapartum">
                                            <input type="text" class="form-control" name="bloodLossPostpartum" placeholder="Postpartum">
                                            <input type="text" class="form-control" name="totalBloodLoss" placeholder="Total Est. Blood Loss">
                                        </td>
                                        <td>
                                            <label for="text" class="form-control">CC</label>
                                            <label for="text" class="form-control">CC</label>
                                            <label for="text" class="form-control">CC</label>
                                            <label for="text" class="form-control">CC</label>

                                        </td>


                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><b>METHOD OF DELIVERY</b></label>

                            <div class="mb-3">

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="method[]" value="NSVD" onclick="toggleCheckbox(this)">
                                    <label class="form-check-label" for="inlineRadio2">NSVD</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="method[]" value="Cesarean" onclick="toggleCheckbox(this)">
                                    <label class="form-check-label" for="inlineRadio2">Cesarean</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="method[]" value="OF" onclick="toggleCheckbox(this)">
                                    <label class="form-check-label" for="inlineRadio2">OF</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="method[]" value="LF" onclick="toggleCheckbox(this)">
                                    <label class="form-check-label" for="inlineRadio2">LF</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="method[]" value="TBE" onclick="toggleCheckbox(this)">
                                    <label class="form-check-label" for="inlineRadio2">TBE</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="method[]" value="PBE" onclick="toggleCheckbox(this)">
                                    <label class="form-check-label" for="inlineRadio2">PBE</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="method[]" value="CCS" onclick="toggleCheckbox(this)">
                                    <label class="form-check-label" for="inlineRadio2">CCS</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="method[]" value="ME" onclick="toggleCheckbox(this)">
                                    <label class="form-check-label" for="inlineRadio2">ME</label>
                                </div>
                                <div class="form-check form-check-inline">


                                    <input class="form-check-input" type="checkbox" name="method[]" value="Other">
                                    <label class="form-check-label" for="inlineRadio2">Other (Specify)</label>
                                    <input class="form-input1" type="text" name="method[]" value="">
                                </div>
                            </div>
                            <div class="row mb-3">

                                <div class="col-md-12">
                                    <label class="form-label"><b>INDICATION FOR OPERATIVE DELIVERY:</b></label>
                                    <div class="mb-3">
                                        <label class="form-check-label" for="inlineRadio2">Episiotomy: </label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="Episiotomy[]" value="Median" onclick="toggleCheckbox(this)">
                                            <label class="form-check-label" for="inlineRadio2">Median</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="Episiotomy[]" value="Right Med. Lateral" onclick="toggleCheckbox(this)">
                                            <label class="form-check-label" for="inlineRadio2">Right Med. Lateral</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="Episiotomy[]" value="Left Med. Lateral" onclick="toggleCheckbox(this)">
                                            <label class="form-check-label" for="inlineRadio2">Left Med. Lateral</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="Episiotomy[]" value="None" onclick="toggleCheckbox(this)">
                                            <label class="form-check-label" for="inlineRadio2">None</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="Episiotomy[]" value="Extension" onclick="toggleCheckbox(this)">
                                            <label class="form-check-label" for="inlineRadio2">Extension</label>
                                        </div>

                                    </div>
                                    <div class="mb-3">
                                        <label class="form-check-label" for="inlineRadio2">Laceration: </label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="Laceration[]" value="Perinial 1 2 3" onclick="toggleCheckbox(this)">
                                            <label class="form-check-label" for="inlineRadio2">Perinial 1" 2" 3"</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="Laceration[]" value="Vaginal" onclick="toggleCheckbox(this)">
                                            <label class="form-check-label" for="inlineRadio2">Vaginal </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="Laceration[]" value="Cervical" onclick="toggleCheckbox(this)">
                                            <label class="form-check-label" for="inlineRadio2">Cervical</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="Laceration[]" value="Repaired" onclick="toggleCheckbox(this)">
                                            <label class="form-check-label" for="inlineRadio2">Repaired</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="Laceration[]" value="Not Repaired" onclick="toggleCheckbox(this)">
                                            <label class="form-check-label" for="inlineRadio2">Not Repaired</label>
                                        </div>

                                    </div>
                                    <div class="mb-3">
                                        <label class="form-check-label" for="inlineRadio2">Anethesia: </label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="Anethesia[]" value="Local Infiltration" onclick="toggleCheckbox(this)">
                                            <label class="form-check-label" for="inlineRadio2">Local Infiltration</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="Anethesia[]" value="General Inhalation" onclick="toggleCheckbox(this)">
                                            <label class="form-check-label" for="inlineRadio2">General Inhalation</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="Anethesia[]" value="None" onclick="toggleCheckbox(this)">
                                            <label class="form-check-label" for="inlineRadio2">None</label>
                                        </div>


                                    </div>
                                    <div class="mb-3">
                                        <label class="form-check-label" for="inlineRadio2">Analgesia: </label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="Analgesia[]" value="Yes" onclick="toggleCheckbox(this)">
                                            <label class="form-check-label" for="inlineRadio2">Yes</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="Analgesia[]" value="None" onclick="toggleCheckbox(this)">
                                            <label class="form-check-label" for="inlineRadio2">None</label>
                                        </div>


                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label"><b>CONDITION UPON LEAVING THE DELIVERY ROOM</b></label>
                                <div class="mb-3">

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="condition[]" value="Awake" onclick="toggleCheckbox(this)">
                                        <label class="form-check-label" for="inlineRadio2">Awake</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="condition[]" value="Reactive" onclick="toggleCheckbox(this)">
                                        <label class="form-check-label" for="inlineRadio2">Reactive</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="condition[]" value="Depressed" onclick="toggleCheckbox(this)">
                                        <label class="form-check-label" for="inlineRadio2">Depressed</label>
                                    </div>


                                </div>




                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-12">
                                <label class="form-label"><b>URINARY BLADDER:</b></label>
                                <div class="mb-3">

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="urinary_bladder[]" value="W/Catheter" onclick="toggleCheckbox(this)">
                                        <label class="form-check-label" for="inlineRadio2">W/Catheter</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="urinary_bladder[]" value="Voided" onclick="toggleCheckbox(this)">
                                        <label class="form-check-label" for="inlineRadio2">Voided</label>
                                    </div>

                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label" for="inlineRadio2">Total Urine Output: </label>
                                        <input class="form-input1" type="text" name="urinary_bladder[]" value="" onclick="toggleCheckbox(this)">
                                        <label class="form-check-label" for="inlineRadio2">CC</label>
                                    </div>


                                </div>




                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-12">
                                <label class="form-label"><b>VITAL SIGNS:</b></label>
                                <div class="mb-3">



                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label" for="inlineRadio2">BP: </label>
                                        <input class="form-input1" type="text" id="bp" value="" readonly>

                                    </div>

                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label" for="inlineRadio2">PR: </label>
                                        <input class="form-input1" type="text" id="pr" value="" readonly>

                                    </div>

                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label" for="inlineRadio2">RR: </label>
                                        <input class="form-input1" type="text" id="rr" value="" readonly>

                                    </div>

                                    <div class="form-check form-check-inline">

                                        <label class="form-check-label" for="inlineRadio2">T: </label>
                                        <input class="form-input1" type="text" id="t" value="" readonly>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-12">
                                <label class="form-label"><b>UTERUS:</b></label>
                                <div class="mb-3">

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="uterus[]" value="Well Contracted" onclick="toggleCheckbox(this)">
                                        <label class="form-check-label" for="inlineRadio2">Well Contracted </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="uterus[]" value="Relaxing" onclick="toggleCheckbox(this)">
                                        <label class="form-check-label" for="inlineRadio2">Relaxing </label>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <label class="form-check-label me-2" for="complicationsRelated">COMPLICATIONS RELATED TO PREGNANCY: </label>
                                        <input class="form-input1 me-2" type="text" name="pregnancy" id="pregnancyInput" value="">
                                        <input class="form-check-input me-1" type="checkbox" name="pregnancy" id="pregnancyCheckbox" value="None">
                                        <label class="form-check-label" for="pregnancyCheckbox">None</label>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <label class="form-check-label me-2" for="complicationsNotRelated">COMPLICATIONS NOT RELATED TO PREGNANCY: </label>
                                        <input class="form-input1 me-2" type="text" name="not_related" id="notRelatedInput" value="">
                                        <input class="form-check-input me-1" type="checkbox" name="not_related" id="notRelatedCheckbox" value="None">
                                        <label class="form-check-label" for="notRelatedCheckbox">None</label>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <label class="form-check-label me-2" for="complicationsLabor">COMPLICATION OF LABOR: </label>
                                        <input class="form-input1 me-2" type="text" name="complications" id="laborInput" value="">
                                        <input class="form-check-input me-1" type="checkbox" name="complications" id="laborCheckbox" value="None">
                                        <label class="form-check-label" for="laborCheckbox">None</label>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="row mb-3">
                            <div class="col-md-12">

                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <label for="handledBy">Handled by:</label>
                                                <input type="text" class="form-control" name="handledBy">
                                            </td>
                                            <td>
                                                <label for="assistedBy">Assisted by:</label>
                                                <input type="text" class="form-control" name="assistedBy">
                                            </td>
                                            <td>
                                                <label for="physicianOnDuty">Physician on duty:</label>
                                                <select name="physician" id="" class="form-select">

                                                    <?php echo $physician; ?>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="savedeliveryRecord" class="btn btn-primary">Save</button>

                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="ViewdeliveryRecord" tabindex="-1" aria-labelledby="exampleModalXlLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title h4" id="exampleModalXlLabel">
                   POSPARTOM MONITORING RECORD
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <input type="hidden" name="patientid" id="patient">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="patientName" class="form-label">Patient's Name:</label>
                        <input type="text" class="form-input1" id="patientName" name="patientName" required>
                    </div>
                    <div class="col-md-2">
                        <label for="age" class="form-label">Age:</label>
                        <input type="text" class="form-input1" id="age" name="age" required>
                    </div>
                    <div class="col-md-4">
                        <label for="dateAdmitted" class="form-label">Date Admitted:</label>
                        <input type="text" id="dateAdmitted" class="form-input1" required>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>

