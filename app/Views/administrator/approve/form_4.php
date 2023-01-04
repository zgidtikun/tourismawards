<div class="regis-form-data-row">
  <div class="regis-form-data-col1">
    <h3>
      <picture>
        <source srcset="<?= base_url() ?>/assets/images/formicon-type.svg">
        <img src="<?= base_url() ?>/assets/images/formicon-type.png">
      </picture> คุณสมบัติเบื้องต้นของผลงานที่ส่งเข้าประกวด
    </h3>
  </div>

  <div class="regis-form-data-col2">
    <h4>เปิดให้บริการหรือดำเนินการตั้งแต่ พ.ศ.<span class="required">*</span></h4>
    <input value="<?= $result->year_open ?>" readonly>
  </div>

  <div class="regis-form-data-col2">
    <h4>ระยะเวลารวมทั้งสิ้น</h4>
    <input value="<?= $result->year_total ?>" readonly>
  </div>

  <div class="regis-form-data-col1">
    <h4>เลขที่ใบอนุญาตประกอบธุรกิจ<span class="required">*</span></h4>
    <input value="<?= $result->buss_license ?>" readonly>
  </div>

  <div class="bs-row">
    <h4>แนบเอกสาร</h4>
    <hr>
    <div class="bs-row row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12 mb-4">
        <span class="fs-18 fw-semibold">
          ต้องมีใบอนุญาตประกอบธุรกิจนำเที่ยวไม่น้อยกว่า 2 ปี จนถึงวันปิดรับสมัคร
          <span class="required">*</span>
        </span>
        <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
          <div class="card-body selecter-file">
            <h4>เอกสาร</h4>
            <?php
            if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
              foreach (json_decode($result->pack_file) as $key => $value) {
                if ($value->file_position == 'guideCertFiles') {
            ?>
                  <div class="card card-body">
                    <div class="bs-row">
                      <div class="col-12"> <span class="fs-file-name"><?= $value->file_original ?> (<?= $value->file_size ?> Mb)</span>
                        <a href="<?= base_url() . '/' . $value->file_path ?>" class="float-end pointer" title="โหลดไฟล์" target="_blank"><i class="bi bi-download"></i></a>
                      </div>
                    </div>
                  </div>
            <?php
                }
              }
            } else {
              echo '<h5 class="text-danger"><i>ไม่ได้แนบเอกสาร</i></h5>';
            }
            ?>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12 mb-4">
        <span class="fs-18 fw-semibold">
          มีใบอนุญาตประกอบธุรกิจนำเที่ยวจากกรมการท่องเที่ยว ในกรณีที่ใบอนุญาตหมดอายุ หรืออยู่ระหว่างการยื่นเอกสารขอต่ออายุ
          ให้แสดงหลักฐานการยื่นขอต่ออายุจากกรมการท่องเที่ยว หรือสำนักงานทะเบียนจังหวัดที่สถานประกอบการนั้นตั้งอยู่
          <span class="required">*</span>
        </span>
        <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
          <div class="card-body selecter-file">
            <h4>เอกสาร</h4>
            <?php
            if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
              foreach (json_decode($result->pack_file) as $key => $value) {
                if ($value->file_position == 'guideOldCertFiles') {
            ?>
                  <div class="card card-body">
                    <div class="bs-row">
                      <div class="col-12"> <span class="fs-file-name"><?= $value->file_original ?> (<?= $value->file_size ?> Mb)</span>
                        <a href="<?= base_url() . '/' . $value->file_path ?>" class="float-end pointer" title="โหลดไฟล์" target="_blank"><i class="bi bi-download"></i></a>
                      </div>
                    </div>
                  </div>
            <?php
                }
              }
            } else {
              echo '<h5 class="text-danger"><i>ไม่ได้แนบเอกสาร</i></h5>';
            }
            ?>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12 mb-4">
        <span class="fs-18 fw-semibold">
          หลักฐานการถือครองที่ดินที่กฎหมายรับรอง สัญญาเช่า หรือหนังสือยินยอม
          ให้ใช้สถานที่ หรือมีเอกสารที่ได้รับอนุญาตให้ใช้พื้นที่จากทางราชการ
          <span class="required">*</span>
        </span>
        <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
          <div class="card-body selecter-file">
            <h4>เอกสาร</h4>
            <?php
            if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
              foreach (json_decode($result->pack_file) as $key => $value) {
                if ($value->file_position == 'titleDeedT4Files') {
            ?>
                  <div class="card card-body">
                    <div class="bs-row">
                      <div class="col-12"> <span class="fs-file-name"><?= $value->file_original ?> (<?= $value->file_size ?> Mb)</span>
                        <a href="<?= base_url() . '/' . $value->file_path ?>" class="float-end pointer" title="โหลดไฟล์" target="_blank"><i class="bi bi-download"></i></a>
                      </div>
                    </div>
                  </div>
            <?php
                }
              }
            } else {
              echo '<h5 class="text-danger"><i>ไม่ได้แนบเอกสาร</i></h5>';
            }
            ?>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12 mb-4">
        <span class="fs-18 fw-semibold">
          สำเนาใบประกอบธุรกิจที่ถูกต้องตามกฎหมาย (ถ้ามี) (แนบเอกสาร)
          สำเนาใบรับรองมาตรฐาน หรือประกาศนียบัตรจากการท่องเที่ยวแห่งประเทศไทย
          กรมการท่องเที่ยว องค์การบริหารการพัฒนาพื้นที่พิเศษเพื่อการท่องเที่ยวอย่างยั่งยืน (องค์การมหาชน) ฯลฯ (ถ้ามี)

        </span>
        <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
          <div class="card-body selecter-file">
            <h4>เอกสาร</h4>
            <?php
            if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
              foreach (json_decode($result->pack_file) as $key => $value) {
                if ($value->file_position == 'otherT4CertFiles') {
            ?>
                  <div class="card card-body">
                    <div class="bs-row">
                      <div class="col-12"> <span class="fs-file-name"><?= $value->file_original ?> (<?= $value->file_size ?> Mb)</span>
                        <a href="<?= base_url() . '/' . $value->file_path ?>" class="float-end pointer" title="โหลดไฟล์" target="_blank"><i class="bi bi-download"></i></a>
                      </div>
                    </div>
                  </div>
            <?php
                }
              }
            } else {
              echo '<h5 class="text-danger"><i>ไม่ได้แนบเอกสาร</i></h5>';
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>