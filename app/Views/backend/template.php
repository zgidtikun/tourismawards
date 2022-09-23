<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Tourism Award</title>
  <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('backend/assets/images/favicon.png') ?>">
  <link rel="stylesheet" href="<?php echo base_url('backend/assets/css/style.css') ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/backend/assets/plugins/toastr/toastr.min.css">


  <!-- jQuery -->
  <script src="<?php echo base_url() ?>/backend/assets/plugins/jquery/jquery.min.js"></script>
  <!-- Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDB2A4EdZqLr5zN8CsQitzyAf6QsSl4MI"></script>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/backend/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>/backend/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>/backend/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


  <?php echo view('backend/main_css') ?>
</head>

<body>

  <!-- Preloader start -->
  <div id="preloader" style="display: none;">
    <div class="spinner">
      <div class="spinner-a"></div>
      <div class="spinner-b"></div>
    </div>
  </div>
  <!-- Preloader end -->

  <!-- Main wrapper start -->
  <div id="main-wrapper" class="show">

    <!-- Nav header start -->
    <div class="nav-header">
      <div class="brand-logo">
        <a href="index.html">
          <b class="logo-abbr"><img src="<?php echo base_url('backend/assets/images/logo.png') ?>" alt="Tourismaward"> </b>
          <span class="logo-compact"><img src="<?php echo base_url('backend/assets/images/logo-compact.png') ?>" alt="Tourismaward"></span>
          <span class="brand-title">
            <img src="<?php echo base_url('backend/assets/images/logo-compact.png') ?>" alt="Tourismaward" style="width: 70%;">
          </span>
        </a>
      </div>

      <div class="nav-control wave-effect wave-effect-x waves-effect">
        <div class="hamburger">
          <span class="toggle-icon"><i class="icon-list"></i></span>
        </div>
      </div>
    </div>
    <!-- Nav header end -->

    <!-- Header start -->
    <?php echo view('backend/header') ?>
    <!-- Header end ti-comment-alt -->

    <!-- Sidebar start -->
    <?php echo view('backend/sidebar') ?>
    <!-- Sidebar end -->

    <!-- Content body start -->
    <div class="content-body">
      <!-- row -->
      <?php echo view($view) ?>
      <!-- ./end row -->
    </div>
    <!-- Content body end -->

    <!-- Footer start -->
    <?php echo view('backend/footer') ?>
    <!-- Footer end -->
  </div>
  <!-- Main wrapper end -->

  <!-- Scripts -->
  <script src="<?php echo base_url('backend/assets/js/common.min.js') ?>"></script>
  <script src="<?php echo base_url('backend/assets/js/custom.min.js') ?>"></script>
  <script src="<?php echo base_url('backend/assets/js/settings.js') ?>"></script>
  <script src="<?php echo base_url('backend/assets/js/quixnav.js') ?>"></script>
  <script src="<?php echo base_url('backend/assets/js/styleSwitcher.js') ?>"></script>
  <!-- Chartjs chart -->
  <script src="<?php echo base_url('backend/assets/js/Chart.bundle.min.js') ?>"></script>
  <script src="<?php echo base_url('backend/assets/js/dashboard-1.js') ?>"></script>

  <!-- SweetAlert2 -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Toastr -->
  <script src="<?php echo base_url() ?>/backend/assets/plugins/toastr/toastr.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="<?php echo base_url() ?>/backend/assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url() ?>/backend/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo base_url() ?>/backend/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo base_url() ?>/backend/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo base_url() ?>/backend/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo base_url() ?>/backend/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?php echo base_url() ?>/backend/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?php echo base_url() ?>/backend/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?php echo base_url() ?>/backend/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

  <!-- Bootstrap 4 -->
  <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script> -->

  <?php echo view('backend/main_js') ?>
</body>

</html>