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
    <span class="fs-18 fw-semibold">แนบเอกสาร</h4>
      <hr>
      <div class="bs-row row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
          <span class="fs-18 fw-semibold">
            ใบอนุญาตประกอบการธุรกิจโรงแรม (ตาม พ.ร.บ. โรงแรม ปี พ.ศ. 2547) เป็นระยะเวลาไม่ต่ำกว่า 1 ปี นับถึงวันปิดรับสมัคร<span class="required">*</span>
          </span>
          <div class="card" style="border: 1px solid #E5E6ED;">
            <div class="card-body selecter-file">
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
              }
              ?>

            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
          <div class="regis-form-data-col1">
            <h4>ต้องมีชื่อโรงแรมและจำนวนห้องพักตรงกับที่ระบุในใบอนุญาต <span class="required">*</span></h4>
            <p>
              <input type="radio" id="buss_ckroom_1" value="1" <?= ($result->buss_ckroom == 1) ? 'checked' : ''; ?>>
              <label for="buss_ckroom_1">ตรง</label>
            </p>
            <p>
              <input type="radio" id="buss_ckroom_0" value="0" <?= ($result->buss_ckroom == 0) ? 'checked' : ''; ?>>
              <label for="buss_ckroom_0">ไม่ตรง</label>
            </p>
          </div>
        </div>
      </div>
      <div class="bs-row row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
          <span class="fs-18 fw-semibold">สำเนาหนังสือให้ความเห็นชอบต่อรายงานการประเมินผลกระทบสิ่งแวดล้อม (EIA) ในกรณีที่มีจำนวนห้องพักตั้งแต่ 80 ห้องขึ้นไปหรือมีพื้นที่ใช้สอยตั้งแต่ 4,000 ตารางเมตรขึ้นไป หรือสำเนาหนังสือให้ความเห็นชอบต่อรายงานการประเมินผลกระทบสิ่งแวดล้อมเบื้องต้น (IEE)ในกรณีที่มีจำนวนห้องพักหรือพื้นที่ใช้สอยต่ำกว่าและอยู่ในพื้นที่ที่กฎหมายกำหนด
            <span class="required">*</span>
          </span>
          <div class="card" style="border: 1px solid #E5E6ED;">
            <div class="card-body selecter-file">
              <h4>เอกสาร</h4>
              <?php
              if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                foreach (json_decode($result->pack_file) as $key => $value) {
                  if ($value->file_position == 'EIAreportFiles') {
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
              }
              ?>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-4">
          <div class="regis-form-data-col1">
            <h4>กรณีมีส่วนต่อขยายของอาคารจะต้องแสดงรายงานการประเมินผลกระทบสิ่งแวดล้อมที่สอดคล้องกัน <span class="required">*</span></h4>
            <p>
              <input type="radio" id="buss_build_ext_1" value="1" <?= ($result->buss_buildExt == 1) ? 'checked' : ''; ?>>
              <label for="buss_build_ext_1">มี (กรณีที่เลือก ต้องแนบเอกสารการประเมินผลกระทบสิ่งแวดล้อมที่สอดคล้องกัน)</label>
            </p>
            <p>
              <input type="radio" id="buss_build_ext_0" value="0" <?= ($result->buss_buildExt == 0) ? 'checked' : ''; ?>>
              <label for="buss_build_ext_0">ไม่มี</label>
            </p>
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
              <h4>เอกสาร</h4>
              <?php
              if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                foreach (json_decode($result->pack_file) as $key => $value) {
                  if ($value->file_position == 'otherT2CertFiles') {
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
              }
              ?>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>