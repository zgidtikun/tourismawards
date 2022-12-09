const MapField = {
    step: {
        s1: [
            { input: '[name=step1-appType]', variant: 'appType', 
                api: 'application_type_id', id: '#step1-appType-', require: true },
            { input: '[name=step1-appTypeSub]', variant: 'appTypeSub', 
                api: 'application_type_sub_id', id: '#step1-appTypeSub-', require: true },
            { input: '#step1-desc', variant: 'desc', api: 'highlights', require: true },
            { input: '#step1-link', variant: 'link', api: 'link', require: false },
        ],
        s2: [
            { input: '#step2-siteNameTh', variant: 'siteNameTh', api: 'attraction_name_th', require: true },
            { input: '#step2-siteNameEng', variant: 'siteNameEng', api: 'attraction_name_en', require: false },
            { input: '#step2-address', variant: 'address', api: 'address_no', require: true },
            { input: '#step2-road', variant: 'road', api: 'address_road', require: true },
            { input: '#step2-subDistrict', variant: 'subDistrict', api: 'address_sub_district', require: true },
            { input: '#step2-district', variant: 'district', api: 'address_district', require: true },
            { input: '#step2-province', variant: 'province', api: 'address_province', require: true },
            { input: '#step2-zipcode', variant: 'zipcode', api: 'address_zipcode', require: true },
            { input: '#step2-fb', variant: 'fb', api: 'facebook', require: false },
            { input: '#step2-ig', variant: 'ig', api: 'instagram', require: false },
            { input: '#step2-lid', variant: 'lid', api: 'line_id', require: false },
            { input: '#step2-other', variant: 'other', api: 'other_social', require: false},
            { input: '#step2-gm', variant: 'gm', api: 'google_map', require: false},
        ],
        s3: [
            { input: '#step3-companyName', variant: 'companyName', api: 'company_name', require: true },
            { input: '[name=step3-setAddress]', variant: 'setAddress', 
                api: 'company_setaddr', id: '#step3-setAddress-', require: true },
            { input: '#step3-address', variant: 'address', api: 'company_addr_no', require: true },
            { input: '#step3-road', variant: 'road', api: 'company_addr_road', require: true },
            { input: '#step3-subDistrict', variant: 'subDistrict', api: 'company_addr_sub_district', require: true },
            { input: '#step3-district', variant: 'district', api: 'company_addr_district', require: true },
            { input: '#step3-province', variant: 'province', api: 'company_addr_province', require: true },
            { input: '#step3-zipcode', variant: 'zipcode', api: 'company_addr_zipcode', require: true },
            { input: '#step3-telephone', variant: 'telephone', api: 'mobile', require: true },
            { input: '#step3-email', variant: 'email', api: 'email', require: true },
            { input: '#step3-lid', variant: 'lid', api: 'line_id', require: false },
        ],
        s4: [
            { input: '#step4-name', variant: 'name', api: 'knitter_name', require: true },
            { input: '#step4-position', variant: 'position', api: 'knitter_position', require: true },
            { input: '#step4-telephone', variant: 'telephone', api: 'knitter_tel', require: true },
            { input: '#step4-email', variant: 'email', api: 'knitter_email', require: true },
            { input: '#step4-lid', variant: 'lid', api: 'knitter_line', require: false },
        ],
        s5: [
            { input: '#step5-openYear', variant: 'openYear', type: 'all', api: 'year_open', require: true },
            { input: '#step5-totalYear', variant: 'totalYear', type: 'all', api: 'year_total', require: false },
            { 
                input: '[name=step5-t1-manageBy]', variant: 'manageBy', type: 1, div: '#step5-type1',
                api: 'manage_by', id: '#step5-ty1-manageBy-', require: false 
            },
            { 
                input: '#step5-t2-bussLicense', variant: 'bussLicense', type: 2, div: '#step5-type2', 
                api: 'buss_license', require: true
            },
            { 
                input: '[name=step5-t2-bussCkRoom]', variant: 'bussCkRoom', type: 2, div: '#step5-type2',
                api: 'buss_ckroom', id: '#step5-t2-bussCkRoom-', require: false 
            },
            { 
                input: '[name=step5-t2-buildExt]', variant: 'buildExt', type: 2, div: '#step5-type2',
                api: 'buss_buildExt', id: '#step5-t2-buildExt-', require: false 
            },
            { 
                input: '#step5-t3-bussLicense', variant: 'bussLicenseT3', type: 3, div: '#step5-type3', 
                api: 'buss_license', require: true 
            },
            { 
                input: '[name=step5-t3-bussCites]', variant: 'bussCites', type: 3, div: '#step5-type3',
                api: 'buss_cites', id: '#step5-t3-bussCites-', require: false 
            },
            { 
                input: '[name=step5-t3-nominee]', variant: 'nominee', type: 3, div: '#step5-type3',
                api: 'admin_nominee', id: '#step5-t3-nominee-', require: false 
            },
            { 
                input: '[name=step5-t3-outlander]', variant: 'outlander', type: 3, div: '#step5-type3',
                api: 'has_outlander', id: '#step5-t3-outlander-', require: false 
            },
            { 
                nput: '#step5-t4-bussLicense', variant: 'bussLicenset4', type: 4, div: '#step5-type4', 
                api: 'buss_license', require: true 
            },
        ],
    }                                                                                        
};

const register = {
    id: null,
    status: null,
    expired: false,
    count: [],
    change: false,
    appType: { main: [], sub: [] },
    formData: {
        currentStep: null,
        step1: {}, step2: {}, step3: {}, step4: {}, step5: {},
    },
    passYear: true,
    passYearCount: '',
    init: function(expired){        
        loading('show');
        this.expired = expired == 'Expired' ? true : false;
        this.getAppType().then(function(appType){
            register.appType.main = appType.main;
            register.appType.sub = appType.sub;

            let radio = '',
                count = 0,
                typeId,typeSubId;

            $.each(register.appType.main, function(key,value){
                let rbId = 'id="step1-appType-'+value.id+'"',
                    rbName = 'name="step1-appType"',
                    rbValue = 'value="'+value.id+'"',
                    rbOC = 'onclick="selectType(\'appType\','+value.id+')"';
                    rbCheck = '';
                
                if(key == 0) {
                    rbCheck = 'checked';
                    typeId = value.id;
                }
                
                radio += '<p>';
                radio += '<input type="radio" '+rbOC+' '+rbId+' '+rbName+' '+rbValue+' '+rbCheck+'>';
                radio += (key+1)+'. '+value.name;
                radio += '</p>';
            });            

            $('#group-type').append(radio);
            radio = '<h4>สาขารางวัล<span class="required">*</span></h4>';

            $.each(register.appType.sub, function(key,value){
                if(value.application_type_id == register.appType.main[0].id){
                    let rbId = 'id="step1-appTypeSub-'+value.id+'"',
                        rbName = 'name="step1-appTypeSub"',
                        rbValue = 'value="'+value.id+'"',
                        rbOC = 'onclick="selectType(\'appTypeSub\','+value.id+')"';
                        rbCheck = '';
                    
                    if(count == 0) {         
                        rbCheck = 'checked';          
                        $('#form-define').html(value.descreption);
                        typeSubId = value.id;
                    }
                    radio += '<p>';
                    radio += '<input type="radio" '+rbOC+' '+rbId+' '+rbName+' '+rbValue+' '+rbCheck+'>';
                    radio += value.name;
                    radio += '</p>';
                    count++;
                }
            }); 

            $('#group-type-sub').html(radio);

            register.getApc().then(function(dataApc){
                
                if(dataApc.result == 'success'){
                    if(empty(register.formData.step1.appType)){
                        register.formData.step1.appType = typeId;
                    }

                    if(empty(register.formData.step1.appTypeSub)){
                        register.formData.step1.appTypeSub = typeSubId;
                    }

                    register.change = false;
                    register.setStep(1);
                    loading('hide');

                    if(register.status == 3){
                        $('#link-pre-screen').removeClass('disabled');
                        let setting = {
                            icon: 'success',
                            title: 'ใบสมัครของท่านผ่านการอนุมัติ',
                            text: 'โปรดกรอกแบบประเมินขั้นต้น (Pre-screen) ภายในระยะเวลาที่กำหนด',
                            mode: 'default',
                            button: {
                                confirm: 'ไปตอบแบบประเมินขั้นต้น',
                                cancel: 'ยกเลิก'
                            }
                        }

                        alert.confirm(setting).then(function(response){
                            if(response.status){
                                window.location.href = getBaseUrl()+'/awards/pre-screen';
                            }
                        });
                    }
                }
            });
        });
    },
    getAppType: async function(){
        return new Promise(function(resolve) {            
            api({method: 'get', url: '/inner-api/app/type-all'}).then(function(data){
                resolve(data);
            });
        });
    },
    getApc: async function(){
        return new Promise(function(resolve) {
            
            api({method: 'get', url: '/inner-api/app/detail'}).then(function(response){
                let app = response.data;
                let files = !empty(app.pack_file) ? app.pack_file : [],
                    tmp = [];
                
                register.id = app.id;
                register.status = app.status;
                register.formData.currentStep = app.current_step;
                register.formData.step1.appType = app.application_type_id;
                
                if(!register.expired){
                    switch(Number(register.status)){
                        case 1: 
                            $('#formstep-sts').addClass('date');
                            $('.form-main-title').removeClass('hide');
                            $('.attach-file').remove();
                        break;
                        case 2: 
                            $('#formstep-sts').addClass('check');
                            $('#formstep-sts').html('รอตรวจสอบ');
                            $('#formstatus-info').removeClass('hide');
                            $('.regis-form-data input, textarea').prop('disabled',true);
                            $('.btn-action, .selecter-file').remove();
                        break;
                        case 3: 
                            $('#formstep-sts').addClass('pass');
                            $('#formstep-sts').html('ผ่านการตรวจสอบ');
                            $('#formstatus-pass').removeClass('hide');
                            $('.regis-form-data input, textarea').prop('disabled',true);
                            $('.btn-action, .selecter-file').remove();
                        break;
                        case 4: 
                            $('#comoment').html(app.judge_comment);
                            $('#formstep-sts').addClass('notpass');
                            let sts_html = $('#formstep-sts').html();
                            $('#formstep-sts').html('ตอบกลับ'+sts_html);
                            $('.form-main-title, .formstatus-comoment').removeClass('hide');
                            $('#formstatus-uncomplete').removeClass('hide');
                            $('.attach-file').remove();
                        break;
                        case 0: 
                            $('#formstep-sts').addClass('notpass');
                            $('#formstep-sts').html('ไม่ผ่านการอนุมัติ');
                            $('.form-main-title').removeClass('hide');
                            $('#formstatus-nopass').removeClass('hide');
                            $('.regis-form-data input, textarea').prop('disabled',true);
                            $('.attach-file').remove();
                        break;
                    }
                } else {
                    $('#formstep-sts').addClass('notpass');
                    $('#formstep-sts').html('หมดเวลาการส่งใบสมัครแล้ว');
                    $('.btn-action, .btn-file, .bfd-dropfield, .attach-file').remove();
                    $('.regis-form-data input, textarea').prop('disabled',true);
                }

                $('#formstep-sts').removeClass('hide');

                $.each([1,2,3,4,5], function(key,index){
                    let str = 'step'+index;
                    let mapFData = register.getMapField('step',index);
                        tmp[str] = [];
                        
                    $.each(mapFData,function(keym,vulm){
                        tmp[str][vulm.variant] = '';

                        $.each(app,function(keya,vula){
                            if(vulm.api == keya){
                                if(!empty(vula)){
                                    tmp[str][vulm.variant] = vula;
                                    
                                    if($(vulm.input).length > 0){
                                        let = attrType = $(vulm.input).attr('type');
                                        
                                        if($.inArray(attrType,['radio','checkbox']) === -1){
                                            $(vulm.input).val(vula);
                                        } else {                                            
                                            $(vulm.id+vula).prop('checked',true);   
                                        }
                                    }
                                }
                            }
                        });
                    });
                });
                
                Object.assign(register.formData.step1, tmp['step1']);
                Object.assign(register.formData.step2, tmp['step2']);
                Object.assign(register.formData.step3, tmp['step3']);
                Object.assign(register.formData.step4, tmp['step4']);
                Object.assign(register.formData.step5, tmp['step5']);
                
                $.each(referance, function(key,ref){
                    if(ref.app == 'awards/application'){
                        let pointer = ref.pointer;
                        register.formData[pointer[0]][pointer[1]] = [];
                        register.count[pointer[1]] = 0;
                    }
                });
                
                if(files.length > 0){
                    $.each(files,function(key,file){
                        let map = referance.find(el => el.position == file.file_position);
                        let pointer = map.pointer;
                        register.formData[pointer[0]][pointer[1]].push(file);
                        register.count[pointer[1]]++;
                    });

                    $.each(referance, function(key,ref){
                        if(ref.app == 'awards/application'){
                            let pointer = ref.pointer;
                            if(register.count[pointer[1]] > 0){                            
                                showFiles.tycoon(
                                    ref.input,register.formData[pointer[0]][pointer[1]]
                                );
                            }
                        }
                    });
                }
                
                resolve(response);
            });
        });  
    },
    setAppTypeSub: function(id){        
        register.formData.step1.appType = id;  
        
        let count = 0;
        let radio = '<h4>สาขารางวัล<span class="required">*</span></h4>';

        $.each(register.appType.sub, function(key,value){
            if(value.application_type_id == id){
                let rbId = 'id="step1-appTypeSub-'+value.id+'"',
                    rbName = 'name="step1-appTypeSub"',
                    rbValue = 'value="'+value.id+'"',
                    rbOC = 'onclick="selectType(\'appTypeSub\','+value.id+')"',
                    rbCheck = '';
                
                if(count == 0) {
                    rbCheck = 'checked';
                    $('#form-define').html(value.descreption);
                    register.formData.step1.appTypeSub = value.id;
                }

                radio += '<p>';
                radio += '<input type="radio" '+rbOC+' '+rbId+' '+rbName+' '+rbValue+' '+rbCheck+'>';
                radio += value.name;
                radio += '</p>';  
                count++;               
            }
        });

        $('#group-type-sub').html(radio);
    },
    setFormDefine: function(id){
        let sub = this.appType.sub.find(el => el.id == id);
        $('#form-define').html(sub.descreption);
    },
    setStep: function(step){
        let tabs = [
            {step: 1, id: '#tab-s1', form: '#form-step-1'},            
            {step: 2, id: '#tab-s2', form: '#form-step-2'},
            {step: 3, id: '#tab-s3', form: '#form-step-3'},
            {step: 4, id: '#tab-s4', form: '#form-step-4'},
            {step: 5, id: '#tab-s5', form: '#form-step-5'}
        ];

        if(register.change){
            this.saveDraft(this.formData.currentStep,'draft');
            register.change = false;
        }

        this.formData.currentStep = step;

        if(step == 5){
            ;[1,2,3,4].forEach(index => {
                if(!$('#step5-type'+index).hasClass('hide'))
                    $('#step5-type'+index).addClass('hide');

                if(index == register.formData.step1.appType)
                    $('#step5-type'+index).removeClass('hide');
            });

            $('.btn-regis').removeClass('disabled');
            $('.btn-regis').addClass('active');
        } else {
            $('.btn-regis').addClass('disabled');
            $('.btn-regis').removeClass('active');
        }
        
        $.each(tabs,function(key,tab){
            let checkRequire = true;

            if(tab.step == step){
                if($(tab.id).hasClass('complete')){
                    $(tab.id).removeClass('complete');
                }

                $(tab.id).addClass('active');
                $(tab.form).removeClass('hide');
            } else {
                $(tab.id).removeClass('active');
                $(tab.form).addClass('hide');
            }

            let maps = register.getMapField('step',tab.step);

            $.each(maps,function(key,map){                
                if(map.require){
                    if(empty(register.formData['step'+tab.step][map.variant])){
                        checkRequire = false;
                    }
                }
            });
            
            if(!checkRequire){
                if($(tab.id).hasClass('complete')){
                    $(tab.id).removeClass('complete');
                }
            } else {
                if(!$(tab.id).hasClass('complete')){
                    $(tab.id).addClass('complete');
                }
            }
        });
    },
    saveDraft: function(step,mode){
        let formData = new FormData(),
            mapFData = this.getMapField('step',step),
            dataStep = this.formData['step'+step],
            setting = {
                method: 'action',
                url: '/inner-api/app/draft',
                data: []
            };
            
        formData.append('id',this.id);
        formData.append('step',step);

        $.each(mapFData,function(key,map){
            formData.append(map.api,dataStep[map.variant]);
        });

        setting.data = formData;

        api(setting).then(function(response){
            let draft = response;

            if(draft.result == 'error_login'){
                alert.login();
            } else {
                if(mode == 'draft'){
                    alert.toast({icon: draft.result, title: draft.message});
                } else {
                    let title,  message;

                    if(draft.result == 'success'){
                        title = draft.result;
                        message = 'ท่านสามารถบันทึกข้อมูลได้ตลอดเวลา ด้วยปุ่ม "บันทึก"<br>';
                        message += 'และกดปุ่ม "ส่งใบสมัคร" เมื่อพร้อม และเมื่อส่งใบสมัครแล้ว';
                        message += 'ท่านจะไม่สามารถแก้ไขข้อมูลได้อีก ดังนั้น กรุณาตรวจสอบ';
                        message += 'ความถูกต้องของข้อมูลก่อนส่งใบสมัคร';
                    } else {
                        title = 'ไม่สามารถบันทึกข้อมูลได้';
                        message = draft.message;
                    }

                    alert.show(
                        draft.result,
                        draft.message
                    );
                }
            }
        });
    },
    getMapField: function(by,st){
        let map = [];

        if(by == 'step'){            
            let temp = MapField.step;
            if(st != 'finish'){ 
                if(st != 5){
                    map = temp['s'+st]; 
                } else {
                    temp = temp['s5'];
                    let appType = register.formData.step1.appType;

                    $.each(temp, function(key,val){
                        if(appType == val.type || val.type == 'all'){
                            map.push(val);
                        }
                    });
                }
            } else {
                map.concat(
                    temp.s1.concat(
                        temp.s2.concat(
                            temp.s3.concat(
                                temp.s4.concat(temp.s5)))));
            }
        }

        return map;
    },
    validate: function(){
        let bool_input = true;        
        
        ;[1,2,3,4,5].forEach(index => {
            let mapFData = this.getMapField('step',index),
                formData = register.formData['step'+index];

            $.each(mapFData,function(key,map){
                if(map.require){    
                    if(empty(formData[map.variant])){
                        $(map.input).addClass('is-invalid');
                        bool_input = false;
                    } else {
                        $(map.input).removeClass('is-invalid');
                    }
                }
            });
        });

        return bool_input;

    },
    saveApp: function(){
        if(register.validate()){

            if(!register.passYear){
                let title_a = 'เปิดรับสมัครสําหรับผู้ประกอบการ<br>ที่จดทะเบียนมาแล้ว '+register.passYearCount+' ปีขึ้นไป';
                alert.show('error',title_a,'');
                return;
            }

            if(!checkRequireFiles('awards/application')){                
                let title_c = 'ท่านยังแนบเอสารไม่ครบถ้วน';
                let txt_c = 'ท่านยังแนบเอสารไม่ครบถ้วน กรุณาตรวจสอบการแนบไฟล์ของท่าน'
                alert.show('error',title_c,txt_c);
                return;
            }

            let setting = {
                icon: 'info',
                title: 'ยืนยันการส่งใบสมัคร',
                text: 'โปรดตรวจสอบข้อมูลของท่านให้เรียบร้อย<br>ก่อนกดปุ่มส่งใบสมัคร',
                mode: 'confirm-main',
                button: {
                    confirm: 'ส่งใบสมัคร',
                    cancel: 'ยกเลิก'
                }
            };

            alert.confirm(setting).then(function(response){
                if(response.status){
                    loading('show');

                    let formData = new FormData();
                    formData.append('id',register.id);
                    formData.append('step','finish');
                    formData.append('type',register.formData.step1.appType);                    

                    ;[1,2,3,4,5].forEach(index => {
                        let mapFData = register.getMapField('step',index),
                            form = register.formData['step'+index];

                        $.each(mapFData,function(mapk,mapv){
                            let df = !empty(form[mapv.variant]) ? form[mapv.variant] : '';
                            formData.append(mapv.api,df);
                        });
                    });            

                    api({method: 'action', url: '/inner-api/app/finish', data: formData})
                    .then(function(res){
                        loading('hide');
                        let save = res;

                        if(save.result == 'error_login'){
                            alert.login();
                        } else {
                            if(save.result == 'success'){
                                var title = 'ส่งใบสมัครเรียบร้อยแล้ว',
                                    message = 'ระบบได้รับใบสมัครของท่านเรียบร้อยแล้ว<br>เจ้าหน้าที่จะใช้เวลาในการตรวจสอบข้อมูลภายใน 7 วัน';
                            } else {
                                var title = 'ไม่สามารถบันทึกข้อมูลได้',
                                    message = save.message;
                            }

                            alert.show(save.result,title,message).then(function(res){
                                if(save.result == 'success'){ window.location.reload(); }
                            });
                        }
                    });
                }
            });
        } else {
            alert.show('error','ดำเนินการไม่สำเร็จ','โปรดตรวจสอบแบบฟอร์มใบสมัคร ให้ครบถ้วน ก่อนส่งแบบฟอร์มใบสมัคร');
        }
    },
}

// Application Register
// Step 1 
const selectType = (type,value) => {
    if(type == 'appType'){
        register.formData.step1.appType = value; 
        register.setAppTypeSub(value);
    } else {
        register.formData.step1.appTypeSub = value; 
        register.setFormDefine(value);
    }
    register.change = true;
};

$('#step1-desc').on('keyup', function(){ 
    register.change = true;
    register.formData.step1.desc = $(this).val(); 
    $('#step1-desc-cc').html(1000 - register.formData.step1.desc.length);
});

$('#step1-link').on('keyup', function(){ 
    register.change = true;
    register.formData.step1.link = $(this).val(); 
});

// Step 2
$('#step2-siteNameTh').on('keyup', function(){ register.formData.step2.siteNameTh = $(this).val(); register.change = true;});
$('#step2-siteNameEng').on('keyup', function(){ register.formData.step2.siteNameEng = $(this).val(); register.change = true;});
$('#step2-address').on('keyup', function(){ register.formData.step2.address = $(this).val(); register.change = true;});
$('#step2-road').on('keyup', function(){ register.formData.step2.road = $(this).val(); register.change = true;});
$('#step2-province').on('keyup change', function(){ register.formData.step2.province = $(this).val(); register.change = true;});
$('#step2-district').on('keyup change', function(){ register.formData.step2.district = $(this).val(); register.change = true;});
$('#step2-subDistrict').on('keyup change', function(){ register.formData.step2.subDistrict = $(this).val(); register.change = true;});
$('#step2-zipcode').on('keyup change', function(){ register.formData.step2.zipcode = $(this).val(); register.change = true;});
$('#step2-fb').on('keyup', function(){ register.formData.step2.fb = $(this).val(); register.change = true;});
$('#step2-ig').on('keyup', function(){ register.formData.step2.ig = $(this).val(); register.change = true;});
$('#step2-lid').on('keyup', function(){ register.formData.step2.lid = $(this).val(); register.change = true;});
$('#step2-other').on('keyup', function(){ register.formData.step2.other = $(this).val(); register.change = true;});
$('#step2-gm').on('keyup', function(){ register.formData.step2.gm = $(this).val(); register.change = true;});

// Step 3
$('#step3-companyName').on('keyup', function(){ register.formData.step3.companyName = $(this).val(); register.change = true;});

$('[name=step3-setAddress]').on('click', function(){
    let current = $(this).val() == 1 ? true : false;    
    register.formData.step3.setAddress = $(this).val();

    register.change = true;
    register.formData.step3.address = current ? register.formData.step2.address : '';
    register.formData.step3.road = current ? register.formData.step2.road : '';
    register.formData.step3.province = current ? register.formData.step2.province : '';
    register.formData.step3.district = current ? register.formData.step2.district : '';
    register.formData.step3.subDistrict = current ? register.formData.step2.subDistrict : '';
    register.formData.step3.zipcode = current ? register.formData.step2.zipcode : '';

    $('#step3-address').val(register.formData.step3.address);
    $('#step3-road').val(register.formData.step3.road);
    $('#step3-province').val(register.formData.step3.province);
    $('#step3-district').val(register.formData.step3.district);
    $('#step3-subDistrict').val(register.formData.step3.subDistrict);
    $('#step3-zipcode').val(register.formData.step3.zipcode);
});

$('#step3-address').on('keyup', function(){ register.formData.step3.address = $(this).val(); register.change = true;});
$('#step3-road').on('keyup', function(){ register.formData.step3.road = $(this).val(); register.change = true;});
$('#step3-province').on('keyup, change', function(){ register.formData.step3.province = $(this).val(); register.change = true;});
$('#step3-district').on('keyup, change', function(){ register.formData.step3.district = $(this).val(); register.change = true;});
$('#step3-subDistrict').on('keyup, change', function(){ register.formData.step3.subDistrict = $(this).val(); register.change = true;});
$('#step3-zipcode').on('keyup, change', function(){ register.formData.step3.zipcode = $(this).val(); register.change = true;});
$('#step3-telephone').on('keyup', function(){ register.formData.step3.telephone = $(this).val(); register.change = true;});
$('#step3-email').on('keyup', function(){ register.formData.step3.email = $(this).val(); register.change = true;});
$('#step3-lid').on('keyup', function(){ register.formData.step3.lid = $(this).val(); register.change = true;});

// Step 4
$('#step4-name').on('keyup', function(){ register.formData.step4.name = $(this).val(); register.change = true;});
$('#step4-position').on('keyup', function(){ register.formData.step4.position = $(this).val(); register.change = true;});
$('#step4-telephone').on('keyup', function(){ register.formData.step4.telephone = $(this).val(); register.change = true;});
$('#step4-email').on('keyup', function(){ register.formData.step4.email = $(this).val(); register.change = true;});
$('#step4-lid').on('keyup', function(){ register.formData.step4.lid = $(this).val(); register.change = true;});

// Step 5
$('#step5-openYear').on('change', function(){    
    if(!empty($(this).val())){
        let date = new Date(),
            openDate = $(this).val().split('/');

        let from = openDate[1]+'/'+openDate[2]+'/'+(Number(openDate[0]) - 543)
            to = String(date.getMonth()+1).padStart(2, '0')+'/'+String(date.getDate()).padStart(2, '0')+'/'+date.getFullYear();

        let totalYear = calcDate(from,to);
        
        register.change = true;
        register.passYear = true;
        register.formData.step5.openYear = $(this).val();
        register.formData.step5.totalYear = totalYear.result;
        $('#step5-totalYear').val(totalYear.result);

        let app = register.formData.step1.appType;
        let confYear = register.appType.main.find(el => el.id = app);
        register.passYearCount = confYear.fixe_year_open;
        
        if(Number(totalYear.total_year) < Number(confYear.fixe_year_open)){
            register.passYear = false;
            let title = 'เปิดรับสมัครสําหรับผู้ประกอบการ<br>ที่จดทะเบียนมาแล้ว '+confYear.fixe_year_open+' ปีขึ้นไป';
            alert.show('error',title,'');
        }
    } else { $('#step5-totalYear').val(''); }
});

$('[name=step5-t1-manageBy]').on('click', function(){ 
    register.formData.step5.manageBy = $(this).val(); 
    register.change = true;
    let title;

    switch($(this).val()){
        case '1': title = 'สำเนาหนังสือการจดทะเบียนวิสาหกิจชุมชน'; break;
        case '2': title = 'สำเนาใบอนุญาตประกอบธุรกิจที่ถูกต้องตามกฎหมาย'; break;
        case '3': title = 'ใบรับรองมาตรฐาน หรือประกาศนียบัตรจากการท่องเที่ยวแห่ง'; break;
    }
    
    $('#step5-file1-title').html(title+'<span class="required">*</span>');
});

$('#step5-t2-bussLicense').on('keyup', function(){ register.formData.step5.bussLicense = $(this).val(); register.change = true;});
$('[name=step5-t2-bussCkRoom]').on('click', function(){ register.formData.step5.bussCkRoom = $(this).val(); register.change = true;});
$('#step5-t3-bussLicense').on('keyup', function(){ register.formData.step5.bussLicenseT3 = $(this).val(); register.change = true;});
$('[name=step5-t3-bussCites]').on('click', function(){ 
    register.formData.step5.bussCites = $(this).val(); 
    register.change = true;
});
$('[name=step5-t3-nominee]').on('click', function(){ register.formData.step5.nominee = $(this).val(); register.change = true;});
$('[name=step5-t3-outlander]').on('click', function(){ register.formData.step5.outlander = $(this).val(); register.change = true;});

