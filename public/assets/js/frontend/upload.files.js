const onFileHandle = (setting, input, type) => {
    let handle = $(input)[0].files,
        filter = accept[type],
        ref = referance.find(el => el.input == input),
        check = true,
        error, total;
        
    if (handle.length > 0) {
        switch (ref.app) {
            case 'awards/application':
            case 'awards/pre-screen':
            case 'estimate/onsite':

                if (ref.app == 'awards/application') {
                    total = Number(register.count[ref.pointer[1]]) + Number(handle.length);
                } else if (ref.app == 'awards/pre-screen') {
                    let length = psc.questions[setting.cate].question[setting.seg][ref.position].length;
                    total = Number(length) + Number(handle.length);
                } else if (ref.app == 'estimate/onsite') {
                    let length = dataset[setting.cate].question[setting.seg].estFiles[ref.position].length;
                    total = Number(length) + Number(handle.length);
                }

                if (total > ref.maxUpload) {
                    alert.show('warning', 'ไม่สามารถอัพโหลดไฟล์ได้', 'คุณสามารถอัพโหลดไฟล์ได้ไม่เกิน ' + ref.maxUpload + ' ไฟล์เท่านั้น');
                    return false
                }

                $.each(handle, function(key, val) {
                    let mb = (val.size / (1024 * 1024)).toFixed(2);

                    if ($.inArray(val.type, filter) === -1) {
                        check = false;
                        error = 'outType';
                        return false;
                    }

                    if (mb > ref.maxSize) {
                        check = false;
                        error = 'outSize';
                        return false
                    }
                });

                if (!check) {
                    let error_title, error_text;
                    error_title = type == 'paper' ? 'ไม่สามารถอัพโหลดไฟล์ได้' : 'ไม่สามารถอัพโหลดรูปได้';

                    if (error == 'outType') {
                        error_text = type == 'paper' ? 'กรุณาเลือกเป็นไฟล์ .pdf เท่านั้น' : 'กรุณาเลือกเป็นไฟล์ .jpeg, .jpg, .png เท่านั้น';
                    } else if (error == 'outSize') {
                        error_text = 'กรุณาเลือกขนาดไฟล์ไม่เกิน ' + ref.maxSize + ' MiB.'
                    }

                    alert.show('warning', error_title, error_text);
                    return false;
                }

                uploadFile(setting, input, 'input');

                break;
        }
    }
};

const uploadFile = (setting, input, handleBy) => {
    let formData = new FormData(),
        ref = referance.find(el => el.input == input),
        handle = handleBy == 'input' ? $(input)[0].files : setting.files,
        api_setting = {},
        label_html;

    if (ref.path == 'paper' || ref.position == 'camera') {
        label_html = $(ref.label).html();
        $(ref.label).html(setSpinner('Uploading...'));
        $(ref.btn).prop('disabled', true);
    } else {
        $(ref.label.input).addClass('hide');
        $(ref.label.progress).removeClass('hide');
        $(ref.label.progress).html(setSpinner('Uploading...'));
    }

    $.each(handle, function(key, file) {
        formData.append('files[]', file);
    });

    switch (ref.app) {
        case 'awards/application':
            formData.append('id', setting.id);
            formData.append('position', ref.position);
            formData.append('path', ref.path);
            api_setting.method = 'action';
            api_setting.url = ref.api;
            api_setting.data = formData;

            api(api_setting).then(function(response) {
                let res = response;

                if (res.result == 'error_login') {
                    alert.login();
                } else if (res.result == 'success') {
                    $.each(res.files, function(key, file) {
                        register.formData[ref.pointer[0]][ref.pointer[1]].push(file);
                    });

                    showFiles.tycoon(ref.input, register.formData[ref.pointer[0]][ref.pointer[1]]);
                } else {
                    alert.show(res.result, 'ไม่สามารถอัพโหลดไฟล์ได้', res.message);
                }

                if (ref.path == 'paper') {
                    $(ref.label).html(label_html);
                    $(ref.btn).prop('disabled', false);
                } else {
                    $(ref.label.input).removeClass('hide');
                    $(ref.label.progress).addClass('hide');
                    $(ref.label.progress).html('');
                }
            });
            break;
        case 'awards/pre-screen':

            let answer = psc.questions[setting.cate].question[setting.seg];
            let setAction = !empty(answer.reply_id) ? 'update' : 'create';
            formData.append('qid', answer.id);
            formData.append('aid', !empty(answer.reply_id) ? answer.reply_id : '');
            formData.append('action', setAction);
            formData.append('position', ref.position);
            formData.append('path', ref.path);
            api_setting.method = 'action';
            api_setting.url = ref.api;
            api_setting.data = formData;

            api(api_setting).then(function(response) {
                let res = response;

                if (res.result == 'error_login') {
                    alert.login();
                } else if (res.result == 'success') {
                    if(setAction == 'create'){
                        psc.questions[setting.cate].question[setting.seg].reply_id = res.id;
                    }
                    psc.questions[setting.cate].question[setting.seg][ref.position] = res.files;
                    showFiles.tycoon(ref.input, psc.questions[setting.cate].question[setting.seg][ref.position]);
                } else {
                    alert.show(res.result, 'ไม่สามารถอัพโหลดไฟล์ได้', res.message);
                }

                if (ref.path == 'paper') {
                    $(ref.label).html(label_html);
                    $(ref.btn).prop('disabled', false);
                } else {
                    $(ref.label.input).removeClass('hide');
                    $(ref.label.progress).addClass('hide');
                    $(ref.label.progress).html('');
                }
            });
            break;
        case 'estimate/onsite':
            let estimate = dataset[setting.cate].question[setting.seg];
            formData.append('id',estimate.est_id);
            formData.append('position',ref.position);
            formData.append('path', ref.path);
            api_setting.method = 'action';
            api_setting.url = ref.api;
            api_setting.data = formData;

            api(api_setting).then(function(response) {
                let res = response;

                if (res.result == 'error_login') {
                    alert.login();
                } else if (res.result == 'success') {
                    dataset[setting.cate].question[setting.seg].estFiles[ref.position] = res.files;
                    showFiles.tycoon(ref.input, dataset[setting.cate].question[setting.seg].estFiles[ref.position]);
                } else {
                    alert.show(res.result, 'ไม่สามารถอัพโหลดไฟล์ได้', res.message);
                }

                if (ref.path == 'paper' || ref.position == 'camera') {
                    $(ref.label).html(label_html);
                    $(ref.btn).prop('disabled', false);
                } else {
                    $(ref.label.input).removeClass('hide');
                    $(ref.label.progress).addClass('hide');
                    $(ref.label.progress).html('');
                }
            });
            break;
    }

}

const removeFile = (input, setting) => {
    let api_setting = {},
        pointer,
        ref = referance.find(el => el.input == input);

    $(ref.btnrm).prop('disabled', true);
    $(ref.btnrm).html(setSpinner('Removing...'));

    if ($.inArray(ref.app, ['awards/application', 'awards/pre-screen', 'estimate/onstie']) !== -1) {
        api_setting.method = 'post';

        if (ref.app == 'awards/application') {
            api_setting.url = '/inner-api/app/remove/file';
        } else if (ref.app == 'awards/pre-screen') {
            pointer = psc.getPointer();
            setting.id = psc.questions[pointer.cate].question[pointer.seg].id;
            api_setting.url = '/inner-api/answer/remove/file';
        } else if (ref.app == 'estimate/onsite') {
            pointer = getPointer();
            setting.id = dataset[pointer.cate].question[pointer.seg].est_id;
            api_setting.url = '/inner-api/estimate/onsite/files/remove';
        }

        setting.position = ref.position;
        api_setting.data = setting;
        
        api(api_setting).then(function(response) {
            let res = response;

            if (res.result == 'error_login') {
                alert.login();
            } 
            else if (res.result == 'success' && ref.app == 'awards/application') {
                if (setting.remove == 'fixed') {
                    register.formData[ref.pointer[0]][ref.pointer[1]] = [];
                    register.change[ref.pointer[1]] = 0;

                    $.each(res.files, function(key, file) {
                        if (file.file_position == ref.position) {
                            register.formData[ref.pointer[0]][ref.pointer[1]].push(file);
                            register.change[ref.pointer[1]]++;
                        }
                    });
                } else {
                    register.formData[ref.pointer[0]][ref.pointer[1]] = [];
                    register.change[ref.pointer[1]] = 0;
                }

                showFiles.tycoon(input, register.formData[ref.pointer[0]][ref.pointer[1]]);
            } 
            else if (res.result == 'success' && ref.app == 'awards/pre-screen') {
                if (setting.remove == 'fixed') {
                    psc.questions[pointer.cate].question[pointer.seg][ref.position] = res.files;
                } else {
                    psc.questions[pointer.cate].question[pointer.seg][ref.position] = [];
                }

                showFiles.tycoon(input, psc.questions[pointer.cate].question[pointer.seg][ref.position]);
            } 
            else if (res.result == 'success' && ref.app == 'estimate/onsite') {
                if (setting.remove == 'fixed') {
                    dataset[pointer.cate].question[pointer.seg].estFiles[ref.position] = res.files;
                } else {
                    dataset[pointer.cate].question[pointer.seg].estFiles[ref.position] = [];
                }

                showFiles.tycoon(input, dataset[pointer.cate].question[pointer.seg].estFiles[ref.position]);
            } 
            else {
                alert.show(res.result, 'ไม่สามารถลบไฟล์ได้', res.message);
            }

            $(ref.btnrm).prop('disabled', false);
            $(ref.btnrm).html('Remove All');
        });
    }
}

const downloadFile = (input) => {
    let id, url, pointer,
        emptyFile = false;
        ref = referance.find(el => el.input == input);

    if (ref.app == 'awards/application') {
        if(register.count[ref.pointer[1]] > 0){
            id = register.id;
            url = getBaseUrl() + '/inner-api/app/download/file';
        } else {
            emptyFile = true;
        }
    } else if (ref.app == 'awards/pre-screen') {
        pointer = psc.getPointer();

        if(psc.questions[pointer.cate].question[pointer.seg].paper.length > 0){
            id = psc.questions[pointer.cate].question[pointer.seg].reply_id;
            url = getBaseUrl() + '/inner-api/answer/download/file';
        } else {
            emptyFile = true;
        } 
    } else if (ref.app == 'estimate/onsite') {
        pointer = getPointer();
        
        if(dataset[pointer.cate].question[pointer.seg].estFiles[ref.position].length > 0){
            id = dataset[pointer.cate].question[pointer.seg].est_id;
            url = getBaseUrl() + '/inner-api/estimate/onsite/files/download';
        } else {
            emptyFile = true;
        } 
    }

    if(!emptyFile){
        url += '/' + id + '/' + ref.position;
        window.open(url, '_blank');
    } else {
        alert.show('warning','ไม่มีไฟล์ในรายการนี้','');
    }
}

const showFiles = {
    tycoon: function(input, files) {
        let ref = referance.find(el => el.input == input),
            html;
            
        if (ref.app == 'awards/pre-screen' && psc.status == 'reject' && ref.path == 'images') {
            html = [];
        } else {
            html = '';
        }

        $.each(files, function(key, file) {
            if (ref.app == 'awards/pre-screen' && psc.status == 'reject' && ref.path == 'images') {
                html.push(showFiles.setFile(input, file));
            } else {
                html += showFiles.setFile(input, file);
            }
        });

        if (ref.path == 'images') {
            if (
                (ref.app == 'awards/application' && $.inArray(Number(register.status), [1, 4]) !== -1) ||
                (ref.app == 'awards/pre-screen' && psc.status == 'draft') || 
                (
                    ref.app == 'estimate/onsite' 
                    && (
                        $.inArray(Number(getStageStatus()),[6,7]) === -1
                        && getIsFinish() != 'finish' 
                    )
                )
            ) {
                $(ref.show).html(html);
            } else if (ref.app == 'awards/pre-screen' && psc.status == 'reject') {

                let hinput = '',
                    hablum = '';

                $.each(html, function(k, v) {
                    hinput += v.input;
                    hablum += v.ablum;
                });

                $(ref.show).html(hinput);
                $(ref.ablum).html(hablum);
            } else {
                $(ref.ablum).html(html);
            }
        } else {
            $(ref.show).html(html);
        }


    },
    setFile(input, setting) {
        let html, onclick, id, img,
            ref = referance.find(el => el.input == input);

        if (ref.app == 'awards/application') { id = register.id; }

        if (
            $.inArray(ref.app, ['awards/application', 'awards/pre-screen', 'estimate/onsite']) !== -1 &&
            ref.path == 'paper'
        ) {
            onclick = 'onclick="removeFile(\'' + input + '\',{';

            if (ref.app == 'awards/application') {
                onclick += 'id: ' + id + ','
            }

            onclick += "file_name: '" + setting.file_name + "',";
            onclick += "file_path: '" + setting.file_path + "',";
            onclick += 'remove: \'fixed\'})"';

            html = '<div class="col-12">'
                        + '<div class="card card-body-muted">'
                            + '<div class="bs-row">'
                                + '<div class="col-12">'
                                    + '<span class="fs-file-name">' + setting.file_original + ' '
                                    + '<br>(' + setting.file_size + 'MB)</span>'
                                    + '<a ' + onclick + ' class="fs-file-remove float-end" title="ลบไฟล์">'
                                        + '<i class="bi bi-trash-fill"></i> ลบ'
                                    + '</a>'
                                + '</div>'
                            + '</div>'
                        + '</div>'
                    + '</div>';

            return html;
        } else if (
            $.inArray(ref.app, ['awards/application', 'awards/pre-screen', 'estimate/onsite']) !== -1 &&
            ref.path == 'images'
        ) {
            img = getBaseUrl() + '/' + setting.file_path;

            if (
                (ref.app == 'awards/application' && $.inArray(Number(register.status), [1, 4]) !== -1) ||
                (ref.app == 'awards/pre-screen' && psc.status == 'draft') ||
                (
                    ref.app == 'estimate/onsite' 
                    && (
                        $.inArray(Number(getStageStatus()),[6,7]) === -1
                        && getIsFinish() != 'finish' 
                    )
                )
            ) {
                if(ref.app == 'estimate/onsite' && ref.position == 'camera'){
                    html = '<div class="list">'
                                + '<img src="' + img + '" onclick="zoomImages(this)">'
                            + '</div>';
                } else {
                    onclick = 'href="javascript:removeFile(\'' + input + '\',{';

                    if (ref.app == 'awards/application') {
                        onclick += 'id: ' + id + ','
                    }

                    onclick += "file_name: '" + setting.file_name + "',";
                    onclick += "file_path: '" + setting.file_path + "',";
                    onclick += 'remove: \'fixed\'});"';

                    html = '<div class="card card-left mt-1 mb-1">'
                                + '<img src="' + img + '" class="card-img-left">'
                                + '<div class="card-body">'
                                    + '<div class="bs-row">'
                                        + '<span class="fs-file-name fw-semibold">' 
                                            + setting.file_original 
                                        + '</span>'
                                    + '</div>'
                                    + '<div class="bs-row">'
                                        + '<div class="col-12">'
                                            + '<span style="font-size: 14px;" class="text-muted">' 
                                                + setting.file_size 
                                            + 'MB</span>'
                                            + '<a ' + onclick + ' class="fs-file-remove float-end" title="ลบไฟล์">'
                                                + '<i class="bi bi-trash-fill"></i> ลบ'
                                            + '</a>'
                                        + '</div>'
                                    + '</div>'
                                + '</div>'
                            + '</div>';
                }

                return html;
            } else if (ref.app == 'awards/pre-screen' && psc.status == 'reject') {
                html = { input: '', ablum: '' };

                onclick += "file_name: '" + setting.file_name + "',";
                onclick += "file_path: '" + setting.file_path + "',";
                onclick += 'remove: \'fixed\'});"';

                html.input = '<div class="card card-left mt-1 mb-1">'
                                + '<img src="' + img + '" class="card-img-left">'
                                + '<div class="card-body">'
                                    + '<div class="bs-row">'
                                        + '<span class="fs-file-name fw-semibold">' 
                                        + setting.file_original + '</span>'
                                    + '</div>'
                                    + '<div class="bs-row">'
                                        + '<div class="col-12">'
                                            + '<span style="font-size: 14px;" class="text-muted">' 
                                                + setting.file_size + 'MB</span>'
                                            + '<a ' + onclick + ' class="fs-file-remove float-end" title="ลบไฟล์">'
                                                + '<i class="bi bi-trash-fill"></i> ลบ'
                                            + '</a>'
                                        + '</div>'
                                    + '</div>'
                                + '</div>'
                            + '</div>';


                html.ablum = '<div class="ablumbox-col">'
                                + '<div class="ablum-mainimg">'
                                    + '<div class="ablum-mainimg-scale">'
                                        + '<img src="' + img + '" '
                                        + 'class="ablum-img" onclick="zoomImages(this)">'
                                    + '</div>'
                                + '</div>'
                        + '</div>';

                return html;
            } else {
                html = '<div class="ablumbox-col">'
                            + '<div class="ablum-mainimg">'
                                + '<div class="ablum-mainimg-scale">'
                                    + '<img src="' + img + '" '
                                    + 'class="ablum-img" onclick="zoomImages(this)">'
                                + '</div>'
                            + '</div>'
                        + '</div>';
                return html;
            }
        }

    },
}

const resetFileInput = (input) => {
    let ele = $(input);
    ele.wrap('<form>').closest('form').get(0).reset();
    ele.unwrap();

}

let dropAreaImg, dropAreaFile;

if ($('#step1-images-drop').length > 0) {
    dropAreaImg = document.getElementById('step1-images-drop');
} else if ($('#images-drop').length > 0) {
    dropAreaImg = document.getElementById('images-drop');
} else if ($('#etm-images-drop').length > 0) {
    dropAreaImg = document.getElementById('etm-images-drop');
}

if ($('#file-drop').length > 0) {
    dropAreaFile = document.getElementById('file-drop');
}

const preventDefaults = (e) => {
    e.preventDefault();
    e.stopPropagation();
}

const imagesFileDrop = (e) => {
    let dt = e.dataTransfer,
        files = dt.files
    id = '#' + e.target.id;
    handleDrop(id, files);
}

const handleDrop = (id, files) => {
    let temp = [],
        check = true,
        error, appId, total, pointer, setting,
        ref = referance.find(el => el.area == id || el.input == id);

    if (ref.app == 'awards/application') {
        total = Number(register.count[ref.pointer[1]]) + Number([...files].length);
    } else if (ref.app == 'awards/pre-screen') {
        pointer = psc.getPointer();
        let length = psc.questions[pointer.cate].question[pointer.seg][ref.position].length;
        total = Number(length) + Number([...files].length);
    } else if (ref.app ==  'estimate/onsite') {
        pointer = getPointer();
        let length = dataset[pointer.cate].question[pointer.seg].estFiles[ref.position].length;
        total = Number(length) + Number([...files].length)

    }

    if (total > ref.maxUpload) {
        alert.show(
            'warning', 
            ref.pointer[1] == 'images' ?  'ไม่สามารถอัพโหลดรูปได้' : 'ไม่สามารถอัพโหลดเอกสารได้', 
            'คุณสามารถอัพโหลดไฟล์ได้ไม่เกิน ' + ref.maxUpload + ' ไฟล์เท่านั้น'
        );
    }

    const acceptType = ref.pointer[1] == 'images' ? accept.images : accept.paper;

    $.each([...files], function(key, file) {
        if ($.inArray(file.type, acceptType) !== '1') {
            let mb = (file.size / (1024 * 1024)).toFixed(2);

            if (mb > ref.maxSize) {
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

    if (!check) {
        let error_title, error_text;
        error_title = ref.pointer[1] == 'images' ?  'ไม่สามารถอัพโหลดรูปได้' : 'ไม่สามารถอัพโหลดเอกสารได้';

        if (error == 'outType') {
            error_text = (
                'กรุณาเลือกเป็นไฟล์ '
                + ref.pointer[1] == 'images' ? '.jpg, jpeg, png' : '.pdf'
                + ' เท่านั้น'
            );
        } else if (error == 'outSize') {
            error_text = 'กรุณาเลือกขนาดไฟล์ไม่เกิน ' + ref.maxSize + ' MiB.'
        }

        alert.show('warning', error_title, error_text);
        return false;
    }

    if (ref.app == 'awards/application') {
        setting = { id: register.id, files: temp };
    } else if ($.inArray(ref.app,['awards/pre-screen','estimate/onsite']) !==  -1) {
        setting = pointer;
        setting.files = temp;
    }

    uploadFile(setting, ref.input, 'drop');
}

;

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    if(dropAreaImg !== undefined && dropAreaImg !== 'undefined'){
        dropAreaImg.addEventListener(eventName, preventDefaults, false);
    }

    if(dropAreaFile !== undefined && dropAreaFile !== 'undefined'){
        dropAreaFile.addEventListener(eventName, preventDefaults, false);
    }
});

if(dropAreaImg !== undefined && dropAreaImg !== 'undefined'){
    dropAreaImg.addEventListener('drop', imagesFileDrop, false);
}

if(dropAreaFile !== undefined && dropAreaFile !== 'undefined'){
    dropAreaFile.addEventListener('drop', imagesFileDrop, false);
}

const accept = {
    paper: ['application/pdf'],
    images: ['image/jpg', 'image/jpeg', 'image/png']
};

const referance = [{
        input: '#step1-paper',
        pointer: ['step1', 'paper'],
        btn: '#step1-paper-btn',
        btnrm: '#step1-paper-remove',
        show: '#step1-paper-list',
        label: '#step1-paper-label',
        api: '/inner-api/app/upload',
        position: 'paperFiles',
        path: 'paper',
        app: 'awards/application',
        maxUpload: 5,
        maxSize: 15
    },
    {
        input: '#step1-detail',
        pointer: ['step1', 'detail'],
        btn: '#step1-detail-btn',
        btnrm: '#step1-detail-remove',
        show: '#step1-detail-list',
        label: '#step1-detail-label',
        api: '/inner-api/app/upload',
        position: 'detailFiles',
        path: 'paper',
        app: 'awards/application',
        maxUpload: 5,
        maxSize: 15
    },
    {
        input: '#step1-images',
        area: '#step1-images-input',
        pointer: ['step1', 'images'],
        btn: '#step1-images-btn',
        btnrm: '#step1-images-remove',
        show: '#step1-images-list',
        ablum: '#step1-images-ablum',
        label: {
            input: '#step1-images-input',
            progress: '#step1-images-progress'
        },
        api: '/inner-api/app/upload',
        position: 'registerImages',
        path: 'images',
        app: 'awards/application',
        maxUpload: 10,
        maxSize: 10
    },
    {
        input: '#step5-landOwner',
        pointer: ['step5', 'landOwner', 1],
        btn: '#step5-landOwner-btn',
        btnrm: '#step5-landOwner-remove',
        show: '#step5-landOwner-list',
        label: '#step5-landOwner-label',
        api: '/inner-api/app/upload',
        position: 'landOwnerFiles',
        require: true,
        path: 'paper',
        app: 'awards/application',
        maxUpload: 5,
        maxSize: 15
    },
    {
        input: '#step5-businessCert',
        pointer: ['step5', 'businessCert', 1],
        btn: '#step5-businessCert-btn',
        btnrm: '#step5-businessCert-remove',
        show: '#step5-businessCert-list',
        label: '#step5-businessCert-label',
        api: '/inner-api/app/upload',
        position: 'businessCertFiles',
        require: true,
        path: 'paper',
        app: 'awards/application',
        maxUpload: 5,
        maxSize: 15
    },
    {
        input: '#step5-otherCert',
        pointer: ['step5', 'otherCert'],
        btn: '#step5-otherCert-btn',
        btnrm: '#step5-otherCert-remove',
        show: '#step5-otherCert-list',
        label: '#step5-otherCert-label',
        api: '/inner-api/app/upload',
        position: 'otherCertFiles',
        path: 'paper',
        app: 'awards/application',
        maxUpload: 5,
        maxSize: 15
    },
    {
        input: '#step5-bussLicenseFiles',
        pointer: ['step5', 'bussLicenseFiles', 2],
        btn: '#step5-bussLicenseFiles-btn',
        btnrm: '#step5-bussLicenseFiles-remove',
        show: '#step5-bussLicenseFiles-list',
        label: '#step5-bussLicenseFiles-label',
        api: '/inner-api/app/upload',
        position: 'bussLicenseFiles',
        require: true,
        path: 'paper',
        app: 'awards/application',
        maxUpload: 5,
        maxSize: 15
    },
    {
        input: '#step5-EIAreport',
        pointer: ['step5', 'EIAreport', 2],
        btn: '#step5-EIAreport-btn',
        btnrm: '#step5-EIAreport-remove',
        show: '#step5-EIAreport-list',
        label: '#step5-EIAreport-label',
        api: '/inner-api/app/upload',
        position: 'EIAreportFiles',
        require: true,
        path: 'paper',
        app: 'awards/application',
        maxUpload: 5,
        maxSize: 15
    },
    {
        input: '#step5-otherT2Cert',
        pointer: ['step5', 'otherT2Cert'],
        btn: '#step5-otherT2Cert-btn',
        btnrm: '#step5-otherT2Cert-remove',
        show: '#step5-otherT2Cert-list',
        label: '#step5-otherT2Cert-label',
        api: '/inner-api/app/upload',
        position: 'otherT2CertFiles',
        path: 'paper',
        app: 'awards/application',
        maxUpload: 5,
        maxSize: 15
    },
    {
        input: '#step5-spaCert',
        pointer: ['step5', 'spaCert',3],
        btn: '#step5-spaCert-btn',
        btnrm: '#step5-spaCert-remove',
        show: '#step5-spaCert-list',
        label: '#step5-spaCert-label',
        api: '/inner-api/app/upload',
        position: 'spaCertFiles',
        require: true,
        path: 'paper',
        app: 'awards/application',
        maxUpload: 5,
        maxSize: 15
    },
    {
        input: '#step5-effluent',
        pointer: ['step5', 'effluent'],
        btn: '#step5-effluent-btn',
        btnrm: '#step5-effluent-remove',
        show: '#step5-effluent-list',
        label: '#step5-effluent-label',
        api: '/inner-api/app/upload',
        position: 'effluentFiles',
        path: 'paper',
        app: 'awards/application',
        maxUpload: 5,
        maxSize: 15
    },
    {
        input: '#step5-wellnessCert',
        pointer: ['step5', 'wellnessCert',3,12],
        btn: '#step5-wellnessCert-btn',
        btnrm: '#step5-wellnessCert-remove',
        show: '#step5-wellnessCert-list',
        label: '#step5-wellnessCert-label',
        api: '/inner-api/app/upload',
        position: 'wellnessCertFiles',
        require: true,
        path: 'paper',
        app: 'awards/application',
        maxUpload: 5,
        maxSize: 15
    },
    {
        input: '#step5-spaManger',
        pointer: ['step5', 'spaManger',3,11],
        btn: '#step5-spaManger-btn',
        btnrm: '#step5-spaManger-remove',
        show: '#step5-spaManger-list',
        label: '#step5-spaManger-label',
        api: '/inner-api/app/upload',
        position: 'spaMangerFiles',
        require: true,
        path: 'paper',
        app: 'awards/application',
        maxUpload: 5,
        maxSize: 15
    },
    {
        input: '#step5-titleDeed',
        pointer: ['step5', 'titleDeed'],
        btn: '#step5-titleDeed-btn',
        btnrm: '#step5-titleDeed-remove',
        show: '#step5-titleDeed-list',
        label: '#step5-titleDeed-label',
        api: '/inner-api/app/upload',
        position: 'titleDeedFiles',
        path: 'paper',
        app: 'awards/application',
        maxUpload: 5,
        maxSize: 15
    },
    {
        input: '#step5-outlander',
        pointer: ['step5', 'outlander',3],
        btn: '#step5-outlander-btn',
        btnrm: '#step5-outlander-remove',
        show: '#step5-outlander-list',
        label: '#step5-outlander-label',
        api: '/inner-api/app/upload',
        position: 'outlanderFiles',
        require: true,
        path: 'paper',
        app: 'awards/application',
        maxUpload: 5,
        maxSize: 15
    },
    {
        input: '#step5-guideCert',
        pointer: ['step5', 'guideCert',4],
        btn: '#step5-guideCert-btn',
        btnrm: '#step5-guideCert-remove',
        show: '#step5-guideCert-list',
        label: '#step5-guideCert-label',
        api: '/inner-api/app/upload',
        position: 'guideCertFiles',
        require: true,
        path: 'paper',
        app: 'awards/application',
        maxUpload: 5,
        maxSize: 15
    },
    {
        input: '#step5-otherT3',
        pointer: ['step5', 'otherT3'],
        btn: '#step5-otherT3-btn',
        btnrm: '#step5-otherT3-remove',
        show: '#step5-otherT3-list',
        label: '#step5-otherT3-label',
        api: '/inner-api/app/upload',
        position: 'otherT3Files',
        path: 'paper',
        app: 'awards/application',
        maxUpload: 5,
        maxSize: 15
    },
    {
        input: '#step5-EffluentT3',
        pointer: ['step5', 'EffluentT3'],
        btn: '#step5-EffluentT3-btn',
        btnrm: '#step5-EffluentT3-remove',
        show: '#step5-EffluentT3-list',
        label: '#step5-EffluentT3-label',
        api: '/inner-api/app/upload',
        position: 'EffluentT3Files',
        path: 'paper',
        app: 'awards/application',
        maxUpload: 5,
        maxSize: 15
    },
    {
        input: '#step5-guideOldCert', pointer: ['step5','guideOldCert',4],
        btn: '#step5-guideOldCert-btn', btnrm: '#step5-guideOldCert-remove',
        show: '#step5-guideOldCert-list', label: '#step5-guideOldCert-label',
        api: '/inner-api/app/upload', position: 'guideOldCertFiles',
        require: true,
        path: 'paper', app: 'awards/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-titleDeedT4', pointer: ['step5','titleDeedT4',4],
        btn: '#step5-titleDeedT4-btn', btnrm: '#step5-titleDeedT4-remove',
        show: '#step5-titleDeedT4-list', label: '#step5-titleDeedT4-label',
        api: '/inner-api/app/upload', position: 'gtitleDeedT4Files',
        require: true,
        path: 'paper', app: 'awards/application',
        maxUpload: 5, maxSize: 15
    },
    {
        input: '#step5-otherT4Cert',
        pointer: ['step5', 'otherT4Cert'],
        btn: '#step5-otherT4Cert-btn',
        btnrm: '#step5-otherT4Cert-remove',
        show: '#step5-otherT4Cert-list',
        label: '#step5-otherT4Cert-label',
        api: '/inner-api/app/upload',
        position: 'otherT4CertFiles',
        path: 'paper',
        app: 'awards/application',
        maxUpload: 5,
        maxSize: 15
    },
    {
        input: '#images',
        area: '#images-input',
        pointer: ['', 'images'],
        btn: '#images-btn',
        btnrm: '#images-remove',
        show: '#images-list',
        ablum: '#images-ablum',
        label: {
            input: '#images-input',
            progress: '#images-progress'
        },
        api: '/inner-api/answer/upload',
        position: 'images',
        path: 'images',
        app: 'awards/pre-screen',
        maxUpload: 10,
        maxSize: 10
    },
    {
        input: '#file',
        pointer: ['', 'paper'],
        btn: '#file-btn',
        btnrm: '#file-remove',
        show: '#file-list',
        label: '#file-label',
        api: '/inner-api/answer/upload',
        position: 'paper',
        path: 'paper',
        app: 'awards/pre-screen',
        maxUpload: 5,
        maxSize: 15
    },
    {
        input: '#file',
        area: '#file-input',
        pointer: ['', 'paper'],
        btn: '#file-btn',
        btnrm: '#file-remove',
        show: '#file-list',
        label: {
            input: '#file-input',
            progress: '#file-progress'
        },
        api: '/inner-api/answer/upload',
        position: 'paper',
        path: 'paper',
        app: 'awards/pre-screen',
        maxUpload: 5,
        maxSize: 15
    },
    {
        input: '#etm-images',
        area: '#etm-images-input',
        pointer: ['', 'etm-images'],
        btn: '#etm-images-btn',
        btnrm: '#etm-mages-remove',
        show: '#etm-images-list',
        ablum: '#etm-images-ablum',
        label: {
            input: '#etm-images-input',
            progress: '#etm-images-progress'
        },
        api: '/inner-api/estimate/onsite/files/upload',
        position: 'images',
        path: 'images',
        app: 'estimate/onsite',
        maxUpload: 10,
        maxSize: 10
    },
    {
        input: '#camera',
        pointer: ['', 'camera'],
        btn: '#camera-btn',
        btnrm: '#camera-remove',
        show: '#camera-gallery',
        ablum: '#camera-gallery',
        label: '#camera-label',
        api: '/inner-api/estimate/onsite/files/upload',
        position: 'camera',
        path: 'images',
        app: 'estimate/onsite',
        maxUpload: 999,
        maxSize: 1000000
    },
    {
        input: '#etm-file',
        pointer: ['', 'paper'],
        btn: '#etm-file-btn',
        btnrm: '#etm-file-remove',
        show: '#etm-file-list',
        label: '#etm-file-label',
        api: '/inner-api/estimate/onsite/files/upload',
        position: 'paper',
        path: 'paper',
        app: 'estimate/onsite',
        maxUpload: 5,
        maxSize: 15
    },
];

const checkRequireFiles = (app) => {
    let check = true;

    $.each(referance,(rk,rv) => {
        if(app == rv.app){
            if(!empty(rv.require) && rv.require){
                if(!empty(rv.pointer[3])){
                    if(
                        Number(register.appType.main) == rv.pointer[3]
                        && Number(register.appType.sub) == rv.pointer[4]
                    ){
                        if(register.count[rv.pointer[1]] <= 0){
                            check = false;
                        }
                    }
                } else {
                    if(Number(register.appType.main) == rv.pointer[3]){
                        if(register.count[rv.pointer[1]] <= 0){
                            check = false;
                        }
                    }
                }
            }
        }
    });

    return check;
}