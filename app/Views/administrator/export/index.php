<div class="backendcontent">

  <div class="backendcontent-row">
    <div class="backendcontent-title">
      <div class="backendcontent-title-txt">
        <h3>หมวดหมู่รายงาน</h3>
      </div>
    </div>

    <ul class="list-report">
      <li><a href="<?= base_url('administrator/report/export/register'); ?>" class="btn-export" target="_blank"><i class="bi bi-box-arrow-in-down"></i> ผลงานที่สมัครทั้งหมด</a></li>
      <li><a href="<?= base_url('administrator/report/export/pre_officer'); ?>" class="btn-export" target="_blank"><i class="bi bi-box-arrow-in-down"></i> คะแนนรอบ Pre-Screen (กรรมการแต่ละท่าน)</a></li>
      <li><a href="<?= base_url('administrator/report/export/pre_average'); ?>" class="btn-export" target="_blank"><i class="bi bi-box-arrow-in-down"></i> สรุปคะแนนรอบ Pre-Screen (ค่าเฉลี่ย)</a></li>
      <li><a href="<?= base_url('administrator/report/export/onsite_officer'); ?>" class="btn-export" target="_blank"><i class="bi bi-box-arrow-in-down"></i> คะแนนรอบลงพื้นที่ (กรรมการแต่ละท่าน)</a></li>
      <li><a href="<?= base_url('administrator/report/export/onsite_average'); ?>" class="btn-export" target="_blank"><i class="bi bi-box-arrow-in-down"></i> สรุปคะแนนรอบลงพื้นที่ (ค่าเฉลี่ย)</a></li>
      <li><a href="<?= base_url('administrator/report/export/summary_scores'); ?>" class="btn-export" target="_blank"><i class="bi bi-box-arrow-in-down"></i> สรุปคะแนนทั้งหมด</a></li>
      <li><a href="<?= base_url('administrator/report/export/suggestion'); ?>" class="btn-export" target="_blank"><i class="bi bi-box-arrow-in-down"></i> ข้อเสนอแนะกรรมการ</a></li>
    </ul>

  </div>

</div>

<script>
  $(function() {
    var pgurl = BASE_URL_BACKEND + '/report';
    active_page(pgurl);
  });
</script>