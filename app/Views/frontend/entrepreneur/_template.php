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
        <!--include header-->
        <div id="includedheader">
            <?= view('_header-menu') ?>
        </div>

        <!-- inclide main contents -->
        <div class="mainsite mb-4">
            <?= view($view) ?>
        </div>

        <!--include footer-->
        <div id="includedfooter">
            <?= view('_footer') ?>
        </div>
        <a href="#0" class="cd-top"></a>
        
    </body>
</html>