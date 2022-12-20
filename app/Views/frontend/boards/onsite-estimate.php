<div class="container">
    <div class="row">

        <div class="col12">
            <div class="form-main-title">
                <div class="form-main-title-txt">
                    ประเมินรอบลงพื้นที่
                </div>
                <div class="form-main-btn">
                    <button style="width: 100px;" class="btn btn-back fw-semibold" 
                    onclick="window.open('<?= base_url('boards') ?>','_self')">
                        ย้อนกลับ
                    </button>
                    <button style="width: 250px;" disabled class="btn btn-confirm-submit fw-semibold" 
                    onclick="setFinish()">
                        ส่งผลประเมินเข้าระบบ
                    </button>
                </div>
            </div>
        </div>
        <div class="col12">

            <div class="formmainbox">
                <div class="regis-form-header">
                    <div class="bs-row text-sm-center">
                        <div class="col-12">
                            <span class="fs-title text-base-main fw-semibold">ข้อมูลใบสมัคร</span>
                        </div>
                    </div>
                </div>
                <div class="regis-form-data judge-form-data">
                    <div class="bs-row" style="font-size: 16px;">
                        <div class="col-sm-12 col-md-4 mb-2">
                            <span class="fw-semibold text-base-main">
                                รหัสใบสมัคร : <span class="fw-normal" id="tyCode"></span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2">
                            <span class=" fw-semibold text-base-main">
                            ประเภท : <span class="fw-normal" id="tyType"></span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2">
                            <span class=" fw-semibold text-base-main">
                            ชื่อ-นามสกุล : <span class="fw-normal" id="tyName"></span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2">
                            <span class=" fw-semibold text-base-main">
                            ชื่อสถานประกอบการ : <span class="fw-normal" id="tyAttnTh"></span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2">
                            <span class=" fw-semibold text-base-main">
                            สาขา : <span class="fw-normal" id="tyTSbu"></span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2">
                            <span class=" fw-semibold text-base-main">
                            อีเมล : <span class="fw-normal" id="tyEmail"></span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2">
                            <span class=" fw-semibold text-base-main">
                            Establishment : <span class="fw-normal" id="tyAttnEn"></span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2">
                            <span class=" fw-semibold text-base-main">
                            วันที่ส่งใบสมัคร : <span class="fw-normal" id="tyUdat"></span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2">
                            <span class=" fw-semibold text-base-main">
                            เบอร์ติดต่อ : <span class="fw-normal" id="tyTel"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col12">

            <div class="formmainbox">
                <div class="regis-form-step">
                    <a href="javascript:setQuestion(0,0);" id="tab-0" class="btn-form-step disabled active">
                        1. Tourism Excellence
                    </a>
                    <a href="javascript:setQuestion(1,0);" id="tab-1" class="btn-form-step disabled">
                        2. Suporting Business & Marketing Factors
                    </a>
                    <a href="javascript:setQuestion(2,0);" id="tab-2" class="btn-form-step disabled">
                        3. Responsibility and Safety & Health
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
                                <span id="qTitle"></span>
                                <br>
                                <span class="txt-yellow title-comment">
                                    คำถามทั้งหมด <span id="qSum"></span> ข้อ
                                </span>
                            </h3>

                            <div class="choicebox">
                                <div class="choicebox-col select-choice">
                                    คำถามข้อที่
                                    <span id="qNum" class="fs-20 mr-2 ml-2">1</span>
                                </div>
                                <div class="choicebox-col">
                                    <a href="javascript:void(0)" class="btn-choice">
                                        <i class="bi bi-toggles"></i>
                                    </a>
                                </div>
                                <div class="choicebox-col label-score">
                                    <button class="btn btn-score">
                                        คะแนนรอบ Pre-screen : <?=$score?> คะแนน
                                    </button>
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
                            <h4 id="qSubject"></h4>
                            <span id="qResult">คำตอบ</span>
                            <textarea class="form-control" id="qReply" rows="12" readonly>
                            </textarea>
                            <div id="qRemark" class="alert alert-info fs-18 mt-3" role="alert"></div>
                        </div>

                        <div class="regis-form-data-col2 attachfile" id="qImages">
                            <div class="attachinp">
                                <h4>รูปภาพ</h4>
                                <div class="ablumbox" id="qAblum">
                                </div>
                            </div>
                        </div>

                        <div class="regis-form-data-col2 attachfile" id="qFiles">
                            <div class="attachinp">
                                <h4>แนบไฟล์</h4>
                                <a href="javascript:downloadFileAnswer();" class="btn-download">ดาวน์โหลดไฟล์แนบ</a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="regis-form-data judge-form-data">
                    <div class="regis-form-data-row">

                        <div class="regis-form-data-col1 none-estimate" style="display: none;">
                            <div class="alert alert-danger" role="alert">
                                <span style="font-size: 18px;" class="fw-semibold">
                                    <i class="bi bi-exclamation-diamond-fill mr-2"></i>
                                    ไม่มีการประเมินในรอบ ลงพื้นที่
                                </span>
                            </div>
                        </div>

                        <div class="regis-form-data-col1 title is-estimate">
                            <h3>
                                <picture>
                                    <source srcset="<?= base_url('assets/images/formicon-type.svg') ?>">
                                    <img src="<?= base_url('assets/images/formicon-type.png') ?>">
                                </picture>
                                เกณฑ์การประเมินผล
                                <div id="qEva">
                                </div>
                            </h3>

                            <div class="regis-form-data-col1 mt-2" id="qSco">
                            </div>

                            <div class="regis-form-data-col1">
                                <span class="fw-semibold">ความคิดเห็นของกรรมการ</span>
                                <span class="text-muted">(จำนวนตัวอักษรคงเหลือ <span id="charNum">1,000</span>/1,000)</span>
                                <textarea class="form-control" rows="6" id="comment" 
                                onkeyup="countChar($('#comment'))"></textarea>
                                <script>
                                    function countChar(inp) {
                                        var len = inp.val().length;
                                        if (len >= 1000) {
                                            $('#charNum').text('0');
                                            inp.val(inp.val().substring(0, 1000));
                                        } else {
                                            $('#charNum').text((1000 - len).toLocaleString("en"));
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
                                                        <button class="btn btn-file" style="font-size: 16px;" id="etm-images-btn">
                                                            <span id="images-label">Upload Files</span>
                                                            <input type="file" id="etm-images"
                                                            accept=".jpg,.jpeg,.png" multiple
                                                            onchange="onFileHandle({cate: pointer.cate,seg: pointer.seg},'#'+this.id,'images')"/>
                                                        </button>  
                                                        <button class="btn btn-action" id="etm-images-remove"
                                                        onclick="removeFile('#etm-images',{cate: pointer.cate,seg: pointer.seg,remove: 'all'})">
                                                            Remove All
                                                        </button>
                                                    </div>
                                                    <!-- <div class="col-12"> 
                                                        <div class='bfd-dropfield'> 
                                                            <div class='bfd-dropfield-inner' id="etm-images-drop">
                                                                <div class="mt-4 mb-4" id="etm-images-input">
                                                                    <span class="fw-semibold">Drop File Here</span><br>
                                                                    <button class="btn btn-file" style="font-size: 16px;" id="etm-images-btn">
                                                                        <span id="images-label">Upload Files</span>
                                                                        <input type="file" id="etm-images"
                                                                        accept=".jpg,.jpeg,.png" multiple
                                                                        onchange="onFileHandle({cate: pointer.cate,seg: pointer.seg},'#'+this.id,'images')"/>
                                                                    </button>   
                                                                </div>
                                                                <div class="mt-4 mb-4 hide" id="etm-images-progress">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                </div>
                                                <div class="bs-row">
                                                    <span class="text-muted" style="font-size: 14px;">
                                                        จำกัดแค่ไฟล์ .jpg, .jpeg, .png เท่านั้น ขนาดไฟล์ไม่เกิน 10MB และอัพโหลดได้ไม่เกิน 10 รูป
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="card-body-muted c-lef selecter-file" id="etm-images-list">
                                            </div>
                                            <div class="card-body attach-file">
                                                <div class="ablumbox" id="etm-images-ablum">
                                                    
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
                                                        <button class="btn btn-file" id="etm-file-btn">
                                                            <span id="etm-file-label">Upload Files</span>
                                                            <input type="file" id="etm-file"
                                                            accept=".pdf" multiple
                                                            onchange="onFileHandle({cate: pointer.cate,seg: pointer.seg},'#'+this.id,'paper')"/>
                                                        </button>                                                                    
                                                        <button class="btn btn-action" id="etm-file-remove"
                                                        onclick="removeFile('#etm-file',{cate: pointer.cate,seg: pointer.seg,remove: 'all'})">
                                                            Remove All
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="bs-row" id="etm-file-list">
                                                </div>
                                                <div class="bs-row">
                                                    <span class="text-muted" style="font-size: 14px;">จำกัดแค่ไฟล์ .PDF เท่านั้น ขนาดไฟล์ไม่เกิน 15MB และอัพโหลดได้ไม่เกิน 5 ไฟล์</span>
                                                </div>
                                            </div>
                                            <div class="card-body attach-file">
                                                <div class="bs-row">
                                                    <div class="d-grid">
                                                        <button class="btn btn-primary" type="button"
                                                        onclick="downloadFile('#etm-file')">
                                                            <i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <div class="card" style="border: 1px solid #E5E6ED;">
                                            <div class="card-header text-center" style="border-bottom: 0;">
                                                <span class="fs-18 fw-semibold">แนบไฟล์จากกล้องถ่ายรูป</span>
                                            </div>
                                            <div class="card-body selecter-file">
                                                <div class="bs-row">
                                                    <div class="d-grid">
                                                        <button class="btn btn-file" id="camera-btn">
                                                            <span id="camera-label"><i class="bi bi-camera-fill mr-2"></i> ถ่ายรูป</span>
                                                            <input type="file" id="camera"
                                                            accept=".jpg,.jpeg,.png" multiple
                                                            onchange="onFileHandle({cate: pointer.cate,seg: pointer.seg},'#'+this.id,'images')"/>
                                                        </button>     
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="image-gallery">
                                                <div class="album" id="camera-gallery">
                                                    <!-- <div class="list">
                                                        <img src="<?=base_url('assets/images/news01.jpg')?>" onclick="zoomImages(this)">
                                                    </div> -->
                                                </div>
                                                <div class="remove">
                                                    <button class="btn btn-sm btn-danger" id="camera-remove">
                                                        Remove All
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="regis-form-data">
                    <div class="regis-form-data-row">
                        <div class="regis-form-data-col2 clear">
                            <button class="btn btn-danger is-estimate" onclick="resetEstimate(pointer.cate,pointer.seg)" id="btn-reset">
                                ล้างข้อมูลการให้คะแนน
                            </button>
                        </div>
                        <div class="regis-form-data-col2 continue">
                            <button class="btn-next" id="btn-back">ย้อนกลับ</button>
                            <button class="btn-next" id="btn-next">ถัดไป</button>
                            <button class="btn-save is-estimate" id="btn-save">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="judge-memo is-estimate">
                <h4>บันทึกส่วนตัว (Private Memo)</h4>
                <textarea class="form-control" id="note" rows="6"></textarea>
                <p style="text-align: right">
                    <a href="javascript:void(0)" class="btn-memosave">บันทึก</a>
                </p>
            </div>

        </div>
    </div>
</div>

<div class="loading" id="loading-page"></div>

<div id="images-modal" class="images-modal" onclick="this.style.display='none'">
    <div class="images-modal-content">
        <span class="images-close">&times;</span>
        <img id="img-modal" class="w-100">
    </div>
</div>

<?php $app = new \Config\App(); ?>
<script src="<?= base_url('assets/js/frontend/bootstrap/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/js/frontend/upload.files.js') ?>?v=<?= $app->script_v ?>"></script>
<script src="<?= base_url('assets/js/frontend/ose.js') ?>?v=<?= $app->script_v ?>" async></script>
<script defer>
    $(document).ready(function() {
        try {
            setPage(
                <?=$app_id?>,
                { 
                    stage: <?=$stage->stage?>, 
                    status: <?=$stage->status?>,
                    isFinish: '<?=$isFinish?>', 
                },
                [<?=implode(",",$assign)?>]
            );
        } catch(error){
            window.location.reload();
        }
    });
</script>