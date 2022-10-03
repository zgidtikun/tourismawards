<div class="container">
    <div class="bs-row mt-5 justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-11 col-xl-11">
            <div class="bs-row">
                <?=view('frontend/entrepreneur/_navigator')?>
            </div>
            <div class="bs-row mt-4">
                <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6" id="">
                    <h1 class="page-title m-0 form-legend">
                        กรอกแบบฟอร์มใบสมัคร                      
                    </h1>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 form-btn-action d-flex justify-content-end" id="appFormBtn">  
                    <button class="btn btn-main btn-site mr-2"
                    onclick="">
                        บันทึก
                    </button>
                    <button class="btn btn-outline-gold btn-site" disabled
                    onclick="">
                        ส่งใบสมัคร
                    </button>
                </div>
            </div>
            <div class="bs-row mt-4">
                <div class="card">
                    <div class="card-header">
                        <ul class="card-header-tabs nav nav-tabs justify-content-center">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">
                                    <span>1. ประเภทการสมัคร</span>
                                    <i class="bi bi-check-circle-fill text-success hide"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span>2. ข้อมูลผลงาน</span>                                
                                    <i class="bi bi-check-circle-fill text-success hide"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span>3. ข้อมูลหน่วยงาน/บริษัท</span>
                                    <i class="bi bi-check-circle-fill text-success hide"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span>4. ข้อมูลผู้ประสานงาน</span>
                                    <i class="bi bi-check-circle-fill text-success hide"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" title="คุณสมบัติเบื้องต้น/เอกสารประกอบการสมัคร">
                                    <span>5. คุณสมบัติเบื้องต้น/เอกสาร...</span>
                                    <i class="bi bi-check-circle-fill text-success hide"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <form class="bs-row">
                            <div class="col-12 mt-2">                            
                                <span class="form-title">
                                    <i class="bi bi-file-text-fill text-info mr-2"></i>
                                    ประเภทที่ต้องการสมัครประกวดรางวัลอุตสาหกรรมท่องเที่ยวไทย
                                </span>
                            </div>       
                            <div class="col-12 mt-4" id="group-type">
                                <legend class="fs-22 mb-2">
                                    กรุณาเลือกประเภทที่สอดคล้องกับการดำเนินงานและกลุ่มลูกค้าของท่านมากที่สุด
                                    <span style="color: #F64E60;">*</span>
                                </legend>
                            </div>
                            <div class="col-12 mt-4" >
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $app = new \Config\App(); ?>
<link rel="preload" as="script" href="<?= base_url('assets/js/frontend/apc.js')?>?v=<?=$app->script_v?>"> 
<script src="<?=base_url('assets/js/frontend/apc.js')?>?v=<?=$app->script_v?>"></script>
<script>
    $(document).ready(function(){
        register.init(<?=session()->get('id')?>);
    });

    $.Thailand({
        $district: $('#step2-subDistrict'),
        $amphoe: $('#step2-district'),
        $province: $('#step2-province'),
        $zipcode: $('#step2-zipcode'),
    });

    $.Thailand({
        $district: $('#step3-subDistrict'),
        $amphoe: $('#step3-district'),
        $province: $('#step3-province'),
        $zipcode: $('#step3-zipcode'),
    });
</script>

<script type="text/javascript" async>
    jQuery(document).ready(function($) {

        var screen_w = $(window).width();

        // if(screen_w < 768){
        //     console.log('moblie')
        //     // appFormTitle
        //     // appFormBtn
        //     if(!$('#appFormTitle').hasClass('text-center'));
        //         $('#appFormTitle').addClass('text-center');
        // } else {
        //     console.log('PC')
        //     if($('#appFormTitle').hasClass('text-center'));
        //         $('#appFormTitle').removeClass('text-center');

        // }
    });
</script>