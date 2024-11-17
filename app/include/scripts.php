<script src="<?php echo DOMAIN; ?>/web/assets/web/assets/jquery/jquery.min.js"></script>
<script src="<?php echo DOMAIN; ?>/web/assets/popper/popper.min.js"></script>
<script src="<?php echo DOMAIN; ?>/web/assets/tether/tether.min.js"></script>
<script src="<?php echo DOMAIN; ?>/web/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo DOMAIN; ?>/web/assets/smoothscroll/smooth-scroll.js"></script>
<script src="<?php echo DOMAIN; ?>/web/assets/viewportchecker/jquery.viewportchecker.js"></script>
<script src="<?php echo DOMAIN; ?>/web/assets/dropdown/js/nav-dropdown.js"></script>
<script src="<?php echo DOMAIN; ?>/web/assets/dropdown/js/navbar-dropdown.js"></script>
<script src="<?php echo DOMAIN; ?>/web/assets/touchswipe/jquery.touch-swipe.min.js"></script>
<script src="<?php echo DOMAIN; ?>/web/assets/parallax/jarallax.min.js"></script>
<script src="<?php echo DOMAIN; ?>/web/assets/sociallikes/social-likes.js"></script>
<script src="<?php echo DOMAIN; ?>/web/assets/theme/js/script.js"></script>
<script>
 //scroll acitivity
 window.onscroll = function() {
  myFunction();
 };
 var header2 = document.getElementById("header");

 function myFunction() {
  if (window.pageYOffset > sticky) {
   header2.classList.add("bg-primary");
  } else {
   header2.classList.remove("bg-primary");
  }
 }
</script>