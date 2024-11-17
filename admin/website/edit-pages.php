<?php
$Dir = "../..";
require $Dir . '/require/modules.php';
require $Dir . "/require/admin/sessionvariables.php";
require $Dir . '/include/admin/common.php';

$PageName = "Edit Page";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title> <?php echo $PageName; ?> | <?php echo company_name; ?></title>
  <?php include $Dir . '/include/header_files.php'; ?>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../header.php'; ?>

    <!--END NAVBAR-->
    <div class="boxed">
      <div id="content-container">
        <div id="page-content">

          <div class="panel">
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12">
                  <h3 class="m-t-3"><i class="fa fa-file app-text"></i> <?php echo $PageName; ?></h3>
                </div>
              </div>

              <div class="row">
                <?php
                if (isset($_GET['id'])) {
                  $Pageid = $_GET['id'];
                  $_SESSION['PageId'] = $Pageid;
                } else {
                  $Pageid = $_SESSION['PageId'];
                }
                $fetchPages = FetchConvertIntoArray("SELECT * FROM pages where PagesId='$Pageid'", true);
                if ($fetchPages == null) {
                  NoData("No Page Found");
                } else {
                  foreach ($fetchPages as $Pages) { ?>
                    <div class="col-md-12 col-lg-12">
                      <div class="shadow-sm p-2 m-b-20">
                        <small class="text-grey">Current Page Name</small>
                        <h4 class="m-t-0 bold section-heading"><b><?php echo $Pages->PageTitle; ?></b></h4>
                        <form action="<?php echo CONTROLLER; ?>/pagecontroller.php" method="POST">
                          <?php FormPrimaryInputs(true, [
                            "PageId" => $Pages->PagesId
                          ]); ?>
                          <div class="row">
                            <div class="col-md-12 form-group">
                              <label>Page Name</label>
                              <input type="text" name="PageTitle" class="form-control" value="<?php echo $Pages->PageTitle; ?>" required="">
                            </div>

                            <div class="col-md-12 form-group">
                              <label>Page Descriptions</label>
                              <textarea class="form-control editor" rows="50" name="PageDesc"><?php echo html_entity_decode(SECURE($Pages->PageDesc, "d")); ?></textarea>
                            </div>

                            <div class="col-md-12">
                              <button class="btn btn-sm btn-primary" name="UpdatePageDetails">Update Page Descriptions</button>
                              <a href="index.php" class="btn btn-sm btn-default">Back to All Pages</a>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                <?php }
                } ?>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
    <?php include  '../sidebar.php'; ?>
    <?php include  '../footer.php'; ?>
  </div>

  <?php include $Dir . '/include/footer_files.php'; ?>
</body>

</html>