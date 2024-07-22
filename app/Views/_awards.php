<?php $app = new \Config\App; ?>
<link rel="stylesheet" href="<?=base_url('assets/plugins/lightbox2/css/lightbox.css')?>">
<script src="<?=base_url('assets/plugins/lightbox2/js/lightbox.js')?>"></script>
<script src="<?=base_url('assets/js/awards.js')?>?v=<?=$app->script_v?>"></script>
<script>
    $(document).ready(function() {
        awards.init('<?=$setting?>');
    });

    $('.branch').on('click', function() {
        $('.branch').removeClass('active');
        $(this).addClass('active');
        awards.Winner($(this).attr('data-branch'));
    });

    lightbox.option({
        albumLabel: 'รูปภาพ %1 จาก %2',
        resizeDuration: 200,
        wrapAround: true
    });
</script>