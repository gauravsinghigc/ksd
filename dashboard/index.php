<?php
require '../require/modules.php';
require '../require/admin/sessionvariables.php';
require '../include/admin/common.php';
$_SESSION['RUNNING_URL'] = DOMAIN . "/dashboard";
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <title>Dashboard | <?php echo company_name; ?></title>
 <?php include '../include/header_files.php'; ?>
</head>

<body>
 <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
  <?php include 'header.php'; ?>

  <div class="boxed">
   <div id="content-container" class="pl-0" style="padding-bottom:28px !important;">

    <!--Page content-->
    <div id="page-content">
     <div class="row">
      <div class="col-md-12 col-lg-12 col-12 margin-top-dash">
       <div class="panel p-1 square">
        <div class="panel-body">
         <div class="row">
          <div class="col-md-12">
           <h3 class="m-t-0"><i class="fa fa-home app-text"></i> Dashboard</h3>
          </div>

          <a data-toggle="modal" data-target="#projects">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/projects.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Projects</h2>
              </div>
             </div>
            </div>
           </div>
          </a>

          <!-- Modal for Projects -->
          <div class="modal fade" id="projects" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/projects",
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Projects</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" tabindex="1" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="PROJECT">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>



          <a data-toggle="modal" data-target="#projectsunits">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/project-units.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Plots</h2>
              </div>
             </div>
            </div>
           </div>
          </a>

          <!-- Modal for Projects Units -->
          <div class="modal fade" id="projectsunits" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/projects/plots"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Plots</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="PROJECT">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#agents">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/agents.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Agents</h2>
              </div>
             </div>
            </div>
           </div>
          </a>

          <!-- Modal for Agents -->
          <div class="modal fade" id="agents" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/partner"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Agents</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="AGENTS">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#bookings">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/booking.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Bookings</h2>
              </div>
             </div>
            </div>
           </div>
          </a>

          <!-- Modal for Bookings -->
          <div class="modal fade" id="bookings" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/booking"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Bookings</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="BOOKING">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#emipayments">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/emi.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Monthly EMIs</h2>
              </div>
             </div>
            </div>
           </div>
          </a>

          <!-- Modal for Bookings -->
          <div class="modal fade" id="emipayments" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/payments/search"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Monthly EMI</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="EMI">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>


          <a data-toggle="modal" data-target="#leads">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/marketing.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Leads</h2>
              </div>
             </div>
            </div>
           </div>
          </a>

          <!-- Modal for Agents -->
          <div class="modal fade" id="leads" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/leads"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Leads</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="MARKETING">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#accounts">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/account.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Accounts</h2>
              </div>
             </div>
            </div>
           </div>
          </a>

          <!-- Modal for Accounts -->
          <div class="modal fade" id="accounts" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/payments"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Accounts</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="ACCOUNTS">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#enquiries">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/enquiry.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Walk Ins</h2>
              </div>
             </div>
            </div>
           </div>
          </a>

          <!-- Modal for Enquiries -->
          <div class="modal fade" id="enquiries" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/enquiries"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Walk Ins</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="ENQUIRIES">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#projectsmap">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/project-map.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Project Map</h2>
              </div>
             </div>
            </div>
           </div>
          </a>

          <!-- Modal for Projects Map -->
          <div class="modal fade" id="projectsmap" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/projects/live"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Project Maps</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="PROJECTMAP">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#customers">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/customers.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Customers</h2>
              </div>
             </div>
            </div>
           </div>
          </a>

          <!-- Modal for Customers -->
          <div class="modal fade" id="customers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/customer"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Customers</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="CUSTOMERS">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#expanses">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/expanse.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Expenses</h2>
              </div>
             </div>
            </div>
           </div>
          </a>

          <!-- Modal for Expanses -->
          <div class="modal fade" id="expanses" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/expanses"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Expenses</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="EXPANSES">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#receptions">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/reception.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Reception</h2>
              </div>
             </div>
            </div>
           </div>
          </a>

          <!-- Modal for Receptions -->
          <div class="modal fade" id="receptions" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/enquiries"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Reception</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="RECEPTION">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#sitevisits">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/visits.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Site Visits</h2>
              </div>
             </div>
            </div>
           </div>
          </a>

          <!-- Modal for Site Visits -->
          <div class="modal fade" id="sitevisits" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(
                                                                true,
                                                                [
                                                                    "requested_url" => DOMAIN . "/admin/site-visits"
                                                                ]
                                                            ); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Site Visits</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="SITE_VISITS">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#calls">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/calla.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Calls</h2>
              </div>
             </div>
            </div>
           </div>
          </a>
          <!-- Modal for Calls -->
          <div class="modal fade" id="calls" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/calls"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Calls</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="Calls">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#hr">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/hr.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">HR</h2>
              </div>
             </div>
            </div>
           </div>
          </a>

          <!-- Modal for HR -->
          <div class="modal fade" id="hr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/employees"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>HR</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="HR">Contact US</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#queries">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/query.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Web Queries</h2>
              </div>
             </div>
            </div>
           </div>
          </a>
          <!-- Modal for Queries -->
          <div class="modal fade" id="queries" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/enquiries"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Qeuries</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="QUERIES">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#appsettings" appsettings>
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/app-settings.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">App Settings</h2>
              </div>
             </div>
            </div>
           </div>
          </a>
          <!-- Modal for App Settings -->
          <div class="modal fade" id="appsettings" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/settings"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>App Settings</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="APP_SETTINGS">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#websites">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/web.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Website</h2>
              </div>
             </div>
            </div>
           </div>
          </a>
          <!-- Modal for Websites -->
          <div class="modal fade" id="websites" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/website/"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Website</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="WEBSITE">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#smssettings">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/sms.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">SMS</h2>
              </div>
             </div>
            </div>
           </div>
          </a>
          <!-- Modal for SMS -->
          <div class="modal fade" id="smssettings" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/sms/"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>SMS</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="SMS">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#notification">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/notification.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Notifications</h2>
              </div>
             </div>
            </div>
           </div>
          </a>
          <!-- Modal for Notifications -->
          <div class="modal fade" id="notification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/notifications"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Notifications</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="NOTIFICATION">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#storage">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/storage.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Storage</h2>
              </div>
             </div>
            </div>
           </div>
          </a>
          <!-- Modal for Storage -->
          <div class="modal fade" id="storage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/storage"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Storage</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="STORAGE">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#reports">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/reports.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Reports</h2>
              </div>
             </div>
            </div>
           </div>
          </a>
          <!-- Modal for Reports -->
          <div class="modal fade" id="reports" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/reports"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Reports</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="REPORTS">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#company">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/company.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Company</h2>
              </div>
             </div>
            </div>
           </div>
          </a>
          <!-- Modal for Company -->
          <div class="modal fade" id="company" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/company-profile"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Company</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="COMPANY">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#subscriptions">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/subscription.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Subscription</h2>
              </div>
             </div>

            </div>
           </div>
          </a>
          <!-- Modal for Subscription -->
          <div class="modal fade" id="subscriptions" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/subscription"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>SUBSCRIPTION</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="SUBSCRIPTION">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#modules">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 panel-bdr">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/module.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Manage</h5>
               <h2 class="mt-0">Modules</h2>
              </div>
             </div>
            </div>
           </div>
          </a>
          <!-- Modal for Modules -->
          <div class="modal fade" id="modules" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "/admin/module"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="<?php echo $DOMAIN; ?>/storage/sys-img/dash/lock.png" class="w-50">
                <h2>Modules</h2>
                <h4>Verify Your Access</h4>
                <p>Please enter password provided by your administrator.</p>
               </div>
               <div class="form-group text-center">
                <input type="password" name="access_password" class="form-control text-center access-pass"
                 placeholder="********" required="">
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="MODULES">Get Access</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <!-- premium modules -->

          <a data-toggle="modal" data-target="#agreement">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 premium">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/agreeement.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Premium
                <i class="fa fa-star fa-spin text-danger pull-right fs-13"></i>
               </h5>
               <h2 class="mt-0">Agreement</h2>
              </div>
             </div>
            </div>
           </div>
          </a>
          <!-- Modal for Modules -->
          <div class="modal fade" id="agreement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="" method="POST" class="access-form">
               <?php FormPrimaryInputs(true, [
                                                                "requested_url" => DOMAIN . "//admin/module"
                                                            ]); ?>
               <div class="form-group text-center">
                <img src="https://responsive-muse.com/wp-content/uploads/2017/01/premium-access.png"
                 class="w-100 premium">
                <h2>Agreement</h2>
                <h4>Premium Module</h4>
                <p>This is a premium module, to access this you have to purchase it</p>
               </div>
               <div class="form-group text-center">
                <p>You can also book free demo for this. for free demo contact to <?php echo DEVELOPED_BY; ?></p>
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="HR">Contact US</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#registry">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 premium">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/registry.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Premium
                <i class="fa fa-star fa-spin text-danger pull-right fs-13"></i>
               </h5>
               <h2 class="mt-0">Registry</h2>
              </div>
             </div>
            </div>
           </div>
          </a>
          <!-- Modal for Modules -->
          <div class="modal fade" id="registry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="" method="POST" class="access-form">
               <?php FormPrimaryInputs(true); ?>
               <div class="form-group text-center">
                <img src="https://responsive-muse.com/wp-content/uploads/2017/01/premium-access.png"
                 class="w-100 premium">
                <h2>Registry</h2>
                <h4>Premium Module</h4>
                <p>This is a premium module, to access this you have to purchase it</p>
               </div>
               <div class="form-group text-center">
                <p>You can also book free demo for this. for free demo contact to <?php echo DEVELOPED_BY; ?></p>
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="HR">Contact US</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#construction">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 premium">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/construction.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Premium
                <i class="fa fa-star fa-spin text-danger pull-right fs-13"></i>
               </h5>
               <h2 class="mt-0">Construction</h2>
              </div>
             </div>
            </div>
           </div>
          </a>
          <!-- Modal for Modules -->
          <div class="modal fade" id="construction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="" method="POST" class="access-form">
               <?php FormPrimaryInputs(true); ?>

               <div class="form-group text-center">
                <img src="https://responsive-muse.com/wp-content/uploads/2017/01/premium-access.png"
                 class="w-100 premium">
                <h2>Construction</h2>
                <h4>Premium Module</h4>
                <p>This is a premium module, to access this you have to purchase it</p>
               </div>
               <div class="form-group text-center">
                <p>You can also book free demo for this. for free demo contact to <?php echo DEVELOPED_BY; ?></p>
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="HR">Contact US</button>
              </form>
             </div>
            </div>
           </div>
          </div>

          <a data-toggle="modal" data-target="#mlm">
           <div class="col-lg-2 col-md-2 col-6 col-sm-4 m-b-15">
            <div class="p-1r shadow-lg p-t-20 premium">
             <div class="header flex-start">
              <div>
               <img src="<?php echo DOMAIN; ?>/storage/sys-img/dash/mlm.png">
              </div>
              <div>
               <h5 class="text-grey m-b-0 italic">Premium
                <i class="fa fa-star fa-spin text-danger pull-right fs-13"></i>
               </h5>
               <h2 class="mt-0">MLM</h2>
              </div>
             </div>
            </div>
           </div>
          </a>
          <!-- Modal for Modules -->
          <div class="modal fade" id="mlm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-body">
              <form action="../controller/accesscontroller.php" method="POST" class="access-form">
               <?php FormPrimaryInputs(true); ?>
               <div class="form-group text-center">
                <img src="https://responsive-muse.com/wp-content/uploads/2017/01/premium-access.png"
                 class="w-100 premium">
                <h2>Real Estate MLM</h2>
                <h4>Premium Module</h4>
                <p>This is a premium module, to access this you have to purchase it</p>
               </div>
               <div class="form-group text-center">
                <p>You can also book free demo for this. for free demo contact to <?php echo DEVELOPED_BY; ?></p>
               </div>

             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn app-bg" name="GetAccessFOR" value="HR">Contact US</button>
              </form>
             </div>
            </div>
           </div>
          </div>




         </div>
         <div class="row">
          <div class="col-md-12 text-right">
           <div class="flex-s-b">
            <div class="p-1 w-25 text-left">
             <form class="row" action="../controller/usercontroller.php" method="POST">
              <?php FormPrimaryInputs($url = DOMAIN . "/dashboard"); ?>
              <?php $alert_sound = FETCH("SELECT * FROM users where id='" . LOGIN_UserId . "'", "alert_sound"); ?>
              <?php
                                                        if ($alert_sound === "ON") { ?>
              <button type="submit" name="alert_sound" class="btn btn-md app-bg" value="<?php echo $alert_sound; ?>">
               <i class="fa fa-volume-up"></i> <?php echo $alert_sound; ?>
              </button>
              <?php } else { ?>
              <button type="submit" name="alert_sound" value="<?php echo $alert_sound; ?>"
               class="btn btn-md btn-danger">
               <i class="fa fa-bell-slash"></i> <?php echo $alert_sound; ?>
              </button>
              <?php } ?>
              <input type="text" name="notification_update" value="true" hidden="">
              <span class="p-1">Notification Sound</span>
             </form>
            </div>
            <div class="p-1">
             <button onclick="supportPanel()" class="btn app-bg">System Support <i
               class="fa fa-info-circle"></i></button>
             <p class="text-grey m-t-10 fs-14"><b><?php echo DEVELOPED_BY; ?></b> welcomes every suggestion, feedback,
              queries and upgrades requests.
              You can also raise request at <a href="mailto:<?php echo DEVELOPER_SUPPORT_MAIL_ID; ?>"
               class="text-primary"><?php echo DEVELOPER_SUPPORT_MAIL_ID; ?></a>
              <br><a href="https://download.anydesk.com/AnyDesk.exe" download="AnyDesk.exe">Download Remote <span
                class="text-decoration-underline">Support Software (Anydesk) </span></a>
             </p>
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

   <!-- Support Panel -->
   <div class="support-panel" id="support-panel-card">
    <div class="flex-s-b">
     <div class="w-50">
      <h3 class="p-1">How can we Help you?</h3>
     </div>
     <div class="p-3">
      <button onclick="supportPanel()" class="btn btn-md btn-default"><i class="fa fa-times"></i></button>
     </div>
    </div>
    <div class="col-md-12">
     <p class="p-1 fs-13 lh-1-2">If you are facing & observing any errors, bugs, suggestion, and feedback with our
      system, then please send them to us, these help us in improving & making more user friendly future technologies.
     </p>
    </div>
    <form method="POST" action="../controller/supportcontroller.php">
     <?php
                    FormPrimaryInputs(true);
                    ?>
     <div class="form-group col-md-6">
      <label>Package Name</label>
      <input type="text" name="packagename" value="<?php echo company_name; ?>" class="form-control">
     </div>
     <?php
                    SELECT_OPTION("supportype", "Support Type", ["Support for Errors & Bugs", "Support for Update & Upgrades", "Support for Modification & Corrections", "Support for Designing & Theme", "Support for Development & Deployment", "Require DEMO", "We are not Sure about Support Type",], "true", "col-md-12", "0");
                    SELECT_OPTION("supportcategory", "Support Category", ["There is an ERROR", "There is a BUG", "Require some changes", "Need Modification", "Need Update & Upgrades", "Facing Technical Issues", "Unable to do CRUD (Create, View, Edit & Delete Data) Operation", "Unable to Upload Files & Documents", "Buttons are not working", "Unable to Import & Export Data", "Unable to Make Call for Numbers", "Unable to Send Emails", "Unable to do Auth Process (Login, Logout, Password Reset, OTP Failure", "Overlapping of Section are observing", "BUG in Theme & Design", "Functionality Issue", "Display Issues", "Require DEMO", "We are not sure about the Support Category"], "true", "col-md-12", "01");
                    SELECT_OPTION("supportpriority", "Support Priority Level (1 For High & 10 For Low)", ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"], "true", "col-md-12", "05");
                    ?>
     <div class="form-group col-md-6">
      <label>Contact Email-id</label>
      <input type="text" name="contactmailid" value="<?php echo LOGIN_UserEmailId; ?>" class="form-control">
     </div>
     <div class="form-group col-md-6">
      <label>Company Email-id</label>
      <input type="text" name="companymailid" value="<?php echo company_email; ?>" class="form-control">
     </div>
     <div class="form-group col-md-6">
      <label>Contact Phone Number</label>
      <input type="text" name="contactphonenumber" value="<?php echo LOGIN_UserPhoneNumber; ?>" class="form-control">
     </div>
     <div class="form-group col-md-6">
      <label>Company Phone Number</label>
      <input type="text" name="companyphonenumber" value="<?php echo company_phone; ?>" class="form-control">
     </div>
     <?php
                    TEXTAREA("Support Description", "supportdetails", "Hello Support Team,", "true", "5", "col-md-12");
                    ?>
     <div class="form-group col-md-12">
      <button class="btn btn-block btn-md app-bg" type="submit" name="supportrequest">Send Request</button>
     </div>
    </form>
   </div>

   <script>
   function supportPanel() {
    var supportCard = document.getElementById("support-panel-card");
    if (supportCard.style.display == "block") {
     supportCard.style.display = "none";
    } else {
     supportCard.style.display = "block";
    }
   }
   </script>
   <!-- end -->
   <?php include 'footer.php'; ?>
   <?php include '../include/footer_files.php'; ?>
</body>

</html>
