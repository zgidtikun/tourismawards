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
        <table id="main_datatable" class="display">
          <thead>
            <tr>
              <th class="no">ลำดับ</th>
              <th class="name">ชื่อ-สกุล</th>
              <th class="tel">เบอร์โทรศัพท์</th>
              <th class="mail">อีเมล</th>
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
                  $url_edit = base_url() . '/administrator/Users/edit/';
                } else if ($value->role_id == 2) {
                  $label = '<div class="userstatus officer">เจ้าหน้าที่ ททท.</div>';
                  $url_edit = base_url() . '/administrator/TAT/edit/';
                } else if ($value->role_id == 3) {
                  $label = '<div class="userstatus judge">กรรมการ</div>';
                  $url_edit = base_url() . '/administrator/Officer/edit/';
                } else if ($value->role_id == 4) {
                  $label = '<div class="userstatus admin">ผู้ดูแลระบบ</div>';
                  $url_edit = base_url() . '/administrator/Admin/edit/';
                }
            ?>
                <tr>
                  <td class=""><?= $i++ ?></td>
                  <td class="text-center">
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
                  <td class=""><?= $label ?></td>
                  <td class=""><?= docDate($value->created_at, 3) ?></td>
                  <td class="">
                    <div class="form-table-col edit">
                      <a href="<?= $url_edit . $value->id ?>" class="btn-edit"><i class="bi bi-pencil-square"></i></a>
                      <!-- <a href="#" class="btn-delete"><i class="bi bi-trash-fill text-danger"></i></a> -->
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
                  $url_edit = base_url() . '/administrator/Users/edit/';
                } else if ($value->role_id == 2) {
                  $label = '<div class="userstatus officer">เจ้าหน้าที่ ททท.</div>';
                  $url_edit = base_url() . '/administrator/TAT/edit/';
                } else if ($value->role_id == 3) {
                  $label = '<div class="userstatus judge">กรรมการ</div>';
                  $url_edit = base_url() . '/administrator/Officer/edit/';
                } else if ($value->role_id == 4) {
                  $label = '<div class="userstatus admin">ผู้ดูแลระบบ</div>';
                  $url_edit = base_url() . '/administrator/Admin/edit/';
                }
            ?>
                <tr>
                  <td class=""><?= $i++ ?></td>
                  <td class="text-center">
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
                  <td class=""><?= $label ?></td>
                  <td class=""><?= docDate($value->created_at, 3) ?></td>
                  <td class="">
                    <div class="form-table-col edit">
                      <a href="<?= $url_edit . $value->id ?>" class="btn-edit"><i class="bi bi-pencil-square"></i></a>
                      <!-- <a href="#" class="btn-delete"><i class="bi bi-trash-fill text-danger"></i></a> -->
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
    var pgurl = BASE_URL_BACKEND + '/Users/all';
    active_page(pgurl);
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