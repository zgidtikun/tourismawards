<?php $script_v = config(\Config\App::class)->script_v; ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="description" content="Thailand Tourism Awards รางวัลอุตสาหกรรมท่องเที่ยวไทย เป็นรางวัลที่รับรองคุณภาพสินค้าและบริการทางการท่องเที่ยว ด้วยมาตรฐานการท่องเที่ยวอย่างยั่งยืน รับผิดชอบต่อสังคม และสิ่งแวดล้อม (Responsible Tourism)">
    <title><?= $this->renderSection('title') ?></title>
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png') ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/boilerplate.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?= base_url('assets/css/css.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?= base_url('assets/css/fonts.css') ?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?= base_url('assets/css/animated-header.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?= base_url('assets/css/flexnav.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?= base_url('assets/css/totop.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?= base_url('assets/css/slick.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?= base_url('assets/css/slick-theme.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?= base_url('assets/css/jquery.mmenu.all.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?= base_url('assets/css/cookie.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?= base_url('assets/css/mobilemenu.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?= base_url('assets/css/device.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?= base_url('assets/css/index.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?= base_url('assets/css/index-login.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?= base_url('assets/css/sfr-css.css') ?>?v=<?= $script_v ?>" rel="stylesheet" type="text/css" media="all">

    <?= $this->renderSection('css') ?>

    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/jquery.mmenu.min.all.js') ?>?v=<?= $script_v ?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?= base_url('assets/js/animated-header.js') ?>?v=<?= $script_v ?>" charset="utf-8"></script>
    <script src="<?= base_url('assets/js/slick.js') ?>?v=<?= $script_v ?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?= base_url('assets/js/main.js') ?>?v=<?= $script_v ?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?= base_url('assets/js/jquery.flexnav.min.js') ?>?v=<?= $script_v ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/jquery.cookie.js') ?>?v=<?= $script_v ?>" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div id="wrapper">
        <div id="includedheader">
            <?= $this->include('_header-menu') ?>
        </div>

        <?= $this->renderSection('banner') ?>

        <div class="mainsite">
            <?= $this->renderSection('content') ?>
        </div>

        <div id="includedfooter">
            <?= $this->include('_footer') ?>
        </div>
    </div>

    <a href="#0" class="cd-top"></a>

    <?= $this->include('_cookie') ?>
    <?= $this->renderSection('recapcha') ?>
    
    <?= $this->renderSection('js') ?>

    <script>
        window.uploadFileUrl = '<?= UPLOAD_FILE_URL ?>';

        document.addEventListener('DOMContentLoaded', () => {   
            <?php if (session()->get('isLoggedIn')) : ?>         
                document.querySelector('.login_list li.userlogin').style.display = 'block';
            <?php endif; ?>

            const headerHeight = document.querySelector('#header-inner').offsetHeight;

            if(document.querySelector('.banner-box') !== null){
                document.querySelector('.banner-box').style.display = 'block';
                document.querySelector('.banner-box').style.marginTop = `${headerHeight}px`;
            }

            if(document.querySelector('.formlogin .mainsite') !== null){
                document.querySelector('.formlogin .mainsite').style.display = 'block';
                document.querySelector('.formlogin .mainsite').style.paddingTop = `${headerHeight}px`;
            }

            if(document.querySelector('.regisform .mainsite') !== null){
                document.querySelector('.regisform .mainsite').style.display = 'block';
                document.querySelector('.regisform .mainsite').style.paddingTop = `${headerHeight}px`;
            }
        });        

        $(".flexnav").flexNav();
    </script>
</body>

</html>