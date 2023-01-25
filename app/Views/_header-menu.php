<div id="header">
   <div id="header-inner">

      <div class="header-box">
         <div class="header-box-row regisform login_list">
            <div class="header-box-col">
               <ul>
                  <?php
                     if (!session()->get('isLoggedIn')):
                        $_app = new \Config\App();
                        $_register_expire = date('Y-m-d') > $_app->Register_expired;
                        if (!$_register_expire):
                        ?>
	                        <li class="nonlogin">
	                           <a href="<?=base_url('register')?>" title="ลงทะเบียน">
	                              <i class="bi bi-person-circle"></i>&nbsp;&nbsp;ลงทะเบียน
	                           </a>
	                        </li>
	                     <?php endif;?>
                     <li class="nonlogin">
                        <a href="<?=base_url('login')?>" title="เข้าสู่ระบบ">
                           <i class="bi bi-box-arrow-in-right"></i>&nbsp;&nbsp;เข้าสู่ระบบ
                        </a>
                     </li>
                  <?php else: ?>
                     <li class="userlogin">
                        <a href="javascript:void(0);" class="btn-noti">
                           <i class="bi bi-bell-fill"></i>
                           <span class="noti-alert"></span>
                        </a>
                        <div class="noti-box" style="display: none;">
                           <div class="noti-box-overlay"></div>
                           <div class="noti-box-content">
                              <div class="noti-box-title">
                                 การแจ้งเตือน
                                 <a href="javascript:void(0);" class="noti-box-close">
                                    <i class="bi bi-x"></i>
                                 </a>
                              </div>
                              <div class="noti-box-txt">
                                 <ul id="noti-list">
                                 </ul>
                              </div>
                              <div class="noti-box-footer">
                                 <a href="<?=base_url('notification')?>" class="link">
                                    ดูการแจ้งเตือนทั้งหมด
                                 </a>
                              </div>
                           </div>
                        </div>
                     </li>
                     <li class="userlogin">
                        <a href="javascript:void(0)" class="btn-user">
                           <?=session()->get('user')?>&nbsp;&nbsp;
                           <i class="bi bi-person-circle ml-2"></i>
                        </a>
                        <div class="user-box" style="display: none;">
                           <div class="user-box-overlay"></div>
                           <div class="user-box-content">
                              <div class="user-box-title">
                                 ผู้ใช้งาน <a href="javascript:void(0)" class="user-box-close">
                                    <i class="bi bi-x"></i>
                                 </a>
                              </div>
                              <div class="user-box-txt">
                                 <div class="user-status">
                                    <div class="user-status-img">
                                       <div class="status-img">
                                          <div class="status-img-scale">
                                             <img id="header-img-profile" src="<?=base_url(session()->get('profile'))?>">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="user-status-txt">
                                       <p class="username"><?=session()->get('user')?></p>
                                       <p class="useridentity">
                                          <?php if (session()->get('role') == 1): ?>
                                             ผู้ประกอบการ
                                          <?php elseif (session()->get('role') == 2): ?>
                                             เจ้าหน้าที่ ททท.
                                          <?php elseif (session()->get('role') == 3): ?>
                                             คณะกรรมการ
                                          <?php else: ?>
                                             ผู้ดูแลระบบ
                                          <?php endif;?>
                                       </p>
                                       <p class="usermail"><?=session()->get('account')?></p>
                                       <a href="<?=base_url('auth/logout')?>" class="userlogout">ออกจากระบบ</a>
                                    </div>
                                 </div>
                                 <div class="user-profile">
                                    <?php
                                       if (in_array(session()->get('role'), [1, 3])):
                                          // $user_obj = new \App\Models\Users();
                                          // $user = $user_obj->where('id',session()->get('id'))
                                          // ->select('verify_code')
                                          // ->first();
                                          // $new_pass_token = urlencode($user->verify_code.session()->get('id'));
                                       ?>
	                                       <a href="<?=base_url('profile')?>" class="mb-1">
	                                          <i class="bi bi-person-fill"></i>
	                                          &nbsp;&nbsp;ข้อมูลส่วนตัว
	                                       </a>
	                                       <?php
                                             if (session()->get('role') == 1) {
                                                if (session()->get('stage') == 1) {
                                                      $url = 'awards/application';
                                                } elseif (session()->get('stage') == 2) {
                                                   $url = 'awards/pre-screen';
                                                } elseif (session()->get('stage') == 3) {
                                                   $url = 'awards/result';
                                                } else {
                                                   $url = 'awards/application';
                                                }

                                                $content = 'ข้อมูลใบสมัคร';
                                                $manual = base_url('download/tycoon_manual.pdf');
                                             } else {
                                                $url = 'boards';
                                                $content = 'การประเมิน';
                                                $manual = base_url('download/judge_manual.pdf');
                                             }
                                       ?>
                                       <a href="<?=base_url($url)?>" class="mb-1">
                                          <i class="bi bi-award-fill"></i>
                                          &nbsp;&nbsp;<?=$content?>
                                       </a>
                                       <a href="<?=base_url('new-password')?>" class="mb-1">
                                          <i class="bi bi-key-fill"></i>
                                          &nbsp;&nbsp;เปลี่ยนรหัสผ่านใหม่
                                       </a>
                                       <a href="<?=$manual?>" target="_blank" class="mb-1" class="mb-1">
                                          <i class="bi bi-cloud-arrow-down-fill"></i>
                                          &nbsp;&nbsp;ดาวน์โหลดคู่มือการใช้งาน
                                       </a>
                                    <?php else: ?>
                                       <a href="administrator/dashboard" class="mb-1">
                                          <i class="bi bi-file-bar-graph-fill"></i>
                                          &nbsp;&nbsp;Dashboard
                                       </a>
                                    <?php endif;?>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </li>
                  <?php endif;?>
                  <li class="social_login">
                     <a href="https://www.facebook.com/ThailandTourismAwardsNew" title="facebook" target="_blank">
                        <i class="bi bi-facebook"></i>
                     </a>
                  </li>
               </ul>
            </div>
         </div>
         <div class="header-box-row menulist">
            <div class="header-box-col logo">
               <a href="<?=base_url('home')?>">
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
                     <li><a id="menu-home" href="<?=base_url('home')?>">หน้าแรก</a></li>
                     <li><a href="javascript:void(0)" id="aboutmenu">เกี่ยวกับโครงการ</a>
                        <ul>
                           <li><a href="<?=base_url('about-us')?>">ข้อมูลโครงการฯ /ความเป็นมา/วัตถุประสงค์</a></li>
                           <li><a href="<?=base_url('judge')?>">กรรมการที่ปรึกษา</a></li>
                           <li><a href="<?=base_url('judge')?>">กรรมการตัดสินแต่ละประเภท</a></li>
                        </ul>
                     </li>
                     <li><a href="javascript:void(0)" id="informationmenu">ข้อมูลการประกวดรางวัล</a>
                        <ul>
                           <li><a href="<?=base_url('awards-infomation')?>?p=Attraction">แหล่งท่องท่องเที่ยว 6 สาขา</a></li>
                           <li><a href="<?=base_url('awards-infomation')?>?p=Accommodation">ที่พักนักท่องเที่ยว 4 สาขา</a></li>
                           <li><a href="<?=base_url('awards-infomation')?>?p=HealthAndWellness">การท่องเที่ยวเชิงสุขภาพ 4 สาขา</a></li>
                           <li><a href="<?=base_url('awards-infomation')?>?p=TourProgram">รายการนำเที่ยว</a></li>
                           <li><a href="<?=base_url('awards-infomation')?>?p=Judge">เกณฑ์การให้คะแนนตัดสิน</a></li>
                           <li><a href="<?=base_url('awards-infomation')?>?p=Benefits">สิทธิประโยชน์สำหรับผู้ที่ได้รับรางวัล</a></li>
                        </ul>
                     </li>
                     <li><a href="javascript:void(0)" id="regismenu">คู่มือการสมัคร</a>
                        <ul>
                           <li><a href="<?=base_url('application-guide')?>?p=manual">คู่มือการลงทะเบียนประกวดรางวัล</a></li>
                           <li><a href="<?=base_url('application-guide')?>?p=duedate">กำหนดการรับสมัคร</a></li>
                           <li><a href="<?=base_url('application-guide')?>?p=register">สมัครเข้าร่วมประกวดรางวัล</a></li>
                        </ul>
                     </li>
                     <li><a href="javascript:void(0)" id="awardmenu">ผลงานที่ได้รับรางวัล</a>
                        <ul>
                           <!-- <li><a href="<?=base_url('awards-winner')?>">ครั้งที่ 14</a></li> -->
                           <li><a href="<?=base_url('awards-winner-13')?>">ครั้งที่ 13</a></li>
                        </ul>
                     </li>
                     <li>
                        <a href="<?=base_url('new')?>" id="newsmenu">ข่าวประชาสัมพันธ์</a>
                     </li>
                     <li><a href="<?=base_url('contact-us')?>" id="contactmenu">ติดต่อเรา</a>
                     </li>
                     <!-- <li class="search">
                        <a href="javascript:void(0)">
                           <i class="bi bi-search"></i>
                        </a>
                     </li> -->
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
               <a href="javascript:void(0)" class="menuclose"><i class="bi bi-x"></i></a>
               <div class="menulogo">
                  <picture>
                     <source srcset="https://www.tennis.in.th/assets/images/logo.svg">
                     <img src="https://www.tennis.in.th/assets/images/logo.png">
                  </picture>
               </div>
               <ul>
                  <li><a href="<?=base_url('home')?>">หน้าแรก</a></li>
                  <li><a href="javascript:" class="btn-submenu" data-tab="1">เกี่ยวกับโครงการ</a></li>
                  <div class="submenubox-list" data-tab="1" style="display: none;">
                     <ul>
                        <li><a href="<?=base_url('about-us')?>">ข้อมูลโครงการฯ /ความเป็นมา/วัตถุประสงค์</a></li>
                        <li><a href="<?=base_url('judge')?>">กรรมการที่ปรึกษา</a></li>
                        <li><a href="<?=base_url('judge')?>">กรรมการตัดสินแต่ละประเภท</a></li>
                     </ul>

                  </div>
                  <li><a href="javascript:" data-tab="2" class="btn-submenu">ข้อมูลการประกวดรางวัล</a></li>
                  <div class="submenubox-list" data-tab="2" style="display: none;">
                     <ul>
                        <li><a href="<?=base_url('awards-infomation')?>?p=Attraction">แหล่งท่องท่องเที่ยว 6 สาขา</a></li>
                        <li><a href="<?=base_url('awards-infomation')?>?p=Accommodation">ที่พักนักท่องเที่ยว 4 สาขา</a></li>
                        <li><a href="<?=base_url('awards-infomation')?>?p=HealthAndWellness">การท่องเที่ยวเชิงสุขภาพ 4 สาขา</a></li>
                        <li><a href="<?=base_url('awards-infomation')?>?p=TourProgram">รายการนำเที่ยว</a></li>
                        <li><a href="<?=base_url('awards-infomation')?>?p=Judge">เกณฑ์การให้คะแนนตัดสิน</a></li>
                        <li><a href="<?=base_url('awards-infomation')?>?p=Benefits">สิทธิประโยชน์สำหรับผู้ที่ได้รับรางวัล</a></li>
                     </ul>
                  </div>

                  <li><a href="javascript:" data-tab="3" class="btn-submenu">คู่มือการสมัคร</a></li>
                  <div class="submenubox-list" data-tab="3" style="display: none;">
                     <ul>
                        <li><a href="<?=base_url('application-guide')?>?p=manual">คู่มือการลงทะเบียนประกวดรางวัล</a></li>
                        <li><a href="<?=base_url('application-guide')?>?p=duedate">กำหนดการรับสมัคร</a></li>
                        <li><a href="<?=base_url('application-guide')?>?p=register">สมัครเข้าร่วมประกวดรางวัล</a></li>
                     </ul>
                  </div>
                  <li><a href="javascript:" data-tab="4" class="btn-submenu">ผลงานที่ได้รับรางวัล</a></li>
                  <div class="submenubox-list" data-tab="4" style="display: none;">
                     <ul>
                        <!-- <li><a href="<?=base_url('awards-winner')?>">ครั้งที่ 14</a></li> -->
                        <li><a href="<?=base_url('awards-winner-13')?>">ครั้งที่ 13</a></li>
                     </ul>
                  </div>
                  <li><a href="<?=base_url('new')?>">ข่าวประชาสัมพันธ์</a></li>
                  <li><a href="<?=base_url('contact-us')?>">ติดต่อเรา</a></li>
               </ul>
            </div>

         </div>
      </div>

   </div>
</div>

<script>

   jQuery(document).ready(function() {

      $('.btn-menu').click(function() {
         if ($('.menubox').hasClass('active')) {
            $('body').removeClass('overlay');
            $('.menubox').removeClass('active');
         } else {
            $('body').addClass('overlay');
            $('.menubox').addClass('active');
         }
      });

      $('.menuclose').click(function() {
         $('body').removeClass('overlay');
         $('.menubox').removeClass('active');
      });
      
      $(".btn-submenu").click(function () {
         const datatabsubmenu = $(this).attr("data-tab");
         
         if ($(this).hasClass("active")) {
            $(".btn-submenu").removeClass("active");
            $(".submenubox-list").removeClass("active").slideUp();
         } else {
            $(".btn-submenu").removeClass("active");
            $(".submenubox-list").removeClass("active").slideUp();
            $('.btn-submenu[data-tab="' + datatabsubmenu + '"]').addClass("active");
            $('.submenubox-list[data-tab="' + datatabsubmenu + '"]')
            .addClass("active")
            .slideDown();
         }
      });

   });

   jQuery(document).ready(function() {
      $('.btn-noti').click(function() {
         $('.noti-box').slideDown(200).addClass('active lockbody');
         $('.btn-noti').html('<i class="bi bi-bell-fill"></i>');
      });
      $('.noti-box-close').click(function() {
         $('.noti-box').slideUp(200).removeClass('active lockbody');
      });
      $('.noti-box-overlay').click(function() {
         $('.noti-box').slideUp(200).removeClass('active lockbody');
      });
   });

   jQuery(document).ready(function() {
      $('.btn-user').click(function() {
         $('.user-box').slideDown(100).addClass('active lockbody');
      });
      $('.user-box-close').click(function() {
         $('.user-box').slideUp(100).removeClass('active lockbody');
      });
      $('.user-box-overlay').click(function() {
         $('.user-box').slideUp(100).removeClass('active lockbody');
      });
   });

   $(".flexnav").flexNav();

   <?php if (session()->get('isLoggedIn')): ?>
      $(document).ready(function() {
         $.ajax({
            type: 'post',
            url: window.location.origin + '/inner-api/noti/get',
            data: {
               limit: 5
            },
            dataType: 'json',
            success: function(res) {
               let icon, list = '';

               $.each(res.noti, function(k, v) {
                  list += '<li><a href="' + v.link + '">' + v.message + '</a></li>';
               });

               icon = '<i class="bi bi-bell-fill"></i>';
               if (res.noti.length > 0) {
                  icon += '<span class="noti-alert"></span>';
               }

               $('#noti-list').html(list);
               $('.noti-box').attr('data-id', res.id);
               $('.btn-noti').html(icon);
            }
         });
      });
   <?php endif;?>
</script>