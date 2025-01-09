<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

if (isset($_GET['id'])) {
  $ViewCustomerId = $_GET['id'];
  $_SESSION['USER_VIEW_ID_AGENT_DASHBOARD'] = $_GET['id'];
} else {
  $ViewCustomerId = $_SESSION['USER_VIEW_ID_AGENT_DASHBOARD'];
}
require "../../../include/admin/page-header-req/user-profile-req.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Dashboard | <?php echo company_name; ?></title>
  <?php include '../../../include/header_files.php'; ?>
  <script>
    window.onload = function() {
      document.getElementById("commission_paid").classList.add("app-bg");
    }
  </script>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../../header.php'; ?>
    <!--END NAVBAR-->
    <div class="boxed">
      <!--CONTENT CONTAINER-->
      <!--===================================================-->
      <div id="content-container">
        <!--===================================================-->
        <div id="page-content">
          <div class="panel">
            <div class="panel-body">
              <div class="row">
                <?php include 'user-info.php'; ?>
                <div class="col-md-12">
                  <h3 class='app-sub-heading'>ALL Commission Lists</h3>

                  <?php
                  $commission_amount_total = 0;
                  $SQL_commissions = SELECT("SELECT * FROM  commission where commission.partner_id='$ViewCustomerId'  ORDER BY commission.commission_id DESC");
                  $SerialNo = 0;
                  while ($FetchCommission = mysqli_fetch_array($SQL_commissions)) {
                    $SerialNo++;
                    $commission_id = $FetchCommission['commission_id'];
                    $commission_amount_total += (int)$FetchCommission['commission_amount'];
                    $PayoutSql = "SELECT * FROM commission_payouts where commission_id='$commission_id'";
                    $commission_amount = $FetchCommission['commission_amount']; ?>
                    <div class="data-list flex-s-b">
                      <span class="w-pr-2">
                        <span class='text-grey'>Sno</span><br>
                        <span><?php echo $SerialNo; ?></span>
                      </span>
                      <span class="w-pr-7">
                        <span class='text-grey'>BookingId</span><br>
                        <span>
                          <a class="text-primary" target="_blank" href="<?php echo DOMAIN; ?>/admin/booking/details/?id=<?php echo $FetchCommission['booking_id']; ?>">B<?php echo $FetchCommission['booking_id']; ?>/<?php echo date("m/Y", strtotime($FetchCommission['created_at'])); ?></a>
                        </span>
                      </span>
                      <span class="w-pr-7">
                        <span class='text-grey'>UnitName</span><br>
                        <span><?php
                              $project_unit_id = FETCH("SELECT * FROM bookings where bookingid='" . $FetchCommission['booking_id'] . "'", "project_unit_id");
                              $Area = FETCH("SELECT * FROM project_units where project_units_id='$project_unit_id'", "project_unit_area");
                              $ProjectUnitType = FETCH("SELECT * FROM project_units where project_units_id='$project_unit_id'", "projects_unit_type");
                              echo UpperCase(FETCH("SELECT * FROM bookings where bookingid='" . $FetchCommission['booking_id'] . "'", "unit_name")) . " (" . $ProjectUnitType . ")"; ?></span>
                      </span>
                      <span class="w-pr-10">
                        <span class='text-grey'>UnitArea</span><br>
                        <span>
                          <?php echo FETCH("SELECT * FROM bookings where bookingid='" . $FetchCommission['booking_id'] . "'", "unit_area"); ?>
                        </span>
                      </span>
                      <span class="w-pr-10">
                        <span class='text-grey'>NetUnitCost</span><br>
                        <span><?php echo Price(FETCH("SELECT * FROM bookings where bookingid='" . $FetchCommission['booking_id'] . "'", "net_payable_amount"), "text-success", "Rs."); ?></span>
                      </span>
                      <span class="w-pr-7">
                        <span class='text-grey'>PayType</span><br>
                        <span><?php echo strtoupper($FetchCommission['commission_type']); ?></span>
                      </span>
                      <span class="w-pr-7">
                        <span class='text-grey'>EligiblePayment.</span><br>
                        <span><?php echo Price($Payable = $FetchCommission['commission_amount'], "text-success", "Rs."); ?></span>
                      </span>
                      <span class="w-pr-7">
                        <span class='text-grey'>AmountPaid.</span><br>
                        <span><?php echo Price($Amount = AMOUNT("SELECT * FROM commission_payouts where partner_id='$ViewCustomerId' and commission_id='$commission_id'", "commission_payout_amount"), "text-success", "Rs."); ?></span>
                      </span>
                      <span class="w-pr-8">
                        <span class='text-grey'>CreatedAt</span><br>
                        <span><?php echo DATE_FORMATE2("d M, Y", $FetchCommission['created_at']); ?></span>
                      </span>
                      <span class="w-pr-7">
                        <span class='text-grey'>Status</span><br>
                        <span>
                          <?php
                          if ($Amount >= $Payable) {
                            echo "<span class='text-success'><i class='fa fa-check'></i> Paid</span>";
                          } else {
                            echo "<span class='text-danger'><i class='fa fa-warning'></i> Un-Paid</span>";
                          } ?>
                        </span>
                      </span>
                      <span class="w-pr-8">
                        <span class='text-grey'>LastPayment</span><br>
                        <span><?php echo DATE_FORMATE2("d M, Y", FETCH($PayoutSql, "commission_payout_date")); ?></span>
                      </span>

                      <span class="w-pr-10 text-right">
                        <span class='text-grey'>Action</span><br>
                        <span>
                          <a href="edit-commission.php?bookingid=<?php echo $FetchCommission['booking_id'];  ?>&search_type=id&search_value=<?php echo $ViewCustomerId; ?>&partner_id=<?php echo $ViewCustomerId; ?>&commission_id=<?php echo $FetchCommission['commission_id']; ?>" class="text-primary m-r-3"><i class="fa fa-edit text-info"></i> Update Payment </a>
                        </span>
                      </span>
                    </div>
                  <?php } ?>


                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include '../../sidebar.php'; ?>
    <?php include '../../footer.php'; ?>
  </div>

  <?php include '../../../include/footer_files.php'; ?>
</body>

</html>