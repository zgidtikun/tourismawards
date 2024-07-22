<style>
    .btn-action.gold {
        --bs-btn-color: #fff;
        --bs-btn-bg: #C79534;
        --bs-btn-border-color: #C79534;
        --bs-btn-hover-color: #fff;
        --bs-btn-hover-bg: #C79534;
        --bs-btn-hover-border-color: #C79534;
        --bs-btn-focus-shadow-rgb: 60, 153, 110;
        --bs-btn-active-color: #fff;
        --bs-btn-active-bg: #C79534;
        --bs-btn-active-border-color: #C79534;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        --bs-btn-disabled-color: #C79534;
        --bs-btn-disabled-bg: #ededed;
        --bs-btn-disabled-border-color: #ededed;
    }

    #step5-openYear-btn {
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }

    .regis-form-data-col1 input.form-control.is-invalid~div.invalid-feedback,
    .regis-form-data-col2 input.form-control.is-invalid~div.invalid-feedback {
        display: block !important;
    }

    a.btn-save.disabled {
        color: #152a54;
        background-color: #ededed;
        border-bottom: 3px solid #ededed;
        pointer-events: none;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col12">
            <div class="formmainbox">
                <div class="title">
                    <div class="title-txt">
                        สถานะการสมัครประกวดรางวัลอุตสาหกรรมท่องเที่ยวไทย ครั้งที่ 14 ประจำปี 2566
                    </div>
                </div>

                <div class="formstep">
                    <div class="formstep-col register active">
                        <a href="<?= base_url('awards/application') ?>">
                            <div class="formstep-title">1. กรอกแบบฟอร์มใบสมัคร</div>
                        </a>
                        <div class="formstep-status hide" id="formstep-sts" data-tab="1">
                            <?= $duedate->expired_str ?>
                        </div>
                        <div class="formstep-icon"><span><i class="bi bi-pencil-fill"></i></span></div>
                    </div>
                    <div class="formstep-col prescreen">
                        <a href="<?= base_url('awards/pre-screen') ?>" id="link-pre-screen" class="disabled">
                            <div class="formstep-title">2. กรอกแบบประเมินขั้นต้น (Pre-Screen)</div>
                        </a>
                        <div class="formstep-status" data-tab="2" id="formstep-pre"></div>
                        <div class="formstep-icon"><span><i class="bi bi-three-dots"></i></span></div>
                    </div>
                    <div class="formstep-col estimate">
                        <a href="<?= base_url('awards/result') ?>" id="link-pre-result" class="disabled">
                            <div class="formstep-title">3. ผลการประเมิน</div>
                        </a>
                        <div class="formstep-status" data-tab="3" id="formstep-result"></div>
                        <div class="formstep-icon"><span><i class="bi bi-three-dots"></i></span></div>
                    </div>
                    <script>
                        jQuery(document).ready(function() {
                            var formstepdate = $('.formstep-title').length;
                            var formsteptab = [];
                            for (var i = 1; i <= formstepdate;) {
                                formsteptab[i] = $('.formstep-title[data-tab="' + i + '"]').height();
                                i++
                            }
                            var formstepdate = formsteptab.reduce(function(a, b) {
                                return Math.max(a, b);
                            });
                            $('.formstep-title').css({
                                "height": formstepdate
                            });
                        });

                        jQuery(document).ready(function() {
                            var formstepdate = $('.formstep-status').length;
                            var formsteptab = [];
                            for (var i = 1; i <= formstepdate;) {
                                formsteptab[i] = $('.formstep-status[data-tab="' + i + '"]').height();
                                i++
                            }
                            var formstepdate = formsteptab.reduce(function(a, b) {
                                return Math.max(a, b);
                            });
                            $('.formstep-status').css({
                                "height": formstepdate
                            });

                        });
                    </script>
                </div>
            </div>

            <div class="formstatus info hide" id="formstatus-info">
                <img src="<?= base_url('/assets/images/complete-regis-form.png') ?>">
                <h3>ส่งใบสมัครเรียบร้อยแล้ว</h3>
                <p>เจ้าหน้าที่จะใช้เวลาในการตรวจสอบข้อมูลภายใน 7 วัน และจะแจ้งผลให้ท่านทราบทันทีหลังการตรวจสอบ</p>
            </div>

            <div class="formstatus pass hide" id="formstatus-pass">
                <img src="<?= base_url('/assets/images/pass-regis-form.png') ?>">
                <h3>ใบสมัครของท่านผ่านการอนุมัติ</h3>
                <p>โปรดกรอกแบบประเมินขั้นต้น (Pre-screen) ภายในระยะเวลาที่กำหนด</p>
            </div>

            <div class="formstatus uncomplete hide" id="formstatus-uncomplete">
                <img src="<?= base_url('/assets/images/uncomplete-regis-form.png') ?>">
                <h3 id="formstatus-uncomplete-title">ขอข้อมูลเพิ่มเติม</h3>
                <p id="formstatus-uncomplete-message">ข้อมูลของท่านอาจยังไม่สมบูรณ์ โปรดดูรายละเอียด เพื่อแก้ไขและส่งใบสมัครอีกครั้ง</p>
            </div>

            <div class="formstatus uncomplete hide" id="formstatus-nopass">
                <img src="<?= base_url('/assets/images/uncomplete-regis-form.png') ?>">
                <h3>ไม่ผ่านการอนุมัติ</h3>
                <p>หากมีข้อสงสัยสามารถสอบถามเพิ่มเติมได้ที่ Line OA : @tourismawards</p>
            </div>

            <div class="formstatus-comoment hide">
                <h4>ความคิดเห็นจากผู้ตรวจสอบใบสมัคร</h4>
                <p id="comoment"></p>
            </div>

            <div class="form-main-title hide">
                <div class="form-main-title-txt">
                    กรอกแบบฟอร์มใบสมัคร
                </div>
                <div class="form-main-btn">
                    <a href="javascript:register.saveDraft(register.formData.currentStep,'save')" class="btn-save" data-tab="1">บันทึก</a>
                    <a href="javascript:register.saveApp()" class="btn-regis disabled" data-tab="2" id="btnHFinish">ส่งใบสมัคร</a>
                </div>
            </div>

            <div class="formmainbox" id="main-focus">
                <div class="regis-form-step">
                    <a id="tab-s1" href="javascript:void(0);" onclick="register.setStep(1)" class="btn-form-step active">
                        1. ประเภทการสมัคร
                    </a>
                    <a id="tab-s2" href="javascript:void(0);" onclick="register.setStep(2)" class="btn-form-step">
                        2. ข้อมูลผลงานที่ส่งเข้าประกวด
                    </a>
                    <a id="tab-s3" href="javascript:void(0);" onclick="register.setStep(3)" class="btn-form-step">
                        3. ข้อมูลหน่วยงานบริษัท
                    </a>
                    <a id="tab-s4" href="javascript:void(0);" onclick="register.setStep(4)" class="btn-form-step">
                        4. ข้อมูลผู้ประสานงาน
                    </a>
                    <a id="tab-s5" href="javascript:void(0);" onclick="register.setStep(5)" class="btn-form-step">
                        5. คุณสมบัติ/เอกสาร
                    </a>
                </div>

                <div class="regis-form-data hide" id="form-step-1">
                    <div class="regis-form-data-row">
                        <div class="regis-form-data-col1">
                            <h3>
                                <picture>
                                    <source srcset="<?= base_url('assets/images/formicon-type.svg') ?>">
                                    <img src="<?= base_url('assets/images/formicon-type.png') ?>">
                                </picture> ประเภทที่ต้องการสมัครประกวดรางวัลอุตสาหกรรมท่องเที่ยวไทย
                            </h3>
                        </div>
                        <div class="regis-form-data-col1" id="group-type">
                            <h4>กรุณาเลือกประเภทการสมัคร <span class="required">*</span></h4>
                        </div>
                        <div class="regis-form-data-col1" id="group-type-sub">
                        </div>
                        <div class="regis-form-data-col1">
                            <div class="comment yellow">
                                <i class="bi bi-exclamation-lg"></i>
                                <h4>นิยาม</h4>
                                <p id="form-define"></p>
                            </div>
                        </div>
                        <div class="regis-form-data-col1">
                            <h4>กรุณาระบุ หากต้องการสมัครเพิ่มประเภท Low Carbon & Sustainability</h4>
                            <p>
                                <input type="radio" name="step1-lowcarbon" id="step1-lowcarbon-1" value="1">ต้องการ
                            </p>
                            <p>
                                <input type="radio" name="step1-lowcarbon" id="step1-lowcarbon-2" value="2">ไม่ต้องการ
                            </p>
                            <a href="<?= base_url('download/คุณสมบัติและเกณฑ์ประเภทประเภทการท่องเที่ยวคาร์บอนต่ำ.pdf') ?>" target="_blank" style="color: #2a6118;">
                                <small>คลิกดูคุณสมบัติ/เกณฑ์ประเภท Carbon & Sustainability</small>
                            </a>
                        </div>
                        <div class="regis-form-data-col1">
                            <h4>อธิบายจุดเด่นของผลงานที่ต้องการส่งเข้าประกวด <span class="required">*</span></h4>
                            ระบุคำตอบ <span class="required">*</span>
                            <span class="text-muted">(จำนวนตัวอักษรคงเหลือ <span id="step1-desc-cc">1,000</span>/1,000)</span>
                            <textarea class="form-control" id="step1-desc" rows="12"></textarea>
                            <div class="invalid-feedback">กรุณาอธิบายจุดเด่นของผลงานที่ต้องการส่งเข้าประกวด</div>
                        </div>
                        <div class="regis-form-data-col1 inpvdo">
                            <label>ลิ้งก์เว็บไซต์ หรือ ลิ้งก์วิดีโอ</label> <input type="text" class="form-control" id="step1-link">
                        </div>
                        <div class="bs-row mt-2">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6">
                                <div class="col-12">
                                    <div class="card" style="border: 1px solid #E5E6ED;">
                                        <div class="card-header text-center" style="border-bottom: 0;">
                                            <span class="fs-18 fw-semibold">รายละเอียดผลงาน (แนบไฟล์)</span>
                                        </div>
                                        <div class="card-body selecter-file">
                                            <div class="bs-row mb-2">
                                                <div class="col-12">
                                                    <button class="btn btn-file" id="step1-detail-btn">
                                                        <span id="step1-detail-label">Upload Files</span>
                                                        <input type="file" id="step1-detail" accept=".pdf" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'paper')" />
                                                    </button>
                                                    <button class="btn btn-file" id="step1-detail-remove" onclick="removeFile('#step1-detail',{id: register.id,remove: 'all'})">
                                                        Remove All
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="bs-row" id="step1-detail-list"></div>
                                            <div class="bs-row">
                                                <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                            </div>
                                        </div>
                                        <div class="card-body attach-file">
                                            <div class="bs-row" id="attach-file-step1-detail">
                                                <div class="d-grid">
                                                    <button class="btn btn-primary" type="button" onclick="downloadFile('#step1-detail')">
                                                        <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-4 mb-4">
                                    <div class="card" style="border: 1px solid #E5E6ED;">
                                        <div class="card-header text-center" style="border-bottom: 0;">
                                            <span class="fs-18 fw-semibold">สื่อสิ่งพิมพ์ (แนบไฟล์)</span>
                                        </div>
                                        <div class="card-body selecter-file">
                                            <div class="bs-row mb-2">
                                                <div class="col-12">
                                                    <button class="btn btn-file" id="step1-paper-btn">
                                                        <span id="step1-paper-label">Upload Files</span>
                                                        <input type="file" id="step1-paper" accept=".pdf" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'paper')" />
                                                    </button>
                                                    <button class="btn btn-file" id="step1-paper-remove" onclick="removeFile('#step1-paper',{id: register.id,remove: 'all'})">
                                                        Remove All
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="bs-row" id="step1-paper-list"></div>
                                            <div class="bs-row">
                                                <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                            </div>
                                        </div>
                                        <div class="card-body attach-file">
                                            <div class="bs-row" id="attach-file-step1-paper">
                                                <div class="d-grid">
                                                    <button class="btn btn-primary" type="button" onclick="downloadFile('#step1-paper')">
                                                        <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
                                <div class="col-12">
                                    <div class="card" style="border: 1px solid #E5E6ED;">
                                        <div class="card-header text-center" style="background-color: rgba(0, 0, 0, 0.03);">
                                            <span class="fs-18 fw-semibold">แนบรูปภาพความละเอียดสูง</span>
                                        </div>
                                        <div class="card-body selecter-file">
                                            <div class="bs-row">
                                                <div class="col-12">
                                                    <button class="btn btn-file" style="font-size: 16px;" id="step1-images-btn">
                                                        <span id="step1-images-label">Upload Files</span>
                                                        <input type="file" id="step1-images" accept=".jpg,.jpeg,.png" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'images')" />
                                                    </button>
                                                    <button class="btn btn-file" id="step1-images-remove" onclick="removeFile('#step1-images',{id: register.id,remove: 'all'})">
                                                        Remove All
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="bs-row">
                                                <span class="text-muted" style="font-size: 14px;">
                                                    จำกัดแค่ไฟล์ .jpg, .jpeg, .png เท่านั้น ขนาดไฟล์ไม่เกิน 10MB และอัพโหลดได้ไม่เกิน 10 รูป
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body-muted c-lef selecter-file" id="step1-images-list"></div>
                                        <div class="card-body attach-file">
                                            <div class="ablumbox" id="step1-images-ablum"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="regis-form-data-row">
                        <div class="regis-form-data-col1 continue">
                            <button class="btn btn-action" id="btn-next" onclick="register.setStep(2)">
                                ถัดไป
                            </button>
                        </div>
                    </div>
                </div>

                <div class="regis-form-data hide" id="form-step-2">
                    <div class="regis-form-data-row">
                        <div class="regis-form-data-col1">
                            <h3>
                                <picture>
                                    <source srcset="<?= base_url('assets/images/formicon-type.svg') ?>">
                                    <img src="<?= base_url('assets/images/formicon-type.png') ?>">
                                </picture> ข้อมูลผลงานที่ส่งเข้าประกวด
                            </h3>
                        </div>
                        <div class="regis-form-data-col1">
                            <h4>ชื่อแหล่งท่องเที่ยว/สถานประกอบการ/รายการนำเที่ยว (TH) <span class="required">*</span></h4>
                            <input type="text" class="form-control" id="step2-siteNameTh">
                            <span style="font-size: 14px;" class="text-muted">(หมายเหตุ: ชื่อโรงแรม ตามใบอนุญาตประกอบการธุรกิจโรงแรม) *</span>
                            <div class="invalid-feedback">กรุณากรอก ชื่อแหล่งท่องเที่ยว/สถานประกอบการ/รายการนำเที่ยว (TH)</div>
                        </div>
                        <div class="regis-form-data-col1">
                            <h4>ชื่อแหล่งท่องเที่ยว/สถานประกอบการ/รายการนำเที่ยว (EN)</h4>
                            <input type="text" class="form-control" id="step2-siteNameEng">
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>ที่ตั้ง/เลขที่ <span class="required">*</span></h4>
                            <input type="text" class="form-control" id="step2-address">
                            <div class="invalid-feedback">กรุณากรอก ที่ตั้ง/เลขที่</div>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>ถนน</h4>
                            <input type="text" class="form-control" id="step2-road">
                            <div class="invalid-feedback">กรุณากรอก ถนน</div>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>ตำบล <span class="required">*</span></h4>
                            <input type="text" class="form-control" id="step2-subDistrict">
                            <div class="invalid-feedback">กรุณากรอก ตำบล</div>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>อำเภอ <span class="required">*</span></h4>
                            <input type="text" class="form-control" id="step2-district">
                            <div class="invalid-feedback">กรุณากรอก อำเภอ</div>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>จังหวัด <span class="required">*</span></h4>
                            <input type="text" class="form-control" id="step2-province">
                            <div class="invalid-feedback">กรุณากรอก จังหวัด</div>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>รหัสไปรษณีย์ <span class="required">*</span></h4>
                            <input type="number" class="form-control" id="step2-zipcode" min="0" maxlength="5">
                            <div class="invalid-feedback" id="invalid-step2-zipcode">กรุณากรอก รหัสไปรษณีย์ ให้ถูกต้อง</div>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>Facebook</h4>
                            <input type="text" class="form-control" id="step2-fb">
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>Instagram</h4>
                            <input type="text" class="form-control" id="step2-ig">
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>Line ID</h4>
                            <input type="text" class="form-control" id="step2-lid">
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>Social Media อื่นๆ</h4>
                            <input type="text" class="form-control" id="step2-other">
                        </div>
                        <div class="regis-form-data-col1">
                            <h4>ลิ้งก์แผนที่ Google Map</h4>
                            <input type="text" class="form-control" id="step2-gm">
                        </div>
                    </div>
                    <div class="regis-form-data-row">
                        <div class="regis-form-data-col1 continue">
                            <button class="btn btn-action" id="btn-next" onclick="register.setStep(1)">
                                ย้อนกลับ
                            </button>
                            <button class="btn btn-action" id="btn-next" onclick="register.setStep(3)">
                                ถัดไป
                            </button>
                        </div>
                    </div>
                </div>

                <div class="regis-form-data hide" id="form-step-3">
                    <div class="regis-form-data-row">
                        <div class="regis-form-data-col1">
                            <h3>
                                <picture>
                                    <source srcset="<?= base_url('assets/images/formicon-type.svg') ?>">
                                    <img src="<?= base_url('assets/images/formicon-type.png') ?>">
                                </picture> ข้อมูลหน่วยงาน/บริษัทที่ส่งเข้าประกวด
                            </h3>
                        </div>
                        <div class="regis-form-data-col1">
                            <h4>ชื่อหน่วยงาน/บริษัท <span class="required">*</span></h4>
                            <input type="text" class="form-control" id="step3-companyName">
                            <div class="invalid-feedback">กรุณากรอก ชื่อหน่วยงาน/บริษัท</div>
                        </div>
                        <div class="regis-form-data-col1">
                            <h4>ที่อยู่</h4>
                            <div class="selectaddress">
                                <div class="selectaddresscol">
                                    <p><input type="radio" name="step3-setAddress" id="step3-setAddress-1" value="1"> สถานที่เดียวกับผลงานที่ส่งเข้าประกวด
                                    </p>
                                </div>
                                <div class="selectaddresscol">
                                    <p><input type="radio" name="step3-setAddress" id="step3-setAddress-2" value="2"> ระบุที่อยู่ใหม่</p>
                                </div>
                            </div>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>ที่ตั้ง/เลขที่</h4>
                            <input type="text" class="form-control" id="step3-address">
                            <div class="invalid-feedback">กรุณากรอก ที่ตั้ง/เลขที่</div>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>ถนน</h4>
                            <input type="text" class="form-control" id="step3-road">
                            <div class="invalid-feedback">กรุณากรอก ถนน</div>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>ตำบล</h4>
                            <input type="text" class="form-control" id="step3-subDistrict">
                            <div class="invalid-feedback">กรุณากรอก ตำบล</div>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>อำเภอ</h4>
                            <input type="text" class="form-control" id="step3-district">
                            <div class="invalid-feedback">กรุณากรอก อำเภอ</div>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>จังหวัด</h4>
                            <input type="text" class="form-control" id="step3-province">
                            <div class="invalid-feedback">กรุณากรอก จังหวัด</div>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>รหัสไปรษณีย์</h4>
                            <input type="number" class="form-control" id="step3-zipcode" min="0">
                            <div class="invalid-feedback">กรุณากรอก รหัสไปรษณีย์ ให้ถูกต้อง</div>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>หมายเลขโทรศัพท์</h4>
                            <input type="text" class="form-control" id="step3-telephone">
                            <div class="invalid-feedback">กรุณากรอก หมายเลขโทรศัพท์</div>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>อีเมล</h4>
                            <input type="email" class="form-control" id="step3-email">
                            <div class="invalid-feedback">กรุณากรอก อีเมล</div>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>Line ID</h4>
                            <input type="text" class="form-control" id="step3-lid">
                        </div>
                    </div>
                    <div class="regis-form-data-row">
                        <div class="regis-form-data-col1 continue">
                            <button class="btn btn-action" id="btn-next" onclick="register.setStep(2)">
                                ย้อนกลับ
                            </button>
                            <button class="btn btn-action" id="btn-next" onclick="register.setStep(4)">
                                ถัดไป
                            </button>
                        </div>
                    </div>
                </div>

                <div class="regis-form-data hide" id="form-step-4">
                    <div class="regis-form-data-row">
                        <div class="regis-form-data-col1">
                            <h3>
                                <picture>
                                    <source srcset="<?= base_url('assets/images/formicon-type.svg') ?>">
                                    <img src="<?= base_url('assets/images/formicon-type.png') ?>">
                                </picture> ข้อมูลผู้ประสานงาน
                            </h3>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>ชื่อ-นามสกุลผู้ประสานงาน <span class="required">*</span></h4>
                            <input type="text" class="form-control" id="step4-name">
                            <div class="invalid-feedback">กรุณากรอก ชื่อ-นามสกุลผู้ประสานงาน</div>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>ตำแหน่ง</h4>
                            <input type="text" class="form-control" id="step4-position">
                            <div class="invalid-feedback">กรุณากรอก ตำแหน่ง</div>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>หมายเลขโทรศัพท์ <span class="required">*</span></h4>
                            <input type="text" class="form-control" id="step4-telephone">
                            <div class="invalid-feedback">กรุณากรอก หมายเลขโทรศัพท์</div>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>อีเมล <span class="required">*</span></h4>
                            <input type="email" class="form-control" id="step4-email">
                            <div class="invalid-feedback" id="invalid-step4-email">กรุณากรอก อีเมล ให้ถูกต้อง</div>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>Line ID</h4>
                            <input type="text" class="form-control" id="step4-lid">
                        </div>
                    </div>
                    <div class="regis-form-data-row">
                        <div class="regis-form-data-col1 continue">
                            <button class="btn btn-action" id="btn-next" onclick="register.setStep(3)">
                                ย้อนกลับ
                            </button>
                            <button class="btn btn-action" id="btn-next" onclick="register.setStep(5)">
                                ถัดไป
                            </button>
                        </div>
                    </div>
                </div>

                <div class="regis-form-data" id="form-step-5">
                    <div class="regis-form-data-row">
                        <div class="regis-form-data-col1">
                            <h3>
                                <picture>
                                    <source srcset="<?= base_url('assets/images/formicon-type.svg') ?>">
                                    <img src="<?= base_url('assets/images/formicon-type.png') ?>">
                                </picture> คุณสมบัติเบื้องต้นของผลงานที่ส่งเข้าประกวด
                            </h3>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>เปิดให้บริการหรือดำเนินการตั้งแต่ พ.ศ. <span class="required">*</span></h4>
                            <div class="input-group">
                                <input type="text" class="form-control" id="step5-openYear" readonly style="pointer-events: none;">
                                <input type="hidden" id="step5-hiddenDate">
                                <button class="btn btn-outline-success" type="button" id="step5-openYear-btn"><i class="bi bi-calendar"></i></button>
                                <div class="invalid-feedback" id="error-open-year">กรุณากรอก เปิดให้บริการหรือดำเนินการตั้งแต่ พ.ศ.</div>
                            </div>
                        </div>
                        <div class="regis-form-data-col2">
                            <h4>ระยะเวลารวมทั้งสิ้น</h4>
                            <input type="text" class="form-control" id="step5-totalYear" disabled>
                        </div>
                    </div>
                    <div class="regis-form-data-row hide" id="step5-type1">
                        <div class="regis-form-data-col1">
                            <h4>แหล่งท่องเที่ยว/กิจกรรมอยู่ในความดูแล</h4>
                            <p><input type="radio" name="step5-t1-manageBy" id="step5-t1-manageBy-1" value="1"> ภาครัฐ</p>
                            <p><input type="radio" name="step5-t1-manageBy" id="step5-t1-manageBy-2" value="2"> ชุมชนท่องเที่ยว</p>
                            <p><input type="radio" name="step5-t1-manageBy" id="step5-t1-manageBy-3" value="3"> ภาคเอกชน</p>
                        </div>
                        <div class="bs-row">
                            <h4>แนบเอกสาร</h4>
                            <hr>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
                                <span class="fs-18 fw-semibold">
                                    หลักฐานการถือครองที่ดินที่กฎหมายรับรอง สัญญาเช่า หรือหนังสือยินยอมให้ใช้สถานที่
                                    <span class="required">*</span>
                                </span>
                                <div class="card" style="border: 1px solid #E5E6ED;">
                                    <div class="card-body selecter-file">
                                        <div class="bs-row mb-2">
                                            <div class="col-12">
                                                <button class="btn btn-file" id="step5-landOwner-btn">
                                                    <span id="step5-landOwner-label">Upload Files</span>
                                                    <input type="file" id="step5-landOwner" accept=".pdf" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'paper')" />
                                                </button>
                                                <button class="btn btn-file" id="step5-landOwner-remove" onclick="removeFile('#step5-landOwner',{id: register.id,remove: 'all'})">
                                                    Remove All
                                                </button>
                                            </div>
                                        </div>
                                        <div class="bs-row" id="step5-landOwner-list">
                                        </div>
                                        <div class="bs-row">
                                            <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                        </div>
                                    </div>
                                    <div class="card-body attach-file">
                                        <div class="bs-row" id="attach-file-step5-landOwner">
                                            <div class="d-grid">
                                                <button class="btn btn-primary" type="button" onclick="downloadFile('#step5-landOwner')">
                                                    <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4" id="div-step5-businessCert" style="display:none;">
                                <span class="fs-18 fw-semibold" id="step5-file1-title">
                                    ใบรับรองมาตรฐาน หรือประกาศนียบัตรจากการท่องเที่ยวแห่ง
                                    <span class="required">*</span>
                                </span>
                                <div class="card" style="border: 1px solid #E5E6ED;">
                                    <div class="card-body selecter-file">
                                        <div class="bs-row mb-2">
                                            <div class="col-12">
                                                <button class="btn btn-file" id="step5-businessCert-btn">
                                                    <span id="step5-businessCert-label">Upload Files</span>
                                                    <input type="file" id="step5-businessCert" accept=".pdf" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'paper')" />
                                                </button>
                                                <button class="btn btn-file" id="step5-businessCert-remove" onclick="removeFile('#step5-businessCert',{id: register.id,remove: 'all'})">
                                                    Remove All
                                                </button>
                                            </div>
                                        </div>
                                        <div class="bs-row" id="step5-businessCert-list">
                                        </div>
                                        <div class="bs-row">
                                            <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                        </div>
                                    </div>
                                    <div class="card-body attach-file">
                                        <div class="bs-row" id="attach-file-step5-businessCert">
                                            <div class="d-grid">
                                                <button class="btn btn-primary" type="button" onclick="downloadFile('#step5-businessCert')">
                                                    <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6">
                                <span class="fs-18 fw-semibold">
                                    ใบรับรองมาตรฐาน หรือประกาศนียบัตรจากการท่องเที่ยวแห่งประเทศไทย, SHA, กรมการท่องเที่ยว,
                                    องค์การบริหารการพัฒนาพื้นที่พิเศษเพื่อการท่องเที่ยวอย่างยั่งยืน (องค์การมหาชน) ฯลฯ (ถ้ามี)
                                </span>
                                <div class="card" style="border: 1px solid #E5E6ED;">
                                    <div class="card-body selecter-file">
                                        <div class="bs-row mb-2">
                                            <div class="col-12">
                                                <button class="btn btn-file" id="step5-otherCert-btn">
                                                    <span id="step5-otherCert-label">Upload Files</span>
                                                    <input type="file" id="step5-otherCert" accept=".pdf" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'paper')" />
                                                </button>
                                                <button class="btn btn-file" id="step5-otherCert-remove" onclick="removeFile('#step5-otherCert',{id: register.id,remove: 'all'})">
                                                    Remove All
                                                </button>
                                            </div>
                                        </div>
                                        <div class="bs-row" id="step5-otherCert-list">
                                        </div>
                                        <div class="bs-row">
                                            <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                        </div>
                                    </div>
                                    <div class="card-body attach-file">
                                        <div class="bs-row" id="attach-file-step5-otherCert">
                                            <div class="d-grid">
                                                <button class="btn btn-primary" type="button" onclick="downloadFile('#step5-otherCert')">
                                                    <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="regis-form-data-row hide" id="step5-type2">
                        <div class="regis-form-data-col1">
                            <h4>
                                เลขที่ใบอนุญาตประกอบธุรกิจ
                                <span class="required">*</span>
                            </h4>
                            <input type="text" class="form-control" id="step5-t2-bussLicense">
                            <div class="invalid-feedback">กรุณากรอก เลขที่ใบอนุญาตประกอบธุรกิจ</div>
                        </div>
                        <div class="bs-row">
                            <span class="fs-18 fw-semibold">แนบเอกสาร</h4>
                                <hr>
                                <div class="bs-row">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
                                        <span class="fs-18 fw-semibold">
                                            ใบอนุญาตประกอบการธุรกิจโรงแรม (ตาม พ.ร.บ. โรงแรม ปี พ.ศ. 2547) เป็นระยะเวลาไม่ต่ำกว่า 1 ปี
                                            นับถึงวันปิดรับสมัคร
                                            <span class="required">*</span>
                                        </span>
                                        <div class="card" style="border: 1px solid #E5E6ED;">
                                            <div class="card-body selecter-file">
                                                <div class="bs-row mb-2">
                                                    <div class="col-12">
                                                        <button class="btn btn-file" id="step5-bussLicenseFiles-btn">
                                                            <span id="step5-bussLicenseFiles-label">Upload Files</span>
                                                            <input type="file" id="step5-bussLicenseFiles" accept=".pdf" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'paper')" />
                                                        </button>
                                                        <button class="btn btn-file" id="step5-bussLicenseFiles-remove" onclick="removeFile('#step5-bussLicenseFiles',{id: register.id,remove: 'all'})">
                                                            Remove All
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="bs-row" id="step5-bussLicenseFiles-list">
                                                </div>
                                                <div class="bs-row">
                                                    <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                                </div>
                                            </div>
                                            <div class="card-body attach-file">
                                                <div class="bs-row" id="attach-file-step5-bussLicenseFiles">
                                                    <div class="d-grid">
                                                        <button class="btn btn-primary" type="button" onclick="downloadFile('#step5-bussLicenseFiles')">
                                                            <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
                                        <div class="regis-form-data-col1">
                                            <h4>
                                                ชื่อโรงแรมและจำนวนห้องพักตรงกับที่ระบุในใบอนุญาต
                                                <span class="required">*</span>
                                            </h4>
                                            <p><input type="radio" name="step5-t2-bussCkRoom" id="step5-t2-bussCkRoom-1" value="1"> ตรง</p>
                                            <p><input type="radio" name="step5-t2-bussCkRoom" id="step5-t2-bussCkRoom-0" value="0"> ไม่ตรง</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bs-row">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
                                        <span class="fs-18 fw-semibold">สำเนาหนังสือให้ความเห็นชอบต่อรายงานการประเมินผลกระทบสิ่งแวดล้อม (EIA) ในกรณีที่มีจำนวนห้องพักตั้งแต่ 80 ห้องขึ้นไปหรือมีพื้นที่ใช้สอยตั้งแต่ 4,000 ตารางเมตรขึ้นไป
                                            หรือสำเนาหนังสือให้ความเห็นชอบต่อรายงานการประเมินผลกระทบสิ่งแวดล้อมเบื้องต้น (IEE) ในกรณีที่มีจำนวนห้องพักหรือพื้นที่ใช้สอยต่ำกว่าและอยู่ในพื้นที่ที่กฎหมายกำหนด
                                            <span class="required">*</span>
                                        </span>
                                        <div class="card" style="border: 1px solid #E5E6ED;">
                                            <div class="card-body selecter-file">
                                                <div class="bs-row mb-2">
                                                    <div class="col-12">
                                                        <button class="btn btn-file" id="step5-EIAreport-btn">
                                                            <span id="step5-EIAreport-label">Upload Files</span>
                                                            <input type="file" id="step5-EIAreport" accept=".pdf" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'paper')" />
                                                        </button>
                                                        <button class="btn btn-file" id="step5-EIAreport-remove" onclick="removeFile('#step5-EIAreport',{id: register.id,remove: 'all'})">
                                                            Remove All
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="bs-row" id="step5-EIAreport-list">
                                                </div>
                                                <div class="bs-row">
                                                    <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                                </div>
                                            </div>
                                            <div class="card-body attach-file">
                                                <div class="bs-row" id="attach-file-step5-EIAreport">
                                                    <div class="d-grid">
                                                        <button class="btn btn-primary" type="button" onclick="downloadFile('#step5-EIAreport')">
                                                            <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
                                        <div class="regis-form-data-col1">
                                            <h4>
                                                กรณีมีส่วนต่อขยายของอาคารจะต้องแสดงรายงานการประเมินผลกระทบสิ่งแวดล้อมที่สอดคล้องกัน
                                                <span class="required">*</span>
                                            </h4>
                                            <p><input type="radio" name="step5-t2-buildExt" id="step5-t2-buildExt-1" value="1"> มี (กรณีที่เลือก ต้องแนบเอกสารการประเมินผลกระทบสิ่งแวดล้อมที่สอดคล้องกัน)</p>
                                            <p><input type="radio" name="step5-t2-buildExt" id="step5-t2-buildExt-0" value="0"> ไม่มี</p>
                                            <div class="card mt-3" style="border: 1px solid #E5E6ED;">
                                                <div class="card-body selecter-file">
                                                    <div class="bs-row mb-2">
                                                        <div class="col-12">
                                                            <button class="btn btn-file" id="step5-buildExt-btn">
                                                                <span id="step5-buildExt-label">Upload Files</span>
                                                                <input type="file" id="step5-buildExt" accept=".pdf" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'paper')" />
                                                            </button>
                                                            <button class="btn btn-file" id="step5-buildExt-remove" onclick="removeFile('#step5-buildExt',{id: register.id,remove: 'all'})">
                                                                Remove All
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="bs-row" id="step5-buildExt-list">
                                                    </div>
                                                    <div class="bs-row">
                                                        <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                                    </div>
                                                </div>
                                                <div class="card-body attach-file">
                                                    <div class="bs-row" id="attach-file-step5-buildExt">
                                                        <div class="d-grid">
                                                            <button class="btn btn-primary" type="button" onclick="downloadFile('#step5-buildExt')">
                                                                <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bs-row">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
                                        <span class="fs-18 fw-semibold">
                                            สำเนาใบรับรองมาตรฐาน หรือประกาศนียบัตรจากการท่องเที่ยวแห่งประเทศไทย, กรมการท่องเที่ยว,
                                            องค์การบริหารการพัฒนาพื้นที่พิเศษเพื่อการท่องเที่ยวอย่างยั่งยืน (องค์การมหาชน), TAT Academy ฯลฯ
                                            (ถ้ามี)
                                        </span>
                                        <div class="card" style="border: 1px solid #E5E6ED;">
                                            <div class="card-body selecter-file">
                                                <div class="bs-row mb-2">
                                                    <div class="col-12">
                                                        <button class="btn btn-file" id="step5-otherT2Cert-btn">
                                                            <span id="step5-otherT2Cert-label">Upload Files</span>
                                                            <input type="file" id="step5-otherT2Cert" accept=".pdf" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'paper')" />
                                                        </button>
                                                        <button class="btn btn-file" id="step5-otherT2Cert-remove" onclick="removeFile('#step5-otherT2Cert',{id: register.id,remove: 'all'})">
                                                            Remove All
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="bs-row" id="step5-otherT2Cert-list">
                                                </div>
                                                <div class="bs-row">
                                                    <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                                </div>
                                            </div>
                                            <div class="card-body attach-file">
                                                <div class="bs-row" id="attach-file-step5-otherT2Cert">
                                                    <div class="d-grid">
                                                        <button class="btn btn-primary" type="button" onclick="downloadFile('#step5-otherT2Cert')">
                                                            <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="regis-form-data-row hide" id="step5-type3">
                        <div class="regis-form-data-col1">
                            <h4>
                                เลขที่ใบอนุญาตประกอบธุรกิจ
                                <span class="required">*</span>
                            </h4>
                            <input type="text" class="form-control" id="step5-t3-bussLicense">
                            <div class="invalid-feedback">กรุณากรอก เลขที่ใบอนุญาตประกอบธุรกิจ</div>
                        </div>
                        <div class="regis-form-data-col1">
                            <h4>จะต้องไม่ประกอบกิจการที่มีการครอบครอง จำหน่าย หรือค้าสัตว์ป่าสงวน
                                สัตว์ป่าคุ้มครอง หรือสัตว์ป่าตามอนุสัญญาฯ (CITES) หรือซากของสัตว์ป่า
                                และผลิตภัณฑ์ที่ทำจากซากของสัตว์และผลิตภัณฑ์ที่ทำจากซากของสัตว์ป่า
                                หรือที่ทำจากงาช้าง รวมทั้งพันธุ์พืชหวงห้ามหรือพืชอนุรักษ์ทุกชนิด โดยที่
                                ไม่ชอบด้วยกฎหมาย
                            </h4>
                            <p><input type="radio" name="step5-t3-bussCites" id="step5-t3-bussCites-0" value="0"> ไม่ประกอบกิจการ</p>
                            <p><input type="radio" name="step5-t3-bussCites" id="step5-t3-bussCites-1" value="1"> ประกอบกิจการ</p>
                        </div>
                        <div class="regis-form-data-col1">
                            <h4>ผู้ส่งผลงานจะต้องไม่มีส่วนได้ส่วนเสียกับการท่องเที่ยวแห่งประเทศไทย (ททท.) ทั้งทางตรงและทางอ้อม</h4>
                            <p><input type="radio" name="step5-t3-nominee" id="step5-t3-nominee-1" value="1"> มีส่วนได้ส่วนเสีย</p>
                            <p><input type="radio" name="step5-t3-nominee" id="step5-t3-nominee-0" value="0"> ไม่มีส่วนได้ส่วนเสีย</p>
                        </div>
                        <div class="bs-row">
                            <span class="fs-18 fw-semibold">แนบเอกสาร</h4>
                                <hr>
                                <div class="bs-row">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
                                        <span class="fs-18 fw-semibold">มีใบอนุญาตประกอบกิจการสถานประกอบการสปาเพื่อสุขภาพจากกระทรวงสาธารณสุขมาแล้วไม่น้อยกว่า 1 ปี นับจนถึงวันปิดรับสมัคร ในกรณีที่ใบรับรองมาตรฐานสปาเพื่อสุขภาพหมดอายุหรืออยู่ระหว่างการยื่นเอกสารขอต่ออายุ
                                            ให้แสดงหลักฐานการยื่นขอต่ออายุจากกระทรวงสาธารณสุขหรือสำนักงานสาธารณสุขจังหวัดที่สถานประกอบการนั้นตั้งอยู่
                                            <span class="required">*</span>
                                        </span>
                                        <div class="card" style="border: 1px solid #E5E6ED;">
                                            <div class="card-body selecter-file">
                                                <div class="bs-row mb-2">
                                                    <div class="col-12">
                                                        <button class="btn btn-file" id="step5-spaCert-btn">
                                                            <span id="step5-spaCert-label">Upload Files</span>
                                                            <input type="file" id="step5-spaCert" accept=".pdf" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'paper')" />
                                                        </button>
                                                        <button class="btn btn-file" id="step5-spaCert-remove" onclick="removeFile('#step5-spaCert',{id: register.id,remove: 'all'})">
                                                            Remove All
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="bs-row" id="step5-spaCert-list">
                                                </div>
                                                <div class="bs-row">
                                                    <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                                </div>
                                            </div>
                                            <div class="card-body attach-file">
                                                <div class="bs-row" id="attach-file-step5-spaCert">
                                                    <div class="d-grid">
                                                        <button class="btn btn-primary" type="button" onclick="downloadFile('#step5-spaCert')">
                                                            <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
                                        <span class="fs-18 fw-semibold">
                                            มีผลการตรวจสอบลักษณะน้ำทิ้ง (ในกรณีเป็นสถานประกอบกิจการที่ต้องถูกควบคุมการระบายน้ำทิ้งตามกฎหมายกำหนด)
                                        </span>
                                        <div></div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="step5-t3-hasEffluent" id="step5-t3-hasEffluent-1" value="1">
                                            <label class="form-check-label mr-2">มี</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="step5-t3-hasEffluent" id="step5-t3-hasEffluent-2" value="2">
                                            <label class="form-check-label mr-2">ไม่มี</label>
                                        </div>
                                        <div class="card" style="border: 1px solid #E5E6ED;">
                                            <div class="card-body selecter-file">
                                                <div class="bs-row mb-2">
                                                    <div class="col-12">
                                                        <button class="btn btn-file" id="step5-effluent-btn">
                                                            <span id="step5-effluent-label">Upload Files</span>
                                                            <input type="file" id="step5-effluent" accept=".pdf" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'paper')" />
                                                        </button>
                                                        <button class="btn btn-file" id="step5-effluent-remove" onclick="removeFile('#step5-effluent',{id: register.id,remove: 'all'})">
                                                            Remove All
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="bs-row" id="step5-effluent-list">
                                                </div>
                                                <div class="bs-row">
                                                    <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                                </div>
                                            </div>
                                            <div class="card-body attach-file">
                                                <div class="bs-row" id="attach-file-step5-effluent">
                                                    <div class="d-grid">
                                                        <button class="btn btn-primary" type="button" onclick="downloadFile('#step5-effluent')">
                                                            <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4" id="step5-wellnessCert-only">
                                        <span class="fs-18 fw-semibold">
                                            มีใบอนุญาตประกอบกิจการสถานพยาบาล หรือใบอนุญาตให้ดำเนินการสถานพยาบาล (เฉพาะสาขา Wellness Spa)
                                            <span class="required">*</span>
                                        </span>
                                        <div class="card" style="border: 1px solid #E5E6ED;">
                                            <div class="card-body selecter-file">
                                                <div class="bs-row mb-2">
                                                    <div class="col-12">
                                                        <button class="btn btn-file" id="step5-wellnessCert-btn">
                                                            <span id="step5-wellnessCert-label">Upload Files</span>
                                                            <input type="file" id="step5-wellnessCert" accept=".pdf" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'paper')" />
                                                        </button>
                                                        <button class="btn btn-file" id="step5-wellnessCert-remove" onclick="removeFile('#step5-wellnessCert',{id: register.id,remove: 'all'})">
                                                            Remove All
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="bs-row" id="step5-wellnessCert-list">
                                                </div>
                                                <div class="bs-row">
                                                    <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                                </div>
                                            </div>
                                            <div class="card-body attach-file">
                                                <div class="bs-row" id="attach-file-step5-wellnessCert">
                                                    <div class="d-grid">
                                                        <button class="btn btn-primary" type="button" onclick="downloadFile('#step5-wellnessCert')">
                                                            <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4" id="step5-spa-only">
                                        <span class="fs-18 fw-semibold">
                                            สำเนาใบอนุญาตเป็นผู้ดำเนินการสปา (Spa Manager)
                                            <span class="required">*</span>
                                        </span>
                                        <div class="card" style="border: 1px solid #E5E6ED;">
                                            <div class="card-body selecter-file">
                                                <div class="bs-row mb-2">
                                                    <div class="col-12">
                                                        <button class="btn btn-file" id="step5-spaManger-btn">
                                                            <span id="step5-spaManger-label">Upload Files</span>
                                                            <input type="file" id="step5-spaManger" accept=".pdf" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'paper')" />
                                                        </button>
                                                        <button class="btn btn-file" id="step5-spaManger-remove" onclick="removeFile('#step5-spaManger',{id: register.id,remove: 'all'})">
                                                            Remove All
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="bs-row" id="step5-spaManger-list">
                                                </div>
                                                <div class="bs-row">
                                                    <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                                </div>
                                            </div>
                                            <div class="card-body attach-file">
                                                <div class="bs-row" id="attach-file-step5-spaManger">
                                                    <div class="d-grid">
                                                        <button class="btn btn-primary" type="button" onclick="downloadFile('#step5-spaManger')">
                                                            <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
                                        <span class="fs-18 fw-semibold">
                                            สำเนาโฉนดที่ดิน/เอกสารสิทธิ์ที่ถูกต้องตามกฎหมาย หรือมีเอกสารที่ได้รับอนุญาตให้ใช้พื้นที่จากทางราชการหรือสัญญาเช่า
                                            <span class="required">*</span>
                                        </span>
                                        <div class="card" style="border: 1px solid #E5E6ED;">
                                            <div class="card-body selecter-file">
                                                <div class="bs-row mb-2">
                                                    <div class="col-12">
                                                        <button class="btn btn-file" id="step5-titleDeed-btn">
                                                            <span id="step5-titleDeed-label">Upload Files</span>
                                                            <input type="file" id="step5-titleDeed" accept=".pdf" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'paper')" />
                                                        </button>
                                                        <button class="btn btn-file" id="step5-titleDeed-remove" onclick="removeFile('#step5-titleDeed',{id: register.id,remove: 'all'})">
                                                            Remove All
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="bs-row" id="step5-titleDeed-list">
                                                </div>
                                                <div class="bs-row">
                                                    <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                                </div>
                                            </div>
                                            <div class="card-body attach-file">
                                                <div class="bs-row" id="attach-file-step5-titleDeed">
                                                    <div class="d-grid">
                                                        <button class="btn btn-primary" type="button" onclick="downloadFile('#step5-titleDeed')">
                                                            <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
                                        <span class="fs-18 fw-semibold">เอกสารแนบอื่น ๆ (ถ้ามี) เช่น หนังสือรับรอง GMP ของโรงงานผู้ผลิตผลิตภัณฑ์ที่ใช้ในสถานประกอบการ เอกสารรับรอง (Certificate)
                                            หรือรางวัลมาตรฐานผลิตภัณฑ์ระดับนานาชาติของผลิตภัณฑ์หรือของโรงงานผู้ผลิตผลิตภัณฑ์ที่ใช้ในสถานประกอบการ</span>
                                        <div class="card" style="border: 1px solid #E5E6ED;">
                                            <div class="card-body selecter-file">
                                                <div class="bs-row mb-2">
                                                    <div class="col-12">
                                                        <button class="btn btn-file" id="step5-otherT3-btn">
                                                            <span id="step5-otherT3-label">Upload Files</span>
                                                            <input type="file" id="step5-otherT3" accept=".pdf" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'paper')" />
                                                        </button>
                                                        <button class="btn btn-file" id="step5-otherT3-remove" onclick="removeFile('#step5-otherT3',{id: register.id,remove: 'all'})">
                                                            Remove All
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="bs-row" id="step5-otherT3-list">
                                                </div>
                                                <div class="bs-row">
                                                    <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                                </div>
                                            </div>
                                            <div class="card-body attach-file">
                                                <div class="bs-row" id="attach-file-step5-otherT3">
                                                    <div class="d-grid">
                                                        <button class="btn btn-primary" type="button" onclick="downloadFile('#step5-otherT3')">
                                                            <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
                                        <span class="fs-18 fw-semibold">
                                            จะต้องเป็นสถานประกอบการที่ไม่มีการจ้างแรงงานที่ผิดกฎหมาย หากมี
                                            การจ้างแรงงานต่างด้าวจะต้องแสดงหลักฐานการจ้างแรงงานที่ถูกต้องตามกฎหมายกำหนด
                                            <span class="required">*</span>
                                        </span>
                                        <div></div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="step5-t3-outlander" id="step5-t3-outlander-1" value="1">
                                            <label class="form-check-label mr-2">มี</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="step5-t3-outlander" id="step5-t3-outlander-0" value="0">
                                            <label class="form-check-label mr-2">ไม่มี</label>
                                        </div>
                                        <div class="card mt-1" style="border: 1px solid #E5E6ED;">
                                            <div class="card-body selecter-file">
                                                <div class="bs-row mb-2">
                                                    <div class="col-12">
                                                        <button class="btn btn-file" id="step5-outlander-btn">
                                                            <span id="step5-outlander-label">Upload Files</span>
                                                            <input type="file" id="step5-outlander" accept=".pdf" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'paper')" />
                                                        </button>
                                                        <button class="btn btn-file" id="step5-outlander-remove" onclick="removeFile('#step5-outlander',{id: register.id,remove: 'all'})">
                                                            Remove All
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="bs-row" id="step5-outlander-list">
                                                </div>
                                                <div class="bs-row">
                                                    <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                                </div>
                                            </div>
                                            <div class="card-body attach-file">
                                                <div class="bs-row" id="attach-file-step5-outlander">
                                                    <div class="d-grid">
                                                        <button class="btn btn-primary" type="button" onclick="downloadFile('#step5-outlander')">
                                                            <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="regis-form-data-row hide" id="step5-type4">
                        <div class="regis-form-data-col1">
                            <h4>
                                เลขที่ใบอนุญาตประกอบธุรกิจ <span class="required">*</span>
                            </h4>
                            <input type="text" class="form-control" id="step5-t4-bussLicense">
                            <div class="invalid-feedback">กรุณากรอก เลขที่ใบอนุญาตประกอบธุรกิจ</div>
                        </div>
                        <div class="bs-row">
                            <h4>แนบเอกสาร</h4>
                            <hr>
                            <div class="bs-row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
                                    <span class="fs-18 fw-semibold">
                                        ต้องมีใบอนุญาตประกอบธุรกิจนำเที่ยวไม่น้อยกว่า 2 ปี จนถึงวันปิดรับสมัคร
                                        <span class="required">*</span>
                                    </span>
                                    <div class="card mt-1" style="border: 1px solid #E5E6ED;">
                                        <div class="card-body selecter-file">
                                            <div class="bs-row mb-2">
                                                <div class="col-12">
                                                    <button class="btn btn-file" id="step5-guideCert-btn">
                                                        <span id="step5-guideCert-label">Upload Files</span>
                                                        <input type="file" id="step5-guideCert" accept=".pdf" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'paper')" />
                                                    </button>
                                                    <button class="btn btn-file" id="step5-guideCert-remove" onclick="removeFile('#step5-guideCert',{id: register.id,remove: 'all'})">
                                                        Remove All
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="bs-row" id="step5-guideCert-list">
                                            </div>
                                            <div class="bs-row">
                                                <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                            </div>
                                        </div>
                                        <div class="card-body attach-file">
                                            <div class="bs-row" id="attach-file-step5-guideCert">
                                                <div class="d-grid">
                                                    <button class="btn btn-primary" type="button" onclick="downloadFile('#step5-guideCert')">
                                                        <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
                                    <span class="fs-18 fw-semibold">
                                        มีใบอนุญาตประกอบธุรกิจนำเที่ยวจากกรมการท่องเที่ยว ในกรณีที่ใบอนุญาตหมดอายุ หรืออยู่ระหว่างการยื่นเอกสารขอต่ออายุ
                                        ให้แสดงหลักฐานการยื่นขอต่ออายุจากกรมการท่องเที่ยว หรือสำนักงานทะเบียนจังหวัดที่สถานประกอบการนั้นตั้งอยู่
                                        <span class="required">*</span>
                                    </span>
                                    <div class="card mt-1" style="border: 1px solid #E5E6ED;">
                                        <div class="card-body selecter-file">
                                            <div class="bs-row mb-2">
                                                <div class="col-12">
                                                    <button class="btn btn-file" id="step5-guideOldCert-btn">
                                                        <span id="step5-guideOldCert-label">Upload Files</span>
                                                        <input type="file" id="step5-guideOldCert" accept=".pdf" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'paper')" />
                                                    </button>
                                                    <button class="btn btn-file" id="step5-guideOldCert-remove" onclick="removeFile('#step5-guideOldCert',{id: register.id,remove: 'all'})">
                                                        Remove All
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="bs-row" id="step5-guideOldCert-list">
                                            </div>
                                            <div class="bs-row">
                                                <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                            </div>
                                        </div>
                                        <div class="card-body attach-file">
                                            <div class="bs-row" id="attach-file-step5-guideOldCert">
                                                <div class="d-grid">
                                                    <button class="btn btn-primary" type="button" onclick="downloadFile('#step5-guideOldCert')">
                                                        <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
                                    <span class="fs-18 fw-semibold">
                                        หลักฐานการถือครองที่ดินที่กฎหมายรับรอง สัญญาเช่า หรือหนังสือยินยอม
                                        ให้ใช้สถานที่ หรือมีเอกสารที่ได้รับอนุญาตให้ใช้พื้นที่จากทางราชการ
                                        <span class="required">*</span>
                                    </span>
                                    <div class="card mt-1" style="border: 1px solid #E5E6ED;">
                                        <div class="card-body selecter-file">
                                            <div class="bs-row mb-2">
                                                <div class="col-12">
                                                    <button class="btn btn-file" id="step5-titleDeedT4-btn">
                                                        <span id="step5-titleDeedT4-label">Upload Files</span>
                                                        <input type="file" id="step5-titleDeedT4" accept=".pdf" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'paper')" />
                                                    </button>
                                                    <button class="btn btn-file" id="step5-titleDeedT4-remove" onclick="removeFile('#step5-titleDeedT4',{id: register.id,remove: 'all'})">
                                                        Remove All
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="bs-row" id="step5-titleDeedT4-list">
                                            </div>
                                            <div class="bs-row">
                                                <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                            </div>
                                        </div>
                                        <div class="card-body attach-file">
                                            <div class="bs-row" id="attach-file-step5-titleDeedT4">
                                                <div class="d-grid">
                                                    <button class="btn btn-primary" type="button" onclick="downloadFile('#step5-titleDeedT4')">
                                                        <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
                                    <span class="fs-18 fw-semibold">
                                        สำเนาใบประกอบธุรกิจที่ถูกต้องตามกฎหมาย (ถ้ามี) (แนบเอกสาร)
                                        สำเนาใบรับรองมาตรฐาน หรือประกาศนียบัตรจากการท่องเที่ยวแห่งประเทศไทย
                                        กรมการท่องเที่ยว องค์การบริหารการพัฒนาพื้นที่พิเศษเพื่อการท่องเที่ยวอย่างยั่งยืน (องค์การมหาชน) ฯลฯ (ถ้ามี)

                                    </span>
                                    <div class="card mt-1" style="border: 1px solid #E5E6ED;">
                                        <div class="card-body selecter-file">
                                            <div class="bs-row mb-2">
                                                <div class="col-12">
                                                    <button class="btn btn-file" id="step5-otherT4Cert-btn">
                                                        <span id="step5-otherT4Cert-label">Upload Files</span>
                                                        <input type="file" id="step5-otherT4Cert" accept=".pdf" multiple onchange="onFileHandle({id: register.id},'#'+this.id,'paper')" />
                                                    </button>
                                                    <button class="btn btn-file" id="step5-otherT4Cert-remove" onclick="removeFile('#step5-otherT4Cert',{id: register.id,remove: 'all'})">
                                                        Remove All
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="bs-row" id="step5-otherT4Cert-list">
                                            </div>
                                            <div class="bs-row">
                                                <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                            </div>
                                        </div>
                                        <div class="card-body attach-file">
                                            <div class="bs-row" id="attach-file-step5-otherT4Cert">
                                                <div class="d-grid">
                                                    <button class="btn btn-primary" type="button" onclick="downloadFile('#step5-otherT4Cert')">
                                                        <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="regis-form-data-row">
                        <div class="regis-form-data-col1 continue">
                            <button class="btn btn-action" id="btn-next" onclick="register.setStep(4)">
                                ย้อนกลับ
                            </button>
                            <!-- <button class="btn btn-confirm-submit" disabled -->
                            <button class="btn btn-action gold" disabled id="btnFFinish" onclick="register.saveApp()">
                                ส่งใบสมัคร
                            </button>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="images-modal" class="images-modal" onclick="this.style.display='none'">
    <div class="images-modal-content">
        <span class="images-close">&times;</span>
        <img id="img-modal" class="w-100">
    </div>
</div>

<div class="loading" id="loading-page"></div>

<?php $app = new \Config\App(); ?>
<link href="<?= base_url('assets/js/frontend/datepicker/jquery-ui.css') ?>?v=<?= $app->script_v ?>" rel="stylesheet">
<script src="<?= base_url('assets/js/frontend/datepicker/jquery-ui.js') ?>?v=<?= $app->script_v ?>"></script>


<script src="<?= base_url('assets/js/frontend/upload.files.js') ?>?v=<?= $app->script_v ?>"></script>
<script src="<?= base_url('assets/js/frontend/apc.js') ?>?v=<?= $app->script_v ?>"></script>
<script>
    $(function() {

        $("#step5-hiddenDate").datepicker({
            dateFormat: 'yy/mm/dd',
            maxDate: '-1Y',
            yearRange: "-100:+0",
            changeMonth: true,
            changeYear: true,
            dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
            dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
            monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
            monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
            onSelect: function(dp, input) {
                const yearT = new Date(dp).getFullYear() - 0;
                const yearTH = yearT + 543;
                const dpdate = dp;
                const fulldateTH = dpdate.replace(yearT, yearTH);
                $('#step5-openYear').val(fulldateTH);
                $('#step5-hiddenDate').val(dpdate);

                if (!empty(dp)) {
                    const date = new Date(register.configRegisDate);
                    const fulldate = $(this).val().split('/');
                    const from = fulldate[1] + '/' + fulldate[2] + '/' + fulldate[0];
                    const to = String(date.getMonth() + 1).padStart(2, '0') + '/' + String(date.getDate()).padStart(2, '0') + '/' + date.getFullYear();
                    const totalYear = calcDate(from, to);

                    register.change = true;
                    register.passYear = true;
                    register.formData.step5.openYear = fulldateTH;
                    register.formData.step5.totalYear = totalYear.result;
                    $('#step5-totalYear').val(totalYear.result);

                    const app = register.formData.step1.appType;
                    const confYear = register.appType.main.find(el => el.id == app);
                    register.passYearCount = confYear.fixe_year_open;

                    if (Number(totalYear.total_year) < Number(confYear.fixe_year_open)) {
                        register.passYear = false;
                        const title = 'เปิดรับสมัครสําหรับสถานประกอบการ<br>ที่จดทะเบียนมาแล้ว ' + confYear.fixe_year_open + ' ปีขึ้นไป';
                        alert.show('error', title, '');
                    }
                } else {
                    $('#step5-totalYear').val('');
                }
            }
        });

        $("#step5-openYear-btn").click(() => {
            $('#step5-hiddenDate').datepicker('show');
        });

    });

    $(document).ready(function() {
        register.init(
            '<?= $duedate->expired_sts ? 'Expired' : 'Unexpired' ?>',
            '<?= $config_date ?>'
        );
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

    const zoomImages = (el) => {
        Swal.fire({
            imageUrl: el.src,
            width: 800,
            height: 800,
            confirmButtonColor: '#DD3342',
            confirmButtonText: '<i class="fas fa-times"></i> ปิด',
            showCloseButton: true,
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });
    }
</script>