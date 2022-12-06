<div class="container login" style="height: 100%;" data-id="<?=$id?>">
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
                    url: '<?= base_url('auth/new-password') ?>',
                    data: {
                        id: $('.login').attr('data-id'),
                        email: $('#username').val(),
                        password: $('#password').val(),
                        recapcha_token: signin.token
                    },
                    dataType: 'json',
                    async: false,
                    success: function(response) {
                        if (response.result == 'success') {
                            $('#password').val('');
                            $('#con-password').val('');

                            let message;
                            
                            <?php if(!session()->get('isLoggedIn')) : ?>
                            message = 'ด้วยปุ่ม "ตกลง" เพื่อยังหน้าเข้าสู่ระบบ';
                            <?php else : ?>
                            message = 'ด้วยปุ่ม "ตกลง" เพื่อยังหน้าข้อมูลส่วนตัว';
                            <?php endif; ?>

                            alert.show('success','Reset Password Complete.', message).then(function(data){
                                <?php if(!session()->get('isLoggedIn')) : ?>
                                window.location.href = '<?=base_url('login/'.$id)?>';
                                <?php else : ?>
                                window.location.href = '<?=base_url('profile')?>';
                                <?php endif; ?>
                            });
                        } else {
                            alert.show('error','Oops Reset Password Fail...!', response.message);                               
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
                alert.show('error','Oops Reset Password Fail...!', 'กรุณากรอกอีเมล');
                return false;
            }

            if ($('#password').val() == '') {
                alert.show('error','Oops Reset Password Fail...!', 'กรุณากรอกรหัสผ่านใหม่');
                return false;
            }

            if ($('#con-password').val() == '') {
                alert.show('error','Oops Reset Password Fail...!', 'กรุณากรอกยืนยันรหัสผ่านใหม่');
                return false;
            }

            if ($('#password').val() != $('#con-password').val()) {
                alert.show('error','Oops Reset Password Fail...!', 'รหัสผ่านใหม่และยืนยันรหัสผ่านใหม่ไม่เหมือนกัน');
                return false;
            }

            return true;
        }
    }
</script>