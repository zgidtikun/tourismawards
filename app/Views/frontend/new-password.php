<div class="container login" style="height: 100%;">
    <div class="row">
        <div class="col6 loginbox">
            <div class="formbox">
                <div class="formbox_row">
                    <div class="inp_form login">
                        <h3>ตั้งค่ารหัสผ่านใหม่</h3>
                        <div class="inp_form_row">
                            <div class="inp_form_col1">
                                <input type="text" id="username" placeholder="อีเมล"
                                value="<?=$email?>"
                                <?=!empty($email) ? 'disabled' : ''?>>
                            </div>
                            <div class="inp_form_col1">
                                <input type="password" id="password" placeholder="รหัสผ่านใหม่">
                            </div>
                            <div class="inp_form_col1">
                                <input type="password" id="con-password" placeholder="ยืนยันรหัสผ่านใหม่">
                            </div>
                            <div class="inp_form_col1 submit">
                                <button type="button" onclick="signin.authen()">บันทึก</button>
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
                                message = 'คุณสามารถบันทึกข้อมูลได้ตลอดเวลา<br>';
                                message += 'ด้วยปุ่ม "บันทึก" และกดปุ่ม "ส่งใบสมัคร" เมื่อพร้อม';    
                            } else {
                                message = 'คุณสามารถกลับมาประเมินต่อ หรือแก้ไขการประเมินได้<br>';
                                message += 'ก่อนส่งผลการประเมินเข้าระบบ';
                            }

                            alert.show('info','คำแนะนำการใช้งาน', message).then(function(data){
                                window.location.href = response.redirect;
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