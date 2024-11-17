<?php
//add controller helper files
require 'helper.php';

//add aditional requirements
require '../require/admin/sessionvariables.php';

//start request processing

//update company profile
if (isset($_POST['update_company_profile'])) {
	$company_id = SECURE("" . $_POST['update_company_profile'] . "", "d");
	$company_name = $_POST['company_name'];
	$company_email = $_POST['company_email'];
	$company_phone = $_POST['company_phone'];
	$company_desc = $_POST['company_desc'];
	$company_tagline = $_POST['company_tagline'];
	$updated_at = RequestDataTypeDate;
	$updatecompanyprofile = UPDATE("UPDATE companies SET company_name='$company_name', company_email='$company_email', company_phone='$company_phone', company_desc='$company_desc', company_tagline='$company_tagline', updated_at=CURRENT_TIMESTAMP where company_id='$company_id'");
	if ($updatecompanyprofile == true) {
		LOCATION("success", "$company_name is Updated successfully!", "../admin/company-profile");
	} else {
		LOCATION("warning", "Unable to update $company_name at the moment!", "../admin/company-profile");
	}

	//update company address
} else if (isset($_POST['update_company_address']) || isset($_POST['update_company_address2'])) {

	if (isset($_POST['update_company_address'])) {
		$company_branch_id = $_POST['update_company_address'];
		$company_branch_name = $_POST['company_branch_name'];
		$company_street_address = $_POST['company_street_address'];
		$company_area_locality = $_POST['company_area_locality'];
		$company_state = $_POST['company_state'];
		$company_city = $_POST['company_city'];
		$company_country = $_POST['company_country'];
		$company_pincode = $_POST['company_pincode'];
		$updated_at = RequestDataTypeDate;
		$company_branch_map_link = POST("company_branch_map_link");
	} elseif (isset($_POST['update_company_address2'])) {
		$company_branch_id = $_POST['update_company_address2'];
		$company_branch_name = $_POST['company_branch_name2'];
		$company_street_address = $_POST['company_street_address2'];
		$company_area_locality = $_POST['company_area_locality2'];
		$company_state = $_POST['company_state2'];
		$company_city = $_POST['company_city2'];
		$company_country = $_POST['company_country2'];
		$company_pincode = $_POST['company_pincode2'];
		$updated_at = RequestDataTypeDate;
		$company_branch_map_link = POST("company_branch_map_link2");
	}

	$updatecompanyaddress = UPDATE("UPDATE company_branches SET company_branch_map_link='$company_branch_map_link',  company_branch_name='$company_branch_name', company_street_address='$company_street_address', company_area_locality='$company_area_locality', company_state='$company_state', company_city='$company_city', company_country='$company_country', company_pincode='$company_pincode', updated_at='$update_at' where company_branch_id='$company_branch_id'");
	if ($updatecompanyaddress == true) {
		LOCATION("success", "$company_branch_name address is Updated successfully!", "../admin/company-profile");
	} else {
		LOCATION("warning", "Unable to update $company_branch_name at the moment!", "../admin/company-profile");
	}

	//create company attribute
} else if (isset($_POST['save_attribute'])) {
	$company_id = $_POST['save_attribute'];
	$company_attribute_name = $_POST['company_attribute_name'];
	$company_attribute_value = $_POST['company_attribute_value'];
	$company_attribute_status = "ACTIVE";
	$created_at = RequestDataTypeDate;

	$saveattributes = SAVE("company_attributes", ["company_id", "company_attribute_name", "company_attribute_value", "company_attribute_status", "created_at"]);
	if ($saveattributes == true) {
		LOCATION("success", "$company_attribute_name is created!", "$access_url");
	} else {
		LOCATION("danger", "Unable to create $company_attribute_name!", "$access_url");
	}

	//update company attributes
} else if (isset($_POST['update_company_attributes'])) {
	$company_attribute_id = $_POST['update_company_attributes'];
	$company_attribute_name = $_POST['company_attribute_name'];
	$company_attribute_value = $_POST['company_attribute_value'];
	$update_at = RequestDataTypeDate();

	$updateattributes = UPDATE("UPDATE company_attributes SET company_attribute_name='$company_attribute_name', company_attribute_value='$company_attribute_value', update_at='$update_at' where company_attribute_id='$company_attribute_id'");
	if ($updateattributes == true) {
		LOCATION("success", "$company_attribute_name is updated successfully!", "$access_url");
	} else {
		LOCATION("warning", "Unable to update $company_attribute_name", "$access_url");
	}

	//update company logo
} else if (isset($_POST['updatecompanyprofile'])) {
	$company_id = $_POST['updatecompanyprofile'];
	$GetUserImg = SELECT("SELECT * FROM companies where company_id='$company_id'");
	$FetchData = mysqli_fetch_array($GetUserImg);
	$company_logo = $FetchData['company_logo'];
	$update_at = RequestDataTypeDate();

	if ($user_profile_img == "demo-logo.png") {
	} else {
		unlink("../storage/company/$company_id/img/$company_logo");
	}

	$UserProfile = $_FILES['company_logo']['name'];
	$temp_name = $_FILES['company_logo']['tmp_name'];
	$Folder = "../storage/company/$company_id/img/";
	$temp = explode(".", $_FILES["company_logo"]["name"]);
	$newfilename = "company_" . $UserId . "_" . rand(1111111, 999999999) . date("_d_M_Y_h_m_s") . '.' . end($temp);

	$FileType = strtolower(pathinfo($newfilename, PATHINFO_EXTENSION));
	if (in_array($FileType, $FileNotAllowed)) {
		LOCATION("warning", "Unable to Upload System File", "../admin/company-profile");
	} else {
		move_uploaded_file($_FILES['company_logo']['tmp_name'], $Folder . $newfilename);

		$updatecompanylogo = UPDATE("UPDATE companies set company_logo='$newfilename', updated_at='$update_at' where company_id='$company_id'");
		if ($updatecompanylogo == true) {
			LOCATION("success", "Company logo changed successfully!", "../admin/company-profile");
		} else {
			LOCATION("warning", "Unable to update company logo!", "../admin/company-profile");
		}
	}

	//update company status
} else if (isset($_GET['updatecompany'])) {
	if ($_GET['updatecompany'] == "true") {
		if ($company_status == "ACTIVE") {
			$newstatus = "INACTIVE";
		} else {
			$newstatus = "ACTIVE";
		}
		$update = UPDATE("UPDATE companies SET company_status='$newstatus' where company_id='$company_id'");
		if ($update == true) {
			LOCATION("success", "$company_name Website is now $newstatus!", "../admin/company-profile");
		} else {
			LOCATION("danger", "Unable to $newstatus $company_name Website", "../admin/company-profile");
		}
	} else {
		LOCATION("warning", "Company Not Found!!", "../admin/company-profile");
	}

	//add new company address
} else if (isset($_POST['add_new_company_address'])) {
	$company_id = SECURE($_POST['add_new_company_address'], "d");
	$company_branch_name = $_POST['company_branch_name'];
	$company_street_address = htmlentities($_POST['company_street_address']);
	$company_area_locality = htmlentities($_POST['company_area_locality']);
	$company_state = htmlentities($_POST['company_state']);
	$company_city = htmlentities($_POST['company_city']);
	$company_country = htmlentities($_POST['company_country']);
	$created_at = RequestDataTypeDate();
	$company_branch_status = "ACTIVE";
	$company_pincode = htmlentities($_POST['company_pincode']);
	$company_branch_map_link = htmlentities(POST("company_branch_map_link"));
	$ifdefault = "no";

	$Save = SAVE("company_branches", ["company_id", "company_branch_name", "company_street_address", "company_area_locality", "company_state", "company_city", "company_country", "created_at", "company_branch_status", "company_pincode", "company_branch_map_link", "ifdefault"]);
	RESPONSE($Save, "New Address <b>$company_branch_name</b> is Saved Successfully!", "Unable to create new Address");

	//change primary
} elseif (isset($_GET['changeprimary'])) {
	$company_branch_id = $_GET['ref'];
	$access_url = $_GET['access_url'];

	$Update = UPDATE("UPDATE company_branches SET ifdefault='No' where company_id='" . company_id . "'");
	if ($Update == true) {
		$update = UPDATE("UPDATE company_branches SET ifdefault='yes' where company_branch_id='$company_branch_id'");
	} else {
		$update = false;
	}

	RESPONSE($update, "Primary Address Changed!", "Unable to Change Primary Address");

	//delete address
} else if (isset($_GET['disabledaddress'])) {
	$company_branch_id = $_GET['ref'];
	$access_url = $_GET['access_url'];

	$delete = DELETE("DELETE from company_branches where company_branch_id='$company_branch_id'");
	RESPONSE($delete, "Branch Address Deleted!", "Unable to Delete Branch Address");
}
