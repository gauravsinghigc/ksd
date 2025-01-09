<?php
$Dir = "../..";
require $Dir . '/require/modules.php';
require $Dir . "/require/admin/sessionvariables.php";
require $Dir . '/include/admin/common.php';

$PageName = "Pages";
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
        $fetchPages = FetchConvertIntoArray("SELECT * FROM pages", true);
        if ($fetchPages == null) {
         NoData("No Page Found");
        } else {
         foreach ($fetchPages as $Pages) { ?>
          <div class="col-md-6 col-lg-6">
           <div class="shadow-sm p-2 m-b-20">
            <small class="text-grey">Page Name</small>
            <h4 class="m-t-0 bold section-heading"><b><?php echo $Pages->PageTitle; ?></b></h4>

            <div class="page-desc">
             <?php echo SECURE($Pages->PageDesc, "d"); ?>
            </div>
            <hr>
            <a href="edit-pages.php?id=<?php echo $Pages->PagesId; ?>" class='btn btn-sm btn-primary'>Edit <?php echo $Pages->PageTitle; ?> Page</a>
            <span>
             <small class="text-grey">Last Updated At</small>
             <?php echo $Pages->UpdatedAt; ?>
            </span>
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