<div class="banner-box">

    <div class="txt-banner">
        <h2>ติดต่อเรา</h2>
    </div>

</div>

<div class="contact-map">
    <div class="contact-map-scale">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8452.525786717564!2d100.55464927037488!3d13.748727849525267!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e29eeecb3fec3d%3A0xb4906a2c98066a18!2z4LiB4Liy4Lij4LiX4LmI4Lit4LiH4LmA4LiX4Li14LmI4Lii4Lin4LmB4Lir4LmI4LiH4Lib4Lij4Liw4LmA4LiX4Lio4LmE4LiX4Lii!5e0!3m2!1sth!2sth!4v1666939929623!5m2!1sth!2sth" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>

<div class="container">
    <div class="container_box">
        <div class="row">
            <div class="col12">
                <div class="contact-list">
                    <ul>
                        <li>
                            <div class="contact-col">
                                <div class="contact-img">
                                    <picture>
                                        <source srcset="<?=base_url('assets/images/location.svg')?>">
                                        <img src="<?=base_url('assets/images/location.png')?>">
                                    </picture>
                                </div>
                                <div class="contact-subject">
                                    ที่อยู่
                                </div>
                                <div class="contact-txt">
                                    1600 ถ.เพชรบุรีตัดใหม่
                                    แขวงมักกะสัน เขตราชเทวี
                                    กรุงเทพฯ 10400
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="contact-col">
                                <div class="contact-img">
                                    <picture>
                                        <source srcset="<?=base_url('assets/images/tel.svg')?>">
                                        <img src="<?=base_url('assets/images/tel.png')?>">
                                    </picture>
                                </div>
                                <div class="contact-subject">
                                    เบอร์โทรศัพท์
                                </div>
                                <div class="contact-txt">
                                    <b>02-250-5500</b><br>
                                    ศูนย์บริการข่าวสาร<br>
                                    การท่องเที่ยว ททท. 1672
                                </div>
                            </div>
                        </li>


                        <li>
                            <div class="contact-col">
                                <div class="contact-img">
                                    <picture>
                                        <source srcset="<?=base_url('assets/images/mail.svg')?>">
                                        <img src="<?=base_url('assets/images/mail.png')?>">
                                    </picture>
                                </div>
                                <div class="contact-subject">
                                    อีเมล
                                </div>
                                <div class="contact-txt">
                                    tourismawards14@gmail.com
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="contact-col">
                                <div class="contact-img">
                                    <picture>
                                        <source srcset="<?=base_url('assets/images/facebook.svg')?>">
                                        <img src="<?=base_url('assets/images/facebook.png')?>">
                                    </picture>
                                </div>
                                <div class="contact-subject">
                                    Facebook
                                </div>
                                <div class="contact-txt">
                                    Thailand Tourism Awards
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col12">
                <div class="main-title">
                    <div class="catagory-txt">
                        <picture>
                            <source srcset="<?=base_url('assets/images/HaveQuestions.svg')?>">
                            <source srcset="<?=base_url('assets/images/HaveQuestions.png')?>">
                            <img src="<?=base_url('assets/images/HaveQuestions.png')?>" width="277" height="50">
                        </picture>
                    </div>

                    <div class="main-title-txt">
                        <h2>ติดต่อโครงการฯ
                    </div>
                </div>

                <div class="contact-form">
                    <div class="contact-form-row">
                        <div class="contact-form-col2 inputfield">
                            <label data-tab="1" id="lName">ชื่อ-นามสกุล<span class="required">*</span></label>
                            <input type="text" id="sName" data-tab="1">
                            <div class="invalid-feedback" id="ivName"></div>
                            <a href="javascript:void(0)" class="btn-inpreset" data-tab="1"><i class="bi bi-x"></i></a>
                        </div>
                        <div class="contact-form-col2 inputfield">
                            <label data-tab="2" id="lEmail">อีเมล<span class="required">*</span></label>
                            <input type="email" id="sEmail" data-tab="2">
                            <div class="invalid-feedback" id="ivEmail"></div>
                            <a href="javascript:void(0)" class="btn-inpreset" data-tab="2"><i class="bi bi-x"></i></a>
                        </div>
                        <div class="contact-form-col1 inputfield">
                            <label data-tab="3" id="lSubject">เรื่อง<span class="required">*</span></label>
                            <input type="text" id="sSubject" data-tab="3">
                            <div class="invalid-feedback" id="ivSubject"></div>
                            <a href="javascript:void(0)" class="btn-inpreset" data-tab="3"><i class="bi bi-x"></i></a>
                        </div>
                        <div class="contact-form-col1 inputfield">
                            <label data-tab="4" id="lMessage">ข้อความ<span class="required">*</span></label>
                            <textarea id="sMessage" rows="5" data-tab="4"></textarea>
                            <div class="invalid-feedback" id="ivMessage"></div>
                            <a href="javascript:void(0)" class="btn-inpreset" data-tab="4"><i class="bi bi-x"></i></a>
                        </div>
                        <div class="contact-form-col1 btn-form-row">
                            <button type="submit" class="btn-save" onclick="send()">ส่งข้อความ</button>
                        </div>
                    </div>

                    <script>
                        jQuery(document).ready(function() { //input value hide label
                            $('.btn-inpreset').hide();

                            $('input, textarea').on('input', function() {
                                const datatab = $(this).attr('data-tab');
                                const input = `.inputfield input[data-tab="${datatab}"]`;
                                const textarea = `.inputfield textarea[data-tab="${datatab}"]`;
                                const label = `label[data-tab="${datatab}"]`;
                                const inpreset = `.btn-inpreset[data-tab="${datatab}"]`;

                                $(input).removeClass('is-invalid');
                                $(textarea).removeClass('is-invalid');
                                
                                if ($(this).val().length > 0) {
                                    $(label).hide();
                                    $(inpreset).show();
                                } else {
                                    $(label).show();
                                    $(inpreset).hide();
                                }
                            });

                            $('.btn-inpreset').click(function() {
                                const datatab = $(this).attr('data-tab');
                                $(`.inputfield input[data-tab="${datatab}"]`).val('');
                                $(`.inputfield input[data-tab="${datatab}"]`).removeClass('is-invalid');
                                $(`.inputfield textarea[data-tab="${datatab}"]`).val('');
                                $(`.inputfield textarea[data-tab="${datatab}"]`).removeClass('is-invalid');
                                $(`label[data-tab="${datatab}"]`).show();
                                $(this).hide();
                            });
                        });
                    </script>
                </div>
            </div>
        </div>

    </div>

</div>
<style>
    .btn {
        --bs-btn-padding-x: 0.75rem;
        --bs-btn-padding-y: 0.375rem;
        --bs-btn-font-family: ;
        --bs-btn-font-size: 18px;
        --bs-btn-font-weight: 400;
        --bs-btn-line-height: 1.5;
        --bs-btn-color: #212529;
        --bs-btn-bg: transparent;
        --bs-btn-border-width: 1px;
        --bs-btn-border-color: transparent;
        --bs-btn-border-radius: 0.625rem;
        --bs-btn-hover-border-color: transparent;
        --bs-btn-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15), 0 1px 1px rgba(0, 0, 0, 0.075);
        --bs-btn-disabled-opacity: 0.65;
        --bs-btn-focus-box-shadow: 0 0 0 0.25rem rgba(var(--bs-btn-focus-shadow-rgb), .5);
        display: inline-block;
        padding: var(--bs-btn-padding-y) var(--bs-btn-padding-x);
        font-family: var(--bs-btn-font-family);
        font-size: var(--bs-btn-font-size);
        font-weight: var(--bs-btn-font-weight);
        line-height: var(--bs-btn-line-height);
        color: var(--bs-btn-color);
        text-align: center;
        text-decoration: none;
        vertical-align: middle;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
        border: var(--bs-btn-border-width) solid var(--bs-btn-border-color);
        border-radius: var(--bs-btn-border-radius);
        background-color: var(--bs-btn-bg);
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }    

    .btn-primary {
        --bs-btn-color: #fff;
        --bs-btn-bg: #0d6efd;
        --bs-btn-border-color: #0d6efd;
        --bs-btn-hover-color: #fff;
        --bs-btn-hover-bg: #0b5ed7;
        --bs-btn-hover-border-color: #0a58ca;
        --bs-btn-focus-shadow-rgb: 49, 132, 253;
        --bs-btn-active-color: #fff;
        --bs-btn-active-bg: #0a58ca;
        --bs-btn-active-border-color: #0a53be;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        --bs-btn-disabled-color: #fff;
        --bs-btn-disabled-bg: #0d6efd;
        --bs-btn-disabled-border-color: #0d6efd;
        --bs-btn-border-radius: 0.375rem;
    }

    input.is-invalid, 
    textarea.is-invalid {
        border-color: #dc3545;
        background-color: #F0DDDD;
        padding-right: calc(1.5em + 0.75rem);
    }

    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 15px;
        color: #dc3545;
    }

    .is-invalid~.invalid-feedback {
        display: block;
    }
</style>
<?php $config = new \Config\App(); ?>
<script src="<?=base_url('assets/js/frontend/other.js')?>?v=<?=$config->script_v?>"></script>
<script>
    $(document).ready(() => {
        $('.mainsite').addClass('contact');
    });    

    const send = async() => {      
        if(validate()){
            return;
        }

        let recapcha_token = '';
        <?php if (!empty($_recapcha) && $_recapcha) : ?>
        const recap = await recapchaToken();
        recapcha_token = recap.rccToken;
        <?php endif; ?>

        const st = {
            method: 'post',
            url: '/contact-us/send',
            data: {
                name: $('#sName').val(),
                email: $('#sEmail').val(),
                subject: $('#sSubject').val(),
                message: $('#sMessage').val(),
                recapcha_token: recapcha_token
            }
        }

        const callback = await api(st);
        let title, message;

        if(callback.result == 'success'){            
            title = 'ได้ทำการส่งอีเมลเรียบร้อยแล้ว';            
            defaultInput();
        } else {
            title = 'ไม่สามารถส่งอีเมลได้';

            if(!empty(callback.message)){
                message = callback.message;
            }
        }

        Swal.fire({
            icon: callback.result,
            title: title,
            html: message,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'ตกลง',
            customClass: {
                confirmButton: 'btn btn-primary'
            },
            buttonsStyling: false
        });
    }

    const validate = () => {
        const mf = [
            { label: '#lName', input: '#sName', invaid: '#ivName' },
            { label: '#lEmail', input: '#sEmail', invaid: '#ivEmail' },
            { label: '#lSubject', input: '#sSubject', invaid: '#ivSubject' },
            { label: '#lMessage', input: '#sMessage', invaid: '#ivMessage' }
        ];

        const patternEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

        let invalid = false;

        $.each(mf,(k,v) => {
            if(empty($(v.input).val())){
                const message = 'กรุณากรอก '+$(v.label).html();
                $(v.input).addClass('is-invalid');
                $(v.invaid).html(message);
                invalid = true;
            } else {
                if(v.input == '#sEmail'){
                    if(!patternEmail.test($(v.input).val())){
                        $(v.input).addClass('is-invalid');
                        $(v.invaid).html('กรุณากรอก อีเมล ให้ถูกต้อง');
                        invalid = true;
                    }
                }
            }
        });

        return invalid;
    }

    const defaultInput = () => {
        $.each([1,2,3,4],(key,val) => {
            $(`input[data-tab="${val}"]`).val('');
            $(`textarea[data-tab="${val}"]`).val('');
            $(`label[data-tab="${val}"]`).show();
            $(`.btn-inpreset[data-tab="${val}"]`).hide();
        });
    }
</script>