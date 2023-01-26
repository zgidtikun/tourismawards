const MapField = {
    step: {
        s1: [
            { input: '[name=step1-appType]', variant: 'appType', 
                api: 'application_type_id', id: '#step1-appType-', require: true },
            { input: '[name=step1-appTypeSub]', variant: 'appTypeSub', 
                api: 'application_type_sub_id', id: '#step1-appTypeSub-', require: true },
            { input: '#step1-desc', variant: 'desc', api: 'highlights', require: true },
            { input: '#step1-link', variant: 'link', api: 'link', require: false },
            { input: '[name=step1-lowcarbon]', variant: 'lowcarbon', 
                api: 'require_lowcarbon', id: '#step1-lowcarbon-', require: false },
        ],
        s2: [
            { input: '#step2-siteNameTh', variant: 'siteNameTh', api: 'attraction_name_th', require: true },
            { input: '#step2-siteNameEng', variant: 'siteNameEng', api: 'attraction_name_en', require: false },
            { input: '#step2-address', variant: 'address', api: 'address_no', require: true },
            { input: '#step2-road', variant: 'road', api: 'address_road', require: false },
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
                api: 'company_setaddr', id: '#step3-setAddress-', require: false },
            { input: '#step3-address', variant: 'address', api: 'company_addr_no', require: false },
            { input: '#step3-road', variant: 'road', api: 'company_addr_road', require: false },
            { input: '#step3-subDistrict', variant: 'subDistrict', api: 'company_addr_sub_district', require: false },
            { input: '#step3-district', variant: 'district', api: 'company_addr_district', require: false },
            { input: '#step3-province', variant: 'province', api: 'company_addr_province', require: false },
            { input: '#step3-zipcode', variant: 'zipcode', api: 'company_addr_zipcode', require: false },
            { input: '#step3-telephone', variant: 'telephone', api: 'mobile', require: false },
            { input: '#step3-email', variant: 'email', api: 'email', require: false },
            { input: '#step3-lid', variant: 'lid', api: 'line_id', require: false },
        ],
        s4: [
            { input: '#step4-name', variant: 'name', api: 'knitter_name', require: true },
            { input: '#step4-position', variant: 'position', api: 'knitter_position', require: false },
            { input: '#step4-telephone', variant: 'telephone', api: 'knitter_tel', require: true },
            { input: '#step4-email', variant: 'email', api: 'knitter_email', require: true },
            { input: '#step4-lid', variant: 'lid', api: 'knitter_line', require: false },
        ],
        s5: [
            { input: '#step5-openYear', variant: 'openYear', type: 'all', api: 'year_open', require: true },
            { input: '#step5-totalYear', variant: 'totalYear', type: 'all', api: 'year_total', require: false },
            { 
                input: '[name=step5-t1-manageBy]', variant: 'manageBy', type: 1, div: '#step5-type1',
                api: 'manage_by', id: '#step5-t1-manageBy-', require: false 
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
                input: '[name=step5-t3-hasEffluent]', variant: 'hasEffluent', type: 3, div: '#step5-type3',
                api: 'has_effluent', id: '#step5-t3-hasEffluent-', require: false 
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
                input: '[name=step5-t3-outlander]', variant: 'inpOutlander', type: 3, div: '#step5-type3',
                api: 'has_outlander', id: '#step5-t3-outlander-', require: false 
            },
            {
                input: '#step5-t4-bussLicense', variant: 'bussLicenseT4', type: 4, div: '#step5-type4', 
                api: 'buss_license', require: true 
            },
        ],
    }                                                                                        
};

const register = {
    id: null,
    status: null,
    expired: false,
    requestExpire: false,
    count: [],
    change: false,
    appType: { main: [], sub: [] },
    formData: {
        currentStep: null,
        step1: {}, step2: {}, step3: {}, step4: {}, step5: {},
    },
    first: null,
    currentDate: null,
    passYear: true,
    passYearCount: '',
    complete: false,
    init:async function(expired){        
        await loading('show');
        this.expired = expired == 'Expired' ? true : false;
        this.currentDate = getCurrentDate();
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
            radio = '<h4>สาขารางวัล <span class="required">*</span></h4>';

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
                    register.checkComplete();
                    loading('hide');

                    if(register.status == 3){
                        $('#link-pre-screen').removeClass('disabled');
                        $('#link-pre-screen').addClass('inactive');
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
                
                register.first = true;
                register.id = app.id;
                register.status = app.status;
                register.formData.currentStep = app.current_step;
                register.formData.step1.appType = app.application_type_id;
                
                if(register.expired && $.inArray(Number(register.status),[1,0]) !== -1){
                    $('#formstep-sts').addClass('notpass');
                    $('#formstatus-uncomplete').removeClass('hide');

                    if(Number(register.status) == 4){
                        $('#formstep-sts').html('หมดเวลาตอบกลับการขอข้อมูลเพิ่มเติม');
                        $('#formstatus-uncomplete-title').html('หมดเวลาตอบกลับการขอข้อมูลเพิ่มเติมใบสมัครแล้ว');
                        $('#formstatus-uncomplete-message').hide();
                    } else {
                        $('#formstep-sts').html('หมดเวลาการส่งใบสมัครแล้ว');
                        $('#formstatus-uncomplete-title').html('หมดเวลาการส่งใบสมัครแล้ว');
                        $('#formstatus-uncomplete-message').hide();
                    }
                                        
                    $('.btn-action.gold, .selecter-file').remove();
                    $('.regis-form-data input, textarea, #step5-openYear-btn').prop('disabled',true);
                    $('.btn-confirm-submit').hide();
                } else {
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
                            $('.regis-form-data input, textarea, #step5-openYear-btn').prop('disabled',true);
                            $('.btn-action.gold, .selecter-file').remove();
                            $('.btn-confirm-submit').hide();
                            register.complete = true;
                        break;
                        case 3: 
                            const prescreen = response.pre_status;
                            const result = response.result_status;
                            let pre_css, pre_str, result_css, result_str;
                            
                            if($.inArray(prescreen,['draft','reject']) !== -1){
                                pre_css = 'check';
                                pre_str = 'เข้าทำแบบประเมินขั้นต้น';
                            } else {
                                pre_css = 'pass';
                                pre_str = 'ส่งแบบประเมินเรียบร้อยแล้ว';
                            }

                            if(result){
                                result_css = 'check';
                                result_str = 'ตรวจสอบผลการประเมิน';                                
                                $('#link-pre-result').removeClass('disabled');                    
                                $('#link-pre-result').addClass('inactive');
                            }
                            
                            $('#formstep-sts').addClass('pass');
                            $('#formstep-sts').html('ผ่านการตรวจสอบ');
                            $('#formstatus-pass').removeClass('hide');
                            $('#formstep-pre').addClass(pre_css);
                            $('#formstep-pre').html(pre_str);
                            $('#formstep-result').addClass(result_css);
                            $('#formstep-result').html(result_str);
                            $('.regis-form-data input, textarea, #step5-openYear-btn').prop('disabled',true);
                            $('.btn-action.gold, .selecter-file').remove();
                            $('.btn-confirm-submit').hide();
                            register.complete = true;
                        break;
                        case 4: 
                            if(!app.request_expired){
                                $('#comoment').html(app.judge_comment);
                                $('#formstep-sts').addClass('notpass');
                                let sts_html = $('#formstep-sts').html();
                                $('#formstep-sts').html('ตอบกลับ ภายในวันที่ '+app.request_time_str);
                                $('.form-main-title, .formstatus-comoment').removeClass('hide');
                                $('#formstatus-uncomplete').removeClass('hide');
                                $('.attach-file').remove();
                            } else {
                                $('#formstep-sts').addClass('notpass');
                                $('#formstatus-uncomplete').removeClass('hide');
                                $('#formstep-sts').html('หมดเวลาตอบกลับการขอข้อมูลเพิ่มเติม');
                                $('#formstatus-uncomplete-title').html('หมดเวลาตอบกลับการขอข้อมูลเพิ่มเติมใบสมัครแล้ว');
                                $('#formstatus-uncomplete-message').hide();
                                $('.btn-action.gold, .selecter-file').remove();
                                $('.regis-form-data input, textarea, #step5-openYear-btn').prop('disabled',true);
                                $('.btn-confirm-submit').hide();
                                register.expired = true;
                                register.complete = true;
                            }
                        break;
                        case 0: 
                            $('#formstep-sts').addClass('notpass');
                            $('#formstep-sts').html('ไม่ผ่านการอนุมัติ');
                            $('#formstatus-nopass').removeClass('hide');
                            $('.regis-form-data input, textarea, #step5-openYear-btn').prop('disabled',true);
                            $('.btn-action.gold, .selecter-file').remove();
                            $('.btn-confirm-submit').hide();
                            register.complete = true;
                        break;
                    }
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
                                            if(vulm.variant == 'openYear'){
                                                $(vulm.input).val(vula); 
                                                $('#step5-hiddenDate').val(convertYearThToEn(vula));
                                            } else {
                                                $(vulm.input).val(vula);  
                                            }
                                        } else { 
                                            if(vulm.api != 'application_type_sub_id'){                                            
                                                $(vulm.id+vula).prop('checked',true); 
                                            }  
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
                
                register.setAppTypeSub(register.formData.step1.appType);

                if(Number(register.formData.step3.setAddress) == 1){
                    register.formData.step3.address = register.formData.step2.address;
                    register.formData.step3.road = register.formData.step2.road;
                    register.formData.step3.province = register.formData.step2.province;
                    register.formData.step3.district = register.formData.step2.district;
                    register.formData.step3.subDistrict = register.formData.step2.subDistrict;
                    register.formData.step3.zipcode = register.formData.step2.zipcode;
                    $('#step3-address').val(register.formData.step2.address);
                    $('#step3-road').val(register.formData.step2.road);
                    $('#step3-subDistrict').val(register.formData.step2.subDistrict);
                    $('#step3-district').val(register.formData.step2.district);
                    $('#step3-province').val(register.formData.step2.province);
                    $('#step3-zipcode').val(register.formData.step2.zipcode);
                }

                if(Number(register.formData.step1.appType) == 1){
                    if(Number(register.formData.step5.manageBy) == 1){
                        $('#div-step5-businessCert').hide();
                    } else {
                        const title = $('#step5-file1-title');

                        if(Number(register.formData.step5.manageBy) == 2){
                            title.html('สำเนาหนังสือการจดทะเบียนวิสาหกิจชุมชน <span class="required">*</span>');
                        } else {
                            title.html('สำเนาใบอนุญาตประกอบธุรกิจที่ถูกต้องตามกฎหมาย <span class="required">*</span>');  
                        }

                        $('#div-step5-businessCert').show();
                    }
                }
                
                $.each(referance, function(key,ref){
                    if(ref.app == 'awards/application'){
                        let pointer = ref.pointer;
                        register.formData[pointer[0]][pointer[1]] = [];
                        register.count[pointer[1]] = 0;
                    }
                });
                
                if(files.length > 0){
                    $.each(files,function(key,file){
                        let ref = referance.find(el => el.position == file.file_position);
                        let pointer = ref.pointer;
                        register.formData[pointer[0]][pointer[1]].push(file);
                        register.count[pointer[1]]++;
                    });

                    $.each(referance, function(key,ref){
                        if(ref.app == 'awards/application'){
                            let pointer = ref.pointer;
                            if(register.formData[pointer[0]][pointer[1]].length > 0){                            
                                showFiles.tycoon(
                                    ref.input,register.formData[pointer[0]][pointer[1]]
                                );
                            } else {
                                if($.inArray(Number(register.status),[2,3,0]) === -1 && !register.expired) {
                                    clearBtnRemoveFile('by-input',ref.app,ref.input);
                                } else {                                    
                                    if(ref.path == 'images'){
                                        $(ref.ablum).removeClass('ablumbox');                                        
                                        $(ref.ablum).addClass('text-center');
                                        $(ref.ablum).html('ไม่มีรูปแนบ');
                                    } else {
                                        const button = $(`button[onclick="downloadFile('${ref.input}')"]`);
                                        button.prop('disabled',true);
                                        button.removeClass('btn-primary');
                                        button.addClass('btn-transparent');
                                        button.css('color','#000');
                                        button.css('opacity','1');
                                        button.html('ไม่มีไฟล์แนบ');
                                    }
                                }
                            }
                        }
                    });
                } else {
                    if($.inArray(Number(register.status),[2,3,0]) === -1 && !register.expired) {
                        clearBtnRemoveFile('all','awards/application','');
                    } else {
                        $.each(referance, function(key,ref){                                  
                            if(ref.path == 'images'){
                                $(ref.ablum).removeClass('ablumbox');                                        
                                $(ref.ablum).addClass('text-center');
                                $(ref.ablum).html('ไม่มีรูปแนบ');
                            } else {
                                const button = $(`button[onclick="downloadFile('${ref.input}')"]`);
                                button.prop('disabled',true);
                                button.removeClass('btn-primary');
                                button.addClass('btn-transparent');
                                button.css('color','#000');
                                button.css('opacity','1');
                                button.html('ไม่มีไฟล์แนบ');
                            }
                        });
                    }
                }
                
                resolve(response);
            });
        });  
    },
    setAppTypeSub: function(id){        
        register.formData.step1.appType = id;  
        
        let count = 0;
        let radio = '<h4>สาขารางวัล <span class="required">*</span></h4>';        
        let rdDisabled = ''

        if($.inArray(Number(register.status),[2,3,0]) !== -1 || register.expired) {
            rdDisabled = 'disabled';
        }

        $.each(register.appType.sub, function(key,value){
            if(value.application_type_id == id){
                let rbId = 'id="step1-appTypeSub-'+value.id+'"',
                    rbName = 'name="step1-appTypeSub"',
                    rbValue = 'value="'+value.id+'"',
                    rbOC = 'onclick="selectType(\'appTypeSub\','+value.id+')"',
                    rbCheck = '';
                
                if(register.first){                    
                    let typeSub = register.formData.step1.appTypeSub;
                    if(typeSub == value.id){
                        rbCheck = 'checked';
                        $('#form-define').html(value.descreption);
                    }
                } else {
                    if(count == 0) {
                        rbCheck = 'checked';
                        $('#form-define').html(value.descreption);
                        register.formData.step1.appTypeSub = value.id;
                    } 
                }

                radio += '<p>';
                radio += '<input type="radio" '+rbOC+' '
                    +rbId+' '+rbName+' '+rbValue+' '
                    +rbCheck+' '+rdDisabled+'>';
                radio += value.name;
                radio += '</p>';  
                count++;               
            }
        });

        register.first = false;
        $('#group-type-sub').html(radio);
    },
    setFormDefine: function(id){
        let sub = this.appType.sub.find(el => el.id == id);
        $('#form-define').html(sub.descreption);
    },
    checkComplete(){
        let tabs = [
            {step: 1, id: '#tab-s1', form: '#form-step-1'},            
            {step: 2, id: '#tab-s2', form: '#form-step-2'},
            {step: 3, id: '#tab-s3', form: '#form-step-3'},
            {step: 4, id: '#tab-s4', form: '#form-step-4'},
            {step: 5, id: '#tab-s5', form: '#form-step-5'}
        ];

        let checkComplete = true;
        const pattern_email = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        
        $.each(tabs,function(key,tab){
            let checkRequire = true;
            let checkFileRequire = true;

            if(tab.step == register.formData.currentStep){
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
                    // else {
                    //     if(map.input == '#step2-zipcode'){
                    //         if(register.formData['step'+tab.step][map.variant].length != 5){
                    //             checkRequire = false;
                    //         } else {
                    //             $(map.input).removeClass('is-invalid');
                    //         }
                    //     } 
                    //     else if(map.input == '#step4-email'){
                    //         if(!pattern_email.test(register.formData['step'+tab.step][map.variant])){
                    //             checkRequire = false;
                    //         } else {
                    //             $(map.input).removeClass('is-invalid');
                    //         }
                    //     }
                    //     else {
                    //         $(map.input).removeClass('is-invalid');
                    //     }
                    // }
                }
            });

            if(tab.step == 5){
                checkFileRequire = checkRequireFiles('awards/application');
            }

            if(!checkRequire || !checkFileRequire){
                checkComplete = false;
                if($(tab.id).hasClass('complete')){
                    $(tab.id).removeClass('complete');
                }
            } else {
                if(!$(tab.id).hasClass('complete')){
                    $(tab.id).addClass('complete');
                }
            }
        });

        if(checkComplete){
            $('#btnHFinish').removeClass('disabled');
            $('#btnHFinish').addClass('active');
            $('#btnFFinish').prop('disabled',false);
        } else {
            $('#btnHFinish').addClass('disabled');
            $('#btnHFinish').removeClass('active');
            $('#btnFFinish').prop('disabled',true);
        }

    },
    setStep: function(step){

        if(register.change){
            register.saveDraft(register.formData.currentStep,'draft');
            register.change = false;
        }

        register.formData.currentStep = step;

        if(step == 5){
            ;[1,2,3,4].forEach(index => {
                if(!$('#step5-type'+index).hasClass('hide'))
                    $('#step5-type'+index).addClass('hide');

                if(index == register.formData.step1.appType){
                    $('#step5-type'+index).removeClass('hide');

                    if(register.formData.step1.appType == 3){
                        if(register.formData.step1.appTypeSub == 11){
                            $('#step5-spa-only').show();
                            $('#step5-wellnessCert-only').hide();
                        }
                        else if(register.formData.step1.appTypeSub == 12){
                            $('#step5-spa-only').hide();
                            $('#step5-wellnessCert-only').show();
                        }
                        else {
                            $('#step5-spa-only').hide();
                            $('#step5-wellnessCert-only').hide();
                        }
                    }
                }
            });
        }

        register.checkComplete();
    },
    saveDraft:async function(step,mode){        
        await loading('show');
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

        $.each(mapFData,function(key,mapf){
            const mapV = !empty(dataStep[mapf.variant]) ? dataStep[mapf.variant] : '';
            formData.append(mapf.api,mapV);
        });

        setting.data = formData;

        api(setting).then(function(response){
            loading('hide');
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
                        $('*').removeClass('is-invalid');
                    } else {
                        title = 'ไม่สามารถบันทึกข้อมูลได้';
                        message = draft.message;
                    }

                    alert.show(
                        draft.result,
                        draft.message
                    );                    

                    register.checkComplete();
                }
            }
        });
    },
    getMapField: function(by,st){
        let mapf = [];

        if(by == 'step'){            
            let temp = MapField.step;
            if(st != 'finish'){ 
                if(st != 5){
                    mapf = temp['s'+st]; 
                } else {
                    temp = temp['s5'];
                    let appType = register.formData.step1.appType;

                    $.each(temp, function(key,val){
                        if(appType == val.type || val.type == 'all'){
                            mapf.push(val);
                        }
                    });
                }
            } else {
                mapf.concat(
                    temp.s1.concat(
                        temp.s2.concat(
                            temp.s3.concat(
                                temp.s4.concat(temp.s5)))));
            }
        }

        return mapf;
    },
    validate: function(){
        const pattern_email = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        let bool_input = true;        
        
        ;[1,2,3,4,5].forEach(index => {
            let mapFData = this.getMapField('step',index),
                formData = register.formData['step'+index];

            $.each(mapFData,function(key,mapf){
                if(mapf.require){    
                    if(mapf.input == '#step2-zipcode'){
                        if(empty(formData[mapf.variant]) || (formData[mapf.variant]).toString().length !== 5){
                            $(mapf.input).addClass('is-invalid');
                            $('#invalid-step2-zipcode').show();
                            bool_input = false;
                        } else {
                            $(mapf.input).removeClass('is-invalid');  
                            $('#invalid-step2-zipcode').hide(); 
                        }
                    } 
                    else if(mapf.input == '#step4-email'){                        
                        if(empty(formData[mapf.variant]) || !pattern_email.test(formData[mapf.variant])){
                            $(mapf.input).addClass('is-invalid');
                            $('#invalid-step4-email').show();
                            bool_input = false;
                        } else {
                            $(mapf.input).removeClass('is-invalid');   
                            $('#invalid-step4-email').hide();
                        }
                    } else {
                        if(empty(formData[mapf.variant])){
                            $(mapf.input).addClass('is-invalid');
                            bool_input = false;
                        } else {
                            $(mapf.input).removeClass('is-invalid');  
                        }    
                    }
                }
            });
        });

        if(!register.passYear){
            const app = register.formData.step1.appType;
            const confYear = register.appType.main.find(el => el.id == app);
            $('#step5-openYear').addClass('is-invalid');
            $('#error-open-year').html('เปิดรับสมัครสําหรับผู้ประกอบการที่จดทะเบียนมาแล้ว '+confYear.fixe_year_open+' ปีขึ้นไป');
            bool_input = false;
        } else {
            const date = new Date();
            const fulldate = $('#step5-hiddenDate').val().split('/');

            const from = fulldate[1]+'/'+fulldate[2]+'/'+fulldate[0];
            const to = String(date.getMonth()+1).padStart(2, '0')+'/'+String(date.getDate()).padStart(2, '0')+'/'+date.getFullYear();
            
            const totalYear = calcDate(from,to);
            const app = register.formData.step1.appType;
            const confYear = register.appType.main.find(el => el.id == app);
            register.passYearCount = confYear.fixe_year_open;

            if(Number(totalYear.total_year) < Number(confYear.fixe_year_open)){
                bool_input = false;
                register.passYear = false;
                $('#error-open-year').html('เปิดรับสมัครสําหรับผู้ประกอบการที่จดทะเบียนมาแล้ว '+confYear.fixe_year_open+' ปีขึ้นไป');
                $('#step5-openYear').addClass('is-invalid');
            } else {
                $('#step5-openYear').removeClass('is-invalid');  
                register.passYear = true;
            }
        }

        if(!bool_input){
            alert.show(
                'error',
                'ดำเนินการไม่สำเร็จ',
                'โปรดตรวจสอบแบบฟอร์มใบสมัคร ให้ครบถ้วน ก่อนส่งแบบฟอร์มใบสมัคร'
            );
        }

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

                            register.checkComplete();
                        }
                    });
                }
            });
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
    register.checkComplete();
};

$('#step1-desc').on('keyup change input', function(){ 
    register.change = true;
    register.formData.step1.desc = $(this).val(); 
    $('#step1-desc-cc').html(1000 - register.formData.step1.desc.length);
    register.checkComplete();
});

$('#step1-link').on('keyup change input', function(){ 
    register.change = true;
    register.formData.step1.link = $(this).val(); 
    register.checkComplete();
});

$('[name=step1-lowcarbon]').on('click', function(){ 
    register.formData.step1.lowcarbon = $(this).val(); 
    register.change = true; 
    register.checkComplete();
});

// Step 2
$('#step2-siteNameTh').on('keyup change input', function(){ 
    register.formData.step2.siteNameTh = $(this).val();
     register.change = true;
     register.checkComplete();
});

$('#step2-siteNameEng').on('keyup change input', function(){ 
    let value = $(this).val().replace(/[^a-zA-Z0-9\s]/g,'');
    $(this).val(value);
    register.formData.step2.siteNameEng = value; 
    register.change = true;
    register.checkComplete();
});

$('#step2-address').on('keyup change input', function(){ 
    register.formData.step2.address = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step2-road').on('keyup change input', function(){ 
    register.formData.step2.road = $(this).val(); 
    register.change = true;
    register.checkComplete();
});
$('#step2-province').on('keyup change input', function(){ 
    register.formData.step2.province = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step2-district').on('keyup change input', function(){ 
    register.formData.step2.district = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step2-subDistrict').on('keyup change input', function(){ 
    register.formData.step2.subDistrict = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step2-zipcode').on('keyup change input',async function(){   
    register.formData.step2.zipcode = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step2-fb').on('keyup change input', function(){ 
    register.formData.step2.fb = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step2-ig').on('keyup change input', function(){ 
    register.formData.step2.ig = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step2-lid').on('keyup change input', function(){ 
    register.formData.step2.lid = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step2-other').on('keyup change input', function(){ 
    register.formData.step2.other = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step2-gm').on('keyup change input', function(){ 
    register.formData.step2.gm = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

// Step 3
$('#step3-companyName').on('keyup change input', function(){ 
    register.formData.step3.companyName = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

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
    register.checkComplete();
});

$('#step3-address').on('keyup change input', function(){ 
    register.formData.step3.address = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step3-road').on('keyup change input', function(){ 
    register.formData.step3.road = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step3-province').on('keyup, change input', function(){ 
    register.formData.step3.province = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step3-district').on('keyup, change input', function(){ 
    register.formData.step3.district = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step3-subDistrict').on('keyup, change input', function(){ 
    register.formData.step3.subDistrict = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step3-zipcode').on('keyup change input', function(){ 
    register.formData.step3.zipcode = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step3-telephone').on('keyup change input', function(){ 
    register.formData.step3.telephone = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step3-email').on('keyup change input', function(){ 
    register.formData.step3.email = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step3-lid').on('keyup change input', function(){ 
    register.formData.step3.lid = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

// Step 4
$('#step4-name').on('keyup change input', function(){ 
    register.formData.step4.name = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step4-position').on('keyup change input', function(){ 
    register.formData.step4.position = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step4-telephone').on('keyup change input', function(){ 
    register.formData.step4.telephone = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step4-email').on('keyup change input', function(){ 
    register.formData.step4.email = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step4-lid').on('keyup change input', function(){ 
    register.formData.step4.lid = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

// Step 5
$('[name=step5-t1-manageBy]').on('click', function(){ 
    register.formData.step5.manageBy = $(this).val(); 
    register.change = true;
    
    const panel = $('#div-step5-businessCert');
    const title = $('#step5-file1-title');

    switch($(this).val()){
        case '1': 
            title.html('ใบรับรองมาตรฐาน หรือประกาศนียบัตรจากการท่องเที่ยวแห่ง'); 
            panel.hide();
        break;
        case '2': 
            title.html('สำเนาหนังสือการจดทะเบียนวิสาหกิจชุมชน <span class="required">*</span>');  
            panel.show();
        break;
        case '3': 
            title.html('สำเนาใบอนุญาตประกอบธุรกิจที่ถูกต้องตามกฎหมาย <span class="required">*</span>');  
            panel.show();
        break;
    }
    
    register.checkComplete();
});

$('[name=step5-t2-buildExt]').on('click', function(){ 
    register.formData.step5.buildExt = $(this).val(); 
    register.change = true;
    console.log('buildExt: '+register.formData.step5.buildExt);
    register.checkComplete();
});

$('#step5-t2-bussLicense').on('keyup change input', function(){ 
    register.formData.step5.bussLicense = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('[name=step5-t2-bussCkRoom]').on('click', function(){ 
    register.formData.step5.bussCkRoom = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step5-t3-bussLicense').on('keyup change input', function(){ 
    register.formData.step5.bussLicenseT3 = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('[name=step5-t3-hasEffluent]').on('click', function(){ 
    register.formData.step5.hasEffluent = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('[name=step5-t3-bussCites]').on('click', function(){ 
    register.formData.step5.bussCites = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('[name=step5-t3-nominee]').on('click', function(){ 
    register.formData.step5.nominee = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('[name=step5-t3-outlander]').on('click', function(){ 
    register.formData.step5.inpOutlander = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

$('#step5-t4-bussLicense').on('keyup change input', function(){ 
    register.formData.step5.bussLicenseT4 = $(this).val(); 
    register.change = true;
    register.checkComplete();
});

