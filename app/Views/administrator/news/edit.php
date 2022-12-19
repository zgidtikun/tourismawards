<div class="backendcontent">
  <form id="input_form" style="display: flex;">
    <input type="hidden" name="insert_id" id="insert_id" value="<?= @$result->id ?>">
    <div class="backendcontent-row2" style="margin-right: 1rem;">
      <div class="backendcontent-title">
        <div class="backendcontent-title-txt">
          <h3>ข้อมูลทั่วไป</h3>
        </div>
      </div>

      <div class="backendform-row">
        <div class="backendform-col">
          <label class="d-inline">หมวดหมู่ <span class="required">*</span></label>
          <button type="button" class="btn btn-dark btn-sm mb-2" onclick="add_category(this)"><i class="bi bi-plus"></i> เพิ่มหมวดหมู่</button>
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

        <div class="backendform-col">
          <label>หัวข้อข่าว <span class="required">*</span></label>
          <input type="text" name="title" id="title" class="form-control" value="<?= @$result->title ?>" placeholder="" required>
        </div>

        <div class="backendform-col">
          <label>รายละเอียด <span class="required">*</span></label>
          <textarea class="form-control" name="description" id="description" cols="30" rows="10" required><?= @$result->description ?></textarea>
        </div>

      </div>
    </div>

    <div class="backendcontent-row2">
      <div class="backendcontent-title">
        <div class="backendcontent-title-txt">
          <h3></h3>
        </div>
      </div>
      <div class="backendform-row">
        <div class="backendform-col">
          <div class="formrow">
            <button type="button" class="btn btn-success fileup-btn">
              Attach files
              <!-- <input type="file" id="upload-1" /> -->
              <input type="file" name="image_cover" id="image_cover" required>
              <input type="hidden" name="image_cover_old" id="image_cover_old" value="<?= @$result->image_cover ?>">
            </button>
            <!-- <a class="control-button btn btn-link" style="display: none;" href="javascript:$.fileup1('upload-1', 'upload', '*')">Upload all</a> -->
            <!-- <a class="control-button btn btn-link" style="display: none;" href="javascript:$.fileup1('upload-1', 'remove', '*')">Remove all</a> -->
          </div>
          <span class="required">(file type: jpg , png , gif)</span>
          <?php
          if (!empty($result->image_cover) && $result->image_cover != "") {
            $style = '';
            $path = base_url('uploads/news/images') . '/' . $result->image_cover;
          } else {
            $style = 'style="display: none;"';
            $path = base_url('/backend/assets/images/add_img.png');
          }
          ?>
          <div id="upload_data" class="queue" <?= $style ?>>
            <div id="data_img_upload" class="fileup-file fileup-image">
              <div class="fileup-preview">
                <img src="<?= $path ?>" id="image_cover_show">
              </div>
              <div class="fileup-container">
                <div class="fileup-description"><span class="fileup-name"><?= @$result->image_cover ?></span> <span class="fileup-size"></span></div>
                <!-- <div class="fileup-controls"><span class="fileup-remove" onclick="" title="Remove"></span></div> -->
              </div>
            </div>
          </div>
        </div>

        <div class="backendform-col2">
          <label>เผยแพร่ตั้งแต่วันที่ <span class="required">*</span></label>
          <input type="datetime-local" name="publish_start" id="publish_start" class="form-control" value="<?= @$result->publish_start ?>" required>
        </div>

        <div class="backendform-col2">
          <label>ถึงวันที่ <span class="required">*</span></label>
          <input type="datetime-local" name="publish_end" id="publish_end" class="form-control" value="<?= @$result->publish_end ?>" required>
        </div>

        <div class="backendform-col2">
          <label>สถานะ <span class="required">*</span></label>
          <p><input type="radio" id="status_1" name="status" value="1" <?= (@$result->status == 1) ? 'checked' : ''; ?>> <label for="status_1">เปิดใช้งาน</label> </p>
          <p><input type="radio" id="status_0" name="status" value="0" <?= (@$result->status == 0) ? 'checked' : ''; ?>> <label for="status_0">ปิดใช้งาน</label> </p>
        </div>
      </div>

      <div class="form-main-btn">
        <a href="javascript:void(0)" class="btn-cancle" onclick="window.location.href = BASE_URL_BACKEND + '/news'">ยกเลิก</a>
        <a href="javascript:void(0)" class="btn-save" id="btn_save">บันทึก</a>
      </div>

    </div>
  </form>
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
        <form id="input_form_category">
          <div class="row">
            <div class="col-sm-3 text-end">
              <label for="">ชื่อ Category</label>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <input type="text" class="form-control" name="name" id="name" placeholder="" required>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times"></i> ยกเลิก</button>
        <button type="button" class="btn btn-primary" id="btn_save_category"><i class="fas fa-save"></i> บันทึก</button>
      </div>
    </div>
  </div>
</div>


<script>
  $(function() {
    var pgurl = BASE_URL_BACKEND + '/news';
    active_page(pgurl);
  });

  $(function() {
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

          var option = {
            title: "คุณต้องการลบรูปภาพหรือไม่?",
            text: "หากทำการกดยืนยันแล้วจะไม่สามารถนำกลับมาใช้ใหม่ได้",
          }
          swal_confirm(option).done(function() {
            var res = main_post(BASE_URL_BACKEND + '/news/removeImage', {
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
    var lib_url = BASE_URL_BACKEND + '/news/uploadImage';
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
        var res = main_save(BASE_URL_BACKEND + '/news/saveInsert', '#input_form');
        res_swal(res, 0, function() {
          if (res.type == 'success') {
            window.location.href = '<?= base_url('backend/news') ?>';
          }
        });
      } else {
        var res = main_save(BASE_URL_BACKEND + '/news/saveUpdate', '#input_form');
        res_swal(res, 0, function() {
          if (res.type == 'success') {
            window.location.href = BASE_URL_BACKEND + '/news';
          }
        });
      }
    }
  });

  image_cover.onchange = evt => {
    const [file] = image_cover.files
    if (file) {
      $('#upload_data').show();
      $('.fileup-name').html(file.name);
      $('.fileup-size').html('(' + F2C(file.size / 1024) + ' Kb)');
      image_cover_show.src = URL.createObjectURL(file)
    }
  }

  function add_category(elm) {

    $('#input_form_category')[0].reset();
    $('#exampleModalLabel').html($(elm).html())
    $('#exampleModal').modal('show');
  }

  $('#btn_save_category').click(function(e) {
    if (main_validated('input_form_category')) {
      var res = main_save(BASE_URL_BACKEND + '/news/saveCategory', '#input_form_category');
      var option = "";
      if (res.data !== null) {
        $.each(res.data, function(index, value) {
          option += '<option valur="' + value.id + '">' + value.name + '</option>';
        });
        $('#category_id').html(option);
      }
      res_swal(res, 0, function(e) {
        $('#exampleModal').modal('hide');
      });
    }
  });
</script>