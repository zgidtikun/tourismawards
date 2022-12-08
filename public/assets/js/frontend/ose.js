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

const draft = (cate,seg) => {
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

const setFinish = () => {
    let tscore, mscore, tescore, ttescore, sbscoe, 
        tsbscoe, rsscore, trsscore, 
        te, sb, rs;

    tscore = mscore = cscore = 0;
    tescore = sbscoe = rsscore = 0;
    ttescore = tsbscoe = trsscore = 0;

    $.each(assign,(ak,av) => {
        let index = ak+1;

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
                if(av == 1){ 
                    tescore += Number(qv.score_pre);
                    ttescore += Number(qv.onside_score);
                }
                else if(av == 2){ 
                    sbscoe += Number(qv.score_pre);
                    tsbscoe += Number(qv.onside_score);
                }
                else{
                    rsscore += Number(qv.score_pre);
                    trsscore += Number(qv.onside_score);
                }
            }
        });
    });

    const stescore = (tescore / ttescore).toFixed(2);
    const ssbscore = (sbscoe / tsbscoe).toFixed(2);
    const srsscore = (rsscore / trsscore).toFixed(2);
    const totalScore = tescore + tescore + tescore;
    const totalMax = ttescore + ttescore + ttescore; 
    const sscore = (totalScore * tscore / totalMax).toFixed(2);
    
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
                }
                else {
                    alert.show(rs.result, 'ส่งผลประเมินเข้าระบบเรียบร้อยแล้ว', '')
                    .then(() => {
                        window.location.reload();
                    });
                }
            });
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
    
    const category = dataset[cate];
    const question = category.question[seg];
    
    if(dataset[point.cate].question[point.seg].estimate){
        draft(point.cate,point.seg);
    }

    $('.hide-choice').hide();
    $('body').removeClass('lockbody');

    $('.sl').removeClass('active');
    $('#sl-'+seg).addClass('active');
    
    if(!empty(dataset[point.cate].question[point.seg].score_onsite)){
        $('#sl-'+point.seg).addClass('complete');
    } 
    else {
        $('#sl-'+point.seg).removeClass('complete');
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
    esCmm.val(question.comment_onsite);
    esNote.val(question.note_onsite);

    if(Number(question.onside_status) == 1){
        $('.none-estimate').hide();
        $('.is-estimate').show();
    } else {
        $('.none-estimate').show();
        $('.is-estimate').hide();        
        return;
    }    

    if(Number(question.pre_status) == 0){
        $('#qResult, #qReply, #qImages, #qFiles').hide();
    } else {
        $('#qResult, #qReply, #qImages, #qFiles').show();
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
    
    showFiles.tycoon('#etm-images',question.estFiles.images);
    showFiles.tycoon('#etm-file',question.estFiles.paper);
    showFiles.tycoon('#camera',question.estFiles.camera);

    const eva = question.os_eva.split(',');
    const sco = question.os_scor.split(',');
    
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
            
        if(
            $.inArray(Number(getStageStatus()),[3,6,7]) !== -1
            || getIsFinish() == 'finish'
        ){
            dis = 'disabled';
        }
        
        if(!empty(question.score_onsite)){
            if(Number(question.score_onsite) == Number(tmp[0].trim())){
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
}

const setDropdown = (qt,cate,seg) => {
    const md = $('#selection-list');
    let modal = slt = '';
    
    $.each(qt, function(k, v){
        let hr = 'href="javascript:setQuestion('+cate+','+k+');"',
            id = 'id="sl-'+k+'"',
            cp, cl;        
            
        if(Number(v.onside_status) == 1){
            cp = !empty(v.score_onsite) && seg != k ? 'complete' : '';
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
            $('tap-'+ck).addClass('complete');
        } else {
            $('tap-'+ck).removeClass('complete');
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
        $('.btn-confirm-submit').prop('disabled',true);
        $('.btn-main, .btn-action, .selecter-file, .bfd-dropfield').remove();
        esCmm.prop('readonly','readyonly');
        btnSave.prop('disabled',true);
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
    $("#img-modal").attr('src', el.src);
    $("#images-modal").show();
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
    
    dataset[point.cate].question[point.seg].score_onsite = ele.value;
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
