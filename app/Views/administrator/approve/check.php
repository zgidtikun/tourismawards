<div class="row page-titles mx-0">
  <div class="col-sm p-md-0">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('backend/Dashboard') ?>">หน้าแรก</a></li>
      <li class="breadcrumb-item active"><a href="javascript:void(0)"><?= $title ?></a></li>
    </ol>
  </div>
  <div class="col-sm p-md-0 mt-2 mt-sm-0 justify-content-sm-end d-flex">

  </div>
</div>

<div class="row ml-4 mr-4">
  <div class="col-xl-12 col-xxl-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">ข้อมูลใบสมัคร</h3>
      </div>
      <div class="card-body">

        <div class="row">

          <div class="col-sm-4">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="name">รหัสใบสมัคร :</label>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label for="">ชื่อ :</label>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label for="">Name :</label>
              </div>
            </div>
          </div>

          <div class="col-sm-4">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="name">ประเภท :</label>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label for="">สาขา :</label>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label for="">วันที่ส่งใบสมัคร :</label>
              </div>
            </div>
          </div>

          <div class="col-sm-4">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="name">ชื่อ - นามสกุล :</label>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label for="">อีเมล :</label>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label for="">เบอร์ติดต่อ :</label>
              </div>
            </div>
          </div>

        </div>


      </div>
    </div>
  </div>
</div>

<div class="row ml-4 mr-4">
  <div class="col-xl-12 col-xxl-12">
    <div class="card">
      <div class="card-body">

        <div class="">
          <div class="tabs">
            <button class="btn_nev btn1 active" id="1">1. เลือกประเภทการสมัคร <i class="fas fa-check-circle text-success"></i> </button>
            <button class="btn_nev btn2" id="2">2. ข้อมูลผลงาน</button>
            <button class="btn_nev btn3" id="3">3. ข้อมูลหน่วยงาน/บริษัท</button>
            <button class="btn_nev btn4" id="4">4. ข้อมูลผู้ประสานงาน</button>
            <button class="btn_nev btn5" id="5">5. คุณสมบัติเบื้องต้น / เอกสารประกอบการสมัคร</button>
          </div>
          <div class="sections">
            <div class="content content1 active">
              <h4><strong><i class="fas fa-file-alt text-primary"></i> ประเภทที่ต้องการสมัครประกวดรางวัลอุตสาหกรรมการท่องเที่ยวไทย</strong></h4>

              <h4>กรุณาเลือกประเภทที่สอดคล้องกับการดำเนินงานและกลุ่มลูกค้าของท่านมากที่สุด <span class="text-danger">*</span> </h4>
              <div class="form-group">
                <?php
                if (!empty($application_type)) :
                  foreach ($application_type as $key => $value) :
                    $checked = "";
                    if ($key == 0) {
                      $checked = "checked";
                    }
                ?>
                    <div class="icheck-peterriver">
                      <input type="radio" id="application_type_<?= $value->id ?>" name="application_type" value="<?= $value->id ?>" <?= $checked ?>>
                      <label for="application_type_<?= $value->id ?>"> <?= $value->name ?></label>
                    </div>
                <?php
                  endforeach;
                endif;
                ?>
              </div>

              <h4>สาขารางวัล <span class="text-danger">*</span> </h4>
              <div class="form-group" id="option_application_type_sub">
                <?php
                if (!empty($application_type_sub)) :
                  foreach ($application_type_sub as $key => $value) :
                    $checked = "";
                    if ($key == 0) {
                      $checked = "checked";
                    }
                ?>
                    <div class="icheck-peterriver">
                      <input type="radio" id="application_type_sub_<?= $value->id ?>" name="application_type_sub" value="<?= $value->id ?>" <?= $checked ?>>
                      <label for="application_type_sub_<?= $value->id ?>"> <?= $value->name ?></label>
                    </div>
                <?php
                  endforeach;
                endif;
                ?>
              </div>

              <div class="alert alert-warning">
                <h4><i class="fas fa-info-circle"></i> นิยาม</h4>
                <h6>กิจกรรมหรือสถานที่ท่องเที่ยวที่สร้างหรือพัฒนาขึ้น เพื่อเน้นให้ความบันเทิงหรือความสนุกสนาน แก่นักท่องเที่ยว เช่น สวนสนุก สวนน้ำ การแสดงต่างๆ ตลาดน้ำ ตลาดย้อนยุค เป็นต้น</h6>
              </div>

              <h4>อธิบายจุดเด่นของผลงานที่ต้องการส่งเข้าประกวด <span class="text-danger">*</span> </h4>
              <h6>ระบุคำตอบ <span class="text-danger">*</span> <span id="count_total" style="color: #a7a7a7;"></span></h6>
              <div class="col-sm-12">
                <textarea class="form-control" name="highlights" id="highlights" readonly></textarea>
              </div>
            </div>
            <div class="content content2">
              <h2>Heading 2</h2>
            </div>
            <div class="content content3">
              <h2>Heading 3</h2>
            </div>
            <div class="content content4">
              <h2>Heading 4</h2>
            </div>
            <div class="content content5">
              <h2>Heading 5</h2>
            </div>
          </div>
        </div>


      </div>
    </div>
  </div>
</div>

<div class="row ml-4 mr-4">
  <div class="col-xl-12 col-xxl-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">การอนุมัติใบสมัคร</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-3">
            <div class="form-group">
              <label for="name">สถานะ :</label>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <div class="icheck-peterriver d-inline mr-3">
                <input type="radio" id="approve_1" name="approve" value="1" checked>
                <label for="approve_1"> อนุมัติ</label>
              </div>

              <div class="icheck-peterriver d-inline">
                <input type="radio" id="approve_0" name="approve" value="0">
                <label for="approve_0"> ไม่อนุมัติ</label>
              </div>

            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-3">
            <div class="form-group">
              <label for="name">ความคิดเห็น :</label>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <textarea class="form-control" name="" id="" rows="5"></textarea>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary"><i class="fas fa-times"></i> ยกเลิก</button>
        <button type="button" class="btn btn-primary"><i class="fas fa-save"></i> บันทึก</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(function() {
    // Active Menu
    var menu = $('#menu');
    var item = $(menu).find("a[href='<?= base_url() ?>/backend/Approve']");
    var ul = $(item).closest('ul');
    var li = $(ul).closest('li');

    li.find('.has-arrow').attr('aria-expanded', 'true');
    li.addClass('active');
    item.addClass('active');
    $(ul).collapse('toggle');

    count_text($('#highlights'), 'count_total');
  });


  const buttons = document.querySelectorAll("button");
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

  $('[name="application_type"]').change(function(e) {
    var res = main_post(BASE_URL_BACKEND + '/Approve/getAplicationTypeSub/' + $(this).val());
    var html = ``;
    if (!$.isEmptyObject(res)) {
      $.each(res, function(index, value) {
        var checked = "";
        if (index == 0) {
          checked = "checked";
        }
        html += `<div class="icheck-peterriver">
                  <input type="radio" id="application_type_sub_` + value.id + `" name="application_type_sub" value="` + value.id + `" ` + checked + `>
                  <label for="application_type_sub_` + value.id + `"> ` + value.name + `</label>
                </div>`;
      });
    } else {
      html += `<span class="text-danger">ไม่พบสาขารางวัล</span>`;
    }
    $('#option_application_type_sub').html(html);
  });

  function count_text(elm, id) {
    $('#' + id).text("(จำนวนตัวอักษรคงเหลือ " + $(elm).val().length + "/1,000)");
  }
</script>