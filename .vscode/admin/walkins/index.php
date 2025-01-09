<?php
require '../../require/modules.php';
require "../../require/admin/sessionvariables.php";
require '../../include/admin/common.php';


$PageName = "Walkins/Enquiries";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo $PageName; ?> | <?php echo company_name; ?></title>
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
                      <h3 class="m-t-3"><i class="fa fa-info-circle app-text"></i> Walkins & Local Enquiries</h3>
                    </div>
                    <div class="col-md-12">
                      <div class="flex-s-b">
                        <div class="btn-group btn-group-sm w-100 m-b-10">
                          <a class="btn btn-primary square btn-labeled fa fa-plus" href="add-enquiry.php">Walkins</a>
                          <?php if (isset($_GET['search'])) { ?>
                            <a href="<?php echo DOMAIN; ?>/admin/enquiries/export.php?search_type=<?php echo $_GET['search_type']; ?>&search_value=<?php echo $_GET['search_value']; ?>&search=true" target="blank" class="btn btn-secondary square btn-labeled fa fa-print">Export All</a>
                          <?php } else { ?>
                            <a href="<?php echo DOMAIN; ?>/admin/enquiries/export.php" target="blank" class="btn btn-secondary square btn-labeled fa fa-print">Export All</a>
                          <?php } ?>
                        </div>

                        <div class="btn-group btn-group-sm w-100 m-b-10">
                          <?php SEARCH_FORM([
                            "WalkinName" => "Person Full Name",
                            "WalkinPhone" => "Phone Number",
                            "WalkinAddress" => "Address",
                            "WalkinEmailid" => "Email Id",
                            "WalkinTypes" => "Types/Purpose",
                            "WalkinsRemarks" => "Remark/Notes",
                            "WalkinCreatedAt" => "Walkin Dates"
                          ]); ?>
                        </div>
                      </div>
                    </div>
                    <?php CLEAR_SEARCH(); ?>
                    <div class="col-lg-12 col-md-12 col-12 col-sm-12 p-l-0 p-r-0">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th style=" width:5%;">WalkinId</th>
                            <th>WalkinName</th>
                            <th>WalkinPhone</th>
                            <th>WalkinAddress</th>
                            <th>WalkinEmailid</th>
                            <th>WalkinTypes</th>
                            <th>WalkinCreatedAt</th>
                            <th>Details</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if (isset($_GET['search'])) {
                            $search_type = $_GET['search_type'];
                            $search_value = $_GET['search_value'];
                            $SQL_expanses = SELECT("SELECT * FROM walkins where $search_type like '%$search_value%' ORDER BY walkinsid DESC");
                          } else {
                            $SQL_expanses = SELECT("SELECT * FROM walkins ORDER BY walkinsid DESC");
                          }
                          $Count = 0;
                          while ($Fetchexpanses = mysqli_fetch_array($SQL_expanses)) {
                            $walkinsid  = $Fetchexpanses['walkinsid'];
                            $WalkinName = $Fetchexpanses['WalkinName'];
                            $WalkinPhone = $Fetchexpanses['WalkinPhone'];
                            $WalkinAddress = SECURE($Fetchexpanses['WalkinAddress'], "d");
                            $WalkinEmailid = $Fetchexpanses['WalkinEmailid'];
                            $WalkinTypes = $Fetchexpanses['WalkinTypes'];
                            $WalkinsRemarks = SECURE($Fetchexpanses['WalkinsRemarks'], "d");
                            $WalkinCreatedAt = $Fetchexpanses['WalkinCreatedAt'];
                            $Count++;
                          ?>
                            <tr>
                              <td><?php echo $Count; ?></td>
                              <td><?php echo $WalkinName; ?></td>
                              <td><?php echo $WalkinPhone; ?></td>
                              <td><?php echo $WalkinTypes; ?></td>
                              <td><?php echo $WalkinEmailid; ?></td>
                              <td><?php echo $WalkinAddress; ?></td>
                              <td><?php echo $WalkinCreatedAt; ?></td>
                              <td>
                                <a href="#" title="<?php echo $WalkinsRemarks; ?>" alt="<?php echo $WalkinsRemarks; ?>" class="btn btn-primary btn-sm">Info</a>
                              </td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>


    <!-- Modal  3-->
    <div class="modal fade square" id="add_data" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header app-bg text-white">
            <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-white">Add Expanse</h4>
          </div>
          <div class="modal-body overflow-auto">
            <form action="../../controller/expansecontroller.php" method="POST" enctype="multipart/form-data">
              <input type="text" name="access_url" value="../admin/expanses/" hidden="">
              <div class="row">
                <div class="form-group col-12 col-md-12">
                  <label>Expanse Title</label>
                  <input type="text" name="expanses_title" class="form-control" required="" placeholder="Expanse Name">
                </div>
                <div class="form-group col-12 col-md-12">
                  <label>Expanse Tags</label>
                  <input name="expanses_tags" class="form-control" id="expanse_tags" required="">
                  <datalist id="browsers">
                    <?php
                    $expnasesSQL = SELECT("SELECT * from expanses");
                    while ($FETCHexpansesTags = mysqli_fetch_array($expnasesSQL)) {
                      $expanses_tags = $FETCHexpansesTags['expanses_tags']; ?>
                      <option value="<?php echo $expanses_tags; ?>"></option>
                    <?php } ?>
                  </datalist>
                </div>

                <div class="form-group col-6 col-md-6">
                  <label>Expanse/Billing Date</label>
                  <input type="date" name="expanse_date" class="form-control" require="" placeholder="12234">
                </div>
                <div class="form-group col-6 col-md-6">
                  <label>Expanse/Billing Amount</label>
                  <input class="form-control" placeholder="" name="expanse_amount" rows="3">
                </div>
                <div class="form-group col-12 col-md-12">
                  <label>Expanse Description</label>
                  <textarea type="text" name="expanse_description" class="form-control" required=""></textarea>
                </div>
                <div class="form-group col-12 col-md-12">
                  <label>Bill/Invoice/File</label>
                  <input type="FILE" name="expanse_file" class="form-control">
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="create_new_expanses" value="<?php echo company_id; ?>" class="btn btn-success" onclick="actionBtn('create_expanse', 'Saving...')" id="create_expanse">Save</button>
            </form>
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