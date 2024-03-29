<div class="backendcontent forminput">
  <div class="backendcontent-row">
    <div class="backendcontent-title">
      <div class="backendcontent-title-txt">
        <h3>ข้อมูลใบสมัคร</h3>
      </div>
    </div>

    <div class="backendform dataregis">

      <div class="backendform-row">
        <div class="backendform-col3">
          <p>รหัสใบสมัคร : <?= $result->code ?></p>
          <p>ชื่อสถานประกอบการ : <?= $result->attraction_name_th ?></p>
          <p>ชื่อสถานประกอบการภาษาอังกฤษ : <?= $result->attraction_name_en ?></p>
        </div>

        <div class="backendform-col3">
          <p>ประเภท : <?= applicationType($result->application_type_id) ?></p>
          <p>สาขา : <?= applicationTypeSub($result->application_type_sub_id) ?></p>
          <p>วันที่ส่งใบสมัคร : <?= docDate($result->send_date, 3) ?></p>
        </div>

        <div class="backendform-col3">
          <p>ชื่อ-นามสกุล : <?= $result->knitter_name ?></p>
          <p>อีเมล : <?= $result->knitter_email ?></p>
          <p>เบอร์ติดต่อ : <?= $result->knitter_tel ?></p>
        </div>


      </div>

    </div>
  </div>
</div>

<a name="pageform"></a>
<div class="backendcontent">
  <div class="backendcontent-row">

    <div class="formmainbox">

      <div class="regis-form-step" style="grid-template-columns: repeat(5, 1fr);">
        <a id="1" href="javascript:void(0);" class="btn-form-step complete active">
          1. ประเภทการสมัคร
        </a>
        <a id="2" href="javascript:void(0);" class="btn-form-step complete">
          2. ข้อมูลผลงานที่ส่งเข้าประกวด
        </a>
        <a id="3" href="javascript:void(0);" class="btn-form-step complete">
          3. ข้อมูลหน่วยงานบริษัท
        </a>
        <a id="4" href="javascript:void(0);" class="btn-form-step complete">
          4. ข้อมูลผู้ประสานงาน
        </a>
        <a id="5" href="javascript:void(0);" class="btn-form-step complete">
          5. คุณสมบัติ/เอกสาร
        </a>
      </div>
      <div class="sections regis-form-data">
        <div class="content content1 active">
          <div class="regis-form-data">
            <div class="regis-form-data-row">
              <div class="regis-form-data-col1">
                <h3>
                  <picture>
                    <source srcset="<?= base_url() ?>/assets/images/formicon-type.svg">
                    <img src="<?= base_url() ?>/assets/images/formicon-type.png">
                  </picture> ประเภทที่ต้องการสมัครประกวดรางวัลอุตสาหกรรมท่องเที่ยวไทย
                </h3>
              </div>
              <div class="regis-form-data-col1">
                <h4>กรุณาเลือกประเภทการสมัคร <span class="required">*</span></h4>

                <?php
                if (!empty($application_type)) :
                  foreach ($application_type as $key => $value) :
                    $checked = "";
                    if ($value->id == $result->application_type_id) {
                      $checked = "checked";
                    }
                ?>
                    <p>
                      <input type="radio" id="application_type_<?= $value->id ?>" name="application_type" value="<?= $value->id ?>" <?= $checked ?> disabled>
                      <label for="application_type_<?= $value->id ?>"> <?= $value->name ?></label>
                    </p>
                <?php
                  endforeach;
                endif;
                ?>
              </div>

              <div class="regis-form-data-col1">
                <h4>สาขารางวัล <span class="required">*</span></h4>
                <div id="option_application_type_sub">
                  <?php
                  $descreption = '';
                  if (!empty($application_type_sub)) {
                    foreach ($application_type_sub as $key => $value) :
                      $checked = "";
                      if ($value->id == $result->application_type_sub_id) {
                        $checked = "checked";
                        $descreption = $value->descreption;
                      }
                  ?>
                      <p>
                        <input type="radio" id="application_type_sub_<?= $value->id ?>" name="application_type_sub" value="<?= $value->id ?>" <?= $checked ?> disabled>
                        <label for="application_type_sub_<?= $value->id ?>"> <?= $value->name ?></label>
                      </p>
                  <?php
                    endforeach;
                  } else {
                    echo '<span class="text-danger">ไม่พบสาขารางวัล</span>';
                  }
                  ?>
                </div>

              </div>

              <div class="regis-form-data-col1">
                <div class="comment yellow">
                  <i class="bi bi-exclamation-lg"></i>
                  <h4>นิยาม</h4>
                  <p><?php echo $descreption ?></p>
                </div>
              </div>

              <div class="regis-form-data-col1">
                <h4>กรุณาระบุ หากต้องการสมัครประเภทพิเศษ Low Carbon & Sustainability</h4>
                <div id="option_application_type_sub">
                  <?php
                  $checked = "";
                  if ($result->require_lowcarbon == 1) {
                    $checked = "checked";
                  }
                  ?>
                  <p>
                    <input type="radio" id="require_lowcarbon_1" name="require_lowcarbon" value="1" <?= ($result->require_lowcarbon == 1) ? 'checked' : ''; ?> disabled>
                    <label for="require_lowcarbon_1"> ต้องการ</label>
                  </p>
                  <p>
                    <input type="radio" id="require_lowcarbon_2" name="require_lowcarbon" value="2" <?= ($result->require_lowcarbon != 1) ? 'checked' : ''; ?> disabled>
                    <label for="require_lowcarbon_2"> ไม่ต้องการ</label>
                  </p>
                  <a href="<?= base_url('download/คุณสมบัติและเกณฑ์ประเภทประเภทการท่องเที่ยวคาร์บอนต่ำ.pdf') ?>" target="_blank" style="color: #2a6118;">
                    <small>คลิกดูคุณสมบัติ/เกณฑ์ประเภท Carbon & Sustainability</small>
                  </a>
                </div>
              </div>

              <div class="regis-form-data-col1">
                <h4>อธิบายจุดเด่นของผลงานที่ต้องการส่งเข้าประกวด <span class="required">*</span></h4>
                <span>ระบุคำตอบ <span class="required">*</span> </span>
                <span class="commentrequired">(จำนวนตัวอักษรคงเหลือ <span id="charNum">1,000</span>/1,000)</span>
                <textarea rows="6" id="field" onkeyup="countChar(this)" readonly><?= $result->highlights ?></textarea>
                <script>
                  function countChar(elm) {
                    var len = elm.value.replace(/\r/g, '').length;
                    if (len >= 1000) {
                      $('#charNum').text('0');
                    } else {
                      $('#charNum').text((1000 - len).toLocaleString("en"));
                    }
                  }
                </script>
              </div>

              <div class="regis-form-data-col1 inpvdo">
                <label>ลิ้งก์เว็บไซต์ หรือ ลิ้งก์วิดีโอ</label> <input value="<?= $result->link ?>" disabled="">
              </div>

              <div class="regis-form-data-col2 attachfile">
                <div class="attachinp">
                  <h4>รายละเอียดผลงาน</h4>
                  <?php
                  if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                    foreach (json_decode($result->pack_file) as $key => $value) {
                      if ($value->file_position == 'detailFiles') {
                  ?>
                        <div class="card card-body">
                          <div class="bs-row">
                            <div class="col-12">
                              <span class="fs-file-name"><?= $value->file_original ?> (<?= $value->file_size ?> Mb)</span>
                              <a href="<?= base_url() . '/' . $value->file_path ?>" class="float-end download_pdf pointer" title="ดูรายละเอียดเอกสาร" target="_blank"><i class="bi bi-eye"></i></a>
                              <a href="javascript:download_pdf('<?= $value->file_original ?>', '<?= base_url() . '/' . $value->file_path ?>')" class="float-end download_pdf pointer" title="ดาวน์โหลดไฟล์"><i class="bi bi-download"></i></a>
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

                <div class="attachinp">
                  <h4>สื่อสิ่งพิมพ์</h4>

                  <?php
                  if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                    foreach (json_decode($result->pack_file) as $key => $value) {
                      if ($value->file_position == 'paperFiles') {
                  ?>
                        <div class="card card-body">
                          <div class="bs-row">
                            <div class="col-12">
                              <span class="fs-file-name"><?= $value->file_original ?> (<?= $value->file_size ?> Mb)</span>
                              <a href="<?= base_url() . '/' . $value->file_path ?>" class="float-end download_pdf pointer" title="ดูรายละเอียดเอกสาร" target="_blank"><i class="bi bi-eye"></i></a>
                              <a href="javascript:download_pdf('<?= $value->file_original ?>', '<?= base_url() . '/' . $value->file_path ?>')" class="float-end download_pdf pointer" title="ดาวน์โหลดไฟล์"><i class="bi bi-download"></i></a>
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

              <div class="regis-form-data-col2 attachfile">
                <div class="attachinp">
                  <h4>แนบรูปภาพความละเอียดสูง (ประมาณ 5-10 รูป)</h4>
                  <div class="ablumbox">

                    <?php
                    if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                      foreach (json_decode($result->pack_file) as $key => $value) {
                        if ($value->file_position == 'registerImages') {
                    ?>
                          <div class="ablumbox-col">
                            <div class="ablum-mainimg">
                              <div class="ablum-mainimg-scale">
                                <img src="<?= base_url() . '/' . $value->file_path ?>" title="<?= $value->file_original ?>" class="ablum-img" onclick="view_img(this)">
                              </div>
                            </div>
                          </div>
                    <?php
                        }
                      }
                    } else {
                      echo '<h5 class="text-danger"><i>ไม่ได้แนบรูปภาพ</i></h5>';
                    }
                    ?>

                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="content content2">
          <div class="regis-form-data">
            <div class="regis-form-data-row">
              <div class="regis-form-data-col1">
                <h3>
                  <picture>
                    <source srcset="<?= base_url() ?>/assets/images/formicon-type.svg">
                    <img src="<?= base_url() ?>/assets/images/formicon-type.png">
                  </picture> ข้อมูลผลงานที่ส่งเข้าประกวด
                </h3>
              </div>
              <div class="regis-form-data-col1">
                <h4>ชื่อแหล่งท่องเที่ยว/สถานประกอบการ/รายการนำเที่ยว (TH)<span class="required">*</span></h4>
                <input value="<?= $result->attraction_name_th ?>" readonly>
                <span class="inpcomment">(หมายเหตุ: ชื่อโรงแรม ตามใบอนุญาตประกอบการธุรกิจโรงแรม)*</span>
              </div>

              <div class="regis-form-data-col1">
                <h4>ชื่อแหล่งท่องเที่ยว/สถานประกอบการ/รายการนำเที่ยว (EN)</h4>
                <input value="<?= $result->attraction_name_en ?>" readonly>
              </div>

              <div class="regis-form-data-col2">
                <h4>ที่ตั้ง/เลขที่<span class="required">*</span></h4>
                <input value="<?= $result->address_no ?>" readonly>
              </div>

              <div class="regis-form-data-col2">
                <h4>ถนน</h4>
                <input value="<?= $result->address_road ?>" readonly>
              </div>

              <div class="regis-form-data-col2">
                <h4>ตำบล<span class="required">*</span></h4>
                <input value="<?= $result->address_sub_district ?>" readonly>
              </div>

              <div class="regis-form-data-col2">
                <h4>อำเภอ<span class="required">*</span></h4>
                <input value="<?= $result->address_district ?>" readonly>
              </div>

              <div class="regis-form-data-col2">
                <h4>จังหวัด<span class="required">*</span></h4>
                <input value="<?= $result->address_province ?>" readonly>
              </div>

              <div class="regis-form-data-col2">
                <h4>รหัสไปรษณีย์<span class="required">*</span></h4>
                <input value="<?= $result->address_zipcode ?>" readonly>
              </div>

              <div class="regis-form-data-col2">
                <h4>Facebook</h4>
                <input value="<?= $result->facebook ?>" readonly>
              </div>

              <div class="regis-form-data-col2">
                <h4>Instagram</h4>
                <input value="<?= $result->instagram ?>" readonly>
              </div>

              <div class="regis-form-data-col2">
                <h4>Line ID</h4>
                <input value="<?= $result->line_id ?>" readonly>
              </div>

              <div class="regis-form-data-col2">
                <h4>Social Media อื่นๆ</h4>
                <input value="<?= $result->other_social ?>" readonly>
              </div>

              <div class="regis-form-data-col1">
                <h4>ลิ้งก์แผนที่ Google Map</h4>
                <input value="<?= $result->google_map ?>" readonly>
              </div>
            </div>

          </div>
        </div>

        <div class="content content3">
          <div class="regis-form-data">
            <div class="regis-form-data-row">
              <div class="regis-form-data-col1">
                <h3>
                  <picture>
                    <source srcset="<?= base_url() ?>/assets/images/formicon-type.svg">
                    <img src="<?= base_url() ?>/assets/images/formicon-type.png">
                  </picture> ข้อมูลหน่วยงาน/บริษัทที่ส่งเข้าประกวด
                </h3>
              </div>
              <div class="regis-form-data-col1">
                <h4>ชื่อหน่วยงาน/บริษัท <span class="required">*</span></h4>
                <input value="<?= $result->company_name ?>" readonly>
              </div>

              <div class="regis-form-data-col1">
                <h4>ที่อยู่</h4>
                <div class="selectaddress">
                  <div class="selectaddresscol">
                    <p>
                      <input type="radio" name="company_setaddr" value="1" id="oldaddress" <?= ($result->company_setaddr == 1) ? 'checked' : ''; ?> disabled>
                      <label for="oldaddress"> สถานที่เดียวกับผลงานที่ส่งเข้าประกวด</label>
                    </p>
                  </div>
                  <div class="selectaddresscol">
                    <p>
                      <input type="radio" name="company_setaddr" value="2" id="newaddress" <?= ($result->company_setaddr == 2) ? 'checked' : ''; ?> disabled>
                      <label for="newaddress"> ระบุที่อยู่ใหม่</label>
                    </p>
                  </div>
                </div>
              </div>

              <div class="hide-address">
                <div class="regis-form-data-col2">
                  <h4>ที่ตั้ง/เลขที่</h4>
                  <input value="<?= $result->company_addr_no ?>" readonly>
                </div>

                <div class="regis-form-data-col2">
                  <h4>ถนน</h4>
                  <input value="<?= $result->company_addr_road ?>" readonly>
                </div>

                <div class="regis-form-data-col2">
                  <h4>ตำบล</h4>
                  <input value="<?= $result->company_addr_sub_district ?>" readonly>
                </div>

                <div class="regis-form-data-col2">
                  <h4>อำเภอ</h4>
                  <input value="<?= $result->company_addr_district ?>" readonly>
                </div>

                <div class="regis-form-data-col2">
                  <h4>จังหวัด</h4>
                  <input value="<?= $result->company_addr_province ?>" readonly>
                </div>

                <div class="regis-form-data-col2">
                  <h4>รหัสไปรษณีย์</h4>
                  <input value="<?= $result->company_addr_zipcode ?>" readonly>
                </div>

                <div class="regis-form-data-col2">
                  <h4>หมายเลขโทรศัพท์</h4>
                  <input value="<?= $result->mobile ?>" readonly>
                </div>

                <div class="regis-form-data-col2">
                  <h4>อีเมล</h4>
                  <input value="<?= $result->email ?>" readonly>
                </div>

                <div class="regis-form-data-col2">
                  <h4>Line ID</h4>
                  <input value="<?= $result->company_line ?>" readonly>
                </div>

              </div>
            </div>
          </div>
        </div>

        <div class="content content4">
          <div class="regis-form-data">
            <div class="regis-form-data-row">
              <div class="regis-form-data-col1">
                <h3>
                  <picture>
                    <source srcset="<?= base_url() ?>/assets/images/formicon-type.svg">
                    <img src="<?= base_url() ?>/assets/images/formicon-type.png">
                  </picture> ข้อมูลผู้ประสานงาน
                </h3>
              </div>
              <div class="regis-form-data-col2">
                <h4>ชื่อ-นามสกุลผู้ประสานงาน <span class="required">*</span></h4>
                <input value="<?= $result->knitter_name ?>" readonly>
              </div>

              <div class="regis-form-data-col2">
                <h4>ตำแหน่ง</h4>
                <input value="<?= $result->knitter_position ?>" readonly>
              </div>

              <div class="regis-form-data-col2">
                <h4>หมายเลขโทรศัพท์ <span class="required">*</span></h4>
                <input value="<?= $result->knitter_tel ?>" readonly>
              </div>

              <div class="regis-form-data-col2">
                <h4>อีเมล <span class="required">*</span></h4>
                <input value="<?= $result->knitter_email ?>" readonly>
              </div>

              <div class="regis-form-data-col2">
                <h4>Line ID</h4>
                <input value="<?= $result->knitter_line ?>" readonly>
              </div>
            </div>
          </div>
        </div>
        <div class="content content5">
          <div class="regis-form-data">
            <?php
            if ($result->application_type_id == 1) {
              echo view('administrator/approve/form_1', ['result' => $result]);
            } else if ($result->application_type_id == 2) {
              echo view('administrator/approve/form_2', ['result' => $result]);
            } else if ($result->application_type_id == 3) {
              echo view('administrator/approve/form_3', ['result' => $result]);
            } else if ($result->application_type_id == 4) {
              echo view('administrator/approve/form_4', ['result' => $result]);
            }

            ?>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>

<div class="backendcontent forminput">
  <div class="backendcontent-row">
    <div class="backendcontent-title">
      <div class="backendcontent-title-txt">
        <h3>การอนุมัติใบสมัคร</h3>
      </div>
    </div>

    <div class="backendform">

      <form id="insert_form">
        <div class="backendform-row">
          <div class="backendform-col1 subject">
            สถานะ
          </div>
          <input type="hidden" name="insert_id" id="insert_id" value="<?= $id ?>">
          <div class="backendform-col1 judgeradio">
            <div class="judgeradio-col">
              <input type="radio" id="status_4" name="status" value="4" <?= ($result->status == 4) ? 'checked' : ''; ?>>
              <label for="status_4">ขอข้อมูลเพิ่มเติม</label>
            </div>
            <div class="judgeradio-col">
              <input type="radio" id="status_3" name="status" value="3" <?= ($result->status == 3) ? 'checked' : ''; ?>>
              <label for="status_3">อนุมัติ</label>
            </div>
            <div class="judgeradio-col">
              <input type="radio" id="status_0" name="status" value="0" <?= ($result->status == 0) ? 'checked' : ''; ?>>
              <label for="status_0">ไม่อนุมัติ</label>
            </div>
          </div>
        </div>

        <div class="backendform-row">
          <div class="backendform-col1 subject">
            ความคิดเห็น
          </div>
          <div class="backendform-col1 inpfield">
            <textarea rows="5" name="judge_comment" id="judge_comment"><?= $result->judge_comment ?></textarea>
          </div>
        </div>

        <?php if ($result->status == 0 || $result->status == 3) { ?>
          <div class="text-end">
            ผู้อนุมัติ: <?= $result->approve_name ?> อัพเดทวันที่ <?= docDate($result->approve_time, 3) ?> <?= date('H:i', strtotime($result->approve_time)) ?> น.
          </div>
        <?php } else { ?>
          <div class="form-main-btn">
            <a href="javascript:void(0)" class="btn-cancle">ยกเลิก</a>
            <a href="javascript:void(0)" class="btn-save" id="btn_save" data-tab="1">บันทึก</a>
          </div>
        <?php } ?>

      </form>


    </div>
  </div>
</div>

<form action="<?= base_url('administrator/approve/download') ?>" method="post" id="form_download" target="_blank">
  <input type="hidden" name="name" id="name" value="">
  <input type="hidden" name="url" id="url" value="">
</form>
<script>
  $(function() {

    var pgurl = BASE_URL_BACKEND + '/approve';
    active_page(pgurl);

    $('#field').keyup();

    const buttons = document.querySelectorAll(".btn-form-step");
    const sections = document.querySelectorAll(".content");

    buttons.forEach((btn) => {
      btn.addEventListener("click", () => {
        buttons.forEach((btn) => {
          btn.classList.remove("active");
        });
        btn.classList.add("active");
        const id = btn.id;
        sections.forEach((section) => {
          section.classList.remove("active");
        });
        const req = document.getElementsByClassName(`content${id}`);
        req[0].classList.add("active");
      });
    });

    if ('<?= $result->status == 0 ?>' || '<?= $result->status == 3 ?>') {
      $('[name="status"]').prop('disabled', true);
      $('#judge_comment').prop('readonly', true);
    } else {
      $('[name="status"]').prop('disabled', false);
      $('#judge_comment').prop('readonly', false);
    }


  });

  $('#btn_save').click(function(e) {
    var insert_id = $('#insert_id').val();
    var judge_comment = $('#judge_comment').val();
    var status = $('input[name="status"]:checked').val();
    if (status == undefined) {
      $('input[name="status"]').first().focus();
      toastr.error('กรุณาระบุสถานะ');
      return false;
    }

    $('#').addClass('was-validated');
    if (status == 4 && judge_comment == "") {
      $('#judge_comment').focus();
      $('#judge_comment').prop('required', true);
      toastr.error('กรุณาระบุความคิดเห็น');
      return false;
    } else {
      $('#judge_comment').prop('required', false);
    }
    $('#btn_save').html('<i class="fa fa-spinner spinner-border"></i>').addClass('disable-click');
    var data = {
      status: status,
      insert_id: insert_id,
      judge_comment: judge_comment,
    }
    var res = main_post(BASE_URL_BACKEND + '/approve/saveStatus', data);
    // cc(res)
    res_swal(res, 0, function() {
      window.history.back();
    });
  });

  $('[name="application_type"]').change(function(e) {
    var res = main_post(BASE_URL_BACKEND + '/approve/getAplicationTypeSub/' + $(this).val());
    var html = ``;
    if (!$.isEmptyObject(res)) {
      $.each(res, function(index, value) {
        var checked = "";
        if (index == 0) {
          checked = "checked";
        }
        html += `<p>
                  <input type="radio" id="application_type_sub_` + value.id + `" name="application_type_sub" value="` + value.id + `" ` + checked + `>
                  <label for="application_type_sub_` + value.id + `"> ` + value.name + `</label>
                </p>`;
      });
    } else {
      html += `<span class="text-danger">ไม่พบสาขารางวัล</span>`;
    }
    $('#option_application_type_sub').html(html);
  });

  function download_pdf(name, url) {
    $('#url').val(url);
    $('#name').val(name);
    $('#form_download').submit();
  }
</script>