<style>
  .tabs {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
  }

  .content.active {
    padding: 2rem;
    display: block;
  }

  .content {
    display: none;
  }

  .btn_nev {
    padding: 0.75rem 1.25rem;
    font-size: 1.5rem;
    cursor: pointer;
    border: none;
    color: #9b9b9b;
  }

  .btn_nev:hover {
    background-color: #ddd;
  }

  .btn_nev:focus {
    border: none;
  }

  .btn_nev.active {
    /* background-color: lightgreen; */
    border-bottom: 5px solid #6993ff;
    color: #6993ff;
  }
</style>
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
        <h3 class="card-title">ข้อมูลผู้ประกอบการ</h3>
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
                <th class="text-center" width="10%">ชื่อผู้ประกอบการ</th>
                <th class="text-center" width="10%">ประเภทสมาชิก</th>
                <th class="text-center" width="10%">เบอร์มือถือ</th>
                <th class="text-center" width="10%">E-mail</th>
                <!-- <th class="text-center" width="5%">สถานะ</th> -->
                <th class="text-center" width="10%">จัดการ</th>
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
                    <td><?= $value->member_type_name ?></td>
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

<div class="row ml-4 mr-4">
  <div class="col-xl-12 col-xxl-12">
    <div class="card">
      <div class="card-body">

        <div class="">
          <div class="tabs">
            <button class="btn_nev btn1 active" id="1">1 เลือกประเภทการสมัคร</button>
            <button class="btn_nev btn2" id="2">2 ข้อมูลผลงาน</button>
            <button class="btn_nev btn3" id="3">3 ข้อมูลหน่วยงาน/บริษัท</button>
            <button class="btn_nev btn4" id="4">4 ข้อมูลผู้ประสานงาน</button>
            <button class="btn_nev btn5" id="5">5 คุณสมบัติเบื้องต้น</button>
          </div>
          <div class="sections">
            <div class="content content1 active">
              <h2>Heading 1</h2>
            </div>
            <div class="content content2">
              <h2>Heading 2</h2>
            </div>
            <div class="content content3">
              <h2>Heading 3</h2>
            </div>
            <div class="content content4">
              <h2>Heading 4</h2>
            </div>
            <div class="content content5">
              <h2>Heading 5</h2>
            </div>
          </div>
        </div>


      </div>
    </div>
  </div>
</div>

<script>
  const buttons = document.querySelectorAll("button");
  const sections = document.querySelectorAll(".content");

  buttons.forEach((btn) => {
    btn.addEventListener("click", () => {
      buttons.forEach((btn) => {
        btn.classList.remove("active");
      });
      btn.classList.add("active");
      const id = btn.id;
      sections.forEach((section) => {
        section.classList.remove("active");
      });
      const req = document.getElementsByClassName(`content${id}`);
      req[0].classList.add("active");
    })
  })
</script>