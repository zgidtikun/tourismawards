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

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@200;300&display=swap');

    html {
      font-family: "TATSana-Chon", "Tahoma", "Helvetica";
      --bs-font-sans-serif: "TATSana-Chon", "Tahoma", "Helvetica" !important;
      --bs-font-monospace: "TATSana-Chon", "Tahoma", "Helvetica" !important;
      --bs-body-font-family: var(--bs-font-sans-serif);
      font-size: 18px;
      font-style: normal;
      font-weight: normal;
      -webkit-font-smoothing: antialiased;
      transition: all 0.2s;
      line-height: 1.5em;
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

  <script src="<?php echo base_url('assets/js/common.min.js') ?>"></script>
</body>

</html>