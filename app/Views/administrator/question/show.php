<link rel="stylesheet" href="<?= base_url('assets/css/custom-bs.css?v='.config(\Config\App::class)->script_v) ?>">
<?php if(!$expired): ?>  
<style>
    a:hover, a:focus { color: #0a58ca }
    [eva-ps-input], [eva-os-input] { display: none; }
    .form-table-col.edit {
        height: 100%;
        align-items: flex-end;
    }
</style>
<?php endif; ?>
<div class="backendcontent">
    <div class="backendcontent-row">

        <div class="backendcontent-title">
            <div class="backendcontent-title-txt">
                <h3>รายละเอียดคำถาม</h3>
            </div>
        </div>

        <div class="backendcontent-subrow" style="margin: 0;justify-content: center;width: 100%;">
            <div class="bs-row">
                <div class="bs-col-12 bs-col-md-6 bs-col-lg-3">
                    <p class="small text-muted m-0">ประเภทรางวัล</p>
                    <?= $question->type_name ?>
                </div>
                <div class="bs-col-12 bs-col-md-6 bs-col-lg-3">
                    <p class="small text-muted m-0">ประเภทรางวัลย่อย</p>
                    <?= $question->sub_name ?>
                </div>
                <div class="bs-col-12 bs-col-md-6 bs-col-lg-3">
                    <p class="small text-muted m-0">กลุ่มการประเมิน</p>
                    <?= $question->assessment_name ?>
                </div>
                <div class="bs-col-12 bs-col-md-6 bs-col-lg-3">
                    <p class="small text-muted m-0">ห้วข้อหลักเกณฑ์</p>
                    <?= $question->topic_name ?>
                </div>
                <div class="bs-col-12 bs-col-md-3 bs-col-lg-2">
                    <p class="small text-muted m-0">ลำดับคำถาม</p>
                    <?= $question->ordering ?>
                </div>
                <div class="bs-col-12 bs-col-md-3 bs-col-lg-2">
                    <p class="small text-muted m-0">ลำดับหลักเกณฑ์</p>
                    <?= $question->topic_no ?>
                </div>
                <div class="bs-col-12 bs-col-md-3 bs-col-lg-2">
                    <p class="small text-muted m-0">น้ำหนักการให้คะแนน</p>
                    <?php if(!$expired): ?>
                    <a href="javascript:changeWeight(<?= $question->weight ?>,<?= $question->id ?>);" title="เปลี่ยนน้ำหนักการให้คะแนน">
                        <?= $question->weight ?> 
                        <i class="bi bi-pencil-square" style="margin-left: 0.25rem;"></i>
                    </a>
                    <?php else: ?>
                        <?= $question->weight ?> 
                    <?php endif; ?>
                </div>
                <div class="bs-col-12">
                    <p class="small text-muted m-0">รอบการประเมิน</p>
                    <?php if($question->pre_status == 1): ?>
                    <span style="margin-right: 0.5rem;"><i class="bi bi-check2-square text-success"></i> Pre-Screen</span>
                    <?php endif; ?>
                    <?php if($question->onside_status == 1): ?>
                    <span style="margin-right: 0.5rem;"><i class="bi bi-check2-square text-success"></i> ลงพื้นที่</span>
                    <?php endif; ?>
                    <?php if($question->lowcarbon_status == 1): ?>
                    <span style="margin-right: 0.5rem;"><i class="bi bi-check2-square text-success"></i> Low Carbon</span>
                    <?php endif; ?>
                </div>
                <div class="bs-col-12">
                    <p class="small text-muted m-0">คำถาม</p>
                    <?= $question->question ?>
                </div>
                <div class="bs-col-12">
                    <p class="small text-muted m-0">หมายเหตุคำถาม</p>
                    <?= $question->remark ?>
                </div>
                <div class="bs-col-12 bs-col-lg-6">
                    <form class="criteria" eva-ps-form>
                        <div class="bs-row" style="margin-top: 0.5rem;margin-bottom: 0.5rem;">
                            <div class="bs-col" style="margin-top: 0;">
                                <span style="font-weight: 600;">การประเมินผล Pre-Screen</span>                                
                                <?php if(!$expired): ?>
                                <a href="javascript:setEdit('ps');" class="float-end" eva-ps-edit>
                                    <i class="bi bi-pencil-square"></i>
                                    แก้ไข
                                </a>
                                <?php endif; ?>
                            </div>
                            <div class="bs-col" eva-ps-show>
                                <p class="small text-muted m-0">เกณฑ์การประเมิน</p>
                                <?= $question->pre_evaluation??'ไม่ได้กำหนด' ?>
                            </div>
                            <?php if(!$expired): ?>
                            <div class="bs-col" eva-ps-input>
                                <label for="ps-criteria" class="form-label small text-muted">เกณฑ์การประเมิน</label>
                                <textarea id="ps-criteria" class="form-control editer"><?= $question->pre_evaluation ?></textarea>
                                <div for="ps-criteria" class="invalid-feedback">กรุณาระบุ เกณฑ์การประเมิน</div>
                            </div>
                            <?php endif; ?>
                            <div class="bs-col" eva-ps-show>
                                <p class="small text-muted m-0">คะแนนเต็ม</p>
                                <?= $question->pre_score??'ไม่ได้กำหนด' ?>
                            </div>
                            <?php if(!$expired): ?>
                            <div class="bs-col-12 bs-col-md-6" eva-ps-input>
                                <label for="ps-max" class="form-label small text-muted">คะแนนเต็ม</label>
                                <input type="text" id="ps-max" class="form-control text-end number"
                                value="<?= $question->pre_score ?>">
                                <div for="ps-max" class="invalid-feedback">กรุณาระบุ คะแนนเต็ม</div>
                            </div>              
                            <div class="bs-col-12 bs-col-md-6" eva-ps-input>
                                <div class="form-table-col edit" style="justify-content: flex-end;">
                                    <a href="javascript:eva.add('ps')" class="btn-edit" >
                                        <i class="bi bi-plus-lg"></i>
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="bs-col" style="margin-top: 0.25rem">
                                <div class=" table-responsive">
                                    <table class="table table-sm table-hover table-striped m-0" id="eva-ps-tbl">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="85%">เกณฑ์คะแนน</th>
                                                <th class="text-center" width="15%">คะแนน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        if(!empty($question->pre_scoring)):
                                            foreach($question->pre_scoring as $score):
                                        ?>
                                            <tr eva-ps-show>
                                                <td><?= $score->subject ?></td>
                                                <td class="text-center"><?= $score->score ?></td>
                                            </tr>
                                        <?php 
                                            endforeach;
                                            if(!$expired):
                                                foreach($question->pre_scoring as $score):
                                                    $uid = uniqid();
                                        ?>
                                        <tr eva-ps-input data-origin="default" data-uid="<?= $uid ?>">
                                            <td>
                                                <input id="ps-subject-<?= $uid ?>" type="text" class="form-control"
                                                value="<?= $score->subject ?>">
                                            </td>
                                            <td>
                                                <input id="ps-score-<?= $uid ?>" type="text" class="form-control number"
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
                                        else:
                                        ?>
                                            <tr><td class="text-center" colspan="2">ไม่ได้กำหนด</td></tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php if(!$expired): ?>
                            <div eva-ps-input class="bs-col text-right">
                                <button type="button" class="btn btn-success">
                                    บันทึก
                                </button>
                                <button type="button" class="btn btn-danger" onclick="closeEdit('ps')">
                                    ยกเลิก
                                </button>
                            </div>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
                <div class="bs-col-12 bs-col-lg-6">
                    <form class="criteria" eva-os-form>
                        <div class="bs-row" style="margin-top: 0.5rem;margin-bottom: 0.5rem;">
                            <div class="bs-col" style="margin-top: 0;">
                                <span style="font-weight: 600;">การประเมินผล ลงพื้นที่</span>
                                <?php if(!$expired): ?>
                                <a href="javascript:setEdit('os');" class="float-end" eva-os-edit>
                                    <i class="bi bi-pencil-square"></i>
                                    แก้ไข
                                </a>
                                <?php endif; ?>
                            </div>
                            <div class="bs-col" eva-os-show>
                                <p class="small text-muted m-0">เกณฑ์การประเมิน</p>
                                <?= $question->onside_evaluation??'ไม่ได้กำหนด' ?>
                            </div>
                            <?php if(!$expired): ?>
                            <div class="bs-col" eva-os-input>
                                <label for="os-criteria" class="form-label text-muted">เกณฑ์การประเมิน</label>
                                <textarea id="os-criteria" class="form-control editer"><?= $question->onside_evaluation ?></textarea>
                                <div for="os-criteria" class="invalid-feedback">กรุณาระบุ เกณฑ์การประเมิน</div>
                            </div>
                            <?php endif; ?>
                            <div class="bs-col" eva-os-show>
                                <p class="small text-muted m-0">คะแนนเต็ม</p>
                                <?= $question->onside_score??'ไม่ได้กำหนด' ?>
                            </div>
                            <?php if(!$expired): ?>
                            <div class="bs-col-12 bs-col-md-6" eva-os-input>
                                <label for="os-max" class="form-label small text-muted">คะแนนเต็ม</label>
                                <input type="text" id="os-max" class="form-control text-end number"
                                value="<?= $question->onside_score ?>">
                                <div for="os-max" class="invalid-feedback">กรุณาระบุ คะแนนเต็ม</div>
                            </div>                   
                            <div class="bs-col-12 bs-col-md-6" eva-os-input>
                                <div class="form-table-col edit" style="justify-content: flex-end;">
                                    <a href="javascript:eva.add('os')" class="btn-edit" >
                                        <i class="bi bi-plus-lg"></i>
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="bs-col" style="margin-top: 0.25rem">
                                <div class=" table-responsive">
                                    <table class="table table-sm table-hover table-striped m-0" id="eva-os-tbl">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="85%">เกณฑ์คะแนน</th>
                                                <th class="text-center" width="15%">คะแนน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        if(!empty($question->onside_scoring)):
                                            foreach($question->onside_scoring as $score):
                                        ?>
                                            <tr eva-os-show>
                                                <td><?= $score->subject ?></td>
                                                <td class="text-center"><?= $score->score ?></td>
                                            </tr>
                                        <?php 
                                            endforeach;
                                            if(!$expired):
                                                foreach($question->onside_scoring as $score):
                                                    $uid = uniqid();
                                        ?>
                                        <tr eva-os-input data-origin="default" data-uid="<?= $uid ?>">
                                            <td>
                                                <input id="os-subject-<?= $uid ?>" type="text" class="form-control"
                                                value="<?= $score->subject ?>">
                                            </td>
                                            <td>
                                                <input id="os-score-<?= $uid ?>" type="text" class="form-control number"
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
                                        else:
                                        ?>
                                            <tr><td class="text-center" colspan="2">ไม่ได้กำหนด</td></tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>                                
                            </div>
                            <?php if(!$expired): ?>                                          
                            <div eva-os-input class="bs-col text-right">
                                <button type="button" class="btn btn-success">
                                    บันทึก
                                </button>
                                <button type="button" class="btn btn-danger" onclick="closeEdit('os')">
                                    ยกเลิก
                                </button>
                            </div>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<?php if(!$expired): ?>  
<script src="<?= base_url('assets/js/admin/question/show.js?v='.config(\Config\App::class)->script_v) ?>"></script>
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
<?php endif; ?>
