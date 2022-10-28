const alert = {
    initToast: function(){
        const init = Swal.mixin({
            toast: true,
            showConfirmButton: false,
            position: 'top-end',
            customClass: {
                container: 'toast-absolute'
            },
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        return init;
    },
    initBootstrap: function(mode){
        let css;

        switch(mode){
            case 'confirm-main':
                css = {
                    confirmButton: 'btn btn-confirm-submit',
                    cancelButton: 'btn btn-confirm-cancel mr-3'
                }                
            break;
            default:  
                css = {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-danger mr-3'
                }
            break;
        }

        const init = Swal.mixin({
            customClass: css,
            buttonsStyling: false
        });                
        return init;
    },
    login: function(){        
        Swal.fire({
            icon: 'error',
            title: 'หมดเวลาการเข้าสู่ระบบ',
            html: 'เวลาการเข้าสู่ระบบของคุณหมดลงแล้ว<br>กรุณาเข้าสู่ระบบใหม่',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'เข้าสู่ระบบ',
        }).then((result) => {
            let origin = window.location.origin;
            window.location.href =  origin+'/login';
        });
    },
    toast: function(setting){
        let init = this.initToast();
        init.fire({
            icon: setting.icon,
            title: setting.title
        });
    },
    show: async function(icon,title,text = ''){     
        return new Promise(function(resolve){       
            Swal.fire({
                icon: icon,
                title: title,
                html: text,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ตกลง',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            }).then((result) => {
                resolve({status: true});
            });
        });
    },
    confirm: async function(setting){
        return new Promise(function(resolve){
            let init = alert.initBootstrap(setting.mode);
            init.fire({
                icon: setting.icon,
                title: setting.title,
                html: setting.text,
                showCancelButton: true,
                confirmButtonText: setting.button.confirm,
                cancelButtonText: setting.button.cancel,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    resolve({status: true});
                } else {
                    resolve({status: false});
                }
            });
        });
    },
}