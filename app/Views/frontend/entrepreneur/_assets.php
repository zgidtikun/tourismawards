<?php $app = new \Config\App(); ?>
<link rel="preconnect" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"> 
<link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" as="style"> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"  rel="stylesheet">

<link rel="preload" href="<?= base_url('assets/css/boilerplate.css') ?>?v=<?=$app->script_v?>" as="style">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/boilerplate.css') ?>?v=<?=$app->script_v?>">

<link rel="preload" href="<?= base_url('assets/css/mobilemenu.css') ?>?v=<?=$app->script_v?>" as="style">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/mobilemenu.css') ?>?v=<?=$app->script_v?>">

<link rel="preload" href="<?= base_url('assets/css/totop.css') ?>?v=<?=$app->script_v?>" as="style">
<link href="<?= base_url('assets/css/totop.css') ?>?v=<?=$app->script_v?>" rel="stylesheet" type="text/css">

<link rel="preload" href="<?= base_url('assets/css/css.css') ?>?v=<?=$app->script_v?>" as="style">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/css.css')?>?v=<?=$app->script_v?>">

<link rel="preload" href="<?= base_url('assets/css/fonts.css') ?>?v=<?=$app->script_v?>" as="style">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/fonts.css')?>?v=<?=$app->script_v?>">

<link rel="preload" href="<?= base_url('assets/css/animated-header.css') ?>?v=<?=$app->script_v?>" as="style">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/animated-header.css')?>?v=<?=$app->script_v?>">

<link rel="preload" href="<?= base_url('assets/css/flexnav.css') ?>?v=<?=$app->script_v?>" as="style">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/flexnav.css')?>?v=<?=$app->script_v?>">

<link rel="preload" href="<?= base_url('assets/css/slick.css') ?>?v=<?=$app->script_v?>" as="style">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/slick.css')?>?v=<?=$app->script_v?>">

<link rel="preload" href="<?= base_url('assets/css/slick-theme.css') ?>?v=<?=$app->script_v?>" as="style">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/slick-theme.css')?>?v=<?=$app->script_v?>">

<link rel="preload" href="<?= base_url('assets/css/device.css') ?>?v=<?=$app->script_v?>" as="style">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/device.css')?>?v=<?=$app->script_v?>">

<link rel="preload" href="<?= base_url('assets/css/mobilemenu.css') ?>?v=<?=$app->script_v?>" as="style">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/mobilemenu.css')?>?v=<?=$app->script_v?>">

<link rel="preload" href="<?= base_url('assets/css/login.css') ?>?v=<?=$app->script_v?>" as="style">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/login.css')?>?v=<?=$app->script_v?>">

<link rel="preload" href="<?= base_url('assets/css/custom.css') ?>?v=<?=$app->script_v?>" as="style">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/custom.css') ?>?v=<?=$app->script_v?>">

<link rel="preconnect" href="<?=base_url('assets/js/jquery-3.6.1.min.js') ?>"> 
<link rel="preload" as="script" href="<?=base_url('assets/js/jquery-3.6.1.min.js') ?>">     
<script src="<?=base_url('assets/js/jquery-3.6.1.min.js') ?>" type="text/javascript"></script>

<link rel="preload" as="script" href="<?= base_url('assets/js/jquery.mmenu.min.all.js')?>"> 
<script src="<?=base_url('assets/js/jquery.mmenu.min.all.js')?>" type="text/javascript" charset="utf-8"></script>

<link rel="preload" as="script" href="<?= base_url('assets/js/main.js')?>?v=<?=$app->script_v?>"> 
<script src="<?=base_url('assets/js/main.js')?>?v=<?=$app->script_v?>" type="text/javascript"  charset="utf-8"></script>

<link rel="preload" as="script" href="<?= base_url('assets/js/animated-header.js')?>?v=<?=$app->script_v?>"> 
<script src="<?=base_url('assets/js/animated-header.js')?>?v=<?=$app->script_v?>" charset="utf-8"></script>

<link rel="preload" as="script" href="<?= base_url('assets/js/jquery.flexnav.min.js')?>?v=<?=$app->script_v?>"> 
<script src="<?=base_url('assets/js/jquery.flexnav.min.js')?>?v=<?=$app->script_v?>" type="text/javascript"></script>

<link rel="preload" as="script" href="<?= base_url('assets/js/jquery.cookie.js')?>"> 
<script src="<?=base_url('assets/js/jquery.cookie.js')?>" type="text/javascript"></script>

<link rel="preconnect" href="//cdn.jsdelivr.net/npm/sweetalert2@11"> 
<link rel="preload" as="script" href="//cdn.jsdelivr.net/npm/sweetalert2@11"> 
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="preload" as="script" href="<?= base_url('assets/js/frontend/other.js')?>?v=<?=$app->script_v?>"> 
<script src="<?= base_url('assets/js/frontend/other.js') ?>?v=<?=$app->script_v?>" charset="utf-8" type="text/javascript"></script>

<link rel="preload" as="script" href="<?= base_url('assets/js/frontend/alert.js')?>?v=<?=$app->script_v?>"> 
<script src="<?= base_url('assets/js/frontend/alert.js') ?>?v=<?=$app->script_v?>" charset="utf-8" type="text/javascript"></script>

<?php if($view == 'frontend/entrepreneur/application') : ?>
<link rel="preconnect" href="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/JQL.min.js"> 
<link rel="preload" as="script" href="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/JQL.min.js"> 
<script src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/JQL.min.js" type="text/javascript"></script>

<link rel="preconnect" href="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/typeahead.bundle.js"> 
<link rel="preload" as="script" href="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/typeahead.bundle.js"> 
<script src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/typeahead.bundle.js" type="text/javascript"></script>

<link rel="preconnect" href="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css">
<link rel="preload" href="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css" as="style">
<link href="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css" rel="stylesheet">

<link rel="preconnect" href="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.js"> 
<link rel="preload" as="script" href="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.js"> 
<script src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.js" type="text/javascript"></script>

<script>
    $.Thailand.setup({
        database: 'https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/database/db.json'
    });
</script>
<?php endif; ?>