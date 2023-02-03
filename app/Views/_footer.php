<div class="container footer">
    <div class="container_box">
        <div class="row">
            <div class="col4 logo">
                <picture>
                    <source srcset="<?= base_url('assets/images/footer-logo.svg') ?>">
                    <source srcset="<?= base_url('assets/images/footer-logo.png') ?>">
                    <img src="<?= base_url('assets/images/footer-logo.png') ?>" width="257" height="100" alt="logo" loading="lazy">
                </picture>
                <p>
                การท่องเที่ยวแห่งประเทศไทย (สำนักงานใหญ่)<br>
                1600 ถ.เพชรบุรีตัดใหม่ แขวงมักกะสัน เขตราชเทวี กรุงเทพฯ<br>
                10400 ประเทศไทย<br><br>
                โทร : 064-104-3958<br>
                อีเมล : tourismawards14@gmail.com
                </p>
            </div>
            <div class="col8 footermenu">

                <div class="footermenu_col">
                    <p class="footermenutitle" data-tab="1">เกี่ยวกับโครงการฯ</p>
                    <ul data-tab="1">                        
                        <li><a href="<?=base_url('about-us')?>">ข้อมูลโครงการฯ</a></li>
                        <li><a href="<?=base_url('judge')?>">คณะกรรมการ</a></li>
                    </ul>
                </div>

                <div class="footermenu_col">
                    <p class="footermenutitle" data-tab="2">ข้อมูลการประกวดรางวัล</p>
                    <ul data-tab="2">
                        <li><a href="javascript:;">ประเภทแหล่งท่องเที่ยว</a></li>
                        <li><a href="javascript:;">ประเภทที่พักนักท่องเที่ยว</a></li>
                        <li><a href="javascript:;">ประเภทการท่องเที่ยวเชิงสุขภาพ</a></li>
                        <li><a href="javascript:;">ประเภทรายการนำเที่ยว</a></li>
                        <li><a href="javascript:;">ประเภทการท่องเที่ยวคาร์บอนต่ำเพื่อความยั่งยืน</a></li>
                    </ul>
                </div>

                <div class="footermenu_col">
                    <p class="footermenutitle" data-tab="3">ข้อมูลการใช้งานระบบ</p>
                    <ul data-tab="3">
                        <li><a href="javascript:;">ประเภทแหล่งท่องเที่ยว</a></li>
                        <li><a href="javascript:;">ประเภทที่พักนักท่องเที่ยว</a></li>
                        <li><a href="javascript:;">ประเภทการท่องเที่ยวเชิงสุขภาพ</a></li>
                        <li><a href="javascript:;">ประเภทรายการนำเที่ยว</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="container copyright">
    <div class="container_box">
        <div class="row ">
            <div class="col6">
                <div class="list_copyright">
                    Copyright © <?=date('Y')?>
                    <ul>
                        <li><a href="<?= base_url('privacy-policy') ?>" title="Privacy Policy">Privacy Policy</a></li>
                        <!-- <li><a href="<?= base_url('about-us') ?>" title="About Us">About Us</a></li> -->
                        <li><a href="<?= base_url('contact-us') ?>" title="Contact Us">Contact Us</a></li>
                    </ul>
                </div>
            </div>

            <div class="col6">
                Thailand Tourism Awards 2023.
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        var screen_w = $(window).width();
        var screen_h = $(window).height();
        if (screen_w <= 1024) {
            $(".footermenutitle").click(function() {
                var datatab = $(this).attr("data-tab");
                if ($(this).hasClass("active")) {
                    $(".footermenu_col ul").slideUp(200);
                    $(this).removeClass("active");
                } else {
                    $(".footermenu_col ul").slideUp(200);
                    $('.footermenu_col ul[data-tab="' + datatab + '"]').slideDown(200);
                    $(".footermenutitle").removeClass("active");
                    $(this).addClass("active");
                }
            });
        }

    });
</script>