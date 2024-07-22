if(document.querySelectorAll('.number').length > 0){
    document.querySelectorAll('.number').forEach( ele => {
        ele.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9.]/g, '');
            if(this.classList.contains('is-invalid')) this.classList.remove('is-invalid');
        });
    });
}

;['ps', 'os'].forEach( target => {
    if(document.querySelectorAll(`tr[eva-${target}-input]`).length > 0){
        document.querySelectorAll(`tr[eva-${target}-input]`).forEach( tr => {
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

const changeWeight = (orinal, id) => {
    Swal.fire({
        title: "กรอก น้ำหนักการให้คะแนน",
        input: "number",
        inputAttributes: {
            autocapitalize: "off"
        },
        showCancelButton: true,
        confirmButtonText: "บันทึก",
        confirmButtonColor: '#01AE5C',
        cancelButtonText: "ยกเลิก",
        cancelButtonColor: '#DD3342',
        showLoaderOnConfirm: true,
        preConfirm: async (weight) => {
            try {
                if(parseFloat(weight) < 0.00){
                    return Swal.showValidationMessage('ต้องระบุตัวเลขมากกว่า 0');
                }

                const headers = new Headers();
                headers.append('Content-Type', 'application/json');                    

                const response = await fetch(
                    `${window.location.origin}/administrator/question/change-weight`,
                    {
                        method: 'POST',
                        headers: headers,
                        body: JSON.stringify({
                            id: id,
                            weight: weight
                        }),
                        redirect: "error"
                    }
                );

                if (response.result === 'error') {
                    return Swal.showValidationMessage(response.message);
                }

                return response.json();
            } catch (error) {
                Swal.showValidationMessage(`
                    Request failed: ${error}
                `);
            }
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {       
            const callback = result.vlaue;   
            
            if(callback.result === 'success'){
                toastr.success(callback.message);

                window.setTimeout(() => {
                    window.location.reload();
                }, 200);
            }
        }
    });
}

const setEdit = (target) => {
    $(`[eva-${target}-show]`).slideUp(200);
    $(`[eva-${target}-edit]`).fadeOut(200);
    $(`[eva-${target}-input]`).delay(200).slideDown(150);
}

const closeEdit = target => {
    $(`[eva-${target}-input]`).slideUp(200);
    $(`[eva-${target}-edit]`).delay(200).fadeIn(200);
    $(`[eva-${target}-show]`).delay(200).slideDown(150);

    document.querySelector(`[eva-${target}-form]`).reset();

    const defaultValue = document.querySelector(`#${target}-criteria`).defaultValue 
    $(`#${target}-criteria`).summernote('code', defaultValue);

    if(document.querySelectorAll(`tr[eva-${target}-input]`).length > 0){
        document.querySelectorAll(`tr[eva-${target}-input]`).forEach( tr => {
            const uid = tr.dataset.uid;
            const origin = tr.dataset.origin;

            if(origin !== 'default') document.querySelector(`tr[eva-${target}-input][data-uid="${uid}"]`).remove();
        });
    }
}


const eva = {
    target: null,
    add: target => {
        const tbl = document.querySelector(`#eva-${target}-tbl tbody`);
        const uid = Date.now();

        tbl.innerHTML += `<tr eva-${target}-input data-origin="new" data-uid="${uid}"
        style="display: table-row;">
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
        document.querySelector(`tr[eva-${target}-input][data-uid="${uid}"]`).style.display = 'none';
    },
}