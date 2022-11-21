<div class="banner-box">

    <div class="txt-banner">
        <h2><?=$new->title?></h2>
    </div>

</div>

<div class="container">
    <div class="container_box">
        <div class="row">
            <div class="col12">
                <div class="news-content">
                    <div class="news-content-img">
                        <img src="<?=base_url('uploads/news/images/'.$new->image_cover)?>">
                    </div>
                    <div class="news-subject">
                        <div class="news-name">
                            <i class="bi bi-calendar"></i> <?=$new->publish_start?>
                        </div>
                        <div class="news-date">
                            <i class="bi bi-person-fill"></i> <?=$new->created_by?>
                        </div>
                    </div>
                    <div class="news-content-txt">
                        <?=$new->description?>
                    </div>
                    <div class="news-content-social">
                        <a href="javascript:;"><i class="bi bi-facebook"></i></a>
                        <a href="javascript:;"><i class="bi bi-twitter"></i></a>
                        <a href="javascript:;"><i class="bi bi-google"></i></a>
                    </div>
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