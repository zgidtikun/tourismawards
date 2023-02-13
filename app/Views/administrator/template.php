<?php $app = new \Config\App(); ?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Amazing Thailand Safety and Health Administration (SHA)</title>
  <meta name="apple-mobile-web-app-capable" content="yes">
  <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/favicon.png">

  <!-- ของเดิม -->
  <script src="https://code.jquery.com/jquery-2.2.0.min.js?v=<?= $app->script_v ?>" type="text/javascript"></script>
  <!-- ของใหม่ -->
  <!-- <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script> -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js?v=<?= $app->script_v ?>"></script>
  <!-- DataTable -->
  <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js?v=<?= $app->script_v ?>"></script>
  <script src="<?= base_url() ?>/assets/js/dataTables.responsive.min.js?v=<?= $app->script_v ?>"></script>

  <script type="text/javascript" src="<?= base_url() ?>/assets/js/main.js?v=<?= $app->script_v ?>" charset="utf-8"></script>
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/boilerplate.css?v=<?= $app->script_v ?>" type="text/css" />

  <!-- Bootstrap 5 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css?v=<?= $app->script_v ?>">
  <!-- Bootstrap 4 -->
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css?v=<?= $app->script_v ?>"> -->


  <!-- DataTable -->
  <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css?v=<?= $app->script_v ?>">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/site.css?v=<?= $app->script_v ?>" />
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/responsive.dataTables.min.css?v=<?= $app->script_v ?>" />

  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/fonts.css?v=<?= $app->script_v ?>" />
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/totop.css?v=<?= $app->script_v ?>" />
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/cookie.css?v=<?= $app->script_v ?>" />
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/backend.css?v=<?= $app->script_v ?>" />
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/fileup.css?v=<?= $app->script_v ?>" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css?v=<?= $app->script_v ?>">

  <!-- Select2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css?v=<?= $app->script_v ?>">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/summernote/summernote-bs5.min.css?v=<?= $app->script_v ?>">
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/summernote/summernote-lite.min.css?v=<?= $app->script_v ?>">

  <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css?v=<?= $app->script_v ?>" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js?v=<?= $app->script_v ?>"></script>

  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css?v=<?= $app->script_v ?>" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js?v=<?= $app->script_v ?>"></script> -->

  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css?v=<?= $app->script_v ?>">

  <!-- Chart JS -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js?v=<?= $app->script_v ?>"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

  <?php echo view('administrator/main_css') ?>
</head>

<body>

  <div class="backend">

    <div class="container">
      <div class="row">

        <!--include backendmenu-->
        <div id="includedbackendmenu">
          <?php echo view('administrator/sidebar') ?>
        </div>

        <div class="backendmain">

          <div class="backendheader">
            <div class="backendheader-row">

              <!--include backenduser-->
              <div id="includedbackenduser">
                <?php echo view('administrator/header') ?>
              </div>

            </div>

            <div class="backendheader-row">
              <div class="backend-title">
                <h2><?= $title ?></h2>
              </div>
            </div>
          </div>

          <div class="">
            <?php echo view($view) ?>
          </div>

        </div>
      </div>
    </div>

  </div>

  <!--include cookie-->
  <!-- <div id="includedcookiebox"></div> -->

  <a href="#0" class="cd-top"></a>


  <!-- SweetAlert2 -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Toastr -->
  <script src="<?php echo base_url() ?>/assets/plugins/toastr/toastr.min.js?v=<?= $app->script_v ?>"></script>
  <!-- Select2 -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js?v=<?= $app->script_v ?>"></script>
  <!-- Summernote -->
  <script src="<?php echo base_url() ?>/assets/plugins/summernote/summernote-bs5.min.js?v=<?= $app->script_v ?>"></script>
  <script src="<?php echo base_url() ?>/assets/plugins/summernote/summernote-lite.min.js?v=<?= $app->script_v ?>"></script>

  <?php echo view('administrator/main_js') ?>

</body>

</html>