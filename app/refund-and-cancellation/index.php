<?php
require '../../config.php';
require '../../extra/web_body.php';
require '../../extra/web_common.php'; ?>
<!DOCTYPE html>
<html>

<head>
 <meta charset="UTF-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="generator" content="<?php echo DEVELOPED_BY; ?>, App Version <?php echo APP_VERSION; ?>">
 <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
 <?php include '../include/meta.php'; ?>

 <title>Refund and Cancellation | <?php echo company_name; ?></title>
 <?php include '../include/header_files.php'; ?>
 <style>
  p {
   font-size: calc(1.07rem + (1.2 - 1.07) * ((100vw - 20rem) / (48 - 20))) !important;
   line-height: calc(1.4 * (1.07rem + (1.2 - 1.07) * ((100vw - 20rem) / (48 - 20)))) !important;
  }
 </style>
</head>

<body>
 <?php include '../include/header.php'; ?>
 <section class="content5 cid-swlMFugAXk" id="content5-f" style="background-image: url('<?php echo DOMAIN; ?>/storage/web-img/contact-us-background.png');padding-top: 4rem;">

  <div class="container-fluid">
   <div class="row justify-content-center">
    <div class="col-md-12 col-lg-12 pl-1 pr-1 mt-5">
     <div style="padding-top:3rem !important;background-color: #2c5d2c47;" class="p-3">
      <h3 class="mbr-section-title text-white mbr-fonts-style mb-2 display-2">
       <strong>Refund and Cancellation | <?php echo $DOMAIN; ?></strong>
      </h3>
     </div>
    </div>
   </div>
  </div>
 </section>

 <section class="content5">
  <div class="container-fluid">
   <div class="row">
    <div class="col-md-12 col-12 text-justify pt-4">
     <h4 class="mbr-section-subtitle mbr-fonts-style mb-4 display-5">
      Refund and Cancellation
     </h4>
     <p class="mbr-text mbr-fonts-style display-7">
      <?php
      $Select = SELECT("SELECT * FROM pages where PagesId='5'");
      $Fetch = mysqli_fetch_array($Select);
      $HomePageIntro = $Fetch['PageDesc'];
      echo SECURE("$HomePageIntro", "d"); ?>
     </p>
    </div>
   </div>
  </div>
 </section>

 <?php
 include '../include/contact_form.php';
 include '../include/follow.php';
 ?>

 <?php
 include '../include/footer.php';
 include '../include/scripts.php'; ?>
</body>

</html>