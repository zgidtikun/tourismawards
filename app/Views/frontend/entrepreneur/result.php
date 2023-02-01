<div class="container">
    <div class="row">
        <div class="col12">
            <div class="formmainbox">
                <div class="title">
                    <div class="title-txt">
                        สถานะการสมัครประกวดรางวัลอุตสาหกรรมท่องเที่ยวไทย ครั้งที่ 14 ประจำปี 2566
                    </div>
                </div>

                <div class="formstep">
                    <div class="formstep-col register complete">
                        <a href="<?= base_url('awards/application') ?>" class="inactive">
                            <div class="formstep-title" data-tab="1">1. กรอกแบบฟอร์มใบสมัคร</div>
                        </a>
                        <div class="formstep-status pass" data-tab="1">ผ่านการตรวจสอบ</div>
                        <div class="formstep-icon"><span><i class="bi bi-check-lg"></i></span></div>
                    </div>
                    <div class="formstep-col prescreen complete">
                        <a href="<?= base_url('awards/pre-screen') ?>" class="inactive">
                            <div class="formstep-title" data-tab="2">2. กรอกแบบประเมินขั้นต้น (Pre-Screen)</div>
                        </a>
                        <div class="formstep-status pass" data-tab="2">ส่งแบบประเมินเรียบร้อยแล้ว</div>
                        <div class="formstep-icon"><span><i class="bi bi-check-lg"></i></span></div>
                    </div>
                    <div class="formstep-col estimate active">
                        <div class="formstep-title" data-tab="3">3. ผลการประเมิน</div>
                        <div class="formstep-status check" data-tab="3">ตรวจสอบผลการประเมิน
                        </div>
                        <div class="formstep-icon"><span><i class="bi bi-clock"></i></span></div>
                    </div>
                    <script>
                        jQuery(document).ready(function() {
                            var formstepdate = $('.formstep-title').length;
                            var formsteptab = [];
                            for (var i = 1; i <= formstepdate;) {
                                formsteptab[i] = $('.formstep-title[data-tab="' + i + '"]').height();
                                i++
                            }
                            var formstepdate = formsteptab.reduce(function(a, b) {
                                return Math.max(a, b);
                            });
                            $('.formstep-title').css({
                                "height": formstepdate
                            });
                        });

                        jQuery(document).ready(function() {
                            var formstepdate = $('.formstep-status').length;
                            var formsteptab = [];
                            for (var i = 1; i <= formstepdate;) {
                                formsteptab[i] = $('.formstep-status[data-tab="' + i + '"]').height();
                                i++
                            }
                            var formstepdate = formsteptab.reduce(function(a, b) {
                                return Math.max(a, b);
                            });
                            $('.formstep-status').css({
                                "height": formstepdate
                            });

                        });
                    </script>
                </div>

            </div>

            <div class="formstatus pass">
                <picture>
                    <source srcset="<?=base_url('assets/images/pass-regis-form.svg')?>">
                    <img src="<?=base_url('assets/images/pass-regis-form.png')?>">
                </picture>
                <h3><?=$result->sts_title?></h3>
                <?php if(!empty($result->sts_content)): ?>
                <p><?=$result->sts_title?></p>
                <?php endif; ?>
            </div>
            
            <div class="formmainbox">
                <div class="estimate-result">
                    <?php if(!empty($result->title)): ?>
                    <span class="header"><?=$result->title?></span>
                    <?php endif; ?>
                    <img src="<?=$result->img?>" 
                    <?php if($result->award_result) : ?>
                        style="width: 300px !important;padding-bottom: 2rem !important;"
                    <?php endif; ?>                    
                    <?php if(empty($result->title)) : ?>
                        style="padding-top: 0 !important;"
                    <?php endif; ?> 
                    >
                    <span class="content"><?=$result->content?></span>
                </div>
            </div>

        </div>
    </div>
</div>