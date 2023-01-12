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
              <form action="#">
                <div class="form-group mb-4">
                  <h4 id="title_name">เข้าสู่ระบบ</h4>
                </div>
                <div class="form-group mb-4">
                  <input type="text" id="username" class="form-control border-dark" placeholder="ชื่อผู้ใช้" value="<?php if (isset($_COOKIE["username"])) {
                                                                                                                      echo $_COOKIE["username"];
                                                                                                                    } ?>">
                  <div class="invalid-feedback" id="invalid-username"></div>
                </div>
                <div class="form-group mb-4">
                  <input type="password" id="password" class="form-control border-dark" placeholder="รหัสผ่าน" value="">
                  <div class="invalid-feedback" id="invalid-password"></div>
                </div>
                <button class="btn btn-lg border-white gradient-4 gradient-4-hover gradient-4-shadow w-100 waves-effect mb-2" id="btn_login" type="button" onclick="signin.authen()">เข้าสู่ระบบ</button>
                <div class="form-group ml-3">
                  <a href="<?= base_url('forgot-password') ?>" class="mt-2" rel="noopener noreferrer">ลืมรหัสผ่าน</a>
                </div>
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

<?php if (!empty($_recapcha) && $_recapcha) : ?>
  <?= view('_recapcha') ?>
<?php endif; ?>
<script>
  $(function() {
    <?php if (session('success')) { ?>
      toastr.success("<?php echo session('success'); ?>");
    <?php } else if (session('error')) {  ?>
      toastr.error("<?php echo session('error'); ?>");
    <?php } else if (session('warning')) {  ?>
      toastr.warning("<?php echo session('warning'); ?>");
    <?php } else if (session('info')) {  ?>
      toastr.info("<?php echo session('info'); ?>");
    <?php } ?>
  });

  const signin = {
    token: '',
    authen: function() {
      if (this.validation()) {
        <?php if (!empty($_recapcha) && $_recapcha) : ?>
          recapchaToken().then(function(data) {
            signin.token = data.rccToken;
          <?php endif; ?>
          $.ajax({
            method: 'post',
            url: '<?= base_url('auth/check/administrator') ?>',
            data: {
              username: $('#username').val(),
              password: $('#password').val(),
              recapcha_token: signin.token
            },
            dataType: 'json',
            async: false,
            success: function(response) {
              if (response.result == 'success') {
                let url = '<?= base_url('administrator/dashboard') ?>';
                window.location.href = url;
              } else {
                if (response.type == 'recapcha') {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops Login Fail...!',
                    text: response.message,
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops Login Fail...!',
                    text: response.message,
                  });
                  $('#' + response.type).addClass('is-invalid');
                  $('#invalid-' + response.type).html(response.message);
                }
              }
            }
          });
          <?php if (!empty($_recapcha) && $_recapcha) : ?>
          });
        <?php endif; ?>
      }
    },
    validation: function() {
      let valid = true;

      $('#username').removeClass('is-invalid');
      $('#password').removeClass('is-invalid');

      if ($('#username').val() == '') {
        $('#username').addClass('is-invalid');
        $('#invalid-username').html('Plase enter a usernamne.');
        valid = false;
      }

      if ($('#password').val() == '') {
        $('#password').addClass('is-invalid');
        $('#invalid-password').html('Plase enter a password.');
        valid = false;
      }

      return valid;
    }
  }

  $('#password').keyup(function(e) {
    var code = e.key; // recommended to use e.key, it's normalized across devices and languages
    if (code === "Enter") {
      $('#btn_login').click();
    }
  });
</script>