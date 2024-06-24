<?= $this->extend('layout') ?>
<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>

<?= $this->section('recapcha') ?>
<?php if (!empty($_recapcha) && $_recapcha) : ?>
<?= $this->include('_recapcha'); ?>
<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
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
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?=base_url('assets/js/frontend/other.js')?>?v=<?= config(\Config\App::class)->script_v ?>"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const headerHeight = document.querySelector('#header-inner').offsetHeight;
        const mainsite = document.querySelector('.mainsite');

        mainsite.classList.add('contact');
        mainsite.style.display = 'block';
        mainsite.style.marginTop = `${headerHeight}px`;

        document.querySelectorAll('.btn-inpreset').forEach( e => {
            e.style.display = 'none';
        });
    });

    document.querySelectorAll('input, textarea').forEach( ele => {
        ele.addEventListener('input', function() {
            const tab = this.dataset.tab;
            const length = this.value.length;
            const label = document.querySelector(`label[data-tab="${tab}"]`);
            const inpreset = document.querySelector(`.btn-inpreset[data-tab="${tab}"]`);

            this.classList.remove('is-invalid');
            label.style.display = length > 0 ? 'none' : 'block';
            inpreset.style.display = length > 0 ? 'flex' : 'none';
        });
    });

    document.querySelectorAll('.btn-inpreset').forEach( ele => {
        ele.addEventListener('click', function(e) {
            const tab = this.dataset.tab;
            const label = document.querySelector(`label[data-tab="${tab}"]`);
            const input = document.querySelector(`.inputfield input[data-tab="${tab}"]`);
            const textarea = document.querySelector(`.inputfield textarea[data-tab="${tab}"]`);
            
            this.style.display = 'none';
            label.style.display = 'block';

            if(input !== null){
                input.value = '';
                input.classList.remove('is-invalid');
            }

            if(textarea !== null){
                textarea.value = '';
                textarea.classList.remove('is-invalid');
            }
        });
    });

    const send = async() => {
        if(validate()) return;

        let recapcha_token = '';

        <?php if (!empty($_recapcha) && $_recapcha) : ?>
        const recap = await recapchaToken();
        recapcha_token = recap.rccToken;
        <?php endif; ?>

        const setting = {
            method: 'post',
            url: '/contact-us/send',
            data: {
                name: document.querySelector('#sName').value,
                email: document.querySelector('#sEmail').value,
                subject: document.querySelector('#sSubject').value,
                message: document.querySelector('#sMessage').value,
                recapcha_token: recapcha_token
            }
        }

        const callback = await api(setting);
        let title, message;

        if(callback.result == 'success'){            
            title = 'ได้ทำการส่งอีเมลเรียบร้อยแล้ว';            
            defaultInput();
        } else {
            title = 'ไม่สามารถส่งอีเมลได้';
            if(!empty(callback.message)) message = callback.message;
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
        const mapField = [
            { label: '#lName', input: '#sName', invaid: '#ivName' },
            { label: '#lEmail', input: '#sEmail', invaid: '#ivEmail' },
            { label: '#lSubject', input: '#sSubject', invaid: '#ivSubject' },
            { label: '#lMessage', input: '#sMessage', invaid: '#ivMessage' }
        ];

        const patternEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        let invalid = false;

        for(index in mapField){
            const field = mapField[index];
            const input = document.querySelector(field.input);
            const invalid = document.querySelector(field.invalid);

            if(empty(input.value)){
                const label = document.querySelector(field.label).innerHTML;
                input.classList.add('is-invalid');
                invalid.innerHTML = `กรุณากรอก ${label}`;
                invalid = true;
            }
            else if(field.input =='#sEmail' && !patternEmail.test(input.value)){
                input.classList.add('is-invalid');
                invalid.innerHTML = `กรุณากรอก อีเมล ให้ถูกต้อง`;
                invalid = true;
            }
            else {
                input.classList.remove('is-invalid');
                invalid.innerHTML = ``;
            }
        }

        return invalid;
    }

    const defaultInput = () => {
        ;[1, 2, 3, 4].forEach(tab => {
            document.querySelector(`label[data-tab="${tab}"]`).style.display = 'block';
            document.querySelector(`.btn-inpreset[data-tab="${tab}"]`).style.display = 'none';

            if(document.querySelector(`input[data-tab="${tab}"]`) !== null){
                document.querySelector(`input[data-tab="${tab}"]`).value = '';
                document.querySelector(`input[data-tab="${tab}"]`).classList.remove('is-invalid');
            }

            if(document.querySelector(`textarea[data-tab="${tab}"]`) !== null){
                document.querySelector(`textarea[data-tab="${tab}"]`).value = '';
                document.querySelector(`textarea[data-tab="${tab}"]`).classList.remove('is-invalid');
            }
        });
    }
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="banner-box">
    <div class="txt-banner"><h2>ติดต่อเรา</h2></div>
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
                                    <b><a href="tel:022505500">0 2250 5500</a></b>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="contact-col">
                                <div class="contact-img">
                                    <picture>
                                        <source srcset="<?=base_url('assets/images/line.svg')?>">
                                        <img src="<?=base_url('assets/images/line.png')?>">
                                    </picture>
                                </div>
                                <div class="contact-subject">
                                    Line Official Account 
                                </div>
                                <div class="contact-txt">
                                    <a href="https://lin.ee/KhaHCpd" target="_blank">@tourismawards</a>
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
                </div>
            </div>
        </div>

    </div>

</div>
<?= $this->endSection() ?>