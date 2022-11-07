<div class="banner-box">

    <div class="txt-banner">
        <h2>ติดต่อ</h2>
    </div>

</div>

<div class="contact-map">
    <div class="contact-map-scale">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8452.525786717564!2d100.55464927037488!3d13.748727849525267!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e29eeecb3fec3d%3A0xb4906a2c98066a18!2z4LiB4Liy4Lij4LiX4LmI4Lit4LiH4LmA4LiX4Li14LmI4Lii4Lin4LmB4Lir4LmI4LiH4Lib4Lij4Liw4LmA4LiX4Lio4LmE4LiX4Lii!5e0!3m2!1sth!2sth!4v1666939929623!5m2!1sth!2sth" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>

<div class="container">
    <div class="container_box">
        <div class="row">
            <div class="col12">
                <div class="contact-list">
                    <ul>
                        <li>
                            <div class="contact-col">
                                <div class="contact-img">
                                    <picture>
                                        <source srcset="<?=base_url('assets/images/location.svg')?>">
                                        <img src="<?=base_url('assets/images/location.png')?>">
                                    </picture>
                                </div>
                                <div class="contact-subject">
                                    ที่อยู่
                                </div>
                                <div class="contact-txt">
                                    1600 ถ.เพชรบุรีตัดใหม่
                                    แขวงมักกะสัน เขตราชเทวี
                                    กรุงเทพฯ 10400
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="contact-col">
                                <div class="contact-img">
                                    <picture>
                                        <source srcset="<?=base_url('assets/images/tel.svg')?>">
                                        <img src="<?=base_url('assets/images/tel.png')?>">
                                    </picture>
                                </div>
                                <div class="contact-subject">
                                    เบอร์โทรศัพท์
                                </div>
                                <div class="contact-txt">
                                    <b>02-250-5500</b><br>
                                    ศูนย์บริการข่าวสาร<br>
                                    การท่องเที่ยว ททท. 1672
                                </div>
                            </div>
                        </li>


                        <li>
                            <div class="contact-col">
                                <div class="contact-img">
                                    <picture>
                                        <source srcset="<?=base_url('assets/images/mail.svg')?>">
                                        <img src="<?=base_url('assets/images/mail.png')?>">
                                    </picture>
                                </div>
                                <div class="contact-subject">
                                    อีเมล
                                </div>
                                <div class="contact-txt">
                                    tourismawards.tat@gmail.com
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="contact-col">
                                <div class="contact-img">
                                    <picture>
                                        <source srcset="<?=base_url('assets/images/facebook.svg')?>">
                                        <img src="<?=base_url('assets/images/facebook.png')?>">
                                    </picture>
                                </div>
                                <div class="contact-subject">
                                    Facebook
                                </div>
                                <div class="contact-txt">
                                    Thailand Tourism Awards
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col12">
                <div class="main-title">
                    <div class="catagory-txt">
                        <picture>
                            <source srcset="<?=base_url('assets/images/HaveQuestions.svg')?>">
                            <source srcset="<?=base_url('assets/images/HaveQuestions.png')?>">
                            <img src="<?=base_url('assets/images/HaveQuestions.png')?>" width="277" height="50">
                        </picture>
                    </div>

                    <div class="main-title-txt">
                        <h2>ติดต่อโครงการฯ
                    </div>
                </div>

                <div class="contact-form">
                    <div class="contact-form-row">
                        <div class="contact-form-col2 inputfield">
                            <label data-tab="1">ชื่อ-นามสกุล<span class="required">*</span></label>
                            <input data-tab="1">
                            <a href="javascript:void(0)" class="btn-inpreset" data-tab="1"><i class="bi bi-x"></i></a>
                        </div>
                        <div class="contact-form-col2 inputfield">
                            <label data-tab="2">อีเมล<span class="required">*</span></label>
                            <input data-tab="2">
                            <a href="javascript:void(0)" class="btn-inpreset" data-tab="2"><i class="bi bi-x"></i></a>
                        </div>
                        <div class="contact-form-col1 inputfield">
                            <label data-tab="3">เรื่อง<span class="required">*</span></label>
                            <input data-tab="3">
                            <a href="javascript:void(0)" class="btn-inpreset" data-tab="3"><i class="bi bi-x"></i></a>
                        </div>
                        <div class="contact-form-col1 inputfield">
                            <label data-tab="4">ข้อความ<span class="required">*</span></label>
                            <textarea rows="5" data-tab="4"></textarea>
                            <a href="javascript:void(0)" class="btn-inpreset" data-tab="4"><i class="bi bi-x"></i></a>
                        </div>
                        <div class="contact-form-col1 btn-form-row">
                            <button type="submit" class="btn-save">ส่งข้อความ</button>
                        </div>
                    </div>

                    <script>
                        jQuery(document).ready(function() { //input value hide label
                            $('.btn-inpreset').hide();
                            $('input').keypress(function() {
                                var datatab = $(this).attr('data-tab');
                                $('.btn-inpreset[data-tab="' + datatab + '"]').show();
                                $('label[data-tab="' + datatab + '"]').hide();
                            });
                            $('textarea').keypress(function() {
                                var datatab = $(this).attr('data-tab');
                                $('.btn-inpreset[data-tab="' + datatab + '"]').show();
                                $('label[data-tab="' + datatab + '"]').hide();
                            });
                            $('.btn-inpreset').click(function() {
                                var datatab = $(this).attr('data-tab');
                                $('.inputfield input[data-tab="' + datatab + '"]').val('');
                                $('.inputfield textarea[data-tab="' + datatab + '"]').val('');
                                $('label[data-tab="' + datatab + '"]').show();
                                $(this).hide();
                            });

                        });

                        $('input').change(function() {
                            var datatab = $(this).attr('data-tab');
                            if ($(this).val().length > 0) {
                                //input value has value hide label
                                $('label[data-tab="' + datatab + '"]').hide();
                            } else {
                                //input value empt value hide label
                                $('.btn-inpreset[data-tab="' + datatab + '"]').hide();
                                $('label[data-tab="' + datatab + '"]').show();
                            }
                        });

                        $('textarea').change(function() {
                            var datatab = $(this).attr('data-tab');
                            if ($(this).val().length > 0) {
                                //input value has value hide label
                                $('label[data-tab="' + datatab + '"]').hide();
                            } else {
                                //input value empt value hide label
                                $('.btn-inpreset[data-tab="' + datatab + '"]').hide();
                                $('label[data-tab="' + datatab + '"]').show();
                            }
                        });
                    </script>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    $(document).ready(() => {
        $('.mainsite').addClass('contact');
    });
</script>