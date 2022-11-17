<div class="banner-box">

    <div class="txt-banner">
        <p>ผลงานที่ได้รับรางวัลอุตสาหกรรมท่องเที่ยวไทย ครั้งที่ 14 ปี 2566</p>
        <?php $temp = explode('(',$main->name) ?>
        <h2><?=trim($temp[0])?></h2>
        <p>(<?=trim($temp[1])?></p>
    </div>

</div>

<div class="container">
    <div class="container_box">
        <div class="row">
            <div class="col12">
                <div class="awardsection-list">
                    <ul>
                    <?php 
                        if(!empty($sub)) :
                        foreach($sub as $key=>$value){ 
                            $temp = explode('(',$value->name);
                    ?>
                        <li>
                            <a href="javascript:void(0)" 
                            class="btn-selectsec <?php if($key == 0){ echo  'active'; } ?>" 
                            id="selectsec-<?=($key+1)?>"
                            data-tab="<?=($key+1)?>"
                            onclick="setTabs('#'+this.id)">
                                <?=trim($temp[0])?><br>
                                (<?=trim($temp[1])?>
                            </a>
                        </li>
                    <?php } endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container_box awardsection active">
        <div class="row">
            <div class="col12">
                <div class="main-title">
                    <div class="main-title-txt">
                    </div>
                </div>

                <div class="gold-award">
                    <h2>Thailand Tourism Gold Awards
                </div>

                <div class="award-list">
                    <ul>
                        <li>
                            <div class="award-list-img">
                                <div class="award-list-imgscale">Award#1</div>
                            </div>
                            <div class="award-winner-name">
                                ชื่อสถานประกอบการ
                            </div>
                            <div class="award-winner-subject">
                                <p><label>จังหวัด:</label> </p>
                                <p><label>ที่อยู่:</label> </p>
                                <p><label>พิกัด:</label> </p>
                                <p><label>เบอร์ติดต่อ:</label> </p>
                                <p><label>เว็บไซต์:</label> </p>
                                <p><label>Facebook:</label> </p>
                            </div>
                        </li>

                        <li>
                            <div class="award-list-img">
                                <div class="award-list-imgscale">Award#1</div>
                            </div>
                            <div class="award-winner-name">
                                ชื่อสถานประกอบการ
                            </div>
                            <div class="award-winner-subject">
                                <p><label>จังหวัด:</label> </p>
                                <p><label>ที่อยู่:</label> </p>
                                <p><label>พิกัด:</label> </p>
                                <p><label>เบอร์ติดต่อ:</label> </p>
                                <p><label>เว็บไซต์:</label> </p>
                                <p><label>Facebook:</label> </p>
                            </div>
                        </li>

                        <li>
                            <div class="award-list-img">
                                <div class="award-list-imgscale">Award#1</div>
                            </div>
                            <div class="award-winner-name">
                                ชื่อสถานประกอบการ
                            </div>
                            <div class="award-winner-subject">
                                <p><label>จังหวัด:</label> </p>
                                <p><label>ที่อยู่:</label> </p>
                                <p><label>พิกัด:</label> </p>
                                <p><label>เบอร์ติดต่อ:</label> </p>
                                <p><label>เว็บไซต์:</label> </p>
                                <p><label>Facebook:</label> </p>
                            </div>
                        </li>

                        <li>
                            <div class="award-list-img">
                                <div class="award-list-imgscale">Award#1</div>
                            </div>
                            <div class="award-winner-name">
                                ชื่อสถานประกอบการ
                            </div>
                            <div class="award-winner-subject">
                                <p><label>จังหวัด:</label> </p>
                                <p><label>ที่อยู่:</label> </p>
                                <p><label>พิกัด:</label> </p>
                                <p><label>เบอร์ติดต่อ:</label> </p>
                                <p><label>เว็บไซต์:</label> </p>
                                <p><label>Facebook:</label> </p>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col12">
                <div class="silver-award">
                    <h2>Thailand Tourism Awards
                </div>

                <div class="award-list">
                    <ul>
                        <li>
                            <div class="award-list-img">
                                <div class="award-list-imgscale">Award#1</div>
                            </div>
                            <div class="award-winner-name">
                                ชื่อสถานประกอบการ
                            </div>
                            <div class="award-winner-subject">
                                <p><label>จังหวัด:</label> </p>
                                <p><label>ที่อยู่:</label> </p>
                                <p><label>พิกัด:</label> </p>
                                <p><label>เบอร์ติดต่อ:</label> </p>
                                <p><label>เว็บไซต์:</label> </p>
                                <p><label>Facebook:</label> </p>
                            </div>
                        </li>

                        <li>
                            <div class="award-list-img">
                                <div class="award-list-imgscale">Award#1</div>
                            </div>
                            <div class="award-winner-name">
                                ชื่อสถานประกอบการ
                            </div>
                            <div class="award-winner-subject">
                                <p><label>จังหวัด:</label> </p>
                                <p><label>ที่อยู่:</label> </p>
                                <p><label>พิกัด:</label> </p>
                                <p><label>เบอร์ติดต่อ:</label> </p>
                                <p><label>เว็บไซต์:</label> </p>
                                <p><label>Facebook:</label> </p>
                            </div>
                        </li>

                        <li>
                            <div class="award-list-img">
                                <div class="award-list-imgscale">Award#1</div>
                            </div>
                            <div class="award-winner-name">
                                ชื่อสถานประกอบการ
                            </div>
                            <div class="award-winner-subject">
                                <p><label>จังหวัด:</label> </p>
                                <p><label>ที่อยู่:</label> </p>
                                <p><label>พิกัด:</label> </p>
                                <p><label>เบอร์ติดต่อ:</label> </p>
                                <p><label>เว็บไซต์:</label> </p>
                                <p><label>Facebook:</label> </p>
                            </div>
                        </li>

                        <li>
                            <div class="award-list-img">
                                <div class="award-list-imgscale">Award#1</div>
                            </div>
                            <div class="award-winner-name">
                                ชื่อสถานประกอบการ
                            </div>
                            <div class="award-winner-subject">
                                <p><label>จังหวัด:</label> </p>
                                <p><label>ที่อยู่:</label> </p>
                                <p><label>พิกัด:</label> </p>
                                <p><label>เบอร์ติดต่อ:</label> </p>
                                <p><label>เว็บไซต์:</label> </p>
                                <p><label>Facebook:</label> </p>
                            </div>
                        </li>

                        <li>
                            <div class="award-list-img">
                                <div class="award-list-imgscale">Award#1</div>
                            </div>
                            <div class="award-winner-name">
                                ชื่อสถานประกอบการ
                            </div>
                            <div class="award-winner-subject">
                                <p><label>จังหวัด:</label> </p>
                                <p><label>ที่อยู่:</label> </p>
                                <p><label>พิกัด:</label> </p>
                                <p><label>เบอร์ติดต่อ:</label> </p>
                                <p><label>เว็บไซต์:</label> </p>
                                <p><label>Facebook:</label> </p>
                            </div>
                        </li>

                        <li>
                            <div class="award-list-img">
                                <div class="award-list-imgscale">Award#1</div>
                            </div>
                            <div class="award-winner-name">
                                ชื่อสถานประกอบการ
                            </div>
                            <div class="award-winner-subject">
                                <p><label>จังหวัด:</label> </p>
                                <p><label>ที่อยู่:</label> </p>
                                <p><label>พิกัด:</label> </p>
                                <p><label>เบอร์ติดต่อ:</label> </p>
                                <p><label>เว็บไซต์:</label> </p>
                                <p><label>Facebook:</label> </p>
                            </div>
                        </li>

                        <li>
                            <div class="award-list-img">
                                <div class="award-list-imgscale">Award#1</div>
                            </div>
                            <div class="award-winner-name">
                                ชื่อสถานประกอบการ
                            </div>
                            <div class="award-winner-subject">
                                <p><label>จังหวัด:</label> </p>
                                <p><label>ที่อยู่:</label> </p>
                                <p><label>พิกัด:</label> </p>
                                <p><label>เบอร์ติดต่อ:</label> </p>
                                <p><label>เว็บไซต์:</label> </p>
                                <p><label>Facebook:</label> </p>
                            </div>
                        </li>

                        <li>
                            <div class="award-list-img">
                                <div class="award-list-imgscale">Award#1</div>
                            </div>
                            <div class="award-winner-name">
                                ชื่อสถานประกอบการ
                            </div>
                            <div class="award-winner-subject">
                                <p><label>จังหวัด:</label> </p>
                                <p><label>ที่อยู่:</label> </p>
                                <p><label>พิกัด:</label> </p>
                                <p><label>เบอร์ติดต่อ:</label> </p>
                                <p><label>เว็บไซต์:</label> </p>
                                <p><label>Facebook:</label> </p>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>

        </div>
    </div>    

</div>

<script>
    $(document).ready(() => {
        $('.mainsite').addClass('awardbranch');
        setTabs('#selectsec-1');
    });

    const setTabs = (tab) => {
        const htmltab = $(tab).html();
        $('.btn-selectsec').removeClass('active');
        $(tab).addClass('active');

        let temp = htmltab.split('<br>');
        let title = '<h2>' + temp[0].trim() + '</h2>'
            + temp[1].trim();

        $('.main-title-txt').html(title);
    };
</script>