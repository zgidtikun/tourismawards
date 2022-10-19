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
        <?php
        // pp($result);
        ?>
        <div class="table-responsive">
          <table id="main_datatable" class="table table-striped" style="width:100%">
            <thead>
              <tr>
                <th class="text-center" width="1%">#</th>
                <th class="text-center" width="10%">ชื่อเจ้าหน้าที่ ททท.</th>
                <!-- <th class="text-center" width="10%">ประเภทสมาชิก</th> -->
                <th class="text-center" width="10%">เบอร์มือถือ</th>
                <th class="text-center" width="10%">E-mail</th>
                <!-- <th class="text-center" width="5%">สถานะ</th> -->
                <th class="text-center" width="5%">จัดการ</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (!empty($result)) :
                foreach ($result as $key => $value) :
              ?>
                  <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $value->prefix . ' ' . $value->name . ' ' . $value->surname ?></td>
                    <!-- <td><?= $value->member_type_name ?></td> -->
                    <td><?= $value->mobile ?></td>
                    <td><?= $value->email ?></td>
                    <!-- <td class="text-center"><?= ($value->status) ? '<span class="text-success">Active</span>' : '<span class="text-danger">InActive</span>'; ?></td> -->
                    <td class="text-center">
                      <i class="fas fa-edit text-primary mr-2" data-toggle="tooltip" title="แก้ไขข้อมูล" onclick="edit_item('<?= $value->id ?>')"></i></a>
                      <i class="fas fa-trash-alt text-danger mr-2" data-toggle="tooltip" title="ลบข้อมูล" onclick="delete_item('<?= $value->id ?>')"></i>
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

<script>
  function delete_item(id) {
    var option = {
      title: "Warning!",
      text: "คุณต้องการยืนยันการลบข้อมูล<?= $title ?>หรือไม่?",
    }
    swal_confirm(option).done(function() {
      var res = main_post(BASE_URL_BACKEND + '/TAT/delete', {
        id: id
      });
      res_swal(res, 1);
    })
  }

  function edit_item(id) {
    window.location.href = '<?= base_url('backend/TAT/edit') ?>' + '/' + id;
  }

  function insert_item(elm) {
    window.location.href = '<?= base_url('backend/TAT/add') ?>';
  }
</script>