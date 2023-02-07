
<div class="banner-box">

    <div class="txt-banner">
        <h2>คณะกรรมการ</h2>
    </div>

</div>

<div class="container judgebox">
    <div class="container_box">
        <!-- <div class="row">
            <div class="col12">
                <div class="judge-title">กรรมการที่ปรึกษา</div>
                <div class="judge-list">
                    <ul>
                    <?php //foreach($judge as $val){ ?>
                        <li>
                            <a href="javascript:void(0);" onclick="setDirector(0)">
                                <div class="judge-img">
                                    <div class="judge-img-scale">
                                        <img src="<?php //base_url($val->profile)?>">
                                    </div>
                                </div>
                                <div class="judge-name"><?php //$val->fullname?></div>
                                <div class="judge-appointment">กรรมการที่ปรึกษา</div>
                            </a>
                        </li>
                    <?php //} ?>
                    </ul>
                </div>
            </div>
        </div> -->

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

<!-- <div class="modal fade" id="directorModal" tabindex="-1" aria-labelledby="directorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="bs-row">
                    <div class="col-12">
                        <img src="<?=base_url('assets/images/unknown_user.jpg')?>"
                        class="rounded" id="directorImage">
                    </div>
                    <div class="col-12 title">
                        <h2>Gidtikun Suksumran</h2>
                        Director
                    </div>
                    <div class="col-12 history">
                        xxxxxxxxxxxxx
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div> -->

<!-- <link href="<?=base_url('assets/css/custom.css')?>" rel="stylesheet" type="text/css" >
<style>
    .modal {
        top: 0;
    }
    .title,
    .history {
        margin-top: 1rem;
    }
    .title h2 {
        color: #1b510a;
        margin: 0;
    }
</style>
<script src="<?=base_url('assets/js/jquery-3.6.1.min.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/js/frontend/bootstrap/bootstrap.bundle.min.js')?>" type="text/javascript"></script>
<script>
    const directorModal = $('#directorModal');
    const directorImage = $('#directorImage');

    const director = [
        {
            image: '<?=base_url('assets/images/unknown_user.jpg')?>',
            name: 'กรรมการ 1',
            position: 'กรรมการที่ปรึกษา',
            history: 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxx'
        }
    ]

    const setDirector = index => {
        const setting = director[index];
        directorImage.attr('src',setting.image);
        $('.title').html(`<h2>${setting.name}</h2>${setting.position}`);
        $('.history').html(setting.history);        
        directorModal.modal('show');
    }
</script> -->