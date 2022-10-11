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
    pointer: {
        category: -1,
        segment: -1,
    },
    questions: null,
    init: function(){
        loading('show');
        api({method: 'get', url: '/inner-api/question/get'}).then(function(response){           
            psc.questions = response;
            console.log(response);
            $.each(psc.questions,function(ckey,cval){
                $.each(cval.question,function(qkey,qval){
                    if(empty(qval.answer)){ qval.answer = ''; }                        
                    qval.change = false;
                });
            });

            psc.setNewQuestion(0,0);
            loading('hide');
        });
    },
    setApi: function(act,cate = null,seg = null){
        let setting = null;
        switch(act){
            case 'fixed':
                let qt = this.questions[cate].question[seg];

                setting = {
                    method: 'action',
                    data: null
                };

                let formData = new FormData(),
                    paper = qt.paper.new,
                    images = qt.images.new;
                
                formData.append('action',!empty(qt.id) ? 'update' : 'create');
                formData.append('id',!empty(qt.id) ? qt.id : '');
                formData.append('oldFiles',qt.paper.list.concat(qt.images.list));
                formData.append('deleteFies',qt.paper.delete.concat(qt.images.delete))

                if(paper.length > 0){
                    $.each(paper,function(key,file){
                        formData.append(MapData.input.paper.api,file);
                    });
                }

                if(images.length > 0){
                    $.each(images,function(key,file){
                        formData.append(MapData.input.images.api,file);
                    });
                }

                setting.data = formData;
                break;
            case 'submit':
                break;
            case 'adjunct':
                break;
        }

        return  setting;
    },
    reply: function(cate,seg){
        let setting = this.setApi('fixed',cate,seg);
        console.log(setting);
    },
    toStep: function(cate,seg){
        let point = this.getPointer();
        this.setPointer(cate,seg);

        if(this.questions[point.cate].question[point.seg].change){
            let setAlert = {
                icon: 'warning',
                title: 'กรุณาบันทึกข้อมูล',
                text: 'คุณมีการเปลี่ยนแปลงข้อมูล กรุณาบันทึกข้อมูลใหม่',
                button: { confirm: 'บันทึกข้อมูล', cancel: 'ยกเลิก' },
                mode: 'default'
            };

            alert.confirm(setAlert).then(function(alt){
                if(alt.status){

                }
            });
        } else this.setNewQuestion()

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

        $('.hide-choice').hide();
        $('body').removeClass('lockbody');

        if(point.cate == -1){ point.cate = 0; }
        if(point.seg == -1){ point.seg = 0; }

        if(!empty(this.questions[point.cate].question[point.seg].answer)){
            $(MapData.label.model.item+point.seg).addClass('complete');
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
        $(MapData.input.reply.id).val(question.answer);

        if(!empty(question.remark)){
            $(MapData.label.remark).html(question.remark);
            $(MapData.label.remark).show();
        } else {
            $(MapData.label.remark).hide();
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
                cp = !empty(value.answer) && seg != key ? 'complete' : '',
                cl;
            console.log(seg,key,(seg == key))
            cl = 'class="sl '+cp+'"';
            model += '<li><a '+hr+' '+id+' '+cl+'> ช้อที่ '+value.no+'</a></li>';
        })

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
