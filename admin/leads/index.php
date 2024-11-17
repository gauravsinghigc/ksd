<?php
require '../../require/modules.php';
require "../../require/admin/sessionvariables.php";
require '../../include/admin/common.php';

//pagevariables
$PageName = "All Leads";
$PageDescription = "Manage all Leads";
$btntext = "Add New Leads";
$DomainExpireInCurrentMonth = date("Y-m-d", strtotime("+1 month"));

if (isset($_GET['search'])) {
  $search = $_GET['search'];
  $_SESSION['search'] = $search;
} elseif (isset($_SESSION['search'])) {
  $search = $_SESSION['search'];
} else {
  $search = "";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SHORT_DESCRIPTION; ?>">
  <?php include '../../include/header_files.php'; ?>
  <script type="text/javascript">
    function SidebarActive() {
      document.getElementById("leads").classList.add("active");
      document.getElementById("all_leads").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../header.php'; ?>

    <!-- main content area -->
    <div class="boxed">
      <!--CONTENT CONTAINER-->
      <!--===================================================-->
      <div id="content-container">
        <!--Page content-->
        <div id="page-content">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-12">
              <div class="panel square">

                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-12 m-b-10">
                      <h3 class="m-t-3 m-b-10"><i class="fa fa-phone app-text"></i> <?php echo $PageName; ?>
                        <a href="add.php" class="btn btn-md btn-danger pull-right"><i class="fa fa-plus"></i> Add New Leads</a>
                      </h3>
                    </div>
                    <div class="col-md-2 mb-10px">
                      <div class="card card-body border-1 rounded-3 p-4 shadow-lg">
                        <div class="flex-s-b">
                          <h3 class="count text-primary mb-0 m-t-5">
                            <?php echo TOTAL("SELECT * FROM leads"); ?>
                          </h3>
                          <span class="pull-right text-grey" style="line-height:0.6rem;">
                            <span class="fs-11">Today : </span><span class="fs-13 count"><?php echo TOTAL("SELECT * FROM leads where Date(LeadPersonCreatedAt)='" . date("Y-m-d") . "'"); ?></span><br>
                            <span class="fs-11">Yesterday : </span><span class="fs-13 count"><?php echo TOTAL("SELECT * FROM leads where Date(LeadPersonCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'"); ?></span>
                          </span>
                        </div>
                        <p class="mb-0 fs-12 text-black">All Leads</p>
                      </div>
                    </div>
                    <?php
                    foreach (LEAD_STAGES as $Stages => $values) { ?>
                      <div class="col-md-2 mb-10px">
                        <div class="card card-body border-1 rounded-3 p-4 shadow-lg">
                          <div class="flex-s-b">
                            <h3 class="count text-primary mb-0 m-t-5">
                              <?php echo TOTAL("SELECT * FROM leads where LeadPersonStatus like '%$Stages%'"); ?>
                            </h3>
                            <span class="pull-right text-grey" style="line-height:0.6rem;">
                              <span class="fs-11">Today : </span><span class="fs-13 count"><?php echo TOTAL("SELECT * FROM leads where LeadPersonStatus like '%$Stages%' and Date(LeadPersonCreatedAt)='" . date("Y-m-d") . "'"); ?></span><br>
                              <span class="fs-11">Yesterday : </span><span class="fs-13 count"><?php echo TOTAL("SELECT * FROM leads where LeadPersonStatus like '%$Stages%' and Date(LeadPersonCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'"); ?></span>
                            </span>
                          </div>
                          <p class="mb-0 fs-12 text-black"><?php echo $values; ?></p>
                        </div>
                      </div>
                    <?php } ?>
                  </div>

                  <div class="row m-t-2">
                    <div class="col-md-2">

                      <?php
                      if (isset($_GET['LeadPersonManagedBy'])) {
                        $LeadPersonManagedBy = $_GET['LeadPersonManagedBy'];
                      } else {
                        $LeadPersonManagedBy = "";
                      }

                      if (isset($_GET['LeadPersonCreatedBy'])) {
                        $LeadPersonCreatedBy = $_GET['LeadPersonCreatedBy'];
                      } else {
                        $LeadPersonCreatedBy = "";
                      }
                      if (isset($_GET['LeadPersonCreatedAt'])) {
                        $LeadPersonCreatedAt = $_GET['LeadPersonCreatedAt'];
                      } else {
                        $LeadPersonCreatedAt = date("Y-m-d");
                      }

                      ?>
                      <form action="" method="get">
                        <input type="date" name="LeadPersonCreatedAt" value="<?php echo $LeadPersonCreatedAt; ?>" hidden>
                        <input type="text" hidden="" name="LeadPersonCreatedBy" value="<?php echo $LeadPersonCreatedBy; ?>">
                        <input type="text" hidden="" name="LeadPersonManagedBy" value="<?php echo $LeadPersonManagedBy; ?>">
                        <select class="form-control" name="LeadPersonStatus" onchange="form.submit()">
                          <option value="">Filter By Lead Status</option>
                          <?php
                          $FilteredData = FetchConvertIntoArray("SELECT * FROM leads GROUP BY LeadPersonStatus", true);
                          if ($FilteredData != null) {
                            foreach ($FilteredData as $data) {
                              if (isset($_GET['LeadPersonStatus'])) {
                                if ($_GET['LeadPersonStatus'] == $data->LeadPersonStatus) {
                                  $active = "selected";
                                } else {
                                  $active = "";
                                }
                              } else {
                                $active = "";
                              }
                          ?>
                              <option value="<?php echo $data->LeadPersonStatus; ?>" <?php echo $active; ?>><?php echo $data->LeadPersonStatus; ?></option>
                          <?php
                            }
                          }  ?>
                        </select>
                      </form>
                    </div>
                    <div class="col-md-2">
                      <?php
                      if (isset($_GET['LeadPersonManagedBy'])) {
                        $LeadPersonManagedBy = $_GET['LeadPersonManagedBy'];
                      } else {
                        $LeadPersonManagedBy = "";
                      }

                      if (isset($_GET['LeadPersonStatus'])) {
                        $LeadPersonStatus = $_GET['LeadPersonStatus'];
                      } else {
                        $LeadPersonStatus = "";
                      }
                      if (isset($_GET['LeadPersonCreatedAt'])) {
                        $LeadPersonCreatedAt = $_GET['LeadPersonCreatedAt'];
                      } else {
                        $LeadPersonCreatedAt = date("Y-m-d");
                      }

                      ?>
                      <form action="" method="get">
                        <input type="date" name="LeadPersonCreatedAt" value="<?php echo $LeadPersonCreatedAt; ?>" hidden>
                        <input type="text" hidden="" name="LeadPersonStatus" value="<?php echo $LeadPersonStatus; ?>">
                        <input type="text" hidden="" name="LeadPersonManagedBy" value="<?php echo $LeadPersonManagedBy; ?>">
                        <select class="form-control" name="LeadPersonCreatedBy" onchange="form.submit()">
                          <option value="">Filter By Lead Created By</option>
                          <?php
                          $LeadCreatedByData = FetchConvertIntoArray("SELECT * FROM leads GROUP BY LeadPersonCreatedBy", true);
                          if ($LeadCreatedByData != null) {
                            foreach ($LeadCreatedByData as $data2) {
                              if (isset($_GET['LeadPersonCreatedBy'])) {
                                if ($_GET['LeadPersonCreatedBy'] == $data2->LeadPersonCreatedBy) {
                                  $active2 = "selected";
                                } else {
                                  $active2 = "";
                                }
                              } else {
                                $active2 = "";
                              }
                          ?>
                              <option value="<?php echo $data2->LeadPersonCreatedBy; ?>" <?php echo $active2; ?>><?php echo FETCH("SELECT * FROM users where id='" . $data2->LeadPersonCreatedBy . "'", "name"); ?> @ <?php echo FETCH("SELECT * FROM users where id='" . $data2->LeadPersonCreatedBy . "'", "phone"); ?></option>
                          <?php
                            }
                          }  ?>
                        </select>
                      </form>
                    </div>
                    <div class="col-md-2">
                      <?php
                      if (isset($_GET['LeadPersonCreatedBy'])) {
                        $LeadPersonCreatedBy = $_GET['LeadPersonCreatedBy'];
                      } else {
                        $LeadPersonCreatedBy = "";
                      }

                      if (isset($_GET['LeadPersonStatus'])) {
                        $LeadPersonStatus = $_GET['LeadPersonStatus'];
                      } else {
                        $LeadPersonStatus = "";
                      }

                      if (isset($_GET['LeadPersonCreatedAt'])) {
                        $LeadPersonCreatedAt = $_GET['LeadPersonCreatedAt'];
                      } else {
                        $LeadPersonCreatedAt = date("Y-m-d");
                      }

                      ?>
                      <form action="" method="get">
                        <input type="date" name="LeadPersonCreatedAt" value="<?php echo $LeadPersonCreatedAt; ?>" hidden>
                        <input type="text" hidden="" name="LeadPersonStatus" value="<?php echo $LeadPersonStatus; ?>">
                        <input type="text" hidden="" name="LeadPersonCreatedBy" value="<?php echo $LeadPersonCreatedBy; ?>">
                        <select class="form-control" name="LeadPersonManagedBy" onchange="form.submit()">
                          <option value="">Filter By Lead Assigned</option>
                          <?php
                          $LeadPersonManagedByData = FetchConvertIntoArray("SELECT * FROM leads GROUP BY LeadPersonManagedBy", true);
                          if ($LeadPersonManagedByData != null) {
                            foreach ($LeadPersonManagedByData as $data3) {
                              if (isset($_GET['LeadPersonManagedBy'])) {
                                if ($_GET['LeadPersonManagedBy'] == $data3->LeadPersonManagedBy) {
                                  $active3 = "selected";
                                } else {
                                  $active3 = "";
                                }
                              } else {
                                $active3 = "";
                              }
                          ?>
                              <option value="<?php echo $data3->LeadPersonManagedBy; ?>" <?php echo $active3; ?>><?php echo FETCH("SELECT * FROM users where id='" . $data3->LeadPersonManagedBy . "'", "name"); ?> @ <?php echo FETCH("SELECT * FROM users where id='" . $data3->LeadPersonManagedBy . "'", "phone"); ?></option>
                          <?php
                            }
                          }  ?>
                        </select>
                      </form>
                    </div>
                    <div class="col-md-2">
                      <?php
                      if (isset($_GET['LeadPersonCreatedBy'])) {
                        $LeadPersonCreatedBy = $_GET['LeadPersonCreatedBy'];
                      } else {
                        $LeadPersonCreatedBy = "";
                      }

                      if (isset($_GET['LeadPersonStatus'])) {
                        $LeadPersonStatus = $_GET['LeadPersonStatus'];
                      } else {
                        $LeadPersonStatus = "";
                      }

                      if (isset($_GET['LeadPersonManagedBy'])) {
                        $LeadPersonManagedBy = $_GET['LeadPersonManagedBy'];
                      } else {
                        $LeadPersonManagedBy = "";
                      }

                      if (isset($_GET['LeadPersonCreatedAt'])) {
                        $LeadPersonCreatedAt = $_GET['LeadPersonCreatedAt'];
                      } else {
                        $LeadPersonCreatedAt = date("Y-m-d");
                      }
                      ?>
                      <form action="" method="get">
                        <input type="text" hidden="" name="LeadPersonManagedBy" value="<?php echo $LeadPersonManagedBy; ?>">
                        <input type="text" hidden="" name="LeadPersonStatus" value="<?php echo $LeadPersonStatus; ?>">
                        <input type="text" hidden="" name="LeadPersonCreatedBy" value="<?php echo $LeadPersonCreatedBy; ?>">
                        <input type="date" name="LeadPersonCreatedAt" value="<?php echo $LeadPersonCreatedAt; ?>" class="form-control" onchange="form.submit()">
                      </form>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <?php if (isset($_GET['LeadPersonStatus'])) {
                          $ListHeading = "All " . ucfirst(str_replace("_", " ", $_GET['LeadPersonStatus']))  . " Leads";
                        } else {
                          $ListHeading = "All Active leads";
                        } ?>
                        <h4 class="section-heading"><?php echo $ListHeading; ?>
                          <?php if (isset($_GET['LeadPersonCreatedAt'])) { ?>
                            <a href="index.php" class="btn btn-sm btn-danger pull-right" style="margin-top:-0.3rem;"><i class="fa fa-times"></i> Clear Search</a>
                          <?php } ?>
                        </h4>
                        <p class="text-grey fs-12"><i class="fa fa-star text-danger fa-spin fs-12"></i> All Leads listing order is as per their need or approx purchase date mentioned during lead entry time.</p>
                        <div class="row">
                          <?php
                          if (isset($_GET['LeadPersonStatus'])) {
                            $LeadPersonStatus = $_GET['LeadPersonStatus'];
                            $LeadPersonCreatedBy = $_GET['LeadPersonCreatedBy'];
                            $LeadPersonManagedBy = $_GET['LeadPersonManagedBy'];
                            $LeadPersonCreatedAt = $_GET['LeadPersonCreatedAt'];
                            $GetLeads = FetchConvertIntoArray("SELECT * FROM leads where DATE(LeadPersonCreatedAt)='$LeadPersonCreatedAt' and LeadPersonManagedBy LIKE '%$LeadPersonManagedBy%' and LeadPersonStatus like '%$LeadPersonStatus%' and LeadPersonCreatedBy LIKE '%$LeadPersonCreatedBy%' ORDER BY  DATE(LeadPersonNeeddate) DESC", true);
                          } else {
                            $LOGIN_UserId = LOGIN_UserId;
                            $GetLeads = FetchConvertIntoArray("SELECT * FROM leads where LeadPersonStatus!='APPROVED_WON' and LeadPersonStatus!='REJECTED_LOST' OR LeadPersonCreatedBy='$LOGIN_UserId' OR LeadPersonManagedBy='$LOGIN_UserId'  ORDER by DATE(LeadPersonNeeddate) DESC", true);
                          }

                          if ($GetLeads == null) { ?>
                            <div class="col-md-4">
                              <div class="card card-body border-0 shadow-sm">
                                <div class="text-left">
                                  <h1><i class="fa fa-globe fa-spin display-4 text-success"></i></h1>
                                  <h4 class="text-muted">No leads found</h4>
                                  <p class="text-muted">You can add a new lead by clicking the button above.</p>
                                  <a href="add.php" class="btn btn-md btn-primary">Add leads</a>
                                </div>
                              </div>
                            </div>
                            <?php } else {
                            $Count = 0;
                            foreach ($GetLeads as $leads) {
                              $Count++;
                              $LeadPersonCreatedBy = $leads->LeadPersonCreatedBy;
                            ?>
                              <div class="col-md-12 m-b-3">
                                <div class="m-0 rounded-2 p-0 bg-white">
                                  <a href="details/index.php?LeadsId=<?php echo SECURE($leads->LeadsId, "e"); ?>" class="flex-s-b">
                                    <p class="m-b-0 fs-12 data-list-style">
                                      <span class="text-primary"><span class="right-btn-i"><?php echo $Count; ?></span>
                                        <i class="fa fa-angle-right text-warning"></i>
                                        <span class="text-grey"><?php echo $leads->LeadSalutations; ?></span> <?php echo $leads->LeadPersonFullname; ?></span> |
                                      <span class="text-grey"><?php echo $leads->LeadPersonCompanyType; ?></span> |
                                      <span><?php echo LeadStage($leads->LeadPersonStatus); ?></span> |
                                      <span><?php echo LeadStatus($leads->LeadPriorityLevel); ?></span>
                                      <?php DisplayReminder($leads->LeadsId); ?>
                                    </p>
                                    <span class="m-r-5 m-t-5 fs-12">
                                      <span class='right-btn-i text-grey'>
                                        <i class="fa fa-calendar"></i> <?php echo DATE_FORMATE2("d M, Y", $leads->LeadPersonCreatedAt); ?>
                                        <i class="fa fa-angle-right fs-15"></i>
                                      </span>
                                    </span>
                                  </a>
                                </div>
                              </div>
                            <?php } ?>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end -->
    <?php include '../sidebar.php'; ?>
    <?php include '../footer.php'; ?>
  </div>

  <?php include '../../include/footer_files.php'; ?>

</body>

</html>