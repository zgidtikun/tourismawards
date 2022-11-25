<div class="container login">
    <div class="row">
        <div class="col6 loginbox">
            <div class="formbox">
                <div class="formbox_row">
                    <div class="inp_form">
                    <?php if($_verified) : ?>
                        <div class="alert alert-success" id="success">
                            <b><i class="bi bi-check-circle-fill"></i> 
                            Verified ผู้ประกอบการเรียบร้อยแล้ว</b>  
                        </div>
                    <?php else : ?>
                        <div class="alert alert-danger alert-dismissible fade show" id="error">
                            <i class="bi bi-exclamation-triangle-fill"></i> 
                            ไม่สามารถ Verify ผู้ประกอบการได้ กรุณาติดต่อเจ้าหน้าที่ได้ที่  
                            <a class="alert-link" href="<?=base_url('contact-us')?>" title="ติดต่อเรา">
                                ติดต่อเรา
                            </a>
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
    <?php if($_verified) : ?>
    alert.confirm(
        {
            mode: 'default',
            icon: 'success',
            title: 'Verified ผู้ประกอบการเรียบร้อยแล้ว',
            text: '<?=($_password) ? 'คุณยังไม่ได้ตั้งค่ารหัสผผ่าน' : ''?>',
            button: {
                confirm: '<?=($_password) ? 'ตั้งค่ารหัสผผ่าน' : 'เข้าสู่ระบบ'?>',
                cancel: 'ยกเลิก'
            }
        }
    ).then((res) => {
        <?php if($_password) : ?>
        window.location.href = '<?=base_url('new-password')?>';
        <?php else : ?>
        window.location.href = '<?=base_url('login')?>';
        <?php endif; ?>
    });
    <?php else : ?>
    alert.show('error','ไม่สามารถ Verify ผู้ประกอบการได้','กรุณาติดต่อเจ้าหน้าที่');
    <?php endif; ?>
</script>