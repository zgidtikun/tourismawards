<div class="container login" style="height: 100%;">
    <div class="row">
        <div class="col6 loginbox">
            <div class="formbox">
                <div class="formbox_row logo">
                    <picture>
                        <source srcset="<?= base_url('assets/images/logo.svg') ?>">
                        <img src="<?= base_url('assets/images/logo.png') ?>" width="230" height="89">
                    </picture>
                </div>

                <div class="formbox_row">
                    <div class="inp_form login">
                        <h3>เข้าสู่ระบบ</h3>
                        <div class="inp_form_row">
                            <div class="inp_form_col1">
                                <form>
                                <input type="file" onchange="register.onFileHandle('#step1-detail')" 
                                id="step1-detail" multiple>
                                </form>
                            </div>
                            <div class="inp_form_col1">
                                <input type="password" id="password" placeholder="รหัสผ่าน">
                            </div>
                            <div class="inp_form_col1 userregister">
                                มีบัญชีผู้ใช้อยู่แล้ว? 
                                <a href="<?= base_url('register') ?>" class="link_yellow">ลงทะเบียน</a>
                                <br>
                                <a href="<?= base_url('forget-password') ?>" class="link_yellow">ลืมรหัสผ่าน</a>
                            </div>
                            <div class="inp_form_col1 submit">
                                <button type="button">เข้าสู่ระบบ</button>
                            </div>
                            <div class="inp_form_col1 accept" id="group-type">

                            </div>
                            <div class="inp_form_col1 accept" id="group-type-sub">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col6 loginbg">
        </div>    
        <div class="loading" id="loading-page"></div>
    </div>
</div>
<link rel="preload" as="script" href="<?= base_url('assets/js/apc.js')?>"> 
<script src="<?=base_url('assets/js/apc.js')?>"></script>
<script>
    $(document).ready(function(){
        register.init(<?=session()->get('id')?>);
    });

    $.Thailand({
        $district: $('#step2-subDistrict'),
        $amphoe: $('#step2-district'),
        $province: $('#step2-province'),
        $zipcode: $('#step2-zipcode'),
    });

    $.Thailand({
        $district: $('#step3-subDistrict'),
        $amphoe: $('#step3-district'),
        $province: $('#step3-province'),
        $zipcode: $('#step3-zipcode'),
    });
</script>