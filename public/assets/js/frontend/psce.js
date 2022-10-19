var appid, tycoon, dataset,
    pointer     = { cate: -1, seg: -1 };
const btnSave   = $('#btn-save');
const btnBack   = $('#btn-back');
const btnNext   = $('#btn-next');
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

const setPage = (id) => {
    appid = id;
    init();
}

const getPointer = () => {
    return pointer;
}

const setPointer = (cate,seg) => {
    pointer = { cate: cate, seg: seg };
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
        
        loading('hide');
        setQuestion(0,0)
    });
}

const draft = (cate,seg) => {
    
}

const setQuestion = (cate,seg) => {
    let point = getPointer();
    setPointer(cate,seg);

    if(point.cate != cate){
        $('.btn-form-step').removeClass('active');
        $('#tab-'+cate).addClass('active');
        setDropdown(dataset[cate].question,cate,seg);
    }
    
    const category = dataset[cate];
    const question = category.question[seg];

    if(category.question[point.seg]){
        
    }

    $('.hide-choice').hide();
    $('body').removeClass('lockbody');

    $('.sl').removeClass('active');
    $('#sl-'+seg).addClass('active');

    if(point.cate == -1){ point.cate = 0; }
    if(point.seg == -1){ point.seg = 0; }

    if(!empty(category.question[point.seg].score_pre)){
        $('#sl-'+point.seg).addClass('complete');
    } else {
        $('#sl-'+point.seg).removeClass('complete');
    }

    setPointer(cate,seg);

    console.log(question);
    qTitle.attr('data-id',question.reply_id);
    qTitle.html(category.group.name);
    qSum.html(category.question.length);
    mSum.html(category.question.length);
    qNum.html(question.no);
    mTNum.html(question.no);
    mNum.html(question.no);
    hSubject.html(question.no+'. '+question.question);

    if(Number(question.pre_status) == 1){
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

    const eva = question.pre_eva.split(',');
    const sco = question.pre_scor.split(',');
    
    $.each(eva,(k,v) => {
        let tmp = v.split('.');

        ev += (
            '<span class="txt-yellow title-comment">'
                + tmp[0].trim()+'. '+tmp[1].trim()
            + '</span><br>'
        );
    });

    sc += '<h4>เกณฑ์การให้คะแนนรอบ Pre-Screen</h4>';
    
    $.each(sco,(k,v) => {
        let tmp = v.split('=');

        sc += (
            '<p><input type="radio" name="score" value="'+tmp[0].trim()+'"'
            + 'onclick="calScore(this)">'
                + tmp[1].trim()
            + '</p>'
        );
    });

    qEva.html(ev);
    qSco.html(sc);

    let back = seg != 0 ? seg-1 : seg,
        next = seg != category.question.length-1 ? seg+1 : seg;

    $('#btn-back').attr('onclick','setQuestion('+cate+','+back+')');
    $('#btn-next').attr('onclick','setQuestion('+cate+','+next+')');

    if(seg == 0){
        $('#btn-back').hide();
        $('#btn-next').show();
    } else if(seg >= category.question.length-1){
        $('#btn-back').show();
        $('#btn-next').hide();
    } else {
        $('#btn-back').show();
        $('#btn-next').show();
    }
}

const setDropdown = (qt,cate,seg) => {
    const md = $('#selection-list');
    let modal = '';
    
    $.each(qt, function(k, v){
        let hr = 'href="javascript:setQuestion('+cate+','+k+');"',
            id = 'id="sl-'+k+'"',
            cp, cl;
        
            
        if(Number(v.pre_status) == 1){
            cp = !empty(v.score_pre) && seg != k ? 'complete' : '';
        } else {
            cp = 'hold';
        }
            
        cl = 'class="sl '+cp+'"';
        modal += '<li><a '+hr+' '+id+' '+cl+'> ช้อที่ '+v.no+'</a></li>';
    });

    md.html(modal);
}

const downloadFile = () => {
    let url = getBaseUrl()+'/inner-api/answer/download/file';
    url += '/'+qTitle.attr('data-id')+'/paper';
    window.open(url,'_blank');
}

const resetEstimate = (cate,seg) => {
    $('[name="score"]').prop('checked',false);
    esCmm.val('');

    const point = getPointer();
    dataset[point.cate].question[point.seg].comment_pre = null;
    dataset[point.cate].question[point.seg].score_pre = null;
    dataset[point.cate].question[point.seg].tscore_per = null;
    dataset[point.cate].question[point.seg].estimate = true;
}

const calScore = (ele) => {
    const point = getPointer();
    const question = dataset[point.cate].question[point.seg];
    const maxscore = question.onside_status;
    const weight = question.weight;
    const fullscore = parseFloat(maxscore) * parseFloat(weight);
    const selfscore = parseFloat(ele.value) * parseFloat(weight);
    const totalscore = selfscore / fullscore;
    
    dataset[point.cate].question[point.seg].score_pre = ele.value;
    dataset[point.cate].question[point.seg].tscore_per = totalscore;
    dataset[point.cate].question[point.seg].estimate = true;
    console.log(dataset[point.cate].question[point.seg])
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