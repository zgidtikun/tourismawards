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
    <h4>แหล่งท่องเที่ยว/กิจกรรมอยู่ในความดูแล</h4>
    <p><input type="radio" name="manage_by" id="manage_by_1" <?= ($result->manage_by == 1) ? 'checked' : ''; ?>><label for="manage_by_1">ภาครัฐ</label></p>
    <p><input type="radio" name="manage_by" id="manage_by_2" <?= ($result->manage_by == 2) ? 'checked' : ''; ?>><label for="manage_by_2">ชุมชนท่องเที่ยว</label></p>
    <p><input type="radio" name="manage_by" id="manage_by_3" <?= ($result->manage_by == 3) ? 'checked' : ''; ?>><label for="manage_by_3">ภาคเอกชน</label></p>
  </div>

  <div class="regis-form-data-col2">
    <h4 class="headertitile" data-tab="1" style="height: 50px;">ใบอนุญาตประกอบการธุรกิจโรงแรม (ตาม พ.ร.บ. โรงแรม ปี พ.ศ. 2547) เป็นระยะเวลาไม่ต่ำกว่า 1 ปี นับถึงวันปิดรับสมัคร</h4>
    <div class="attachinp">
      <h4>เอกสาร</h4>
      <?php
      if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
        foreach (json_decode($result->pack_file) as $key => $value) {
          if ($value->file_position == 'bussLicenseFiles') {
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

  <div class="regis-form-data-col2">
    <h4 class="headertitile" data-tab="2" style="height: 50px;">สำเนาใบประกอบธุรกิจที่ถูกต้องตามกฎหมาย (ถ้ามี)</h4>
    <div class="attachinp">
      <h4>เอกสาร</h4>
      <?php
      if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
        foreach (json_decode($result->pack_file) as $key => $value) {
          if ($value->file_position == 'bussLicenseFiles') {
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

  <div class="regis-form-data-col2">
    <h4>สำเนาใบรับรองมาตรฐาน หรือประกาศนียบัตรจากการท่องเที่ยวแห่งประเทศไทย, กรมการท่องเที่ยว, องค์การบริหารการพัฒนาพื้นที่พิเศษเพื่อการท่องเที่ยวอย่างยั่งยืน (องค์การมหาชน), TAT Academy ฯลฯ (ถ้ามี)</h4>
    <div class="attachinp">
      <h4>เอกสาร</h4>
      <?php
      if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
        foreach (json_decode($result->pack_file) as $key => $value) {
          if ($value->file_position == 'bussLicenseFiles') {
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