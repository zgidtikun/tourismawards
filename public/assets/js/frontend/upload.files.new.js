const getReferance = input => {
    return referance.find(el => el.input == input);
}

const lockUpload = (label, btn, action) => {
    return new Promise(function (resolve) {
        const html_uploading = 'Uploading...';
        const html_finish = 'Upload Files';

        switch (action) {
            case 'lock':
                $(label).html(setSpinner(html_uploading));
                $(btn).prop('disabled', true);
                resolve({ status: true });
                break;
            case 'unlock':
                $(label).html(html_finish);
                $(btn).prop('disabled', false);
                resolve({ status: true });
                break;
        }
    });
}

const onFileHandle = async(setting, input, type) => {
    const files = $(input)[0].files;
    const acceptableTypes = accept[type];
    const reference = getReferance(input);
    let isValid = true;
    let error, totalFiles;

    if (files.length > 0) {
        if (reference.app == 'awards/application') {
            totalFiles = Number(register.count[reference.pointer[1]]) + Number(files.length);
        } else if (reference.app == 'awards/pre-screen') {
            const length = psc.questions[setting.cate].question[setting.seg][reference.position].length;
            totalFiles = Number(length) + Number(files.length);
        } else if (reference.app == 'estimate/onsite') {
            const length = dataset[setting.cate].question[setting.seg].estFiles[reference.position].length;
            totalFiles = Number(length) + Number(files.length);
        }

        if (Number(totalFiles) > Number(reference.maxUpload)) {
            alert.show('warning', 'ไม่สามารถอัพโหลดไฟล์ได้', `คุณสามารถอัพโหลดไฟล์ได้ไม่เกิน ${reference.maxUpload} ไฟล์เท่านั้น`);
            return false
        }

        $.each(files,(key,file) => {
            const mb = (file.size / (1024 * 1024)).toFixed(2);
            
            if (!acceptableTypes.includes(file.type)) {
                isValid = false;
                error = 'invalidType';
                return false;
            }

            if (mb > reference.maxSize) {
                isValid = false;
                error = 'exceedsSizeLimit';
                return false;
            }
        });

        if (!isValid) {
            let errorTitle, errorMessage;
            errorTitle = type === 'paper' ? 'ไม่สามารถอัพโหลดไฟล์ได้' : 'ไม่สามารถอัพโหลดรูปได้';

            if (error === 'invalidType') {
                errorMessage = type === 'paper' ? 'กรุณาเลือกเป็นไฟล์ .pdf เท่านั้น' : 'กรุณาเลือกเป็นไฟล์ .jpeg, .jpg, .png เท่านั้น';
            } else if (error === 'exceedsSizeLimit') {
                errorMessage = `กรุณาเลือกขนาดไฟล์ไม่เกิน ${reference.maxSize}MB.`;
            }

            alert.show('warning', errorTitle, errorMessage);
            return false;
        } else {            

            if (reference.app == 'awards/application') {
                await register.waitUpload('lock', input);
            } else {
                if (reference.app == 'awards/pre-screen') {
                    await psc.waitDraft('wait');
                } else {
                    await waitDraft('wait');
                }

                await lockUpload(reference.label, reference.btn, 'lock');
            }

            $.each(files,async(key,file) => {
                const uploaded = await uploadFile(setting, input, file);

                if(uploaded === 'error_login'){
                    alert.login();
                    return false;
                } 
                else if(uploaded === 'error'){                    
                    return false;
                }
            });

            switch (reference.app) {
                case 'awards/application':                    
                    await register.waitUpload('unlock', input);                    
                    register.checkComplete();               
                    $(input).val('');
                break;
                case 'awards/pre-screen':
                case 'estimate/onsite':
                    if (reference.app == 'awards/pre-screen') {
                        await psc.waitDraft('finish');
                    } else {
                        await waitDraft('finish'); 
                    }   

                    await lockUpload(reference.label, reference.btn, 'unlock');          
                    $(input).val('');
                break;
            }
        }
    }
};

const uploadFile = async (setting, input, file) => {    
    return new Promise(async(resolve, reject) => {
        const formData = new FormData();
        const reference = getReferance(input);
        const api_setting = {};
        let callback;
        
        formData.append('files[]', file);

        switch (reference.app) {
            case 'awards/application':
                formData.append('id', setting.id);
                formData.append('position', reference.position);
                formData.append('path', reference.path);

                api_setting.method = 'action';
                api_setting.url = reference.api;
                api_setting.data = formData;

                callback = await api(api_setting);

                if (callback.result == 'error_login') {
                    resolve(callback.result); 
                } else if (callback.result == 'success') {
                    let countFile = 0;
                    $.each(callback.files, function (key, file) {
                        register.formData[reference.pointer[0]][reference.pointer[1]].push(file);
                        countFile++;
                    });
                    
                    register.count[reference.pointer[1]] = await register.count[reference.pointer[1]] + Number(countFile);
                    register.checkComplete();
                    showFiles.tycoon(reference.input, register.formData[reference.pointer[0]][reference.pointer[1]]);
                    resolve(callback.result); 
                } else {
                    alert.show(callback.result, 'ไม่สามารถอัพโหลดไฟล์ได้', callback.message);
                    resolve(callback.result); 
                }
            break;
            case 'awards/pre-screen':
                const answer = psc.questions[setting.cate].question[setting.seg];
                const setAction = !empty(answer.reply_id) ? 'update' : 'create';

                formData.append('qid', answer.id);
                formData.append('aid', !empty(answer.reply_id) ? answer.reply_id : '');
                formData.append('action', setAction);
                formData.append('position', reference.position);
                formData.append('path', reference.path);

                api_setting.method = 'action';
                api_setting.url = reference.api;
                api_setting.data = formData;

                callback = await api(api_setting);

                if (callback.result == 'error_login') {
                    resolve(callback.result); 
                } else if (callback.result == 'success') {
                    if (setAction == 'create') {
                        psc.questions[setting.cate].question[setting.seg].reply_id = callback.id;
                    }
                    
                    psc.questions[setting.cate].question[setting.seg][reference.position] = callback.files;
                    showFiles.tycoon(reference.input, callback.files);
                    resolve(callback.result); 
                } else {
                    alert.show(callback.result, 'ไม่สามารถอัพโหลดไฟล์ได้', callback.message);
                    resolve(callback.result); 
                }
            break;
            case 'estimate/onsite':
                const estimate = dataset[setting.cate].question[setting.seg];
                const est_id = !empty(estimate.est_id) ? estimate.est_id : '';

                formData.append('app_id', appid);
                formData.append('answer_id', estimate.reply_id);
                formData.append('estimate_id', est_id);
                formData.append('question_id', estimate.id);
                formData.append('position', reference.position);
                formData.append('path', reference.path);

                api_setting.method = 'action';
                api_setting.url = reference.api;
                api_setting.data = formData;

                callback = await api(api_setting);

                if (callback.result == 'error_login') {
                    resolve(callback.result); 
                } else if (callback.result == 'success') {
                    dataset[setting.cate].question[setting.seg].est_id = callback.estimate_id;
                    dataset[setting.cate].question[setting.seg].estFiles[reference.position] = callback.files;
                    showFiles.tycoon(reference.input, callback.files);
                    resolve(callback.result); 
                } else {
                    alert.show(callback.result, 'ไม่สามารถอัพโหลดไฟล์ได้', callback.message);
                    resolve(callback.result); 
                }
            break;
        }
    })
}

const removeFile = async (input, setting) => {
    const ref = getReferance(input);
    let api_setting = {};
    let pointer;

    $(ref.btnrm).prop('disabled', true);
    $(ref.btnrm).html(setSpinner('Removing...'));

    if ($.inArray(ref.app, ['awards/application', 'awards/pre-screen', 'estimate/onsite']) !== -1) {
        api_setting.method = 'post';

        if (ref.app == 'awards/application') {
            api_setting.url = '/inner-api/app/remove/file';
        } else if (ref.app == 'awards/pre-screen') {
            pointer = psc.getPointer();
            if (pointer.cate == -1) { pointer.cate = 0; }
            if (pointer.seg == -1) { pointer.seg = 0; }
            setting.id = psc.questions[pointer.cate].question[pointer.seg].reply_id;
            api_setting.url = '/inner-api/answer/remove/file';
            await psc.waitDraft('wait');
        } else if (ref.app == 'estimate/onsite') {
            pointer = getPointer();
            if (pointer.cate == -1) { pointer.cate = 0; }
            if (pointer.seg == -1) { pointer.seg = 0; }
            setting.id = dataset[pointer.cate].question[pointer.seg].est_id;
            api_setting.url = '/inner-api/estimate/onsite/files/remove';
            await waitDraft('wait');
        }

        setting.position = ref.position;
        api_setting.data = setting;

        const callback = await api(api_setting);

        if (callback.result == 'error_login') {
            alert.login();
        }
        else if (callback.result == 'success' && ref.app == 'awards/application') {
            if (setting.remove == 'fixed') {
                register.formData[ref.pointer[0]][ref.pointer[1]] = [];
                register.count[ref.pointer[1]] = 0;

                $.each(callback.files, function (key, file) {
                    if (file.file_position == ref.position) {
                        register.formData[ref.pointer[0]][ref.pointer[1]].push(file);
                        register.count[ref.pointer[1]]++;
                    }
                });
                register.checkComplete();
            } else {
                register.formData[ref.pointer[0]][ref.pointer[1]] = [];
                register.count[ref.pointer[1]] = 0;                
                register.checkComplete();
            }
            showFiles.tycoon(input, register.formData[ref.pointer[0]][ref.pointer[1]]);
        }
        else if (callback.result == 'success' && ref.app == 'awards/pre-screen') {
            if (setting.remove == 'fixed') {
                psc.questions[pointer.cate].question[pointer.seg][ref.position] = callback.files;
            } else {
                psc.questions[pointer.cate].question[pointer.seg][ref.position] = [];
            }

            showFiles.tycoon(input, psc.questions[pointer.cate].question[pointer.seg][ref.position]);
        }
        else if (callback.result == 'success' && ref.app == 'estimate/onsite') {
            if (setting.remove == 'fixed') {
                dataset[pointer.cate].question[pointer.seg].estFiles[ref.position] = callback.files;
            } else {
                dataset[pointer.cate].question[pointer.seg].estFiles[ref.position] = [];
            }

            showFiles.tycoon(input, dataset[pointer.cate].question[pointer.seg].estFiles[ref.position]);
        }
        else {
            if (ref.app == 'awards/pre-screen') {
                await psc.waitDraft('finish');
            }
            else if (ref.app == 'estimate/onsite') {
                await waitDraft('finish');
            }

            alert.show(res.result, 'ไม่สามารถลบไฟล์ได้', res.message);
        }

        $(ref.btnrm).prop('disabled', false);
        $(ref.btnrm).html('Remove All');
    }
}

const downloadFile = (input) => {
    const ref = getReferance(input);
    let id, url, pointer,
        emptyFile = false;

    if (ref.app == 'awards/application') {
        if (register.count[ref.pointer[1]] > 0) {
            id = register.id;
            url = `${getBaseUrl()}/inner-api/app/download/file`;
        } else {
            emptyFile = true;
        }
    } else if (ref.app == 'awards/pre-screen') {
        pointer = psc.getPointer();
        if (pointer.cate == -1) { pointer.cate = 0; }
        if (pointer.seg == -1) { pointer.seg = 0; }

        if (psc.questions[pointer.cate].question[pointer.seg].paper.length > 0) {
            id = psc.questions[pointer.cate].question[pointer.seg].reply_id;
            url = `${getBaseUrl()}/inner-api/answer/download/file`;
        } else {
            emptyFile = true;
        }
    } else if (ref.app == 'estimate/onsite') {
        pointer = getPointer();
        if (pointer.cate == -1) { pointer.cate = 0; }
        if (pointer.seg == -1) { pointer.seg = 0; }

        if (dataset[pointer.cate].question[pointer.seg].estFiles[ref.position].length > 0) {
            id = dataset[pointer.cate].question[pointer.seg].est_id;
            url = `${getBaseUrl()}/inner-api/estimate/onsite/files/download`;
        } else {
            emptyFile = true;
        }
    }

    if (!emptyFile) {
        url += `/${id}/${ref.position}`;
        window.open(url, '_blank');
    } else {
        alert.show('warning', 'ไม่มีไฟล์ในรายการนี้', '');
    }
}

const showFiles = {
    tycoon: function (input, files) {
        const ref = getReferance(input);
        let html;

        if (ref.app == 'awards/pre-screen' && psc.status == 'reject' && ref.path == 'images') {
            html = [];
        } else {
            html = '';
        }

        $.each(files, function (key, file) {
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
                        $.inArray(Number(getStageStatus()), [6, 7]) === -1
                        && getIsFinish() != 'finish'
                    )
                )
            ) {
                $(ref.show).html(html);
                if (html == '') {
                    setBtnUploadFile(ref.input)
                    clearBtnRemoveFile('by-input', ref.app, ref.input);
                } else {
                    setBtnUploadFile(ref.input)
                    clearBtnRemoveFile('show-input', ref.app, ref.input);
                }
            } else if (ref.app == 'awards/pre-screen' && psc.status == 'reject') {

                let hinput = '',
                    hablum = '';

                $.each(html, function (k, v) {
                    hinput += v.input;
                    hablum += v.ablum;
                });

                $(ref.show).html(hinput);
                $(ref.ablum).html(hablum);
                if (hinput == '') {
                    setBtnUploadFile(ref.input)
                    clearBtnRemoveFile('by-input', ref.app, ref.input);
                } else {
                    setBtnUploadFile(ref.input)
                    clearBtnRemoveFile('show-input', ref.app, ref.input);
                }
            } else {
                $(ref.ablum).html(html);
                if (html == '') {
                    setBtnUploadFile(ref.input)
                    clearBtnRemoveFile('by-input', ref.app, ref.input);
                } else {
                    setBtnUploadFile(ref.input)
                    clearBtnRemoveFile('show-input', ref.app, ref.input);
                }
            }
        } else {
            if (
                (ref.app == 'awards/application' && register.complete) ||
                (ref.app == 'awards/pre-screen' && psc.complete) ||
                (
                    ref.app == 'estimate/onsite' && (
                        $.inArray(Number(getStageStatus()), [3, 6, 7]) !== -1
                        || getIsFinish() == 'finish'
                    )
                )
            ) {
                if (html == '') {
                    html = `<div class="col-12 text-center">ไม่มีไฟล์แนบ</div>`;
                }

                $(ref.ablum).html(html);
            } else {
                $(ref.show).html(html);

                if (html == '') {
                    setBtnUploadFile(ref.input)
                    clearBtnRemoveFile('by-input', ref.app, ref.input);
                } else {
                    setBtnUploadFile(ref.input)
                    clearBtnRemoveFile('show-input', ref.app, ref.input);
                }
            }
        }


    },
    setFile(input, setting) {
        let html, file_name, onclick, id, img, status;
        const ref = getReferance(input);

        if (ref.app == 'awards/application') {
            id = register.id;
            status = register.complete ? 'finish' : 'unfinish';
        }

        if (
            $.inArray(ref.app, ['awards/application', 'awards/pre-screen', 'estimate/onsite']) !== -1 &&
            ref.path == 'paper'
        ) {
            onclick = '';

            if (
                (ref.app == 'awards/application' && status == 'finish') ||
                (ref.app == 'awards/pre-screen' && psc.complete) ||
                (
                    ref.app == 'estimate/onsite' && (
                        $.inArray(Number(getStageStatus()), [3, 6, 7]) !== -1
                        || getIsFinish() == 'finish'
                    )
                )
            ) {
                const file_link = `${window.uploadFileUrl}${setting.file_path}`;
                onclick = '';

                file_name = `<a href="${file_link}" target="_blank">
                    <span class="fs-file-name">${setting.file_original}</span></a>`;

            } else {
                file_name = `<span class="fs-file-name">${setting.file_original}
                    <br>(${setting.file_size}MB)</span>`;

                onclick = `<a class="fs-file-remove float-end" 
                    href="javascript:void(0);" onclick="removeFile('${input}',{
                    ${!empty(id) ? `id: ${id}, ` : ``}
                    file_name: '${setting.file_name}',
                    file_path: '${setting.file_path}', remove: 'fixed'})">
                        <i class="bi bi-trash-fill"></i> ลบ
                    </a>`;
            }

            html = `<div class="col-12">
                        <div class="card card-body-muted">
                            <div class="bs-row">
                                <div class="col-12">
                                    ${file_name}
                                    ${onclick}
                                </div>
                            </div>
                        </div>
                    </div>`;

            return html;
        } else if (
            $.inArray(ref.app, ['awards/application', 'awards/pre-screen', 'estimate/onsite']) !== -1 &&
            ref.path == 'images'
        ) {
            img = `${window.uploadFileUrl}${setting.file_path}`;

            if (
                (ref.app == 'awards/application' && $.inArray(Number(register.status), [1, 4]) !== -1) ||
                (ref.app == 'awards/pre-screen' && psc.status == 'draft') ||
                (
                    ref.app == 'estimate/onsite'
                    && (
                        $.inArray(Number(getStageStatus()), [6, 7]) === -1
                        && getIsFinish() != 'finish'
                    )
                )
            ) {
                if (ref.app == 'estimate/onsite' && ref.position == 'camera') {
                    html = `<div class="list">
                                <img src="${img}" onclick="zoomImages(this)">
                            </div>`;
                } else {
                    onclick = `onclick="removeFile('${input}',{`;

                    if (ref.app == 'awards/application') {
                        onclick += `id: '${id}',`;
                    }

                    onclick += `file_name: '${setting.file_name}',`;
                    onclick += `file_path: '${setting.file_path}',`;
                    onclick += `remove: 'fixed'});"`;

                    html = `<div class="card card-left mt-1 mb-1">
                                <img src="${img}" class="card-img-left">
                                <div class="card-body">
                                    <div class="bs-row">
                                        <span class="fs-file-name fw-semibold">
                                            ${setting.file_original}
                                        </span>
                                    </div>
                                    <div class="bs-row">
                                        <div class="col-12">
                                            <span style="font-size: 14px;" class="text-muted">
                                                ${setting.file_size}MB
                                            </span>
                                            <a href="javascript:void(0);" ${onclick} class="fs-file-remove float-end" title="ลบไฟล์">
                                                <i class="bi bi-trash-fill"></i> ลบ
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                }

                return html;
            } else if (ref.app == 'awards/pre-screen' && psc.status == 'reject') {
                html = { input: '', ablum: '' };

                onclick = `onclick="removeFile('${input}',{`;
                onclick += `file_name: '${setting.file_name}',`;
                onclick += `file_path: '${setting.file_path}',`;
                onclick += `remove: 'fixed'});"`;

                html.input = `<div class="card card-left mt-1 mb-1">
                                <img src="${img}" class="card-img-left">
                                <div class="card-body">
                                    <div class="bs-row">
                                        <span class="fs-file-name fw-semibold">
                                        ${setting.file_original}</span>
                                    </div>
                                    <div class="bs-row">
                                        <div class="col-12">
                                            <span style="font-size: 14px;" class="text-muted">
                                                ${setting.file_size}MB</span>
                                            <a href="javascript:void(0);" ${onclick} class="fs-file-remove float-end" title="ลบไฟล์">
                                                <i class="bi bi-trash-fill"></i> ลบ
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>`;


                html.ablum = `<div class="ablumbox-col">
                                <div class="ablum-mainimg">
                                    <div class="ablum-mainimg-scale">
                                        <img src="${img}" class="ablum-img" onclick="zoomImages(this)">
                                    </div>
                                </div>
                            </div>`;

                return html;
            } else {
                html = `<div class="ablumbox-col">
                            <div class="ablum-mainimg">
                                <div class="ablum-mainimg-scale">
                                    <img src="${img}" class="ablum-img" onclick="zoomImages(this)">
                                </div>
                            </div>
                        </div>`;
                return html;
            }
        }

    },
}

const clearBtnRemoveFile = (target, app, input) => {
    let ref;

    switch (target) {
        case 'all':
            $.each(referance, (key, ref) => {
                if (ref.app == app) {
                    $(ref.btnrm).hide();
                }
            });
            break;
        case 'by-input':
            ref = getReferance(input);
            $(ref.btnrm).hide();
            break;
        case 'show-input':
            ref = getReferance(input);
            $(ref.btnrm).show();
            break;
    }
}

const setBtnUploadFile = (input) => {
    const ref = getReferance(input);
    const btn = ref.btn;
    const maxUpload = Number(ref.maxUpload);
    let length;

    switch (ref.app) {
        case 'awards/application':
            if (Number(register.count[ref.pointer[1]]) >= maxUpload) {
                $(btn).hide();
            } else { $(btn).show(); }
            break;
        case 'awards/pre-screen':
            pointer = psc.getPointer();
            if (pointer.cate == -1) { pointer.cate = 0; }
            if (pointer.seg == -1) { pointer.seg = 0; }

            length = psc.questions[pointer.cate].question[pointer.seg][ref.position].length;
            if (length >= maxUpload) {
                $(btn).hide();
            } else { $(btn).show(); }
            psc.waitDraft('finish');
            break;
        case 'estimate/onsite':
            pointer = getPointer();
            if (pointer.cate == -1) { pointer.cate = 0; }
            if (pointer.seg == -1) { pointer.seg = 0; }
            length = dataset[pointer.cate].question[pointer.seg].estFiles[ref.position].length;
            if (length >= maxUpload) {
                $(btn).hide();
            } else { $(btn).show(); }
            waitDraft('finish');
            break;
    }
}

const checkRequireFiles = (app) => {
    let check = true;

    $.each(referance, (rk, rv) => {
        if (app == rv.app) {
            if (!empty(rv.require) && rv.require) {
                if (!empty(rv.pointer[3])) {
                    if (
                        Number(register.formData.step1.appType) == rv.pointer[2]
                        && Number(register.formData.step1.appTypeSub) == rv.pointer[3]
                    ) {
                        if (register.count[rv.pointer[1]] <= 0) {
                            console.log(4,register.count[rv.pointer[1]])
                            check = false;
                        }
                    }
                } else {
                    if (Number(register.formData.step1.appType) == rv.pointer[2]) {
                        if (rv.pointer[2] == 1) {
                            if (rv.pointer[1] == 'businessCert') {
                                if (!empty(register.formData.step5.manageBy)) {
                                    if (Number(register.formData.step5.manageBy) != 1) {
                                        if (register.count[rv.pointer[1]] <= 0) {
                                            check = false;
                                        }
                                    }
                                }
                            }
                            else if (register.count[rv.pointer[1]] <= 0) {
                                check = false;
                            }
                        }
                        else if (rv.pointer[2] == 2) {
                            if (rv.pointer[1] == 'buildExtF') {
                                const buildExt = Number(register.formData.step5.buildExt);
                                if (buildExt == 1) {
                                    if (register.count[rv.pointer[1]] <= 0) {
                                        check = false;
                                    }
                                }
                            }
                            else if (register.count[rv.pointer[1]] <= 0) {
                                check = false;
                            }
                        }
                        else if (rv.pointer[2] == 3) {
                            if (rv.pointer[1] == 'outlander') {
                                const inpOutlander = Number(register.formData.step5.inpOutlander);
                                if (inpOutlander == 1) {
                                    if (register.count[rv.pointer[1]] <= 0) {
                                        check = false;
                                    }
                                }
                            }
                            else if (register.count[rv.pointer[1]] <= 0) {
                                check = false;
                            }
                        }
                        else if (register.count[rv.pointer[1]] <= 0) {
                            check = false;
                        }
                    }
                }
            }
        }
    });

    return check;
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
    ablum: '#attach-file-step1-paper',
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
    ablum: '#attach-file-step1-detail',
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
    label: '#step1-images-label',
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
    ablum: '#attach-file-step5-landOwner',
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
    ablum: '#attach-file-step5-businessCert',
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
    ablum: '#attach-file-step5-otherCert',
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
    ablum: '#attach-file-step5-bussLicenseFiles',
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
    ablum: '#attach-file-step5-EIAreport',
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
    input: '#step5-buildExt',
    pointer: ['step5', 'buildExtF', 2],
    btn: '#step5-buildExt-btn',
    btnrm: '#step5-buildExt-remove',
    show: '#step5-buildExt-list',
    ablum: '#attach-file-step5-buildExt',
    label: '#step5-buildExt-label',
    api: '/inner-api/app/upload',
    position: 'buildExtFiles',
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
    ablum: '#attach-file-step5-otherT2Cert',
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
    pointer: ['step5', 'spaCert', 3],
    btn: '#step5-spaCert-btn',
    btnrm: '#step5-spaCert-remove',
    show: '#step5-spaCert-list',
    ablum: '#attach-file-step5-spaCert',
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
    ablum: '#attach-file-step5-effluent',
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
    pointer: ['step5', 'wellnessCert', 3, 12],
    btn: '#step5-wellnessCert-btn',
    btnrm: '#step5-wellnessCert-remove',
    show: '#step5-wellnessCert-list',
    ablum: '#attach-file-step5-wellnessCert',
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
    pointer: ['step5', 'spaManger', 3, 11],
    btn: '#step5-spaManger-btn',
    btnrm: '#step5-spaManger-remove',
    show: '#step5-spaManger-list',
    ablum: '#attach-file-step5-spaManger',
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
    pointer: ['step5', 'titleDeed', 3],
    btn: '#step5-titleDeed-btn',
    btnrm: '#step5-titleDeed-remove',
    show: '#step5-titleDeed-list',
    ablum: '#attach-file-step5-titleDeed',
    label: '#step5-titleDeed-label',
    api: '/inner-api/app/upload',
    position: 'titleDeedFiles',
    require: true,
    path: 'paper',
    app: 'awards/application',
    maxUpload: 5,
    maxSize: 15
},
{
    input: '#step5-outlander',
    pointer: ['step5', 'outlander', 3],
    btn: '#step5-outlander-btn',
    btnrm: '#step5-outlander-remove',
    show: '#step5-outlander-list',
    ablum: '#attach-file-step5-outlander',
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
    pointer: ['step5', 'guideCert', 4],
    btn: '#step5-guideCert-btn',
    btnrm: '#step5-guideCert-remove',
    show: '#step5-guideCert-list',
    ablum: '#attach-file-step5-guideCert',
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
    ablum: '#attach-file-step5-otherT3',
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
    ablum: '#attach-file-step5-EffluentT3',
    label: '#step5-EffluentT3-label',
    api: '/inner-api/app/upload',
    position: 'EffluentT3Files',
    path: 'paper',
    app: 'awards/application',
    maxUpload: 5,
    maxSize: 15
},
{
    input: '#step5-guideOldCert',
    pointer: ['step5', 'guideOldCert', 4],
    btn: '#step5-guideOldCert-btn',
    btnrm: '#step5-guideOldCert-remove',
    show: '#step5-guideOldCert-list',
    ablum: '#attach-file-step5-guideOldCert',
    label: '#step5-guideOldCert-label',
    api: '/inner-api/app/upload',
    position: 'guideOldCertFiles',
    require: true,
    path: 'paper',
    app: 'awards/application',
    maxUpload: 5,
    maxSize: 15
},
{
    input: '#step5-titleDeedT4',
    pointer: ['step5', 'titleDeedT4', 4],
    btn: '#step5-titleDeedT4-btn',
    btnrm: '#step5-titleDeedT4-remove',
    show: '#step5-titleDeedT4-list',
    ablum: '#attach-file-step5-titleDeedT4',
    label: '#step5-titleDeedT4-label',
    api: '/inner-api/app/upload',
    position: 'gtitleDeedT4Files',
    require: true,
    path: 'paper',
    app: 'awards/application',
    maxUpload: 5,
    maxSize: 15
},
{
    input: '#step5-otherT4Cert',
    pointer: ['step5', 'otherT4Cert'],
    btn: '#step5-otherT4Cert-btn',
    btnrm: '#step5-otherT4Cert-remove',
    show: '#step5-otherT4Cert-list',
    ablum: '#attach-file-step5-otherT4Cert',
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
    label: '#images-label',
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
    ablum: '#attach-file-list',
    label: '#file-label',
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
    btnrm: '#etm-images-remove',
    show: '#etm-images-list',
    ablum: '#etm-images-ablum',
    label: '#images-label',
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
    maxUpload: 10,
    maxSize: 10
},
{
    input: '#etm-file',
    pointer: ['', 'paper'],
    btn: '#etm-file-btn',
    btnrm: '#etm-file-remove',
    show: '#etm-file-list',
    ablum: '#attach-etm-file-list',
    label: '#etm-file-label',
    api: '/inner-api/estimate/onsite/files/upload',
    position: 'paper',
    path: 'paper',
    app: 'estimate/onsite',
    maxUpload: 5,
    maxSize: 15
},
];