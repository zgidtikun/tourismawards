var appid, sp, tycoon, dataset, assign,
    pointer     = { cate: -1, seg: -1 };

const btnSave   = $('#btn-save');
const btnBack   = $('#btn-back');
const btnNext   = $('#btn-next');
const btnReset  = $('#btn-reset');
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
        console.log(assign)
        $.each(assign,(k,v) => {
            $('#tab-'+(v-1)).removeClass('disabled');
        });
        
        loading('hide');
        setQuestion(assign[0]-1,0);
        // checkComplete();
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
    console.log(question)
    if(category.question[point.seg].estimate){
        draft(point.cate,point.seg);
    }

    $('.hide-choice').hide();
    $('body').removeClass('lockbody');

    $('.sl').removeClass('active');
    $('#sl-'+seg).addClass('active');

    if(
        !empty(category.question[point.seg].request_status)
        && $.inArray(Number(category.question[point.seg].request_status),[0,1,2]) === -1
    ){
        if(
            !empty(category.question[point.seg].score_pre) 
            || category.question[point.seg].score_pre == 0
        ){
            $('#sl-'+point.seg).addClass('complete');
        } else {
            $('#sl-'+point.seg).removeClass('complete');
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

    if(Number(question.onside_status) == 1){
        $('.none-estimate').hide();
        $('.is-estimate').show();
    } else {
        $('.none-estimate').show();
        $('.is-estimate').hide();
        
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
            
        if($.inArray(Number(getStageStatus()),[3,6,7]) !== -1){
            dis = 'disabled';
        }

        if(Number(question.score_onsite) == Number(tmp[0].trim())){
            ck = 'checked';
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
    const selfscore = parseFloat(ele.value) * parseFloat(weight);
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