<?php
    $noLogin = array('frontend/login', 'frontend/register', 'frontend/forgetpass');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $title ?></title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png') ?>">

    <?= view('_assets-frontend', ['noLogin' => $noLogin, 'view' => $view]) ?>

</head>
<?php if (in_array($view, $noLogin)) : ?>

    <body style="background-color: #eff2fb;">

        <!--include header-->
        <div id="includedheaderuser" class="formlogin">
            <?= view('frontend/_header-menu') ?>
        </div>

        <!--include banner-->
        <div id="includedbanneruser">
            <?= view('frontend/_banner') ?>
        </div>

        <div class="mainsite loginform">
            <?= view($view) ?>
        </div>

        <a href="#0" class="cd-top"></a>

    </body>
    <!--include cookie-->
    <?= view('_cookie') ?>

    <!--include recapcha-->
    <?php if (!empty($_recapcha) && $_recapcha) : ?>
        <?= view('_recapcha') ?>
    <?php endif; ?>
    <script>
        jQuery(document).each(function() {
            var headerheight = $('.header-box').height();
            $('.inpform').css({
                "display": "block",
                "margin-top": headerheight
            });
        });
    </script>
<?php else : ?>

    <body style="background-color: #f5f4f1;">
        <div id="wrapper">

            <!--include header-->
            <div id="includedheader">
                <?= view('_header-menu') ?>
            </div>

            <!-- inclide main contents -->
            <div class="mainsite">
                <?= view($view) ?>
            </div>

            <!--include footer-->
            <div id="includedfooter" style="width: 100%;">
                <?= view('_footer') ?>
            </div>

            <a href="#0" class="cd-top"></a>
        </div>
    </body>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            jQuery(document).each(function() {
                var headerheight = $('.header-box ').height();
                $('#mainsite').css({
                    "display": "block",
                    "margin-top": headerheight
                });
            });
        });
    </script>
<?php endif; ?>

</html>