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
        <li class="clearfix">
          <div class="user-img">
            <span class="activity active"></span>
            <img src="./assets/images/1.png" height="40" width="40" alt="">
          </div>
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