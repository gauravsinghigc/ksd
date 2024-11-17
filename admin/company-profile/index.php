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
  <title>Company Profile | <?php echo company_name; ?></title>
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
        <!--Page content-->
        <div id="page-content">
          <div class="panel">
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12">
                  <h3 class="m-t-3 m-b-0"><i class="fa fa-home app-text"></i> Company Profile</h3>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-12 col-xs-12">
                  <form action="../../controller/companycontroller.php" style="margin-top: -1rem;" method="POST" enctype="multipart/form-data">
                    <?php FormPrimaryInputs(true); ?>
                    <label for="for-company-logo">
                      <div class="upload-logo fs-8">
                        <i class="fa fa-edit"></i> Update Logo
                      </div>
                    </label>
                    <input type="FILE" id="for-company-logo" name="company_logo" class="display-none" onchange="form.submit()">
                    <input type="hidden" name="updatecompanyprofile" value="<?php echo company_id; ?>">
                  </form>
                  <div class="userWidget-1">
                    <div class="avatar app-bg">
                      <img src="<?php echo company_logo; ?>" alt="avatar">
                      <div class="name osLight"> <?php echo company_name; ?> </div>
                    </div>
                    <div class="title fs-11"> Reg at : <?php echo DATE_FORMATE2("d M, Y", created_at); ?></div>
                    <div class="address fs-10"> Last Update at : <?php echo DATE_FORMATE2("d M, Y", updated_at); ?></div>
                    <table class="table display">
                      <tbody>
                        <tr>
                          <td colspan="3">
                            <iframe src="<?php echo company_branch_map_link; ?>" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                          </td>
                        </tr>
                        <tr>
                          <td><i class="fa fa-globe ph-5 text-info"></i></td>
                          <td>
                            <?php if (company_status == "ACTIVE") { ?>
                              <span class="text-success"><?php echo HOST; ?> | <i class="fa fa-check-circle"></i> Active</span>
                            <?php } else { ?>
                              <span class="text-danger"><?php echo HOST; ?> | <i class="fa fa-warning"></i> <?php echo company_status; ?></span>
                            <?php } ?>
                          </td>
                        </tr>
                        <tr>
                          <td><i class="fa fa-envelope-o ph-5 text-info"></i></td>
                          <td><a href="mailto:<?php echo company_email; ?>"><?php echo company_email; ?></a> </td>
                        </tr>
                        <tr>
                          <td><i class="fa fa-phone ph-5 text-primary"></i></td>
                          <td><a href="<?php echo company_email; ?>"><?php echo company_phone; ?></a> </td>
                        </tr>
                        <tr>
                          <td><i class="fa fa-map-marker ph-5 text-success"></i></td>
                          <td>
                            <b><?php echo company_branch_name; ?></b> <i class="fa fa-angle-right"></i> <span class="text-success fs-10"><i>Primary</i></span><br><?php echo company_address; ?>
                          </td>
                        </tr>

                        <?php
                        $SelectBranchAddress3 = SELECT("SELECT * FROM company_branches where company_id='" . company_id . "' and ifdefault!='yes'");
                        while ($FetchBranch3 = mysqli_fetch_array($SelectBranchAddress3)) {
                          $company_branch_id3  = $FetchBranch3['company_branch_id'];
                          $company_branch_name3 = $FetchBranch3['company_branch_name'];
                          $company_street_address3 = $FetchBranch3['company_street_address'];
                          $company_area_locality3 = $FetchBranch3['company_area_locality'];
                          $company_state3 = $FetchBranch3['company_state'];
                          $company_city3 = $FetchBranch3['company_city'];
                          $company_country3 = $FetchBranch3['company_country'];
                          $company_pincode3 = $FetchBranch3['company_pincode'];
                          $c_created_at3 = $FetchBranch3['created_at'] . "";
                          $c_updated_at3 = $FetchBranch3['updated_at'] . "";
                          $company_branch_status3 = $FetchBranch3['company_branch_status'];
                          $ifdefault3 = $FetchBranch3['ifdefault'];
                          $company_address3 = "$company_street_address3, $company_area_locality3, $company_city3, $company_state3 $company_country3 - $company_pincode3";
                        ?>
                          <tr>
                            <td><i class="fa fa-map-marker ph-5 text-success"></i></td>
                            <td>
                              <b><?php echo $company_branch_name3; ?></b><br>
                              <?php echo $company_address3; ?>
                            </td>
                          </tr>
                        <?php } ?>

                        <tr>
                          <td><i class="fa fa-tag text-warning"></i></td>
                          <td><?php echo company_tagline; ?></td>
                        </tr>
                        <tr>
                          <td><i class="fa fa-info text-dark"></i></td>
                          <td><?php echo company_desc; ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="clearfix"> </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-12 col-xs-12" style="margin-top: 0.8rem;">
                  <!--Default Tabs (Left Aligned)-->
                  <!--===================================================-->
                  <div class="tab-base">
                    <!--Nav Tabs-->
                    <ul class="nav nav-tabs">
                      <li class="active"> <a data-toggle="tab" href="#profile"> Company Profile </a> </li>
                      <li> <a data-toggle="tab" href="#address">Company Address</a> </li>
                      <?php if ($_SESSION['UserId'] == "5") { ?>
                        <li> <a data-toggle="tab" href="#attributes">Company Configurations</a> </li>
                      <?php } ?>
                    </ul>
                    <!--Tabs Content-->
                    <div class="tab-content">

                      <div id="profile" class="tab-pane fade active in">
                        <h4 class="p-1r text-dark">Update Company Profile</h4>
                        <div class="btn-group btn-group-sm float-right action-bar-margin">
                          <a href="../../controller/companycontroller.php?updatecompany=true" class="btn btn-primary square" onclick="actionBtn('updatestatus', 'Change Status...')" id="updatestatus">Website Status <i class="fa fa-angle-right"></i></a>
                          <a href="../../controller/companycontroller.php?updatecompany=true" class="btn btn-deafult square">
                            <?php if (company_status == "ACTIVE") { ?>
                              <span class="text-success"><i class="fa fa-check-circle"></i> Active</span>
                            <?php } else { ?>
                              <span class="text-danger"><i class="fa fa-warning"></i> <?php echo company_status; ?></span>
                            <?php } ?>
                          </a>
                        </div>
                        <form action="../../controller/companycontroller.php" method="POST">
                          <?php FormPrimaryInputs(true); ?>
                          <div class="row">
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <label>Company Name</label>
                              <input id="name" class="form-control" type="text" value="<?php echo company_name; ?>" name="company_name" placeholder="Full Name" required="">
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <label>Company Email</label>
                              <input id="email" class="form-control" type="email" name="company_email" value="<?php echo company_email ?>" placeholder="Email Id" required="">
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <label>Company Phone</label>
                              <input id="phone" class="form-control" type="phone" name="company_phone" value="<?php echo company_phone ?>" placeholder="00000000" required="">
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <label>Company Tagline</label>
                              <input id="phone" class="form-control" type="text" name="company_tagline" value="<?php echo company_tagline ?>" placeholder="Tag Line" required="">
                            </div>
                            <div class="form-group col-12 col-md-12 col-lg-12 col-sm-12">
                              <label>Company Description</label>
                              <textarea class="form-control" name="company_desc" min="50" value="<?php echo company_desc; ?>" required="" rows="3"><?php echo company_desc; ?></textarea>
                            </div>
                            <div class="col-md-12 m-b-20">
                              <button class="btn btn-primary btn-lg" name="update_company_profile" value="<?php echo SECURE(company_id, "e"); ?>" type="submit" onclick="actionBtn('updatecompanyprofile', 'Updating Company Profile...')" id="updatecompanyprofile">Update Company</button>
                              <br>
                            </div>
                          </div>
                        </form>

                      </div>


                      <div id="address" class="tab-pane fade in">
                        <div class="flex-s-b">
                          <h4 class="p-1r text-dark mb-0">Update Company Address</h4>
                          <div class="btn-group-sm p-2">
                            <a class="btn btn-sm btn-primary" onclick="Databar('addaddress', 'btnaddress', 'Add_Address')" id="btnaddress"><span id="Add_Address"><i class="fa fa-plus"></i> Add Address</span></a>
                          </div>
                        </div>
                        <form class="bg-secondary shadow-lg p-2 br15" id="addaddress" style="display:none;" action="../../controller/companycontroller.php" method="POST">
                          <?php FormPrimaryInputs(true); ?>
                          <div class="row">
                            <div class="col-md-12">
                              <h4 class="text-danger">ADD NEW Address</h4>
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <label>Street Address</label>
                              <textarea class="form-control" name="company_street_address" value="" placeholder="House No/Plot No/Flat No/Street Address" rows="4" required=""></textarea>
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <label>Branch Name</label>
                              <input id="phone" class="form-control" type="text" name="company_branch_name" value="" placeholder="company_branch_name" required="">
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <label>Area locality</label>
                              <input id="phone" class="form-control" type="text" name="company_area_locality" value="" placeholder="00000000" required="">
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <label>City</label>
                              <input id="phone" class="form-control" type="text" name="company_city" value="" placeholder="00000000" required="">
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <label>State</label>
                              <input id="phone" class="form-control" type="text" name="company_state" value="" placeholder="00000000" required="">
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <label>Pincode</label>
                              <input id="phone" class="form-control" type="text" name="company_pincode" value="" placeholder="00000000" required="">
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <label>Country</label>
                              <input id="phone" class="form-control" type="text" name="company_country" value="" placeholder="00000000" required="">
                            </div>
                            <div class="form-group col-md-12">
                              <label>Map Location Link</label>
                              <textarea rows="5" type="text" name="company_branch_map_link" class="form-control" placeholder="Primary Location Map Link" value="" required=""></textarea>
                              <div class="flex-start p-b-15">
                                <a href="<?php echo DOMAIN; ?>/storage/sys-img/location-link-suggesstion.png" class="fs-12 text-primary btn-sm btn-default btn" target="_blank">How to Get Location Link?</a>
                                <a href="https://www.google.com/maps/" class="fs-12 text-success btn-sm btn-default btn" target="_blank"><i class="fa fa-map-marker"></i> Open Map</a>
                                <a href="https://business.google.com/create" class="fs-12 text-danger btn-sm btn-default btn" target="_blank"><i class="fa fa-map-marker"></i> Register Business Location</a>

                              </div>
                            </div>
                            <div class="form-group col-md-12">
                              <button class="btn btn-success btn-md" name="add_new_company_address" value="<?php echo SECURE(company_id, "e"); ?>" type="submit" onclick="actionBtn('updatecprofile2', 'Updating Company Adress...')" id="updatecprofile2">Save
                                Address</button>
                            </div>
                          </div>
                        </form>
                        <form action="../../controller/companycontroller.php" method="POST">
                          <?php FormPrimaryInputs(true); ?>
                          <div class="row">
                            <div class="col-md-12">
                              <h5 class="text-success"><i>Primary Address</i></h5>
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <label>Street Address</label>
                              <textarea class="form-control" name="company_street_address" value="<?php echo company_street_address; ?>" placeholder="House No/Plot No/Flat No/Street Address" rows="4" required=""><?php echo company_street_address; ?></textarea>
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <label>Branch Name</label>
                              <input id="phone" class="form-control" type="text" name="company_branch_name" value="<?php echo company_branch_name; ?>" placeholder="company_branch_name" required="">
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <label>Area locality</label>
                              <input id="phone" class="form-control" type="text" name="company_area_locality" value="<?php echo company_area_locality; ?>" placeholder="00000000" required="">
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <label>City</label>
                              <input id="phone" class="form-control" type="text" name="company_city" value="<?php echo company_city; ?>" placeholder="00000000" required="">
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <label>State</label>
                              <input id="phone" class="form-control" type="text" name="company_state" value="<?php echo company_state; ?>" placeholder="00000000" required="">
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <label>Pincode</label>
                              <input id="phone" class="form-control" type="text" name="company_pincode" value="<?php echo company_pincode; ?>" placeholder="00000000" required="">
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <label>Country</label>
                              <input id="phone" class="form-control" type="text" name="company_country" value="<?php echo company_country; ?>" placeholder="00000000" required="">
                            </div>

                            <div class="form-group col-md-12">
                              <label>Map Location Link</label>
                              <textarea rows="5" type="text" name="company_branch_map_link" class="form-control" placeholder="Primary Location" value="" required=""><?php echo company_branch_map_link; ?></textarea>
                              <div class="flex-start p-b-15">
                                <a href="<?php echo DOMAIN; ?>/storage/sys-img/location-link-suggesstion.png" class="fs-12 text-primary btn-sm btn-default btn" target="_blank">How to Get Location Link?</a>
                                <a href="https://www.google.com/maps/" class="fs-12 text-success btn-sm btn-default btn" target="_blank"><i class="fa fa-map-marker"></i> Open Map</a>
                                <a href="https://business.google.com/create" class="fs-12 text-danger btn-sm btn-default btn" target="_blank"><i class="fa fa-map-marker"></i> Register Business Location</a>
                              </div>
                            </div>

                            <div class="col-md-12">
                              <button class="btn btn-primary btn-lg" name="update_company_address" value="<?php echo company_branch_id; ?>" type="submit" onclick="actionBtn('updatecompanyaddress2', 'Updating Company Adress...')" id="updatecompanyaddress2">
                                Update Primary Address
                              </button>
                            </div>
                          </div>
                        </form>
                        <hr>

                        <?php
                        $SelectBranchAddress2 = SELECT("SELECT * FROM company_branches where company_id='" . company_id . "' and ifdefault!='yes'");
                        while ($FetchBranch2 = mysqli_fetch_array($SelectBranchAddress2)) {
                          $company_branch_id2  = $FetchBranch2['company_branch_id'];
                          $company_branch_name2 = $FetchBranch2['company_branch_name'];
                          $company_street_address2 = $FetchBranch2['company_street_address'];
                          $company_area_locality2 = $FetchBranch2['company_area_locality'];
                          $company_state2 = $FetchBranch2['company_state'];
                          $company_city2 = $FetchBranch2['company_city'];
                          $company_country2 = $FetchBranch2['company_country'];
                          $company_pincode2 = $FetchBranch2['company_pincode'];
                          $c_created_at2 = $FetchBranch2['created_at'] . "";
                          $c_updated_at2 = $FetchBranch2['updated_at'] . "";
                          $company_branch_status2 = $FetchBranch2['company_branch_status'];
                          $ifdefault2 = $FetchBranch2['ifdefault'];
                          $company_branch_map_link2 = $FetchBranch2['company_branch_map_link'];
                        ?>
                          <form class="shadow-lg br15 p-2" action="../../controller/companycontroller.php" method="POST">
                            <?php FormPrimaryInputs(true); ?>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="flex-s-b">
                                  <div>
                                    <h5 class="text-dark m-b-0"><i>Branch Address</i></h5>
                                    <h3 class="text-primary m-t-0"><?php echo $company_branch_name2; ?></h3>
                                  </div>
                                  <div class="btn-group-sm p-2">
                                    <a href="../../controller/companycontroller.php?changeprimary=true&ref=<?php echo $company_branch_id2; ?>&access_url=<?php echo get_url(); ?>" class="btn btn-sm btn-success">Make Primary</a>
                                    <a href="../../controller/companycontroller.php?disabledaddress=true&ref=<?php echo $company_branch_id2; ?>&access_url=<?php echo get_url(); ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                <label>Street Address</label>
                                <textarea class="form-control" name="company_street_address2" value="<?php echo $company_street_address2; ?>" placeholder="House No/Plot No/Flat No/Street Address" rows="4" required=""><?php echo $company_street_address2; ?></textarea>
                              </div>
                              <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                <label>Branch Name</label>
                                <input id="phone" class="form-control" type="text" name="company_branch_name2" value="<?php echo $company_branch_name2; ?>" placeholder="company_branch_name" required="">
                              </div>
                              <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                <label>Area locality</label>
                                <input id="phone" class="form-control" type="text" name="company_area_locality2" value="<?php echo $company_area_locality2; ?>" placeholder="00000000" required="">
                              </div>
                              <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                <label>City</label>
                                <input id="phone" class="form-control" type="text" name="company_city2" value="<?php echo $company_city2; ?>" placeholder="00000000" required="">
                              </div>
                              <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                <label>State</label>
                                <input id="phone" class="form-control" type="text" name="company_state2" value="<?php echo $company_state2; ?>" placeholder="00000000" required="">
                              </div>
                              <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                <label>Pincode</label>
                                <input id="phone" class="form-control" type="text" name="company_pincode2" value="<?php echo $company_pincode2; ?>" placeholder="00000000" required="">
                              </div>
                              <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                <label>Country</label>
                                <input id="phone" class="form-control" type="text" name="company_country2" value="<?php echo $company_country2; ?>" placeholder="00000000" required="">
                              </div>

                              <div class="form-group col-md-12">
                                <label>Map Location Link</label>
                                <textarea rows="5" type="text" name="company_branch_map_link2" class="form-control" placeholder="Primary Location" value="" required=""><?php echo $company_branch_map_link2; ?></textarea>
                              </div>

                              <div class="form-group col-md-12">
                                <button class="btn btn-default btn-md" name="update_company_address2" value="<?php echo $company_branch_id2; ?>" type="submit" onclick="actionBtn('updatecompanyaddress', 'Updating Company Adress...')" id="updatecompanyaddress">
                                  Update Address
                                </button>
                              </div>
                            </div>
                          </form>
                        <?php } ?>
                      </div>

                      <?php if ($_SESSION['UserId'] == "5") { ?>

                        <div id="attributes" class="tab-pane fade in">
                          <h4 class="p-1r text-dark">Configurations</h4>
                          <div class="btn-group btn-group-sm float-right action-bar-margin">
                            <a class="btn btn-primary square btn-labeled fa fa-plus" data-toggle="modal" data-target="#attirbute">
                              Attributes</a>
                          </div>

                          <div class="table-responsive m-t-5 clearfix clear-both text-right p-1">

                            <?php
                            $FetchATTRIBUTES = SELECT("SELECT * FROM company_attributes where company_id='" . company_id . "'");
                            while ($FA = mysqli_fetch_array($FetchATTRIBUTES)) { ?>
                              <form class="flex-s-b m-b-5" action="../../controller/companycontroller.php" method="POST">
                                <input type="text" name="access_url" value="../admin/company-profile" hidden="">
                                <input class="form-control m-b-0 lh-32 disabled" readonly="" name="company_attribute_name" value="<?php echo $FA['company_attribute_name']; ?>" required="" placeholder="name">
                                <input class="form-control m-b-0 lh-32" name="company_attribute_value" value="<?php echo $FA['company_attribute_value']; ?>" required="" placeholder="value">
                                <div class="btn-group-sm">
                                  <button type="submit" name="update_company_attributes" value="<?php echo $FA['company_attribute_id']; ?>" class="btn btn-sm fs-9 btn-primary">
                                    Update</button>
                                </div>
                              </form>
                            <?php } ?>

                          </div>

                          <!-- model or pop forms -->
                          <!-- Modal  1-->
                          <div class="modal fade square" id="attirbute" role="dialog">
                            <div class="modal-dialog modal-sm">
                              <div class="modal-content">
                                <div class="modal-header app-bg text-white">
                                  <button type="button" class="close text-white m-r-5 m-t-1" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title text-white">Add Attributes</h4>
                                </div>
                                <div class="modal-body">
                                  <form action="../../controller/companycontroller.php" method="POST">
                                    <?php FormPrimaryInputs(true); ?>
                                    <div class="row">
                                      <div class="form-group col-12">
                                        <label>Attribute name</label>
                                        <input type="text" name="company_attribute_name" class="form-control" required="" placeholder="ex: GST, pan, tin, Bank Details">
                                      </div>
                                      <div class="form-group col-12">
                                        <label>Attribute Value</label>
                                        <input type="text" name="company_attribute_value" class="form-control" required="" placeholder="123, 3532872">
                                      </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  <button type="submit" name="save_attribute" value="<?php echo company_id; ?>" class="btn btn-success">Save Attribute</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        <?php } ?>

                        </div>
                    </div>
                    <!--===================================================-->
                    <!--End Default Tabs (Left Aligned)-->
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- content end -->
        </div>
        <!--===================================================-->
        <!--END CONTENT CONTAINER-->




        <!-- end -->
        <?php include '../sidebar.php'; ?>
        <?php include '../footer.php'; ?>
      </div>

      <?php include '../../include/footer_files.php'; ?>
</body>

</html>