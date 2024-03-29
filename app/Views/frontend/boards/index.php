<style>
  .dataTables_wrapper .dataTables_paginate .paginate_button {
    width: auto !important;
  }
  
  .score {
    top: 0;
    font-size: 18px;
    font-weight: 600;
  }

  .header-score {
    font-size: 14px;
    font-weight: 400;
  }

  .body-score {
    color: #6c757d;
    font-size: 14px;
    font-weight: 400;
  }

  #modal-detail .badge {
    display: inline-block !important;
  }
</style>
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
          <section class="slider estimateslide estimatestatus-row">

            <div class="estimatestatus-col">
              <div class="estimatestatus-subrow pre_wait">
                <div class="estimat-title" data-tab="1">
                  <i class="bi bi-file-earmark-text"></i>
                  รอบ Pre-screen<br />
                  ที่รอประเมิน
                </div>
                <div class="estimat-amount" id="count-tab1">
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </div>
              </div>
            </div>

            <div class="estimatestatus-col">
              <div class="estimatestatus-subrow pre_eastimate">
                <div class="estimat-title" data-tab="2">
                  <i class="bi bi-file-earmark-text"></i>
                  รอบ Pre-screen<br />
                  ที่ประเมินแล้ว
                </div>
                <div class="estimat-amount" id="count-tab2">
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </div>
              </div>
            </div>

            <div class="estimatestatus-col">
              <div class="estimatestatus-subrow local_wait">
                <div class="estimat-title" data-tab="3">
                  <i class="bi bi-geo-alt"></i>
                  รอบลงพื้นที่<br />
                  ที่รอประเมิน
                </div>
                <div class="estimat-amount" id="count-tab3">
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </div>
              </div>
            </div>

            <div class="estimatestatus-col">
              <div class="estimatestatus-subrow local_eastimate">
                <div class="estimat-title" data-tab="4">
                  <i class="bi bi-geo-alt"></i>
                  รอบลงพื้นที่<br />
                  ที่ประเมินแล้ว
                </div>
                <div class="estimat-amount" id="count-tab4">
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </div>
              </div>
            </div>

          </section>

        </div>

        <script>
          jQuery(document).ready(function () {
            var formstepdate = $(".estimat-title").length;
            var formsteptab = [];

            for (var i = 1; i <= formstepdate; i++) {
              formsteptab[i] = $('.estimat-title[data-tab="' + i + '"]').height();
            }

            var formstepdate = formsteptab.reduce(function (a, b) { 
              return Math.max(a, b);
            });

            $(".estimat-title").css({
              height: formstepdate,
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
              <input type="text" class="form-control" id="sip" placeholder="ค้นหารายชื่อ" disabled />
              <label>ค้นหารายชื่อ</label>
            </div>
          </div>
        </div>
        <table class="display boards" id="tbl-boards" style="width: 100%;">
          <thead>
            <tr>
              <th class="text-center">ลำดับ</th>
              <th class="text-center">ชื่อแหล่งท่องเที่ยว</th>
              <th class="text-center">ประเภทแหล่งท่องเที่ยว</th>
              <th class="text-center">สาขาที่ประกวด</th>
              <th class="text-center">สถานะ</th>
              <th class="text-center">วันที่ประเมินล่าสุด</th>
              <th class="text-center">จัดการ</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
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
      <div class="modal-body">
        <div class="bs-row">
          <div class="col-12 text-base-main fw-semibold">ประเภทแหล่งท่องเที่ยว</div>
          <div class="col-12 mb-2" id="modal-appt"></div>
          <div class="col-12 text-base-main fw-semibold">สาขาที่ประกวด</div>
          <div class="col-12 mb-2" id="modal-appts"></div>
          <div class="col-12 text-base-main fw-semibold mb-2">สถานะ <span id="modal-badge" class="badge ml-1"></span></div>
          <div class="col-12 text-base-main fw-semibold">วันที่ประเมินล่าสุด</div>
          <div class="col-12 mb-4" id="modal-date"></div>
          <div class="col-12 editbtn">
            <button type="button" class="btn btn-sm btn-success" id="btn-score" onclick="score('md')">
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
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <span class="modal-title text-base-main fw-semibold" id="modal-score-label">
          ผลการประเมิน
        </span>
        <button type="button" class="btn-close" onclick="closeScore()"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive-sm">
          <table class="table boards" id="score" width="100%">
            <thead class="align-middle">
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $app = new \Config\App();?>
<script src="<?=base_url('assets/js/frontend/boards.js')?>?v=<?=$app->script_v?>"></script>
<script src="<?=base_url('assets/js/frontend/bootstrap/bootstrap.bundle.min.js')?>"></script>
<script>
  $(document).ready(function () {
    init();

    $("#sip, #sat-main, #sat-sub").on("keyup change", function () {
      searchAll();
    });
  });
</script>

<!-- DataTable -->
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets/js/dataTables.responsive.min.js')?>"></script>
<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="<?=base_url('assets/css/site.css')?>" />
<link rel="stylesheet" href="<?=base_url('assets/css/responsive.dataTables.min.css')?>" />

<!-- Slick -->
<script src="<?=base_url('assets/js/slick.js')?>"></script>
<link rel="stylesheet" href="<?=base_url('assets/css/slick.css')?>" />
<link rel="stylesheet" href="<?=base_url('assets/css/slick-theme.css')?>" />

<script type="text/javascript">
  jQuery(document).ready(function( $ ) {
    var screen_w = $(window).width();

    if(screen_w > 767){
      $(".estimateslide").css("display", "flex");
    }else if(screen_w <= 767){
      $(".estimateslide").css("display", "block");
        $(".estimateslide").slick({
          dots: true,
          infinite: false,
          arrows:false,
          slidesToShow: 1,
          slidesToScroll: 1,
          autoplay: false,
      });
    }
  });
</script>