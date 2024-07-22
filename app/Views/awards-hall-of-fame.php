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
<div class="banner-box" data-id="1">
    <img src="<?= base_url('assets/images/banner/halloffame.jpg') ?>" width="1920" height="900" alt="" loading="lazy">
</div>

<div class="container">
    <div class="container_box hall_of_fame awardsection goldsilverawards active">
        <div class="row">
            <div class="col12">
                <div class="award-list">
                    <ul id="list-gold-award">                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?=view('_awards')?>