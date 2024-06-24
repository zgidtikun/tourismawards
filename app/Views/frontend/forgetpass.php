<?= $this->extend('frontend/layout') ?>
<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    const forget = {
        token: null,
        validate: function(){
            if(document.querySelector('#email').value == ''){
                alert.show('error','ไม่สามารถรีเซ็ตรหัสผ่าน','กรุณากรอกอีเมล');
                return false;
            } else return true;
        },
        reset: function(){
            if(this.validate()){
                <?php if (!empty($_recapcha) && $_recapcha) : ?>
                recapchaToken().then(function(data) {
                    forget.token = data.rccToken;
                <?php endif; ?>
                    const headers = new Headers();
                    headers.append('Content-Type', 'application/json');

                    fetch(
                        '<?=base_url('auth/ajax-reset-password')?>',
                        {
                            method: 'POST',
                            headers: headers,
                            body: JSON.stringify({
                                email: document.querySelector('#email').value,
                                recapcha_token: forget.token                              
                            })
                        }
                    )
                    .then(response => response.json())
                    .then(async response => {
                        if(response.result == 'success'){
                            let setting = {
                                icon: 'success',
                                title: 'ระบบได้ส่งลิงก์เพื่อทำการรีเซ็ตรหัสผ่านให้ท่านทางอีเมล',
                                text: 'กรุณาตรวจสอบอีเมลของท่าน ทาง Inbox หรือ Spam',
                                button: {
                                    confirm: 'ล็อคอินเข้าสู่ระบบ',
                                    cancel: 'ออก'
                                },
                                mode: 'default'
                            }

                            let confirm = await alert.confirm(setting);
                            
                            if(confirm.status) {
                                window.location.href = '<?=base_url('login')?>/'+response.bank;
                            } else {
                                document.querySelector('#email').value = ''
                            }
                        } else {
                            alert.show('error','ไม่สามารถรีเซ็ตรหัสผ่าน',response.message);
                            return;
                        }
                    })
                    .catch(errors => {
                        resolve({
                            status: false,
                            result: 'error',
                            message: `Request failed : ${errors.statusText}`
                        });
                    });                    
                <?php if (!empty($_recapcha) && $_recapcha) : ?>
                });
                <?php endif; ?>
            }
        }
    }
</script>
<?= $this->endSection() ?>

<?= $this->section('recapcha') ?>
<?php if (!empty($_recapcha) && $_recapcha) : ?>
<?= $this->include('_recapcha'); ?>
<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container login">
    <div class="row">
        <div class="col6 loginbox">
            <div class="formbox">

                <div class="formbox_row">
                    <div class="inp_form forget">
                        <h3>ลืมรหัสผ่าน</h3>
                        <p class="subhead">รีเซ็ตรหัสผ่านด้วยอีเมลที่ใช้งาน</p>
                        <?= form_open() ?>
                            <div class="inp_form_row">
                                <div class="inp_form_col1">
                                    <input type="email" id="email" placeholder="อีเมล">
                                </div>

                                <div class="inp_form_col1 submit">
                                    <button type="button" class="reset" onclick="forget.reset()">รีเซ็ตรหัสผ่าน</button>
                                    <button type="reset">ยกเลิก</button>
                                </div>

                                <div class="inp_form_col1 userregister">
                                    มีบัญชีกับเราแล้ว? <a href="<?=route_to('login')?>" class="link_yellow">ล็อคอินเข้าสู่ระบบ</a>
                                </div>
                            </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col6 loginbg">
        </div>
    </div>
</div>
<?= $this->endSection() ?>