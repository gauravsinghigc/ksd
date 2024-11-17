<section class="features5 cid-swlM0m3RmZ" id="features6-e">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-lg-12 col-md-12 col-12 col-sm-12 text-center pb-4">
        <h1 class="heading card-title">Our Projects</h1>
        <p>We provide various type of lands, plots, flats, residential & commercial property.</p>
      </div>
      <?php
      $SelectServices = SELECT("SELECT * FROM projects where project_status='ACTIVE'");
      $CountServices = mysqli_num_rows($SelectServices);
      if ($CountServices != 0) {
        while ($FetchServices = mysqli_fetch_array($SelectServices)) { ?>

          <div class="col-lg-4 col-md-4 col-sm-6 col-12">
            <div class="bg-light p-2">
              <div class="img-fluid">
                <img src="<?php echo STORAGE_URL; ?>/projects/media/<?php echo FETCH("SELECT * FROM project_media_files where ProjectMainProjectId='" . $FetchServices['Projects_id'] . "' ORDER BY ProjectMediaFileId DESC LIMIT 1", "ProjectMediaFileAttachements"); ?>" style="height: 13.7rem;">
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
                <a href="<?php echo DOMAIN; ?>/app/projects/project_details.php?id=<?php echo $FetchServices['Projects_id']; ?>" class="btn btn-primary display-4">View Project</a>
              </div>
            </div>
          </div>
      <?php }
      } ?>
    </div>
  </div>
</section>