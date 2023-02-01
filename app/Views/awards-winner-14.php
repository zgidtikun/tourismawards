<style>    
.certificate-award{
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
<div class="banner-box" data-id="<?=$main->id?>">

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
                            data-id="<?=$value->id?>"
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
                    <ul id="list-gold-award">
                    </ul>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col12">
                <div class="silver-award">
                    <h2>Thailand Tourism Silver Awards
                </div>

                <div class="award-list">
                    <ul id="list-silver-award">
                    </ul>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col12">
                <div class="certificate-award">
                    <h2>Thailand Tourism Certificate
                </div>

                <div class="award-list">
                    <ul id="list-certificate-award">
                    </ul>
                </div>
            </div>

        </div>
    </div>    

</div>

<script src="<?=base_url('assets/js/frontend/other.js')?>"></script>
<script>
    var dataset;
    const lga = $('#list-gold-award');
    const lsa = $('#list-silver-award');
    const lca = $('#list-certificate-award');

    $(document).ready(() => {
        $('.mainsite').addClass('awardbranch');
        setTabs('#selectsec-1');
    });

    const setTabs = async(tab) => {
        const htmltab = $(tab).html();
        const typeId = $('.banner-box').attr('data-id');
        const subId = $(tab).attr('data-id');
        const temp = htmltab.split('<br>');
        const title = `<h2>${temp[0].trim()}</h2>${temp[1].trim()}`;

        $('.btn-selectsec').removeClass('active');
        $(tab).addClass('active');
        $('.main-title-txt').html(title);   
        
        await setListDefault();
        <?php if(!$duedate) : ?>        
        return;
        <?php endif; ?>
        const awards = await getAward(typeId,subId);

        let content_g = '',
            content_s = '',
            content_c = '';
        
        if(awards.gold.length > 0){
            $.each(awards.gold,(gk, gv) => {
                content_g += setListContent(gv);
            });
        }
        
        if(awards.silver.length > 0){
            $.each(awards.silver,(sk, sv) => {
                content_s += setListContent(sv);
            });
        }
        
        if(awards.certificate.length > 0){
            $.each(awards.certificate,(sk, sv) => {
                content_c += setListContent(sv);
            });
        }

        lga.html(content_g);
        lsa.html(content_s);
        lca.html(content_c);
    };

    const setListDefault = () => {
        return new Promise(function(resolve, reject){
            const cs = 4;
            let counter = 0,
                content = '';
            
            while(counter < cs){
                content += setListContent({ place_name: 'ชื่อสถานประกอบการ', province: '', address: '', gps: '', mobile: '', web: '', fb: '' });
                counter++;
            }
            
            lga.html(content);
            lsa.html(content);
            lca.html(content);

            resolve({result: true});
        });
    }

    const getAward = (typeId,subId) => {
        return new Promise(function(resolve, reject){            
            $.ajax({
                type: 'post',
                url: '<?=base_url('get-awards-winner')?>',
                async: false,
                data: {
                    type: typeId,
                    sub: subId
                },
                dataType: 'json',
                success: response => {
                    resolve(response);
                }
            });
        });
    }

    const setListContent = (data) => {
        const file_position = 'registerImages';
        const files = [];
        let img = '';

        $.each(data.pack_file,(key,file) => {
            if(file.file_position == file_position){
                files.push(`${getBaseUrl()}/${file.file_path}`);
            }
        });
        console.log(files);
        if(!empty(files)){
            img = `<img src="${files[0]}">`;
        } else {
            img = 'Award#1';
        }

        return (
            `<li>
                <div class="award-list-img">
                    <div class="award-list-imgscale">${img}</div>
                </div>
                <div class="award-winner-name">
                    ${data.place_name}
                </div>
                <div class="award-winner-subject">
                    <p><label>จังหวัด: ${data.province}</label> </p>
                    <p><label>ที่อยู่: ${data.address}</label> </p>
                    <p><label>พิกัด: ${data.gps}</label> </p>
                    <p><label>เบอร์ติดต่อ: ${data.mobile}</label> </p>
                    <p><label>เว็บไซต์: ${data.web}</label> </p>
                    <p><label>Facebook: ${data.fb}</label> </p>
                </div>
            </li>`
        );

    }
</script>