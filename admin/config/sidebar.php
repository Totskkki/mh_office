<?php include 'session.php';
// if (isset($_SESSION['login']) && $_SESSION['login'] === true && $_SESSION['user_type'] === 'Admin') {
//   if ($_SESSION['user_type'] === 'Admin') {
//       // Admin is already logged in, so allow access
//   } elseif ($_SESSION['user_type'] === 'MHO') {
//       // MHO is logged in, so prevent access to BHW page
//       header("location: ../home.php");
//       exit;
//   } elseif ($_SESSION['user_type'] === 'BHW') {
//       // BHW is logged in, so prevent access to MHO page
//       header("location: ../RHU/dashboard-bhw.php");
//       exit;
//   }
//   }

?>



<?php $Page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1); ?>

<style>
  .sidebar-menu .treeview-menu li.active>a {

    color: red;
    border-left: 1px solid #e50000;
  }

  .sidebar-wrapper {
    background-color: #fff;
    width: 250px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 11;
    -webkit-transition: left .3s ease, width .3s ease;
    transition: left .3s ease, width .3s ease;
  }
</style>
<!-- Sidebar wrapper start -->
<nav id="sidebar" class="sidebar-wrapper">

  <!-- App brand starts -->
  <div class="app-brand px-3 py-2 d-flex align-items-center">
    <a href="dashboard.php">
      <h3 class="brand-image-xl logo-xl mb-0 text-center" style="color:white">MH-Office <b>MHO</b></h3>
      <!-- <img src="logo/1.png" class="logo" alt="BHW Gallery" /> -->
    </a>
  </div>
  <!-- App brand ends -->
  <!-- Sidebar menu starts -->
  <div class="sidebarMenuScroll">
    <ul class="sidebar-menu">
      <li class="dashboard.php <?php if ($Page === 'dashboard.php') echo 'active'; ?> " id="mnu_dashboard">
        <a href="dashboard.php ">
          <i class="icon-roofing"></i>
          <span class="menu-text">Dashboard</span>
        </a>
      </li>



      <!-- <li class="treeview <?php if (strpos($_SERVER['REQUEST_URI'], 'new_prescription.php') !== false || strpos($_SERVER['REQUEST_URI'], 'patient.php') !== false) echo 'active'; ?>">
        <a href="#!">
          <i class="icon-face"></i>
          <span class="menu-text <?php if ($Page === 'new_prescription.php') echo 'active'; ?>">Patients</span>
        </a>
        <ul class="treeview-menu" <?php if ($Page === 'patient.php' ) echo 'style="display:block;"'; ?>>
          <li <?php if ($Page === 'patient.php') echo 'class="active"'; ?>>
            <a href="patient.php">Patient</a>
          </li>

        </ul>
      </li> -->

      <li class="events.php <?php if ($Page === 'patient.php' || $Page === 'view_patient.php') echo 'active'; ?>" >

        <a href="patient.php">

          <i class="icon-face"></i>
          <span class="menu-text">Patients</span>
        </a>
      </li>





      <li class="treeview <?php if (strpos($_SERVER['REQUEST_URI'], 'medicine.php') !== false || strpos($_SERVER['REQUEST_URI'], 'medicine_details.php') !== false || strpos($_SERVER['REQUEST_URI'], 'medicine_inventory.php') !== false) echo 'active'; ?>">
        <a href="#!">

          <i class="icon-medical_services"></i>
          <span class="menu-text <?php if ($Page === 'medicine_details.php') echo 'active'; ?>">Medicines</span>
        </a>
        <ul class="treeview-menu" <?php if ($Page === 'medicine.php') echo 'style="display:block;"'; ?>>
          <li <?php if ($Page === 'medicine.php') echo 'class="active"'; ?>>
            <a href="medicine.php">Medicine List</a>
          </li>
          <li <?php if ($Page === 'medicine_details.php') echo 'class="active"'; ?>>
            <a href="medicine_details.php">Medicine details</a>
          </li>
          <li <?php if ($Page === 'medicine_inventory.php') echo 'class="active"'; ?>>
            <a href="medicine_inventory.php">Inventory</a>
          </li>

        </ul>
      </li>
      <li class="treeview <?php if (strpos($_SERVER['REQUEST_URI'], 'reports.php')) echo 'active'; ?>">
        <a href="#!">
          <i class="icon-edit"></i>
          <span class="menu-text <?php if ($Page === 'reports.php') echo 'active'; ?>">Reports</span>
        </a>
        <ul class="treeview-menu"  <?php if ($Page === 'reports.php') echo 'style="display:block;"'; ?>>
          <li <?php if ($Page === 'reports.php') echo 'class="active"'; ?>>
            <a href="reports.php">Records</a>
          </li>
          <!-- <li>
                <a href="calendar-external-draggable.html">Medical Certificate</a>
              </li>
              <li>
                <a href="calendar-google.html">Refferal</a>
              </li> -->

        </ul>
      </li>

      <li class="treeview <?php if (strpos($_SERVER['REQUEST_URI'], 'doctor.php') !== false || strpos($_SERVER['REQUEST_URI'], 'Doctor_schedule.php') ) echo 'active'; ?>">
        <a href="#!">
          <i class="icon-streetview"></i>
          <span class="menu-text <?php if ($Page === 'doctor.php') echo 'active'; ?>">Health Professionals</span>
        </a>
        <ul class="treeview-menu"  <?php if ($Page === 'doctor.php') echo 'style="display:block;"'; ?>>
          <li <?php if ($Page === 'doctor.php') echo 'class="active"'; ?>>
            <a href="doctor.php">Manage Health 
              <br>
              Professionals</a>
          </li>
          <li <?php if ($Page === 'Doctor_schedule.php') echo 'class="active"'; ?>>
            <a href="Doctor_schedule.php">Doctor's Schedule</a>
          </li>

        </ul>
      </li>

      <li class="events.php <?php if ($Page === 'events.php') echo 'active'; ?>" >

        <a href="events.php">

          <i class="icon-calendar"></i>
          <span class="menu-text">Events</span>
        </a>
      </li>
      <li class="user.php <?php if ($Page === 'user.php') echo 'active'; ?>">
        <a href="user.php">
          <i class="icon-users"></i>
          <span class="menu-text">Accounts</span>
        </a>
      </li>
      <li class="user_log <?php if ($Page === 'user_log.php') echo 'active'; ?>">
        <a href="user_log.php">
          <i class="icon-security"></i>
          <span class="menu-text">User Logs</span>
        </a>
      </li>

      <li class="treeview <?php if (strpos($_SERVER['REQUEST_URI'], 'backup.php')) echo  'active'; ?>">
        <a href="#!">
          <i class="icon-database"></i>
          <span class="menu-text <?php if ($Page === 'backup.php') echo 'active'; ?>">Backup</span>
        </a>
        <ul class="treeview-menu"  <?php if ($Page === 'backup.php') echo 'style="display:block;"'; ?>>
          <li <?php if ($Page === 'backup.php') echo 'class="active"'; ?>>
            <a href="backup.php">Backup</a>
          </li>
          


        </ul>
      </li>

    </ul>
  </div>
  <!-- Sidebar menu ends -->

</nav>
<!-- Sidebar wrapper end -->