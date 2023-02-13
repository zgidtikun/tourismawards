<style>
  #btn_back_1,
  #btn_back_2,
  #btn_back_3,
  #btn_back_4,
  #btn_back_5 {
    display: none;
  }
</style>
<div class="backendcontent forminput">
  <div class="backendcontent-row">
    <div class="backendcontent-title">
      <div class="backendcontent-title-txt">
        <h3>ข้อมูลผลงาน</h3>
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
          <p>ชื่อสถานประกอบการ : <?= $result->attraction_name_th ?></p>
          <p>ชื่อสถานประกอบการภาษาอังกฤษ : <?= $result->attraction_name_en ?></p>
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


<div class="backendcontent forminput">
  <div class="backendcontent-row">
    <div class="backendcontent-title">
      <div class="backendcontent-title-txt">
        <h3>รายชื่อคณะกรรมการรอบลงพื้นที่</h3>
      </div>
    </div>

    <div class="backendform">

      <form id="input_form">
        <input type="hidden" name="insert_id" id="insert_id" value="<?= @$committees->id ?>">
        <input type="hidden" name="users_id" id="users_id" value="<?= $result->created_by ?>">
        <input type="hidden" name="application_form_id" id="application_form_id" value="<?= $result->id ?>">
        <div class="backendform-row">
          <div class="backendform-col3">
            <label data-tab="1">1. Tourism Excellence (Product/Service) <span class="required">*</span></label>
            <div class="editjudge-out">
              <select class="js-example-basic-multiple" id="status_1" name="tourism[]" multiple>
                <?php
                if (!empty($status_1)) {
                  foreach ($status_1 as $key => $value) {
                    $selected = "";
                    if (!empty($committees->admin_id_tourism)) {
                      $admin_id = json_decode($committees->admin_id_tourism);
                      if (in_array($value->id, $admin_id)) {
                        $selected = "selected";
                      }
                    }
                ?>
                    <option value="<?= $value->id ?>" <?= $selected; ?>><?= $value->name ?> <?= $value->surname ?></option>
                <?php
                  }
                }
                ?>
              </select>
            </div>
          </div>

          <div class="backendform-col3">
            <label data-tab="2">2. Supporting Business & Marketing Factors <span class="required">*</span></label>
            <div class="editjudge-out">
              <select class="js-example-basic-multiple" id="status_2" name="supporting[]" multiple>
                <?php
                if (!empty($status_2)) {
                  foreach ($status_2 as $key => $value) {
                    $selected = "";
                    if (!empty($committees->admin_id_supporting)) {
                      $admin_id = json_decode($committees->admin_id_supporting);
                      if (in_array($value->id, $admin_id)) {
                        $selected = "selected";
                      }
                    }
                ?>
                    <option value="<?= $value->id ?>" <?= $selected; ?>><?= $value->name ?> <?= $value->surname ?></option>
                <?php
                  }
                }
                ?>
              </select>
            </div>
          </div>

          <div class="backendform-col3">
            <label data-tab="3">3. Responsibility and Safety & Health Administration <span class="required">*</span></label>
            <div class="editjudge-out">
              <select class="js-example-basic-multiple" id="status_3" name="responsibility[]" multiple>
                <?php
                if (!empty($status_3)) {
                  foreach ($status_3 as $key => $value) {
                    $selected = "";
                    if (!empty($committees->admin_id_responsibility)) {
                      $admin_id = json_decode($committees->admin_id_responsibility);
                      if (in_array($value->id, $admin_id)) {
                        $selected = "selected";
                      }
                    }
                ?>
                    <option value="<?= $value->id ?>" <?= $selected; ?>><?= $value->name ?> <?= $value->surname ?></option>
                <?php
                  }
                }
                ?>
              </select>
            </div>
          </div>
        </div>

        <div class="form-main-btn">
          <a href="javascript: history.back(1)" class="btn-cancle">ยกเลิก</a>
          <a href="javascript:void(0)" class="btn-save" id="btn_save" data-tab="1">บันทึก</a>
        </div>
      </form>

    </div>
  </div>
</div>

<div class="backendcontent">
  <div class="backendcontent-row">
    <div class="regis-form-step" style="grid-template-columns: repeat(3, 1fr);">
      <?php
      $i = 1;
      // pp($assessment_group);
      foreach ($assessment_group as $key => $value) {
        $active = "";
        if ($i == 1) {
          $active = "active";
        }
      ?>
        <a id="<?= $i ?>" href="javascript:void(0);" class="btn-form-step <?= $active ?>"><?= ($key + 1) ?>. <?= $value->name ?></a>
      <?php
        $i++;
      }
      ?>
    </div>

    <div class="sections regis-form-data">

      <div class="content content1 active">
        <div class="regis-form-data">
          <div class="regis-form-data-row">
            <div class="regis-form-data-col1 title">
              <h3>
                <picture>
                  <source srcset="<?= base_url() ?>/assets/images/formicon-type.svg">
                  <img src="<?= base_url() ?>/assets/images/formicon-type.png">
                </picture>
                Tourism Excellence<br><span class="txt-yellow title-comment">คำถามทั้งหมด <span id="question_count_1"><?= count($question[1]) ?></span> ข้อ</span>
              </h3>

              <div class="choicebox">
                <div class="choicebox-col select-choice">
                  คำถามข้อที่ <span id="question_no_1">1</span>
                </div>
                <div class="choicebox-col">
                  <a href="javascript:void(0)" class="btn-choice"><i class="bi bi-toggles"></i></a>
                </div>
              </div>

              <div class="hide-choice" style="display: none;">
                <div class="hide-choice-overlay"></div>
                <div class="hide-choice-box">
                  <div class="hide-choice-title">
                    รายการคำถาม <a href="javascript:void(0)" class="btn-choice-close"><i class="bi bi-x"></i></a>
                  </div>
                  <div class="hide-choice-content">
                    <ul>
                      <?php foreach ($question[1] as $key => $value) : ?>
                        <li><a href="javascript:void(0)" onclick="change_no(this, 1, '<?= $key ?>')" class="select_no_1" id="select_no_1_<?= $key + 1 ?>"> ข้อที่ <?= $key + 1 ?> </a></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
                <script>
                  jQuery(document).ready(function() {
                    $('.btn-choice').click(function() {
                      $('.hide-choice').show();
                      $('body').addClass('lockbody');
                    });
                    $('.btn-choice-close').click(function() {
                      $('.hide-choice').hide();
                      $('body').removeClass('lockbody');
                    });
                    $('.hide-choice-overlay').click(function() {
                      $('.hide-choice').hide();
                      $('body').removeClass('lockbody');
                    });
                  });
                </script>
              </div>

            </div>

            <div class="regis-form-data-col1 inputfield">
              <h4 id="question_name_1">1. <?= $question[1][0]->question ?></h4>
              <div style="margin-bottom: 10px;">
                ระบุคำตอบ<span class="required"> *</span> <span class="commentrequired">(จำนวนตัวอักษรคงเหลือ <span id="charNum_1">1,000</span>/1,000)</span>
              </div>
              <div>
                <textarea rows="6" id="reply_1" onkeyup="countChar(this, 'charNum_1')" readonly></textarea>
              </div>
            </div>

            <div class="regis-form-data-col2 attachfile">
              <div class="attachinp">
                <h4>แนบรูปภาพ</h4>

                <div class="ablumbox" id="ablumbox_1">
                  <h5 class="text-danger"><i>ไม่ได้แนบรูปภาพ</i></h5>
                </div>
              </div>
            </div>

            <div class="regis-form-data-col2 attachfile">
              <div class="attachinp">
                <h4>แนบไฟล์เอกสาร</h4>
                <div class="ablumbox" id="paper_1">
                  <h5 class="text-danger"><i>ไม่ได้แนบเอกสาร</i></h5>
                </div>
              </div>
            </div>

            <div class="regis-form-data-col attachfile remark_text_1">
              <div id="qRemark" class="alert alert-info fs-18 mt-3" role="alert">หมายเหตุ : <span id="remark_text_1"><?= $question[1][0]->remark ?></span></div>
            </div>
          </div>

          <div class="regis-form-data-row">
            <div class="regis-form-data-col1 continue">
              <button type="button" class="btn-next" id="btn_back_1" onclick="btn_back(this, 1)" no="<?= count($question[1]) ?>">ย้อนกลับ</button>
              <button type="button" class="btn-next" id="btn_next_1" onclick="btn_next(this, 1)" no="1">ถัดไป</button>
            </div>

          </div>
        </div>
      </div>

      <div class="content content2">
        <div class="regis-form-data">
          <div class="regis-form-data-row">
            <div class="regis-form-data-col1 title">
              <h3>
                <picture>
                  <source srcset="<?= base_url() ?>/assets/images/formicon-type.svg">
                  <img src="<?= base_url() ?>/assets/images/formicon-type.png">
                </picture>
                Supporting Business & Marketing Factors<br><span class="txt-yellow title-comment">คำถามทั้งหมด <span id="question_count_2"><?= count($question[2]) ?></span> ข้อ</span>
              </h3>

              <div class="choicebox">
                <div class="choicebox-col select-choice">
                  คำถามข้อที่ <span id="question_no_2">1</span>
                </div>
                <div class="choicebox-col">
                  <a href="javascript:void(0)" class="btn-choice"><i class="bi bi-toggles"></i></a>
                </div>
              </div>

              <div class="hide-choice" style="display: none;">
                <div class="hide-choice-overlay"></div>
                <div class="hide-choice-box">
                  <div class="hide-choice-title">
                    รายการคำถาม <a href="javascript:void(0)" class="btn-choice-close"><i class="bi bi-x"></i></a>
                  </div>
                  <div class="hide-choice-content">
                    <ul>
                      <?php foreach ($question[2] as $key => $value) : ?>
                        <li><a href="javascript:void(0)" onclick="change_no(this, 2, '<?= $key ?>')" class="select_no_2" id="select_no_2_<?= $key + 1 ?>"> ข้อที่ <?= $key + 1 ?> </a></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
                <script>
                  jQuery(document).ready(function() {
                    $('.btn-choice').click(function() {
                      $('.hide-choice').show();
                      $('body').addClass('lockbody');
                    });
                    $('.btn-choice-close').click(function() {
                      $('.hide-choice').hide();
                      $('body').removeClass('lockbody');
                    });
                    $('.hide-choice-overlay').click(function() {
                      $('.hide-choice').hide();
                      $('body').removeClass('lockbody');
                    });
                  });
                </script>
              </div>

            </div>

            <div class="regis-form-data-col1 inputfield">
              <h4 id="question_name_2">1. <?= $question[2][0]->question ?></h4>
              <div style="margin-bottom: 10px;">
                ระบุคำตอบ<span class="required"> *</span> <span class="commentrequired">(จำนวนตัวอักษรคงเหลือ <span id="charNum_2">1,000</span>/1,000)</span>
              </div>
              <div>
                <textarea rows="6" id="reply_2" onkeyup="countChar(this, 'charNum_2')" readonly></textarea>
              </div>
            </div>

            <div class="regis-form-data-col2 attachfile">
              <div class="attachinp">
                <h4>แนบรูปภาพ</h4>

                <div class="ablumbox" id="ablumbox_2">
                  <h5 class="text-danger"><i>ไม่ได้แนบรูปภาพ</i></h5>
                </div>
              </div>
            </div>

            <div class="regis-form-data-col2 attachfile">
              <div class="attachinp">
                <h4>แนบไฟล์เอกสาร</h4>
                <div class="ablumbox" id="paper_2">
                  <h5 class="text-danger"><i>ไม่ได้แนบเอกสาร</i></h5>
                </div>
              </div>
            </div>

            <div class="regis-form-data-col attachfile remark_text_2">
              <div id="qRemark" class="alert alert-info fs-18 mt-3" role="alert">หมายเหตุ : <span id="remark_text_2"><?= $question[2][0]->remark ?></span></div>
            </div>
          </div>

          <div class="regis-form-data-row">
            <div class="regis-form-data-col1 continue">
              <button type="button" class="btn-next" id="btn_back_2" onclick="btn_back(this, 2)" no="<?= count($question[2]) ?>">ย้อนกลับ</button>
              <button type="button" class="btn-next" id="btn_next_2" onclick="btn_next(this, 2)" no="1">ถัดไป</button>
            </div>

          </div>
        </div>
      </div>

      <div class="content content3">
        <div class="regis-form-data">
          <div class="regis-form-data-row">
            <div class="regis-form-data-col1 title">
              <h3>
                <picture>
                  <source srcset="<?= base_url() ?>/assets/images/formicon-type.svg">
                  <img src="<?= base_url() ?>/assets/images/formicon-type.png">
                </picture>
                Responsibility and Safety & Health Administration<br><span class="txt-yellow title-comment">คำถามทั้งหมด <span id="question_count_3"><?= count($question[3]) ?></span> ข้อ</span>
              </h3>

              <div class="choicebox">
                <div class="choicebox-col select-choice">
                  คำถามข้อที่ <span id="question_no_3">1</span>
                </div>
                <div class="choicebox-col">
                  <a href="javascript:void(0)" class="btn-choice"><i class="bi bi-toggles"></i></a>
                </div>
              </div>

              <div class="hide-choice" style="display: none;">
                <div class="hide-choice-overlay"></div>
                <div class="hide-choice-box">
                  <div class="hide-choice-title">
                    รายการคำถาม <a href="javascript:void(0)" class="btn-choice-close"><i class="bi bi-x"></i></a>
                  </div>
                  <div class="hide-choice-content">
                    <ul>
                      <?php foreach ($question[3] as $key => $value) : ?>
                        <li><a href="javascript:void(0)" onclick="change_no(this, 3, '<?= $key ?>')" class="select_no_3" id="select_no_3_<?= $key + 1 ?>"> ข้อที่ <?= $key + 1 ?> </a></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
                <script>
                  jQuery(document).ready(function() {
                    $('.btn-choice').click(function() {
                      $('.hide-choice').show();
                      $('body').addClass('lockbody');
                    });
                    $('.btn-choice-close').click(function() {
                      $('.hide-choice').hide();
                      $('body').removeClass('lockbody');
                    });
                    $('.hide-choice-overlay').click(function() {
                      $('.hide-choice').hide();
                      $('body').removeClass('lockbody');
                    });
                  });
                </script>
              </div>

            </div>

            <div class="regis-form-data-col1 inputfield">
              <h4 id="question_name_3">1. <?= $question[3][0]->question ?></h4>
              <div style="margin-bottom: 10px;">
                ระบุคำตอบ<span class="required"> *</span> <span class="commentrequired">(จำนวนตัวอักษรคงเหลือ <span id="charNum_3">1,000</span>/1,000)</span>
              </div>
              <div>
                <textarea rows="6" id="reply_3" onkeyup="countChar(this, 'charNum_3')" readonly></textarea>
              </div>
            </div>

            <div class="regis-form-data-col2 attachfile">
              <div class="attachinp">
                <h4>แนบรูปภาพ</h4>

                <div class="ablumbox" id="ablumbox_3">
                  <h5 class="text-danger"><i>ไม่ได้แนบรูปภาพ</i></h5>
                </div>
              </div>
            </div>

            <div class="regis-form-data-col2 attachfile">
              <div class="attachinp">
                <h4>แนบไฟล์เอกสาร</h4>
                <div class="ablumbox" id="paper_3">
                  <h5 class="text-danger"><i>ไม่ได้แนบเอกสาร</i></h5>
                </div>
              </div>
            </div>

            <div class="regis-form-data-col attachfile remark_text_3">
              <div id="qRemark" class="alert alert-info fs-18 mt-3" role="alert">หมายเหตุ : <span id="remark_text_3"><?= $question[3][0]->remark ?></span></div>
            </div>
          </div>

          <div class="regis-form-data-row">
            <div class="regis-form-data-col1 continue">
              <button type="button" class="btn-next" id="btn_back_3" onclick="btn_back(this, 3)" no="<?= count($question[3]) ?>">ย้อนกลับ</button>
              <button type="button" class="btn-next" id="btn_next_3" onclick="btn_next(this, 3)" no="1">ถัดไป</button>
            </div>

          </div>
        </div>
      </div>

    </div>

  </div>
</div>

<textarea id="data_question" style="display: none;"><?php echo json_encode($question) ?></textarea>
<input type="hidden" id="created_by" value="<?= $result->created_by ?>">
<script>
  $(function() {
    var question = JSON.parse($('#data_question').val());
    // cc(question)
    add_aws(question[1][0].id, 1);
    add_aws(question[2][0].id, 2);
    add_aws(question[3][0].id, 3);

    $('.select_no_1').eq(0).addClass('active');
    $('.select_no_3').eq(0).addClass('active');
    $('.select_no_3').eq(0).addClass('active');

    var pgurl = BASE_URL_BACKEND + '/onsite';
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

    $('.js-example-basic-multiple').select2({
      // maximumSelectionLength: 2
    });
  });

  $('#btn_save').click(function(e) {
    if (validated()) {
      var insert_id = $('#insert_id').val();
      if (insert_id == 0 || insert_id == "") {
        var res = main_save(BASE_URL_BACKEND + '/onsite/saveInsert', '#input_form');
        res_swal(res, 0, function() {
          if (res.type == 'success') {
            window.location.href = BASE_URL_BACKEND + '/onsite/estimate';
          }
        });
      } else {
        var res = main_save(BASE_URL_BACKEND + '/onsite/saveUpdate', '#input_form');
        res_swal(res, 0, function() {
          if (res.type == 'success') {
            window.location.href = BASE_URL_BACKEND + '/onsite/estimate';
          }
        });
      }
    }
  });

  function validated() {
    var status_1 = $('#status_1 option:selected').map(function(i, e) {
      return $(e).val();
    }).get();

    var status_2 = $('#status_2 option:selected').map(function(i, e) {
      return $(e).val();
    }).get();

    var status_3 = $('#status_3 option:selected').map(function(i, e) {
      return $(e).val();
    }).get();

    if (status_1.length < 1) {
      toastr.error('กรุณาระบุกรรมการสำหรับ Tourism Excellence อย่างน้อย 1 คน');
      return false;
    }

    if (status_2.length < 1) {
      toastr.error('กรุณาระบุกรรมการสำหรับ Supporting Business อย่างน้อย 1 คน');
      return false;
    }

    if (status_3.length < 1) {
      toastr.error('กรุณาระบุกรรมการสำหรับ Responsibility อย่างน้อย 1 คน');
      return false;
    }

    return true;
  }

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

  function countChar(val, charNum) {
    var len = val.value.length;
    if (len >= 1000) {
      val.value = val.value.substring(0, 1000);
    } else {
      $('#' + charNum).text(1000 - len);
    }
  };

  function add_aws(id, tab) {
    var data = {
      id: id,
      created_by: $('#created_by').val()
    }
    var res = main_post(BASE_URL_BACKEND + '/onsite/getAnswer', data);
    $('#reply_' + tab).val(res.reply).keyup();

    var ablumbox = '';
    var paper = '';
    $.each(JSON.parse(res.pack_file), function(index, value) {
      if (value.file_position == "images") {
        ablumbox += `<div class="ablumbox-col">
                      <div class="ablum-mainimg">
                        <div class="ablum-mainimg-scale">
                          <img src="<?= base_url() ?>/` + value.file_path + `" title="` + value.file_original + `" class="ablum-img" onclick="view_img(this)">
                        </div>
                      </div>
                    </div>`;
      }

      if (value.file_position == "paper") {
        paper += `<div class="card card-body mb-2">
                    <div class="bs-row">
                      <div class="col-12"> <span class="fs-file-name">` + value.file_original + ` (` + value.file_size + ` Mb)</span>
                        <a href="<?= base_url() ?>/` + value.file_path + `" class="float-end pointer" title="โหลดไฟล์" target="_blank"><i class="bi bi-download"></i></a>
                      </div>
                    </div>
                  </div>`;
      }

    });
    $('#paper_' + tab).html(paper);
    $('#ablumbox_' + tab).html(ablumbox);
  }

  function change_no(elm, tab, id) {
    var question = JSON.parse($('#data_question').val());
    $('.select_no_' + tab).removeClass('active');
    $(elm).addClass('active');
    var no = Number(id) + Number(1);
    $(question).filter(function(index) {
      $('#question_name_' + tab).html(no + '. ' + question[tab][id].question);
      if (question[tab][id].remark != "") {
        $('.remark_text_' + tab).show();
        $('#remark_text_' + tab).html(question[tab][id].remark);
      } else {
        $('.remark_text_' + tab).hide();
      }

      $('#question_no_' + tab).html(no);
      $('#btn_next_' + tab).attr('no', no);
      $('#btn_back_' + tab).attr('no', no);

      var question_count = $('#question_count_' + tab).text();
      if (no <= 1) {
        $('#btn_back_' + tab).hide();
        $('#btn_next_' + tab).show();
      } else if (no == question_count) {
        $('#btn_next_' + tab).hide();
        $('#btn_back_' + tab).show();
      } else {
        $('#btn_back_' + tab).show();
        $('#btn_next_' + tab).show();
      }
      add_aws(question[tab][id].id, tab);
    });

    $('.hide-choice').hide();
    $('body').removeClass('lockbody');
  }

  function btn_back(elm, tab) {
    var id = $(elm).attr('no');
    var no = Number(id) - Number(1);
    $('#select_no_' + tab + '_' + no).click();
    if (no <= 1) {
      $('#btn_back_' + tab).attr('no', 1);
      $('#btn_next_' + tab).attr('no', 1);
      $('#btn_back_' + tab).hide();
    } else {
      $('#btn_back_' + tab).attr('no', no);
      $('#btn_next_' + tab).attr('no', no);
      $('#btn_next_' + tab).show();
    }
  }

  function btn_next(elm, tab) {
    var id = $(elm).attr('no');
    var no = Number(id) + Number(1);
    var question_count = $('#question_count_' + tab).text();
    $('#select_no_' + tab + '_' + no).click();
    if (no >= question_count) {
      $('#btn_back_' + tab).attr('no', question_count);
      $('#btn_next_' + tab).attr('no', question_count);
      $('#btn_next_' + tab).hide();
    } else {
      $('#btn_next_' + tab).attr('no', no);
      $('#btn_back_' + tab).attr('no', no);
      $('#btn_back_' + tab).show();
    }
  }
</script>