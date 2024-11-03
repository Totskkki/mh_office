<?php include 'session.php'; ?>

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
    <a href="dashboard-mho.php">
      <h3 class="brand-image-xl logo-xl mb-0 text-center" style="color:white">MH-Office <b>MHO</b></h3>
      <!-- <img src="logo/1.png" class="logo" alt="BHW Gallery" /> -->
    </a>
  </div>
  <!-- App brand ends -->
  <!-- Sidebar menu starts -->
  <div class="sidebarMenuScroll">
    <ul class="sidebar-menu">
      <li class="dashboard-mho.php <?php if ($Page === 'dashboard-mho.php') echo 'active'; ?> " id="mnu_dashboard">
        <a href="dashboard-mho.php ">
          <i class="icon-roofing"></i>
          <span class="menu-text">Dashboard</span>
        </a>
      </li>
      
      <li class="treeview <?php if (strpos($_SERVER['REQUEST_URI'], 'checkup.php') !== false || strpos($_SERVER['REQUEST_URI'], 'maternity.php')
      !== false || strpos($_SERVER['REQUEST_URI'], 'prenatal.php')
       !== false || strpos($_SERVER['REQUEST_URI'], 'animal_bite.php') 
       !== false || strpos($_SERVER['REQUEST_URI'], 'vaccination.php')
       !== false || strpos($_SERVER['REQUEST_URI'], 'checkup_record.php') 
        !== false || strpos($_SERVER['REQUEST_URI'], 'records_animalbite.php')
        !== false || strpos($_SERVER['REQUEST_URI'], 'records_prenatal.php')
        !== false || strpos($_SERVER['REQUEST_URI'], 'records_birthing.php')
        !== false || strpos($_SERVER['REQUEST_URI'], 'birthing_monitoring.php')
        !== false || strpos($_SERVER['REQUEST_URI'], 'birthing_patients.php')
        
        !== false) echo 'active'; ?>">
        <a href="#!">

          <i class="icon-business"></i>
          <span class="menu-text <?php if ($Page === 'maternity.php') echo 'active'; ?>">Integrated Health</span>
        </a>
        <ul class="treeview-menu <?php if ($Page === 'maternity.php')  echo 'style="display:block;"'; ?>">
          <li <?php if ($Page === 'checkup.php'|| $Page === 'checkup_record.php')  echo 'class="active"'; ?>>
            <a href="checkup.php">Checkup</a>
          </li>
          <li <?php if ($Page === 'maternity.php') echo 'class="active"'; ?>>
            <a href="maternity.php">Birthing</a>
          </li>
          <li <?php if ($Page === 'prenatal.php') echo 'class="active"'; ?>>
            <a href="prenatal.php">Prenatal</a>
          </li>
          <li <?php if ($Page === 'animal_bite.php' ) echo 'class="active"'; ?>>
            <a href="animal_bite.php">Animal bite & care</a>
          </li>
          <li <?php if ($Page === 'vaccination.php') echo 'class="active"'; ?>>
            <a href="vaccination.php">Vaccination & Immunization</a>
          </li>

        </ul>
      </li>
     
      <li class="treeview <?php if (strpos($_SERVER['REQUEST_URI'], 'new_prescription.php') !== false || strpos($_SERVER['REQUEST_URI'], 'patient.php') !== false || strpos($_SERVER['REQUEST_URI'], 'patient_history.php')!== false || strpos($_SERVER['REQUEST_URI'], 'patient_form.php') 
      !== false || strpos($_SERVER['REQUEST_URI'], 'individual_treatment.php') !== false || strpos($_SERVER['REQUEST_URI'], 'old_patient.php')) echo 'active'; ?>">
        <a href="#!">
          <i class="icon-face"></i>
          <span class="menu-text <?php if ($Page === 'new_prescription.php') echo 'active'; ?>">Patients</span>
        </a>
        
        <ul class="treeview-menu" <?php if ($Page === 'patient.php') echo 'style="display:block;"'; ?>>
          <li <?php if ($Page === 'patient.php'|| $Page ==='patient_form.php'|| $Page ==='individual_treatment.php') echo 'class="active"'; ?>>
            <a href="patient.php">New Patient</a>
          </li>
          <li <?php if ($Page === 'old_patient.php') echo 'class="active"'; ?>>
            <a href="old_patient.php">Old Patient</a>
          </li>
          <li <?php if ($Page === 'new_prescription.php') echo 'class="active"'; ?>>
            <a href="new_prescription.php">New Prescription</a>
          </li>
          <li <?php if ($Page === 'patient_history.php') echo 'class="active"'; ?>>
            <a href="patient_history.php">Patient History</a>
          </li>
        </ul>
      </li>


<!-- 
      <li class="laboratory.php <?php if ($Page === 'laboratory.php') echo 'active'; ?>">

<a href="laboratory.php">

  <i class="icon-activity"></i>
  <span class="menu-text">Laboratory</span>
</a>
</li> -->
      <!-- <ul class="header">PRINTABLES</ul> -->

      <li class="med_cert.php <?php if ($Page === 'med_cert.php') echo 'active'; ?>">

        <a href="med_cert.php">

          <i class="icon-award"></i>
          <span class="menu-text">Certificates & Referrals</span>
        </a>
      </li>

      <!-- <li class="med_cert.php <?php if ($Page === 'referrals.php') echo 'active'; ?>">

        <a href="referrals.php">

          <i class="icon-slack"></i>
          <span class="menu-text">Referrals</span>
        </a>
      </li> -->




    </ul>
  </div>
  <!-- Sidebar menu ends -->

</nav>
<!-- Sidebar wrapper end -->