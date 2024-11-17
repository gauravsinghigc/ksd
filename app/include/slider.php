<style>
  .carousel-caption {
    text-align: left !important;
    background: #2c61330a !important;
    padding: 4% !important;
    bottom: 10rem !important;
  }

  @media (max-width: 767px) {
    .cid-swlLsUSZnA .carousel-control {
      bottom: 33rem !important;
    }

    .carousel-caption {
      text-align: left !important;
      background: #2c61330a !important;
      padding: 4% !important;
      bottom: 25rem !important;
    }

  }

  .cid-swlLsUSZnA .carousel-control {
    width: 50px !important;
    height: 50px !important;
  }

  .mbr-fullscreen {
    min-height: fit-content !important;
  }

  .cid-swlLsUSZnA .carousel-control.carousel-control-next {
    margin-right: 0.5rem !important;
  }

  .cid-swlLsUSZnA .carousel-control.carousel-control-prev {
    margin-left: 0.5rem !important;
  }
</style>
<section class="slider1 cid-swlLsUSZnA mbr-fullscreen" id="slider1-9">
  <div class="carousel slide" id="swlOPsMLRV" data-ride="carousel" data-interval="4000">
    <ol class="carousel-indicators">
      <?php
      $SelectSlider = SELECT("SELECT * FROM sliders where Status='1'");
      $CountSliders = mysqli_num_rows($SelectSlider);
      $Count = 0;
      if ($CountSliders != 0) {
        while ($FetchSliders = mysqli_fetch_array($SelectSlider)) {
          if ($Count == 0) {
            $active = "active";
          } else {
            $active = "";
          } ?>
          <li data-slide-to="<?php echo $Count; ?>" class="<?php echo $active; ?>"></li>
      <?php $Count++;
        }
      }
      ?>
    </ol>
    <div class="carousel-inner">

      <div class="carousel-item slider-image item active">
        <div class="item-wrapper">
          <img class="d-block w-100" src="<?php echo STORAGE_URL; ?>/img/sliders/slider_183306188_14_Dec_2021_10_12_09.jpg" alt='<?php echo company_name; ?>' title='<?php echo company_name; ?>'>
          <div class="carousel-caption">
            <h5 class="mbr-section-subtitle mbr-fonts-style display-5">
              <strong><?php echo company_name; ?></strong>
            </h5>
            <p class="mbr-section-text mbr-fonts-style display-7">
              <?php echo company_desc; ?></p>
            <div class="mbr-section-btn">
              <a href="contact-us.php" class="btn btn-primary display-4">Get Enquiry</a>
            </div>
          </div>
        </div>
      </div>

      <?php
      $SelectSlider = SELECT("SELECT * FROM sliders where Status='1'");
      $CountSliders = mysqli_num_rows($SelectSlider);
      $Count = 0;
      if ($CountSliders != 0) {
        while ($FetchSliders = mysqli_fetch_array($SelectSlider)) {
          $Count++; ?>

          <div class="carousel-item slider-image item">
            <div class="item-wrapper">
              <img class="d-block w-100" src="<?php echo STORAGE_URL . "/website/slider/" . $FetchSliders['sliderimg']; ?>" alt='<?php echo $FetchSliders['slidertitle']; ?>' title='<?php echo $FetchSliders['slidertitle']; ?>'>
              <div class="carousel-caption">
                <h5 class="mbr-section-subtitle mbr-fonts-style display-5">
                  <strong><?php echo $FetchSliders['slidertitle']; ?></strong>
                </h5>
                <p class="mbr-section-text mbr-fonts-style display-7">
                  <?php echo SECURE("" . $FetchSliders['sliderdesc'] . "", "d"); ?></p>
                <div class="mbr-section-btn">
                  <a href="contact-us.php" class="btn btn-primary display-4">Get Enquiry</a>
                </div>
              </div>
            </div>
          </div>
      <?php }
      }
      ?>

    </div>
    <a class="carousel-control carousel-control-prev" role="button" data-slide="prev" href="#swlOPsMLRV">
      <span class="mobi-mbri mobi-mbri-arrow-prev" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control carousel-control-next" role="button" data-slide="next" href="#swlOPsMLRV">
      <span class="mobi-mbri mobi-mbri-arrow-next" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</section>