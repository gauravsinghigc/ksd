<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';
require "handler/HeaderRequest.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Receive Other Payments | <?php echo company_name; ?></title>
  <?php include '../../../include/header_files.php'; ?>
  <style>
    table tr th,
    td {
      padding: 2px 4px !important;
    }
  </style>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../../header.php'; ?>

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
                      <h3 class="m-t-3"><i class="fa fa-calendar app-text"></i> Receive Other Payments</h3>
                      <a href="<?php echo ADMIN_URL; ?>/booking/details" class="btn btn-md btn-default"><i class="fa fa-angle-left"></i> Back to Booking Dashboard</a>
                    </div>
                    <form action="../../../controller/bookingcontroller.php" method="POST" class="fs-13 row">
                      <?php FormPrimaryInputs(true, [
                        "project_measure_unit" => MeasurementUnit,
                        "PayReqBookingId" => $bookingid,
                        "PhoneNumber" => FETCH($Select_Users, "phone"),
                        "EmailId" => FETCH($Select_Users, "email"),
                        "Name" => FETCH($Select_Users, "name"),
                        "MainBookingID" => $MainBookingID,
                        "PayReqType" => "OTHER"
                      ]) ?>
                      <div class="col-md-7 col-lg-7 col-12">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="cust-details shadow-lg p-2">
                              <div class="avatar app-bg p-3">
                                <img src="<?php echo $C_user_profile_img; ?>" alt="avatar" class="bg-white w-pr-30">
                                <div class="name osLight fs-20 p-b-2 m-t-7"> <?php echo $C_name ?> </div>
                                <a href="<?PHP echo DOMAIN; ?>/admin/customer/details/?id=<?php echo $customer_id; ?>" class="btn btn-sm btn-primary square float-right m-t-20">View Profile</a>
                              </div>
                              <div class="title text-uppercase m-t-12 text-secondary font-italic"> <?php echo $C_role_name ?> </div>
                              <div class="address p-b-10 p-t-5">
                                <p class="text-grey fs-14 p-l-0 m-l-0 mb-5">
                                  <span><i class="fa fa-phone fs-14 text-info p-0 w-px-20 text-center"></i> : <?php echo $C_phone; ?></span><br>
                                  <span><i class="fa fa-envelope fs-14 text-danger p-0 w-px-20 text-center"></i> : <?php echo $C_email; ?></span><br>
                                  <span><i class="fa fa-map-marker fs-14 text-success p-0 w-px-20 text-center"></i> : <?php echo "$C_user_street_address, $C_user_area_locality, <br>$C_user_city $C_user_state - $C_user_country $C_user_pincode"; ?></span><br>
                                </p>
                                <br>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <h4 class="section-heading mt-0 pt-0">Booking Details</h4>
                            <table class="table table-striped">
                              <tr>
                                <th>Booking ID</th>
                                <td><span class="text-info text-decoration-underline"><?php echo $MainBookingID; ?></span></td>
                              </tr>
                              <tr>
                                <th>Project Name</th>
                                <td><?php echo $project_name; ?></td>
                              </tr>
                              <tr>
                                <th>Project Area</th>
                                <td><?php echo $project_area; ?></td>
                              </tr>
                              <tr>
                                <th>Unit No:</th>
                                <td><?php echo $unit_name; ?></td>
                              </tr>
                              <tr>
                                <th>Unit Area</th>
                                <td><?php echo $unit_area; ?></td>
                              </tr>
                              <tr>
                                <th>Unit Rate</th>
                                <td>Rs.<?php echo $unit_rate; ?> / sq area</td>
                              </tr>
                              <tr>
                                <th>Unit Cost</th>
                                <td><span>Rs.<?php echo $unit_cost; ?></span></td>
                              </tr>
                              <?php if ($charges != 0) { ?>
                                <tr>
                                  <th>Charges <span class="text-grey fs-11 m-l-5"><?php echo $chargename; ?> ( <?php echo $charges; ?>% )</span></th>
                                  <td>+ Rs.<?php echo $unit_cost / 100 * $charges; ?></td>
                                </tr>
                              <?php } ?>
                              <?php if ($discount != 0) { ?>
                                <tr>
                                  <th>Discount <span class="text-grey fs-11 m-l-5"><?php echo $discountname; ?> ( Rs.<?php echo $discount;  ?> )</span></th>
                                  <td>- Rs.<?php echo $unit_area_in_numbers * $discount; ?></td>
                                </tr>
                              <?php } ?>
                              <tr>
                                <th>Net Payable Amount</th>
                                <td><span class="text-success fs-14">Rs.<?php echo $net_payable_amount; ?></span></td>
                              </tr>
                              <tr>
                                <th>Booking Date</th>
                                <td><?php echo DATE_FORMATE2("d M, Y", $booking_date); ?></td>
                              </tr>
                              <tr>
                                <th>Booking Created at</th>
                                <td><?php echo DATE_FORMATE2("d M, Y", $created_at); ?></td>
                              </tr>
                            </table>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                            <h4 class="section-heading">Add Other Payment Details</h4>
                            <div class="row">
                              <div class="col-md-12 form-group">
                                <label>Payment Title</label>
                                <input type="text" name="PayReqTitle" value="" placeholder="Other Payment" class="form-control" required>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12 form-group pt-3">
                                <label>Payment Notes</label>
                                <textarea class="form-control" name="PayRequestDescriptions" rows="3"></textarea>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                      <div class="col-md-5 col-lg-5 col-12">
                        <div class="payment-section">
                          <div class="row">
                            <h4 class="section-heading m-t-0">Select Payment Mode</h4>
                            <div class="col-md-12">
                              <div class="btn-group-lg btn-group payments">
                                <label class="btn btn-success">
                                  <input type="radio" name="payment_mode" id="pay_mode" hidden="" value="cash" onclick="PaymentMode('cash')" checked=""> <i class="fa fa-money"></i> Cash Receipts
                                </label>
                                <label class="btn btn-warning">
                                  <input type="radio" name="payment_mode" hidden="" id="pay_mode" value="banking" onclick="PaymentMode('banking')"><i class="fa fa-mobile"></i> Online Receipts
                                </label>
                                <label class="btn btn-danger">
                                  <input type="radio" name="payment_mode" hidden="" id="pay_mode" value="check" onclick="PaymentMode('check')"><i class="fa fa-text-height"></i> Cheque/DD Receipts
                                </label>
                              </div>
                            </div>
                            <div class="col-md-12 col-12" style="display:none;" id="check">
                              <div class="row">
                                <div class="col-md-12">
                                  <h4>Cheque/DD Payment</h4>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                    <label>Issue to</label>
                                    <input type="text" name="checkissuedto" value="" class="form-control">
                                  </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                    <label>Cheque/DD Number</label>
                                    <input type="text" name="checknumber" value="" class="form-control">
                                  </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                    <label>Bank Name</label>
                                    <input type="text" name="BankName" value="" class="form-control">
                                  </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                    <label>Bank IFSC Code</label>
                                    <input type="text" name="ifsc" value="" class="form-control">
                                  </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                    <label>Cheque Date</label>
                                    <input type="date" value="<?php echo date('Y-m-d'); ?>" name="checkissuedate" class="form-control">
                                  </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                    <label>Cheque Status</label>
                                    <select class="form-control" name="checkstatus" id="checkissustatus" onchange="checkcheckstatuscheck()">
                                      <option value="Issued" selected>Select Cheque Status</option>
                                      <option value="Issued">Received</option>
                                      <option value="Clear">Clear</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12" style="display:none;" id="checkcleardate">
                                  <div class="form-group">
                                    <label>Cheque Clear Date</label>
                                    <input type="date" name="clearedat" value="" class="form-control">
                                  </div>
                                </div>
                              </div>

                            </div>

                            <div class="col-md-12 col-12" style="display:none;" id="banking">
                              <div class="row">
                                <div class="col-md-12">
                                  <h4>Online Banking</h4>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                    <label>Online Payment Type</label>
                                    <select name="onlinepaymenttype" class="form-control">
                                      <option value="NetBanking" selected>Net Banking</option>
                                      <option value="CC/DC">Credit/Debit Card</option>
                                      <option value="Wallets">Online Wallets</option>
                                      <option value="UPI">UPI</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                    <label>Bank/Wallet/Upi/Provider name</label>
                                    <input type="text" name="OnlineBankName" value="" class="form-control">
                                  </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                    <label>Transaction ID</label>
                                    <input type="text" name="transactionId" value="" class="form-control">
                                  </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                    <label>Transaction Status</label>
                                    <select name="transaction_status" class="form-control">
                                      <option value="Success">Success</option>
                                      <option value="Pending" selected>Pending</option>
                                      <option value="Failed">Failed</option>
                                      <option value="Rejected">Rejected By Provider</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                    <label>Transaction Details/Notes</label>
                                    <textarea class="form-control" name="payment_details" row="1"></textarea>
                                  </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                    <label>Transaction Date</label>
                                    <input type="date" name="transactiondate" value="<?php echo date('Y-m-d'); ?>" class="form-control">
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="col-md-12 col-12" id="cash">
                              <div class="row">
                                <div class="col-md-12">
                                  <h4>Cash Payment</h4>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                    <label>Cash Received By</label>
                                    <input type="text" name="cashreceivername" value="<?php echo LOGIN_UserFullName; ?> @ <?php echo LOGIN_UserId; ?>" class="form-control">
                                  </div>
                                </div>
                                <input type="text" hidden="" name="cashamount" id="cashamount">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                    <label>Cash Received date</label>
                                    <input type="date" name="cashreceivedate" value="<?php echo date('Y-m-d'); ?>" class="form-control">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <h4 class="section-heading">Enter Payable Amount</h4>
                          <div class="form-group col-12 col-md-6">
                            <label>BookingID</label>
                            <select name="bookingid" class="form-control" readonly="">
                              <?php
                              $FetchPROJECT_TYPE = SELECT("SELECT * from bookings where bookingid='$bookingID'");
                              while ($FetchPROJECTST = mysqli_fetch_array($FetchPROJECT_TYPE)) {
                                $bookingid = $FetchPROJECTST['bookingid'];
                                $booking_date = date("m/Y", strtotime($FetchPROJECTST['booking_date'])); ?>
                                <option value="<?php echo $bookingid; ?>" selected="">B<?php echo $bookingid; ?>/<?php echo $booking_date; ?></option>
                              <?php }
                              if ($DemandId != null && $DemandId != '') {
                                $DemandSQL = "SELECT * FROM booking_pay_req where PaymentRequestId='" . $DemandId . "'";
                                $PayingAmount = FETCH($DemandSQL, "PayRequestingAmount");
                                $PayReqTitle = FETCH($DemandSQL, "PayReqTitle");
                                $PayReqPayTags = FETCH($DemandSQL, "PayReqPayTags");
                                $PayReqPayPeriod = FETCH($DemandSQL, "PayReqPayPeriod");
                                $PayReqPayingMonths = FETCH($DemandSQL, "PayReqPayingMonths");
                              } else {
                                $PayingAmount = 0;
                                $PayReqTitle = "";
                                $PayReqPayTags = "";
                                $PayReqPayPeriod = "";
                                $PayReqPayingMonths = "";
                              }
                              ?>
                            </select>
                          </div>
                          <div class="form-group col-12 col-md-6 p-r-0 p-l-0">
                            <label>Payment Amount</label>
                            <input type="text" name="NetPayableEmiAmount" id="netpayableemiamount" value="<?php echo $PayingAmount; ?>" hidden="">
                            <input type="text" name="payment_amount" oninput="getpaidamount()" value="<?php echo $PayingAmount; ?>" id="paidamount" class="form-control" placeholder="" required="">
                          </div>
                          <div class="col-md-12 text-right p-l-0 p-r-0">
                            <table class="table table-striped p-l-0 p-r-0">
                              <tr>
                                <td>
                                  <span class="fs-17" class="text-primary">Amount Paying : Rs.<span id="p_amount"><?php echo $PayingAmount; ?></span></span>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <span class="fs-17" id="chargeshow" style="display:none;"></span>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <span class="fs-17" id="discountshow" style="display:none;"></span>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <span class="fs-18"><b>Net Paybale :</b><span class="text-success"> Rs.<span id="netpaidamount" class="text-success"></span></span></span>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <span class="fs-17" id="checkcstatus" style="display:none;"></span>
                                </td>
                              </tr>
                            </table>
                          </div>
                          <div class="col-md-12 text-center" id="emi_payment_alert" style="display:none;">
                            <span id="" class="bg-danger p-2 br20"><i class="fa fa-warning"></i> Payment Amount cannot be greater then Total EMI Amount</span>
                          </div>
                          <div class="row" id="notesarea" style="display:none;">
                            <div class="col-md-12">
                              <h4 class="section-heading">Tally No & Remark</h4>
                            </div>
                            <div class="p-1">
                              <div class="from-group col-md-6">
                                <label>Tally No </label>
                                <input type="text" name="slip_no" class="form-control" placeholder="TALLY/###">
                              </div>
                              <div class="from-group col-md-6">
                                <label>Remarks/Note </label>
                                <input type="text" name="remark" class="form-control" placeholder="">
                              </div>
                            </div>
                          </div>
                          <input type="text" name="net_paid" id="net_payable" value="<?php echo $totalpayment; ?>" hidden="">
                          <div class="row">
                            <div class="col-md-12 m-t-30">
                              <a data-toggle="modal" id="continuebutton" onmouseover="GetDetails()" data-target="#confirm_payment" class="btn btn-success btn-block p-3">Receive Payments</a>
                            </div>
                          </div>
                          <!--END CONTENT CONTAINER-->
                          <!-- Modal  3-->
                          <div class="modal fade square" id="confirm_payment" role="dialog">
                            <div class="modal-dialog modal-md">
                              <div class="modal-content">
                                <div class="modal-header app-bg text-white">
                                  <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title text-white">Confirm Payment</h4>
                                </div>
                                <div class="modal-body overflow-auto">
                                  <div clas="row">
                                    <div class="col-md-12">
                                      <div class="cust-details">
                                        <div class="userWidget-1">
                                          <div class="avatar app-bg">
                                            <img src="<?php echo $C_user_profile_img; ?>" alt="avatar">
                                            <div class="name osLight fs-20 p-b-2"> <?php echo $C_name ?> </div>
                                          </div>
                                          <div class="title text-uppercase"> <?php echo $C_role_name ?> </div>
                                          <div class="address p-b-10 p-t-5">
                                            <p class="text-grey fs-14 p-l-0 m-l-0">
                                              <span><i class="fa fa-phone fs-14 text-info p-0"></i> : <?php echo $C_phone; ?></span> &nbsp; &nbsp;|
                                              <span><i class="fa fa-envelope fs-14 text-danger p-0"></i> : <?php echo $C_email; ?></span><br>
                                              <span><i class="fa fa-map-marker fs-14 text-success p-0"></i> : <?php echo "$C_user_street_address, $C_user_area_locality, $C_user_city $C_user_state - $C_user_country $C_user_pincode"; ?></span><br>
                                            </p>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <h4 class="section-heading">Booking Details</h4>
                                      <table class="table table-striped">
                                        <?php

                                        $GetBookings = SELECT("SELECT * FROM bookings where bookingid='$bookingid' ORDER BY bookingid DESC");
                                        if ($GetBookings == false) {
                                          echo "<h3 class='text-danger'>No Bookings Found!</h3>";
                                        }
                                        while ($Bookings = mysqli_fetch_array($GetBookings)) {
                                          $bookingid = $Bookings['bookingid'];
                                          $project_name = $Bookings['project_name'];
                                          $project_area = $Bookings['project_area'];
                                          $unit_name = strtoupper($Bookings['unit_name']);
                                          $unit_area = $Bookings['unit_area'];
                                          $unit_rate = $Bookings['unit_rate'];
                                          $unit_cost = $Bookings['unit_cost'];
                                          $net_payable_amount = $Bookings['net_payable_amount'];
                                          $booking_date = $Bookings['booking_date'];
                                          $clearing_date = $Bookings['clearing_date'];
                                          $possession = $Bookings['possession'];
                                          $chargename = $Bookings['chargename'];
                                          $charges = $Bookings['charges'];
                                          $discountname = $Bookings['discountname'];
                                          $discount = $Bookings['discount'];
                                          $created_at = $Bookings['created_at'];
                                          $customer_id = $Bookings['customer_id'];
                                          $matches = preg_replace('/[^0-9.]+/', '', $unit_area);
                                          $unit_area_in_numbers = (int)$matches;
                                          $possession_notes = SECURE($Bookings['possession_notes'], "d");
                                          $possession_update_date = $Bookings['possession_update_date'];
                                          $emi_months = $Bookings['emi_months'];
                                          $MainBookingID = "B$bookingid/" . date("m/Y", strtotime($created_at));
                                          $emi_id = FETCH("SELECT * FROM booking_emis where booking_id='$bookingid'", "emi_id");
                                        ?>
                                          <tr>
                                            <th>Booking ID</th>
                                            <td><span class="text-info text-decoration-underline"><?php echo $MainBookingID; ?></span></td>
                                          </tr>
                                          <tr>
                                            <th>Plot Name</th>
                                            <td><?php echo $unit_name; ?> @ <?php echo $project_name; ?></td>
                                          </tr>
                                          <tr>
                                            <th>Plot Area</th>
                                            <td><?php echo $unit_area; ?></td>
                                          </tr>
                                          <tr>
                                            <th>Unit Amount</th>
                                            <td><span class="text-success fs-14">Rs.<?php echo $net_payable_amount; ?></span></td>
                                          </tr>
                                          <tr>
                                            <th>Booking Date</th>
                                            <td><?php echo DATE_FORMATE2("d M, Y", $booking_date); ?></td>
                                          </tr>
                                          <tr>
                                            <th>Booking Created at</th>
                                            <td><?php echo DATE_FORMATE2("d M, Y", $created_at); ?></td>
                                          </tr>
                                        <?php } ?>
                                      </table>
                                    </div>
                                    <div class="col-md-6">
                                      <h4 class="section-heading">Payment Details</h4>
                                      <table class="table table-striped">
                                        <tr>
                                          <th>Pay Title</th>
                                          <td>
                                            <span><?php echo $PayReqTitle; ?></span>
                                          </td>
                                        </tr>
                                        <tr>
                                          <th>Paying Tags</th>
                                          <td>
                                            <span><?php echo $PayReqPayTags; ?></span>
                                          </td>
                                        </tr>
                                        <tr>
                                          <th>Paying For</th>
                                          <td>
                                            <span><?php echo $PayReqPayingMonths; ?> Months</span>
                                          </td>
                                        </tr>
                                        <tr>
                                          <th>Paying Period</th>
                                          <td>
                                            <span><?php echo $PayReqPayPeriod; ?></span>
                                          </td>
                                        </tr>
                                        <tr>
                                          <th>Payment Mode</th>
                                          <td>
                                            <span id="pmode">Cash Payment</span>
                                          </td>
                                        </tr>
                                        <tr>
                                          <th>Paying Amount</th>
                                          <td>
                                            <span class="text-success">Rs.<span id="r_amount"></span></span>
                                          </td>
                                        </tr>
                                      </table>
                                    </div>
                                    <div class="col-md-12">
                                      <h2 class="text-center"><span class="verification"><?php echo $verification; ?></span></h2>
                                      <div class="form-group">
                                        <label class="text-center m-t-10">Type Above Text below <span id="vstatus"></span></label>
                                        <input type="text" name="" id="v_date" oninput="verifications()" class="form-control text-center" placeholder="">
                                      </div>

                                    </div>
                                  </div>
                                </div>

                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                  <button type="button" value="<?php echo $DemandId; ?>" name="ReceiveOtherPayment" style="display:none;" onclick="actionBtn('emibtn', 'Receiving Payment')" id="emibtn" class="btn btn-success">Confirm & Receive Payment</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </form>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


    </div>
  </div>
  <script>
    function checkcheckstatuscheck() {
      var current_paying_amount = document.getElementById("netpayableemiamount").value;
      var net_payable_amount = <?php echo $net_payable_amount; ?>;
      if (document.getElementById("checkissustatus").value == "Clear") {
        document.getElementById("checkcleardate").style.display = "block";
        document.getElementById("ifcheckisalloted").innerHTML = "Check is Cleared! So payment will be added and adjusted!";
        document.getElementById("err").innerHTML = "";
        document.getElementById("amount_left").value = +net_payable_amount - +current_paying_amount;
        document.getElementById("paid_amount").innerHTML = "<b>- Rs." + current_paying_amount + "</b>";
        document.getElementById("amounttobepaid").innerHTML = +net_payable_amount - +current_paying_amount;
        document.getElementById("amounttobepaid2").innerHTML = +net_payable_amount - +current_paying_amount;
        document.getElementById("calculatedemi").value = +net_payable_amount - +current_paying_amount;
        document.getElementById("cashamount").value = +net_payable_amount - +current_paying_amount;
        document.getElementById("p_amount").innerHTML = net_payable_amount;
      } else {
        document.getElementById("checkcleardate").style.display = "none";
        document.getElementById("ifcheckisalloted").innerHTML = "Check is Issued! Payment will be added after check is cleared!";
        document.getElementById("err").innerHTML = "";
        document.getElementById("amount_left").value = net_payable_amount;
        document.getElementById("paid_amount").innerHTML = "<b>- Rs." + current_paying_amount + "</b>";
        document.getElementById("amounttobepaid").innerHTML = net_payable_amount;
        document.getElementById("calculatedemi").value = net_payable_amount;
        document.getElementById("amounttobepaid2").innerHTML = net_payable_amount;
        document.getElementById("cashamount").value = +net_payable_amount - +current_paying_amount;
        document.getElementById("p_amount").innerHTML = net_payable_amount;
      }
    }
  </script>

  <!-- end -->
  <?php include '../../sidebar.php'; ?>
  <?php include '../../footer.php'; ?>
  </div>
  <script>
    function verifications() {
      var v_date = document.getElementById("v_date");
      if (v_date.value == <?php echo $verification; ?>) {
        document.getElementById("vstatus").innerHTML = "Payment Receiving Confimed!";
        document.getElementById("vstatus").classList.add("text-success");
        document.getElementById("vstatus").classList.remove("text-danger");
        document.getElementById("emibtn").style.display = "";
        document.getElementById("emibtn").type = "submit";
      } else {
        document.getElementById("vstatus").innerHTML = "";
        document.getElementById("vstatus").classList.add("text-danger");
        document.getElementById("vstatus").classList.remove("text-success");
        document.getElementById("emibtn").style.display = "none";
        document.getElementById("emibtn").type = "";
      }
    }
  </script>
  <script>
    function GetDetails() {
      document.getElementById("r_amount").innerHTML = document.getElementById("paidamount").value;
    }
  </script>
  <script>
    document.getElementById("netpaidamount").innerHTML = document.getElementById("paidamount").value;
    document.getElementById("cashamount").value = document.getElementById("paidamount").value;
  </script>
  <script>
    function PaymentMode(data) {
      if (data == "cash") {
        document.getElementById("cash").style.display = "block";
        document.getElementById("check").style.display = "none";
        document.getElementById("banking").style.display = "none";
        document.getElementById("pmode").innerHTML = "Cash Payment";
      } else if (data == "check") {
        document.getElementById("cash").style.display = "none";
        document.getElementById("check").style.display = "block";
        document.getElementById("banking").style.display = "none";
        document.getElementById("pmode").innerHTML = "Cheque Payment";
      } else if (data == "banking") {
        document.getElementById("cash").style.display = "none";
        document.getElementById("check").style.display = "none";
        document.getElementById("banking").style.display = "block";
        document.getElementById("pmode").innerHTML = "Online Payment";
      } else {
        document.getElementById("cash").style.display = "block";
        document.getElementById("check").style.display = "none";
        document.getElementById("banking").style.display = "none";
        document.getElementById("pmode").innerHTML = "Cash Payment";
      }
    }
  </script>
  <script>
    function getpaidamount() {
      document.getElementById("cashamount").value = document.getElementById("paidamount").value;
      document.getElementById("netpaidamount").innerHTML = document.getElementById("paidamount").value;
      document.getElementById("net_payable").value = document.getElementById("paidamount").value;
      document.getElementById("p_amount").innerHTML = document.getElementById("paidamount").value;
      var payingamount = document.getElementById("paidamount");
      var netrequireamount = <?php echo $PayingAmount; ?>;
      if (payingamount.value <= netrequireamount) {
        document.getElementById("emi_payment_alert").style.display = "none";
        document.getElementById("continuebutton").style.display = "block";
      } else {
        document.getElementById("emi_payment_alert").style.display = "none";
        document.getElementById("continuebutton").style.display = "block";
      }
    }
  </script>
  <script>
    function chargesCalcu() {
      var chargevalue = document.getElementById("chargevalue").value;
      var chargeshow = document.getElementById("chargeshow");
      var net_payable = document.getElementById("net_payable").value;
      var unit_cost = document.getElementById("paidamount").value;
      var chargename = document.getElementById("chargename").value;
      var discountvalue = document.getElementById("discountvalue").value;
      var discountshow = document.getElementById("discountshow");
      var discountname = document.getElementById("discountname").value;

      if (chargevalue > 0 || discountvalue > 0) {
        chargeshow.style.display = "block";

        if (discountvalue > 0) {


          document.getElementById("checkcstatus").innerHTML = "Amount is Added in the System!";
          discountshow.style.display = "block";
          discountamount = discountvalue;
          discountableamount = +unit_cost - +discountvalue;
          discountshow.innerHTML = discountname + " : <b> - Rs." + discountamount + "</b>";
          discountname.value = discountname;
          chargeableamount = chargevalue;
          new_net_payable = (+unit_cost + +chargeableamount) - +discountamount;

          document.getElementById("net_payable").value = new_net_payable;
          chargeshow.innerHTML = chargename + " : <b> + Rs." + chargeableamount + "</b>";

          document.getElementById("netpaidamount").innerHTML = new_net_payable;
          document.getElementById("paidamount").innerHTML = unit_cost;
          chargename.value = chargename;
          document.getElementById("p_amount").innerHTML = new_net_payable;

        } else {
          discountshow.style.display = "none";
          discountableamount = 0;
          chargename.value = "";
          discountname.value = "";
          chargeableamount = chargevalue;
          new_net_payable = +unit_cost + +chargeableamount;

          document.getElementById("net_payable").value = new_net_payable;
          chargeshow.innerHTML = chargename + " : <b> + Rs." + chargeableamount + "</b>";

          document.getElementById("netpaidamount").innerHTML = new_net_payable;
          document.getElementById("paidamount").innerHTML = unit_cost;
          chargename.value = chargename;
          document.getElementById("p_amount").innerHTML = new_net_payable;

        }

      } else {
        chargeshow.style.display = "none";
        discountshow.style.display = "none";

        document.getElementById("net_payable").value = unit_cost;
        document.getElementById("netpaidamount").innerHTML = unit_cost;
        document.getElementById("paidamount").innerHTML = unit_cost;
        chargename.value = "";
        discountname.value = "";
      }

      if (discountvalue > 0) {
        discountshow.style.display = "block";
      } else if (discountvalue == 0) {
        discountshow.style.display = "none";
      } else {
        discountshow.style.display = "none";
      }

      if (chargevalue > 0) {
        chargeshow.style.display = "block";
      } else if (chargevalue == 0) {
        chargeshow.style.display = "none";
      } else {
        chargeshow.style.display = "none";
      }
    }
  </script>
  <script type="text/javascript">
    function selects() {
      var ele = document.getElementsByName('emi_list_id');
      for (var i = 0; i < ele.length; i++) {
        if (ele[i].type == 'checkbox')
          ele[i].checked = true;
      }
    }
  </script>

  <?php include '../../../include/footer_files.php'; ?>
</body>

</html>