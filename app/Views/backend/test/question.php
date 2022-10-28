<div class="row page-titles mx-0">
  <div class="col-sm p-md-0">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('backend/Dashboard') ?>">หน้าแรก</a></li>
      <li class="breadcrumb-item active"><a href="javascript:void(0)"><?= $title ?></a></li>
    </ol>
  </div>
  <div class="col-sm p-md-0 mt-2 mt-sm-0 justify-content-sm-end d-flex">

  </div>
</div>

<div class="row ml-4 mr-4">
  <div class="col-xl-12 col-xxl-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?= $title ?> (Demo ทำไว้ใช้เอง)</h3>
        <div class="card-action float-sm-right my-3 my-sm-0">
          <button type="button" class="btn btn-primary" onclick="insert_item(this)"><i class="fas fa-edit"></i> เพิ่มข้อมูล</button>
        </div>
      </div>
      <div class="card-body">
        <?php
        // pp($result);
        ?>
        <div class="table-responsive">
          <table id="main_datatable" class="table table-striped" style="width:100%">
            <thead>
              <tr>
                <th class="text-center" width="1%">#</th>
                <th class="text-center" width="10%">Topic</th>
                <th class="text-center" width="10%">question</th>
                <th class="text-center" width="10%">pre score</th>
                <!-- <th class="text-center" width="5%">score</th> -->
                <th class="text-center" width="10%">onside score</th>
                <!-- <th class="text-center" width="5%">score</th> -->
                <th class="text-center" width="5%">weight</th>
                <!-- <th class="text-center" width="10%">คำถาม</th>
                <th class="text-center" width="10%">คำถาม-หมายเหตุ</th> -->
                <th class="text-center" width="5%">จัดการ</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (!empty($result)) :
                foreach ($result as $key => $value) :
              ?>
                  <tr>
                    <td class="text-center"><?= $value->id ?></td>
                    <td><?= $value->criteria_topic ?></td>
                    <td><?= $value->question ?></td>
                    <!-- <td><?= $value->pre_scoring_criteria ?></td> -->
                    <td>
                      <input type="text" name="pre_score" class="form-control text-center pre_score" value="<?= $value->pre_score ?>">
                    </td>
                    <!-- <td><?= $value->onside_scoring_criteria ?></td> -->
                    <td>
                      <input type="text" name="onside_score" class="form-control text-center onside_score" value="<?= $value->onside_score ?>">
                    </td>
                    <td>
                      <input type="text" name="weight" class="form-control text-center weight" value="<?= $value->weight ?>">
                    </td>
                    <!-- <td><?= $value->question ?></td> -->
                    <!-- <td><?= $value->remark ?></td> -->
                    <td class="text-center">
                      <i class="fas fa-edit text-primary mr-2" data-toggle="tooltip" title="แก้ไขข้อมูล" onclick="edit_item('<?= $value->id ?>')"></i></a>
                      <i class="fas fa-save text-success mr-2" data-toggle="tooltip" title="บันทึกข้อมูล" onclick="save_item(this, '<?= $value->id ?>')"></i></a>
                      <!-- <i class="fas fa-trash-alt text-danger mr-2" data-toggle="tooltip" title="ลบข้อมูล" onclick="delete_item('<?= $value->id ?>')"></i> -->
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

<!-- Modal -->
<div class="modal fade bd-example-modal-xl" id="exampleModal" data-target=".bd-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ตัวอย่างเนื้อหา</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times text-danger"></i>
        </button>
      </div>
      <div class="modal-body">

        <form id="form_input">
          <input type="hidden" name="table" id="table">
          <div class="row">
            <?php
            foreach ($fields as $key => $value) :
              $key_arr = range(7, 13);
            ?>
              <div class="col-6">
                <div class="form-group">
                  <label for="<?= $value ?>"><?= $value ?></label>
                  <textarea class="form-control" name="<?= $value ?>" id="<?= $value ?>" <?= (in_array($key, $key_arr)) ? 'cols="15" rows="10"' : ''; ?>></textarea>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
        <button type="button" class="btn btn-success" id="btn_save"><i class="fas fa-save"></i> บันทึก</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#btn_save').click(function(e) {
    var id = $('#id').val();
    $('#table').val('question');
    if (id == 0 || id == "") {
      var res = main_save(BASE_URL_BACKEND + '/MarkTest/saveInsert', '#form_input');
      cc(res)
      res_swal(res, 1)
    } else {
      var res = main_save(BASE_URL_BACKEND + '/MarkTest/saveUpdate', '#form_input');
      cc(res)
      res_swal(res, 1)
    }
  });

  function delete_item(id) {
    var option = {
      title: "Warning!",
      text: "คุณต้องการยืนยันการลบข้อมูล<?= $title ?>หรือไม่?",
    }
    swal_confirm(option).done(function() {
      var res = main_post(BASE_URL_BACKEND + '/MarkTest/delete', {
        id: id,
        table: 'question',
      });
      res_swal(res, 0);
    })
  }

  function edit_item(id) {
    var res = main_post(BASE_URL_BACKEND + '/MarkTest/getData', {
      id: id,
      table: 'question',
    });
    $.each(res, function(index, value) {
      $('#' + index).val(value);
    });
    
    // $('#id').val("");
    $('#exampleModal').modal('show');
  }

  function insert_item(elm) {
    $('#form_input')[0].reset();

    $('#assessment_group_id').val(3);
    $('#application_type_id').val(1);
    $('#application_type_sub_id').val(1);

    $('#pre_status').val(1);
    $('#onside_status').val(1);
    $('#criteria_topic').val('ด้านความปลอดภัย');

    $('#exampleModal').modal('show');
  }

  function save_item(elm, id) {
    var tr = $(elm).closest('tr');
    var pre_score = $(tr).find('.pre_score').val();
    var onside_score = $(tr).find('.onside_score').val();
    var weight = $(tr).find('.weight').val();

    var res = main_post(BASE_URL_BACKEND + '/MarkTest/saveUpdate', {
      id: id,
      pre_score: pre_score,
      onside_score: onside_score,
      weight: weight,
      table: 'question',
    });
    res_swal(res, 0);
  }
</script>