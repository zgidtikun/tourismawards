<style>
  .dataTables_wrapper .dataTables_length {
    justify-content: flex-start !important;
  }
</style>
<div class="backendcontent">
  <div class="backendcontent-row">
    <div class="backendcontent-title">
      <div class="backendcontent-title-txt">
        <h3>รายการข่าวประชาสัมพันธ์ </h3>
      </div>
      <a href="javascript:" class="btn-blue" onclick="insert_item(this)">เพิ่มข้อมูล</a>
    </div>

    <!-- <form action="" method="get">
      <div class="backendcontent-subrow">
        <div class="backendcontent-subcol searchbox">
          <input type="text" name="keyword" id="keyword" value="<?= @$_GET['keyword'] ?>" placeholder="ค้นหา">
        </div>

        <div class="backendcontent-subcol btn">
          <button type="submit" class="but-blue" id="btn_search">ค้นหา</button>
        </div>

      </div>
    </form> -->

    <div class="backendcontent-subrow">
      <div class="form-table">
        <div class="grid">
          <div class="unit w-1-1">
            <table id="example" class="display" style="width: 100%;">
              <thead>
                <tr>
                  <th class="text-center" width="1%">#</th>
                  <th class="text-center" width="3%">รูป</th>
                  <th class="text-center" width="50%">หัวข้อ</th>
                  <!-- <th class="text-center" width="10%">หมวดหมู่</th> -->
                  <th class="text-center" width="5%">สถานะ</th>
                  <th class="text-center" width="8%">วันที่</th>
                  <th class="text-center" width="5%">จัดการ</th>
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
                        <img src="<?= $path ?>" alt="" srcset="" width="100px" onclick="view_img(this)">
                        <textarea class="description" style="display: none;"><?= $value->description ?></textarea>
                      </td>
                      <td class="text-start"><?= $value->title ?></td>
                      <!-- <td class="text-center"><?php /*echo $category[$value->category_id]*/ ?></td> -->
                      <td class="text-center">
                        <?= ($value->status) ? '<div class="userstatus judge">เผยแพร่แล้ว</div>' : '<div class="userstatus officer">ไม่เผยแพร่</div>'; ?>
                      </td>
                      <td class="text-center"><?= docDate($value->updated_at) ?></td>
                      <td class="text-center">

                        <div class="form-table-col edit">
                          <a href="javascript:" class="btn-edit" title="ดูรายละเอียด" onclick="view_item(this)"><i class="bi bi-eye text-success"></i></a>
                          <a href="javascript:" class="btn-edit" title="แก้ไขข้อมูล" onclick="edit_item('<?= $value->id ?>')"><i class="bi bi-pencil-square"></i></a>
                          <a href="javascript:" class="btn-delete" title="ลบข้อมูล" onclick="delete_item('<?= $value->id ?>')"><i class="bi bi-trash-fill text-danger"></i></a>
                        </div>

                        <!-- <i class="fa fa-eye text-success mr-2" data-toggle="tooltip" title="ดูรายละเอียด" onclick="view_item(this)"></i>
                  <i class="fas fa-edit text-primary mr-2" data-toggle="tooltip" title="แก้ไขข้อมูล" onclick="edit_item('<?= $value->id ?>')"></i>
                  <i class="fas fa-trash-alt text-danger mr-2" data-toggle="tooltip" title="ลบข้อมูล" onclick="delete_item('<?= $value->id ?>')"></i> -->
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

</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-xl" id="exampleModal" data-target=".bd-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ตัวอย่างเนื้อหา</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(function() {
    var pgurl = BASE_URL_BACKEND + '/news';
    active_page(pgurl);

    $.fn.DataTable.ext.pager.numbers_length = 6;
    $("#example").dataTable().fnDestroy();
    $("#example").addClass("nowrap").dataTable({
      responsive: true,
      searching: true,
      columnDefs: [{
        responsivePriority: 1,
        targets: 2
      }, {
        responsivePriority: 2,
        targets: 4
      }, {
        responsivePriority: 10001,
        targets: 4
      }, {
        responsivePriority: 10001,
        targets: 3
      }, {
        responsivePriority: 10001,
        targets: 1
      }],
      pageLength: 10,
      numbersLength: 3,
      // pagingType: 'numbers',
      lengthMenu: [1, 10, 25, 50, 100],
      oLanguage: {
        sSearchPlaceholder: "ค้นหา",
        sLengthMenu: "แสดง _MENU_ รายการ",
        sSearch: "ค้นหา",
        sInfo: "แสดง _START_ ถึง _END_ ทั้งหมด _TOTAL_ รายการ",
        sInfoEmpty: "แสดง 0 ถึง 0 ทั้งหมด 0 รายการ",
        sInfoFiltered: "(ค้นหาจากทั้งหมด _MAX_ รายการ)",
        sZeroRecords: "ไม่มีข้อมูล",
        sProcessing: "Processing",
        semptyTable: "ไม่มีข้อมูล",
        // oPaginate: {
        //   sFirst: "First", // This is the link to the first page
        //   sPrevious: "<<", // This is the link to the previous page
        //   sNext: ">>", // This is the link to the next page
        //   sLast: "Last" // This is the link to the last page
        // }
      }
    });
  });

  $('#keyword').on('keypress', function(e) {
    if (e.which == 13) {
      $('#btn_search').click();
    }
  });

  function delete_item(id) {
    var option = {
      title: "Warning!",
      text: "คุณต้องการยืนยันการลบข้อมูล<?= $title ?>หรือไม่?",
    }
    swal_confirm(option).done(function() {
      var res = main_post(BASE_URL_BACKEND + '/news/delete', {
        id: id,
        image_cover: $('#image_cover_old').val(),
      });
      res_swal(res, 1);
    })
  }

  function view_item(elm) {
    var tr = $(elm).closest('tr');
    var description = $(tr).find('.description').val();
    $('.modal-body').html(description);
    $('#exampleModal').modal('show');
  }

  function edit_item(id) {
    window.location.href = BASE_URL_BACKEND + '/news/edit/' + id;
  }

  function insert_item(elm) {
    window.location.href = BASE_URL_BACKEND + '/news/add';
  }
</script>