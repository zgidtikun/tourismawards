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
      <div class="card-header">
        <h3 class="card-title">รายชื่อคณะกรรมการสำหรับประเมินใบสมัคร : รอบประเมินขั้นต้น (Pre-Screen)</h3>
      </div>
      <div class="card-body">
        <form id="input_form">
          <div class="row">

            <input type="hidden" name="users_id" id="users_id" value="">
            <input type="hidden" name="assessment_round" id="assessment_round" value="1">
            <input type="hidden" name="application_form_id" id="application_form_id" value="">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="assessment_group_name_1">1. Tourism Excellence (Product/Service)</label>
                <!-- <textarea class="form-control tagsinput" name="assessment_group_name[1][]" id="assessment_group_name_1" cols="30" rows="4" data-role="tagsinput"></textarea> -->
                <select class="form-control" id="assessment_group_name_1" name="assessment_group_name_1[1][]" multiple="multiple"></select>
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group">
                <label for="assessment_group_name_2">2. Supporting Business & Marketing Factors</label>
                <!-- <textarea class="form-control tagsinput" name="assessment_group_name[2][]" id="assessment_group_name_2" cols="30" rows="4"></textarea> -->
                <select class="form-control" id="assessment_group_name_2" name="assessment_group_name_2[2][]" multiple="multiple"></select>
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group">
                <label for="assessment_group_name_3">3. Responsibility and Safety & Health Administration</label>
                <!-- <textarea class="form-control tagsinput" name="assessment_group_name[3][]" id="assessment_group_name_3" cols="30" rows="4"></textarea> -->
                <select class="form-control" id="assessment_group_name_3" name="assessment_group_name_3[3][]" multiple="multiple"></select>
              </div>
            </div>

          </div>
        </form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary"><i class="fas fa-times"></i> ยกเลิก</button>
        <button type="button" class="btn btn-primary" id="btn_save"><i class="fas fa-save"></i> บันทึก</button>
      </div>

    </div>
  </div>
</div>

<script>
  $(function() {
    get_data_option()
    $('#assessment_group_name_1, #assessment_group_name_2, #assessment_group_name_3').select2({
      maximumSelectionLength: 2,
      tags: true,
      language: {
        maximumSelected: function(e) {
          var t = "สามารถเลือกได้สูงสุด " + e.maximum + " คน / รายการ";
          // e.maximum != 1 && (t += "s");
          return t;
        }
      }
    });
  });

  $('#btn_save').click(function(e) {
    var res = main_post(BASE_URL + '/backend/Directors/saveInsert');
    res_swal(res, 1);
  });

  function get_data_option() {
    var res = main_post(BASE_URL + '/backend/Directors/getAdmin');

    if (res.status_1.length > 0) {
      var html = ``;
      $.each(res.status_1, function(index, value) {
        html += `<option value="` + value.id + `">` + value.name + `</option>`;
      });
      $('#assessment_group_name_1').html(html);
    }

    if (res.status_2.length > 0) {
      var html = ``;
      $.each(res.status_2, function(index, value) {
        html += `<option value="` + value.id + `">` + value.name + `</option>`;
      });
      $('#assessment_group_name_2').html(html);
    }

    if (res.status_3.length > 0) {
      var html = ``;
      $.each(res.status_3, function(index, value) {
        html += `<option value="` + value.id + `">` + value.name + `</option>`;
      });
      $('#assessment_group_name_3').html(html);
    }
  }
</script>