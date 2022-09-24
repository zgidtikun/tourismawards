var baseUrl = window.location.origin;

const register = {
    id: null,
    statue: null,
    count: null,
    appType: { main: [], sub: [] },
    formData: {
        currentStep: null,
        step1: {}, step2: {}, step3: {}, step4: {}, step5: {},
    },
    mapField: {
        step1: [
            { input: '[name=step1-appType]', variant: 'appType', 
                api: 'application_type_id', id: 'step1-appType-', require: true },
            { input: '[name=step1-appTypeSub]', variant: 'appTypeSub', 
                api: 'application_type_sub_id', id: 'step1-appTypeSub-', require: true },
            { input: '#step1-desc', variant: 'desc', api: 'highlights', require: true },
            { input: '#step1-link', variant: 'link', api: 'link', require: false },
        ],
        step2: [
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
        ],
        step3: [
            { input: '#step3-companyName', variant: 'companyName', api: 'company_name', require: true },
            { input: '#step3-address', variant: 'address', api: 'company_addr_no', require: true },
            { input: '#step3-road', variant: 'road', api: 'company_addr_road', require: true },
            { input: '#step3-subDistrict', variant: 'subDistrict', api: 'company_addr_sub_district', require: true },
            { input: '#step3-district', variant: 'district', api: 'company_addr_district', require: true },
            { input: '#step3-province', variant: 'province', api: 'company_addr_province', require: true },
            { input: '#step3-zipcode', variant: 'zipcode', api: 'company_addr_zipcode', require: true },
            { input: '#step3-telephone', variant: 'telephone', api: 'mobile', require: false },
            { input: '#step3-email', variant: 'email', api: 'email', require: false },
            { input: '#step3-lid', variant: 'lid', api: 'line_id', require: false },
        ],
        step4: [
            { input: '#step4-name', variant: 'name', api: 'knitter_name', require: true },
            { input: '#step4-position', variant: 'position', api: 'knitter_position', require: true },
            { input: '#step4-telephone', variant: 'telephone', api: 'knitter_tel', require: true },
            { input: '#step4-email', variant: 'email', api: 'knitter_email', require: true },
            { input: '#step4-lid', variant: 'lid', api: 'knitter_line', require: false },
        ],
        step5: [
            { input: '#step5-openYear', variant: 'openYear', api: 'year_open', require: true },
            { input: '#step5-totalYear', variant: 'totalYear', api: 'year_total', require: true },
            { input: '[name=step5-manageBy]', variant: 'manageBy', 
                api: 'manage_by', id: 'step5-manageBy-', require: false },
        ],
        files: [
            { input: '#step1-detail', step: 1, show: 'div.detail-new', api: 'detailFiles[]' },
            { input: '#step1-paper', step: 1, show: 'div.paper-new', api: 'paperFiles[]' },
            { input: '#step5-landOwner', step: 5, show: 'div.landOwner-new', api: 'landOwnerFiles[]' },
            { input: '#step5-businessCert', step: 5, show: 'div.businessCert-new', api: 'businessCertFiles[]' },
            { input: '#step5-otherCert', step: 5, show: 'div.otherCert-new', api: 'otherCertFiles[]' },
        ]
    },
    init: function(){        
        this.getAppType().then(function(dataApp){
            register.appType.main = dataApp.main;
            register.appType.sub = dataApp.sub;

            let radio = '',
                counter = 0;

            $.each(register.appType.main, function(key,value){
                let rbId = 'id="step1-appType-'+value.id+'"',
                    rbName = 'name="step1-appType"',
                    rbValue = 'value="'+value.id+'"',
                    rbCheck = '';
                
                if(key == 0) rbCheck = 'checked';

                radio += '<input type="radio" '+rbId+' '+rbName+' '+rbValue+' '+rbCheck+'>';
                radio += '<label>'+value.name+'</label>';
            });            

            $('#group-type').html(radio);

            $.each(register.appType.sub, function(key,value){
                if(value.application_type_id == register.appType.main[0].id){
                    let rbId = 'id="step1-appTypeSub-'+value.id+'"',
                        rbName = 'name="step1-appTypeSub"',
                        rbValue = 'value="'+value.id+'"',
                        rbCheck = '';
                    
                    if(key == 0) rbCheck = 'checked';

                    radio += '<input type="radio" '+rbId+' '+rbName+' '+rbValue+' '+rbCheck+'>';
                    radio += '<label>'+value.name+'</label>';
                    
                    if(counter == 1) 
                        register.formData.step1.appTypeSub = value.id;
                    counter++;
                }
            }); 

            $('#group-type-sub').html(radio);

            register.getApc().then(function(dataApc){
                if(dataApc.status == 'success')
                    loading('hide');
            });
        });
    },
    getApc: function(){
        return new Promise(function(resolve, reject) {
            $.ajax({
                type: 'get',
                url: baseUrl+'/frontend/app/detail',
                async: false,
                success: function(response){
                    let app = response.data;
                    let files = app.files,
                        tmp = [];
                    
                    register.id = app.id;
                    register.statue = app.status;
                    register.formData.currentStep = app.current_step;

                    for(let i = 1; i <= 5; i++){
                        let mapFData = register.getMapField(i);                        
                        tmp['step'+i] = [];

                        $.each(mapFData,function(keym,vulm){
                            tmp['step'+i][keym.variant] = '';
                            $.each(app,function(keya,vula){
                                if(keym.api == keya){
                                    if(!empty(vula)){
                                        tmp['step'+i][keym.variant] = vula;

                                        if(!$(vulm.input).length){
                                            let = attrType = $(vulm.input).attr('type');
                                            if(!$.inArray(attrType,['radio','checkbox']))
                                                $(vulm.input).val(vula);
                                            else
                                                $(vulm.id+'-'+vula).prop('checked',true);                                            
                                        }
                                    }
                                }
                            });
                        });
                    }
                    
                    Object.assign(register.formData.step1, tmp['step1']);
                    Object.assign(register.formData.step2, tmp['step2']);
                    Object.assign(register.formData.step3, tmp['step3']);
                    Object.assign(register.formData.step4, tmp['step4']);
                    Object.assign(register.formData.step5, tmp['step5']);
                    
                    register.formData.step1.images = [];
                    register.formData.step1.detail = [];
                    register.formData.step1.paper = [];
                    register.formData.step5.landOwner = [];
                    register.formData.step5.businessCert = [];
                    register.formData.step5.otherCert = [];
                    register.count = {
                        image: 0, detail: 0, paper: 0,
                        landOwner: 0, businessCert: 0, otherCert: 0
                    };

                    if(files.length > 0){
                        $.each(files,function(key,file){
                            switch(file.file_position){
                                case 'app-register-img':
                                    register.formData.step1.images.push(file);
                                    register.count.image++;
                                break;
                                case 'app-register-detail': 
                                    register.formData.step1.detail.push(file);
                                    register.count.detail++;
                                break;
                                case 'app-register-paper':
                                    register.formData.step1.paper.push(file);
                                    register.count.paper++;
                                break;
                                case 'app-register-landOwner':
                                    register.formData.step5.landOwner.push(file);
                                    register.count.landOwner++;
                                break;
                                case 'app-register-businessCert':
                                    register.formData.step5.businessCert.push(file);
                                    register.count.businessCert++;
                                break;
                                case 'app-register-otherCert':
                                    register.formData.step5.otherCert.push(file);
                                    register.count.otherCert++;
                                break;
                            }
                        });
                    }
                    
                    resolve({status: response.result});
                }
            });
        });  
    },
    getAppType: function(){
        return new Promise(function(resolve, reject) {
            $.ajax({
                type: 'get',
                url: baseUrl+'/frontend/app/type-all',
                dataType: 'json',
                async: false,
                success: function(response){
                    resolve(response);
                }
            });
        });
    },
    setAppTypeSub: function(id){        
        this.formData.step1.appType = id;  
        let radio = '';

        $.each(this.appType.sub, function(key,value){
            if(value.application_type_id == id){
                let rbId = 'id="step1-appTypeSub-'+value.id+'"',
                    rbName = 'name="step1-appTypeSub"',
                    rbValue = 'value="'+value.id+'"',
                    rbCheck = '';
                
                if(key == 0) rbCheck = 'checked';

                radio += '<input type="radio" '+rbId+' '+rbName+' '+rbValue+' '+rbCheck+'>';
                radio += '<label>'+value.name+'</label>';
                
                if(counter == 1) 
                    this.formData.step1.appTypeSub = value.id;                    
            }
        });

        $('#group-type-sub').html(radio);
    },
    setStep: function(step){

    },
    getMapField: function(step){
        let map = [];

        if(step == 1) map = mapField.step1 
        else if(step == 2) map = mapField.step2 
        else if(step == 3) map = mapField.step3 
        else if(step == 4) map = mapField.step4
        else if(step == 5) map = mapField.step5;
        else if(step == 'finish') {
            map.concat(mapField.step1.concat(mapField.step2.concat(mapField.step3.concat(mapField.step4.concat(mapField.step5)))));
        }

        return map;
    },
    validate: function(step){
        let mapFData = this.getMapField(step),
            bool = true;

        $.each(mapFData,function(key,map){
            if(map.require){
                let = attrType = $(map.input).attr('type');

                if($.inArray(attrType,['text','number'])){
                    if($(map.input).val() == ''){
                        bool = false;
                    }
                } else bool = false;
            }
        });

        if($.inArray(step,[1,'finish'])){
            let file = ['#step1-detail','#step1-paper'];
            $.each(file,function(key,id){
                if(!this.onFileHandle(id))
                    bool = false;
            });
        }
        
        if($.inArray(step,[5,'finish'])){
            let file = ['#step5-landOwner','#step5-businessCert','#step5-otherCert'];
            $.each(file,function(key,id){
                if(!this.onFileHandle(id))
                    bool = false;
            });
        }

        return bool;

    },
    saveStep: function(step){
        if(this.validate(step)){
            loading('show');

            let formData = new FormData(),
                mapFData = this.getMapField(step)
                mapFiles = this.mapField.files;

            formData.append('id',this.id);
            formData.append('step',step);
            formData.append('status',step != 'finish' ? 1 : 2);
            
            $.each(mapFData,function(mapk,mapv){
                formData.append(mapv.api,this.formData['step'+step][mapv.variant]);
            });

            if($.inArray(step,[1,5,'finish'])){
                $.each(mapFiles,function(kmf,vmf){
                    let isAppend = false;

                    if($.inArray(step,[1,5])){
                        if(vmf.step == step){
                            isAppend = true;
                        }
                    } else isAppend = true;

                    if(isAppend){
                        let files = $(vmf.input)[0].files;
                        if(files.length > 0){
                            $.each(detail,function(key,file){
                                formData.append(vmf.api,file);
                            });
                        }
                    }
                });
            }

            this.saveApp(formData,baseUrl+'/frontend/app/draft').then(function(res){
                loading('hide');
                let save = res;
            });

        } else {
            alert.show('error','ไม่สามารถบันทึกใบสมัครได้','กรุณาตรวจทานข้อมูลอีกครั้ง');
        }
    },
    saveApp: function(postData,link){
        return new Promise(function(resolve, reject) {
            $.ajax({
                type: 'post',
                url: link,
                data: postData,
                dataType: 'json',
                contentType: false,
                processData: false,
                async: false,
                success: function(response){
                    resolve(response);
                }
            });
        });
    },
    setFile: function(){

    },
    onFileHandle: function(id, clear = true){
        let file = {
                input: ['#step1-detail','#step1-paper','#step5-landOwner','#step5-businessCert','#step5-otherCert'],
                inputAccept: ['.doc','docx','application/pdf',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
                image:  ['#step1-img'],
                imageAccept: ['image/jpg','image/jpeg','image/gif','image/png','image/webp'],
            },
            filehandle = $(id)[0].files,
            checkType = true;
        
        if(filehandle > 0){
            if($.inArray(id,file.input) !== -1){
                let indexCount = null
                
                if(id.indexOf('#step1-') !== -1)
                    indexCount = id.replace('#step1-','');
                else if(id.indexOf('#step5-') !== -1)
                    indexCount = id.replace('#step5-','');

                let fileTotal = Number(this.count[indexCount]) + Number(filehandle.length);

                if(fileTotal > 5){
                    alert.show('warning','ไม่สามารถอัพโหลดไฟล์ได้','คุณสามารถอัพโหลดไฟล์ได้ไม่เกิน 5 ไฟล์เท่านั้น');
                    checkType = false;
                }

                if(checkType){
                    let accept = file.inputAccept.concat(file.imageAccept);
                    $.each(filehandle,function(key,val){
                        let mb = (val.size / (1024 * 1024)).toFixed(2);
                        
                        if($.inArray(val.type,accept) === -1){
                            checkType = false;
                        } else if(mb > 1.00){
                            checkType = false;
                        } 
                    });
                }
                
            } else {
                let imageTotal = Number(this.count.image) + Number(filehandle.length);
                
                if(imageTotal <= 10){
                    
                    $.each(filehandle,function(key,val){
                        if($.inArray(val.type,file.imageAccept) === -1)
                            checkType = false;
                    });

                    if(checkType){
                        this.uploadImage(id);
                    } else {
                        checkType = false;
                        alert.show('warning','ไม่สามารถอัพโหลดรูปได้','กรุณาเลือกเป็นไฟล์ .jpg, .jpeg, .gif, .png .webp เท่านั้น');
                    }
                } else {
                    checkType = false;
                    alert.show('warning','ไม่สามารถอัพโหลดรูปได้','คุณสามารถอัพโหลดรูปได้ไม่เกิน 10 รูปเท่านั้น');
                }
            }
        } else {
            if(id == '#step5-landOwner')
                checkType = false;
        }
        
        if(!checkType && clear)
           this.resetFileInput(id);
        
        return checkType;
    },
    resetFileInput: function(id){
        let ele = $(id);
        ele.wrap('<form>').closest('form').get(0).reset();
        ele.unwrap();

        if(id != '#step1-img'){
            let map = this.mapField.files.find(el => el.input == id);
            $(map.show).remove();
        }
    },
    uploadImage: function(id){
        loading('show');

        let images = $(id)[0].files,
            formData = new FormData();

        formData.append('id',this.id);
        formData.append('step',1);
        formData.append('position','registerImages');
        
        $.each(images,function(key,file){
            formData.append('images[]',file);
        });

        this.saveApp(formData,baseUrl+'/frontend/app/upload/images').then(function(res){
            loading('hide');
            let save = res;

            if(save.result == 'error_login'){
                alert.login();
            } else {
                if(save.result == 'success'){
                    register.count.image += Number(save.upload_c);
                    var title = 'อัพโหลดรูปเรียบร้อยแล้ว'
                } else {
                    var title = 'ไม่สามารถอัพโหลดรูปได้'
                }
                alert.show(save.result,title,save.message);
                return;
            }

        });
        
    },
}

// Application Register
// Step 1 
$('[name=step1-appType]').on('click', function(){ register.formData.step1.appType = $(this).val(); });
$('[name=step1-appTypeSub]').on('click', function(){ register.formData.step1.appTypeSub = $(this).val(); });
$('#step1-desc').on('keyup', function(){ register.formData.step1.desc = $(this).val(); });
$('#step1-link').on('keyup', function(){ register.formData.step1.link = $(this).val(); });

// Step 2
$('#step2-siteNameTh').on('keyup', function(){ register.formData.step2.siteNameTh = $(this).val(); });
$('#step2-siteNameEng').on('keyup', function(){ register.formData.step2.siteNameEng = $(this).val(); });
$('#step2-address').on('keyup', function(){ register.formData.step2.address = $(this).val(); });
$('#step2-road').on('keyup', function(){ register.formData.step2.road = $(this).val(); });
$('#step2-province').on('keyup', function(){ register.formData.step2.province = $(this).val(); });
$('#step2-district').on('keyup', function(){ register.formData.step2.district = $(this).val(); });
$('#step2-subDistrict').on('keyup', function(){ register.formData.step2.subDistrict = $(this).val(); });
$('#step2-zipcode').on('keyup', function(){ register.formData.step2.zipcode = $(this).val(); });
$('#step2-fb').on('keyup', function(){ register.formData.step2.fb = $(this).val(); });
$('#step2-ig').on('keyup', function(){ register.formData.step2.ig = $(this).val(); });
$('#step2-lid').on('keyup', function(){ register.formData.step2.lid = $(this).val(); });
$('#step2-other').on('keyup', function(){ register.formData.step2.other = $(this).val(); });

// Step 3
$('#step3-companyName').on('keyup', function(){ register.formData.step3.companyName = $(this).val(); });

$('[name=step3-setAddress]').on('click', function(){
    let current;

    if($('#step3-setCurrent').is(':checked')) current = true;
    if($('#step3-setNew').is(':checked')) current = false;

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

$('#step3-address').on('keyup', function(){ register.formData.step3.address = $(this).val(); });
$('#step3-road').on('keyup', function(){ register.formData.step3.road = $(this).val(); });
$('#step3-province').on('keyup', function(){ register.formData.step3.province = $(this).val(); });
$('#step3-district').on('keyup', function(){ register.formData.step3.district = $(this).val(); });
$('#step3-subDistrict').on('keyup', function(){ register.formData.step3.subDistrict = $(this).val(); });
$('#step3-zipcode').on('keyup', function(){ register.formData.step3.zipcode = $(this).val(); });
$('#step3-telephone').on('keyup', function(){ register.formData.step3.telephone = $(this).val(); });
$('#step3-email').on('keyup', function(){ register.formData.step3.email = $(this).val(); });
$('#step3-lid').on('keyup', function(){ register.formData.step3.lid = $(this).val(); });

// Step 4
$('#step4-name').on('keyup', function(){ register.formData.step4.name = $(this).val(); });
$('#step4-position').on('keyup', function(){ register.formData.step4.position = $(this).val(); });
$('#step4-telephone').on('keyup', function(){ register.formData.step4.telephone = $(this).val(); });
$('#step4-email').on('keyup', function(){ register.formData.step4.email = $(this).val(); });
$('#step4-lid').on('keyup', function(){ register.formData.step4.lid = $(this).val(); });

// Step 5
$('#step5-openYear').on('keyup', function(){      
    let currntYear = new Date().getFullYear() + 543,
        openYear = $(this).val();

    let totalYear = Number(currntYear) = Number(openYear);

    register.formData.step5.openYear = openYear;
    register.formData.step5.totalYear = totalYear;
    $('#step5-totalYear').val(totalYear+' ปี');
});

$('[name=step5-manageBy]').on('click', function(){ register.formData.step5.manageBy = $(this).val(); });

