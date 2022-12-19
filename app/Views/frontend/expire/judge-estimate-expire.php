<div class="container">
    <div class="row">

        <div class="col12">
            <div class="form-main-title">
                <div class="form-main-title-txt">
                    
                </div>
                <div class="form-main-btn">
                    <button style="width: 100px;" class="btn btn-back fw-semibold" 
                    onclick="window.open('<?= base_url('boards') ?>','_self')">
                        ย้อนกลับ
                    </button>
                </div>
            </div>
        </div>
        <div class="col12">

            <div class="formmainbox">
                <div class="estimate-result">
                    <span class="header">
                    <?php if($stage == 1) : ?>
                        หมดเวลาการประเมินขั้นต้น (Pre-screen)แล้ว
                    <?php else : ?>
                        หมดเวลาการประเมินรอบลงพื้นที่แล้ว
                    <?php endif; ?>
                    </span>
                    <img src="<?=base_url('assets/images/prescreen_uncomplete.png')?>">
                    <!-- <span class="content">ขณะนี้กำลังอยู่ในช่วงขั้นตอยการประเมินรอบลงพื้นที่ 
                จากทางคณะกรรมการ จะประกาศผลการประเมินในวันที่</span> -->
                </div>
            </div>

        </div>
    </div>
</div>