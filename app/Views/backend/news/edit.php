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
      </div>
      <div class="card-body">

        <form id="input_form">
          <input type="hidden" name="insert_id" id="insert_id" value="<?= @$result->id ?>">

          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="category_id">หมวดหมู่ <span class="text-danger">*</span></label>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <select name="category_id" id="category_id" class="form-control">
                  <?php
                  if (!empty($category)) :
                    foreach ($category as $key => $value) :
                      $selected = '';
                      if (!empty($result->category_id) && ($result->category_id && $value->id)) {
                        $selected = 'selected';
                      }
                  ?>
                      <option value="<?= $value->id ?>" <?= $selected ?>><?= $value->name ?></option>
                  <?php
                    endforeach;
                  endif;
                  ?>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="title">หัวข้อ <span class="text-danger">*</span></label>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <input type="text" name="title" id="title" class="form-control" value="<?= @$result->title ?>" placeholder="" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="image_cover">รูปหน้าปก <span class="text-danger">*</span></label>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <div class="custom-file">
                  <input type="file" name="image_cover" id="image_cover" class="custom-file-input" required>
                  <label class="custom-file-label" for="image_cover">Choose file...</label>
                </div>
                <?php
                if (!empty($result->image_cover) && $result->image_cover != "") {
                  $path = base_url('uploads/news/images') . '/' . $result->image_cover;
                } else {
                  $path = base_url('/backend/assets/images/add_img.png');
                }
                ?>
                <input type="hidden" name="image_cover_old" id="image_cover_old" value="<?= @$result->image_cover ?>">
                <img id="image_cover_show" class="img-thumbnail mt-2" onclick="$('#image_cover').click()" src="<?= $path ?>" width="200px">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="description">รายละเอียด <span class="text-danger">*</span></label>
              </div>
            </div>
            <div class="col-sm-8">
              <div class="form-group">
                <textarea class="form-control" name="description" id="description" cols="30" rows="10" required><?= @$result->description ?></textarea>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="publish_start">ระยะเวลาเผยแพร่ <span class="text-danger">*</span></label>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <input type="datetime-local" name="publish_start" id="publish_start" class="form-control" value="<?= @$result->publish_start ?>" required>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <input type="datetime-local" name="publish_end" id="publish_end" class="form-control" value="<?= @$result->publish_end ?>" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="status">สถานะ <span class="text-danger">*</span></label>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <div class="d-flex">
                  <h6 class="text-dark mr-2 mt-2">ไม่เผยแพร่</h6>
                  <div class="tgl-btn-primary">
                    <input type="checkbox" class="tgl tgl-flat" id="status" name="status" value="1" <?= (@$result->status == 1) ? 'checked' : ''; ?>>
                    <label class="tgl-btn" for="status"></label>
                  </div>
                  <h6 class="text-dark ml-2 mt-2">เผยแพร่</h6>
                </div>
              </div>
            </div>
          </div>

        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="window.location.href = '<?= base_url('backend/News') ?>'"><i class="fas fa-times"></i> ยกเลิก</button>
        <button type="button" class="btn btn-primary" id="btn_save"><i class="fas fa-save"></i> บันทึก</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(function() {
    // Active Menu
    var menu = $('#menu');
    var item = $(menu).find("a[href='<?= base_url() ?>/backend/News']");
    var ul = $(item).closest('ul');
    var li = $(ul).closest('li');

    li.find('.has-arrow').attr('aria-expanded', 'true');
    li.addClass('active');
    item.addClass('active');
    $(ul).collapse('toggle');

    // $('#description').summernote({
    //   height: 300
    // });

    $('#description').summernote({
      tabsize: 2,
      height: 400,
      spellCheck: true,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'italic', 'superscript', 'subscript', 'clear']],
        ['fontname', ['fontname', 'fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'help', 'undo', 'redo', 'codeview']],
      ],
      callbacks: {
        onImageUpload: function(files, editor, welEditable) {
          sendFile(files[0], editor, welEditable);
        },
        onMediaDelete: function(files, editor, welEditable) {
          var imageUrl = $(files[0]).attr('src');
          var image = imageUrl.split('/');
          cc(image[6])
          cc(imageUrl)

          var option = {
            title: "คุณต้องการลบรูปภาพหรือไม่?",
            text: "หากทำการกดยืนยันแล้วจะไม่สามารถนำกลับมาใช้ใหม่ได้",
          }
          swal_confirm(option).done(function() {
            var res = main_post(BASE_URL + '/backend/News/removeImage', {
              path: image[6]
            });
            res_swal(res, 1);
          });

          // deleteImage(image[4]);
        }
      }
    });

  });

  function sendFile(file, editor, welEditable) {
    var lib_url = BASE_URL + '/backend/News/uploadImage';
    data = new FormData();
    data.append("file", file);
    $.ajax({
      data: data,
      type: "POST",
      url: lib_url,
      cache: false,
      processData: false,
      contentType: false,
      success: function(url) {
        var image = $('<img>').attr('src', url);
        $('#description').summernote("insertNode", image[0]);
      }
    });
  }


  $('#btn_save').click(function(e) {
    var insert_id = $('#insert_id').val();
    if (insert_id == "" || insert_id == 0) {
      $('#image_cover').prop('required', true);
    } else {
      $('#image_cover').prop('required', false);
    }
    if (main_validated('input_form')) {
      if (insert_id == "" || insert_id == 0) {
        var res = main_save(BASE_URL + '/backend/News/saveInsert', '#input_form');
        res_swal(res, 0, function() {
          if (res.type == 'success') {
            window.location.href = '<?= base_url('backend/News') ?>';
          }
        });
      } else {
        var res = main_save(BASE_URL + '/backend/News/saveUpdate', '#input_form');
        res_swal(res, 0, function() {
          if (res.type == 'success') {
            window.location.href = '<?= base_url('backend/News') ?>';
          }
        });
      }
    }
  });

  image_cover.onchange = evt => {
    const [file] = image_cover.files
    if (file) {
      image_cover_show.src = URL.createObjectURL(file)
    }
  }
</script>