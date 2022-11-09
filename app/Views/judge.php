<div class="banner-box">

    <div class="txt-banner">
        <h2>คณะกรรมการ</h2>
    </div>

</div>

<div class="container judgebox">
    <div class="container_box">
        <div class="row">
            <div class="col12">
                <div class="judge-title">กรรมการที่ปรึกษา</div>
                <div class="judge-list">
                    <ul>
                    <?php foreach($judge as $val){ ?>
                        <li>
                            <div class="judge-img">
                                <div class="judge-img-scale">
                                    <img src="<?=base_url($val->profile)?>">
                                </div>
                            </div>
                            <div class="judge-name"><?=$val->fullname?></div>
                            <div class="judge-appointment">กรรมการที่ปรึกษา</div>
                        </li>
                    <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col12">
                <div class="judge-title">กรรมการประเภทแหล่งท่องเที่ยว</div>
                <div class="judge-list">
                    <ul>
                    <?php foreach($judge as $val){ ?>
                        <?php if(in_array(1,$val->award_type)): ?>
                        <li>
                            <div class="judge-img">
                                <div class="judge-img-scale">
                                    <img src="<?=base_url($val->profile)?>">
                                </div>
                            </div>
                            <div class="judge-name"><?=$val->fullname?></div>
                            <div class="judge-appointment">กรรมการที่ปรึกษา</div>
                        </li>
                        <?php endif; ?>
                    <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col12">
                <div class="judge-title">กรรมการประเภทการท่องเที่ยวเชิงสุขภาพ</div>
                <div class="judge-list">
                    <ul>
                    <?php foreach($judge as $val){ ?>
                        <?php if(in_array(2,$val->award_type)): ?>
                        <li>
                            <div class="judge-img">
                                <div class="judge-img-scale">
                                    <img src="<?=base_url($val->profile)?>">
                                </div>
                            </div>
                            <div class="judge-name"><?=$val->fullname?></div>
                            <div class="judge-appointment">กรรมการที่ปรึกษา</div>
                        </li>
                        <?php endif; ?>
                    <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col12">
                <div class="judge-title">กรรมการประเภทที่พักนักท่องเที่ยว</div>
                <div class="judge-list">
                    <ul>
                    <?php foreach($judge as $val){ ?>
                        <?php if(in_array(3,$val->award_type)): ?>
                        <li>
                            <div class="judge-img">
                                <div class="judge-img-scale">
                                    <img src="<?=base_url($val->profile)?>">
                                </div>
                            </div>
                            <div class="judge-name"><?=$val->fullname?></div>
                            <div class="judge-appointment">กรรมการที่ปรึกษา</div>
                        </li>
                        <?php endif; ?>
                    <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col12">
                <div class="judge-title">กรรมการประเภทรายการนำเที่ยว</div>
                <div class="judge-list">
                    <ul>
                    <?php foreach($judge as $val){ ?>
                        <?php if(in_array(4,$val->award_type)): ?>
                        <li>
                            <div class="judge-img">
                                <div class="judge-img-scale">
                                    <img src="<?=base_url($val->profile)?>">
                                </div>
                            </div>
                            <div class="judge-name"><?=$val->fullname?></div>
                            <div class="judge-appointment">กรรมการที่ปรึกษา</div>
                        </li>
                        <?php endif; ?>
                    <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>