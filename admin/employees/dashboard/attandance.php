<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Dashboard | <?php echo company_name; ?></title>
   <?php include '../../../include/header_files.php'; ?>
</head>

<body>
   <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
      <?php include '../../header.php';
      if (isset($_GET['id'])) {
         $ViewCustomerId = $_GET['id'];
         $_SESSION['USER_VIEW_ID'] = $_GET['id'];
      } else {
         $ViewCustomerId = $_SESSION['USER_VIEW_ID'];
      }
      $CustomerId = $ViewCustomerId;
      $Select_Users = "SELECT * FROM users where id='$CustomerId'";
      $Query = mysqli_query($DBConnection, $Select_Users);
      $Customers = mysqli_fetch_assoc($Query);
      $C_user_role_id = $Customers['user_role_id'];
      $C_name = $Customers['name'];
      $C_email = $Customers['email'];
      $C_phone = $Customers['phone'];
      $C_user_profile_img = $Customers['user_profile_img'];
      $C_created_at = $Customers['created_at'];
      $C_updated_at = $Customers['updated_at'];
      $C_password = $Customers['password'];
      $C_company_relation_id = $Customers['company_relation'];
      if ($C_user_profile_img == null or $C_user_profile_img == "user.png") {
         $C_user_profile_img = DOMAIN . "/storage/sys-img/user.png";
      } else {
         $C_user_profile_img = DOMAIN . "/storage/users/$CustomerId/img/$C_user_profile_img";
      }
      //customer address
      $C_FetchAddress = SELECT("SELECT * FROM user_address where user_id='$CustomerId'");
      $C_IfExits = mysqli_num_rows($C_FetchAddress);
      if ($C_IfExits == 0) {
         $C_user_street_address = "";
         $C_user_area_locality = "";
         $C_user_state = "";
         $C_user_city = "";
         $C_user_pincode = "";
         $C_created_at = "";
         $C_updated_at = "";
         $C_user_country = "";
      } else {
         $C_fetchAdd = mysqli_fetch_array($C_FetchAddress);
         $C_user_street_address = htmlentities($C_fetchAdd['user_street_address']);
         $C_user_area_locality = $C_fetchAdd['user_area_locality'];
         $C_user_city = $C_fetchAdd['user_city'];
         $C_user_state = $C_fetchAdd['user_state'];
         $C_user_pincode = $C_fetchAdd['user_pincode'];
         $C_user_country = $C_fetchAdd['user_country'];
         $C_created_at = $C_fetchAdd['created_at'];
         $C_updated_at = $C_fetchAdd['updated_at'];
      }

      //customer type
      $C_Select_UsersTypes = SELECT("SELECT * from user_roles where role_id='$C_user_role_id'");
      $C_UserTypes = mysqli_fetch_assoc($C_Select_UsersTypes);
      $C_role_name = $C_UserTypes['role_name'];

      //employeement 
      $EmpSql = "SELECT * FROM user_employments where UserEmpMainUserId='$ViewCustomerId'";
      $REQ_UserId = $ViewCustomerId; ?>
      <!--END NAVBAR-->
      <div class="boxed">
         <!--CONTENT CONTAINER-->
         <!--===================================================-->
         <div id="content-container">
            <!--Page content-->
            <!--===================================================-->
            <div id="page-content">
               <div class="panel">
                  <div class="panel-body">
                     <div class="row">
                        <div class="col-md-12">
                           <h3 class="m-t-3"><i class="fa fa-user app-text"></i> Employee Details</h3>
                        </div>
                        <?php include "c-profile.php"; ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12 c-dashboard-padding">
                           <?php include "common-nav.php"; ?>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-md-12">
                           <h4 class="section-heading">Attandance Records</h4>
                        </div>
                     </div>
                     <form action="<?php echo CONTROLLER; ?>/empcontroller.php" method="POST">
                        <?php FormPrimaryInputs(true, [
                           "UserAttandanceMainUserId" => $REQ_UserId
                        ]); ?>
                        <div class="row mb-10px">
                           <div class="col-md-2 form-group">
                              <label>Check-in Date</label>
                              <input type="date" readonly="" name="UserAttandanceStartDate" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                           </div>
                           <div class="col-md-2 form-group">
                              <label>Check-in Time</label>
                              <input type="time" readonly="" id="at_times" name="UserAttandanceStartTime" class="form-control" value="">
                              <script>
                                 window.setInterval(function() {
                                    var todays = new Date();
                                    var times = todays.getHours() + ":" + todays.getMinutes() + ":" + todays.getSeconds();
                                    document.getElementById("at_times").value = times;
                                 }, 1000);
                              </script>
                           </div>
                           <div class="col-md-2 form-group">
                              <label>Status</label>
                              <select name="UserAttandanceStatus" id="at_status" onchange="CheckLeaves()" class="form-control" required="">
                                 <option value="PRESENT">PRESENT</option>
                                 <option value="ABSANT">ABSANT</option>
                                 <option value="WORK_FROM_HOME">WORK FROM HOME</option>
                                 <option value="LEAVE">LEAVE</option>
                              </select>
                           </div>
                           <div class="col-md-4 form-group hidden" id="leavenote">
                              <label>Enter Reason</label>
                              <textarea name="UserAttandanceNotes" class="form-control" rows="3"></textarea>
                           </div>
                           <div class="col-md-2">
                              <button type="submit" name="AttandanceRecords" class="btn btn-md btn-success mt-25px">Save Records</button>
                           </div>
                        </div>
                     </form>

                     <div class="row mb-5px">
                        <div class="col-md-12">
                           <h5 class="app-sub-heading">Open/Pending/Un-Check-out Attandances</h5>
                           <?php
                           $sql = "SELECT * FROM user_attandances where UserAttandanceMainUserId='$REQ_UserId' and UserAttandanceEndTime='null' and UserAttandanceEndDate='null' GROUP BY UserAttandanceMonth ORDER BY DATE('UserAttandanceStartDate') DESC";
                           $FetchAttandances = FetchConvertIntoArray("$sql", true);
                           if ($FetchAttandances != null) {
                              foreach ($FetchAttandances as $Record) {
                                 $MonthGroup = $date = $Record->UserAttandanceMonth; ?>
                                 <form action="<?php echo CONTROLLER; ?>/empcontroller.php" method="POST">
                                    <?php FormPrimaryInputs(true, [
                                       "UserAttandanceId" => $Record->UserAttandanceId,
                                    ]) ?>
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
                              NoData("No Pending Record Found!");
                           } ?>
                           <h5 class="app-sub-heading">Monthly Attandance History</h5>
                           <?php if (isset($_GET['month-group']) && isset($_GET['monthview'])) {
                              $ReqMonthGroup = $_GET['month-group']; ?>
                              <div class="flex-s-b mb-5px">
                                 <h4>Attandance Record for : <b><?php echo $_GET['month-group']; ?></b></h4>
                                 <a href="attandance.php" class="btn btn-sm btn-primary">Hide Record</a>
                              </div>
                              <table class="table table-striped">
                                 <tr>
                                    <th>Date</th>
                                    <th>Month</th>
                                    <th>Check-in/IP</th>
                                    <th>Check-Out/IP</th>
                                    <th>Work Hours</th>
                                    <th>WorkDayCount</th>
                                    <th>Status/Note</th>
                                 </tr>
                                 <?php
                                 $sql2 = "SELECT * FROM user_attandances where UserAttandanceMainUserId='$REQ_UserId' and UserAttandanceMonth='$ReqMonthGroup' ORDER BY DATE('UserAttandanceStartDate') DESC";
                                 $FetchAttandances = FetchConvertIntoArray("$sql2", true);
                                 if ($FetchAttandances != null) {
                                    $TotalHours = 0;
                                    $TotalDays = 0;
                                    foreach ($FetchAttandances as $Record) {
                                       $MonthGroup = $date = $Record->UserAttandanceMonth;
                                       $CheckIN = $Record->UserAttandanceStartDate . " " . $Record->UserAttandanceStartTime;
                                       $CheckOUT = $Record->UserAttandanceEndDate . " " . $Record->UserAttandanceEndTime;
                                       $WorkingHoursTotal = GetHours($CheckIN, $CheckOUT);
                                       $WorkDaysTotal = round($WorkingHoursTotal / REQUIRED_WORK_HOURS_PER_DAY, 1);
                                       $TotalHours += $WorkingHoursTotal;
                                       $TotalDays += $WorkDaysTotal; ?>
                                       <tr>
                                          <td><span class="bold text-primary"><?php echo DATE_FORMATE2("d M, Y", strtoupper($Record->UserAttandanceStartDate)); ?></span></td>
                                          <td><?php echo strtoupper($MonthGroup); ?></td>
                                          <td><?php echo $Record->UserAttandanceStartIP; ?></td>
                                          <td><?php echo $Record->UserAttandanceEndIP; ?></td>
                                          <td>
                                             <?php echo $WorkingHoursTotal; ?> Hrs.
                                          </td>
                                          <td>
                                             <?php echo $WorkDaysTotal; ?> Days
                                          </td>
                                          <td><?php echo $Record->UserAttandanceStatus; ?></td>
                                       </tr>
                                    <?php
                                    } ?>
                                    <tr>
                                       <td colspan="4" align="right"><b>Total Work Hours : </b><?php echo $TotalHours; ?> Hrs.</td>
                                       <td colspan="3" class="text-center"><b>Total Work Days: </b><?php echo $TotalDays; ?> Days</td>
                                    </tr>
                                 <?php
                                 } ?>
                              </table>
                           <?php } ?>
                           <table class="table table-striped">
                              <thead>
                                 <tr>
                                    <th>Month-Year</th>
                                    <th>Presents</th>
                                    <th>Absants</th>
                                    <th>WFH</th>
                                    <th>Leaves</th>
                                    <th>WorkHours</th>
                                    <th>WorkDays</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                 $sql = "SELECT * FROM user_attandances where UserAttandanceMainUserId='$REQ_UserId' GROUP BY UserAttandanceMonth ORDER BY DATE('UserAttandanceStartDate') DESC";
                                 $FetchAttandances = FetchConvertIntoArray("$sql", true);

                                 if ($FetchAttandances != null) {
                                    $TotalHours = 0;
                                    $TotalDays = 0;
                                    foreach ($FetchAttandances as $Record) {
                                       $MonthGroup = $date = $Record->UserAttandanceMonth;
                                       $CheckIN = $Record->UserAttandanceStartDate . " " . $Record->UserAttandanceStartTime;
                                       $CheckOUT = $Record->UserAttandanceEndDate . " " . $Record->UserAttandanceEndTime;
                                       $WorkingHours = GetHours($CheckIN, $CheckOUT);
                                       $WorkDays = round($WorkingHours / REQUIRED_WORK_HOURS_PER_DAY, 1);

                                       //count total work hours and days
                                       $sql2 = "SELECT * FROM user_attandances where UserAttandanceMainUserId='$REQ_UserId' and UserAttandanceMonth='$MonthGroup' ORDER BY DATE('UserAttandanceStartDate') DESC";
                                       $FetchAttandances = FetchConvertIntoArray("$sql2", true);
                                       if ($FetchAttandances != null) {
                                          foreach ($FetchAttandances as $Record) {
                                             $MonthGroup = $date = $Record->UserAttandanceMonth;
                                             $CheckIN = $Record->UserAttandanceStartDate . " " . $Record->UserAttandanceStartTime;
                                             $CheckOUT = $Record->UserAttandanceEndDate . " " . $Record->UserAttandanceEndTime;
                                             $WorkingHoursTotal = GetHours($CheckIN, $CheckOUT);
                                             $WorkDaysTotal = round($WorkingHoursTotal / REQUIRED_WORK_HOURS_PER_DAY, 1);
                                             $TotalHours += $WorkingHoursTotal;
                                             $TotalDays += $WorkDaysTotal;
                                          }
                                       }

                                 ?>
                                       <tr>
                                          <td><span class="bold text-primary"><?php echo strtoupper($MonthGroup); ?></span></td>
                                          <td class="bold"><?php echo TOTAL("SELECT * FROM user_attandances where UserAttandanceMainUserId='$REQ_UserId' and UserAttandanceMonth='" . $date . "' and UserAttandanceStatus='PRESENT'"); ?></td>
                                          <td class="bold"><?php echo TOTAL("SELECT * FROM user_attandances where UserAttandanceMainUserId='$REQ_UserId' and UserAttandanceMonth='" . $date . "' and UserAttandanceStatus='ABSANT'"); ?></td>
                                          <td class="bold"><?php echo TOTAL("SELECT * FROM user_attandances where UserAttandanceMainUserId='$REQ_UserId' and UserAttandanceMonth='" . $date . "' and UserAttandanceStatus='WORK_FROM_HOME'"); ?></td>
                                          <td class="bold"><?php echo TOTAL("SELECT * FROM user_attandances where UserAttandanceMainUserId='$REQ_UserId' and UserAttandanceMonth='" . $date . "' and UserAttandanceStatus='LEAVE'"); ?></td>
                                          <td>
                                             <?php echo $TotalHours; ?> Hrs.
                                          </td>
                                          <td>
                                             <?php echo $TotalDays; ?> Days
                                          </td>
                                          <td>
                                             <a href="?monthview=true&month-group=<?php echo $MonthGroup; ?>" class="text-primary bold">View Day Chart</a>
                                          </td>
                                       </tr>
                                 <?php
                                    }
                                 }
                                 ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <script>
         function CheckLeaves() {
            var at_status = document.getElementById("at_status");

            if (at_status.value == "LEAVE" || at_status.value == "WORK_FROM_HOME") {
               document.getElementById("leavenote").style.display = "block";
            } else {
               document.getElementById("leavenote").style.display = "none";
            }
         }
      </script>



      <!-- end -->
      <?php include '../../sidebar.php'; ?>
      <?php include '../../footer.php'; ?>
   </div>

   <?php include '../../../include/footer_files.php'; ?>
</body>

</html>