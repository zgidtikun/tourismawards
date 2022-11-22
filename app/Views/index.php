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
                    <h2>สาขารางวัลอุตสาหกรรมท่องเที่ยวไทย</h2>
                </div>
            </div>
        </div>
        <div class="col3 reveal">
            <div class="branch_img">
                <div class="branch_img_box">
                    <div class="branch_img_scale">
                        <img src="<?= base_url('assets/images/award_01.jpg') ?>" width="443" height="315" alt="..." loading="lazy">
                    </div>
                </div>
            </div>
            <div class="branch_content">
                <div class="branch_title" data-tab="1">ประเภทแหล่งท่องเที่ยว</div>
                <!-- <div class="branch_txt" data-tab="1">
                </div> -->
                <a href="<?=base_url('awards-winner/attraction')?>" class="btn-yellow">
                    ENTER AWARD
                </a>
            </div>
        </div>

        <div class="col3 reveal">
            <div class="branch_img">
                <div class="branch_img_box">
                    <div class="branch_img_scale">
                        <img src="<?= base_url('assets/images/award_02.jpg') ?>" width="443" height="315" alt="..." loading="lazy">
                    </div>
                </div>
            </div>
            <div class="branch_content">
                <div class="branch_title" data-tab="2">ประเภทที่พักนักท่องเที่ยว</div>
                <!-- <div class="branch_txt" data-tab="2">
                </div> -->
                <a href="<?=base_url('awards-winner/accommodation')?>" class="btn-yellow">
                    ENTER AWARD
                </a>
            </div>
        </div>

        <div class="col3 reveal">
            <div class="branch_img">
                <div class="branch_img_box">
                    <div class="branch_img_scale">
                        <img src="<?= base_url('assets/images/award_03.jpg') ?>" width="443" height="315" alt="..." loading="lazy">
                    </div>
                </div>
            </div>
            <div class="branch_content">
                <div class="branch_title" data-tab="3">ประเภทการท่องเที่ยวเชิงสุขภาพ</div>
                <!-- <div class="branch_txt" data-tab="3">
                </div> -->
                <a href="<?=base_url('awards-winner/health-and-wellness-tourism')?>" class="btn-yellow">
                    ENTER AWARD
                </a>
            </div>
        </div>
        <div class="col3 reveal">
            <div class="branch_img">
                <div class="branch_img_box">
                    <div class="branch_img_scale">
                        <img src="<?= base_url('assets/images/award_04.jpg') ?>" width="443" height="315" alt="..." loading="lazy">
                    </div>
                </div>
            </div>
            <div class="branch_content">
                <div class="branch_title" data-tab="4">ประเภทรายการนำเที่ยว</div>
                <!-- <div class="branch_txt" data-tab="4"> 
                </div> -->
                <a href="<?=base_url('awards-winner/tourism-program')?>" class="btn-yellow">
                    ENTER AWARD
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
                    <div class="main-title-txt">
                        <h2>สิทธิประโยชน์สำหรับผู้ได้รับรางวัลอุตสาหกรรมท่องเที่ยวไทย</h2>
                    </div>
                </div>
            </div>
            <div class="col3 reveal">
                <div class="claim_img">
                    <div class="claim_img_box">
                        <div class="claim_img_scale">
                            <picture>
                                <source srcset="<?= base_url('assets/images/claim_01.svg') ?>">
                                <source srcset="<?= base_url('assets/images/claim_01.png') ?>">
                                <img src="<?= base_url('assets/images/claim_01.png') ?>" 
                                width="138" height="128" alt="..." loading="lazy">
                            </picture>
                        </div>
                    </div>
                </div>
                <div class="claim_content">
                    <div class="claim_title" data-tab="1">ส่งเสริมการขาย</div>
                    <div class="claim_txt" data-tab="1">
                        ส่งเสริมการขายผ่านทางช่องทาง Online และ Offline ที่ ททท. 
                        จัดขึ้นอยู่กับความเหมาะสมของแต่ละกลุ่มตลาดและเทรนด์การท่องเที่ยวในปีที่จัดงาน
                    </div>
                </div>
            </div>

            <div class="col3 reveal">
                <div class="claim_img">
                    <div class="claim_img_box">
                        <div class="claim_img_scale">
                            <picture>
                                <source srcset="<?= base_url('assets/images/claim_02.svg') ?>">
                                <source srcset="<?= base_url('assets/images/claim_02.png') ?>">
                                <img src="<?= base_url('assets/images/claim_02.png') ?>" 
                                width="138" height="128" alt="..." loading="lazy">
                            </picture>
                        </div>
                    </div>
                </div>
                <div class="claim_content">
                    <div class="claim_title" data-tab="2">ประชาสัมพันธ์</div>
                    <div class="claim_txt" data-tab="2">
                        ประชาสัมพันธ์ผู้ได้รับรางวัลอุตสาหกรรมท่องเที่ยวไทยให้เป็นที่รู้จัก โดยผ่านสื่อต่าง ๆ 
                        ในเครือข่ายและช่องทาง ของ ททท. รวมทั้ง ททท. สำนักงานในประเทศและต่างประเทศ
                    </div>
                </div>
            </div>

            <div class="col3 reveal">
                <div class="claim_img">
                    <div class="claim_img_box">
                        <div class="claim_img_scale">
                            <picture>
                                <source srcset="<?= base_url('assets/images/claim_03.svg') ?>">
                                <source srcset="<?= base_url('assets/images/claim_03.png') ?>">
                                <img src="<?= base_url('assets/images/claim_03.png') ?>" 
                                width="138" height="128" alt="..." loading="lazy">
                            </picture>
                        </div>
                    </div>
                </div>
                <div class="claim_content">
                    <div class="claim_title" data-tab="3">สิทธิพิเศษในการแจ้งข้อมูลข่าวสาร</div>
                    <div class="claim_txt" data-tab="3">
                        ได้รับสิทธิพิเศษในการแจ้งข้อมูลข่าวสารการเปิดรับสมัครหรือเข้าร่วมงานส่งเสริมการขายต่าง ๆ 
                        ของ ททท
                    </div>
                </div>
            </div>

            <div class="col3 reveal">
                <div class="claim_img">
                    <div class="claim_img_box">
                        <div class="claim_img_scale">
                            <picture>
                                <source srcset="<?= base_url('assets/images/claim_04.svg') ?>">
                                <source srcset="<?= base_url('assets/images/claim_04.png') ?>">
                                <img src="<?= base_url('assets/images/claim_04.png') ?>" 
                                width="138" height="128" alt="..." loading="lazy">
                            </picture>
                        </div>
                    </div>
                </div>
                <div class="claim_content">
                    <div class="claim_title" data-tab="4">สิทธิ์การเข้าร่วมอบรม</div>
                    <div class="claim_txt" data-tab="4">
                        ได้รับสิทธิ์การเข้าร่วมการอบรมหรือกิจกรรมพัฒนาศักยภาพด้านการตลาดการท่องเที่ยว 
                        ที่จัดโดย ททท
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ruleawards">
    <div class="row">
        <div class="col6 btn-ruleyellow reveal">
            <a href="<?= base_url('awards-infomation') ?>?p=property" title="คุณสมบัติและวิธีการเข้าร่วมประกวด">คุณสมบัติและวิธีการเข้าร่วมประกวด 
                <picture>
                    <source srcset="<?= base_url('assets/images/arrow_next.svg') ?>">
                    <img src="<?= base_url('assets/images/arrow_next.png') ?>" width="24" height="24" alt="...">
                </picture>
            </a>
        </div>
        <div class="col6 btn-ruledblue reveal">
            <a href="<?= base_url('awards-infomation') ?>?p=Judge" title="เกณฑ์การให้คะแนนและตัดสิน">เกณฑ์การให้คะแนนและตัดสิน 
                <picture>
                    <source srcset="<?= base_url('assets/images/arrow_next.svg') ?>">
                    <img src="<?= base_url('assets/images/arrow_next.png') ?>" width="24" height="24" alt="...">
                </picture>
            </a>
        </div>
    </div>
</div>

<div class="container directoraward">
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

<style>
    .winner-title {
        font-size: 5vw;
    }

    .winner-title-large {
        font-size: 10vw;
    }

    .award-section-col {
        cursor: pointer;
    }

    .award-section-txt {
        color: #FFF;
        font-size: 20px !important;
        font-weight: 600;
        background: rgb(0, 0, 0);
        background: rgba(0, 0, 0, 0.5);
        transition: .5s ease;
        width: auto;
        border-top-right-radius: 10px;
    }
</style>
<div class="container reveal"
style="background-image: url('<?= base_url('assets/images/banner/banner1.jpg') ?>');">
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
                    <div class="award-section-col" onclick="toAwardsWinner('attraction')">
                        <div class="award-section-img">
                            <div class="award-section-imgscale">
                                <img src="<?= base_url('assets/images/award_01.jpg') ?>" 
                                style="max-width: none !important;">
                                <div class="award-section-txt">
                                    Attraction
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="award-section-col" onclick="toAwardsWinner('accommodation')">
                        <div class="award-section-img">
                            <div class="award-section-imgscale">
                                <img src="<?= base_url('assets/images/award_02.jpg') ?>" 
                                style="max-width: none !important;">
                                <div class="award-section-txt">
                                    Accommodation
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="award-section-col" onclick="toAwardsWinner('health-and-wellness-tourism')">
                        <div class="award-section-img">
                            <div class="award-section-imgscale">
                                <img src="<?= base_url('assets/images/award_03.jpg') ?>" 
                                style="max-width: none !important;">
                                <div class="award-section-txt">
                                    Health and Wellness Tourism
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="award-section-col" onclick="toAwardsWinner('tourism-program')">
                        <div class="award-section-img">
                            <div class="award-section-imgscale">
                                <img src="<?= base_url('assets/images/award_04.jpg') ?>" 
                                style="max-width: none !important;">
                                <div class="award-section-txt">
                                    Tourism Program
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
<!-- 
<div class="container winnneraward reveal">
    <img src="<?= base_url('assets/images/winner.jpg') ?>" alt="..." loading="lazy">
</div>

<div class="container commentaward">
    <div class="row">
        <div class="col12 reveal">
            <div class="main-title">
                <div class="catagory-txt">
                    <picture>
                        <source srcset="<?php //base_url('assets/images/traveller.svg') ?>">
                        <source srcset="<?php //base_url('assets/images/traveller.png') ?>">
                        <img src="<?php //base_url('assets/images/traveller.png') ?>" 
                        width="145" height="36" alt="..." loading="lazy">
                    </picture>
                </div>
                <div class="main-title-txt">
                    <h2>ความคิดนักท่องเที่ยวที่มีต่อสถานที่ที่ได้รับรางวัล</h2>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy
                        nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. nsectetuer adipiscing
                        lit, sed diam nonummy ibh euismod tincidunt ut laoreet dolore magn</p>
                </div>
            </div>
        </div>

        <div class="col12 reveal">
            <section class="comment_slide slider" style="display: none;">
                <div>
                    <div class="comment_box">
                        <div class="comment_txt">
                            I want to talk about to things that are quite important to me. There are love and one my personal
                            inadequacies. The thing is that I’m quite fond of love
                        </div>
                        <div class="comment_name">
                            <div class="comment_img">
                                <div class="trvel_img">
                                    <div class="trvel_img_scale">
                                        <img src="<?php //base_url('assets/images/traveller_01.jpg') ?>" width="200" height="200" alt="..." loading="lazy">
                                    </div>
                                </div>
                            </div>
                            <div class="trvel_name">คุณจันทรรัสม์ แก้วสมบุญ</div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="comment_box">
                        <div class="comment_txt">
                            I want to talk about to things that are quite important to me. There are love and one my personal
                            inadequacies. The thing is that I’m quite fond of love
                        </div>
                        <div class="comment_name">
                            <div class="comment_img">
                                <div class="trvel_img">
                                    <div class="trvel_img_scale">
                                        <img src="<?php //base_url('assets/images/traveller_02.jpg') ?>" width="200" height="200" alt="..." loading="lazy">
                                    </div>
                                </div>
                            </div>
                            <div class="trvel_name">คุณจันทรรัสม์ แก้วสมบุญ</div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="comment_box">
                        <div class="comment_txt">
                            I want to talk about to things that are quite important to me. There are love and one my personal
                            inadequacies. The thing is that I’m quite fond of love
                        </div>
                        <div class="comment_name">
                            <div class="comment_img">
                                <div class="trvel_img">
                                    <div class="trvel_img_scale">
                                        <img src="<?php //base_url('assets/images/traveller_03.jpg') ?>" width="200" height="200" alt="..." loading="lazy">
                                    </div>
                                </div>
                            </div>
                            <div class="trvel_name">คุณจันทรรัสม์ แก้วสมบุญ</div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="comment_box">
                        <div class="comment_txt">
                            I want to talk about to things that are quite important to me. There are love and one my personal
                            inadequacies. The thing is that I’m quite fond of love
                        </div>
                        <div class="comment_name">
                            <div class="comment_img">
                                <div class="trvel_img">
                                    <div class="trvel_img_scale">
                                        <img src="<?php //base_url('assets/images/traveller_01.jpg') ?>" width="200" height="200" alt="..." loading="lazy">
                                    </div>
                                </div>
                            </div>
                            <div class="trvel_name">คุณจันทรรัสม์ แก้วสมบุญ</div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="comment_box">
                        <div class="comment_txt">
                            I want to talk about to things that are quite important to me. There are love and one my personal
                            inadequacies. The thing is that I’m quite fond of love
                        </div>
                        <div class="comment_name">
                            <div class="comment_img">
                                <div class="trvel_img">
                                    <div class="trvel_img_scale">
                                        <img src="<?php //base_url('assets/images/traveller_02.jpg') ?>" width="200" height="200" alt="..." loading="lazy">
                                    </div>
                                </div>
                            </div>
                            <div class="trvel_name">คุณจันทรรัสม์ แก้วสมบุญ</div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="comment_box">
                        <div class="comment_txt">
                            I want to talk about to things that are quite important to me. There are love and one my personal
                            inadequacies. The thing is that I’m quite fond of love
                        </div>
                        <div class="comment_name">
                            <div class="comment_img">
                                <div class="trvel_img">
                                    <div class="trvel_img_scale">
                                        <img src="<?php //base_url('assets/images/traveller_03.jpg') ?>" width="200" height="200" alt="..." loading="lazy">
                                    </div>
                                </div>
                            </div>
                            <div class="trvel_name">คุณจันทรรัสม์ แก้วสมบุญ</div>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>

</div> -->

<div class="container newsaward">
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

        // console.log(webHeight);
        // console.log(webelementTop);

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
            $('.claim_title').css("height", claimtitleheight);

            //----------------------------------------------------------------------------------//
            var claimtxt = $('.claim_txt').length;
            var claimtxttab = [];
            for (var i = 1; i <= claimtxt;) {
                claimtxttab[i] = $('.claim_txt[data-tab="' + i + '"]').height();
                i++
            }
            var claimtxtheight = claimtxttab.reduce(function(a, b) {
                return Math.max(a, b);
            });
            $('.claim_txt').css("height", claimtxtheight);

        } else if (screen_w >= 768) {
            $(".comment_slide").css("display", "block");
            $(".comment_slide").slick({
                dots: true,
                infinite: false,
                arrows: false,
                slidesToShow: 2,
                slidesToScroll: 2
            });
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