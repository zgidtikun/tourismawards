<div id="header">
   <div id="header-inner">

      <div class="header-box">
         <div class="header-box-row login_list">
            <div class="header-box-col">
               <ul>
                  <?php if(!session()->get('isLoggedIn')) : ?>
                  <li>
                     <a href="<?=route_to('register')?>" title="ลงทะเบียน">
                        <picture>
                           <source srcset="<?=base_url('assets/images/register.png')?>">
                           <source srcset="<?=base_url('assets/images/register.svg')?>">
                           <img src="<?=base_url('assets/images/register.png')?>" alt="...">
                        </picture> ลงทะเบียน
                     </a>
                  </li>
                  <li>
                     <a href="<?=route_to('login')?>" title="เข้าสู่ระบบ">
                        <picture>
                           <source srcset="<?=base_url('assets/images/login.png')?>">
                           <source srcset="<?=base_url('assets/images/login.svg')?>">
                           <img src="<?=base_url('assets/images/login.png')?>" alt="...">
                        </picture> เข้าสู่ระบบ
                     </a>
                  </li>
                  <?php else : ?>
                  <li>
                     <a href="<?=base_url('frontend/application')?>" title="Profile">
                        <picture>
                           <source srcset="<?=base_url('assets/images/register.png')?>">
                           <source srcset="<?=base_url('assets/images/register.svg')?>">
                           <img src="<?=base_url('assets/images/register.png')?>" alt="...">
                        </picture> สวัสดี, <?=session()->get('user')?>
                     </a>
                  </li>
                  <li>
                     <a href="<?=route_to('auth/logout')?>" title="ออกจากระบบ">
                        <picture>
                           <source srcset="<?=base_url('assets/images/login.png')?>">
                           <source srcset="<?=base_url('assets/images/login.svg')?>">
                           <img src="<?=base_url('assets/images/login.png')?>" alt="...">
                        </picture> ออกจากระบบ
                     </a>
                  </li>
                  <?php endif; ?>
                  <li class="social_login">
                     <a href="https://www.facebook.com/ThailandTourismAwardsNew" title="facebook" target="_blank">
                        <picture>
                           <source srcset="<?=base_url('assets/images/fb.png')?>">
                           <source srcset="<?=base_url('assets/images/fb.svg')?>">
                           <img src="<?=base_url('assets/images/fb.png')?>" alt="...">
                        </picture>
                     </a>
                  </li>
               </ul>
            </div>
         </div>
         <div class="header-box-row menulist">
            <div class="header-box-col logo">
               <a href="<?=route_to('home')?>">
                  <picture>
                     <source srcset="<?=base_url('assets/images/logo.svg')?>">
                     <source srcset="<?=base_url('assets/images/logo.png')?>">
                     <img src="<?=base_url('assets/images/logo.png')?>" width="514" height="200" alt="logo">
                  </picture>
               </a>
            </div>
            <div class="header-box-col menu">
               <nav>
                  <ul class="flexnav">
                     <li><a id="menu-home" href="<?=route_to('home')?>">หน้าแรก</a></li>
                     <li><a href="javascript:void(0)" id="aboutmenu">เกี่ยวกับโครงการ</a>
                        <ul>
                           <li><a href="javascript:void(0);">ข้อมูลโครงการฯ /ความเป็นมา/วัตถุประสงค์</a></li>
                           <li><a href="javascript:void(0);">กรรมการที่ปรึกษา</a></li>
                           <li><a href="javascript:void(0);">กรรมการตัดสินแต่ละประเภท</a></li>
                        </ul>
                     </li>
                     <li><a href="javascript:void(0)" id="informationmenu">ข้อมูลการประกวดรางวัล</a>
                        <ul>
                           <li><a href="javascript:void(0);">แหล่ง ท่องท่องเที่ยว 6 สาขา</a></li>
                           <li><a href="javascript:void(0);">ที่พักนักท่องเที่ยว 4 สาขา</a></li>
                           <li><a href="javascript:void(0);">การท่องเที่ยวเชิงสุขภาพ 4 สาขา</a></li>
                           <li><a href="javascript:void(0);">รายการนำเที่ยว</a></li>
                           <li><a href="javascript:void(0);">เกณฑ์การให้คะแนนตัดสิน</a></li>
                           <li><a href="javascript:void(0);">สิทธิประโยชน์สำหรับผู้ที่ได้รับรางวัล</a></li>
                        </ul>
                     </li>
                     <li><a href="javascript:void(0)" id="regismenu">คู่มือการสมัคร</a>
                        <ul>
                           <li><a href="javascript:void(0);">คู่มือการลงทะเบียนประกวดรางวัล</a></li>
                           <li><a href="javascript:void(0);">กำหนดการรับสมัคร</a></li>
                           <li><a href="javascript:void(0);">สมัครเข้าร่วมประกวดรางวัล</a></li>
                           <li><a href="javascript:void(0);">เกณฑ์การให้คะแนนตัดสิน</a></li>
                        </ul>
                     </li>
                     <li><a href="javascript:void(0)" id="awardmenu">ผลงานที่ได้รับรางวัล</a>
                        <ul>
                           <li><a href="javascript:void(0);">ครั้งที่ 14</a></li>
                           <li><a href="javascript:void(0);">ครั้งที่ 13</a></li>
                           <li><a href="javascript:void(0);">ครั้งที่ 12</a></li>
                           <li><a href="javascript:void(0);">ครั้งที่ 11</a></li>
                        </ul>
                     </li>
                     <li><a href="javascript:void(0)" id="newsmenu">ข่าวประชาสัมพันธ์</a>
                        <!-- <ul>
                           <li><a href="javascript:void(0);">บทความข่าวสารที่เกี่ยวข้องกับโครงการฯ</a></li>
                           <li><a href="javascript:void(0);">ภาพถ่าย</a></li>
                           <li><a href="javascript:void(0);">วิดีโอ</a></li>
                           <li><a href="javascript:void(0);">E-Book</a></li>
                        </ul> -->
                     </li>
                     <li><a href="javascript:void(0)" id="contactmenu">ติดต่อเรา</a>
                        <!-- <ul>
                           <dt>ข้อมูลการติดต่อโครงการฯ </dt>
                           <li><a href="javascript:void(0);">ที่อยู่ – แผนที่ google map</a></li>
                           <li><a href="javascript:void(0);">เบอร์โทรศัพท์</a></li>
                           <li><a href="javascript:void(0);">อีเมล</a></li>
                           <li><a href="javascript:void(0);">Facebook</a></li>
                           <li><a href="javascript:void(0);">Line</a></li>
                        </ul> -->
                     </li>
                     <li class="search">
                        <a href="javascript:void(0)">
                           <picture>
                              <source srcset="<?= base_url('assets/images/search_btn.png')?>">
                              <source srcset="<?= base_url('assets/images/search_btn.svg')?>">
                              <img src="<?= base_url('assets/images/search_btn.png')?>" alt="...">
                           </picture>
                        </a>
                     </li>
                  </ul>
               </nav>
            </div>            
            <div class="header-box-col mobilemenu">
               <a href="javascript:void(0)" class="btn-menu">
                  <svg style="width:34px;height:34px" viewBox="0 0 24 24">
                     <path fill="#FFFFFF" d="M3,6H21V8H3V6M3,11H21V13H3V11M3,16H21V18H3V16Z" />
                  </svg>
               </a>
            </div>            

            <div class="menubox">
               <a href="javascript:void(0)" class="menuclose">
                  <picture>
                     <source srcset="<?= base_url('assets/images/btnclose.svg')?>">
                     <img src="<?= base_url('assets/images/btnclose.png')?>">
                  </picture>
               </a>
               <div class="menulogo">
                  <picture>
                     <source srcset="<?= base_url('assets/images/logo.svg')?>">
                     <img src="<?= base_url('assets/images/logo.png')?>">
                  </picture>
               </div>
               <ul>
                  <li><a href="<?=route_to('home')?>">หน้าแรก</a></li>
                  <li><a href="javascript:void(0);">เกี่ยวกับโครงการ</a></li>
                  <li><a href="javascript:void(0);">ข้อมูลการประกวดรางวัล</a></li>
                  <li><a href="javascript:void(0);">คู่มือประกวดรางวัล</a></li>
                  <li><a href="javascript:void(0);">คู่มือการสมัคร</a></li>
                  <li><a href="javascript:void(0);">ผลงานที่ได้รับรางวัล</a></li>
                  <li><a href="javascript:void(0);">ข่าวประชาสัมพันธ์</a></li>
                  <li><a href="javascript:void(0);">ติดต่อเรา</a></li>
                  <li><a href="javascript:void(0);">ค้นหา</a></li>
               </ul>
            </div>
         </div>
      </div>

   </div>
</div>

<script>
   jQuery(document).ready(function() {

      $('.btn-menu').click(function () {
         if ($('.menubox').hasClass('active')) {
            $('body').removeClass('overlay');
            $('.menubox').removeClass('active');
         } else {
            $('body').addClass('overlay');
            $('.menubox').addClass('active');
         }
      });

      $('.menuclose').click(function () {
         $('body').removeClass('overlay');
         $('.menubox').removeClass('active');
      });

   });
   
   $(".flexnav").flexNav();
</script>