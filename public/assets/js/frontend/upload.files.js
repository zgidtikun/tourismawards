const onFileHandle = (setting,input,type) => {
    let handle  = $(input)[0].files,
        filter  = accept[type],
        ref     = referance.find(el => el.input == input),
        error   = null,
        check   = true;
        
    if(handle.length > 0){
        switch(ref.app){
            case 'frontend/application': 
            
                if(
                    type == 'paper' 
                    && (register.formData[ref.pointer[0]][ref.pointer[1]].length + handle.length) > ref.maxUpload
                ){
                    alert.show('warning','ไม่สามารถอัพโหลดไฟล์ได้','คุณสามารถอัพโหลดไฟล์ได้ไม่เกิน 5 ไฟล์เท่านั้น');
                    resetFileInput(input);
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
                    if(error == 'outType'){
                        if(type == 'paper' ){
                            alert.show('warning','ไม่สามารถอัพโหลดไฟล์ได้','กรุณาเลือกเป็นไฟล์ .pdf เท่านั้น');
                        }
                    } else if(error == 'outSize'){
                        if(type == 'paper' ){
                            alert.show('warning','กรุณาเลือกขนาดไฟล์ไม่เกิน .. MiB.');
                        }
                    }
                    return false;
                }
                
                uploadFile({id: setting.id},input);

            break;
        }
    }
};

const uploadFile = (setting,input) => {
    let formData = new FormData(),
        ref      = referance.find(el => el.input == input),
        handle   = $(input)[0].files,
        api_setting = {};

    formData.append('id',setting.id);

    $.each(handle,function(key,file){
        formData.append('files[]',file);
    });

    switch(ref.app){
        case 'frontend/application': 
            $(ref.label).html(setSpinner('Uploading...'));
            $(ref.btn).prop('disabled',true);

            formData.append('position',ref.position);
            formData.append('path',ref.path);
            api_setting.method = 'action';
            api_setting.url = ref.api;
            api_setting.data = formData;         
            
            api(api_setting).then(function(response){
                let res = response;

                if(save.result == 'error_login'){
                    alert.login();
                } else if(res.result == 'success'){
                    register.formData[ref.pointer[0]][ref.pointer[1]] = res.files;
                    showFiles.registerPaper(input,res.files);
                } else {
                    alert.show(res.result,'ไม่สามารถอัพโหลดไฟล์ได้',res.message);
                }

                $(ref.label).html('Upload Files');
                $(ref.btn).prop('disabled',false);
            });
        break;
    }

}

const removeFile = (input,setting) => {
    let api_setting, ref;

    if($.inArray(input,['#step1-paper'])){
        ref = referance.find(el => el.input == input),
        api_setting = setting;
        api_setting.method = 'post';
        api_setting.url = '/frontend/app/remove/file';

        api(api_setting).then(function(response){
            let res = response;

            if(save.result == 'error_login'){
                alert.login();
            } else if(res.result == 'success'){
                register.formData[ref.pointer[0]][ref.pointer[1]] = res.files;
                showFiles.registerPaper(input,res.files);
            } else {
                alert.show(res.result,'ไม่สามารถลบไฟล์ได้',res.message);
            }
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
        let html, onclick, id;

        switch(input){
            case '#step1-paper':
                id = register.id;
                onclick = 'onclick="removeFile(\''+input+'\',{id: '+id+',';
                onclick += "file_name: '"+setting.file_name+"',";
                onclick += "file_path: '"+setting.file_path+"',";
                onclick += 'remove: \'fixed\'})"';

                html = '<div class="col-12">';
                html += '<div class="card card-body-muted"><div class="bs-row">';
                html += '<div class="col-xs-12 col-sm-12 col-md-10 col-xl-10">';
                html += '<span class="fs-file-name">'+setting.file_original+' ';
                html += '('+setting.file_size+'MB)</span>';
                html += '</div>';
                html += '<div class="col-xs-12 col-sm-12 col-md-2 col-xl-2 d-flex justify-content-end">';
                html += '<button type="button" class="btn btn-close" '+onclick+'></button>';
                html += '</div></div></div></div>';
            break;
        }

        return html;
    },
}

const resetFileInput = (input) => {
    let ele = $(input);
    ele.wrap('<form>').closest('form').get(0).reset();
    ele.unwrap();

}

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
    }
];