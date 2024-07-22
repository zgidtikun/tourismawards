document.querySelectorAll('.unsign').forEach( ele => {
    ele.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if(this.classList.contains('is-invalid')) this.classList.remove('is-invalid');
    });
});

document.querySelectorAll('.number').forEach( ele => {
    ele.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9.]/g, '');
        if(this.classList.contains('is-invalid')) this.classList.remove('is-invalid');
    });
});

document.querySelector('#type').addEventListener('change', function() {
    if(this.classList.contains('is-invalid')) 
        this.classList.remove('is-invalid');

    if(document.querySelector('#subtype').classList.contains('is-invalid'))
        document.querySelector('#subtype').classList.remove('is-invalid');

    const main_type = Number(this.value);

    document.querySelectorAll('#subtype option').forEach( ele => {
        if(main_type === Number(ele.dataset.parent) || ele.dataset.parent === ''){
            ele.style.display = 'block';
        } else {
            ele.style.display = 'none';
        }
    });
});

document.querySelector('#subtype').addEventListener('change', function() {
    if(this.classList.contains('is-invalid')) this.classList.remove('is-invalid');
});

document.querySelector('#assessment').addEventListener('change', function() {
    if(this.classList.contains('is-invalid')) this.classList.remove('is-invalid');
});

;['#is_ps','#is_os','#is_lc'].forEach( id => {
    document.querySelector(id).addEventListener('change', function() {
        document.querySelector('#is_ps').classList.remove('is-invalid');
        document.querySelector('#is_os').classList.remove('is-invalid');
        document.querySelector('#is_lc').classList.remove('is-invalid');
        document.querySelector('#invalid-round').style.display = 'none';        
    });
});

;['ps', 'os'].forEach( target => {
    if(document.querySelectorAll(`tr[${target}-score-list]`).length > 0){
        document.querySelectorAll(`tr[${target}-score-list]`).forEach( tr => {
            const uid = tr.dataset.uid;
    
            document.querySelector(`#${target}-subject-${uid}`).addEventListener('input', function() {
                if(this.classList.contains('is-invalid')) this.classList.remove('is-invalid');
            });
    
            document.querySelector(`#${target}-score-${uid}`).addEventListener('input', function() {
                if(this.classList.contains('is-invalid')) this.classList.remove('is-invalid');
            });
        });
    }
});

const eva = {
    target: null,
    add: target => {
        const tbl = document.querySelector(`#eva-${target}-tbl tbody`);
        const uid = Date.now();

        tbl.innerHTML += `<tr ${target}-score-list data-uid="${uid}">
            <td>
                <input id="${target}-subject-${uid}" type="text" class="form-control">
            </td>
            <td>
                <input id="${target}-score-${uid}" class="form-control number">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger" 
                onclick="eva.remove('${target}','${uid}')">
                    <i class="bi bi-trash2-fill"></i>
                </button>
            </td>
        </tr>`;

        document.querySelector(`#${target}-subject-${uid}`).addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });

        document.querySelector(`#${target}-score-${uid}`).addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9.]/g, '');
            this.classList.remove('is-invalid');
        });
    },
    remove: (target, uid) => {
        document.querySelector(`tr[${target}-score-list][data-uid="${uid}"]`).remove();
    },
    save: async(action) => {
        if(eva.validate()){
            const headers = new Headers();
            headers.append('Content-Type', 'application/json');

            const body = {
                action: action,
                id: null,
                type_id: document.querySelector('#type').value,
                sub_id: document.querySelector('#subtype').value,
                assessmen_id: document.querySelector('#assessment').value,
                ordering: document.querySelector('#ordering_question').value,
                topic_no: document.querySelector('#ordering_topic').value,
                topic: document.querySelector('#topic').value,
                question: '',
                remark: document.querySelector('#remark-question').value,
                weight: document.querySelector('#weight').value,
                pre_status: document.querySelector('#is_ps').checked ? 1 : 0,
                onside_status: document.querySelector('#is_os').checked ? 1 : 0,
                lowcarbon_status: document.querySelector('#is_lc').checked ? 1 : 0,
                pre_evaluation: '',
                pre_score: document.querySelector('#ps-max').value,
                onside_evaluation: '',
                onside_score: document.querySelector('#os-max').value,
                pre_scoring: [],
                onside_scoring: []
            }

            if($('#question').summernote('code').replace('<p><br></p>', '').trim() !== ''){
                body.question = $('#question').summernote('code');
            } else body.question = '';

            if($('#ps-criteria').summernote('code').replace('<p><br></p>', '').trim() !== ''){
                body.pre_evaluation = $('#ps-criteria').summernote('code');
            } else body.pre_evaluation = '';

            if($('#os-criteria').summernote('code').replace('<p><br></p>', '').trim() !== ''){
                body.onside_evaluation = $('#os-criteria').summernote('code');
            } else body.onside_evaluation = '';

            if(action === 'edit') body.id = document.querySelector('#id').value;

            ;['ps', 'os'].forEach( target => {
                if(document.querySelectorAll(`tr[${target}-score-list]`).length > 0){
                    document.querySelectorAll(`tr[${target}-score-list]`).forEach( tr => {
                        const uid = tr.dataset.uid;
                        const subject = document.querySelector(`#${target}-subject-${uid}`).value;
                        const score = document.querySelector(`#${target}-score-${uid}`).value;
                        const data = { subject: subject, score: score }

                        if(target === 'ps') body.pre_scoring.push(data);
                        else  body.onside_scoring.push(data);
                    });
                }
            });
            
            const setting = {
                method: 'POST',
                headers: headers,
                body: JSON.stringify(body),
                redirect: "error"
            }

            fetch(
                `${window.location.origin}/administrator/question/store`,
                setting
            )
            .then(response => response.json())
            .then(response => {
                if(response.result === 'success'){
                    toastr.success(response.message);

                    window.setTimeout(() => {
                        if(action === 'add')
                            window.location.href = `${window.location.origin}/administrator/question`;
                        else window.location.reload();
                    }, 200);
                } else toastr.error(response.message);
            })
            .catch(errors => {
                toastr.error(`Request failed : ${errors.statusText}`);
            });
        }
    }, 
    validate: () => {
        let valid = true;

        ;['type','subtype','assessment','ordering_topic','ordering_question','weight','ps-max','os-max'].forEach(id => {
            const input = document.querySelector(`#${id}`);
            const label = document.querySelector(`label[for="${id}"]`).innerHTML.replace('*','').trim();
            const feedback = document.querySelector(`.invalid-feedback[for="${id}"]`);
            
            if(input.value === ''){
                input.classList.add('is-invalid');
                feedback.innerHTML = `กรุณาระบุ ${label}`;
                valid = false;
            }
            else if(['ordering_topic','ordering_question','weight','ps-max','os-max'].includes(id) && parseFloat(input.value) <= 0){
                input.classList.add('is-invalid');
                feedback.innerHTML = `ต้องระบุตัวเลขมากกว่า 0`;
                valid = false;
            }
            else {
                input.classList.remove('is-invalid');                
            }
        });

        if(
            !document.querySelector('#is_ps').checked &&
            !document.querySelector('#is_os').checked &&
            !document.querySelector('#is_lc').checked
        ) {
            document.querySelector('#is_ps').classList.add('is-invalid');
            document.querySelector('#is_os').classList.add('is-invalid');
            document.querySelector('#is_lc').classList.add('is-invalid');
            document.querySelector('#invalid-round').style.display = 'inline';
            valid = false;
        } else {
            document.querySelector('#is_ps').classList.remove('is-invalid');
            document.querySelector('#is_os').classList.remove('is-invalid');
            document.querySelector('#is_lc').classList.remove('is-invalid');
            document.querySelector('#invalid-round').style.display = 'none';
        }

        ;['question','ps-criteria','os-criteria'].forEach( id => {
            const value = $(`#${id}`).summernote('code').replace('<p><br></p>', '').trim();

            if(value === ''){
                document.querySelector(`#${id} ~ .note-editor`).classList.add('is-invalid','border-danger');
                valid = false;
            } else {
                document.querySelector(`#${id} ~ .note-editor`).classList.remove('is-invalid','border-danger');
            }
        });

        ;['ps', 'os'].forEach( target => {
            if(document.querySelectorAll(`tr[${target}-score-list]`).length > 0){
                document.querySelectorAll(`tr[${target}-score-list]`).forEach( tr => {
                    const uid = tr.dataset.uid;
                    const subject = document.querySelector(`#${target}-subject-${uid}`);
                    const score = document.querySelector(`#${target}-score-${uid}`);
                    
                    if(subject.value === ''){
                        subject.classList.add('is-invalid');
                        valid = false;
                    } else subject.classList.remove('is-invalid');

                    if(score.value === '' || parseFloat(score.value) < 0){
                        score.classList.add('is-invalid');
                        valid = false;
                    } else score.classList.remove('is-invalid');
                });
            }
        });

        return valid;
    }
}
