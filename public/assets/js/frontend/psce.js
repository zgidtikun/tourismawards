var appid, sp, tycoon, dataset, assign, expireRequest,
    pointer     = { cate: -1, seg: -1 },
    haveRequest = false,
    lowcarbon   = false;

const btnSave   = $('#btn-save');
const btnBack   = $('#btn-back');
const btnNext   = $('#btn-next');
const btnReset  = $('#btn-reset');
const btnRequest= $('#btn-request');
const btnSMemo  = $('.btn-memosave');
const qTitle    = $('#qTitle');
const qSum      = $('#qSum');
const qNum      = $('#qNum');
const qSubject  = $('#qSubject');
const qRemark  = $('#qRemark');
const hSubject  = $('#hSubject');
const qReply    = $('#qReply');
const qAblum    = $('#qAblum');
const mTNum     = $('#mTNum');
const mNum      = $('#mNum');
const mSum      = $('#mSum');
const qEva      = $('#qEva');
const qSco      = $('#qSco');
const esCmm     = $('#comment');
const esNote    = $('#note');
const qRequest  = $('#qRequest');
const mSelect   = $('#mSelect');
const sRequest   = $('#sRequest');

const setPage = (id,stage,ass,er) => {
    appid = id;
    sp = stage;
    assign = ass;
    expireRequest = er == 1 ? false : true;
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
    .then(async(rs) => {
        tycoon      = rs.tycoon;     
        dataset     = rs.data;  
        haveRequest = rs.request;
        lowcarbon   = rs.lowcarbon
        
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

        if(lowcarbon){
            $('#tab-3').show();
        }
        
        loading('hide');        
        setQuestion(assign[0]-1,0);
        checkComplete();
    });
}

const setRequest = async() => {    
    await loading('show');
    const st = {
        method: 'post',
        url: '/inner-api/estimate/pre-screen/request',
        data: {
            application_id: appid
        }
    }

    api(st).then((rs) => {
        loading('hide');
        let title, msg;

        $('#modal-add-paper').modal('hide');
        sp.status = 3;

        if(rs.result == 'success'){
            title = 'ส่งคำขอข้อมูลเพิ่มเติมแล้ว';
            msg = 'กรุณารอผู้ประกอบการตอบกลับภายใน 72 ชั่วโมง<br>ท่านจึงจะสามารถกลับมาประเมินต่อได้';
        } else {
            title = 'ไม่สามารถส่งคำขอข้อมูลเพิ่มเติมได้';
            msg = rs.message;
        }

        alert.show(rs.result,title,msg).then((al) => {
            if(rs.result == 'success'){
                sp.status = 3;
                haveRequest = true;
                disabledForm();
            }
        });
    });
}

const setFinish = () => {
    let tscore, mscore, tescore, ttescore, sbscoe, 
        tsbscoe, rsscore, trsscore, 
        te, sb, rs;
        
    tscore = mscore = 0;
    tescore = sbscoe = rsscore = 0;
    ttescore = tsbscoe = trsscore = 0;
    lcbscore = 0;

    let estimateLowCarbon = false;
    let estimateMain = false;
    
    $.each(assign,(ak,av) => {        
        let index = av-1;

        if(av == 1){ 
            te = Number(dataset[index].group.score_prescreen);
            tscore += Number(dataset[index].group.score_prescreen);
            estimateMain = true; 
        }
        else if(av == 2){ 
            sb = Number(dataset[index].group.score_prescreen);
            tscore += Number(dataset[index].group.score_prescreen);
            estimateMain = true; 
        }
        else if(av == 3){
            rs = Number(dataset[index].group.score_prescreen);
            tscore += Number(dataset[index].group.score_prescreen);
            estimateMain = true; 
        }
        else {
            estimateLowCarbon = true; 
        }

        $.each(dataset[index].question,(qk,qv) => {
            if(!empty(qv.score_pre) && Number(qv.pre_status) == 1){
                if(av == 1){ 
                    tescore += Number(qv.score_pre_origin) *  Number(qv.weight);
                    ttescore += Number(qv.pre_score);
                }
                else if(av == 2){ 
                    sbscoe += Number(qv.score_pre_origin) *  Number(qv.weight);
                    tsbscoe += Number(qv.pre_score);
                }
                else if(av == 3){
                    rsscore += Number(qv.score_pre_origin) *  Number(qv.weight);
                    trsscore += Number(qv.pre_score);
                } else {
                    lcbscore += Number(qv.score_pre_origin);
                }             
            }
        });
    });
    
    let confirm_title = `ยืนยันการส่งผลประเมินเข้าระบบ`;

    if(estimateMain){
        const stescore = tescore != 0 ? ((tescore * te) / ttescore).toFixed(2) : 0;
        const ssbscore = sbscoe != 0 ? ((sbscoe * sb) / tsbscoe).toFixed(2) : 0;
        const srsscore = rsscore != 0 ? ((rsscore * rs) / trsscore).toFixed(2) : 0;
        const sscore = (parseFloat(stescore) + parseFloat(ssbscore) + parseFloat(srsscore)).toFixed(2);
        confirm_title += `\r\nคะแนนที่ประเมินคือ <span class="txt-yellow">${sscore}</span> คะแนน`;
    }

    if(estimateLowCarbon){
        confirm_title += `\r\nคะแนน Low Carbon คือ <span class="txt-yellow">${lcbscore}</span> คะแนน`;
    }

    alert.confirm({
        mode: 'confirm-main',
        icon: 'info',
        title: confirm_title,
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
                url: '/inner-api/estimate/pre-screen/complete',
                data: JSON.stringify({
                    data:{
                        appId: appid,
                        stage: 1,
                        lowcarbon: estimateLowCarbon
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

const save = (cate,seg) => {
    return new Promise(async (resolve, reject) => {
        await waitDraft('wait');
        if(cate == -1){ cate = 0; }
        if(seg == -1){ seg = 0; }
        
        const question = dataset[cate].question[seg];

        if(
            $.inArray(Number(question.request_status),[2,4]) !== -1 &&
            !empty(question.score_pre) && 
            Number(question.pre_status) == 1
        ){
            question.request_status = null;
            dataset[cate].question[seg].request_status = null;
        }

        const st = {
            method: 'post',
            url: '/inner-api/estimate/pre-screen/draft',
            data: {
                target: 'pre-screen',
                action: empty(question.est_id) ? 'create' : 'update',
                application_id: appid,
                question_id: question.id,
                est_id: question.est_id,
                answer_id: question.reply_id,
                score: question.score_pre,
                tscore: question.tscore_pre,
                comment: question.comment_pre,
                note: question.note_pre,
                score_origin: question.score_pre_origin,
                request_list: question.request_list,
                request_date: question.request_date,
                request_status: question.request_status,
            }
        };

        api(st).then((rs) => {
            if(rs.result == 'success'){
                dataset[cate].question[seg].est_id = rs.id;
                dataset[cate].question[seg].estimate_by = rs.by;
                dataset[cate].question[seg].estimate = false;

                if(
                    !empty(dataset[cate].question[seg].request_status) &&
                    $.inArray(Number(dataset[cate].question[seg].request_status),[0,1,2,4]) !== -1
                ){
                    $('#sl-'+seg).removeClass('active')
                    .removeClass('complete')
                    .removeClass('respond')
                    .addClass('request');
                    setReqestFiled(dataset[cate].question[seg]);
                }
                else if(!empty(dataset[cate].question[seg].score_pre_origin)){
                    $('#sl-'+seg)
                    .removeClass('active')
                    .removeClass('request')
                    .removeClass('respond')
                    .addClass('complete');
                } else {
                    $('#sl-'+seg)
                    .removeClass('complete')
                    .removeClass('request')
                    .removeClass('respond')
                    .addClass('active');
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
    return new Promise(async (resolve, reject) => {
        await waitDraft('wait');
        if(cate == -1){ cate = 0; }
        if(seg == -1){ seg = 0; }
        
        const question = dataset[cate].question[seg];

        if(question.estimate){      

            const st = {
                method: 'post',
                url: '/inner-api/estimate/pre-screen/draft',
                data: {
                    target: 'pre-screen',
                    action: empty(question.est_id) ? 'create' : 'update',
                    application_id: appid,
                    question_id: question.id,
                    est_id: question.est_id,
                    answer_id: question.reply_id,
                    score: question.score_pre,
                    tscore: question.tscore_pre,
                    comment: question.comment_pre,
                    note: question.note_pre,
                    score_origin: question.score_pre_origin,
                    request_list: question.request_list,
                    request_date: question.request_date,
                    request_status: question.request_status,
                }
            };

            api(st).then((rs) => {
                if(rs.result == 'success'){
                    dataset[cate].question[seg].est_id = rs.id;
                    dataset[cate].question[seg].estimate_by = rs.by;
                    dataset[cate].question[seg].estimate = false;
                    
                    if(
                        !empty(dataset[cate].question[seg].request_status) &&
                        $.inArray(Number(dataset[cate].question[seg].request_status),[0,1,2,4]) !== -1
                    ){
                        $('#sl-'+seg).removeClass('active')
                        .removeClass('complete')
                        .removeClass('respond')
                        .addClass('request');
                    }
                    else if(!empty(dataset[cate].question[seg].score_pre_origin)){
                        $('#sl-'+seg)
                        .removeClass('active')
                        .removeClass('request')
                        .removeClass('respond')
                        .addClass('complete');
                    } else {
                        $('#sl-'+seg)
                        .removeClass('complete')
                        .removeClass('request')
                        .removeClass('respond')
                        .addClass('active');
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
        if(sts == 'wait'){
            $('#tab-0').addClass('disabled');
            $('#tab-1').addClass('disabled');
            $('#tab-2').addClass('disabled');
            $('.btn-choice').addClass('disabled');
            $('.btn-confirm-submit').prop('disabled',true);
            $('[name=score]').prop('disabled',true);
            esCmm.prop('readonly','readyonly');
            qRequest.prop('readonly','readyonly');
            esNote.prop('readonly','readyonly');
            btnBack.prop('disabled',true);
            btnNext.prop('disabled',true);
            btnSMemo.prop('disabled',true);
            btnSave.prop('disabled',true);
            btnReset.prop('disabled',true);
            btnRequest.prop('disabled',true);
            resolve({finish: true});
        } else {
            $('#tab-0').removeClass('disabled');
            $('#tab-1').removeClass('disabled');
            $('#tab-2').removeClass('disabled');
            $('.btn-choice').removeClass('disabled');
            $('.btn-confirm-submit').prop('disabled',false);
            $('[name=score]').prop('disabled',false);
            esCmm.prop('readonly','');
            qRequest.prop('readonly','');
            esNote.prop('readonly','');
            btnBack.prop('disabled',false);
            btnNext.prop('disabled',false);
            btnSMemo.prop('disabled',false);
            btnSave.prop('disabled',false);
            btnReset.prop('disabled',false);
            btnRequest.prop('disabled',false);             
            checkComplete();
            resolve({finish: true});
        }
    });
}

const setQuestion = (cate,seg) => {    
    const regex = /<[^>]+>/gi;
    let point = getPointer(),
        changeCate = false;
        qcontent = '';

    if(point.cate != cate){
        changeCate = true;
    }
    
    draft(point.cate,point.seg).then(draftRes => {
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
        // console.log(question,`QuestionID: ${question.id}, Origin: ${question.score_pre_origin}, Weignt: ${question.weight}, Full score: ${question.pre_score}`);
        $('.hide-choice').hide();
        $('body').removeClass('lockbody');

        $('.sl').removeClass('active');
        
        if(!$('#sl-'+seg).hasClass('complete') && !$('#sl-'+seg).hasClass('request')){
            $('#sl-'+seg).addClass('active');
        }

        if(!changeCate){
            if(
                dataset[point.cate].question[point.seg].request_status === null
                || Number(dataset[point.cate].question[point.seg].request_status) === 3
            ){
                if(
                    empty(dataset[point.cate].question[point.seg].score_pre)
                ){
                    $('#sl-'+point.seg).removeClass('complete');
                } else {
                    $('#sl-'+point.seg).addClass('complete');
                }
            } else {
                const request_status = Number(dataset[point.cate].question[point.seg].request_status);
                $('#sl-'+point.seg).removeClass('complete');
                if(request_status == 0 || request_status == 1){
                    $('#sl-'+point.seg).addClass('request');
                } else {
                    $('#sl-'+point.seg).addClass('respond');
                }
            }
        }

        setPointer(cate,seg);
        sRequest.hide();
        
        if(!empty(question.request_status)){
            if($.inArray(Number(question.request_status),[0,1,2,4]) !== -1){
                if($.inArray(Number(question.request_status),[0,1]) !== -1){
                    sRequest.html('คุณมีการขอข้อมูลเพิ่มเติมในข้อนี้');
                } 
                else if(Number(question.request_status) == 2){
                    sRequest.html('คุณได้รับการตอบกลับข้อมูลเพิ่มเติมในข้อนี้แล้ว');
                }
                else {
                    sRequest.html('คุณยังไม่ได้รับการตอบกลับข้อมูลเพิ่มเติมในข้อนี้');
                }

                sRequest.show();
            }
        }  
        
        if(cate != 3){
            qTitle.html(category.group.name);
        } else {
            qTitle.html(question.criteria_topic);
        }
        
        qTitle.attr('data-id',question.reply_id);
        qSum.html(category.question.length);
        mSum.html(category.question.length);
        qNum.html(question.no);
        mTNum.html(question.no);
        mNum.html(question.no);
        qSubject.html(question.no+'. '+question.question);
        esCmm.val(question.comment_pre);
        esNote.val(question.note_pre);    

        if(!empty(question.remark)){
            qRemark.html('หมายเหตุ : '+question.remark);
            qRemark.show();
        } else {
            qRemark.hide();
        }

        countChar($('#comment'))

        if(question.images.length > 0){
            qAblum.removeClass('text-center');                                        
            qAblum.addClass('ablumbox');
            let ap = '';

            $.each(question.images,(k,v) => {
                ap += (
                    '<div class="ablumbox-col">'
                        + '<div class="ablum-mainimg">'
                            + '<div class="ablum-mainimg-scale">'
                                + '<img src="'+window.uploadFileUrl+v.file_path+'" '
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
                                    <a href="${window.uploadFileUrl+paper.file_path}" target="_blank">
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

        let back = seg != 0 ? seg-1 : seg,
            next = seg != category.question.length-1 ? seg+1 : seg;

        btnBack.attr('onclick','setQuestion('+cate+','+back+')');
        btnNext.attr('onclick','setQuestion('+cate+','+next+')');
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

        qReply.html(question.reply);

        if(Number(question.pre_status) == 1 && $.inArray(cate+1,assign) !== -1){
            $('.none-estimate').hide();
            $('.none-assign').hide();
            $('.is-estimate').show();
            btnSave.attr('onclick','save('+cate+','+seg+')');
            btnRequest.attr('onclick','save('+cate+','+seg+')');
            btnSave.show();
            btnReset.show();
        } else {
            if($.inArray(cate+1,assign) !== -1){
                $('.none-assign').hide();
                $('.none-estimate').show();
            } else {
                $('.none-assign').show();
                $('.none-estimate').hide();
            }

            $('.is-estimate').hide();
            btnSave.hide();    
            btnReset.hide();  
            return;
        }

        countChar1($('#qRequest'));

        let ev = sc = '';

        if(regex.test(question.pre_eva)){
            ev = question.pre_eva;
        } else {            
            ev = '<span class="title-comment">'
                    + question.pre_eva
                '</span>';
        }

        const sco = question.pre_scor.split('|');

        sc += '<h4>เกณฑ์การให้คะแนนรอบ Pre-Screen</h4>';
        
        $.each(sco,(k,v) => {
            if(!empty(v)){
                let tmp = v.split('='),
                    dis = ck = '';
                    
                if(
                    $.inArray(Number(getStageStatus()),[3,6,7]) !== -1
                ){
                    if(
                        getIsFinish() == 'finish' 
                        || (getIsFinish() == 'unfinish' && haveRequest)
                    ){
                        dis = 'disabled';
                    }
                }

                if(!empty(question.score_pre_origin)){
                    if(Number(question.score_pre_origin) == Number(tmp[0].trim())){
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

        qEva.html(ev);
        qSco.html(sc);     
        $('.regis-form-step')[0].scrollIntoView();
        disabledForm();
    });
}

const setDropdown = (qt,cate,seg) => {
    const md = $('#selection-list');
    let modal = slt = '';
    cate = cate == -1 ? 0 : cate;
    
    $.each(qt, function(k, v){
        let hr = 'href="javascript:setQuestion('+cate+','+k+');"',
            id = 'id="sl-'+k+'"',
            cp, cl;        
            
        if(Number(v.pre_status) == 1 && $.inArray(cate+1,assign) !== -1){            
            if(
                !empty(v.request_status)
                && $.inArray(Number(v.request_status),[0,1,2,4]) !== -1
            ){
                if($.inArray(Number(v.request_status),[2,4]) !== -1){
                    cp = 'respond';
                } else {
                    cp = 'request';
                }
            } else {
                cp = !empty(v.score_pre) ? 'complete' : '';
            }

            slt += '<option value="'+k+'">'+v.no+'</option>';
        } else {
            cp = 'hold';
        }
            
        cl = 'class="sl '+cp+'"';
        modal += '<li><a '+hr+' '+id+' '+cl+'> ข้อที่ '+v.no+'</a></li>';
    });

    md.html(modal);
    mSelect.html(slt); 
    checkComplete();
}

const checkComplete = () => {
    const cp = assign.length;
    let ccp = crq = rcp = 0,
        isRequest = false,
        isEmpty = false;

    $.each(assign,(ak,av) => {
        let checkEmptyScore = true,
            index = av-1;

        let countNoQuestion = 0;
        let countFinish = 0;
        let countRequest = 0;
       
        $.each(dataset[index].question,(qk,qv) => {
            if(Number(qv.pre_status) == 1){
                countNoQuestion++;
                let checkNotEmpty = true,
                    checkRequest = false;

                if(Number(qv.request_status) === 0 && qv.request_status !== null){
                    checkRequest = true;
                    isRequest = true;
                }
                
                if(empty(qv.score_pre)){
                    checkEmptyScore = false;
                    checkNotEmpty = false;
                    isEmpty = true;
                }

                if(checkNotEmpty || checkRequest){
                    countFinish++;
                }
            }
        });
        
        if(Number(countFinish) == Number(countNoQuestion)){            
            ccp++;
        }

        if(checkEmptyScore){
            $('#tab-'+index).addClass('complete');
        } else {
            $('#tab-'+index).removeClass('complete');
        }
    });

    let p = getPointer();    
    if(p.cate == -1){ p.cate = 0; }
    if(p.seg == -1){ p.seg = 0; }
    const request_status = dataset[p.cate].question[p.seg].request_status;
        
    if(!empty(request_status)){
        if($.inArray(Number(request_status),[0,1,2]) !== -1){
            if($.inArray(Number(request_status),[0,1]) !== -1){
                sRequest.html('คุณมีการขอข้อมูลเพิ่มเติมในข้อนี้');
            } 
            else if(Number(request_status) == 2){
                sRequest.html('คุณได้รับการตอบกลับข้อมูลเพิ่มเติมในข้อนี้แล้ว');
            }
            else {
                sRequest.html('คุณยังไม่ได้รับการตอบกลับข้อมูลเพิ่มเติมในข้อนี้');
            }

            sRequest.show();
        } else {
            sRequest.hide();
        }
    } else {
        sRequest.hide();
    }

    if(ccp < cp){
        $('#btn-send-request').prop('disabled',true);
        $('#btn-send-request-modal').prop('disabled',true);
        $('#btn-send-estimate').prop('disabled',true);
    } else {    
        if(isRequest){
            $('#btn-send-request').prop('disabled',false);
            $('#btn-send-request-modal').prop('disabled',false);
        } else {
            $('#btn-send-request').prop('disabled',true);
            $('#btn-send-request-modal').prop('disabled',true);
        }
        
        if(isEmpty || isRequest){
            $('#btn-send-estimate').prop('disabled',true);
        } else {
            $('#btn-send-estimate').prop('disabled',false);
        }
    }
    
    disabledForm();
}

const disabledForm = () => {    
    if($.inArray(Number(getStageStatus()),[3,6,7]) !== -1){
        if(
            getIsFinish() == 'finish' 
            || (getIsFinish() == 'unfinish' && haveRequest)
        ){
            $('.btn-confirm-submit').hide();        
            $('[name="score"]').prop('disabled','disabled');
            esCmm.prop('readonly','readyonly');
            qRequest.prop('readonly','readyonly');
            esNote.prop('readonly','readyonly');
            btnSave.hide();
            btnReset.hide();
            btnRequest.hide();
            btnSMemo.hide();
        }
    } 
    else if(getIsFinish() == 'finish') {
        $('.btn-confirm-submit').hide();        
        $('[name="score"]').prop('disabled','disabled');
        esCmm.prop('readonly','readyonly');
        qRequest.prop('readonly','readyonly');
        esNote.prop('readonly','readyonly');
        btnSave.hide();
        btnReset.hide();
        btnRequest.hide();
        btnSMemo.hide();
    }
}

const downloadFile = () => {
    const point = getPointer();
    if(dataset[point.cate].question[point.seg].paper.length > 0) {
        let url = getBaseUrl()+'/inner-api/answer/download/file';
        url += '/'+qTitle.attr('data-id')+'/paper';
        window.open(url,'_blank');
    } else {
        alert.show('warning','ไม่มีไฟล์ในรายการนี้','');
    }
}

const resetEstimate = (cate,seg) => {
    $('[name="score"]').prop('checked',false);
    esCmm.val('');

    const point = getPointer();
    dataset[point.cate].question[point.seg].comment_pre = null;
    dataset[point.cate].question[point.seg].score_pre_origin = null;
    dataset[point.cate].question[point.seg].score_pre = null;
    dataset[point.cate].question[point.seg].tscore_pre = null;
    dataset[point.cate].question[point.seg].estimate = true;
    checkComplete();
}

const calScore = (ele) => {
    const point = getPointer();
    const question = dataset[point.cate].question[point.seg];
    const request_status = dataset[point.cate].question[point.seg].request_status;
    let selfscore, totalscore;

    if(lowcarbon && Number(point.cate) == 3){
        totalscore = selfscore = 0;
    } else {
        const maxscore = question.pre_score;
        const weight = question.weight;
        selfscore = parseFloat(ele.value) * parseFloat(weight);
        totalscore = selfscore / maxscore;    
    }
    
    dataset[point.cate].question[point.seg].score_pre_origin = ele.value;
    dataset[point.cate].question[point.seg].score_pre = selfscore;
    dataset[point.cate].question[point.seg].tscore_pre = totalscore;
    dataset[point.cate].question[point.seg].estimate = true;

    if($.inArray(Number(request_status),[2,4]) !== -1){
        dataset[point.cate].question[point.seg].request_status = null;
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

esCmm.on('keypu change',() => {
    const point = getPointer();
    dataset[point.cate].question[point.seg].comment_pre = esCmm.val();
    dataset[point.cate].question[point.seg].estimate = true;
});

esNote.on('keypu change',() => {
    const point = getPointer();
    dataset[point.cate].question[point.seg].note_pre = esNote.val();
    dataset[point.cate].question[point.seg].estimate = true;
});

qRequest.on('keypu change',() => {
    const point = getPointer();

    if(!empty(qRequest.val())){
        dataset[point.cate].question[point.seg].request_list = qRequest.val();
        dataset[point.cate].question[point.seg].request_status = 0;
        dataset[point.cate].question[point.seg].request_date = getCurrentDate();
    } else {
        dataset[point.cate].question[point.seg].request_list = null;
        dataset[point.cate].question[point.seg].request_status = null;
        dataset[point.cate].question[point.seg].request_date = null;
    }
    
    dataset[point.cate].question[point.seg].estimate = true;
});

$('.btn-getdata').click(function() {
    const point = getPointer();
    const question =  dataset[point.cate].question[point.seg];
    setReqestFiled(question);
    
    mTNum.html(question.no);
    mNum.html(question.no);
    mSelect.val(point.seg);
    qRequest.val(question.request_list);
    countChar1($('#qRequest'))

    $('#modal-add-paper').modal('show');
});

mSelect.change(async() => {        
    const point = getPointer();
    
    if(dataset[point.cate].question[mSelect.val()].estimate){
        await save(point.cate,point.seg);
    }
    
    const question = dataset[point.cate].question[mSelect.val()];
    setReqestFiled(question);

    setQuestion(point.cate,mSelect.val());
    mTNum.html(question.no);
    mNum.html(question.no);
    qRequest.val(question.request_list);
});

const setReqestFiled = question => {    
    $('#rq-finish').hide();
    $('#rq-wait').hide();
    $('#rq-unfinish').hide();
    $('#rq-warning').hide();

    if(expireRequest){
        $('#rq-warning').show();
        $('#rq-warning-txt').html('หมดเวลาการขอข้อมูลเพิ่มเติมแล้ว');
        qRequest.prop('readonly','readonly');
    }
    else if(getIsFinish() == 'finish'){
        qRequest.prop('readonly','readonly'); 
    }
    else if(!empty(question.request_list)){
        if($.inArray(Number(question.request_status),[1,2,3,4]) !== -1){
            if(Number(question.request_status) == 1){
                $('#rq-wait').show();
                qRequest.prop('readonly','readonly');  
            }
            else if(Number(question.request_status) == 2) {
                $('#rq-finish').show();
                qRequest.prop('readonly',haveRequest ? 'readonly' : '');
            } 
            else if(Number(question.request_status) == 4) {
                $('#rq-unfinish').show();
                qRequest.prop('readonly',haveRequest ? 'readonly' : '');
            } else {     
                if(haveRequest){          
                    $('#rq-warning').show();
                    $('#rq-warning-txt').html('กำลังรอการตอบกลับจากสถานประกอบการ ไม่สามารถขอข้อมูลเพิ่มเติมได้');      
                    qRequest.prop('readonly','readonly');  
                }
                qRequest.prop('readonly',haveRequest ? 'readonly' : '');
            }
        }
        else {
            // if(Number(question.request_status) != 0){
            //     $('#rq-finish').show();
            // }
            qRequest.prop('readonly',haveRequest ? 'readonly' : '');
        }
    } else {      
        if(haveRequest){          
            $('#rq-warning').show();
            $('#rq-warning-txt').html('กำลังรอการตอบกลับจากสถานประกอบการ ไม่สามารถขอข้อมูลเพิ่มเติมได้');      
            qRequest.prop('readonly','readonly');  
        }
        else {
            qRequest.prop('readonly','');
        }
    }
}

