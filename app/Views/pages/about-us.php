<?= $this->extend('layout') ?>
<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const headerHeight = document.querySelector('#header-inner').offsetHeight;
        document.querySelector('.mainsite').style.display = 'block';
        document.querySelector('.mainsite').style.marginTop = `${headerHeight}px`;
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="banner-box">
    <div>
        <div class="banner-box-scale">
            <div class="banner-box-scale-img">
                <picture>
                    <source media="(max-width: 767px) and (orientation: portrait)" srcset="<?= base_url('assets/images/banner/aboutus_4-3.jpg') ?>" />
                    <img alt="" src="<?= base_url('assets/images/banner/aboutus.jpg') ?>" srcset="<?= base_url('assets/images/banner/aboutus.jpg') ?>" />
                </picture>
            </div>
        </div>
    </div>
</div>

<div class="container aboutus">
    <div class="container_box">
        <div class="row">
            <div class="col12">
                <div class="catagory-txt">
                    <picture>
                        <source srcset="<?= base_url('assets/images/aboutus.svg') ?>" />
                        <img src="<?= base_url('assets/images/aboutus.png') ?>" />
                    </picture>
                </div>
                <div class="main-title-txt" style="margin-top: 1rem;">
                    <h2 class="txt-center" style="line-height: 1.5;">
                        โครงการประกวดรางวัลอุตสาหกรรมท่องเที่ยวไทย<br>
                        ครั้งที่ 14 ประจำปี 2566<br>
                        <span style="position:relative;">(The 14<span style="position:absolute;top: 6px;font-size:12px;">th</span> &nbsp;Thailand Tourism Awards 2023)</span>
                    </h2>
                </div>
            </div>
            <div class="col12">
                <p class="pinden"><b>
                        การท่องเที่ยวแห่งประเทศไทย (ททท.) จัดประกวดรางวัลอุตสาหกรรมท่องเที่ยวไทย ครั้งที่ 14 ประจำปี 2566 เพื่อคัดสรรผู้ประกอบการท่องเที่ยวไทยที่มีคุณภาพมาตรฐานระดับสากล ทั้งในด้านการท่องเที่ยวอย่างปลอดภัย
                        และยั่งยืน (Safe and Sustainable Tourism) รวมทั้งการรับผิดชอบต่อสังคม และสิ่งแวดล้อม (Responsible Tourism) เพื่อเป้าหมายร่วมกันในการยกระดับอุตสาหกรรมท่องเที่ยวไทยสู่การเติบโตอย่างยั่งยืน (High Value and Sustainability)
                    </b></p>
                <ol>
                    <li>
                        ประเภทแหล่งท่องเที่ยว (Attraction) แบ่งประเภทรางวัลย่อยออกเป็น 6 สาขา ประกอบด้วย

                        <ol>
                            <li>สาขาแหล่งท่องเที่ยวเพื่อการผจญภัย (Outdoor & Adventure Activities)</li>
                            <li>สาขาแหล่งท่องเที่ยวเพื่อการเรียนรู้ (Learning & Doing)</li>
                            <li>สาขาแหล่งท่องเที่ยวธรรมชาติ (Nature & Park)</li>
                            <li>สาขาแหล่งท่องเที่ยวนันทนาการและความบันเทิง (Recreation & Entertainment)</li>
                            <li>สาขาแหล่งท่องเที่ยวประวัติศาสตร์และวัฒนธรรม (Historical & Culture)</li>
                            <li>สาขาแหล่งท่องเที่ยวชุมชน (Local & Community)</li>
                        </ol>
                    </li>
                    <li>
                        ประเภทที่พักนักท่องเที่ยว (Accommodation) แบ่งประเภทรางวัลย่อยออกเป็น 4 สาขา ประกอบด้วย

                        <ol>
                            <li>สาขาลักซ์ชูรี โฮเทล (Luxury Hotel)</li>
                            <li>สาขาโลเคชัน โฮเทล (Location Hotel)</li>
                            <li>สาขารีสอร์ต (Resort)</li>
                            <li>สาขาดีไซน์ โฮเทล (Design Hotel)</li>
                        </ol>
                    </li>
                    <li>
                        ประเภทการท่องเที่ยวเชิงสุขภาพ (Health and Wellness Tourism) แบ่งประเภทรางวัลย่อยออกเป็น 4 สาขา ประกอบด้วย

                        <ol>
                            <li>สาขาสปา (Spa)</li>
                            <li>สาขาเวลเนส สปา (Wellness Spa)</li>
                            <li>สาขาเวลเนส แอนด์ สปา รีทรีต (Wellness & Spa Retreat)</li>
                            <li>สาขานวดไทย (Nuad Thai for Health)</li>
                        </ol>
                    </li>
                    <li>ประเภทรายการนำเที่ยว (Tour Programmes)</li>
                    <li>ประเภทการท่องเที่ยวคาร์บอนต่ำเพื่อความยั่งยืน (Low Carbon & Sustainability)</li>
                </ol>
                <p><b>รางวัลอุตสาหกรรมท่องเที่ยวไทย แบ่งออกเป็น 3 รางวัล ดังนี้ </b></p>
                <ol>
                    <li>รางวัลยอดเยี่ยม (Thailand Tourism Gold Award) </li>
                    <li>รางวัลดีเด่น (Thailand Tourism Silver Award) </li>
                    <li>เกียรติบัตรรางวัลอุตสาหกรรมท่องเที่ยวไทย (Thailand Tourism Certificate) </li>
                </ol>
                <p>
                    *** โดยผลงานที่ได้รับรางวัล Thailand Tourism Gold Award จำนวน 3 ครั้งติดต่อกัน โดยไม่จำเป็นต้องได้รับรางวัลประเภทเดียวกัน จะได้รับรางวัล Hall of Fame
                </p>
                <p><b>กรอบแนวคิดการตัดสินรางวัลประกอบไปด้วย 3 แนวคิดหลักคือ</b></p>
                <ol>
                    <li>การท่องเที่ยวอย่างยั่งยืน (Sustainable Tourism) ส่งเสริมรูปแบบการท่องเที่ยวที่มีความหมายและนำไปสู่ความยั่งยืน มีกระบวนการจัดการที่คำนึงถึงสังคม เศรษฐกิจ
                        และสิ่งแวดล้อม กลไกสำคัญประกอบด้วย BCG Economy Model/Responsible Tourism/Low Carbon Management</li>
                    <li>ความปลอดภัยด้านสุขอนามัย (Safety & Health Administration)</li>
                    <li>ความสนใจของกลุ่มนักท่องเที่ยว (Customers Interest)</li>
                </ol>
                <p><b>สิทธิประโยชน์จากทางโครงการฯ</b></p>
                <p class="pinden">
                    ผลงานที่ได้รับรางวัลจะได้รับตราสัญลักษณ์กินรีเพื่อเป็นเครื่องหมายรับรองคุณภาพสินค้าและบริการทางการท่องเที่ยวด้วยมาตรฐานการท่องเที่ยวอย่างรับผิดชอบต่อสังคม
                    และสิ่งแวดล้อมช่วยเพิ่มโอกาสทางการตลาดในการเสนอขายสินค้าและผลิตภัณฑ์ให้นักท่องเที่ยว และได้รับสิทธิประโยชน์ต่างๆ ดังต่อไปนี้
                </p>
                <ol>
                    <li>
                        ส่งเสริมการขายและการตลาด
                        <ol>
                            <li>
                                ได้รับเชิญเข้าร่วมงานส่งเสริมการขาย Trade Show/Road Show/Consumer Fair ของ ททท. และพันธมิตรที่ ททท. สนับสนุน ทั้งนี้ ขึ้นอยู่กับความเหมาะสมของแต่ละกลุ่มตลาด
                            </li>
                            <li>
                                ได้รับสิทธิ์ส่วนลดค่าใช้จ่าย 50% ในการเข้าร่วมงานส่งเสริมการขาย Trade Show/Road Show/Consumer Fair กับ ททท. ทั้งในประเทศและต่างประเทศ ทั้งนี้ขึ้นอยู่กับความเหมาะสมของแต่ละกลุ่มตลาด
                            </li>
                            <li>
                                ได้รับการนำเสนอข้อมูลขายผ่านสื่อการตลาดดิจิทัลของ ททท.ได้แก่ Video clip/E-Book/Digital Brochure
                            </li>
                        </ol>
                    </li>
                    <li>
                        ประชาสัมพันธ์ ผลงานที่ได้รับรางวัลจะได้รับการประชาสัมพันธ์ผ่านสื่อดังต่อไปนี้
                        <ol>
                            <li>ประชาสัมพันธ์ผ่านสื่อออฟไลน์ และออนไลน์ของ ททท. ได้แก่ เพจ Amazing Thailand และเพจ Thailand Tourism Awards/อนุสาร อสท.</li>
                            <li>ประชาสัมพันธ์ผ่านเว็บไซต์ข่าวออนไลน์ และสื่อสิ่งพิมพ์ ได้แก่ ผู้จัดการออนไลน์/ข่าวสดออนไลน์/ฐานเศรษฐกิจ/มติชนออนไลน์/เดลินิวส์/แนวหน้า </li>
                            <li>ประชาสัมพันธ์ผ่าน Blog/สื่อโซเชียลมีเดียท่องเที่ยวที่มีชื่อเสียง</li>
                        </ol>
                    </li>
                    <li>
                        ยกระดับพัฒนาองค์กร Upskill - Reskill
                        <ol>
                            <li>ได้รับสิทธิ์ร่วมกิจกรรม Seminar/Workshop อาทิเช่น Online Digital Marketing Workshop/งานสัมมนาเจ้าบ้านที่ดี 2566</li>
                        </ol>
                    </li>
                </ol>
            </div>
            <div class="col12">
                <p>
                    <b>
                        ททท.ขอเชิญชวนผู้ประกอบการอุตสาหกรรมท่องเที่ยวร่วมเป็นส่วนหนึ่งในการยกระดับคุณภาพสินค้าและบริการอุตสาหกรรมท่องเที่ยวไทยสู่การเติบโตอย่างยั่งยืน
                        ด้วยการส่งผลงานร่วมประกวดรางวัลอุตสาหกรรมท่องเที่ยวไทย (Thailand Tourism Awards) ครั้งที่ 14 ประจำปี 2566
                    </b>
                </p>
                <p>
                    <b>
                        เปิดรับสมัครผลงานเข้าประกวดตั้งแต่วันที่ 1 มีนาคม – 30 เมษายน 2566
                        ผู้ประกอบการด้านการท่องเที่ยวสามารถศึกษาข้อมูลคุณสมบัติและเกณฑ์การตัดสินเพื่อเตรียมความพร้อม
                        ก่อนสมัครได้ที่ 
                    </b>
                </p>
                <p>
                    <b>
                        www.thailandtourismawards.com
                        <br>
                        Facebook: Thailand Tourism Awards
                        <br>
                        Line Official Account โครงการฯ: <a href="http://line.me/ti/p/@tourismawards" target="_blank">@tourismawards</a>
                    </b>
                </p>
                <p>
                    <b>
                        Line Official Account แยกตามประเภทรางวัล
                        <br>
                        ประเภทแหล่งท่องเที่ยว: <a href="http://line.me/ti/p/@tourismawards1" target="_blank">@tourismawards1</a>
                        <br>
                        ประเภทที่พัก: <a href="http://line.me/ti/p/@tourismawards2" target="_blank">@tourismawards2</a>
                        <br>
                        ประเภทการท่องเที่ยวเชิงสุขภาพ: <a href="http://line.me/ti/p/@tourismawards3" target="_blank">@tourismawards3</a>
                        <br>
                        ประเภทรายการนำเที่ยว: <a href="http://line.me/ti/p/@tourismawards4" target="_blank">@tourismawards4
                        <br>
                        ประเภทการท่องเที่ยวคาร์บอนต่ำเพื่อความยั่งยืน: <a href="http://line.me/ti/p/@tourismawards5" target="_blank">@tourismawards5</a>
                    </b>
                </p>

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>