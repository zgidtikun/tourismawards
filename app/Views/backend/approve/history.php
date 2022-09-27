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
        <h3 class="card-title"><?= $title ?></a></h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="main_datatable" class="table table-striped" style="width:100%">
            <thead>
              <tr>
                <th class="text-center" width="1%">#</th>
                <th class="text-center" width="10%">รหัสใบสมัคร</th>
                <th class="text-center" width="10%">ชื่อ</th>
                <th class="text-center" width="10%">ประเภทที่ตัดสิน</th>
                <th class="text-center" width="10%">สาขารางวัล</th>
                <th class="text-center" width="10%">วันที่ส่งใบสมัคร</th>
                <th class="text-center" width="10%">สถานะ</th>
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
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
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