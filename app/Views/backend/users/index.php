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
        <h3 class="card-title"><?= $title ?></h3>
        <div class="card-action float-sm-right my-3 my-sm-0">
          <button type="button" class="btn btn-primary" onclick="insert_item(this)"><i class="fas fa-edit"></i> เพิ่มข้อมูล</button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="main_datatable" class="table table-striped" style="width:100%">
            <thead>
              <tr>
                <th class="text-center" width="1%">#</th>
                <th class="text-center" width="10%">ชื่อผู้ประกอบการ</th>
                <th class="text-center" width="10%">ประเภทสมาชิก</th>
                <th class="text-center" width="10%">เบอร์มือถือ</th>
                <th class="text-center" width="10%">E-mail</th>
                <th class="text-center" width="8%">สถานะ</th>
                <th class="text-center" width="8%">วันที่ลงทะเบียน</th>
                <th class="text-center" width="5%">จัดการ</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (!empty($result)) :
                foreach ($result as $key => $value) :
                  $color = 'table-danger';
                  $status = '<span class="text-danger">รอตรวจสอบ</span>';
                  if ($value->status) {
                    $color = 'table-success';
                    $status = '<span class="text-success">ผ่านการตรวจสอบ</span>';
                  }
              ?>
                  <tr class="<?= $color ?>">
                    <td><?= $key + 1 ?></td>
                    <td><?= $value->prefix . ' ' . $value->name . ' ' . $value->surname ?></td>
                    <td><?= $value->role_name ?></td>
                    <td><?= $value->mobile ?></td>
                    <td><?= $value->email ?></td>
                    <td class="text-center"><?= $status ?></td>
                    <td class="text-center"><?= docDate($value->created_at, 4) ?></td>
                    <td class="text-center">
                      <?php if (!$value->status) : ?>
                        <!-- <i class="fa fa-check text-success mr-2" data-toggle="tooltip" title="ยืนยันผู้ประกอบการ" onclick="active_user('<?= $value->id ?>')"></i> -->
                        <i class="fas fa-eye text-success mr-2" data-toggle="tooltip" title="ดูข้อมูล" onclick="view_user('<?= $value->id ?>')"></i></a>
                      <?php endif; ?>
                      <i class="fas fa-edit text-primary mr-2" data-toggle="tooltip" title="แก้ไขข้อมูล" onclick="edit_user('<?= $value->id ?>')"></i></a>
                      <i class="fas fa-trash-alt text-danger mr-2" data-toggle="tooltip" title="ลบข้อมูล" onclick="delete_user('<?= $value->id ?>')"></i>
                    </td>
                  </tr>
              <?php
                endforeach;
              endif;
              ?>
            </tbody>
          </table>
          <span class="text-danger">* หมายเหตุ</span> <small>กดดูข้อมูลเพื่อตรวจสอบ </small> <i class="fas fa-eye text-success"></i> <br>
          <span>🟥 รอการตรวจสอบ</span><br>
          <span>🟩 ถูกตรวจสอบแล้ว</span>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
  function active_user(id) {
    var option = {
      title: "Warning!",
      text: "คุณต้องการยืนยันการสมัครสมาชิกของผู้ประกอบการหรือไม่?",
    }
    swal_confirm(option).done(function() {
      var res = main_post(BASE_URL + '/backend/Users/active', {
        id: id
      });
      res_swal(res, 1);
    })
  }

  function delete_user(id) {
    var option = {
      title: "Warning!",
      text: "คุณต้องการยืนยันการลบข้อมูลผู้ประกอบการหรือไม่?",
    }
    swal_confirm(option).done(function() {
      var res = main_post(BASE_URL + '/backend/Users/delete', {
        id: id
      });
      res_swal(res, 1);
    })
  }

  function edit_user(id) {
    window.location.href = '<?= base_url('backend/Users/edit') ?>' + '/' + id;
  }

  function insert_item(elm) {
    window.location.href = '<?= base_url('backend/Users/add') ?>';
  }
</script>