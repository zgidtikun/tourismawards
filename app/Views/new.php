<div class="banner-box">

    <div class="txt-banner">
        <h2>ข่าวประชาสัมพันธ์</h2>
    </div>

</div>

<div class="container">
    <div class="container_box">
        <div class="row">
            <div class="col12">
                <div class="news-list">
                    <ul>
                    <?php foreach($news as $key=>$new){ ?>
                        <li>
                            <div class="news-col">
                                <div class="news-img">
                                    <div class="news-imgscale">
                                        <a href="<?=base_url('new/'.$new->id)?>">
                                            <img src="<?=base_url('uploads/news/images/'.$new->image_cover)?>">
                                        </a>
                                    </div>
                                </div>
                                <div class="news-subject">
                                    <div class="news-name">
                                        <i class="bi bi-calendar"></i> <?=$new->publish_start?>
                                    </div>
                                    <div class="news-date">
                                        <i class="bi bi-person-fill"></i> <?=$new->created_by?>
                                    </div>
                                </div>
                                <div class="news-txt">
                                    <a href="<?=base_url('new/'.$new->id)?>">
                                        <?=$new->title?>
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(() => {
        $('.mainsite').addClass('news');
    });
</script>