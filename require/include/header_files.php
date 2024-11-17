    <link href="http://fonts.googleapis.com/css?family=Roboto+Slab:400,300,100,700" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto:500,400italic,100,700italic,300,700,500italic,400" rel="stylesheet">
    <link href="<?php echo DOMAIN; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo DOMAIN; ?>/assets/css/style.css" rel="stylesheet">
    <link href="<?php echo DOMAIN; ?>/assets/css/utility.css" rel="stylesheet">
    <link href="<?php echo DOMAIN; ?>/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo DOMAIN; ?>/assets/plugins/switchery/switchery.min.css" rel="stylesheet">
    <link href="<?php echo DOMAIN; ?>/assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
    <link href="<?php echo DOMAIN; ?>/assets/css/custom.css" rel="stylesheet">
    <link href="<?php echo DOMAIN; ?>/assets/plugins/jquery-ricksaw-chart/css/rickshaw.css" rel="stylesheet">
    <link href="<?php echo DOMAIN; ?>/assets/plugins/bootstrap-validator/bootstrapValidator.min.css" rel="stylesheet">
    <link href="<?php echo DOMAIN; ?>/assets/plugins/summernote/summernote.min.css" rel="stylesheet">
    <link href="<?php echo DOMAIN; ?>/assets/plugins/pace/pace.min.css" rel="stylesheet">
    <script src="<?php echo DOMAIN; ?>/assets/plugins/pace/pace.min.js"></script>
    <link rel="icon" href="<?php echo company_logo; ?>" type="image/x-icon">
    <link href="<?php echo DOMAIN; ?>/assets/plugins/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo DOMAIN; ?>/assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo DOMAIN; ?>/assets/js/textarea.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "lengthMenu": [
                    [20, 50, 100],
                    [20, 50, 100]
                ]
            });
        });
    </script>
    <script>
        tinymce.init({
            selector: 'textarea.editor',
            menubar: false
        });
    </script>