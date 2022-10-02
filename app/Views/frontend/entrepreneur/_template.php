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
    <body>
        <div id="wrapper">

            <!--include header-->
            <div id="includedheader">
                <?= view('_header-menu') ?>
            </div>

            <!-- inclide main contents -->
            <div class="mainsite mb-5">
                <?= view($view) ?>
            </div>

            <!--include footer-->
            <div id="includedfooter">
                <?= view('_footer') ?>
            </div>

            <a href="#0" class="cd-top"></a>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                jQuery(document).each(function() {
                    var headerheight = $('div.header-box').height()+'px';
                    $('.mainsite').css({
                        "display": "block",
                        "margin-top": headerheight
                    });
                });
            });
        </script>
        
    </body>
</html>