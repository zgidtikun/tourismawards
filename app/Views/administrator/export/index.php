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
      ],
      [
        'link' => base_url('administrator/report/export/pre_officer'),
        'name' => 'คะแนนรอบ Pre-Screen (รายกรรมการ)',
      ],
      [
        'link' => base_url('administrator/report/export/pre_average'),
        'name' => 'สรุปคะแนนรอบ Pre-Screen (ค่าเฉลี่ย)',
      ],
      [
        'link' => base_url('administrator/report/export/onsite_officer'),
        'name' => 'คะแนนรอบลงพื้นที่ (รายกรรมการ)',
      ],
      [
        'link' => base_url('administrator/report/export/onsite_average'),
        'name' => 'สรุปคะแนนรอบลงพื้นที่ (ค่าเฉลี่ย)',
      ],
      [
        'link' => base_url('administrator/report/export/summary_scores'),
        'name' => 'สรุปคะแนนทั้งหมด',
      ],
      [
        'link' => base_url('administrator/report/export/suggestion'),
        'name' => 'ข้อเสนอแนะกรรมการ',
      ],
      [
        'link' => base_url('administrator/report/export/lowcarbon'),
        'name' => 'Low Carbon',
      ],
      [
        'link' => base_url('administrator/report/export/lowcarbon_officer'),
        'name' => 'Low Carbon (รายกรรมการ)',
      ],
    ];
    ?>

    <ul class="list-report">
      <?php foreach ($data as $key => $value) : ?>
        <li><a href="<?= $value['link']; ?>" class="btn-export" target="_blank"><i class="bi bi-box-arrow-in-down"></i> <?= $value['name']; ?></a></li>
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
</script>