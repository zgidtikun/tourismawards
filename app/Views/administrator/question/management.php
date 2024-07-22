<style>
    .grid {
        border-top: 1px solid #eee;
        padding-top: 1rem;
    }

    .dataTables_wrapper .dataTables_length {
        justify-content: flex-start !important;
    }

    .dataTables_wrapper .dataTables_length label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .line-clamp {
        display: -webkit-box;
        text-overflow: ellipsis;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }

    .line-clamp-del {
        display: -webkit-box;
        text-overflow: ellipsis;
        -webkit-line-clamp: 5;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
</style>
<div class="backendcontent">
    <div class="backendcontent-row">
        <div class="backendcontent-title">
            <div class="backendcontent-title-txt">
                <h3>รายการคำถาม</h3>
            </div>
            <?php if(isChaiyo()): ?>
            <a href="<?= base_url('administrator/question/add') ?>" class="btn-blue">เพิ่มคำถาม</a>
            <?php endif; ?>
        </div>

        <form class="backendcontent-subrow row" action="" method="GET">
            <div class="backendcontent-subcol searchbox col-sm-2">
            <input type="text" class="form-control" name="keyword" id="keyword" value="<?= @$_GET['keyword'] ?>" placeholder="ค้นหา">
            </div>
            <div class="backendcontent-subcol selectbox col-sm-3">
                <label>ประเภทรางวัล</label>
                <select id="type" name="type">
                    <option value="">ทั้งหมด</option>
                    <?php foreach($types as $type): ?>
                        <option value="<?= $type->id ?>"><?= $type->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="backendcontent-subcol selectbox col-sm-3">
                <label>ประเภทรางวัลย่อย</label>
                <select id="subtype" name="subtype">
                    <option value="">ทั้งหมด</option>
                    <?php foreach($subs as $sub): ?>
                        <option value="<?= $sub->id ?>" data-parent="<?= $sub->application_type_id ?>">
                            <?= $sub->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="backendcontent-subcol selectbox col-sm-3">
                <label>กลุ่มการประเมิน</label>
                <select id="assessment" name="assessment">
                    <option value="">ทั้งหมด</option>
                    <?php foreach($asses as $asse): ?>
                        <option value="<?= $asse->id ?>"><?= $asse->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="backendcontent-subcol btn col-sm-3">
                <button type="button" class="but-blue" id="btn_search" onclick="getList()">ค้นหา</button>
            </div>
        </form>

        <div class="backendcontent-subrow">
            <div class="form-table">
                <div class="grid">
                    <div class="unit w-1-1">
                        <table id="question-tbl" class="display" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center text-nowrap">#</th>
                                    <th class="text-center text-nowrap">ลำดับข้อ</th>
                                    <th class="text-center text-nowrap">ประเภทรางวัล</th>
                                    <th class="text-center text-nowrap">ประเภทรางวัลย่อย</th>
                                    <th class="text-center text-nowrap">กลุ่มการประเมิน</th>
                                    <th class="text-center text-nowrap">คำถาม</th>
                                    <th class="text-center text-nowrap"><i class="bi bi-three-dots"></i></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        getList();
    });

    var questions, datatable;

    const getList = () => {
        const headers = new Headers();
        headers.append('Content-Type', 'application/json');

        fetch(
            `${window.location.origin}/administrator/question/list`,
            {
                method: 'POST',
                headers: headers,
                body: JSON.stringify({
                    keyword: document.querySelector('#keyword').value,
                    type: document.querySelector('#type').value,
                    sub_type: document.querySelector('#subtype').value, 
                    assessment: document.querySelector('#assessment').value
                }),
                redirect: "error"
            }
        )
        .then(response => response.json())
        .then(response => {
            questions = response;
            setTable(questions);
        })
        .catch(errors => {
            resolve({
                status: false,
                result: 'error',
                message: `Request failed : ${errors.statusText}`
            });
        })
    }

    <?php if(isChaiyo()): ?>
    const removeQuestion = id => {
        const question = questions.find(el => Number(el.id) === id);
        
        const option = {
            title: 'คุณต้องการลบคำถามนี้หรือไม่',
            html: `<div class="line-clamp-del text-start">${question.question}</div>`
        }

        swal_confirm(option).done(function() {
            fetch(`${window.location.origin}/administrator/question/remove/${id}`, {method: 'get'})        
            .then(response => response.json())        
            .then(response => {
                if(response.result === 'success'){
                    res_swal({ type: 'success', title: 'เสร็จสิ้น', html: response.message });
                    datatable.ajax.reload();
                } else {
                    res_swal({ type: 'error', title: 'ไม่สำเร็จ', html: response.message });
                }
            })
            .catch(errors => {
                res_swal({ type: 'error', title: 'Warning!', html: errors.statusText });
            });
        });
    }
    <?php endif; ?>

    const setTable = data => {
        if(!$.fn.DataTable.isDataTable('#question-tbl')){
            datatable = $('#question-tbl').DataTable({
                data: data,
                pageLength: 25,
                responsive: true,
                procressing: true,
                info: true,
                lengthChange: true,
                searching: false,
                autoWidth: false, 
                columns: [
                    { data: 'no' },
                    { data: 'ordering' },
                    { data: 'type_name' },
                    { data: 'sub_name' },
                    { data: 'asses_name' },
                    { 
                        data: 'question', render: (data, type, row, meta) => {
                            const content = `<div class="line-clamp">${data}</div>`;
                            return content;
                        }
                    },
                    {
                        data: 'id', render: (data, type, row, meta) => {
                            let content = '<div class="form-table-col edit">';

                            <?php if(isChaiyo()): ?>
                                content += `
                                    <a href="${window.location.origin}/administrator/question/detail/${data}" class="btn-edit" title="แก้ไข">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="javascript:removeQuestion(${data})" class="btn-delete" title="ลบ">
                                        <i class="bi bi-trash2-fill text-danger"></i>
                                    </a>`;
                            <?php //else: ?>
                                content += `<a href="${window.location.origin}/administrator/question/show/${data}" class="btn-edit" title="ดูข้อมูล">
                                        <i class="bi bi-eye-fill text-info"></i>
                                </a>`;
                            <?php endif; ?>

                            content += '</div>';

                            return content;
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: [0, 1],
                        className: 'text-nowrap'
                    },
                    {
                        targets: [2, 3, 4, 5],
                        className: 'text-start'
                    },                  
                    {                    
                        targets: [0, 1, 2, 3, 4, 5, 6],
                        searchable: false,
                        orderable: false
                    }
                ],
                order: [],
                lengthMenu: [10, 25, 50, 100, 250, 500],
                language: {
                    search: "ค้นหา",
                    searchPlaceholder: "ค้นหา",
                    emptyTable: "ไม่มีรายการข้อมูล",
                    info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    infoEmpty: "",
                    zeroRecords: "ไม่มีรายการข้อมูล",
                    infoFiltered: "(ค้นหาจากทั้งหมด _MAX_ รายการ)",
                    lengthMenu: "แสดง _MENU_ รายการ",
                    processing: "กำลังดึงข้อมูล",
                    paginate: {
                        next: 'ถัดไป',
                        previous: 'ย้อนกลับ'
                    }
                },
            });

            datatable.on('order.dt search.dt', function() {
                let i = 1;

                datatable.cells(null, 0, { search: 'applied', order: 'applied' }).every(function(cell) {
                    this.data(i++);
                });
            }).draw();
        } else {
            datatable.clear().rows.add(data).draw();
        }
    }
</script>