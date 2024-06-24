<link rel="stylesheet" href="<?=base_url('assets/plugins/lightbox2/css/lightbox.css')?>">
<script src="<?=base_url('assets/plugins/lightbox2/js/lightbox.js')?>"></script>
<script src="<?=base_url('assets/js/awards.js')?>?v=<?= config(\Config\App::class)->script_v ?>"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        awards.init('<?=$setting?>');
    });

    document.querySelectorAll('.branch').forEach( inp => {
        inp.addEventListener('click', function() {
            document.querySelectorAll('.branch').forEach( e => {
                e.classList.remove('active');
            });

            this.classList.add('active');
            awards.Winner(this.dataset.branch);
        });
    });

    lightbox.option({
        albumLabel: 'รูปภาพ %1 จาก %2',
        resizeDuration: 200,
        wrapAround: true
    });
</script>