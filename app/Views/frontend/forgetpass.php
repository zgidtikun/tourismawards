<div class="container login">
    <div class="row">
        <div class="col6 loginbox">
            <div class="formbox">

                <div class="formbox_row">
                    <div class="inp_form forget">
                        <h3>ลืมรหัสผ่าน</h3>
                        <p class="subhead">รีเซ็ตรหัสผ่านด้วยอีเมลที่ใช้งาน</p>
                        <?=form_open()?>
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
                        <?=form_close()?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col6 loginbg">
        </div>
    </div>
</div>
<script>
    const forget = {
        token: null,
        validate: function(){
            if($('#email').val() == ''){
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
                    $.ajax({
                        method: 'post',
                        url: '<?=base_url('auth/ajax-reset-password')?>',
                        async: false,
                        data: {
                            email: $('#email').val(),
                            recapcha_token: forget.token
                        },
                        dataType: 'json',
                        success:async function(response){
                            if(response.result == 'success'){
                                let setting = {
                                    icon: 'success',
                                    title: 'รีเซ็ตรหัสผ่านเรียบร้อยแล้ว',
                                    text: 'กรุณาตรวจสอบรหัสผ่านที่อีเมลของคุณ',
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
                                    $('#email').val('');
                                }
                            } else {
                                alert.show('error','ไม่สามารถรีเซ็ตรหัสผ่าน',response.message);
                                return;
                            }
                        }
                    });                        
                <?php if (!empty($_recapcha) && $_recapcha) : ?>
                });
                <?php endif; ?>
            }
        }
    }
</script>