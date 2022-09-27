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
        <h3 class="card-title">ข้อมูลใบสมัคร</h3>
      </div>
      <div class="card-body">

        <div class="row">

          <div class="col-sm-4">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="name">รหัสใบสมัคร :</label>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label for="">ชื่อ :</label>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label for="">Name :</label>
              </div>
            </div>
          </div>

          <div class="col-sm-4">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="name">ประเภท :</label>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label for="">สาขา :</label>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label for="">วันที่ส่งใบสมัคร :</label>
              </div>
            </div>
          </div>

          <div class="col-sm-4">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="name">ชื่อ - นามสกุล :</label>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label for="">อีเมล :</label>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label for="">เบอร์ติดต่อ :</label>
              </div>
            </div>
          </div>

        </div>


      </div>
    </div>
  </div>
</div>

<div class="row ml-4 mr-4">
  <div class="col-xl-12 col-xxl-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">รายชื่อคณะกรรมการสำหรับประเมินใบสมัคร : รอบลงพื้นที่</h3>
      </div>
      <div class="card-body">

        <div class="row">

          <div class="col-sm-4">
            <div class="form-group">
              <label for="assessment_group_name_1">1. Tourism Excellence (Product/Service)</label>
              <input type="text" class="form-control tagsinput" value="Amsterdam,Washington,Sydney,Beijing,Cairo" data-role="tagsinput">
              <textarea class="form-control tagsinput" name="assessment_group_name[1][]" id="assessment_group_name_1" cols="30" rows="4"></textarea>
            </div>
          </div>

          <div class="col-sm-4">
            <div class="form-group">
              <label for="assessment_group_name_2">2. Supporting Business & Marketing Factors</label>
              <textarea class="form-control tagsinput" name="assessment_group_name[2][]" id="assessment_group_name_2" cols="30" rows="4"></textarea>
            </div>
          </div>

          <div class="col-sm-4">
            <div class="form-group">
              <label for="assessment_group_name_3">3. Responsibility and Safety & Health Administration</label>
              <textarea class="form-control tagsinput" name="assessment_group_name[3][]" id="assessment_group_name_3" cols="30" rows="4"></textarea>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
</div>

<script>
  $(function() {
    $(".tagsinput").tagsinput('items');
  });
</script>