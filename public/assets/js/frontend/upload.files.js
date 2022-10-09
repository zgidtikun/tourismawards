const onFileHandle = (setting,input,type) => {
    let handle  = $(input)[0].files,
        filter  = accept[type],
        ref     = referance.find(el => el.input == input),
        error   = null,
        check   = true;
        
    if(handle.length > 0){
        switch(ref.app){
            case 'frontend/application': 
            
                if(Number(register.count[ref.pointer[1]]) + Number(handle.length) > ref.maxUpload){
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
                
                uploadFile({id: setting.id},input,'input');

            break;
        }
    }
};

const uploadFile = (setting,input,handleBy) => {
    let formData = new FormData(),
        ref      = referance.find(el => el.input == input),
        handle   = handleBy == 'input' ? $(input)[0].files : setting.files,
        api_setting = {};
        
    formData.append('id',setting.id);

    $.each(handle,function(key,file){
        formData.append('files[]',file);
    });

    switch(ref.app){
        case 'frontend/application': 
            if(ref.path == 'paper'){
                $(ref.label).html(setSpinner('Uploading...'));
                $(ref.btn).prop('disabled',true);
            } else {
                $(ref.label.input).addClass('hide');
                $(ref.label.progress).removeClass('hide');
                $(ref.label.progress).html(setSpinner('Uploading...'));
            }

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
                    register.formData[ref.pointer[0]][ref.pointer[1]] = res.files;
                    showFiles.registerPaper(ref.input,res.files);
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
    let api_setting = {}, ref;
    
    if($.inArray(input,['#step1-images','#step1-detail','#step1-paper']) !== -1){
        ref = referance.find(el => el.input == input),
        api_setting.data = setting;
        api_setting.method = 'post';
        api_setting.url = '/frontend/app/remove/file';

        if(setting.remove == 'all'){
            api_setting.data.position = ref.position;
        }
        
        $(ref.btnrm).prop('disabled',true);
        $(ref.btnrm).html(setSpinner('Removing...'));

        api(api_setting).then(function(response){
            let res = response;

            if(res.result == 'error_login'){
                alert.login();
            } else if(res.result == 'success'){
                register.formData[ref.pointer[0]][ref.pointer[1]] = res.files;
                showFiles.registerPaper(input,res.files);
            } else {
                alert.show(res.result,'ไม่สามารถลบไฟล์ได้',res.message);
            }
            
            $(ref.btnrm).prop('disabled',false);
            $(ref.btnrm).html('Remove All');
        });
    }
}

const showFiles = {
    registerPaper(input,files){

        let ref = referance.find(el => el.input == input),
            html = '';
            
        $.each(files,function(key,file){
            html += showFiles.setFile(input,file);
        });
        
        $(ref.show).html(html);
    },
    setFile(input,setting){
        let html, onclick, id, img,
            ref = referance.find(el => el.input == input);

        if(ref.app = 'frontend/application') id = register.id;
        
        if(ref.app = 'frontend/application' && path == 'paper'){
            onclick = 'onclick="removeFile(\''+input+'\',{id: '+id+',';
            onclick += "file_name: '"+setting.file_name+"',";
            onclick += "file_path: '"+setting.file_path+"',";
            onclick += 'remove: \'fixed\'})"';

            html = '<div class="col-12">';
            html += '   <div class="card card-body-muted"><div class="bs-row">';                
            html += '       <div class="bs-row">';
            html += '           <div class="col-xs-12 col-sm-12 col-md-10 col-xl-10">';
            html += '               <span class="fs-18 fs-file-name">'+setting.file_original+' ';
            html += '               ('+setting.file_size+'MB)</span>';
            html += '           </div>';
            html += '           <div class="col-xs-12 col-sm-12 col-md-2 col-xl-2 d-flex justify-content-end">';
            html += '               <button type="button" class="btn btn-close" '+onclick+'></button>';
            html += '           </div>';
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
        } else if(ref.app = 'frontend/application' && path == 'images'){            
            onclick = 'href="javascript:removeFile(\''+input+'\',{id: '+id+',';
            onclick += "file_name: '"+setting.file_name+"',";
            onclick += "file_path: '"+setting.file_path+"',";
            onclick += 'remove: \'fixed\'});"';
            
            img = getBaseUrl()+'/'+setting.file_path;
            html = '<div class="card card-left mt-1 mb-1">';
            html += '   <img src="'+img+'" class="card-img-left">';
            html += '   <div class="card-body">';
            html += '       <div class="bs-row">';
            html += '           <span class="fw-semibold">'+setting.file_original+'<span>';
            html += '       </div>';
            html += '       <div class="bs-row">';
            html += '           <span style="font-size: 14px;" class="text-muted">'+setting.file_size+'MB<span>';
            html += '           <a '+onclick+' class="text-danger float-end" title="ลบไฟล์">';
            html += '               <i class="bi bi-trash-fill"></i> ลบ';
            html += '           </a>';
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
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
    let temp = [], check = true, error, appId,
        ref = referance.find(el => el.area == id || el.input == id);
        
    if((Number(register.count[ref.pointer[1]]) + Number([...files].length)) > ref.maxUpload){
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

    if(ref.app == 'frontend/application')
        appId = register.id;

    uploadFile({id: appId, files: temp},ref.input,'drop');
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
        api: '/frontend/app/upload', position: 'paperFiles',
        path: 'paper', app: 'frontend/application',
        maxUpload: 5, maxSize: 15
    },
    { 
        input: '#step1-detail', pointer: ['step1','detail'],
        btn: '#step1-detail-btn', btnrm: '#step1-detail-remove',
        show: '#step1-detail-list', label: '#step1-detail-label',
        api: '/frontend/app/upload', position: 'detailFiles',
        path: 'paper', app: 'frontend/application',
        maxUpload: 5, maxSize: 15
    },
    { 
        input: '#step1-images', area: '#step1-images-input',
        pointer: ['step1','images'],
        btn: '#step1-images-btn', btnrm: '#step1-images-remove',
        show: '#step1-detail-list', label: {
            input: '#step1-images-input',
            progress: '#step1-images-progress'
        },
        api: '/frontend/app/upload', position: 'registerImages',
        path: 'images', app: 'frontend/application',
        maxUpload: 5, maxSize: 10
    },
    {
        input: '#step5-landOwner', pointer: ['step5','landOwner'],
        btn: '#step5-landOwner-btn', btnrm: '#step5-landOwner-remove',
        show: '#step5-landOwner-list', label: '#step5-landOwner-label',
        api: '/frontend/app/upload', position: 'landOwnerFiles',
        path: 'paper', app: 'frontend/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-businessCert', pointer: ['step5','businessCert'],
        btn: '#step5-businessCert-btn', btnrm: '#step5-businessCert-remove',
        show: '#step5-businessCert-list', label: '#step5-businessCert-label',
        api: '/frontend/app/upload', position: 'businessCertFiles',
        path: 'paper', app: 'frontend/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-otherCert', pointer: ['step5','otherCert'],
        btn: '#step5-otherCert-btn', btnrm: '#step5-otherCert-remove',
        show: '#step5-otherCert-list', label: '#step5-otherCert-label',
        api: '/frontend/app/upload', position: 'otherCertFiles',
        path: 'paper', app: 'frontend/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-bussLicense', pointer: ['step5','bussLicense'],
        btn: '#step5-bussLicense-btn', btnrm: '#step5-bussLicense-remove',
        show: '#step5-bussLicense-list', label: '#step5-bussLicense-label',
        api: '/frontend/app/upload', position: 'bussLicenseFiles',
        path: 'paper', app: 'frontend/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-EIAreport', pointer: ['step5','EIAreport'],
        btn: '#step5-EIAreport-btn', btnrm: '#step5-EIAreport-remove',
        show: '#step5-EIAreport-list', label: '#step5-EIAreport-label',
        api: '/frontend/app/upload', position: 'EIAreportFiles',
        path: 'paper', app: 'frontend/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-otherT2Cert', pointer: ['step5','otherT2Cert'],
        btn: '#step5-otherT2Cert-btn', btnrm: '#step5-otherT2Cert-remove',
        show: '#step5-otherT2Cert-list', label: '#step5-otherT2Cert-label',
        api: '/frontend/app/upload', position: 'otherT2CertFiles',
        path: 'paper', app: 'frontend/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-spaCert', pointer: ['step5','spaCert'],
        btn: '#step5-spaCert-btn', btnrm: '#step5-spaCert-remove',
        show: '#step5-spaCert-list', label: '#step5-spaCert-label',
        api: '/frontend/app/upload', position: 'spaCertFiles',
        path: 'paper', app: 'frontend/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-effluent', pointer: ['step5','effluent'],
        btn: '#step5-effluent-btn', btnrm: '#step5-effluent-remove',
        show: '#step5-effluent-list', label: '#step5-effluent-label',
        api: '/frontend/app/upload', position: 'effluentFiles',
        path: 'paper', app: 'frontend/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-wellnessCert', pointer: ['step5','wellnessCert'],
        btn: '#step5-wellnessCert-btn', btnrm: '#step5-wellnessCert-remove',
        show: '#step5-wellnessCert-list', label: '#step5-wellnessCert-label',
        api: '/frontend/app/upload', position: 'wellnessCertFiles',
        path: 'paper', app: 'frontend/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-spaManger', pointer: ['step5','spaManger'],
        btn: '#step5-spaManger-btn', btnrm: '#step5-spaManger-remove',
        show: '#step5-spaManger-list', label: '#step5-spaManger-label',
        api: '/frontend/app/upload', position: 'spaMangerFiles',
        path: 'paper', app: 'frontend/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-titleDeed', pointer: ['step5','titleDeed'],
        btn: '#step5-titleDeed-btn', btnrm: '#step5-titleDeed-remove',
        show: '#step5-titleDeed-list', label: '#step5-titleDeed-label',
        api: '/frontend/app/upload', position: 'titleDeedFiles',
        path: 'paper', app: 'frontend/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-outlander', pointer: ['step5','outlander'],
        btn: '#step5-outlander-btn', btnrm: '#step5-outlander-remove',
        show: '#step5-outlander-list', label: '#step5-outlander-label',
        api: '/frontend/app/upload', position: 'outlanderFiles',
        path: 'paper', app: 'frontend/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-guideCert', pointer: ['step5','guideCert'],
        btn: '#step5-guideCert-btn', btnrm: '#step5-guideCert-remove',
        show: '#step5-guideCert-list', label: '#step5-guideCert-label',
        api: '/frontend/app/upload', position: 'guideCertFiles',
        path: 'paper', app: 'frontend/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-titleDeedT4', pointer: ['step5','titleDeedT4'],
        btn: '#step5-titleDeedT4-btn', btnrm: '#step5-titleDeedT4-remove',
        show: '#step5-titleDeedT4-list', label: '#step5-titleDeedT4-label',
        api: '/frontend/app/upload', position: 'gtitleDeedT4Files',
        path: 'paper', app: 'frontend/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-otherT4Cert', pointer: ['step5','otherT4Cert'],
        btn: '#step5-otherT4Cert-btn', btnrm: '#step5-otherT4Cert-remove',
        show: '#step5-otherT4Cert-list', label: '#step5-otherT4Cert-label',
        api: '/frontend/app/upload', position: 'otherT4CertFiles',
        path: 'paper', app: 'frontend/application',
        maxUpload: 5, maxSize: 15
    },
];