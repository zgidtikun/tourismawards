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
            paper: ['.doc','docx','application/pdf','application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
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

        this.setPointer(cate,seg);

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
    setPointer: function(cate,seg){
        this.pointer.category = cate;
        this.pointer.segment = seg;
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
            this.questions[point.cate].question[point.seg][type].new = [];

            if(type == 'images'){
                $.each(files,function(key,file){
                    if($.inArray(file.type,accept) === -1){
                        check = false;
                        return false;
                    } else {
                        this.questions[point.cate].question[point.seg][type].new.push(file);
                    }
                });

                if(!check){
                    this.questions[point.cate].question[point.seg][type].new = [];
                    let message = 'กรุณาเลือกเป็นไฟล์ .jpg, .jpeg, .gif, .png, .webp  เท่านั้น';
                    alert.show('warning','ไม่สามารถอัพโหลดรูปได้',message);
                }
            } else {
                $.each(files,function(key,file){
                    let mb = (file.size / (1024 * 1024)).toFixed(2);

                    if($.inArray(val.file,accept) === -1){
                        var text = 'กรุณาเลือกเป็นไฟล์ .docx, .doc, .pdf เท่านั้น'
                        check = false;
                        return false;
                    } else if(mb > 20.00){
                        var text = 'กรุณาเลือกขนาดไฟล์ไม่เกิน 20 MiB.'
                        check = false;
                        return false;
                    }

                    if(check){
                        this.questions[point.cate].question[point.seg][type].new.push(file);
                    } else {
                        alert.show('warning','ไม่สามารถอัพโหลดไฟล์ได้',text);
                    }
                });
            }
        } else {
            check = false;
            let title = type == 'images' ? 'ไม่สามารถอัพโหลดรูปได้' : 'ไม่สามารถอัพโหลดไฟล์ได้';
            let text = type == 'images' ? 'คุณสามารถอัพโหลกไฟล์ได้ไม่เกิน '+max+' ไฟล์เท่านั้น' : 'คุณสามารถอัพโหลดรูปได้ไม่เกิน '+max+' รูปเท่านั้น';
            alert.show('warning',title,text);
        }
        
        if(!check){
            let ele = $(id);
            ele.wrap('<form>').closest('form').get(0).reset();
            ele.unwrap();
        } else {
            this.questions[point.cate].question[point.seg].change = true;
        }
    },
    removeFiles: function(type,act,index){
        let point = this.getPointer();
        let temp = this.questions[point.cate].question[point.seg][type][act][index];
        this.questions[point.cate].question[point.seg][type][act].splice(index,1);
        this.questions[point.cate].question[point.seg].change = true;

        if(act == 'list')
            this.questions[point.cate].question[point.seg][type].delete.push(temp);

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
