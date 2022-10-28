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
                    <div class="formstep-col register complete">
                        <a href="<?= base_url('awards/application') ?>" class="inactive">
                            <div class="formstep-title">1. กรอกแบบฟอร์มใบสมัคร</div>
                        </a>
                        <div class="formstep-status pass" data-tab="1">ผ่านการตรวจสอบ</div>
                        <div class="formstep-icon"><span><i class="bi bi-check-lg"></i></span></div>
                    </div>
                    <div class="formstep-col prescreen active">
                        <a href="<?= base_url('awards/pre-screen') ?>">
                            <div class="formstep-title">2. กรอกแบบประเมินขั้นต้น (Pre-Screen)</div>
                        </a>
                        <div class="formstep-status" id="formstep-sts" data-tab="2">
                            <?= $duedate->expired_str ?>
                        </div>
                        <div class="formstep-icon"><span><i class="bi bi-pencil-fill"></i></span></div>
                    </div>
                    <div class="formstep-col estimate">
                        <div class="formstep-title">3. สรุปผลการประเมิน</div>
                        <div class="formstep-status" data-tab="3"></div>
                        <div class="formstep-icon"><span><i class="bi bi-three-dots"></i></span></div>
                    </div>
                    <script>
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

            <div class="formstatus pass hide" id="formstatus-pass">
                <img src="<?=base_url('/assets/images/pass-regis-form.png')?>">
                <h3>ใบสมัครของท่านผ่านการอนุมัติ</h3>
                <p>โปรดกรอกแบบประเมินขั้นต้น (Pre-screen) ภายในระยะเวลาที่กำหนด</p>
            </div>

            <div class="formstatus pass hide" id="formstatus-complete">
                <img src="<?=base_url('/assets/images/pass-regis-form.png')?>">
                <h3>ส่งแบบประเมินขั้นต้น (Pre-screen) เรียบร้อยแล้ว</h3>
                <p>โปรดติดตามรายละเอียดการแจ้งผลประเมินได้ทางหน้าเว็บไซต์ หรือการแจ้งเตือนต่าง ๆ</p>
            </div>

            <div class="formstatus uncomplete hide" id="formstatus-reject">
                <img src="<?=base_url('/assets/images/uncomplete-regis-form.png')?>">
                <h3>ขอข้อมูลเพิ่มเติม</h3>
                <p>ข้อมูลของท่านอาจยังไม่สมบูรณ์ โปรดดูรายละเอียด เพื่อแก้ไขและส่งใบสมัครอีกครั้ง</p>
            </div>
            
            <div class="formstatus uncomplete hide" id="formstatus-unpass">
                <img src="<?=base_url('/assets/images/uncomplete-regis-form.png')?>">
                <h3>หมดเวลาการส่งแบบประเมินขั้นต้น</h3>
                <p>เวลาในการกรอกแบบประเมินขั้นต้น (Pre-screen) หมดลงแล้ว</p>
            </div>

            <div class="form-main-title hide">
                <div class="form-main-title-txt">
                    กรอกแบบประเมินขั้นต้น
                </div>
                <div class="form-main-btn">
                    <a href="javascript:void(0)" class="btn-regis active" data-tab="1"
                    onclick="psc.finish()">
                        ส่งแบบประเมิน
                    </a>
                </div>
            </div>

            <div class="formmainbox">
                <div class="regis-form-step">
                    <a href="javascript:;" id="tab-0" class="btn-form-step active"
                    onclick="psc.setNewQuestion(0,0)">
                        1. Tourism Excellence
                    </a>
                    <a href="javascript:;" id="tab-1" class="btn-form-step"
                    onclick="psc.setNewQuestion(1,0)">
                        2. Suporting Business & Marketing Factors
                    </a>
                    <a href="javascript:;" id="tab-2" class="btn-form-step"
                    onclick="psc.setNewQuestion(2,0)">
                        3. Responsibility and Safety &
                        Health
                    </a>
                </div>

                <div class="regis-form-data">
                    <div class="regis-form-data-row">
                        <div class="regis-form-data-col1 title">
                            <h3>
                                <picture>
                                    <source srcset="<?= base_url('assets/images/formicon-type.svg') ?>">
                                    <img src="<?= base_url('assets/images/formicon-type.png') ?>">
                                </picture>
                                <span id="title"></span>
                                <br>
                                <span class="txt-yellow title-comment">คำถามทั้งหมด <span id="sum"></span> ข้อ</span>
                            </h3>

                            <div class="choicebox">
                                <div class="choicebox-col select-choice">
                                    คำถามข้อที่
                                    <span id="num" class="fs-20 mr-2 ml-2"></span>
                                </div>
                                <div class="choicebox-col">
                                    <a href="javascript:void(0)" class="btn-choice">
                                        <i class="bi bi-toggles"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="hide-choice" style="display: none;">
                                <div class="hide-choice-overlay"></div>
                                <div class="hide-choice-box">
                                    <div class="hide-choice-title">
                                        รายการคำถาม 
                                        <a href="javascript:void(0)" class="btn-choice-close">
                                            <i class="bi bi-x"></i>
                                        </a>
                                    </div>
                                    <div class="hide-choice-content">
                                        <ul id="selection-list">
                                        </ul>
                                    </div>
                                </div>
                                <script>
                                    jQuery(document).ready(function() {
                                        $('.btn-choice').click(function() {
                                            $('.hide-choice').show();
                                            $('body').addClass('lockbody');
                                        });
                                        $('.btn-choice-close').click(function() {
                                            $('.hide-choice').hide();
                                            $('body').removeClass('lockbody');
                                        });
                                        $('.hide-choice-overlay').click(function() {
                                            $('.hide-choice').hide();
                                            $('body').removeClass('lockbody');
                                        });
                                    });
                                </script>
                            </div>

                        </div>

                        <div class="regis-form-data-col1">
                            <h4 id="question"></h4> 
                            ระบุคำตอบ<span class="required">*</span>   
                            <div class="mt-3 hide" id="reject">
                                ขอข้อมูลเพิ่มเติม (กรรมการ)
                                <div class="alert alert-warning fs-18 mt-2" role="alert">   
                                    รายละเอียดขอข้อมูลเพิ่มเติม ดังต่อไปนี้
                                    <ul class="ml-3" id="request-list">
                                    </ul>                       
                                </div>
                            </div>
                            <span class="text-muted">(จำนวนตัวอักษรคงเหลือ <span id="charNum">1,000</span>/1,000)</span>
                            <textarea class="form-control" id="reply" onkeyup="countChar(this)" maxlength="1000" rows="12"></textarea>                                                     
                            <div id="remark" class="alert alert-info fs-18 mt-3" role="alert">                            
                            </div>
                            <script>
                                function countChar(val) {
                                    var len = val.value.length;
                                    if (len >= 1000) {
                                        val.value = val.value.substring(0, 1000);
                                    } else {
                                        $('#charNum').text(1000 - len);
                                    }
                                };
                            </script>
                        </div>

                        <div class="bs-row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
                                <div class="col-12">
                                    <div class="card" style="border: 1px solid #E5E6ED;">
                                    <div class="card-header text-center" style="background-color: rgba(0, 0, 0, 0.03);">
                                            <span class="fs-18 fw-semibold">แนบรูปภาพความละเอียดสูง</span>
                                        </div>
                                        <div class="card-body selecter-file">
                                            <div class="bs-row">
                                                <div class="col-12">                                                                 
                                                    <button class="btn btn-action" id="images-remove"
                                                    onclick="removeFile('#images',{cate: psc.pointer.category,seg: psc.pointer.segment,remove: 'all'})">
                                                        Remove All
                                                    </button>
                                                </div>
                                                <div class="col-12"> 
                                                    <div class='bfd-dropfield'> 
                                                        <div class='bfd-dropfield-inner' id="images-drop">
                                                            <div class="mt-4 mb-4" id="images-input">
                                                                <span class="fw-semibold">Drop File Here</span><br>
                                                                <button class="btn btn-file" style="font-size: 16px;" id="images-btn">
                                                                    <span id="images-label">Upload Files</span>
                                                                    <input type="file" id="images"
                                                                    accept=".jpg,.jpeg,.png" multiple
                                                                    onchange="onFileHandle({cate: psc.pointer.category,seg: psc.pointer.segment},'#'+this.id,'images')"/>
                                                                </button>   
                                                            </div>
                                                            <div class="mt-4 mb-4 hide" id="images-progress">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bs-row">
                                                <span class="text-muted" style="font-size: 14px;">
                                                    จำกัดแค่ไฟล์ .jpg, .jpeg, .png เท่านั้น ขนาดไฟล์ไม่เกิน 10MB และอัพโหลดได้ไม่เกิน 10 รูป
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body-muted c-lef selecter-file" id="images-list">
                                        </div>
                                        <div class="card-body attach-file">
                                            <div class="ablumbox" id="images-ablum">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6">
                                <div class="col-12">
                                    <div class="card" style="border: 1px solid #E5E6ED;">
                                        <div class="card-header text-center" style="border-bottom: 0;">
                                            <span class="fs-18 fw-semibold">แนบไฟล์</span>
                                        </div>
                                        <div class="card-body selecter-file">
                                            <div class="bs-row mb-2">
                                                <div class="col-12">
                                                    <button class="btn btn-file" id="file-btn">
                                                        <span id="file-label">Upload Files</span>
                                                        <input type="file" id="file"
                                                        accept=".pdf" multiple
                                                        onchange="onFileHandle({cate: psc.pointer.category,seg: psc.pointer.segment},'#'+this.id,'paper')"/>
                                                    </button>                                                                    
                                                    <button class="btn btn-action" id="file-remove"
                                                    onclick="removeFile('#file',{cate: psc.pointer.category,seg: psc.pointer.segment,remove: 'all'})">
                                                        Remove All
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="bs-row" id="file-list">
                                            </div>
                                            <div class="bs-row">
                                                <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                            </div>
                                        </div>
                                        <div class="card-body attach-file">
                                            <div class="bs-row">
                                                <div class="d-grid">
                                                    <button class="btn btn-primary" type="button"
                                                    onclick="downloadFile('#file')">
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
                    <div class="regis-form-data-row label-action hide">
                        <div class="regis-form-data-col1 continue">                                                                                                               
                            <button class="btn btn-action" id="btn-back">
                                ย้อนกลับ
                            </button>                                                                                                                 
                            <button class="btn btn-action" id="btn-next">
                                ถัดไป
                            </button>                                                                                                               
                            <button class="btn btn-main" id="btn-next" 
                            onclick="psc.reply(psc.pointer.category,psc.pointer.segment)">
                                บันทึก
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- <div class="loading" id="loading-page"></div> -->

<?php $app = new \Config\App(); ?>
<script src="<?= base_url('assets/js/frontend/upload.files.js') ?>?v=<?= $app->script_v ?>"></script>
<script src="<?= base_url('assets/js/frontend/psc.js') ?>?v=<?= $app->script_v ?>"></script>

<script>
    $(document).ready(function(){      
        psc.init(<?=$duedate->expired_sts?>,{status: <?=$stage->status?>, duedate: '<?=$stage->duedate?>', duedateStr: '<?=$stage->duedate_str?>' });
    });    

    // $('.bfd-dropfield-inner').click(function() {
    //     $('#file')[0].click();
    // });
</script>