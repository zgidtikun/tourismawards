const MapData = {
    label: {
        title: '#title', sum: '#sum', question: '#question', remark: '#remark', 
        num: '#num', selection: '#select-dropdown', 
        model: {
            selection: '#selection-list', item: '#sl-'
        }
    },
    input: {
        reply: { id: '#reply', api: 'reply', require: true }
    }
}

const psc = {
    status: null,
    expired: false,
    stage: null,
    pointer: {
        category: -1,
        segment: -1,
    },
    questions: null,
    init: function(expired,stage){
        loading('show');
        api({method: 'get', url: '/inner-api/question/get'}).then(function(response){
            psc.expired = expired === 'true' ? true : false;               
            psc.status = response.status;        
            psc.questions = response.data;
            psc.stage = stage;
            
            if(!psc.expired){
                switch(psc.status){
                    case 'draft':   
                        $('#formstep-sts').addClass('date');
                        $('.form-main-title').removeClass('hide');
                        $('.label-action').removeClass('hide');
                        $('.attach-file').remove();                        
                        $('#formstatus-pass').removeClass('hide');                          
                    break;
                    case 'reject':
                        $('#formstep-sts').addClass('date');
                        $('#formstep-sts').html('ตอบกลับภายใน '+stage.duedateStr);    
                        $('.form-main-title').removeClass('hide');
                        $('.label-action').removeClass('hide');                     
                        $('#formstatus-reject').removeClass('hide');
                        $('.regis-form-data textarea').prop('disabled',true);
                        $('.btn-main, .selecter-file, .bfd-dropfield').css('display','none');
                    break;
                    case 'finish':
                    case 'estimate':
                        $('#formstep-sts').addClass('pass');
                        $('#formstep-sts').html('ส่งแบบประเมินเรียบร้อยแล้ว');                      
                        $('#formstatus-complete').removeClass('hide');
                        $('.regis-form-data textarea').prop('disabled',true);
                        $('.btn-main, .btn-action, .selecter-file, .bfd-dropfield').remove();

                        if(psc.status == 'estimate'){
                            $('#formstep-result').html('สรุปผลการประเมินขั้นต้นเรียบร้อยแล้ว');
                            $('.formstep-col.estimate > a').removeClass('disabled');
                            $('.formstep-col.estimate > a').addClass('inactive');
                        }
                    break;
                }
            } else {                   
                $('#formstatus-unpass').removeClass('hide');
                $('#formstep-sts').addClass('notpass');
                $('#formstep-sts').html('หมดเวลาการส่งแบบประเมินขั้นต้น');
                $('.btn-main, .btn-action, .btn-file, .bfd-dropfield, file-list').remove();
                $('.regis-form-data textarea').prop('disabled',true);
            }
            
            $.each(psc.questions,function(ckey,cval){
                $.each(cval.question,function(qkey,qval){
                    if(empty(qval.reply)){ qval.reply = ''; }                        
                    qval.change = false;
                });
            });

            showFiles.tycoon('#file',psc.questions[0].question[0].paper);
            showFiles.tycoon('#images',psc.questions[0].question[0].images);

            psc.setNewQuestion(0,0);
            loading('hide');
        });
    },
    setApi: function(act, cate = null, seg = null){
        let setting;

        switch(act){
            case 'fixed':
                let qt = this.questions[cate].question[seg];
                
                setting = {
                    method: 'post',
                    url: '/inner-api/answer/save',
                    data: {
                        qid: qt.id,
                        action: !empty(qt.reply_id) ? 'update' : 'create',
                        aid: !empty(qt.reply_id) ? qt.reply_id : '',
                        reply: qt.reply
                    }
                };
                break;
            case 'finish':                
                setting = {
                    method: 'post',
                    url: '/inner-api/answer/save',
                    data: {
                        action: 'finish',
                        answer: []
                    }
                };
                
                $.each(this.questions, function(keyc,valc){
                    $.each(valc.question, function(keyq, valq){
                        setting.data.answer.push({
                            qid: valq.id,
                            action: !empty(valq.reply_id) ? 'update' : 'create',
                            aid: !empty(valq.reply_id) ? valq.reply_id : '',
                            reply: valq.reply
                        });
                    });
                });
                break;
            case 'reject':
                break;
        }
        
        return  setting;
    },
    reply: function(cate,seg){
        let setting = this.setApi('fixed',cate,seg);
        
        api(setting).then(function(response){
            let reply = response;

            if(reply.result == 'error_login'){
                alert.login();
            } else {
                if(reply.result == 'success'){
                    psc.questions[cate].question[seg].reply_id = reply.id;
                    psc.questions[cate].question[seg].change = false;
                }

                alert.toast({icon: reply.result, title: reply.message});
            }
        });
    },
    finish: function(){
        if(this.validate()){
            let setAlert = {
                icon: 'info',
                title: 'ยืนยันการส่งแบบประเมิน',
                text: 'โปรดตรวจสอบข้อมูลของท่านให้เรียบร้อย<br>ก่อนกดปุ่มส่งแบบประเมิน',
                button: { 
                    confirm: 'ส่งแบบประเมิน', 
                    cancel: 'ยกเลิก' 
                },
                mode: 'confirm-main'
            };

            alert.confirm(setAlert).then(function(alt){
                if(alt.status){
                    loading('show');
                    let setting = psc.setApi('finish');
                    
                    api(setting).then(function(response){
                        loading('hide');
                        let finish = response;

                        if(finish.result == 'error_login'){
                            alert.login();
                        } else {
                            if(finish.result == 'success'){
                                let title = 'ส่งแบบประเมินเรียบร้อยแล้ว',
                                    message = 'เราจะแจ้งผลให้ทราบ<b>ช่วงประมาณกลางเดือนเมษายน 2566';

                                alert.show(finish.result,title,message).then(function(res){
                                    window.location.reload();
                                });

                            } else {
                                alert.show('error','ดำเนินการไม่สำเร็จ',finish.message);
                            }
                        }
                    });
                }
            });
        } else {
            alert.show('error','ดำเนินการไม่สำเร็จ','โปรดตรวจสอบการประเมินของท่าน ให้ครบถ้วน<br>ก่อนส่งแบบประเมินเข้าระบบ');
        }
    },
    validate: function(){
        let check = true;

        $.each(this.questions, function(keyc,valc){
            $.each(valc.question, function(keyq, valq){
                if(empty(valq.reply)){ check = false }
            });
        });

        return check;
    },
    setNewQuestion: function(cate,seg){        
        let point = this.getPointer(),
            category = this.questions[cate],
            question = this.questions[cate].question[seg];

        if(point.cate != cate){
            $('.btn-form-step').removeClass('active');
            $('#tab-'+cate).addClass('active');
            this.setDropdown(category.question,cate,seg);
        }

        if(point.cate == -1){ point.cate = 0; }
        if(point.seg == -1){ point.seg = 0; }

        if(this.questions[point.cate].question[point.seg].change){
            this.reply(point.cate,point.seg);
        }

        $('.hide-choice').hide();
        $('body').removeClass('lockbody');

        if(!empty(this.questions[point.cate].question[point.seg].reply)){
            if(
                !empty(this.questions[point.cate].question[point.seg].reply_sts)
                && this.questions[point.cate].question[point.seg].reply_sts == 3
            ) {
                $(MapData.label.model.item+point.seg).addClass('request');
            } else {
                $(MapData.label.model.item+point.seg).addClass('complete');
            }
        } else {
            $(MapData.label.model.item+point.seg).removeClass('complete');
        }
              
        $('.sl').removeClass('active');
        $(MapData.label.model.item+seg).addClass('active');            
        
        this.setPointer(cate,seg);

        $(MapData.label.title).html(category.group.name);
        $(MapData.label.sum).html(category.question.length); 
        $(MapData.label.num).html(question.no);
        $(MapData.label.question).html(question.no+'. '+question.question);
        $(MapData.input.reply.id).val(question.reply);

        showFiles.tycoon('#file',question.paper);
        showFiles.tycoon('#images',question.images);

        if(!empty(question.remark)){
            $(MapData.label.remark).html('หมายเหตุ : '+question.remark);
            $(MapData.label.remark).show();
        } else {
            $(MapData.label.remark).hide();
        }

        if(
            !empty(question.reply_sts)
            && question.reply_sts == 3
        ) {
            let req = '';

            $.each(question.request,function(rk,rv){
                if(!empty(rv.request_list)){
                    req += '<li>'+rv.request_list+'</li>';
                }
            });

            $('#request-list').html(req);
            $('#reject').removeClass('hide');            
            $('.regis-form-data textarea').prop('disabled',false);
            $('.attach-file').css('display','none');
            $('.btn-main, .selecter-file, .bfd-dropfield').css('display','block');
        } else {
            if(psc.status == 'reject'){
                $('.regis-form-data textarea').prop('disabled',true);
                $('.attach-file').css('display','block');
                $('.btn-main, .selecter-file, .bfd-dropfield').css('display','none');
            }

            $('#reject').addClass('hide');
        }

        let back = seg != 0 ? seg-1 : seg,
            next = seg != category.question.length-1 ? seg+1 : seg;

        $('#btn-back').attr('onclick','psc.setNewQuestion('+cate+','+back+')');
        $('#btn-next').attr('onclick','psc.setNewQuestion('+cate+','+next+')');

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
    },
    setDropdown: function(qt,cate,seg){
        let model = '';
        
        $.each(qt, function(key, value){
            let hr = 'href="javascript:psc.setNewQuestion('+cate+','+key+');"',
                id = 'id="sl-'+key+'"',
                cp, cl;
            
            if(this.stage !== 'reject'){
                cp = !empty(value.reply) && seg != key ? 'complete' : '';
            } else {
                if(!empty(value.reply_sts) && Number(value.reply_sts) == 3 ){
                    cp = 'request';
                } else {
                    cp = 'complete';
                }
            }
                
            cl = 'class="sl '+cp+'"';
            model += '<li><a '+hr+' '+id+' '+cl+'> ช้อที่ '+value.no+'</a></li>';
        });

        $(MapData.label.model.selection).html(model);
    },
    setReply: function(str){
        let point = this.getPointer();
        this.questions[point.cate].question[point.seg].reply = str;
        this.questions[point.cate].question[point.seg].change = true;
    },
    setPointer: function(cate,seg){
        this.pointer.category = cate;
        this.pointer.segment = seg;
    },
    getPointer: function(){
        return {cate: this.pointer.category, seg: this.pointer.segment};
    },
}

$(MapData.input.reply.id).keyup(function(){
    psc.setReply($(this).val());
});
