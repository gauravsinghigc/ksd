<?php include 'body_files.php'; ?>

<script src="<?php echo DOMAIN; ?>/assets/js/jquery-2.1.1.min.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/plugins/fast-click/fastclick.min.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/plugins/switchery/switchery.min.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/plugins/nanoscrollerjs/jquery.nanoscroller.min.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/plugins/metismenu/metismenu.min.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/js/scripts.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/plugins/parsley/parsley.min.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/plugins/jquery-steps/jquery-steps.min.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/plugins/masked-input/bootstrap-inputmask.min.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/plugins/bootstrap-validator/bootstrapValidator.min.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/plugins/moment-range/moment-range.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/plugins/jquery-ricksaw-chart/js/raphael-min.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/plugins/jquery-ricksaw-chart/js/d3.v2.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/plugins/summernote/summernote.min.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/plugins/screenfull/screenfull.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/js/jquery-ui.min.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/plugins/datatables/media/js/jquery.dataTables.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo DOMAIN; ?>/assets/js/demo/tables-datatables.js"></script>

<script>
    function actionBtn(type, text) {
        document.getElementById("" + type + "").innerHTML = "<i class='fa fa-spinner fa-spin'></i> " + text;
        document.getElementById("" + type + "").classList.remove("btn-primary");
        document.getElementById("" + type + "").classList.remove("btn-success");
        document.getElementById("" + type + "").classList.remove("btn-danger");
        document.getElementById("" + type + "").classList.remove("btn-warning");
        document.getElementById("" + type + "").classList.remove("btn-dark");
        document.getElementById("" + type + "").classList.remove("square");
        document.getElementById("" + type + "").classList.add("app-bg");
    }
</script>

<script>
    function Databar(data, btn, txt, action, cancel) {
        databar = document.getElementById("" + data + "");
        if (databar.style.display === "block") {
            databar.style.display = "none";
            document.getElementById("" + btn + "").classList.remove("btn-danger");
            document.getElementById("" + btn + "").classList.add("btn-primary");
            document.getElementById("" + txt + "").innerHTML = "<i class='fa fa-plus'></i> " + action;
        } else {
            databar.style.display = "block";
            document.getElementById("" + btn + "").classList.remove("btn-primary");
            document.getElementById("" + btn + "").classList.add("btn-danger");
            document.getElementById("" + txt + "").innerHTML = "<i class='fa fa-times'></i> " + cancel;
        }
    }
</script>

<script>
    $('.count').each(function() {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 1500,
            easing: 'swing',
            step: function(now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
</script>
<script type="text/javascript">
    $('.numbers').each(function() {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 3000,
            easing: 'linear',
            step: function(now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
</script>

<script>
    $(function() {
        $('.selectpicker').selectpicker();
    });
</script>