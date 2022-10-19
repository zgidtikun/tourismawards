<div class="container">
    <div class="row">
        <div class="col12">

            <div class="form-main-title">
                <div class="form-main-title-txt">
                    ประเมินรอบขั้นต้น (Pre-screen)
                </div>
                <div class="form-main-btn">
                    <button style="width: 250px;" disabled class="btn btn-confirm-submit fw-semibold">
                        ส่งคำขอข้อมูลทั้งหมด
                    </button>
                    <button style="width: 250px;" disabled class="btn btn-confirm-submit fw-semibold">
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
                                รหัสใบสมัคร : <span class="fw-normal" id="tyCode">xxxx</span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2"">
                            <span class="fw-semibold text-base-main">
                            ประเภท : <span class="fw-normal" id="tyType">xxxx</span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2"">
                            <span class="fw-semibold text-base-main">
                            ชื่อ-นามสกุล : <span class="fw-normal" id="tyName">xxxx</span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2"">
                            <span class="fw-semibold text-base-main">
                            ชื่อสถานประกอบการ : <span class="fw-normal" id="tyAttnTh">xxxx</span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2"">
                            <span class="fw-semibold text-base-main">
                            สาขา : <span class="fw-normal" id="tyTSbu">xxxx</span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2"">
                            <span class="fw-semibold text-base-main">
                            อีเมล : <span class="fw-normal" id="tyEmail">xxxx</span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2"">
                            <span class="fw-semibold text-base-main">
                            Establishment : <span class="fw-normal" id="tyAttnEn">xxxx</span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2"">
                            <span class="fw-semibold text-base-main">
                            วันที่ส่งใบสมัคร : <span class="fw-normal" id="tyUdat">xxxx</span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2"">
                            <span class="fw-semibold text-base-main">
                            เบอร์ติดต่อ : <span class="fw-normal" id="tyTel">xxxx</span>
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
                        2. Suporting Business & Marketing Factors
                    </a>
                    <a href="javascript:setQuestion(2,0);" id="tab-2" class="btn-form-step">
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

                        <div class="regis-form-data-col1 none-estimate" style="display: none;">
                            <h4 id="hSubject"></h4>
                            <div class="alert alert-danger" role="alert">
                                <span style="font-size: 18px;" class="fw-semibold">
                                    <i class="bi bi-exclamation-diamond-fill mr-2"></i>
                                    ไม่มีการประเมินในรอบ Pre-screen
                                </span>
                            </div>
                        </div>

                        <div class="regis-form-data-col1 is-estimate">
                            <h4 id="qSubject"></h4>
                            คำตอบ
                            <textarea class="form-control" id="qReply" rows="12" readonly>
                            </textarea>
                        </div>

                        <div class="regis-form-data-col2 attachfile is-estimate">
                            <div class="attachinp">
                                <h4>รูปภาพ</h4>
                                <div class="ablumbox" id="qAblum">
                                </div>
                            </div>
                        </div>

                        <div class="regis-form-data-col2 attachfile is-estimate">
                            <div class="attachinp">
                                <h4>แนบไฟล์</h4>
                                <a href="javascript:downloadFile();" class="btn-download">ดาวน์โหลดไฟล์แนบ</a>
                            </div>
                            <div class="attachinp border-0">
                                <a href="javascript:void(0)" class="btn-getdata active" data-tab="2">
                                    ขอข้อมูลเพิ่มเติม
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="regis-form-data judge-form-data is-estimate">
                    <div class="regis-form-data-row">
                        <div class="regis-form-data-col1 title">
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

                        <div class="regis-form-data-col1" id="qSco">
                        </div>

                        <div class="regis-form-data-col1">
                            <span class="fw-semibold">ความคิดเห็นของกรรมการ</span>
                            <span class="text-muted">(จำนวนตัวอักษรคงเหลือ <span id="charNum">1,000</span>/1,000)</span>
                            <textarea class="form-control" rows="6" id="comment" onkeyup="countChar(this)"></textarea>
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

                    </div>
                </div>

                <div class="regis-form-data is-estimate">
                    <div class="regis-form-data-row">
                        <div class="regis-form-data-col2 clear">
                            <button class="btn btn-danger" onclick="resetEstimate(pointer.cate,pointer.seg)">
                                ล้างข้อมูลการให้คะแนน
                            </button>
                        </div>
                        <div class="regis-form-data-col2 continue">
                            <button class="btn-next" id="btn-back">ย้อนกลับ</button>
                            <button class="btn-next" id="btn-next">ถัดไป</button>
                            <button class="btn-save" id="btn-save">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="judge-memo is-estimate">
                <h4>บันทึกส่วนตัว (Private Memo)</h4>
                <textarea class="form-control" id="note" rows="6"></textarea>
                <p style="text-align: right"><a href="javascript:void(0)" class="btn-memosave" data-tab="3">บันทึก</a></p>
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
                <div class="bs-row choicebox">
                    <div class="col-sm-12 col-md-4 text-sm-center mb-sm-3">
                        <span class="text-base-main fw-semibold">
                            <i class="bi bi-bookmark-fill"></i>
                            ข้อมูลเพิ่มเติมข้อที่ <span id="mTNum"></span>
                        </span>
                    </div>
                    <div class="col-sm-12 col-md-8 text-sm-center text-end">
                        <!-- <span class="mr-3">คำถามข้อที่ <span id="mNum" class="fs-20"></span></span> -->
                        <!-- <select style="width: 70px; height: 40px;">
                            <option value="1">1</option>
                        </select> -->
                        <span class="">ทั้งหมด <span id="mSum"></span> ข้อ </span>                  
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
                <textarea rows="9" id="field1" onkeyup="countChar1(this)"></textarea>
                <script>
                    function countChar1(val) {
                        var len = val.value.length;
                        if (len >= 1000) {
                            val.value = val.value.substring(0, 1000);
                        } else {
                            $('#charNum1').text(1000 - len);
                        }
                    };
                </script>
            </div>
            <div class="modal-footer border-0" style="display: block;">
                <button class="btn btn-sm btn-confirm-submit float-start" disabled>
                    ส่งคำขอข้อมูลทั้งหมด
                </button>
                <button type="button" style="width: 80px !important;" 
                class="btn btn-sm btn-action float-end" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" style="width: 80px !important;" 
                class="btn btn-sm btn-main float-end">
                    บันทึก
                </button>
            </div>
        </div>
    </div>
</div>
<div class="loading" id="loading-page"></div>

<?php $app = new \Config\App(); ?>
<script src="<?= base_url('assets/js/frontend/bootstrap/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/js/frontend/psce.js') ?>?v=<?= $app->script_v ?>" async></script>
<script defer>
    $(document).ready(function() {
        setPage(<?=$app_id?>);
    });

    $('.btn-getdata').click(function() {
        $('#modal-add-paper').modal('show');
    });

    const zoomImages = (el) => {
        $("#img-modal").attr('src', el.src);
        $("#images-modal").show();
    }
</script>