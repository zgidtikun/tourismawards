<style>
    .btn {
        --bs-btn-padding-x: 0.75rem;
        --bs-btn-padding-y: 0.375rem;
        --bs-btn-font-family: ;
        --bs-btn-font-size: 18px;
        --bs-btn-font-weight: 400;
        --bs-btn-line-height: 1.5;
        --bs-btn-color: #212529;
        --bs-btn-bg: transparent;
        --bs-btn-border-width: 1px;
        --bs-btn-border-color: transparent;
        --bs-btn-border-radius: 0.625rem;
        --bs-btn-hover-border-color: transparent;
        --bs-btn-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15), 0 1px 1px rgba(0, 0, 0, 0.075);
        --bs-btn-disabled-opacity: 0.65;
        --bs-btn-focus-box-shadow: 0 0 0 0.25rem rgba(var(--bs-btn-focus-shadow-rgb), .5);
        display: inline-block;
        padding: var(--bs-btn-padding-y) var(--bs-btn-padding-x);
        font-family: var(--bs-btn-font-family);
        font-size: var(--bs-btn-font-size);
        font-weight: var(--bs-btn-font-weight);
        line-height: var(--bs-btn-line-height);
        color: var(--bs-btn-color);
        text-align: center;
        text-decoration: none;
        vertical-align: middle;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
        border: var(--bs-btn-border-width) solid var(--bs-btn-border-color);
        border-radius: var(--bs-btn-border-radius);
        background-color: var(--bs-btn-bg);
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .btn-main {
        --bs-btn-color: #fff;
        --bs-btn-bg: #0C2C55;
        --bs-btn-border-color: #0C2C55;
        --bs-btn-hover-color: #fff;
        --bs-btn-hover-bg: #0C2C55;
        --bs-btn-hover-border-color: #0C2C55;
        --bs-btn-focus-shadow-rgb: 60, 153, 110;
        --bs-btn-active-color: #fff;
        --bs-btn-active-bg: #0C2C55;
        --bs-btn-active-border-color: #0C2C55;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        --bs-btn-disabled-color: #fff;
        --bs-btn-disabled-bg: #0C2C55;
        --bs-btn-disabled-border-color: #0C2C55;
    }
</style>
<div class="banner-box">

    <div class="txt-banner" id="pointer-0">
        <h2>ข้อมูลการประกวดรางวัล</h2>
    </div>

</div>

<div class="container tourismaward">
    <div class="container_box">
        <div class="row" id="pointer-1">
            <div class="col12">
                <div class="main-title">
                    <div class="catagory-txt">
                        <picture>
                            <source srcset="<?=base_url('assets/images/award_catagories.svg')?>">
                            <source srcset="<?=base_url('assets/images/award_catagories.png')?>">
                            <img src="<?=base_url('assets/images/award_catagories.png')?>" width="277" height="50">
                        </picture>
                    </div>

                    <div class="main-title-txt">
                        <h2>ประเภทรางวัลอุตสาหกรรมท่องเที่ยวไทย ครั้งที่ 14 ประจำปี 2566</h2>
                    </div>
                </div>

                <div class="award-list">
                    <ul>
                        <li>
                            <div class="award-list-img">
                                <div class="award-list-imgscale">
                                    <img src="<?= base_url('assets/images/award_01.jpg') ?>" style="max-width: none !important;">
                                </div>
                            </div>
                            <div class="award-list-name">
                                ประเภทแหล่งท่องเที่ยว<br>
                                (Attraction)
                            </div>
                            <div class="award-list-section">
                                <ol>
                                    <li>สาขาแหล่งท่องเที่ยวเพื่อการผจญภัย (Outdoor & Adventure Activities)
                                    </li>
                                    <li>สาขาแหล่งท่องเที่ยวเพื่อการเรียนรู้ (Learning & Doing) </li>
                                    <li>สาขาแหล่งท่องเที่ยวธรรมชาติ (Nature & Park) </li>
                                    <li>สาขาแหล่งท่องเที่ยวนันทนาการและความบันเทิง (Recreation &
                                        Entertainment ) </li>
                                    <li>สาขาแหล่งท่องเที่ยวประวัติศาสตร์และวัฒนธรรม (Historical & Culture)
                                    </li>
                                    <li>สาขาแหล่งท่องเที่ยวชุมชน (Local & Community)</li>
                                </ol>
                            </div>
                        </li>

                        <li>
                            <div class="award-list-img">
                                <div class="award-list-imgscale">
                                    <img src="<?= base_url('assets/images/award_02.jpg') ?>" style="max-width: none !important;">
                                </div>
                            </div>
                            <div class="award-list-name">
                                ประเภทที่พักนักท่องเที่ยว<br>
                                (Accommodation)
                            </div>
                            <div class="award-list-section">
                                <ol>
                                    <li>สาขาลักซ์ชูรี โฮเทล (Luxury Hotel)</li>
                                    <li>สาขาโลเคชั่น โฮเทล (Location Hotel) </li>
                                    <li>สาขารีสอร์ต (Resort) </li>
                                    <li>สาขาดีไซน์ โฮเทล (Design Hotel) </li>
                                </ol>
                            </div>
                        </li>

                        <li>
                            <div class="award-list-img">
                                <div class="award-list-imgscale">
                                    <img src="<?= base_url('assets/images/award_03.jpg') ?>" style="max-width: none !important;">
                                </div>
                            </div>
                            <div class="award-list-name">
                                ประเภทการท่องเที่ยวเชิงสุขภาพ<br>
                                (Health and Wellness Tourism)
                            </div>
                            <div class="award-list-section">
                                <ol>
                                    <li>สาขาสปา (Spa) </li>
                                    <li>สาขาเวลเนส รีทรีต (Wellness Retreat) </li>
                                    <li>สาขานวดไทยเพื่อสุขภาพ (Nuad Thai for Health) </li>
                                    <li>สาขา เวลเนส แอนด์ สปา รีทรีต (Wellness & Spa Retreat) </li>
                                </ol>
                            </div>
                        </li>

                        <li>
                            <div class="award-list-img">
                                <div class="award-list-imgscale">
                                    <img src="<?= base_url('assets/images/award_04.jpg') ?>" style="max-width: none !important;">
                                </div>
                            </div>
                            <div class="award-list-name">
                                ประเภทรายการนำเที่ยว<br>
                                (Tour Program)
                            </div>

                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row" id="pointer-2">
            <div class="col12">
                <div class="main-title">
                    <div class="catagory-txt">
                        <picture>
                            <source srcset="<?=base_url('assets/images/QualificationsofApplicant.svg')?>">
                            <source srcset="<?=base_url('assets/images/QualificationsofApplicant.png')?>">
                            <img src="<?=base_url('assets/images/QualificationsofApplicant.png')?>" width="277" height="50">
                        </picture>
                    </div>

                    <div class="main-title-txt">
                        <h2>คุณสมบัติผู้สมัคร
                        </h2>
                    </div>
                </div>

                <div class="award-list txt-center">
                    <button type="button" class="btn btn-main">
                        <i class="bi bi-cloud-download"></i> Download
                    </button>
                </div>
            </div>
        </div>

        <div class="row" id="pointer-3">
            <div class="col12">
                <div class="main-title">
                    <div class="catagory-txt">
                        <picture>
                            <source srcset="<?=base_url('assets/images/JudgingCriteria.svg')?>">
                            <source srcset="<?=base_url('assets/images/JudgingCriteria.png')?>">
                            <img src="<?=base_url('assets/images/JudgingCriteria.png')?>" width="277" height="50">
                        </picture>
                    </div>

                    <div class="main-title-txt">
                        <h2>เกณฑ์การให้คะแนนตัดสิน</h2>
                    </div>
                </div>

                <div class="award-list txt-center">
                    <button type="button" class="btn btn-main">
                        <i class="bi bi-cloud-download"></i> Download
                    </button>
                </div>
            </div>
        </div>

        <div class="row" id="pointer-4">
            <div class="col12">
                <div class="main-title">
                    <div class="catagory-txt">
                        <picture>
                            <source srcset="<?=base_url('assets/images/Benefits.svg')?>">
                            <source srcset="<?=base_url('assets/images/Benefits.png')?>">
                            <img src="<?=base_url('assets/images/Benefits.png')?>" width="277" height="50">
                        </picture>
                    </div>

                    <div class="main-title-txt">
                        <h2>สิทธิประโยชน์สำหรับผู้ได้รับรางวัลอุตสาหกรรมท่องเที่ยวไทย
                            ครั้งที่ 14 ประจำปี 2566</h2>
                    </div>
                </div>

                <div class="award-list txt-center">
                    <button type="button" class="btn btn-main">
                        <i class="bi bi-cloud-download"></i> Download
                    </button>
                </div>
            </div>
        </div>

        <div class="row" id="pointer-5">
            <div class="col12">
                <div class="main-title">
                    <div class="catagory-txt">
                        <picture>
                            <source srcset="<?=base_url('assets/images/HandbookforEntrants.svg')?>">
                            <source srcset="<?=base_url('assets/images/HandbookforEntrants.png')?>">
                            <img src="<?=base_url('assets/images/HandbookforEntrants.png')?>" width="277" height="50">
                        </picture>
                    </div>

                    <div class="main-title-txt">
                        <h2>คู่มือการสมัคร</h2>
                    </div>
                </div>

                <div class="award-list txt-center">
                    <button type="button" class="btn btn-main">
                        <i class="bi bi-cloud-download"></i> Download
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(()=>{
        try {
            const sPageURL = window.location.search.substring(1);
            const sURLVariables = sPageURL.split('&');
            let pv;

            $.each(sURLVariables,(key, value)=>{
                const sParameterName = value.split('=');
                if(sParameterName[0] == 'p'){
                    pv = sParameterName[1];
                    return;
                }
            });
            
            switch(pv.toLowerCase()){
                case 'attraction':
                case 'accommodation':
                case 'healthandwellness':
                case 'tourprogram':
                    $('#pointer-1')[0].scrollIntoView();
                    break;
                case 'judge':
                    $('#pointer-3')[0].scrollIntoView();
                    break;
                case 'benefits':
                    $('#pointer-4')[0].scrollIntoView();
                    break;
                default: 
                    $('#pointer-0')[0].scrollIntoView();
                    break;
            }
        } catch(error){}
    });
</script>