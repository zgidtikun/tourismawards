const MapData = {
    label: {
        title: '#title', sum: '#sum', question: '#question', remark: '#remark', 
    },
    input: {
        reply: {id: '#reply', api: 'reply', require: true},
        paper: {id: '#paperFile', api: 'paperFile[]', require: false},
        images: {id: '#imagesFile', api: 'imagesFile[]', require: false},
    },
    files: {
        fixed: {
            paper: {id: '#paper-fixed-', new: 'div.paper-new', ready: 'div.paper-ready'},
            images: {id: '#images-fixed-', new: 'div.images-new', ready: 'div.images-ready'}
        },
        accept: {
            paper: ['.doc','docx','application/pdf',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
            images: ['image/jpg','image/jpeg','image/gif','image/png','image/webp'],
        }
    }
}

const psc = {
    pointer: {
        category: 0,        
        segment: 0,
    },
    questions: null,
    init: function(){
        loading('show');
        api({method: 'get', url: '/frontend/question/get'}).then(function(response){           
            psc.questions = response;

            $.each(psc.questions,function(ckey,cval){
                $.each(cval.question,function(qkey,qval){
                    if(empty(qval.answer))
                        qval.answer = '';

                    qval.images.new = qval.images.delete = [];
                    qval.paper.new = qval.images.delete = [];
                    qval.change = false;
                });
            });
            
            psc.setNewQuestion(0,0);
            loading('hide');
        });
    },
    setNewQuestion: function(cate,seg){        
        let old = this.getPointer(),
            category = this.questions[cate],
            question = this.questions[cate].question[seg];

        this.pointer.category = cate;
        this.pointer.segment = seg;

        $(MapData.label.title).html(category.group.name);
        $(MapData.label.sum).html(category.question.length);
        $(MapData.label.question).html(question.question);
        $(MapData.label.remark).html(question.remark);
        $(MapData.input.reply.id).val(question.answer);
    },
    setReply: function(str){
        let point = this.getPointer();
        this.questions[point.cate].question[point.seg].reply = str;
        this.questions[point.cate].question[point.seg].change = true;
    },
    getPointer: function(){
        return {cate: this.pointer.category, seg: this.pointer.segment};
    },
    onFileHandel: function(type){
        let id = MapData.input[type].id,
            tag = MapData.files.fixed[type].new,
            point = this.getPointer(),
            max = type == 'images' ? 10 : 5,
            check = true;
        let files = $(id)[0].files,
            sysFiles = this.questions[point.cate].question[point.seg][type].list;
        let count = files.length + sysFiles.length;

        $(tag).remove();

        if(count <= max){
            let accept = MapData.files.accept[type];

            if(type == 'images'){
                $.each(files,function(key,file){
                    if($.inArray(file.type,accet) === -1){
                        check = false;
                        return false;
                    } else {

                    }
                });
            } else {
                
            }
        } else {
            check = false;
            let title = type == 'images' ? 'ไม่สามารถอัพโหลดรูปได้' : 'ไม่สามารถอัพโหลดไฟล์ได้';
            let texte = type == 'images' ? 'คุณสามารถอัพโหลกไฟล์ได้ไม่เกิน '+max+' ไฟล์เท่านั้น' : 'คุณสามารถอัพโหลดรูปได้ไม่เกิน '+max+' รูปเท่านั้น';
            alert.show('warning',title,text);
        }
        
        if(!check){
            let ele = $(id);
            ele.wrap('<form>').closest('form').get(0).reset();
            ele.unwrap();
        }
    }
}

$(MapData.input.reply.id).keyup(function(){
    psc.setReply($(this).val());
});

$(MapData.input.images.id).change(function(){
    if($(this)[0].files.length > 0)
        psc.onFileHandel('images');
});

$(MapData.input.paper.id).change(function(){
    if($(this)[0].files.length > 0)
        psc.onFileHandel('paper');
});
