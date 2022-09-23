<div class="nk-sidebar">
  <div class="slimScrollDiv">
    <div class="nk-nav-scroll active">
      <ul class="metismenu in" id="menu">
        <li class="nav-label">เมนูหลัก</li>
        <li><a href="<?= base_url('backend/Dashboard') ?>"><i class="icon-speedometer"></i><span class="nav-text">หน้าแรก</span></a></li>
        <li>
          <a class="has-arrow" href="javascript:void()" aria-expanded="false">
            <i class="icon-user"></i><span class="nav-text">สมาชิก</span>
          </a>
          <ul aria-expanded="false" class="collapse in">
            <li><a href="<?= base_url('backend/Users') ?>">ผู้ประกอบการ</a></li>
            <li><a href="<?= base_url('backend/Officer') ?>">กรรมการ</a></li>
            <li><a href="<?= base_url('backend/Officer/tat') ?>">เจ้าหน้าที่ ททท.</a></li>
            <li><a href="<?= base_url('backend/Admin') ?>">ผู้ดูแลระบบ</a></li>
          </ul>
        </li>
        <!-- <li class="nav-label">Forms</li> -->
        <!-- <li><a href="<?= base_url('backend/Users') ?>"><i class="icon-user"></i><span class="nav-text">ผู้ประกอบการ</span></a></li> -->
        <!-- <li><a href="<?= base_url('backend/Admin') ?>"><i class="icon-people"></i><span class="nav-text">คณะกรรมการ</span></a></li> -->

        <!-- <li class="nav-label">เอกสาร</li> -->
        <li>
          <a class="has-arrow" href="javascript:void()">
            <i class="icon-layers"></i><span class="nav-text">ขั้นตอนการดำเนินการ</span>
          </a>
          <ul>
            <li><a href="<?= base_url('backend/') ?>">อนุมัติใบสมัคร</a></li>
            <li><a href="<?= base_url('backend/') ?>">ประวัติการอนุมัติ</a></li>
            <li><a href="<?= base_url('backend/') ?>">ประเมินขั้นต้น (ผู้ประกอบการ)</a></li>
            <li><a href="<?= base_url('backend/') ?>">เพิ่มกรรมการประเมินขั้นต้น</a></li>
            <li><a href="<?= base_url('backend/') ?>">ประเมินขั้นต้น (กรรมการ)</a></li>
            <li><a href="<?= base_url('backend/') ?>">เพิ่มกรรมการรอบลงพื้นที่</a></li>
            <li><a href="<?= base_url('backend/') ?>">รอบลงพื้นที่ (กรรมการ)</a></li>
            <li><a href="<?= base_url('backend/') ?>">ดำเนินการเสร็จสมบูรณ์</a></li>
          </ul>
        </li>
        <!-- <li>
          <a class="has-arrow" href="javascript:void()">
            <i class="icon-layers"></i><span class="nav-text">หน้า CMS</span>
          </a>
          <ul>
            <li><a href="backend/topic">หัวข้อ</a></li>
            <li><a href="backend/question">คำถาม</a></li>
          </ul>
        </li> -->
        <!-- <li><a href="backend/"><i class="icon-bell"></i><span class="nav-text">รายงานการแจ้งเตือน</span></a></li>
        
        <li class="nav-label">System</li>
        <li><a href="<?= base_url('backend/Setting') ?>"><i class="icon-settings"></i><span class="nav-text">การตั้งค่า</span></a></li>
        <li><a href="backend/"><i class="icon-folder"></i><span class="nav-text">รายงาน</span></a></li> -->
      </ul>
    </div>
    <div class="slimScrollBar"></div>
    <div class="slimScrollRail"></div>
  </div>
</div>