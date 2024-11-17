<?php
//Display msg
if (isset($_SESSION['msg']) or isset($_SESSION['err']) or isset($_SESSION['alert']) or isset($_SESSION['info'])) {
  if (isset($_SESSION['msg'])) {
    $MsgDis = $_SESSION['msg'];
    $bg = "bg-success";
    $dis = "<i class='fa fa-check-circle font-20'></i> Success!";
    $tone = DOMAIN . "/admin/web-admin/assets/data/tone/alert_tone.mp3";
  } elseif (isset($_SESSION['err'])) {
    $MsgDis = $_SESSION['err'];
    $bg = "bg-danger";
    $dis = "<i class='fa fa-times font-20'></i> Failed!";
    $tone =  DOMAIN . "/admin/web-admin/assets/data/tone/danger_alert.mp3";
  } elseif (isset($_SESSION['alert'])) {
    $MsgDis = $_SESSION['alert'];
    $bg = "bg-warning";
    $dis = "<i class='fa fa-warning font-20'></i> Warning!";
    $tone =  DOMAIN . "/admin/web-admin/assets/data/tone/warning.mp3";
  } elseif (isset($_SESSION['info'])) {
    $MsgDis = $_SESSION['info'];
    $bg = "bg-info";
    $dis = "<i class='fa fa-bell font-20'></i> Info!";
    $tone =  DOMAIN . "/admin/web-admin/assets/data/tone/info.mp3";
  }
  echo '
<div class="text-black border-circle mb-4 square p-1 notification-box" id="MsgArea">
 <audio controls autoplay hidden="">
  <source src="' . $tone . '" type="audio/mp3">
 </audio>
 <p class="mb-0">
 <h6 class="' . $bg . ' p-2 text-white" onclick="HideMsgNote()"> ' . $dis . '</h6>
 <span class="font-14">
  ' . $MsgDis . '
 </span><br><br>
 <a href="#" onclick="HideMsgNote()" class="text-grey text-decoration-none">Dismiss</a>
 </p>
 <script>
  setTimeout(function() {
   $("#MsgArea").fadeOut("slow");
  }, 2500);
 </script>
</div>
<script>
 function HideMsgNote() {
  document.getElementById("MsgArea").style.display = "none";
 }
</script>
';
  unset($_SESSION['msg']);
  unset($_SESSION['err']);
  unset($_SESSION['alert']);
  unset($_SESSION['info']);
} else {
  echo "";
}

  //mention your tags for bodies
