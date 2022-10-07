<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $title ?></title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png') ?>">

    <?= view('_assets-frontend') ?>

</head>

    <body class="formlogin">

        <!--include header-->
        <div id="includedheaderuser">
            <?= view('_header-menu') ?>
        </div>

        <!--include banner-->
        <div id="includedbanneruser" class="loginform">
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
        jQuery(document).each(function () {
                var headerheight = $('.header-box ').height()+"px";
                $('#includedbanner').css({ "display": "block", "margin-top": headerheight });
                $('.formlogin .mainsite').css({ "display": "block", "padding-top": headerheight });
                $('.regisform .mainsite').css({ "display": "block", "padding-top": headerheight });
            });
    </script>

</html>