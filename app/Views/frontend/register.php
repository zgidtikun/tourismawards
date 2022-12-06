<div class="container login">
    <div class="row">
        <div class="col6 loginbox">
            <div class="formbox">
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
                                สมัครสมาชิกเรียบร้อยแล้ว กรุณารอการตรวจสอบอีเมลของท่านเพื่อทำการยืนยันตัวตนเข้าสู่ระบบ
                            </b>
                        </div>
                            <?php else: ?>
                        <div class="alert alert-danger alert-dismissible fade show" id="error">
                            <p><b><i class="bi bi-exclamation-triangle-fill"></i> เกิดข้อผิดพลาดตามรายการนี้</b></p>
                            <?php foreach($_signup->error as $key=>$e){ ?>
                            <?=($key+1)?>. <?=$e?><br>
                            <?php } ?>
                            
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
                                    $attr = ['id' => 'role', 'readonly' => 'readonly'];
                                    $options = ['1' => 'ผู้ประกอบการ'/*, '2' => 'คณะกรรมการ'*/];
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
                                    <textarea rows="7" id="policy" class="policy" style="font-size: 15px;" readonly>
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
        $('#policy').html(
            '1. สามารถเลือกส่งผลงานเข้าประกวดได้เพียงประเภทรางวัลเดียวสาขาเดียวเท่านั้นที่ตรงกับแนวทางการดำเนินงานของท่าน มากที่สุด \n'
            + '2. เมื่อเลือกสมัครในประเภทรางวัลใดแล้ว ไม่สามารถเปลี่ยนแปลงประเภทรางวัลได้ \n'
            + '3. หน่วยงานเจ้าของผลงานจะต้องเป็นผู้ส่งผลงานเข้าประกวดเองหรือบุคคล/หน่วยงานอื่นเป็นผู้ส่งผลงานเข้าประกวดให้ได้ '
            + 'แต่เจ้าของผลงานต้องลงลายมือชื่อให้การยินยอมไว้เป็นหลักฐานในเอกสารการสมัคร \n'
            + '4. ขอสงวนสิทธิ์ในการพิจารณารางวัลหากพบว่าเป็นผลงานที่ขาดคุณสมบัติตามเกณฑ์ที่กำหนด \n'
            + '5. กรณีที่ผลงานที่ส่งเข้าประกวดรางวัลได้รับการคัดเลือกเข้าสู่กระบวนการตรวจประเมินเจ้าของผลงานจะต้องให้ความร่วมมือ '
            + 'ต่อคณะกรรมการในการเรียกดูเอกสารที่เกี่ยวข้องเพิ่มเติมและการเข้าตรวจประเมินพื้นที่และการใช้ประโยชน์ของพื้นที่ให้สอดคล้อง'
            + 'กับประเภทรางวัลที่ส่งเข้าประกวด \n'
            + '6. หากพบว่าผู้ส่งผลงานมีเจตนาแสดงข้อมูลอันเป็นเท็จ ททท. จะตัดสิทธิ์ในการประกวดทันที \n'
            + '7. ผลการตัดสินรางวัลของกรรมการฯ ถือเป็นที่สิ้นสุด โดยมีกำหนดระยะเวลา ๒ ปี นับจากวันที่ได้รับรางวัล และ ททท. '
            + 'ขอสงวนสิทธิ์ในการยกเลิก เปลี่ยนแปลง การให้รางวัลได้โดยไม่ต้องแจ้งให้ทราบล่วงหน้า'
        );
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
        $('#regis-form').submit();      
    }
</script>