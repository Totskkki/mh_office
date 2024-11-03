<div class="modal fade" id="ViewdeliveryRecord" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ViewdeliveryRecord">
                    DELIVERY ROOM RECORD
                </h5>
                <span class=" mx-auto">
                    <a href="#" id="printdelivery" target="_blank" class="btn btn-secondary"> <i class="icon-printer"></i> Print</a> </span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <input type="hidden" name="patientid" id="patients">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="patientName" class="form-label">Patient's Name:</label>
                        <input type="text" class="form-input1" id="patientName" name="patientName" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="age" class="form-label">Age:</label>
                        <input type="text" class="form-input1" id="patientage" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="date" class="form-label">Date admitted:</label>
                        <input type="text" class="form-input1" id="Admitted" readonly>
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label for="lmp" class="form-label">LMP:</label>
                        <input type="text" class="form-input1" id="lmp1" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="edc" class="form-label">EDC:</label>
                        <input type="text" class="form-input1" id="edc1" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="aog" class="form-label">AOG:</label>
                        <input type="text" class="form-input1" id="aog1" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="gravida" class="form-label">Gravida:</label>
                        <input type="text" class="form-input1" id="gravida" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="para" class="form-label">Para:</label>
                        <input type="text" class="form-input1" id="para" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="fullTerm" class="form-label">Full Term:</label>
                        <input type="text" class="form-input1" id="fullTerm" name="fullTerm" readonly>
                    </div>
                </div>
                <div class="row mb-3">



                    <div class="col-md-2">
                        <label for="premature" class="form-label">Premature:</label>
                        <input type="text" class="form-input1" id="premature" name="premature" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="abortion" class="form-label">Abortion:</label>
                        <input type="text" class="form-input1" id="abortion" name="abortion" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="noOfLiving" class="form-label">No. of Living:</label>
                        <input type="text" class="form-input1" id="noOfLiving" name="noOfLiving" readonly>
                    </div>
                </div>


                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label"><b>LABOR</b></label>
                        <div class="table-responsive">
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
                                        <td id="checkbox-container">
                                            <input type="checkbox" name="labor[]" value="Onset" class="form-check-input" onclick="toggleCheckbox(this)" disabled>
                                            <label> Onset</label><br>
                                            <input type="checkbox" name="labor[]" value="Spontaneous" class="form-check-input" onclick="toggleCheckbox(this)" disabled>
                                            <label> Spontaneous</label><br>
                                            <input type="checkbox" name="labor[]" value="Induced" class="form-check-input" onclick="toggleCheckbox(this)" disabled>
                                            <label> Induced</label>
                                            <div class="invalid-feedback">
                                                is required.
                                            </div>
                                        </td>
                                        <td>
                                            <input type="time" name="laborTime" class="form-control" readonly>
                                            <!-- 
                                            <div class="invalid-feedback">
                                                is required.
                                            </div> -->
                                        </td>

                                        <td>

                                            <input type="text" name="laborDate" class="form-control" readonly>




                                        </td>
                                        <td class="text-center">
                                            <!-- <input type="checkbox" name="Livebirth" value="Livebirth" class="form-check-input" onclick="toggleCheckbox(this)"> -->
                                            <label> I</label>

                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="laborHrs" placeholder="Hrs." readonly>
                                        </td>
                                        <td>

                                            <input type="text" class="form-control" name="laborMins" placeholder="Mins." readonly>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td><label for="text">Cervix Fully Dilated</label> </td>
                                        <td><input type="time" name="CervixTime" class="form-control" readonly></td>
                                        <td> <input type="text" name="CervixDate" class="form-control" readonly>

                                        </td>
                                        <td class="text-center">

                                            <label> II</label>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="CervixHrs" placeholder="Hrs." readonly>
                                        </td>
                                        <td>

                                            <input type="text" class="form-control" name="CervixMins" placeholder="Mins." readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="text">Baby Delivered</label></td>
                                        <td><input type="time" name="BabylaborTime" class="form-control" readonly></td>
                                        <td> <input type="text" name="BabylaborDate" class="form-control" readonly>

                                        </td>
                                        <td class="text-center">

                                            <label> III</label>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="babyHrs" placeholder="Hrs." readonly>
                                        </td>
                                        <td>

                                            <input type="text" class="form-control" name="babyMins" placeholder="Mins." readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="text">Placenta Delivered</label></td>
                                        <td><input type="time" name="PlacentaTime" class="form-control" readonly></td>
                                        <td> <input type="text" name="PlacentaDate" class="form-control" readonly>


                                        </td>
                                        <td>
                                            <label for="text">Total Duration</label>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="PlacentaHrs" placeholder="Hrs." readonly>
                                        </td>
                                        <td>

                                            <input type="text" class="form-control" name="PlacentaMins" placeholder="Mins." readonly>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
                                        <input type="checkbox" name="placentaExpelled[]" class="form-check-input" value="Expelled Completely" disabled>
                                        <label for="placentaExpelled">Expelled Completely</label><br>
                                        <input type="checkbox" name="placentaExpelled[]" class="form-check-input" value="Retained for Method of Expulsion" disabled>
                                        <label for="placentaRetained">Retained for Method of Expulsion</label><br>
                                        <input type="checkbox" name="placentaExpelled[]" class="form-check-input" value="Spontaneous" disabled>
                                        <label for="placentaSpontaneous">Spontaneous</label><br>
                                        <input type="checkbox" name="placentaExpelled[]" class="form-check-input" value="Manual Extraction" disabled>
                                        <label for="placentaManualExtraction">Manual Extraction</label><br>

                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="cm" placeholder="Cm." readonly>
                                        <div class="d-flex align-items-center">
                                            <input type="text" class="form-control me-2" name="no_nexk" placeholder="No. of Loops at Neck" readonly>
                                            <input type="checkbox" name="no_nexk" value="None" class="form-check-input me-1" disabled>
                                            <label> None</label>
                                        </div>
                                        <div class="d-flex align-items-center">

                                            <input type="text" class="form-control me-2" name="umbilicalCordLoops" placeholder="Other Abnormalities" readonly>
                                            <input type="checkbox" name="umbilicalCordLoops" value="None" class="form-check-input  me-1" disabled>
                                            <label> None</label>

                                        </div>
                                        <input type="text" class="form-control" name="placentaOther" placeholder="Other (Specify)" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="bloodLossAntepartum" placeholder="Antepartum" readonly>
                                        <input type="text" class="form-control" name="bloodLossIntrapartum" placeholder="Intrapartum" readonly>
                                        <input type="text" class="form-control" name="bloodLossPostpartum" placeholder="Postpartum" readonly>
                                        <input type="text" class="form-control" name="totalBloodLoss" placeholder="Total Est. Blood Loss" readonly>
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
                                <input class="form-check-input" type="checkbox" name="method[]" value="Other" id="checkboxOther">
                                <label class="form-check-label" for="checkboxOther">Other (Specify)</label>
                                <input class="form-input1" type="text" name="method_details" id="inputOther" value="">
                            </div>
                            <div class="invalid-feedback method-invalid-feedback">
                                At least one method of delivery option is required.
                            </div>
                        </div>
                        <div class="row mb-3">

                            <div class="col-md-12">
                                <label class="form-label"><b>INDICATION FOR OPERATIVE DELIVERY:</b></label>
                                <div class="mb-3">
                                    <label class="form-check-label" for="inlineRadio2">Episiotomy: </label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="Episiotomy[]" value="Median">
                                        <label class="form-check-label" for="inlineRadio2">Median</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="Episiotomy[]" value="Right Med. Lateral">
                                        <label class="form-check-label" for="inlineRadio2">Right Med. Lateral</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="Episiotomy[]" value="Left Med. Lateral">
                                        <label class="form-check-label" for="inlineRadio2">Left Med. Lateral</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="Episiotomy[]" value="None">
                                        <label class="form-check-label" for="inlineRadio2">None</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="Episiotomy[]" value="Extension">
                                        <label class="form-check-label" for="inlineRadio2">Extension</label>
                                    </div>
                                    <div class="invalid-feedback Episiotomy-invalid-feedback">
                                        At least one option is required.
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
                                    <div class="invalid-feedback Laceration-invalid-feedback">
                                        At least one option is required.
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
                                    <div class="invalid-feedback Anethesia-invalid-feedback">
                                        At least one option is required.
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
                                    <div class="invalid-feedback Analgesia-invalid-feedback">
                                        At least one option is required.
                                    </div>


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
                            <div class="invalid-feedback condition-invalid-feedback">
                                At least one option is required.
                            </div>


                        </div>




                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="form-label"><b>URINARY BLADDER:</b></label>
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="urinary_bladder[]" value="W/Catheter" id="urinaryBladderWC">
                                <label class="form-check-label" for="urinaryBladderWC">W/Catheter</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="urinary_bladder[]" value="Voided" id="urinaryBladderVoided">
                                <label class="form-check-label" for="urinaryBladderVoided">Voided</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="urinaryBladderTotalOutput">Total Urine Output:</label>
                                <input class="form-input1" type="text" name="urinary_bladder_output" id="urinaryBladderTotalOutput" value="">
                                <label class="form-check-label" for="urinaryBladderTotalOutput">CC</label>
                            </div>
                            <div class="invalid-feedback urinary_bladder-invalid-feedback">
                                At least one option is required.
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
                                <input class="form-input1" type="text" id="bp1" value="" readonly>

                            </div>

                            <div class="form-check form-check-inline">

                                <label class="form-check-label" for="inlineRadio2">PR: </label>
                                <input class="form-input1" type="text" id="pr1" value="" readonly>

                            </div>

                            <div class="form-check form-check-inline">

                                <label class="form-check-label" for="inlineRadio2">RR: </label>
                                <input class="form-input1" type="text" id="rr1" value="" readonly>

                            </div>

                            <div class="form-check form-check-inline">

                                <label class="form-check-label" for="inlineRadio2">T: </label>
                                <input class="form-input1" type="text" id="t1" value="" readonly>

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
                            <div class="invalid-feedback uterus-invalid-feedback">
                                At least one option is required.
                            </div>


                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <label class="form-check-label me-2" for="complicationsRelated">COMPLICATIONS RELATED TO PREGNANCY: </label>
                                <input class="form-input1 me-2" type="text" name="pregnancy" id="pregnancyInput1" value="">
                                <input class="form-check-input me-1" type="checkbox" name="pregnancy" id="pregnancyCheckbox1" value="None">
                                <label class="form-check-label" for="pregnancyCheckbox">None</label>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label class="form-check-label me-2" for="complicationsNotRelated">COMPLICATIONS NOT RELATED TO PREGNANCY: </label>
                                <input class="form-input1 me-2" type="text" name="not_related" id="notRelatedInput1" value="">
                                <input class="form-check-input me-1" type="checkbox" name="not_related" id="notRelatedCheckbox1" value="None">
                                <label class="form-check-label" for="notRelatedCheckbox">None</label>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label class="form-check-label me-2" for="complicationsLabor">COMPLICATION OF LABOR: </label>
                                <input class="form-input1 me-2" type="text" name="complications" id="laborInput1" value="">
                                <input class="form-check-input me-1" type="checkbox" name="complications" id="laborCheckbox1" value="None">
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
                                        <input type="text" class="form-control" id="handledBy" required>
                                        <div class="invalid-feedback">
                                            Handled by is required.
                                        </div>
                                    </td>
                                    <td>
                                        <label for="assistedBy">Assisted by:</label>
                                        <input type="text" class="form-control" id="assistedBy" required>
                                        <div class="invalid-feedback">
                                            Assisted by is required.
                                        </div>
                                    </td>
                                    <td>
                                        <label for="physicianOnDuty">Physician on duty:</label>
                                        <select name="physician" id="physician" class="form-select" required>

                                            <?php echo $physician; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Physician on duty is required.
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>
<!-- start Save Records -->
<div class="modal fade" id="labourRecord" tabindex="-1" aria-labelledby="labourRecord" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title h4" id="labourRecord">
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
                            <div class="table-responsive">
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
                            <div class="table-responsive">
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
                <button type="submit" name="saveLabour" class="btn btn-info"><i class="icon-save"></i> Save  </button>
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

<div class="modal fade" id="viewRecord" tabindex="-1" aria-labelledby="viewRecord" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title h4" id="viewRecord   ">
                    LABOUR RECORD
                </h5>
                <span class=" mx-auto">
                    <a href="#" id="printPdfButton" target="_blank" class="btn btn-secondary"> <i class="icon-printer"></i> Print</a> </span>

                <!-- <span class="btn btn-secondary mx-auto" onclick="printContent()">
                    <i class="icon-printer"></i> Print
                </span>  -->

                <!-- <span class="btn btn-info" onclick="downlaodcontent('LABOUR_RECORD')">
                                                    <i class="icon-download"></i> download
                                                </span> -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div id="print">
                    <form  method="POST" action="./controller/update_labour.php">
                        <div style="text-align: left; flex: 1;">
                            <label class="form-label"><b>USE THIS RECORD FOR MONITORING DURING LABOUR, DELIVERY AND POSTPARTUM</b>

                            </label><span style="margin-left: 2rem;">Case No.:</span>

                          
                            <input type="hidden" name="birthMonitorID" id="birthMonitorID">

                            <input type="text" id="view_case_no"name="case_no" class="form-input">
                            <br>
                            <label class="form-label"><b>NAME:</b></label>
                            <input type="text" id="name" class="form-input1">
                            <label class="form-label"><b>AGE:</b></label>
                            <input type="text" id="age" class="form-input">
                            <input type="hidden" name="patientid" id="view_patientid">
                            <label class="form-label">Parity:</label>
                            <input type="text" id="parity" name="parity" class="form-input" readonly>
                            <br>
                            <label class="form-label"><b>ADDRESS:</b></label>
                            <input type="text" id="address" class="form-input1" style="width: 35%;" readonly>
                        </div>


                        <div class="row">
                            <div class="table-responsive">
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
                                                <input type="date" id="addmissiondate"name="addmissiondate" class="form-control">
                                            </td>
                                            <td><label>Birth Time:</label>
                                                <input type="time" id="birthTime" name="birthTime" class="form-control">
                                            </td>
                                            <td>
                                                <label>Livebirth:</label>
                                                <input type="checkbox" name="Livebirth" value="Livebirth" class="form-check-input" id="livebirth" onclick="toggleCheckbox(this)">

                                                <label>Stillbirth-Fresh:</label>
                                                <input type="checkbox" name="Livebirth" value="Stillbirth-Fresh" class="form-check-input" id="stillbirth" onclick="toggleCheckbox(this)">
                                            </td>


                                            
                                            <td> <textarea id="newbord" name="newbord" class="form-control" style="resize:none;" ></textarea></td>

                                        </tr>
                                        <tr>
                                            <td><label>Admission Time:</label>
                                                <input type="time" id="admissionTime" name="admissionTime" class="form-control" >
                                            </td>
                                            <td> <label>Oxytocin-Time Given:</label>
                                                <input type="time" id="Oxytocin"name="Oxytocin" class="form-control" >
                                            </td>
                                            <td> <label>RESUSCITATION:</label><br>
                                                Yes <input type="checkbox" name="RESUSCITATION" value="Yes" class="form-check-input" onclick="toggleCheckbox(this)">
                                                No <input type="checkbox" name="RESUSCITATION" value="No" class="form-check-input" onclick="toggleCheckbox(this)"></td>

                                        </tr>
                                        <tr>
                                            <td><label>TIME ACTIVE LABOUR STARTED:</label>
                                                <input type="time" id="timeactive" name="timeactive" class="form-control">
                                            </td>
                                            <td><label>Placenta Complete:</label><br>
                                                Yes <input type="checkbox" name="placentaComplete" value="Yes" class="form-check-input" onclick="toggleCheckbox(this)">
                                                NO <input type="checkbox" name="placentaComplete" value="No" class="form-check-input" onclick="toggleCheckbox(this)"></td>
                                            <td><label>Birth Weight:</label>
                                                <input type="text" id="birthweight"  name="birthweight"  class="form-control">
                                            </td>

                                        </tr>
                                        <tr>
                                            <td> <label>TIME MEMBRANES RUPTURED:</label>
                                                <input type="time" id="timeMembranes"name="timeMembranes" class="form-control">
                                            </td>
                                            <td> <label>Time Delivered:</label>
                                                <input type="time" id="timedelevered" name="timedelevered" class="form-control">
                                            </td>
                                            <td><label>AOG: 36 Wks or Preterm:</label><br>
                                                Yes <input type="checkbox" name="Preterm" value="Yes" class="form-check-input" onclick="toggleCheckbox(this)">
                                                No <input type="checkbox" name="Preterm" value="No" class="form-check-input" onclick="toggleCheckbox(this)">
                                            </td>

                                        </tr>
                                        <tr>
                                            <td> <label>TIME SECOND STAGE STARTS:</label>
                                                <input type="time" id="timeSecond"name="timeSecond" class="form-control">
                                            </td>
                                            <td> <label>Estimated Blood Loss:</label>
                                                <input type="text" id="Estimated"name="Estimated" class="form-control">
                                            </td>
                                            <td> <label>Second Baby:</label>
                                                <input type="text" id="secondbaby" name="secondbaby" class="form-control">
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
                            <div class="table-responsive">
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
                                            <td> <textarea id="maternalplan" name="maternalplan" class="form-control" style="resize:none;"></textarea></td>
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
                        <input type="text" id="problem" name="problem" class="form-input1">


                        <label class="form-label"><b>TIME ONSET</b></label>
                        <input type="text" id="timeonset" name="time_onset" class="form-input1">
                        <br>
                        <label class="form-label"><b>TREATMENT OTHER THAN NORMAL SUPPORTIVE CARE</b></label>
                        <input type="text" id="treatmentsupport" name="treatments" class="form-input1">


                        <label class="form-label"><b>IF MOTHER REFERRED DURING LABOUR OR DELIVERY, RECORD TIME AND EXPLAIN</b></label>
                        <input type="text" id="referralMother" name="referral_details" class="form-input1">
                </div>

                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="Updatelabour" class="btn btn-info"><i class="icon-update"></i> Update</button> 
                        

                    </div>
                </div>

                </form>
            

            </div>


        </div>
    </div>
</div>

<div class="modal fade" id="deliveryRecord" tabindex="-1" aria-labelledby="deliveryRecord" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title h4" id="deliveryRecord">
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
                            <input type="text" id="dateAdmitted" name="dateAdmitted" class="form-input1" required>
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
                            <input type="text" class="form-input1" name="gravida" required>
                            <div class="invalid-feedback">
                                Gravida is required.
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label for="para" class="form-label">Para:</label>
                            <input type="text" class="form-input1" name="para" required>
                            <div class="invalid-feedback">
                                Para is required.
                            </div>
                        </div>

                    </div>
                    <div class="row mb-3">


                        <div class="col-md-2">
                            <label for="fullTerm" class="form-label">Full Term:</label>
                            <input type="text" class="form-input1" name="fullTerm" required>
                            <div class="invalid-feedback">
                                Full Term is required.
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label for="premature" class="form-label">Premature:</label>
                            <input type="text" class="form-input1" name="premature">

                        </div>

                        <div class="col-md-2">
                            <label for="abortion" class="form-label">Abortion:</label>
                            <input type="text" class="form-input1" name="abortion">

                        </div>
                        <div class="col-md-3">
                            <label for="noOfLiving" class="form-label">No. of Living:</label>
                            <input type="text" class="form-input1" name="noOfLiving">

                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><b>LABOR</b></label>
                            <div class="table-responsive">
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
                                                <div class="invalid-feedback labor-invalid-feedback">
                                                    At least one labor option is required.
                                                </div>
                                            </td>
                                            <td>
                                                <input type="time" name="laborTime" class="form-control " required>
                                                <!-- 
                                            <div class="invalid-feedback">
                                                is required.
                                            </div> -->
                                            </td>

                                            <td>

                                                <!-- <input type="date" name="laborDate" class="form-control date-shift" required> -->
                                                <div class="input-group">
                                                    <input type="text" class="form-control datepicker " name="laborDate">
                                                    <span class="input-group-text">
                                                        <i class="icon-calendar"></i>
                                                    </span>
                                                </div>

                                            </td>
                                            <td class="text-center">
                                                <!-- <input type="checkbox" name="Livebirth" value="Livebirth" class="form-check-input" onclick="toggleCheckbox(this)"> -->
                                                <label> I</label>

                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="laborHrs" placeholder="Hrs." required>
                                            </td>
                                            <td>

                                                <input type="number" min="0" class="form-control" name="laborMins" placeholder="Mins." required>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td><label for="text">Cervix Fully Dilated</label> </td>
                                            <td><input type="time" name="CervixTime" class="form-control" required></td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control datepicker " name="CervixDate" required>
                                                    <span class="input-group-text">
                                                        <i class="icon-calendar"></i>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-center">

                                                <label> II</label>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="CervixHrs" placeholder="Hrs." required>
                                            </td>
                                            <td>

                                                <input type="number" min="0" class="form-control" name="CervixMins" placeholder="Mins." required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="text">Baby Delivered</label></td>
                                            <td><input type="time" name="BabylaborTime" class="form-control " required></td>
                                            <td>

                                                <div class="input-group">
                                                    <input type="text" class="form-control datepicker " name="BabylaborDate" required>
                                                    <span class="input-group-text">
                                                        <i class="icon-calendar"></i>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-center">

                                                <label> III</label>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="babyHrs" placeholder="Hrs." required>
                                            </td>
                                            <td>

                                                <input type="number" min="0" class="form-control" name="babyMins" placeholder="Mins." required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="text">Placenta Delivered</label></td>
                                            <td><input type="time" name="PlacentaTime" class="form-control " required></td>
                                            <td>

                                                <div class="input-group">
                                                    <input type="text" class="form-control datepicker " name="PlacentaDate" required>
                                                    <span class="input-group-text">
                                                        <i class="icon-calendar"></i>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <label for="text">Total Duration</label>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="PlacentaHrs" placeholder="Hrs." required>
                                            </td>
                                            <td>

                                                <input type="number" min="0" class="form-control" name="PlacentaMins" placeholder="Mins." required>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
                                            <input type="checkbox" name="placentaExpelled[]" class="form-check-input" value="Expelled Completely">
                                            <label for="placentaExpelled">Expelled Completely</label><br>
                                            <input type="checkbox" name="placentaExpelled[]" class="form-check-input" value="Retained for Method of Expulsion">
                                            <label for="placentaRetained">Retained for Method of Expulsion</label><br>
                                            <input type="checkbox" name="placentaExpelled[]" class="form-check-input" value="Spontaneous">
                                            <label for="placentaSpontaneous">Spontaneous</label><br>
                                            <input type="checkbox" name="placentaExpelled[]" class="form-check-input" value="Manual Extraction">
                                            <label for="placentaManualExtraction">Manual Extraction</label><br>
                                            <div class="invalid-feedback placenta-invalid-feedback">
                                                At least one placenta option is required.
                                            </div>

                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="cm" placeholder="Cm." required>
                                            <div class="invalid-feedback">
                                                Cm is required.
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control me-2" name="no_nexk" id="no_nexk" value="" placeholder="No. of Loops at Neck">
                                                <input type="checkbox" name="no_nexk" id="no_nexk_checkbox" value="None" class="form-check-input me-1">
                                                <label for="no_nexk_checkbox">None</label>
                                                <div class="invalid-feedback">
                                                    At least one option is required.
                                                </div>

                                            </div>

                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control me-2" name="umbilicalCordLoops" id="umbilicalCordLoops" value="" placeholder="Other Abnormalities">
                                                <input type="checkbox" name="umbilicalCordLoops" id="umbilicalCordLoops_checkbox" value="None" class="form-check-input me-1">
                                                <label for="umbilicalCordLoops_checkbox">None</label>
                                                <div class="invalid-feedback">
                                                    At least one option is required.
                                                </div>
                                            </div>

                                            <input type="text" class="form-control" name="placentaOther" value="" placeholder="Other (Specify)">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="bloodLossAntepartum" placeholder="Antepartum" required>
                                            <div class="invalid-feedback">
                                                Antepartum is required.
                                            </div>
                                            <input type="text" class="form-control" name="bloodLossIntrapartum" placeholder="Intrapartum" required>
                                            <div class="invalid-feedback">
                                                Intrapartum is required.
                                            </div>
                                            <input type="text" class="form-control" name="bloodLossPostpartum" placeholder="Postpartum" required>
                                            <div class="invalid-feedback">
                                                Postpartum is required.
                                            </div>
                                            <input type="text" class="form-control" name="totalBloodLoss" placeholder="Total Est. Blood Loss" required>
                                            <div class="invalid-feedback">
                                                Total Est. Blood Loss is required.
                                            </div>
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
                                <div class="invalid-feedback method-invalid-feedback">
                                    At least one method of delivery option is required.
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
                                        <div class="invalid-feedback Episiotomy-invalid-feedback">
                                            At least one option is required.
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
                                        <div class="invalid-feedback Laceration-invalid-feedback">
                                            At least one option is required.
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
                                        <div class="invalid-feedback Anethesia-invalid-feedback">
                                            At least one option is required.
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
                                        <div class="invalid-feedback Analgesia-invalid-feedback">
                                            At least one option is required.
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
                                    <div class="invalid-feedback condition-invalid-feedback">
                                        At least one option is required.
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
                                    <div class="invalid-feedback urinary_bladder-invalid-feedback">
                                        At least one option is required.
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
                                    <div class="invalid-feedback uterus-invalid-feedback">
                                        At least one option is required.
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
                                                <input type="text" class="form-control" name="handledBy" required>
                                                <div class="invalid-feedback">
                                                    Handled by is required.
                                                </div>
                                            </td>
                                            <td>
                                                <label for="assistedBy">Assisted by:</label>
                                                <input type="text" class="form-control" name="assistedBy" required>
                                                <div class="invalid-feedback">
                                                    Assisted by is required.
                                                </div>
                                            </td>
                                            <td>
                                                <label for="physicianOnDuty">Physician on duty:</label>
                                                <select name="physician" id="" class="form-select" required>

                                                    <?php echo $physician; ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Physician on duty is required.
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="savedeliveryRecord" class="btn btn-info"><i class="icon-save"></i> Save</button>

                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="PostpartumRecord" tabindex="-1" aria-labelledby="exampleModalXlLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title h4" id="exampleModalXlLabel">
                    POSTPARTUM MONITORING RECORD
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST" novalidate>
                    <input type="hidden" name="patientid" id="postpartumid">
                    <div class="row align-items-center mb-3">
                        <div class="col-auto">
                            <label for="text" class="form-label">Date:</label>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker " name="datepostpartum">
                                <span class="input-group-text">
                                    <i class="icon-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>



                    <div class="table-responsive">
                        <table class="table table-bordered" border="1">
                            <thead>
                                <tr>
                                    <th rowspan="3">Monitoring After Birth</th>

                                </tr>
                                <tr>
                                    <th>Every 5-15 mins for 1st hour</th>
                                    <th>2HR</th>
                                    <th>3HR</th>
                                    <th>4HR</th>
                                    <th>8HR</th>
                                    <th>12HR</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="date" class="form-control" name="date" required>

                                        <input type="time" name="time" class="form-control" required>


                                        <div class="invalid-feedback labor-invalid-feedback">
                                            At least one labor option is required.
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Every 5-15 mins times -->
                                        <input type="time" class="form-control" name="every5_15[]" />
                                        <input type="time" class="form-control" name="every5_15[]" />
                                        <input type="time" class="form-control" name="every5_15[]" />
                                        <input type="time" class="form-control" name="every5_15[]" />
                                    </td>
                                    <td><input type="time" name="2HR" class="form-control" /></td>
                                    <td><input type="time" name="3HR" class="form-control" /></td>
                                    <td><input type="time" name="4HR" class="form-control" /></td>
                                    <td><input type="time" name="8HR" class="form-control" /></td>
                                    <td><input type="time" name="12HR" class="form-control" /></td>


                                </tr>
                                <th></th>
                                <th>16HR</th>
                                <th>20HR</th>
                                <th>24HR</th>
                                <th>DISCHARGE</th>
                                <tr>
                                    <td></td>
                                    <td>
                                        <input type="date" name="date2" class="form-control" />
                                        <input type="time" name="16HR" class="form-control" />
                                    </td>
                                    <td><input type="time" name="20HR" class="form-control" /></td>
                                    <td><input type="time" name="24HR" class="form-control" /></td>
                                    <td><input type="time" name="DISCHARGE" class="form-control" /></td>
                                </tr>



                                <tr>
                                    <td><label for="text">MATERNAL WELL-BEING:</label><br>
                                        <input type="checkbox" name="maternal" value="1. CONSCIOUS" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 1. CONSCIOUS</label><br>
                                        <input type="checkbox" name="maternal" value=" 2.PALLOR" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 2. PALLOR</label><br>

                                        <div class="invalid-feedback labor-invalid-feedback">
                                            At least one labor option is required.
                                        </div>
                                    </td>
                                    <td><label for="text">UTERINE FIRMNESS:</label> <br>
                                        <input type="checkbox" name="uterine" value="1. CONTRACTED" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 1. CONTRACTED</label><br>
                                        <input type="checkbox" name="uterine" value=" 2. RELAX" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 2. RELAX</label><br>

                                        <div class="invalid-feedback labor-invalid-feedback">
                                            At least one labor option is required.
                                        </div>

                                    </td>
                                    <td colspan="2"><label for="text">RUBRA:</label> <br>
                                        <input type="checkbox" name="rubra" value="1. HEAVY" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 1. HEAVY</label><br>
                                        <input type="checkbox" name="rubra" value="2. MODERATE" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 2. MODERATE</label><br>
                                        <input type="checkbox" name="rubra" value="3. SCANTY" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 3. SCANTY</label><br>

                                        <div class="invalid-feedback labor-invalid-feedback">
                                            At least one labor option is required.
                                        </div>

                                    </td>
                                    <td colspan="2"><label for="text">PERINEUM/VULVA (PAIN INTENSITY):</label> <br>
                                        <input type="checkbox" name="perineum" value="1. MILD(1-3)" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 1. MILD(1-3)</label><br>
                                        <input type="checkbox" name="perineum" value="2. MODERATE(4-6)" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 2. MODERATE(4-6)</label><br>
                                        <input type="checkbox" name="perineum" value="3. STRONG (7-9)" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 3. STRONG (7-9)</label><br>
                                        <input type="checkbox" name="perineum" value="4. UNDEARABLE (10)" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 4. UNDEARABLE (10)</label><br>

                                        <div class="invalid-feedback labor-invalid-feedback">
                                            At least one labor option is required.
                                        </div>

                                    </td>
                                    <td colspan="3"><label for="text">BREAST CONDITION:</label> <br>
                                        <input type="checkbox" name="breast" value="1. ENGORGED" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 1. ENGORGED</label><br>
                                        <input type="checkbox" name="breast" value="2. SORE NIPPLE" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 2. SORE NIPPLE</label>


                                        <div class="invalid-feedback labor-invalid-feedback">
                                            At least one labor option is required.
                                        </div>

                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="2"><label for="text">FEEDING:</label> <br>
                                        <input type="checkbox" name="feeding" value="1. EXCLUSIVE BREASTFEEDING" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 1. EXCLUSIVE BREASTFEEDING</label><br>
                                        <input type="checkbox" name="feeding" value="2. MIXED FEEDING" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 2. MIXED FEEDING</label>


                                        <div class="invalid-feedback labor-invalid-feedback">
                                            At least one labor option is required.
                                        </div>

                                    </td>
                                    <td colspan="2"><label for="text">BLADDER:</label> <br>
                                        <input type="checkbox" name="bladder" value="1. FULL BLADDER" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 1. FULL BLADDER</label><br>
                                        <input type="checkbox" name="bladder" value="2. EMPTY BLADDER" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 2. EMPTY BLADDER</label>


                                        <div class="invalid-feedback labor-invalid-feedback">
                                            At least one labor option is required.
                                        </div>

                                    </td>
                                    <td colspan="2"><label for="text">BOWEL MOVEMENT:</label> <br>
                                        <input type="checkbox" name="bowel" value="1. With BM" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 1. With BM</label><br>
                                        <input type="checkbox" name="bowel" value="2. W/o BM" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 2. W/o BM</label>


                                        <div class="invalid-feedback labor-invalid-feedback">
                                            At least one labor option is required.
                                        </div>

                                    </td>
                                </tr>
                                <tr>

                                    <td colspan="3"><label for="text">RE-ENFORCE KEY MESSAGES:</label> <br>
                                        <input type="checkbox" class="form-check-input" name="message" value="1. Proper Nutrition" />
                                        <label for="text">1. Proper Nutrition</label>
                                        <br>
                                        <input type="checkbox" class="form-check-input" name="message" value="2. Personal hygien" />
                                        <label for="text">2. Personal hygien</label>
                                        <br>
                                        <input type="checkbox" class="form-check-input" name="message" value="3. Danger signs" />
                                        <label for="text">3. Danger signs</label>
                                        <br>
                                        <input type="checkbox" class="form-check-input" name="message" value="4. Importance of Exclusive Breastfeeding" />
                                        <label for="text">4. Importance of Exclusive Breastfeeding</label>
                                        <br>
                                        <input type="checkbox" class="form-check-input" name="message" value="5. Imprtance of family" />
                                        <label for="text">5. Imprtance of family</label>
                                        <br>
                                        <input type="checkbox" class="form-check-input" name="message" value="6. Home instruction on Discharge of mother and her" />
                                        <label for="text">6. Home instruction on Discharge of mother and her</label>
                                        <br>

                                    </td>
                                    <td colspan="3"><label for="text">VAGINAL DISCHARGE(foul smelling):</label> <br>
                                        <input type="checkbox" name="viginaldischarge" value="Yes" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> Yes</label><br>
                                        <input type="checkbox" name="viginaldischarge" value="No" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> No</label>


                                        <div class="invalid-feedback labor-invalid-feedback">
                                            At least one labor option is required.
                                        </div>

                                    </td>


                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="text">Before sending mother and baby home, check the following to ensure wellness and safety at home:</label><br>
                            <label>1. Perform a pre-discharge examination</label><br>
                            <label>2. Ask about general feeling, pain, urge of urination and if there are problems</label><br>
                            <label>3. Check vital signs, mother's breast if filling or engorged, and condition of nipple in preparation for breastfeeding</label><br>
                            <label>4. Check abdomen for uterine contraction and signs of bladder distention</label><br>
                            <label for="">5. Check perineum for hygiene, sign of swelling if with sutures, and condition of wound, foul smelling discharge, or any profuse lochia</label><br>
                            <label for="">6. Always record findings. It can help you make right and timely decisions for the care of the woman.</label>
                            <br>
                            <label for="">Repeat important health information. Allow mother to reapet home instructions to ensure mother's understanding on the information given.</label><br>
                            <label for="">Make schedule for the 'Return Visit'.</label><br>
                            <label for="">1. All postpartum women should have atleast (2)postpartum visits. Advice for family planning </label><br>
                            <label for="">2. Recommend schedule for postpartum care.</label><br>
                            <label for="" style="margin-left: 2rem;">1st POSTPARTUM CARE: After 24 hours after delivery</label><br>
                            <label for="" style="margin-left: 2rem;">2nd POSTPARTUM CARE: After 7 days from discharge</label>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12 text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="savepostpartum" class="btn btn-info">Save</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ViewPostpartumRecord" tabindex="-1" aria-labelledby="exampleModalXlLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title h4" id="exampleModalXlLabel">
                    POSTPARTUM MONITORING RECORD
                </h5>
                <span class=" mx-auto">
                    <a href="#" id="printpostpartum" target="_blank" class="btn btn-secondary"> <i class="icon-printer"></i> Print</a> </span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST" novalidate>
                    <input type="hidden" name="patientid" id="patientname">
                    <input type="hidden" name="postpartumId" id="postpartumId">

                    <div class="row align-items-center mb-3">
                        <div class="col-auto">
                            <label for="text" class="form-label">Date:</label>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker " id="datepostpartum" name="datepost">
                                <span class="input-group-text">
                                    <i class="icon-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>



                    <div class="table-responsive">
                        <table class="table table-bordered" border="1">
                            <thead>
                                <tr>
                                    <th rowspan="3">Monitoring After Birth</th>

                                </tr>
                                <tr>
                                    <th>Every 5-15 mins for 1st hour</th>
                                    <th>2HR</th>
                                    <th>3HR</th>
                                    <th>4HR</th>
                                    <th>8HR</th>
                                    <th>12HR</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="date" class="form-control" name="date" required>

                                        <input type="time" name="time" class="form-control" required>


                                        <div class="invalid-feedback labor-invalid-feedback">
                                            At least one labor option is required.
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Every 5-15 mins times -->
                                        <input type="time" class="form-control" name="every5[]" />
                                        <input type="time" class="form-control" name="every5[]" />
                                        <input type="time" class="form-control" name="every5[]" />
                                        <input type="time" class="form-control" name="every5[]" />
                                    </td>
                                    <td><input type="time" name="2HR" class="form-control" /></td>
                                    <td><input type="time" name="3HR" class="form-control" /></td>
                                    <td><input type="time" name="4HR" class="form-control" /></td>
                                    <td><input type="time" name="8HR" class="form-control" /></td>
                                    <td><input type="time" name="12HR" class="form-control" /></td>


                                </tr>
                                <th></th>
                                <th>16HR</th>
                                <th>20HR</th>
                                <th>24HR</th>
                                <th>DISCHARGE</th>
                                <tr>
                                    <td></td>
                                    <td>
                                        <input type="date" name="date2" class="form-control" />
                                        <input type="time" name="16HR" class="form-control" />
                                    </td>
                                    <td><input type="time" name="20HR" class="form-control" /></td>
                                    <td><input type="time" name="24HR" class="form-control" /></td>
                                    <td><input type="time" name="DISCHARGE" class="form-control" /></td>
                                </tr>



                                <tr>
                                    <td><label for="text">MATERNAL WELL-BEING:</label><br>
                                        <input type="checkbox" name="maternal" value="1. CONSCIOUS" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 1. CONSCIOUS</label><br>
                                        <input type="checkbox" name="maternal" value=" 2.PALLOR" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 2. PALLOR</label><br>

                                        <div class="invalid-feedback labor-invalid-feedback">
                                            At least one labor option is required.
                                        </div>
                                    </td>
                                    <td><label for="text">UTERINE FIRMNESS:</label> <br>
                                        <input type="checkbox" name="uterine" value="1. CONTRACTED" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 1. CONTRACTED</label><br>
                                        <input type="checkbox" name="uterine" value=" 2. RELAX" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 2. RELAX</label><br>

                                        <div class="invalid-feedback labor-invalid-feedback">
                                            At least one labor option is required.
                                        </div>

                                    </td>
                                    <td colspan="2"><label for="text">RUBRA:</label> <br>
                                        <input type="checkbox" name="rubra" value="1. HEAVY" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 1. HEAVY</label><br>
                                        <input type="checkbox" name="rubra" value="2. MODERATE" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 2. MODERATE</label><br>
                                        <input type="checkbox" name="rubra" value="3. SCANTY" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 3. SCANTY</label><br>

                                        <div class="invalid-feedback labor-invalid-feedback">
                                            At least one labor option is required.
                                        </div>

                                    </td>
                                    <td colspan="2"><label for="text">PERINEUM/VULVA (PAIN INTENSITY):</label> <br>
                                        <input type="checkbox" name="perineum" value="1. MILD(1-3)" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 1. MILD(1-3)</label><br>
                                        <input type="checkbox" name="perineum" value="2. MODERATE(4-6)" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 2. MODERATE(4-6)</label><br>
                                        <input type="checkbox" name="perineum" value="3. STRONG (7-9)" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 3. STRONG (7-9)</label><br>
                                        <input type="checkbox" name="perineum" value="4. UNDEARABLE (10)" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 4. UNDEARABLE (10)</label><br>

                                        <div class="invalid-feedback labor-invalid-feedback">
                                            At least one labor option is required.
                                        </div>

                                    </td>
                                    <td colspan="3"><label for="text">BREAST CONDITION:</label> <br>
                                        <input type="checkbox" name="breast" value="1. ENGORGED" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 1. ENGORGED</label><br>
                                        <input type="checkbox" name="breast" value="2. SORE NIPPLE" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 2. SORE NIPPLE</label>


                                        <div class="invalid-feedback labor-invalid-feedback">
                                            At least one labor option is required.
                                        </div>

                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="2"><label for="text">FEEDING:</label> <br>
                                        <input type="checkbox" name="feeding" value="1. EXCLUSIVE BREASTFEEDING" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 1. EXCLUSIVE BREASTFEEDING</label><br>
                                        <input type="checkbox" name="feeding" value="2. MIXED FEEDING" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 2. MIXED FEEDING</label>


                                        <div class="invalid-feedback labor-invalid-feedback">
                                            At least one labor option is required.
                                        </div>

                                    </td>
                                    <td colspan="2"><label for="text">BLADDER:</label> <br>
                                        <input type="checkbox" name="bladder" value="1. FULL BLADDER" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 1. FULL BLADDER</label><br>
                                        <input type="checkbox" name="bladder" value="2. EMPTY BLADDER" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 2. EMPTY BLADDER</label>


                                        <div class="invalid-feedback labor-invalid-feedback">
                                            At least one labor option is required.
                                        </div>

                                    </td>
                                    <td colspan="2"><label for="text">BOWEL MOVEMENT:</label> <br>
                                        <input type="checkbox" name="bowel" value="1. With BM" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 1. With BM</label><br>
                                        <input type="checkbox" name="bowel" value="2. W/o BM" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> 2. W/o BM</label>


                                        <div class="invalid-feedback labor-invalid-feedback">
                                            At least one labor option is required.
                                        </div>

                                    </td>
                                </tr>
                                <tr>

                                    <td colspan="3"><label for="text">RE-ENFORCE KEY MESSAGES:</label> <br>
                                        <input type="checkbox" class="form-check-input" name="message" value="1. Proper Nutrition" />
                                        <label for="text">1. Proper Nutrition</label>
                                        <br>
                                        <input type="checkbox" class="form-check-input" name="message" value="2. Personal hygien" />
                                        <label for="text">2. Personal hygien</label>
                                        <br>
                                        <input type="checkbox" class="form-check-input" name="message" value="3. Danger signs" />
                                        <label for="text">3. Danger signs</label>
                                        <br>
                                        <input type="checkbox" class="form-check-input" name="message" value="4. Importance of Exclusive Breastfeeding" />
                                        <label for="text">4. Importance of Exclusive Breastfeeding</label>
                                        <br>
                                        <input type="checkbox" class="form-check-input" name="message" value="5. Imprtance of family" />
                                        <label for="text">5. Imprtance of family</label>
                                        <br>
                                        <input type="checkbox" class="form-check-input" name="message" value="6. Home instruction on Discharge of mother and her" />
                                        <label for="text">6. Home instruction on Discharge of mother and her</label>
                                        <br>

                                    </td>
                                    <td colspan="3"><label for="text">VAGINAL DISCHARGE(foul smelling):</label> <br>
                                        <input type="checkbox" name="viginaldischarge" value="Yes" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> Yes</label><br>
                                        <input type="checkbox" name="viginaldischarge" value="No" class="form-check-input" onclick="toggleCheckbox(this)">
                                        <label> No</label>


                                        <div class="invalid-feedback labor-invalid-feedback">
                                            At least one labor option is required.
                                        </div>

                                    </td>


                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="text">Before sending mother and baby home, check the following to ensure wellness and safety at home:</label><br>
                            <label>1. Perform a pre-discharge examination</label><br>
                            <label>2. Ask about general feeling, pain, urge of urination and if there are problems</label><br>
                            <label>3. Check vital signs, mother's breast if filling or engorged, and condition of nipple in preparation for breastfeeding</label><br>
                            <label>4. Check abdomen for uterine contraction and signs of bladder distention</label><br>
                            <label for="">5. Check perineum for hygiene, sign of swelling if with sutures, and condition of wound, foul smelling discharge, or any profuse lochia</label><br>
                            <label for="">6. Always record findings. It can help you make right and timely decisions for the care of the woman.</label>
                            <br>
                            <label for="">Repeat important health information. Allow mother to reapet home instructions to ensure mother's understanding on the information given.</label><br>
                            <label for="">Make schedule for the 'Return Visit'.</label><br>
                            <label for="">1. All postpartum women should have atleast (2)postpartum visits. Advice for family planning </label><br>
                            <label for="">2. Recommend schedule for postpartum care.</label><br>
                            <label for="" style="margin-left: 2rem;">1st POSTPARTUM CARE: After 24 hours after delivery</label><br>
                            <label for="" style="margin-left: 2rem;">2nd POSTPARTUM CARE: After 7 days from discharge</label>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12 text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="Updatepostpartum" class="btn btn-info">Update</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Refer Modal -->
<div class="modal fade" id="referModal" tabindex="-1" aria-labelledby="referModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Refer Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="referPatientId">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="referPatientName" class="form-label">Patient's Name:</label>
                        <input type="text" class="form-control" id="referPatientName" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="referAge" class="form-label">Age:</label>
                        <input type="text" class="form-control" id="referAge" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="referDateAdmitted" class="form-label">Date Admitted:</label>
                        <input type="text" class="form-control" id="referDateAdmitted" readonly>
                    </div>
                </div>
                <!-- Additional fields as needed -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="submit" name="submitDischarged" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>



<!-- <div class="modal fade" id="discharged" tabindex="-1" aria-labelledby="exampleModalXlLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title h4" id="discharged">
                    DISCHARGE FORM
                </h5>


                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST" novalidate>
                    <input type="text" name="patientid" id="patientdishcarged">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="patientName" class="form-label">Patient's Name:</label>
                            <input type="text" class="form-input1" id="patientName1" name="patientName" required>
                        </div>
                        <div class="col-md-2">
                            <label for="age" class="form-label">Age:</label>
                            <input type="text" class="form-input1" id="age1" name="age" required>
                        </div>
                        <div class="col-md-4">
                            <label for="dateAdmitted" class="form-label">Sex:</label>
                            <input type="text" id="sex" class="form-input1" required>
                        </div>
                        <div class="col-md-4">
                            <label for="dateAdmitted" class="form-label">Diagnosis:</label>
                            <textarea name="Diagnosis" class="form-control" style="resize: none;"></textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="text" class="form-label">Date of discharged:</label>
                            <div class="input-group">
                                <input type="text" class="form-control datepicker " name="datedischarged">
                                <span class="input-group-text">
                                    <i class="icon-calendar"></i>
                                </span>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="dateAdmitted" class="form-label">A. Home Medications:</label>
                        </div>
                    </div>
                    <div id="medicationContainer">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center" style="margin-left:  2rem;">
                                    <input type="text" id="homeMedications" name="homeMedications[]" class="form-control me-2" required>
                                    <button type="button" class="btn btn-info add-medication me-2"><i class="icon-plus"></i></button>
                                    <button type="button" class="btn btn-danger remove-medication d-none"><i class="icon-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="dateAdmitted" class="form-label">B. Follow-up check-up:</label>
                            <div class="input-group">
                                <input type="text" class="form-control datepicker " name="dateFollow">
                                <span class="input-group-text">
                                    <i class="icon-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="dateAdmitted" class="form-label">C. Home Instruction:</label><br>
                            <label style="margin-left: 2rem;" for="dateAdmitted" class="form-label">[ ]. Ipagpatuloy ang pagpasuso sa bata. Hayan na dumighayang iyong bata pagkatapos ng pagpasuso.</label>
                            <br><label style="margin-left: 2rem;" for="dateAdmitted" class="form-label">[ ] Maghugas ng kamay parati</label>
                            <br><label style="margin-left: 2rem;" for="dateAdmitted" class="form-label">[ ] Kumain ng masustansyang pagkain araw-araw</label>
                            <br><label style="margin-left: 2rem;" for="dateAdmitted" class="form-label">[ ] Iwasan ang matataong lugar.</label>
                            <br><label style="margin-left: 2rem;" for="dateAdmitted" class="form-label">[ ] Iwasan ang maalat na pagkain.</label>


                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-4">
                            <select name="nursemidwife" id="" class="form-select mb-2">
                                <?php echo $midwife; ?>

                            </select>
                            <label for="text" class="form-label">Nurse/Midwife on duty</label>
                        </div>
                        <div class="col-md-4">
                            <select name="getphysician" id="" class="form-select mb-2">

                                <?php echo $getphysician; ?>

                            </select>
                            <label for="text" class="form-label">Attending Physician</label>
                        </div>
                    </div>


            </div>



            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="submit" name="submitDischarged" class="btn btn-primary">
                    Submit
                </button>
            </div>
            </form>
        </div>
    </div>
</div> -->


<div class="modal fade" id="discharged" tabindex="-1" aria-labelledby="exampleModalXlLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title h4" id="discharged">
                    DISCHARGE FORM
                </h5>


                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST" novalidate id="dischargeform">
                    <input type="hidden" name="patientid" id="patientdishcarged">
                    <input type="hidden" name="birthiid" id="birthiid">
                    <div class="row mb-3">
                        <div class="col-md-5 mb-2">
                            <label for="patientName" class="form-label">Patient's Name:</label>
                            <input type="text" class="form-control" id="patientName1" name="patientName" required>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="age" class="form-label">Age:</label>
                            <input type="text" class="form-control" id="age1" name="age" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="dateAdmitted" class="form-label">Sex:</label>
                            <input type="text" id="sex" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="dateAdmitted" class="form-label">Diagnosis:</label>
                            <textarea name="Diagnosis" class="form-control" style="resize: none;" required></textarea>
                            <div class="invalid-feedback ">
                                Diagnosis is required.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="text" class="form-label">Date of discharged:</label>
                            <div class="input-group">
                                <input type="text" class="form-control datepicker " name="datedischarged" required>
                                <span class="input-group-text">
                                    <i class="icon-calendar"></i>
                                </span>
                                <div class="invalid-feedback ">
                                    Date of discharged is required.
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- <div class="row">
                    <div class="col-md-4">
                        <label for="dateAdmitted" class="form-label">A. Home Medications:</label>
                    </div>
                </div>
                <div id="medicationContainer">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center" style="margin-left:  2rem;">
                                <input type="text" id="homeMedications" name="homeMedications[]" class="form-control me-2" required>
                                <button type="button" class="btn btn-info add-medication me-2"><i class="icon-plus"></i></button>
                                <button type="button" class="btn btn-danger remove-medication d-none"><i class="icon-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="dateAdmitted" class="form-label">B. Follow-up check-up:</label>
                        <div class="input-group">
                            <input type="text" class="form-control datepicker " name="dateFollow">
                            <span class="input-group-text">
                                <i class="icon-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div> -->

                    <div class="row mb-2">
                        <div class="col-md-4" id="medicationContainer">
                            <label for="homeMedications" class="form-label">A. Home Medications:</label>

                            <div class="d-flex align-items-center" style="margin-left: 2rem;">
                                <input type="text" id="homeMedications" name="homeMedications[]" class="form-control me-2" required>
                                <button type="button" class="btn btn-info add-medication me-2"><i class="icon-plus"></i></button>
                                <button type="button" class="btn btn-danger remove-medication d-none"><i class="icon-trash"></i></button>
                            </div>
                            <div class="invalid-feedback ">
                                Home Medications is required.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="dateFollow" class="form-label">B. Follow-up check-up:</label>
                            <div class="input-group">
                                <input type="text" class="form-control datepickerNexvisit" name="dateFollow" required>
                                <span class="input-group-text">
                                    <i class="icon-calendar"></i>
                                </span>
                                <div class="invalid-feedback ">
                                    Follow-up check-up is required.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="dateAdmitted" class="form-label">C. Home Instruction:</label><br>
                            <label style="margin-left: 2rem;" for="dateAdmitted" class="form-label">[ ]. Ipagpatuloy ang pagpasuso sa bata. Hayan na dumighayang iyong bata pagkatapos ng pagpasuso.</label>
                            <br><label style="margin-left: 2rem;" for="dateAdmitted" class="form-label">[ ] Maghugas ng kamay parati</label>
                            <br><label style="margin-left: 2rem;" for="dateAdmitted" class="form-label">[ ] Kumain ng masustansyang pagkain araw-araw</label>
                            <br><label style="margin-left: 2rem;" for="dateAdmitted" class="form-label">[ ] Iwasan ang matataong lugar.</label>
                            <br><label style="margin-left: 2rem;" for="dateAdmitted" class="form-label">[ ] Iwasan ang maalat na pagkain.</label>


                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-4">
                            <select name="nursemidwife" class="form-select mb-2" required>
                                <?php echo $midwife; ?>

                            </select>
                            <label for="text" class="form-label">Nurse/Midwife on duty</label>
                        </div>
                        <div class="col-md-4">
                            <select name="getphysician" class="form-select mb-2" required>

                                <?php echo $getphysician; ?>

                            </select>
                            <label for="text" class="form-label">Attending Physician</label>
                        </div>
                    </div>


            </div>



            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="submit" name="submitDischarged" class="btn btn-info">
                    Submit
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="COnfirmRefer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Refer Patient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Are you sure you want to Refer Patient?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmReferral" class="btn btn-primary">Ok</button>
            </div>
        </div>
    </div>
</div>