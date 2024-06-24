<div id="header">
   <div id="header-inner">

      <div class="header-box">
         <div class="header-box-row regisform login_list">
            <div class="header-box-col">
               <ul>
                  <?php
                     if (!session()->get('isLoggedIn')):
                        $_app = config(\Config\App::class);
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
                                             <img id="header-img-profile" src="<?=session()->get('profile')?>">
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
                                    <?php if (in_array(session()->get('role'), [1, 3])): ?>
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
                                             } else {
                                                $url = 'boards';
                                                $content = 'การประเมิน';
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
                     <source srcset="<?=base_url('assets/images/logo.svg')?>?v=2">
                     <source srcset="<?=base_url('assets/images/logo.png')?>?v=2">
                     <img src="<?=base_url('assets/images/logo.png')?>?v=2" width="514" height="200" alt="logo">
                  </picture>
               </a>
            </div>
            <div class="header-box-col menu">
               <nav>
                  <ul class="flexnav">
                     <li><a id="menu-home" href="<?=base_url('home')?>">หน้าแรก</a></li>
                     <li><a href="javascript:void(0)" id="aboutmenu">เกี่ยวกับโครงการฯ</a>
                        <ul>
                           <li><a href="<?=base_url('about-us')?>">ข้อมูลโครงการฯ</a></li>
                        </ul>
                     </li>
                     <li><a href="javascript:void(0)" id="informationmenu">ข้อมูลการประกวดรางวัล</a>
                        <ul>
                           <li><a href="<?=DOWNLOAD_FILE_URL.('download/Factsheet-ประเภทแหล่งท่องเที่ยว.pdf')?>" target="_blank">ประเภทแหล่งท่องเที่ยว</a></li>
                           <li><a href="<?=DOWNLOAD_FILE_URL.('download/Factsheet-ประเภทที่พักนักท่องเที่ยว.pdf')?>" target="_blank">ประเภทที่พักนักท่องเที่ยว</a></li>
                           <li><a href="<?=DOWNLOAD_FILE_URL.('download/Factsheet-ประเภทการท่องเที่ยวเชิงสุขภาพ.pdf')?>" target="_blank">ประเภทการท่องเที่ยวเชิงสุขภาพ</a></li>
                           <li><a href="<?=DOWNLOAD_FILE_URL.('download/Factsheet-ประเภทรายการนำที่ยว.pdf')?>" target="_blank">ประเภทรายการนำเที่ยว</a></li>
                           <li><a href="<?=DOWNLOAD_FILE_URL.('download/Factsheet-ประเภทการท่องเที่ยวคาร์บอนต่ำ.pdf')?>" target="_blank">ประเภทการท่องเที่ยวคาร์บอนต่ำเพื่อความยั่งยืน</a></li>
                        </ul>
                     </li>
                     <li><a href="javascript:void(0)" id="regismenu">ข้อมูลการใช้งานระบบ</a>
                        <ul>
                           <li><a href="<?=DOWNLOAD_FILE_URL.('download/'.rawurlencode('คู่มือการใช้งานสำหรับผู้ประกอบการ ประเภทแหล่งท่องเที่ยว.pdf'))?>" target="_blank">ประเภทแหล่งท่องเที่ยว</a></li>
                           <li><a href="<?=DOWNLOAD_FILE_URL.('download/'.rawurlencode('คู่มือการใช้งานสำหรับผู้ประกอบการ ประเภทที่พักนักท่องเที่ยว.pdf'))?>" target="_blank">ประเภทที่พักนักท่องเที่ยว</a></li>
                           <li><a href="<?=DOWNLOAD_FILE_URL.('download/'.rawurlencode('คู่มือการใช้งานสำหรับผู้ประกอบการ ประเภทการท่องเที่ยวเชิงสุขภาพ.pdf'))?>" target="_blank">ประเภทการท่องเที่ยวเชิงสุขภาพ</a></li>
                           <li><a href="<?=DOWNLOAD_FILE_URL.('download/'.rawurlencode('คู่มือการใช้งานสำหรับผู้ประกอบการ ประเภทรายการนำเที่ยว.pdf'))?>" target="_blank">ประเภทรายการนำเที่ยว</a></li>
                        </ul>
                     </li>
                     <li><a href="javascript:void(0)" id="awardmenu">ผลงานที่ได้รับรางวัล</a>
                        <ul>
                           <li><a href="<?=base_url('awards-winner')?>">ครั้งที่ 14 ปี 2566</a></li>
                           <li><a href="<?=base_url('last-awards-winner')?>">ปีที่ผ่านมา</a></li>
                        </ul>
                     </li>
                     <li><a href="<?=base_url('contact-us')?>" id="contactmenu">ติดต่อเรา</a></li>
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
                     <source srcset="<?=base_url('assets/images/logo.svg')?>">
                     <img src="<?=base_url('assets/images/logo.png')?>">
                  </picture>
               </div>
               <ul>
                  <li><a href="<?=base_url('home')?>">หน้าแรก</a></li>
                  <li><a href="javascript:" class="btn-submenu" data-tab="1">เกี่ยวกับโครงการฯ</a></li>
                  <div class="submenubox-list" data-tab="1" style="display: none;">
                     <ul>
                        <li><a href="<?=base_url('about-us')?>">ข้อมูลโครงการฯ</a></li>
                     </ul>
                  </div>
                  <li><a href="javascript:" data-tab="2" class="btn-submenu">ข้อมูลการประกวดรางวัล</a></li>
                  <div class="submenubox-list" data-tab="2" style="display: none;">
                     <ul>
                        <li><a href="<?=DOWNLOAD_FILE_URL.('download/Factsheet-ประเภทแหล่งท่องเที่ยว.pdf')?>" target="_blank">ประเภทแหล่งท่องเที่ยว</a></li>
                        <li><a href="<?=DOWNLOAD_FILE_URL.('download/Factsheet-ประเภทที่พักนักท่องเที่ยว.pdf')?>" target="_blank">ประเภทที่พักนักท่องเที่ยว</a></li>
                        <li><a href="<?=DOWNLOAD_FILE_URL.('download/Factsheet-ประเภทการท่องเที่ยวเชิงสุขภาพ.pdf')?>" target="_blank">ประเภทการท่องเที่ยวเชิงสุขภาพ</a></li>
                        <li><a href="<?=DOWNLOAD_FILE_URL.('download/Factsheet-ประเภทรายการนำที่ยว.pdf')?>" target="_blank">ประเภทรายการนำเที่ยว</a></li>
                        <li><a href="<?=DOWNLOAD_FILE_URL.('download/Factsheet-ประเภทการท่องเที่ยวคาร์บอนต่ำ.pdf')?>" target="_blank">ประเภทการท่องเที่ยวคาร์บอนต่ำเพื่อความยั่งยืน</a></li>
                     </ul>
                  </div>

                  <li><a href="javascript:" data-tab="3" class="btn-submenu">ข้อมูลการใช้งานระบบ</a></li>
                  <div class="submenubox-list" data-tab="3" style="display: none;">
                     <ul>
                        <li><a href="<?=DOWNLOAD_FILE_URL.('download/'.rawurlencode('คู่มือการใช้งานสำหรับผู้ประกอบการ ประเภทแหล่งท่องเที่ยว.pdf'))?>" target="_blank">ประเภทแหล่งท่องเที่ยว</a></li>
                        <li><a href="<?=DOWNLOAD_FILE_URL.('download/'.rawurlencode('คู่มือการใช้งานสำหรับผู้ประกอบการ ประเภทที่พักนักท่องเที่ยว.pdf'))?>" target="_blank">ประเภทที่พักนักท่องเที่ยว</a></li>
                        <li><a href="<?=DOWNLOAD_FILE_URL.('download/'.rawurlencode('คู่มือการใช้งานสำหรับผู้ประกอบการ ประเภทการท่องเที่ยวเชิงสุขภาพ.pdf'))?>" target="_blank">ประเภทการท่องเที่ยวเชิงสุขภาพ</a></li>
                        <li><a href="<?=DOWNLOAD_FILE_URL.('download/'.rawurlencode('คู่มือการใช้งานสำหรับผู้ประกอบการ ประเภทรายการนำเที่ยว.pdf'))?>" target="_blank">ประเภทรายการนำเที่ยว</a></li>
                     </ul>
                  </div>
                  <li><a href="javascript:" data-tab="4" class="btn-submenu">ผลงานที่ได้รับรางวัล</a></li>
                  <div class="submenubox-list" data-tab="4" style="display: none;">
                     <ul>
                        <li><a href="<?=base_url('awards-winner')?>">ครั้งที่ 14 ปี 2566</a></li>
                        <li><a href="<?=base_url('last-awards-winner')?>">ปีที่ผ่านมา</a></li>
                     </ul>
                  </div>
                  <li><a href="<?=base_url('contact-us')?>">ติดต่อเรา</a></li>
               </ul>
            </div>

         </div>
      </div>

   </div>
</div>

<script>
   document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('.btn-menu').forEach( e => {
         e.addEventListener('click', () => {
            const body = document.querySelector('body');
            const box = document.querySelector('.menubox');

            if(box.classList.contains('active')){
               body.classList.remove('overlay');
               box.classList.remove('active');
            } else {
               body.classList.add('overlay');
               box.classList.add('active');
            }
         });
      });      

      document.querySelector('.menuclose').addEventListener('click', () => {
         document.querySelector('body').classList.remove('overlay');
         document.querySelector('.menubox').classList.remove('active');
      });

      document.querySelectorAll('.btn-submenu').forEach( el => {
         el.addEventListener('click', function() {
            const thisTab = this.dataset.tab;

            document.querySelectorAll('.btn-submenu').forEach( function(ip) {
               const tab = ip.dataset.tab;
               if(thisTab !== tab) ip.classList.remove('active');
            });            
            
            $(".submenubox-list").removeClass("active").slideUp();

            if(this.classList.contains('active')){
               document.querySelector(`.btn-submenu[data-tab="${thisTab}"]`).classList.remove('active');
               $(".submenubox-list").removeClass("active").slideUp();      
            } else {
               document.querySelector(`.btn-submenu[data-tab="${thisTab}"]`).classList.add('active');
               $(`.submenubox-list[data-tab="${thisTab}"]`).addClass("active").slideDown();
            } 
         });
      });

      if(document.querySelector('.btn-noti') !== null){
         document.querySelector('.btn-noti').addEventListener('click', () => {
            $('.noti-box').slideDown(150).addClass('active ');
            document.querySelector('body').classList.add('overlay');
            document.querySelector('.btn-noti').innerHTML = '<i class="bi bi-bell-fill"></i>';
         });
      }

      if(document.querySelector('.btn-noti-close') !== null){
         document.querySelector('.noti-box-close').addEventListener('click', () => {
            $('.noti-box').slideDown(150).removeClass('active ');
            document.querySelector('body').classList.remove('overlay');
         });
      }

      if(document.querySelector('.btn-noti-overlay') !== null){
         document.querySelector('.noti-box-overlay').addEventListener('click', () => {
            $('.noti-box').slideDown(150).removeClass('active ');
            document.querySelector('body').classList.remove('overlay');
         });
      }      

      if(document.querySelector('.btn-user') !== null){
         document.querySelector('.btn-user').addEventListener('click', () => {
            $('.user-box').slideDown(150).addClass('active ');
            document.querySelector('body').classList.add('overlay');
         });
      }

      if(document.querySelector('.btn-user-close') !== null){
         document.querySelector('.btn-user-close').addEventListener('click', () => {
            $('.user-box').slideDown(150).removeClass('active ');
            document.querySelector('body').classList.remove('overlay');
         });
      }

      if(document.querySelector('.btn-user-overlay') !== null){
         document.querySelector('.btn-user-overlay').addEventListener('click', () => {
            $('.user-box').slideDown(150).removeClass('active ');
            document.querySelector('body').classList.remove('overlay');
         });
      }

      <?php if (session()->get('isLoggedIn')): ?>
         getHeaderNoti();
      <?php endif;?>
   });

   <?php if (session()->get('isLoggedIn')): ?>
      const getHeaderNoti = () => { 
         const headers = new Headers();
         headers.append('Content-Type', 'application/json');

         fetch(
            `${window.location.origin}/inner-api/noti/get`,
            {
               method: 'POST',
               headers: headers,
               body: JSON.stringify({limit: 5})
            }
         )
         .then(response => response.json())
         .then(response => {
            let   icon = '<i class="bi bi-bell-fill"></i>',
                  list = '';
            
            for(index in response.noti){
               const noti = response.noti[index];
               list += `<li><a href="${noti.link}">${noti.message}</a></li>`;
            }

            if(response.noti > 0) icon += '<span class="noti-alert"></span>';

            document.querySelector('.noti-box').dataset.id = response.id;
            document.querySelector('.btn-noti').innerHTML = icon;
            document.querySelector('#noti-list').innerHTML = list;
         })
        .catch(errors => {
            resolve({
                status: false,
                result: 'error',
                message: `Request failed : ${errors.statusText}`
            });
        });
      }
   <?php endif;?>
</script>