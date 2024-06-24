<?php $script_v = config(\Config\App::class)->script_v; ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $this->renderSection('title') ?></title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png') ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/boilerplate.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/css/fonts.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/css/totop.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/css/custom.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/css/login.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/css/cookie.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/css/css.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/css/animated-header.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/css/flexnav.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/css/jquery.mmenu.all.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/css/device.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/css/mobilemenu.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/css/index-login.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/css/sfr-css.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css" media="all">

    <?= $this->renderSection('css') ?>

    <script src="<?= base_url('assets/js/jquery-3.6.1.min.js') ?>?v=<?= $script_v ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/main.js') ?>?v=<?= $script_v ?>" charset="utf-8" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/jquery.mmenu.min.all.js') ?>?v=<?= $script_v ?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?= base_url('assets/js/animated-header.js') ?>?v=<?= $script_v ?>" charset="utf-8"></script>
    <script src="<?= base_url('assets/js/slick.js') ?>?v=<?= $script_v ?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?= base_url('assets/js/main.js') ?>?v=<?= $script_v ?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?= base_url('assets/js/jquery.flexnav.min.js') ?>?v=<?= $script_v ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/jquery.cookie.js') ?>?v=<?= $script_v ?>" type="text/javascript"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        window.uploadFileUrl = '<?=UPLOAD_FILE_URL?>';
    </script>

    <script src="<?= base_url('assets/js/frontend/other.js') ?>?v=<?= $script_v ?>" charset="utf-8" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/frontend/alert.js') ?>?v=<?= $script_v ?>" charset="utf-8" type="text/javascript"></script>
</head>

<body class="formlogin">

    <div id="includedheaderuser">
        <?= $this->include('_header-menu') ?>
    </div>

    <div class="mainsite loginform">
        <div id="includedbanneruser" class="loginform">
            <?= $this->include('frontend/_banner') ?>
        </div>
        <?= $this->renderSection('content') ?>
    </div>

    <a href="#0" class="cd-top"></a>

    <?= $this->include('_cookie') ?>
    <?= $this->renderSection('recapcha') ?>

    <?= $this->renderSection('js') ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            <?php if (session()->get('isLoggedIn')) : ?>
                document.querySelector('.login_list li.userlogin').style.display = 'block';
            <?php endif; ?>

            const headerHeight = document.querySelector('.header-box').offsetHeight;

            if (document.querySelector('#includedbanner') !== null) {
                document.querySelector('#includedbanner').style.display = 'block';
                document.querySelector('#includedbanner').style.marginTop = `${headerHeight}px`;
            }

            if (document.querySelector('.formlogin .mainsite') !== null) {
                document.querySelector('.formlogin .mainsite').style.display = 'block';
                document.querySelector('.formlogin .mainsite').style.paddingTop = `${headerHeight}px`;
            }

            if (document.querySelector('.regisform .mainsite') !== null) {
                document.querySelector('.regisform .mainsite').style.display = 'block';
                document.querySelector('.regisform .mainsite').style.paddingTop = `${headerHeight}px`;
            }
        });

        $(".flexnav").flexNav();
    </script>

</body>

</html>