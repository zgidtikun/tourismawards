<div class="row page-titles mx-0">
  <div class="col-sm p-md-0">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('backend/Dashboard') ?>">หน้าแรก</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('backend/User') ?>">ผู้ประกอบการ</a></li>
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
        <h3 class="card-title"><?= $title ?></h3>
      </div>
      <div class="card-body">

        <form id="input_form">
          <input type="hidden" name="insert_id" id="insert_id" value="<?= @$result->id ?>">
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="">ชื่อ - นามสกุล <span class="text-danger">*</span></label>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <input type="text" name="name" id="name" class="form-control" value="<?= @$result->name ?>" placeholder="" required>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <input type="text" name="surname" id="surname" class="form-control" value="<?= @$result->surname ?>" placeholder="" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="">อีเมล <span class="text-danger">*</span></label>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <input type="text" name="email" id="email" class="form-control" value="<?= @$result->email ?>" placeholder="" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="">เบอร์ติดต่อ <span class="text-danger">*</span></label>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <input type="text" name="mobile" id="mobile" class="form-control" value="<?= @$result->mobile ?>" placeholder="" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="">รหัสผ่าน <span class="text-danger">*</span></label>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <input type="password" name="password" id="password" class="form-control" value="" placeholder="">
              </div>
            </div>
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="window.location.href = '<?= base_url('backend/Users') ?>'"><i class="fas fa-times"></i> ยกเลิก</button>
        <button type="button" class="btn btn-primary" id="btn_save"><i class="fas fa-save"></i> บันทึก</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(function() {
    // Active Menu
    var menu = $('#menu');
    var item = $(menu).find("a[href='<?= base_url() ?>/backend/Users']");
    var ul = $(item).closest('ul');
    var li = $(ul).closest('li');

    li.find('.has-arrow').attr('aria-expanded', 'true');
    li.addClass('active');
    item.addClass('active');
    $(ul).collapse('toggle');

    var insert_id = $('#insert_id').val();
    if (insert_id != "" || insert_id != 0) {
      $('#email').prop('disabled', true);
    } else {
      $('#email').prop('disabled', false);
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
        if ($('#password').val() == "") {
          toastr.error('กรุณาระบุรหัสผ่าน');
          return false;
        }
        if (validated_email()) {
          toastr.error('E-Mail นี้มีการสมัครเข้าใช้งานแล้ว');
          return false;
        }
        var res = main_save(BASE_URL + '/backend/Users/saveInsert', '#input_form');
        res_swal(res, 0, function() {
          window.location.href = '<?= base_url('backend/Users') ?>';
        });
      } else {
        var res = main_save(BASE_URL + '/backend/Users/saveUpdate', '#input_form');
        res_swal(res, 0, function() {
          window.location.href = '<?= base_url('backend/Users') ?>';
        });
      }
    }
  });

  function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }

  function validated_email() {
    var email = $('#email').val();
    var res = main_post(BASE_URL + '/backend/Users/checkData', {
      email: email
    });
    return res;
  }
</script>