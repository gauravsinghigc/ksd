<?php
//check user login status
if (!isset($_SESSION['UserId'])) {
 header("location: " . DOMAIN . "/auth/login/");

 //Users Data
} else {
}

//default configuration
define("MeasurementUnit", FETCH("SELECT * from company_attributes where company_id='" . company_id . "' and company_attribute_name='MEASUREMENT_UNIT'", "company_attribute_value"));
define("DeafultCommissionAmount", FETCH("SELECT * from company_attributes where company_id='" . company_id . "' and company_attribute_name='DEFAULT_COMMISSION_AMOUNT'", "company_attribute_value"));
define("DeafultCommissionPercentage", FETCH("SELECT * from company_attributes where company_id='" . company_id . "' and company_attribute_name='DEFAULT_COMMISSION_PERCENTAGE'", "company_attribute_value"));
define("Defaultdiscountperunitarea", FETCH("SELECT * from company_attributes where company_id='" . company_id . "' and company_attribute_name='DISCOUNT_AMOUNT_PER_UNIT_AREA'", "company_attribute_value"));
define("MIN_EMI_MONTH", FETCH("SELECT * from company_attributes where company_id='" . company_id . "' and company_attribute_name='MIN_EMI_MONTH'", "company_attribute_value"));
define("MAX_EMI_MONTHS", FETCH("SELECT * from company_attributes where company_id='" . company_id . "' and company_attribute_name='MAX_EMI_MONTHS'", "company_attribute_value"));
define("COMMISSION_OPTIONS", array("AREA", "AMOUNT", "PERCENTAGE"));
