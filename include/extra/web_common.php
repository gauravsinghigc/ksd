<?php
//company data
$Sql = "SELECT * FROM companies where user_id='" . APP_ID . "'";
define("company_id", FETCH("$Sql", "company_id"));
define("company_name", FETCH("$Sql", "company_name"));
define("company_email", FETCH("$Sql", "company_email"));
define("company_phone", FETCH("$Sql", "company_phone"));
define("company_desc", FETCH("$Sql", "company_desc"));
define("company_tagline", FETCH("$Sql", "company_tagline"));
define("company_status", FETCH("$Sql", "company_status"));
define("created_at", FETCH("$Sql", "created_at"));
define("updated_at", FETCH("$Sql", "updated_at"));

if (FETCH("$Sql", "company_logo") == "demo-logo.png") {
 define("company_logo", STORAGE_URL . "/sys-img/demo-logo.png");
} else {
 define("company_logo", STORAGE_URL . "/company/" . company_id . "/img/" . FETCH("$Sql", "company_logo"));
}

//default branch address
$SelectBranchAddress = "SELECT * FROM company_branches where company_id='" . company_id . "' and ifdefault='yes'";
define("company_branch_id", FETCH("$SelectBranchAddress", "company_branch_id"));
define("company_branch_name", FETCH("$SelectBranchAddress", "company_branch_name"));
define("company_street_address", FETCH("$SelectBranchAddress", "company_street_address"));
define("company_area_locality", FETCH("$SelectBranchAddress", "company_area_locality"));
define("company_state", FETCH("$SelectBranchAddress", "company_state"));
define("company_city", FETCH("$SelectBranchAddress", "company_city"));
define("company_country", FETCH("$SelectBranchAddress", "company_country"));
define("company_pincode", FETCH("$SelectBranchAddress", "company_pincode"));
define("company_created_at", FETCH("$SelectBranchAddress", "created_at"));
define("company_updated_at", FETCH("$SelectBranchAddress", "updated_at"));
define("company_branch_status", FETCH("$SelectBranchAddress", "company_branch_status"));
define("company_default", FETCH("$SelectBranchAddress", "ifdefault"));
define("company_branch_map_link", SECURE(FETCH("$SelectBranchAddress", "company_branch_map_link"), "d"));
define("company_address", "" . company_street_address . "<br>" . company_area_locality . "<br>" . company_state . " " . company_city . "<br>" . company_country . "-" . company_pincode);
define("company_address2", "" . company_street_address . " " . company_area_locality . " " . company_state . " " . company_city . " " . company_country . "-" . company_pincode);


//website configs
define("SOCIAL_MEDIA_FIXED", false);
