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
    <p><input type="radio" name="manage_by" id="manage_by_1" <?= ($result->manage_by == 1 || $result->manage_by == null) ? 'checked' : ''; ?> disabled><label for="manage_by_1">ภาครัฐ</label></p>
    <p><input type="radio" name="manage_by" id="manage_by_2" <?= ($result->manage_by == 2) ? 'checked' : ''; ?> disabled><label for="manage_by_2">ชุมชนท่องเที่ยว</label></p>
    <p><input type="radio" name="manage_by" id="manage_by_3" <?= ($result->manage_by == 3) ? 'checked' : ''; ?> disabled><label for="manage_by_3">ภาคเอกชน</label></p>
  </div>

  <?php if ($result->manage_by == 1 || $result->manage_by == null) : ?>

    <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12 mb-4">
      <span class="fs-18 fw-semibold">หลักฐานการถือครองที่ดินที่กฎหมายรับรอง สัญญาเช่า หรือหนังสือยินยอมให้ใช้สถานที่ <span class="required">*</span></span>
      <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
        <div class="card-body selecter-file">
          <h4>เอกสาร</h4>
          <?php
          if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
            foreach (json_decode($result->pack_file) as $key => $value) {
              if ($value->file_position == 'landOwnerFiles') {
          ?>
                <div class="card card-body">
                  <div class="bs-row">
                    <div class="col-12"> <span class="fs-file-name"><?= $value->file_original ?> (<?= $value->file_size ?> Mb)</span>
                      <a href="<?= base_url() . '/' . $value->file_path ?>" class="float-end pointer" title="โหลดไฟล์" target="_blank"><i class="bi bi-eye"></i></a>
                      <a href="javascript:download_pdf('<?= $value->file_original ?>', '<?= base_url() . '/' . $value->file_path ?>')" class="float-end pointer" title="ดาวน์โหลดไฟล์"><i class="bi bi-download"></i></a>
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

    <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12 mb-4">
      <span class="fs-18 fw-semibold">ใบรับรองมาตรฐาน หรือประกาศนียบัตรจากการท่องเที่ยวแห่ง <span class="required">*</span></span>
      <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
        <div class="card-body selecter-file">
          <h4>เอกสาร</h4>
          <?php
          if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
            foreach (json_decode($result->pack_file) as $key => $value) {
              if ($value->file_position == 'businessCertFiles') {
          ?>
                <div class="card card-body">
                  <div class="bs-row">
                    <div class="col-12"> <span class="fs-file-name"><?= $value->file_original ?> (<?= $value->file_size ?> Mb)</span>
                      <a href="<?= base_url() . '/' . $value->file_path ?>" class="float-end pointer" title="โหลดไฟล์" target="_blank"><i class="bi bi-eye"></i></a>
                      <a href="javascript:download_pdf('<?= $value->file_original ?>', '<?= base_url() . '/' . $value->file_path ?>')" class="float-end pointer" title="ดาวน์โหลดไฟล์"><i class="bi bi-download"></i></a>
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
    </div> -->

    <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12 mb-4">
      <span class="fs-18 fw-semibold">ใบรับรองมาตรฐาน หรือประกาศนียบัตรจากการท่องเที่ยวแห่งประเทศไทย, SHA, กรมการท่องเที่ยว, องค์การบริหารการพัฒนาพื้นที่พิเศษเพื่อการท่องเที่ยวอย่างยั่งยืน (องค์การมหาชน) ฯลฯ (ถ้ามี) <span class="required">*</span></span>
      <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
        <div class="card-body selecter-file">
          <h4>เอกสาร</h4>
          <?php
          if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
            foreach (json_decode($result->pack_file) as $key => $value) {
              if ($value->file_position == 'otherCertFiles') {
          ?>
                <div class="card card-body">
                  <div class="bs-row">
                    <div class="col-12"> <span class="fs-file-name"><?= $value->file_original ?> (<?= $value->file_size ?> Mb)</span>
                      <a href="<?= base_url() . '/' . $value->file_path ?>" class="float-end pointer" title="โหลดไฟล์" target="_blank"><i class="bi bi-eye"></i></a>
                      <a href="javascript:download_pdf('<?= $value->file_original ?>', '<?= base_url() . '/' . $value->file_path ?>')" class="float-end pointer" title="ดาวน์โหลดไฟล์"><i class="bi bi-download"></i></a>
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
  <?php endif; ?>


  <?php if ($result->manage_by == 2) : ?>
    <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12 mb-4">
      <span class="fs-18 fw-semibold">หลักฐานการถือครองที่ดินที่กฎหมายรับรอง สัญญาเช่า หรือหนังสือยินยอมให้ใช้สถานที่ <span class="required">*</span></span>
      <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
        <div class="card-body selecter-file">
          <h4>เอกสาร</h4>
          <?php
          if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
            foreach (json_decode($result->pack_file) as $key => $value) {
              if ($value->file_position == 'landOwnerFiles') {
          ?>
                <div class="card card-body">
                  <div class="bs-row">
                    <div class="col-12"> <span class="fs-file-name"><?= $value->file_original ?> (<?= $value->file_size ?> Mb)</span>
                      <a href="<?= base_url() . '/' . $value->file_path ?>" class="float-end pointer" title="โหลดไฟล์" target="_blank"><i class="bi bi-eye"></i></a>
                      <a href="javascript:download_pdf('<?= $value->file_original ?>', '<?= base_url() . '/' . $value->file_path ?>')" class="float-end pointer" title="ดาวน์โหลดไฟล์"><i class="bi bi-download"></i></a>
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
      <span class="fs-18 fw-semibold">สำเนาหนังสือการจดทะเบียนวิสาหกิจชุมชน <span class="required">*</span></span>
      <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
        <div class="card-body selecter-file">
          <h4>เอกสาร</h4>
          <?php
          if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
            foreach (json_decode($result->pack_file) as $key => $value) {
              if ($value->file_position == 'businessCertFiles') {
          ?>
                <div class="card card-body">
                  <div class="bs-row">
                    <div class="col-12"> <span class="fs-file-name"><?= $value->file_original ?> (<?= $value->file_size ?> Mb)</span>
                      <a href="<?= base_url() . '/' . $value->file_path ?>" class="float-end pointer" title="โหลดไฟล์" target="_blank"><i class="bi bi-eye"></i></a>
                      <a href="javascript:download_pdf('<?= $value->file_original ?>', '<?= base_url() . '/' . $value->file_path ?>')" class="float-end pointer" title="ดาวน์โหลดไฟล์"><i class="bi bi-download"></i></a>
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
      <span class="fs-18 fw-semibold">ใบรับรองมาตรฐาน หรือประกาศนียบัตรจากการท่องเที่ยวแห่งประเทศไทย, SHA, กรมการท่องเที่ยว, องค์การบริหารการพัฒนาพื้นที่พิเศษเพื่อการท่องเที่ยวอย่างยั่งยืน (องค์การมหาชน) ฯลฯ (ถ้ามี) <span class="required">*</span></span>
      <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
        <div class="card-body selecter-file">
          <h4>เอกสาร</h4>
          <?php
          if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
            foreach (json_decode($result->pack_file) as $key => $value) {
              if ($value->file_position == 'otherCertFiles') {
          ?>
                <div class="card card-body">
                  <div class="bs-row">
                    <div class="col-12"> <span class="fs-file-name"><?= $value->file_original ?> (<?= $value->file_size ?> Mb)</span>
                      <a href="<?= base_url() . '/' . $value->file_path ?>" class="float-end pointer" title="โหลดไฟล์" target="_blank"><i class="bi bi-eye"></i></a>
                      <a href="javascript:download_pdf('<?= $value->file_original ?>', '<?= base_url() . '/' . $value->file_path ?>')" class="float-end pointer" title="ดาวน์โหลดไฟล์"><i class="bi bi-download"></i></a>
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
  <?php endif; ?>


  <?php if ($result->manage_by == 3) : ?>

    <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12 mb-4">
      <span class="fs-18 fw-semibold">หลักฐานการถือครองที่ดินที่กฎหมายรับรอง สัญญาเช่า หรือหนังสือยินยอมให้ใช้สถานที่ <span class="required">*</span></span>
      <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
        <div class="card-body selecter-file">
          <h4>เอกสาร</h4>
          <?php
          if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
            foreach (json_decode($result->pack_file) as $key => $value) {
              if ($value->file_position == 'landOwnerFiles') {
          ?>
                <div class="card card-body">
                  <div class="bs-row">
                    <div class="col-12"> <span class="fs-file-name"><?= $value->file_original ?> (<?= $value->file_size ?> Mb)</span>
                      <a href="<?= base_url() . '/' . $value->file_path ?>" class="float-end pointer" title="โหลดไฟล์" target="_blank"><i class="bi bi-eye"></i></a>
                      <a href="javascript:download_pdf('<?= $value->file_original ?>', '<?= base_url() . '/' . $value->file_path ?>')" class="float-end pointer" title="ดาวน์โหลดไฟล์"><i class="bi bi-download"></i></a>
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
      <span class="fs-18 fw-semibold">สำเนาใบอนุญาตประกอบธุรกิจที่ถูกต้องตามกฎหมาย <span class="required">*</span></span>
      <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
        <div class="card-body selecter-file">
          <h4>เอกสาร</h4>
          <?php
          if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
            foreach (json_decode($result->pack_file) as $key => $value) {
              if ($value->file_position == 'businessCertFiles') {
          ?>
                <div class="card card-body">
                  <div class="bs-row">
                    <div class="col-12"> <span class="fs-file-name"><?= $value->file_original ?> (<?= $value->file_size ?> Mb)</span>
                      <a href="<?= base_url() . '/' . $value->file_path ?>" class="float-end pointer" title="โหลดไฟล์" target="_blank"><i class="bi bi-eye"></i></a>
                      <a href="javascript:download_pdf('<?= $value->file_original ?>', '<?= base_url() . '/' . $value->file_path ?>')" class="float-end pointer" title="ดาวน์โหลดไฟล์"><i class="bi bi-download"></i></a>
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
      <span class="fs-18 fw-semibold">ใบรับรองมาตรฐาน หรือประกาศนียบัตรจากการท่องเที่ยวแห่งประเทศไทย, SHA, กรมการท่องเที่ยว, องค์การบริหารการพัฒนาพื้นที่พิเศษเพื่อการท่องเที่ยวอย่างยั่งยืน (องค์การมหาชน) ฯลฯ (ถ้ามี) <span class="required">*</span></span>
      <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
        <div class="card-body selecter-file">
          <h4>เอกสาร</h4>
          <?php
          if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
            foreach (json_decode($result->pack_file) as $key => $value) {
              if ($value->file_position == 'otherCertFiles') {
          ?>
                <div class="card card-body">
                  <div class="bs-row">
                    <div class="col-12"> <span class="fs-file-name"><?= $value->file_original ?> (<?= $value->file_size ?> Mb)</span>
                      <a href="<?= base_url() . '/' . $value->file_path ?>" class="float-end pointer" title="โหลดไฟล์" target="_blank"><i class="bi bi-eye"></i></a>
                      <a href="javascript:download_pdf('<?= $value->file_original ?>', '<?= base_url() . '/' . $value->file_path ?>')" class="float-end pointer" title="ดาวน์โหลดไฟล์"><i class="bi bi-download"></i></a>
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

  <?php endif; ?>

</div>