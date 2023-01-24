<style>
:not(.btn-check) + .btn:hover, .btn:first-child:hover {
  color: var(--bs-btn-hover-color);
  background-color: var(--bs-btn-hover-bg);
  border-color: var(--bs-btn-hover-border-color);
}

.btn:focus-visible {
  color: var(--bs-btn-hover-color);
  background-color: var(--bs-btn-hover-bg);
  border-color: var(--bs-btn-hover-border-color);
  outline: 0;
  box-shadow: var(--bs-btn-focus-box-shadow);
}

.btn {
  --bs-btn-padding-x: 0.75rem;
  --bs-btn-padding-y: 0.375rem;
  --bs-btn-font-family: ;
  --bs-btn-font-size: 18px;
  --bs-btn-font-weight: 400;
  --bs-btn-line-height: 1.5;
  --bs-btn-color: #212529;
  --bs-btn-bg: transparent;
  --bs-btn-border-width: 1px;
  --bs-btn-border-color: transparent;
  --bs-btn-border-radius: 0.375rem;
  --bs-btn-hover-border-color: transparent;
  --bs-btn-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15), 0 1px 1px rgba(0, 0, 0, 0.075);
  --bs-btn-disabled-opacity: 0.65;
  --bs-btn-focus-box-shadow: 0 0 0 0.25rem rgba(var(--bs-btn-focus-shadow-rgb), .5);
  display: inline-block;
  padding: var(--bs-btn-padding-y) var(--bs-btn-padding-x);
  font-family: var(--bs-btn-font-family);
  font-size: var(--bs-btn-font-size);
  font-weight: var(--bs-btn-font-weight);
  line-height: var(--bs-btn-line-height);
  color: var(--bs-btn-color);
  text-align: center;
  text-decoration: none;
  vertical-align: middle;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  user-select: none;
  border: var(--bs-btn-border-width) solid var(--bs-btn-border-color);
  border-radius: var(--bs-btn-border-radius);
  background-color: var(--bs-btn-bg);
  transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.btn-success {
  --bs-btn-color: #fff;
  --bs-btn-bg: #198754;
  --bs-btn-border-color: #198754;
  --bs-btn-hover-color: #fff;
  --bs-btn-hover-bg: #157347;
  --bs-btn-hover-border-color: #146c43;
  --bs-btn-focus-shadow-rgb: 60, 153, 110;
  --bs-btn-active-color: #fff;
  --bs-btn-active-bg: #146c43;
  --bs-btn-active-border-color: #13653f;
  --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
  --bs-btn-disabled-color: #fff;
  --bs-btn-disabled-bg: #198754;
  --bs-btn-disabled-border-color: #198754;
}

.btn-primary {
  --bs-btn-color: #fff;
  --bs-btn-bg: #0d6efd;
  --bs-btn-border-color: #0d6efd;
  --bs-btn-hover-color: #fff;
  --bs-btn-hover-bg: #0b5ed7;
  --bs-btn-hover-border-color: #0a58ca;
  --bs-btn-focus-shadow-rgb: 49, 132, 253;
  --bs-btn-active-color: #fff;
  --bs-btn-active-bg: #0a58ca;
  --bs-btn-active-border-color: #0a53be;
  --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
  --bs-btn-disabled-color: #fff;
  --bs-btn-disabled-bg: #0d6efd;
  --bs-btn-disabled-border-color: #0d6efd;
}

.btn-danger {
  --bs-btn-color: #fff;
  --bs-btn-bg: #dc3545;
  --bs-btn-border-color: #dc3545;
  --bs-btn-hover-color: #fff;
  --bs-btn-hover-bg: #bb2d3b;
  --bs-btn-hover-border-color: #b02a37;
  --bs-btn-focus-shadow-rgb: 225, 83, 97;
  --bs-btn-active-color: #fff;
  --bs-btn-active-bg: #b02a37;
  --bs-btn-active-border-color: #a52834;
  --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
  --bs-btn-disabled-color: #fff;
  --bs-btn-disabled-bg: #dc3545;
  --bs-btn-disabled-border-color: #dc3545;
}

.btn-sm, .btn-group-sm > .btn {
  --bs-btn-padding-y: 0.25rem;
  --bs-btn-padding-x: 0.5rem;
  --bs-btn-font-size: 0.875rem;
  --bs-btn-border-radius: 0.25rem;
}

.btn-profile {
    margin: 0;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-left-radius: var(--bs-card-inner-border-radius);
    border-bottom-right-radius: var(--bs-card-inner-border-radius);
    width: 100%;
}

.btn-profile input[type=file] {
    position: absolute;
    top: 0;
    left: 0;
    text-align: center;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: none;
    cursor: inherit;
    display: block;
    padding: 0;
    width: 100%;
    height: 100%;
}

.btn i.bi-pencil-square:before {
    color: #fff !important;
}

</style>
<div class="container" data-sess-id="<?=session()->get('id')?>">
    <div class="row">
        <div class="col12">
            <div class="card">
                <div class="card-body">
                    <div class="bs-row">
                        <div class="col-xs-12 col-sm-12 col-md-2 col-xl-2 mb-3">
                            <img id="p-image" src="<?=$profile->profile?>" class="profile">
                            <!-- <div class="d-grid"> -->
                                <button type="button" class="btn btn-sm btn-profile btn-success">
                                    <span id="file-label">
                                        <i class="bi bi-person-bounding-box mr-1"></i> Upload Image
                                    </span>
                                    <input type="file" id="p-uimage" onchange="onFileHandel(this.id)"
                                    accept=".jpg,.jpeg,.png"/>
                                </button>
                            <!-- </div> -->
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
                                                ชื่อแหล่งท่องเที่ยว/สถานประกอบการ/รายการนำเที่ยว
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
                                                ประเภทการสมัคร
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
                                                สาขารางวัล
                                            </span>
                                        </div>
                                        <div class="card-body" style="padding: 10px;">
                                            <span class="fs-18">
                                                <?=$profile->app_ts?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <?php if($profile->lowdarbon_sts): ?>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 mb-3">
                                    <div class="card border"> 
                                        <div class="card-header text-sm-center">
                                            <span class="fs-18 text-base-main fw-semibold">
                                                ต้องการสมัครประเภทพิเศษ Low Carbon & Sustainability
                                            </span>
                                        </div>
                                        <div class="card-body" style="padding: 10px;">
                                            <span class="fs-18">
                                                <?=$profile->lowcarbon_str?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
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
                                        <input type="text" class="form-control" id="p-name" maxlength="255"
                                        value="<?=$profile->name?>">
                                        <label>ชื่อจริง<span class="text-danger ml-1">*</span></label>
                                        <div id="invalid-p-name" class="invalid-feedback">
                                            กรุณากรอก ชื่อจริง
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="p-surname" maxlength="255"
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
                                        value="<?=$profile->mobile?>" maxlength="10">
                                        <label>เบอร์โทรศัพท์<span class="text-danger ml-1">*</span></label>
                                        <div id="invalid-p-mobile" class="invalid-feedback">
                                            กรุณากรอก เบอร์โทรศัพท์
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-8">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="p-email" readonly
                                        value="<?=$profile->email?>">
                                        <label>อีเมล</label>
                                        <div id="invalid-p-email" class="invalid-feedback" >
                                            กรุณากรอก อีเมล
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bs-row mt-3">
                                <div class="col-12">
                                    <!-- <button type="reset" class="btn btn-danger float-end ml-2">
                                        <i class="bi bi-x-circle mr-1"></i> ยกเลิก
                                    </button> -->
                                    <button type="button" class="btn btn-primary float-end" onclick="pf.save()">
                                        <i class="bi bi-pencil-square mr-1"></i> อัพเดทข้อมูล
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
<script>
    $('#p-mobile').on('keyup change input', function(){
        this.value = this.value.replace(/[^0-9]/g,'');
    });

    $('#p-name, #p-surname').on('keyup change input', function() {
        this.value = this.value.replace(/[^a-zA-Z\u0E00-\u0E7F\s]/g,'');
    });
</script>
<?php $config = new \Config\App(); ?>
<script src="<?=base_url('assets/js/frontend/profile.js')?>?v=<?=$config->script_v?>"></script>