<div class="backendcontent">

  <div class="backendcontent-row">
    <div class="backendcontent-title">
      <div class="backendcontent-title-txt">
        <h3>หมวดหมู่รายงาน</h3>
      </div>
    </div>
    <?php
    $data = [
      [
        'link' => base_url('administrator/report/export/register'),
        'name' => 'ผลงานที่สมัครทั้งหมด',
        'class' => '',
      ],
      [
        'link' => base_url('administrator/report/export/pre_average'),
        'name' => 'สรุปคะแนนรอบ Pre-Screen (ค่าเฉลี่ย)',
        'class' => '',
      ],
      [
        'link' => base_url('administrator/report/export/onsite_average'),
        'name' => 'สรุปคะแนนรอบลงพื้นที่ (ค่าเฉลี่ย)',
        'class' => '',
      ],
      [
        'link' => base_url('administrator/report/export/summary_scores'),
        'name' => 'สรุปคะแนนทั้งหมด',
        'class' => '',
      ],
      [
        'link' => base_url('administrator/report/export/suggestion'),
        'name' => 'ข้อเสนอแนะกรรมการ',
        'class' => '',
      ],
      [
        'link' => base_url('administrator/report/export/lowcarbon'),
        'name' => 'Low Carbon',
        'class' => '',
      ],
      [
        'link' => base_url('administrator/report/export/lowcarbon_officer'),
        'name' => 'Low Carbon (รายกรรมการ)',
        'class' => '',
      ],
    ];

    $data_2 = [
      [
        'link' => base_url('administrator/report/export/pre_officer/1'),
        'name' => 'คะแนนรอบ Pre-Screen (รายกรรมการ)',
        'class' => 'pre_officer',
      ],
      [
        'link' => base_url('administrator/report/export/onsite_officer/1'),
        'name' => 'คะแนนรอบลงพื้นที่ (รายกรรมการ)',
        'class' => 'onsite_officer',
      ],
    ];
    ?>

    <ul class="list-report">
      <?php foreach ($data as $key => $value) : ?>
        <li>
          <a href="javascript:" data-href="<?= $value['link']; ?>" class="btn-export <?= $value['class']; ?>" target="_blank">
            <i class="bi bi-box-arrow-in-down"></i> <?= $value['name']; ?>
          </a>
        </li>
      <?php endforeach; ?>

      <div class="backendcontent-row">
        <div class="regis-form-data-col1" style="margin-left: 10px;">
          <small class="text-danger mt-0"><i>* เงื่อนไข เฉพาะ คะแนนรอบ Pre-Screen (รายกรรมการ) และ คะแนนรอบลงพื้นที่ (รายกรรมการ) เท่านั้น</i></small>
          <h4>กรุณาเลือกประเภทการสมัคร</h4>
          <p>
            <input type="radio" id="application_type_1" name="application_type" value="1" checked="">
            <label for="application_type_1"> แหล่งท่องเที่ยว (Attraction)</label>
          </p>
          <p>
            <input type="radio" id="application_type_2" name="application_type" value="2">
            <label for="application_type_2"> ที่พักนักท่องเที่ยว (Accommodation)</label>
          </p>
          <p>
            <input type="radio" id="application_type_3" name="application_type" value="3">
            <label for="application_type_3"> การท่องเที่ยวเชิงสุขภาพ (Health and Wellness Tourism)</label>
          </p>
          <p>
            <input type="radio" id="application_type_4" name="application_type" value="4">
            <label for="application_type_4"> รายการนำเที่ยว (Tourism Program)</label>
          </p>
        </div>
      </div>

      <?php foreach ($data_2 as $key => $value) : ?>
        <li>
          <a href="javascript:" data-href="<?= $value['link']; ?>" class="btn-export <?= $value['class']; ?>" target="_blank">
            <i class="bi bi-box-arrow-in-down"></i> <?= $value['name']; ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>

  </div>

</div>

<script>
  $(function() {
    $('.btn-menulist').each(function(key, elm) {
      if ($(elm).data('tab') == 2) {
        $(elm).click();
      }
    });
  });

  $('.btn-export').click(function(e) {
    var href = $(this).data('href');
    var pre = $(this).hasClass('pre_officer');
    var onsite = $(this).hasClass('onsite_officer');
    var type = $('[name="application_type"]:checked').val();
    if (pre) {
      window.open(href + '/' + type, '_blank');
    } else if (onsite) {
      window.open(href + '/' + type, '_blank');
    } else {
      window.open(href, '_blank');
    }
  });
</script>