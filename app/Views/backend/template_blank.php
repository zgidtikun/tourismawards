<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Tourism Award | <?= $title ?></title>
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/images/favicon.png') ?>">
  <link rel="stylesheet" href="<?php echo base_url('backend/assets/css/style.css') ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style type="text/css">
    /* Chart.js */

    @-webkit-keyframes chartjs-render-animation {
      from {
        opacity: 0.99
      }

      to {
        opacity: 1
      }
    }

    @keyframes chartjs-render-animation {
      from {
        opacity: 0.99
      }

      to {
        opacity: 1
      }
    }

    .chartjs-render-monitor {
      -webkit-animation: chartjs-render-animation 0.001s;
      animation: chartjs-render-animation 0.001s;
    }
  </style>
</head>

<body style="height: 100vh;">

  <!--*******************
        Preloader start
    ********************-->
  <div id="preloader" style="display: none;">
    <div class="spinner">
      <div class="spinner-a"></div>
      <div class="spinner-b"></div>
    </div>
  </div>


  <?php echo view($view) ?>

  <script src="<?php echo base_url('backend/assets/js/common.min.js') ?>"></script>
  <script src="<?php echo base_url('backend/assets/js/custom.min.js') ?>"></script>
  <script src="<?php echo base_url('backend/assets/js/settings.js') ?>"></script>
  <script src="<?php echo base_url('backend/assets/js/quixnav.js') ?>"></script>
  <script src="<?php echo base_url('backend/assets/js/styleSwitcher.js') ?>"></script>
  <!-- Chartjs chart -->
  <script src="<?php echo base_url('backend/assets/js/Chart.bundle.min.js') ?>"></script>
</body>

</html>