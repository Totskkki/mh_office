<?php
if (!(isset($_SESSION['user_id']))) {
  header("location:login.php");
  exit;
}
$userRole = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
$isAdmin = $userRole == 'admin';
?>
<!-- App header starts -->
<div class="app-header d-flex align-items-center">

<!-- Toggle buttons start -->
<div class="d-flex">
    <button class="btn btn-outline-success toggle-sidebar" id="toggle-sidebar">
        <i class="icon-menu"></i>
    </button>
    <button class="btn btn-outline-danger pin-sidebar" id="pin-sidebar">
        <i class="icon-menu"></i>
    </button>
</div>
<!-- Toggle buttons end -->

<!-- App brand sm start -->
<div class="app-brand-sm d-md-none d-sm-block">
    <a href="index.html">
        <img src="assets/images/logo-sm.svg" class="logo" alt="Bootstrap Gallery">
    </a>
</div>
<!-- App brand sm end -->

<!-- Search container start -->
<div class="search-container d-lg-block d-none mx-3">
    <input type="text" class="form-control" id="search" placeholder="Search" />
    <i class="icon-search"></i>
</div>
<!-- Search container end -->

<!-- App header actions start -->
<div class="header-actions">
    <div class="d-md-flex d-none gap-2">
        <!-- <div class="dropdown">
            <a class="dropdown-toggle position-relative action-icon" href="#!" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img src="assets/images/flags/1x1/gb.svg" class="flag-img" alt="Bootstrap Dashboards" />
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow-sm dropdown-menu-mini">
                <div class="country-container">
                    <a href="index.html" class="py-2">
                        <img src="assets/images/flags/1x1/us.svg" alt="Admin Panel" />
                    </a>
                    <a href="index.html" class="py-2">
                        <img src="assets/images/flags/1x1/in.svg" alt="Admin Panels" />
                    </a>
                    <a href="index.html" class="py-2">
                        <img src="assets/images/flags/1x1/br.svg" alt="Admin Dashboards" />
                    </a>
                    <a href="index.html" class="py-2">
                        <img src="assets/images/flags/1x1/tr.svg" alt="Admin Themes" />
                    </a>
                    <a href="index.html" class="py-2">
                        <img src="assets/images/flags/1x1/id.svg" alt="Google Admin" />
                    </a>
                </div>
            </div>
        </div> -->
       
        <div class="dropdown">
            <a class="dropdown-toggle position-relative action-icon" href="#!" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="icon-twitch fs-5 lh-1"></i>
                <span class="count rounded-circle bg-danger">5</span>
            </a>
            <!-- <div class="dropdown-menu dropdown-menu-end dropdown-menu-md shadow-sm">
                <h5 class="fw-semibold px-3 py-2 m-0">Notifications</h5>
                <a href="javascript:void(0)" class="dropdown-item">
                    <div class="d-flex align-items-start py-2">
                        <img src="assets/images/user.png" class="img-3x me-3 rounded-3" alt="Admin Themes" />
                        <div class="m-0">
                            <h6 class="mb-1 fw-semibold">Bernie Massey</h6>
                            <p class="mb-1">
                                Membership has been ended.
                            </p>
                            <p class="small m-0 opacity-50">
                                Today, 07:30pm
                            </p>
                        </div>
                    </div>
                </a>
                <a href="javascript:void(0)" class="dropdown-item">
                    <div class="d-flex align-items-start py-2">
                        <img src="assets/images/user2.png" class="img-3x me-3 rounded-3" alt="Admin Theme" />
                        <div class="m-0">
                            <h6 class="mb-1 fw-semibold">Beth Chang</h6>
                            <p class="mb-1">
                                Congratulate, James for new job.
                            </p>
                            <p class="small m-0 opacity-50">
                                Today, 08:00pm
                            </p>
                        </div>
                    </div>
                </a>
                <a href="javascript:void(0)" class="dropdown-item">
                    <div class="d-flex align-items-start py-2">
                        <img src="assets/images/user1.png" class="img-3x me-3 rounded-3" alt="Admin Theme" />
                        <div class="m-0">
                            <h6 class="mb-1 fw-semibold">Marques Stevie</h6>
                            <p class="mb-1">
                                Lewis added new schedule release.
                            </p>
                            <p class="small m-0 opacity-50">
                                Today, 09:30pm
                            </p>
                        </div>
                    </div>
                </a>
                <div class="d-grid p-3 border-top">
                    <a href="javascript:void(0)" class="btn btn-outline-primary">View all</a>
                </div>
            </div> -->
        </div>
    </div>
    <div class="dropdown ms-3">
        <a class="dropdown-toggle d-flex align-items-center" href="#!" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <img src="user_images/<?= $_SESSION['avatar']; ?>" class="img-3x m-2 ms-0 rounded-5" alt="" />
            <div class="d-flex flex-column">
                <span><?= $_SESSION['name']; ?></span>
                <small></small>
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-sm shadow-sm gap-3">
            
            <a class="dropdown-item d-flex align-items-center py-2" href="update_user.php"><i
                    class="icon-settings fs-4 me-3"></i>Account Settings</a>
            <a class="dropdown-item d-flex align-items-center py-2" href="login.php"><i
                    class="icon-log-out fs-4 me-3"></i>Logout</a>
                 
        </div>
    </div>
</div>
<!-- App header actions end -->

</div>
<!-- App header ends -->
