<div class="container">
    <div class="row">
        <div class="col12">
            <div class="formmainbox">
                <div class="title">
                    <div class="title-txt">
                        สถิติการประเมิน
                    </div>
                </div>

                <div class="estimatestatus">
                    <div class="bs-row">
                        <div class="col-sm-12 col-md-3 mb-3">
                            <div class="estimatestatus-subrow pre_wait">
                                <div class="estimat-title" data-tab="1">
                                    <i class="bi bi-file-earmark-text"></i>
                                    รอบ Pre-screen<br>ที่รอประเมิน
                                </div>
                                <div class="estimat-amount" id="count-tab1">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-3 mb-3">
                            <div class="estimatestatus-subrow pre_eastimate">
                                <div class="estimat-title" data-tab="2">
                                    <i class="bi bi-file-earmark-text"></i>
                                    รอบ Pre-screen<br>ที่ประเมินแล้ว
                                </div>
                                <div class="estimat-amount" id="count-tab2">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-3 mb-3">
                            <div class="estimatestatus-subrow local_wait">
                                <div class="estimat-title" data-tab="3">
                                    <i class="bi bi-geo-alt"></i>
                                    รอบลงพื้นที่<br>ที่รอประเมิน
                                </div>
                                <div class="estimat-amount" id="count-tab3">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-3">
                            <div class="estimatestatus-subrow local_eastimate">
                                <div class="estimat-title" data-tab="4">
                                    <i class="bi bi-geo-alt"></i>
                                    รอบลงพื้นที่<br>ที่ประเมินแล้ว
                                </div>
                                <div class="estimat-amount" id="count-tab4">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        jQuery(document).ready(function() {
                            var formstepdate = $('.estimat-title').length;
                            var formsteptab = [];
                            for (var i = 1; i <= formstepdate;) {
                                formsteptab[i] = $('.estimat-title[data-tab="' + i + '"]').height();
                                i++
                            }
                            var formstepdate = formsteptab.reduce(function(a, b) {
                                return Math.max(a, b);
                            });
                            $('.estimat-title').css({
                                "height": formstepdate
                            });

                        });
                    </script>
                </div>
            </div>

            <div class="formmainbox">
                <div class="dashboard-tab">
                    <div class="dashboard-tab-row">
                        <div class="dashboard-tab-col">
                            <a href="javascript:void(0)" id="tab1" class="btn-dashboard active" data-tab="1">รอบ Pre-screen ที่รอประเมิน</a>
                        </div>
                        <div class="dashboard-tab-col">
                            <a href="javascript:void(0)" id="tab2" class="btn-dashboard" data-tab="2">รอบ Pre-screen ที่ประเมินแล้ว</a>
                        </div>
                        <div class="dashboard-tab-col">
                            <a href="javascript:void(0)" id="tab3" class="btn-dashboard" data-tab="3">รอบลงพื้นที่ที่รอประเมิน</a>
                        </div>
                        <div class="dashboard-tab-col">
                            <a href="javascript:void(0)" id="tab4" class="btn-dashboard" data-tab="4">รอบลงพื้นที่ที่ประเมินแล้ว</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="formmainbox">
                <div class="dashboard-box" data-tab="1">

                    <div class="bs-row mt-4">
                        <div class="col-sm-12 col-md-12 fs-title text-base-main fw-semibold border-bottom mb-3">
                            รายการ รอบ Pre-screen ที่รอประเมิน
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2">
                            <div class="form-floating">
                                <select class="form-select" id="sat-main" col-num="2" disabled>
                                    <option value="" selected>ทั้งหมด</option>
                                </select>
                                <label>กรองด้วย ประเภท</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2">
                            <div class="form-floating">
                                <select class="form-select" id="sat-sub" col-num="3" disabled>
                                    <option value="" selected>ทั้งหมด</option>
                                </select>
                                <label>กรองด้วย สาขา</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="sip" placeholder="ค้นหารายชื่อ" disabled>
                                <label>ค้นหารายชื่อ</label>
                            </div>
                        </div>
                    </div>
                    <table class="table boards" id="tbl-boards">
                        <thead style="border-radius: 6px;">
                            <tr>
                                <th class="no">ลำดับ</th>
                                <th class="landmark">ชื่อแหล่งท่องเที่ยว</th>
                                <th class="type">ประเภทแหล่งท่องเที่ยว</th>
                                <th class="section">สาขาที่ประกวด</th>
                                <th class="status">สถานะ</th>
                                <th class="date">วันที่ประเมินล่าสุด</th>
                                <th class="edit">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="" id="loading-page"></div>
<!-- Modal -->
<div class="modal fade" id="modal-detail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title text-base-main fw-semibold">
                    <i class="bi bi-geo-alt-fill mr-2"></i>
                    <span id="modal-plate"></span>
                </span>
            </div>
            <div class="modal-body" style="font-size: 16px;">
                <div class="bs-row">
                    <div class="col-12 text-base-main fw-semibold">ประเภทแหล่งท่องเที่ยว</div>
                    <div class="col-12 mb-2" id="modal-appt"></div>
                    <div class="col-12 text-base-main fw-semibold">สาขาที่ประกวด</div>
                    <div class="col-12 mb-2" id="modal-appts"></div>
                    <div class="col-12 text-base-main fw-semibold mb-2">
                        สถานะ <span id="modal-badge" class="badge ml-1"></span>
                    </div>
                    <div class="col-12 text-base-main fw-semibold">วันที่ประเมินล่าสุด</div>
                    <div class="col-12 mb-4" id="modal-date"></div>
                    <div class="col-12">
                        <button type="button" class="btn btn-sm btn-success" id="btn-score"
                        onclick="boards.score('md')">
                            <i class="bi bi-toggles"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-warning" id="btn-estimate">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle mr-2"></i>ออก
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-score" data-bs-backdrop="static" data-bs-keyboard="false" 
tabindex="-1" aria-labelledby="modal-score-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <span class="modal-title text-base-main fw-semibold" id="modal-score-label">
                    สรุปผลการประเมิน
                </span>
                <button type="button" class="btn-close"
                onclick="boards.closeScore()"></button>
            </div>
            <div class="modal-body">
                <table class="table boards" style="font-size: 14px;">
                    <thead class="align-middle">
                        <tr>
                            <th class="text-center" width="33.34%">คะแนนรวม<br>(Pre-screen)</th>
                            <th class="text-center" width="33.34%">คะแนนรวม<br>(รอบลงพื้นที่)</th>
                            <th class="text-center" width="33.34%">คะแนนรวมทั้งหมด</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center" id="td-spre">1.00</td>
                            <td class="text-center" id="td-sons">5.00</td>
                            <td class="text-center fw-semibold" id="td-stt">6.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $app = new \Config\App(); ?>
<script src="<?= base_url('assets/DataTables/datatables.js') ?>?v=<?= $app->script_v ?>"></script>
<script src="<?= base_url('assets/js/frontend/boards.js') ?>?v=<?= $app->script_v ?>"></script>
<script src="<?= base_url('assets/js/frontend/bootstrap/bootstrap.bundle.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        boards.init();
        
        $('#sip, #sat-main, #sat-sub').on('keyup change', function() {
            boards.searchAll();
        });
    });
</script>