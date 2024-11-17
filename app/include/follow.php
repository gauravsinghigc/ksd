<section class="contacts4 cid-swlLtNVtTa" id="contacts4-a">

  <div class="container">
    <div class="row align-items-center justify-content-center">
      <div class="text-content col-12 col-md-6">
        <h2 class="mbr-section-title mbr-fonts-style display-6">
          <strong>Like, Share & Follow</strong>
        </h2>
        <p class="mbr-text mbr-fonts-style display-8">
          Follow, like, share <?php echo company_name; ?> on social account and stay updated to latest real state
          news, offers and updates.
        </p>
      </div>
      <div class="icons d-flex align-items-center col-12 col-md-6 justify-content-end mt-md-0 mt-2 flex-wrap">
        <?php
        $Query = SELECT("SELECT * FROM sociallinks where status='1'");
        $Count = mysqli_num_rows($Query);
        if ($Count != 0) {
          while ($fetch = mysqli_fetch_array($Query)) { ?>
            <a href="<?php echo $fetch['url']; ?>" target="_blank">
              <span class="fa <?php echo $fetch['icon']; ?> socicon mbr-iconfont mbr-iconfont-social"></span>
            </a>
        <?php  }
        } ?>

      </div>
    </div>
  </div>

</section>