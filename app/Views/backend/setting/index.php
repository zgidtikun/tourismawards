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
            <div class="col-md-8 row">

              <div class="col-md-6">
                <div class="justify-content-between">
                  <div>
                    <div class="form-group">
                      <label for="">ชื่อเว็บไซต์</label>
                      <input type="text" class="form-control border-secondary" id="name" name="name" placeholder="ชื่อเว็บไซต์">
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="justify-content-between">
                  <div>
                    <div class="form-group">
                      <label for="">อีเมลติดต่อ</label>
                      <input type="text" class="form-control border-secondary" id="email" name="email" placeholder="อีเมลติดต่อ">
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="justify-content-between">
                  <div>
                    <div class="form-group">
                      <label for="">รูปแบบวันที่</label>
                      <input type="text" class="form-control border-secondary text-center" id="date" name="date" placeholder="รูปแบบวันที่">
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="justify-content-between">
                  <div>
                    <div class="form-group">
                      <label for="">รูปแบบเวลา</label>
                      <input type="text" class="form-control border-secondary text-center" id="time" name="time" placeholder="รูปแบบเวลา">
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </form>

      </div>
    </div>
  </div>
</div>