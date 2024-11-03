<div class="modal fade" id="consultModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header ">
                <h5 class="modal-title" id="consultModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form method="POST">


                    <input type="hidden" id="user" name="patient_id">
                    <input type="hidden" id="complainid" name="hidden1">


                    <div class="mb-3 row">
                        <label for="vaccineSelect" class="col-sm-3 col-form-label text-center">Search and Select Vaccine</label>
                        <div class="col-sm-8">
                            <select id="vaccineSelect" multiple="multiple" data-placeholder="Search here" name="vaccineSelect[]" class="vaccineSelect form-control" style="width: 100%;">
                                <?php echo $medicines; ?>
                            </select>
                        </div>
                    </div>



                    <div class="mb-3 row">
                        <label for="text" class="col-sm-3 col-form-label text-center">Date Administered</label>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date_ad" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#date_ad" name="date_ad" data-toggle="datetimepicker" autocomplete="off"required />
                                <div class="input-group-append" data-target="#date_ad" data-toggle="datetimepicker">
                                    <div class="input-group-text" style="height: 100%;">
                                        <i class="icon-calendar" style="height: 100%;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="text" class="col-sm-3 col-form-label text-center">Next Due Visit</label>
                        <div class="col-sm-8">
                            

                            <div class="input-group date" id="next_due" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#next_due" name="next_due" data-toggle="datetimepicker" autocomplete="off"required />
                                <div class="input-group-append" data-target="#next_due" data-toggle="datetimepicker">
                                    <div class="input-group-text" style="height: 100%;">
                                        <i class="icon-calendar" style="height: 100%;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="text" class="col-sm-3 col-form-label text-center">Notes</label>
                        <div class="col-sm-8">
                            <textarea name="notes" id="notes" cols="30" rows="3" class="form-control" style="resize:none;"></textarea>
                        </div>
                    </div>


            </div>




            <div class="modal-footer">
                <button type="button" class="btn " data-bs-dismiss="modal">
                    Close
                </button>
                <button type="submit" id="save_vaccination" name="save_vaccination" class="btn btn-info">
                    Submit
                </button>

            </div>
        </div>

        </form>
    </div>
</div>
</div>