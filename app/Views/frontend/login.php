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
                                มีบัญชีผู้ใช้อยู่แล้ว? 
                                <a href="<?= base_url('register') ?>" class="link_yellow">ลงทะเบียน</a>
                                <br>
                                <a href="<?= base_url('forget-password') ?>" class="link_yellow">ลืมรหัสผ่าน</a>
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
                            let message,url;

                            if(response.role == 1){
                                message = 'คุณสามารถบันทึกข้อมูลได้ตลอดเวลา<br>';
                                message += 'ด้วยปุ่ม "บันทึก" และกดปุ่ม "ส่งใบสมัคร" เมื่อพร้อม';                                                                
                                url = '<?= base_url('awards/application') ?>';
                            } else {
                                message = 'คุณสามารถกลับมาประเมินต่อ หรือแก้ไขการประเมินได้<br>';
                                message += 'ก่อนส่งผลการประเมินเข้าระบบ';
                            }

                            alert.show('info','คำแนะนำการใช้งาน', message).then(function(data){
                                window.location.href = url;
                            });
                        } else {
                            alert.show('error','Oops Login Fail...!', response.message);                               
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
                alert.show('error','Oops Login Fail...!', 'Plase enter a usernamne.');
                return false;
            }

            if ($('#password').val() == '') {
                alert.show('error','Oops Login Fail...!', 'Plase enter a password.');
                return false;
            }

            return true;
        }
    }
</script>