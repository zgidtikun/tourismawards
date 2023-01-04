<div class="backendcontent">
  <div class="backendcontent-row">
    <div class="backendcontent-title">
      <div class="backendcontent-title-txt">
        <h3>รางวัลยอดเยี่ยม </h3>
      </div>
      <a href="javascript:" class="btn-export" target="_blank">Export</a>
    </div>

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
                  <th class="text-center name">ชื่อสถานประกอบการ</th>
                  <th class="text-center name">คะแนน (Pre-screen)</th>
                  <th class="text-center name">คะแนน (ลงพื้นที่)</th>
                  <th class="text-center name">คะแนนรวม</th>
                  <!-- <th class="text-center type">ประเภทที่ตัดสิน</th> -->
                  <!-- <th class="text-center section">สาขารางวัล</th> -->
                  <!-- <th class="text-center status">สถานะ</th> -->
                  <!-- <th class="text-center date">วันที่ส่งใบสมัคร</th> -->
                  <th class="text-center edit">ดูรายละเอียด</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (!empty($result)) :
                  foreach ($result as $key => $value) :
                    $status = "";
                    // if ($value->status == 2) {
                    //   $status = '<div class="userstatus trader">รอตรวจสอบ</div>';
                    // } else if ($value->status == 4) {
                    //   $status = '<div class="userstatus chk">ขอข้อมูลเพิ่มเติม</div>';
                    // } else if ($value->status == 3) {
                    //   $status = '<div class="userstatus judge">อนุมัติ</div>';
                    // } else if ($value->status == 0) {
                    //   $status = '<div class="userstatus officer">ไม่อนุมัติ</div>';
                    // }
                ?>
                    <tr>
                      <td><?= $key + 1 ?></td>
                      <td class="text-center"><?= $value->code ?></td>
                      <td class="text-start"><?= $value->attraction_name_th ?></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"><?= $value->award_persent ?></td>
                      <!-- <td class="text-start"><?= applicationType($value->application_type_id) ?></td> -->
                      <!-- <td class="text-start"><?= applicationTypeSub($value->application_type_sub_id) ?></td> -->
                      <!-- <td class="text-center"><?= $status ?></td> -->
                      <!-- <td class="text-center"><?= docDate($value->created_at, 3) ?></td> -->
                      <td>
                        <div class="form-table-col edit">
                          <a href="javascript:" class="btn-edit" title="ดูข้อมูล" onclick="view_item('<?= $value->id ?>')"><i class="bi bi-eye-fill"></i></a>
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

    var pgurl = BASE_URL_BACKEND + '/award/best';
    active_page(pgurl);

    $.fn.DataTable.ext.pager.numbers_length = 6;
    $("#example").dataTable().fnDestroy();
    $("#example").addClass("nowrap").dataTable({
      responsive: true,
      searching: true,
      columnDefs: [{
        responsivePriority: 1,
        targets: 2
      }, {
        responsivePriority: 1,
        targets: 5
      }, {
        responsivePriority: 10001,
        targets: 6
      }, {
        responsivePriority: 10001,
        targets: 4
      }, {
        responsivePriority: 10001,
        targets: 3
      }, {
        responsivePriority: 10001,
        targets: 1
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

  function view_item(id) {
    window.location.href = BASE_URL_BACKEND + '/complete/view/' + id;
  }
</script>