<div class="backendmenu-box">
  <div class="backendmenu-row">
    <div class="backendmenu-logo">
      <picture>
        <source srcset="<?= base_url() ?>/assets/images/logo.svg">
        <img src="<?= base_url() ?>/assets/images/logo.png" width="372" height="144">
      </picture>
    </div>
    <div class="backendmenu-list">
      <div class="backendmenu-list-row">
        <a href="<?= base_url() ?>/administrator/"><i class="bi bi-layers-fill"></i> สถิติการใช้งาน</a>
      </div>
      <div class="backendmenu-list-row title">เมนูหลัก</div>
      <div class="backendmenu-list-row">
        <a href="javascript:void(0)" class="btn-menulist" data-tab="1"><i class="bi bi-grid-fill"></i>สมาชิก</a>
        <div class="hide-menu-list" data-tab="1">
          <ul>
            <li><a href="<?= base_url() ?>/administrator/Users/all">สมาชิกทั้งหมด</a></li>
            <li><a href="<?= base_url() ?>/administrator/Users">ผู้ประกอบการ</a></li>
            <li><a href="<?= base_url() ?>/administrator/Officer">กรรมการ</a></li>
            <li><a href="<?= base_url() ?>/administrator/TAT">เจ้าหน้าที่ ททท.</a></li>
            <li><a href="<?= base_url() ?>/administrator/Admin">ผู้ดูแลระบบ</a></li>
          </ul>
        </div>
      </div>
      <div class="backendmenu-list-row">
        <a href="javascript:void(0)" class="btn-menulist" data-tab="2"><i class="bi bi-toggles"></i> ขั้นตอนการดำเนินการ</a>
        <div class="hide-menu-list" data-tab="2">
          <ul>
            <li><a href="admin_register.html"><label>ตรวจสอบใบสมัคร<span class="menu-list-amount">24</span></label></a></li>
            <li><a href="admin_personal.html" class="active">ประวัติการตรวจสอบใบสมัคร</a></li>
            <li><a href="admin_prescreen.html">ประเมินขั้นต้น (ผู้ประกอบการ)</a></li>
            <li><a href="admin_addprescreen.html"><label>เพิ่มกรรมการรอบประเมินขั้นต้น  <span class="menu-list-amount">99</span></label></a></li>
            <li><a href="admin_judgeprescreen.html">ประเมินขั้นต้น (กรรมการ)</a></li>
            <li><a href="admin_addjudgelocal.html"><label>เพิ่มกรรมการรอบลงพื้นที่  <span class="menu-list-amount">13</span></label></a></li>
            <li><a href="admin_judgeonsite.html">รอบลงพื้นที่ (กรรมการ)</a></li>
            <li><a href="admin_complete.html">ดำเนินการเสร็จสมบูรณ์</a></li>
          </ul>
        </div>
      </div>
      <div class="backendmenu-list-row">
        <a href="javascript:void(0)" class="btn-menulist" data-tab="3"><i class="bi bi-gear-fill"></i> ตั้งค่าอื่นๆ</a>
        <div class="hide-menu-list" data-tab="3">
          <ul>
            <li><a href="<?= base_url() ?>/administrator/News">ข่าวประชาสัมพันธ์</a></li>
          </ul>
        </div>
      </div>
      <div class="backendmenu-list-row">
        <a href="javascript:void(0)" class="btn-menulist" data-tab="4"><i class="bi bi-file-text"></i> รายงาน</a>
        <div class="hide-menu-list" data-tab="4">
          <ul>
            <li><a href="admin_prescreenreport.html">รายงานรอบ Pre-screen</a></li>
            <li><a href="admin_localreport.html">รายงานรอบลงพื้นที่</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  jQuery(document).ready(function() {
    $('.btn-menulist').click(function() {
      var datatab = $(this).attr('data-tab');
      console.log(datatab);
      if ($(this).hasClass('active')) {
        $('.hide-menu-list[data-tab="' + datatab + '"]').slideUp(200);
        $(this).removeClass('active');
      } else {
        $('.hide-menu-list[data-tab="' + datatab + '"]').slideDown(200);
        $(this).addClass('active');
      }
    });
  });
</script>