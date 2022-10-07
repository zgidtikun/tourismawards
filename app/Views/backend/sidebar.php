<div class="nk-sidebar">
  <div class="slimScrollDiv">
    <div class="nk-nav-scroll active">
      <ul class="metismenu in" id="menu">
        <li class="nav-label">Dashboard</li>
        <li><a href="<?= base_url('backend/dashboard') ?>"><i class="icon-speedometer"></i><span class="nav-text">สถิติการใช้งาน</span></a></li>
        <li class="nav-label">เมนูหลัก</li>

        <?php if (isAdmin()) : ?>
          <li>
            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
              <i class="icon-user"></i><span class="nav-text">สมาชิก</span>
            </a>
            <ul>
              <li><a href="<?= base_url('backend/Users') ?>">ผู้ประกอบการ</a></li>
              <li><a href="<?= base_url('backend/Officer') ?>">กรรมการ</a></li>
              <li><a href="<?= base_url('backend/TAT') ?>">เจ้าหน้าที่ ททท.</a></li>
              <li><a href="<?= base_url('backend/Admin') ?>">ผู้ดูแลระบบ</a></li>
            </ul>
          </li>
        <?php endif; ?>

        <li>
          <a class="has-arrow" href="javascript:void()">
            <i class="icon-layers"></i><span class="nav-text">ขั้นตอนการดำเนินการ</span>
          </a>
          <ul>
            <li><a href="<?= base_url('backend/Approve') ?>">ตรวจสอบใบสมัคร <div class="badge badge-pill badge-warning">24</div> </a></li>
            <li><a href="<?= base_url('backend/Approve/history') ?>">ประวัติการตรวจสอบใบสมัคร </a></li>
            <li><a href="<?= base_url('backend/Approve/check') ?>">ประเมินขั้นต้น (ผู้ประกอบการ)</a></li>
            <li><a href="<?= base_url('backend/Directors/initial') ?>">เพิ่มกรรมการประเมินขั้นต้น <div class="badge badge-pill badge-warning">49</div> </a></li>
            <li><a href="<?= base_url('backend/') ?>">ประเมินขั้นต้น (กรรมการ)</a></li>
            <li><a href="<?= base_url('backend/Directors/area') ?>">เพิ่มกรรมการรอบลงพื้นที่ <div class="badge badge-pill badge-warning">13</div> </a></li>
            <li><a href="<?= base_url('backend/') ?>">รอบลงพื้นที่ (กรรมการ)</a></li>
            <li><a href="<?= base_url('backend/') ?>">ดำเนินการเสร็จสมบูรณ์</a></li>
          </ul>
        </li>
        <li>
          <a class="has-arrow" href="javascript:void()">
            <i class="fas fa-cog"></i> <span class="nav-text">ตั้งค่าอื่นๆ</span>
          </a>
          <ul>
            <li><a href="<?= base_url('backend/News') ?>">ข่าวประชาสัมพันธ์ </a></li>
          </ul>
        </li>

        <?php if (isAdmin()) : ?>
          <li>
            <a class="has-arrow" href="javascript:void()">
              <i class="fas fa-file"></i> <span class="nav-text">รายงาน</span>
            </a>
            <ul>
              <li><a href="<?= base_url('backend/Report') ?>">Excel </a></li>
              <!-- <li><a href="<?= base_url('backend/') ?>">รายงานรอบลงพื้นที่ </a></li> -->
            </ul>
          </li>
        <?php endif; ?>

      </ul>
    </div>
    <div class="slimScrollBar"></div>
    <div class="slimScrollRail"></div>
  </div>
</div>