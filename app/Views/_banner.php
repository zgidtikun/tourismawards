<div class="banner-box">

  <section class="regular slider" style="display: none;">
    <div>
      <div class="banner-box-scale">
        <div class="banner-box-scale-img">
          <div class="banner-txt" style="display:none"></div>
          <a href="javascript:$('.branchawards')[0].scrollIntoView();">
            <picture>
              <source media="(max-width: 767px) and (orientation:portrait)" srcset="<?= base_url('assets/images/banner/mobile/banner_slide1.jpg') ?>" />
              <source media="(max-width: 768px)" srcset="<?= base_url('assets/images/banner/tablet_v/banner_slide1.jpg') ?>" />
              <source media="(max-width: 1024px)" srcset="<?= base_url('assets/images/banner/tablet_h/banner_slide1.jpg') ?>" />
              <img alt="" src="<?= base_url('assets/images/banner/pc/banner_slide1.jpg') ?>">
            </picture>
          </a>
        </div>
      </div>
    </div>

    <div>
      <div class="banner-box-scale">
        <div class="banner-box-scale-img">
          <div class="banner-txt" style="display:none"></div>
          <picture>
            <source media="(max-width: 767px) and (orientation:portrait)" srcset="<?= base_url('assets/images/banner/mobile/banner_slide2.jpg') ?>" />
            <source media="(max-width: 768px)" srcset="<?= base_url('assets/images/banner/tablet_v/banner_slide2.jpg') ?>" />
            <source media="(max-width: 1024px)" srcset="<?= base_url('assets/images/banner/tablet_h/banner_slide2.jpg') ?>" />
            <img alt="" src="<?= base_url('assets/images/banner/pc/banner_slide2.jpg') ?>">
          </picture>
        </div>
      </div>
    </div>

    <div>
      <div class="banner-box-scale">
        <div class="banner-box-scale-img">
          <div class="banner-txt" style="display:none"></div>
          <a href="<?=base_url('download/Factsheet-ประเภทการท่องเที่ยวคาร์บอนต่ำ.pdf')?>" target="_blank">
            <picture>
              <source media="(max-width: 767px) and (orientation:portrait)" srcset="<?= base_url('assets/images/banner/mobile/banner_slide3.jpg') ?>" />
              <source media="(max-width: 768px)" srcset="<?= base_url('assets/images/banner/tablet_v/banner_slide3.jpg') ?>" />
              <source media="(max-width: 1024px)" srcset="<?= base_url('assets/images/banner/tablet_h/banner_slide3.jpg') ?>" />
              <img alt="" src="<?= base_url('assets/images/banner/pc/banner_slide3.jpg') ?>">
            </picture>
          </a>
        </div>
      </div>
    </div>

    <div>
      <div class="banner-box-scale">
        <div class="banner-box-scale-img">
          <div class="banner-txt" style="display:none"></div>
          <picture>
            <source media="(max-width: 767px) and (orientation:portrait)" srcset="<?= base_url('assets/images/banner/mobile/banner_slide4.jpg') ?>" />
            <source media="(max-width: 768px)" srcset="<?= base_url('assets/images/banner/tablet_v/banner_slide4.jpg') ?>" />
            <source media="(max-width: 1024px)" srcset="<?= base_url('assets/images/banner/tablet_h/banner_slide4.jpg') ?>" />
            <img alt="" src="<?= base_url('assets/images/banner/pc/banner_slide4.jpg') ?>">
          </picture>
        </div>
      </div>
    </div>

  </section>

</div>

<script type="text/javascript">
  jQuery(document).ready(function($) {
    $(".regular").css("display", "block");
    $(".regular").slick({
      dots: true,
      infinite: true,
      arrows: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 4000
    });

    jQuery(document).each(function() {
      var headerheight = $('.header-box ').height()+'px';
      $('#includedbanner').css({
        "display": "block",
        "margin-top": headerheight
      });
    });

  });
</script>