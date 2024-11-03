<div class="modal fade" id="prescriptionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="prescriptionModalLabel">Prescription for <span id="medicineName"></span  id="patient_name"><span></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Prescription content -->
        <table class="table"> 
          <thead>
            <tr>
             

              <th>Dosage</th>
              <th>Dose Schedule</th>            
              <th>Quantity</th>
              <th>Dose frequency</th> 
              <th>Time Frame</th>
            </tr>
          </thead>
          <tbody id="prescriptionContent">
            <!-- Prescription details will be displayed here -->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
