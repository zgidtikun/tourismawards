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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kanit:wght@400&display=swap">


  <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Toastr -->
  <script src="<?php echo base_url() ?>/assets/plugins/toastr/toastr.min.js"></script>

  <style>
    body {
      font-family: 'Kanit', sans-serif !important;
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

</body>

</html>