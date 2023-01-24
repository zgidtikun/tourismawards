<div class="container login">
    <div class="row">
        <div class="col6 loginbox">
            <div class="formbox">
                <div class="formbox_row">
                    <div class="inp_form">
                    <?php //if($_expire) : ?>
                        <!-- <div class="alert alert-danger alert-dismissible fade show" id="error">
                            <i class="bi bi-exclamation-triangle-fill"></i> 
                            ไม่สามารถ Verify ได้เนื่องจากหมดเวลาการยืนยันตัวตนได้ กรุณาติดต่อเจ้าหน้าที่ได้ที่  
                            <a class="alert-link" href="<?=base_url('contact-us')?>" title="ติดต่อเรา">
                                ติดต่อเรา
                            </a>
                        </div> -->
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
    $(document).ready(function(){
        showAlert('<?=($_verified ? 'success' : 'error')?>');
    });

    const showAlert = async verified => {
        switch(verified){
            case 'success':
                const setting = {
                    icon: 'success',
                    title: 'Verified ผู้ประกอบการเรียบร้อยแล้ว',
                    text: '',
                    btnText: 'เข้าสู่ระบบ'
                    // text: '<?=($_password) ? 'คุณยังไม่ได้ตั้งค่ารหัสผผ่าน' : ''?>',
                    // btnText: '<?=($_password) ? 'ตั้งค่ารหัสผผ่าน' : 'เข้าสู่ระบบ'?>',
                }

                alert.verify(setting).then(response => {
                    <?php // if($_password) : ?>
                    // window.location.href = '<?=base_url('new-password')?>';
                    <?php //else : ?>
                    window.location.href = '<?=base_url('login')?>';
                    <?php // endif; ?>                    
                });
            break;
            case 'error': 
                alert.show('error','ไม่สามารถ Verify ผู้ประกอบการได้','กรุณาติดต่อเจ้าหน้าที่');
            break;
        }
    }
</script>