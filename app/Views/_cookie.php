<script type="text/javascript" async>
  // Set cookie
  jQuery(document).ready(function($) {       
    if($.cookie('cookieinfo') !== 'true'){
      const cookie_box = `
        <div id="cookie_box" style="display: none;">
          <div class="container">
            <div class="container_row">
              <div class="row">
                <div class="col9">
                  เว็บไซต์ของเราใช้คุกกี้ (Cookies) เพื่อเพิ่มประสิทธิภาพ และประสบการณ์ที่ดีในการใช้งานเว็บไซต์ กรุณากดยอมรับ คุณสามารถศึกษารายละเอียดได้ที่
                  <a href="<?=base_url('privacy-policy')?>">นโยบายความเป็นส่วนตัวและข้อมูลส่วนบุคคลของเว็บไซต์</a>
                </div>
                <div class="col3">
                  <button onclick="javascript:cookieinfo()" class="btn-cookie">ยอมรับ</button>
                </div>
              </div>
            </div>
      `;

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