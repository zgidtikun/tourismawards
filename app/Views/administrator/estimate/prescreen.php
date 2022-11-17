<div class="backendcontent">
  <div class="backendcontent-row">
    <div class="backendcontent-title">
      <div class="backendcontent-title-txt">
        <h3>รายการใบสมัครที่รอกรรมการส่งแบบประเมินขั้นต้น (Pre-Screen) </h3>
      </div>
      <!-- <a href="#" class="btn-blue" onclick="insert_item(this)">เพิ่มข้อมูล</a> -->
    </div>

    <form action="" method="get">
      <div class="backendcontent-subrow row">
        <div class="backendcontent-subcol searchbox col-sm-2">
          <input type="text" class="form-control" name="keyword" id="keyword" value="<?= @$_GET['keyword'] ?>" placeholder="ค้นหา">
        </div>

        <div class="backendcontent-subcol selectbox col-sm-3">
          <label>ประเภทที่ตัดสิน</label>
          <select id="application_type_id" name="application_type_id">
            <option value="">ทั้งหมด</option>
            <?php
            if (!empty($application_type)) {
              foreach ($application_type as $key => $value) {
            ?>
                <option value="<?= $value->id ?>" <?= ($value->id == @$_GET['application_type_id']) ? 'selected' : ''; ?>><?= $value->name ?></option>
            <?php
              }
            }
            ?>
          </select>
        </div>

        <div class="backendcontent-subcol selectbox col-sm-3">
          <label>สาขารางวัล</label>
          <select id="application_type_sub_id" name="application_type_sub_id">
            <option value="">ทั้งหมด</option>
            <?php
            if (!empty($application_type_sub)) {
              foreach ($application_type_sub as $key => $value) {
            ?>
                <option value="<?= $value->id ?>" <?= ($value->id == @$_GET['application_type_sub_id']) ? 'selected' : ''; ?>><?= $value->name ?></option>
            <?php
              }
            }
            ?>
          </select>
        </div>

        <div class="backendcontent-subcol btn col-sm-3">
          <button type="submit" class="but-blue" id="btn_search">ค้นหา</button>
        </div>

      </div>
    </form>

    <div class="backendcontent-subrow">
      <div class="form-table">
        <div class="grid">
          <div class="unit w-1-1">
            <!-- <table id="main_datatable" class="display"> -->
            <table id="example" class="display" style="width: 100%;">
              <thead>
                <tr>
                  <th class="text-center no">#</th>
                  <th class="text-center noid">รหัสใบสมัคร</th>
                  <th class="text-center name">ชื่อ</th>
                  <th class="text-center type">ประเภทที่ตัดสิน</th>
                  <th class="text-center section">สาขารางวัล</th>
                  <th class="text-center status">สถานะ</th>
                  <th class="text-center date">กำหนดส่ง</th>
                  <th class="text-center edit">จัดการ</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (!empty($result)) :
                  foreach ($result as $key => $value) :
                    if ($value->users_stage_status == 1) {
                      $status = '<div class="userstatus trader">รอส่งผลการประเมิน</div>';
                    } else if ($value->users_stage_status == 2) {
                      $status = '<div class="userstatus chk">กำลังประเมิน</div>';
                    } else if ($value->users_stage_status == 3) {
                      $status = '<div class="userstatus trader">ขอข้อมูลเพิ่มเติม</div>';
                    } else if ($value->users_stage_status == 4) {
                      $status = '<div class="userstatus judge">ตอบรับคำขอ</div>';
                    } else if ($value->users_stage_status == 5) {
                      $status = '<div class="userstatus officer">ไม่มีการตอบกลับ</div>';
                    } else if ($value->users_stage_status == 6) {
                      $status = '<div class="userstatus judge">ผ่านการประเมิน</div>';
                    } else if ($value->users_stage_status == 7) {
                      $status = '<div class="userstatus officer">ไม่ผ่านการประเมิน</div>';
                    }
                ?>
                    <tr>
                      <td><?= $key + 1 ?></td>
                      <td class="text-center"><?= $value->code ?></td>
                      <td class="text-start"><?= $value->company_name ?></td>
                      <td class="text-start"><?= applicationType($value->application_type_id) ?></td>
                      <td class="text-start"><?= applicationTypeSub($value->application_type_sub_id) ?></td>
                      <td class="text-center"><?= $status ?></td>
                      <td class="text-center">
                        <?php echo docDate($value->duedate, 3); ?>
                      </td>
                      <td>
                        <div class="form-table-col edit">
                          <a href="#" class="btn-edit" title="แก้ไขข้อมูล" onclick="edit_item('<?= $value->id ?>')"><i class="bi bi-eye"></i></a>
                          <!-- <a href="#" class="btn-delete" title="ลบข้อมูล" onclick="delete_item('<?= $value->id ?>')"><i class="bi bi-trash-fill text-danger"></i></a> -->
                        </div>
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
</div>


<script>
  $(function() {

    var pgurl = BASE_URL_BACKEND + '/Estimate/prescreen';
    active_page(pgurl);

    $("#example").dataTable().fnDestroy();
    $("#example").addClass("nowrap").dataTable({
      responsive: true,
      searching: false,
      columnDefs: [{
        responsivePriority: 1,
        targets: 1
      }, {
        responsivePriority: 10001,
        targets: 5
      }, {
        responsivePriority: 10001,
        targets: 3
      }, {
        responsivePriority: 10001,
        targets: 2
      }],
      lengthMenu: [10, 25, 50, 100],
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
  })


  $('#keyword').on('keypress', function(e) {
    if (e.which == 13) {
      $('#btn_search').click();
    }
  });

  $('#application_type_id').change(function(e) {
    $('#btn_search').click();
  });

  $('#application_type_sub_id').change(function(e) {
    $('#btn_search').click();
  });

  function delete_item(id) {
    var option = {
      title: "Warning!",
      text: "คุณต้องการยืนยันการลบข้อมูล<?= $title ?>หรือไม่?",
    }
    swal_confirm(option).done(function() {
      var res = main_post(BASE_URL_BACKEND + '/Estimate/delete', {
        id: id,
        image_cover: $('#image_cover_old').val(),
      });
      res_swal(res, 1);
    })
  }

  function edit_item(id) {
    window.location.href = BASE_URL_BACKEND + '/Estimate/view/' + id;
  }
</script>