<div class="container">
    <div class="bs-row justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-10 col-xl-10">
            <div class="bs-row">
                <?=view('frontend/entrepreneur/_navigator')?>
            </div>
            <div class="bs-row mt-4">
                <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6" id="">
                    <h1 class="page-title m-0 form-legend">
                        กรอกแบบฟอร์มใบสมัคร                      
                    </h1>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 form-btn-action">  
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
            <div class="bs-row mt-4 mb-5">
                <div class="card">
                    <div class="card-header">
                        <ul class="card-header-tabs bs-nav bs-nav-tabs justify-content-center">
                            <li class="bs-nav-item">
                                <a class="bs-nav-link active" href="#">
                                    <span>1. ประเภทการสมัคร</span>
                                    <i class="bi bi-check-circle-fill text-success hide"></i>
                                </a>
                            </li>
                            <li class="bs-nav-item">
                                <a class="bs-nav-link" href="#">
                                    <span>2. ข้อมูลผลงาน</span>                                
                                    <i class="bi bi-check-circle-fill text-success hide"></i>
                                </a>
                            </li>
                            <li class="bs-nav-item">
                                <a class="bs-nav-link" href="#">
                                    <span>3. ข้อมูลหน่วยงาน/บริษัท</span>
                                    <i class="bi bi-check-circle-fill text-success hide"></i>
                                </a>
                            </li>
                            <li class="bs-nav-item">
                                <a class="bs-nav-link" href="#">
                                    <span>4. ข้อมูลผู้ประสานงาน</span>
                                    <i class="bi bi-check-circle-fill text-success hide"></i>
                                </a>
                            </li>
                            <li class="bs-nav-item">
                                <a class="bs-nav-link" href="#" title="คุณสมบัติเบื้องต้น/เอกสารประกอบการสมัคร">
                                    <span>5. คุณสมบัติเบื้องต้น/เอกสารประกอบการสมัคร</span>
                                    <i class="bi bi-check-circle-fill text-success hide"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="bs-row justify-content-center">
                            <div class="col-xs-12 col-sm-12 col-md-10 col-xl-10">   

                                <div class="form bs-row" id="form-step-1">
                                    <fieldset>
                                        <div class="col-12 mt-2">                            
                                            <span class="form-title">
                                                <picture>
                                                    <source srcset="<?=base_url('assets/images/formicon-type.svg')?>">
                                                    <img src="<?=base_url('assets/images/formicon-type.png')?>" class="mr-2">
                                                </picture>
                                                ประเภทที่ต้องการสมัครประกวดรางวัลอุตสาหกรรมท่องเที่ยวไทย
                                            </span>
                                        </div>       
                                        <div class="col-12 mt-4" id="group-type">
                                            <div class="fw-semibold mb-2">
                                                กรุณาเลือกประเภทที่สอดคล้องกับการดำเนินงานและกลุ่มลูกค้าของท่านมากที่สุด<span class="ml-1" style="color: #F64E60;">*</span>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-4" id="group-type-sub">
                                            <div class="fw-semibold mb-2">
                                                สาขารางวัล
                                                <span style="color: #F64E60;">*</span>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-4">
                                            <div class="alert alert-warning">
                                                <p class="form-define">
                                                    <i class="bi bi-exclamation-circle-fill text-warning mr-2"></i>
                                                    นิยาม
                                                </p>
                                                <span class="ml-4" style="font-size: 1rem;" id="form-define"></span>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-4">
                                            <div class="fw-semibold mb-2">
                                            อธิบายจุดเด่นของผลงานที่ต้องการส่งเข้าประกวด<span class="ml-1" style="color: #F64E60;">*</span>
                                            </div>
                                            <label class="form-label">
                                                ระบุคำตอบ<span style="color: #F64E60;">*</span> 
                                                <span class="ml-1 text-muted">(จำนวนตัวอักษรคงเหลือ <span id="step1-desc-cc">1,000</span>/1,000)</span>
                                            </label>
                                            <textarea class="form-control" id="step1-desc" maxlength="1000" rows="8"></textarea>
                                        </div>
                                        <div class="bs-row mt-4">
                                            <label class="col-xs-12 col-sm-12 col-md-3 col-xl-3 col-form-label">ลิงก์เว็บไซต์ หรือ ลิงก์วิดีโอ</label>
                                            <div class="col-xs-12 col-sm-12 col-md-9 col-xl-9">
                                                <input type="text" class="form-control" id="step1-link">
                                            </div>
                                        </div>
                                        <div class="bs-row mt-4">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6">
                                                <div class="col-12">
                                                    <div class="card" style="border: 1px solid #E5E6ED;">
                                                        <div class="card-header text-center" style="border-bottom: 0;">
                                                            <span class="card-title fw-semibold">รายละเอียดผลงาน (แนบไฟล์)</span>
                                                        </div>
                                                        <div class="card-body">
                                                            ...............................
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-4 mb-4">
                                                    <div class="card" style="border: 1px solid #E5E6ED;">
                                                        <div class="card-header text-center" style="border-bottom: 0;">
                                                            <span class="card-title fw-semibold">สื่อสิ่งพิมพ์ (แนบไฟล์)</span>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="bs-row mb-2">
                                                                <div class="col-12">
                                                                    <button class="btn btn-file" id="step1-paper-btn">
                                                                        <span id="step1-paper-label">Upload Files</span>
                                                                        <input type="file" name="step1-paper" id="step1-paper"
                                                                        accept=".pdf" multiple
                                                                        onchange="onFileHandle({id: register.id},'#'+this.id,'paper')"/>
                                                                    </button>
                                                                    
                                                                    <button class="btn btn-action" id="step1-paper-remove">
                                                                        Remove All
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="bs-row" id="step1-paper-list">
                                                                <!-- <div class="col-12">
                                                                    <div class="card card-body-muted">
                                                                        <div class="bs-row">
                                                                            <div class="col-xs-12 col-sm-12 col-md-10 col-xl-10">                                                                            
                                                                                <span class="fs-file-name">text.pdf (15MB)</span>
                                                                            </div>
                                                                            <div class="col-xs-12 col-sm-12 col-md-2 col-xl-2 d-flex justify-content-end"> 
                                                                                <button type="button" class="btn btn-close">
                                                                                </button>                      
                                                                            </div>
                                                                        </div>
                                                                    </div> 
                                                                </div> -->
                                                            </div>
                                                            <div class="bs-row">
                                                                <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6">
                                                <div class="col-12">
                                                    <div class="card" style="border: 1px solid #E5E6ED;">
                                                        <div class="card-header text-center" style="background-color: rgba(0, 0, 0, 0.03);">
                                                            <span class="card-title fw-semibold">แนบรูปความระเอียดสูง (ประมาณ 5-10 รูป)</span>
                                                        </div>
                                                        <div class="card-body">
                                                            ...............................
                                                        </div>
                                                        <div class="card-body-muted" style="border-top: 1px solid #E5E6ED;">
                                                            ...............................
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    <fieldset>
                                </div>



                            </div>
                        </div>
                        <div class="mb-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="loading" id="loading-page"></div>
<?php $app = new \Config\App(); ?>
<link rel="preload" as="script" href="<?= base_url('assets/js/frontend/apc.js')?>?v=<?=$app->script_v?>"> 
<script src="<?=base_url('assets/js/frontend/apc.js')?>?v=<?=$app->script_v?>"></script>
<script src="<?=base_url('assets/js/frontend/upload.files.js')?>?v=<?=$app->script_v?>"></script>
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