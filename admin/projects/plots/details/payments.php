<?php
require '../../../../require/modules.php';
require "../../../../require/admin/sessionvariables.php";
require '../../../../include/admin/common.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Plots | <?php echo company_name; ?></title>
  <?php include '../../../../include/header_files.php'; ?>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../../../header.php'; ?>

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


                  <?php
                  include "sections/customer-project-details.php";
                  include "sections/project-resale-counter.php";
                  include "sections/navbar.php";
                  ?>

                  <!--===== TABLE SECTION ======-->
                  <section class="table-list">
                    <h4>All Payments</h4>
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">S.No.</th>
                          <th scope="col">PaymentRefId</th>
                          <th scope="col">BookingId</th>
                          <th scope="col">ProjectName</th>
                          <th scope="col">UnitName</th>
                          <th scope="col">UnitArea</th>
                          <th scope="col">PaymentMode</th>
                          <th scope="col">PaymentDate</th>
                          <th scope="col">PaymentType</th>
                          <th scope="col">PaidAmount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>B1/P1/T1/D2652022</td>
                          <td>B1/10/2022</td>
                          <td>YASH VIHAR</td>
                          <td>P01</td>
                          <td>146.38 SQ YARDS</td>
                          <td>CHEQUE</td>
                          <td>18 Aug, 2022</td>
                          <td>BOOKING</td>
                          <td>Rs.51,000</td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td>B1/P1/T1/D15082022</td>
                          <td>B1/10/2022</td>
                          <td>YASH VIHAR</td>
                          <td>P01</td>
                          <td>146.38 SQ YARDS</td>
                          <td>CHEQUE</td>
                          <td>18 Sept, 2022</td>
                          <td>Month EMI</td>
                          <td>Rs.25,000</td>
                        </tr>
                      </tbody>
                    </table>
                  </section>
                  <section class="footer-calculation">
                    <ul class="list-group">
                      <li class="list-group-item text-end d-flex justify-content-end">
                        <p class="">
                          <span class="text-secondary">Net Payable Amount:</span>
                          <span class="text-success">Rs.20,23,516</span><br>
                          <span class="text-dark">rupees twenty lakhs twenty three thousands five hundred and sixteen Only</span>
                        </p>
                      </li>
                      <li class="list-group-item text-end d-flex justify-content-end">
                        <p>
                          <span class="text-secondary">Net Payable Amount:</span>
                          <span class="text-primary">Rs.5,00,000</span><br>
                          <span class="text-dark">rupees five lakh Only</span>
                        </p>
                      </li>
                      <li class="list-group-item text-end d-flex justify-content-end">
                        <p>
                          <span class="text-secondary">Net Payable Amount:</span>
                          <span class="text-danger">Rs.15,23,516</span><br>
                          <span class="text-dark">rupees fifteen lakhs twenty three thousands five hundred and sixteen Only</span>
                        </p>
                      </li>
                    </ul>
                  </section>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>





    <!-- end -->
    <?php include '../../../sidebar.php'; ?>
    <?php include '../../../footer.php'; ?>

  </div>

  <?php include '../../../../include/footer_files.php'; ?>
</body>

</html>