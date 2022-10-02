<div class="container login" style="height: 100%;">
    <div class="row">
        <div class="col6 loginbox">
            <div class="formbox">
                <div class="formbox_row logo">
                    <picture>
                        <source srcset="<?= base_url('assets/images/logo.svg') ?>">
                        <img src="<?= base_url('assets/images/logo.png') ?>" width="230" height="89">
                    </picture>
                </div>

                <div class="formbox_row">
                    <div class="inp_form login">
                        <h1 id="title">เข้าสู่ระบบ</h3>
                        <h4 id="sum">เข้าสู่ระบบ</h3>
                        <h3 id="question">เข้าสู่ระบบ</h3>
                        <h4 id="remark">เข้าสู่ระบบ</h3>
                        <div class="inp_form_row">
                            <div class="inp_form_col1">
                                
                                    
                                <div class="inp_form_col1">
                                    <input type="text" id="reply">
                                </div>

                                <form>
                                <div class="inp_form_col1">
                                    <input type="file" id="paperFile" multiple>
                                </div>
                                </form>

                                <form>
                                <div class="inp_form_col1">
                                    <input type="file" id="imagesFile" multiple>
                                </div>
                                </form>
                            </div>
                            <div class="inp_form_col1 submit">
                                <button type="button">เข้าสู่ระบบ</button>
                            </div>
                            <div class="inp_form_col1 accept" id="group-type">

                            </div>
                            <div class="inp_form_col1 accept" id="group-type-sub">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col6 loginbg">
        </div>    
        <div class="loading" id="loading-page"></div>
    </div>
</div>
<?php $app = new \Config\App(); ?>
<link rel="preload" as="script" href="<?= base_url('assets/js/frontend/psc.js')?>?v=<?=$app->script_v?>"> 
<script src="<?=base_url('assets/js/frontend/psc.js')?>?v=<?=$app->script_v?>"></script>
<script>
    $(document).ready(function(){
        psc.init();
    });
</script>