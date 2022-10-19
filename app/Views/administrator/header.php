<div class="backendheader-user">
  <div class="backend-noti">
    <a href="javascript:void(0)" class="btn-noti"><i class="bi bi-bell-fill"></i> <span class="noti-alert"></span></a>

    <div class="noti-box" style="display: none;">
      <div class="noti-box-overlay"></div>
      <div class="noti-box-content">
        <div class="noti-box-title">การแจ้งเตือน <a href="javascript:void(0)" class="noti-box-close">
            <i class="bi bi-x"></i>
          </a></div>
        <div class="noti-box-txt">
          <ul>
            <li><a href="#">ข้อมูลใบสมัครของท่านอาจยังไม่สมบูรณ์ โปรดดูรายละเอียด เพื่อแก้ไขและส่งใบสมัครอีกครั้ง</a></li>
            <li><a href="#">ใบสมัครของท่านผ่านการอนุมัติ โปรดกรอกข้อมูลแบบประเมินขั้นต้น (Pre-screen)</a></li>
            <li><a href="#">ข้อมูลแบบประเมินขั้นต้น (Pre-screen) ของท่านไม่ผ่านเกณฑ์</a></li>
            <li><a href="#">แจ้งผลการประเมินขั้นต้น (Pre-screen) ของท่านเรียบร้อยแล้ว</a></li>
            <li><a href="#">แจ้งผลการประเมินรอบลงพื้นที่ของท่านเรียบร้อยแล้ว</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="backend-userlogin">
    <a href="javascript:void(0)" class="btn-user">Hi, <?= session()->user ?> <span class="user-icon"><?= strtoupper(substr(session()->user,0,1)); ?></span></a>

    <div class="user-box" style="display: none;">
      <div class="user-box-overlay"></div>
      <div class="user-box-content">
        <div class="user-box-title">ผู้ใช้งาน <a href="javascript:void(0)" class="user-box-close">
            <i class="bi bi-x"></i>
          </a></div>
        <div class="user-box-txt">
          <?php //pp(session()->get()) ?>
          <div class="user-status">
            <div class="user-status-img">
              <div class="status-img">
                <div class="status-img-scale">
                  <img src="<?= base_url() ?>/<?= session()->profile ?>">
                </div>
              </div>
            </div>
            <div class="user-status-txt">
              <p class="username"><?= session()->user ?></p>
              <p class="useridentity"><?= roleName(session()->role) ?></p>
              <p class="usermail"><?= session()->account ?></p>
              <a href="<?= base_url('auth/logout') ?>" class="userlogout">ออกจากระบบ</a>
            </div>
          </div>
          <div class="user-profile">
            <a href="#"><i class="bi bi-person-fill"></i>&nbsp;&nbsp;ข้อมูลส่วนตัว</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  jQuery(document).ready(function() {
    $('.btn-noti').click(function() {
      $('.noti-box').slideDown(200).addClass('active lockbody');
    });
    $('.noti-box-close').click(function() {
      $('.noti-box').slideUp(200).removeClass('active lockbody');
    });
    $('.noti-box-overlay').click(function() {
      $('.noti-box').slideUp(200).removeClass('active lockbody');
    });
  });
  //--------------------------------------------------------------------------------------------//
  jQuery(document).ready(function() {
    $('.btn-user').click(function() {
      $('.user-box').slideDown(100).addClass('active lockbody');
    });
    $('.user-box-close').click(function() {
      $('.user-box').slideUp(100).removeClass('active lockbody');
    });
    $('.user-box-overlay').click(function() {
      $('.user-box').slideUp(100).removeClass('active lockbody');
    });
  });
</script>