<style>
  p {
    font-size: calc(1.07rem + (1.2 - 1.07) * ((100vw - 20rem) / (48 - 20))) !important;
    line-height: calc(1.4 * (1.07rem + (1.2 - 1.07) * ((100vw - 20rem) / (48 - 20)))) !important;
  }
</style>
<section class="content15" id="content15-c">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="card col-md-12 col-lg-11 pt-5 pb-3">
        <div class="card-wrapper">
          <div class="card-box align-left text-black">
            <h4 class="card-title mbr-fonts-style mbr-black mb-3 display-5 pt-2">
              <strong>About | <?php echo company_name; ?></strong>
            </h4>
            <p class="mbr-text mbr-fonts-style display-7 text-black">
              <?php
              $Select = SELECT("SELECT * FROM pages where PageTitle='HomePage'");
              $Fetch = mysqli_fetch_array($Select);
              $HomePageIntro = $Fetch['PageDesc'];
              echo SECURE("$HomePageIntro", "d"); ?>
            </p>
            <div class="mbr-section-btn mt-3"><a class="btn btn-primary display-4" href="<?php echo DOMAIN; ?>/app/about-us">Know More...</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>