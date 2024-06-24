<?= $this->extend('layout') ?>
<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>

<?= $this->section('css') ?>
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
<?= $this->endSection() ?>

<?= $this->section('banner') ?>
<div id="includedbanner">
    <?= $this->include('_banner') ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container titlebox">
    <div class="container_box">
        <div class="row">
            <div class="col12 reveal">
                <p class="txt-center">
                    <img src="<?= base_url('assets/images/logo.png') ?>?v=2" width="372" height="144" class="contentlogo" alt="..." loading="lazy">
                </p>
                <h1 class="tat_reg_type txt-yellow txt-center" style="position:relative;">The 14<span style="position:absolute;top: 0px;font-size:12px;line-height:1;">th</span> &nbsp;Thailand Tourism Awards 2023</h1>
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
                <a href="<?=DOWNLOAD_FILE_URL.('download/Factsheet-ประเภทแหล่งท่องเที่ยว.pdf')?>" class="btn-yellow" target="_blank">
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
                <a href="<?=DOWNLOAD_FILE_URL.('download/Factsheet-ประเภทที่พักนักท่องเที่ยว.pdf')?>" class="btn-yellow" target="_blank">
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
                <a href="<?=DOWNLOAD_FILE_URL.('download/Factsheet-ประเภทการท่องเที่ยวเชิงสุขภาพ.pdf')?>" class="btn-yellow" target="_blank">
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
                <a href="<?=DOWNLOAD_FILE_URL.('download/Factsheet-ประเภทรายการนำที่ยว.pdf')?>" class="btn-yellow" target="_blank">
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
                <a href="<?=DOWNLOAD_FILE_URL.('download/Factsheet-ประเภทการท่องเที่ยวคาร์บอนต่ำ.pdf')?>" class="btn-yellow" target="_blank">
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
                    <div class="claim_title" data-tab="3">ยกระดับพัฒนาองค์กร Upskill-Re skill</div>
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
            <a href="<?= DOWNLOAD_FILE_URL.('download/timeline.jpg') ?>" target="_blank" title="กำหนดการโครงการฯ">กำหนดการโครงการฯ 
                <picture>
                    <source srcset="<?= base_url('assets/images/arrow_next.svg') ?>">
                    <img src="<?= base_url('assets/images/arrow_next.png') ?>" width="24" height="24" alt="...">
                </picture>
            </a>
        </div>
        <div class="col6 btn-ruledblue reveal">
            <a href="<?= base_url('login') ?>" title="เข้าสู่ระบบ">เข้าสู่ระบบ 
                <picture>
                    <source srcset="<?= base_url('assets/images/arrow_next.svg') ?>">
                    <img src="<?= base_url('assets/images/arrow_next.png') ?>" width="24" height="24" alt="...">
                </picture>
            </a>
        </div>
    </div>
</div>

<div class="container reveal" style="background-image: url(<?=base_url('assets/images/banner/awards_bg.jpg')?>);background-position: bottom center;background-repeat: no-repeat;background-size: cover;">
    <div class="container_box">

        <div class="row">
            <div class="col12">
                <div class="winner-title">
                    WINNER
                    <div class="winner-title-large">2023</div>
                </div>
                <div class="award-section goldsilverawards">
                    <div class="award-section-col">
                        <a href="<?=base_url('awards-winner/hall-of-fame')?>"> Hall of Fame</a>
                    </div>
                    <div class="award-section-col">
                        <a href="<?=base_url('awards-winner/gold-awards')?>">
                            <span class="txt-small">Thailand Tourism</span><br>Gold Awards
                        </a>
                    </div>
                    <div class="award-section-col">
                        <a href="<?=base_url('awards-winner/silver-awards')?>">
                            <span class="txt-small">Thailand Tourism </span><br>Silver Awards
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="container reveal" style="background-image: url('<?= base_url('assets/images/winneraward_bg.jpg') ?>');background-position:center;background-size:cover;display:none;">
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
                    <b>ติดต่อสอบถามข้อมูลโครงการ<br><a href="tel:022505500" class="txt-green">โทร. 0 2250 5500</a></b>
                </p>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const headerHeight = document.querySelector('#header-inner').offsetHeight;
        document.querySelector('#includedbanner').style.display = 'block';
        document.querySelector('#includedbanner').style.marginTop = `${headerHeight}px`;

        window.addEventListener('load', () => {
            const reveals = document.querySelectorAll(".reveal");
            const webHeight = window.innerHeight;
            const webelementTop = reveals[0].getBoundingClientRect().top; 

            for(let i = 0; i < 4; i++){
                if (webelementTop > webHeight / 3) reveals[0].classList.add('active');
                else reveals[0].classList.add('active');
            }
        });

        window.addEventListener("scroll", reveal);

        const screen_w = window.offsetWidth;
        const screen_h = window.offsetHeight;

        let branchTitle, branchTitleHeight, claimTitle, claimTitleHeight;
        let branchTitleTab = claimTitleTab = [] ;

        if(screen_w > 1024){
            document.querySelector(".comment_slide").style.display = 'block';

            $(".comment_slide").slick({
                dots: true,
                infinite: false,
                arrows: false,
                slidesToShow: 3,
                slidesToScroll: 3
            });

            setHeight('.branch_title');
            setHeight('.claim_title');
        }
        else if(screen_w >= 768){
            document.querySelector(".comment_slide").style.display = 'block';

            $(".comment_slide").slick({
                dots: true,
                infinite: false,
                arrows: false,
                slidesToShow: 2,
                slidesToScroll: 2
            });

            setHeight('.branch_title');
        }
        else if(screen_w < 768){
            document.querySelector(".comment_slide").style.display = 'block';

            $(".comment_slide").slick({
                dots: true,
                infinite: false,
                arrows: false,
                slidesToShow: 1,
                slidesToScroll: 1
            });
        }
    });
    
    const toAwardsWinner = param => {
        const url = `${window.location.origin}/awards-winner/${param}`;
        window.open(url,'_blank');
    }
    
    const reveal = () => {
        const windowHeight = window.innerHeight;
        const elementVisible = 10;

        document.querySelectorAll(".reveal").forEach( e => {
            const elementTop = e.getBoundingClientRect().top;

            if(elementTop < (windowHeight - elementVisible)) e.classList.add('active');
            else e.classList.remove('active');
        });
    }

    const setHeight = selector => {
        const length = document.querySelectorAll(selector).length;
        const heights = [];

        for(let i = 1; i <= length; i++) {
            const height = document.querySelector(`${selector}[data-tab="${i}"]`).offsetHeight;
            heights.push(height);
        };

        const maxHeight = heights.reduce((a, b) => {
            return Math.max(a, b);
        });

        document.querySelectorAll(selector).style.height = maxHeight;
    }
</script>
<?= $this->endSection() ?>