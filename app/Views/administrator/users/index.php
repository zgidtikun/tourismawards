<div class="backendcontent">
  <div class="backendcontent-row">
    <div class="backendcontent-title">
      <div class="backendcontent-title-txt">
        <h3>รายชื่อ<?= $title ?></h3>
      </div>
      <a href="#" class="btn-blue" onclick="insert_item(this)">เพิ่มสมาชิก</a>
    </div>

    <form action="" method="get">
      <div class="backendcontent-subrow">
        <div class="backendcontent-subcol searchbox">
          <input type="text" name="keyword" id="keyword" value="<?= @$_GET['keyword'] ?>" placeholder="ค้นหา">
        </div>

        <div class="backendcontent-subcol btn">
          <button type="submit" class="but-blue" id="btn_search">ค้นหา</button>
        </div>

      </div>
    </form>

    <div class="backendcontent-subrow">
      <div class="form-table">
        <table id="main_datatable" class="display">
          <thead>
            <tr>
              <th class="no">ลำดับ</th>
              <th class="name">ชื่อ-สกุล</th>
              <th class="tel">เบอร์โทรศัพท์</th>
              <th class="mail">อีเมล</th>
              <th class="status">สถานะ</th>
              <th class="date">วันที่สร้าง</th>
              <th class="edit">จัดการ</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 1;
            if (!empty($result)) :
              foreach ($result as $key => $value) :
                $label = '';
                if ($value->role_id == 1) {
                  $label = '<div class="userstatus trader">ผู้ประกอบการ</div>';
                } else if ($value->role_id == 2) {
                  $label = '<div class="userstatus officer">เจ้าหน้าที่ ททท.</div>';
                } else if ($value->role_id == 3) {
                  $label = '<div class="userstatus judge">กรรมการ</div>';
                } else if ($value->role_id == 4) {
                  $label = '<div class="userstatus admin">ผู้ดูแลระบบ</div>';
                }

                $status = '<div class="userstatus officer">ไม่ได้ยืนยัน</div>';
                if ($value->status == 1) {
                  $status = '<div class="userstatus judge">ยืนยันแล้ว</div>';
                }
            ?>
                <tr>
                  <td class=""><?= $i++ ?></td>
                  <td class="">
                    <?php
                    if (!empty($value->profile) && $value->profile != "") {
                      $path = base_url() . "/" . $value->profile;
                    } else {
                      $path = base_url() . '/assets/images/unknown_user.jpg';
                    }
                    ?>
                    <img src="<?= $path ?>" style="height: 50px; width: 50px"> <?= $value->name ?>  <?= $value->surname ?>
                  </td>
                  <td class=""><?= $value->mobile ?></td>
                  <td class="text-start"><?= $value->email ?></td>
                  <td class=""><?= $status ?></td>
                  <td class=""><?= docDate($value->created_at, 3) ?></td>
                  <td class="">
                    <div class="form-table-col edit">
                      <?php if ($value->status != 1) { ?>
                        <a href="#" class="btn-edit" data-toggle="tooltip" data-bs-placement="top" title="ยืนยันการสมัคร" onclick="active_user('<?= $value->id ?>')"><i class="bi bi-check-square text-success"></i></a>
                      <?php } ?>
                      <a href="#" class="btn-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="แก้ไขข้อมูล" onclick="edit_item('<?= $value->id ?>')"><i class="bi bi-pencil-square"></i></a>
                      <a href="#" class="btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="ลบข้อมูล" onclick="delete_item('<?= $value->id ?>')"><i class="bi bi-trash-fill text-danger"></i></a>
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


<script>
  $(function() {
    var pgurl = BASE_URL_BACKEND + '/Users';
    active_page(pgurl);
  });

  $('#keyword').on('keypress', function(e) {
    if (e.which == 13) {
      $('#btn_search').click();
    }
  });

  function active_user(id) {
    var option = {
      title: "Warning!",
      text: "คุณต้องการยืนยันการสมัครสมาชิกของผู้ประกอบการหรือไม่?",
    }
    swal_confirm(option).done(function() {
      var res = main_post(BASE_URL_BACKEND + '/Users/active', {
        id: id
      });
      res_swal(res, 1);
    })
  }

  function delete_item(id) {
    var option = {
      title: "Warning!",
      text: "คุณต้องการยืนยันการลบข้อมูลผู้ประกอบการหรือไม่?",
    }
    swal_confirm(option).done(function() {
      var res = main_post(BASE_URL_BACKEND + '/Users/delete', {
        id: id
      });
      res_swal(res, 1);
    })
  }

  function edit_item(id) {
    window.location.href = BASE_URL_BACKEND + '/Users/edit/' + id;
  }

  function insert_item(elm) {
    window.location.href = BASE_URL_BACKEND + '/Users/add';
  }
</script>