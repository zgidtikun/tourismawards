<link rel="stylesheet" href="<?= base_url('assets/css/custom-bs.css?v='.config(\Config\App::class)->script_v) ?>">
<div class="backendcontent">
    <div class="backendcontent-row">
        <div class="backendcontent-title">
            <div class="backendcontent-title-txt">
                <h3>เพิ่มคำถาม</h3>
            </div>
        </div>

        <div class="backendcontent-subrow" style="margin: 0;justify-content: center;width: 100%;">
            <input type="hidden" id="id" value="<?= $question->id ?>">
            <div class="bs-row">
                <div class="bs-col-12 bs-col-md-4 bs-col-lg-3">
                    <label for="type" class="form-label">ประเภทรางวัล <span class="text-danger">*</span></label>
                    <select id="type" class="form-select">
                        <option value="">เลือก</option>
                        <?php foreach($types as $type): ?>
                            <option value="<?= $type->id ?>"
                            <?php if($question->application_type_id == $type->id) echo 'selected' ?>
                            ><?= $type->name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div for="type" class="invalid-feedback">กรุณาเลือก ประเภทรางวัล</div>
                </div>
                <div class="bs-col-12 bs-col-md-4 bs-col-lg-3">
                    <label for="subtype" class="form-label">ประเภทรางวัลย่อย <span class="text-danger">*</span></label>
                    <select id="subtype" class="form-select">
                        <option value="" data-parent="">เลือก</option>
                        <?php foreach($subs as $sub): ?>
                            <option value="<?= $sub->id ?>" 
                            <?php if($question->application_type_sub_id == $sub->id) echo 'selected' ?>
                            <?php if($question->application_type_id != $sub->application_type_id) echo 'style="display: none;"' ?>                            
                            data-parent="<?= $sub->application_type_id ?>">
                                <?= $sub->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div for="subtype" class="invalid-feedback">กรุณาเลือก ประเภทรางวัลย่อย</div>
                </div>
                <div class="bs-col-12 bs-col-md-4 bs-col-lg-3">
                    <label for="assessment" class="form-label">กลุ่มการประเมิน <span class="text-danger">*</span></label>
                    <select id="assessment" class="form-select">
                        <option value="">เลือก</option>
                        <?php foreach($asses as $asse): ?>
                            <option value="<?= $asse->id ?>"
                            <?php if($question->assessment_group_id == $asse->id) echo 'selected' ?>
                            ><?= $asse->name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div for="assessment" class="invalid-feedback">กรุณาเลือก กลุ่มการประเมิน</div>
                </div>
                <div class="bs-col-12 bs-col-md-4 bs-col-lg-3">
                    <label for="topic" class="form-label">ห้วข้อหลักเกณฑ์</label>
                    <select id="topic" class="form-select">
                        <option value="">ไม่กำหนด</option>
                        <?php foreach($topics as $topic): ?>
                            <option value="<?= $topic->id ?>"
                            <?php if($question->criteria_topic == $topic->id) echo 'selected' ?>
                            ><?= $topic->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="bs-col-12 bs-col-md-3 bs-col-lg-2">
                    <label for="ordering_topic" class="form-label">ลำดับหลักเกณฑ์ <span class="text-danger">*</span></label>
                    <input type="text" id="ordering_topic" class="form-control text-end unsign" 
                    value="<?= $question->topic_no ?>">
                    <div for="ordering_topic" class="invalid-feedback">กรุณาระบุ ลำดับหลักเกณฑ์</div>
                </div>
                <div class="bs-col-12 bs-col-md-3 bs-col-lg-2">
                    <label for="ordering_question" class="form-label">ลำดับคำถาม <span class="text-danger">*</span></label>
                    <input type="text" id="ordering_question" class="form-control text-end unsign" 
                    value="<?= $question->question_ordering ?>">
                    <div for="ordering_question" class="invalid-feedback">กรุณาระบุ ลำดับคำถาม</div>
                </div>
                <div class="bs-col-12 bs-col-md-3 bs-col-lg-2">
                    <label for="weight" class="form-label">น้ำหนักการให้คะแนน <span class="text-danger">*</span></label>
                    <input type="text" id="weight" class="form-control text-end number" 
                    value="<?= $question->weight ?>">
                    <div for="weight" class="invalid-feedback">กรุณาระบุ น้ำหนักการให้คะแนน</div>
                </div>
                <div class="bs-col-12">
                    <label for="weight" class="form-label">
                        รอบการประเมิน <span class="text-danger">*</span>
                        <span class="text-danger" id="invalid-round" style="display: none;font-size: 0.875em;margin-left: 0.5rem;">
                            กรุณาระบุ รอบการประเมิน
                        </span>
                    </label>
                </div>
                <div class="bs-col-12" style="margin-top: 0;">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="is_ps" value="1"
                        <?php if($question->pre_status == 1) echo 'checked' ?>>
                        <label class="form-check-label" for="is_pre">Pre-Screen</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="is_os" value="1"
                        <?php if($question->onside_status == 1) echo 'checked' ?>>
                        <label class="form-check-label" for="is_os">ลงพื้นที่</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="is_lc" value="1"
                        <?php if($question->lowcarbon_status == 1) echo 'checked' ?>>
                        <label class="form-check-label" for="is_lc">Low Carbon</label>
                    </div>
                </div>
                
                <div class="bs-col-12">
                    <label for="question" class="form-label">คำถาม <span class="text-danger">*</span></label>
                    <textarea id="question" class="form-control editer"><?= $question->question ?></textarea>
                    <div for="question" class="invalid-feedback">กรุณาระบุ คำถาม</div>
                </div>
                <div class="bs-col-12">
                    <label for="ordering_question" class="form-label">หมายเหตุคำถาม</label>
                    <textarea id="remark-question" class="form-control"><?= $question->remark ?></textarea>
                </div>
                <div class="bs-col-12 bs-col-lg-6">
                    <div class="criteria">
                        <div class="bs-row" style="margin-top: 0.5rem;margin-bottom: 0.5rem;">
                            <div class="bs-col" style="margin-top: 0;">
                                <span style="font-weight: 600;">การประเมินผล Pre-Screen</span>
                            </div>
                            <div class="bs-col">
                                <label for="ps-criteria" class="form-label">เกณฑ์การประเมิน</label>
                                <textarea id="ps-criteria" class="form-control editer"><?= $question->pre_evaluation_criteria ?></textarea>
                                <div for="ps-criteria" class="invalid-feedback">กรุณาระบุ เกณฑ์การประเมิน</div>
                            </div>
                            <div class="bs-col-12 bs-col-md-6">
                                <label for="ps-max" class="form-label">คะแนนเต็ม</label>
                                <input type="text" id="ps-max" class="form-control text-end number"
                                value="<?= $question->pre_score ?>">
                                <div for="ps-max" class="invalid-feedback">กรุณาระบุ คะแนนเต็ม</div>
                            </div>
                            <div class="bs-col">
                                <div class="form-table-col edit" style="justify-content: flex-end;">
                                    <a href="javascript:eva.add('ps')" class="btn-edit" >
                                        <i class="bi bi-plus-lg"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="bs-col" style="margin-top: 0.25rem">
                                <div class=" table-responsive">
                                    <table class="table table-sm table-hover table-striped m-0" id="eva-ps-tbl">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="80%">เกณฑ์คะแนน</th>
                                                <th class="text-center" width="15%">คะแนน</th>
                                                <th class="text-center" width="5%"><i class="bi bi-three-dots"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        if(!empty($question->pre_scoring_criteria)):
                                            foreach($question->pre_scoring_criteria as $score):
                                                $uid = uniqid();
                                        ?>
                                            <tr ps-score-list data-uid="<?= $uid ?>">
                                                <td>
                                                    <input id="ps-subject-<?= $uid ?>" type="text" class="form-control"
                                                    value="<?= $score->subject ?>">
                                                </td>
                                                <td>
                                                    <input id="ps-score-<?= $uid ?>" class="form-control number"
                                                    value="<?= $score->score ?>">
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger" 
                                                    onclick="eva.remove('ps','<?= $uid ?>')">
                                                        <i class="bi bi-trash2-fill"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php 
                                            endforeach;
                                        endif;
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bs-col-12 bs-col-lg-6">
                    <div class="criteria">
                        <div class="bs-row" style="margin-top: 0.5rem;margin-bottom: 0.5rem;">
                            <div class="bs-col" style="margin-top: 0;">
                                <span style="font-weight: 600;">การประเมินผล ลงพื้นที่</span>
                            </div>
                            <div class="bs-col">
                                <label for="os-criteria" class="form-label">เกณฑ์การประเมิน</label>
                                <textarea id="os-criteria" class="form-control editer"><?= $question->onside_evaluation_criteria ?></textarea>
                                <div for="os-criteria" class="invalid-feedback">กรุณาระบุ เกณฑ์การประเมิน</div>
                            </div>
                            <div class="bs-col-12 bs-col-md-6">
                                <label for="os-max" class="form-label">คะแนนเต็ม</label>
                                <input type="text" id="os-max" class="form-control text-end number"
                                value="<?= $question->onside_score ?>">
                                <div for="os-max" class="invalid-feedback">กรุณาระบุ คะแนนเต็ม</div>
                            </div>
                            <div class="bs-col">
                                <div class="form-table-col edit" style="justify-content: flex-end;">
                                    <a href="javascript:eva.add('os')" class="btn-edit" >
                                        <i class="bi bi-plus-lg"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="bs-col" style="margin-top: 0.25rem">
                                <div class=" table-responsive">
                                    <table class="table table-sm table-hover table-striped m-0" id="eva-os-tbl">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="80%">เกณฑ์คะแนน</th>
                                                <th class="text-center" width="15%">คะแนน</th>
                                                <th class="text-center" width="5%"><i class="bi bi-three-dots"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        if(!empty($question->onside_scoring_criteria)):
                                            foreach($question->onside_scoring_criteria as $score):
                                                $uid = uniqid();
                                        ?>
                                            <tr os-score-list data-uid="<?= $uid ?>">
                                                <td>
                                                    <input id="os-subject-<?= $uid ?>" type="text" class="form-control"
                                                    value="<?= $score->subject ?>">
                                                </td>
                                                <td>
                                                    <input id="os-score-<?= $uid ?>" class="form-control number"
                                                    value="<?= $score->score ?>">
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger" 
                                                    onclick="eva.remove('os','<?= $uid ?>')">
                                                        <i class="bi bi-trash2-fill"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php 
                                            endforeach;
                                        endif;
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bs-col">  
                    <div class="form-main-btn">                 
                        <a href="<?= base_url('administrator/question') ?>" class="btn-cancle">ยกเลิก</a>
                        <a href="javascript:eva.save('edit')" class="btn-save" id="btn_save">บันทึก</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="<?= base_url('assets/js/admin/question/create.js?v='.config(\Config\App::class)->script_v) ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        $('.editer').summernote({
            height: 100,
            callbacks: {
                onChange: function(contents, $editable) {       
                    if(document.querySelector(`#${this.id} ~ .note-editor`).classList.contains('is-invalid')){
                        document.querySelector(`#${this.id} ~ .note-editor`).classList.remove('is-invalid','border','border-danger');
                    }
                }
            }
        });
    });
</script>
