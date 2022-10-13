<div class="container" data-sess-id="<?=session()->get('id')?>">
    <div class="row">
        <div class="col12">
            <div class="card">
                <div class="card-body">
                    <div class="bs-row">
                        <div class="col-xs-12 col-sm-12 col-md-2 col-xl-2 mb-3">
                            <img id="p-image" src="<?=$profile->profile?>" class="profile">
                            <div class="d-grid">
                                <button type="button" class="btn btn-sm btn-profile btn-success">
                                    <span id="file-label">
                                        <i class="bi bi-person-bounding-box mr-1"></i> Upload Image
                                    </span>
                                    <input type="file" id="p-uimage" onchange="onFileHandel(this.id)"
                                    accept=".jpg,.jpeg,.png"/>
                                </button>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-10 col-xl-10">
                            <div class="bs-row mb-3">
                                <div class="col-12 fs-4 text-sm-center">
                                    <span class="text-base-main fw-semibold">
                                        <?=$profile->fullname?>
                                    </span>
                                </div>
                            </div>
                            <?php if($profile->role_id == 1): ?>
                            <div class="bs-row mb-3">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12 mb-3">
                                    <div class="card border"> 
                                        <div class="card-header text-sm-center">
                                            <span class="fs-18 text-base-main fw-semibold">
                                                แหล่งท่องเที่ยว/สถานประกอบการ/รายการนำเที่ยว
                                            </span>
                                        </div>
                                        <div class="card-body" style="padding: 10px;">
                                            <span class="fs-18">
                                                <?=$profile->app_attr?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-3">
                                    <div class="card border"> 
                                        <div class="card-header text-sm-center">
                                            <span class="fs-18 text-base-main fw-semibold">
                                                สาขารางวัลเข้าร่วมประกวด
                                            </span>
                                        </div>
                                        <div class="card-body" style="padding: 10px;">
                                            <span class="fs-18">
                                                <?=$profile->app_t?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-3">
                                    <div class="card border"> 
                                        <div class="card-header text-sm-center">
                                            <span class="fs-18 text-base-main fw-semibold">
                                                สาขารางวัลย่อยเข้าร่วมประกวด
                                            </span>
                                        </div>
                                        <div class="card-body" style="padding: 10px;">
                                            <span class="fs-18">
                                                <?=$profile->app_ts?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6">
                                    <div class="card card-body border" style="padding: 10px;">  
                                        <span class="fs-18 text-base-main fw-semibold">
                                            สถานะ : <span class="fw-normal text-dark"><?=$profile->member_type?></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="bs-row">
                            </div>
                            <?php else: ?>
                            <div class="bs-row mb-3">
                                <div class="col-xs-12 col-sm-12 col-md-3 col-xl-3 mb-3">
                                    <div class="card border">  
                                        <div class="card-header text-center">
                                            <span class="text-base-main fw-semibold">ประเภทสมาชิก</span>                                            
                                        </div>
                                        <div class="card-body">
                                            <?=$profile->member_type?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4 col-xl-4 mb-3">
                                    <div class="card border">  
                                        <div class="card-header text-center">
                                            <span class="text-base-main fw-semibold">รับผิดชอบการตัดสิน</span>                                            
                                        </div>
                                        <div class="card-body">
                                            <?php foreach($profile->award_type as $key=>$type){ ?>
                                                <?=$key+1?>. <?=$type?><br>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-5 col-xl-5">
                                    <div class="card border">  
                                        <div class="card-header text-center">
                                            <span class="text-base-main fw-semibold">รับผิดชอบกลุ่มการประเมิน</span>                                            
                                        </div>
                                        <div class="card-body">
                                            <?php foreach($profile->assessment_group as $key=>$group){ ?>
                                                <?=$key+1?>. <?=$group?><br>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col12">
            <div class="card">
                <div class="card-header text-sm-center fs-20 text-base-main fw-semibold">
                    <span class="mt-3 ml-3"><i class="bi bi-person-lines-fill mr-1"></i> ข้อมูลส่วนตัว</span>
                </div>
                <div class="card-body">
                    <form id="form-profile">
                        <fieldset id="fieldset-profile">
                            <div class="bs-row g-3">
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-floating">
                                        <select class="form-select" id="p-prefix">
                                            <option value="นาย" <?php if($profile->prefix == 'นาย'){ echo 'selectedd'; } ?>>นาย</option>
                                            <option value="นาง" <?php if($profile->prefix == 'นาย'){ echo 'selectedd'; } ?>>นาง</option>
                                            <option value="นางสาว" <?php if($profile->prefix == 'นาย'){ echo 'selectedd'; } ?>>นางสาว</option>
                                        </select>
                                        <label>คำนำหน้า</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="p-name"
                                        value="<?=$profile->name?>">
                                        <label>ชื่อจริง<span class="text-danger ml-1">*</span></label>
                                        <div id="invalid-p-name" class="invalid-feedback">
                                            กรุณากรอก ชื่อจริง
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="p-surname"
                                        value="<?=$profile->surname?>">
                                        <label>นามสกุล<span class="text-danger ml-1">*</span></label>
                                        <div id="invalid-p-surname" class="invalid-feedback">
                                            กรุณากรอก นามสกุล
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="p-mobile"
                                        value="<?=$profile->mobile?>">
                                        <label>เบอร์โทรศัพท์<span class="text-danger ml-1">*</span></label>
                                        <div id="invalid-p-mobile" class="invalid-feedback">
                                            กรุณากรอก เบอร์โทรศัพท์
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-8">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="p-email"
                                        value="<?=$profile->email?>">
                                        <label>อีเมล<span class="text-danger ml-1">*</span></label>
                                        <div id="invalid-p-email" class="invalid-feedback">
                                            กรุณากรอก อีเมล
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bs-row mt-3">
                                <div class="col-12 form-btn-action">
                                    <button type="button" class="btn btn-primary" onclick="pf.save()">
                                        <i class="bi bi-pencil-square mr-1"></i> แก้ไข
                                    </button>
                                    <button type="reset" class="btn btn-danger ml-2">
                                        <i class="bi bi-pencil-square mr-1"></i> ยกเลิก
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?=base_url('assets/js/frontend/profile.js')?>"></script>