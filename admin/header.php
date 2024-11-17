<!--===================================================-->
<style>
  .time-block {
    color: white !important;
    font-size: 1.4rem !important;
    padding: 3%;
    width: 365px;
    display: flex;
    justify-content: flex-start;
    min-width: fit-content;
    padding-left: 0px !important;
    margin-top: 1%;
  }

  .time-block .display-8 {
    font-size: 1.4rem !important;
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button {
    box-sizing: border-box !important;
    display: inline-block !important;
    min-width: 1em !important;
    padding: 0em 0em !important;
    margin-left: 2px !important;
    text-align: left !important;
    text-decoration: none !important;
    cursor: pointer !important;
    color: #333 !important;
    border: 1px solid transparent !important;
    border-radius: 2px;
    z-index: 0 !important;
  }

  .form-group {
    display: flex !important;
    flex-direction: column !important;
  }

  .btn-dark {
    background-color: black !important;
    color: white !important;
  }

  @media (max-width: 720px) {
    .notification-box {
      width: 100% !important;
      min-width: 100% !important;
      max-width: 100%;
      bottom: 0px;
      z-index: 1111111111111 !important;
      position: fixed;
      border-top-right-radius: 20px !important;
      border-top-left-radius: 20px !important;
      box-shadow: 0px 0px 1px lightgrey !important;
      padding-top: 2% !important;
    }
  }

  @media (max-width: 458px) {
    .time-block {
      font-size: 1.1rem !important;
      transform: scale(1) !important;
      text-align: left !important;
      display: flex !important;
      justify-content: flex-start !important;
      min-width: 10px !important;
      max-width: 65vw !important;
      margin-top: 2% !important;
      -webkit-transform: scale(1) !important;
      -moz-transform: scale(1) !important;
      -ms-transform: scale(1) !important;
      -o-transform: scale(1) !important;
    }
  }

  @media (max-width: 368px) {
    .time-block {
      font-size: 0.8rem !important;
      transform: scale(1) !important;
      text-align: left !important;
      display: flex !important;
      justify-content: flex-start !important;
      min-width: 10px !important;
      max-width: 65vw !important;
      margin-top: 7% !important;
      -webkit-transform: scale(1) !important;
    }
  }
</style>
<header id="navbar">
  <div id="navbar-container" class="boxed">
    <!--Navbar Dropdown-->
    <!--================================-->
    <div class="navbar-content clearfix">
      <ul class="nav navbar-top-links pull-left">

        <!--Navigation toogle button-->
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <?php if (DEVICE_TYPE != "Computer") { ?>
          <li class="tgl-menu-btn">
            <a class="mainnav-toggle" href="#" id="sidebarController"> <i class="fa fa-navicon fa-lg"></i> </a>
          </li>
        <?php } ?>
        <li>
          <!--===================================================-->
          <div class="display-4 time-block">
            <span><i class="fa fa-clock-o pl-1"></i> </span>
            <span id="clock" class="display-2"> 8:10:45</span>
          </div>

          <script>
            setInterval(showTime, 1000);

            function showTime() {
              let time = new Date();
              let hour = time.getHours();
              let min = time.getMinutes();
              let sec = time.getSeconds();
              am_pm = "AM ";

              if (hour > 12) {
                hour -= 12;
                am_pm = " PM";
              }
              if (hour == 0) {
                hr = 12;
                am_pm = " AM";
              }

              hour = hour < 10 ? "0" + hour : hour;
              min = min < 10 ? "0" + min : min;
              sec = sec < 10 ? "0" + sec : sec;

              let currentTime = hour + ":" +
                min + ":" + sec + am_pm + "";

              document.getElementById("clock")
                .innerHTML = "&nbsp;" + currentTime + " ";
            }

            showTime();
          </script>
        </li>

      </ul>
      <ul class="nav navbar-top-links pull-right">
        <li id="dropdown-user" class="dropdown">
          <a href="<?php echo DOMAIN; ?>/admin/profile/" data-toggle="dropdown" class="dropdown-toggle text-right">
            <span class="pull-right">
              <img class="img-circle img-user media-object" src="<?php echo LOGIN_UserProfileImage; ?>" alt="<?php echo LOGIN_UserFullName; ?>" title="<?php echo LOGIN_UserFullName; ?>"> </span>
            <div class="username hidden-xs"><?php echo LOGIN_UserFullName; ?></div>
          </a>
          <div class="dropdown-menu dropdown-menu-right with-arrow">
            <!-- User dropdown menu -->
            <ul class="head-list">
              <li>
                <a href="<?php echo DOMAIN; ?>/admin/profile/"> <i class="fa fa-user fa-fw"></i> Profile </a>
              </li>
              <li>
                <a href="<?php echo DOMAIN; ?>/admin/profile/"> <i class="fa fa-gear fa-fw"></i> Settings </a>
              </li>
              <li>
                <a href="<?php echo DOMAIN; ?>/logout.php"> <i class="fa fa-sign-out fa-fw"></i> Logout </a>
              </li>
            </ul>
          </div>
        </li>

      </ul>
    </div>
  </div>
</header>