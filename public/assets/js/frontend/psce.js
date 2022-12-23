var appid, sp, tycoon, dataset, assign,
    pointer     = { cate: -1, seg: -1 }
    haveRequest = false;

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

const init = () =>{
    loading('show');

    api({ method: 'get', url: '/inner-api/boards/estimate/'+appid })
    .then((rs) => {
        tycoon = rs.tycoon;     
        dataset = rs.data;  
        haveRequest = rs.request;
        
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

const setRequest = () => {
    const st = {
        method: 'post',
        url: '/inner-api/estimate/pre-screen/request',
        data: {
            application_id: appid
        }
    }

    api(st).then((rs) => {
        let title, msg;

        $('#modal-add-paper').modal('hide');
        sp.status = 3;

        if(rs.result == 'success'){
            title = 'ส่งคำขอข้อมูลเพิ่มเติมแล้ว';
            msg = 'กรุณารอผู้ประกอบการตอบกลับ (ภายใน 3 วัน)<br>ท่านจึงจะสามารถกลับมาประเมินต่อได้';
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

    let arrayScore = [];
    
    $.each(assign,(ak,av) => {        
        let index = av-1;

        if(av == 1){ 
            te = Number(dataset[index].group.score_prescreen);
            tscore += Number(dataset[index].group.score_prescreen);
        }
        else if(av == 2){ 
            sb = Number(dataset[index].group.score_prescreen);
            tscore += Number(dataset[index].group.score_prescreen);
        }
        else{
            rs = Number(dataset[index].group.score_prescreen);
            tscore += Number(dataset[index].group.score_prescreen);
        }

        $.each(dataset[index].question,(qk,qv) => {
            if(!empty(qv.score_pre)){
                arrayScore.push({
                    appId: appid,
                    stage: 1,
                    assign: av,
                    assign_total: dataset[index].group.score_prescreen,
                    est_id: qv.est_id,
                    ques_id: qv.id,
                    estFiles: qv.estFiles,
                    comment_pre: qv.comment_pre,
                    note_pre: qv.note_pre,
                    estimate_by: qv.estimate_by,
                    score_pre: qv.score_pre,
                    pre_score: qv.pre_score,
                    pre_origin: qv.score_pre_origin,
                    weight: qv.weight,
                });

                if(av == 1){ 
                    tescore += Number(qv.score_pre);
                    ttescore += Number(qv.pre_score);
                }
                else if(av == 2){ 
                    sbscoe += Number(qv.score_pre);
                    tsbscoe += Number(qv.pre_score);
                }
                else{
                    rsscore += Number(qv.score_pre);
                    trsscore += Number(qv.pre_score);
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
            + '</span> คะแนน',
        text: 'กรุณาตรวจสอบความถูกต้องก่อนส่งผลประเมินเข้าระบบ',
        button: {
            confirm: 'ส่งผลประเมินเข้าระบบ',
            cancel: 'ยกเลิก'
        }
    })
    .then((rs) => {
        if(rs.status){
            loading('show');

            const st = {
                method: 'post',
                url: '/inner-api/estimate/pre-screen/complete',
                data: {
                    appId: appid,
                    stage: 1,
                    score_te: stescore,
                    score_sb: ssbscore,
                    score_rs: srsscore,
                    score_tt: sscore,
                    sourcs: arrayScore
                }
            }

            api(st).then((rs) => {
                loading('hide');

                if(rs.result == 'error_login'){
                    alert.login();
                }
                else if(rs.result == 'error'){
                    alert.show('warning','ไม่สามารถส่งผลประเมินเข้าระบบได้',rs.message);
                    waitDraft('finish');
                }
                else {
                    alert.show('success', 'ส่งผลประเมินเข้าระบบเรียบร้อยแล้ว', '').then(() => {
                        window.location.reload();
                    });
                    checkComplete();
                    waitDraft('finish');
                }
            });
        }
    });
}

const draft = (cate,seg) => {
    return new Promise(function(resolve, reject){
        waitDraft('wait');
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
                    if(st.data.action == 'create'){
                        dataset[cate].question[seg].est_id = rs.id;
                    }

                    dataset[cate].question[seg].estimate = false;
                    alert.toast({icon: 'success', title: 'บันทึกการประเมินแล้ว'});
                    resolve({ result: 'success' });        
                    waitDraft('finish');
                }
                else if(rs.result == 'error_login'){
                    alert.login();
                    resolve({ result: 'error' });
                } else {
                    alert.toast({icon: rs.result, title: rs.message});
                    resolve({ result: 'error' });        
                    waitDraft('finish');
                }
            });
        } else {
            resolve({ result: 'success' });      
            waitDraft('finish')
        }
    });
}

const waitDraft = sts => {
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
    }
}

const setQuestion = (cate,seg) => {    
    const regex = /<[^>]+>/gi;
    let point = getPointer(),
        changeCate = false;
        qcontent = '';
        
    draft(point.cate,point.seg).then(draftRes => {
        setPointer(cate,seg);

        if(point.cate != cate){
            $('.btn-form-step').removeClass('active');
            $('#tab-'+cate).addClass('active');
            changeCate = true;
            setDropdown(dataset[cate].question,cate,seg);
        }
        
        if(point.cate == -1){ point.cate = cate; }
        if(point.seg == -1){ point.seg = seg; }
        
        const category = dataset[cate];
        const question = category.question[seg];

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
                $('#sl-'+point.seg).removeClass('complete');
                $('#sl-'+point.seg).addClass('request');
            }
        }

        setPointer(cate,seg);

        if(regex.test(question.pre_eva)){
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
        esCmm.val(question.comment_pre);
        esNote.val(question.note_pre);    

        if(!empty(question.remark)){
            qRemark.html('หมายเหตุ : '+question.remark);
            qRemark.show();
        } else {
            qRemark.hide();
        }

        countChar($('#comment'))

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
            btnSave.attr('onclick','draft('+cate+','+seg+')');
            btnRequest.attr('onclick','draft('+cate+','+seg+')');
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

        let ap = ev = sc = '';
        const url = getBaseUrl();

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

        if(regex.test(question.pre_eva)){
            ev = question.pre_eva;
        } else {
            const eva = question.pre_eva.split(',');
        
            $.each(eva,(k,v) => {
                if(!empty(v)){
                    let val, tmp = v.split('.');
                    
                    if(tmp.length > 1) { val = tmp[0].trim()+'. '+tmp[1].trim(); }
                    else { val = tmp[0].trim(); }
    
                    if(v != ''){
                        ev += (
                            '<span class="txt-yellow title-comment">'
                            + val
                            + '</span><br>'
                        );
                    }
                }
            });
        }

        const sco = question.pre_scor.split(',');

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

                if(!empty(question.score_pre)){
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
                && $.inArray(Number(v.request_status),[0,1,2]) !== -1
            ){
                cp = 'request';
            } else {
                cp = !empty(v.score_pre) ? 'complete' : '';
            }
        } else {
            cp = 'hold';
        }
            
        cl = 'class="sl '+cp+'"';
        modal += '<li><a '+hr+' '+id+' '+cl+'> ข้อที่ '+v.no+'</a></li>';
        slt += '<option value="'+k+'">'+v.no+'</option>';
    });

    md.html(modal);
    mSelect.html(slt); 
    checkComplete();
}

const checkComplete = () => {
    const cp = assign.length;
    let ccp = ccr = rcp = 0
        isRequest = false;

    $.each(assign,(ak,av) => {
        let checkEmptyScore = true,
            checkRequest = false,
            index = av-1;
        let countNoQuestion = 0;
        let countFinish = 0;
        let countRequest = 0;
       
        $.each(dataset[index].question,(qk,qv) => {
            if(Number(qv.pre_status) == 1){
                countNoQuestion++;
                if(empty(qv.score_pre)){
                    checkEmptyScore = false;
                } else {
                    countFinish++;
                }

                if(qv.request_status === 0 || qv.request_status === '0'){
                    checkRequest = true;
                    countRequest++;
                }
            }
        });

        if((Number(countFinish) + Number(countRequest)) >= Number(countNoQuestion)){
            if(checkRequest){
                isRequest = true;;
            }

            ccr++
        }

        if(checkEmptyScore){
            $('tap-'+index).addClass('complete');
            ccp++;
        } else {
            $('tap-'+index).removeClass('complete');
        }
    });

    if(ccr < cp){
        // $('.btn-confirm-submit').prop('disabled',true);
        $('#btn-send-request').prop('disabled',true);
        $('#btn-send-request-modal').prop('disabled',true);
    } else {
        // $('.btn-confirm-submit').prop('disabled',false);
        if(isRequest){
            $('#btn-send-request').prop('disabled',false);
            $('#btn-send-request-modal').prop('disabled',false);
        } else {
            $('#btn-send-request').prop('disabled',true);
            $('#btn-send-request-modal').prop('disabled',true);
        }
    }

    if(ccp < cp){
        // $('.btn-confirm-submit').prop('disabled',true);
        $('#btn-send-estimate').prop('disabled',true);
    } else {
        // $('.btn-confirm-submit').prop('disabled',false);
        $('#btn-send-estimate').prop('disabled',false);
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
    dataset[point.cate].question[point.seg].score_pre = null;
    dataset[point.cate].question[point.seg].tscore_pre = null;
    dataset[point.cate].question[point.seg].estimate = true;
}

const calScore = (ele) => {
    const point = getPointer();
    const question = dataset[point.cate].question[point.seg];
    const maxscore = question.pre_score;
    const weight = question.weight;
    const selfscore = parseFloat(ele.value) * parseFloat(weight);
    const totalscore = selfscore / maxscore;    
    
    dataset[point.cate].question[point.seg].score_pre_origin = ele.value;
    dataset[point.cate].question[point.seg].score_pre = selfscore;
    dataset[point.cate].question[point.seg].tscore_pre = totalscore;
    dataset[point.cate].question[point.seg].estimate = true;
}

const getCurrentDate = () => {
    const date = new Date();
    const year = date.getFullYear();
    const month = date.getMonth()+1;
    const day = date.getDate();
    return year + '-' +
        ( month < 10 ? '0' : '') + month + '-' +
        ( day <10 ? '0' : '') + day;
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

esCmm.keyup(() => {
    const point = getPointer();
    dataset[point.cate].question[point.seg].comment_pre = esCmm.val();
    dataset[point.cate].question[point.seg].estimate = true;
});

esNote.keyup(() => {
    const point = getPointer();
    dataset[point.cate].question[point.seg].note_pre = esCmm.val();
    dataset[point.cate].question[point.seg].estimate = true;
});

qRequest.keyup(() => {
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
    
    mTNum.html(question.no);
    mNum.html(question.no);
    mSelect.val(point.seg);
    qRequest.val(question.request_list);
    countChar1($('#qRequest'))

    if($.inArray(Number(question.request_status),[1,2,3]) !== -1){
        qRequest.prop('readonly','readonly');

        if($.inArray(Number(question.request_status),[2,3]) !== -1){
            $('#rp-finish').show();
        } else {
            $('#rp-wait').show();
        }
    } else {
        qRequest.prop('readonly','');
    }

    $('#modal-add-paper').modal('show');
});

mSelect.change(() => {
    const point = getPointer();
    const question =  dataset[point.cate].question[mSelect.val()];
    mTNum.html(question.no);
    mNum.html(question.no);
    qRequest.val(question.request_list);
});

