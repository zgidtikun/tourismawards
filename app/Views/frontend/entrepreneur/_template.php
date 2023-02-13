<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title><?=$title?></title>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png') ?>">

        <?=view('frontend/entrepreneur/_assets',['view' => $view])?>

    </head>
    <body class="regisform">
        <!--include header-->
        <div id="includedheader">
            <?= view('_header-menu') ?>
        </div>

        <!-- inclide main contents -->
        <div class="mainsite">
            <?= view($view) ?>
        </div>

        <!--include footer-->
        <div id="includedfooter">
            <?= view('_footer') ?>
        </div>
        <a href="#0" class="cd-top"></a>
        <script>            
            jQuery(document).each(function () {
                var headerheight = $('#header-inner').height()+'px';
                $('#includedbanner').css({ "display": "block", "margin-top": headerheight });
                $('.banner-box').css({ "display": "block", "margin-top": headerheight });
                $('.winneraward').css({ "display": "block", "margin-top": headerheight });
                $('.formlogin .mainsite').css({ "display": "block", "padding-top": headerheight });
                $('.regisform .mainsite').css({ "display": "block", "padding-top": headerheight });
            });
        </script>
    </body>
</html>