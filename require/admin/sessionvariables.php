<?php
//login per details
if (isset($_SESSION['UserId'])) {
 $UserId = $_SESSION['UserId'];
 define("LOGIN_UserId", FETCH("SELECT * FROM users where id='$UserId'", "id"));
 define("LOGIN_UserFullName", FETCH("SELECT * FROM users where id='$UserId'", "name"));
 define("LOGIN_UserPhoneNumber", FETCH("SELECT * FROM users where id='$UserId'", "phone"));
 define("LOGIN_UserEmailId", FETCH("SELECT * from users where id='$UserId'", "email"));
 define("LOGIN_UserCreatedAt", FETCH("SELECT * FROM users where id='$UserId'", "created_at"));
 define("LOGIN_UserUpdatedAt", FETCH("SELECT * FROM users where id='$UserId'", "updated_at"));
 define("LOGIN_UserStatus", FETCH("SELECT * FROM users where id='$UserId'", "user_status"));
 define("LOGIN_UserProfileImage1", FETCH("SELECT * FROM users WHERE id='$UserId'", "user_profile_img"));
 define("LOGIN_UserRoles", FETCH("SELECT * FROM users WHERE id='$UserId'", "user_role_id"));
 define("LOGIN_UserCompanyRelation", FETCH("SELECT * FROM users where id='$UserId'", "company_relation"));
 if (LOGIN_UserProfileImage1 == "default.png") {
  define("LOGIN_UserProfileImage", "default.png");
 } else {
  define("LOGIN_UserProfileImage", STORAGE_URL_U . "/" . LOGIN_UserId . "/img/" . LOGIN_UserProfileImage1);
 }

 $FetchAddress = "SELECT * FROM user_address where user_id='" . LOGIN_UserId . "'";
 define("LOGIN_UserStreetAddess", FETCH("$FetchAddress", "user_street_address"));
 define("LOGIN_UserAreaLocality", FETCH($FetchAddress, "user_area_locality"));
 define("LOGIN_UserCity", FETCH("$FetchAddress", "user_city"));
 define("LOGIN_UserState", FETCH("$FetchAddress", "user_state"));
 define("LOGIN_UserPincode", FETCH("$FetchAddress", "user_pincode"));
 define("LOGIN_UserCountry", FETCH("$FetchAddress", "user_country"));
 define("user_address_created_at", FETCH("$FetchAddress", "created_at"));
 define("user_address_updated_at", FETCH("$FetchAddress", "updated_at"));

 //UserType
 $Select_UsersTypes = "SELECT * from user_roles where role_id='" . LOGIN_UserRoles . "'";
 define("role_name", FETCH("$Select_UsersTypes", "role_name"));
 define("LOGIN_UserRoleName", role_name);

 //get company data
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

 //common variables
 $company_id = company_id;
 $name = LOGIN_UserFullName;
 $email = LOGIN_UserEmailId;
 $phone = LOGIN_UserPhoneNumber;
 $role_name = LOGIN_UserRoleName;
 //else variables
} else {
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
 define("company_branch_map_link", FETCH("$SelectBranchAddress", "company_branch_map_link"));
 define("company_address", "" . company_street_address . "<br>" . company_area_locality . "<br>" . company_state . " " . company_city . "<br>" . company_country . "-" . company_pincode);
 define("company_address2", "" . company_street_address . " " . company_area_locality . " " . company_state . " " . company_city . " " . company_country . "-" . company_pincode);
}
