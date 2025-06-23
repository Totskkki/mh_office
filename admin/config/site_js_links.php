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
<script src="../assets/jquery-ui.js"></script>
<!--<script src="../assets/sync.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/toastr@latest/toastr.min.js"></script>



<script>
    // Create a Swal mixin for toast-style alerts
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
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

<!-- <script type = "text/javascript">
    $(document).ready(function() {
        function disableBack() { window.history.forward() }

        window.onload = disableBack();
        window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
    });
</script> -->

<script>
    let notificationInterval;

function checkNotifications() {
    // Check if notifications have already been shown in the current session
    if (sessionStorage.getItem('notificationsShown') === 'true') {
        return; // Exit the function if notifications have already been shown
    }

    $.ajax({
        url: 'ajax/check_notifications.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success && response.count > 0) {
                toastr.info(`You have ${response.count} new notifications!`, 'New Notifications', {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 5000,
                });

                // Set a flag in session storage to indicate that notifications have been shown
                sessionStorage.setItem('notificationsShown', 'true');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching notifications:', error);
        }
    });
}

$(document).ready(function() {
    // Initial check on page load
    checkNotifications();

    // Start interval for checking notifications every 2 minutes
    notificationInterval = setInterval(checkNotifications, 120000);

    // Stop interval when the page is refreshing or unloading
    window.onbeforeunload = function () {
        clearInterval(notificationInterval);
    };
});

</script>
