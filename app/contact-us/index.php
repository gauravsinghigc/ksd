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

  <title>Contact Us | <?php echo company_name; ?></title>
  <?php include '../include/header_files.php'; ?>
  <style>
    p {
      font-size: calc(1.07rem + (1.2 - 1.07) * ((100vw - 20rem) / (48 - 20))) !important;
      line-height: calc(1.4 * (1.07rem + (1.2 - 1.07) * ((100vw - 20rem) / (48 - 20)))) !important;
    }
  </style>
</head>

<body>
  <?php include '../include/header.php';
  require '../../include/extra/web_body.php'; ?>
  <section class="content4 cid-swlOyo6IEd" id="content4-q" style="background-image:url('<?php echo DOMAIN; ?>/storage/web-img/contact-1.webp');">
    <div class="container">
      <div class="row">
        <div class="title col-md-12 col-lg-12" style="background: #0080001f;padding: 3%;">
          <h3 class="mbr-section-title mbr-fonts-style align-left mb-4 display-2">
            <strong>Contact Us | <?php echo company_name ?></strong>
          </h3>
          <h4 class="mbr-section-subtitle align-left mbr-fonts-style mb-0 display-5">
            Feel free to contact us for queries, suggestions, and feedbacks.
          </h4>
        </div>
      </div>
    </div>
  </section>
  <section class="form5 cid-swlOvWpUck">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
          <div class="bg-light p-3" style="height: 11rem;">
            <h3><strong>Corporate Address</strong></h3>
            <p><i class="fa fa-map-marker text-info"></i> <?php echo company_address; ?></p>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
          <div class="bg-light p-3" style="height: 11rem;">
            <h3><strong>Call Us</strong></h3>
            <p>
              <a href="tel:<?php echo company_phone; ?>"><i class="fa fa-phone text-success"></i>
                <?php echo company_phone; ?>
              </a>
            </p>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
          <div class="bg-light p-3" style="height: 11rem;">
            <h3><strong>Mail Us</strong></h3>
            <p>
              <a href="mailto:<?php echo company_email; ?>">
                <i class="fa fa-envelope text-primary"></i> <?php echo company_email; ?>
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="form5 cid-swlOvWpUck pt-0" id="form5-p">
    <div class="container">
      <div class="row justify-content-center mt-0">
        <div class="col-lg-8 mx-auto mbr-form" data-form-type="formoid">
          <h1>Send Your Query, feedback & Suggestions</h1>
          <p>We welcome all queries, feedback, suggestions, because they improve us and our services.</p>
          <hr>
          <form action="../../admin/web-admin/action/insert.php" method="POST" class="mbr-form form-with-styler" data-form-title="Form Name">
            <input type="text" name="access_url" value="<?php echo get_url(); ?>" hidden="">
            <div class="dragArea row">
              <div class="col-md-6 col-sm-12 form-group" data-for="name">
                <input type="text" name="FullName" placeholder="Name" data-form-field="name" class="form-control" value="" id="name-form5-p">
              </div>
              <div class="col-md-6 col-sm-12 form-group" data-for="email">
                <input type="email" name="email" placeholder="E-mail" data-form-field="email" class="form-control" value="" id="email-form5-p">
              </div>
              <div class="col-12 form-group" data-for="url">
                <input type="text" name="phone" placeholder="Phone" data-form-field="phone" class="form-control" value="">
              </div>
              <div class="col-12 form-group" data-for="url">
                <select class="form-control" name="type" required="">
                  <?php
                  $SQL_project_types = SELECT("SELECT * FROM project_types where company_id='" . company_id . "' and project_type_status='ACTIVE'");
                  while ($ProjectTypes = mysqli_fetch_array($SQL_project_types)) { ?>
                    <option value="<?php echo $ProjectTypes['project_type_name']; ?>"><?php echo $ProjectTypes['project_type_name']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-12 form-group" data-for="textarea">
                <textarea name="message" placeholder="Message" rows="6" data-form-field="textarea" class="form-control" id="textarea-form5-p"></textarea>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 align-center mbr-section-btn">
                <button type="submit" name="ContactForm" value="CONTACT_FORM" class="btn btn-primary display-4">Send
                  message</button>
              </div>
            </div>
          </form>
        </div>
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