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
                <th class="text-center" width="10%">รูป</th>
                <th class="text-center" width="10%">หัวข้อ</th>
                <th class="text-center" width="10%">หมวดหมู่</th>
                <th class="text-center" width="10%">สถานะ</th>
                <th class="text-center" width="10%">วันที่</th>
                <th class="text-center" width="10%">จัดการ</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (!empty($result)) :
                foreach ($result as $key => $value) :

                  if (!empty($value->image_cover) && $value->image_cover != "") {
                    $path = base_url('uploads/news/images') . '/' . $value->image_cover;
                  } else {
                    $path = base_url('/backend/assets/images/add_img.png');
                  }
              ?>
                  <tr>
                    <td><?= $key + 1 ?></td>
                    <td class="text-center">
                      <img src="<?= $path ?>" alt="" srcset="" width="100px">
                    </td>
                    <td><?= $value->title ?></td>
                    <td class="text-center"><?= $category[$value->category_id] ?></td>
                    <td class="text-center">
                      <?= ($value->status) ? '<span class="text-success">เผยแพร่</span>' : '<span class="text-danger">ไม่เผยแพร่</span>'; ?>
                    </td>
                    <td class="text-center"><?= docDate($value->updated_at) ?></td>
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
      var res = main_post(BASE_URL + '/backend/News/delete', {
        id: id,
        image_cover: $('#image_cover_old').val(),
      });
      res_swal(res, 1);
    })
  }

  function edit_item(id) {
    window.location.href = '<?= base_url('backend/News/edit') ?>' + '/' + id;
  }

  function insert_item(elm) {
    window.location.href = '<?= base_url('backend/News/add') ?>';
  }
</script>