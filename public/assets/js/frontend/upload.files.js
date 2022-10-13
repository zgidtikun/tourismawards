const onFileHandle = (setting,input,type) => {
    let handle  = $(input)[0].files,
        filter  = accept[type],
        ref     = referance.find(el => el.input == input),
        check   = true,
        error, total;
        
    if(handle.length > 0){
        switch(ref.app){
            case 'awards/application': 
            case 'awards/pre-screen':

                if(ref.app == 'awards/application'){
                    total = Number(register.count[ref.pointer[1]]) + Number(handle.length);
                } else if(ref.app == 'awards/pre-screen'){
                    let length = psc.questions[setting.cate].question[setting.seg][ref.position].length;
                    total = Number(length) + Number(handle.length);
                }
            
                if(total > ref.maxUpload){
                    alert.show('warning','ไม่สามารถอัพโหลดไฟล์ได้','คุณสามารถอัพโหลดไฟล์ได้ไม่เกิน '+ref.maxUpload+' ไฟล์เท่านั้น');
                    return false
                }

                $.each(handle,function(key,val){
                    let mb = (val.size / (1024 * 1024)).toFixed(2);
                    
                    if($.inArray(val.type,filter) === -1){
                        check = false;
                        error = 'outType';
                        return false;
                    } 
                    
                    if(mb > ref.maxSize){
                        check = false; 
                        error = 'outSize';
                        return false
                    } 
                });

                if(!check){
                    let error_title, error_text;                    
                    error_title = type == 'paper' ? 'ไม่สามารถอัพโหลดไฟล์ได้' : 'ไม่สามารถอัพโหลดรูปได้';

                    if(error == 'outType'){
                        error_text = type == 'paper' ? 'กรุณาเลือกเป็นไฟล์ .pdf เท่านั้น' : 'กรุณาเลือกเป็นไฟล์ .jpeg, .jpg, .png เท่านั้น';
                    } else if(error == 'outSize'){
                        error_text = 'กรุณาเลือกขนาดไฟล์ไม่เกิน '+ref.maxSize+' MiB.'
                    }

                    alert.show('warning',error_title,error_text);
                    return false;
                }
                
                uploadFile(setting,input,'input');

            break;
        }
    }
};

const uploadFile = (setting,input,handleBy) => {
    let formData = new FormData(),
        ref      = referance.find(el => el.input == input),
        handle   = handleBy == 'input' ? $(input)[0].files : setting.files,
        api_setting = {};        
    
    if(ref.path == 'paper'){
        $(ref.label).html(setSpinner('Uploading...'));
        $(ref.btn).prop('disabled',true);
    } else {
        $(ref.label.input).addClass('hide');
        $(ref.label.progress).removeClass('hide');
        $(ref.label.progress).html(setSpinner('Uploading...'));
    }

    $.each(handle,function(key,file){
        formData.append('files[]',file);
    });

    switch(ref.app){
        case 'awards/application': 
            formData.append('id',setting.id);
            formData.append('position',ref.position);
            formData.append('path',ref.path);
            api_setting.method = 'action';
            api_setting.url = ref.api;
            api_setting.data = formData;      
            
            api(api_setting).then(function(response){
                let res = response;

                if(res.result == 'error_login'){
                    alert.login();
                } else if(res.result == 'success'){
                    $.each(res.files,function(key,file){
                        register.formData[ref.pointer[0]][ref.pointer[1]].push(file);
                    });
                    
                    showFiles.tycoon(ref.input,register.formData[ref.pointer[0]][ref.pointer[1]]);
                } else {
                    alert.show(res.result,'ไม่สามารถอัพโหลดไฟล์ได้',res.message);
                }

                if(ref.path == 'paper'){
                    $(ref.label).html('Upload Files');
                    $(ref.btn).prop('disabled',false);
                } else {
                    $(ref.label.input).removeClass('hide');
                    $(ref.label.progress).addClass('hide');
                    $(ref.label.progress).html('');
                }
            });
        break;
        case 'awards/pre-screen':
            
            let answer = psc.questions[setting.cate].question[setting.seg];

            formData.append('qid',answer.id);
            formData.append('aid',!empty(answer.reply_id) ? answer.reply_id : '');
            formData.append('action',!empty(answer.reply_id) ? 'update' : 'create');
            formData.append('position',ref.position);
            formData.append('path',ref.path);
            api_setting.method = 'action';
            api_setting.url = ref.api;
            api_setting.data = formData;   
            
            api(api_setting).then(function(response){
                let res = response;

                if(res.result == 'error_login'){
                    alert.login();
                } else if(res.result == 'success'){
                    psc.questions[setting.cate].question[setting.seg][ref.position] = res.files;
                    showFiles.tycoon(ref.input,psc.questions[setting.cate].question[setting.seg][ref.position]);
                } else {
                    alert.show(res.result,'ไม่สามารถอัพโหลดไฟล์ได้',res.message);
                }

                if(ref.path == 'paper'){
                    $(ref.label).html('Upload Files');
                    $(ref.btn).prop('disabled',false);
                } else {
                    $(ref.label.input).removeClass('hide');
                    $(ref.label.progress).addClass('hide');
                    $(ref.label.progress).html('');
                }
            });
        break;
    }

}

const removeFile = (input,setting) => {
    let api_setting = {}, pointer,
        ref = referance.find(el => el.input == input);        
        
    $(ref.btnrm).prop('disabled',true);
    $(ref.btnrm).html(setSpinner('Removing...'));
    
    if($.inArray(ref.app,['awards/application','awards/pre-screen'])){        
        api_setting.method = 'post';

        if(ref.app == 'awards/application'){
            api_setting.url = '/inner-api/app/remove/file';
        } else if(ref.app == 'awards/pre-screen') {            
            pointer = psc.getPointer();
            setting.id = psc.questions[pointer.cate].question[pointer.seg].id;            
            api_setting.url = '/inner-api/answer/remove/file';
        }        
        
        setting.position = ref.position;
        api_setting.data = setting;

        api(api_setting).then(function(response){
            let res = response;

            if(res.result == 'error_login'){
                alert.login();
            } else if(res.result == 'success' && ref.app == 'awards/application'){
                if(setting.remove == 'fixed'){
                    register.formData[ref.pointer[0]][ref.pointer[1]] = [];
                    register.change[ref.pointer[1]] = 0;

                    $.each(res.files,function(key,file){
                        if(file.file_position == ref.position){
                            register.formData[ref.pointer[0]][ref.pointer[1]].push(file);
                            register.change[ref.pointer[1]]++;
                        }
                    });
                } else {
                    register.formData[ref.pointer[0]][ref.pointer[1]] = [];
                    register.change[ref.pointer[1]] = 0;
                }

                showFiles.tycoon(input,register.formData[ref.pointer[0]][ref.pointer[1]]);
            } else if(res.result == 'success' && ref.app == 'awards/pre-screen'){
                if(setting.remove == 'fixed'){
                    psc.questions[pointer.cate].question[pointer.seg][ref.position] = res.files;
                } else {
                    psc.questions[pointer.cate].question[pointer.seg][ref.position] = [];
                }

                showFiles.tycoon(input,psc.questions[pointer.cate].question[pointer.seg][ref.position]);
            } else {
                alert.show(res.result,'ไม่สามารถลบไฟล์ได้',res.message);
            }
            
            $(ref.btnrm).prop('disabled',false);
            $(ref.btnrm).html('Remove All');
        });
    }
}

const downloadFile = (input) => {
    let id, url, point,
        ref = referance.find(el => el.input == input);

    if(ref.app == 'awards/application'){
        id = register.id;
        url = getBaseUrl()+'/inner-api/app/download/file';
    } else if(ref.app == 'awards/pre-screen'){
        pointer = psc.getPointer();
        id = psc.questions[pointer.cate].question[pointer.seg].reply_id;
        url = getBaseUrl()+'/inner-api/answer/download/file';
    }

    url += '/'+id+'/'+ref.position;
    window.open(url,'_blank');
}

const showFiles = {
    tycoon: function(input,files){
        let ref = referance.find(el => el.input == input),
            html = '', layout;
            
        $.each(files,function(key,file){
            html += showFiles.setFile(input,file);
        });
        
        if(ref.path == 'images'){
            if(
                (ref.app == 'awards/application' && $.inArray(register.status,[1,4]) !== -1)
                || (ref.app == 'awards/pre-screen' && $.inArray(psc.status,['draft','reject']) !== -1)
            ){
                layout = ref.show;
            } else {
                layout = ref.ablum;
            }
        } else {
            layout = ref.show;
        }
        
        $(layout).html(html);
    },
    setFile(input,setting){
        let html, onclick, id, img,
            ref = referance.find(el => el.input == input);

        if(ref.app == 'awards/application'){ id = register.id; }
        
        if(
            $.inArray(ref.app,['awards/application','awards/pre-screen']) !== -1 
            && ref.path == 'paper'
        ){            
            onclick = 'onclick="removeFile(\''+input+'\',{';

            if(ref.app == 'awards/application'){
                onclick += 'id: '+id+','
            }

            onclick += "file_name: '"+setting.file_name+"',";
            onclick += "file_path: '"+setting.file_path+"',";
            onclick += 'remove: \'fixed\'})"';

            html = '<div class="col-12">';
            html += '   <div class="card card-body-muted">';
            html += '       <div class="bs-row">';   
            html += '           <div class="col-12">';
            html += '               <span class="fs-file-name">'+setting.file_original+' ';
            html += '               ('+setting.file_size+'MB)</span>';
            html += '               <a '+onclick+' class="fs-file-remove float-end" title="ลบไฟล์">';
            html += '                   <i class="bi bi-trash-fill"></i> ลบ';
            html += '               </a>';
            html += '           </div>';
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
        } else if(
            $.inArray(ref.app,['awards/application','awards/pre-screen']) !== -1 
            && ref.path == 'images'
        ){ 
            img = getBaseUrl()+'/'+setting.file_path;

            if(
                (ref.app == 'awards/application' && $.inArray(register.status,[1,4]) !== -1)
                || (ref.app == 'awards/pre-screen' && $.inArray(psc.status,['draft','reject']) !== -1)
            ){       
                onclick = 'href="javascript:removeFile(\''+input+'\',{';

                if(ref.app == 'awards/application'){
                    onclick += 'id: '+id+','
                }

                onclick += "file_name: '"+setting.file_name+"',";
                onclick += "file_path: '"+setting.file_path+"',";
                onclick += 'remove: \'fixed\'});"';                
                
                html = '<div class="card card-left mt-1 mb-1">';
                html += '   <img src="'+img+'" class="card-img-left">';
                html += '   <div class="card-body">';
                html += '       <div class="bs-row">';
                html += '           <span class="fs-file-name fw-semibold">'+setting.file_original+'</span>';
                html += '       </div>';
                html += '       <div class="bs-row">'; 
                html += '           <div class="col-12">';
                html += '               <span style="font-size: 14px;" class="text-muted">'+setting.file_size+'MB</span>';
                html += '               <a '+onclick+' class="fs-file-remove float-end" title="ลบไฟล์">';
                html += '                   <i class="bi bi-trash-fill"></i> ลบ';
                html += '               </a>';
                html += '           </div>';
                html += '       </div>';
                html += '   </div>';
                html += '</div>';
            } else {
                html = '<div class="ablumbox-col">';
                html += '    <div class="ablum-mainimg">';
                html += '        <div class="ablum-mainimg-scale">';
                html += '            <img src="'+img+'">';
                html += '       </div>';
                html += '   </div>';
                html += '</div>';
            }
        }

        return html;
    },
}

const resetFileInput = (input) => {
    let ele = $(input);
    ele.wrap('<form>').closest('form').get(0).reset();
    ele.unwrap();

}

let dropArea;

if($('#step1-images-drop').length > 0){
    dropArea = document.getElementById('step1-images-drop');
} else if($('#images-drop').length > 0){
    dropArea = document.getElementById('images-drop');
}

const preventDefaults = (e) => {
    e.preventDefault();
    e.stopPropagation();
}

const imagesDrop = (e) => {
    let dt = e.dataTransfer,
        files = dt.files
        id = '#'+e.target.id;
    handleDropImages(id,files);
}

const handleDropImages = (id,files) => {
    let temp = [], check = true, error, appId, total, pointer, setting,
        ref = referance.find(el => el.area == id || el.input == id);

    if(ref.app == 'awards/application'){
        total = Number(register.count[ref.pointer[1]]) + Number([...files].length);
    } else if(ref.app == 'awards/pre-screen'){
        pointer = psc.getPointer();
        let length = psc.questions[pointer.cate].question[pointer.seg][ref.position].length;
        total = Number(length) + Number([...files].length);
    }
        
    if(total > ref.maxUpload){
        alert.show('warning','ไม่สามารถอัพโหลดรูปได้','คุณสามารถอัพโหลดรูปได้ไม่เกิน '+ref.maxUpload+' ไฟล์เท่านั้น');
    }

    $.each([...files],function(key,file){
        if($.inArray(file.type,accept.images) !== '1'){
            let mb = (file.size / (1024 * 1024)).toFixed(2);

            if(mb > ref.maxSize){
                check = false; 
                error = 'outSize';
            } else {                
                temp.push(file);
            }
        } else {
            check = false;
            error = 'outType';
            return false;
        }
    });

    if(!check){
        let error_title, error_text;   
        error_title = 'ไม่สามารถอัพโหลดรูปได้';  

        if(error == 'outType'){
            error_text = 'กรุณาเลือกเป็นไฟล์ .jpeg, .jpg, .png เท่านั้น';
        } else if(error == 'outSize'){
            error_text = 'กรุณาเลือกขนาดไฟล์ไม่เกิน '+ref.maxSize+' MiB.'
        }

        alert.show('warning',error_title,error_text);
        return false;
    }

    if(ref.app == 'awards/application'){
        setting = {id: register.id, files: temp};
    } else if(ref.app == 'awards/pre-screen'){
        setting = pointer;
        setting.files = temp;
    }

    uploadFile(setting,ref.input,'drop');
}

;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, preventDefaults, false);
});  

dropArea.addEventListener('drop', imagesDrop, false);

const accept = {
    paper: ['application/pdf'],
    images: ['image/jpg','image/jpeg','image/png']
};

const referance = [
    { 
        input: '#step1-paper', pointer: ['step1','paper'],
        btn: '#step1-paper-btn', btnrm: '#step1-paper-remove',
        show: '#step1-paper-list', label: '#step1-paper-label',
        api: '/inner-api/app/upload', position: 'paperFiles',
        path: 'paper', app: 'awards/application',
        maxUpload: 5, maxSize: 15
    },
    { 
        input: '#step1-detail', pointer: ['step1','detail'],
        btn: '#step1-detail-btn', btnrm: '#step1-detail-remove',
        show: '#step1-detail-list', label: '#step1-detail-label',
        api: '/inner-api/app/upload', position: 'detailFiles',
        path: 'paper', app: 'awards/application',
        maxUpload: 5, maxSize: 15
    },
    { 
        input: '#step1-images', area: '#step1-images-input',
        pointer: ['step1','images'],
        btn: '#step1-images-btn', btnrm: '#step1-images-remove',
        show: '#step1-images-list', ablum: '#step1-images-ablum', 
        label: {
            input: '#step1-images-input',
            progress: '#step1-images-progress'
        },
        api: '/inner-api/app/upload', position: 'registerImages',
        path: 'images', app: 'awards/application',
        maxUpload: 10, maxSize: 10
    },
    {
        input: '#step5-landOwner', pointer: ['step5','landOwner'],
        btn: '#step5-landOwner-btn', btnrm: '#step5-landOwner-remove',
        show: '#step5-landOwner-list', label: '#step5-landOwner-label',
        api: '/inner-api/app/upload', position: 'landOwnerFiles',
        path: 'paper', app: 'awards/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-businessCert', pointer: ['step5','businessCert'],
        btn: '#step5-businessCert-btn', btnrm: '#step5-businessCert-remove',
        show: '#step5-businessCert-list', label: '#step5-businessCert-label',
        api: '/inner-api/app/upload', position: 'businessCertFiles',
        path: 'paper', app: 'awards/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-otherCert', pointer: ['step5','otherCert'],
        btn: '#step5-otherCert-btn', btnrm: '#step5-otherCert-remove',
        show: '#step5-otherCert-list', label: '#step5-otherCert-label',
        api: '/inner-api/app/upload', position: 'otherCertFiles',
        path: 'paper', app: 'awards/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-bussLicenseFiles', pointer: ['step5','bussLicenseFiles'],
        btn: '#step5-bussLicenseFiles-btn', btnrm: '#step5-bussLicenseFiles-remove',
        show: '#step5-bussLicenseFiles-list', label: '#step5-bussLicenseFiles-label',
        api: '/inner-api/app/upload', position: 'bussLicenseFiles',
        path: 'paper', app: 'awards/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-EIAreport', pointer: ['step5','EIAreport'],
        btn: '#step5-EIAreport-btn', btnrm: '#step5-EIAreport-remove',
        show: '#step5-EIAreport-list', label: '#step5-EIAreport-label',
        api: '/inner-api/app/upload', position: 'EIAreportFiles',
        path: 'paper', app: 'awards/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-otherT2Cert', pointer: ['step5','otherT2Cert'],
        btn: '#step5-otherT2Cert-btn', btnrm: '#step5-otherT2Cert-remove',
        show: '#step5-otherT2Cert-list', label: '#step5-otherT2Cert-label',
        api: '/inner-api/app/upload', position: 'otherT2CertFiles',
        path: 'paper', app: 'awards/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-spaCert', pointer: ['step5','spaCert'],
        btn: '#step5-spaCert-btn', btnrm: '#step5-spaCert-remove',
        show: '#step5-spaCert-list', label: '#step5-spaCert-label',
        api: '/inner-api/app/upload', position: 'spaCertFiles',
        path: 'paper', app: 'awards/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-effluent', pointer: ['step5','effluent'],
        btn: '#step5-effluent-btn', btnrm: '#step5-effluent-remove',
        show: '#step5-effluent-list', label: '#step5-effluent-label',
        api: '/inner-api/app/upload', position: 'effluentFiles',
        path: 'paper', app: 'awards/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-wellnessCert', pointer: ['step5','wellnessCert'],
        btn: '#step5-wellnessCert-btn', btnrm: '#step5-wellnessCert-remove',
        show: '#step5-wellnessCert-list', label: '#step5-wellnessCert-label',
        api: '/inner-api/app/upload', position: 'wellnessCertFiles',
        path: 'paper', app: 'awards/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-spaManger', pointer: ['step5','spaManger'],
        btn: '#step5-spaManger-btn', btnrm: '#step5-spaManger-remove',
        show: '#step5-spaManger-list', label: '#step5-spaManger-label',
        api: '/inner-api/app/upload', position: 'spaMangerFiles',
        path: 'paper', app: 'awards/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-titleDeed', pointer: ['step5','titleDeed'],
        btn: '#step5-titleDeed-btn', btnrm: '#step5-titleDeed-remove',
        show: '#step5-titleDeed-list', label: '#step5-titleDeed-label',
        api: '/inner-api/app/upload', position: 'titleDeedFiles',
        path: 'paper', app: 'awards/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-outlander', pointer: ['step5','outlander'],
        btn: '#step5-outlander-btn', btnrm: '#step5-outlander-remove',
        show: '#step5-outlander-list', label: '#step5-outlander-label',
        api: '/inner-api/app/upload', position: 'outlanderFiles',
        path: 'paper', app: 'awards/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-guideCert', pointer: ['step5','guideCert'],
        btn: '#step5-guideCert-btn', btnrm: '#step5-guideCert-remove',
        show: '#step5-guideCert-list', label: '#step5-guideCert-label',
        api: '/inner-api/app/upload', position: 'guideCertFiles',
        path: 'paper', app: 'awards/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-titleDeedT4', pointer: ['step5','titleDeedT4'],
        btn: '#step5-titleDeedT4-btn', btnrm: '#step5-titleDeedT4-remove',
        show: '#step5-titleDeedT4-list', label: '#step5-titleDeedT4-label',
        api: '/inner-api/app/upload', position: 'gtitleDeedT4Files',
        path: 'paper', app: 'awards/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-otherT4Cert', pointer: ['step5','otherT4Cert'],
        btn: '#step5-otherT4Cert-btn', btnrm: '#step5-otherT4Cert-remove',
        show: '#step5-otherT4Cert-list', label: '#step5-otherT4Cert-label',
        api: '/inner-api/app/upload', position: 'otherT4CertFiles',
        path: 'paper', app: 'awards/application',
        maxUpload: 5, maxSize: 15
    },
    { 
        input: '#images', area: '#images-input',
        pointer: ['','images'],
        btn: '#images-btn', btnrm: '#images-remove',
        show: '#images-list', ablum: '#images-ablum', 
        label: {
            input: '#images-input',
            progress: '#images-progress'
        },
        api: '/inner-api/answer/upload', position: 'images',
        path: 'images', app: 'awards/pre-screen',
        maxUpload: 10, maxSize: 10
    },
    {
        input: '#file', pointer: ['','paper'],
        btn: '#file-btn', btnrm: '#file-remove',
        show: '#file-list', label: '#file-label',
        api: '/inner-api/answer/upload', position: 'paper',
        path: 'paper', app: 'awards/pre-screen',
        maxUpload: 5, maxSize: 15
    },
];