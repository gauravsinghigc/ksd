<?php
require '../../require/modules.php';
require '../../include/extra/web_body.php';
require '../../include/extra/web_common.php';
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="<?php echo company_name; ?>, App Version <?php echo APP_VERSION; ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <?php include '../include/meta.php'; ?>

  <title>Projects | <?php echo company_name; ?></title>
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
  <section class="content5 cid-swlMFugAXk" id="content5-f" style="background-image: url('<?php echo DOMAIN; ?>/storage/web-img/1531661627p8.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    background-size: cover;">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-12 col-lg-11 mt-5">
          <h3 class="mbr-section-title text-white mbr-fonts-style mb-4 pt-4 pb-5 display-2">
            <strong>Projects | <?php echo company_name; ?></strong>
          </h3>
        </div>
      </div>
    </div>
  </section>

  <?php
  include '../include/pro_section.php';
  include '../include/contact_form.php';
  include '../include/follow.php';
  ?>

  <?php
  include '../include/footer.php';
  include '../include/scripts.php'; ?>
</body>

</html>