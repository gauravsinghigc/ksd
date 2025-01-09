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
  <title>Booking failed | <?php echo company_name; ?></title>
  <?php include '../../include/header_files.php'; ?>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../header.php'; ?>

    <!--END NAVBAR-->
    <div class="boxed">
      <!--CONTENT CONTAINER-->
      <!--===================================================-->
      <div id="content-container">
        <div class="pageheader hidden-xs">
          <h3>Booking B<?php echo $_SESSION['booking_id']; ?> Creation Failed!</h3>
        </div>
        <!--Page content-->
        <div id="page-content">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-12 text-center">
              <div class="panel square">
                <div class="panel-body">
                  <img src="https://media0.giphy.com/media/lQD1lvFH1wKXePWWlg/giphy.gif?cid=6c09b952227739ff60e199137ba3ed8cd1be29eacc0441dd&rid=giphy.gif&ct=s" class="img-fluid w-50" style="width:30% !important;"><br>
                  <h4>Unable to Create Booking At Moment!</h4><br>
                  <a href="<?php echo DOMAIN; ?>/admin/booking/index.php" class="btn btn-info"><i class="fa fa-angle-left"></i> Back to Bookings</a>
                  <a class="btn btn-primary" target="blank" href="<?php echo DOMAIN; ?>/admin/booking/booking_exports.php?id=<?php echo $_SESSION['booking_id']; ?>"><i class="fa fa-print"></i> Print Receipt <i class="fa fa-angle-right"></i></a>
                  <br><br>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end -->
      </div>
      <!--===================================================-->
      <!--END CONTENT CONTAINER-->



      <!-- end -->
      <?php include '../sidebar.php'; ?>
      <?php include '../footer.php'; ?>
    </div>

    <?php include '../../include/footer_files.php'; ?>
</body>

</html>f