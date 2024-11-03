<?php

include 'session.php';

if ($_SESSION['user_type'] === 'Admin') {
  header("location: ../admin/dashboard.php");
  exit;
} else if ($_SESSION['user_type'] === 'RHU') {

  header("location: RHU/dashboard-mho.php");
  exit;
}

// if (isset($_SESSION['login']) && $_SESSION['login'] === true && $_SESSION['user_type'] === 'RHU'&& $_SESSION['login'] === true && $_SESSION['user_type'] === 'Admin') {
//   header("location: RHU/dashboard-mho.php");
//   exit;
// }

?>

<?php $Page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1); ?>

<style>
 


 .sidebar-menu .treeview-menu>li>a {
    padding: 7px 15px 7px 25px;
    margin-left: 40px;
    border-left: 1px solid #e7e9f1;
    display: block;
    color: #fff;
    white-space: nowrap;
}

  .sidebar-menu>li>a:hover,
  .sidebar-menu .treeview-menu li>a:hover {
    color: #ffffff;
    background-color: #4787ed;
    border-radius: 15px;
  }

  .sidebar-menu>li.treeview.active:after {
    transform: rotate(-90deg);
    color: #4787ed;
  }

  #sidebar {
    display: flex;
    flex-direction: column;
    height: 100vh;
  }

  /* .sidebar-footer {
    position: sticky;
    bottom: 0;
    width: 100%;
    background: inherit;

  } */

  .sidebarMenuScroll {
    flex: 1;
    overflow-y: auto;
  }

  /* #896a22 */
  /* .sidebar-wrapper {
    background-color: #ef0000;
}
   */
  .app-brand {

    background: #3F7791;

  }

  .btn-outline-danger {
    --bs-btn-color: #fff;
    --bs-btn-border-color: #3F7791;
    --bs-btn-hover-color: #ffffff;
    --bs-btn-hover-bg: #34424F;
    --bs-btn-hover-border-color: #fff;
    --bs-btn-focus-shadow-rgb: 229, 0, 0;
    --bs-btn-active-color: #ffffff;
    --bs-btn-active-bg: #fff;
    --bs-btn-active-border-color: #fff;
    --bs-btn-active-shadow: inset 0 3px 5px rgba(24, 24, 25, 0.125);
    --bs-btn-disabled-color: #FF4500;
    --bs-btn-disabled-bg: transparent;
    --bs-btn-disabled-border-color: #fff;
    --bs-gradient: none;
  }

  .sidebar-wrapper {
    background-color: #34424F;
  }

  .sidebar-menu>li.active>a [class^=icon-] {
    color: #000000;
    background: #fff;
  }

  .sidebar-menu>li>a {
    display: flex;
    padding: 7px 15px 7px 15px;
    align-items: center;
    font-size: .875rem;
    color: #ffffff;
    transition: background-color 0.3s, color 0.3s, border-radius 0.3s;
    white-space: nowrap;
  }

  /* Hover state for links */
  .sidebar-menu>li>a:hover {
    color: #ffffff;
    background-color: #4787ed;
    border-radius: 15px;

  }


  .sidebar-menu>li.active>a {
    background-color: #202A33;
    color: #ffffff;
    border-radius: 15px;

  }
</style>


<!-- Sidebar wrapper start -->
<nav id="sidebar" class="sidebar-wrapper">

  <!-- App brand starts -->
  <div class="app-brand px-3 py-2 d-flex align-items-center">
    <a href="home.php">
      <h3 class="brand-image-xl logo-xl mb-0 text-center" style="color:white"> <?php echo $user['sidebar']; ?></b>

      </h3>
      <!-- <img src="logo/1.png" class="logo" alt="BHW Gallery" /> -->

    </a>
  </div>
  <!-- App brand ends -->

  <!-- Sidebar menu starts -->
  <div class="sidebarMenuScroll">
    <ul class="sidebar-menu">
      <li class="home.php <?php if ($Page === 'home.php') echo 'active'; ?>" id="mnu_dashboard">
        <a href="home.php">
          <i class="icon-roofing"></i>
          <span class="menu-text">Dashboard</span>
        </a>
      </li>

      <li class="add_patient.php <?php if ($Page === 'add_patient.php') echo 'active'; ?>">

        <a href="add_patient.php">
          <i class="icon-portrait"></i>
          <span class="menu-text">New Patient </span>
        </a>
      </li>

      <!-- <li class="old_patient.php <?php if ($Page === 'old_patient.php') echo 'active'; ?>">

        <a href="old_patient.php">
          <i class="icon-accessible_forward"></i>

          <span class="menu-text">Old Patient</span>
        </a>
      </li> -->

      <li class="treeview <?php if (strpos($_SERVER['REQUEST_URI'], 'old_patient.php')) echo 'active'; ?>">
        <a href="#!">
          <i class="icon-settings"></i>
          <span class="menu-text <?php if ($Page === 'old_patient.php') echo 'active'; ?>">Old Patient</span>
        </a>

        <ul class="treeview-menu" <?php if ($Page === 'old_patient.php') echo 'style="display:block;"'; ?>>
          <li <?php if ($Page === 'old_patient.php') echo 'class="active"'; ?>>
            <a href="old_patient.php">Individual Treatment</a>
          </li>

        </ul>
      </li>

      <li class="patient_list.php <?php if ($Page === 'patient_list.php') echo 'active'; ?>">

        <a href="patient_list.php">
          <i class="icon-person"></i>

          <span class="menu-text">Records</span>
        </a>
      </li>


      <li class="med_cert.php <?php if ($Page === 'referrals.php') echo 'active'; ?>">

        <a href="referrals.php">

          <i class="icon-slack"></i>
          <span class="menu-text">Referrals</span>
        </a>
      </li>

      <!-- <li class="profile.php <?php if ($Page === 'profile.php') echo 'active'; ?>">

        <a href="profile.php?id=<?php echo $_SESSION['user_id']; ?>">
          <i class="icon-settings"></i>
          <span class="menu-text">Settings</span>
        </a>
      </li> -->
      <li class="treeview <?php if (strpos($_SERVER['REQUEST_URI'], 'profile.php')) echo 'active'; ?>">
        <a href="#!">
          <i class="icon-settings"></i>
          <span class="menu-text <?php if ($Page === 'profile.php') echo 'active'; ?>">Settings</span>
        </a>

        <ul class="treeview-menu" <?php if ($Page === 'profile.php') echo 'style="display:block;"'; ?>>
          <li <?php if ($Page === 'profile.php') echo 'class="active"'; ?>>
            <a href="profile.php?id=<?php echo $_SESSION['user_id']; ?>">Profile</a>
          </li>

        </ul>
      </li>


      <li class="nav-header"></li>

      <!-- Remaining sidebar menu items... -->
      <!-- <li style="margin-top: auto;">
    <a href="logout.php" class="btn">
        <i class="icon-log-out"></i>
        <span class="btn btn-primary">Logout</span>
    </a>
</li> -->
      <!-- Sidebar Ends -->









    </ul>


  </div>
  <!-- Sidebar menu ends -->

  <div class="sidebar-footer ">


    <ul class="sidebar-menu">
      <li class="#">

        <a href="logout.php">
          <i class="icon-log-out "></i>
          <span class="menu-text">Logout</span>
        </a>
      </li>
    </ul>
  </div>

</nav>
<!-- Sidebar wrapper end -->