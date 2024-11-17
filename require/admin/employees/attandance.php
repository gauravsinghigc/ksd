<?php
require '../../require/modules.php';
require "../../require/admin/sessionvariables.php";
require '../../include/admin/common.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Attadance | <?php echo company_name; ?></title>
  <?php include '../../include/header_files.php'; ?>
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
                    <div class="col-md-12">
                      <h3 class="m-t-3"><i class="fa fa-calendar app-text"></i> Add Attadance Records</h3>
                    </div>
                  </div>
                  <?php
                  $Employees = FetchConvertIntoArray("SELECT * FROM users where users.user_role_id='5'", true);
                  if ($Employees == null) {
                    NoData("No Employee Found!", [
                      "url" => ADMIN_URL . "/employees/index.php",
                      "name" => "Add Employees",
                      "target" => "_blank",
                      "class" => "btn btn-sm btn-primary m-l-5"
                    ]);
                  } else {
                    foreach ($Employees as $Employee) {
                      $REQ_UserId = $Employee->id ?>
                      <form action="<?php echo CONTROLLER; ?>/empcontroller.php" method="POST">
                        <?php FormPrimaryInputs(true, [
                          "UserAttandanceMainUserId" => $REQ_UserId
                        ]); ?>
                        <div class="row">
                          <div class="col-md-12">
                            <a href="dashboard/index.php?id=<?php echo $REQ_UserId; ?>">
                              <h3><i class="fa fa-briefcase text-success"></i> <span class="text-primary"><?php echo $Employee->name; ?></span> | <small><?php echo $Employee->email; ?></small>, <small><?php echo $Employee->phone; ?></small></h3>
                            </a>
                          </div>
                        </div>
                        <div class="row mb-10px">
                          <div class="col-md-2 form-group">
                            <label>Check-in Date</label>
                            <input type="date" readonly="" name="UserAttandanceStartDate" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                          </div>
                          <div class="col-md-2 form-group">
                            <label>Check-in Time</label>
                            <input type="time" readonly="" id="at_times_<?php echo $REQ_UserId; ?>" name="UserAttandanceStartTime" class="form-control" value="">
                            <script>
                              window.setInterval(function() {
                                var todays_<?php echo $REQ_UserId; ?> = new Date();
                                var times_<?php echo $REQ_UserId; ?> = todays_<?php echo $REQ_UserId; ?>.getHours() + ":" + todays_<?php echo $REQ_UserId; ?>.getMinutes() + ":" + todays_<?php echo $REQ_UserId; ?>.getSeconds();
                                document.getElementById("at_times_<?php echo $REQ_UserId; ?>").value = times_<?php echo $REQ_UserId; ?>;
                              }, 1000);
                            </script>
                          </div>
                          <div class="col-md-2 form-group">
                            <label>Status</label>
                            <select name="UserAttandanceStatus" id="at_status_<?php echo $REQ_UserId; ?>" onchange="CheckLeaves_<?php echo $REQ_UserId; ?>()" class="form-control" required="">
                              <option value="PRESENT">PRESENT</option>
                              <option value="ABSANT">ABSANT</option>
                              <option value="WORK_FROM_HOME">WORK FROM HOME</option>
                              <option value="LEAVE">LEAVE</option>
                            </select>
                          </div>
                          <div class="col-md-4 form-group hidden" id="leavenote_<?php echo $REQ_UserId; ?>">
                            <label>Enter Reason</label>
                            <textarea name="UserAttandanceNotes" class="form-control" rows="1"></textarea>
                          </div>
                          <div class="col-md-2">
                            <button type="submit" name="AttandanceRecords" class="btn btn-md btn-success mt-25px">Add Attandance</button>
                          </div>
                        </div>
                      </form>
                      <script>
                        function CheckLeaves_<?php echo $REQ_UserId; ?>() {
                          var at_status_<?php echo $REQ_UserId; ?> = document.getElementById("at_status_<?php echo $REQ_UserId; ?>");

                          if (at_status_<?php echo $REQ_UserId; ?>.value == "LEAVE" || at_status_<?php echo $REQ_UserId; ?>.value == "WORK_FROM_HOME") {
                            document.getElementById("leavenote_<?php echo $REQ_UserId; ?>").style.display = "block";
                          } else {
                            document.getElementById("leavenote_<?php echo $REQ_UserId; ?>").style.display = "none";
                          }
                        }
                      </script>


                  <?php
                    }
                  } ?>

                  <div class="row mb-5px">
                    <div class="col-md-12">
                      <h5 class="app-sub-heading">Open/Pending/Un-Check-out Attandances</h5>
                      <?php
                      $sql = "SELECT * FROM user_attandances where UserAttandanceEndTime='null' and UserAttandanceEndDate='null' and DATE(UserAttandanceStartDate)='" . DATE('Y-m-d') . "' ORDER BY UserAttandanceId DESC";
                      $FetchAttandances = FetchConvertIntoArray($sql, true);
                      if ($FetchAttandances != null) {
                        foreach ($FetchAttandances as $Record) {
                          $MonthGroup = $date = $Record->UserAttandanceMonth;
                          $SqlEmp = "SELECT * FROM users where id='" . $Record->UserAttandanceMainUserId . "'";  ?>
                          <form action="<?php echo CONTROLLER; ?>/empcontroller.php" method="POST">
                            <?php FormPrimaryInputs(true, [
                              "UserAttandanceId" => $Record->UserAttandanceId,
                            ]) ?>
                            <div class="row">
                              <div class="col-md-12">
                                <h3><i class="fa fa-briefcase text-success"></i> <span class="text-primary"><?php echo FETCH($SqlEmp, "name"); ?></span> | <small><?php echo FETCH($SqlEmp, "email"); ?></small>, <small><?php echo FETCH($SqlEmp, "phone"); ?></small></h3>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-5">
                                <p class="flex-s-b" style="line-height:18px;">
                                  <span>
                                    <span class="text-grey">Check-in Date</span><br>
                                    <span class="text-black fs-17px"><b><?php echo DATE_FORMATE2("d M, Y", $Record->UserAttandanceStartDate); ?></b></span>
                                  </span>
                                  <span>
                                    <span class="text-grey">Check-in Time</span><br>
                                    <span class="text-black fs-17px"><b><?php echo DATE_FORMATE2("h:m A", $Record->UserAttandanceStartTime); ?></b></span>
                                  </span>
                                  <span>
                                    <span class="text-grey">Status</span><br>
                                    <span class="text-black fs-17px"><?php echo $Record->UserAttandanceStatus; ?></span>
                                  </span>
                                </p>
                              </div>
                              <div class="col-md-7 flex-s-b shadow-sm rounded-1">
                                <div class="form-group">
                                  <label>Check-out Date</label>
                                  <input type="date" readonly="" name="UserAttandanceEndDate" value="<?php echo date('Y-m-d'); ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                  <label>Check-out Time</label>
                                  <input type="time" readonly="" name="UserAttandanceEndTime" id="<?php echo $Record->UserAttandanceId; ?>_times" value="" class="form-control">
                                </div>
                                <script>
                                  window.setInterval(function() {
                                    var today_<?php echo $Record->UserAttandanceId; ?> = new Date();
                                    var times_<?php echo $Record->UserAttandanceId; ?> = today_<?php echo $Record->UserAttandanceId; ?>.getHours() + ":" + today_<?php echo $Record->UserAttandanceId; ?>.getMinutes() + ":" + today_<?php echo $Record->UserAttandanceId; ?>.getSeconds();
                                    document.getElementById("<?php echo $Record->UserAttandanceId; ?>_times").value = times_<?php echo $Record->UserAttandanceId; ?>;
                                  }, 1000);
                                </script>
                                <div>
                                  <button class="btn btn-warning btn-lg" name="CheckOutRecord">Check-out <i class="fa fa-angle-right"></i></button>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <hr>
                              </div>
                            </div>
                          </form>
                      <?php }
                      } else {
                        NoData("No Pending Attandance Found!");
                      } ?>
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