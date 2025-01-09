<footer id="footer">

  <!-- Visible when footer positions are static -->
  <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
  <div class="m-l-10 flex-start">
    <a href="<?php echo DOMAIN; ?>/dashboard" class="text-white fs-13 suggest-view"><i class="fa fa-angle-left"></i> Back to Modules
      <span class="suggest-text">Click for Back to All Modules</span>
    </a>
    <form action="<?php echo DOMAIN; ?>/controller/usercontroller.php" method="POST" class="m-l-15">
      <?php FormPrimaryInputs(true); ?>
      <?php $alert_sound = FETCH("SELECT * FROM users where id='" . LOGIN_UserId . "'", "alert_sound"); ?>
      <?php
      if ($alert_sound === "ON") { ?>
        <button type="submit" name="alert_sound" class="text-black s-button suggest-view" value="<?php echo $alert_sound; ?>">
          Sound <?php echo $alert_sound; ?> <i class="fa fa-volume-up text-success"></i>
          <span class="suggest-text">Click to OFF Notification Sound</span>
        </button>
      <?php } else { ?>
        <button type="submit" class="text-black s-button suggest-view" name="alert_sound" value="<?php echo $alert_sound; ?>">
          Sound <?php echo $alert_sound; ?> <i class="fa fa-volume-off text-danger"></i>
          <span class="suggest-text">Click to ON Notification Sound</span>
        </button>
      <?php } ?>
      <input type="text" name="notification_update" value="true" hidden="">
    </form>
  </div>
  <div class="hide-fixed text-white m-r-10">
    Copyrighted &#0169; <?php echo date("Y"); ?> By <?php echo DEVELOPED_BY; ?> | <?php echo APP_NAME; ?>
    <a href=" <?php echo DEVELOPER_DOMAIN; ?>" class="text-white text-decoration-underline" target="blank"> </a> v<?php echo APP_VERSION; ?>
  </div>

</footer>
<!--===================================================-->
<!-- END FOOTER -->
<!-- SCROLL TOP BUTTON -->
<!--===================================================-->