<?php
require '../../require/modules.php';
require '../../include/extra/web_body.php';
require '../../include/extra/web_common.php'; ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="<?php echo DEVELOPED_BY; ?>, App Version <?php echo APP_VERSION; ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <?php include '../include/meta.php'; ?>
  <title>Live Project Maps | <?php echo company_name ?></title>
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
              <strong>Live Project Maps | <?php echo company_name ?></strong>
            </h3>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="features5 cid-swlM0m3RmZ" id="features6-e">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12 col-12 col-sm-12 text-center pb-4">
          <h1 class="heading card-title">Our Live Projects Maps</h1>
          <p>Live Project Map is digital, dynamic and easy to understand Project area, design and actual project location digitally with their sold, active, hold status.</p>
        </div>
        <?php
        $SelectServices = SELECT("SELECT * FROM projects where project_status='ACTIVE'");
        $CountServices = mysqli_num_rows($SelectServices);
        if ($CountServices != 0) {
          while ($FetchServices = mysqli_fetch_array($SelectServices)) { ?>

            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
              <div class="bg-light p-2">
                <div class="img-fluid">
                  <img src="<?php echo STORAGE_URL; ?>/projects/media/<?php echo FETCH("SELECT * FROM project_media_files where ProjectMediaFileType='image' and ProjectMainProjectId='" . $FetchServices['Projects_id'] . "' ORDER BY ProjectMediaFileId DESC LIMIT 1", "ProjectMediaFileAttachements"); ?>" style="height: 13.7rem;">
                </div>
                <div class="" style="height: 17rem !important;
    overflow: hidden;">
                  <h2 class="pt-3 pb-3 display-6"><strong><?php echo $FetchServices['project_title']; ?></strong><br>
                    <small class="text-grey"><?php echo $FetchServices['project_type']; ?></small>
                  </h2>
                  <p class="mbr-text mbr-fonts-style mb-3 display-4">
                    <?php
                    $ServiceDetails = $FetchServices['project_descriptions'];
                    $ReqDetails = $ServiceDetails;
                    echo  $ReqDetails; ?>
                    <br>
                    <b>Project Area :</b> <?php echo $FetchServices['project_area']; ?> <?php echo $FetchServices['project_measure_unit']; ?><br>
                    <b>Total Unit : </b> <?php echo TOTAL("SELECT * FROM project_units where project_id='" . $FetchServices['Projects_id'] . "'"); ?> Plots
                  </p>
                </div>
                <div class="mbr-section-btn">
                  <a href="<?php echo DOMAIN; ?>/app/live-map/<?php echo $FetchServices['Projects_id']; ?>/" class="btn btn-primary display-4" target="_blank">View Project Map</a>
                </div>
              </div>
            </div>
        <?php }
        } ?>
      </div>
    </div>
  </section>

  <?php
  include '../include/follow.php';
  ?>

  <?php
  include '../include/footer.php';
  include '../include/scripts.php'; ?>
</body>

</html>