<div class="backendcontent">
  <div class="backendcontent-row">
    <div class="backendcontent-title">
      <div class="backendcontent-title-txt">
        <h3>ข้อมูลทั่วไป</h3>
      </div>
    </div>

    <div class="backendform">
      <form id="input_form">
        <input type="hidden" name="insert_id" id="insert_id" value="<?= @$result->id ?>">

        <div class="backendform-row">
          <div class="backendform-col subject">
            รูปผู้ใช้งาน
          </div>
          <div class="backendform-col inpfield">
            <!-- <form id="multiple1"> -->
            <div class="formrow">
              <button type="button" class="btn btn-success fileup-btn">
                Attach files
                <input type="file" name="profile" id="profile" required>
                <input type="hidden" name="profile_old" id="profile_old" value="<?= @$result->profile ?>">
              </button>
            </div>
            <span class="required">(file type: jpg , png , gif)</span>
            <?php
            if (!empty($result->profile) && $result->profile != "") {
              $style = '';
              $path = base_url() . '/' . $result->profile;
              $name = explode('/', $result->profile);
              $name = end($name);
            } else {
              $style = 'style="display: none;"';
              $path = base_url('/backend/assets/images/add_img.png');
              $name = "";
            }
            ?>
            <div id="upload_data" class="queue" <?= $style ?>>
              <div id="data_img_upload" class="fileup-file fileup-image">
                <div class="fileup-preview">
                  <img src="<?= $path ?>" id="profile_show">
                </div>
                <div class="fileup-container">
                  <div class="fileup-description"><span class="fileup-name"><?= @$name ?></span> <span class="fileup-size"></span></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="backendform-row">
          <div class="backendform-col subject">
            คำนำหน้า <span class="required">*</span>
          </div>
          <div class="backendform-col inpfield">
            <select name="prefix" id="prefix" class="form-control">
              <option value="นาย" <?= (@$result->prefix == 'นาย') ? 'selected' : ''; ?>>นาย</option>
              <option value="นาง" <?= (@$result->prefix == 'นาง') ? 'selected' : ''; ?>>นาง</option>
              <option value="นางสาว" <?= (@$result->prefix == 'นางสาว') ? 'selected' : ''; ?>>นางสาว</option>
            </select>
          </div>
        </div>

        <div class="backendform-row">
          <div class="backendform-col subject">
            ชื่อ <span class="required">*</span>
          </div>
          <div class="backendform-col inpfield">
            <input type="text" name="name" id="name" class="form-control" value="<?= @$result->name ?>" placeholder="" required>
          </div>
        </div>

        <div class="backendform-row">
          <div class="backendform-col subject">
            นามสกุล <span class="required">*</span>
          </div>
          <div class="backendform-col inpfield">
            <input type="text" name="surname" id="surname" class="form-control" value="<?= @$result->surname ?>" placeholder="" required>
          </div>
        </div>

        <div class="backendform-row">
          <div class="backendform-col subject">
            อีเมล <span class="required">*</span>
          </div>
          <div class="backendform-col inpfield">
            <input type="text" name="email" id="email" class="form-control" value="<?= @$result->email ?>" placeholder="" required>
          </div>
        </div>

        <div class="backendform-row password">
          <div class="backendform-col subject">
            รหัสผ่าน
          </div>
          <div class="backendform-col inpfield">
            <input type="password" name="password" id="password" class="form-control" value="" placeholder="">
          </div>
        </div>


        <div class="backendform-row">
          <div class="backendform-col subject">
            เบอร์ติดต่อ
          </div>
          <div class="backendform-col inpfield">
            <input type="number" name="mobile" id="mobile" class="form-control" maxlength="10" value="<?= @$result->mobile ?>" placeholder="">
          </div>
        </div>

        <!-- <div class="backendform-row">
          <div class="backendform-col subject">
            ตำแหน่งงาน <span class="required">*</span>
          </div>
          <div class="backendform-col inpfield">
            <input type="text" name="position" id="position" class="form-control" value="<?= @$result->position ?>" placeholder="" required>
          </div>
        </div> -->

        <div class="backendform-row">
          <div class="backendform-col subject">
            ฝ่ายรับผิดชอบ <span class="required">*</span>
          </div>
          <div class="backendform-col inpfield">
            <select name="award_type" id="award_type" class="form-control">
              <?php
              if (!empty($award_type)) {
                foreach ($award_type as $key => $value) {
              ?>
                  <option value="<?= $value->id ?>" <?= ($value->id == @$result->award_type) ? 'selected' : ''; ?>><?= $value->name ?></option>
              <?php
                }
              }
              ?>
            </select>
          </div>
        </div>

      </form>
    </div>

    <div class="form-main-btn">
      <a href="javascript:void(0)" class="btn-cancle" onclick="window.location.href = BASE_URL_BACKEND + '/tat'">ยกเลิก</a>
      <a href="javascript:void(0)" class="btn-save" data-tab="1" id="btn_save">บันทึก</a>
    </div>

  </div>
</div>

<script>
  $(function() {
    var pgurl = BASE_URL_BACKEND + '/tat';
    active_page(pgurl);
  });

  $(function() {
    var insert_id = $('#insert_id').val();
    if (insert_id != "" || insert_id != 0) {
      $('#email').prop('disabled', true);
      $('.password').show();
    } else {
      $('#email').prop('disabled', false);
      $('.password').hide();
    }
  });

  $('#btn_save').click(function(e) {
    var insert_id = $('#insert_id').val();
    if (main_validated('input_form')) {
      if (!isEmail($('#email').val())) {
        toastr.error('กรุณาระบุรูปแบบอีเมลให้ถูกต้อง');
        return false;
      }
      if (insert_id == "" || insert_id == 0) {
        if (validated_email()) {
          toastr.error('E-Mail นี้มีการสมัครเข้าใช้งานแล้ว');
          return false;
        }
        var res = main_save(BASE_URL_BACKEND + '/tat/saveInsert', '#input_form');
        res_swal(res, 0, function() {
          if (res.type == 'success') {
            window.location.href = BASE_URL_BACKEND + '/tat';
          }
        });
      } else {
        if (validated()) {
          var res = main_save(BASE_URL_BACKEND + '/tat/saveUpdate', '#input_form');
          res_swal(res, 0, function() {
            if (res.type == 'success') {
              window.location.href = BASE_URL_BACKEND + '/tat';
            }
          });
        }

      }
    }
  });

  function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }

  function validated() {
    var number = /([0-9])/;
    var alphabets = /([a-z])/;
    var alphabets_upper = /([A-Z])/;

    if ($('#password').val() != "") {
      if ($('#password').val().length < 6 || !$('#password').val().match(alphabets) || !$('#password').val().match(alphabets_upper) || !$('#password').val().match(number)) {
        toastr.error('กรุณาระบุรหัสผ่านมากกว่า 6 ตัวอักษร ประกอบไปด้วย ตัวเลข และ ตัวอักษรภาษาอังกฤษ (0-9,a-z,A-Z)');
        return false;
      }
    }

    return true;
  }

  function validated_email() {
    var email = $('#email').val();
    var res = main_post(BASE_URL_BACKEND + '/admin/checkData', {
      email: email
    });
    return res;
  }

  profile.onchange = evt => {
    const [file] = profile.files
    if (file) {
      $('#upload_data').show();
      $('.fileup-name').html(file.name);
      $('.fileup-size').html('(' + F2C(file.size / 1024) + ' Kb)');
      profile_show.src = URL.createObjectURL(file)
    }
  }
</script>