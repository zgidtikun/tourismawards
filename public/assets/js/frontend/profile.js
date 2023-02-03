const mapField = [    
    { ip: '#p-prefix', id: 'p-prefix', iv: '', ps: 'form', api: 'prefix', validate: true },
    { ip: '#p-name', id: 'p-name', iv: '#nvalid-p-name', ps: 'form', api: 'name', validate: true },
    { ip: '#p-surname', id: 'p-surname', iv: '#nvalid-p-surname', ps: 'form', api: 'surname', validate: true },
    { ip: '#p-mobile', id: 'p-mobile', iv: '#nvalid-p-mobile', ps: 'form', api: 'mobile', validate: true },
    { ip: '#p-uimage', id: 'p-uimage', src: '#p-image', ps: 'file', size: 10 },
];

const getId = () => {
    return $('.container').attr('data-sess-id');
};

const save = async() => {
    if(validation()){
        const setting = {
            method: 'post',
            url: '/inner-api/profile/update',
            data : {
                profile: {}
            }
        }

        $.each(mapField, (key,map) => {
            if(map.ps == 'form'){
                setting.data.profile[map.api] = $(map.ip).val();
            }
        });
        
        const callback = await api(setting);        

        if(callback.result == 'error_login'){
            alert.login();
        } 
        else {
            const title = callback.result == 'success' ? 'อัพเดทข้อมูลเรียบร้อยแล้ว' : 'ไม่สามารถอัพเดทข้อมูลได้';
            const text = callback.result == 'success' ? '' : callback.message;
            alert.show(callback.result,title,text);
        }

    }
}

const validation = () => {
    let valid = true;

    $.each(mapField, (key, map) => {
        if(map.ps == 'form' && map.validate){
            if(empty($(map.ip).val())){
                $(map.ip).addClass('is-invalid');
                valid = false;
            }
        }
    });

    return valid;
}

const onFileHandel = async(id) => {
    const accept = ['image/jpg','image/jpeg','image/png'];
    const map = mapField.find(el => el.id == id);
    const handel = $(map.ip)[0].files[0];
    
    if(!empty(handel)){
        const mb = (handel.size / (1024 * 1024)).toFixed(2);
        
        if(mb > map.size){
            alert.show('error','ไม่สามารถอัพโหลดรูปได้','ขนาดไฟล์ไม่เกิน '+s.s+'MB เท่านั้น');
            return;
        }

        if($.inArray(handel.type,accept) === -1){
            alert.show('error','ไม่สามารถอัพโหลดรูปได้','กรุณาเลือกเป็นไฟล์ .jpeg, .jpg, .png เท่านั้น');
            return;
        }

        const formData = new FormData();
        formData.append('id',getId());
        formData.append('image[]',handel);

        const setting = {
            method: 'action',
            url: '/inner-api/profile/upload/image',
            data: formData
        }

        const callback = await api(setting);

        if(callback.result == 'error_login'){
            alert.login();
        } 
        else if(callback.result == 'success'){
            $('#header-img-profile').attr('src',callback.link);
            $(map.src).attr('src',callback.link);
        } 
        else {
            alert.show(callback.result,'ไม่สามารถอัพโหลดรูปได้',callback.message);
        }
    }
}