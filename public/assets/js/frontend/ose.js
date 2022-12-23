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

const init = () =>{
    loading('show');

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

const draft = (cate,seg) => {
    return new Promise(function(resolve, reject){
        waitDraft('wait');
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
        }
    }
}

const setFinish = () => {
    let tscore, mscore, tescore, ttescore, sbscoe, 
        tsbscoe, rsscore, trsscore, 
        te, sb, rs;

    tscore = mscore = cscore = 0;
    tescore = sbscoe = rsscore = 0;
    ttescore = tsbscoe = trsscore = 0;

    let arrayScore = [];
    
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
            if(!empty(qv.score_onsite)){
                arrayScore.push({
                    appId: appid,
                    stage: 1,
                    assign: av,
                    assign_total: dataset[index].group.score_onsite,
                    est_id: qv.est_id,
                    ques_id: qv.id,
                    estFiles: qv.estFiles,
                    comment_onsite: qv.comment_onsite,
                    note_onsite: qv.note_onsite,
                    estimate_by: qv.estimate_by,
                    score_onsite: qv.score_onsite,
                    onside_score: qv.onside_score,
                    onsite_origin: qv.score_onsite_origin,
                    weight: qv.weight,
                });

                if(av == 1){ 
                    tescore += Number(qv.score_onsite);
                    ttescore += Number(qv.onside_score);
                }
                else if(av == 2){ 
                    sbscoe += Number(qv.score_onsite);
                    tsbscoe += Number(qv.onside_score);
                }
                else{
                    rsscore += Number(qv.score_onsite);
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
            // + '<br>'
            // + 'คะแนนการจัดการคาร์บอนต่ำคือ <span class="txt-yellow">'
            // + cscore
            // + '</span> คะแนน'
            ,
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
                url: '/inner-api/estimate/onsite/complete',
                data: {
                    appId: appid,
                    stage: 2,
                    score_te: stescore,
                    score_sb: ssbscore,
                    score_rs: srsscore,
                    score_tt: sscore
                }
            }

            api(st).then((rs) => {
                loading('hide');

                if(rs.result == 'error_login'){
                    alert.login();
                }
                else if(rs.result == 'error'){
                    alert.show(rs.result,'ไม่สามารถส่งผลประเมินเข้าระบบได้',rs.message);
                    waitDraft('finish');
                }
                else {
                    alert.show(rs.result, 'ส่งผลประเมินเข้าระบบเรียบร้อยแล้ว', '')
                    .then(() => {
                        window.location.reload();
                    });
                    waitDraft('finish');
                }
            });
        }
    });
}

const setQuestion = (cate,seg) => {   
    const regex = /<[^>]+>/gi;
    let point = getPointer(),
        qcontent = '';
        
    draft(point.cate,point.seg).then(draftRes => {
        
        waitDraft('finish');
        setPointer(cate,seg);

        if(point.cate != cate){
            $('.btn-form-step').removeClass('active');
            $('#tab-'+cate).addClass('active');
            setDropdown(dataset[cate].question,cate,seg);
        }

        if(point.cate == -1){ point.cate = cate; }
        if(point.seg == -1){ point.seg = seg; }
        
        const category = dataset[cate];
        const question = category.question[seg];

        $('.hide-choice').hide();
        $('body').removeClass('lockbody');

        $('.sl').removeClass('active');

        if(!$('#sl-'+seg).hasClass('complete')){
            $('#sl-'+seg).addClass('active');
        }
        
        if(
            !empty(dataset[point.cate].question[point.seg].score_onsite)
        ){
            $('#sl-'+point.seg).addClass('complete');
        } 
        else {
            $('#sl-'+point.seg).removeClass('complete');
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
        esCmm.val(question.comment_onsite);
        esNote.val(question.note_onsite);    

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
        btnSave.attr('onclick','draft('+cate+','+seg+')');
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
        
        showFiles.tycoon('#etm-images',question.estFiles.images);
        showFiles.tycoon('#etm-file',question.estFiles.paper);
        showFiles.tycoon('#camera',question.estFiles.camera);

        const regex = /<[^>]+>/gi;

        if(regex.test(str)){
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
        
        const sco = question.os_scor.split(',');

        sc += '<h4>เกณฑ์การให้คะแนนรอบ Pre-Screen</h4>';
        
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
                
                if(!empty(question.score_onsite)){
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

        qEva.html(ev);
        qSco.html(sc);
        disabledForm();
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
            $('tap-'+index).addClass('complete');
        } else {
            $('tap-'+index).removeClass('complete');
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
    dataset[point.cate].question[point.seg].score_onsite = null;
    dataset[point.cate].question[point.seg].tscore_onsite = null;
    dataset[point.cate].question[point.seg].estimate = true;
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

const getCurrentDate = () => {
    const date = new Date();
    const year = date.getFullYear();
    const month = date.getMonth()+1;
    const day = date.getDate();
    return year + '-' +
        ( month < 10 ? '0' : '') + month + '-' +
        ( day <10 ? '0' : '') + day;
}

esCmm.keyup(() => {
    const point = getPointer();
    dataset[point.cate].question[point.seg].comment_onsite = esCmm.val();
    dataset[point.cate].question[point.seg].estimate = true;
});

esNote.keyup(() => {
    const point = getPointer();
    dataset[point.cate].question[point.seg].note_onsite = esCmm.val();
    dataset[point.cate].question[point.seg].estimate = true;
});
