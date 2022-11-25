<div class="backendcontent">
  <div class="backendcontent-row">
    <div class="backendcontent-title">
      <div class="backendcontent-title-txt">
        <h3>รายการใบสมัครที่รอตรวจสอบ </h3>
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
                  <th class="text-center date">วันที่ส่งใบสมัคร</th>
                  <th class="text-center edit">จัดการ</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (!empty($result)) :
                  foreach ($result as $key => $value) :
                    $status = "";
                    if ($value->status == 2) {
                      $status = '<div class="userstatus trader">รอตรวจสอบ</div>';
                    } else if ($value->status == 4) {
                      $status = '<div class="userstatus chk">ขอข้อมูลเพิ่มเติม</div>';
                    } else if ($value->status == 3) {
                      $status = '<div class="userstatus judge">อนุมัติ</div>';
                    } else if ($value->status == 0) {
                      $status = '<div class="userstatus officer">ไม่อนุมัติ</div>';
                    }
                ?>
                    <tr>
                      <td><?= $key + 1 ?></td>
                      <td class="text-center"><?= $value->code ?></td>
                      <td class="text-start"><?= $value->company_name ?></td>
                      <td class="text-start"><?= applicationType($value->application_type_id) ?></td>
                      <td class="text-start"><?= applicationTypeSub($value->application_type_sub_id) ?></td>
                      <td class="text-center"><?= $status ?></td>
                      <td class="text-center"><?= docDate($value->created_at, 3) ?></td>
                      <td>
                        <div class="form-table-col edit">
                          <a href="#" class="btn-edit" title="แก้ไขข้อมูล" onclick="edit_item('<?= $value->id ?>')"><i class="bi bi-pencil-square"></i></a>
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

    var pgurl = BASE_URL_BACKEND + '/Approve';
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
      var res = main_post(BASE_URL_BACKEND + '/Approve/delete', {
        id: id,
        image_cover: $('#image_cover_old').val(),
      });
      res_swal(res, 1);
    })
  }

  function edit_item(id) {
    window.location.href = BASE_URL_BACKEND + '/Approve/edit/' + id;
  }

  function insert_item(elm) {
    window.location.href = BASE_URL_BACKEND + '/Approve/add';
  }
</script>