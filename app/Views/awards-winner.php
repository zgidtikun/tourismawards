<style>
    .award-section-col {
        cursor: pointer;
    }

    .award-section-txt {
        font-size: 20px !important;
        font-weight: 600;
        background: rgb(0, 0, 0);
        background: rgba(0, 0, 0, 0.5);
        transition: .5s ease;
        width: auto;
        border-top-right-radius: 10px;
    }
</style>

<div class="container"
style="background-image: url('<?= base_url('assets/images/banner/banner1.jpg') ?>');">
    <div class="container_box">

        <div class="row">
            <div class="col12">
                <div class="winner-title">
                    WINNER
                    <div class="winner-title-large">
                        2023
                    </div>
                </div>

                <p class="txt-center">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                    eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse
                    ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. 
                </p>

                <div class="award-section">
                    <div class="award-section-col" onclick="toAwardsWinner('attraction')">
                        <div class="award-section-img">
                            <div class="award-section-imgscale">
                                <img src="<?= base_url('assets/images/award_01.jpg') ?>" 
                                style="max-width: none !important;">
                                <div class="award-section-txt">
                                    Attraction
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="award-section-col" onclick="toAwardsWinner('accommodation')">
                        <div class="award-section-img">
                            <div class="award-section-imgscale">
                                <img src="<?= base_url('assets/images/award_02.jpg') ?>" 
                                style="max-width: none !important;">
                                <div class="award-section-txt">
                                    Accommodation
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="award-section-col" onclick="toAwardsWinner('health-and-wellness-tourism')">
                        <div class="award-section-img">
                            <div class="award-section-imgscale">
                                <img src="<?= base_url('assets/images/award_03.jpg') ?>" 
                                style="max-width: none !important;">
                                <div class="award-section-txt">
                                    Health and Wellness Tourism
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="award-section-col" onclick="toAwardsWinner('tourism-program')">
                        <div class="award-section-img">
                            <div class="award-section-imgscale">
                                <img src="<?= base_url('assets/images/award_04.jpg') ?>" 
                                style="max-width: none !important;">
                                <div class="award-section-txt">
                                    Tourism Program
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(() => {
        $('.mainsite').addClass('winneraward');
    });

    const toAwardsWinner = (param) => {
        const url = window.location.origin+'/awards-winner/'+param;
        window.open(url,'_blank');
    }
</script>