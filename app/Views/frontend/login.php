<div class="container login" style="height: 100%;">
    <div class="row">
        <div class="col6 loginbox">
            <div class="formbox">
                <div class="formbox_row">
                    <div class="inp_form login">
                        <h3>เข้าสู่ระบบ</h3>
                        <div class="inp_form_row">
                            <div class="inp_form_col1">
                                <input type="text" id="username" placeholder="อีเมล">
                            </div>
                            <div class="inp_form_col1">
                                <input type="password" id="password" placeholder="รหัสผ่าน">
                            </div>
                            <div class="inp_form_col1 userregister">
                                <?php 
                                    $_app = new \Config\App();
                                    $_register_expire = date('Y-m-d') > $_app->Register_expired;
                                    if(!$_register_expire):
                                ?>
                                มีบัญชีผู้ใช้อยู่แล้ว? 
                                <a href="<?= base_url('register') ?>" class="link_yellow">ลงทะเบียน</a>
                                <br>
                                <?php endif; ?>
                                <a href="<?= base_url('forgot-password') ?>" class="link_yellow">ลืมรหัสผ่าน</a>
                            </div>
                            <div class="inp_form_col1 submit">
                                <button type="button" onclick="signin.authen()">เข้าสู่ระบบ</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col6 loginbg">
        </div>
    </div>
</div>
<script>
    $('#username, #password').keypress((e) => {
        if(e.keyCode == 13){
            signin.authen();
        }
    });

    const signin = {
        token: '',
        authen: function() {
            if (this.validation()) {
                <?php if (!empty($_recapcha) && $_recapcha) : ?>
                recapchaToken().then(function(data) {
                    signin.token = data.rccToken;
                <?php endif; ?>
                $.ajax({
                    method: 'post',
                    url: '<?= base_url('auth/check/frontend') ?>',
                    data: {
                        username: $('#username').val(),
                        password: $('#password').val(),
                        memorize: false,
                        recapcha_token: signin.token
                    },
                    dataType: 'json',
                    async: false,
                    success: function(response) {
                        if (response.result == 'success') {
                            let message;

                            if(response.role == 1){
                                message = 'คุณสามารถบันทึกข้อมูลได้ตลอดเวลา ';
                                message += 'ด้วยปุ่ม <b>"บันทึก"</b> และกดปุ่ม <b>"ส่งใบสมัคร" </b>เมื่อพร้อม';    
                            } else {
                                message = 'ท่านสามารถบันทึกข้อมูลได้ตลอดเวลา ด้วยปุ่ม <b>"บันทึก"</b> ';
                                message += 'และสามารถกลับมาประเมินต่อ หรือแก้ไขผลการประเมินได้ ';
                                message += 'และกดปุ่ม <b>"ส่งผลประเมิน"</b> เมื่อพร้อม ดังนั้น ';
                                message += 'กรุณาตรวจสอบความถูกต้องก่อนส่งผลประเมินเข้าระบบ';
                            }

                            alert.show('info','คำแนะนำการใช้งาน', message).then(function(data){
                                window.location.href = response.redirect;
                            });
                        } else {
                            alert.show('error','ไม่สามารถเข้าสู่ระบบได้!', response.message);                               
                        }
                    }
                });
                <?php if (!empty($_recapcha) && $_recapcha) : ?>
                });
                <?php endif; ?>
            }
        },
        validation: function() {
            if ($('#username').val() == '') {
                alert.show('error','ไม่สามารถเข้าสู่ระบบได้!', 'กรุณากรอก อีเมล');
                return false;
            }

            if ($('#password').val() == '') {
                alert.show('error','ไม่สามารถเข้าสู่ระบบได้!', 'กรุณากรอก รหัสผ่าน');
                return false;
            }

            return true;
        }
    }
</script>