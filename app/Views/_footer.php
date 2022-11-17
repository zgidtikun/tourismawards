<div class="container footer">
    <div class="container_box">
        <div class="row">
            <div class="col4 logo">
                <picture>
                    <source srcset="<?= base_url('assets/images/footer-logo.svg') ?>">
                    <source srcset="<?= base_url('assets/images/footer-logo.png') ?>">
                    <img src="<?= base_url('assets/images/footer-logo.png') ?>" width="257" height="100" alt="logo" loading="lazy">
                </picture>
                <p>รางวัลอุตสาหกรรมท่องเที่ยวไทย
                    เป็นรางวัลที่รับรองคุณภาพสินค้าและบริการทางการท่องเที่ยว ด้วยมาตรฐานการท่องเที่ยวอย่างยั่งยืน
                    รับผิดชอบต่อสังคม และสิ่งแวดล้อม (Responsible Tourism)
                    เพื่อผลักดันให้ผู้ประกอบการยกระดับสินค้าให้มีคุณภาพ และบริการที่ดี
                    เพื่อยกระดับและพัฒนาการท่องเที่ยว ที่ได้มาตรฐาน “การท่องเที่ยวสีขาว” ที่มีทั้งความสะดวก สะอาด ปลอดภัย
                    เป็นธรรม
                    และเป็นมิตรกับสิ่งแวดล้อม เพื่อสร้างคุณค่าและมูลค่าของสินค้าทางการท่องเที่ยวไทยสู่ระดับสากล</p>
            </div>
            <div class="col8 footermenu">

                <div class="footermenu_col">
                    <p class="footermenutitle" data-tab="1">ข้อมูลการประกวดรางวัล</p>
                    <ul data-tab="1">
                        <li><a href="<?= base_url('awards-winner') ?>" title="ประเภทรางวัล TTA 14TH">ประเภทรางวัล TTA 14<span class="upper-txt">th</span></a></li>
                        <li><a href="<?= base_url('awards-infomation') ?>?p=Judge" title="เกณฑ์การให้คะแนนตัดสิน">เกณฑ์การให้คะแนนตัดสิน</a></li>
                        <li><a href="<?= base_url('awards-infomation') ?>?p=Benefits" title="สิทธิประโยชน์สำหรับผู้ที่ได้รับรางวัล">สิทธิประโยชน์สำหรับผู้ที่ได้รับรางวัล</a></li>
                    </ul>
                </div>

                <div class="footermenu_col">
                    <p class="footermenutitle" data-tab="2">คู่มือการสมัคร</p>
                    <ul data-tab="2">
                        <li><a href="javascript:void(0);" title="หลักเกณฑ์การสมัครเข้าร่วมประกวดรางวัล">หลักเกณฑ์การสมัครเข้าร่วมประกวดรางวัล</a></li>
                        <li><a href="javascript:void(0);" title="คู่มือการลงทะเบียนประกวดรางวัล">คู่มือการลงทะเบียนประกวดรางวัล</a></li>
                        <li><a href="javascript:void(0);" title="กำหนดการรับสมัคร">กำหนดการรับสมัคร</a></li>
                    </ul>
                </div>

                <div class="footermenu_col">
                    <p class="footermenutitle" data-tab="3">ข่าวประชาสัมพันธ์</p>
                    <ul data-tab="3">
                        <li><a href="<?= base_url('new') ?>" title="บทความข่าวสารที่เกี่ยวข้องกับโครงการฯ">บทความข่าวสารที่เกี่ยวข้องกับโครงการฯ</a></li>
                        <!-- <li><a href="javascript:void(0);" title="ภาพถ่าย">ภาพถ่าย</a></li>
                        <li><a href="javascript:void(0);" title="วิดีโอ">วิดีโอ</a></li>
                        <li><a href="javascript:void(0);" title="E-Book">E-Book</a></li> -->
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
                    Copyright © 2022
                    <ul>
                        <li><a href="<?= base_url('privacy-policy') ?>" title="Privacy Policy">Privacy Policy</a></li>
                        <li><a href="<?= base_url('about-us') ?>" title="About Us">About Us</a></li>
                        <li><a href=<?= base_url('contact-us') ?>" title="Contact Us">Contact Us</a></li>
                    </ul>
                </div>
            </div>

            <div class="col6">
                Thailand Tourism Awards 2022.
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