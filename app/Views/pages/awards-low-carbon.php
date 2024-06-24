<?= $this->extend('layout') ?>
<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
    .certificate-award {
        display: flex;
        justify-content: center;
    }

    .certificate-award h2 {
        background-color: #0c2e54;
        color: #fff;
        padding: 10px 20px;
        text-align: center;
        margin: 0;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const headerHeight = document.querySelector('#header-inner').offsetHeight;
        const mainsite = document.querySelector('.mainsite');
        mainsite.style.display = 'block';
        mainsite.style.marginTop = `${headerHeight}px`;
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="banner-box">
    <img width="1920" height="900" alt="" loading="lazy"
    <?php if($setting == 'gold-awards-low-carbon'): ?>
    src="<?=base_url('assets/images/banner/gold_awards.jpg')?>"
    <?php else: ?>
    src="<?=base_url('assets/images/banner/silver_awards.jpg')?>"
    <?php endif; ?>
    >
</div>

<div class="container">
    <div class="container_box awardsection goldsilverawards active" id="list-award">
        <div class="row">
            <div class="col12">
                <div class="main-title">
                    <div class="main-title-txt">
                        <h2>ประเภทการท่องเที่ยวคาร์บอนต่ำเพื่อความยั่งยืน<br>(Low Carbon & Sustainbility)</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('_awards') ?>
<?= $this->endSection() ?>