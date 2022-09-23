<script type="text/javascript" async>
  // Set cookie
  jQuery(document).ready(function($) {    
    if($.cookie('cookieinfo') !== 'true'){
      var cookie_box = '<div id="cookie_box" style="display: none;"><div class="container"><div class="container_row">';
      cookie_box += '<div class="row"><div class="col9">เว็บไซต์นี้มีการจัดเก็บคุกกี้ (Cookies) เพื่อพัฒนาปรับปรุงการนำเสนอเนื้อหาที่ดีสำหรับผู้ใช้งาน ';
      cookie_box += 'และอำนวยความสะดวกให้ผู้ใช้งานสามารถใช้บริการต่างๆ ภายในเว็บไซต์ได้ง่ายและมีประสิทธิภาพยิ่งขึ้นการใช้งานเว็บไซต์นี้เป็นการยอมรับข้อกำหนดและยินยอมการจัดเก็บคุกกี้ดังกล่าว ';
      cookie_box += 'โดยสามารถดูรายละเอียดเพิ่มเติมเกี่ยวกับคุกกี้ได้ที่ <a href="javascript:void(0);" target="_blank">นโยบายความเป็นส่วนตัวและข้อมูลส่วนบุคคล</a> ของบริษัทฯ</div>';
      cookie_box += '<div class="col3"><button onclick="javascript:cookieinfo()" class="btn-cookie">ตกลง</button> </div></div></div></div></div>';

      $('body').after(cookie_box);

      setTimeout(function() {
        $('#cookie_box').fadeIn(500);
      }, 500);
    }
  });

  function cookieinfo() {

    $.cookie('cookieinfo',"true", {
        expires: 7,
        path: '/',
    });    
    
    $('#cookie_box').fadeOut(500);
    $('.set_cookie').fadeOut(500);
    $('body').removeClass("lockbody");

  }
</script>