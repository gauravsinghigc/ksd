<nav id="mainnav-container">
  <!--Brand logo & name-->
  <!--================================-->
  <div class="navbar-header">
    <a href="admin" class="navbar-brand">
      <div class="p-3 rounded">
        <span class="p-3 text-white app-icon" id="onlyicon">
          <img src="<?php echo company_logo; ?>">
        </span>
        <div class="brand-title">
          <span class="brand-text" id="brandName"><?php echo substr(company_name, 0, 21); ?></span>
        </div>
      </div>
    </a>
  </div>
  <!--================================-->
  <!--End brand logo & name-->
  <div id="mainnav">
    <!--Menu-->
    <!--================================-->
    <div id="mainnav-menu-wrap">
      <div class="nano">
        <div class="nano-content mt-1">
          <ul id="mainnav-menu" class="list-group m-t-5">
            <!--Menu list item-->
            <li class="mt-1"> <a href="<?php echo DOMAIN; ?>/admin"> <i class="fa fa-home"></i> <span class="menu-title"> Dashboard </span> </a> </li>
            <?php
            $SelectModuleAccess = SELECT("SELECT * FROM module_list, module_controls, users where module_list.module_id=module_controls.moduleid and module_controls.userid=users.id and module_controls.status='ACTIVE' and module_controls.userid='" . LOGIN_UserId . "'");
            while ($Modules = mysqli_fetch_array($SelectModuleAccess)) {
              $ModuleName = $Modules['module_name'];
              if ($ModuleName == "ADMIN") { ?>
                <!--Category name-->

                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/projects"> <i class="fa fa-briefcase"></i>
                    <span class="menu-title"> Projects </span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/projects/plots"> <i class="fa fa-map-marker"></i>
                    <span class="menu-title"> Plots</span>
                  </a>
                </li>
                <li hidden="">
                  <a href="<?php echo DOMAIN; ?>/admin/projects/flats"> <i class="fa fa-building"></i>
                    <span class="menu-title"> Flats</span>
                  </a>
                </li>

                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/booking"> <i class="fa fa-star"></i>
                    <span class="menu-title"> Bookings</span> </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-inr"></i>
                    <span class="menu-title">Payments Receipts</span>
                    <i class="arrow"></i>
                  </a>
                  <!--Submenu-->
                  <ul class="collapse">
                    <li class="sqaure"><a href="<?php echo DOMAIN; ?>/admin/payments" class="sqaure"> All Receipts</a></li>
                    <li><a href="<?php echo DOMAIN; ?>/admin/payments/cash-payments"><i class="fa fa-caret-right"></i> Cash Receipts</a></li>
                    <li><a href="<?php echo DOMAIN; ?>/admin/payments/check-payments"> <i class="fa fa-caret-right"></i> Cheque Receipts</a></li>
                    <li><a href="<?php echo DOMAIN; ?>/admin/payments/online-payments"> <i class="fa fa-caret-right"></i> Online Receipts</a></li>
                  </ul>
                </li>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/partner"> <i class="fa fa-briefcase"></i>
                    <span class="menu-title"> Agents</span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/customer"> <i class="fa fa-users"></i>
                    <span class="menu-title"> Customers</span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/employees"> <i class="fa fa-briefcase"></i>
                    <span class="menu-title">Employees</span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/expanses"> <i class="fa fa-exchange"></i>
                    <span class="menu-title"> Expenses</span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/invoices"> <i class="fa fa-file-pdf-o"></i>
                    <span class="menu-title"> Invoices</span>
                  </a>
                </li>
               
                <li>
                  <a href="#">
                    <i class="fa fa-info-circle"></i>
                    <span class="menu-title">Enquiry & Walkins</span>
                    <i class="arrow"></i>
                  </a>

                  <ul class="collapse">
                    <li><a href="<?php echo DOMAIN; ?>/admin/walkins/"><i class="fa fa-caret-right"></i> Walkins </a></li>
                    <li><a href="<?php echo DOMAIN; ?>/admin/enquiries/"><i class="fa fa-caret-right"></i> Enquiries</a></li>
                  </ul>
                </li>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/notification"> <i class="fa fa-bell"></i>
                    <span class="menu-title"> Alerts & Notifications</span>
                  </a>
                </li>
                <!--Menu list item-->
                <li>
                  <a href="#">
                    <i class="fa fa-phone-square"></i>
                    <span class="menu-title">Leads</span>
                    <i class="arrow"></i>
                  </a>
                  <!--Submenu-->
                  <ul class="collapse">
                    <li><a href="<?php echo DOMAIN; ?>/admin/leads/add.php"><i class="fa fa-caret-right"></i> ADD New Lead</a></li>
                    <li><a href="<?php echo DOMAIN; ?>/admin/leads/"><i class="fa fa-caret-right"></i> All Leads</a></li>
                    <li><a href="<?php echo DOMAIN; ?>/admin/leads/calls/"><i class="fa fa-caret-right"></i> All Calls</a></li>
                  </ul>
                </li>

                <li>
                  <a href="#">
                    <i class="fa fa-file-pdf-o"></i>
                    <span class="menu-title">Reports</span>
                    <i class="arrow"></i>
                  </a>
                  <!--Submenu-->
                  <ul class="collapse" hidden="">
                    <li><a href=" <?php echo DOMAIN; ?>/admin/reports/booking-reports"><i class="fa fa-caret-right"></i>Booking Reports</a>
                    </li>
                    <li><a href="<?php echo DOMAIN; ?>/admin/reports/project-reports"><i class="fa fa-caret-right"></i> Project Reports</a></li>
                    <li><a href="<?php echo DOMAIN; ?>/admin/reports/plot-reports"><i class="fa fa-caret-right"></i> Plot Reports</a></li>
                    <li><a href="<?php echo DOMAIN; ?>/admin/reports/flat-reports"><i class="fa fa-caret-right"></i> Flat Reports</a></li>
                    <li><a href="<?php echo DOMAIN; ?>/admin/reports/payment-reports"><i class="fa fa-caret-right"></i> Payment Reports</a></li>
                    <li><a href="<?php echo DOMAIN; ?>/admin/reports/expenses-reports"><i class="fa fa-caret-right"></i> Expense Reports</a></li>
                    <li><a href="<?php echo DOMAIN; ?>/admin/reports/invoices"><i class="fa fa-caret-right"></i> Invoices</a></li>
                    <li><a href="<?php echo DOMAIN; ?>/admin/reports/call-reports"><i class="fa fa-caret-right"></i> Call Reports</a></li>
                  </ul>
                </li>

                <li>
                  <a href="#">
                    <i class="fa fa-gear"></i>
                    <span class="menu-title">Company Profile</span>
                    <i class="arrow"></i>
                  </a>
                  <!--Submenu-->
                  <ul class="collapse">
                    <li><a href="<?php echo DOMAIN; ?>/admin/company-profile"><i class="fa fa-caret-right"></i> Company Profile</a></li>
                  </ul>
                </li>
                <!--Menu list item-->

                <!--Menu list item-->

              <?php } else if ($ModuleName == "PROJECT") { ?>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/projects"> <i class="fa fa-briefcase"></i>
                    <span class="menu-title"> Projects </span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/projects/plots"> <i class="fa fa-map-marker"></i>
                    <span class="menu-title"> Plots</span>
                  </a>
                </li>
                <li hidden="">
                  <a href="<?php echo DOMAIN; ?>/admin/projects/flats"> <i class="fa fa-building"></i>
                    <span class="menu-title"> Flats</span>
                  </a>
                </li>

              <?php } else if ($ModuleName == "BOOKING") { ?>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/booking"> <i class="fa fa-star"></i>
                    <span class="menu-title"> Bookings</span> </a>
                </li>

              <?php } else if ($ModuleName == "AGENT") { ?>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/partner"> <i class="fa fa-briefcase"></i>
                    <span class="menu-title"> Agent</span>
                  </a>
                </li>
              <?php } else if ($ModuleName == "ACCOUNTS") { ?>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/payments"> <i class="fa fa-inr"></i>
                    <span class="menu-title"> Payments Receipts</span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/payments/check"> <i class="fa fa-inr"></i>
                    <span class="menu-title"> Check Payments</span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/expanses"> <i class="fa fa-exchange"></i>
                    <span class="menu-title"> Expenses</span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/invoices"> <i class="fa fa-file-pdf-o"></i>
                    <span class="menu-title"> Invoices</span>
                  </a>
                </li>
              <?php } else if ($ModuleName == "ENQUIRIES") { ?>
                <li>
                  <a href="#">
                    <i class="fa fa-info-circle"></i>
                    <span class="menu-title">Enquiry & Walkins</span>
                    <i class="arrow"></i>
                  </a>

                  <ul class="collapse">
                    <li><a href="<?php echo DOMAIN; ?>/admin/walkins/"><i class="fa fa-caret-right"></i> Walkins </a></li>
                    <li><a href="<?php echo DOMAIN; ?>/admin/enquiries/"><i class="fa fa-caret-right"></i> Enquiries</a></li>
                  </ul>
                </li>

              <?php } else if ($ModuleName == "PROJECT_MAP") { ?>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/project-map"> <i class="fa fa-map-marker"></i>
                    <span class="menu-title"> Project Map</span>
                  </a>
                </li>

              <?php } else if ($ModuleName == "CUSTOMERS") { ?>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/customer"> <i class="fa fa-users"></i>
                    <span class="menu-title"> Customers</span>
                  </a>
                </li>

              <?php } else if ($ModuleName == "EXPANSES") { ?>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/expanses"> <i class="fa fa-exchange"></i>
                    <span class="menu-title"> Expenses</span>
                  </a>
                </li>

              <?php } else if ($ModuleName == "RECEPTION") { ?>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/customer"> <i class="fa fa-users"></i>
                    <span class="menu-title"> Customers</span>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-info-circle"></i>
                    <span class="menu-title">Enquiry & Walkins</span>
                    <i class="arrow"></i>
                  </a>

                  <ul class="collapse">
                    <li><a href="<?php echo DOMAIN; ?>/admin/walkins/"><i class="fa fa-caret-right"></i> Walkins </a></li>
                    <li><a href="<?php echo DOMAIN; ?>/admin/enquiries/"><i class="fa fa-caret-right"></i> Enquiries</a></li>
                  </ul>
                </li>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/leads/calls"> <i class="fa fa-phone"></i>
                    <span class="menu-title"> Calls</span>
                  </a>
                </li>

              <?php } else if ($ModuleName == "SITE_VISITS") { ?>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/site-visits"> <i class="fa fa-users"></i>
                    <span class="menu-title"> Site Visits</span>
                  </a>
                </li>

              <?php } else if ($ModuleName == "CALLS") { ?>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/leads/calls"> <i class="fa fa-phone"></i>
                    <span class="menu-title"> Calls</span>
                  </a>
                </li>


              <?php } else if ($ModuleName == "HR") { ?>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/employees"> <i class="fa fa-briefcase"></i>
                    <span class="menu-title">Employees</span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/employees/attendance"> <i class="fa fa-calendar"></i>
                    <span class="menu-title">Attendance</span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/employees/salary"> <i class="fa fa-inr"></i>
                    <span class="menu-title">Salary</span>
                  </a>
                </li>

              <?php } else if ($ModuleName == "WEB_QUERIES") { ?>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/web-queries"> <i class="fa fa-info-circle"></i>
                    <span class="menu-title">Web Queries</span>
                  </a>
                </li>

              <?php } else if ($ModuleName == "APP_SETTINGS") { ?>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/app-settings"> <i class="fa fa-gear"></i>
                    <span class="menu-title">App Settings</span>
                  </a>
                </li>

              <?php } else if ($ModuleName == "SMS") { ?>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/app-settings"> <i class="fa fa-comment"></i>
                    <span class="menu-title">SMS</span>
                  </a>
                </li>

              <?php } else if ($ModuleName == "NOTIFICATION") { ?>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/notifications"> <i class="fa fa-bell"></i>
                    <span class="menu-title">Notification</span>
                  </a>
                </li>

              <?php } else if ($ModuleName == "STORAGE") { ?>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/storage"> <i class="fa fa-upload"></i>
                    <span class="menu-title">STORAGE</span>
                  </a>
                </li>

              <?php } else if ($ModuleName == "REPORTS") { ?>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/reports"> <i class="fa fa-file-pdf-o"></i>
                    <span class="menu-title">Reports</span>
                  </a>
                </li>

              <?php } else if ($ModuleName == "COMPANY") { ?>
                <li>
                  <a href="#">
                    <i class="fa fa-gear"></i>
                    <span class="menu-title">Company Profile</span>
                    <i class="arrow"></i>
                  </a>
                  <!--Submenu-->
                  <ul class="collapse">
                    <li><a href="<?php echo DOMAIN; ?>/admin/company-profile"><i class="fa fa-caret-right"></i> Company Profile</a></li>
                  </ul>
                </li>

              <?php } else if ($ModuleName == "SUBSCRIPTION") { ?>
                <li>
                  <a href="<?php echo DOMAIN; ?>/admin/subscription"> <i class="fa fa-refresh"></i>
                    <span class="menu-title">Subscription</span>
                  </a>
                </li>

              <?php } else if ($ModuleName == "LEADS") { ?>
                <li>
                  <a href="#">
                    <i class="fa fa-phone-square"></i>
                    <span class="menu-title">Leads</span>
                    <i class="arrow"></i>
                  </a>
                  <!--Submenu-->
                  <ul class="collapse">
                    <li><a href="<?php echo DOMAIN; ?>/admin/leads/add.php"><i class="fa fa-caret-right"></i> ADD New Lead</a></li>
                    <li><a href="<?php echo DOMAIN; ?>/admin/leads/"><i class="fa fa-caret-right"></i> All Leads</a></li>
                    <li><a href="<?php echo DOMAIN; ?>/admin/leads/calls/"><i class="fa fa-caret-right"></i> All Calls</a></li>
                  </ul>
                </li>

              <?php } else if ($ModuleName == "MODULES") { ?>
                <li>
                  <a href="#">
                    <i class="fa fa-gears"></i>
                    <span class="menu-title">Advance Settings</span>
                    <i class="arrow"></i>
                  </a>
                  <!--Submenu-->
                  <ul class="collapse">
                    <li><a href="<?php echo DOMAIN; ?>/admin/module/"><i class="fa fa-caret-right"></i>Module Settings</a></li>
                    <li><a href="<?php echo DOMAIN; ?>/admin/settings/"><i class="fa fa-caret-right"></i>Company Settings</a></li>
                  </ul>
                </li>

              <?php } else if ($ModuleName == "WEBSITE") { ?>
                <li>
                  <a href="#">
                    <i class="fa fa-globe"></i>
                    <span class="menu-title">Website Settings</span>
                    <i class="arrow"></i>
                  </a>
                  <!--Submenu-->
                  <ul class="collapse">
                    <li><a href="<?php echo DOMAIN; ?>/admin/website/index.php"><i class="fa fa-caret-right"></i>Pages</a></li>
                    <li><a href="<?php echo DOMAIN; ?>/admin/website/sliders/"><i class="fa fa-caret-right"></i>Sliders</a></li>
                    <li><a href="<?php echo DOMAIN; ?>/admin/website/social-links/"><i class="fa fa-caret-right"></i>Social Media Links</a></li>
                  </ul>
                </li>

              <?php } else { ?>
                <li>
                  <a href="#"><i class="fa fa-warning"></i><span class="menu-title">No Module Access</span></a>
                </li>
              <?php } ?>


            <?php  } ?>

            <li> <a href="<?php echo DOMAIN; ?>/admin/profile"> <i class="fa fa-user"></i> <span class="menu-title"> Profile</span> </a>
            </li>
            <li> <a href="<?php echo DOMAIN; ?>/logout.php"> <i class="fa fa-sign-out"></i> <span class="menu-title"> Logout</span> </a>
            </li>
            <li><br></li>
            <li><br></li>
            <li><br></li>
            <li><br></li>
          </ul>
        </div>
      </div>
      <!--================================-->
      <!--End widget-->
    </div>

    <!--================================-->
    <!--End menu-->
  </div>
</nav>