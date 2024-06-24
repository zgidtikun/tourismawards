<?= $this->extend('layout') ?>
<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
    .winner-title { font-size: 5vw; }
    .winner-title-large { font-size: 10vw; }
    .award-section-col { cursor: pointer; }

    .award-section-txt {
        font-size: 20px !important;
        font-weight: 600;
        transition: .5s ease;
        width: auto;
        border-top-right-radius: 10px;
    }

    .awards {
        background-image: url(<?=base_url('assets/images/banner/awards_bg.jpg')?>);
        background-position: bottom center; 
        background-repeat: no-repeat; 
        background-size: cover;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const headerHeight = document.querySelector('#header-inner').offsetHeight;
        document.querySelector('.mainsite').style.display = 'block';
        document.querySelector('.mainsite').style.marginTop = `${headerHeight}px`;
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container awards">
    <div class="container_box">
        <div class="row">
            <div class="col12">
                <div class="winner-title">
                    WINNER
                    <div class="winner-title-large">2023</div>
                </div>
                <div class="award-section goldsilverawards">
                    <div class="award-section-col">
                        <a href="<?=base_url('awards-winner/hall-of-fame')?>"> Hall of Fame</a>
                    </div>
                    <div class="award-section-col">
                        <a href="<?=base_url('awards-winner/gold-awards')?>">
                            <span class="txt-small">Thailand Tourism</span><br>Gold Awards
                        </a>
                    </div>
                    <div class="award-section-col">
                        <a href="<?=base_url('awards-winner/silver-awards')?>">
                            <span class="txt-small">Thailand Tourism </span><br>Silver Awards
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>