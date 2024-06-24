<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <title>Thailand Tourism Awards</title>
        <link rel="shortcut icon" href="<?=base_url('assets/images/favicon.png')?>">

        <style>
            body, html{
                font-family: TATSana-Chon,Tahoma,Helvetica;
                height: 100%;
                font-size: 18px;
                width: 100%
            }            
            .logo,.text,body,html{
                width: 100%
            }            
            @font-face{
                font-family:TATSana-Chon;
                src:url('assets/fonts/TATSanaChon-Regular.eot');
                src:url('assets/fonts/TATSanaChon-Regular.eot#iefix') format('embedded-opentype'),
                    url('assets/fonts/TATSanaChon-Regular.ttf') format('truetype'),
                    url('assets/fonts/TATSanaChon-Regular.woff') format('woff'),
                    url('assets/fonts/TATSanaChon-Regular.svg#login') format('svg');
                font-weight: 400;
                font-style: normal
            }            
            html{
                background-image:url(/assets/images/coming-soon-bg.jpg);
                background-position:center;
                background-repeat:no-repeat;
                background-size:cover;
                background-color:#113a6b
            }            
            body{
                overflow: hidden;
                padding: 0;
                margin: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                line-height: 1.4
            }            
            .mainbox{
                display: flex;
                position: relative;
                margin: 0 auto;
                text-align: center;
                color: #fff;
                max-width: 95%;
                max-height: 97%;
                flex-wrap: wrap;
                justify-content: center
            }
            img{
                width:auto;
                height:auto;
                max-width:100%;
                max-height:100%
            }            
            .logo{
                margin-bottom:40px
            }            
            .logo img{
                width:674px;
                height:auto
            }            
            .text{
                font-family:TATSana-Chon;
                font-size:3rem;
                color:#fff;
                word-break:break-word;
                white-space:pre-line
            }
            @media screen and (max-width:1024px){
                body,html{
                    font-size:16px
                }
                .logo{
                    max-width:65vw
                }
                .text{
                    font-size:2rem
                }
            }
            @media screen and (max-width:768px){
                .text{
                    font-size:2rem
                }
            }
            @media screen and (max-width:767px){
                .text{
                    font-size:1.3rem
                }
            }
        </style>

    </head>

    <body>

        <div class="mainbox">
            <div class="logo">
                <picture>
                    <source srcset="<?=base_url('assets/images/coming-logo.svg')?>">
                    <source srcset="<?=base_url('assets/images/coming-logo.png')?>">
                    <img src="<?=base_url('assets/images/coming-logo.png')?>" width="674" height="262">
                </picture>
            </div>
            <div class="text">
                เตรียมพบกับเว็บไซต์โฉมใหม่ของ 
                Thailand Tourism Awards เร็ว ๆ นี้
            </div>
        </div>

    </body>
</html>