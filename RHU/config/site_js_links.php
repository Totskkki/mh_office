<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>

<!-- 
<script src="dist/js/jquery_confirm/jquery-confirm.js"></script> -->

<!-- Custom JS files -->
<script src="../assets/js/custom.js"></script>


<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script> -->

<script src="../assets/js/jquery-confirm.min.js"></script>

<script src="../assets/select2.js"></script>
<script src="../assets/select2/js/select2.full.min.js"></script>



<script src="../assets/js/common_javascript_functions.js"></script>

<script src="../assets/sweetalert2/sweetalert2.min.js"></script>

<script src="../assets/js/sweetalert.min.js"></script>


<script src="../assets/jquery-validation/jquery.validate.min.js"></script>
<script src="../assets/jquery-validation/additional-methods.min.js"></script>

<script src="../assets/moment/moment.min.js"></script>
<script src="../assets/daterangepicker/daterangepicker.js"></script>
<script src="../assets/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="../assets/inputmask/jquery.inputmask.min.js"></script>


<!-- Select 2 js -->
<script type="text/javascript" src="../assets/select2/js/select2.full.min.js"></script>
<!-- Multiselect js -->
<!-- <script type="text/javascript" src="../assets/bootstrap-multiselect/js/bootstrap-multiselect.js">
</script>
<script type="text/javascript" src="../assets/multiselect/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="../assets/jquery.quicksearch.js"></script> -->


<script src="../assets/library/dselect.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
    // Create a Swal mixin for toast-style alerts
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        customClass: {
            popup: 'toast-popup-class',
            title: 'toast-title-class'
        }
    });

    $(document).ready(function() {
        <?php
        if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
        ?>
            Toast.fire({
                icon: '<?php echo $_SESSION['status_code']; ?>',
                title: '<?php echo $_SESSION['status']; ?>'
            });
        <?php
            unset($_SESSION['status']);
            unset($_SESSION['status_code']);
        }
        ?>
    });
</script>