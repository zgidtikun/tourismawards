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
        <h3>รายการแบบประเมิน</h3>
      </div>
      <!-- <a href="javascript:" class="btn-blue" onclick="insert_item(this)">เพิ่มข้อมูล</a> -->
      <!-- <a href="javascript:" onclick="export_data()" class="btn-export"><i class="bi bi-box-arrow-right" style="margin-right: 5px;"></i> Export</a> -->
    </div>

    <!-- <form action="" method="get" id="search_form">
      <div class="backendcontent-subrow row">
        <div class="backendcontent-subcol searchbox col-sm-2">
          <input type="text" class="form-control" name="keyword" id="keyword" value="<?= @$_GET['keyword'] ?>" placeholder="ค้นหา">
        </div>

        <div class="backendcontent-subcol btn col-sm-3">
          <button type="submit" class="but-blue" id="btn_search">ค้นหา</button>
        </div>

      </div>
    </form> -->

    <div class="backendcontent-subrow">
      <div class="form-table">
        <div class="grid">
          <div class="unit w-1-1">
            <table id="example" class="display" style="width: 100%;">
              <thead>
                <tr>
                  <th data-priority="2">ลำดับ</th>
                  <th>รหัสใบสมัคร</th>
                  <th data-priority="1">ชื่อสถานประกอบการ</th>
                  <th>กรรมการ</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (!empty($result)) :
                  $i = 1;
                  foreach ($result as $key => $value) :
                    $lowcarbon = json_decode($value->admin_id_lowcarbon);
                    $label = [];
                    foreach ($lowcarbon as $key => $val) {
                      $label[] = '<span class="text-primary pointer" onclick="edit_score(' . $value->id . ', ' . @$val . ')">' . usersName(@$val) . '</span>';
                    }
                ?>
                    <tr>
                      <td class="text-center"><?= $i++; ?></td>
                      <td class="text-center"><?= $value->code ?></td>
                      <td class="text-start"><?= $value->attraction_name_th ?></td>
                      <td class="text-start">
                        <?= implode('<hr class="m-0">', $label) ?>
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

    var pgurl = BASE_URL_BACKEND + '/lowcarbon';
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
  });

  function edit_score(app_id, user_id) {
    window.location.href = BASE_URL_BACKEND + '/lowcarbon/edit/' + app_id + '/' + user_id;
  }
</script>