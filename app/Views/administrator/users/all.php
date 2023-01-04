<div class="backendcontent">
  <div class="backendcontent-row">
    <div class="backendcontent-title">
      <div class="backendcontent-title-txt">
        <h3>รายชื่อ<?= $title ?></h3>
      </div>
      <!-- <a href="" class="btn-blue">เพิ่มสมาชิก</a> -->
    </div>

    <form action="" method="get">
      <div class="backendcontent-subrow">
        <div class="backendcontent-subcol searchbox">
          <input type="text" name="keyword" id="keyword" value="<?= @$_GET['keyword'] ?>" placeholder="ค้นหา">
        </div>

        <div class="backendcontent-subcol selectbox">
          <label>บทบาทผู้ใช้งาน</label>
          <select name="role" id="role">
            <option value="all">ทั้งหมด</option>
            <?php
            if (!empty($role)) {
              foreach ($role as $key => $value) {
                $selected = "";
                if (!empty($search['role']) && $search['role'] == $value->id) {
                  $selected = 'selected';
                }
            ?>
                <option value="<?= $value->id ?>" <?= $selected ?>><?= $value->user_groups ?></option>
            <?php
              }
            }
            ?>
          </select>
        </div>
        <div class="backendcontent-subcol btn">
          <button type="submit" class="but-blue" id="btn_search">ค้นหา</button>
        </div>

      </div>
    </form>

    <div class="backendcontent-subrow">
      <div class="form-table">
        <div class="grid">
          <div class="unit w-1-1">
            <table id="example" class="display" style="width: 100%;">
              <thead>
                <tr>
                  <th class="no">ลำดับ</th>
                  <th class="name">ชื่อ-สกุล</th>
                  <th class="tel">เบอร์โทรศัพท์</th>
                  <th class="name">อีเมล</th>
                  <th class="status">สถานะ</th>
                  <th class="status">บทบาทผู้ใช้งาน</th>
                  <th class="date">วันที่สร้าง</th>
                  <th class="edit">จัดการ</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 1;
                if (!empty($users)) :
                  foreach ($users as $key => $value) :
                    $label = '';
                    $url_edit = '';
                    if ($value->role_id == 1) {
                      $label = '<div class="userstatus trader">ผู้ประกอบการ</div>';
                      $url_edit = base_url() . '/administrator/users/edit/';
                    } else if ($value->role_id == 2) {
                      $label = '<div class="userstatus officer">เจ้าหน้าที่ ททท.</div>';
                      $url_edit = base_url() . '/administrator/tat/edit/';
                    } else if ($value->role_id == 3) {
                      $label = '<div class="userstatus judge">กรรมการ</div>';
                      $url_edit = base_url() . '/administrator/officer/edit/';
                    } else if ($value->role_id == 4) {
                      $label = '<div class="userstatus admin">ผู้ดูแลระบบ</div>';
                      $url_edit = base_url() . '/administrator/admin/edit/';
                    }

                    $status = '<div class="userstatus officer">ไม่ได้ยืนยัน</div>';
                    if ($value->status == 1) {
                      $status = '<div class="userstatus judge">ยืนยันแล้ว</div>';
                    }
                ?>
                    <tr>
                      <td class=""><?= $i++ ?></td>
                      <td class="use_name">
                        <?php
                        if (!empty($value->profile) && $value->profile != "") {
                          $path = base_url() . "/" . $value->profile;
                        } else {
                          $path = base_url() . '/assets/images/unknown_user.jpg';
                        }
                        ?>
                        <img src="<?= $path ?>" class="d-none d-sm-block" style="height: 50px; width: 50px"> <?= $value->name ?> <?= $value->surname ?>
                      </td>
                      <td class=""><?= $value->mobile ?></td>
                      <td class="text-start"><?= $value->email ?></td>
                      <td class=""><?= $status ?></td>
                      <td class=""><?= $label ?></td>
                      <td class=""><?= docDate($value->created_at, 3) ?></td>
                      <td class="">
                        <div class="form-table-col edit">
                          <a href="<?= $url_edit . $value->id ?>" class="btn-edit"><i class="bi bi-pencil-square"></i></a>
                          <!-- <a href="javascript:" class="btn-delete"><i class="bi bi-trash-fill text-danger"></i></a> -->
                        </div>
                      </td>
                    </tr>
                <?php
                  endforeach;
                endif;
                ?>

                <?php
                if (!empty($admin)) :
                  foreach ($admin as $key => $value) :
                    $label = '';
                    $url_edit = '';
                    if ($value->role_id == 1) {
                      $label = '<div class="userstatus trader">ผู้ประกอบการ</div>';
                      $url_edit = base_url() . '/administrator/users/edit/';
                    } else if ($value->role_id == 2) {
                      $label = '<div class="userstatus officer">เจ้าหน้าที่ ททท.</div>';
                      $url_edit = base_url() . '/administrator/tat/edit/';
                    } else if ($value->role_id == 3) {
                      $label = '<div class="userstatus judge">กรรมการ</div>';
                      $url_edit = base_url() . '/administrator/officer/edit/';
                    } else if ($value->role_id == 4) {
                      $label = '<div class="userstatus admin">ผู้ดูแลระบบ</div>';
                      $url_edit = base_url() . '/administrator/admin/edit/';
                    }

                    $status = '<div class="userstatus officer">ไม่ได้ยืนยัน</div>';
                    if ($value->status == 1) {
                      $status = '<div class="userstatus judge">ยืนยันแล้ว</div>';
                    }
                ?>
                    <tr>
                      <td class=""><?= $i++ ?></td>
                      <td class="use_name">
                        <?php
                        if (!empty($value->profile) && $value->profile != "") {
                          $path = base_url() . "/" . $value->profile;
                        } else {
                          $path = base_url() . '/assets/images/unknown_user.jpg';
                        }
                        ?>
                        <img src="<?= $path ?>" class="d-none d-sm-block" style="height: 50px; width: 50px"> <?= $value->name ?> <?= $value->surname ?>
                      </td>
                      <td class=""><?= $value->mobile ?></td>
                      <td class="text-start"><?= $value->email ?></td>
                      <td class=""><?= $status ?></td>
                      <td class=""><?= $label ?></td>
                      <td class=""><?= docDate($value->created_at, 3) ?></td>
                      <td class="">
                        <div class="form-table-col edit">
                          <a href="<?= $url_edit . $value->id ?>" class="btn-edit"><i class="bi bi-pencil-square"></i></a>
                          <!-- <a href="javascript:" class="btn-delete"><i class="bi bi-trash-fill text-danger"></i></a> -->
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
    var pgurl = BASE_URL_BACKEND + '/users/all';
    active_page(pgurl);

    $.fn.DataTable.ext.pager.numbers_length = 6;
    $("#example").dataTable().fnDestroy();
    $("#example").addClass("nowrap").dataTable({
      responsive: true,
      searching: false,
      columnDefs: [{
        responsivePriority: 1,
        targets: 2
      }, {
        responsivePriority: 2,
        targets: 4
      }, {
        responsivePriority: 10001,
        targets: 6
      }, {
        responsivePriority: 10001,
        targets: 5
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
      pageLength: 10,
      numbersLength: 3,
      // pagingType: 'numbers',
      lengthMenu: [1, 10, 25, 50, 100],
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
        // oPaginate: {
        //   sFirst: "First", // This is the link to the first page
        //   sPrevious: "<<", // This is the link to the previous page
        //   sNext: ">>", // This is the link to the next page
        //   sLast: "Last" // This is the link to the last page
        // }
      }
    });

  });

  $('#keyword').on('keypress', function(e) {
    if (e.which == 13) {
      $('#btn_search').click();
    }
  });

  $('#role').change(function(e) {
    $('#btn_search').click();
  });
</script>