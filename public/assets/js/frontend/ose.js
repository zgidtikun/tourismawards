var appid, sp, tycoon, dataset, assign,
    pointer     = { cate: -1, seg: -1 };

const btnSave   = $('#btn-save');
const btnBack   = $('#btn-back');
const btnNext   = $('#btn-next');
const btnReset  = $('#btn-reset');
const btnSMemo  = $('.btn-memosave');
const qTitle    = $('#qTitle');
const qSum      = $('#qSum');
const qNum      = $('#qNum');
const qSubject  = $('#qSubject');
const qRemark  = $('#qRemark');
const hSubject  = $('#hSubject');
const qReply    = $('#qReply');
const qAblum    = $('#qAblum');
const cAblum    = $('#cAblum');
const mTNum     = $('#mTNum');
const mNum      = $('#mNum');
const mSum      = $('#mSum');
const qEva      = $('#qEva');
const qSco      = $('#qSco');
const esCmm     = $('#comment');
const esNote    = $('#note');
const mSelect   = $('#mSelect');

const setPage = (id,stage,ass) => {
    appid = id;
    sp = stage;
    assign = ass;
    init();
}

const getPointer = () => {
    return pointer;
}

const setPointer = (cate,seg) => {
    pointer = { cate: cate, seg: seg };
}

const getStageStatus = () => {
    return sp.status;
}

const getIsFinish = () => {
    return sp.isFinish;
}

const init = async() =>{
    await loading('show');

    api({ method: 'get', url: '/inner-api/boards/estimate/'+appid })
    .then((rs) => {
        tycoon = rs.tycoon;     
        dataset = rs.data;

        if(
            $.inArray(Number(getStageStatus()),[1,2,3,4,5]) !== -1
            && getIsFinish() != 'finish'
        ){
            $('.attach-file').remove();             
        } else { 
            $('.regis-form-data textarea, #note').prop('readonly','readonly');
            $('.btn-main, .btn-action, .selecter-file, .bfd-dropfield').remove();
            $('.image-gallery .remove, .btn-memosave').remove();
            $('#btn-reset, #btn-save, .btn-confirm-submit').remove();
        }
        
        let tmp = tycoon.t_name.split('(');
        tycoon.t_name = tmp[0].trim();

        tmp = tycoon.ts_name.split('(');
        tycoon.ts_name = tmp[0].trim();

        $('#tyCode').html(tycoon.code);      
        $('#tyType').html(tycoon.t_name);    
        $('#tyName').html(tycoon.knitter_name);    
        $('#tyAttnTh').html(tycoon.attn_th);    
        $('#tyTSbu').html(tycoon.ts_name);    
        $('#tyEmail').html(tycoon.knitter_email);    
        $('#tyAttnEn').html(tycoon.attn_en);    
        $('#tyUdat').html(tycoon.send_date);    
        $('#tyTel').html(tycoon.knitter_tel);
        
        loading('hide');
        setQuestion(assign[0]-1,0);
        checkComplete();
    });
}

const save = (cate,seg) => {
    return new Promise(async(resolve, reject) => {
        await waitDraft('wait');
        if(cate == -1){ cate = 0; }
        if(seg == -1){ seg = 0; }

        const question = dataset[cate].question[seg];

        const st = {
            method: 'post',
            url: '/inner-api/estimate/onsite/draft',
            data: {
                target: 'onsite',
                action: empty(question.est_id) ? 'create' : 'update',
                application_id: appid,
                question_id: question.id,
                est_id: question.est_id,
                answer_id: question.reply_id,
                score_origin: question.score_onsite_origin,
                score: question.score_onsite,
                tscore: question.tscore_onsite,
                comment: question.comment_onsite,
                note: question.note_onsite,
            }
        };
        
        api(st).then((rs) => {
            if(rs.result == 'success'){
                dataset[cate].question[seg].est_id = rs.id;
                dataset[cate].question[seg].estimate_by = rs.by;
                dataset[cate].question[seg].estimate = false;

                if(!empty(dataset[cate].question[seg].score_onsite)){
                    $('#sl-'+seg).removeClass('active');
                    $('#sl-'+seg).addClass('complete');
                }
                
                alert.toast({icon: 'success', title: 'บันทึกการประเมินแล้ว'});    
                waitDraft('finish');
                resolve({ result: 'success' });    
            }
            else if(rs.result == 'error_login'){
                alert.login();
                resolve({ result: 'error' });
            } else {
                alert.toast({icon: rs.result, title: rs.message});      
                waitDraft('finish');
                resolve({ result: 'error' });  
            }
        });
    });
}

const draft = (cate,seg) => {
    return new Promise(async(resolve, reject) => {
        await waitDraft('wait');
        if(cate == -1){ cate = 0; }
        if(seg == -1){ seg = 0; }

        const question = dataset[cate].question[seg];

        if(question.estimate){

            const st = {
                method: 'post',
                url: '/inner-api/estimate/onsite/draft',
                data: {
                    target: 'onsite',
                    action: empty(question.est_id) ? 'create' : 'update',
                    application_id: appid,
                    question_id: question.id,
                    est_id: question.est_id,
                    answer_id: question.reply_id,
                    score_origin: question.score_onsite_origin,
                    score: question.score_onsite,
                    tscore: question.tscore_onsite,
                    comment: question.comment_onsite,
                    note: question.note_onsite,
                }
            };
            
            api(st).then((rs) => {
                if(rs.result == 'success'){
                    dataset[cate].question[seg].est_id = rs.id;
                    dataset[cate].question[seg].estimate_by = rs.by;
                    dataset[cate].question[seg].estimate = false;

                    if(!empty(dataset[cate].question[seg].score_onsite)){
                        $('#sl-'+seg).removeClass('active');
                        $('#sl-'+seg).addClass('complete');
                    }
                    
                    alert.toast({icon: 'success', title: 'บันทึกการประเมินแล้ว'});    
                    waitDraft('finish');
                    resolve({ result: 'success' });    
                }
                else if(rs.result == 'error_login'){
                    alert.login();
                    resolve({ result: 'error' });
                } else {
                    alert.toast({icon: rs.result, title: rs.message});      
                    waitDraft('finish');
                    resolve({ result: 'error' });  
                }
            });
        } else {                 
            waitDraft('finish')
            resolve({ result: 'success' }); 
        }
    });
}

const waitDraft = sts => {
    return new Promise(function(resolve, reject){
        if(
            $.inArray(Number(getStageStatus()),[3,6,7]) === -1
            && getIsFinish() != 'finish'
        ){
            if(sts == 'wait'){
                $('#tab-0').addClass('disabled');
                $('#tab-1').addClass('disabled');
                $('#tab-2').addClass('disabled');
                $('#camera-remove').prop('disabled',true);
                $('.btn-choice').addClass('disabled');
                $('.btn-confirm-submit, .btn-file, .btn-action').prop('disabled',true);
                $('[name=score]').prop('disabled',true);
                esCmm.prop('readonly','readyonly');
                esNote.prop('readonly','readyonly');
                btnBack.prop('disabled',true);
                btnNext.prop('disabled',true);
                btnSMemo.prop('disabled',true);
                btnSave.prop('disabled',true);
                btnReset.prop('disabled',true);
                resolve({finish: true});
            } else {
                $('#tab-0').removeClass('disabled');
                $('#tab-1').removeClass('disabled');
                $('#tab-2').removeClass('disabled');
                $('#camera-remove').prop('disabled',false);
                $('.btn-choice').removeClass('disabled');
                $('.btn-confirm-submit, .btn-file, .btn-action').prop('disabled',false);
                $('[name=score]').prop('disabled',false);
                esCmm.prop('readonly','');
                esNote.prop('readonly','');
                btnBack.prop('disabled',false);
                btnNext.prop('disabled',false);
                btnSMemo.prop('disabled',false);
                btnSave.prop('disabled',false);
                btnReset.prop('disabled',false);        
                checkComplete();
                resolve({finish: true});
            }
        } else {
            resolve({finish: true});
        }
    });
}

const setFinish = () => {
    let tscore, mscore, tescore, ttescore, sbscoe, 
        tsbscoe, rsscore, trsscore, 
        te, sb, rs;

    tscore = mscore = cscore = 0;
    tescore = sbscoe = rsscore = 0;
    ttescore = tsbscoe = trsscore = 0;
    
    $.each(assign,(ak,av) => {
        
        let index = av-1;
        
        if(av == 1){ 
            te = Number(dataset[index].group.score_onsite);
            tscore += Number(dataset[index].group.score_onsite);
        }
        else if(av == 2){ 
            sb = Number(dataset[index].group.score_onsite);
            tscore += Number(dataset[index].group.score_onsite);
        }
        else{
            rs = Number(dataset[index].group.score_onsite);
            tscore += Number(dataset[index].group.score_onsite);
        }

        $.each(dataset[index].question,(qk,qv) => {
            if(!empty(qv.score_onsite) && Number(qv.onside_status) == 1){
                if(av == 1){ 
                    tescore += Number(qv.score_onsite_origin) *  Number(qv.weight);
                    ttescore += Number(qv.onside_score);
                }
                else if(av == 2){ 
                    sbscoe += Number(qv.score_onsite_origin) *  Number(qv.weight);
                    tsbscoe += Number(qv.onside_score);
                }
                else{
                    rsscore += Number(qv.score_onsite_origin) *  Number(qv.weight);
                    trsscore += Number(qv.onside_score);
                }
            }
        });
    });
    
    const stescore = tescore != 0 ? ((tescore * te) / ttescore).toFixed(2) : 0;
    const ssbscore = sbscoe != 0 ? ((sbscoe * sb) / tsbscoe).toFixed(2) : 0;
    const srsscore = rsscore != 0 ? ((rsscore * rs) / trsscore).toFixed(2) : 0;
    const sscore = (parseFloat(stescore) + parseFloat(ssbscore) + parseFloat(srsscore)).toFixed(2);
    
    alert.confirm({
        mode: 'confirm-main',
        icon: 'info',
        title: 'ยืนยันการส่งผลประเมินเข้าระบบ'
            + '<br>'
            + 'คะแนนที่ประเมินคือ <span class="txt-yellow">'
            + sscore
            + '</span> คะแนน'
            ,
        text: 'กรุณาตรวจสอบความถูกต้องก่อนส่งผลประเมินเข้าระบบ<br>หากส่งผลประเมินเข้าระบบแล้ว จะไม่สามารถกลับมาแก้ไขการประเมินได้',
        button: {
            confirm: 'ส่งผลประเมินเข้าระบบ',
            cancel: 'ยกเลิก'
        }
    })
    .then(async(rs) => {
        if(rs.status){
            await loading('show');

            const setting = {
                method: 'post',
                url: '/inner-api/estimate/onsite/complete',
                data:  JSON.stringify({
                    data:{
                        appId: appid,
                        stage: 2,
                        lowcarbon: false
                }})
            }

            const callback = await api(setting);
            await loading('hide');

            if(callback.result == 'error_login'){
                alert.login();
            }
            else if(callback.result == 'error'){
                alert.show('warning','ไม่สามารถส่งผลประเมินเข้าระบบได้',callback.message);
                waitDraft('finish');
            }
            else {
                await alert.show('success', 'ส่งผลประเมินเข้าระบบเรียบร้อยแล้ว', '');
                checkComplete();
                waitDraft('finish');
                window.location.href = `${getBaseUrl()}/boards`;
            }
        }
    });
}

const setQuestion = async(cate,seg) => {   
    const regex = /<[^>]+>/gi;
    let point = getPointer(),
        changeCate = false;
        qcontent = '';

    if(point.cate != cate){
        changeCate = true;
    }
        
    draft(point.cate,point.seg).then((draftRes) => {
        if(changeCate){
            $('.btn-form-step').removeClass('active');
            $('#tab-'+cate).addClass('active');
            $('#tab-'+cate)[0].scrollIntoView();
            setDropdown(dataset[cate].question,cate,seg);
        }

        if(point.cate == -1){ point.cate = cate; }
        if(point.seg == -1){ point.seg = seg; }

        qTitle.attr('data-id','');
        qSum.html('');
        mSum.html('');
        qNum.html('');
        mTNum.html('');
        mNum.html('');
        qSubject.html('');
        esCmm.val('');
        esNote.val(''); 
        qRemark.html('หมายเหตุ : ');
        qAblum.html('');        
        qEva.html('');
        qSco.html('');
        
        const category = dataset[cate];
        const question = category.question[seg];

        $('.hide-choice').hide();
        $('body').removeClass('lockbody');

        if(!changeCate){
            if(
                empty(dataset[point.cate].question[point.seg].score_onsite)
            ){
                $('#sl-'+point.seg).removeClass('active');
                $('#sl-'+point.seg).removeClass('complete');
            } else {
                $('#sl-'+point.seg).removeClass('active');
                $('#sl-'+point.seg).addClass('complete');
            }
        }

        if(
            !empty(question.score_onsite)
        ){
            $('#sl-'+seg).removeClass('active');
            $('#sl-'+seg).addClass('complete');
        } 
        else {
            $('#sl-'+seg).removeClass('complete');
            $('#sl-'+seg).addClass('active');
        }

        setPointer(cate,seg);

        if(regex.test(question.question)){
            qcontent = question.question;
        } else {        
            if(question.question.search('ระบุ,') !== -1){
                const qno = question.question.split(',');
                
                $.each(qno,(qk,qv) => {
                    if(qk != 0){
                        qcontent += '<br>&nbsp;&nbsp;&nbsp;&nbsp;';
                        qv = qv.trim();
                        s2p = qv.substr(0,2);
                        
                        if(isNaN(s2p)){
                            qcontent += '&bull;&nbsp;&nbsp;'+qv;
                        }else{
                            s2p = s2p.trim();
                            qv = qv.substr(2).trim();
                            // question.no+'.'+s2p+
                            qcontent += '&bull;&nbsp;&nbsp;'+qv;
                        }
                    } else {
                        qcontent += qv;
                    }
                });
            } else {
                qcontent = question.question;
            }
        }
        
        qTitle.attr('data-id',question.reply_id);
        qTitle.html(category.group.name);
        qSum.html(category.question.length);
        mSum.html(category.question.length);
        qNum.html(question.no);
        mTNum.html(question.no);
        mNum.html(question.no);
        qSubject.html(question.no+'. '+qcontent);
        esCmm.val(question.comment_onsite);
        esNote.val(question.note_onsite);    

        if(!empty(question.remark)){
            qRemark.html('หมายเหตุ : '+question.remark);
            qRemark.show();
        } else {
            qRemark.hide();
        }

        const url = getBaseUrl();

        if(question.images.length > 0){
            qAblum.removeClass('text-center');                                        
            qAblum.addClass('ablumbox');
            let ap = '';

            $.each(question.images,(k,v) => {
                ap += (
                    '<div class="ablumbox-col">'
                        + '<div class="ablum-mainimg">'
                            + '<div class="ablum-mainimg-scale">'
                                + '<img src="'+url+'/'+v.file_path+'" '
                                + 'class="ablum-img" onclick="zoomImages(this)">'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                );
            });        

            qAblum.html(ap);
        } else {
            qAblum.removeClass('ablumbox');                                        
            qAblum.addClass('text-center');
            qAblum.css('color','#000');
            qAblum.text('ไม่มีรูปแนบ');
        }

        const btnDownload = $(`.btn-download`);
        const listDownload = $(`#list-download`);

        if(question.paper < 1){           
            // btnDownload.addClass('btn-transparent disabled');
            // btnDownload.css('color','#000');
            // btnDownload.css('opacity','1');
            // btnDownload.html('ไม่มีไฟล์แนบ');
            btnDownload.show();
            listDownload.hide();
        } else {
            // btnDownload.removeClass('btn-transparent disabled');
            // btnDownload.css('color','#fff');
            // btnDownload.css('opacity','1');
            // btnDownload.html('ดาวน์โหลดไฟล์แนบ');
            let list = '';
            $.each(question.paper,(key,paper) => {
                list += `
                    <div class="col-12">
                        <div class="card card-body-muted">
                            <div class="bs-row">
                                <div class="col-12">
                                    <a href="${getBaseUrl()+'/'+paper.file_path}" target="_blank">
                                        <span class="fs-file-name">${paper.file_original}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            btnDownload.hide();
            listDownload.html(list);
            listDownload.show();
        }

        countChar($('#comment'))

        let back = seg != 0 ? seg-1 : seg,
            next = seg != category.question.length-1 ? seg+1 : seg;

        btnBack.attr('onclick','setQuestion('+cate+','+back+')');
        btnNext.attr('onclick','setQuestion('+cate+','+next+')');
        btnSave.attr('onclick','save('+cate+','+seg+')');
        btnSMemo.attr('onclick','draft('+cate+','+seg+')');

        if(seg == 0){
            btnBack.hide();
            btnNext.show();
        } else if(seg >= category.question.length-1){
            btnBack.show();
            btnNext.hide();
        } else {
            btnBack.show();
            btnNext.show();
        } 
        
        qSubject.html(question.no+'. '+question.question);
        qReply.html(question.reply);    

        if(Number(question.onside_status) == 1 && $.inArray(cate+1,assign) !== -1){
            $('.none-estimate').hide();
            $('.is-estimate').show();               
            $('.none-assign').hide();         
            btnSave.show();
            btnReset.show();
        } else {
            if($.inArray(cate+1,assign) !== -1){
                $('.none-estimate').show();
            } else {
                $('.none-assign').show();
            }

            $('.is-estimate').hide();   
            btnSave.hide();    
            btnReset.hide();  
            return;
        }   

        if(
            $.inArray(Number(getStageStatus()),[3,6,7]) !== -1
            || getIsFinish() == 'finish'
        ){
            const ablum_i = $('#etm-images-ablum');
            const ablum_c = $('#camera-gallery');
            
            showFiles.tycoon('#etm-file',question.estFiles.paper);

            if(question.estFiles.images.length > 0){
                ablum_i.removeClass('text-center');                                      
                ablum_i.addClass('ablumbox');
                showFiles.tycoon('#etm-images',question.estFiles.images);
            } else {
                ablum_i.removeClass('ablumbox');                                        
                ablum_i.addClass('text-center');
                ablum_i.css('color','#000');
                ablum_i.text('ไม่มีรูปแนบ');
            }

            if(question.estFiles.camera.length > 0){
                ablum_c.removeClass('text-center');                                      
                ablum_c.addClass('album');
                showFiles.tycoon('#camera',question.estFiles.camera);
            } else {
                ablum_c.removeClass('album');                                        
                ablum_c.addClass('text-center');
                ablum_c.css('color','#000');
                ablum_c.text('ไม่มีรูปแนบ');
            }
        } else {        
            showFiles.tycoon('#etm-images',question.estFiles.images);
            showFiles.tycoon('#etm-file',question.estFiles.paper);
            showFiles.tycoon('#camera',question.estFiles.camera);
        }

        let ev = sc = '';

        if(regex.test(question.os_eva)){
            ev = question.os_eva;
        } else {
            ev = '<span class="title-comment">'
                    + question.os_eva
                '</span>';
        }

        qEva.html(ev);        
        const sco = question.os_scor.split('|');
        
        sc += '<h4>เกณฑ์การให้คะแนนรอบ ลงพื้นที่</h4>';
        
        $.each(sco,(k,v) => {
            if(!empty(v)){
                let tmp = v.split('='),
                    dis = ck = '';
                    
                if(
                    $.inArray(Number(getStageStatus()),[3,6,7]) !== -1
                    || getIsFinish() == 'finish'
                ){
                    dis = 'disabled';
                }
                
                if(!empty(question.score_onsite_origin)){
                    if(Number(question.score_onsite_origin) == Number(tmp[0].trim())){
                        ck = 'checked';
                    }
                }

                sc += (
                    '<p><input type="radio" name="score" value="'+tmp[0].trim()+'" '
                    + dis+' '+ck
                    + ' onclick="calScore(this)">'
                        + tmp[1].trim()
                        + ' ('+tmp[0].trim()+' คะแนน)'
                    + '</p>'
                );
            }
        });

        qSco.html(sc);
        $('.regis-form-step')[0].scrollIntoView();
        checkComplete();
    });
}

const setDropdown = (qt,cate,seg) => {
    const md = $('#selection-list');
    let modal = slt = '';
    
    $.each(qt, function(k, v){
        let hr = 'href="javascript:setQuestion('+cate+','+k+');"',
            id = 'id="sl-'+k+'"',
            cp, cl;        
            
        if(Number(v.onside_status) == 1 && $.inArray(cate+1,assign) !== -1){
            cp = !empty(v.score_onsite) ? 'complete' : '';
        } else {
            cp = 'hold';
        }
            
        cl = 'class="sl '+cp+'"';
        modal += '<li><a '+hr+' '+id+' '+cl+'> ข้อที่ '+v.no+'</a></li>';
        slt += '<option value="'+k+'">'+v.no+'</option>';
    });

    md.html(modal);
    mSelect.html(slt);
}

const checkComplete = () => {
    let ccp = true;

    $.each(assign,(ak,av) => {
        let check = true,
            index = av-1;
            
        $.each(dataset[index].question,(qk,qv) => {
            if(Number(qv.onside_status) == 1){
                if(empty(qv.score_onsite)){
                    check = false;
                }
            }
        });

        if(check){
            $('#tab-'+index).addClass('complete');
        } else {
            $('#tab-'+index).removeClass('complete');
            ccp = false;
        }
    });
    
    if(!ccp){
        $('.btn-confirm-submit').prop('disabled',true);
    } else {
        $('.btn-confirm-submit').prop('disabled',false);
    }
    
    disabledForm();
}

const disabledForm = () => {
    if(
        $.inArray(Number(getStageStatus()),[3,6,7]) !== -1
        || getIsFinish() == 'finish'
    ){
        esCmm.prop('readonly','readyonly');
        esNote.prop('readonly','readyonly');
        btnSave.hide();
        btnSMemo.hide();
        btnReset.hide();
        $('.btn-confirm-submit').hide();
        $('.btn-main, .btn-action, .selecter-file, .bfd-dropfield').remove();
    }
}

const downloadFileAnswer = () => {
    const point = getPointer();
    if(dataset[point.cate].question[point.seg].paper.length > 0) {
        let url = getBaseUrl()+'/inner-api/answer/download/file';
        url += '/'+qTitle.attr('data-id')+'/paper';
        window.open(url,'_blank');
    } else {
        alert.show('warning','ไม่มีไฟล์ในรายการนี้','');
    }
}

const zoomImages = (el) => {
    Swal.fire({
        imageUrl: el.src,
        width: 800,
        height: 800,
        confirmButtonColor: '#DD3342',
        confirmButtonText: '<i class="fas fa-times"></i> ปิด',
        showCloseButton: true,
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    });
}

const resetEstimate = (cate,seg) => {
    $('[name="score"]').prop('checked',false);
    esCmm.val('');

    const point = getPointer();
    dataset[point.cate].question[point.seg].comment_onsite = null;
    dataset[point.cate].question[point.seg].score_onsite_origin = null;
    dataset[point.cate].question[point.seg].score_onsite = null;
    dataset[point.cate].question[point.seg].tscore_onsite = null;
    dataset[point.cate].question[point.seg].estimate = true;
    checkComplete();
}

const calScore = (ele) => {
    const point = getPointer();
    const question = dataset[point.cate].question[point.seg];
    const maxscore = question.onside_score;
    const weight = question.weight;
    let selfscore;

    if(Number(weight) > 0){
        selfscore = parseFloat(ele.value) * parseFloat(weight);
    } else {
        selfscore = ele.value;
    }

    const totalscore = selfscore / maxscore;
    
    dataset[point.cate].question[point.seg].score_onsite_origin = ele.value;    
    dataset[point.cate].question[point.seg].score_onsite = selfscore;
    dataset[point.cate].question[point.seg].tscore_onsite = totalscore;
    dataset[point.cate].question[point.seg].estimate = true;
}

esCmm.on('keypu change',() => {
    const point = getPointer();
    dataset[point.cate].question[point.seg].comment_onsite = esCmm.val();
    dataset[point.cate].question[point.seg].estimate = true;
    countChar($('#comment'));
});

esNote.on('keypu change',() => {
    const point = getPointer();
    dataset[point.cate].question[point.seg].note_onsite = esNote.val();
    dataset[point.cate].question[point.seg].estimate = true;
});
