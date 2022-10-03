const MapField = {
    step: {
        s1: [
            { input: '[name=step1-appType]', variant: 'appType', 
                api: 'application_type_id', id: 'step1-appType-', require: true },
            { input: '[name=step1-appTypeSub]', variant: 'appTypeSub', 
                api: 'application_type_sub_id', id: 'step1-appTypeSub-', require: true },
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
        ],
        s3: [
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
        s4: [
            { input: '#step4-name', variant: 'name', api: 'knitter_name', require: true },
            { input: '#step4-position', variant: 'position', api: 'knitter_position', require: true },
            { input: '#step4-telephone', variant: 'telephone', api: 'knitter_tel', require: true },
            { input: '#step4-email', variant: 'email', api: 'knitter_email', require: true },
            { input: '#step4-lid', variant: 'lid', api: 'knitter_line', require: false },
        ],
        s5: [
            { input: '#step5-openYear', variant: 'openYear', api: 'year_open', require: true },
            { input: '#step5-totalYear', variant: 'totalYear', api: 'year_total', require: true },
            { input: '[name=step5-manageBy]', variant: 'manageBy', 
                api: 'manage_by', id: 'step5-manageBy-', require: false },
        ],
    },
    files: [
        { input: '#step1-img', step: 1, show: 'div.image-new', api: 'registerImages[]',
            position: 'registerImages', filed: 'image' },
        { input: '#step1-detail', step: 1, show: 'div.detail-new', api: 'detailFiles[]',
            position: 'detailFiles', filed: 'detail' },
        { input: '#step1-paper', step: 1, show: 'div.paper-new', api: 'paperFiles[]',
            position: 'paperFiles', filed: 'paper' },
        { input: '#step5-landOwner', step: 5, show: 'div.landOwner-new', api: 'landOwnerFiles[]',
            position: 'landOwnerFiles', filed: 'landOwner' },
        { input: '#step5-businessCert', step: 5, show: 'div.businessCert-new', api: 'businessCertFiles[]',
            position: 'businessCertFiles', filed: 'businessCert' },
        { input: '#step5-otherCert', step: 5, show: 'div.otherCert-new', api: 'otherCertFiles[]',
            position: 'otherCertFiles', filed: 'otherCert' },
    ],
    fileFilter: {
        input: ['#step1-detail','#step1-paper','#step5-landOwner','#step5-businessCert','#step5-otherCert'],
        inputAccept: ['application/pdf'],
        image:  ['#step1-img'],
        imageAccept: ['image/jpg','image/jpeg','image/png'],
    }                                                                                         
};

const register = {
    id: null,
    statue: null,
    count: null,
    appType: { main: [], sub: [] },
    formData: {
        currentStep: null,
        step1: {}, step2: {}, step3: {}, step4: {}, step5: {},
    },
    init: function(){        
        loading('show');
        this.getAppType().then(function(appType){
            register.appType.main = appType.main;
            register.appType.sub = appType.sub;

            let radio = '',
                count = 0;

            $.each(register.appType.main, function(key,value){
                let rbId = 'id="step1-appType-'+value.id+'"',
                    rbName = 'name="step1-appType"',
                    rbValue = 'value="'+value.id+'"',
                    rbOC = 'onclick="selectType(\'appType\','+value.id+')"';
                    rbCheck = '';
                
                if(key == 0) rbCheck = 'checked';
                
                radio += '<div class="form-check">';
                radio += '<input class="form-check-input" type="radio" '+rbOC+' '+rbId+' '+rbName+' '+rbValue+' '+rbCheck+'>';
                radio += '<label class="form-check-label">'+(key+1)+'. '+value.name+'</label>';
                radio += '</div>';
            });            

            $('#group-type').append(radio);
            radio = '<legend class="fs-22 mb-2">';
            radio += 'สาขารางวัล';
            radio += '<span class="ml-1" style="color: #F64E60;">*</span>';
            radio += '</legend>';

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
                        register.formData.step1.appTypeSub = value.id;
                    }
                    radio += '<div class="form-check">';
                    radio += '<input class="form-check-input" type="radio" '+rbOC+' '+rbId+' '+rbName+' '+rbValue+' '+rbCheck+'>';
                    radio += '<label class="form-check-label">'+value.name+'</label>';
                    radio += '</div>';
                    count++;
                }
            }); 

            $('#group-type-sub').html(radio);

            register.getApc().then(function(dataApc){
                if(dataApc.result == 'success')
                    loading('hide');
            });
        });
    },
    getAppType: async function(){
        return new Promise(function(resolve) {            
            api({method: 'get', url: '/frontend/app/type-all'}).then(function(data){
                resolve(data);
            });
        });
    },
    getApc: async function(){
        return new Promise(function(resolve) {
            api({method: 'get', url: '/frontend/app/detail'}).then(function(response){
                let app = response.data;
                let files = app.files,
                    tmp = [];
                
                register.id = app.id;
                register.statue = app.status;
                register.formData.currentStep = app.current_step;

                for(let i = 1; i <= 5; i++){
                    let mapFData = register.getMapField('step',i);                        
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
                            case 'registerImages':
                                register.formData.step1.images.push(file);
                                register.count.image++;
                            break;
                            case 'detailFiles': 
                                register.formData.step1.detail.push(file);
                                register.count.detail++;
                            break;
                            case 'paperFiles':
                                register.formData.step1.paper.push(file);
                                register.count.paper++;
                            break;
                            case 'landOwnerFiles':
                                register.formData.step5.landOwner.push(file);
                                register.count.landOwner++;
                            break;
                            case 'businessCertFiles':
                                register.formData.step5.businessCert.push(file);
                                register.count.businessCert++;
                            break;
                            case 'otherCertFiles':
                                register.formData.step5.otherCert.push(file);
                                register.count.otherCert++;
                            break;
                        }
                    });
                }
                
                resolve(response);
            });
        });  
    },
    setAppTypeSub: function(id){        
        this.formData.step1.appType = id;  
        let count = 0;
        let radio = '<legend class="fs-22 mb-2">';
        radio += 'สาขารางวัล';
        radio += '<span class="ml-1" style="color: #F64E60;">*</span>';
        radio += '</legend>';

        $.each(this.appType.sub, function(key,value){
            if(value.application_type_id == id){
                let rbId = 'id="step1-appTypeSub-'+value.id+'"',
                    rbName = 'name="step1-appTypeSub"',
                    rbValue = 'value="'+value.id+'"',
                    rbOC = 'onclick="selectType(\'appTypeSub\','+value.id+')"';
                    rbCheck = '';
                
                if(count == 0) {
                    rbCheck = 'checked';
                    $('#form-define').html(value.descreption);
                    register.formData.step1.appTypeSub = value.id;
                }
                radio += '<div class="form-check">';
                radio += '<input class="form-check-input" type="radio" '+rbOC+' '+rbId+' '+rbName+' '+rbValue+' '+rbCheck+'>';
                radio += '<label class="form-check-label">'+value.name+'</label>';
                radio += '</div>';  
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

    },
    getMapField: function(by,st = 1){
        let map = [];

        if(by == 'step'){            
            let temp = MapField.step;
            if(st != 'finish') 
                map = temp['s'+st]; 
            else 
                map.concat(temp.s1.concat(temp.s2.concat(temp.s3.concat(temp.s4.concat(temp.s5)))));
        } else if(by == 'files')
            map = MapField.files;

        return map;
    },
    validate: function(step){
        let mapFData = this.getMapField('step',step),
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
                mapFData = this.getMapField('step',step),
                mapFiles = this.getMapField('files');

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

                    if(isAppend && vmf.input != '#step1-img'){
                        let files = $(vmf.input)[0].files;
                        if(files.length > 0){
                            $.each(detail,function(key,file){
                                formData.append(vmf.api,file);
                            });
                        }
                    }
                });
            }

            api({method: 'action', url: '/frontend/app/draft', data: formData}).then(function(res){
                loading('hide');
                let save = res;

                if(save.result == 'error_login'){
                    alert.login();
                } else {
                    if(save.result == 'success'){
                        var title = 'บันทึกข้อมูลเรียบร้อยแล้ว';
                    } else {
                        var title = 'ไม่สามารถบันทึกข้อมูลได้';
                    }
                    alert.show(save.result,title,save.message);
                    return;
                }
            });

        } else {
            alert.show('error','ไม่สามารถบันทึกข้อมูลได้','กรุณาตรวจทานข้อมูลอีกครั้ง');
        }
    },
    setFile: function(){

    },
    onFileHandle: function(id, clear = true){
        let filter = MapField.fileFilter,
            filehandle = $(id)[0].files,
            checkType = true;
        
        if(filehandle > 0){
            if($.inArray(id,filter.input) !== -1){
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
                    let accept = filter.inputAccept.concat(filter.imageAccept);
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
                        if($.inArray(val.type,filter.imageAccept) === -1)
                            checkType = false;
                    });

                    if(checkType){
                        this.uploadImage(id);
                    } else {
                        checkType = false;
                        alert.show('warning','ไม่สามารถอัพโหลดรูปได้','กรุณาเลือกเป็นไฟล์ .jpg, .jpeg, .png เท่านั้น');
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

        api({method: 'action', url: '/frontend/app/upload', data: formData}).then(function(res){
            loading('hide');
            let save = res;

            if(save.result == 'error_login'){
                alert.login();
            } else {
                if(save.result == 'success'){
                    register.count.image += Number(save.upload_c);
                    var title = 'อัพโหลดรูปเรียบร้อยแล้ว';
                } else {
                    var title = 'ไม่สามารถอัพโหลดรูปได้';
                }
                alert.show(save.result,title,save.message);
                return;
            }

        });
        
    },
    removeFile: function(id,pos){
        let filter = MapField.files.find(el => el.position == pos);
        let files = this.formData['step'+filter.step][filter.filed],
            file = files.find(el => el.id == id),
            setAlert = {
                icon: 'question',
                title: 'ยืนยันการลบไฟล์!',
                text: 'คุณต้องการลบไฟล์ '+file.file_original+' หรือไม่',
                button: { confirm: 'ลบไฟล์', cancel: 'ยกเลิก' }
            };

        alert.confirm(setAlert).then(function(al){
            loading('show');
            if(al.status){
                let setting = {
                    method: 'post', url: '/frontend/app/remove-file',
                    data: { id: file.id, path: file.path }
                };

                api(setting).then(function(res){
                    loading('hide');
                    let save = res;

                    if(save.result == 'error_login'){
                        alert.login();
                    } else {
                        if(save.result == 'success'){
                            register.count[filter.filed]--;
                            var title = 'ลบไฟล์เรียบร้อยแล้ว';
                        } else {
                            var title = 'ไม่สามารถลบไฟล์ได้';
                        }
                        alert.show(save.result,title,save.message);
                        return;
                    }
                });
            }
        });

    },
    resetFileInput: function(id){
        let ele = $(id);
        ele.wrap('<form>').closest('form').get(0).reset();
        ele.unwrap();

        if(id != '#step1-img'){
            let map = MapField.files.find(el => el.input == id);
            $(map.show).remove();
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
};

$('#step1-desc').on('keyup', function(){ 
    register.formData.step1.desc = $(this).val(); 
    $('#step1-desc-cc').html(1000 - register.formData.step1.desc.length);
});
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

    let totalYear = Number(currntYear) - Number(openYear);

    register.formData.step5.openYear = openYear;
    register.formData.step5.totalYear = totalYear;
    $('#step5-totalYear').val(totalYear+' ปี');
});

$('[name=step5-manageBy]').on('click', function(){ register.formData.step5.manageBy = $(this).val(); });

