<?php
//add controller helper files
require 'helper.php';

//add aditional requirements
require '../require/admin/sessionvariables.php';

if (isset($_POST['SaveNewVendor'])) {
 $vendors = [
  "vendor_company_name" => $_POST['vendor_company_name'],
  "vendor_display_name" => $_POST['vendor_person_name'] . " " . $_POST['vendor_company_name'],
  "vendor_person_name" => $_POST['vendor_person_name'],
  "vendor_person_phone" => $_POST['vendor_person_phone'],
  "vendor_person_email_id" => $_POST['vendor_person_email_id'],
  "vendor_person_street_address" => $_POST['vendor_person_street_address'],
  "vendor_person_area_locality" => $_POST['vendor_person_area_locality'],
  "vendor_person_city" => $_POST['vendor_person_city'],
  "vendor_person_state" => $_POST['vendor_person_state'],
  "vendor_person_country" => "INDIA",
  "vendor_person_pincode" => $_POST['vendor_person_pincode'],
  "vendor_gst_no" => $_POST['vendor_gst_no'],
  "vendor_created_at" => date("Y-m-d"),
  "vendor_status" => $_POST['vendor_status'],
  "vendor_highlight_details" => $_POST['vendor_highlight_details']
 ];

 $Save = INSERT("vendors", $vendors);
 RESPONSE($Save, "Vendor details are saved successfully!", "unable to save vendor details at the moment!");

 //update vendor details
} elseif (isset($_POST['UpdateVendorDetails'])) {
 $vendor_id = SECURE($_POST['vendor_id'], "d");

 $vendors = [
  "vendor_company_name" => $_POST['vendor_company_name'],
  "vendor_display_name" => $_POST['vendor_person_name'] . " " . $_POST['vendor_company_name'],
  "vendor_person_name" => $_POST['vendor_person_name'],
  "vendor_person_phone" => $_POST['vendor_person_phone'],
  "vendor_person_email_id" => $_POST['vendor_person_email_id'],
  "vendor_person_street_address" => $_POST['vendor_person_street_address'],
  "vendor_person_area_locality" => $_POST['vendor_person_area_locality'],
  "vendor_person_city" => $_POST['vendor_person_city'],
  "vendor_person_state" => $_POST['vendor_person_state'],
  "vendor_person_country" => "INDIA",
  "vendor_person_pincode" => $_POST['vendor_person_pincode'],
  "vendor_gst_no" => $_POST['vendor_gst_no'],
  "vendor_updated_at" => date("Y-m-d"),
  "vendor_status" => $_POST['vendor_status'],
  "vendor_highlight_details" => $_POST['vendor_highlight_details']
 ];
 $Update = UPDATE_DATA("vendors", $vendors, "vendor_id='$vendor_id'");
 RESPONSE($Update, "Vendor details are updated successfully!", "Unable to update vendor details at the moment!");

 //add vendor material
} elseif (isset($_POST['AddVendorMaterialEntry'])) {
 $vendor_main_id = SECURE($_POST['vendor_id'], "d");

 $vendor_materials = [
  "vendor_main_id" => $vendor_main_id,
  "vendor_material_remarks" => SECURE($_POST['vendor_material_remarks'], "e"),
  "vendor_material_receive_date" => $_POST['vendor_material_receive_date'],
  "vendor_material_created_by" => LOGIN_UserId,
  "vendor_material_updated_by" => LOGIN_UserId,
  "vendor_material_created_at" => date("Y-m-d"),
  "vendor_material_updated_at" => date("Y-m-d"),
  "vendor_material_net_amount" => $_POST['vendor_material_net_amount'],
  "vendor_material_uploaded_bill" => UPLOAD_FILES("../storage/vendor/material/$vendor_main_id", null, "Vendor_Material", "Record", "vendor_material_uploaded_bill")
 ];

 $Save = INSERT("vendor_materials", $vendor_materials);

 if ($Save == true) {
  $vendor_material_id = FETCH("SELECT vendor_material_id FROM vendor_materials ORDER BY vendor_material_id desc limit 1", "vendor_material_id");

  //check payment details are enabled or not
  if (isset($_POST['PaymentDetails'])) {
   if ($_POST['PaymentDetails'] == "true") {
    $vendor_transactions = [
     "vendor_main_id" => $vendor_main_id,
     "vendor_material_id" => $vendor_material_id,
     "vendor_paid_amount" => $_POST['vendor_paid_amount'],
     "vendor_pay_mode" => $_POST['vendor_pay_mode'],
     "vendor_pay_ref_no" => $_POST['vendor_pay_ref_no'],
     "vendor_payment_details" => Secure($_POST['vendor_payment_details'], "e"),
     "vendor_payment_date" => $_POST['vendor_payment_date'],
     "vendor_payment_have_receipt" => UPLOAD_FILES("../storage/vendor/payments/$vendor_main_id", null, "Vendor_Material", "Payment_Receipt", "vendor_payment_have_receipt"),
     "vendor_payment_created_at" => date("Y-m-d"),
     "vendor_payment_updated_at" => date("Y-m-d"),
     "vendor_payment_created_by" => LOGIN_UserId,
     "vendor_payment_updated_by" => LOGIN_UserId
    ];

    $SavePayment = INSERT("vendor_transactions", $vendor_transactions);
   }
  }
 }
 RESPONSE($Save, "Vendor material entry is saved successfully!", "Unable to save vendor material entry at the moment!");

 //add payment record
} elseif (isset($_POST['AddPaymentRecord'])) {
 $vendor_main_id = SECURE($_POST['vendor_main_id'], "d");
 $vendor_transactions = [
  "vendor_main_id" => $vendor_main_id,
  "vendor_material_id" => "",
  "vendor_paid_amount" => $_POST['vendor_paid_amount'],
  "vendor_pay_mode" => $_POST['vendor_pay_mode'],
  "vendor_pay_ref_no" => $_POST['vendor_pay_ref_no'],
  "vendor_payment_details" => Secure($_POST['vendor_payment_details'], "e"),
  "vendor_payment_date" => $_POST['vendor_payment_date'],
  "vendor_payment_have_receipt" => UPLOAD_FILES("../storage/vendor/payments/$vendor_main_id", null, "Vendor_Material", "Payment_Receipt", "vendor_payment_have_receipt"),
  "vendor_payment_created_at" => date("Y-m-d"),
  "vendor_payment_updated_at" => date("Y-m-d"),
  "vendor_payment_created_by" => LOGIN_UserId,
  "vendor_payment_updated_by" => LOGIN_UserId
 ];

 $SavePayment = INSERT("vendor_transactions", $vendor_transactions);
 RESPONSE($SavePayment, "Payment record is saved successfully!", "Unable to save payment record at the moment!");

 //add vendor item
} elseif (isset($_POST['VendorMaterialRecord'])) {
 $vendor_main_id = SECURE($_POST['vendor_main_id'], "d");

 $vendor_materials = [
  "vendor_main_id" => $vendor_main_id,
  "vendor_material_remarks" => SECURE($_POST['vendor_material_remarks'], "e"),
  "vendor_material_receive_date" => $_POST['vendor_material_receive_date'],
  "vendor_material_created_by" => LOGIN_UserId,
  "vendor_material_updated_by" => LOGIN_UserId,
  "vendor_material_created_at" => date("Y-m-d"),
  "vendor_material_net_amount" => $_POST['vendor_material_net_amount'],
  "vendor_material_updated_at" => date("Y-m-d"),
  "vendor_material_uploaded_bill" => UPLOAD_FILES("../storage/vendor/material/$vendor_main_id", null, "Vendor_Material", "Record", "vendor_material_uploaded_bill")
 ];

 $Save = INSERT("vendor_materials", $vendor_materials);
 RESPONSE($Save, "Vendor item is saved successfully!", "Unable to save vendor item at the moment!");

 //update material details
} elseif (isset($_POST['UpdateMaterialRecord'])) {
 $vendor_material_id = SECURE($_POST['vendor_material_id'], "d");
 $vendor_main_id = SECURE($_POST['vendor_main_id'], "d");

 $vendor_materials = [
  "vendor_material_remarks" => SECURE($_POST['vendor_material_remarks'], "e"),
  "vendor_material_receive_date" => $_POST['vendor_material_receive_date'],
  "vendor_material_updated_by" => LOGIN_UserId,
  "vendor_material_updated_at" => date("Y-m-d"),
  "vendor_material_net_amount" => $_POST['vendor_material_net_amount']
 ];

 $Update = UPDATE_DATA("vendor_materials", $vendor_materials, "vendor_material_id='$vendor_material_id'");
 if ($Update == true) {
  if (isset($_FILES['vendor_material_uploaded_bill']) && $_FILES['vendor_material_uploaded_bill']['error'] === 0) {
   $vendor_materials = [
    "vendor_material_uploaded_bill" => UPLOAD_FILES("../storage/vendor/material/$vendor_main_id", null, "Vendor_Material", "Record", "vendor_material_uploaded_bill")
   ];

   $UpdatePaymentReceipt = UPDATE_DATA("vendor_materials", $vendor_materials, "vendor_material_id='$vendor_material_id'");
  }
 }
 RESPONSE($Update, "Vendor material details are updated successfully!", "Unable to update vendor material details at the moment!");

 //remove vendor material record
} elseif (isset($_GET['remove_vendor_materials'])) {
 $vendor_material_id = SECURE($_GET['control_id'], "d");

 $Delete = DELETE_FROM("vendor_materials", "vendor_material_id='$vendor_material_id'");
 RESPONSE($Delete, "Vendor material record is deleted successfully!", "Unable to delete vendor material record at the moment!");

 //update vendor payment record
} elseif (isset($_POST['UpdatePaymentRecord'])) {
 $vendor_transactions_id = SECURE($_POST['vendor_transactions_id'], "d");
 $vendor_main_id = SECURE($_POST['vendor_main_id'], "d");

 $vendor_transactions = [
  "vendor_paid_amount" => $_POST['vendor_paid_amount'],
  "vendor_pay_mode" => $_POST['vendor_pay_mode'],
  "vendor_pay_ref_no" => $_POST['vendor_pay_ref_no'],
  "vendor_payment_details" => SECURE($_POST['vendor_payment_details'], "e"),
  "vendor_payment_date" => $_POST['vendor_payment_date'],
  "vendor_payment_updated_at" => DATE("Y-m-d"),
  "vendor_payment_updated_by" => LOGIN_UserId,
 ];

 $UpdatePayment = UPDATE_DATA("vendor_transactions", $vendor_transactions, "vendor_transactions_id='$vendor_transactions_id'");
 if ($UpdatePayment == true) {
  if (isset($_FILES['vendor_payment_have_receipt']) && $_FILES['vendor_payment_have_receipt']['error'] === 0) {
   $vendor_transactions = [
    "vendor_payment_have_receipt" => UPLOAD_FILES("../storage/vendor/payments/$vendor_main_id", null, "Vendor_Material", "Payment_Receipt", "vendor_payment_have_receipt"),
   ];

   $UpdatePaymentReceipt = UPDATE_DATA("vendor_transactions", $vendor_transactions, "vendor_transactions_id='$vendor_transactions_id'");
  }
 }
 RESPONSE($UpdatePayment, "Vendor payment record is updated successfully!", "Unable to update vendor payment record at the moment!");

 //remove vendor payment record
} elseif (isset($_GET['remove_vendor_transactions'])) {
 $vendor_transactions_id = SECURE($_GET['control_id'], "d");

 $DeletePayment = DELETE_FROM("vendor_transactions", "vendor_transactions_id='$vendor_transactions_id'");
 RESPONSE($DeletePayment, "Vendor payment record is deleted successfully!", "Unable to delete vendor payment record at the moment!");

 //add item in materials
} elseif (isset($_POST['AddMaterialItems'])) {
 $vendor_material_main_id = SECURE($_POST['vendor_material_main_id'], "d");

 $vendor_material_items = [
  "vendor_material_main_id" => $vendor_material_main_id,
  "vendor_material_item_name" => $_POST['vendor_material_item_name'],
  "vendor_material_item_serial_no" => $_POST['vendor_material_item_serial_no'],
  "vendor_material_item_sos_number" => $_POST['vendor_material_item_sos_number'],
  "vendor_material_item_unit_rate" => $_POST['vendor_material_item_unit_rate'],
  "vendor_material_item_qty" => $_POST['vendor_material_item_qty'],
  "vendor_material_item_qty_type" => $_POST['vendor_material_item_qty_type'],
  "vendor_material_item_net_price" => $_POST['vendor_material_item_unit_rate'] * $_POST['vendor_material_item_qty'],
  "vendor_material_added_at" => DATE("Y-m-d")
 ];
 $Save = INSERT("vendor_material_items", $vendor_material_items);
 RESPONSE($Save, "Item is added successfully!", "Unable to add item at the moment!");

 //updatematerial items
} elseif (isset($_POST['UpdateMaterialItems'])) {
 $vendor_material_item_id  = SECURE($_POST['vendor_material_item_id'], "d");

 $vendor_material_items = [
  "vendor_material_item_name" => $_POST['vendor_material_item_name'],
  "vendor_material_item_serial_no" => $_POST['vendor_material_item_serial_no'],
  "vendor_material_item_sos_number" => $_POST['vendor_material_item_sos_number'],
  "vendor_material_item_unit_rate" => $_POST['vendor_material_item_unit_rate'],
  "vendor_material_item_qty" => $_POST['vendor_material_item_qty'],
  "vendor_material_item_qty_type" => $_POST['vendor_material_item_qty_type'],
  "vendor_material_item_net_price" => $_POST['vendor_material_item_unit_rate'] * $_POST['vendor_material_item_qty'],
  "vendor_material_added_at" => DATE("Y-m-d")
 ];
 $Update = UPDATE_DATA("vendor_material_items", $vendor_material_items, "vendor_material_item_id='$vendor_material_item_id'");
 RESPONSE($Update, "Item details are updated successfully!", "Unable to update item details at the moment!");

 //remove vendor material item record
} elseif (isset($_GET['remove_material_item'])) {
 $vendor_material_item_id = SECURE($_GET['control_id'], "d");

 $Delete = DELETE_FROM("vendor_material_items", "vendor_material_item_id='$vendor_material_item_id'");
 RESPONSE($Delete, "Vendor material item record is deleted successfully!", "Unable to delete vendor material item record at the moment!");
}
