<div class="backendmenu-box">
  <div class="hidemenu">
    <a href="javascript:" class="btn-sidemenu"></a>
  </div>

  <div class="backendmenu-row">
    <div class="backendmenu-logo">
      <picture>
        <source srcset="<?= base_url() ?>/assets/images/logo.svg">
        <img src="<?= base_url() ?>/assets/images/logo.png" width="372" height="144">
      </picture>
    </div>
    <div class="backendmenu-list">
      <div class="backendmenu-list-row">
        <a href="<?= base_url() ?>/administrator"><i class="bi bi-layers-fill"></i> สถิติการใช้งาน</a>
      </div>
      <div class="backendmenu-list-row title">เมนูหลัก</div>
      
      <?php if (isAdmin()) : ?>
        <div class="backendmenu-list-row">
          <a href="javascript:void(0)" class="btn-menulist" data-tab="1" data-type="user"><i class="bi bi-grid-fill"></i>สมาชิก</a>
          <div class="hide-menu-list" data-tab="1" data-type="user">
            <ul>
              <li><a href="<?= base_url() ?>/administrator/Users/all" data-type="user"><label>สมาชิกทั้งหมด</label></a></li>
              <li><a href="<?= base_url() ?>/administrator/Users" data-type="user"><label>ผู้ประกอบการ</label></a></li>
              <li><a href="<?= base_url() ?>/administrator/Officer" data-type="user"><label>กรรมการ</label></a></li>
              <li><a href="<?= base_url() ?>/administrator/TAT" data-type="user"><label>เจ้าหน้าที่ ททท.</label></a></li>
              <li><a href="<?= base_url() ?>/administrator/Admin" data-type="user"><label>ผู้ดูแลระบบ</label></a></li>
            </ul>
          </div>
        </div>
      <?php endif; ?>
      <div class="backendmenu-list-row">
        <a href="javascript:void(0)" class="btn-menulist" data-tab="2" data-type="process"><i class="bi bi-toggles"></i> ขั้นตอนการดำเนินการ</a>
        <div class="hide-menu-list" data-tab="2" data-type="process">
          <ul>
            <li>
              <a href="<?= base_url() ?>/administrator/Approve" data-type="process">
                <label>
                  ตรวจสอบใบสมัคร
                  <?php if (countNotification(1) != 0) : ?>
                    <span class="menu-list-amount"><?= countNotification(1) ?></span>
                  <?php endif; ?>
                </label>
              </a>
            </li>
            <li><a href="<?= base_url() ?>/administrator/Approve/history" data-type="process"><label>ประวัติการตรวจสอบใบสมัคร</label></a></li>
            <li><a href="<?= base_url() ?>/administrator/PreScreen" data-type="process"><label>ใบสมัครที่ผ่านการอนุมัติ</label></a></li>
            <li>
              <a href="<?= base_url() ?>/administrator/Estimate" data-type="process">
                <label>เพิ่มกรรมการรอบ Pre-screen
                  <?php if (countNotification(2) != 0) : ?>
                    <span class="menu-list-amount"><?= countNotification(2) ?></span>
                  <?php endif; ?>
                </label>
              </a>
            </li>
            <li><a href="<?= base_url() ?>/administrator/Estimate/prescreen" data-type="process"><label>การประเมินขั้นต้น</label></a></li>
            <li>
              <a href="<?= base_url() ?>/administrator/Onsite" data-type="process">
                <label>เพิ่มกรรมการรอบลงพื้นที่
                  <?php if (countNotification(3) != 0) : ?>
                    <span class="menu-list-amount"><?= countNotification(3) ?></span>
                  <?php endif; ?>
                </label>
              </a>
            </li>
            <li><a href="<?= base_url() ?>/administrator/Onsite/estimate" data-type="process"><label>การประเมินรอบลงพื้นที่</label></a></li>
            <li><a href="<?= base_url() ?>/administrator/Complete" data-type="process"><label>ดำเนินการเสร็จสมบูรณ์</label></a></li>
          </ul>
        </div>
      </div>
      <div class="backendmenu-list-row">
        <a href="javascript:void(0)" class="btn-menulist" data-tab="3" data-type="news"><i class="bi bi-gear-fill"></i> ตั้งค่าอื่นๆ</a>
        <div class="hide-menu-list" data-tab="3" data-type="news">
          <ul>
            <li><a href="<?= base_url() ?>/administrator/News" data-type="news"><label>ข่าวประชาสัมพันธ์</label></a></li>
          </ul>
        </div>
      </div>
      
      <?php if (isAdmin()) : ?>
        <!-- <div class="backendmenu-list-row">
          <a href="javascript:void(0)" class="btn-menulist" data-tab="4" data-type="award"><i class="bi bi-award-fill"></i> ผลรางวัล</a>
          <div class="hide-menu-list" data-tab="4" data-type="award">
            <ul>
              <li><a href="<?= base_url() ?>/administrator/Award/best" data-type="award"><label>รางวัลยอดเยี่ยม</label></a></li>
              <li><a href="<?= base_url() ?>/administrator/Award/outstanding " data-type="award"><label>รางวัลดีเด่น</label></a></li>
              <li><a href="<?= base_url() ?>/administrator/Award/certificate" data-type="award"><label>เกียรติบัตรรางวัลอุตสาหกรรมท่องเที่ยวไทย</label></a></li>
            </ul>
          </div>
        </div> -->
      <?php endif; ?>

      <?php if (isAdmin()) : ?>
        <div class="backendmenu-list-row">
          <a href="<?= base_url() ?>/administrator/Report" data-tab="4" data-type="report"><i class="bi bi-file-text"></i> รายงาน</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
  $(function() {
    $('.btn-menulist').click(function() {
      var datatab = $(this).attr('data-tab');
      if ($(this).hasClass('active')) {
        $('.hide-menu-list[data-tab="' + datatab + '"]').slideUp(200);
        $(this).removeClass('active');
      } else {
        $('.hide-menu-list[data-tab="' + datatab + '"]').slideDown(200);
        $(this).addClass('active');
      }
    });

    //----------------------------------------------------------------------------------
    // var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
    // cc(pgurl)
    var pgurl = window.location.href.substr();
    $(".backendmenu-list li").each(function() {
      if ($(this).find("a").attr("href") == pgurl) {
        $(".backendmenu-list li a").removeClass("active");
        $(this).find("a").addClass("active");
        var datatype = $(this).find("a").attr("data-type");
        // console.log("Datatype = '" + datatype + "'");
        $('.btn-menulist[data-type="' + datatype + '"]').addClass("active");
        $('.hide-menu-list[data-type="' + datatype + '"]').show().addClass("active");
      }
    });
    //----------------------------------------------------------------------------------

    var screen_w = $(window).width();
    var screen_h = $(window).height();

    $('.backendmenu-box').addClass('hide');

    if (screen_w <= 1024) {

      $('.btn-sidemenu').click(function() {
        if ($(this).hasClass('active')) {
          $('.backendmenu-box').addClass('hide');
          $(this).removeClass('active');
          $('.backendmain').removeClass('overlay');
          $('body').removeClass('lockbody');
          $('.hidemenu').removeClass('active');
        } else {
          $('.backendmenu-box').removeClass('hide').css({
            "transition": "all 0.3s"
          });
          $(this).addClass('active');
          $('.backendmain').addClass('overlay');
          $('body').addClass('lockbody');
          $('.hidemenu').addClass('active');
        }
      });
    }
  });
</script>