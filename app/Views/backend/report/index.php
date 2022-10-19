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
      <div class="card-header pb-0">
        <h3 class="card-title"><?= $title ?></h3>
      </div>
      <div class="card-body">
        <form action="#">

          <div class="row justify-content-center">
            <div class="col-md-5 row">

              <div class="col-md-4">
                <label for="application_type">ประเภทรางวัลอุตสาหกรรมท่องเที่ยวไทย</label>
              </div>

              <div class="col-md-8">
                <div class="form-group">
                  <select class="form-control" name="application_type" id="application_type">

                    <option value="">เลือกประเภท</option>
                    <?php
                    if (!empty($type)) :
                      foreach ($type as $key => $value) :
                    ?>
                        <option value="<?= $value->id ?>"><?= $value->name ?></option>
                    <?php
                      endforeach;
                    endif;
                    ?>

                  </select>
                </div>
              </div>

              <div class="col-md-4">
                <label for="export_type">ประเภทการส่งออก</label>
              </div>

              <div class="col-md-8">
                <div class="form-group">
                  <select class="form-control" name="export_type" id="export_type">
                    <option value="">เลือกประเภทการส่งออก</option>
                    <option value="1">Pre-screen (พร้อมคำถาม)</option>
                    <option value="2">ลงพื้นที่ (พร้อมคำถาม)</option>
                    <option value="3">Pre Screen (เกณฑ์การตัดสิน)</option>
                    <option value="4">ลงพื้นที่ (เกณฑ์การตัดสิน)</option>
                    <option value="5">Pre Screen (ค่าคะแนน)</option>
                    <option value="6">ลงพื้นที่ (ค่าคะแนน)</option>
                    <option value="7">สรุปคะแนน</option>
                  </select>
                </div>
              </div>

              <div class="col-md-12">
                <div class="row justify-content-center">
                  <button type="button" class="btn btn-light mr-2">ยกเลิก</button>
                  <button type="button" class="btn btn-primary">ส่งออก</button>
                </div>
              </div>

            </div>
          </div>

        </form>

      </div>
    </div>
  </div>
</div>