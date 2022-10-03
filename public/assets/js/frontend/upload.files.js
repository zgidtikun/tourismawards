const onFileHandle = (setting,input,type) => {
    let handle  = $(id)[0].files,
        filter  = accept[type],
        ref     = referance.find(el => el.input == input),
        error   = null,
        check   = true;

    if(handle > 0){
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
                        alert.show('warning','ไม่สามารถอัพโหลดไฟล์ได้','กรุณาเลือกเป็นไฟล์ .pdf เท่านั้น');
                    } else if(error == 'outSize'){
                        alert.show('warning','กรุณาเลือกขนาดไฟล์ไม่เกิน .. MiB.');
                    }
                    return false;
                }

                uploadFile({id: id},input);

            break;
        }
    }
};

const resetFileInput = (input) => {
    let ele = $(input);
    ele.wrap('<form>').closest('form').get(0).reset();
    ele.unwrap();

}

const uploadFile = (setting,input) => {
    let formData = new FormData(),
        ref      = referance.find(el => el.input == input),
        handle   = $(id)[0].files,
        api      = {};

    formData.append('id',empty(setting.data));

    $.each(handle,function(key,file){
        formData.append('files[]',file);
    });

    switch(ref.app){
        case 'frontend/application': 
            formData.append('position',ref.position);
            formData.append('path',ref.path);
            api.method = 'action';
            api.url = ref.api;
            api.data = formData;
        break;
    }

    api(api).then(function(response){
        let res = response;
    });

}

const showFiles = {
    registerPaper(input,files){

    },
    setFile(input){
        switch(input){
            case '#step1-paper':

            break;
        }
    },
}

const accept = {
    paper: ['application/pdf'],
    images: ['image/jpg','image/jpeg','image/png']
};

const referance = [
    { 
        input: '#step1-paper', pointer: ['step1','paper'],
        label: 'step1-paper-label', position: 'paperFiles',
        api: 'frontend/app/upload',
        path: 'paper', app: 'frontend/application',
        maxUpload: 5, maxSize: 15
    }
];