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

<script>
    var ayear, atab;

    $(document).ready(() => {
        ayear = 2564;
        atab = 1;

        setAwards();
        $('.mainsite').addClass('awardotherbranch');

        $('.btn-selectsec').click(function () {
            let datatab = $(this).attr('data-tab');
            atab = datatab;
            $('.btn-selectsec').removeClass('active');
            $(this).addClass('active');
            setAwards();
            // $('.awardsection').hide();
            // $('.awardsection[data-tab="' + datatab + '"]').show().addClass('active');
        });
    });

    const syear = $('#syear');
    const awards = [
        {
            year: 2564,
            attraction: {
                title: '<h2>ประเภทแหล่งท่องเที่ยว (Attraction)</h2>',
                great: [
                    { name: 'บริษัท สกายเทร็ค แอดเวนเจอร์ จำกัด', province: 'ภูเก็ต' },
                    { name: 'สำนักงานพัฒนาพิงค์นคร (องค์การมหาชน)', province: 'เชียงใหม่' },
                    { name: 'บริษัท ทิฟฟานี่โชว์ พัทยา จำกัด', province: 'ชลบุรี' },
                    { name: 'อุทยานแห่งชาติแจ้ซ้อน', province: 'ลำปาง' },
                    { name: 'บริษัท ธนบดีเดคอร์เซรามิค จำกัด', province: 'ลำปาง' },
                    { name: 'อุทยานหลวงราชพฤกษ์', province: 'เชียงใหม่' },
                    { name: 'หอโบราณคดีเพ็ชรบูรณ์อินทราชัย', province: 'เพชรบูรณ์' },
                    { name: 'สวนสัตว์ขอนแก่น', province: 'ขอนแก่น' },
                ],
                good: [
                    { name: 'วิสาหกิจชุมชนท่องเที่ยวตำบลแหลมสัก ', province: 'กระบี่' },
                    { name: 'ศูนย์วิทยาศาสตร์และวัฒนธรรมเพื่อการศึกษาร้อยเอ็ด', province: 'ขอนแก่น' },
                ],
            },
            accommodation: {
                title: '<h2>ประเภทที่พักนักท่องเที่ยว (Accommodation)</h2>',
                great: [
                    { name: 'โรงแรมดุสิตธานี กระบี่ บีช รีสอร์ท', province: 'กระบี่' },
                    { name: 'โรงแรมเมืองสมุย สปา รีสอร์ท', province: 'สุราษฎร์ธานี' },
                    { name: 'โรงแรมพูลแมน คิง เพาเวอร์ กรุงเทพมหานคร', province: 'กทม.' },
                    { name: 'โรงแรมเอซ ออฟ หัวหิน รีสอร์ท', province: 'เพชรบุรี' },
                    { name: 'โรงแรมสยามเบย์ชอร์ พัทยา', province: 'ชลบุรี' },
                ],
                good: [
                    { name: 'โรงแรมสันธิญา เกาะพะงัน รีสอร์ท แอนด์ สปา', province: 'สุราษฎร์ธานี' },
                    { name: 'โรงแรมรอยัล เมืองสมุย วิลล่า', province: 'สุราษฎร์ธานี' },
                    { name: 'โรงแรมอนันตรา ริเวอร์ไซด์ กรุงเทพมหานคร', province: 'กทม.' },
                ]
            },
            health: {
                title: '<h2>ประเภทการท่องเที่ยวเชิงสุขภาพ (Health and Wellness Tourism)</h2>',
                great: [
                    { name: 'บันยันทรีสปา สมุย<br>(โรงแรมบันยันทรี สปา สมุย)', province: 'สุราษฎร์ธานี' },
                    { name: 'คามาลายา เกาะสมุย<br>(เวลเนส แซงชัวรี่ แอนด์ โฮลิสติก สปา)', province: 'สุราษฎร์ธานี' },
                    { name: 'บันยันทรี สปา ภูเก็ต โรงแรมบันยันทรี สปา แซงชัวรี', province: 'ภูเก็ต' },
                    { name: 'โอเอซิส เทอร์ควอยซ์ โคฟ สปา ', province: 'ภูเก็ต' },
                    { name: 'บันยันทรี สปา กรุงเทพฯ<br>(โรงแรมบันยันทรี กรุงเทพฯ)', province: 'กทม.' },
                    { name: 'ระรินจินดา เวลเนส สปา เชียงใหม่<br>(ระรินจินดา เวลเนส สปา แอนด์ ออนเซ็น เชียงใหม่)', province: 'เชียงใหม่' },
                    { name: 'ฟ้าล้านนา สปา', province: 'เชียงใหม่' },
                    { name: 'ศิรา สปา จ.เชียงใหม่', province: 'เชียงใหม่' },
                    { name: 'โอเอซิสสปา พัทยา<br>(ดิ โอเอซิส สปา พัทยา)', province: 'ชลบุรี' },
                ],
                good: []
            }
        },
        {
            year: 2562,
            attraction: {
                title: '<h2>ประเภทแหล่งท่องเที่ยว (Attraction)</h2>',
                great: [
                    { name: 'บริษัท สกายเทร็ค แอดเวนเจอร์ จำกัด', province: 'ภูเก็ต' },
                    { name: 'วิสาหกิจชุมชนท่องเที่ยวตำบลแหลมสัก ', province: 'กระบี่' },
                    { name: 'สำนักงานพัฒนาพิงค์นคร (องค์การมหาชน)', province: 'เชียงใหม่' },
                    { name: 'อุทยานแห่งชาติแจ้ซ้อน', province: 'ลำปาง' },
                    { name: 'บริษัท ธนบดีเดคอร์เซรามิค จำกัด', province: 'ลำปาง' },
                    { name: 'กลุ่มท่องเที่ยวโดยชุมชนพระบาทห้วยต้ม', province: 'ลำพูน' },
                    { name: 'จินนาลักษณ์มัลเบอร์รี่สาเปเปอร์ ', province: 'เชียงราย' },
                    { name: 'อุทยานหลวงราชพฤกษ์ ', province: 'เชียงใหม่' },
                    { name: 'หอโบราณคดีเพ็ชรบูรณ์อินทราชัย', province: 'เพชรบูรณ์' },
                    { name: 'ไร่องุ่นพีบีวัลเลย์ เขาใหญ่ ไวน์เนอร์รี่<br>(บริษัท บีบี โฮลดิ้ง จำกัด)', province: 'นครราชสีมา' },
                    { name: 'สวนสัตว์ขอนแก่น ', province: 'ขอนแก่น' },
                    { name: 'ศูนย์วิทยาศาสตร์และวัฒนธรรมเพื่อการศึกษาร้อยเอ็ด', province: 'ร้อยเอ็ด' },
                    { name: 'บริษัท ทิฟฟานี่โชว์ พัทยา จำกัด', province: 'ชลบุรี' },
                ],
                good: []
            },
            accommodation: {
                title: '<h2>ประเภทที่พักนักท่องเที่ยว (Accommodation)</h2>',
                great: [
                    { name: 'โรงแรมดุสิตธานี กระบี่ บีช รีสอร์ท', province: 'กระบี่' },
                    { name: 'โรงแรมสันธิญา เกาะพะงัน รีสอร์ท แอนด์ สปา', province: 'สุราษฎร์ธานี' },
                    { name: 'โรงแรมเดอะเชลซี', province: 'กระบี่' },
                    { name: 'โรงแรมรอยัล เมืองสมุย วิลล่า', province: 'สุราษฎร์ธานี' },
                    { name: 'โรงแรมเมืองสมุย สปา รีสอร์ท', province: 'สุราษฎร์ธานี' },
                    { name: 'โรงแรมอนันตรา ริเวอร์ไซด์ กรุงเทพมหานคร', province: 'กทม.' },
                    { name: 'โรงแรมพูลแมน คิง เพาเวอร์ กรุงเทพมหานคร', province: 'กทม.' },
                    { name: 'โรงแรมเซ็นทารา แกรนด์ บีช รีสอร์ท แอนด์ วิลลา หัวหิน', province: 'ประจวบคีรีขันธ์' },
                    { name: 'โรงแรมเอซ ออฟ หัวหิน รีสอร์ท', province: 'เพชรบุรี' },
                    { name: 'โรงแรมรติล้านนา ริเวอร์ไซด์ สปา รีสอร์ท', province: 'เชียงใหม่' },
                    { name: 'โรงแรมสยามเบย์ชอร์ พัทยา', province: 'ชลบุรี' },
                ],
                good: []
            },
            health: {
                title: '<h2>ประเภทการท่องเที่ยวเชิงสุขภาพ (Health and Wellness Tourism)</h2>',
                great: [
                    { name: 'บันยันทรีสปา สมุย<br>(โรงแรมบันยันทรี สปา สมุย)', province: 'สุราษฎร์ธานี' },
                    { name: 'คามาลายา เกาะสมุย<br>(เวลเนส แซงชัวรี่ แอนด์ โฮลิสติก สปา)', province: 'สุราษฎร์ธานี' },
                    { name: 'บันยันทรี สปา ภูเก็ต โรงแรมบันยันทรี สปา แซงชัวร', province: 'ภูเก็ต' },
                    { name: 'โอเอซิส เทอร์ควอยซ์ โคฟ สปา ', province: 'ภูเก็ต' },
                    { name: 'โอเอซิสสปากรุงเทพฯ สุขุมวิท ๓๑ /บางกอกโอเอซิส สปา กรุงเทพมหานคร', province: 'กทม.' },
                    { name: 'ระรินจินดา เวลเนส สปา เพลินจิต', province: 'กทม.' },
                    { name: 'ระรินจินดา เวลเนส สปา ราชดำริ', province: 'กทม.' },
                    { name: 'บันยันทรี สปา กรุงเทพฯ<br>(โรงแรมบันยันทรี กรุงเทพฯ)', province: 'กทม.' },
                    { name: 'ดิ โอเอซิส สปา ลานนา จังหวัดเชียงใหม่', province: 'เชียงใหม่' },
                    { name: 'ระรินจินดา เวลเนส สปา เชียงใหม่<br>(ระรินจินดา เวลเนส สปา แอนด์ ออนเซ็น เชียงใหม่)', province: 'เชียงใหม่' },
                    { name: 'ฟ้าล้านนา สปา', province: 'เชียงใหม่' },
                    { name: 'ศิรา สปา จ.เชียงใหม่', province: 'เชียงใหม่' },
                    { name: 'โรงพยาบาลเจ้าพระยาอภัยภูเบศร<br>(ศูนย์ฝึกอบรมอภัยภูเบศร เดย์ สปา)', province: 'ปราจีนบุรี' },
                    { name: 'โอเอซิสสปา พัทยา<br>(ดิ โอเอซิส สปา พัทยา)', province: 'ชลบุรี' },
                ],
                good: []
            },
        },
        {
            year: 2560,
            attraction: {
                title: '<h2>ประเภทแหล่งท่องเที่ยว (Attraction)</h2>',
                great: [
                    { name: 'บริษัท สกายเทร็ค แอดเวนเจอร์ จำกัด', province: 'ภูเก็ต' },
                    { name: 'สำนักงานพัฒนาพิงค์นคร (องค์การมหาชน)', province: 'เชียงใหม่' },
                    { name: 'ศูนย์วิทยาศาสตร์และวัฒนธรรมเพื่อการศึกษาร้อยเอ็ด', province: 'ร้อยเอ็ด' },
                    { name: 'บริษัท ทิฟฟานี่โชว์ พัทยา จำกัด', province: 'ชลบุรี' },
                ],
                good: [
                    { name: 'อุทยานแห่งชาติแจ้ซ้อน', province: 'ลำปาง' },
                    { name: 'บริษัท ธนบดีเดคอร์เซรามิค จำกัด', province: 'ลำปาง' },
                    { name: 'กลุ่มท่องเที่ยวโดยชุมชนพระบาทห้วยต้ม', province: 'ลำพูน' },
                    { name: 'ไร่องุ่นพีบีวัลเลย์ เขาใหญ่ ไวน์เนอร์รี่<br>(บริษัท บีบี โฮลดิ้ง จำกัด)', province: 'นครราชสีมา' },
                    { name: 'สวนสัตว์ขอนแก่น ', province: 'ขอนแก่น' },
                ]
            },
            accommodation: {
                title: '<h2>ประเภทที่พักนักท่องเที่ยว (Accommodation)</h2>',
                great: [
                    { name: 'โรงแรมรติล้านนา ริเวอร์ไซด์ สปา รีสอร์ท', province: 'เชียงใหม่' },
                    { name: 'โรงแรมสยามเบย์ชอร์ พัทยา', province: 'ชลบุรี' },
                ],
                good: [
                    { name: 'โรงแรมดุสิตธานี กระบี่ บีช รีสอร์ท', province: 'กระบี่' },
                    { name: 'โรงแรมสันธิญา เกาะพะงัน รีสอร์ท แอนด์ สปา', province: 'สุราษฎร์ธานี' },
                    { name: 'โรงแรมเซ็นทารา แกรนด์ บีช รีสอร์ท แอนด์ วิลลา หัวหิน', province: 'ประจวบคีรีขันธ์' },
                ]
            },
            health: {
                title: '<h2>ประเภทการท่องเที่ยวเชิงสุขภาพ (Health and Wellness Tourism)</h2>',
                great: [
                    { name: 'บันยันทรีสปา สมุย<br>(โรงแรมบันยันทรี สปา สมุย)', province: 'สุราษฎร์ธานี' },
                    { name: 'บันยันทรี สปา ภูเก็ต โรงแรมบันยันทรี สปา แซงชัวรี', province: 'ภูเก็ต' },
                    { name: 'โอเอซิส เทอร์ควอยซ์ โคฟ สปา ', province: 'ภูเก็ต' },
                    { name: 'โอเอซิสสปากรุงเทพฯ สุขุมวิท ๓๑ /บางกอกโอเอซิส สปา กรุงเทพมหานคร', province: 'กทม.' },
                    { name: 'บันยันทรี สปา กรุงเทพฯ<br>(โรงแรมบันยันทรี กรุงเทพฯ)', province: 'กทม.' },
                    { name: 'ดิ โอเอซิส สปา ลานนา จังหวัดเชียงใหม่', province: 'เชียงใหม่' },
                    { name: 'ระรินจินดา เวลเนส สปา เชียงใหม่<br>(ระรินจินดา เวลเนส สปา แอนด์ ออนเซ็น เชียงใหม่)', province: 'เชียงใหม่' },
                    { name: 'ฟ้าล้านนา สปา', province: 'เชียงใหม่' },
                    { name: 'โรงพยาบาลเจ้าพระยาอภัยภูเบศร<br>(ศูนย์ฝึกอบรมอภัยภูเบศร เดย์ สปา)', province: 'ปราจีนบุรี' },
                    { name: 'โอเอซิสสปา พัทยา<br>(ดิ โอเอซิส สปา พัทยา)', province: 'ชลบุรี' },
                ],
                good: [
                    { name: 'ระรินจินดา เวลเนส สปา เพลินจิต', province: 'กทม.' },
                    { name: 'ศิรา สปา จ.เชียงใหม่', province: 'เชียงใหม่' },
                ]
            },
        },
        {
            year: 2558,
            attraction: {
                title: '<h2>ประเภทแหล่งท่องเที่ยว (Attraction)</h2>',
                great: [
                    { name: 'ไร่องุ่นพีบีวัลเลย์ เขาใหญ่ ไวน์เนอร์รี่<br>(บริษัท บีบี โฮลดิ้ง จำกัด)', province: 'นครราชสีมา' },
                ],
                good: [
                    { name: 'บริษัท สกายเทร็ค แอดเวนเจอร์ จำกัด', province: 'ภูเก็ต' },
                    { name: 'สำนักงานพัฒนาพิงค์นคร (องค์การมหาชน)', province: 'เชียงใหม่' },
                    { name: 'กลุ่มท่องเที่ยวโดยชุมชนพระบาทห้วยต้ม', province: 'ลำพูน' },
                ]
            },
            accommodation: {
                title: '<h2>ประเภทที่พักนักท่องเที่ยว (Accommodation)</h2>',
                great: [
                    { name: 'โรงแรมสันธิญา เกาะพะงัน รีสอร์ท แอนด์ สปา', province: 'สุราษฎร์ธานี' },
                    { name: 'โรงแรมอนันตรา ริเวอร์ไซด์ กรุงเทพมหานคร', province: 'กทม.' },
                    { name: 'โรงแรมเซ็นทารา แกรนด์ บีช รีสอร์ท แอนด์ วิลลา หัวหิน', province: 'ประจวบคีรีขันธ์' },
                    { name: 'โรงแรมรติล้านนา ริเวอร์ไซด์ สปา รีสอร์ท', province: 'เชียงใหม่' },                    
                ],
                good: [
                    { name: 'โรงแรมสยามเบย์ชอร์ พัทยา', province: 'ชลบุรี' },
                ]
            },
            health: {
                title: '<h2>ประเภทการท่องเที่ยวเชิงสุขภาพ (Health and Wellness Tourism)</h2>',
                great: [
                    { name: 'โอเอซิสสปากรุงเทพฯ สุขุมวิท ๓๑ /บางกอกโอเอซิส สปา กรุงเทพมหานคร', province: 'กทม.' },
                    { name: 'บันยันทรี สปา กรุงเทพฯ  (โรงแรมบันยันทรี กรุงเทพฯ)', province: 'กทม.' },
                    { name: 'ดิ โอเอซิส สปา ลานนา จังหวัดเชียงใหม่', province: 'เชียงใหม่' },
                    { name: 'โรงพยาบาลเจ้าพระยาอภัยภูเบศร<br>(ศูนย์ฝึกอบรมอภัยภูเบศร เดย์ สปา)', province: 'ปราจีนบุรี' },
                ],
                good: [
                    { name: 'บันยันทรีสปา สมุย (โรงแรมบันยันทรี สปา สมุย)', province: 'สุราษฎร์ธานี' },
                    { name: 'คามาลายา เกาะสมุย (เวลเนส แซงชัวรี่ แอนด์ โฮลิสติก สปา)', province: 'สุราษฎร์ธานี' },
                    { name: 'บันยันทรี สปา ภูเก็ต โรงแรมบันยันทรี สปา แซงชัวรี', province: 'ภูเก็ต' },
                    { name: 'ระรินจินดา เวลเนส สปา เชียงใหม่<br>(ระรินจินดา เวลเนส สปา แอนด์ ออนเซ็น เชียงใหม่)', province: 'เชียงใหม่' },
                ]
            },
        },
        {
            year: 2556,
            attraction: {
                title: '<h2>ประเภทแหล่งท่องเที่ยว (Attraction)</h2>',
                great: [],
                good: [
                    { name: 'สำนักงานพัฒนาพิงค์นคร (องค์การมหาชน)', province: 'เชียงใหม่' },
                    { name: 'อุทยานแห่งชาติแจ้ซ้อน', province: 'ลำปาง' },
                    { name: 'ไร่องุ่นพีบีวัลเลย์ เขาใหญ่ ไวน์เนอร์รี่<br>(บริษัท บีบี โฮลดิ้ง จำกัด)', province: 'นครราชสีมา' },
                    { name: 'บริษัท ทิฟฟานี่โชว์ พัทยา จำกัด', province: 'ชลบุรี' },
                ]
            },
            accommodation: {
                title: '<h2>ประเภทที่พักนักท่องเที่ยว (Accommodation)</h2>',
                great: [
                    { name: 'โรงแรมสันธิญา เกาะพะงัน รีสอร์ท แอนด์ สปา', province: 'สุราษฎร์ธานี' },                                        
                ],
                good: [
                    { name: 'โรงแรมอนันตรา ริเวอร์ไซด์ กรุงเทพมหานคร', province: 'กทม.' },
                    { name: 'โรงแรมพูลแมน คิง เพาเวอร์ กรุงเทพมหานคร', province: 'กทม.' },
                    { name: 'โรงแรมเซ็นทารา แกรนด์ บีช รีสอร์ท แอนด์ วิลลา หัวหิน', province: 'ประจวบคีรีขันธ์' },
                    { name: 'โรงแรมรติล้านนา ริเวอร์ไซด์ สปา รีสอร์ท', province: 'เชียงใหม่' },
                    { name: 'โรงแรมสยามเบย์ชอร์ พัทยา', province: 'ชลบุรี' },
                ]
            },
            health: {
                title: '<h2>ประเภทการท่องเที่ยวเชิงสุขภาพ (Health and Wellness Tourism)</h2>',
                great: [],
                good: [
                    { name: 'บันยันทรีสปา สมุย (โรงแรมบันยันทรี สปา สมุย)', province: 'สุราษฎร์ธานี' },
                    { name: 'คามาลายา เกาะสมุย (เวลเนส แซงชัวรี่ แอนด์ โฮลิสติก สปา)', province: 'สุราษฎร์ธานี' },
                    { name: 'บันยันทรี สปา ภูเก็ต โรงแรมบันยันทรี สปา แซงชัวรี', province: 'ภูเก็ต' },
                    { name: 'โอเอซิสสปากรุงเทพฯ สุขุมวิท ๓๑ /บางกอกโอเอซิส สปา กรุงเทพมหานคร', province: 'กทม.' },
                    { name: 'ดิ โอเอซิส สปา ลานนา จังหวัดเชียงใหม่', province: 'เชียงใหม่' },
                ]
            },
        }
    ];

    syear.change(() => {
        ayear = syear.val();
        setAwards();
    });

    const setAwards = () => {
        const award = awards.find(el =>  el.year == ayear);
        let list,
            li_ga = li_sa = '';
         
        if(Number(atab) == 1) list = award.attraction;
        else if(Number(atab) == 2) list = award.accommodation;
        else list = award.health;

        $.each(list.great,(k,v) => {
            li_ga += '<li>'+v.name+' จังหวัด '+v.province+'</li>';
        });

        $.each(list.good,(k,v) => {
            li_sa += '<li>'+v.name+' จังหวัด '+v.province+'</li>';
        });

        $('.txt-banner').html('<h2>ผลงานที่ได้รับรางวัล ปี '+ayear+'</h2>');
        $('.main-title-txt').html(list.title);
        $('#gold-award-list').html(li_ga);
        $('#silver-award-list').html(li_sa);
    }
</script>