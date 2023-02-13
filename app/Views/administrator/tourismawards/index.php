<style>
  .dataTables_wrapper .dataTables_length {
    justify-content: flex-start !important;
  }
</style>
<div class="backendcontent">
  <div class="backendcontent-row">
    <div class="backendcontent-title">
      <div class="backendcontent-title-txt">
        <h3>รายการผลงานที่ได้รับรางวัล</h3>
      </div>
      <!-- <a href="javascript:" class="btn-blue" onclick="insert_item(this)">เพิ่มข้อมูล</a> -->
      <!-- <a href="javascript:" onclick="export_data()" class="btn-export"><i class="bi bi-box-arrow-right" style="margin-right: 5px;"></i> Export</a> -->
    </div>

    <!-- <form action="" method="get" id="search_form">
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

        <div class="backendcontent-subcol selectbox col-sm-3">
          <label>เรียง</label>
          <select id="sort" name="sort">
            <option value="desc" <?= (@$_GET['sort'] == 'desc') ? 'selected' : ''; ?>>มากไปน้อย</option>
            <option value="asc" <?= (@$_GET['sort'] == 'asc') ? 'selected' : ''; ?>>น้อยไปมาก</option>
          </select>
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
                  <th>ลำดับ</th>
                  <th>รหัสใบสมัคร</th>
                  <th>ชื่อสถานประกอบการ</th>
                  <!-- <th>ประเภทที่ตัดสิน</th> -->
                  <!-- <th>สาขารางวัล</th> -->
                  <th>คะแนนรวม</th>
                  <th>รางวัล</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (!empty($result)) :
                  foreach ($result as $key => $value) :
                    $total = $value->score_prescreen_tt + $value->score_onsite_tt;
                    $awards = '';
                    if ($total >= 85) {
                      $awards = 'รางวัลยอดเยี่ยม (Thailand Tourism Gold Award)';
                    } else if ($total >= 75 && $total <= '84.99') {
                      $awards = 'รางวัลดีเด่น (Thailand Tourism Silver Award)';
                    } else if ($total >= 65 && $total <= '74.99') {
                      $awards = 'เกียรติบัตรรางวัลอุตสาหกรรมท่องเที่ยวไทย (Thailand Tourism Certificate)';
                    }
                ?>
                    <tr>
                      <td class="text-center"><?= $key + 1 ?></td>
                      <td class="text-center"><?= $value->code ?></td>
                      <td class="text-start"><?= $value->attraction_name_th ?></td>
                      <!-- <td class="text-start"><?= applicationType($value->application_type_id) ?></td> -->
                      <!-- <td class="text-start"><?= applicationTypeSub($value->application_type_sub_id) ?></td> -->
                      <td class="text-end"><?= $total ?></td>
                      <td class="text-start"><?= $awards ?></td>
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

    var pgurl = BASE_URL_BACKEND + '/tourismawards';
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
        targets: 4
      }, {
        responsivePriority: 10001,
        targets: 3
      }, {
        responsivePriority: 10001,
        targets: 1
      }],
      pageLength: 20,
      lengthMenu: [10, 20, 50, 100],
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
</script>