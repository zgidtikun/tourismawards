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
    <?php if($setting == 'gold-awards'): ?>
    src="<?=base_url('assets/images/banner/gold_awards.jpg')?>"
    <?php else: ?>
    src="<?=base_url('assets/images/banner/silver_awards.jpg')?>"
    <?php endif; ?>
    >
</div>

<div class="container">
    <div class="container_box awardsectionlist">
        <div class="row">
            <div class="col12">
                <div class="awardsection-list">
                    <ul>
                        <li>
                            <a href="javascript:void(0)" class="btn-selectsec branch active" 
                                data-branch="attraction" style="text-align: left;">
                                ประเภทแหล่งท่องเที่ยว<br>(Attraction)
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="btn-selectsec branch" 
                                data-branch="accommodation" style="text-align: left;">
                                ประเภทที่พักนักท่องเที่ยว<br>(Accommodation) 
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="btn-selectsec branch" 
                                data-branch="health_and_wellness_tourism" style="text-align: left;">
                                ประเภทการท่องเที่ยวเชิงสุขภาพ<br>(Health and Wellness Tourism) 
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="btn-selectsec branch" 
                                data-branch="tour_programmes" style="text-align: left;">
                                ประเภทรายการนำเที่ยว<br>(Tour Programmes) 
                            </a>
                        </li>
                        <li>
                            <a href="<?=base_url("awards-winner/$setting/low-carbon")?>" class="btn-selectsec " 
                                data-branch="low_carbon_and_sustainability" style="text-align: left;">
                                ประเภทการท่องเที่ยวคาร์บอนต่ำเพื่อความยั่งยืน<br>(Low Carbon & Sustainability) 
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container_box awardsection goldsilverawards active" id="list-award">
    </div>

</div>

<?= $this->include('_awards') ?>
<?= $this->endSection() ?>