<style>
    .row {
        margin-top: 20px !important;
        margin-right: -10px !important;
        margin-bottom: 10px !important;
        margin-left: -10px !important;
    }

    .main-title-g {
        font-size: 20px;
        font-weight: bold;
        color: #C79534;
        text-align: center;
        margin-bottom: 20px;
    }

    .text-gold {
        color: #C79534;
        font-weight: 500;
    }

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

    .award-list ul.mn-regis {
        justify-content: center !important;
    }

    .award-list li.mn-regis {
        width: 40% ;
    }

    @media screen and (max-width: 767px) and (orientation: portrait){
        .award-list li.mn-regis {
            padding: 20px 0;
            margin: 0;
            width: 100%;
        }
    }
</style>
<div class="banner-box">

    <div class="txt-banner" id="pointer-0">
        <h2>คู่มือการสมัคร</h2>
    </div>

</div>

<div class="container tourismaward" style="margin-bottom: 80px;">
    <div class="container_box">
        <div class="row" id="pointer-1">
            <div class="col12">
                <div class="main-title">
                    <div class="main-title-g">
                        <h2>คู่มือการลงทะเบียนประกวดรางวัล</h2>
                    </div>
                </div>

                <div class="award-list">
                    <ul class="mn-regis">
                        <li class="mn-regis">
                            <div class="award-list-name">
                                6 ขั้นตอนการลงทะเบียน
                            </div>
                            
                            <div class="award-list-section">
                                <ol>
                                    <li>
                                        เข้าเว็บไซต์ 
                                        <span class="text-gold">
                                            https://tourismawards.tourismthailand.org
                                        </span>
                                    </li>
                                    <li>คลิก <span class="text-gold">ลงทะเบียน</span> เพื่อเข้าสู่ระบบ</li>
                                    <li>เข้าสู่ระบบเพื่อ <span class="text-gold">กรอกข้อมูลผู้ประกอบการ</span></li>
                                    <li>
                                        เลือก <span class="text-gold">ประเภท</span> และ <span class="text-gold">สาขา</span> 
                                        รางวัลที่ผู้ประกอบการต้องการเข้าประกวด
                                    </li>
                                    <li>กรอกข้อมูลและแนบเอการประกอบเพื่อ<span class="text-gold">ยืนยันสถานประกอบการ</span></li>
                                    <li>ตรวจสอบข้อมูลและรอ<span class="text-gold">ยืนยันการสมัคร</span></li>
                                </ol>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="award-list txt-center">
                    <button type="button" class="btn btn-main"
                    onclick="window.open('<?=base_url('download/tycoon_manual.pdf')?>','_blank')">
                        <i class="bi bi-cloud-download"></i> Download File
                    </button>
                </div>
            </div>
        </div>

        <div class="row" id="pointer-2">
            <div class="col12">
                <div class="main-title">
                    <div class="main-title-g">
                        <h2>กำหนดการรับสมัคร</h2>
                    </div>
                </div>

                <div class="award-list txt-center">
                </div>
            </div>
        </div>

        <div class="row" id="pointer-3">
            <div class="col12">
                <div class="main-title">
                    <div class="main-title-g">
                        <h2>สมัครเข้าร่วมประกวดรางวัล</h2>
                    </div>
                </div>

                <div class="award-list txt-center">
                    <button type="button" class="btn btn-main" 
                    onclick="window.open('<?=base_url('register')?>','_self')">
                        <i class="bi bi-person-plus-fill"></i> ลงทะเบียน
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
                case 'manual':
                    $('#pointer-1')[0].scrollIntoView();
                    break;
                case 'duedate':
                    $('#pointer-2')[0].scrollIntoView();
                    break;
                case 'register':
                    $('#pointer-3')[0].scrollIntoView();
                    break;
                default: 
                    $('#pointer-0')[0].scrollIntoView();
                    break;
            }
        } catch(error){}
    });
</script>