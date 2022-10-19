<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title><?=$title?></title>
    <link rel="shortcut icon" href="<?=base_url('assets/images/favicon.png')?>">

    <?=view('_assets-app')?>

</head>
<body>
    <div id="wrapper">
        <!--include header-->
        <div id="includedheader">
            <?=view('_header-menu')?>
        </div>

        <?php if(!empty($_banner) && $_banner) : ?>
        <!--include banner-->
        <div id="includedbanner">
            <?=view('_banner')?>
        </div>
        <?php endif; ?>

        <!-- inclide main contents -->
        <div class="mainsite">
            <?=view($view)?>
        </div>

        <!--include footer-->
        <div id="includedfooter">
            <?=view('_footer')?>
        </div>     
    </div>  
    <a href="#0" class="cd-top"></a>   
    <!--include cookie--> 
    <?=view('_cookie')?> 

    <!--include recapcha-->   
    <?php if(!empty($_recapcha) && $_recapcha) : ?>
    <?=view('_recapcha')?>
    <?php endif; ?>
    
    <script>           
        $(document).ready(function(){
            <?php if(session()->get('isLoggedIn')) : ?>
                $('.login_list li.userlogin').css('display','block');
            <?php endif; ?> 
        });

        jQuery(document).each(function () {
            var headerheight = $('#header-inner').height()+'px';
            // console.log("headerheight = "+headerheight);
            $('#includedbanner').css({ "display": "block", "margin-top": headerheight });
            $('.banner-box').css({ "display": "block", "margin-top": headerheight });
            $('.winneraward').css({ "display": "block", "margin-top": headerheight });
            $('.formlogin .mainsite').css({ "display": "block", "padding-top": headerheight });
            $('.regisform .mainsite').css({ "display": "block", "padding-top": headerheight });
        });
    </script>
</body>