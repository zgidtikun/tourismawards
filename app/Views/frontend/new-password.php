<style>
    .inp-remark {
        font-size: 13px;
        color: #6c757d;
        margin-left: 1rem;
}
</style>
<div class="container login" style="height: 100%;" data-id="<?=$id?>" data-lg="<?=$login?>">
    <div class="row">
        <div class="col6 loginbox">
            <div class="formbox">
                <div class="formbox_row">
                    <div class="inp_form login text-center">
                        <h3>ตั้งค่ารหัสผ่านใหม่</h3>
                        <?php if(!$status): ?>
                        <div class="alert alert-danger" style="margin-top:1.5rem;">
                            <?=$message?>
                        </div>
                        <?php else : ?>
                        <div class="inp_form_row">
                            <div class="inp_form_col1">
                                <input type="text" id="username" placeholder="อีเมล"
                                value="<?=$email?>"
                                disabled>
                            </div>
                            <?php if($login): ?>
                            <div class="inp_form_col1">
                                <input type="password" id="old-password" placeholder="รหัสผ่านเดิม">
                            </div>
                            <?php endif; ?>
                            <div class="inp_form_col1">
                                <input type="password" id="password" placeholder="รหัสผ่านใหม่">
                                <span class="inp-remark">รหัสผ่านต้องมี A-Z, a-z, 0-9 และอย่างน้อย 6 ตัวอักษร</span>
                            </div>
                            <div class="inp_form_col1">
                                <input type="password" id="con-password" placeholder="ยืนยันรหัสผ่านใหม่">
                            </div>
                            <div class="inp_form_col1 submit">
                                <button type="button" onclick="signin.authen()">บันทึก</button>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col6 loginbg">
        </div>
    </div>
</div>
<script>
    $('#username, #password, #con-password').keypress((e) => {
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
                        lg: $('.login').attr('data-lg'), 
                        email: $('#username').val(),
                        password: $('#password').val(),
                        password_old: $('#old-password').val(),
                        password_con: $('#con-password').val(),
                        recapcha_token: signin.token
                    },
                    dataType: 'json',
                    async: false,
                    success: function(response) {
                        if (response.result == 'success') {
                            $('#password').val('');
                            $('#con-password').val('');
                            $('#old-password').val('');

                            let message,link;
                            
                            <?php if(!session()->get('isLoggedIn')) : ?>
                            message = 'ด้วยปุ่ม "ตกลง" เพื่อยังหน้าเข้าสู่ระบบ';
                            link = '<?=base_url('login')?>';
                            <?php else : ?>
                            message = 'ด้วยปุ่ม "ตกลง" เพื่อยังหน้าข้อมูลส่วนตัว';
                            link = '<?=base_url('profile')?>';
                            <?php endif; ?>

                            alert.show('success','เปลี่ยนรหัสผ่านใหม่เรียบร้อยแล้ว', message).then(function(data){
                                window.location.href = link;
                            });
                        } else {
                            alert.show('error','ไม่สามารถเปลี่ยนรหัสผ่านใหม่ได้', response.message);                               
                        }
                    }
                });
                <?php if (!empty($_recapcha) && $_recapcha) : ?>
                });
                <?php endif; ?>
            }
        },
        validation: function() {
            const username = $('#username').val();
            const passwordOld = $('#old-password').val();
            const passwordNew = $('#password').val(); 
            const passwordCon = $('#con-password').val();
            const patternPassword = /^[A-Za-z0-9]+$/;
            const lg = $('.login').attr('data-lg');
            let strength = 0;
            
            if (username == '') {
                alert.show('error','ไม่สามารถเปลี่ยนรหัสผ่านใหม่ได้', 'กรุณากรอกอีเมล');
                return false;
            }

            if(Number(lg) == 1 && passwordOld == ''){
                alert.show('error','ไม่สามารถเปลี่ยนรหัสผ่านใหม่ได้', 'กรุณากรอกรหัสผ่านเดิม');
                return false;
            }

            if (passwordNew == '') {
                alert.show('error','ไม่สามารถเปลี่ยนรหัสผ่านใหม่ได้', 'กรุณากรอกรหัสผ่านใหม่');
                return false;
            }

            if (!/^[a-zA-Z0-9]/g.test(passwordNew)) {
                alert.show('error','ไม่สามารถเปลี่ยนรหัสผ่านใหม่ได้', 'รหัสผ่านต้องมี A-Z, a-z, 0-9 และอย่างน้อย 6 ตัวอักษร');
                return false;
            }
            
            if (passwordNew.length < 6) {
                alert.show('error','ไม่สามารถเปลี่ยนรหัสผ่านใหม่ได้', 'รหัสผ่านต้องมี A-Z, a-z, 0-9 และอย่างน้อย 6 ตัวอักษร');
                return false;
            }

            if (passwordNew.match(/[a-z]+/)) {
                strength++;
            }

            if (passwordNew.match(/[A-Z]+/)) {
                strength++;
            }

            if (passwordNew.match(/[0-9]+/)) {
                strength++;
            }
            
            if (strength < 3) {
                alert.show('error','ไม่สามารถเปลี่ยนรหัสผ่านใหม่ได้', 'รหัสผ่านต้องมี A-Z, a-z, 0-9 และอย่างน้อย 6 ตัวอักษร');
                return false;
            }

            if(Number(lg) == 1 && passwordNew == passwordOld){                
                alert.show('error','ไม่สามารถเปลี่ยนรหัสผ่านใหม่ได้', 'กรุณาตัวรหัสผ่านใหม่ให้ไม่เหมือนกับรหัสผ่านเดิม');
                return false;
            }

            if (passwordCon == '') {
                alert.show('error','ไม่สามารถเปลี่ยนรหัสผ่านใหม่ได้', 'กรุณากรอกยืนยันรหัสผ่านใหม่');
                return false;
            }

            if (passwordNew != passwordCon) {
                alert.show('error','ไม่สามารถเปลี่ยนรหัสผ่านใหม่ได้', 'รหัสผ่านใหม่และยืนยันรหัสผ่านใหม่ไม่เหมือนกัน');
                return false;
            }

            return true;
        }
    }
</script>