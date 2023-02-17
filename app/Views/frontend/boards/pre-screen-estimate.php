<style>
    #qReply {
        font-size: 20px;
    }
    #qEva {
        font-size: 20px;
        font-weight: normal;
        color: #000;
    }
    #qSco h4 {
        font-size: 20px;
        color: #1b510a;
    }
    #qSco p {
        font-size: 20px;
    }
    .regis-form-data-col1 ol {
        padding-left: 25px;
        font-size: 20px;
        font-weight: normal;
        color: #000;
    }
    .regis-form-data-col1 div#qRemark ol {
        margin-top: 0;
        padding-left: 40px;
        color: #000;
    }
    h4#qSubject {
        font-size: 20px;
    }
    .regis-form-data-col1 h4#qSubject ol {
        font-size: 20px;
        padding: 0;
        padding-left: 40px;
        color: #000;
    }
    .regis-form-data-col1 h4 {
        margin-bottom: 1rem;
    }
    #sRequest {
        margin-top: 0.5rem;
        padding-top: 10px;
        padding-bottom: 10px;
        text-align: center;
    }
</style>
<?php 
    helper('main');
    $config = new \Config\App(); 
    $appCurrentDate = date('Y-m-d');
    $expireRequest = $config->Estimate_require_date;
    $expireRequestStr = FormatTree($expireRequest,'thailand');
    $showRequest = $appCurrentDate <= $expireRequest ? true : false;
?>
<div class="container">
    <div class="row">
        <div class="col12">

            <div class="form-main-title">
                <div class="form-main-title-txt">
                    ประเมินรอบขั้นต้น (Pre-screen)
                </div>
                <div class="form-main-btn">
                    <button style="width: 100px;" class="btn btn-back fw-semibold"
                    onclick="window.open('<?=base_url('boards')?>','_self')">
                        ย้อนกลับ
                    </button>
                    <?php if($showRequest): ?>
                    <button style="width: 250px;" disabled class="btn btn-confirm-submit fw-semibold"
                    id="btn-send-request" onclick="setRequest()">
                        ส่งคำขอข้อมูลทั้งหมด
                    </button>
                    <?php endif; ?>
                    <button style="width: 250px;" disabled class="btn btn-confirm-submit fw-semibold"
                    id="btn-send-estimate" onclick="setFinish()">
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
                            <span class="fw-semibold text-dark">
                            รหัสใบสมัคร : <span class="fw-normal text-dark" id="tyCode"></span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2">
                            <span class="fw-semibold text-dark">
                            ประเภท : <span class="fw-normal text-dark" id="tyType"></span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2">
                            <span class="fw-semibold  text-dark">
                            ชื่อ-นามสกุล : <span class="fw-normal text-dark" id="tyName"></span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2">
                            <span class="fw-semibold text-dark">
                            ชื่อสถานประกอบการ : <span class="fw-normal text-dark" id="tyAttnTh"></span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2">
                            <span class="fw-semibold text-dark">
                            สาขา : <span class="fw-normal text-dark" id="tyTSbu"></span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2">
                            <span class="fw-semibold text-dark">
                            อีเมล : <span class="fw-normal text-dark" id="tyEmail"></span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2">
                            <span class="fw-semibold text-dark">
                            ชื่อสถานประกอบการภาษาอังกฤษ : <span class="fw-normal text-dark" id="tyAttnEn"></span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2">
                            <span class="fw-semibold text-dark">
                            วันที่ส่งใบสมัคร : <span class="fw-normal text-dark" id="tyUdat"></span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2">
                            <span class="fw-semibold text-dark">
                            เบอร์ติดต่อ : <span class="fw-normal text-dark" id="tyTel"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col12">

            <div class="formmainbox">
                <div class="regis-form-step">
                    <a href="javascript:setQuestion(0,0);" id="tab-0" class="btn-form-step active">
                        1. Tourism Excellence
                    </a>
                    <a href="javascript:setQuestion(1,0);" id="tab-1" class="btn-form-step">
                        2. Supporting Business & Marketing Factors
                    </a>
                    <a href="javascript:setQuestion(2,0);" id="tab-2" class="btn-form-step">
                        3. Responsibility and Safety & Health
                    </a>
                    <a href="javascript:setQuestion(3,0);" id="tab-3" class="btn-form-step"
                    style="display:none;">
                        4. Low Carbon
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
                            คำตอบ
                            <textarea class="form-control" id="qReply" rows="12" readonly>
                            </textarea>
                            <div id="qRemark" class="alert alert-info fs-18 mt-3" role="alert"></div>
                        </div>

                        <div class="regis-form-data-col2 attachfile">
                            <div class="attachinp">
                                <h4>รูปภาพ</h4>
                                <div class="ablumbox" id="qAblum">
                                </div>
                            </div>
                        </div>

                        <div class="regis-form-data-col2 attachfile">
                            <div class="attachinp">
                                <h4>แนบไฟล์</h4>
                                <!-- <a href="javascript:downloadFile();" class="btn-download">ดาวน์โหลดไฟล์แนบ</a> -->
                                <a href="javascript:;" class="btn-download btn-transparent disabled"
                                style="color:#000;opacity:1;">
                                    ไม่มีไฟล์แนบ
                                </a>
                                <div id="list-download">
                                </div>
                            </div>

                            <div class="attachinp border-0 is-estimate">
                                <?php if($showRequest): ?>
                                <a href="javascript:void(0)" class="btn-getdata active">
                                    ขอข้อมูลเพิ่มเติม
                                </a>
                                <div id="sRequest" class="alert alert-warning" style="display: none;" role="alert">
                                    คุณมีการขอข้อมูลเพิ่มเติม
                                </div>
                                <?php endif; ?>
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
                                    ไม่มีการประเมินในรอบขั้นต้น Pre-screen
                                </span>
                            </div>
                        </div>

                        <div class="regis-form-data-col1 none-assign" style="display: none;">
                            <div class="alert alert-danger" role="alert">
                                <span style="font-size: 18px;" class="fw-semibold">
                                    <i class="bi bi-exclamation-diamond-fill mr-2"></i>
                                    คุณไม่ได้รับมอบหมายให้ประเมินในด้านนี้
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
                        </div>

                        <div class="regis-form-data-col1 is-estimate" id="qSco">
                        </div>

                        <div class="regis-form-data-col1 is-estimate">
                            <span class="fw-semibold text-base-main">ความคิดเห็นของกรรมการ</span>
                            <span class="text-muted">(จำนวนตัวอักษรคงเหลือ <span id="charNum">1,000</span>/1,000)</span>
                            <textarea class="form-control" rows="6" id="comment" 
                            onkeyup="countChar($('#comment'))"></textarea>
                            <script>
                                function countChar(inp) {
                                    const str = inp.val();
                                    const len = str.replace(/\r/g,'').length;

                                    if (len >= 1000) {
                                        $('#charNum').text('0');
                                        inp.val(inp.val().substring(0, 1000));
                                    } else {
                                        $('#charNum').text((1000 - len).toLocaleString("en"));
                                    }
                                };
                            </script>
                        </div>

                    </div>
                </div>

                <div class="regis-form-data">
                    <div class="regis-form-data-row">
                        <div class="regis-form-data-col2 clear">
                            <button class="btn btn-danger is-estimate" onclick="resetEstimate(pointer.cate,pointer.seg)"
                            id="btn-reset">
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
                <h4 class="text-base-main">บันทึกส่วนตัว (Private Memo)</h4>
                <textarea class="form-control" id="note" rows="6"></textarea>
                <p style="text-align: right">
                    <a href="javascript:void(0)" class="btn-memosave">บันทึก</a>
                </p>
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

<div class="modal fade border-0" id="modal-add-paper" tabindex="-1"
aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0 mb-0">
                <div class="bs-row choicebox w-100" style="max-width: none;">
                    <div class="col-sm-12 col-md-4 text-sm-center mb-sm-3">
                        <span style="font-size: 20px;" class="text-base-main fw-semibold">
                            <i class="bi bi-bookmark-fill"></i>
                            ข้อมูลเพิ่มเติมข้อที่ <span id="mTNum"></span>
                        </span>
                    </div>
                    <div class="col-sm-12 col-md-8 text-sm-center text-end">
                        <span class="mr-3">คำถามข้อที่ <span id="mNum" class="fs-20"></span></span>
                        <select id="mSelect" style="width: 70px; height: 40px;">
                        </select>
                        <span class="ml-3">ทั้งหมด <span id="mSum"></span> ข้อ </span>                  
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <span class="fw-semibold">
                    ข้อมูลที่ต้องการขอเพิ่มเติม 
                    <span class="fw-normal text-muted">
                        (จำนวนตัวอักษรคงเหลือ <span id="charNum1">1,000</span>/1,000)
                    </span>
                </span>
                <div class="alert alert-warning mt-2" role="alert" id="rq-wait" style="display: none;">
                    <b>รอการตอบกลับจากสถานประกอบการ</b>
                </div>
                <div class="alert alert-danger mt-2" role="alert" id="rq-unfinish" style="display: none;">
                    <b>ไม่มีการตอบกลับจากสถานประกอบการ</b>
                </div>
                <div class="alert alert-success mt-2" role="alert" id="rq-finish" style="display: none;">
                    <b>สถานประกอบการตอบกลับแล้ว</b>
                </div>
                <div class="alert alert-warning mt-2" role="alert" id="rq-warning" style="display: none;">
                    <b id="rq-warning-txt"></b>
                </div>
                <textarea rows="9" id="qRequest" onkeyup="countChar1($('#qRequest'))"
                <?php if(!$showRequest){ echo 'readonly="readonly"'; } ?>></textarea>
                <span class="fw-normal text-danger mt-2">หมายเหตุ : สามารถขอข้อมูลเพิ่มเติมได้ถึงวันที่ <?=$expireRequestStr?></span>
                
            </div>
            <div class="modal-footer border-0" style="display: block;">
                <?php if($showRequest): ?>
                <button class="btn btn-sm btn-confirm-submit float-start" disabled
                id="btn-send-request-modal" onclick="setRequest()">
                    ส่งคำขอข้อมูลทั้งหมด
                </button>
                <?php endif; ?>
                <button type="button" style="width: 80px !important;" 
                class="btn btn-sm btn-action float-end" data-bs-dismiss="modal">
                    ยกเลิก
                </button>
                <?php if($showRequest): ?>
                <button type="button" style="width: 80px !important;" 
                class="btn btn-sm btn-main float-end" id="btn-request">
                    บันทึก
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="loading" id="loading-page"></div>

<?php $app = new \Config\App(); ?>
<link  href="<?= base_url('assets/js/frontend/datepicker/jquery-ui.css') ?>?v=<?= $app->script_v ?>" rel="stylesheet">
<script src="<?= base_url('assets/js/frontend/datepicker/jquery-ui.js') ?>?v=<?= $app->script_v ?>"></script>

<script src="<?= base_url('assets/js/frontend/bootstrap/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/js/frontend/psce.js') ?>?v=<?= $app->script_v ?>" async></script>
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
                [<?=implode(",",$assign)?>],
                <?=($showRequest ? 1 : 0)?>
            );
        } catch(error) {
            window.location.reload();
        }
    });

    function countChar1(inp) {
        const str = inp.val();
        const len = str.replace(/\r/g,'').length;
        if (len >= 1000) {
            $('#charNum1').text('0');
            inp.val(inp.val().substring(0, 1000));
        } else {
            $('#charNum1').text((1000 - len).toLocaleString("en"));
        }
    };
</script>