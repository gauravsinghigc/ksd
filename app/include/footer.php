<style>
  a[class*="text-"]:not(.nav-link):not(.dropdown-item):not([role]):not(.navbar-caption) {
    background-image: none !important;
  }
</style>
<section class="footer3 cid-swlKRVy3sM" once="footers" id="footer3-8">
  <div class="container-fluid">
    <div class="media-container-row mbr-white">
      <div class="row row-links">
        <div class="col-md-4 col-lg-4 col-sm-6 col-12">
          <img src="<?php echo company_logo; ?>" title="<?php echo company_name; ?>" alt="<?php echo company_name; ?>" class="img-fluid w-25 p-1 rounded-1">
          <h4 class="pt-2 pb-2"><?php echo company_name; ?></h4>
          <p class="display-8" style="font-size: 1rem !important;"><i class="fa fa-map-marker"></i>
            <?php echo company_address2; ?>
            <?php if (company_phone == null or company_phone == "") {
            } else { ?>
              <br>
              <i class="fa fa-phone"></i> +91-<?php echo company_phone; ?> <br> <i class="fa fa-envelope"></i> <?php echo company_email; ?>
            <?php } ?>
          </p>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-6 col-12">
          <h5 class="pt-2">About <?php echo company_name; ?></h5>
          <hr>
          <ul class="foot-menu">
            <li class="foot-menu-item mbr-fonts-style display-8 text-decoration-none">
              <a class="text-white text-decoration-none" style="text-decoration: none !important;" href="<?php echo $DOMAIN; ?>">Home</a>
            </li>
            <li class="foot-menu-item mbr-fonts-style display-8">
              <a class="text-white" href="<?php echo DOMAIN; ?>/app/about-us">About us</a>
            </li>
            <li class="foot-menu-item mbr-fonts-style display-8">
              <a class="text-white" href="<?php echo DOMAIN; ?>/app/services">Services</a>
            <li class="foot-menu-item mbr-fonts-style display-8">
              <a class="text-white" href="<?php echo DOMAIN; ?>/app/projects">Projects</a>
            </li>
            <li class="foot-menu-item mbr-fonts-style display-8">
              <a class="text-white" href="<?php echo DOMAIN; ?>/app/properties">Properties</a>
            </li>
            </li>
            <li class="foot-menu-item mbr-fonts-style display-8">
              <a class="text-white" href="<?php echo DOMAIN; ?>/app/contact-us">Contact Us</a>
            </li>
          </ul>
        </div>

        <div class="col-md-4 col-lg-4 col-sm-6 col-12">
          <h5 class="pt-2">More Details</h5>
          <hr>
          <ul class="foot-menu">
            <li class="foot-menu-item mbr-fonts-style display-8">
              <a class="text-white" href="<?php echo DOMAIN; ?>/app/privacy-policy">Privacy Policy</a>
            </li>
            <li class="foot-menu-item mbr-fonts-style display-8">
              <a class="text-white" href="<?php echo DOMAIN; ?>/app/terms-and-condition">Terms & Conditions</a>
            </li>
            <li class="foot-menu-item mbr-fonts-style display-8">
              <a class="text-white" href="<?php echo DOMAIN; ?>/app/refund-and-cancellation">Refund & Cancellation</a>
            </li>
            <li class="foot-menu-item mbr-fonts-style display-8">
              <a class="text-white" href="<?php echo DOMAIN; ?>/admin" target="_blank">App Login</a>
            </li>
            <li class="foot-menu-item mbr-fonts-style display-8">
              <a class="text-white" href="https://play.google.com/store/apps/details?id=com.navixtechnologies.plotx&hl=en_IN&gl=US" target="_blank">
                <h5>Download App</h5>
                <img src="<?php echo STORAGE_URL; ?>/sys-img/download.jpg" class="w-50" alt="<?php echo company_name; ?>" title="<?php echo company_name; ?>">
              </a>
            </li>
          </ul>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <hr>
        </div>
      </div>

      <div class="row row-copirayt">
        <p class="mbr-text mb-0 mbr-fonts-style mbr-white align-center display-8" style="font-size: 1rem !important;">
          Copyrighted © <?php echo DATE("Y"); ?> <?php echo company_name; ?>. All Rights Reserved. | Developed By <a href="<?php echo DEVELOPER_URL; ?>" target="_blank" class="text-white white-underline"><?php echo DEVELOPED_BY; ?></a>
        </p>
      </div>
    </div>
  </div>
</section>

<section class="enquiry-form bg-light pb-3" style="position: fixed;
    bottom: 2rem;
    background-color: white !important;
    width: 70% !important;
    z-index: 1111111;
    right: 1%;
    min-width: 270px;
    max-width: 370px;
    box-shadow: 0px 0px 5px grey !important;
    display:none;
    border-radius:5px;" id="QueryForm">
  <div class="eqnuiry-form-area">
    <div class="heading p-3 pt-4 pb-3 bg-info text-white rounded-1 rounded">
      <h3>Send your Queries</h3>
    </div>
    <div class="form p-3">
      <form class="form" action="<?php echo CONTROLLER; ?>/enquirycontroller.php" method="POST">
        <?php FormPrimaryInputs(true); ?>
        <div class="form-group mt-2 mb-1">
          <input type="text" name="FullName" class="form-control" required="" placeholder="Enter Your Full Name">
        </div>
        <div class="form-group mt-2 mb-1">
          <input type="text" name="phone" class="form-control" required="" placeholder="+91">
        </div>
        <div class="form-group mt-2 mb-1">
          <input type="text" name="email" class="form-control" placeholder="Email Id">
        </div>
        <div class="form-group mt-2 mb-1">
          <select class="form-control" name="type" required="">
            <?php
            $SQL_project_types = SELECT("SELECT * FROM project_types where company_id='" . company_id . "' and project_type_status='ACTIVE'");
            while ($ProjectTypes = mysqli_fetch_array($SQL_project_types)) { ?>
              <option value="<?php echo $ProjectTypes['project_type_name']; ?>"><?php echo $ProjectTypes['project_type_name']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group mt-2 mb-1">
          <textarea type="text" name="message" class="form-control" placeholder="Enter Your Query" rows=3></textarea>
        </div>
        <div class="form-group mt-2 mb-1">
          <button type="submit" name="ContactForm" class="btn btn-sm btn-primary form-control">Send Query</button>
        </div>
      </form>
    </div>
  </div>
</section>

<?php
if (SOCIAL_MEDIA_FIXED == true) { ?>
  <div class="icons-menu social-media-icons">
    <?php
    $Query = SELECT("SELECT * FROM sociallinks where status='1'");
    $Count = mysqli_num_rows($Query);
    if ($Count != 0) {
      while ($fetch = mysqli_fetch_array($Query)) { ?>

        <a class="iconfont-wrapper" href="<?php echo $fetch['url']; ?>" target="_blank">
          <span class="p-2 mbr-iconfont fa <?php echo $fetch['icon']; ?> socicon"></span>
        </a>
    <?php  }
    } ?>
  </div>
<?php } ?>

<a class="btn btn-primary" style="position: fixed;
    z-index: 1111111;
    bottom: 0.5rem;
    right: 0.2%;
    cursor:pointer;" onclick="ShowForm()" id="formtext">Have an Query?</a>
<script>
  function ShowForm() {
    var QueryForm = document.getElementById("QueryForm");
    if (QueryForm.style.display == "none") {
      QueryForm.style.display = "block";
      document.getElementById("formtext").innerHTML = "Close";
      document.getElementById("formtext").classList.remove("btn-primary");
      document.getElementById("formtext").classList.add("btn-danger");
    } else {
      QueryForm.style.display = "none";
      document.getElementById("formtext").innerHTML = "Have an Query?";
      document.getElementById("formtext").classList.remove("btn-danger");
      document.getElementById("formtext").classList.add("btn-primary");
    }
  }
</script>
<section style="background-color: #fff; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif; color:#aaa; font-size:12px; padding: 0; align-items: center; display: none;">
  <a href="https://mobirise.site/l" style="flex: 1 1; height: 3rem; padding-left: 1rem;"></a>
  <p style="flex: 0 0 auto; margin:0; padding-right:1rem;"><a href="https://mobirise.site/k" style="color:#aaa;"></a></p>
</section>