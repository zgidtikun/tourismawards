<link rel="preconnect" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"> 
<link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" as="style"> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"  rel="stylesheet">

<link rel="preload" href="<?= base_url('assets/css/boilerplate.css') ?>" as="style">
<link href="<?= base_url('assets/css/boilerplate.css') ?>" rel="stylesheet" type="text/css" />

<link rel="preload" href="<?= base_url('assets/css/mobilemenu.css') ?>" as="style">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/mobilemenu.css') ?>">

<link rel="preload" href="<?= base_url('assets/css/totop.css') ?>" as="style">
<link href="<?= base_url('assets/css/totop.css') ?>" rel="stylesheet" type="text/css">

<link rel="preload" href="<?= base_url('assets/css/custom.css') ?>" as="style">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/custom.css') ?>">

<?php if(in_array($view,$noLogin)) : ?>

<link rel="preload" href="<?= base_url('assets/css/login.css') ?>" as="style">
<link href="<?= base_url('assets/css/login.css') ?>" rel="stylesheet" type="text/css" />

<link rel="preload" href="<?= base_url('assets/css/cookie.css') ?>" as="style">
<link href="<?= base_url('assets/css/cookie.css') ?>" rel="stylesheet" type="text/css">

<link rel="preload" href="<?= base_url('assets/css/menu.css') ?>" as="style">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/menu.css') ?>">

<link rel="preconnect" href="https://code.jquery.com/jquery-2.2.0.min.js"> 
<link rel="preload" as="script" href="https://code.jquery.com/jquery-2.2.0.min.js"> 
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>

<link rel="preload" as="script" href="<?= base_url('assets/js/main.js')?>"> 
<script src="<?= base_url('assets/js/main.js') ?>" charset="utf-8" type="text/javascript"></script>

<?php else : ?>

<link rel="preload" href="<?= base_url('assets/css/css.css') ?>" as="style">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/css.css')?>">

<link rel="preload" href="<?= base_url('assets/css/animated-header.css') ?>" as="style">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/animated-header.css')?>">

<link rel="preload" href="<?= base_url('assets/css/flexnav.css') ?>" as="style">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/flexnav.css')?>">

<link rel="preload" href="<?= base_url('assets/css/slick.css') ?>" as="style">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/slick.css')?>">

<link rel="preload" href="<?= base_url('assets/css/slick-theme.css') ?>" as="style">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/slick-theme.css')?>">

<link rel="preload" href="<?= base_url('assets/css/jquery.mmenu.all.css') ?>" as="style">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/jquery.mmenu.all.css')?>">

<link rel="preload" href="<?= base_url('assets/css/device.css') ?>" as="style">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/device.css')?>">

<link rel="preload" href="<?= base_url('assets/css/index.css') ?>" as="style">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/index.css')?>">

<link rel="preconnect" href="<?=base_url('assets/js/jquery-3.6.1.min.js') ?>"> 
<link rel="preload" as="script" href="<?=base_url('assets/js/jquery-3.6.1.min.js') ?>">     
<script src="<?=base_url('assets/js/jquery-3.6.1.min.js') ?>" type="text/javascript"></script>

<link rel="preload" as="script" href="<?= base_url('assets/js/jquery.mmenu.min.all.js')?>"> 
<script src="<?=base_url('assets/js/jquery.mmenu.min.all.js')?>" type="text/javascript" charset="utf-8"></script>

<link rel="preload" as="script" href="<?= base_url('assets/js/animated-header.js')?>"> 
<script src="<?=base_url('assets/js/animated-header.js')?>" charset="utf-8"></script>

<link rel="preload" as="script" href="<?= base_url('assets/js/slick.js')?>"> 
<script src="<?=base_url('assets/js/slick.js')?>" type="text/javascript" charset="utf-8"></script>

<link rel="preload" as="script" href="<?= base_url('assets/js/main.js')?>"> 
<script src="<?=base_url('assets/js/main.js')?>" type="text/javascript"  charset="utf-8"></script>

<link rel="preload" as="script" href="<?= base_url('assets/js/jquery.flexnav.min.js')?>"> 
<script src="<?=base_url('assets/js/jquery.flexnav.min.js')?>" type="text/javascript"></script>

<link rel="preload" as="script" href="<?= base_url('assets/js/jquery.cookie.js')?>"> 
<script src="<?=base_url('assets/js/jquery.cookie.js')?>" type="text/javascript"></script>

<?php endif; ?>

<link rel="preload" as="script" href="<?= base_url('assets/js/jquery.cookie.js')?>"> 
<script src="<?=base_url('assets/js/jquery.cookie.js')?>" type="text/javascript"></script>

<link rel="preconnect" href="//cdn.jsdelivr.net/npm/sweetalert2@11"> 
<link rel="preload" as="script" href="//cdn.jsdelivr.net/npm/sweetalert2@11"> 
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="preload" as="script" href="<?= base_url('assets/js/frontend/other.js')?>"> 
<script src="<?= base_url('assets/js/other.js') ?>" charset="utf-8" type="text/javascript"></script>

<link rel="preload" as="script" href="<?= base_url('assets/js/frontend/alert.js')?>"> 
<script src="<?= base_url('assets/js/alert.js') ?>" charset="utf-8" type="text/javascript"></script>

<?php if($view == 'frontend/app-form') : ?>
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

