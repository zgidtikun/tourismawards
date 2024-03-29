<style>
    .in-valid {
        font-size: 13px;
        color: red;
        margin-left: 1rem;
    }

    .inp-invalid {
        border-color: #dc3545;
    }

    .inp-remark {
        font-size: 13px;
        color: red;
        color: #6c757d;
        margin-left: 1rem;
    }
</style>
<div class="container login">
    <div class="row">
        <div class="col6 loginbox">
            <div class="formbox">
                <div class="formbox_row">
                    <div class="inp_form">
                        <?php if(!$_register_expire): ?>
                        <h3>ลงทะเบียนเข้าสู่ระบบ</h3>
                        <?php else: ?>
                        <h3>หมดเวลาการลงทะเบียนเข้าสู่ระบบ</h3>
                        <?php endif; ?>
                        <?php 
                            if($_signup->method == 'post') : 
                                if($_signup->status) :
                        ?>                        
                        <div class="alert alert-success" id="success">
                            <b>
                                <i class="bi bi-check-circle-fill"></i> 
                                ลงทะเบียนเข้าสู่ระบบเรียบร้อยแล้ว<br><br>
                                กรุณาตรวจสอบอีเมลของท่านในกล่องจดหมายเข้า (Inbox) หากไม่พบลองตรวจสอบในกล่องอีเมลขยะ 
                                (Junk หรือ Spam) เพื่อทำการยืนยันตัวตนเข้าสู่ระบบ<br><br>
                                หากท่านไม่กดปุ่มยืนยันตัวตน ท่านจะไม่สามารถเข้าสู่ระบบได้ 
                            </b>
                        </div>
                            <?php 
                                else : 
                                    $error_counter = 1;
                                    if(!empty($_signup->error->recapcha) || !empty($_signup->error->insert)):
                            ?>
                        <div class="alert alert-danger alert-dismissible fade show" id="error">
                            <p><b><i class="bi bi-exclamation-triangle-fill"></i> เกิดข้อผิดพลาดตามรายการนี้</b></p>
                            <?php if(!empty($_signup->error->recapcha)):?>
                            <?=$error_counter++?>. <?=$_signup->error->recapcha?><br>
                            <?php endif; ?>  
                            <?php if(!empty($_signup->error->insert)):?>
                            <?=$error_counter++?>. <?=$_signup->error->insert?><br>
                            <?php endif; ?>                          
                            <button type="button" class="btn-close" onclick="hide('error')"></button>
                        </div>
                        <?php 
                                    endif;
                                endif;
                            endif; 

                            if(!$_register_open):
                        ?>                    
                        <div class="alert alert-warning" id="warning">
                            <b>
                                <i class="bi bi-calendar-check-fill"></i> เปิดให้ลงทะเบียนตั้งแต่วันที่ 1 มีนาคม - 30 เมษายน 2566
                            </b>
                        </div>                        
                        <?php 

                            elseif(!$_signup->status && !$_register_expire && $_register_open) :
                                $attr = ['id' => 'regis-form'];
                                echo form_open(route_to('register'), $attr);
                        ?>
                            <div class="inp_form_row">
                                <div class="inp_form_col3">
                                <?php 
                                    $attr = ['id' => 'prifix'];
                                    $options = ['นาย' => 'นาย', 'นาง' => 'นาง', 'นางสาว'  => 'นางสาว'];
                                    $selected = !empty($_signup->data->prefix) ? $_signup->data->prefix  : 'นาย';
                                    echo form_dropdown('prefix', $options, $selected,$attr);
                                ?>
                                </div>
                                <div class="inp_form_col3">
                                <?php 
                                    $attr = [
                                        'type' => 'text',
                                        'id' => 'name',
                                        'name' => 'name',
                                        'value' => !empty($_signup->data->name) ? $_signup->data->name  : '',
                                        'placeholder' => 'ชื่อ *', 
                                        'maxlength' => 255,
                                        'class' => !empty($_signup->error->name) ? 'inp-invalid' : ''
                                    ];
                                    echo form_input($attr);
                                ?>
                                <?php if(!empty($_signup->error->name)) : ?>
                                    <span class="in-valid"><?=$_signup->error->name?></span>
                                <?php endif;?>
                                </div>
                                <div class="inp_form_col3">
                                <?php 
                                    $attr = [
                                        'type' => 'text',
                                        'id' => 'surname',
                                        'name' => 'surname',
                                        'value' => !empty($_signup->data->surname) ? $_signup->data->surname  : '',
                                        'placeholder' => 'นามสกุล *', 
                                        'maxlength' => 255,
                                        'class' => !empty($_signup->error->surname) ? 'inp-invalid' : ''
                                    ];
                                    echo form_input($attr);
                                ?>
                                <?php if(!empty($_signup->error->surname)) : ?>
                                    <span class="in-valid"><?=$_signup->error->surname?></span>
                                <?php endif;?>
                                </div>
                                <div class="inp_form_col1">
                                <?php 
                                    $attr = [
                                        'type' => 'text',
                                        'id' => 'telephone',
                                        'name' => 'telephone',
                                        'value' => !empty($_signup->data->telephone) ? $_signup->data->telephone  : '',
                                        'placeholder' => 'เบอร์โทรศัพท์ *', 
                                        'maxlength' => 10,
                                        'class' => !empty($_signup->error->telephone) ? 'inp-invalid' : ''
                                    ];
                                    echo form_input($attr);
                                ?>
                                <?php if(!empty($_signup->error->telephone)) : ?>
                                    <span class="in-valid"><?=$_signup->error->telephone?></span>
                                <?php endif;?>
                                </div>
                                <div class="inp_form_col2">
                                <?php 
                                    $attr = [
                                        'type' => 'text',
                                        'id' => 'email',
                                        'name' => 'email',
                                        'value' => !empty($_signup->data->email) ? $_signup->data->email  : '',
                                        'placeholder' => 'อีเมล *', 
                                        'class' => !empty($_signup->error->email) ? 'inp-invalid' : ''
                                    ];
                                    echo form_input($attr);
                                ?>
                                <?php if(!empty($_signup->error->email)) : ?>
                                    <span class="in-valid"><?=$_signup->error->email?></span>
                                <?php endif;?>
                                </div>
                                <div class="inp_form_col2">
                                <?php 
                                    $attr = [
                                        'type' => 'text',
                                        'id' => 'confirmemail',
                                        'name' => 'confirmemail',
                                        'value' => !empty($_signup->data->confirmemail) ? $_signup->data->confirmemail  : '',
                                        'placeholder' => 'ยืนยันอีเมล *', 
                                        'class' => !empty($_signup->error->confirmemail) ? 'inp-invalid' : ''
                                    ];
                                    echo form_input($attr);
                                ?>
                                <?php if(!empty($_signup->error->confirmemail)) : ?>
                                    <span class="in-valid"><?=$_signup->error->confirmemail?></span>
                                <?php endif;?>
                                </div>
                                <div class="inp_form_col2">
                                <?php 
                                    $attr = [
                                        'type' => 'password',
                                        'id' => 'password',
                                        'name' => 'password',
                                        'value' => !empty($_signup->data->password) ? $_signup->data->password  : '',
                                        'placeholder' => 'รหัสผ่าน *', 
                                        'class' => !empty($_signup->error->password) ? 'inp-invalid' : ''
                                    ];
                                    echo form_input($attr);
                                ?>
                                    <span class="inp-remark">รหัสผ่านต้องมี A-Z, a-z, 0-9 และอย่างน้อย 6 ตัวอักษร</span>
                                <?php if(!empty($_signup->error->password)) : ?>
                                    <span class="in-valid"><?=$_signup->error->password?></span>
                                <?php endif;?>
                                </div>
                                <div class="inp_form_col2">
                                <?php 
                                    $attr = [
                                        'type' => 'password',
                                        'id' => 'confirmpass',
                                        'name' => 'confirmpass',
                                        'value' => !empty($_signup->data->confirmpass) ? $_signup->data->confirmpass  : '',
                                        'placeholder' => 'ยืนยันรหัสผ่าน *', 
                                        'class' => !empty($_signup->error->confirmpass) ? 'inp-invalid' : ''
                                    ];
                                    echo form_input($attr);
                                ?>
                                <?php if(!empty($_signup->error->confirmpass)) : ?>
                                    <span class="in-valid"><?=$_signup->error->confirmpass?></span>
                                <?php endif;?>
                                </div>
                                <div class="inp_form_col1 accept">
                                    <input type="checkbox" id="accept">
                                    ข้าพเจ้าได้อ่านและตกลงยินยอมตามรายละเอียดข้อตกลง เงื่อนไขการใช้งานและ<b><a href="<?=base_url('privacy-policy')?>" target="_blank" title="นโยบายความเป็นส่วนตัว">นโยบายความเป็นส่วนตัว</a></b>
                                </div>
                                <div class="inp_form_col1 submit">
                                    <button id="btn-regis" type="button" disabled
                                    onclick="register()">ลงทะเบียน</button>
                                </div>
                                <?php    
                                    $attr = ['type' => 'hidden', 'id' => 'role', 'name' => 'role', 'value' => 1];
                                    echo form_input($attr);

                                    $attr = ['type' => 'hidden', 'id' => 'recapcha_token', 'name' => 'recapcha_token',
                                    'value' => !empty($_signup->data->recapcha_token) ? $_signup->data->recapcha_token  : ''];
                                    echo form_input($attr);
                                ?>
                            </div>
                        <?php 
                                echo form_close();
                            endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col6 loginbg">
        </div>
    </div>
</div>
<script>
    $('#accept').click(function(){
        if($(this).is(':checked'))
            $('#btn-regis').prop('disabled',false);
        else $('#btn-regis').prop('disabled',true);
    });

    $('#telephone').on('keyup change input', function(){
        this.value = this.value.replace(/[^0-9]/g,'');
    });

    $('#name, #surname').on('keyup change input', function() {
        this.value = this.value.replace(/[^a-zA-Z\u0E00-\u0E7F\s]/g,'');
    });

    var hide = (id) => {
        if(!$('#'+id).hasClass('hide'))
            $('#'+id).addClass('hide');
        else $('#'+id).removeClass('hide'); 
    }

    var register = () => {   
        <?php if(!empty($_recapcha) && $_recapcha) : ?>
        setRecapchaToken().then(data => { 
        <?php endif; ?>
            $('#regis-form').submit(); 
        <?php if(!empty($_recapcha) && $_recapcha) : ?>
        });
        <?php endif; ?>
    }
</script>