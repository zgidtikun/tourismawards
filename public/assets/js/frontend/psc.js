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
    appId: null,
    status: null,
    expired: false,
    stage: null,
    lowcarbon: false,
    pointer: {
        category: -1,
        segment: -1,
    },
    questions: null,
    complete: false,
    init:async function(expired,stage){
        await loading('show');
        api({method: 'get', url: '/inner-api/question/get'}).then(function(response){
            psc.expired = expired;               
            psc.status = response.status;    
            psc.appId = response.app_id;    
            psc.lowcarbon = response.lowcarbon;
            psc.questions = response.data;
            psc.stage = stage;    
            
            if(psc.expired && $inArray(psc.status,['draft','reject']) !== -1){ 
                $('#formstatus-unpass').removeClass('hide');
                $('#formstep-sts').addClass('notpass');
                $('#formstep-sts').html('หมดเวลาการส่งแบบประเมินขั้นต้น');
                $('.btn-main, .btn-file, .bfd-dropfield, .selecter-file, file-list').remove();
                $('.regis-form-data textarea').prop('disabled',true);
                psc.complete = true;
            } else {    
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
                        $('.attach-file').remove();                     
                        // $('.form-main-title').removeClass('hide');
                        // $('.label-action').removeClass('hide');                     
                        $('#formstatus-reject').removeClass('hide');
                        // $('.regis-form-data textarea').prop('disabled',true);
                        // $('.btn-main, .selecter-file, .bfd-dropfield').css('display','none');
                    break;
                    case 'finish':
                    case 'result':
                        $('#formstep-sts').addClass('pass');
                        $('#formstep-sts').html('ส่งแบบประเมินเรียบร้อยแล้ว');                      
                        $('#formstatus-complete').removeClass('hide');
                        $('.label-action').removeClass('hide');
                        $('.regis-form-data textarea').prop('disabled',true);
                        $('.btn-main, .selecter-file, .bfd-dropfield').remove();
                        psc.complete = true;

                        if(psc.status == 'result'){
                            $('#formstep-result').html('ตรวจสอบผลการประเมิน');
                            $('.formstep-col.estimate > a').removeClass('disabled');
                            $('.formstep-col.estimate > a').addClass('inactive');
                        }
                    break;
                }           
            }

            if(psc.lowcarbon){
                $('#tab-3').show();
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
                        appId: psc.appId,
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
    waitDraft: function(sts){
        return new Promise(async function(resolve, reject){
            if(psc.expired && $.inArray(psc.status,['draft','reject']) !== -1){
                if(sts == 'wait'){
                    $('#tab-0').addClass('disabled');
                    $('#tab-1').addClass('disabled');
                    $('#tab-2').addClass('disabled');                

                    if(psc.lowcarbon){
                        $('#tab-3').addClass('disabled');
                    }

                    $('.btn-choice,.btn-regis').addClass('disabled');
                    $('#btn-back,#btn-next').prop('disabled',true);
                    $('.btn-file,.btn-action').prop('disabled',true);
                    $(MapData.input.reply.id).prop('readonly','readonly');
                    resolve({finish: true});
                } else {
                    $('#tab-0').removeClass('disabled');
                    $('#tab-1').removeClass('disabled');
                    $('#tab-2').removeClass('disabled');              

                    if(psc.lowcarbon){
                        $('#tab-3').removeClass('disabled');
                    }

                    $('.btn-choice,.btn-regis').removeClass('disabled');
                    $('#btn-back,#btn-next').prop('disabled',false);
                    $('.btn-file,.btn-action').prop('disabled',false);
                    $(MapData.input.reply.id).prop('readonly','');
                    resolve({finish: true});
                }
            } else {                
                resolve({finish: true});
            }
        });
    },
    reply: function(cate,seg){
        return new Promise(async function(resolve, reject){
            await psc.waitDraft('wait');
            if(cate == -1){ cate = 0; }
            if(seg == -1){ seg = 0; }

            if(psc.questions[cate].question[seg].change){

                let setting = psc.setApi('fixed',cate,seg);
                
                api(setting).then(function(response){
                    let reply = response;

                    if(reply.result == 'error_login'){
                        alert.login();
                        resolve({ result: 'error' });
                    } else {
                        if(reply.result == 'success'){
                            psc.questions[cate].question[seg].reply_id = reply.id;
                            psc.questions[cate].question[seg].change = false;
                            alert.toast({icon: reply.result, title: reply.message});

                            if(!empty(psc.questions[cate].question[seg].reply)){
                                if(
                                    $.inArray(Number(psc.stage.status),[3,5]) !== -1
                                    && !empty(psc.questions[cate].question[seg].request)
                                    && Number(psc.questions[cate].question[seg].reply_sts) == 3
                                ) {
                                    $(MapData.label.model.item+seg).addClass('request');
                                } else {
                                    $(MapData.label.model.item+seg).removeClass('active');
                                    $(MapData.label.model.item+seg).addClass('complete');
                                }
                            } else {
                                $(MapData.label.model.item+seg).removeClass('complete');
                            }

                            psc.waitDraft('finish');
                            resolve({ result: 'success' });
                        } else {
                            alert.toast({icon: reply.result, title: reply.message});    
                            psc.waitDraft('finish');
                            resolve({ result: 'error' });                    
                        }
                    }
                });

            } else {
                psc.waitDraft('finish');
                resolve({ result: 'success' });
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

            alert.confirm(setAlert).then(async function(alt){
                if(alt.status){
                    await loading('show');
                    
                    let setting = psc.setApi('finish');
                    
                    api(setting).then(function(response){
                        loading('hide');
                        let finish = response;

                        if(finish.result == 'error_login'){
                            alert.login();
                        } else {
                            if(finish.result == 'success'){
                                let title = 'ส่งแบบประเมินเรียบร้อยแล้ว',
                                    message = 'เราจะแจ้งผลให้ทราบวันที่ <b>19 พฤษภาคม 2566</b>';
                                
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
            alert.show('error','ดำเนินการไม่สำเร็จ','กรุณาตอบคำถามให้ครบถ้วน ก่อนส่งแบบประเมินเข้าระบบ');
        }
    },
    validate: function(){
        let check = true;

        $.each(this.questions, function(keyc,valc){
            $.each(valc.question, function(keyq, valq){
                if(empty(valq.reply)){ 
                    check = false 
                }
            });
        });

        return check;
    },
    setNewQuestion: function(cate,seg){       
        const regex = /<[^>]+>/gi;  
        let point = this.getPointer(),
            changeCate = false;

        psc.reply(point.cate,point.seg).then(replyRes => {
            psc.waitDraft('finish');

            let category = psc.questions[cate],
                question = psc.questions[cate].question[seg],
                qcontent = '';

            if(point.cate != cate){
                $('.btn-form-step').removeClass('active');
                $('#tab-'+cate).addClass('active');
                changeCate = true;
                psc.setDropdown(category.question,cate,seg);
            }

            if(point.cate == -1){ point.cate = 0; }
            if(point.seg == -1){ point.seg = 0; }

            $('.hide-choice').hide();
            $('body').removeClass('lockbody');
            
            if(!changeCate){
                if(!empty(psc.questions[point.cate].question[point.seg].reply)){
                    if(
                        $.inArray(Number(psc.stage.status),[3,5]) !== -1
                        && !empty(psc.questions[point.cate].question[point.seg].request)
                        && Number(psc.questions[point.cate].question[point.seg].reply_sts) == 3
                    ) {
                        $(MapData.label.model.item+point.seg).addClass('request');
                    } else {
                        $(MapData.label.model.item+point.seg).addClass('complete');
                    }
                } else {
                    $(MapData.label.model.item+point.seg).removeClass('complete');
                }
            }
                    
            $('.sl').removeClass('active');

            if(!empty(question.reply)){
                if(
                    $.inArray(Number(psc.stage.status),[3,5]) !== -1
                    && !empty(question.request)
                    && Number(question.reply_sts) == 3
                ){
                    if(!$(MapData.label.model.item+seg).hasClass('request')){
                        $(MapData.label.model.item+seg).addClass('request');
                    }
                } else {
                    if(!$(MapData.label.model.item+seg).hasClass('complete')){
                        $(MapData.label.model.item+seg).addClass('complete');
                    }
                }
            } else {
                $(MapData.label.model.item+seg).addClass('active');
            }          

            $(MapData.label.title).html(category.group.name);
            $(MapData.label.sum).html(category.question.length); 
            $(MapData.label.num).html(question.no);
            $(MapData.label.question).html(question.no+'. '+question.question);
            $(MapData.input.reply.id).val(question.reply);

            countChar($('#reply'));
            psc.setPointer(cate,seg);

            if(!psc.complete){
                showFiles.tycoon('#file',question.paper);
                showFiles.tycoon('#images',question.images);
            } else {
                if(question.images.length > 0){
                    $('#images-ablum').removeClass('text-center');                                        
                    $('#images-ablum').addClass('ablumbox');
                    showFiles.tycoon('#images',question.images);
                } else {
                    $('#images-ablum').removeClass('ablumbox');                                        
                    $('#images-ablum').addClass('text-center');
                    $('#images-ablum').html('ไม่มีรูปแนบ');
                }
                
                const button = $(`button[onclick="downloadFile('#file')"]`);

                if(question.paper < 1){
                    button.prop('disabled',true);
                    button.removeClass('btn-primary');
                    button.addClass('btn-transparent');
                    button.css('color','#000');
                    button.css('opacity','1');
                    button.html('ไม่มีไฟล์แนบ');
                } else {
                    button.prop('disabled',false);
                    button.removeClass('btn-transparent');
                    button.addClass('btn-primary');
                    button.css('color','#fff');
                    button.html('<i class="bi bi-download mr-2"></i> ดาวน์โหลดไฟล์แนบ');
                }
            }

            if(!empty(question.remark)){
                $(MapData.label.remark).html('หมายเหตุ : '+question.remark);
                $(MapData.label.remark).show();
            } else {
                $(MapData.label.remark).hide();
            }

            if(
                !empty(question.reply_sts)
                && Number(question.reply_sts) == 3
            ) {
                let req = '';

                $.each(question.request,function(rk,rv){
                    if(!empty(rv.request_list)){
                        req += '<li>'+rv.request_list+'</li>';
                    }
                });

                $('#request-list').html(req);
                $('#reject').removeClass('hide');            
                // $('.regis-form-data textarea').prop('disabled',false);
                // $('.attach-file').css('display','none');
                // $('.btn-main, .selecter-file, .bfd-dropfield').css('display','block');
            } else {
                // if(psc.status == 'reject'){
                //     $('.regis-form-data textarea').prop('disabled',true);
                //     $('.attach-file').css('display','block');
                //     $('.btn-main, .selecter-file, .bfd-dropfield').css('display','none');
                // }

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

        });
    },
    setDropdown: function(qt,cate,seg){
        let model = '';

        $.each(qt, function(key, value){
            let hr = 'href="javascript:psc.setNewQuestion('+cate+','+key+');"',
                id = 'id="sl-'+key+'"',
                cp, cl;
            
            if($.inArray(Number(psc.stage.status),[3,5]) === -1 && psc.status != 'reject'){
                cp = !empty(value.reply) && seg != key ? 'complete' : '';
            } else {
                if(!empty(value.request) && Number(value.reply_sts) == 3 ){
                    cp = 'request';
                } else {
                    cp = 'complete';
                }
            }
                
            cl = 'class="sl '+cp+'"';
            model += '<li><a '+hr+' '+id+' '+cl+'> ข้อที่ '+value.no+'</a></li>';
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

$(MapData.input.reply.id).on('keyup change', function(){
    psc.setReply($(this).val());
});