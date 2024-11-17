<?php
//custom invoice id
define("INVOICE_ID", "INV-" . date("Y") . "/" . date("Y", strtotime("+1 year")) . "/" . date("m") . "/" . rand(11111, 999999));

//define gst types
define("GST_TYPE", array("null", "IGST", "SGST", "CGST"));

//define gst types
define("GST_PERCENTAGE", array("0", "5", "12", "18", "28"));
