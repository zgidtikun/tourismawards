<div class="backendcontent forminput">
  <div class="backendcontent-row">
    <div class="backendcontent-title">
      <div class="backendcontent-title-txt">
        <h3>ข้อมูลใบสมัคร</h3>
      </div>
    </div>

    <div class="backendform dataregis">
      <?php
      // px($result);
      // pp(json_decode($result->pack_file));
      // pp($application_type_sub);
      ?>

      <div class="backendform-row">
        <div class="backendform-col3">
          <p>รหัสใบสมัคร : <?= $result->code ?></p>
          <p>ชื่อ : <?= $result->attraction_name_th ?></p>
          <p>Name : <?= $result->attraction_name_en ?></p>
        </div>

        <div class="backendform-col3">
          <p>ประเภท : <?= applicationType($result->application_type_id) ?></p>
          <p>สาขา : <?= applicationTypeSub($result->application_type_sub_id) ?></p>
          <p>วันที่ส่งใบสมัคร : <?= docDate($result->created_at, 3) ?></p>
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
          2. ข้อมูลผลงาน
        </a>
        <a id="3" href="javascript:void(0);" class="btn-form-step complete">
          3. ข้อมูลหน่วยงานบริษัท
        </a>
        <a id="4" href="javascript:void(0);" class="btn-form-step complete">
          4. ข้อมูลผู้ประสานงาน
        </a>
        <a id="5" href="javascript:void(0);" class="btn-form-step complete">
          5. คุณสมบัติเบื้องต้น/เอกสารประกอบการสมัคร
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
                <h4>กรุณาเลือกประเภทที่สอดคล้องกับการดำเนินงานและกลุ่มลูกค้าของท่านมากที่สุด <span class="required">*</span></h4>

                <?php
                if (!empty($application_type)) :
                  foreach ($application_type as $key => $value) :
                    $checked = "";
                    if ($value->id == $result->application_type_id) {
                      $checked = "checked";
                    }
                ?>
                    <p>
                      <input type="radio" id="application_type_<?= $value->id ?>" name="application_type" value="<?= $value->id ?>" <?= $checked ?>>
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
                  if (!empty($application_type_sub)) {
                    foreach ($application_type_sub as $key => $value) :
                      $checked = "";
                      if ($value->id == $result->application_type_sub_id) {
                        $checked = "checked";
                      }
                  ?>
                      <p>
                        <input type="radio" id="application_type_sub_<?= $value->id ?>" name="application_type_sub" value="<?= $value->id ?>" <?= $checked ?>>
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
                  <p>กิจกรรมหรือสถานที่เที่ยวเที่ยวที่สร้างหรือพัฒนาขึ้น เพื่อเน้นการให้ความบันเทิงหรือความสนุกสนาน แก่นักท่องเที่ยว เช่น สวนสนุก สวนน้ำ การแสดงต่างๆ ตลาดน้ำ ตลาดย้อนยุค เป็นต้น</p>
                </div>
              </div>

              <div class="regis-form-data-col1">
                <h4>อธิบายจุดเด่นของผลงานที่ต้องการส่งเข้าประกวด<span class="required">*</span></h4>
                ระบุคำตอบ<span class="required">*</span> <span class="commentrequired">(จำนวนตัวอักษรคงเหลือ <span id="charNum">1,000</span>/1,000)</span>
                <textarea rows="6" id="field" onkeyup="countChar(this)"><?= $result->highlights ?></textarea>
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

              <div class="regis-form-data-col1 inpvdo">
                <label>ลิ้งก์เว็บไซต์ หรือ ลิ้งก์วิดีโอ</label> <input value="<?= $result->link ?>" disabled="">
              </div>

              <div class="regis-form-data-col2 attachfile">
                <div class="attachinp">
                  <h4>รายละเอียดผลงาน</h4>
                  <?php
                  if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                    foreach (json_decode($result->pack_file) as $key => $value) {
                      if ($value->file_position == 'paperFiles') {
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

                <div class="attachinp">
                  <h4>สื่อสิ่งพิมพ์</h4>

                  <?php
                  if (!empty($result->pack_file) && !empty(json_decode($result->pack_file))) {
                    foreach (json_decode($result->pack_file) as $key => $value) {
                      if ($value->file_position == 'detailFiles') {
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
                                <img src="<?= base_url() . '/' . $value->file_path ?>" title="<?= $value->file_original ?>">
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
                <span class="inpcomment">(หมายเหตุ: ชื่อโรมแรม ตามใบอนุญาตประกอบการธุรกิจโรงแรม)*</span>
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
                <h4>ถนน<span class="required">*</span></h4>
                <input value="<?= $result->address_road ?>" readonly>
              </div>

              <div class="regis-form-data-col2">
                <h4>จังหวัด<span class="required">*</span></h4>
                <input value="<?= $result->address_province ?>" readonly>
              </div>

              <div class="regis-form-data-col2">
                <h4>อำเภอ<span class="required">*</span></h4>
                <input value="<?= $result->address_district ?>" readonly>
              </div>

              <div class="regis-form-data-col2">
                <h4>ตำบล<span class="required">*</span></h4>
                <input value="<?= $result->address_sub_district ?>" readonly>
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
                <h4>ชื่อหน่วยงาน/บริษัท<span class="required">*</span></h4>
                <input value="<?= $result->company_name ?>" readonly>
              </div>

              <div class="regis-form-data-col1">
                <h4>ที่อยู่<span class="required">*</span></h4>
                <div class="selectaddress">
                  <div class="selectaddresscol">
                    <p>
                      <input type="radio" name="company_setaddr" value="1" id="oldaddress" <?= ($result->company_setaddr == 1) ? 'checked' : ''; ?>>
                      <label for="oldaddress"> สถานที่เดียวกับผลงานที่ส่งเข้าประกวด</label>
                    </p>
                  </div>
                  <div class="selectaddresscol">
                    <p>
                      <input type="radio" name="company_setaddr" value="2" id="newaddress" <?= ($result->company_setaddr == 2) ? 'checked' : ''; ?>>
                      <label for="newaddress"> ระบุที่อยู่ใหม่</label>
                    </p>
                  </div>
                </div>
              </div>

              <div class="hide-address">
                <div class="regis-form-data-col2">
                  <h4>ที่ตั้ง/เลขที่<span class="required">*</span></h4>
                  <input value="<?= $result->company_addr_no ?>" readonly>
                </div>

                <div class="regis-form-data-col2">
                  <h4>ถนน<span class="required">*</span></h4>
                  <input value="<?= $result->company_addr_road ?>" readonly>
                </div>

                <div class="regis-form-data-col2">
                  <h4>จังหวัด<span class="required">*</span></h4>
                  <input value="<?= $result->company_addr_province ?>" readonly>
                </div>

                <div class="regis-form-data-col2">
                  <h4>อำเภอ<span class="required">*</span></h4>
                  <input value="<?= $result->company_addr_district ?>" readonly>
                </div>

                <div class="regis-form-data-col2">
                  <h4>ตำบล<span class="required">*</span></h4>
                  <input value="<?= $result->company_addr_sub_district ?>" readonly>
                </div>

                <div class="regis-form-data-col2">
                  <h4>รหัสไปรษณีย์<span class="required">*</span></h4>
                  <input value="<?= $result->company_addr_zipcode ?>" readonly>
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
                <h4>ชื่อ-นามสกุลผู้ประสานงาน<span class="required">*</span></h4>
                <input value="<?= $result->knitter_name ?>" readonly>
              </div>

              <div class="regis-form-data-col2">
                <h4>ตำแหน่ง<span class="required">*</span></h4>
                <input value="<?= $result->knitter_position ?>" readonly>
              </div>

              <div class="regis-form-data-col2">
                <h4>หมายเลขโทรศัพท์<span class="required">*</span></h4>
                <input value="<?= $result->knitter_tel ?>" readonly>
              </div>

              <div class="regis-form-data-col2">
                <h4>อีเมล<span class="required">*</span></h4>
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

<script>
  $(function() {

    var pgurl = BASE_URL_BACKEND + '/complete';
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


    $(".js-example-basic-multiple").prop("disabled", true);
    $('.js-example-basic-multiple').select2({
      maximumSelectionLength: 2
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
</script>