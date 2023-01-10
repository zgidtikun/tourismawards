<style>
  .dataTables_wrapper .dataTables_length {
    float: none;
    justify-content: unset;
    flex: auto;
    display: flex;
  }
</style>
<div class="backendcontent">
  <div class="backendcontent-row">
    <div class="backendcontent-title">
      <div class="backendcontent-title-txt">
        <h3>แก้ไขคะแนน</h3>
      </div>
      <!-- <a href="javascript:" class="btn-blue" onclick="insert_item(this)">เพิ่มข้อมูล</a> -->
      <a href="<?= base_url() ?>/administrator/lowcarbon/print/<?= $app_id ?>/<?= $user_id ?>" class="btn-export">
        <i class="bi bi-box-arrow-right" style="margin-right: 5px;"></i> พิมพ์
      </a>
    </div>

    <div class="backendcontent-subrow">
      <div class="form-table">
        <div class="grid">
          <div class="unit w-1-1">
            <!-- <table id="main_datatable" class="display"> -->
            <table id="example" class="display" style="width: 100%;">
              <thead>
                <tr>
                  <th width="10%">ข้อ</th>
                  <th width="60%">คำถาม</th>
                  <th width="20%">คะแนน</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (!empty($estimate)) {
                  foreach ($estimate as $key => $value) {
                ?>
                    <tr data-row="<?= $key ?>">
                      <td class="text-center"><?= ($key + 1) ?></td>
                      <td class="text-start"><?= $value->question ?></td>
                      <td class="text-center">
                        <?php
                        // echo $value->score_pre;
                        $checked_0 = '';
                        $checked_1 = '';
                        $disabled_0 = '';
                        $disabled_1 = '';
                        if ($value->score_pre == 1) {
                          $checked_1 = 'checked';
                          $disabled_1 = 'disabled';
                        } else if ($value->score_pre == 0) {
                          $checked_0 = 'checked';
                          $disabled_0 = 'disabled';
                        }
                        ?>
                        <div id="head_row">
                          <input type="radio" id="lowcarbon_1_<?= $key ?>" name="lowcarbon_<?= $key ?>" onclick="change_score(this, <?= $value->qu_id ?>, 1)" value="1" <?= $checked_1; ?> <?= $disabled_1; ?>>
                          <label for="lowcarbon_1_<?= $key ?>"> มีคุณสมบัติตามเกณฑ์</label>
                          <input type="radio" id="lowcarbon_0_<?= $key ?>" name="lowcarbon_<?= $key ?>" onclick="change_score(this, <?= $value->qu_id ?>, 0)" value="0" <?= $checked_0; ?> <?= $disabled_0; ?>>
                          <label for="lowcarbon_0_<?= $key ?>"> ไม่มีคุณสมบัติ</label>
                        </div>
                      </td>
                    </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<input type="hidden" id="app_id" value="<?= $app_id ?>">
<input type="hidden" id="user_id" value="<?= $user_id ?>">

<script>
  $(function() {
    <?php if (!empty($status)) { ?>
      Swal.fire({
        // position: 'top-end',
        icon: 'error',
        title: '<?php echo $status['error'] ?>',
        showConfirmButton: false,
        timer: 3000
      });
    <?php } ?>

    var pgurl = BASE_URL_BACKEND + '/lowcarbon';
    active_page(pgurl);

    $.fn.DataTable.ext.pager.numbers_length = 6;
    $("#example").dataTable().fnDestroy();
    $("#example").addClass("nowrap").dataTable({
      responsive: true,
      searching: true,
      lengthMenu: [20, 50, 100],
      oLanguage: {
        sSearchPlaceholder: "ค้นหา",
        sLengthMenu: "แสดง _MENU_ รายการ",
        sSearch: "ค้นหา",
        sInfo: "แสดง _START_ ถึง _END_ ทั้งหมด _TOTAL_ รายการ",
        sInfoEmpty: "แสดง 0 ถึง 0 ทั้งหมด 0 รายการ",
        sInfoFiltered: "(ค้นหาจากทั้งหมด _MAX_ รายการ)",
        sZeroRecords: "ไม่มีข้อมูล",
        sProcessing: "Processing",
        semptyTable: "ไม่มีข้อมูล",
      }
    });
  });

  function change_score(elm, qu_id, score) {
    var tr = $(elm).closest('tr');
    if (score == 1) {
      $(tr).find('[type="radio"][value="0"]').prop('disabled', false);
      $(tr).find('[type="radio"][value="1"]').prop('disabled', true);
    } else if (score == 0) {
      $(tr).find('[type="radio"][value="0"]').prop('disabled', true);
      $(tr).find('[type="radio"][value="1"]').prop('disabled', false);
    }

    var app_id = $('#app_id').val();
    var user_id = $('#user_id').val();
    var data = {
      score: score,
      user_id: user_id,
      question_id: qu_id,
      application_id: app_id,
    }

    var res = main_post(BASE_URL_BACKEND + '/lowcarbon/changeScore', data);
    if (res.type == 'success') {
      toastr.success(res.text);
    } else {
      toastr.error(res.text);
    }
  }
</script>