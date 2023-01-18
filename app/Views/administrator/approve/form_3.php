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

  <div class="regis-form-data-col">
    <h4>จะต้องไม่ประกอบกิจการที่มีการครอบครอง จำหน่าย หรือค้าสัตว์ป่าสงวนสัตว์ป่าคุ้มครอง หรือสัตว์ป่าตามอนุสัญญาฯ (CITES) หรือซากของสัตว์ป่าและผลิตภัณฑ์ที่ทำจากซากของสัตว์และผลิตภัณฑ์ที่ทำจากซากของสัตว์ป่า หรือที่ทำจากงาช้าง รวมทั้งพันธุ์พืชหวงห้ามหรือพืชอนุรักษ์ทุกชนิด โดยที่ไม่ชอบด้วยกฎหมาย
    </h4>
    <p><input type="radio" id="step5-t3-bussCites-0" value="0" <?= ($result->buss_cites == 0) ? 'checked' : ''; ?> disabled> ไม่ประกอบกิจการ</p>
    <p><input type="radio" id="step5-t3-bussCites-1" value="1" <?= ($result->buss_cites == 1) ? 'checked' : ''; ?> disabled> ประกอบกิจการ</p>
  </div>
  <div class="regis-form-data-col">
    <h4>ผู้ส่งผลงานจะต้องไม่มีส่วนได้ส่วนเสียกับการท่องเที่ยวแห่งประเทศไทย (ททท.) ทั้งทางตรงและทางอ้อม</h4>
    <p><input type="radio" id="step5-t3-nominee-1" value="1" <?= ($result->admin_nominee == 1) ? 'checked' : ''; ?> disabled> มีส่วนได้ส่วนเสีย</p>
    <p><input type="radio" id="step5-t3-nominee-0" value="0" <?= ($result->admin_nominee == 0) ? 'checked' : ''; ?> disabled> ไม่มีส่วนได้ส่วนเสีย</p>
  </div>
  <div class="bs-row">
    <span class="fs-18 fw-semibold">แนบเอกสาร</h4>
      <hr>

      <?php if ($result->application_type_sub_id == 11) : ?>
        <div class="bs-row row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12 mb-4">
            <span class="fs-18 fw-semibold">มีใบอนุญาตประกอบกิจการสถานประกอบการสปาเพื่อสุขภาพจากกระทรวงสาธารณสุขมาแล้วไม่น้อยกว่า 1 ปี นับจนถึงวันปิดรับสมัคร ในกรณีที่ใบรับรองมาตรฐานสปาเพื่อสุขภาพหมดอายุหรืออยู่ระหว่างการยื่นเอกสารขอต่ออายุ ให้แสดงหลักฐานการยื่นขอต่ออายุจากกระทรวงสาธารณสุขหรือสำนักงานสาธารณสุขจังหวัดที่สถานประกอบการนั้นตั้งอยู่
              <span class="required">*</span></span>
            <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
              <div class="card-body selecter-file">
                <h4>เอกสาร</h4>
                <?php
                if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                  foreach (json_decode($result->pack_file) as $key => $value) {
                    if ($value->file_position == 'spaCertFiles') {
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
            <span class="fs-18 fw-semibold">
              มีผลการตรวจสอบลักษณะน้ำทิ้ง (ในกรณีเป็นสถานประกอบกิจการที่ต้องถูกควบคุมการระบายน้ำทิ้งตามกฎหมายกำหนด)
            </span>
            <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
              <div class="card-body selecter-file">
                <h4>เอกสาร</h4>
                <?php
                if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                  foreach (json_decode($result->pack_file) as $key => $value) {
                    if ($value->file_position == 'effluentFiles') {
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
            <span class="fs-18 fw-semibold">
              สำเนาใบอนุญาตเป็นผู้ดำเนินการสปา (Spa Manager)
              <span class="required">*</span>
            </span>
            <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
              <div class="card-body selecter-file">
                <h4>เอกสาร</h4>
                <?php
                if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                  foreach (json_decode($result->pack_file) as $key => $value) {
                    if ($value->file_position == 'spaMangerFiles') {
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
            <span class="fs-18 fw-semibold">
              สำเนาโฉนดที่ดิน/เอกสารสิทธิ์ที่ถูกต้องตามกฎหมาย หรือมีเอกสารที่ได้รับอนุญาตให้ใช้พื้นที่จากทางราชการหรือสัญญาเช่า <span class="required">*</span>
            </span>
            <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
              <div class="card-body selecter-file">
                <h4>เอกสาร</h4>
                <?php
                if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                  foreach (json_decode($result->pack_file) as $key => $value) {
                    if ($value->file_position == 'titleDeedFiles') {
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
            <span class="fs-18 fw-semibold">
              สำเนาผลการตรวจสอบลักษณะน้ำทิ้ง (ในกรณีเป็นสถานประกอบกิจการที่ต้องถูกควบคุมการระบายน้ำทิ้งตามที่กฎหมายกำหนด) (แนบเอกสาร)
              <span class="required">*</span>
            </span>
            <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
              <div class="card-body selecter-file">
                <h4>เอกสาร</h4>
                <?php
                if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                  foreach (json_decode($result->pack_file) as $key => $value) {
                    if ($value->file_position == 'EffluentT3Files') {
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
            <span class="fs-18 fw-semibold">เอกสารแนบอื่น ๆ (ถ้ามี) เช่น หนังสือรับรอง GMP ของโรงงานผู้ผลิตผลิตภัณฑ์ที่ใช้ในสถานประกอบการ เอกสารรับรอง (Certificate) หรือรางวัลมาตรฐานผลิตภัณฑ์ระดับนานาชาติของผลิตภัณฑ์หรือของโรงงานผู้ผลิตผลิตภัณฑ์ที่ใช้ในสถานประกอบการ</h4>
              <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
                <div class="card-body selecter-file">
                  <h4>เอกสาร</h4>
                  <?php
                  if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                    foreach (json_decode($result->pack_file) as $key => $value) {
                      if ($value->file_position == 'otherT3Files') {
                  ?>
                        <div class="card card-body">
                          <div class="bs-row">
                            <div class="col-12"> <span class="fs-file-name"><?= $value->file_original ?> (<?= $value->file_size ?> Mb)</span>
                              <a href="<?= base_url() . '/' . $value->file_path ?>" class="float-end pointer" title="โหลดไฟล์" target="_blank"><i class="bi bi-eye"></i></a>
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
              จะต้องเป็นสถานประกอบการที่ไม่มีการจ้างแรงงานที่ผิดกฎหมาย หากมี การจ้างแรงงานต่างด้าวจะต้องแสดงหลักฐานการจ้างแรงงานที่ถูกต้องตามกฎหมายกำหนด <span class="required">*</span>
            </span>
            <div></div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="step5-t3-outlander-1" name="step5-t3-outlander" disabled value="1" <?= ($result->has_outlander == 1) ? 'checked' : ''; ?>>
              <label class="form-check-label mr-2">มี</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="step5-t3-outlander-0" name="step5-t3-outlander" disabled value="0" <?= ($result->has_outlander == 0) ? 'checked' : ''; ?>>
              <label class="form-check-label mr-2">ไม่มี</label>
            </div>
            <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
              <div class="card-body selecter-file">
                <h4>เอกสาร</h4>
                <?php
                if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                  foreach (json_decode($result->pack_file) as $key => $value) {
                    if ($value->file_position == 'outlanderFiles') {
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
        </div>
      <?php endif; ?>


      <?php if ($result->application_type_sub_id == 12) : ?>
        <div class="bs-row row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12 mb-4">
            <span class="fs-18 fw-semibold">มีใบอนุญาตประกอบกิจการสถานประกอบการสปาเพื่อสุขภาพจากกระทรวงสาธารณสุขมาแล้วไม่น้อยกว่า 1 ปี นับจนถึงวันปิดรับสมัคร ในกรณีที่ใบรับรองมาตรฐานสปาเพื่อสุขภาพหมดอายุหรืออยู่ระหว่างการยื่นเอกสารขอต่ออายุ ให้แสดงหลักฐานการยื่นขอต่ออายุจากกระทรวงสาธารณสุขหรือสำนักงานสาธารณสุขจังหวัดที่สถานประกอบการนั้นตั้งอยู่
              <span class="required">*</span></span>
            <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
              <div class="card-body selecter-file">
                <h4>เอกสาร</h4>
                <?php
                if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                  foreach (json_decode($result->pack_file) as $key => $value) {
                    if ($value->file_position == 'spaCertFiles') {
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
            <span class="fs-18 fw-semibold">
              มีผลการตรวจสอบลักษณะน้ำทิ้ง (ในกรณีเป็นสถานประกอบกิจการที่ต้องถูกควบคุมการระบายน้ำทิ้งตามกฎหมายกำหนด)
            </span>
            <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
              <div class="card-body selecter-file">
                <h4>เอกสาร</h4>
                <?php
                if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                  foreach (json_decode($result->pack_file) as $key => $value) {
                    if ($value->file_position == 'effluentFiles') {
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
            <span class="fs-18 fw-semibold">
              มีใบอนุญาตประกอบกิจการสถานพยาบาล หรือใบอนุญาตให้ดำเนินการสถานพยาบาล (เฉพาะสาขา Wellness Spa)
              <span class="required">*</span>
            </span>
            <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
              <div class="card-body selecter-file">
                <h4>เอกสาร</h4>
                <?php
                if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                  foreach (json_decode($result->pack_file) as $key => $value) {
                    if ($value->file_position == 'wellnessCertFiles') {
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
            <span class="fs-18 fw-semibold">
              สำเนาโฉนดที่ดิน/เอกสารสิทธิ์ที่ถูกต้องตามกฎหมาย หรือมีเอกสารที่ได้รับอนุญาตให้ใช้พื้นที่จากทางราชการหรือสัญญาเช่า <span class="required">*</span>
            </span>
            <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
              <div class="card-body selecter-file">
                <h4>เอกสาร</h4>
                <?php
                if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                  foreach (json_decode($result->pack_file) as $key => $value) {
                    if ($value->file_position == 'titleDeedFiles') {
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
            <span class="fs-18 fw-semibold">
              สำเนาผลการตรวจสอบลักษณะน้ำทิ้ง (ในกรณีเป็นสถานประกอบกิจการที่ต้องถูกควบคุมการระบายน้ำทิ้งตามที่กฎหมายกำหนด) (แนบเอกสาร)
              <span class="required">*</span>
            </span>
            <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
              <div class="card-body selecter-file">
                <h4>เอกสาร</h4>
                <?php
                if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                  foreach (json_decode($result->pack_file) as $key => $value) {
                    if ($value->file_position == 'EffluentT3Files') {
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
            <span class="fs-18 fw-semibold">เอกสารแนบอื่น ๆ (ถ้ามี) เช่น หนังสือรับรอง GMP ของโรงงานผู้ผลิตผลิตภัณฑ์ที่ใช้ในสถานประกอบการ เอกสารรับรอง (Certificate) หรือรางวัลมาตรฐานผลิตภัณฑ์ระดับนานาชาติของผลิตภัณฑ์หรือของโรงงานผู้ผลิตผลิตภัณฑ์ที่ใช้ในสถานประกอบการ</h4>
              <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
                <div class="card-body selecter-file">
                  <h4>เอกสาร</h4>
                  <?php
                  if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                    foreach (json_decode($result->pack_file) as $key => $value) {
                      if ($value->file_position == 'otherT3Files') {
                  ?>
                        <div class="card card-body">
                          <div class="bs-row">
                            <div class="col-12"> <span class="fs-file-name"><?= $value->file_original ?> (<?= $value->file_size ?> Mb)</span>
                              <a href="<?= base_url() . '/' . $value->file_path ?>" class="float-end pointer" title="โหลดไฟล์" target="_blank"><i class="bi bi-eye"></i></a>
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
              จะต้องเป็นสถานประกอบการที่ไม่มีการจ้างแรงงานที่ผิดกฎหมาย หากมี การจ้างแรงงานต่างด้าวจะต้องแสดงหลักฐานการจ้างแรงงานที่ถูกต้องตามกฎหมายกำหนด <span class="required">*</span>
            </span>
            <div></div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="step5-t3-outlander-1" name="step5-t3-outlander" disabled value="1" <?= ($result->has_outlander == 1) ? 'checked' : ''; ?>>
              <label class="form-check-label mr-2">มี</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="step5-t3-outlander-0" name="step5-t3-outlander" disabled value="0" <?= ($result->has_outlander == 0) ? 'checked' : ''; ?>>
              <label class="form-check-label mr-2">ไม่มี</label>
            </div>
            <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
              <div class="card-body selecter-file">
                <h4>เอกสาร</h4>
                <?php
                if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                  foreach (json_decode($result->pack_file) as $key => $value) {
                    if ($value->file_position == 'outlanderFiles') {
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
        </div>
      <?php endif; ?>


      <?php if ($result->application_type_sub_id == 13 || $result->application_type_sub_id == 14) : ?>
        <div class="bs-row row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12 mb-4">
            <span class="fs-18 fw-semibold">มีใบอนุญาตประกอบกิจการสถานประกอบการสปาเพื่อสุขภาพจากกระทรวงสาธารณสุขมาแล้วไม่น้อยกว่า 1 ปี นับจนถึงวันปิดรับสมัคร ในกรณีที่ใบรับรองมาตรฐานสปาเพื่อสุขภาพหมดอายุหรืออยู่ระหว่างการยื่นเอกสารขอต่ออายุ ให้แสดงหลักฐานการยื่นขอต่ออายุจากกระทรวงสาธารณสุขหรือสำนักงานสาธารณสุขจังหวัดที่สถานประกอบการนั้นตั้งอยู่
              <span class="required">*</span></span>
            <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
              <div class="card-body selecter-file">
                <h4>เอกสาร</h4>
                <?php
                if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                  foreach (json_decode($result->pack_file) as $key => $value) {
                    if ($value->file_position == 'spaCertFiles') {
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
            <span class="fs-18 fw-semibold">
              มีผลการตรวจสอบลักษณะน้ำทิ้ง (ในกรณีเป็นสถานประกอบกิจการที่ต้องถูกควบคุมการระบายน้ำทิ้งตามกฎหมายกำหนด)
            </span>
            <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
              <div class="card-body selecter-file">
                <h4>เอกสาร</h4>
                <?php
                if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                  foreach (json_decode($result->pack_file) as $key => $value) {
                    if ($value->file_position == 'effluentFiles') {
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
            <span class="fs-18 fw-semibold">
              สำเนาโฉนดที่ดิน/เอกสารสิทธิ์ที่ถูกต้องตามกฎหมาย หรือมีเอกสารที่ได้รับอนุญาตให้ใช้พื้นที่จากทางราชการหรือสัญญาเช่า <span class="required">*</span>
            </span>
            <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
              <div class="card-body selecter-file">
                <h4>เอกสาร</h4>
                <?php
                if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                  foreach (json_decode($result->pack_file) as $key => $value) {
                    if ($value->file_position == 'titleDeedFiles') {
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
            <span class="fs-18 fw-semibold">
              สำเนาผลการตรวจสอบลักษณะน้ำทิ้ง (ในกรณีเป็นสถานประกอบกิจการที่ต้องถูกควบคุมการระบายน้ำทิ้งตามที่กฎหมายกำหนด) (แนบเอกสาร)
              <span class="required">*</span>
            </span>
            <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
              <div class="card-body selecter-file">
                <h4>เอกสาร</h4>
                <?php
                if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                  foreach (json_decode($result->pack_file) as $key => $value) {
                    if ($value->file_position == 'EffluentT3Files') {
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
            <span class="fs-18 fw-semibold">เอกสารแนบอื่น ๆ (ถ้ามี) เช่น หนังสือรับรอง GMP ของโรงงานผู้ผลิตผลิตภัณฑ์ที่ใช้ในสถานประกอบการ เอกสารรับรอง (Certificate) หรือรางวัลมาตรฐานผลิตภัณฑ์ระดับนานาชาติของผลิตภัณฑ์หรือของโรงงานผู้ผลิตผลิตภัณฑ์ที่ใช้ในสถานประกอบการ</h4>
              <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
                <div class="card-body selecter-file">
                  <h4>เอกสาร</h4>
                  <?php
                  if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                    foreach (json_decode($result->pack_file) as $key => $value) {
                      if ($value->file_position == 'otherT3Files') {
                  ?>
                        <div class="card card-body">
                          <div class="bs-row">
                            <div class="col-12"> <span class="fs-file-name"><?= $value->file_original ?> (<?= $value->file_size ?> Mb)</span>
                              <a href="<?= base_url() . '/' . $value->file_path ?>" class="float-end pointer" title="โหลดไฟล์" target="_blank"><i class="bi bi-eye"></i></a>
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
              จะต้องเป็นสถานประกอบการที่ไม่มีการจ้างแรงงานที่ผิดกฎหมาย หากมี การจ้างแรงงานต่างด้าวจะต้องแสดงหลักฐานการจ้างแรงงานที่ถูกต้องตามกฎหมายกำหนด <span class="required">*</span>
            </span>
            <div></div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="step5-t3-outlander-1" name="step5-t3-outlander" disabled value="1" <?= ($result->has_outlander == 1) ? 'checked' : ''; ?>>
              <label class="form-check-label mr-2">มี</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="step5-t3-outlander-0" name="step5-t3-outlander" disabled value="0" <?= ($result->has_outlander == 0) ? 'checked' : ''; ?>>
              <label class="form-check-label mr-2">ไม่มี</label>
            </div>
            <div class="card mt-1 col-md-6" style="border: 1px solid #E5E6ED;">
              <div class="card-body selecter-file">
                <h4>เอกสาร</h4>
                <?php
                if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                  foreach (json_decode($result->pack_file) as $key => $value) {
                    if ($value->file_position == 'outlanderFiles') {
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
        </div>
      <?php endif; ?>
  </div>
</div>