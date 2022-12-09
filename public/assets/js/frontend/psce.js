var appid, sp, tycoon, dataset, assign,
    pointer     = { cate: -1, seg: -1 };

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
        $('#tyUdat').html(tycoon.updated_at);    
        $('#tyTel').html(tycoon.knitter_tel);

        $.each(assign,(k,v) => {
            $('#tab-'+(v-1)).removeClass('disabled');
        });
        
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
            msg = 'กรุณารอผู้ประกอบการตอบกลับ (ภายใน 5 วัน)<br>ท่านจึงจะสามารถกลับมาประเมินต่อได้';
        } else {
            title = 'ไม่สามารถส่งคำขอข้อมูลเพิ่มเติมได้';
            msg = rs.message;
        }

        alert.show(rs.result,title,msg).then((al) => {
            if(rs.result == 'success'){
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

    const stescore = (tescore / ttescore).toFixed(2);
    const ssbscore = (sbscoe / tsbscoe).toFixed(2);
    const srsscore = (rsscore / trsscore).toFixed(2);
    const totalScore = tescore + sbscoe + rsscore;
    const totalMax = ttescore + tsbscoe + trsscore; 
    const sscore = ((totalScore * tscore) / totalMax).toFixed(2);

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
                }
                else {
                    alert.show(rs.result, 'ส่งผลประเมินเข้าระบบเรียบร้อยแล้ว', '').then(() => {
                        window.location.reload();
                    });
                }
            });
        }
    });
}

const draft = (cate,seg) => {
    const question = dataset[cate].question[seg];

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
            checkComplete();
            alert.toast({icon: 'success', title: 'บันทึกการประเมินแล้ว'});
        }
        else if(rs.result == 'error_login'){
            alert.login();
        } else {
            alert.toast({icon: rs.result, title: rs.message});
        }
    });
}

const setQuestion = (cate,seg) => {
    let point = getPointer();
    setPointer(cate,seg);

    if(point.cate != cate){
        $('.btn-form-step').removeClass('active');
        $('#tab-'+cate).addClass('active');
        setDropdown(dataset[cate].question,cate,seg);
    }

    if(point.cate == -1){ point.cate = cate; }
    if(point.seg == -1){ point.seg = seg; }
    
    if(dataset[point.cate].question[point.seg].estimate){
        draft(point.cate,point.seg);
    }
    
    const category = dataset[cate];
    const question = category.question[seg];

    $('.hide-choice').hide();
    $('body').removeClass('lockbody');

    $('.sl').removeClass('active');
    $('#sl-'+seg).addClass('active');

    if(
        empty(dataset[point.cate].question[point.seg].request_status)
        || $.inArray(Number(dataset[point.cate].question[point.seg].request_status),[0,1,2]) === -1
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

    setPointer(cate,seg);
    
    qTitle.attr('data-id',question.reply_id);
    qTitle.html(category.group.name);
    qSum.html(category.question.length);
    mSum.html(category.question.length);
    qNum.html(question.no);
    mTNum.html(question.no);
    mNum.html(question.no);
    hSubject.html(question.no+'. '+question.question);
    esCmm.val(question.comment_pre);
    esNote.val(question.note_pre);

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

    if(Number(question.pre_status) == 1){
        $('.none-estimate').hide();
        $('.is-estimate').show();
        btnSave.attr('onclick','draft('+cate+','+seg+')');
        btnRequest.attr('onclick','draft('+cate+','+seg+')');
        btnSave.show();
        btnReset.show();
    } else {
        $('.none-estimate').show();
        $('.is-estimate').hide();
        btnSave.hide();    
        btnReset.hide();    
        return;
    }
    
    qSubject.html(question.no+'. '+question.question);
    qReply.html(question.reply);

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

    const eva = question.pre_eva.split(',');
    const sco = question.pre_scor.split(',');
    
    $.each(eva,(k,v) => {
        let val, tmp = v.split('.');
        
        if(tmp.length > 1) { val = tmp[0].trim()+'. '+tmp[1].trim(); }
        else { val = '1. '+tmp[0].trim(); }

        ev += (
            '<span class="txt-yellow title-comment">'
                + val
            + '</span><br>'
        );
    });

    sc += '<h4>เกณฑ์การให้คะแนนรอบ Pre-Screen</h4>';
    
    $.each(sco,(k,v) => {
        let tmp = v.split('='),
            dis = ck = '';
            
        if($.inArray(Number(getStageStatus()),[3,6,7]) !== -1){
            dis = 'disabled';
        }

        if(!empty(question.score_pre)){
            if(Number(question.score_pre) == Number(tmp[0].trim())){
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
    });

    qEva.html(ev);
    qSco.html(sc);
}

const setDropdown = (qt,cate,seg) => {
    const md = $('#selection-list');
    let modal = slt = '';
    
    $.each(qt, function(k, v){
        let hr = 'href="javascript:setQuestion('+cate+','+k+');"',
            id = 'id="sl-'+k+'"',
            cp, cl;        
            
        if(Number(v.pre_status) == 1){            
            if(
                !empty(v.request_status)
                && $.inArray(Number(v.request_status),[0,1,2]) === -1
            ){
                cp = !empty(v.score_pre) && seg != k ? 'complete' : '';
            } else {
                cp = 'request';
            }
        } else {
            cp = 'hold';
        }
            
        cl = 'class="sl '+cp+'"';
        modal += '<li><a '+hr+' '+id+' '+cl+'> ช้อที่ '+v.no+'</a></li>';
        slt += '<option value="'+k+'">'+v.no+'</option>';
    });

    md.html(modal);
    mSelect.html(slt);
}

const checkComplete = () => {
    const cp = assign.length;
    let ccp = 0;

    $.each(assign,(ak,av) => {
        let check = true,
            index = av-1;
       
        $.each(dataset[index].question,(qk,qv) => {
            if(Number(qv.pre_status ) == 1){
                if(empty(qv.score_pre)){
                    check = false;
                }
            }
        });

        if(check){
            $('tap-'+ck).addClass('complete');
            ccp++;
        } else {
            $('tap-'+ck).removeClass('complete');
        }
    });

    if(ccp < cp){
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
        $('.btn-confirm-submit').prop('disabled',true);
        esCmm.prop('readonly','readyonly');
        qRequest.prop('readonly','readyonly');
        btnSave.prop('disabled',true);
        btnReset.prop('disabled',true);
        btnRequest.prop('disabled',true);
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
    
    dataset[point.cate].question[point.seg].score_pre = ele.value;
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
    $("#img-modal").attr('src', el.src);
    $("#images-modal").show();
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

