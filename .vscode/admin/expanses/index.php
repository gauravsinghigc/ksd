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
  <title>Expanses | <?php echo company_name; ?></title>
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
                      <h3 class="m-t-3"><i class="fa fa-exchange app-text"></i> Expanses</h3>
                    </div>
                    <div class="col-md-12">
                      <div class="flex-s-b">
                        <div class="btn-group btn-group-sm w-100 m-b-10">
                          <a class="btn btn-primary square btn-labeled fa fa-plus" data-toggle="modal" data-target="#add_data">Expanses</a>
                          <a href="export_all.php" target="blank" class="btn btn-secondary square btn-labeled fa fa-print">Export All</a>
                        </div>

                        <div class="btn-group btn-group-sm w-100 m-b-10">
                          <?php SEARCH_FORM([
                            "expanses_id" => "Expanse Id",
                            "expanses_title" => "Expanse Title",
                            "expanses_tags" => "Expanse Tags",
                            "expanse_amount" => "Expanse Amount",
                            "expanse_description" => "Expanse Description",
                            "expanse_date" => "Expanse date"
                          ]); ?>
                        </div>
                      </div>
                    </div>
                    <?php CLEAR_SEARCH(); ?>
                    <div class="col-lg-12 col-md-12 col-12 col-sm-12 p-l-0 p-r-0">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th style="width:5%;">ExpanseId</th>
                            <th>Title</th>
                            <th>Tag</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th style="width:15%;">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if (isset($_GET['search'])) {
                            $search_type = $_GET['search_type'];
                            $search_value = $_GET['search_value'];
                            $SQL_expanses = SELECT("SELECT * FROM expanses where $search_type like '%$search_value%' ORDER BY expanses_id DESC");
                          } else {
                            $SQL_expanses = SELECT("SELECT * FROM expanses ORDER BY expanses_id DESC");
                          }
                          $Count = 0;
                          while ($Fetchexpanses = mysqli_fetch_array($SQL_expanses)) {
                            $Count++;
                            $expanses_id = $Fetchexpanses['expanses_id'];
                            $expanse_created_by = $Fetchexpanses['expanse_created_by'];
                            $expanses_title = $Fetchexpanses['expanses_title'];
                            $expanses_tags = $Fetchexpanses['expanses_tags'];
                            $expanse_date = $Fetchexpanses['expanse_date'];
                            $expanse_amount = $Fetchexpanses['expanse_amount'];
                            $expanse_description = html_entity_decode($Fetchexpanses['expanse_description']);
                            $expanses_created_at = $Fetchexpanses['expanses_created_at'];
                            $expanse_file = $Fetchexpanses['expanse_file'];
                            $year = date("Y", strtotime($expanse_date));
                            $month = date("M", strtotime($expanse_date));
                          ?>
                            <tr>
                              <td><?php echo $Count; ?></td>
                              <td><?php echo $expanses_title; ?></td>
                              <td><?php echo $expanses_tags; ?></td>
                              <td><?php echo date("d M, Y", strtotime($expanse_date)); ?></td>
                              <td><i class="fa fa-inr text-success"></i> <?php echo $expanse_amount; ?></td>
                              <td>
                                <?php if ($expanse_file == "null") {
                                  echo "No File";
                                } else { ?>
                                  <a href="<?php echo DOMAIN; ?>/storage/expanses/<?php echo $year; ?>/<?php echo $month; ?>/<?php echo $expanse_file; ?>" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-eye"></i> File</a>
                                <?php } ?>
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
              <?php FormPrimaryInputs(true); ?>
              <div class="row">
                <div class="form-group col-12 col-md-12">
                  <label>Expanse Title</label>
                  <input type="text" name="expanses_title" class="form-control" placeholder="Expanse Name">
                </div>
                <div class="form-group col-12 col-md-12">
                  <label>Expanse Tags/Categories</label>
                  <input name="expanses_tags" class="form-control" list="expanses_tags" required="">
                  <?php SUGGEST("expanses", "expanses_tags", "ASC"); ?>
                </div>

                <div class="form-group col-6 col-md-6">
                  <label>Expanse/Billing Date</label>
                  <input type="date" name="expanse_date" value="<?php echo date("Y-m-d"); ?>" class="form-control" require="" placeholder="12234">
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
                  <label>Bill/Invoice/File (optional)</label>
                  <input type="FILE" name="expanse_file" value="null" class="form-control">
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