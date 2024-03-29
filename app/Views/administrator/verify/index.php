<style>
  .form-input-content {
    height: 100%;
    display: flex;
    justify-content: center;
    flex-direction: column;
  }

  .justify-content-center {
    justify-content: center !important;
  }

  .login-bg {
    background-image: url('<?php echo base_url('backend/assets/images/background-2.png') ?>');
    height: 100%;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
  }

  body.swal2-height-auto {
    height: 100vh !important;
  }
</style>
<div class="login-bg h-100">
  <div class="container h-100">
    <div class="row justify-content-center h-100">
      <div class="col-md-4">
        <div class="form-input-content">
          <div class="card card-login page_security_card">
            <div class="card-header text-center page_security_header page_login" style="padding: 15px;">
              <!-- <h3 class="mb-0">Matex</h3> -->
              <img src="<?php echo base_url('backend/assets/images/logo-compact.png?v=1') ?>" alt="Tourismaward" style="width: 70%;">
            </div>
            <div class="card-body pt-0">
              <form id="form_input" action="" method="post">
                <input type="hidden" id="type" name="type" value="<?= @$type ?>">
                <input type="hidden" id="code" name="code" value="<?= @$code ?>">
                <div class="form-group mb-4">
                  <h4 id="title_name"><?= @$title_name ?></h4>
                </div>
                <div class="form-group mb-4">
                  <input type="text" id="username" name="username" class="form-control border-dark" placeholder="ชื่อผู้ใช้" value="<?= @$result->username ?>" readonly>
                </div>
                <div class="form-group mb-4">
                  <input type="password" id="password" name="password" class="form-control border-dark" placeholder="รหัสผ่าน" value="" required>
                  <div class="invalid-feedback" id="invalid-password">กรุณาระบุรหัสผ่าน</div>
                </div>
                <div class="form-group mb-4">
                  <input type="password" id="confirm_password" name="confirm_password" class="form-control border-dark" placeholder="ยืนยันรหัสผ่าน" value="" required>
                  <div class="invalid-feedback" id="invalid-password">กรุณายืนยันรหัสผ่าน</div>
                </div>
                <button type="button" id="btn_save" class="btn btn-lg border-white gradient-4 gradient-4-hover gradient-4-shadow w-100 waves-effect">บันทึก</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Toastr -->
<script src="<?php echo base_url() ?>/assets/plugins/toastr/toastr.min.js"></script>

<script>
  $(function() {
    $('#btn_save').click(function(e) {
      if (main_validated('form_input') && validated()) {
        let formData = new FormData($('#form_input')[0]);
        var url = '<?= base_url('administrator/VerifyPassword/savePassword') ?>';
        $('#form_input').attr('action', url);
        // console.log(url);
        $('#form_input').submit();
      }
    });

    function validated() {
      var number = /([0-9])/;
      var alphabets = /([a-z])/;
      var alphabets_upper = /([A-Z])/;

      if ($('#password').val() == "") {
        Swal.fire(
          'ผิดพลาด!',
          'กรุณาระบุรหัสผ่าน',
          'error'
        )
        return false;
      }

      if ($('#password').val().length < 6 || !$('#password').val().match(alphabets) || !$('#password').val().match(alphabets_upper) || !$('#password').val().match(number)) {
        Swal.fire(
          'ผิดพลาด!',
          'กรุณาระบุรหัสผ่านมากกว่า 6 ตัวอักษร ประกอบไปด้วย ตัวเลข และ ตัวอักษรภาษาอังกฤษ (0-9,a-z,A-Z)',
          'error'
        )
        return false;
      }

      if ($('#confirm_password').val() == "") {
        Swal.fire(
          'ผิดพลาด!',
          'กรุณายืนยันรหัสผ่าน',
          'error'
        )
        return false;
      }

      if ($('#password').val() != $('#confirm_password').val()) {
        Swal.fire(
          'ผิดพลาด!',
          'รหัสผ่านไม่ตรงกันกรุณาระบุรหัสผ่านอีกครั้ง',
          'error'
        )
        return false;
      }
      return true;
    }

    function main_validated(form_id) {
      let return_ = true;
      $('#' + form_id).addClass('was-validated');
      if (return_) {
        $('#' + form_id + ' input:text, #' + form_id + ' [type="datetime-local"], #' + form_id + ' [type="number"], #' + form_id + ' textarea, #' + form_id + ' .selectpicker').each(function(index) {
          $(this).val($.trim($(this).val()));
          if ($(this).is(':required') && $(this).val() == '') {
            if ($(this).hasClass('datepicker')) {
              // $(this).addClass('is-invalid');
            }
            $(this).focus();
            return_ = false;
            toastr.error('กรุณาตรวจสอบข้อมูลที่จำเป็นต้องระบุ');
            return false;
          }
        });
      }
      return return_;
    }
  });
</script>