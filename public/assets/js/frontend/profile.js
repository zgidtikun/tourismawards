const mf = [    
    { ip: '#p-prefix', id: 'p-prefix', iv: '', ps: 'form', api: 'prefix' },
    { ip: '#p-name', id: 'p-name', iv: '#nvalid-p-name', ps: 'form', api: 'name' },
    { ip: '#p-surname', id: 'p-surname', iv: '#nvalid-p-surname', ps: 'form', api: 'surname' },
    { ip: '#p-mobile', id: 'p-mobile', iv: '#nvalid-p-mobile', ps: 'form', api: 'mobile' },
    { ip: '#p-email', id: 'p-email', iv: '#nvalid-p-email', ps: 'form', api: 'email' },
    { ip: '#p-uimage', id: 'p-uimage', src: '#p-image', ps: 'file', s: 10 },
];

const getId = () => {
    return $('.container').attr('data-sess-id');
};

const pf = {
    save(){
        if(this.validation()){
            let st = {
                method: 'action',
                url: '/inner-api/profile/update',
            }

            let fd = new FormData();
            fd.append('id',getId());

            $.each(mf, function(k,v){
                if(v.ps == 'form'){
                    fd.append('profile['+v.api+']',$(v.ip).val());
                }
            });

            st.data = fd;

            api(st).then(function(r){
                let s = r;

                if(s.result == 'error_login'){
                    alert.login();
                } else if(s.result == 'success'){
                    alert.show(s.result,'อัพเดทข้อมูลเรียบร้อยแล้ว','').then(function(a){
                        window.location.reload();
                    });
                } else {
                    alert.show(s.result,'ไม่สามารถอัพเดทข้อมูลได้',s.message);
                }
            });
        }
    },
    validation(){
        const iv = true;

        $.each(mf, function(k, m){
            if(m.ps == 'form'){
                if(empty($(m.ip).val())){
                    if(!$(m.ip).hasClass('is-invalid'))
                        $(m.ip).addClass('is-invalid');
                    iv = false;
                } else {
                    $(m.ip).removeClass('is-invalid');
                }
            }
        });

        return iv;
    }
};

const onFileHandel = (id) => {
    const a = ['image/jpg','image/jpeg','image/png'];
    const s = mf.find(el => el.id == id);
    const h = $(s.ip)[0].files[0];
    
    if(!empty(h)){
        const mb = (h.size / (1024 * 1024)).toFixed(2);
        
        if(mb > s.s){
            alert.show('error','ไม่สามารถอัพโหลดรูปได้','ขนาดไฟล์ไม่เกิน '+s.s+' เท่านั้น');
            return;
        }

        if($.inArray(h.type,a) === -1){
            alert.show('error','ไม่สามารถอัพโหลดรูปได้','กรุณาเลือกเป็นไฟล์ .jpeg, .jpg, .png เท่านั้น');
        }

        let fd = new FormData();
        fd.append('id',getId());
        fd.append('image[]',h);

        let st = {
            method: 'action',
            url: '/inner-api/profile/upload/image',
            data: fd
        }

        api(st).then(function(r){
            let ul = r;

            if(ul.result == 'error_login'){
                alert.login();
            } else if(ul.result == 'success'){
                $(s.src).attr('src',ul.link);
            } else {
                alert.show(ul.result,'ไม่สามารถอัพโหลดรูปได้',ul.message);
            }
        });
    }
}