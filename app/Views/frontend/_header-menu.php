<div class="header-box">

    <div class="header-box-row">
        <div class="header-box-col logo">
            <picture>
                <source srcset="<?=base_url('assets/images/logo.svg')?>">
                <img src="<?=base_url('assets/images/logo.png')?>">
            </picture>
        </div>

        <div class="header-box-col menu">
            <nav>
                <ul>
                    <li><a href="<?=base_url()?>">หน้าแรก</a></li>
                    <li><a href="javascript:void(0);">เกี่ยวกับโครงการ</a></li>
                    <li><a href="<?=base_url('awards-winner')?>">ข้อมูลการประกวดรางวัล</a></li>
                    <li><a href="javascript:void(0);">คู่มือประกวดรางวัล</a></li>
                    <li><a href="javascript:void(0);">คู่มือการสมัคร</a></li>
                    <li><a href="javascript:void(0);">ผลงานที่ได้รับรางวัล</a></li>
                    <li><a href="<?=base_url('new')?>">ข่าวประชาสัมพันธ์</a>
                    <li><a href="<?=base_url('contact-us')?>">ติดต่อเรา</a></li>
                </ul>
            </nav>
        </div>

        <div class="header-box-col search">
            <div class="searchinput">
                <input class=""><button type="submit"></button>
            </div>
        </div>

        <div class="header-box-col mobilemenu">
            <a href="javascript:void(0)" class="btn-menu">
                <svg style="width:34px;height:34px" viewBox="0 0 24 24">
                    <path fill="#FFFFFF" d="M3,6H21V8H3V6M3,11H21V13H3V11M3,16H21V18H3V16Z" />
                </svg>
            </a>
        </div>

        <div class="menubox">
            <a href="javascript:void(0)" class="menuclose">
                <picture>
                    <source srcset="<?=base_url('assets/images/btnclose.svg')?>">
                    <img src="<?=base_url('assets/images/btnclose.png')?>">
                </picture>
            </a>
            <div class="menulogo">
                <picture>
                    <source srcset="<?=base_url('assets/images/logo.svg')?>">
                    <img src="<?=base_url('assets/images/logo.png')?>">
                </picture>
            </div>
            <ul>
                <li><a href="<?=base_url()?>">หน้าแรก</a></li>
                <li><a href="javascript:void(0);">เกี่ยวกับโครงการ</a></li>
                <li><a href="<?=base_url('awards-winner')?>;">ข้อมูลการประกวดรางวัล</a></li>
                <li><a href="javascript:void(0);">คู่มือประกวดรางวัล</a></li>
                <li><a href="javascript:void(0);">คู่มือการสมัคร</a></li>
                <li><a href="javascript:void(0);">ผลงานที่ได้รับรางวัล</a></li>
                <li><a href="<?=base_url('new')?>">ข่าวประชาสัมพันธ์</a></li>
                <li><a href="<?=base_url('contact-us')?>">ติดต่อเรา</a></li>
                <li><a href="javascript:void(0);">ค้นหา</a></li>
            </ul>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function() {
        $('.btn-menu').click(function() {
            if ($('.menubox').hasClass('active')) {
                $('body').removeClass('overlay');
                $('.menubox').removeClass('active');
                $('.btn-menu path').css({ "fill": "#000" });
            } else {
                $('body').addClass('overlay');
                $('.menubox').addClass('active');
                $('.btn-menu path').css({ "fill": "#FFF" });
            }
        });
        
        $('.menuclose').click(function() {
            $('body').removeClass('overlay');
            $('.menubox').removeClass('active');
            $('.btn-menu path').css({ "fill": "#000" });
        });
    });
</script>