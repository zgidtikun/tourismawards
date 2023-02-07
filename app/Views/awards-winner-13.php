<div class="banner-box">

    <div class="txt-banner">
        <h2>ผลงานที่ได้รับรางวัล ปี 2565</h2>
    </div>

</div>

<div class="container">
    <div class="container_box">
        <div class="row">
            <div class="col12">
                <div class="awardyear">
                    <div class="awardyear-col">
                        <label>ผลงานที่ได้รับรางวัลอุตสาหกรรมท่องเที่ยวไทย</label>
                    </div>
                    <div class="awardyear-col selectyear">
                        <select required id="syear">
                            <option value="" disabled>-- ปี --</option>
                            <option value="2564" selected>ปี 2564</option>
                            <option value="2562">ปี 2562</option>
                            <option value="2560">ปี 2560</option>
                            <option value="2558">ปี 2558</option>
                            <option value="2556">ปี 2556</option>
                            <option value="2553">ปี 2553</option>
                            <option value="2551">ปี 2551</option>
                            <option value="2549">ปี 2549</option>
                            <option value="2547">ปี 2547</option>
                            <option value="2545">ปี 2545</option>
                            <option value="2543">ปี 2543</option>
                            <option value="2541">ปี 2541</option>
                            <option value="2539">ปี 2539</option>
                        </select>
                    </div>
                </div>

                <div class="awardsection-list">
                    <ul>
                        <li>
                            <a href="javascript:void(0)" class="btn-selectsec active" data-tab="1">
                                ประเภทแหล่งท่องเที่ยว
                                <br>(Attraction)
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="btn-selectsec" data-tab="2">
                                ประเภทที่พักนักท่องเที่ยว
                                <br>(Accommodation)
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="btn-selectsec" data-tab="3">
                                ประเภทการท่องเที่ยวเชิงสุขภาพ
                                <br>(Health and Wellness Tourism)
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container_box awardsection active" data-tab="1">
        <div class="row">
            <div class="col12">
                <div class="main-title">
                    <div class="main-title-txt">
                        <h2>ประเภทแหล่งท่องเที่ยว (Attraction)</h2>
                    </div>
                </div>

                <div class="gold-award">
                    <h2>Thailand Tourism Gold Awards
                </div>

                <div class="award-othlist">
                    <ul id="gold-award-list">
                    </ul>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col12">
                <div class="silver-award">
                    <h2>Thailand Tourism Awards</h2>
                </div>

                <div class="award-othlist">
                    <ul id="silver-award-list">
                    </ul>
                </div>
            </div>

        </div>
    </div>

</div>

<script src="<?=base_url('assets/js/frontend/last-winner.js')?>"></script>
<script>

    $(document).ready(() => {
        const paramType = '<?=(!empty($_GET['type']) ? $_GET['type'] : '')?>';
        ayear = 2564;

        switch(paramType){
            case 'attraction':
                atab = 1;
            break;
            case 'accommodation':
                atab = 2;
            break;
            case 'health-and-wellness-tourism':
                atab = 3;
            break;
            default: 
                atab = 1;
        }

        $('.mainsite').addClass('awardotherbranch');
        $('.btn-selectsec').removeClass('active');
        $(`.btn-selectsec[data-tab="${atab}"]`).addClass('active');

        setAwards();

        $('.btn-selectsec').click(function () {
            const datatab = $(this).attr('data-tab');
            atab = datatab;
            $('.btn-selectsec').removeClass('active');
            $(this).addClass('active');
            setAwards();
        });
    });
    
</script>