<style>
    .img-overlay {
        position: absolute;
        bottom: 0;
        background: rgb(0, 0, 0);
        background: rgba(0, 0, 0, 0.5);
        color: #f1f1f1;
        width: 100%;
        transition: .5s ease;
        color: white;
        font-size: 18px;
        padding: 10px;
        text-align: center;
        opacity: 1;
    }
    .btn-ruledblue{
        background-color: #C79534;
    }
    .claim_title {
        font-size: 1.2rem;
        color: #FFF;
        text-align: center;
        font-weight: 600;
        background-color: #1b510a;
        padding: 15px 15px;
    }    
    .claim_txt{
        text-align: left;
        margin: 20px 0;
    }
    .claim_txt ul{
        list-style-position: inside;
    }

    .claim_txt ul li{
        margin-bottom: 1rem;
    }
    @media screen and (max-width: 767px) and (orientation: portrait){
        .branchawards [class^="col"] {
            width: 100%;
            margin-bottom: 1rem;
        }
        .claimawards [class^="col"] {
            width: 100%;
            margin-bottom: 1.5rem;
        }
    }
</style>
<div class="container titlebox">
    <div class="container_box">
        <div class="row">
            <div class="col12 reveal">
                <p class="txt-center">
                    <img src="<?= base_url('assets/images/logo.png') ?>" width="372" height="144" class="contentlogo" alt="..." loading="lazy">
                </p>
                <h1 class="tat_reg_type txt-yellow txt-center">Thailand Tourism Awards</h1>
                <p class="txt-center">รางวัลอุตสาหกรรมท่องเที่ยวไทย
                    เป็นรางวัลที่รับรองคุณภาพสินค้าและบริการทางการท่องเที่ยว ด้วยมาตรฐานการท่องเที่ยวอย่างยั่งยืน
                    รับผิดชอบต่อสังคม และสิ่งแวดล้อม (Responsible Tourism)
                    เพื่อผลักดันให้ผู้ประกอบการยกระดับสินค้าให้มีคุณภาพ และบริการที่ดี
                    เพื่อยกระดับและพัฒนาการท่องเที่ยว ที่ได้มาตรฐาน “การท่องเที่ยวสีขาว” ที่มีทั้งความสะดวก สะอาด ปลอดภัย
                    เป็นธรรม
                    และเป็นมิตรกับสิ่งแวดล้อม เพื่อสร้างคุณค่าและมูลค่าของสินค้าทางการท่องเที่ยวไทยสู่ระดับสากล</p>
            </div>
        </div>
    </div>
</div>

<div class="container branchawards">
    <div class="row">
        <div class="col12 reveal">
            <div class="main-title">
                <div class="catagory-txt">
                    <picture>
                        <source srcset="<?= base_url('assets/images/award_catagories.svg') ?>">
                        <source srcset="<?= base_url('assets/images/award_catagories.png') ?>">
                        <img src="<?= base_url('assets/images/award_catagories.png') ?>" 
                        width="277" height="50" alt="..." loading="lazy">
                    </picture>
                </div>
                <div class="main-title-txt">
                    <h2>5 ประเภทรางวัลอุตสาหกรรมท่องเที่ยวไทย ครั้งที่ 14 ประจำปี 2566</h2>
                </div>
            </div>
        </div>
        <div class="col4 reveal">
            <div class="branch_img">
                <div class="branch_img_box">
                    <div class="branch_img_scale">
                        <img src="<?= base_url('assets/images/award_08.jpg') ?>" width="443" height="315" alt="..." loading="lazy">
                    </div>
                </div>
            </div>
            <div class="branch_content">
                <div class="branch_title" data-tab="1">ประเภทแหล่งท่องเที่ยว</div>
                <a href="<?=base_url('download/Factsheet-ประเภทแหล่งท่องเที่ยว.pdf')?>" class="btn-yellow" target="_blank">
                คุณสมบัติ/เกณฑ์
                </a>
            </div>
        </div>

        <div class="col4 reveal">
            <div class="branch_img">
                <div class="branch_img_box">
                    <div class="branch_img_scale">
                        <img src="<?= base_url('assets/images/award_09.jpg') ?>" width="443" height="315" alt="..." loading="lazy">
                    </div>
                </div>
            </div>
            <div class="branch_content">
                <div class="branch_title" data-tab="2">ประเภทที่พักนักท่องเที่ยว</div>
                <a href="<?=base_url('download/Factsheet-ประเภทที่พักนักท่องเที่ยว.pdf')?>" class="btn-yellow" target="_blank">
                คุณสมบัติ/เกณฑ์
                </a>
            </div>
        </div>

        <div class="col4 reveal">
            <div class="branch_img">
                <div class="branch_img_box">
                    <div class="branch_img_scale">
                        <img src="<?= base_url('assets/images/award_06.jpg') ?>" width="443" height="315" alt="..." loading="lazy">
                    </div>
                </div>
            </div>
            <div class="branch_content">
                <div class="branch_title" data-tab="3">ประเภทการท่องเที่ยวเชิงสุขภาพ</div>
                <a href="<?=base_url('download/Factsheet-ประเภทการท่องเที่ยวเชิงสุขภาพ.pdf')?>" class="btn-yellow" target="_blank">
                คุณสมบัติ/เกณฑ์
                </a>
            </div>
        </div>

        <div class="col6 reveal">
            <div class="branch_img">
                <div class="branch_img_box">
                    <div class="branch_img_scale">
                        <img src="<?= base_url('assets/images/award_04.jpg') ?>" width="443" height="315" alt="..." loading="lazy">
                    </div>
                </div>
            </div>
            <div class="branch_content">
                <div class="branch_title" data-tab="4">ประเภทรายการนำเที่ยว</div>
                <a href="<?=base_url('download/Factsheet-ประเภทรายการนำที่ยว.pdf')?>" class="btn-yellow" target="_blank">
                คุณสมบัติ/เกณฑ์
                </a>
            </div>
        </div>

        <div class="col6 reveal">
            <div class="branch_img">
                <div class="branch_img_box">
                    <div class="branch_img_scale">
                        <img src="<?= base_url('assets/images/award_05.jpg') ?>" width="443" height="315" alt="..." loading="lazy">
                    </div>
                </div>
            </div>
            <div class="branch_content">
                <div class="branch_title" data-tab="4">ประเภทการท่องเที่ยวคาร์บอนต่ำเพื่อความยั่งยืน</div>
                <a href="<?=base_url('download/Factsheet-ประเภทการท่องเที่ยวคาร์บอนต่ำ.pdf')?>" class="btn-yellow" target="_blank">
                คุณสมบัติ/เกณฑ์
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container claimawards">
    <div class="container_box">
        <div class="row">
            <div class="col12 reveal">
                <div class="main-title">
                    <div class="catagory-txt">
                        <picture>
                            <source srcset="<?= base_url('assets/images/benefits.svg') ?>">
                            <source srcset="<?= base_url('assets/images/benefits.png') ?>">
                            <img src="<?= base_url('assets/images/benefits.png') ?>" 
                            width="135" height="47" alt="..." loading="lazy">
                        </picture>
                    </div>
                    <div class="main-title-txt" style="font-size: 20px;">
                        <h2 style="margin-bottom:1rem;">สิทธิประโยชน์สำหรับผู้ได้รับรางวัลอุตสาหกรรมท่องเที่ยวไทยครั้งที่ 14 ประจำปี 2566</h2>
                        ผลงานที่ได้รับรางวัลจะได้รับตราสัญลักษณ์กินรีเพื่อเป็นเครื่องหมายรับรองคุณภาพสินค้าและบริการทางการท่องเที่ยวด้วยมาตรฐานการท่องเที่ยวอย่างรับผิดชอบต่อสังคม
                        และสิ่งแวดล้อมช่วยเพิ่มโอกาสทางการตลาดในการเสนอขายสินค้าและผลิตภัณฑ์ให้นักท่องเที่ยว และได้รับสิทธิประโยชน์ต่าง ๆ ดังต่อไปนี้
                    </div>
                </div>
            </div>
            <div class="col4 reveal">
                <div class="claim_content">
                    <div class="claim_title" data-tab="1">ส่งเสริมการขายและการตลาด</div>
                    <div class="claim_txt" data-tab="1">
                        <ul>
                            <li>
                                ได้รับเชิญเข้าร่วมงานส่งเสริมการขายของ ททท. และพันธมิตรที่ ททท. สนับสนุนน อาทิ Trade Show, Road Show, Consumer Fair  
                                <br>*ทั้งนี้ ขึ้นอยู่กับความเหมาะสมของแต่ละกลุ่มตลาด
                            </li>
                            <li>
                                ได้รับสิทธิ์ส่วนลดค่าใช้จ่าย 50% ในการเข้าร่วมงานส่งเสริมการขายกับ ททท. ทั้งในประเทศและต่างประเทศ
                                <br>*ทั้งนี้ขึ้นอยู่กับความเหมาะสมของแต่ละกลุ่มตลาด 
                            </li>
                            <li>
                                ได้รับการนำเสนอข้อมูลขายผ่านสื่อการตลาดดิจิทัลของ ททท. ได้แก่ Video clip/E-Book/Digital Brochure  
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col4 reveal">
                <div class="claim_content">
                    <div class="claim_title" data-tab="2">ประชาสัมพันธ์</div>
                    <div class="claim_txt" data-tab="2">
                        <ul>
                            <li>
                                ประชาสัมพันธ์ผ่านสื่อออฟไลน์และออนไลน์ของ ททท. ได้แก่ เพจ Amazing Thailand และเพจ Thailand Tourism Awards/อนุสาร อสท.
                            </li>
                            <li>
                                ประชาสัมพันธ์ผ่านเว็บไซต์ข่าวออนไลน์และสิ่งสิ่งพิมพ์ ได้แก่ ผู้จัดการออนไลน์/ข่าวสดออนไลน์/ ฐานเศรษฐกิจ/มติชนออนไลน์/เดลินิวส์/แนวหน้า
                            </li>
                            <li>
                                ประชาสัมพันธ์ผ่าน Blog/สื่อโซเชียลมีเดียท่องเที่ยวที่มีชื่อเสียง
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col4 reveal">
                <div class="claim_content">
                    <div class="claim_title" data-tab="3">ยกระดับพัฒนาองค์กร Upskill-Re skil</div>
                    <div class="claim_txt" data-tab="3">
                        <ul>
                            <li>
                                ได้รับสิทธิ์ร่วมกิจกรรม Seminar/Workshop เช่น Digital Marketing Workshop  งานสัมมนาเจ้าบ้านที่ดี 2566
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ruleawards">
    <div class="row">
        <div class="col6 btn-ruleyellow reveal">
            <a href="javascript:;" title="กำหนดการโครงการฯ">กำหนดการโครงการฯ 
                <picture>
                    <source srcset="<?= base_url('assets/images/arrow_next.svg') ?>">
                    <img src="<?= base_url('assets/images/arrow_next.png') ?>" width="24" height="24" alt="...">
                </picture>
            </a>
        </div>
        <div class="col6 btn-ruledblue reveal">
            <a href="<?= base_url('register') ?>" title="ลงทะเบียนเข้าสู่ระบบ">ลงทะเบียนเข้าสู่ระบบ 
                <picture>
                    <source srcset="<?= base_url('assets/images/arrow_next.svg') ?>">
                    <img src="<?= base_url('assets/images/arrow_next.png') ?>" width="24" height="24" alt="...">
                </picture>
            </a>
        </div>
    </div>
</div>

<div class="container directoraward" style="display:none;">
    <div class="row">
        <div class="col12 reveal">
            <div class="main-title">
                <div class="catagory-txt">
                    <picture>
                        <source srcset="<?= base_url('assets/images/committees.svg') ?>">
                        <source srcset="<?= base_url('assets/images/committees.png') ?>">
                        <img src="<?= base_url('assets/images/committees.png') ?>" 
                        width="276" height="50" alt="..." loading="lazy">
                    </picture>
                </div>
                <div class="main-title-txt">
                    <h2>คณะกรรมการการตัดสิน</h2>
                    <!-- <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy
                        nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p> -->
                    <a href="<?=base_url('judge')?>" class="link_yellow">คณะกรรมการทั้งหมด คลิก!</a>
                </div>
            </div>
        </div>
        <?php if(!empty($judge)){ ?>
        <div class="col5 hilight">
            <div class="judge_box">
                <div class="judge_box_col reveal">
                    <div class="judge_img">
                        <div class="judge_img_scale">
                            <img src="<?=base_url($judge[0]['profile'])?>" alt="..." loading="lazy">
                            <div class="img-overlay">
                                <?=$judge[0]['fullname']?><br>
                                <?=$judge[0]['position']?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col7">
            <div class="judge_box">
                <?php 
                    unset($judge[0]);
                    foreach($judge as $val){
                ?>
                <div class="judge_box_col reveal">
                    <div class="judge_img">
                        <div class="judge_img_scale">
                            <img src="<?=base_url($val['profile'])?>" alt="..." loading="lazy">
                            <div class="img-overlay">
                                <?=$val['fullname']?><br>
                                <?=$val['position']?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<div class="container reveal" style="background-image: url('<?= base_url('assets/images/winneraward_bg.jpg') ?>');background-position:center;background-size:cover;display:none;">
    <div class="container_box">

        <div class="row">
            <div class="col12">
                <div class="winner-title">
                    WINNER
                    <div class="winner-title-large">
                        2023
                    </div>
                </div>

                <div class="award-section">
                    <div class="award-section-col" onclick="//toAwardsWinner('attraction')">
                        <div class="award-section-img">
                            <div class="award-section-imgscale">
                                <img src="<?= base_url('assets/images/award_01.jpg') ?>" 
                                style="max-width: none !important;">
                                <div class="award-section-txt">
                                 <span> Attraction</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="award-section-col" onclick="//toAwardsWinner('accommodation')">
                        <div class="award-section-img">
                            <div class="award-section-imgscale">
                                <img src="<?= base_url('assets/images/award_02.jpg') ?>" 
                                style="max-width: none !important;">
                                <div class="award-section-txt">
                                 <span>Accommodation</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="award-section-col" onclick="//toAwardsWinner('health-and-wellness-tourism')">
                        <div class="award-section-img">
                            <div class="award-section-imgscale">
                                <img src="<?= base_url('assets/images/award_03.jpg') ?>" 
                                style="max-width: none !important;">
                                <div class="award-section-txt">
                                <span>Health and Wellness Tourism</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="award-section-col" onclick="//toAwardsWinner('tourism-program')">
                        <div class="award-section-img">
                            <div class="award-section-imgscale">
                                <img src="<?= base_url('assets/images/award_04.jpg') ?>" 
                                style="max-width: none !important;">
                                <div class="award-section-txt">
                                <span>Tour Programmes</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
<script>
    const toAwardsWinner = (param) => {
        const url = window.location.origin+'/awards-winner/'+param;
        window.open(url,'_blank');
    }
</script>
<div class="container reveal" style="background-image: url('<?= base_url('assets/images/winneraward_bg.jpg') ?>');background-position:center;background-size:cover;">
    <div class="container_box">

        <div class="row">
            <div class="col12">
                <div class="winner-title">
                    WINNER
                    <div class="winner-title-large">
                        2021
                    </div>
                </div>

                <div class="award-section justify-content-center">
                    <div class="award-section-col" 
                    onclick="window.open('<?=base_url('last-awards-winner?type=attraction')?>','_blank')">
                        <div class="award-section-img">
                            <div class="award-section-imgscale">
                                <img src="<?= base_url('assets/images/award_01.jpg') ?>" 
                                style="max-width: none !important;">
                                <div class="award-section-txt">
                                <span>Attraction</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="award-section-col"
                    onclick="window.open('<?=base_url('last-awards-winner?type=accommodation')?>','_blank')">
                        <div class="award-section-img">
                            <div class="award-section-imgscale">
                                <img src="<?= base_url('assets/images/award_02.jpg') ?>" 
                                style="max-width: none !important;">
                                <div class="award-section-txt">
                                <span>Accommodation</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="award-section-col"
                    onclick="window.open('<?=base_url('last-awards-winner?type=health-and-wellness-tourism')?>','_blank')">
                        <div class="award-section-img">
                            <div class="award-section-imgscale">
                                <img src="<?= base_url('assets/images/award_03.jpg') ?>" 
                                style="max-width: none !important;">
                                <div class="award-section-txt">
                                <span>Health and Wellness Tourism</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<div class="container qrcontact">
    <div class="container_box">
        <div class="row">
            <div class="col12 reveal">
                <div class="main-title">
                    <div class="catagory-txt">
                        <picture>
                            <source srcset="<?= base_url('assets/images/contact.svg') ?>" />
                            <source srcset="<?= base_url('assets/images/contact.png') ?>" />
                            <img src="<?= base_url('assets/images/contact.png') ?>" width="145" height="36" alt="..." loading="lazy" />
                        </picture>
                    </div>
                    <div class="main-title-txt">
                        <h2>ติดต่อโครงการฯ</h2>
                    </div>
                </div>
            </div>

            <div class="col12 reveal qrcode">
                <p>
                    <a href="https://lin.ee/KhaHCpd" target="_blank">
                        <img src="<?= base_url('assets/images/qrcode.png') ?>" width="540" height="540" alt="..." loading="lazy">
                    </a>
                </p>
            </div>

            <div class="col12 reveal txt-center">
                <p>
                    <b>Line OA: <a href="https://lin.ee/KhaHCpd" target="_blank" class="txt-green">@touirsmawards</a></b>
                </p>
                <p>
                    <b>ติดต่อสอบถามข้อมูลโครงการ<br><a href="tel:0641043958" class="txt-green">โทร. 064-104-3958</a></b>
                </p>
            </div>

        </div>
    </div>
</div>

<div class="container newsaward" style="display: none;">
    <div class="container_box">
        <div class="row">
            <div class="col12 reveal">
                <div class="main-title">
                    <div class="catagory-txt">
                        <picture>
                            <source srcset="<?= base_url('assets/images/news.svg') ?>">
                            <source srcset="<?= base_url('assets/images/news.png') ?>">
                            <img src="<?= base_url('assets/images/news.png') ?>" 
                            width="145" height="36" alt="..." loading="lazy">
                        </picture>
                    </div>
                    <div class="main-title-txt">
                        <h2>ข่าวประชาสัมพันธ์</h2>
                    </div>
                </div>
            </div>
            <?php if(!empty($news)){ ?>
            <div class="col5 reveal">
                <div class="news_box hilight">
                    <div class="news_img">
                        <div class="news_box_img">
                            <div class="news_box_img_scale">
                                <img src="<?=base_url('uploads/news/images/'.$news[0]['image_cover'])?>" alt="..." loading="lazy">
                            </div>
                        </div>
                    </div>

                    <div class="news_content">
                        <div class="news_box_title">
                            <?=$news[0]['title']?>
                        </div>
                        <div class="news_box_date">
                            <span class="date"><?=$news[0]['publish_start']?></span> <span class="by"><?=$news[0]['created_by']?></span>
                        </div>
                        <div class="news_box_content">
                            <!-- <?php //substr($news[0]['description'],0,150) ?>... -->
                            <a href="<?=base_url('new/'.$news[0]['id'])?>">
                                <span style="color: #dba643; font-size: 16px;">ดูรายละเอียด</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col7 reveal">

                <?php
                    unset($news[0]);
                    foreach($news as $new){
                ?>

                <div class="news_box">
                    <div class="news_img">
                        <div class="news_box_img">
                            <div class="news_box_img_scale">
                                <img src="<?=base_url('uploads/news/images/'.$new['image_cover'])?>" 
                                alt="..." loading="lazy">
                            </div>
                        </div>
                    </div>

                    <div class="news_content">
                        <div class="news_box_title">
                            <?=$new['title']?>
                        </div>
                        <div class="news_box_date">
                            <span class="date"><?=$new['publish_start']?></span> <span class="by"><?=$new['created_by']?></span>
                        </div>
                        <div class="news_box_content">
                            <?=substr($new['description'],0,150)?>...
                            <a href="<?=base_url('new/'.$new['id'])?>">
                                <span style="color: #dba643; font-size: 16px;">ดูรายละเอียด</span>
                            </a>
                        </div>
                    </div>
                </div>

                <?php } ?>                        

            </div>

            <?php } ?>

        </div>

    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($) {

        function reveal() {
            var reveals = document.querySelectorAll(".reveal");

            for (var i = 0; i < reveals.length; i++) {
                var windowHeight = window.innerHeight;
                var elementTop = reveals[i].getBoundingClientRect().top;
                var elementVisible = 10;
				var screen_h = $(window).height();

                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add("active");
                } else {
                    reveals[i].classList.remove("active");
                }
            }
        }

        window.addEventListener("scroll", reveal);

		$(window).load(function () {
        var reveals = document.querySelectorAll(".reveal");
        var webHeight = window.innerHeight;
        var webelementTop = reveals[0].getBoundingClientRect().top;        

        for (var i = 0; i < 4; i++) {
          if (webelementTop > webHeight / 3) {
            reveals[i].classList.add("active");
          } else {
            reveals[i].classList.remove("active");
          }
        }
      });
    });
</script>

<script type="text/javascript" async>
    jQuery(document).ready(function($) {

        var screen_w = $(window).width();
        var screen_h = $(window).height();

        if (screen_w > 1024) {
            $(".comment_slide").css("display", "block");
            $(".comment_slide").slick({
                dots: true,
                infinite: false,
                arrows: false,
                slidesToShow: 3,
                slidesToScroll: 3
            });

            //----------------------------------------------------------------------------------//
            var branchtitle = $('.branch_title').length;
            var branchtitletab = [];
            for (var i = 1; i <= branchtitle;) {
                branchtitletab[i] = $('.branch_title[data-tab="' + i + '"]').height();
                i++
            }
            var branchtitleheight = branchtitletab.reduce(function(a, b) {
                return Math.max(a, b);
            });
            $('.branch_title').css("height", branchtitleheight);
            //----------------------------------------------------------------------------------//
            // var branchtxt = $('.branch_txt').length;
            // var branchtxttab = [];
            // for (var i = 1; i <= branchtxt;) {
            //     branchtxttab[i] = $('.branch_txt[data-tab="' + i + '"]').height();
            //     i++
            // }
            // var branchtxtheight = branchtxttab.reduce(function(a, b) {
            //     return Math.max(a, b);
            // });
            // $('.branch_txt').css("height", branchtxtheight + 20);
            //----------------------------------------------------------------------------------//
            var claimtitle = $('.claim_title').length;
            var claimtitletab = [];
            for (var i = 1; i <= claimtitle;) {
                claimtitletab[i] = $('.claim_title[data-tab="' + i + '"]').height();
                i++
            }
            var claimtitleheight = claimtitletab.reduce(function(a, b) {
                return Math.max(a, b);
            });
            $('.claim_title').css("height", claimtitleheight+30);

            //----------------------------------------------------------------------------------//
            // var claimtxt = $('.claim_txt').length;
            // var claimtxttab = [];
            // for (var i = 1; i <= claimtxt;) {
            //     claimtxttab[i] = $('.claim_txt[data-tab="' + i + '"]').height();
            //     i++
            // }
            // var claimtxtheight = claimtxttab.reduce(function(a, b) {
            //     return Math.max(a, b);
            // });            
            // $('.claim_txt').css("height", `${claimtxtheight}px`);

        } else if (screen_w >= 768) {
            $(".comment_slide").css("display", "block");
            $(".comment_slide").slick({
                dots: true,
                infinite: false,
                arrows: false,
                slidesToShow: 2,
                slidesToScroll: 2
            });
            //----------------------------------------------------------------------------------//
            var branchtitle = $('.branch_title').length;
            var branchtitletab = [];
            for (var i = 1; i <= branchtitle;) {
                branchtitletab[i] = $('.branch_title[data-tab="' + i + '"]').height();
                i++
            }
            var branchtitleheight = branchtitletab.reduce(function(a, b) {
                return Math.max(a, b);
            });
            $('.branch_title').css("height", branchtitleheight);
            //----------------------------------------------------------------------------------//
        } else if (screen_w < 768) {
            $(".comment_slide").css("display", "block");
            $(".comment_slide").slick({
                dots: true,
                infinite: false,
                arrows: false,
                slidesToShow: 1,
                slidesToScroll: 1
            });
        }

    });
</script>