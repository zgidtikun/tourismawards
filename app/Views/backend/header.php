<div class="header">
  <div class="header-content clearfix">
    <div class="header-left">
      <div class="input-group position-static">
        <!-- <div class="input-group-prepend" data-display="static" data-toggle="dropdown">
          <span class="input-group-text bg-transparent border-0" id="basic-addon1">
            <i class="icon-magnifier"></i>
          </span>
        </div> -->
        <!-- <input type="search" class="border-0" placeholder="Search Dashboard" aria-label="Search Dashboard">
        <div class="dropdown-menu animated zoomIn d-md-none">
          <form action="index.html#">
            <input type="text" class="form-control" placeholder="Search">
          </form>
        </div> -->
      </div>
    </div>
    <div class="header-right">

      <ul class="clearfix">
        <!-- <li class="d-none d-md-flex">
          <a href="javascript:void(0)" class="window_fullscreen wave-effect wave-effect-x waves-effect">
            <i class="icon-frame"></i>
          </a>
        </li> -->

        <li class="d-none d-md-flex">
          <?= session()->user ?>
        </li>
        <li class="dropdown">
          <div class="user-img c-pointer wave-effect wave-effect-x waves-effect" data-display="static" data-toggle="dropdown">
            <span class="activity active"></span>
            <img src="./assets/images/1.png" height="40" width="40" alt="">
          </div>
          <!-- <div class="dropdown-menu dropdown-menu-right dropdown-profile animated fadeIn">
            <div class="dropdown-content-body">
              <ul>
                <li><a href="javascript:void()"><i class="icon-user"></i> <span>My Profile</span></a>
                </li>
                <li><a href="javascript:void()"><i class="icon-calender"></i> <span>My Calender</span></a>
                </li>
                <li><a href="javascript:void()"><i class="icon-envelope-open"></i> <span>My Inbox</span>
                    <div class="badge gradient-3 badge-pill badge-primary">3</div>
                  </a>
                </li>
                <li><a href="javascript:void()"><i class="icon-paper-plane"></i> <span>My Tasks</span>
                    <div class="badge badge-pill bg-dark">3</div>
                  </a>
                </li>
                <hr class="my-2">
                <li><a href="javascript:void()"><i class="icon-check"></i> <span>Online</span></a>
                </li>
                <li><a href="javascript:void()"><i class="icon-lock"></i> <span>Lock Screen</span></a>
                </li>
                <li><a href="javascript:void()"><i class="icon-key"></i> <span>Logout</span></a>
                </li>
              </ul>
            </div>
          </div> -->
        </li>
        <li class="d-none d-md-flex">
          <a href="<?= base_url('auth/logout') ?>" data-toggle="tooltip" title="ออกจากระบบ">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>