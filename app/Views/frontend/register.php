<style>
</style>
<div class="container login">
    <div class="row">
        <div class="col6 loginbox">
            <div class="formbox">
                <div class="formbox_row logo">
                    <picture>
                        <source srcset="<?=base_url('assets/images/logo.svg')?>">
                        <img src="<?=base_url('assets/images/logo.png')?>" width="230" height="89">
                    </picture>
                </div>

                <div class="formbox_row">
                    <div class="inp_form">
                        <h3>สมัครสมาชิก</h3>
                        <?php 
                            if($_signup->method == 'post') : 
                                if($_signup->status) :
                        ?>
                        <div class="alert alert-success" id="success">
                            <b>
                                <i class="bi bi-check-circle-fill"></i> 
                                สมัครสมาชิกเรียบร้อยแล้ว กรุณารอการตรวจสอบจากผู้ดำเนินงาน 
                                <a class="alert-link alert-link-fixed-end" href="<?=route_to('login')?>" title="กลับหน้าแรก">
                                    <i class="bi bi-cursor-fill"></i> ล็อคอินเข้าสู่ระบบ
                                </a>
                            </b>
                        </div>
                            <?php else: ?>
                        <div class="alert alert-danger alert-dismissible fade show" id="error">
                            <b><i class="bi bi-exclamation-triangle-fill"></i> เกิดข้อผิดพลาดตามรายการนี้</b>                            
                            <ul id="error-list">
                                <?php foreach($_signup->error as $e){ ?>
                                <li><?=$e?></li>
                                <?php } ?>
                            </ul>
                            
                            <button type="button" class="btn-close" onclick="hide('error')"></button>
                        </div>
                        <?php 
                                endif;
                            endif; 

                            if(!$_signup->status) :
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
                                        'placeholder' => 'ชื่อ *'
                                    ];
                                    echo form_input($attr);
                                ?>
                                </div>
                                <div class="inp_form_col3">
                                <?php 
                                    $attr = [
                                        'type' => 'text',
                                        'id' => 'surname',
                                        'name' => 'surname',
                                        'value' => !empty($_signup->data->surname) ? $_signup->data->surname  : '',
                                        'placeholder' => 'นามสกุล *'
                                    ];
                                    echo form_input($attr);
                                ?>
                                </div>
                                <div class="inp_form_col1">
                                <?php 
                                    $attr = ['id' => 'role'];
                                    $options = ['1' => 'ผู้ประกอบการ', '2' => 'คณะกรรมการ'];
                                    $selected = !empty($_signup->data->role) ? $_signup->data->role  : '1';
                                    echo form_dropdown('role', $options, $selected,$attr);
                                ?>
                                </div>
                                <div class="inp_form_col1">
                                <?php 
                                    $attr = [
                                        'type' => 'text',
                                        'id' => 'telephone',
                                        'name' => 'telephone',
                                        'value' => !empty($_signup->data->telephone) ? $_signup->data->telephone  : '',
                                        'placeholder' => 'เบอร์โทรศัพท์ *'
                                    ];
                                    echo form_input($attr);
                                ?>
                                </div>
                                <div class="inp_form_col2">
                                <?php 
                                    $attr = [
                                        'type' => 'email',
                                        'id' => 'email',
                                        'name' => 'email',
                                        'value' => !empty($_signup->data->email) ? $_signup->data->email  : '',
                                        'placeholder' => 'อีเมล *'
                                    ];
                                    echo form_input($attr);
                                ?>
                                </div>
                                <div class="inp_form_col2">
                                <?php 
                                    $attr = [
                                        'type' => 'email',
                                        'id' => 'confirmemail',
                                        'name' => 'confirmemail',
                                        'value' => !empty($_signup->data->confirmemail) ? $_signup->data->confirmemail  : '',
                                        'placeholder' => 'ยืนยันอีเมล *'
                                    ];
                                    echo form_input($attr);
                                ?>
                                </div>
                                <div class="inp_form_col2">
                                <?php 
                                    $attr = [
                                        'type' => 'password',
                                        'id' => 'password',
                                        'name' => 'password',
                                        'value' => !empty($_signup->data->password) ? $_signup->data->password  : '',
                                        'placeholder' => 'รหัสผ่าน *'
                                    ];
                                    echo form_input($attr);
                                ?>
                                </div>
                                <div class="inp_form_col2">
                                <?php 
                                    $attr = [
                                        'type' => 'password',
                                        'id' => 'confirmpass',
                                        'name' => 'confirmpass',
                                        'value' => !empty($_signup->data->confirmpass) ? $_signup->data->confirmpass  : '',
                                        'placeholder' => 'ยืนยันรหัสผ่าน *'
                                    ];
                                    echo form_input($attr);
                                ?>
                                </div>
                                <div class="inp_form_col1">
                                    <textarea rows="5" id="policy" class="policy" readonly>                                        
                                    </textarea>
                                </div>
                                <div class="inp_form_col1 accept">
                                    <input type="checkbox" id="accept">
                                    ข้าพเจ้าได้อ่านและตกลงยินยอมตามรายละเอียดข้อตกลงและความยินยอมข้างต้น
                                </div>
                                <div class="inp_form_col1 submit">
                                    <button id="btn-regis" type="submit" disabled>ลงทะเบียน</button>
                                </div>
                                <?php                                 
                                    $attr = ['type' => 'hidden', 'id' => 'recapcha_token', 'name' => 'recapcha_token',
                                    ];
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
    $(document).ready(function(){
        $('#policy').html("Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of and scrambled it to make a type Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type");
    });

    $('#accept').click(function(){
        if($(this).is(':checked'))
            $('#btn-regis').prop('disabled',false);
        else $('#btn-regis').prop('disabled',true);
    });

    var hide = (id) => {
        if(!$('#'+id).hasClass('hide'))
            $('#'+id).addClass('hide');
        else $('#'+id).removeClass('hide'); 
    }

    var register = () => {
        <?php if (!empty($_recapcha) && $_recapcha) : ?>
        recapchaToken().then(function(data) {
            $('#recapcha_token').val(data.rccToken);
        <?php endif; ?>
            $('#regis-form').submit();
        <?php if (!empty($_recapcha) && $_recapcha) : ?>
        });
        <?php endif; ?>
    }
</script>