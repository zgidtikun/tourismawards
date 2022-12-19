<div class="banner-box">

  <section class="regular slider" style="display: none;">
    <div>
      <div class="banner-box-scale">
        <div class="banner-box-scale-img">
          <div class="banner-txt">
            <h2>Entries are open for 2023!</h2>
            <h1>Thailand Tourism Awards</h1>
            <p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet
              doming id quod mazim placerat facer possim assum. Eodem modo
              typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p>
            <a href="javascript:void(0);" class="btn-banner">ENTER THE 2023 AWARDS</a>
          </div>
          <picture>
            <source media="(max-width: 767px) and (orientation: portrait)" srcset="<?= base_url('assets/images/banner/banner1_4-3.jpg') ?>" />
            <img alt="" src="<?= base_url('assets/images/banner/banner1.jpg') ?>" srcset="<?= base_url('assets/images/banner/banner1.jpg') ?>" />
          </picture>
        </div>
      </div>
    </div>

    <div>
      <div class="banner-box-scale">
        <div class="banner-box-scale-img">
          <div class="banner-txt">
            <h2>Entries are open for 2023!</h2>
            <h1>Thailand Tourism Awards</h1>
            <p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet
              doming id quod mazim placerat facer possim assum. Eodem modo
              typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p>
            <a href="javascript:void(0);" class="btn-banner">ENTER THE 2023 AWARDS</a>
          </div>
          <picture>
            <source media="(max-width: 767px) and (orientation: portrait)" srcset="<?= base_url('assets/images/banner/banner1_4-3.jpg') ?>" />
            <img alt="" src="<?= base_url('assets/images/banner/banner1.jpg') ?>" srcset="<?= base_url('assets/images/banner/banner1.jpg') ?>" />
          </picture>
        </div>
      </div>
    </div>

    <div>
      <div class="banner-box-scale">
        <div class="banner-box-scale-img">
          <div class="banner-txt">
            <h2>Entries are open for 2023!</h2>
            <h1>Thailand Tourism Awards</h1>
            <p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet
              doming id quod mazim placerat facer possim assum. Eodem modo
              typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p>
            <a href="javascript:void(0);" class="btn-banner">ENTER THE 2023 AWARDS</a>
          </div>
          <picture>
            <source media="(max-width: 767px) and (orientation: portrait)" srcset="<?= base_url('assets/images/banner/banner1_4-3.jpg') ?>" />
            <img alt="" src="<?= base_url('assets/images/banner/banner1.jpg') ?>" srcset="<?= base_url('assets/images/banner/banner1.jpg') ?>" />
          </picture>
        </div>
      </div>
    </div>

    <div>
      <div class="banner-box-scale">
        <div class="banner-box-scale-img">
          <div class="banner-txt">
            <h2>Entries are open for 2023!</h2>
            <h1>Thailand Tourism Awards</h1>
            <p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet
              doming id quod mazim placerat facer possim assum. Eodem modo
              typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p>
            <a href="javascript:void(0);" class="btn-banner">ENTER THE 2023 AWARDS</a>
          </div>
          <picture>
            <source media="(max-width: 767px) and (orientation: portrait)" srcset="<?= base_url('assets/images/banner/banner1_4-3.jpg') ?>" />
            <img alt="" src="<?= base_url('assets/images/banner/banner1.jpg') ?>" srcset="<?= base_url('assets/images/banner/banner1.jpg') ?>" />
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