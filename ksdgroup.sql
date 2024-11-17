-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2024 at 11:01 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ksdgroup`
--

-- --------------------------------------------------------

--
-- Table structure for table `activitytrack`
--

CREATE TABLE `activitytrack` (
  `ActivityId` int(10) UNSIGNED NOT NULL,
  `ActivityName` varchar(100) NOT NULL,
  `ActivityDetails` varchar(1000) NOT NULL,
  `CreatedAt` varchar(100) NOT NULL,
  `UserInvolved` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `AssetsId` int(100) NOT NULL,
  `AssetName` varchar(1000) NOT NULL,
  `AssetCategory` varchar(100) NOT NULL,
  `AssetModalNo` varchar(100) NOT NULL,
  `AssetSerialNo` varchar(100) NOT NULL,
  `AssetsCost` varchar(100) NOT NULL,
  `AssetPurchaseDate` varchar(40) NOT NULL,
  `AssetDateOfIssue` varchar(40) NOT NULL,
  `AssetIusseto` varchar(10) NOT NULL,
  `AssetsDescription` varchar(1000) NOT NULL,
  `AssetsCreatedAt` varchar(40) NOT NULL,
  `AssetsUpdatedAt` varchar(40) NOT NULL,
  `AssetsCreatedBy` varchar(40) NOT NULL,
  `AssetsUpdatedBy` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `bookingid` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `partner_id` varchar(10) NOT NULL,
  `company_id` varchar(10) NOT NULL,
  `project_list_id` varchar(10) NOT NULL,
  `project_name` varchar(100) NOT NULL,
  `project_area` varchar(100) NOT NULL,
  `unit_name` varchar(100) NOT NULL,
  `unit_area` varchar(100) NOT NULL,
  `unit_rate` varchar(10) NOT NULL,
  `unit_cost` varchar(10) NOT NULL,
  `net_payable_amount` int(100) NOT NULL,
  `chargename` varchar(100) NOT NULL,
  `charges` varchar(10) NOT NULL,
  `discountname` varchar(100) NOT NULL,
  `discount` varchar(10) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL,
  `booking_date` varchar(100) NOT NULL,
  `clearing_date` varchar(100) NOT NULL,
  `possession` varchar(100) NOT NULL,
  `project_unit_id` int(10) NOT NULL,
  `possession_update_date` varchar(100) NOT NULL,
  `possession_notes` varchar(10000) NOT NULL,
  `booking_last_updated` varchar(100) NOT NULL,
  `emi_months` varchar(100) NOT NULL,
  `crn_no` varchar(100) NOT NULL,
  `ref_no` varchar(100) NOT NULL,
  `parking_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`bookingid`, `customer_id`, `partner_id`, `company_id`, `project_list_id`, `project_name`, `project_area`, `unit_name`, `unit_area`, `unit_rate`, `unit_cost`, `net_payable_amount`, `chargename`, `charges`, `discountname`, `discount`, `created_at`, `status`, `booking_date`, `clearing_date`, `possession`, `project_unit_id`, `possession_update_date`, `possession_notes`, `booking_last_updated`, `emi_months`, `crn_no`, `ref_no`, `parking_status`) VALUES
(1, 1, '1', '1', '1', 'TITANIA RESIDENCY', '20698.73 sq Yards', '101', '1350 sq Yards', '5700', '7695000', 7695000, '', '0', '', '0', '2024-10-15 07:10:50 PM', 'ACTIVE', '2024-10-15', '2026-10-15', 'no', 5, '', '', '', '24', '', '', ''),
(2, 1, '1', '1', '1', 'TITANIA RESIDENCY', '20698.73 sq Yards', '202', '1450 sq Yards', '5700', '8265000', 8265000, '', '0', '', '0', '2024-10-21 12:10:24 PM', 'ACTIVE', '2024-10-21', '2026-10-21', 'no', 12, '', '', '', '24', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `booking_alloties`
--

CREATE TABLE `booking_alloties` (
  `BookingAllotyId` int(100) NOT NULL,
  `BookingAllotyMainBookingId` varchar(100) NOT NULL,
  `BookingAllotyFullName` varchar(100) NOT NULL,
  `BookingAllotyPhoneNumber` varchar(100) NOT NULL,
  `BookingAllotyEmail` varchar(100) NOT NULL,
  `BookingAllotyFatherName` varchar(100) NOT NULL,
  `BookingAllotyMotherName` varchar(100) NOT NULL,
  `BookingAllotyStreetAddress` varchar(1000) NOT NULL,
  `BookingAllotyArea` varchar(100) NOT NULL,
  `BookingAllotyCity` varchar(100) NOT NULL,
  `BookingAllotyState` varchar(100) NOT NULL,
  `BookingAllotyPincode` varchar(100) NOT NULL,
  `BookingAllotyCountry` varchar(100) NOT NULL,
  `BookingAllotyRelation` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_alloty_documents`
--

CREATE TABLE `booking_alloty_documents` (
  `BookingAlloteeDocId` int(100) NOT NULL,
  `BookingAlloteeMainId` varchar(100) NOT NULL,
  `BookingAlloteeDocName` varchar(100) NOT NULL,
  `BookingAlloteeDocFile` varchar(250) NOT NULL,
  `BookingAlloteeDocNumber` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_cancelled`
--

CREATE TABLE `booking_cancelled` (
  `BookingCancelledId` int(10) NOT NULL,
  `BookingCancelledBookingId` varchar(100) NOT NULL,
  `BookingCancelledDate` varchar(100) NOT NULL,
  `BookingCancelledReason` varchar(10000) NOT NULL,
  `BookingCancelledCreatedAt` varchar(100) NOT NULL,
  `BookingCancelledBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_emis`
--

CREATE TABLE `booking_emis` (
  `emi_id` int(10) NOT NULL,
  `booking_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `emi_start_date` varchar(100) NOT NULL,
  `emi_last_date` varchar(100) NOT NULL,
  `emi_per_month` varchar(100) NOT NULL,
  `emi_day_of_month` varchar(100) NOT NULL,
  `emi_status` varchar(10) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `emi_months` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_emis`
--

INSERT INTO `booking_emis` (`emi_id`, `booking_id`, `customer_id`, `emi_start_date`, `emi_last_date`, `emi_per_month`, `emi_day_of_month`, `emi_status`, `created_at`, `emi_months`) VALUES
(1, 1, 1, '2024-11-15', '', '7695000', '10', 'NOT PAID', '2024-10-14 18:30:00.000000', '24'),
(2, 2, 1, '2024-11-21', '', '8265000', '10', 'NOT PAID', '2024-10-20 18:30:00.000000', '24');

-- --------------------------------------------------------

--
-- Table structure for table `booking_loans`
--

CREATE TABLE `booking_loans` (
  `booking_loan_id` int(10) NOT NULL,
  `booking_main_id` int(10) NOT NULL,
  `booking_bank_name` varchar(100) NOT NULL,
  `booking_santion_amount` varchar(200) NOT NULL,
  `booking_receive_amount` varchar(10) NOT NULL,
  `booking_loan_notes` varchar(10000) NOT NULL,
  `booking_loan_created_at` varchar(50) NOT NULL,
  `booking_loan_updated_at` varchar(50) NOT NULL,
  `booking_bank_ifsc_code` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_loans`
--

INSERT INTO `booking_loans` (`booking_loan_id`, `booking_main_id`, `booking_bank_name`, `booking_santion_amount`, `booking_receive_amount`, `booking_loan_notes`, `booking_loan_created_at`, `booking_loan_updated_at`, `booking_bank_ifsc_code`) VALUES
(1, 0, '', '', '', '', '2024-10-15', '2024-10-15', ''),
(2, 0, '', '', '', '', '2024-10-21', '2024-10-21', '');

-- --------------------------------------------------------

--
-- Table structure for table `booking_pay_req`
--

CREATE TABLE `booking_pay_req` (
  `PaymentRequestId` int(100) NOT NULL,
  `PayReqBookingId` varchar(100) NOT NULL,
  `PayReqDate` varchar(100) NOT NULL,
  `PayRequestingAmount` varchar(100) NOT NULL,
  `PayRequestDueDate` varchar(50) NOT NULL,
  `PayRequestDescriptions` varchar(1000) NOT NULL,
  `PayRequestSendBy` varchar(100) NOT NULL,
  `PayReqSendDate` varchar(100) NOT NULL,
  `PayReqSendDescsriptions` varchar(1000) NOT NULL,
  `PayReqType` varchar(100) NOT NULL DEFAULT 'DEMAND'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_refund`
--

CREATE TABLE `booking_refund` (
  `BookingRefundId` int(10) NOT NULL,
  `BookingRefundMainBookingId` int(10) NOT NULL,
  `BookingRefundReason` varchar(10000) NOT NULL,
  `BookingRefundDate` varchar(100) NOT NULL,
  `BookingRefundTo` varchar(100) NOT NULL,
  `BookingRefundMode` varchar(100) NOT NULL,
  `BookingRefundDetails` varchar(100) NOT NULL,
  `BookingRefundStatus` varchar(10) NOT NULL,
  `BookingRefundCreatedAt` varchar(100) NOT NULL,
  `BookingRefundUpdatedAt` varchar(100) NOT NULL,
  `BookingRefundCreatedBy` varchar(100) NOT NULL,
  `BookingRefundAmount` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_resales`
--

CREATE TABLE `booking_resales` (
  `booking_resale_id` int(10) NOT NULL,
  `booking_main_id` int(10) NOT NULL,
  `booking_sale_from` int(10) NOT NULL,
  `booking_sold_to` int(10) NOT NULL,
  `booking_resale_date` varchar(25) NOT NULL,
  `booking_payable_amount` int(10) NOT NULL,
  `booking_resale_created_at` varchar(25) NOT NULL,
  `booking_resale_created_by` int(10) NOT NULL,
  `booking_plot_id` int(10) NOT NULL,
  `booking_resale_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_payments`
--

CREATE TABLE `cash_payments` (
  `cash_payments` int(10) NOT NULL,
  `payment_id` varchar(100) NOT NULL,
  `cashreceivername` varchar(100) NOT NULL,
  `cashamount` varchar(100) NOT NULL,
  `created_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cash_payments`
--

INSERT INTO `cash_payments` (`cash_payments`, `payment_id`, `cashreceivername`, `cashamount`, `created_at`) VALUES
(1, '1', 'Navix Admin @ 1', '100000', '2024-10-15'),
(2, '2', 'Navix Admin @ 1', '10000', '2024-10-21'),
(3, '3', 'Navix Admin @ 1', '244375', '2024-10-22'),
(4, '4', 'Navix Admin @ 1', '255000', '2024-10-22');

-- --------------------------------------------------------

--
-- Table structure for table `check_payments`
--

CREATE TABLE `check_payments` (
  `check_payments` int(10) NOT NULL,
  `payment_id` varchar(10) NOT NULL,
  `checkissuedto` varchar(100) NOT NULL,
  `checknumber` varchar(100) NOT NULL,
  `bankName` varchar(100) NOT NULL,
  `ifsc` varchar(100) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `checkstatus` varchar(100) NOT NULL,
  `checkamount` varchar(10) NOT NULL,
  `clearedat` varchar(100) NOT NULL,
  `bounceat` varchar(100) NOT NULL,
  `inbankat` varchar(100) NOT NULL,
  `issuedat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commission`
--

CREATE TABLE `commission` (
  `commission_id` int(10) NOT NULL,
  `partner_id` int(10) NOT NULL,
  `booking_id` int(10) NOT NULL,
  `commission_type` varchar(100) NOT NULL,
  `commission_amount` varchar(100) NOT NULL,
  `commission_percentage` varchar(100) NOT NULL,
  `commission_rate_area` varchar(10) NOT NULL,
  `commission_on_area` int(10) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `commission_remark` varchar(100) NOT NULL,
  `total_area` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `commission`
--

INSERT INTO `commission` (`commission_id`, `partner_id`, `booking_id`, `commission_type`, `commission_amount`, `commission_percentage`, `commission_rate_area`, `commission_on_area`, `created_at`, `commission_remark`, `total_area`) VALUES
(1, 1, 1, 'area', '405000', '', '300', 300, '2024-10-15 07:10:50 PM', '', '1350 sq Yards'),
(2, 1, 2, 'area', '449500', '', '310', 310, '2024-10-21 12:10:24 PM', 'nous', '1450 sq Yards');

-- --------------------------------------------------------

--
-- Table structure for table `commission_payouts`
--

CREATE TABLE `commission_payouts` (
  `commission_payout_id` int(10) NOT NULL,
  `partner_id` varchar(10) NOT NULL,
  `commission_id` varchar(100) NOT NULL,
  `commission_payout_amount` varchar(100) NOT NULL,
  `commission_payout_type` varchar(100) NOT NULL,
  `commission_payout_date` varchar(100) NOT NULL,
  `commission_payout_payment_mode` varchar(100) NOT NULL,
  `commission_status` varchar(100) NOT NULL,
  `commission_payout_notes` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `commission_payouts`
--

INSERT INTO `commission_payouts` (`commission_payout_id`, `partner_id`, `commission_id`, `commission_payout_amount`, `commission_payout_type`, `commission_payout_date`, `commission_payout_payment_mode`, `commission_status`, `commission_payout_notes`) VALUES
(1, '1', '2', '10000', 'ELIGIBLE COMISSION', '2024-10-29', 'Select Pay Mode', 'Paid', 'VVR3V2QybVBZTkRZaXJYbklGazRwZz09');

-- --------------------------------------------------------

--
-- Table structure for table `commission_temps`
--

CREATE TABLE `commission_temps` (
  `TempCommissionId` int(100) NOT NULL,
  `TempCommissionSessionId` varchar(1000) NOT NULL,
  `partner_id` varchar(100) NOT NULL,
  `commission_remark` varchar(1000) NOT NULL,
  `commission_type` varchar(100) NOT NULL,
  `commission_amount` varchar(100) NOT NULL,
  `commission_percentage` varchar(100) NOT NULL,
  `commission_rate_area` varchar(100) NOT NULL,
  `commission_on_area` varchar(100) NOT NULL,
  `total_area` varchar(100) NOT NULL,
  `created_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `company_logo` varchar(100) NOT NULL DEFAULT 'demo-logo.png',
  `company_email` varchar(100) NOT NULL,
  `company_phone` varchar(1000) NOT NULL,
  `company_desc` varchar(2000) NOT NULL,
  `company_tagline` varchar(200) NOT NULL DEFAULT 'Not Available',
  `company_status` varchar(10) NOT NULL DEFAULT 'ACTIVE',
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL,
  `created_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`company_id`, `user_id`, `company_name`, `company_logo`, `company_email`, `company_phone`, `company_desc`, `company_tagline`, `company_status`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 1, 'Titania Homes', 'company_1_758707300_13_Oct_2024_09_10_29.png', 'manju@titaniainfra.in', '7042363301', 'Titania Infratech Pvt. Ltd is to create a world where everyone can live in a home they love.', 'APARTMENT BUILDING', 'ACTIVE', '2021-05-28 13:56:50.000000', '2024-10-14 11:40:06', '2');

-- --------------------------------------------------------

--
-- Table structure for table `company_attributes`
--

CREATE TABLE `company_attributes` (
  `company_attribute_id` int(11) NOT NULL,
  `company_id` int(10) NOT NULL,
  `company_attribute_name` varchar(100) NOT NULL,
  `company_attribute_value` varchar(100) NOT NULL,
  `company_attribute_status` varchar(10) NOT NULL DEFAULT 'ACTIVE',
  `created_at` varchar(100) NOT NULL,
  `update_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_attributes`
--

INSERT INTO `company_attributes` (`company_attribute_id`, `company_id`, `company_attribute_name`, `company_attribute_value`, `company_attribute_status`, `created_at`, `update_at`) VALUES
(8, 1, 'GST', '83476R38468745', 'ACTIVE', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000'),
(9, 1, 'PAN_NO', 'AAECK4711F', 'ACTIVE', '0000-00-00 00:00:00.000000', '2022-10-03 08:10:34 PM'),
(10, 1, 'MEASUREMENT_UNIT', 'sq Yards', 'ACTIVE', '0000-00-00 00:00:00.000000', '22 Sep, 2021'),
(11, 1, 'MAX_EMI_MONTHS', '60', 'ACTIVE', '0000-00-00 00:00:00.000000', '21 May, 2022'),
(12, 1, 'DEFAULT_COMMISSION_AMOUNT', '15000', 'ACTIVE', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000'),
(13, 1, 'DEFAULT_COMMISSION_PERCENTAGE', '7', 'ACTIVE', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000'),
(14, 1, 'DISCOUNT_AMOUNT_PER_UNIT_AREA', '100', 'ACTIVE', '0000-00-00 00:00:00.000000', '2021-07-26 13:02:51.610660'),
(15, 1, 'MIN_EMI_MONTH', '1', 'ACTIVE', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `company_branches`
--

CREATE TABLE `company_branches` (
  `company_branch_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_branch_name` varchar(100) NOT NULL,
  `company_street_address` varchar(500) NOT NULL,
  `company_area_locality` varchar(200) NOT NULL,
  `company_state` varchar(100) NOT NULL,
  `company_city` varchar(100) NOT NULL,
  `company_country` varchar(50) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL,
  `company_branch_status` varchar(10) NOT NULL,
  `company_pincode` varchar(10) NOT NULL,
  `company_branch_map_link` varchar(10000) NOT NULL,
  `ifdefault` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_branches`
--

INSERT INTO `company_branches` (`company_branch_id`, `company_id`, `company_branch_name`, `company_street_address`, `company_area_locality`, `company_state`, `company_city`, `company_country`, `created_at`, `updated_at`, `company_branch_status`, `company_pincode`, `company_branch_map_link`, `ifdefault`) VALUES
(1, 1, 'Head Office', 'Pillar No. 52, Plot, 10, Dadri Main Rd', 'Sector 49', 'Uttar Pradesh', 'Noida', 'India', '2021-06-02 11:09:37.218297', '', 'ACTIVE', '201307', 'M3N6cEE1V0syMjBKWE9JamJ0d2dERVk0aGNLSGw4cW5SUjYyKzY1NWNvQjNTZXNISkNhY2hyY1dXb3pSLzhNTXRvejJKZ0FCRFhYQnJZZHJtN3l3NUVGc0ZqaVVQRDAxMDgxMTRVeHVMMlpBRjdOaEs4WGc5K0piMjkxQ0EwZnBsK2c0dVVpRVEzcWJjb0NYeVlxVkFBWThUWU1lN2MzMEdmcElFb25UMld6dFZQSVJYRHFYYmpWbHRIN0YySkFFYnNwQnRFVkZlNDFnQUVTQzRIV3I0SjhCdGNsZytKNUhuKzdYS0ptWnVlRVNqL3R1RlZVSlhraGtBVGQyWGtqdVRxdW5pQlRGdTlwYlFpcXprZHRDK3NqeXhaMmo2WG9kNHVmeGFCMlZXU1dGKzQ5b1M5dWwwYXUwaWozeFp3ajU=', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `configurations`
--

CREATE TABLE `configurations` (
  `ConfigurationId` int(10) UNSIGNED NOT NULL,
  `Data` varchar(100) NOT NULL,
  `Value` varchar(500) NOT NULL,
  `CreatedAt` varchar(100) NOT NULL,
  `UpdatedAt` varchar(100) NOT NULL,
  `Status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `configurations`
--

INSERT INTO `configurations` (`ConfigurationId`, `Data`, `Value`, `CreatedAt`, `UpdatedAt`, `Status`) VALUES
(1, 'APP_NAME', 'PLotX', 'Sun 02 May, 2021 10:05:49 am', '', 1),
(2, 'APP_VERSION', '1.1', 'Sun 02 May, 2021 10:05:49 am', '', 1),
(3, 'DOMAIN', 'https://shrikrishnarealcity.com/', 'Sun 02 May, 2021 10:05:49 am', '', 1),
(4, 'DEV_NAME', 'NaviX', 'Sun 02 May, 2021 10:05:49 am', '', 1),
(5, 'APP_PHONE', '0000000000', 'Sun 02 May, 2021 10:05:49 am', '', 1),
(6, 'APP_MAIL_ID', 'navix365@gmail.com', 'Sun 02 May, 2021 10:05:49 am', '', 1),
(7, 'SENDER_MAIL', 'notification@plotx.navix.in', 'Sun 02 May, 2021 10:05:49 am', '', 1),
(8, 'RECEIVER_MAIL', 'navix365@gmail.com', 'Sun 02 May, 2021 10:05:49 am', '', 1),
(9, 'APP_ADDRESS', 'Sector 64, Noida, Uttar Pradesh ', 'Sun 02 May, 2021 10:05:49 am', '', 1),
(10, 'MAP_LINK', '', 'Sun 02 May, 2021 10:05:49 am', '', 1),
(11, 'DOWNLOAD_APP_LINK', 'https://shrikrishnarealcity.com/', 'Sun 02 May, 2021 10:05:49 am', '', 1),
(12, 'APP_LOGO', 'AVAILABLE FROM COMPANY PROFILE', '', '', 1),
(13, 'META_DESCRIPTION', 'Meta Descriptions', '', '', 1),
(14, 'META_KEYWORDS', 'plotx, real estate management software', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `developmentchargepayments`
--

CREATE TABLE `developmentchargepayments` (
  `devchargepaymentid` int(100) NOT NULL,
  `developmentchargeid` int(100) NOT NULL,
  `devchargepaymentmode` varchar(100) NOT NULL,
  `devchargepaymentamount` varchar(100) NOT NULL,
  `devchargepaymentnotes` varchar(1000) NOT NULL,
  `devpaymentreceivedby` varchar(1000) NOT NULL,
  `devpaymentbankname` varchar(1000) NOT NULL,
  `devpaymentreleaseddate` varchar(1000) NOT NULL,
  `devpaymentstatus` varchar(100) NOT NULL,
  `devpaymentdetails` varchar(1000) NOT NULL,
  `devpaymentcreatedat` varchar(100) NOT NULL,
  `devpaymentupdatedat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `developmentcharges`
--

CREATE TABLE `developmentcharges` (
  `devchargesid` int(100) NOT NULL,
  `bookingid` int(100) NOT NULL,
  `developmentchargetitle` varchar(1000) NOT NULL,
  `developmentchargetype` varchar(1000) NOT NULL,
  `developmentcharge` varchar(1000) NOT NULL,
  `developmentchargepercentage` varchar(100) NOT NULL,
  `developementchargeamount` varchar(1000) NOT NULL,
  `developmentchargedescription` varchar(1000) NOT NULL,
  `developmentchargecreatedat` varchar(1000) NOT NULL,
  `developmentchargesupdatedat` varchar(100) NOT NULL,
  `developmentchargestatus` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emi_lists`
--

CREATE TABLE `emi_lists` (
  `emi_list_id` int(10) NOT NULL,
  `emi_id` int(10) NOT NULL,
  `emi_dates` varchar(100) NOT NULL,
  `emi_amount` varchar(10) NOT NULL,
  `emi_paid` varchar(100) NOT NULL,
  `emi_balance` varchar(100) NOT NULL,
  `emi_list_status` varchar(100) NOT NULL,
  `prefer_day` varchar(100) NOT NULL,
  `emi_number` int(10) NOT NULL,
  `paid_date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emi_lists`
--

INSERT INTO `emi_lists` (`emi_list_id`, `emi_id`, `emi_dates`, `emi_amount`, `emi_paid`, `emi_balance`, `emi_list_status`, `prefer_day`, `emi_number`, `paid_date`) VALUES
(1, 1, '2024-11-15', '7695000', '0', '7695000', 'NOT PAID', '10', 1, ''),
(2, 1, '2024-12-15', '7695000', '0', '7695000', 'NOT PAID', '10', 2, ''),
(3, 1, '2025-01-15', '7695000', '0', '7695000', 'NOT PAID', '10', 3, ''),
(4, 1, '2025-02-15', '7695000', '0', '7695000', 'NOT PAID', '10', 4, ''),
(5, 1, '2025-03-15', '7695000', '0', '7695000', 'NOT PAID', '10', 5, ''),
(6, 1, '2025-04-15', '7695000', '0', '7695000', 'NOT PAID', '10', 6, ''),
(7, 1, '2025-05-15', '7695000', '0', '7695000', 'NOT PAID', '10', 7, ''),
(8, 1, '2025-06-15', '7695000', '0', '7695000', 'NOT PAID', '10', 8, ''),
(9, 1, '2025-07-15', '7695000', '0', '7695000', 'NOT PAID', '10', 9, ''),
(10, 1, '2025-08-15', '7695000', '0', '7695000', 'NOT PAID', '10', 10, ''),
(11, 1, '2025-09-15', '7695000', '0', '7695000', 'NOT PAID', '10', 11, ''),
(12, 1, '2025-10-15', '7695000', '0', '7695000', 'NOT PAID', '10', 12, ''),
(13, 1, '2025-11-15', '7695000', '0', '7695000', 'NOT PAID', '10', 13, ''),
(14, 1, '2025-12-15', '7695000', '0', '7695000', 'NOT PAID', '10', 14, ''),
(15, 1, '2026-01-15', '7695000', '0', '7695000', 'NOT PAID', '10', 15, ''),
(16, 1, '2026-02-15', '7695000', '0', '7695000', 'NOT PAID', '10', 16, ''),
(17, 1, '2026-03-15', '7695000', '0', '7695000', 'NOT PAID', '10', 17, ''),
(18, 1, '2026-04-15', '7695000', '0', '7695000', 'NOT PAID', '10', 18, ''),
(19, 1, '2026-05-15', '7695000', '0', '7695000', 'NOT PAID', '10', 19, ''),
(20, 1, '2026-06-15', '7695000', '0', '7695000', 'NOT PAID', '10', 20, ''),
(21, 1, '2026-07-15', '7695000', '0', '7695000', 'NOT PAID', '10', 21, ''),
(22, 1, '2026-08-15', '7695000', '0', '7695000', 'NOT PAID', '10', 22, ''),
(23, 1, '2026-09-15', '7695000', '0', '7695000', 'NOT PAID', '10', 23, ''),
(24, 1, '2026-10-15', '7695000', '0', '7695000', 'NOT PAID', '10', 24, ''),
(25, 2, '2024-11-21', '8265000', '0', '8265000', 'NOT PAID', '10', 1, ''),
(26, 2, '2024-12-21', '8265000', '0', '8265000', 'NOT PAID', '10', 2, ''),
(27, 2, '2025-01-21', '8265000', '0', '8265000', 'NOT PAID', '10', 3, ''),
(28, 2, '2025-02-21', '8265000', '0', '8265000', 'NOT PAID', '10', 4, ''),
(29, 2, '2025-03-21', '8265000', '0', '8265000', 'NOT PAID', '10', 5, ''),
(30, 2, '2025-04-21', '8265000', '0', '8265000', 'NOT PAID', '10', 6, ''),
(31, 2, '2025-05-21', '8265000', '0', '8265000', 'NOT PAID', '10', 7, ''),
(32, 2, '2025-06-21', '8265000', '0', '8265000', 'NOT PAID', '10', 8, ''),
(33, 2, '2025-07-21', '8265000', '0', '8265000', 'NOT PAID', '10', 9, ''),
(34, 2, '2025-08-21', '8265000', '0', '8265000', 'NOT PAID', '10', 10, ''),
(35, 2, '2025-09-21', '8265000', '0', '8265000', 'NOT PAID', '10', 11, ''),
(36, 2, '2025-10-21', '8265000', '0', '8265000', 'NOT PAID', '10', 12, ''),
(37, 2, '2025-11-21', '8265000', '0', '8265000', 'NOT PAID', '10', 13, ''),
(38, 2, '2025-12-21', '8265000', '0', '8265000', 'NOT PAID', '10', 14, ''),
(39, 2, '2026-01-21', '8265000', '0', '8265000', 'NOT PAID', '10', 15, ''),
(40, 2, '2026-02-21', '8265000', '0', '8265000', 'NOT PAID', '10', 16, ''),
(41, 2, '2026-03-21', '8265000', '0', '8265000', 'NOT PAID', '10', 17, ''),
(42, 2, '2026-04-21', '8265000', '0', '8265000', 'NOT PAID', '10', 18, ''),
(43, 2, '2026-05-21', '8265000', '0', '8265000', 'NOT PAID', '10', 19, ''),
(44, 2, '2026-06-21', '8265000', '0', '8265000', 'NOT PAID', '10', 20, ''),
(45, 2, '2026-07-21', '8265000', '0', '8265000', 'NOT PAID', '10', 21, ''),
(46, 2, '2026-08-21', '8265000', '0', '8265000', 'NOT PAID', '10', 22, ''),
(47, 2, '2026-09-21', '8265000', '0', '8265000', 'NOT PAID', '10', 23, ''),
(48, 2, '2026-10-21', '8265000', '0', '8265000', 'NOT PAID', '10', 24, '');

-- --------------------------------------------------------

--
-- Table structure for table `equiries`
--

CREATE TABLE `equiries` (
  `enquiryid` int(10) NOT NULL,
  `type` varchar(100) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `message` varchar(500) NOT NULL,
  `createdat` varchar(100) NOT NULL,
  `status` varchar(2) NOT NULL,
  `readat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equiries`
--

INSERT INTO `equiries` (`enquiryid`, `type`, `FullName`, `email`, `phone`, `message`, `createdat`, `status`, `readat`) VALUES
(1, 'Residential Plots', 'gaurav singh', 'gauravsinghigc@gmail.com', '9876543210', 'QXBkRzd1Ym1zZDBKU1dRWGRoOVFwZz09', '2024-10-14 11:10:12 AM', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `expanses`
--

CREATE TABLE `expanses` (
  `expanses_id` int(11) NOT NULL,
  `expanses_title` varchar(1000) NOT NULL,
  `expanses_tags` varchar(1000) NOT NULL,
  `expanse_date` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `expanse_amount` int(100) NOT NULL,
  `expanse_description` varchar(10000) NOT NULL,
  `expanse_file` varchar(100) NOT NULL,
  `expanse_partner_id` varchar(10) NOT NULL,
  `expanse_customer_id` varchar(10) NOT NULL,
  `expanse_employee_id` varchar(10) NOT NULL,
  `expanses_created_at` varchar(100) NOT NULL,
  `expanse_created_by` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `LeadsId` int(10) NOT NULL,
  `LeadPersonFullname` varchar(100) NOT NULL,
  `LeadSalutations` varchar(1000) NOT NULL,
  `LeadPersonPhoneNumber` varchar(100) NOT NULL,
  `LeadPersonEmailId` varchar(200) NOT NULL,
  `LeadPersonAddress` varchar(1000) NOT NULL,
  `LeadPersonCreatedAt` varchar(100) NOT NULL,
  `LeadPersonLastUpdatedAt` varchar(100) NOT NULL,
  `LeadPersonCreatedBy` varchar(100) NOT NULL,
  `LeadPersonManagedBy` varchar(100) NOT NULL,
  `LeadPersonStatus` varchar(100) NOT NULL,
  `LeadPriorityLevel` varchar(100) NOT NULL,
  `LeadPersonCompanyName` varchar(100) NOT NULL,
  `LeadPersonCompanyType` varchar(100) NOT NULL,
  `LeadPersonNotes` varchar(10000) NOT NULL,
  `LeadPersonCompanyDomain` varchar(1000) NOT NULL,
  `LeadPersonNeeddate` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leads_calls`
--

CREATE TABLE `leads_calls` (
  `LeadCallId` int(11) NOT NULL,
  `LeadMainId` int(11) NOT NULL,
  `LeadCallingDate` varchar(100) NOT NULL,
  `LeadCallingTime` varchar(100) NOT NULL,
  `LeadCallingReminderTime` varchar(100) NOT NULL,
  `LeadCallingReminderDate` varchar(100) NOT NULL,
  `LeadCallType` varchar(100) NOT NULL,
  `LeadCallStatus` varchar(100) NOT NULL,
  `LeadCallNotes` varchar(100) NOT NULL,
  `LeadCallRemindNotes` varchar(10000) NOT NULL,
  `CallCreatedAt` varchar(100) NOT NULL,
  `CallCreatedBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_call_reschedules`
--

CREATE TABLE `lead_call_reschedules` (
  `LeadCallRescheduleId` int(100) NOT NULL,
  `LeadCallMainId` int(100) NOT NULL,
  `LeadCallPreviousStatus` varchar(100) NOT NULL,
  `LeadCallPreviousDate` varchar(100) NOT NULL,
  `LeadCallPreviousTime` varchar(100) NOT NULL,
  `LeadCallPreviousCreatedAt` varchar(100) NOT NULL,
  `LeadCallPreviousUpdatedAt` varchar(100) NOT NULL,
  `LeadCallPreviousManagedBy` varchar(1000) NOT NULL,
  `LeadCallPreviousDetails` varchar(100) NOT NULL,
  `LeadCallPreviousCreatedBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_requirements`
--

CREATE TABLE `lead_requirements` (
  `LeadRequirementID` int(10) NOT NULL,
  `LeadMainId` int(10) NOT NULL,
  `LeadRequirementDetails` varchar(200) NOT NULL,
  `LeadRequirementCreatedAt` varchar(100) NOT NULL,
  `LeadRequirementStatus` varchar(100) NOT NULL,
  `LeadRequirementNotes` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_stages`
--

CREATE TABLE `lead_stages` (
  `LeadStageId` int(100) NOT NULL,
  `LeadMainid` varchar(100) NOT NULL,
  `LeadStage` varchar(200) NOT NULL,
  `LeadStageDescriptions` varchar(10000) NOT NULL,
  `LeadStageCreatedAt` varchar(100) NOT NULL,
  `LeadStageUpdatedAt` varchar(100) NOT NULL,
  `LeadStageCreatedBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loginlogs`
--

CREATE TABLE `loginlogs` (
  `LogId` int(10) UNSIGNED NOT NULL,
  `Username` varchar(200) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `IpAddress` varchar(300) NOT NULL,
  `DeviceType` varchar(20) NOT NULL,
  `RequestTime` varchar(100) NOT NULL,
  `SystemDetails` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_controls`
--

CREATE TABLE `module_controls` (
  `modulecontrolid` int(10) NOT NULL,
  `userid` int(10) NOT NULL,
  `moduleid` int(100) NOT NULL,
  `modulepassword` varchar(200) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_controls`
--

INSERT INTO `module_controls` (`modulecontrolid`, `userid`, `moduleid`, `modulepassword`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 1, '1234567', '2021-07-04 15:43:24.000000', '06 Feb, 2022', 'ACTIVE'),
(2, 1, 2, '1234567', '2021-07-04 16:09:20.000000', '2021-07-04 16:09:20.000000', 'ACTIVE'),
(3, 1, 3, '1234567', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `module_list`
--

CREATE TABLE `module_list` (
  `module_id` int(10) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_list`
--

INSERT INTO `module_list` (`module_id`, `module_name`, `status`) VALUES
(1, 'ADMIN', 'ACTIVE'),
(2, 'WEBSITE', 'ACTIVE'),
(3, 'MODULES', 'ACTIVE'),
(4, 'PROJECT', 'ACTIVE'),
(6, 'BOOKING', 'ACTIVE'),
(7, 'AGENTS', 'ACTIVE'),
(8, 'ACCOUNTS', 'ACTIVE'),
(9, 'ENQUIRIES', 'ACTIVE'),
(10, 'PROJECT_MAP', 'ACTIVE'),
(11, 'CUSTOMERS', 'ACTIVE'),
(12, 'EXPANSES', 'ACTIVE'),
(13, 'RECEPTION', 'ACTIVE'),
(14, 'SITE_VISITS', 'ACTIVE'),
(15, 'CALLS', 'ACTIVE'),
(16, 'HR', 'ACTIVE'),
(17, 'WEB_QUERIES', 'ACTIVE'),
(18, 'APP_SETTINGS', 'ACTIVE'),
(19, 'SMS', 'ACTIVE'),
(20, 'NOTIFICATION', 'ACTIVE'),
(21, 'STORAGE', 'ACTIVE'),
(22, 'REPORTS', 'ACTIVE'),
(23, 'COMPANY', 'ACTIVE'),
(24, 'SUBSCRIPTION', 'ACTIVE'),
(25, 'MARKETING', 'ACTIVE'),
(26, 'CONSTRUCTIONS', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notificationid` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL,
  `sent_by` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_payments`
--

CREATE TABLE `online_payments` (
  `online_payments_id` int(10) NOT NULL,
  `payment_id` varchar(10) NOT NULL,
  `OnlineBankName` varchar(100) NOT NULL,
  `transactionId` varchar(1000) NOT NULL,
  `payment_details` varchar(1000) NOT NULL,
  `payment_mode` varchar(10) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `transaction_status` varchar(10) NOT NULL,
  `onlinepaidamount` varchar(10) NOT NULL,
  `update_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `PagesId` int(10) NOT NULL,
  `PageTitle` varchar(100) NOT NULL,
  `PageDesc` longtext NOT NULL,
  `CreatedAt` varchar(100) NOT NULL,
  `UpdatedAt` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`PagesId`, `PageTitle`, `PageDesc`, `CreatedAt`, `UpdatedAt`) VALUES
(1, 'HomePage', 'ZUg5TmtCdHR6SjJUVkhDcWVPVnZBSktBaXZyWkN3dHByWTBoUzdBUm12TlVLa3lEbk8wQU53amNqRzZac1Jlbk94Y2dES0pxNURQS1l3SFNKbyt1UGxaQkFjaVkzZEdyNlpmME0zc2Evak9oVDI2Zm1QR3M4YlVMM1pGNzR3d1Fma3V6bXJYb1djNkttQll2eGtjRE9NWnQ3TkxucmdTeEFhZUY1WVdrTy9nY0xCeC9HL2ozc01tL3paZWdLK2xDMmJKZUx1WVlUNWdZeDJVNlRrNW1wMWNsckQ2ZVJNb1BNSHp5NG9ncVFFOUM1cm9mcGpKSkQ4alFmWHovSTJWOFpTSWtBK3cwc0tMaFpRU1ZGaVZ3VkkvLzBYdDdiaWphNkdJUmJvcGwwZy9od2QzWTF5aW5MY1hJUkl1TzZIOEZPUXBqaE1LMitucWw5RUNiYVl5YkFVd1BSYWJpMU1iLzdsdmRtVmJZckhkeE1Ra2o4ZXRlSmhKWHBVQ3NidTk4MXgzUG5LaTg1aHVUK21FcmVKai9vbG9POUwrWXpjbk5KOUhjYk02M2NvZXNmYW9KOTZpZEVIVUlRZDFySVJ1RU9aQ3RkeitpTnpUUTFSdG1sYUVDVzAxUk9ZTnhxOW1oaitGbXVEcWtRYTArM3ZrdnNCUFQ3b3BKNU1WVjBuN2MyMjc2bVFmM2dncXdQRm9zRFRHb2h4NVQzOWxXWGZ4ZzladnluQ2FZbktDbFBRVTBVVWJqY2pJSVdMbDNpellSanFjZTFLOW0rN1ZQcGdaSE1EWVpGRGtTSXV3Wk54ZmFmcUxQbkJYV1JlWU9OKzVSejFia2oxZnFNT2ZhTWRlcTcrc3J3eTdoR0NPVkpIUzNkZEZEeDVYUlBQS2V2d2hVcTJYVjlETkNBdW9KblI3VE1yMmNidjZpbm5vdzVEOHAwYUs2N2ErOEJCMXB4UGhiN04xMmZxSWJHN3VxWkM2dmR5eGpQUHZQdGpybnZVZDFMRkRWeU5NNHVESlVVT0xUTXdFS0Q5MzB6MmhLQktreUxXSFNqR1BIQ2FhTXlOSFA0Z2UzUVBkYVRySGRNSWlkL1kvNDY2NkVPbTdjWS9UdGxXck5adG1DNHhuRWJaN3JsNkc4Q05ObHc2RWNpZGxKM2t1a2dzSXhMZ2piWnNUTjFPUkdRQncxbWtTUXIvTDc2VnBuK2NGN1JQL1N4eFQ2OEF0OFhiemx2eFNxL3ZpdWg4cU92UzU2dXBKdDZKTVhJKzJ1ajhGZmFzTFgyUEdKbnlBbDZtVHBmSVIvSURzQUpxdEo3UzY5a1E3VFVTeWZ4bWJWOXoxL2tRQkZKc1d5cHloSzZZR21OTlprcUt1ZHIvbG53MTdORG5LWDVDY2FCRFFiNG53WHpYMnl0RGVqSGluUStZU2l1RTlyeEoyYW5KMHcwVE9Hc2psN2FmV1VaN3hZR3pzc2puaWJDR3dHRHdyZDM3SE05RTBnenlOcUJSTFdqY0piUTNlNngrL1ZEc2o2bHh6L1Z3NGRPcUs4TEdXRHJ4cXc5NzAxNStZcXhUSjJjTlBiZFBQMVFnbFJuLzE3d3VpTG92M1Fqc28vL0xiUUF0U1R6TjhGQlUyZklIdGdOMDI1L3dWRjA5N250TUZuNFF4dVRZVW1lazdqRnhRS2hXM0drcDZiNHM1OTB6d3dYYmlNMTdEZStueHZ6VlovV2RGV2lOTXhXZ25UakpOSGZMVUdncHhXQ21UUFYvSEVnQkdDWXhVVWxCV0xmUm1jb3gzSVc5d1MvaVZnTFcyODhnV3dsSUZMVFB5VExCc2xhYWFQaHIvRzl3UjVsRlJqZkl2VEMxLzViTnloY2VUdTNLUUR5NGhPdjF2UHlGbFBPakRtWjV5WlZ4WXkzeDN6b3J2TG5IOWFRQk80L2kxNGJzdll4eVVpMzlBT3MyemVvVnArcForNlFjSkY4N0kwWlZEZ0hrMUxsT1E4TTBRTzNBUDBsQ2gwODBVTzBvRDNManJqZkZ1cHVaVm03aVRNNW1JY1VXSmtId1hkZzl1M2JnTys0c1JldE9yaFg3dDdqYXZZaXp6UXcvblBrQ3hsenBrS1U2SlpTOHJxMnpQN2lJZi8rVmNkN1RuMjJlQjFPRHJMem9iUUtZL2N0OE9Ra2ZtTGt6Nk9BbzRnR0JtM0JCdS9hTU9KS2ZWSE82ZHNRMTB2cjMvRjdPSEZKa1EvNU1DbmR2Um50ZVVYSThLRHI1bzRINWNFWHU0MHFMYjVmdmpXTFBkK0NnZXhGYjhleUdqYmRsb2tSN2hpeVViWlNmM0dKRVdNeFY5VEFmLzFVdUhiYUdVMGhIRjdtbVB4dGlPVUovMXdkVm5hYnNXU2FrSm1Oak4rbDlmU2lGMi95S2R6VVVzOTU2M296UWt6cnpOVm5ZS0hUOEZxSW8vRjUxR05nMnVHa3FseEVJcllwVUNUUndhR05HeUlyVGFuOXorMUFpd1dqVWJ2R1ZuVXdQWHBncG01dVJpZGN0TVlWZWs2bTJkWE54K3BPYndhakpHN3M0SitUZUk5VnVOU2VZL1JVaCtxK2VMOHowd3ZsWmtnWXN5bFhhS0FCTmRCcHRxZ2ZYNjBIUWN4bXFjcHB4SWJaMUtZNklEN2k5YUoxendqZGxkZ3VCNVN1USsvSVVVK1BDWEt6dkxpMVBySDFNN3hhaUJxVkY2dEZoZFNJd0x0bCsyYWl2czEwQXp3aEJSS1lNRjk1eFpmWVpXdnBZck1tWHNlR21rNXdGYjl1RjRsWkw1MGdSUDdLQWsyREF0MVhHZnVteXNCTUkyTmJXbXVOaC9xVWI1U0RDV1JMK0xVN0ZPcEtwdWF6ZWF5NS96NnRSYkNzelkrdGNZb25JaHpEeS84VUV1OElOZTZlMVV5WHFLaUorcllhdWVNZHFWNi9DaU1PR3ZXMlM1OUY3KzdQWjVRNG5JTGF5U2lMZ1RIUytLUGY4NkIzYzBmcnoxcWtuY3Z1MmdzUmc4NW94RE1QcU52VDRjZGpUdnNuS0paa09Rc25ybXpXN2VXcWp4UEQ5S3VTR3NmeGNFTldnV2MxRFJxa1hsYlVGSG1Ra2dlV1dBa0FrSzczYlMvdEs1M3prK0RMU1JmME5iSmpRSnMwdDcyQXNUV21ORkJKRWdOR2pCTFA0eTNBN0ZBNkpnSzhFZkVZekN5UXhzZXJTNEkycGJERm5oL2M0NzJyUmVyd3g0OHZxZXZ6NkhJeitZMVdtdkFIV3R0bnVhd3hWNXVDczIrTGY4UXdtcDYyYTJqRldVbjgzOWsrOXM5cXlFMEhDclZJeEFMd1lPRTVGNk50UGtpbFF0bmFBR2o4QT09', '', '2024-10-13 09:10:37 PM'),
(2, 'CompanyProfile', 'ZUg5TmtCdHR6SjJUVkhDcWVPVnZBSktBaXZyWkN3dHByWTBoUzdBUm12UCtGK0oxdFQ3aTllZHpzbkxCTTdGM0J5SnFkbXMzWE9iR1Z5V2R0cUhxQS9oY3hXb0xERVVuamJFYVZMNGtiV1Q1cDRvV09TcEpKdURLVmJGZzNpclJ4RVhFckFCSzZza3YwLzZhb2ppYVBTbUlvVnVhS2d5clVkdkczTEVOMTc1QXEyWExCdGNOM0pLZDNaVUt0VTE4d0ZtRmdBTUtVRjROam5BWEtKWXlOUWNEa2FJRWpNQ2hNRldGV2UwUXg5R0lHYTkrK2pHREIyRG9tV2JhTkZ5UUh5OGtSWnJId0VSL01SMDEwN2ZsVjdhR1ZISFM3ai9ZOEpndk5TVzY1ZnpvT2tBbDVVVllOM0xnck15empZeGZncklJYythdCswTUhhanNJK3h5M3ZYYjNYUlFtaFFTTUNNN2ZQNW1NNEh0SFhvRDE1Qk1ONEhBdnNjRXFEeVpCTjRBRUdFZlpSUTFNdzVuUE5hNEtKSmxRdEtnQ1l1bFNweURaTndGSXBjcXgwK25iblFNQ3p3cHhka29oUVYwVTliQXFFNU82bkFpRXVSWTIrV2M1ZjFOVkt0UFEwbjQyMFRVNzhmYTVCWmdIaThmSHJzQ3EveU9PVGdjVnhXRmNJeHBrZ3ZVenMrOGkwTS9JaUY0RmxIbHFGMGZMSFBDbjkxN0xtem80SmVESUR2OWoxMzkwWDVqeDlMandub2ExSjltSnQzQ3pqSVR3a1dGRnRzSXBmNE1IWUdOcHY0S0t4d215Uk1DUnRPRUNIWGorcHNibTJWUzF3WTRBVkVKSWxWY1N4alBhYVBxRFZielUzcHgzbXZUYkhESnZBWmRlL2RpSmtYNHQxd2NJMVRoREx3WXFDSjJsYVIrYkVWcEZOOXlXQWV4NEdCS1dDdEdoUHIvQ0F6cEkrcHQ4eC84eHBRYzhmNmVSQWczZGg0bm52YmpvTFpnWkI1bXMvZTA5dFEyd0ttVzNsSGlDQkVjbEp6dS9QdnZrSGtta3h6NXFvRjl5cEhIS1BuRXh3SXF4cGhIeWpFVHJaRlRqQ1AzbHdrMWdRaE1lcFUrelNoc3hDNVpUMU9BRHlsN3M0NVRoK2UyTWZkSGh2NURxazRMeWczQzcrZndRZUFzQlRYcUxXWlhiN2lIbk91dFdmWk9GeDcvUzM3d0xwUGNpKzlqcHh6d0xYbW80bG9EblNieDY1dHo1ZkJ6SWtjd2lhTzdmMnoxend0RnZPNmlab1A5WnBYRXpBSnVNRkx1dUpHTFl0YWEzZkZpVzZ5bkhyVlRJb01JcUdBZkQ5RXVMQ1RIWjBMTFRYYkRHQkJJUXBLLzh2SnhQbnZkTjJod2FBT0xDaHJvcVdIcUJvR2Q5a3J0L3NDSElQU0xYSVU2dHJUVDZTQmJKdURIRmxZTXhPajBscmZMRWlTRWFqekxzVFdOTE5rcG1vTUpsQkRVZE1yUVgwY2lSbXZqNGNSQWlPbnFHRDg2NWdzUEpYZUl1S2djN3Z0MGRlZXQvSUdwME1mbVd6ajF1UUdUNjFQR2xGRjhFejROdENYckhlbDlDcUxrSmNIOTdJM0xOdFdSa3l4emR3OFQ2UmlNY1ZXbmVlVWxVa0t3TWY3emVER2ZKd3h4QTB5RzIyZE1DWk5sUVVadVJJK0dNbFhlVzVNL05HNkdaUk9rZEIrRmJtMkVJMWl1dTIwb1h5NHhzL0tONGsyUlFBTjRkbXV1SFB5U1FzTHJsRnNnOVA3azc2bmozOXFxbXpqM3RJSVppT0Z4SGZxQVEzSm52TUo3MExtOHR1UWRMRzJ4cGJEZ3cxUzFJQUZRMlhXdTFMdmhGUWV3TllXeXZ6RnBxbU0zNy85cWt1c3JjSmJXNTJ1akZKVnRMYjdLbmFEMVJUazFyb09mT2ovNnBQbExNWGdZNk9qOUQwR3dOL2tPZ0hlUEZ4YTArOWNLWklBanZOSHJGNlpBOTFDNTlEMldMM2ppWFhCZnJ2VlJ3ai82K2tEZEV1ZGVvYWs5eVpsT2hLcTYwRldTYUxRLzdaTVQ3emcySWQ0ekFJWThZdDVjSHVITnJXZFprS3lHSDRhK01SVWhlaTZUUW5lWVVkTFZLTXpvOHFpWjBPS3ViakpTQ0FUWVlSRkhRL2IrRE1jazNqb052K3BRcFhHVzdTbFIrck90MlYvYUpkSVBzRGlXRkJLRkZNOEdZZTlwZHdLVlhUUGpob0E3UmVJbzhjbEdieXo5UFBIUzNwSmNKaDVoWE13WWJRS2xRMkdjL1ZzNVlDY1BsWjBGMUtGRkZWR0RnenBWV1JkTFRuY0MyK2ZXOUV6QnFXQjB5bzh2OGlKUXRqY2Q3S0VTMUMvNnp1Rit4amQxM2dmejVEeHBqVWtRZElualB4VWxnSWtqeHcwZVU0MzlTN1NBdDdFdlFuYlo5UDcrOFJuSHBpMUZnSHAveHFYdUErUFRYaGVKc0M3aUExaFIwbldUWFZmSk5oaUNHWXhiaGI4N1ZPWnVud1RGTU5qZVFSVHNXTi9BQUNKb0tXZDI5eFkvb29yVERySGlyUkhQRCtsejdIRkdCQ1pTckM4NU82ektMNVBUTnY4SkFQVHFpUWk4UWdxei8rMGJUTmxWQ2FLV0JMOGFHUnMyb2tLQlk3aTFacVdrczBGYWl6UnRkZVpuaklUb2Z4bjRZWEgxWnZDZjVXQUdXQjYzdEhoOUw1UGttTk8rWmJNeU96eTg3UGRMYWhtT3pRMUtCZWlnMkFqc2UwTUsx', '', '2024-10-13 09:10:00 PM'),
(3, 'Privacy Policy', 'b0Zka1dHWVdUZFVJSzBzd1hmdlFyL2pnbHZZbVcrczdlRTA5aDZ4VE9uSWM2dGtqc0hJQnFGYXFGS1BpaWwxOU82dHU2MmhGSGdDQW4vWFo2dURwNERqQ2lyaEw4VTR5ZTVJeWpGTWZIMWVVZ3BUVDRjWCt5WVhRTmk4Sm1tait0MkJoZHVMWHZOajJXZkRqekc1bWhqZTBzdE4vTDZmNnpwZ0UySnBEcmRDZ2hUbFcxblZJY3E1U0xDeUN6Z0llMUhrQ2RkSi9oQVNDNEpiZkRPak1YZFkxTHBWUHBDUUV2aUlPOXRBeEltcXRMd3lkaEQ4M0FUdEx4ZWswNzRQNUlBTEdRVE56ZVJVNWdvcHpMN204Ni9pZzdOMFk0S0tyTkgxRC9QNDN6ZGxJVmNKSlVNZmlNNjZ6cTg3WHROSUVVU3F3VnZGcS9qVjVZdHVET1F0ZG5UYkN3T1Ivejk3Wm44dWgzd0xxRDlhQlpqS0F1QjZYNk5CdWJ3ZHRGZlhERG1scXBUSkE4VU1qM2l2ZTg3T2s5YWxzY1RYQmxud2cxZG9rTU4wZUw1aHRzdFNGNkE1Y3o1d3QzdDFZNFZzTmpyVU5oMFdYMEg2UkNBaXZJb2haWlNRMU1rMUJsaWRBSEFGYi83ZXpiTXBYMDVySHFxeDRFWTFxZWlxWGNKTVhYSWZFODcrbmszNnM0VVh3bG1LWGw1N1NXajBXcE0vWVE2RGRvdkFreEExT2hhSGI1NmxRYnIveTlJbFVzZVFZNG9ISW8vQTUzR2VoT0FNaXl4WFMwcDRJc3d0TGlDNlNNQUprMDA0c1ErS3NPVmxJVEJMQzg2WldzalpscVFaaHFEeTRTRVoyY0duU0I4VXFkZlh1NG5UT0hRZWVYaExCNWoxTjRIcENMMnV3cnFuTGYrMTFOaWxNSURXbW12ZGtFWllQMTFFL0JzTURiclZ6UmEvckMxTE03ZVZ6bFNkenlRWk9SN1U0ZHBjUUhBNnkrdEhEU3dJVzZLK1NnYi8wUDJpV0RJNlJYamMwdlRqWEdLb0hpblBCbW9XMVlRU2Vud1pndmpuK092Q3ovZTlVQnJCdlcrRFBsTSswSTBGK0VKdHhHV2xJY3pJYU55UDBkVjFIdXV6TFkyZm9PQlhncTJDanFiWmlYZkw5QzN2NHp6ZGROVzY1NDVXN0pBQzdtREdOejc4M3BwaEl0OXM3czJ2c013QlFZVXJFaVFSelY3YzdNMS95ejN0clJ4NnpsdHE2OCs4UVpveEd1ejA3eDQ4ekpEdmFmOEMvb1V6RHVOUHNKRWs5Sis4anR4UUV6TmFubmkxcmdrQlBBcVlpT3VtVmlKVVl5STZJbmM0R0pDZWtjNnBvOVhHYlVmaFlCd2lOcVl0Z0VtdmJrazFvcVV0WjVmUGEzZTE2RlJUc0ZGcURSMmp6ZVlyZFBOeEM1Rnp3OWcrdkRqb212MHhmSHFwMCtDZ0dxNzcrd2RhckM0TXFncGVqWVNNbTZzVldTTHBJdksxWUZsc3M1YkRWeDFXQ1FBWVdEeW80dUllWUQ2RUFqbHNjQm01R00yYlo1UFZTY3Z2eTY5eEtGYldDVi96K2x3aEJHUGZDRzZvQnp0QTk0RjR1cUxNWTdCVDNOblY0V20xZlF6TUNUclorNGdSampsSDJYSHVnOUVMZ3VCc0Q4SEtGVklHbUl6Q1J2OUpTOGp3S2lvbWxSaWYwNERrd2dOVEdURlc2L1hVL0hvWFlKaFBPZWdRZHdOYzlqT3NscXk5V01KT3MzaHRzcThCTGpjM1JEU252SjNIK291RUlibEtFQWV5U0YySmpJTkRMZU9IWGcvSE93MnZKK3IvYzkyZ3U5dUxrc2JDdUhxZUtWNmxGVWtrVW5IdHJnZWljMzVWQTAvcGdPMTZwbHRXdG9Jcys0YVVkYlM3b0NwR0NEYmozeUNKSW5JcXVSbkVIL1FzbXNmNnVLQ2NibCtmaS9lb29jRW9FWGM3U25LOUJwS2JUMUkwWlNWako4OXhYVnR4UlkvdkJiVnhaR3NsZ201OHVQanphclpXT2QzcHB1cFpyTUxwRFVRZWRNT3Y1YWpHOUFxYjhmKytBaTF6TnZXQkRaZUt1RmtQUTVDRnd2aGt2a1hrdldiN2VldVpZazA5N1lmWmJDbldnZE9VUDlUM0p1K1IxYzJneGgrNEZHUEZrUUZxZC93b0lOei82Sy9EbTVISVFVU1A5VFlkTGhRZzVYRFJNYXR0cVB2WUVQbG5icWw3eVExd1pmaVp2elgwRm9nUms1UCtSbGMzRXA2SjhvS016Zmh3MDhjK25ucHZvamVTV256S09UdkMxMlBHQUFaVUtvdVZOQW9jWjJSUHVHUGlOZERUN0JiR3FCbTNTMkhURkgxU0lHTzFvaDRUSnd1WUVIUHd2Tk1pWVZHMGJIKzVTYlk2TjJYUDJYTlM0a0ltRXkraHNoU1ZHbGZoUlAyRDMzSEttY3RVem1mZmdYUWtSNDh1ZmxlRHhNeUl1Q01QOXhSZUk3OFphRDVSTG96am9GV0lXbFpod1lWK04xakJ1TlJweC8vNzdLY21hZW9CUGUwdkVBRUsvNUJkYUhFS3R3c3NIOTlVcTFWUmFXWWIwaDZtd3NNbW9MTHQxN3BUV2N3TmdBcktSK1NiZTc2SkJWdDd6NnFJVEwwK2tRdHZBK0gwamFNUVVYbHlwd1B2bEpLK1Yvdjd2bDFHa2ZUbTczdnBvOUZxMFRWMUkvaWRtREh1cTdBS2pyWkFNVEw4VkZMbzM3dHZBZWZ4bGVuT043bFgrTDF4a0JCQWd0L09GY2FrcjBVZHcxUDBybjhrR3lOcGRrWHhKRnFnWkpRZnpxN1dzMWVyZGR5UUVmemh2a2NSWWhiL3dzZklhdWRvQ1RtSnlVTE4zRFR0dmNIRURyUGhKTkRQQ05EMFdmOGF6QVFteitITUNuM2hYUlU2QnpOejNSVlljdGZJZkk4eFQ3YnB0MzJjZmNUdUVTMks2QjdiMnBpaStMazdSTU9raTdkRDRCNXRxaVI2K0pyZmZBYjYvTm9keXd2WjN1Q0NDYnhyeVcwaEVsVjE3VElOdFZkUlFJSml1clVzS0NHZGtZc1lPd2ZRNktKRW1QN1loK09pYmpYbVR2MiswYSs4NGwzV0UrR0FCNU81RVBya1lrRUdta09aemJwbEtNRFAxaC9kVVRGWjBhWFdPS3did21yZE4wUHczYUVoRjBWMktYS3UvSVgxNVBtZWhvU040dlBELzcyRUs3Y1QvSGFXR0h1NkdUSisydGxtV3ZpWXUxbk95dDl1b1RqY0NDUUpwRFpGV0dkVm1UV2lXckFUSmpPSjdNVjNNQ2lEV285UzJ0YUpxTkNJVkZTV2ZiQSszck9XRlhMbXdYT0VDSFg4SjdCOFVFMmV4K2xobzhXc21hb1dxYXN1eENyaS9ZdjlqOS9XeWZTazZYNXlhdFZ0andzcDEyRnZCSnp0UU54OUROclhvSi9TaS9sRDJUM1VhN2VFVFZPUDU5RW0wSkVqTFE0dmhiaGdBazBlN2cwdjh6aFUydDBjaU16Y1Bvc2hQMENuWWJXYUx5bzRXbUFqL2Z3M2VIbWpUZHF1Y3YxR0FDRzRvMjI0UGRQUUFkU01jeno3WWJNTkZOb3A3ZEdCUk8yTGRVbUljZGttR3pBRmxmbktXZFhVVk5CY3d4ODFpZFZoLzJjQzczNHFMTEttd1RxOTBkcXRMNFpEME1aNmJQN2tDVXBUUUloYzFVb1o5WnowQTM2UHdKM0NRbnB0SlJCMGp2QjhpdnJucFVXMGFFblM0Z3JML2NyajV2aFJyZVIvR0VCbkthUGhvWEFHZHdldHlLd21YMlJENmtLSDZaZFAweGUwbHJxeE5lZGFaYWw5ODJBWmxZMVlYcDdsQ2NuWWNxUkV2eXFnTUM1bW5HUHRzZnh3dnlYak9BdFBWcUVrbkJ3WGJIWXFZcmpFYTF3dDA4N0t4NVNCWGlpV1UxeklhRFlRczgzdEZZaEZVb203SzlGSGI2cmdwV0tGK1hJVlR0M3RvekRrODJzZVkyVkNmYS9UejgrRDljT0U3bVRDTGNET095S3ZNbXZYYWJwYTFFL1h3SUlXbmJndlU2Uk5wS2h6eWFaN1FBaXNwbTlpN3NaOGVrcGxSdVpIMnA3dHdXN1pIeVhhOEdUcm9UUGkyQVU4SGxuOC9LeDVWMmRjS0FRdHNLbXFQV3BEeEMrVDNvOStFRUxEUUZTV3M5Ly9YUWs5VWswaG9sNWd6SS9ZOGF1MzJoRWdCNnJaNHNVZ2pxbTc5cDQxQm1OVzZiTVZ1c3cxS2FtYXFKNnB6YmpyeW9CZG9BSE1xMGdheU5tb1NHZFRSaGVxWGlqS2FvYlVkVnJtQXdzTU50TmZmNnZCRWZTdlpocFlURzJMRFBIa3BBWUNxZVMzSWhJd0tlcFgrQ3lzTDNLdnBnWFJUQmJXT2xubVoxU2lyTDk1ZW9CQTNSOUpUay9QNFNlTFNqeDNnZjA3ajZFbFRZbGVSWUVmQUUyZlE3dHdPRUhFNDBGWmRUT09KbHVqYzRROVBwbmVBRGZHOG5KSzUyWncySnYrVnAzdWRETXBxcm5UM01yNGpRbnhvekV0d1MxS0Yyd2FnRzd4MGhSZ2JSbWlROHBtTjJoYVZYUmsyK2JSQ0RLK1ZxSGwyNlovQ0hDTEtYeXl3MnJ2cW9IU2FBTm5mNVhWVkUwYUdNdEFBbXpLNytOZ1phRGpRVUt1RmpvU1BTWGJFS3Q3M09qRVpTQnpoWUYwMWNxOC9wSGM1azA0clVEdXlaTU1NQUFXUXNONDFDWEZTMUlrakoxaUNxeUE2UUJUTDd4YllPYm1OazFEMFdGYVpoTkU5NE9PZzhkK3hzQnc3azRiSmY1UHNudUtVWEg3d0Mza2ZCNTZhaXVHUVBTQktMb1lyT1RhV2dCMWlEdkRBcGVhQlorK3VqYTk1VCtHbElPV2VESXUxZkh1MmhsVVF0Q0tDTWJGSHp6NTdSQmtCcTdSYlpBc1JFN2ZudlBOQXZua1NUZGNqVCtvSTQzOWwranlaS25XTzJ2Zzk2RS9sTHV6NnV2Sm9PdDdHUzczd1h4M1lhV045MmRXci9qUzR4VU92RGcyYURRNktWZElCMGFGbGoxaHhpd1RnOTVIV1R1K1laMldWODJHNTI2QVBJVklFQlZkUytHMTg1NXZLY1M0TUh0WW9NYktQV0l6MzhMTFR2YlVyTUZyVytPa2d6YnVNeXprK05FbWFnalJVcndTSktMODBGUVg2Vno4Zm44S1BHdlJFOVhESzFoeUx2N2p2SVdmQXcwbmtPRW5iMlNlNFVFVEczdGFFdm1Qc1FKSGRMNEFVdUtGOFE0UFNmYmcvSnpiR1RwaUdmTTJ0b1ZNZzE5ellKYVlGd0ZtQlhYb0JOOG9EK2J3S0RkOFBlR3RJNHRHdmxQTUwvZXRDdis1M0MwTWRjRUtuZlppMmFhRjFDcjY1ZlBhV3BTeWdhUWEyaENvM2MrN3dJOGkzaHVUR0trL0xrU3YvSEJHelQwNU9LYkZlV3ltWXVjL3gwMFRQbVdseWZUL1puaHpxcG4zb0JoVFR0RWdiQU1FeVVaRytmZVRrZm13WStCNHV0RkY5Wi9TT2t0UDg1MDFGdFZVeXA3RHlueXQvUHdvbmlMZks1THVPK0hQSmtMZ3pJOFlETmN5TG1la1FrREdWd3NLdXR5UFVJdlhlYVQ2eWtiNnBpNUdXS0NKTko4U3o5cHdBaVlkVzZRc0N0QXhsMmdQZExDVzdMNmVGc29vQkxEZmtaMHR6MFliNEZVN21vS2tjd29BSENNakw2SkE3RUxMWW5VcjZ0VlFKN1hLYjJ3VXJONEtJQXNYY0RhMHozN3hRYjJiR3ovRjljOFFRL2RWUlBvK0RPVlFRNGpjLzZCWTRiM3pyKzRzTkg0ZWV6RWZydmhiOXU1T3ZmSGt3VFlnSnZlWTN1Q2ttTitRVzZpTnNWZ0VTaHpBYXpmd1VmeVlORVYvN2xvSkViMURLaWZuS2thWnlJQVhCaWlCVUNXL05jNWM1YkNjelV3ZEhzN0I1Y0tDN1l6UDlwUW5DMjBraGpiejF5MitpdHRBVWRjSWovS0tqL0Y3VWRWWVVNTXQzWkhXUUJpdmJoM002enBJY1pOSDQxaDhGT2VibE1ESGNGajdGVXova1YvcjdXcFNpQlZaQndDZ3NBeTE0RlNDNEVKazNWSkVhZkEzVUdQOC8xeHFycExNTW9nWFNTYTFVOEVvbzhYbmc3TkxwdUdjc2RNVkdhQ240S2w1d3R6YUhaQ05SMVQyUmUrcEJHaXRXbnZIeU9EeDhGZGkyekZ2eU5rZVBTRGJwdmdyamFmemp0a1BtZFI0VDlzV3V1dmdFWW9Yb3VlK1V6QlRLbWV1a2JNb0J5UTR4aTh0NExuWUd4TngvTlphakFLTkNVajdGNUd0NUwwL2c0REd5a1loQVFvcFFvQXN2V0RScWxmSFZOQS8vajBHMkkxRHo2RWdIaDFQaHludmJ1aU5GM3dhMHp3bXd2S2c2cEdGamVNWmRqclljdFY1QlFnZmhTZmg0MGdITFIxUi81R2Z5KzlwdThKOHpwb2EyYXZwSGlzTjM1K1VKRlp5SFhKZnJVb3FZUEtLc1BralJiTHh3RURNMmhJTXhyMVdadUNDZW9ENWQrMTRzNzZZUVU2bWZHM2RQQk5oQUF6MG9PWVZHS0FKdUpUWVB5UUtCRnZraHZlSUdOaG9tTkRsNEtYb0Zad0hnUW5HS1JFSkVYUDFRRUxOeEFtL3FIS3RtK0dwSERNSG9PaUNZajJFYXZ6RXFuWWpTM3FDSU1taHdYTzFVb1VoajVSRU9zK0ZPSDB6TXJkNkVIZ3RncVFKM3ptWmdiS1VjUTFFZjF3L25JQktpdEZSZ3VUeW1DMGwrOUVKMTBtdlZVSG1ZV0V5a0NzUHkvVi9GVWhLNitlRGJaYW1yd1l0NTJoT3VMeS9UUVRxWWsvYUdGMEN0NmtlZTNPdkVPZ2lpQWw2QWtUY1B4a3VUbUhaUmJCQlE5WGkvaWl2WDdIdXg1d1N4Z1FvTmNLRWhIVEVHb0ZoWVNxVG9YZU9GT0pVQ3VEZGU1bWY1R29QcnNnM1Y3QURQYnBaTzA5V2JoNjNqOXEyTVFiN3p4bm1Rb1J6MDNNSkNTNE9ENkNBS3BiKzk0UWVyMUFpUjBudW8vRkdETFJxZTRjdURoTXJUdzV4R0I2T0ZOSEpvOXlrSnRPdlM1by9yMWxieFd0cGQ2RjhPWmhLRjlxdVFQMm9TZGZXVHNrVTJ5OTlLTEp0VFlBQUsvNW5OTTVneGdnbzc1V3RrS2hHNHpqMHZUZHBkK1BkVHZKWkhoK2RUQXEwQlZyaXpvU3UyUHduS3ZNZVRRWElPMGhMTFJRSjhVQnRseGtHRVJ3RlNDRjAzRXNwM1JYUnE2azFlTGo4UTZiZ3UzbGJwUStZNzJ3enBBNUgrdjkveDJLRFFUbjA0UGtJKzFFTTZ0OHNKUE10cktYRkIwMEJ1N0l0TWFmR0RVaEtnVGlhMFhDYzQ3UEc2eUhBTTcwckFxTnBZTGZtMXhNeUduZnJCK3I1T01ZQThlVGxtYTdOenFReEh3a3FMSUt5c0lqZUUvaDcvT0JhYTBxYlNlZTU4bGdUazlLUUl6akw4ZnIwREtuMzR0ZlNocmpjSnV1WWZtY1NEUVFqOXo4bGhUUjRzeG1QZnFBTURpeUY0Um5Md3NUYXBWT0J0NE53Q0Z0cUJaZCtHWnJqQ1hWNS9KdlNtdml3ZjNpMDVoMDQwUkhnRnl2eVExbll5MThpMDZ3aEhZTW9SeG1jQkZoeWg3TVp1TjhmYXorL2F6eHZhWnk1ZUVKN3pmSlQ4ZDIxa253ZkMyWVQ4YUhwZ1VXY3hSVnZIS3ZhMFF3RHJ5TUU2VVllck1teUFSRitqK3VjQ0hRUTNKK0trNkJUdW5MR0xlaEZvR2Q5eUdMZzZ6cWRsdnlRaGozelNCc21nV0FrcXpSRzJYWTFhTXpNMzk1dmNrd2Z5TURXeFhUZWd6K3Q4d0Q4cWI2aFhBditUalFCbmhTeXVPdWlRTDlLeDErTnd5dVFKeXpGcGE4WUpHMnFqdEp1Z2Z4dUJJOHFJSFZpb0JRejVPM2NhWFlxRTFyMXdXRVFpeXp0eG4xZENucVBvUmJJRTIySHk5M0xjZmxFV3lvNi85aUh0VmFyMlMrYW5OTTQzOGh6MjliaFJrMXo3cmhOOGkybkpMZGFhY044UGRZOWN2QkZlV3pjMVNxRWFBVExwMk9ZcFlSNW40Skx6QUhhNlk2bmZVUHV4bWZNQjE3c3gwaXR5S3BQbzYrUi8vL09TRlZ0SHdDdVpMVklabElQMnBFSk9sN1cwYVB1MVlSSjlZVmdFSklUYWN0U1MySkc4QStLa1FTQy9HTFlIcDg4TVhoUzhlSElEeXYwMFVEa0MxTkRNbXR0TmlnT09uQlVLS2tsWWZkVUM0eGRKZkhybGpCRTBhQXpyVDVIRHNSV0xyM3lTZTdUVGM5YnJNNzh0UGxCMzRVWm1IenFzblQvbDVYM1o2WmRJTkNXODB5RlA3OVc1YU9DVWNNNlF5OEtJell5YUhmVFBicHRpbU45dVRlNEdpWlhJdnZlZVk4VkszWmk2ckY5L3dac005UDkxVXRWdzRWYWorWU1Lc295czk4VXZXTTE3dnV0Rmx5T1BvVytoM0NqTEZiS2FVNGVvMWFQU0hrNkdOUmJ5amRKMGJxZ0YrdisyWFpOZzVQUHgzSWt6c0loUnpaNHF3NkN5M1RoTURLMmNpb0F3NUJKcndBTlR0bUVFOXMvdUxXdllzZVhJbVp1THlJMXZQeHFWNHBRa0krc0prK0EwTjMxMnA1eXNsNWNPVjI1TmFucGprV293Z3MycU9aOU11TGpLWXlZQ00zL0d2RktiTzZsL2orMjJnWTdmcDJMV1JoL2RreEFkTzkyVnpXNVUrSHpEMTBVMHhtbUxtWk5tVGdPbmtTR1hVNlVLRWFaRFhHU3BnQ1lHb3BYTnhNMWlyeVVmamJzSW5MYVlHSjRjaFNiZzBldEJ2emV3Kzkxc09hYitHMEp5azNqMENSMmRMLy9FbHp6NHNPeUxYMTUwUVM1cHNxT1pMQXJnMUxYUyt2WVliUE5KTVhNN2E0ekQyRTNhanpOTFFYS29nZW5UM2s0UStNS3h1ZDYxMVM5ZXJ1Y1FnNVRhK29qZjZwVWFob0tYWFlBWFRhNVBYcExiaEpPQldUVlZDcFVkY1M3UmdieGdoVVFQL0ZBVi9HZWxtWk1hdnB5T1dNeEJiRU9lYzhlM0RSNHlIcElEWlRPa1NBZWwwT3pYTEhLbUttQkgyeVBvTUJtK2hVanA2SUZQNXNZbTdUUi9DWEdMUnpVV2Q2TldTSTc0RUZFNTVzVGcxc21oOUcyZE9IT0tBcWIwSncxUFlhVG1LZVFWZ0UzNGZHWmV1Nk1Ta3J6djJEMHBMblZDNmpiUEFJMm9XN0NSbHUyM0JjSXRpZmhKdmF4blRaclZvK3dYUFcvUTYzOTRpbWVvbkFuSUorZFh6QlBacm1xaCtCTEVqeHlNWm9ZMzV3Z2NwMlVlREV1djBkVENGc21lamoxNlB3TGlBVURkdFk0aFVIdFU5VWRBVnNia2pCT1UrS0oyeG8wYnpmcUp5eGtIdExqcGFSd0RxY1B1NG05SE9VUjJzWG91NlA5dUp4Njk2dnozNzhEelQ1UVpnWW9oVVI5NjRkNk5VeVAyVUJpamdBYkZ5ZUdnVU5oOFBqa2NtNm01UTB3YlFOK3JlMlhTYzFIbHlSRzlEWUxMNFhLRE5LSExncWRrRktxc2RscGRKamVCWWxTWHg0dWlEK0V2aDEzRndManhUMnc1TFhETDhOMkJ4aHJKU20yQUVHdEZ0UHhaYzlVajF4OGFHMjBRMU1NVVJzMGdST3YwN1pZNytLYStPdmZrb1ZneUYyeXQ2K1o5MkgzVkNTTUM1OUVkM3JJUEU1cG12MzR1bFNvemwydjYwTkNFM2psZkR5NG5udmdZcFBrZS9jRlk0aktmaGZKVktDVHdUMlFtcTB3dVkxY3FmNHdyQUovd3VnOVJxQmNQWjRpMUlYdHYyTWlMMFN6Q1l3WEtrTnhCMmUvM3Z5S1h1dERzUFZLY2o1MEhycUdZdHhmL2lQWkhBcHQxK3VtWFEwS2R6WTMwNTFRZDJQMjd1M2g2Vm1FekRWa2ZlbjF2MXZVSHRCVE55NjlCMFNrN3k5amlKVHcxeGdVUldiVjBMMkJBOGtZQy9XZGNPdCsvdTNaeG0vaTBuU3pRc0dDNTF1RVNsMXpzSXNaUDM1eEJyWUFRWFE2Z2xJd0xlUVJkSXdTTGs1UGE4Q0ZXWjh0b2hobGk5YUdaRkxZSzhrcHdhNEFkbFk5MnptVWFVcWluYTFtUnhhZW94Sk1HZkZGdnJlVVhqL0RHd1AwK0NtZnFsQlJ2ZUNyUHBOSnBIT3l4dVYrNDZmZnJmRUZZREhvYXhrVm9ZRW1zTTBpcG5WOEQyT1ptMEhheFl0ZVp3VEIzeTR5S1RocDhKUzZiOGwwd050TyttS0Y2TGVaMnV5eHJHWDN5c1p1WFl5cERjdnlidWRmSGRxaHByd1N5cklBOGpBS0JSNkNhL3hsQjJoZzA4RTgwWXR4S2lQWEx1OERsZkM3OStkeTZMSC8weTYrd3M0NlFlNEoxb3RkcFg3L3hmMUVWVFBmcjRDeStUbTZ4VU5zSnpkUXdLSVVncllMRDJkTjJwc3lTMHVSVkZQWTNsQXRWa2N6eHN4L0FBb0VBZkdmUEh3bWE4TmhRVnpSOENoSXVYMXVybnNnQ2REdGZZMUpqdy85SFc4WGhFSzhjVm1jL0RFOUFkMlpCVnRPSFk3RWlsRkdBbTEyTnF5Ly9PMWxpWTBUQ3VqTjRPNlArckpZZDVKdlBJK29uY1ZFOTNESXdCTHVVbEZTRWQvUjkvTE1hR1YzYWt3bTRWckY0S04xMHN3ZndFcWFiK01uNXB1T1IySkFDQ3pIYU5PK2N0N2dZcTZwVXNVNWM4M1Y4WkRlck5NOFkrdExjWm5wNWZQTjI3VHpPN3JVRFY0cG9NOG1zd3JsVHI0eHVCWTBqbEk2ajhIYVBXZTh3NzhPdjJ6eFVGVzd3REpMVk9FUlhCTXV6R0ltZGRrTXcwWURRYTFEdHFVeTVmVzBLWjN0MGp5Qk1NM2lneEwyWUhnak41d3lHNFFkMFJDZGFYY0xLWkFvVXIrRzJKZTJLbE03Z3dDTFloQUFvQkE0TW56S0JCdDEyUGVQaVd1MmN3VkkwZzl5LzgyT082V01jTlkvUHE0eUtZRDUvcWd3RnNzUUpXcXE0V01MSlhYUHhHZFA0bFc4ekF1aVVldFRINktKaUh1OEFFV2ZwSmhvYVdjeCtoOEFwOUVCelAwMENXV2xXY1QzVE9VVDNBcmRtSVRJUmJOMENaaFZMaGlVM1FXdnBxUkpvRmFCT3diN2NkY0pEdDRuSmVaZnVOaE03RGJZN0lUZFlaUytSU05uMkRlYWJFUjhsbWl1bTBIMm40MVlPTEVCZ1dLa0xyUFhwSk45b0R6T1dsdGs5V1ZlcSs2cGdsNFE5VXV0b3VOcE1uaHEyN2FPbTJzTmxUV1phQndVSSs4VnZjZ21RakJ2WkxHMHFpVmNrY2YwdFNJT1U2SHJiSGZRc253ZGpLQk1NWVFMSUxjQW11elZRUDRpWklxeWdCUEVBQkJjdlliaTRwZlRKbVRnSEcwMHptVGVyK3dkN09KV0c4MG5jTllBZWd2R2NKYWxscnJ6QlQ4VmVaeHhDY2pHbklEdzVodEVQVTErbTF3Y2hTbEVhTENlUjA2NUFjZHVhNTVYT0FRakI1Y2R2WmZrVXVWSWNzekJlQ0ROUjRiUGRPN1U4d1VJUjFBYlBpUXV4RUoydG1weVJhbTRTOU0velpBTks2V0RXaW9qaDN0ZGNJNXBhRk9PUjBYTERWMElCR3dudndrSzNMNjZmRkRIcWtTM3J3NkxUSWdmSWpkUWlLNGVaYzFFUnM0cEw5NHgrK05YaTdreWtMcWtsMWJtNVhDOVJyMUFzWVUrMTFZRTRBcW5uRkxVZjFpeXVLL0xZb3VKNEtVUVN3MzFsYkFGM1Z3bUFxTi9tVGxnakQ1RFR4cEVKSjlQTDNYR0lpUHp3ZWNRdU9yUHdjS0xnWk5WUzZoanpaVGVGUzlJcTAzYXJXaFREZFk5VERYTFY4ZmFma3FvOXN4OGN6elpMUHRtWTd5MzVvclAxRlNXOGpkUEdBWXhjRTM2NzlNUnpzL0k4NFlsTXNmb3RoTDlkMU9KbkFsdWZ0S0RXWnd6dTBlajdDKzhYQTRTR3BzMjZESEpieHV0TTZWTFdaakp0dnVvN00xcTV1aVVmT0czckxGZEd2VVhtWGZDZm5XbEhpa1hjSWZzbkUrdHR5bXBjUW9WdUZVRi9HbFJyVGVtbWlYbFZvQmdiN1Z5NWJPaXR4K0pJWVBaU2JadnhnYklRTE45MjZBOTdleGxVNWtraHRsYVFhZGRraTZmTWIzTVpiVFdqYmpoRmZBZ21mSVNSc0lZZ3ROYy91dU9NMGUvZ3JrRDc4Q0Urcks0OE1WcEJYZ3VaN240UDhRYklSU0ZVK29nb0JGdnhoRHh6S2NGSGp5ZnRaMVduTXRhUlkyUHMxQVZYRUlGMElRNFdlOGN0VXdVakZnTC9uTFZSVUFIaVZxdktLbDdMWUdGLytVbERQbXhlc20vVU1DdWI2c1BXTFRUT1RJOThDdCtrWnllellUOWVtVURqN3VIdEdLSExyWTNQMjRJMStkeTdhUlBJbHBLY0NXOTBuK25teEVBbm12NGIvUG03VVdHYUlJUERlWXRFaDQ5Y2U0Qk5TTmNmUnZUNTN1c3Y3Z3VIa01FMUVMTHdOUTAwSHIrc3oxVjdzRjJoYytyN2l0amlhemppSWZzb05GMjFid0V0SnE4ZE1yMllJbXc1bDMrTnRMU3JnVCsrV0tJWEdtaGJMd3JYUDVvbGYzckR1QkhiRFMwTjhXMDQ3VmtOR3BQRmZ6bXFYMUhlSkErbG43Mi9hN3BONG0wYnBvUEhpOWVlK2NJbGRYUG9CS2l5VVpqSWhPZkdHeXArQWp4emVDL2dXZ1M4bkNIdmhKQnhSZzBDb2NzK0RqeGdaRitWT0VlT1ZhdW5hb254ckVZdDE4TGZtWklLL2duQ1o1akFicUp4UnJmSXFjUTJmdGZtd0lHZHdTclRzVHFBNlJ3Sm5lR1pYMEtqR1pzUUxzc1RnZi9VZEFqemFUKzg1dUk4SGtqZVljQ095NVRMRGxwSmIxdmNLbnBMN1A4dVBDeGxZamkycVlwNllIaUxxS0lXdTlseWFvN3ArcDNwcVN6SkxWNFFVb21qVGpKTWhxZ0c2Z3ZPd3hkS2ZnelpRamdwbHErTzRNU1lXMWJIditHYVZDWGEvVGEwR2VVaWNCVFVIYVZPMTlBTGp3YVAwMi8wVngvdGFNQk9uYlgydFk4b1JraGdjOGFTYjk5QWwrTzhBTCsyQ2ZYUjdMZUhjMkhCYmVSUllVbVFlalA1ODJYT24yaFo0WU5hK1Z6eFdZZmxZWW1lY0JlOHhxdWQrNTd0SjNkeHJqdmF1WUJNL3ZvNmQ5YnRBOG1ySW5UU0V2aTJYWjM2V241Q283VFhMYlRNbmhFaGFaV0VWR3I2cXhlV0FxUEFzTzNqejc5bVhSMWtua2M3Z2tQU0llTmZNNncyRVQyV1NGVGR0Wk9YZ3k1dFl4dThZSDhIYWJKQUFhejBjQVliOHN4NXdNR3VTRnJWREZoRFJuUFNBMHBFRWRRVlQzOURqMlhzQ2NqUzhnMk1YY1VxdnRVQ0RMekpZVjRKUVlEY0JUSldKUThPQ1VQakx6ZmZ6R2l5Y1ZubkY4NWpIaDVQc2YvY3VFOWZvc1pZdlBXRnhhV1JKOFBBb0ZmbnlZQVcrV1NvbjFqeGxrK3R1dGozNEpYbEhzbUM2WUdjazVYWGlkK3F4dE1sSXZjTjlnZldtR0JBSjNkcGJON2Jia3A4Q2tPZnlhenZQdnJPOG1WNHRKZFVCOTJlSy9QdjAzVU1lK2FCRkxOdjNoRW1RUThDZkdWSVRFL1g4dlkwWG1icTNDVy8rbm0zY0p6dTN2Q3lxNys3SkZBbTBZMmgvelNSVmNBNnlrMXpVcHJoRjFaQWxXdXNtYTFaMU5pNHZ2Q1N6YTQ1OVlneWtKSkxlZHdJTStpWUZoZk1GZFBWSFlORjRlZXF3ZWR2dlE1OENLY1hsdDM0R1V3cXlycmNQYkdSQ2pvMmR3MjFrWFZKeEg5b1lZSlhacXNkVTZ4ajJOaHQxOFRRUGlxM1Jsd0tNTlhoTFlxT0l0VC9sVFE0WVFMbVhEZG9SZm56Sm5la1dweFg5dDlzbzJDZWw5dFk0Z2dlVi83NWlBekVPNTRuT09FNEIyQldWSUJZUHFEWTJNc1AwNkgxWGFDUWIySUhzNVVhREcwbWQ4VGhXWDQ1NU9Ka3UvTHZ4WFFmeW5EVlhCVi9uaENUSzVGNWRFWkQ4aS91ek1vd2VCNjZBbXJ3bkNTNnh5djdqc3ZQRnVUQU1Ud3FRQ3hjRXJzNzhnVmRONVlzanVaNGxvQXlRbVNSUWN0dWErNHJMY0RPODBiTlVhT3l1c1FFd2J6ZEk0SHd5M291VmNFUGJxVUFtcmYwZzJjOEdRUHJUMnlDQW9RYmdpWDNudkNrc1R6Z2hDVDNKb1FHWC9WNi81a2wreEhWNk9HcnRhc0hkOTN1MkRCL0tDVjM2R05UMC9acUl5Rk1BYmRmWllhQ2s1emdLUldJQWtoMGZmRTN1M3MvYWdCcmFjaTBTQnYxclhQT2x4UG5xYTVhaG92R0VDcitORzA5ZHNQcFpIaTBvOXdMVkRlSTBlVjdRTmhVQkVOTGlFQ3NUejBOcGljRk9IYXFUbEo3Z2hURk12R1lGUTRudzIvZE9TVzlBVW10TnIzdzQ2Skg4VVFyZGNmZ0Q1VHl0MnRtVkl4SjZIT2h6S29ueDhkN3hpNGIwa2dEQmIzdUFOTFpFSC9PM2g3bXhWSmg0UEltbEEwajJBc0pMM0tST1B6U1RtelNnajhqSTJWWU1DZXlJd3NSUER0cEJ6WXNHTHVObm50M2VLZkFpVHJ3WDNjb2lDRHZqVzcwdm9XcE8wMmVOdUt1QldYR3ZPaUk2YW4vNU1KR0JaNEZ0czdXS05pcTdGdjFFclRBQW1jRjlzZVlXaXJVb3lvVGYyT2NZQkVQWU1iaUlTNHREeC9FVVdMKzJVL2crMkxKUU1MM3dGV2pSTi9DRUZneCsrTlNuT0JvMlRYU0ZpRE9TeERoSXN4ZkhqN21GNmRiZE5tZnNGZmJpWGJPaUdETjRIWU1mWjlRWjAydCt3K090TnB5T29oa3hHci9YYTdRK3NnNHRMdDh0YzN2YXRQMjlwRWxVZ2tjbFZDY2pjaVBETENHVko5K1lpRVN2c0FFcEVscHAydnRsN0VyRzZxQjhSVXF4N2JHLys4dE1GdTNKbDU1VWlGNDA2VkhPYTR4UzNHMDdkcWhzV3k5aFhjeE5zZUhsM01tWG5VTGtUQjU0RGQ5NnFPTVpLVm9aSWQwWHFDb0FwZitLdk1rM3Y4d3NUWFpIOHY4VGJrWkQ1V1ZwR3dsT3JGM2JnelRjSFk1QXdRcDVaSUN6OEx2ako2N0FqeklyNDdwelR1YXVIZVI1dS9nWXg4WE9aOVZiK0RIRk52QVdBa2ZYOWxyT1hsUEJaNWJnOHZSZDJXQ1ZoT2xPcTF2Tjd2VFpMaVFEdDIyNjZFeE8wMnJHNmxCT055elV4RFhBWmpDZUtVQ3Bod05mMEZ5bTd6VGhIUDBpMFRTZjFZZUJWUk11blJFRExBeDhhYjVOMHRtbUhnQTBDRzBIOGRGRzlSVThRbmpNRzFJd3JFVHBhaG5WNWFueXdJdmlWWXFzT3ZCMHp3SGloYmlGOGNpTXJEL1dMM1FycTRFZ0xzZmdaV3FxclJoN2wvb043U3AwMmxVWjlISXVEZ04rS0tUSXJJaGR5dGdNMU9URHJEaGkvT3hocXJ2MlFaZzNlZGtBU1Q3R1JGMDJqL0J1c2Z3blpLSzllMzIzb0ZkSHNYUXB3NkVzOEZKMHJibi84RnpnK2taZVRpdDZxRjU4ejg3dUFvc3M4OGR0WHBzMTZwaEtEQ1JJc3dKU3VOOHVrNWNQQlYwQ1YyMzl6cTJpMFVuWkowT3lMalAyMWp5T2lmN3RIQXpwVGZkeWJ4RU9tdmpQcjlQdTFRTUFnTTRJRXZXbFpqN2gycFhreDF4UlFiU0xLdFZ3Z1pacExNYVQ0S09LZU5nUDZmVytjQ3JpRXMydnZyemd4OU1lakZtL2ZTNUtOSDJROElRMmJ3UkNVVHdrRWNTM3pkUnhPdUFwSFRaUTVIK0lFWkRTUGk1dVErc3duanVpaWtFRHZJVEhZRXQrQmpUcVNFU2JFZUYvMm40UHhSMEV2MGtKY3FnQmV3V1BkOFBvQ3BZMkJjOHFiRDEvNmpaVit5aWtLQ1FCb0RLVGRFYzdVcit6Q1l3eDVwN3ZFUkgyczh6VThNRXA5SFhTNW5uZVRkdHJjQnlLbGJ3eEs5VjRmbzBHblltdXlaeEQrNitJL2lWSlZpK2lVOUpUVkdjd2JHdXg1cTRIYURoUExSZk9aNjJnMmxXdU55RGUrb3VQQmkxV1lBSXU5TEtsRjJDWWtySTk0SjhrMEtzV1BxREZ0TlRVUk5PYmVHKzY2bkY0QzZqbU1iZzVQVVFhbnREd3ZXZmp3NG1qa0pjVmJJQWtoalhJVkZGOWtZcDBQc2hBcFc1Z0NmeEh4RWZQV01BdzJEYThKL2RkcFJydXpVYmc0a0JrR2dJMkpYWVZEYWZFMFFKTzF1WDBvUG1mUTR6TDhkRkVoZ0FrQ2djMWZIZkp1RnZBK2FBSk5hbnpVVGJEa3ZjOTBXUk1EQktwcGw5aHQ3cXc1bTBUaThCYTl0RW5IWCtld2pYdm5hRUZ3TW1aWGtKRmF3R00wcmp4MGtkblhITXlzSWJybUFZS1k1YXQybU10cHMxRHpmR3NqUjQ0Z2ljNGIxdjBHRGFEUWh2d1lsQnZLSGk2djJRcnB4Q0wwYTNqUjJXdzliMG12TG13RDR3b2krQUxoUDlaVjZHeUlEUGF0TGt0a1NKQWI5ditLVFdweDRRR245NmRFSGduQjBFelVuUzFTZUoxZjB2cWdBSjhJdVJLeW5YRUU5bTFxTHhrNXNpWkFkenhFcTFIeDYxZlhsV0ZBK1N1ckUwRGI1OGwveEVVU09XL3JvbGM1amNHQzZON1dyUWFnWjkvd09nTUxsYWoyMVhYdTR0eHJEUlBHdXljMStvNVBPLy92OVZkY3cyK1BidVdhbEFCQ3NxQmM4N1IvK3VhRWhOb09jU1FHYU44ZE95KzNQS0NkMGc2NnRWN211czFhSVhvbjhBTVlCT1ZUUFJDcThXQ1hCNkU4SU9qWWxrcVNsd1NDU0FsYXB5cmtPN0VvUU5WVjhsN1RsS0RkQ0NwcGlXRkp3Nm5RczQxMVprQnR2ZE9EQmRTL0Z6TUhNTzU0akdBZlNBRFRlZ0h3a3FjS3lWUjhlSi9yc1lkN3RXRVhRSFErNk51S25GN0lNWjFBV0RtUEcxUlJ4TW1NREhpV2V0TEo2dW5VbmllWUpoUnNZNWFDOGM4MGtud09SU3M2bWQ5bTROMUJuZExiMzE1Nnh5ZnE0MHFVZlFienluVUgyWTF6Z2dmc1NpSUJyejIvdXRoY3NxMGp6ZEsvd3h2UGRuQi9JTFg0REJPeXFGMkUwdEVMcldZSUtrN09QUmpZZTl5eFBDRVIrUUcyb2MwR1hDZjN1T2puRjRpNEo1bHRicTFja05yNFovOU90dWtWKzNiZXBmS1hhakpDczBqNSs0OXVGR0d3WXFnaGdCbDJ5bHIzdTFEWDNkaytmSUhaRHJ4b25tTTNPR2Rqc1NZSzJjZGNFcG9na0hWNTRKdFlBb043ZG5CRk8ya2dpbDljNEp4VldZcXJLMGJCKzdYVVFSNFZsam5zU3g2bDVmLzhyamE5YVFxcllONG5EZ1RQN3c4T016NTkvU1gxSmJtSVN0d2FNdVV2OTFmQjY3UjFwZGFQOWdIOXVOTVoxZXAwWk8zV25MUFNQRWo3U3A0VUpnWnlWNVQ1WTZNU3A2T0ZzOXJyTGxXT0MxTUdFL1pxUnI3WnMzRk9KK2dHOUlGWUJXZVBLMTU2VzBNeUE2TitmMzJWOHBDR0xObWVJbDBIclNsL2wyNVREd2J5dStWeTdIRTdrVjZxZlc4Y0JPang5K1k3cXRxM1ZqYk9jaWI5L2JjTy9jbWxqdDJKeXpLZzBCaEhmN0xpVmdaRjNld2FaTDJmLzQvODIrT2ZhaVFUL3QxMUJyUHpscHFlV3gzNDFMcktuWUNyZHRRU2RINWVPNno0VGY0RjdYd21HUW04NERRUU94VjAzL2I0a0E0NWx5YVNVVDNqbDNZSWREeFpsK1BDVFRuaE5NZTJhSWFCS05XZ3dGaUVNSXAveXhrcnovTHRJM0h6c2RMQmxUcldiYU1QSlhURURkSnNGb3ZnODB2djhUdDIrUTlUSnpiNDF2STFvRnQzSEdRUFNQSEkyOUFZSFBzYlJXYWhkK05EU1BxME5jNWNKVnRuL1lWK0toTllmbUExejY4RWdFSjlCTjVVR3Y1Wmt2cnl0R3J5c1pOamwvY0tqN1k5bzE3c2Y5azJheXgzVjAvOUJnNWxLMzIyODdDdlByWll0RXVkWjhOdzcvSWJaaFpFVHJ0SnN5WDIvNFMrZkxCbkxYVnZkcllucGVNeEtOSUs3YmZiaHIxenIxNWN6YUJmUUxYY1RBaExyMUlhZXduVjJtdlh1ZHQ5dEMyVGdYbUdNTGZTUzkyT0ZjQnBuRU9mNkh4d1hNYndJTlh0RFJHVWpvRkF5RHc2djQzcm1vT3RDZDdSRDY0SktaeTBJL2F6anVBT3dBcTY4YktVMjdIOFdVV1kxSHc0Q3FvWUNzTTBPU25DbVEyUkU2ZkN5cjBrd3gxY3N0MmxKZzE3cjRYeDhkd2RvRTUvdC80cTgwOTJ4KzE2NVovcytvL0M4bVoydFRTcU9ZdS9jNUZGWVptVVNrakN5V3FRamdDWjFHQXRJUUNpcGxGMXNrUHVrMkhlRElUa1FodE9DTWZVT2JraG84Y2dMQ1ZuTHpuV095bXVkZDhWSm45QlRWU1FLOHJucXlrWmM0Mjd6R0xSUmxxSE5tZVZXSUZkSlYrYUZPOGFUWlJpSFAxMnRCMzVwR1hiUXI0dzZNTC9SblN2c3F5U253ZmN1UWRHc096eWt5NjdScTczQzVSdyt1RmJ2eFVXN0F2U2Y0MGd1VHlBL2ZSOFd0VEdhVVpqNXRBRmJsRnA4UmN2TkE1K3lNdlEzOGtSYnlMdEE5RGtOemhTYlBJU1QzU1UyUGdudnNtUmJpcXh1bm5vQVhkdkJXUHBwQUFBMFJyaDJyTDNPMVdUaXFvMTBUTGRvakcwVy9WOGpqa29TU0ZPc0hMQzVGblNZSHpOSzk5RlQweEF6aHZJdjR3ekNzL1NuS2wzUGFDUDVSNDZYaEZka3VrSXRoVUx1UWh6ckZKSXNnOFZ4aVQrR0tTQXhiazAwSkxKSkZCL0FQNm5aRWh1Y2duMG1UZVVUdld2UG1iR1VOaW1mV1I3eDNocEpYYVhIRFB0OHRqeXU4QUY4TlU0bmJSc0huS3ZXblZpaDlUQlhZcTlQNTJSR2UwNUd2aGtBMk9mSFZjcG90RE1ybzZPYkV6d0RVa0JBbEMvMGZzck1yM1lDMSs5djczTkd2ZEd0VzBJdjh0WUxmazQ3OWxiTk5FNE1yODBCdVE5anpYZEdEb0syUDR2ZjlQS3MrYTg4ZzFHVjRtRWVVK0c2cXBzcjgzY0pTRHQ0ZUJ3SnU4dms5ZThzNlgxVHkwMk1LWm5IVEdXMmd4NEFiMGUrbkNWVFlSb3Y5RDFxa3Vrc2VBU2d6R2FRZTNYVThJZXFEN3c2RVlEeTNhNUxONnh1eDRBdmlSNXlJMmhyNWxNdVVMZVRxYTgxM1l5ZDhFbDcwYWpsUytpcXQ1MEEwdHpZSThMdEVxUStOM1dDOEJ1Y3JOYjhqczNKc3BxK3ZFLzJwSWlzVzdWTnpmZlFKR2N2bGlpYThkazBCa3pweFNRZ1NqWHpwTWZ6MlhIdm9DbnZxU3E5cVVUbThvcGhzRmo2a25jZW05NVUrenpvVUlZY2lvNHJuVTBFdzNQVEw4QWlvUG1UZ21PY3F0bm4yeDlCVTErMTcyZkdEazFyL0VZSjlWMEhTYTJGRDdSaVBQUXc5TmMrbHkybnRTSDFncENvZ1BZM1Q4aUpHbHhGTzlTc3ZYZHNwei8rOGdjamJaTjArQUQzM2FWTDFxRGlHL0NjbnVIeTRxQkxzV3cvWTVMaWVLNS9jQStFYVVzNDJQWGxEdzEwdEVRaEQzU3hwUVhhUGpJTTBGa251Sk5HMWhXd21iN2R5eFY5ejJoTE1EQVpPRXJxTUFXQkdwWW5peUVmR2ZZWHkxSlg5Z3ZLcWNLdDBMM2M4UktXbkUzNEFEdno5ZGU0Y1ZWYUlXMnJnQjUrcGRhSW9wdXU4c0sreG9uUnBIdWtvQzFOMzNUK09vTGRsazVhVEhUOEJWYUtISzZuM1A3U2U5L25QV1loSXBlbk53U05PSzVma3lyOEw1WFZoMUVWSU5pWm5mM0VFa2hSeEFqY0w0Q0xnTmtEdHZSUnhobFBxcjlsSWhmUWxHN0RaQWdRbzU5akxKa2FTT1hENkk4YU5yWlh5VENObHVLY0N4NmZ1bGNKdWZKbC8zWTNKVFlYcDZyMmx0TnlIckg1bEIxM0d4QS9VZi9kYVhLQ0J6VTJ0angvVGM2S2dnbmlLTGV0UGkraW5Wd2kxdVVTNFRLQUFyS1VMMlBCNnNQeXgvRFE2SkFCU01rZXpaQm1IMmtxS25Eb1I3S1B5endqdXVUWHpiRjBVamNDMHhFSUJteTc1SXYvRzBuRnJGQWRpTjZ4Q1J2SElVV3ZYYkdqNHRZVVdOUDRUUlZSeXpMVzNWdHphaTNYWXVlV0xNc3VJbnZSMmovT1dheEhaSUE0b0tRSVk2RzErVXFSZEU2TktiUTZFTDFxWDNZcGw1Nm1BUjBKSFVVbmJ1WGtvcHB3emJXTENoLytPRXpSMGk2ZFp1b2hUV0dLSFkzK3pHRzNyUVFkTlcybEY3QkdxU0ZCcmVMU1hmRyt2MStzOWFTM2dYcmVqVnBlRk9mK3hXN1lIVWoxMFh1Zml3RXVhb0RaWGYwR0dyaWxPSE1MeFgvQk1DenhuazcwVFpmTTl6eDkrOWd2ck9QQzdZeXg2YXJsWmVSMy8vNUZ2Z2J5VjIraEdqNFJyTUxoaVRnb2xiRzFHZXFSL2hCaVB5UU1ubThQQS93R1lRaWhsL2l6b2pKZHlhTlM3ZFZUbXltdTBHUTZUY2J6OGlUVlNBaGpLY1Q5dm43bUhkQzkwMmhIK2FZZnhkRkdwckM2dS9qeHJmLytzaHJzdmQxTnl0VHhpU3VjeHZDbEZQUUtLRGVMd0VqRjRRVlpkS25OS3JlbjlsMkM3bGZybS9lRUdOcnRTR0trMHYxLzVVOTlGNVZza0ZKOHJXb21pTDZnRzVyd3FMVmtINGw2dUc2ekxSaE96eUpWMmdMMEhGNGtOcUlFSVM4c3lpbXdvSzBWSjhnczRtUWZHK2ducnIzVUNQMWdKeElwVEF6V1hRbENRMlFWRHVTUlpFdVF0Rmo1Q0dkOFlXSTJhOXkyS0JTN0oxaUtKb3ZGbm5oSjZkbkNKTUgvSVZvemhRU2w1QUpRQTBiU3ZJbVBxTUd6KzVhampXN1laYkQ0U0JlanhOZlF1K3BBdVl5blcxdkNzVGxpdEgzWkNMS1VCaWY5WWgxZHVvc0pYaEhvRUc3NldsSmpNVm9FalBWMm5CVStXVlpDY2VZZS9ySC9nSzNVYlFPMG5qZFBDcTc4bXkvbzZTTE1FVTNQME1lOUo3dzF5SytSSzdUMG1CY2loS3ZRK0JNMXFDSGxyUkkxTXpuN3A5MW1OWVd5MEIxUGt5VVp3NktlZDVrUElmbmlzMnFSNkxlT1g1NkdpUlM1cVk3MUVKb0NiTlJzY0ZzZTl2YlE4d0JUVHZKWVdrNTFQMGJTbFFzbmZPQ1VaQlRhSWNXUFUvMER0b1JIaDhSV3p6QjdtZkZ4SHQyR0l4b3hBbVA5TXE1OFluZE14cTZicWxNbzh1SkE5RkQ1T1cwRlBHNCtCUk9hZlV5NmVrMi94OWd3cEtzNHE5dUhLQzlBeVZ6UzNrU1ZlcFR6aFNmZjJ6SWgwK1d5dElRajVjK25uWVA3MHVoQnIyOHhzUW85VG9YYjNFR1pyTXVzcmUvR0tSVm5ZK2tGd2RoV0VPUlVJa1Iwc0RzM1U2L2RsN2xRYmNZL2EybGY2b2ZYSEpPOEVMZVJ4SERmUURtUEN4ampQcU9JbkpHR24vSnFXYkpIMzVsTnJmNzg2SWZjb1hkcHJOcTJ1RXdNbGREZ3l5UURSNHI0TTg3WkJoS1V0aUZsVkRNUzFOUURaRGo0V1Y0TWovd1d1QlJPeWlENm5lOTVTTEU2dHREQkV2Qk13VFZtRVV5WENvV1Q4dHQ5Tk1RUmtNa1ptSHVKSHA4R2NWMlNlSUNzRzI5a3RWQmlmcEFCU1AvZnJQcnk3c2NpeEZJVnJMMytralZtL1FwUXRBU0ZlVmJTVzdUYkVZcUY5ckVDdGVpV1hSR2F4cWxVd2dackRaSnJ2RUNLc01MeXJjODlDNVJ1UlVZWkhENmdRbGc1dk1GclRoWHRRL2xycHQyK0ZleStyYVg3cUVaTHR6b1NvV2IrU2FJeVVhUkhZQVpjNnh1V25tbDc5ZEdDT3dyYktJODhxTXV6bUovTjI3R1cxb3R0Rm5ocGl1YlQwc2RvK01JYVlDSGhBa2tJRnI3eTZmNWU0Ri9iUVpLaWxZdS9DQzhHK0U1cWxrR2RoN2NhNFpDTWtuaTd3SEtpUkNBdVl0RGU3dEdGOFhhY1JOWGtQSTVGUGtRelU4cVRYZFpPMm01bVBlNUlQUlVuVkE4c2p2Y0pwQlJ4cTdlZ1NKTlNxQUMrSkV2TjBzU0V4dHh3UlZwbnVVOXZhd29PU2dQUlBiVmJzVk0wd1c0WDF6eE5JRDFjNGZicFdIVmN0SnpGd3JuZTY3cXArWi9SeEVZSW4zclF4SCtoanh1MXptdnBNWWJ4djRFZlpUVVF1UllxdnA0MjRaWlBWR1lrMTRPNUlsR25XYjVxaGZqamRNM0IwdndlWWJXRXdBOEdxZEJtOXN4a3hvakZTRVAvSmcvczFCckJMMTFnT20yWklieHppb3pqdGNKRGNsSmNJMWM3eFFGTGxwN1RTdndMb3FDUThCdHRteU5MTFFZbVdaU2tlQVhKWnh2K1NQNG1nOHU5TERqQ0poZ2tTOEdnVmM3WEkwajE4a2FSZGV2Smc5S1pYNnlJR1Z1bHFkOFJvUm8rU2Nhd0NRUnVPQkcxNmc1MmhCL2xCSDhaTERsTTZGWWlJVnNBU1NMUlloRUZ1ck50Ky9tbmRZNGl0WUc5ZDg3TU0vUWhsbDZHMkhKUG1pdUdKR09sekQzSDl2dVVCVk1sSW5ST1RTeS96amZ3UDA4bUthOW1EY2YvTzlCSzR0RTRmREFnNi9QN0JFS3pORklNNm1QOUNoNVNaNmZhbitzcFBiQWxkL09RZ3FuVWF4SGtzS3QvaWUyd3A0QUIxbS9rWDdGbFZ6NTU4eEVJZFlmVzVkam5ZeExGNDJZMTVwcEhZZ2R4aU52b3hjR1dXcEJXQlJiNTM1ZTNHaTN4YkNFWEhBaGRSMkdyOFJvOGNzTldVTTdURndUcW9ONWJNemlLbmJncVBQTVFSczRUOFNLZnVORzNwblRtMEwzbGRiSTA5YWk5RTloWStGdS9zWEMvNHh3MW03bHhxTW5lUFY3ZjRreUVvQVM3WTcwRnJzd3l0RmJKMmVzcjJMRnhxU2JWS0l2Vzc2QUw0Z3RUbENIcnNPaTFOWEU3US9RamNyZk1aYXZXdUlKS3pwR0c5bEFFQURWNExBTXFIWmJqeDJHWlNZeXBINnU3Yjk5clZxOTVNZU9tT0I1eWs3bmZOZncxMlRoaVdSVjBNTHpnei9PZExucGpwQ1YwUTFWN1lCeVZMbVFNckkyWlJGaDB6NDhVNURjUnRmaHRRbkdiVThaOGRsb09seGpFY2FkZ2N1TjkxMWZnUmJMemY3ME5ib3JMNUIzYVFQZ0xtU3l2U0lGcHRWUTZ1UjJYM3ExK2o4YVJOdG5ZaFpaQlB6MFVNdTNwYys0VytrVDEyTkRCV0k0T2YrNlFmc1k0ZTVBdkRQcTRxbDR1M3FLRUV0QkdlUm1oNm0xcWpTai83ems1cVZVMjgrZ2xJNW1LMkQ5dGc3dlB3RFVLd3oxNTk2VXUrNTBML2xpYWQ0T1I5M2hMOUdlWlpOajBwWE9lUGhmaWNYREEwbWhKd3RkY2dpbk40c0hJandqNDZKNkQ0NTgwN2dQczQzOHJUZ1NRZHdoRlZwR056d1ZWS1BTTHJnQXFsVU9UYVNWTUxwMGkweitLVzhwMWxPQUZ0OEpERmsyMktZdDJmaFlxaTVpM3lDSDZzWDFXSlNIa3VjTzYwNXdQcDMrT3NEOTZGTi9IZE9aYUdaS2puZWFnQzcwMzdnakFGNlJBYTF5aFFaMEwzQlFVVGJmSGdXNFNDTlJjekVZZ2dCR0dwMFFBZEEvbUJzTEFRQXpKc3FNYmc5Qm5PYzNheUJDUjA5dEsvaEF0SUxEM3ZBMmg5eVlzUmh0a0RWV0ZZUWMreW1xck5aTERDWjVlYXBtRG45NytrTUdObW8wbDNZWmJiQU5Wam9NTzhsekxGK0VGRUtJMGxmVVhhTXVCNi9UNGd2Q0ZOQVFha2Rob1Bwdm84UGgyb012S05Cd2p0MjRDc2lvaTljcFJwd0RRZ29Fdk1wdS9FZzV6VDU5a3hhZXZKenA2U2VYRzJNa0h2dnpFUTllblY3NllObVlBbldsdk52ZFRjVEdwZXUza3lYaHFZSk9ueWdMTk1QZkd5MEtlanEvTWJFTU9sK1ZNcGRoQzNTaSttM0NneitEajJWMjI4NXd2OEdmb3dJL3ZqWVBhY1lvNitWZ1lqMW44YnNRMmNBdjZwUGtnajJaMmViVUVSODhyNENYRGwvYm1IRmJFc25XdkZaeEFYcWw1Snk3TnpLR3hpOE96cWpORlVpSGxqUTZqTEE5VmVIRkVOWTVCVGpSMXgzWE5GQVZYdXFySjR1R0lMTERNdTl6REFlQ2pIRVg0NXczU3pnaENwbGM4ZldHSitHWmtrOVFqaXhDWG1BWW9TZE81eng3MEdNeWxvK2VTWnhPTi9xbDVuZFg1WmIwSDFSUUNINjJBd2U4K280L0R5bzA0WlR1SGJ4YkxqbzBTR2NwMUFzMEEzNjF1MTRzQ2hOenpoVFBBaXhDRkl2ZWlOeUN1TEJyMHhlbVdHSVpVNjJuZTFFQS8rS0YxN2hWT0NEQWN3REwwTUpWNTN2MDJtN0FsMi9Cd1hTZk9SUW8rckNkaHZ0Sm1KUG9CNGMzbDNXZXJUU294UFI5M0NtYmdFK0NSQjFSSjgrY1VMSjJWNmNaeC9VTXVPT1hDdi9XOFRnL29UUzFuUy93eGFudFhPTVAyaHZGcGpFTExoYTRqL3ZqNzE5Ly9DMUhiRzMvczhzaEt3YlpzQlpCcVNpT2FRdERlV0NudkphMjJKTCtlZ3BWNzloNXZFTWVWWDZvWVFQK0xOTDQvYXZUUUlrUnZpRTIrdEJNSnE0czBUemxkNzhyRXZCMFhzZkdsU3lRaW1Da05mQzlyNE43Tng5NDUwLzlkREZWL3U2Ni9JelBxNkRWcjdSSXBzNkk1K0hWUnJtK0tMb3B6cFhyWmVMaTRSUTVPVEt2WE5GbDMxVjVxT21SOG9EMEFqS0VjOFh5Z1NmZ0JWRmNRWU1wVXlXRWlRdlZJQlgrV1YzQUhtZ1hrZ3hyNW1mbEM2V0huaGdDK1AvNWdiWklaNE90RUNXZFY5WXlCVnZ6NnY2OEtWRWk0Yks3aU1MNFBreWdnQjZBTWUzcm5OR0JmUHdKRXFVbW1sRGt3cE1laUVIYzJlZDJyV0Q3cWkxeVc1UTVQMytPeXF6QXFiYzN4anZNNmg1Z1Z5YkVKK2d4QjUvNjVXYVozRzRlUEdoOWJOaWVoaVIxTGVTZXlOeUVVZStYaHNhVHpFY3pYWHZZNWtMUERoT2REWDVOMkVucXpmMXRTUnB4QjY3QTc5ZTAycml6MlVhclNTWW9wS1ZuaG9RbVc2Um83UWJYSEJmWkhUdnBFaU5PbmJNZE42ckpuOUxwVmlHbjZIOU1vOEwrdlJxNktROTllMDcvLy9IeElkUGpyajcwZXAzWEcybW1sWGhGWVFYeUltY0orNmVyZnBER1ZmUFMrdEtVUXRYMkk3WFpFMm4xMEttNkNPbHk4VW01TVhqYlN5clBDakpIaWlkcURNRG1PZXNoaVY2KzNpQjhJb1FabkhaZU9tUkpaRjV4MDJVVUhleVV6cTVZMkQ5UEcvRWszSXlqNlNyRkh3VWJ4dW50YVRWZkM1NHNHM3B5eDN5SS92RlZpS2pTeENHWmlYK2lDdThFQTRma2tOZGxoSmJOaDA2NE9obXo2aGY1QnVHWnVHbVZlRlZYUUZsM2ZlWHkxWUlQdk0vOGJCdVNQWkZCVmxZYXlJYXViK3FJa0taMEN6TGhnWVhsSzhGMk42dVo3MloycGtMLzFxL2dyQmVuSHFPb2ZNeURiM2c5aFdBYU1sMllmTThXSWlKclVWNGtJWE5wMGFmRkIyT0drcTFtMHVXTEFkUm1nVk5GNHJmdy9qN3hLSzFuT0hXTUdVakk0ckYwSjlqTGducytZc0dvTVFBNzFjT2NFNjhKWTAvbFVLODYzTTVHaytQcEFNR3cxa2FmY3pQWkN1V2FNb1pnbS9SQ2RuVVJYV0E0aExIRnN1Y1gxMlRzM01QSHhmL1Jpa1BBcHFRZWMzYXUzWW9LZ2RRNVpUdlNyL0h3K0h4azExUXdWN25BMFRMM2g5bjF4eEVURzFzTm9laU1UT1M3UUt0cUV4TGR4N3hDNTh0NDc0VXRqYjhld1JlMk0yL0J3Z0h2QThtNEZaR0x1UW9qREFqZm0vMDlkYVVYMGlhOUF5a2lxVU0yUko0L01BQksxQ3U1d1JTcHFyL0NQMHE4UnBnSktzTUVML2JlNkxYVSttQm1pZ0xSYWtYZE1EMXNBRjRqa1ljZzB6UXB1NTRYM3ptQkRFWVAvd2lJZDRlMHNqanRreVpRa25uZkpvZ0ZYM3pFUTAvanZ4ZEIrNWtMTVU3QlQ3RjFGN0N6eUhsQUxFeDFwaHJzR1dwVUp2L280R09VYmNoR3BVNDdmWDJFMUNpT1IzQTZkOU9KZTdiZ25TbklkOTkxYVBqZHBKZEFZQllOd0F2cGp3cXhXc3l6aS80dTY4UVBsQXBQZmlqbEFrR3Zkbi9zVjFQMlU5d1hDUHl5RThUMm05Y3VrUWF6blJ0SkZBK0NsQ0QrdVpEL3ZVb2ZsZDVWMFo1cmhDSWlXamJGNHRwQm43VUFObFJWcERZQlB1Z211andZZlBpRTNzUXlEMjROb1lBNDZ2K3RVRVEwMmNuQ0dhRzJmMG4rdWJBSktaeGxvMHVHVDRrNlZDRU5wZjFCYmhNK1VLME5jaTdBcTVlaUtjbktaL1ZpUFBGTVA0T3NXb21lSFh5cVZOYXZ5b21QR210c2lQc015dnJvR0VObDhsOU5kVy9yRVF1RE0waEsrei84UE56VXp0OG9YU2xwQ0FkZ2RxQXBnaWlIN2dBVW5PRURRT1NoMnVNaFFLcXNqZzMxU0pjZXBtQWc0cDh6SVRpbHpSeXJFZU1CVmg5dElZcitLZ3lCaHhLWW50Z2NGc3B2MHEvK0M4Ym5rU25MRisydXlFYTRqQi9qb1NZY3Zrd3F6d2RlK2hOdnprNHUwT2UyNGhrU1dkRmFudDRLcCt5Y256c1JRa25vcFhZcnpwcVY1SEdlQmRlVnlFSXNtRHlxNlVTcitVcDMrNHd6b1NMbmhMQU5tZzIxbmVWSWN5cUUzLzgrWDFFRkdxVTFpKzc5U2s5Y095TmVnTTl5L3lpSWZpc0FZRDhCT0tLZE1GWXNhZVBpS2Y5SnVjUkwvYXp3L0NPc3B4NmpYNUFKWUkxQnlCVUpncnpCdFVtU3lrRUNUVi9CbHoxQ2tlcEp0bjVVamNFWWJNcWZHN1YvVFoxdzNSc3F6blpDdVoxM1IyNG1henRabkUzSyt4V2g0NUhLS0pnQmI3KytlYUVFVlRXSTAzMjlQbG14RzNJN3R3YmRpaXFRcGJzMk1tRElQNkk3dkZLTW1SbkRzWHVxcTFab3lGcTJ4ek9RZzBwSlpGUVcwb2Fhb1lBNkR1d2JjbXBJWi94dE1aa09RaDBhY3Z5ZGE4bGdRaXl4WDRGRkJteTFkNnA4TXdxQzlKSGlIc0s5M1NmNGl6dVRRQ3VZaUFJUS9YbTVIV3dCV1ZQR3FiaWhwbktURnlNcXV1U2ZCUzRHN1JLNzh1b0tFa2krNjRvbXRNRGxKZng5TnpFWU9OenQ3cDl4RGZqMU1CTTB0RTE0VWlaRzJ0dWVnRFoxeko0NkdmbWJhaE80VXl4YjNwL1Jrd21UOHlxWUF2YzFrVFYwc04xc21OTGVXZWpNdXRMUmIvMXR5clIwNnRQYnlIY25oNGdOdUwzTWFEOVNVMEkvY2hBbEdtektxODJXQUI4K2w5SWtNeWw4MExvZXlLV1UxeWUyYk01TFpiSnhxY3dkaGNvNGhzZWJlRGI1dkFDWTlIREJZU2ZYb0ZjbENZTEJ6S3NRc0FXRmt3VnVmbW1jQjduTUdkeGhxNHZlZi9JSVVUM2kxNUt6bjJlU2pzaDJVRGpRQVBSVHllYm1CWEIyL0M0ZVlFM0h5ajE3MDZlYng2S1lRdU5sTVo1Q0hrcU9Vakl4NHdLakRWQXo3aFJnUWtOd3g1REdKNjJVZlNuWmwrTmlYSjhpckI1YnVlTFRNRVlIKzB1ZzI5WVVqNm5nQ0x0WDd0RmpRQmpqOXNyWnJVcEU1eFVYSytmZHp1V2lWS1NWc2o0bmZEZ1c4ZStrekFhUXoyWENMY3ZsZ1N5UzJLNXYwdjRjNWMyUDUwdUVNTnFlZldKM0haVC9lWmlXTk05ZnpDelZQTGM3eUZwcWdlK1BmbzZqZ21OWk5DRW1RK2J3UldLVnNUZHBTbkFzdkVTYVBPbkZOaTdmbFZSTk1FVzNyekpJeGdHQXpNRG5yRXF0eEpKMkUvVGdKUWtYQnh6UE9qNE1kTW01TFRRTWhab0V5NVM5WW52TnFEVXBueXlLVUV0dlltM2M1aG83akcycW5Sa28xWmFsbzRUbTBWdmk4VHJ5UE5QbXAwMmc3ZTZPSEdZRGtFV1NRMTl4ZnNwVi8vZWlNVEJjVFdvM0NaR0x0anE4Z3M5TDgzejkrNkFMTkJwMytsbG9kb3QvakNIbHk0WWIvc2lJbFUzZUNHVTBZNUE2UVhZd3RBWDdqblRDVy85KzZ2WEJXakdPenpMWm5Mb3piTm1oYUZDN2JyWVpNOXdZNEQ1YVZVWTdhdkExTEFsRzYxQjc4NU4yR1RBNDQ0amlhaHpuR3pFcU1EYlJXdUJWaTFzNmpVOXBhT1IwaWhjVjE3SkpJR2hZNFNoVTZDNlZ3NjZPaGNQa0ZwTXIxRjFjZSt3M3k1aHVMVWJadkpwdlFSRkxJV3dBZGxoVUZFUjg1bzZzZkluWi91SW9BOERNV2JlMHFHZ3hucVgvU2NPbTRTZHp5cnA3QjNxdUFDaThXZEtWNnljTFRxZFA2Q2JGczdjdGk2OHhXWlZYV08rT1JmVWFMaGYzNHJiU0RuNlkvdmxxeXp6emhrYnVLbjJKSVpXOW1pRm85QmF3dGdzWGJ5UE5WVU5WZHZSYVhFdTlMYjdXS0VvNS9iUVdCZkpNYmdkWjMvclZoMTV1ekRRVk9SZ05BOVpyR2huUEFjbDZ2bVN2ZFBMRDEyM1JUbTJpN0tNQWhBR1B3bDYxano3ZW5yVUJMZVFhWHRpZjI4ZVBKeEc4NDluaFlraVNGclBWZFJBR1d2ZjF0TW1RU2pZa1l4UmtFQ2pCdlRjZTA4NWNWc0lyOHlkbzZSbm4xWExTKzcxd3lhT0F3WElNekVacUloQ2FBY29DUU5ScVhQVm1Ka1ltR3ZxZHozL1RQVUd5YXVjenNFcG1CT2NRWXlpMHBQempwKzZUYkdZN3VWemVTOEZGbk9YOFRQRE0wWGQ2K3JyS0o2SGRCdS9ZdFkxL2h4eUEvVkJsRXpJZHp3RWw1b2UzY0k5Ym1XRm44b0VIeG1CUW1VT0xESDZDV2x2V1IvVDI3VTJOaFZkQ2VISllRZmdreDdZeW9VVExYZ3VydW1vMlJVQkJTR3ViTlNIakV0Qnk0dCtONTZ1U0lCQmJraS9WSTQwNEsyNE9kVFVsWi9OSEZ0a1VPL1hoODBTeUhHUU5YNzFZMXVJTUtiK0hqRGdSbEVmWVpxSkZpTFBWUXlzV1RQdSt5UmpFZWlLd3pLTEFJNEtDS3B6U3hCOXR0U2VuWHowZE1qNnhrOEhoaVpwSTQ0dzFGV1pkRWlnZDVrNnZoQVkyanhQOWFmdThMcVVjK05vWnY3dE12M0hEVmZnM2orSWpnUHRYUktpSEFZUlhwZ1pSZjAwbDRMYm9sakQveWV4VjRxREd1ZVVxRWNwcEJwbGttWTJ4NXFUUmFiWUM1TXoxNDVGdGxrOGxQOEVNVnlLTEx2NDhXRG1RYU1XdDdTR2svVVVBVVlFcWtLS0VseTFiQWJNVHVNRkVrQnlhUlRyekc4d2xBdks4M0k5ZTV5czJxOEY2aTV0MnQ4c1RLQmhScUFuZjFOQ3VpTWFyT1RhSzI4TTNJdllJOXpyTjdVVmdvejlQRWdteHhuVjFWbjM0Nzd3NFgzMzB6ZmlhUmlVTXNzeXZMT3pQbWtobFB4QmhCbDIvM0Fzem1LYjZxZ0xEbko2dUhKU1VWWFdWOURUczRjRm1SU3I3RVNrWkwyYzFPZzBhaHBtQ3ArZU1UanAwN1gyaWFvWUFTUUl1ZFRBSHZnbHBrZVIrd2MzTTJSTXVlTkR0TndqbFltVXZmTTRuMi91V21ocjF4RHBHcFc0VEVPcDVMR3RqRmZrWEd5RkZ2cSswSjlScVNLRkpBL216NWhWQkpDeXJwdnBwQkZ4L2VXZ2s5RmpiOHhKSkQzQi8xVWZjOW05UjJCUHhjdzE1ZTQxckVlN1lIWDhOMEo1b3lqTGRPYlRmWFVlNEJvMmpOb01xbDdXMGpLa2ZkREpyTVVuNWVBTncrelRJdldTVTl1UWI4VVBaeEtsZWRiWmhZOWpEOWhTelMyUzVMZmFOcTFocUtKdzhvNTRYOW51S1RiUFJFcExOTW5HSFY1UWE1UHdKUnJiblBuWDNVOG1pUFdUcVJKV0laZGx2M2FmejlXOXNaSDRGVTFVVG5qaXFDSUI3OWpaMUQ1ckwvVlAxNk9TdEN0eEdwVkdHVU9WN0ZaODI2TWwzOEE1K0RpdWtWZEJ6MElTTkZidElNMndzeHlBTWREcEIvRjRsVkhCRXlHNjNXSlkvQzZoeEplajlRWCt5Q3lYZ3l5K0dFU1pvSzdncDZvRkRPVlM5b05HZ3ZldFVYVTlkRnlWZ29yTWhVa3ZKNkxua09YSjN0YnRsRUN6WHF1VHZsWG1nRDFSczNaZ2lwTkd6dlZlczMway9WbmQweXdJSG5JQTllMk1NbmRaajN4RDNNM1Y1RnB3bjgrUUdNOUJCcWE5TjNLa1I2ZzRVZVhGT05OMVFxUkhhaXhUeGxSSUNRYUFWY0lPUHo0RVpyS04rbVI0TmZXWWpVeE01K25wSGZoYVkyRkFyUkZWaEdsSlJ1RkV0M2lmT0g1RWlJejRYajJFcXpyRE13YWJqNzFQNXZHRXZHMlJRYTRvMnkxWlBLTW1YMEFuZFlyN3hRVVRMajBnUW1tNnVyMXZMQjlWQXlEeDltUEh6T0VENDI1ZmtkdmNBZnBCYWJuNjFTQng3UFVON0hOS2djUlVPczljOERLalV4RXZjRUREblN6VXlDZUFKR2xDVnVrZkxRWDUxejRiUjdLQjhsVkRIMVBkdFJ5dkkweW5LL0hiUjFEajNWdkpiS2MydDNiUStnMXcraDloTmVOelNSdEVTdExPWm1mWm1YdGRWMnl6Z2hDSE1GVWpBbDRYY3NHSVVRSG00Rk9mQy9BMGpDdUdnWmVHTGcwUWZsZTJYSm9GeHhBYTJkYUUyS0Nmbyt2aUJaMEZadHNNcnRnc3VzZDVNVEJEaXl2S0hETFlmQ2RRVnhZV29EUC9sQUpnck91MUlSR2w4SzRkb1VTUEw1Q0lTTFpWOTRaaDRiQ2p4YzVWOUFTZEg1QWQzR3M1cEwvNzNMeXV1Q24xNVBLeThLREQzUEhmekRRM2NFaUpwanFEckFSQXdWNVkxUmRJVk52LzNIOENhYnc4Qm04bDFqOUxGbGhkZFVNZFI0aXpLS1ZQNnNQNXVaNGpsQVppaHFBWlJ1K2xJVEQ4QVVNd3dOVVoxODlnS2RPWlNDM0ZGNGxLRmdEN1NnT2R3UE1yd003bkNrNlF6T2Z5Rm84ejdTbEdOeElFZWg0b1B4dy9qaUZoR0t4TFVmcUF0UmNteDZydEZEa0NKTUpIaWl0d0Z5a2xVbTFkcUExc0pJZmhpMm9sN0haNmU3ajZVTzVxQ0E1Tlpnemh0TUMyNkdWQXJzM1dRNm9ESi80ZCtpMEZBelUzaXQrYTArYVhjLzJsOUZ6QnpyemVLOGp1QWQ2WXdsV2ROM2xrYWdMQllVU2w4NzhMTFZoM3ZzQXFSc25MNU1JZ2FxR3EyY09tQm42ZVdveUtvSXJITEJlZFNJQ0VPa1ltNWM1SE4zSWZpWWFLNmVqVHRmTzBydUxhWEZ4bWsxTVpidWozdFNwS2lWbS8wcS82dVRMS2dPYUs5Z3BtNDMvem5KUkk0clpKVkE2YVFlVnJiVy8vSHJWeEVKQVpHeEJ5d0VONVJmVld3SERDMTVLVkgvNEtpbTQzYllqNjQybVFSdEtoaFpLcDA1MjhzNW80U3d6YUx3STNPRVdvSlFicERGaVVrekM0QjFHb2ZYeEFkUDdMMFBySmcxbVA0TT0=', '', '04 Jul, 2021');
INSERT INTO `pages` (`PagesId`, `PageTitle`, `PageDesc`, `CreatedAt`, `UpdatedAt`) VALUES
(4, 'Terms & Condition', 'b0Zka1dHWVdUZFVJSzBzd1hmdlFyL2pnbHZZbVcrczdlRTA5aDZ4VE9uSWM2dGtqc0hJQnFGYXFGS1BpaWwxOU82dHU2MmhGSGdDQW4vWFo2dURwNERqQ2lyaEw4VTR5ZTVJeWpGTWZIMWVVZ3BUVDRjWCt5WVhRTmk4Sm1tait0MkJoZHVMWHZOajJXZkRqekc1bWhqZTBzdE4vTDZmNnpwZ0UySnBEcmRDZ2hUbFcxblZJY3E1U0xDeUN6Z0llMUhrQ2RkSi9oQVNDNEpiZkRPak1YZFkxTHBWUHBDUUV2aUlPOXRBeEltcXRMd3lkaEQ4M0FUdEx4ZWswNzRQNUlBTEdRVE56ZVJVNWdvcHpMN204Ni9pZzdOMFk0S0tyTkgxRC9QNDN6ZGxJVmNKSlVNZmlNNjZ6cTg3WHROSUVVU3F3VnZGcS9qVjVZdHVET1F0ZG5UYkN3T1Ivejk3Wm44dWgzd0xxRDlhQlpqS0F1QjZYNk5CdWJ3ZHRGZlhERG1scXBUSkE4VU1qM2l2ZTg3T2s5YWxzY1RYQmxud2cxZG9rTU4wZUw1aHRzdFNGNkE1Y3o1d3QzdDFZNFZzTmpyVU5oMFdYMEg2UkNBaXZJb2haWlNRMU1rMUJsaWRBSEFGYi83ZXpiTXBYMDVySHFxeDRFWTFxZWlxWGNKTVhYSWZFODcrbmszNnM0VVh3bG1LWGw1N1NXajBXcE0vWVE2RGRvdkFreEExT2hhSGI1NmxRYnIveTlJbFVzZVFZNG9ISW8vQTUzR2VoT0FNaXl4WFMwcDRJc3d0TGlDNlNNQUprMDA0c1ErS3NPVmxJVEJMQzg2WldzalpscVFaaHFEeTRTRVoyY0duU0I4VXFkZlh1NG5UT0hRZWVYaExCNWoxTjRIcENMMnV3cnFuTGYrMTFOaWxNSURXbW12ZGtFWllQMTFFL0JzTURiclZ6UmEvckMxTE03ZVZ6bFNkenlRWk9SN1U0ZHBjUUhBNnkrdEhEU3dJVzZLK1NnYi8wUDJpV0RJNlJYamMwdlRqWEdLb0hpblBCbW9XMVlRU2Vud1pndmpuK092Q3ovZTlVQnJCdlcrRFBsTSswSTBGK0VKdHhHV2xJY3pJYU55UDBkVjFIdXV6TFkyZm9PQlhncTJDanFiWmlYZkw5QzN2NHp6ZGROVzY1NDVXN0pBQzdtREdOejc4M3BwaEl0OXM3czJ2c013QlFZVXJFaVFSelY3YzdNMS95ejN0clJ4NnpsdHE2OCs4UVpveEd1ejA3eDQ4ekpEdmFmOEMvb1V6RHVOUHNKRWs5Sis4anR4UUV6TmFubmkxcmdrQlBBcVlpT3VtVmlKVVl5STZJbmM0R0pDZWtjNnBvOVhHYlVmaFlCd2lOcVl0Z0VtdmJrazFvcVV0WjVmUGEzZTE2RlJUc0ZGcURSMmp6ZVlyZFBOeEM1Rnp3OWcrdkRqb212MHhmSHFwMCtDZ0dxNzcrd2RhckM0TXFncGVqWVNNbTZzVldTTHBJdksxWUZsc3M1YkRWeDFXQ1FBWVdEeW80dUllWUQ2RUFqbHNjQm01R00yYlo1UFZTY3Z2eTY5eEtGYldDVi96K2x3aEJHUGZDRzZvQnp0QTk0RjR1cUxNWTdCVDNOblY0V20xZlF6TUNUclorNGdSampsSDJYSHVnOUVMZ3VCc0Q4SEtGVklHbUl6Q1J2OUpTOGp3S2lvbWxSaWYwNERrd2dOVEdURlc2L1hVL0hvWFlKaFBPZWdRZHdOYzlqT3NscXk5V01KT3MzaHRzcThCTGpjM1JEU252SjNIK291RUlibEtFQWV5U0YySmpJTkRMZU9IWGcvSE93MnZKK3IvYzkyZ3U5dUxrc2JDdUhxZUtWNmxGVWtrVW5IdHJnZWljMzVWQTAvcGdPMTZwbHRXdG9Jcys0YVVkYlM3b0NwR0NEYmozeUNKSW5JcXVSbkVIL1FzbXNmNnVLQ2NibCtmaS9lb29jRW9FWGM3U25LOUJwS2JUMUkwWlNWako4OXhYVnR4UlkvdkJiVnhaR3NsZ201OHVQanphclpXT2QzcHB1cFpyTUxwRFVRZWRNT3Y1YWpHOUFxYjhmKytBaTF6TnZXQkRaZUt1RmtQUTVDRnd2aGt2a1hrdldiN2VldVpZazA5N1lmWmJDbldnZE9VUDlUM0p1K1IxYzJneGgrNEZHUEZrUUZxZC93b0lOei82Sy9EbTVISVFVU1A5VFlkTGhRZzVYRFJNYXR0cVB2WUVQbG5icWw3eVExd1pmaVp2elgwRm9nUms1UCtSbGMzRXA2SjhvS016Zmh3MDhjK25ucHZvamVTV256S09UdkMxMlBHQUFaVUtvdVZOQW9jWjJSUHVHUGlOZERUN0JiR3FCbTNTMkhURkgxU0lHTzFvaDRUSnd1WUVIUHd2Tk1pWVZHMGJIKzVTYlk2TjJYUDJYTlM0a0ltRXkraHNoU1ZHbGZoUlAyRDMzSEttY3RVem1mZmdYUWtSNDh1ZmxlRHhNeUl1Q01QOXhSZUk3OFphRDVSTG96am9GV0lXbFpod1lWK04xakJ1TlJweC8vNzdLY21hZW9CUGUwdkVBRUsvNUJkYUhFS3R3c3NIOTlVcTFWUmFXWWIwaDZtd3NNbW9MTHQxN3BUV2N3TmdBcktSK1NiZTc2SkJWdDd6NnFJVEwwK2tRdHZBK0gwamFNUVVYbHlwd1B2bEpLK1Yvdjd2bDFHa2ZUbTczdnBvOUZxMFRWMUkvaWRtREh1cTdBS2pyWkFNVEw4VkZMbzM3dHZBZWZ4bGVuT043bFgrTDF4a0JCQWd0L09GY2FrcjBVZHcxUDBybjhrR3lOcGRrWHhKRnFnWkpRZnpxN1dzMWVyZGR5UUVmemh2a2NSWWhiL3dzZklhdWRvQ1RtSnlVTE4zRFR0dmNIRURyUGhKTkRQQ05EMFdmOGF6QVFteitITUNuM2hYUlU2QnpOejNSVlljdGZJZkk4eFQ3YnB0MzJjZmNUdUVTMks2QjdiMnBpaStMazdSTU9raTdkRDRCNXRxaVI2K0pyZmZBYjYvTm9keXd2WjN1Q0NDYnhyeVcwaEVsVjE3VElOdFZkUlFJSml1clVzS0NHZGtZc1lPd2ZRNktKRW1QN1loK09pYmpYbVR2MiswYSs4NGwzV0UrR0FCNU81RVBya1lrRUdta09aemJwbEtNRFAxaC9kVVRGWjBhWFdPS3did21yZE4wUHczYUVoRjBWMktYS3UvSVgxNVBtZWhvU040dlBELzcyRUs3Y1QvSGFXR0h1NkdUSisydGxtV3ZpWXUxbk95dDl1b1RqY0NDUUpwRFpGV0dkVm1UV2lXckFUSmpPSjdNVjNNQ2lEV285UzJ0YUpxTkNJVkZTV2ZiQSszck9XRlhMbXdYT0VDSFg4SjdCOFVFMmV4K2xobzhXc21hb1dxYXN1eENyaS9ZdjlqOS9XeWZTazZYNXlhdFZ0andzcDEyRnZCSnp0UU54OUROclhvSi9TaS9sRDJUM1VhN2VFVFZPUDU5RW0wSkVqTFE0dmhiaGdBazBlN2cwdjh6aFUydDBjaU16Y1Bvc2hQMENuWWJXYUx5bzRXbUFqL2Z3M2VIbWpUZHF1Y3YxR0FDRzRvMjI0UGRQUUFkU01jeno3WWJNTkZOb3A3ZEdCUk8yTGRVbUljZGttR3pBRmxmbktXZFhVVk5CY3d4ODFpZFZoLzJjQzczNHFMTEttd1RxOTBkcXRMNFpEME1aNmJQN2tDVXBUUUloYzFVb1o5WnowQTM2UHdKM0NRbnB0SlJCMGp2QjhpdnJucFVXMGFFblM0Z3JML2NyajV2aFJyZVIvR0VCbkthUGhvWEFHZHdldHlLd21YMlJENmtLSDZaZFAweGUwbHJxeE5lZGFaYWw5ODJBWmxZMVlYcDdsQ2NuWWNxUkV2eXFnTUM1bW5HUHRzZnh3dnlYak9BdFBWcUVrbkJ3WGJIWXFZcmpFYTF3dDA4N0t4NVNCWGlpV1UxeklhRFlRczgzdEZZaEZVb203SzlGSGI2cmdwV0tGK1hJVlR0M3RvekRrODJzZVkyVkNmYS9UejgrRDljT0U3bVRDTGNET095S3ZNbXZYYWJwYTFFL1h3SUlXbmJndlU2Uk5wS2h6eWFaN1FBaXNwbTlpN3NaOGVrcGxSdVpIMnA3dHdXN1pIeVhhOEdUcm9UUGkyQVU4SGxuOC9LeDVWMmRjS0FRdHNLbXFQV3BEeEMrVDNvOStFRUxEUUZTV3M5Ly9YUWs5VWswaG9sNWd6SS9ZOGF1MzJoRWdCNnJaNHNVZ2pxbTc5cDQxQm1OVzZiTVZ1c3cxS2FtYXFKNnB6YmpyeW9CZG9BSE1xMGdheU5tb1NHZFRSaGVxWGlqS2FvYlVkVnJtQXdzTU50TmZmNnZCRWZTdlpocFlURzJMRFBIa3BBWUNxZVMzSWhJd0tlcFgrQ3lzTDNLdnBnWFJUQmJXT2xubVoxU2lyTDk1ZW9CQTNSOUpUay9QNFNlTFNqeDNnZjA3ajZFbFRZbGVSWUVmQUUyZlE3dHdPRUhFNDBGWmRUT09KbHVqYzRROVBwbmVBRGZHOG5KSzUyWncySnYrVnAzdWRETXBxcm5UM01yNGpRbnhvekV0d1MxS0Yyd2FnRzd4MGhSZ2JSbWlROHBtTjJoYVZYUmsyK2JSQ0RLK1ZxSGwyNlovQ0hDTEtYeXl3MnJ2cW9IU2FBTm5mNVhWVkUwYUdNdEFBbXpLNytOZ1phRGpRVUt1RmpvU1BTWGJFS3Q3M09qRVpTQnpoWUYwMWNxOC9wSGM1azA0clVEdXlaTU1NQUFXUXNONDFDWEZTMUlrakoxaUNxeUE2UUJUTDd4YllPYm1OazFEMFdGYVpoTkU5NE9PZzhkK3hzQnc3azRiSmY1UHNudUtVWEg3d0Mza2ZCNTZhaXVHUVBTQktMb1lyT1RhV2dCMWlEdkRBcGVhQlorK3VqYTk1VCtHbElPV2VESXUxZkh1MmhsVVF0Q0tDTWJGSHp6NTdSQmtCcTdSYlpBc1JFN2ZudlBOQXZua1NUZGNqVCtvSTQzOWwranlaS25XTzJ2Zzk2RS9sTHV6NnV2Sm9PdDdHUzczd1h4M1lhV045MmRXci9qUzR4VU92RGcyYURRNktWZElCMGFGbGoxaHhpd1RnOTVIV1R1K1laMldWODJHNTI2QVBJVklFQlZkUytHMTg1NXZLY1M0TUh0WW9NYktQV0l6MzhMTFR2YlVyTUZyVytPa2d6YnVNeXprK05FbWFnalJVcndTSktMODBGUVg2Vno4Zm44S1BHdlJFOVhESzFoeUx2N2p2SVdmQXcwbmtPRW5iMlNlNFVFVEczdGFFdm1Qc1FKSGRMNEFVdUtGOFE0UFNmYmcvSnpiR1RwaUdmTTJ0b1ZNZzE5ellKYVlGd0ZtQlhYb0JOOG9EK2J3S0RkOFBlR3RJNHRHdmxQTUwvZXRDdis1M0MwTWRjRUtuZlppMmFhRjFDcjY1ZlBhV3BTeWdhUWEyaENvM2MrN3dJOGkzaHVUR0trL0xrU3YvSEJHelQwNU9LYkZlV3ltWXVjL3gwMFRQbVdseWZUL1puaHpxcG4zb0JoVFR0RWdiQU1FeVVaRytmZVRrZm13WStCNHV0RkY5Wi9TT2t0UDg1MDFGdFZVeXA3RHlueXQvUHdvbmlMZks1THVPK0hQSmtMZ3pJOFlETmN5TG1la1FrREdWd3NLdXR5UFVJdlhlYVQ2eWtiNnBpNUdXS0NKTko4U3o5cHdBaVlkVzZRc0N0QXhsMmdQZExDVzdMNmVGc29vQkxEZmtaMHR6MFliNEZVN21vS2tjd29BSENNakw2SkE3RUxMWW5VcjZ0VlFKN1hLYjJ3VXJONEtJQXNYY0RhMHozN3hRYjJiR3ovRjljOFFRL2RWUlBvK0RPVlFRNGpjLzZCWTRiM3pyKzRzTkg0ZWV6RWZydmhiOXU1T3ZmSGt3VFlnSnZlWTN1Q2ttTitRVzZpTnNWZ0VTaHpBYXpmd1VmeVlORVYvN2xvSkViMURLaWZuS2thWnlJQVhCaWlCVUNXL05jNWM1YkNjelV3ZEhzN0I1Y0tDN1l6UDlwUW5DMjBraGpiejF5MitpdHRBVWRjSWovS0tqL0Y3VWRWWVVNTXQzWkhXUUJpdmJoM002enBJY1pOSDQxaDhGT2VibE1ESGNGajdGVXova1YvcjdXcFNpQlZaQndDZ3NBeTE0RlNDNEVKazNWSkVhZkEzVUdQOC8xeHFycExNTW9nWFNTYTFVOEVvbzhYbmc3TkxwdUdjc2RNVkdhQ240S2w1d3R6YUhaQ05SMVQyUmUrcEJHaXRXbnZIeU9EeDhGZGkyekZ2eU5rZVBTRGJwdmdyamFmemp0a1BtZFI0VDlzV3V1dmdFWW9Yb3VlK1V6QlRLbWV1a2JNb0J5UTR4aTh0NExuWUd4TngvTlphakFLTkNVajdGNUd0NUwwL2c0REd5a1loQVFvcFFvQXN2V0RScWxmSFZOQS8vajBHMkkxRHo2RWdIaDFQaHludmJ1aU5GM3dhMHp3bXd2S2c2cEdGamVNWmRqclljdFY1QlFnZmhTZmg0MGdITFIxUi81R2Z5KzlwdThKOHpwb2EyYXZwSGlzTjM1K1VKRlp5SFhKZnJVb3FZUEtLc1BralJiTHh3RURNMmhJTXhyMVdadUNDZW9ENWQrMTRzNzZZUVU2bWZHM2RQQk5oQUF6MG9PWVZHS0FKdUpUWVB5UUtCRnZraHZlSUdOaG9tTkRsNEtYb0Zad0hnUW5HS1JFSkVYUDFRRUxOeEFtL3FIS3RtK0dwSERNSG9PaUNZajJFYXZ6RXFuWWpTM3FDSU1taHdYTzFVb1VoajVSRU9zK0ZPSDB6TXJkNkVIZ3RncVFKM3ptWmdiS1VjUTFFZjF3L25JQktpdEZSZ3VUeW1DMGwrOUVKMTBtdlZVSG1ZV0V5a0NzUHkvVi9GVWhLNitlRGJaYW1yd1l0NTJoT3VMeS9UUVRxWWsvYUdGMEN0NmtlZTNPdkVPZ2lpQWw2QWtUY1B4a3VUbUhaUmJCQlE5WGkvaWl2WDdIdXg1d1N4Z1FvTmNLRWhIVEVHb0ZoWVNxVG9YZU9GT0pVQ3VEZGU1bWY1R29QcnNnM1Y3QURQYnBaTzA5V2JoNjNqOXEyTVFiN3p4bm1Rb1J6MDNNSkNTNE9ENkNBS3BiKzk0UWVyMUFpUjBudW8vRkdETFJxZTRjdURoTXJUdzV4R0I2T0ZOSEpvOXlrSnRPdlM1by9yMWxieFd0cGQ2RjhPWmhLRjlxdVFQMm9TZGZXVHNrVTJ5OTlLTEp0VFlBQUsvNW5OTTVneGdnbzc1V3RrS2hHNHpqMHZUZHBkK1BkVHZKWkhoK2RUQXEwQlZyaXpvU3UyUHduS3ZNZVRRWElPMGhMTFJRSjhVQnRseGtHRVJ3RlNDRjAzRXNwM1JYUnE2azFlTGo4UTZiZ3UzbGJwUStZNzJ3enBBNUgrdjkveDJLRFFUbjA0UGtJKzFFTTZ0OHNKUE10cktYRkIwMEJ1N0l0TWFmR0RVaEtnVGlhMFhDYzQ3UEc2eUhBTTcwckFxTnBZTGZtMXhNeUduZnJCK3I1T01ZQThlVGxtYTdOenFReEh3a3FMSUt5c0lqZUUvaDcvT0JhYTBxYlNlZTU4bGdUazlLUUl6akw4ZnIwREtuMzR0ZlNocmpjSnV1WWZtY1NEUVFqOXo4bGhUUjRzeG1QZnFBTURpeUY0Um5Md3NUYXBWT0J0NE53Q0Z0cUJaZCtHWnJqQ1hWNS9KdlNtdml3ZjNpMDVoMDQwUkhnRnl2eVExbll5MThpMDZ3aEhZTW9SeG1jQkZoeWg3TVp1TjhmYXorL2F6eHZhWnk1ZUVKN3pmSlQ4ZDIxa253ZkMyWVQ4YUhwZ1VXY3hSVnZIS3ZhMFF3RHJ5TUU2VVllck1teUFSRitqK3VjQ0hRUTNKK0trNkJUdW5MR0xlaEZvR2Q5eUdMZzZ6cWRsdnlRaGozelNCc21nV0FrcXpSRzJYWTFhTXpNMzk1dmNrd2Z5TURXeFhUZWd6K3Q4d0Q4cWI2aFhBditUalFCbmhTeXVPdWlRTDlLeDErTnd5dVFKeXpGcGE4WUpHMnFqdEp1Z2Z4dUJJOHFJSFZpb0JRejVPM2NhWFlxRTFyMXdXRVFpeXp0eG4xZENucVBvUmJJRTIySHk5M0xjZmxFV3lvNi85aUh0VmFyMlMrYW5OTTQzOGh6MjliaFJrMXo3cmhOOGkybkpMZGFhY044UGRZOWN2QkZlV3pjMVNxRWFBVExwMk9ZcFlSNW40Skx6QUhhNlk2bmZVUHV4bWZNQjE3c3gwaXR5S3BQbzYrUi8vL09TRlZ0SHdDdVpMVklabElQMnBFSk9sN1cwYVB1MVlSSjlZVmdFSklUYWN0U1MySkc4QStLa1FTQy9HTFlIcDg4TVhoUzhlSElEeXYwMFVEa0MxTkRNbXR0TmlnT09uQlVLS2tsWWZkVUM0eGRKZkhybGpCRTBhQXpyVDVIRHNSV0xyM3lTZTdUVGM5YnJNNzh0UGxCMzRVWm1IenFzblQvbDVYM1o2WmRJTkNXODB5RlA3OVc1YU9DVWNNNlF5OEtJell5YUhmVFBicHRpbU45dVRlNEdpWlhJdnZlZVk4VkszWmk2ckY5L3dac005UDkxVXRWdzRWYWorWU1Lc295czk4VXZXTTE3dnV0Rmx5T1BvVytoM0NqTEZiS2FVNGVvMWFQU0hrNkdOUmJ5amRKMGJxZ0YrdisyWFpOZzVQUHgzSWt6c0loUnpaNHF3NkN5M1RoTURLMmNpb0F3NUJKcndBTlR0bUVFOXMvdUxXdllzZVhJbVp1THlJMXZQeHFWNHBRa0krc0prK0EwTjMxMnA1eXNsNWNPVjI1TmFucGprV293Z3MycU9aOU11TGpLWXlZQ00zL0d2RktiTzZsL2orMjJnWTdmcDJMV1JoL2RreEFkTzkyVnpXNVUrSHpEMTBVMHhtbUxtWk5tVGdPbmtTR1hVNlVLRWFaRFhHU3BnQ1lHb3BYTnhNMWlyeVVmamJzSW5MYVlHSjRjaFNiZzBldEJ2emV3Kzkxc09hYitHMEp5azNqMENSMmRMLy9FbHp6NHNPeUxYMTUwUVM1cHNxT1pMQXJnMUxYUyt2WVliUE5KTVhNN2E0ekQyRTNhanpOTFFYS29nZW5UM2s0UStNS3h1ZDYxMVM5ZXJ1Y1FnNVRhK29qZjZwVWFob0tYWFlBWFRhNVBYcExiaEpPQldUVlZDcFVkY1M3UmdieGdoVVFQL0ZBVi9HZWxtWk1hdnB5T1dNeEJiRU9lYzhlM0RSNHlIcElEWlRPa1NBZWwwT3pYTEhLbUttQkgyeVBvTUJtK2hVanA2SUZQNXNZbTdUUi9DWEdMUnpVV2Q2TldTSTc0RUZFNTVzVGcxc21oOUcyZE9IT0tBcWIwSncxUFlhVG1LZVFWZ0UzNGZHWmV1Nk1Ta3J6djJEMHBMblZDNmpiUEFJMm9XN0NSbHUyM0JjSXRpZmhKdmF4blRaclZvK3dYUFcvUTYzOTRpbWVvbkFuSUorZFh6QlBacm1xaCtCTEVqeHlNWm9ZMzV3Z2NwMlVlREV1djBkVENGc21lamoxNlB3TGlBVURkdFk0aFVIdFU5VWRBVnNia2pCT1UrS0oyeG8wYnpmcUp5eGtIdExqcGFSd0RxY1B1NG05SE9VUjJzWG91NlA5dUp4Njk2dnozNzhEelQ1UVpnWW9oVVI5NjRkNk5VeVAyVUJpamdBYkZ5ZUdnVU5oOFBqa2NtNm01UTB3YlFOK3JlMlhTYzFIbHlSRzlEWUxMNFhLRE5LSExncWRrRktxc2RscGRKamVCWWxTWHg0dWlEK0V2aDEzRndManhUMnc1TFhETDhOMkJ4aHJKU20yQUVHdEZ0UHhaYzlVajF4OGFHMjBRMU1NVVJzMGdST3YwN1pZNytLYStPdmZrb1ZneUYyeXQ2K1o5MkgzVkNTTUM1OUVkM3JJUEU1cG12MzR1bFNvemwydjYwTkNFM2psZkR5NG5udmdZcFBrZS9jRlk0aktmaGZKVktDVHdUMlFtcTB3dVkxY3FmNHdyQUovd3VnOVJxQmNQWjRpMUlYdHYyTWlMMFN6Q1l3WEtrTnhCMmUvM3Z5S1h1dERzUFZLY2o1MEhycUdZdHhmL2lQWkhBcHQxK3VtWFEwS2R6WTMwNTFRZDJQMjd1M2g2Vm1FekRWa2ZlbjF2MXZVSHRCVE55NjlCMFNrN3k5amlKVHcxeGdVUldiVjBMMkJBOGtZQy9XZGNPdCsvdTNaeG0vaTBuU3pRc0dDNTF1RVNsMXpzSXNaUDM1eEJyWUFRWFE2Z2xJd0xlUVJkSXdTTGs1UGE4Q0ZXWjh0b2hobGk5YUdaRkxZSzhrcHdhNEFkbFk5MnptVWFVcWluYTFtUnhhZW94Sk1HZkZGdnJlVVhqL0RHd1AwK0NtZnFsQlJ2ZUNyUHBOSnBIT3l4dVYrNDZmZnJmRUZZREhvYXhrVm9ZRW1zTTBpcG5WOEQyT1ptMEhheFl0ZVp3VEIzeTR5S1RocDhKUzZiOGwwd050TyttS0Y2TGVaMnV5eHJHWDN5c1p1WFl5cERjdnlidWRmSGRxaHByd1N5cklBOGpBS0JSNkNhL3hsQjJoZzA4RTgwWXR4S2lQWEx1OERsZkM3OStkeTZMSC8weTYrd3M0NlFlNEoxb3RkcFg3L3hmMUVWVFBmcjRDeStUbTZ4VU5zSnpkUXdLSVVncllMRDJkTjJwc3lTMHVSVkZQWTNsQXRWa2N6eHN4L0FBb0VBZkdmUEh3bWE4TmhRVnpSOENoSXVYMXVybnNnQ2REdGZZMUpqdy85SFc4WGhFSzhjVm1jL0RFOUFkMlpCVnRPSFk3RWlsRkdBbTEyTnF5Ly9PMWxpWTBUQ3VqTjRPNlArckpZZDVKdlBJK29uY1ZFOTNESXdCTHVVbEZTRWQvUjkvTE1hR1YzYWt3bTRWckY0S04xMHN3ZndFcWFiK01uNXB1T1IySkFDQ3pIYU5PK2N0N2dZcTZwVXNVNWM4M1Y4WkRlck5NOFkrdExjWm5wNWZQTjI3VHpPN3JVRFY0cG9NOG1zd3JsVHI0eHVCWTBqbEk2ajhIYVBXZTh3NzhPdjJ6eFVGVzd3REpMVk9FUlhCTXV6R0ltZGRrTXcwWURRYTFEdHFVeTVmVzBLWjN0MGp5Qk1NM2lneEwyWUhnak41d3lHNFFkMFJDZGFYY0xLWkFvVXIrRzJKZTJLbE03Z3dDTFloQUFvQkE0TW56S0JCdDEyUGVQaVd1MmN3VkkwZzl5LzgyT082V01jTlkvUHE0eUtZRDUvcWd3RnNzUUpXcXE0V01MSlhYUHhHZFA0bFc4ekF1aVVldFRINktKaUh1OEFFV2ZwSmhvYVdjeCtoOEFwOUVCelAwMENXV2xXY1QzVE9VVDNBcmRtSVRJUmJOMENaaFZMaGlVM1FXdnBxUkpvRmFCT3diN2NkY0pEdDRuSmVaZnVOaE03RGJZN0lUZFlaUytSU05uMkRlYWJFUjhsbWl1bTBIMm40MVlPTEVCZ1dLa0xyUFhwSk45b0R6T1dsdGs5V1ZlcSs2cGdsNFE5VXV0b3VOcE1uaHEyN2FPbTJzTmxUV1phQndVSSs4VnZjZ21RakJ2WkxHMHFpVmNrY2YwdFNJT1U2SHJiSGZRc253ZGpLQk1NWVFMSUxjQW11elZRUDRpWklxeWdCUEVBQkJjdlliaTRwZlRKbVRnSEcwMHptVGVyK3dkN09KV0c4MG5jTllBZWd2R2NKYWxscnJ6QlQ4VmVaeHhDY2pHbklEdzVodEVQVTErbTF3Y2hTbEVhTENlUjA2NUFjZHVhNTVYT0FRakI1Y2R2WmZrVXVWSWNzekJlQ0ROUjRiUGRPN1U4d1VJUjFBYlBpUXV4RUoydG1weVJhbTRTOU0velpBTks2V0RXaW9qaDN0ZGNJNXBhRk9PUjBYTERWMElCR3dudndrSzNMNjZmRkRIcWtTM3J3NkxUSWdmSWpkUWlLNGVaYzFFUnM0cEw5NHgrK05YaTdreWtMcWtsMWJtNVhDOVJyMUFzWVUrMTFZRTRBcW5uRkxVZjFpeXVLL0xZb3VKNEtVUVN3MzFsYkFGM1Z3bUFxTi9tVGxnakQ1RFR4cEVKSjlQTDNYR0lpUHp3ZWNRdU9yUHdjS0xnWk5WUzZoanpaVGVGUzlJcTAzYXJXaFREZFk5VERYTFY4ZmFma3FvOXN4OGN6elpMUHRtWTd5MzVvclAxRlNXOGpkUEdBWXhjRTM2NzlNUnpzL0k4NFlsTXNmb3RoTDlkMU9KbkFsdWZ0S0RXWnd6dTBlajdDKzhYQTRTR3BzMjZESEpieHV0TTZWTFdaakp0dnVvN00xcTV1aVVmT0czckxGZEd2VVhtWGZDZm5XbEhpa1hjSWZzbkUrdHR5bXBjUW9WdUZVRi9HbFJyVGVtbWlYbFZvQmdiN1Z5NWJPaXR4K0pJWVBaU2JadnhnYklRTE45MjZBOTdleGxVNWtraHRsYVFhZGRraTZmTWIzTVpiVFdqYmpoRmZBZ21mSVNSc0lZZ3ROYy91dU9NMGUvZ3JrRDc4Q0Urcks0OE1WcEJYZ3VaN240UDhRYklSU0ZVK29nb0JGdnhoRHh6S2NGSGp5ZnRaMVduTXRhUlkyUHMxQVZYRUlGMElRNFdlOGN0VXdVakZnTC9uTFZSVUFIaVZxdktLbDdMWUdGLytVbERQbXhlc20vVU1DdWI2c1BXTFRUT1RJOThDdCtrWnllellUOWVtVURqN3VIdEdLSExyWTNQMjRJMStkeTdhUlBJbHBLY0NXOTBuK25teEVBbm12NGIvUG03VVdHYUlJUERlWXRFaDQ5Y2U0Qk5TTmNmUnZUNTN1c3Y3Z3VIa01FMUVMTHdOUTAwSHIrc3oxVjdzRjJoYytyN2l0amlhemppSWZzb05GMjFid0V0SnE4ZE1yMllJbXc1bDMrTnRMU3JnVCsrV0tJWEdtaGJMd3JYUDVvbGYzckR1QkhiRFMwTjhXMDQ3VmtOR3BQRmZ6bXFYMUhlSkErbG43Mi9hN3BONG0wYnBvUEhpOWVlK2NJbGRYUG9CS2l5VVpqSWhPZkdHeXArQWp4emVDL2dXZ1M4bkNIdmhKQnhSZzBDb2NzK0RqeGdaRitWT0VlT1ZhdW5hb254ckVZdDE4TGZtWklLL2duQ1o1akFicUp4UnJmSXFjUTJmdGZtd0lHZHdTclRzVHFBNlJ3Sm5lR1pYMEtqR1pzUUxzc1RnZi9VZEFqemFUKzg1dUk4SGtqZVljQ095NVRMRGxwSmIxdmNLbnBMN1A4dVBDeGxZamkycVlwNllIaUxxS0lXdTlseWFvN3ArcDNwcVN6SkxWNFFVb21qVGpKTWhxZ0c2Z3ZPd3hkS2ZnelpRamdwbHErTzRNU1lXMWJIditHYVZDWGEvVGEwR2VVaWNCVFVIYVZPMTlBTGp3YVAwMi8wVngvdGFNQk9uYlgydFk4b1JraGdjOGFTYjk5QWwrTzhBTCsyQ2ZYUjdMZUhjMkhCYmVSUllVbVFlalA1ODJYT24yaFo0WU5hK1Z6eFdZZmxZWW1lY0JlOHhxdWQrNTd0SjNkeHJqdmF1WUJNL3ZvNmQ5YnRBOG1ySW5UU0V2aTJYWjM2V241Q283VFhMYlRNbmhFaGFaV0VWR3I2cXhlV0FxUEFzTzNqejc5bVhSMWtua2M3Z2tQU0llTmZNNncyRVQyV1NGVGR0Wk9YZ3k1dFl4dThZSDhIYWJKQUFhejBjQVliOHN4NXdNR3VTRnJWREZoRFJuUFNBMHBFRWRRVlQzOURqMlhzQ2NqUzhnMk1YY1VxdnRVQ0RMekpZVjRKUVlEY0JUSldKUThPQ1VQakx6ZmZ6R2l5Y1ZubkY4NWpIaDVQc2YvY3VFOWZvc1pZdlBXRnhhV1JKOFBBb0ZmbnlZQVcrV1NvbjFqeGxrK3R1dGozNEpYbEhzbUM2WUdjazVYWGlkK3F4dE1sSXZjTjlnZldtR0JBSjNkcGJON2Jia3A4Q2tPZnlhenZQdnJPOG1WNHRKZFVCOTJlSy9QdjAzVU1lK2FCRkxOdjNoRW1RUThDZkdWSVRFL1g4dlkwWG1icTNDVy8rbm0zY0p6dTN2Q3lxNys3SkZBbTBZMmgvelNSVmNBNnlrMXpVcHJoRjFaQWxXdXNtYTFaMU5pNHZ2Q1N6YTQ1OVlneWtKSkxlZHdJTStpWUZoZk1GZFBWSFlORjRlZXF3ZWR2dlE1OENLY1hsdDM0R1V3cXlycmNQYkdSQ2pvMmR3MjFrWFZKeEg5b1lZSlhacXNkVTZ4ajJOaHQxOFRRUGlxM1Jsd0tNTlhoTFlxT0l0VC9sVFE0WVFMbVhEZG9SZm56Sm5la1dweFg5dDlzbzJDZWw5dFk0Z2dlVi83NWlBekVPNTRuT09FNEIyQldWSUJZUHFEWTJNc1AwNkgxWGFDUWIySUhzNVVhREcwbWQ4VGhXWDQ1NU9Ka3UvTHZ4WFFmeW5EVlhCVi9uaENUSzVGNWRFWkQ4aS91ek1vd2VCNjZBbXJ3bkNTNnh5djdqc3ZQRnVUQU1Ud3FRQ3hjRXJzNzhnVmRONVlzanVaNGxvQXlRbVNSUWN0dWErNHJMY0RPODBiTlVhT3l1c1FFd2J6ZEk0SHd5M291VmNFUGJxVUFtcmYwZzJjOEdRUHJUMnlDQW9RYmdpWDNudkNrc1R6Z2hDVDNKb1FHWC9WNi81a2wreEhWNk9HcnRhc0hkOTN1MkRCL0tDVjM2R05UMC9acUl5Rk1BYmRmWllhQ2s1emdLUldJQWtoMGZmRTN1M3MvYWdCcmFjaTBTQnYxclhQT2x4UG5xYTVhaG92R0VDcitORzA5ZHNQcFpIaTBvOXdMVkRlSTBlVjdRTmhVQkVOTGlFQ3NUejBOcGljRk9IYXFUbEo3Z2hURk12R1lGUTRudzIvZE9TVzlBVW10TnIzdzQ2Skg4VVFyZGNmZ0Q1VHl0MnRtVkl4SjZIT2h6S29ueDhkN3hpNGIwa2dEQmIzdUFOTFpFSC9PM2g3bXhWSmg0UEltbEEwajJBc0pMM0tST1B6U1RtelNnajhqSTJWWU1DZXlJd3NSUER0cEJ6WXNHTHVObm50M2VLZkFpVHJ3WDNjb2lDRHZqVzcwdm9XcE8wMmVOdUt1QldYR3ZPaUk2YW4vNU1KR0JaNEZ0czdXS05pcTdGdjFFclRBQW1jRjlzZVlXaXJVb3lvVGYyT2NZQkVQWU1iaUlTNHREeC9FVVdMKzJVL2crMkxKUU1MM3dGV2pSTi9DRUZneCsrTlNuT0JvMlRYU0ZpRE9TeERoSXN4ZkhqN21GNmRiZE5tZnNGZmJpWGJPaUdETjRIWU1mWjlRWjAydCt3K090TnB5T29oa3hHci9YYTdRK3NnNHRMdDh0YzN2YXRQMjlwRWxVZ2tjbFZDY2pjaVBETENHVko5K1lpRVN2c0FFcEVscHAydnRsN0VyRzZxQjhSVXF4N2JHLys4dE1GdTNKbDU1VWlGNDA2VkhPYTR4UzNHMDdkcWhzV3k5aFhjeE5zZUhsM01tWG5VTGtUQjU0RGQ5NnFPTVpLVm9aSWQwWHFDb0FwZitLdk1rM3Y4d3NUWFpIOHY4VGJrWkQ1V1ZwR3dsT3JGM2JnelRjSFk1QXdRcDVaSUN6OEx2ako2N0FqeklyNDdwelR1YXVIZVI1dS9nWXg4WE9aOVZiK0RIRk52QVdBa2ZYOWxyT1hsUEJaNWJnOHZSZDJXQ1ZoT2xPcTF2Tjd2VFpMaVFEdDIyNjZFeE8wMnJHNmxCT055elV4RFhBWmpDZUtVQ3Bod05mMEZ5bTd6VGhIUDBpMFRTZjFZZUJWUk11blJFRExBeDhhYjVOMHRtbUhnQTBDRzBIOGRGRzlSVThRbmpNRzFJd3JFVHBhaG5WNWFueXdJdmlWWXFzT3ZCMHp3SGloYmlGOGNpTXJEL1dMM1FycTRFZ0xzZmdaV3FxclJoN2wvb043U3AwMmxVWjlISXVEZ04rS0tUSXJJaGR5dGdNMU9URHJEaGkvT3hocXJ2MlFaZzNlZGtBU1Q3R1JGMDJqL0J1c2Z3blpLSzllMzIzb0ZkSHNYUXB3NkVzOEZKMHJibi84RnpnK2taZVRpdDZxRjU4ejg3dUFvc3M4OGR0WHBzMTZwaEtEQ1JJc3dKU3VOOHVrNWNQQlYwQ1YyMzl6cTJpMFVuWkowT3lMalAyMWp5T2lmN3RIQXpwVGZkeWJ4RU9tdmpQcjlQdTFRTUFnTTRJRXZXbFpqN2gycFhreDF4UlFiU0xLdFZ3Z1pacExNYVQ0S09LZU5nUDZmVytjQ3JpRXMydnZyemd4OU1lakZtL2ZTNUtOSDJROElRMmJ3UkNVVHdrRWNTM3pkUnhPdUFwSFRaUTVIK0lFWkRTUGk1dVErc3duanVpaWtFRHZJVEhZRXQrQmpUcVNFU2JFZUYvMm40UHhSMEV2MGtKY3FnQmV3V1BkOFBvQ3BZMkJjOHFiRDEvNmpaVit5aWtLQ1FCb0RLVGRFYzdVcit6Q1l3eDVwN3ZFUkgyczh6VThNRXA5SFhTNW5uZVRkdHJjQnlLbGJ3eEs5VjRmbzBHblltdXlaeEQrNitJL2lWSlZpK2lVOUpUVkdjd2JHdXg1cTRIYURoUExSZk9aNjJnMmxXdU55RGUrb3VQQmkxV1lBSXU5TEtsRjJDWWtySTk0SjhrMEtzV1BxREZ0TlRVUk5PYmVHKzY2bkY0QzZqbU1iZzVQVVFhbnREd3ZXZmp3NG1qa0pjVmJJQWtoalhJVkZGOWtZcDBQc2hBcFc1Z0NmeEh4RWZQV01BdzJEYThKL2RkcFJydXpVYmc0a0JrR2dJMkpYWVZEYWZFMFFKTzF1WDBvUG1mUTR6TDhkRkVoZ0FrQ2djMWZIZkp1RnZBK2FBSk5hbnpVVGJEa3ZjOTBXUk1EQktwcGw5aHQ3cXc1bTBUaThCYTl0RW5IWCtld2pYdm5hRUZ3TW1aWGtKRmF3R00wcmp4MGtkblhITXlzSWJybUFZS1k1YXQybU10cHMxRHpmR3NqUjQ0Z2ljNGIxdjBHRGFEUWh2d1lsQnZLSGk2djJRcnB4Q0wwYTNqUjJXdzliMG12TG13RDR3b2krQUxoUDlaVjZHeUlEUGF0TGt0a1NKQWI5ditLVFdweDRRR245NmRFSGduQjBFelVuUzFTZUoxZjB2cWdBSjhJdVJLeW5YRUU5bTFxTHhrNXNpWkFkenhFcTFIeDYxZlhsV0ZBK1N1ckUwRGI1OGwveEVVU09XL3JvbGM1amNHQzZON1dyUWFnWjkvd09nTUxsYWoyMVhYdTR0eHJEUlBHdXljMStvNVBPLy92OVZkY3cyK1BidVdhbEFCQ3NxQmM4N1IvK3VhRWhOb09jU1FHYU44ZE95KzNQS0NkMGc2NnRWN211czFhSVhvbjhBTVlCT1ZUUFJDcThXQ1hCNkU4SU9qWWxrcVNsd1NDU0FsYXB5cmtPN0VvUU5WVjhsN1RsS0RkQ0NwcGlXRkp3Nm5RczQxMVprQnR2ZE9EQmRTL0Z6TUhNTzU0akdBZlNBRFRlZ0h3a3FjS3lWUjhlSi9yc1lkN3RXRVhRSFErNk51S25GN0lNWjFBV0RtUEcxUlJ4TW1NREhpV2V0TEo2dW5VbmllWUpoUnNZNWFDOGM4MGtud09SU3M2bWQ5bTROMUJuZExiMzE1Nnh5ZnE0MHFVZlFienluVUgyWTF6Z2dmc1NpSUJyejIvdXRoY3NxMGp6ZEsvd3h2UGRuQi9JTFg0REJPeXFGMkUwdEVMcldZSUtrN09QUmpZZTl5eFBDRVIrUUcyb2MwR1hDZjN1T2puRjRpNEo1bHRicTFja05yNFovOU90dWtWKzNiZXBmS1hhakpDczBqNSs0OXVGR0d3WXFnaGdCbDJ5bHIzdTFEWDNkaytmSUhaRHJ4b25tTTNPR2Rqc1NZSzJjZGNFcG9na0hWNTRKdFlBb043ZG5CRk8ya2dpbDljNEp4VldZcXJLMGJCKzdYVVFSNFZsam5zU3g2bDVmLzhyamE5YVFxcllONG5EZ1RQN3c4T016NTkvU1gxSmJtSVN0d2FNdVV2OTFmQjY3UjFwZGFQOWdIOXVOTVoxZXAwWk8zV25MUFNQRWo3U3A0VUpnWnlWNVQ1WTZNU3A2T0ZzOXJyTGxXT0MxTUdFL1pxUnI3WnMzRk9KK2dHOUlGWUJXZVBLMTU2VzBNeUE2TitmMzJWOHBDR0xObWVJbDBIclNsL2wyNVREd2J5dStWeTdIRTdrVjZxZlc4Y0JPang5K1k3cXRxM1ZqYk9jaWI5L2JjTy9jbWxqdDJKeXpLZzBCaEhmN0xpVmdaRjNld2FaTDJmLzQvODIrT2ZhaVFUL3QxMUJyUHpscHFlV3gzNDFMcktuWUNyZHRRU2RINWVPNno0VGY0RjdYd21HUW04NERRUU94VjAzL2I0a0E0NWx5YVNVVDNqbDNZSWREeFpsK1BDVFRuaE5NZTJhSWFCS05XZ3dGaUVNSXAveXhrcnovTHRJM0h6c2RMQmxUcldiYU1QSlhURURkSnNGb3ZnODB2djhUdDIrUTlUSnpiNDF2STFvRnQzSEdRUFNQSEkyOUFZSFBzYlJXYWhkK05EU1BxME5jNWNKVnRuL1lWK0toTllmbUExejY4RWdFSjlCTjVVR3Y1Wmt2cnl0R3J5c1pOamwvY0tqN1k5bzE3c2Y5azJheXgzVjAvOUJnNWxLMzIyODdDdlByWll0RXVkWjhOdzcvSWJaaFpFVHJ0SnN5WDIvNFMrZkxCbkxYVnZkcllucGVNeEtOSUs3YmZiaHIxenIxNWN6YUJmUUxYY1RBaExyMUlhZXduVjJtdlh1ZHQ5dEMyVGdYbUdNTGZTUzkyT0ZjQnBuRU9mNkh4d1hNYndJTlh0RFJHVWpvRkF5RHc2djQzcm1vT3RDZDdSRDY0SktaeTBJL2F6anVBT3dBcTY4YktVMjdIOFdVV1kxSHc0Q3FvWUNzTTBPU25DbVEyUkU2ZkN5cjBrd3gxY3N0MmxKZzE3cjRYeDhkd2RvRTUvdC80cTgwOTJ4KzE2NVovcytvL0M4bVoydFRTcU9ZdS9jNUZGWVptVVNrakN5V3FRamdDWjFHQXRJUUNpcGxGMXNrUHVrMkhlRElUa1FodE9DTWZVT2JraG84Y2dMQ1ZuTHpuV095bXVkZDhWSm45QlRWU1FLOHJucXlrWmM0Mjd6R0xSUmxxSE5tZVZXSUZkSlYrYUZPOGFUWlJpSFAxMnRCMzVwR1hiUXI0dzZNTC9SblN2c3F5U253ZmN1UWRHc096eWt5NjdScTczQzVSdyt1RmJ2eFVXN0F2U2Y0MGd1VHlBL2ZSOFd0VEdhVVpqNXRBRmJsRnA4UmN2TkE1K3lNdlEzOGtSYnlMdEE5RGtOemhTYlBJU1QzU1UyUGdudnNtUmJpcXh1bm5vQVhkdkJXUHBwQUFBMFJyaDJyTDNPMVdUaXFvMTBUTGRvakcwVy9WOGpqa29TU0ZPc0hMQzVGblNZSHpOSzk5RlQweEF6aHZJdjR3ekNzL1NuS2wzUGFDUDVSNDZYaEZka3VrSXRoVUx1UWh6ckZKSXNnOFZ4aVQrR0tTQXhiazAwSkxKSkZCL0FQNm5aRWh1Y2duMG1UZVVUdld2UG1iR1VOaW1mV1I3eDNocEpYYVhIRFB0OHRqeXU4QUY4TlU0bmJSc0huS3ZXblZpaDlUQlhZcTlQNTJSR2UwNUd2aGtBMk9mSFZjcG90RE1ybzZPYkV6d0RVa0JBbEMvMGZzck1yM1lDMSs5djczTkd2ZEd0VzBJdjh0WUxmazQ3OWxiTk5FNE1yODBCdVE5anpYZEdEb0syUDR2ZjlQS3MrYTg4ZzFHVjRtRWVVK0c2cXBzcjgzY0pTRHQ0ZUJ3SnU4dms5ZThzNlgxVHkwMk1LWm5IVEdXMmd4NEFiMGUrbkNWVFlSb3Y5RDFxa3Vrc2VBU2d6R2FRZTNYVThJZXFEN3c2RVlEeTNhNUxONnh1eDRBdmlSNXlJMmhyNWxNdVVMZVRxYTgxM1l5ZDhFbDcwYWpsUytpcXQ1MEEwdHpZSThMdEVxUStOM1dDOEJ1Y3JOYjhqczNKc3BxK3ZFLzJwSWlzVzdWTnpmZlFKR2N2bGlpYThkazBCa3pweFNRZ1NqWHpwTWZ6MlhIdm9DbnZxU3E5cVVUbThvcGhzRmo2a25jZW05NVUrenpvVUlZY2lvNHJuVTBFdzNQVEw4QWlvUG1UZ21PY3F0bm4yeDlCVTErMTcyZkdEazFyL0VZSjlWMEhTYTJGRDdSaVBQUXc5TmMrbHkybnRTSDFncENvZ1BZM1Q4aUpHbHhGTzlTc3ZYZHNwei8rOGdjamJaTjArQUQzM2FWTDFxRGlHL0NjbnVIeTRxQkxzV3cvWTVMaWVLNS9jQStFYVVzNDJQWGxEdzEwdEVRaEQzU3hwUVhhUGpJTTBGa251Sk5HMWhXd21iN2R5eFY5ejJoTE1EQVpPRXJxTUFXQkdwWW5peUVmR2ZZWHkxSlg5Z3ZLcWNLdDBMM2M4UktXbkUzNEFEdno5ZGU0Y1ZWYUlXMnJnQjUrcGRhSW9wdXU4c0sreG9uUnBIdWtvQzFOMzNUK09vTGRsazVhVEhUOEJWYUtISzZuM1A3U2U5L25QV1loSXBlbk53U05PSzVma3lyOEw1WFZoMUVWSU5pWm5mM0VFa2hSeEFqY0w0Q0xnTmtEdHZSUnhobFBxcjlsSWhmUWxHN0RaQWdRbzU5akxKa2FTT1hENkk4YU5yWlh5VENObHVLY0N4NmZ1bGNKdWZKbC8zWTNKVFlYcDZyMmx0TnlIckg1bEIxM0d4QS9VZi9kYVhLQ0J6VTJ0angvVGM2S2dnbmlLTGV0UGkraW5Wd2kxdVVTNFRLQUFyS1VMMlBCNnNQeXgvRFE2SkFCU01rZXpaQm1IMmtxS25Eb1I3S1B5endqdXVUWHpiRjBVamNDMHhFSUJteTc1SXYvRzBuRnJGQWRpTjZ4Q1J2SElVV3ZYYkdqNHRZVVdOUDRUUlZSeXpMVzNWdHphaTNYWXVlV0xNc3VJbnZSMmovT1dheEhaSUE0b0tRSVk2RzErVXFSZEU2TktiUTZFTDFxWDNZcGw1Nm1BUjBKSFVVbmJ1WGtvcHB3emJXTENoLytPRXpSMGk2ZFp1b2hUV0dLSFkzK3pHRzNyUVFkTlcybEY3QkdxU0ZCcmVMU1hmRyt2MStzOWFTM2dYcmVqVnBlRk9mK3hXN1lIVWoxMFh1Zml3RXVhb0RaWGYwR0dyaWxPSE1MeFgvQk1DenhuazcwVFpmTTl6eDkrOWd2ck9QQzdZeXg2YXJsWmVSMy8vNUZ2Z2J5VjIraEdqNFJyTUxoaVRnb2xiRzFHZXFSL2hCaVB5UU1ubThQQS93R1lRaWhsL2l6b2pKZHlhTlM3ZFZUbXltdTBHUTZUY2J6OGlUVlNBaGpLY1Q5dm43bUhkQzkwMmhIK2FZZnhkRkdwckM2dS9qeHJmLytzaHJzdmQxTnl0VHhpU3VjeHZDbEZQUUtLRGVMd0VqRjRRVlpkS25OS3JlbjlsMkM3bGZybS9lRUdOcnRTR0trMHYxLzVVOTlGNVZza0ZKOHJXb21pTDZnRzVyd3FMVmtINGw2dUc2ekxSaE96eUpWMmdMMEhGNGtOcUlFSVM4c3lpbXdvSzBWSjhnczRtUWZHK2ducnIzVUNQMWdKeElwVEF6V1hRbENRMlFWRHVTUlpFdVF0Rmo1Q0dkOFlXSTJhOXkyS0JTN0oxaUtKb3ZGbm5oSjZkbkNKTUgvSVZvemhRU2w1QUpRQTBiU3ZJbVBxTUd6KzVhampXN1laYkQ0U0JlanhOZlF1K3BBdVl5blcxdkNzVGxpdEgzWkNMS1VCaWY5WWgxZHVvc0pYaEhvRUc3NldsSmpNVm9FalBWMm5CVStXVlpDY2VZZS9ySC9nSzNVYlFPMG5qZFBDcTc4bXkvbzZTTE1FVTNQME1lOUo3dzF5SytSSzdUMG1CY2loS3ZRK0JNMXFDSGxyUkkxTXpuN3A5MW1OWVd5MEIxUGt5VVp3NktlZDVrUElmbmlzMnFSNkxlT1g1NkdpUlM1cVk3MUVKb0NiTlJzY0ZzZTl2YlE4d0JUVHZKWVdrNTFQMGJTbFFzbmZPQ1VaQlRhSWNXUFUvMER0b1JIaDhSV3p6QjdtZkZ4SHQyR0l4b3hBbVA5TXE1OFluZE14cTZicWxNbzh1SkE5RkQ1T1cwRlBHNCtCUk9hZlV5NmVrMi94OWd3cEtzNHE5dUhLQzlBeVZ6UzNrU1ZlcFR6aFNmZjJ6SWgwK1d5dElRajVjK25uWVA3MHVoQnIyOHhzUW85VG9YYjNFR1pyTXVzcmUvR0tSVm5ZK2tGd2RoV0VPUlVJa1Iwc0RzM1U2L2RsN2xRYmNZL2EybGY2b2ZYSEpPOEVMZVJ4SERmUURtUEN4ampQcU9JbkpHR24vSnFXYkpIMzVsTnJmNzg2SWZjb1hkcHJOcTJ1RXdNbGREZ3l5UURSNHI0TTg3WkJoS1V0aUZsVkRNUzFOUURaRGo0V1Y0TWovd1d1QlJPeWlENm5lOTVTTEU2dHREQkV2Qk13VFZtRVV5WENvV1Q4dHQ5Tk1RUmtNa1ptSHVKSHA4R2NWMlNlSUNzRzI5a3RWQmlmcEFCU1AvZnJQcnk3c2NpeEZJVnJMMytralZtL1FwUXRBU0ZlVmJTVzdUYkVZcUY5ckVDdGVpV1hSR2F4cWxVd2dackRaSnJ2RUNLc01MeXJjODlDNVJ1UlVZWkhENmdRbGc1dk1GclRoWHRRL2xycHQyK0ZleStyYVg3cUVaTHR6b1NvV2IrU2FJeVVhUkhZQVpjNnh1V25tbDc5ZEdDT3dyYktJODhxTXV6bUovTjI3R1cxb3R0Rm5ocGl1YlQwc2RvK01JYVlDSGhBa2tJRnI3eTZmNWU0Ri9iUVpLaWxZdS9DQzhHK0U1cWxrR2RoN2NhNFpDTWtuaTd3SEtpUkNBdVl0RGU3dEdGOFhhY1JOWGtQSTVGUGtRelU4cVRYZFpPMm01bVBlNUlQUlVuVkE4c2p2Y0pwQlJ4cTdlZ1NKTlNxQUMrSkV2TjBzU0V4dHh3UlZwbnVVOXZhd29PU2dQUlBiVmJzVk0wd1c0WDF6eE5JRDFjNGZicFdIVmN0SnpGd3JuZTY3cXArWi9SeEVZSW4zclF4SCtoanh1MXptdnBNWWJ4djRFZlpUVVF1UllxdnA0MjRaWlBWR1lrMTRPNUlsR25XYjVxaGZqamRNM0IwdndlWWJXRXdBOEdxZEJtOXN4a3hvakZTRVAvSmcvczFCckJMMTFnT20yWklieHppb3pqdGNKRGNsSmNJMWM3eFFGTGxwN1RTdndMb3FDUThCdHRteU5MTFFZbVdaU2tlQVhKWnh2K1NQNG1nOHU5TERqQ0poZ2tTOEdnVmM3WEkwajE4a2FSZGV2Smc5S1pYNnlJR1Z1bHFkOFJvUm8rU2Nhd0NRUnVPQkcxNmc1MmhCL2xCSDhaTERsTTZGWWlJVnNBU1NMUlloRUZ1ck50Ky9tbmRZNGl0WUc5ZDg3TU0vUWhsbDZHMkhKUG1pdUdKR09sekQzSDl2dVVCVk1sSW5ST1RTeS96amZ3UDA4bUthOW1EY2YvTzlCSzR0RTRmREFnNi9QN0JFS3pORklNNm1QOUNoNVNaNmZhbitzcFBiQWxkL09RZ3FuVWF4SGtzS3QvaWUyd3A0QUIxbS9rWDdGbFZ6NTU4eEVJZFlmVzVkam5ZeExGNDJZMTVwcEhZZ2R4aU52b3hjR1dXcEJXQlJiNTM1ZTNHaTN4YkNFWEhBaGRSMkdyOFJvOGNzTldVTTdURndUcW9ONWJNemlLbmJncVBQTVFSczRUOFNLZnVORzNwblRtMEwzbGRiSTA5YWk5RTloWStGdS9zWEMvNHh3MW03bHhxTW5lUFY3ZjRreUVvQVM3WTcwRnJzd3l0RmJKMmVzcjJMRnhxU2JWS0l2Vzc2QUw0Z3RUbENIcnNPaTFOWEU3US9RamNyZk1aYXZXdUlKS3pwR0c5bEFFQURWNExBTXFIWmJqeDJHWlNZeXBINnU3Yjk5clZxOTVNZU9tT0I1eWs3bmZOZncxMlRoaVdSVjBNTHpnei9PZExucGpwQ1YwUTFWN1lCeVZMbVFNckkyWlJGaDB6NDhVNURjUnRmaHRRbkdiVThaOGRsb09seGpFY2FkZ2N1TjkxMWZnUmJMemY3ME5ib3JMNUIzYVFQZ0xtU3l2U0lGcHRWUTZ1UjJYM3ExK2o4YVJOdG5ZaFpaQlB6MFVNdTNwYys0VytrVDEyTkRCV0k0T2YrNlFmc1k0ZTVBdkRQcTRxbDR1M3FLRUV0QkdlUm1oNm0xcWpTai83ems1cVZVMjgrZ2xJNW1LMkQ5dGc3dlB3RFVLd3oxNTk2VXUrNTBML2xpYWQ0T1I5M2hMOUdlWlpOajBwWE9lUGhmaWNYREEwbWhKd3RkY2dpbk40c0hJandqNDZKNkQ0NTgwN2dQczQzOHJUZ1NRZHdoRlZwR056d1ZWS1BTTHJnQXFsVU9UYVNWTUxwMGkweitLVzhwMWxPQUZ0OEpERmsyMktZdDJmaFlxaTVpM3lDSDZzWDFXSlNIa3VjTzYwNXdQcDMrT3NEOTZGTi9IZE9aYUdaS2puZWFnQzcwMzdnakFGNlJBYTF5aFFaMEwzQlFVVGJmSGdXNFNDTlJjekVZZ2dCR0dwMFFBZEEvbUJzTEFRQXpKc3FNYmc5Qm5PYzNheUJDUjA5dEsvaEF0SUxEM3ZBMmg5eVlzUmh0a0RWV0ZZUWMreW1xck5aTERDWjVlYXBtRG45NytrTUdObW8wbDNZWmJiQU5Wam9NTzhsekxGK0VGRUtJMGxmVVhhTXVCNi9UNGd2Q0ZOQVFha2Rob1Bwdm84UGgyb012S05Cd2p0MjRDc2lvaTljcFJwd0RRZ29Fdk1wdS9FZzV6VDU5a3hhZXZKenA2U2VYRzJNa0h2dnpFUTllblY3NllObVlBbldsdk52ZFRjVEdwZXUza3lYaHFZSk9ueWdMTk1QZkd5MEtlanEvTWJFTU9sK1ZNcGRoQzNTaSttM0NneitEajJWMjI4NXd2OEdmb3dJL3ZqWVBhY1lvNitWZ1lqMW44YnNRMmNBdjZwUGtnajJaMmViVUVSODhyNENYRGwvYm1IRmJFc25XdkZaeEFYcWw1Snk3TnpLR3hpOE96cWpORlVpSGxqUTZqTEE5VmVIRkVOWTVCVGpSMXgzWE5GQVZYdXFySjR1R0lMTERNdTl6REFlQ2pIRVg0NXczU3pnaENwbGM4ZldHSitHWmtrOVFqaXhDWG1BWW9TZE81eng3MEdNeWxvK2VTWnhPTi9xbDVuZFg1WmIwSDFSUUNINjJBd2U4K280L0R5bzA0WlR1SGJ4YkxqbzBTR2NwMUFzMEEzNjF1MTRzQ2hOenpoVFBBaXhDRkl2ZWlOeUN1TEJyMHhlbVdHSVpVNjJuZTFFQS8rS0YxN2hWT0NEQWN3REwwTUpWNTN2MDJtN0FsMi9Cd1hTZk9SUW8rckNkaHZ0Sm1KUG9CNGMzbDNXZXJUU294UFI5M0NtYmdFK0NSQjFSSjgrY1VMSjJWNmNaeC9VTXVPT1hDdi9XOFRnL29UUzFuUy93eGFudFhPTVAyaHZGcGpFTExoYTRqL3ZqNzE5Ly9DMUhiRzMvczhzaEt3YlpzQlpCcVNpT2FRdERlV0NudkphMjJKTCtlZ3BWNzloNXZFTWVWWDZvWVFQK0xOTDQvYXZUUUlrUnZpRTIrdEJNSnE0czBUemxkNzhyRXZCMFhzZkdsU3lRaW1Da05mQzlyNE43Tng5NDUwLzlkREZWL3U2Ni9JelBxNkRWcjdSSXBzNkk1K0hWUnJtK0tMb3B6cFhyWmVMaTRSUTVPVEt2WE5GbDMxVjVxT21SOG9EMEFqS0VjOFh5Z1NmZ0JWRmNRWU1wVXlXRWlRdlZJQlgrV1YzQUhtZ1hrZ3hyNW1mbEM2V0huaGdDK1AvNWdiWklaNE90RUNXZFY5WXlCVnZ6NnY2OEtWRWk0Yks3aU1MNFBreWdnQjZBTWUzcm5OR0JmUHdKRXFVbW1sRGt3cE1laUVIYzJlZDJyV0Q3cWkxeVc1UTVQMytPeXF6QXFiYzN4anZNNmg1Z1Z5YkVKK2d4QjUvNjVXYVozRzRlUEdoOWJOaWVoaVIxTGVTZXlOeUVVZStYaHNhVHpFY3pYWHZZNWtMUERoT2REWDVOMkVucXpmMXRTUnB4QjY3QTc5ZTAycml6MlVhclNTWW9wS1ZuaG9RbVc2Um83UWJYSEJmWkhUdnBFaU5PbmJNZE42ckpuOUxwVmlHbjZIOU1vOEwrdlJxNktROTllMDcvLy9IeElkUGpyajcwZXAzWEcybW1sWGhGWVFYeUltY0orNmVyZnBER1ZmUFMrdEtVUXRYMkk3WFpFMm4xMEttNkNPbHk4VW01TVhqYlN5clBDakpIaWlkcURNRG1PZXNoaVY2KzNpQjhJb1FabkhaZU9tUkpaRjV4MDJVVUhleVV6cTVZMkQ5UEcvRWszSXlqNlNyRkh3VWJ4dW50YVRWZkM1NHNHM3B5eDN5SS92RlZpS2pTeENHWmlYK2lDdThFQTRma2tOZGxoSmJOaDA2NE9obXo2aGY1QnVHWnVHbVZlRlZYUUZsM2ZlWHkxWUlQdk0vOGJCdVNQWkZCVmxZYXlJYXViK3FJa0taMEN6TGhnWVhsSzhGMk42dVo3MloycGtMLzFxL2dyQmVuSHFPb2ZNeURiM2c5aFdBYU1sMllmTThXSWlKclVWNGtJWE5wMGFmRkIyT0drcTFtMHVXTEFkUm1nVk5GNHJmdy9qN3hLSzFuT0hXTUdVakk0ckYwSjlqTGducytZc0dvTVFBNzFjT2NFNjhKWTAvbFVLODYzTTVHaytQcEFNR3cxa2FmY3pQWkN1V2FNb1pnbS9SQ2RuVVJYV0E0aExIRnN1Y1gxMlRzM01QSHhmL1Jpa1BBcHFRZWMzYXUzWW9LZ2RRNVpUdlNyL0h3K0h4azExUXdWN25BMFRMM2g5bjF4eEVURzFzTm9laU1UT1M3UUt0cUV4TGR4N3hDNTh0NDc0VXRqYjhld1JlMk0yL0J3Z0h2QThtNEZaR0x1UW9qREFqZm0vMDlkYVVYMGlhOUF5a2lxVU0yUko0L01BQksxQ3U1d1JTcHFyL0NQMHE4UnBnSktzTUVML2JlNkxYVSttQm1pZ0xSYWtYZE1EMXNBRjRqa1ljZzB6UXB1NTRYM3ptQkRFWVAvd2lJZDRlMHNqanRreVpRa25uZkpvZ0ZYM3pFUTAvanZ4ZEIrNWtMTVU3QlQ3RjFGN0N6eUhsQUxFeDFwaHJzR1dwVUp2L280R09VYmNoR3BVNDdmWDJFMUNpT1IzQTZkOU9KZTdiZ25TbklkOTkxYVBqZHBKZEFZQllOd0F2cGp3cXhXc3l6aS80dTY4UVBsQXBQZmlqbEFrR3Zkbi9zVjFQMlU5d1hDUHl5RThUMm05Y3VrUWF6blJ0SkZBK0NsQ0QrdVpEL3ZVb2ZsZDVWMFo1cmhDSWlXamJGNHRwQm43VUFObFJWcERZQlB1Z211andZZlBpRTNzUXlEMjROb1lBNDZ2K3RVRVEwMmNuQ0dhRzJmMG4rdWJBSktaeGxvMHVHVDRrNlZDRU5wZjFCYmhNK1VLME5jaTdBcTVlaUtjbktaL1ZpUFBGTVA0T3NXb21lSFh5cVZOYXZ5b21QR210c2lQc015dnJvR0VObDhsOU5kVy9yRVF1RE0waEsrei84UE56VXp0OG9YU2xwQ0FkZ2RxQXBnaWlIN2dBVW5PRURRT1NoMnVNaFFLcXNqZzMxU0pjZXBtQWc0cDh6SVRpbHpSeXJFZU1CVmg5dElZcitLZ3lCaHhLWW50Z2NGc3B2MHEvK0M4Ym5rU25MRisydXlFYTRqQi9qb1NZY3Zrd3F6d2RlK2hOdnprNHUwT2UyNGhrU1dkRmFudDRLcCt5Y256c1JRa25vcFhZcnpwcVY1SEdlQmRlVnlFSXNtRHlxNlVTcitVcDMrNHd6b1NMbmhMQU5tZzIxbmVWSWN5cUUzLzgrWDFFRkdxVTFpKzc5U2s5Y095TmVnTTl5L3lpSWZpc0FZRDhCT0tLZE1GWXNhZVBpS2Y5SnVjUkwvYXp3L0NPc3B4NmpYNUFKWUkxQnlCVUpncnpCdFVtU3lrRUNUVi9CbHoxQ2tlcEp0bjVVamNFWWJNcWZHN1YvVFoxdzNSc3F6blpDdVoxM1IyNG1henRabkUzSyt4V2g0NUhLS0pnQmI3KytlYUVFVlRXSTAzMjlQbG14RzNJN3R3YmRpaXFRcGJzMk1tRElQNkk3dkZLTW1SbkRzWHVxcTFab3lGcTJ4ek9RZzBwSlpGUVcwb2Fhb1lBNkR1d2JjbXBJWi94dE1aa09RaDBhY3Z5ZGE4bGdRaXl4WDRGRkJteTFkNnA4TXdxQzlKSGlIc0s5M1NmNGl6dVRRQ3VZaUFJUS9YbTVIV3dCV1ZQR3FiaWhwbktURnlNcXV1U2ZCUzRHN1JLNzh1b0tFa2krNjRvbXRNRGxKZng5TnpFWU9OenQ3cDl4RGZqMU1CTTB0RTE0VWlaRzJ0dWVnRFoxeko0NkdmbWJhaE80VXl4YjNwL1Jrd21UOHlxWUF2YzFrVFYwc04xc21OTGVXZWpNdXRMUmIvMXR5clIwNnRQYnlIY25oNGdOdUwzTWFEOVNVMEkvY2hBbEdtektxODJXQUI4K2w5SWtNeWw4MExvZXlLV1UxeWUyYk01TFpiSnhxY3dkaGNvNGhzZWJlRGI1dkFDWTlIREJZU2ZYb0ZjbENZTEJ6S3NRc0FXRmt3VnVmbW1jQjduTUdkeGhxNHZlZi9JSVVUM2kxNUt6bjJlU2pzaDJVRGpRQVBSVHllYm1CWEIyL0M0ZVlFM0h5ajE3MDZlYng2S1lRdU5sTVo1Q0hrcU9Vakl4NHdLakRWQXo3aFJnUWtOd3g1REdKNjJVZlNuWmwrTmlYSjhpckI1YnVlTFRNRVlIKzB1ZzI5WVVqNm5nQ0x0WDd0RmpRQmpqOXNyWnJVcEU1eFVYSytmZHp1V2lWS1NWc2o0bmZEZ1c4ZStrekFhUXoyWENMY3ZsZ1N5UzJLNXYwdjRjNWMyUDUwdUVNTnFlZldKM0haVC9lWmlXTk05ZnpDelZQTGM3eUZwcWdlK1BmbzZqZ21OWk5DRW1RK2J3UldLVnNUZHBTbkFzdkVTYVBPbkZOaTdmbFZSTk1FVzNyekpJeGdHQXpNRG5yRXF0eEpKMkUvVGdKUWtYQnh6UE9qNE1kTW01TFRRTWhab0V5NVM5WW52TnFEVXBueXlLVUV0dlltM2M1aG83akcycW5Sa28xWmFsbzRUbTBWdmk4VHJ5UE5QbXAwMmc3ZTZPSEdZRGtFV1NRMTl4ZnNwVi8vZWlNVEJjVFdvM0NaR0x0anE4Z3M5TDgzejkrNkFMTkJwMytsbG9kb3QvakNIbHk0WWIvc2lJbFUzZUNHVTBZNUE2UVhZd3RBWDdqblRDVy85KzZ2WEJXakdPenpMWm5Mb3piTm1oYUZDN2JyWVpNOXdZNEQ1YVZVWTdhdkExTEFsRzYxQjc4NU4yR1RBNDQ0amlhaHpuR3pFcU1EYlJXdUJWaTFzNmpVOXBhT1IwaWhjVjE3SkpJR2hZNFNoVTZDNlZ3NjZPaGNQa0ZwTXIxRjFjZSt3M3k1aHVMVWJadkpwdlFSRkxJV3dBZGxoVUZFUjg1bzZzZkluWi91SW9BOERNV2JlMHFHZ3hucVgvU2NPbTRTZHp5cnA3QjNxdUFDaThXZEtWNnljTFRxZFA2Q2JGczdjdGk2OHhXWlZYV08rT1JmVWFMaGYzNHJiU0RuNlkvdmxxeXp6emhrYnVLbjJKSVpXOW1pRm85QmF3dGdzWGJ5UE5WVU5WZHZSYVhFdTlMYjdXS0VvNS9iUVdCZkpNYmdkWjMvclZoMTV1ekRRVk9SZ05BOVpyR2huUEFjbDZ2bVN2ZFBMRDEyM1JUbTJpN0tNQWhBR1B3bDYxano3ZW5yVUJMZVFhWHRpZjI4ZVBKeEc4NDluaFlraVNGclBWZFJBR1d2ZjF0TW1RU2pZa1l4UmtFQ2pCdlRjZTA4NWNWc0lyOHlkbzZSbm4xWExTKzcxd3lhT0F3WElNekVacUloQ2FBY29DUU5ScVhQVm1Ka1ltR3ZxZHozL1RQVUd5YXVjenNFcG1CT2NRWXlpMHBQempwKzZUYkdZN3VWemVTOEZGbk9YOFRQRE0wWGQ2K3JyS0o2SGRCdS9ZdFkxL2h4eUEvVkJsRXpJZHp3RWw1b2UzY0k5Ym1XRm44b0VIeG1CUW1VT0xESDZDV2x2V1IvVDI3VTJOaFZkQ2VISllRZmdreDdZeW9VVExYZ3VydW1vMlJVQkJTR3ViTlNIakV0Qnk0dCtONTZ1U0lCQmJraS9WSTQwNEsyNE9kVFVsWi9OSEZ0a1VPL1hoODBTeUhHUU5YNzFZMXVJTUtiK0hqRGdSbEVmWVpxSkZpTFBWUXlzV1RQdSt5UmpFZWlLd3pLTEFJNEtDS3B6U3hCOXR0U2VuWHowZE1qNnhrOEhoaVpwSTQ0dzFGV1pkRWlnZDVrNnZoQVkyanhQOWFmdThMcVVjK05vWnY3dE12M0hEVmZnM2orSWpnUHRYUktpSEFZUlhwZ1pSZjAwbDRMYm9sakQveWV4VjRxREd1ZVVxRWNwcEJwbGttWTJ4NXFUUmFiWUM1TXoxNDVGdGxrOGxQOEVNVnlLTEx2NDhXRG1RYU1XdDdTR2svVVVBVVlFcWtLS0VseTFiQWJNVHVNRkVrQnlhUlRyekc4d2xBdks4M0k5ZTV5czJxOEY2aTV0MnQ4c1RLQmhScUFuZjFOQ3VpTWFyT1RhSzI4TTNJdllJOXpyTjdVVmdvejlQRWdteHhuVjFWbjM0Nzd3NFgzMzB6ZmlhUmlVTXNzeXZMT3pQbWtobFB4QmhCbDIvM0Fzem1LYjZxZ0xEbko2dUhKU1VWWFdWOURUczRjRm1SU3I3RVNrWkwyYzFPZzBhaHBtQ3ArZU1UanAwN1gyaWFvWUFTUUl1ZFRBSHZnbHBrZVIrd2MzTTJSTXVlTkR0TndqbFltVXZmTTRuMi91V21ocjF4RHBHcFc0VEVPcDVMR3RqRmZrWEd5RkZ2cSswSjlScVNLRkpBL216NWhWQkpDeXJwdnBwQkZ4L2VXZ2s5RmpiOHhKSkQzQi8xVWZjOW05UjJCUHhjdzE1ZTQxckVlN1lIWDhOMEo1b3lqTGRPYlRmWFVlNEJvMmpOb01xbDdXMGpLa2ZkREpyTVVuNWVBTncrelRJdldTVTl1UWI4VVBaeEtsZWRiWmhZOWpEOWhTelMyUzVMZmFOcTFocUtKdzhvNTRYOW51S1RiUFJFcExOTW5HSFY1UWE1UHdKUnJiblBuWDNVOG1pUFdUcVJKV0laZGx2M2FmejlXOXNaSDRGVTFVVG5qaXFDSUI3OWpaMUQ1ckwvVlAxNk9TdEN0eEdwVkdHVU9WN0ZaODI2TWwzOEE1K0RpdWtWZEJ6MElTTkZidElNMndzeHlBTWREcEIvRjRsVkhCRXlHNjNXSlkvQzZoeEplajlRWCt5Q3lYZ3l5K0dFU1pvSzdncDZvRkRPVlM5b05HZ3ZldFVYVTlkRnlWZ29yTWhVa3ZKNkxua09YSjN0YnRsRUN6WHF1VHZsWG1nRDFSczNaZ2lwTkd6dlZlczMway9WbmQweXdJSG5JQTllMk1NbmRaajN4RDNNM1Y1RnB3bjgrUUdNOUJCcWE5TjNLa1I2ZzRVZVhGT05OMVFxUkhhaXhUeGxSSUNRYUFWY0lPUHo0RVpyS04rbVI0TmZXWWpVeE01K25wSGZoYVkyRkFyUkZWaEdsSlJ1RkV0M2lmT0g1RWlJejRYajJFcXpyRE13YWJqNzFQNXZHRXZHMlJRYTRvMnkxWlBLTW1YMEFuZFlyN3hRVVRMajBnUW1tNnVyMXZMQjlWQXlEeDltUEh6T0VENDI1ZmtkdmNBZnBCYWJuNjFTQng3UFVON0hOS2djUlVPczljOERLalV4RXZjRUREblN6VXlDZUFKR2xDVnVrZkxRWDUxejRiUjdLQjhsVkRIMVBkdFJ5dkkweW5LL0hiUjFEajNWdkpiS2MydDNiUStnMXcraDloTmVOelNSdEVTdExPWm1mWm1YdGRWMnl6Z2hDSE1GVWpBbDRYY3NHSVVRSG00Rk9mQy9BMGpDdUdnWmVHTGcwUWZsZTJYSm9GeHhBYTJkYUUyS0Nmbyt2aUJaMEZadHNNcnRnc3VzZDVNVEJEaXl2S0hETFlmQ2RRVnhZV29EUC9sQUpnck91MUlSR2w4SzRkb1VTUEw1Q0lTTFpWOTRaaDRiQ2p4YzVWOUFTZEg1QWQzR3M1cEwvNzNMeXV1Q24xNVBLeThLREQzUEhmekRRM2NFaUpwanFEckFSQXdWNVkxUmRJVk52LzNIOENhYnc4Qm04bDFqOUxGbGhkZFVNZFI0aXpLS1ZQNnNQNXVaNGpsQVppaHFBWlJ1K2xJVEQ4QVVNd3dOVVoxODlnS2RPWlNDM0ZGNGxLRmdEN1NnT2R3UE1yd003bkNrNlF6T2Z5Rm84ejdTbEdOeElFZWg0b1B4dy9qaUZoR0t4TFVmcUF0UmNteDZydEZEa0NKTUpIaWl0d0Z5a2xVbTFkcUExc0pJZmhpMm9sN0haNmU3ajZVTzVxQ0E1Tlpnemh0TUMyNkdWQXJzM1dRNm9ESi80ZCtpMEZBelUzaXQrYTArYVhjLzJsOUZ6QnpyemVLOGp1QWQ2WXdsV2ROM2xrYWdMQllVU2w4NzhMTFZoM3ZzQXFSc25MNU1JZ2FxR3EyY09tQm42ZVdveUtvSXJITEJlZFNJQ0VPa1ltNWM1SE4zSWZpWWFLNmVqVHRmTzBydUxhWEZ4bWsxTVpidWozdFNwS2lWbS8wcS82dVRMS2dPYUs5Z3BtNDMvem5KUkk0clpKVkE2YVFlVnJiVy8vSHJWeEVKQVpHeEJ5d0VONVJmVld3SERDMTVLVkgvNEtpbTQzYllqNjQybVFSdEtoaFpLcDA1MjhzNW80U3d6YUx3STNPRVdvSlFicERGaVVrekM0QjFHb2ZYeEFkUDdMMFBySmcxbVA0TT0=', '', '04 Jul, 2021');
INSERT INTO `pages` (`PagesId`, `PageTitle`, `PageDesc`, `CreatedAt`, `UpdatedAt`) VALUES
(5, 'Refund & Cancellation', 'b0Zka1dHWVdUZFVJSzBzd1hmdlFyL2pnbHZZbVcrczdlRTA5aDZ4VE9uSWM2dGtqc0hJQnFGYXFGS1BpaWwxOU82dHU2MmhGSGdDQW4vWFo2dURwNERqQ2lyaEw4VTR5ZTVJeWpGTWZIMWVVZ3BUVDRjWCt5WVhRTmk4Sm1tait0MkJoZHVMWHZOajJXZkRqekc1bWhqZTBzdE4vTDZmNnpwZ0UySnBEcmRDZ2hUbFcxblZJY3E1U0xDeUN6Z0llMUhrQ2RkSi9oQVNDNEpiZkRPak1YZFkxTHBWUHBDUUV2aUlPOXRBeEltcXRMd3lkaEQ4M0FUdEx4ZWswNzRQNUlBTEdRVE56ZVJVNWdvcHpMN204Ni9pZzdOMFk0S0tyTkgxRC9QNDN6ZGxJVmNKSlVNZmlNNjZ6cTg3WHROSUVVU3F3VnZGcS9qVjVZdHVET1F0ZG5UYkN3T1Ivejk3Wm44dWgzd0xxRDlhQlpqS0F1QjZYNk5CdWJ3ZHRGZlhERG1scXBUSkE4VU1qM2l2ZTg3T2s5YWxzY1RYQmxud2cxZG9rTU4wZUw1aHRzdFNGNkE1Y3o1d3QzdDFZNFZzTmpyVU5oMFdYMEg2UkNBaXZJb2haWlNRMU1rMUJsaWRBSEFGYi83ZXpiTXBYMDVySHFxeDRFWTFxZWlxWGNKTVhYSWZFODcrbmszNnM0VVh3bG1LWGw1N1NXajBXcE0vWVE2RGRvdkFreEExT2hhSGI1NmxRYnIveTlJbFVzZVFZNG9ISW8vQTUzR2VoT0FNaXl4WFMwcDRJc3d0TGlDNlNNQUprMDA0c1ErS3NPVmxJVEJMQzg2WldzalpscVFaaHFEeTRTRVoyY0duU0I4VXFkZlh1NG5UT0hRZWVYaExCNWoxTjRIcENMMnV3cnFuTGYrMTFOaWxNSURXbW12ZGtFWllQMTFFL0JzTURiclZ6UmEvckMxTE03ZVZ6bFNkenlRWk9SN1U0ZHBjUUhBNnkrdEhEU3dJVzZLK1NnYi8wUDJpV0RJNlJYamMwdlRqWEdLb0hpblBCbW9XMVlRU2Vud1pndmpuK092Q3ovZTlVQnJCdlcrRFBsTSswSTBGK0VKdHhHV2xJY3pJYU55UDBkVjFIdXV6TFkyZm9PQlhncTJDanFiWmlYZkw5QzN2NHp6ZGROVzY1NDVXN0pBQzdtREdOejc4M3BwaEl0OXM3czJ2c013QlFZVXJFaVFSelY3YzdNMS95ejN0clJ4NnpsdHE2OCs4UVpveEd1ejA3eDQ4ekpEdmFmOEMvb1V6RHVOUHNKRWs5Sis4anR4UUV6TmFubmkxcmdrQlBBcVlpT3VtVmlKVVl5STZJbmM0R0pDZWtjNnBvOVhHYlVmaFlCd2lOcVl0Z0VtdmJrazFvcVV0WjVmUGEzZTE2RlJUc0ZGcURSMmp6ZVlyZFBOeEM1Rnp3OWcrdkRqb212MHhmSHFwMCtDZ0dxNzcrd2RhckM0TXFncGVqWVNNbTZzVldTTHBJdksxWUZsc3M1YkRWeDFXQ1FBWVdEeW80dUllWUQ2RUFqbHNjQm01R00yYlo1UFZTY3Z2eTY5eEtGYldDVi96K2x3aEJHUGZDRzZvQnp0QTk0RjR1cUxNWTdCVDNOblY0V20xZlF6TUNUclorNGdSampsSDJYSHVnOUVMZ3VCc0Q4SEtGVklHbUl6Q1J2OUpTOGp3S2lvbWxSaWYwNERrd2dOVEdURlc2L1hVL0hvWFlKaFBPZWdRZHdOYzlqT3NscXk5V01KT3MzaHRzcThCTGpjM1JEU252SjNIK291RUlibEtFQWV5U0YySmpJTkRMZU9IWGcvSE93MnZKK3IvYzkyZ3U5dUxrc2JDdUhxZUtWNmxGVWtrVW5IdHJnZWljMzVWQTAvcGdPMTZwbHRXdG9Jcys0YVVkYlM3b0NwR0NEYmozeUNKSW5JcXVSbkVIL1FzbXNmNnVLQ2NibCtmaS9lb29jRW9FWGM3U25LOUJwS2JUMUkwWlNWako4OXhYVnR4UlkvdkJiVnhaR3NsZ201OHVQanphclpXT2QzcHB1cFpyTUxwRFVRZWRNT3Y1YWpHOUFxYjhmKytBaTF6TnZXQkRaZUt1RmtQUTVDRnd2aGt2a1hrdldiN2VldVpZazA5N1lmWmJDbldnZE9VUDlUM0p1K1IxYzJneGgrNEZHUEZrUUZxZC93b0lOei82Sy9EbTVISVFVU1A5VFlkTGhRZzVYRFJNYXR0cVB2WUVQbG5icWw3eVExd1pmaVp2elgwRm9nUms1UCtSbGMzRXA2SjhvS016Zmh3MDhjK25ucHZvamVTV256S09UdkMxMlBHQUFaVUtvdVZOQW9jWjJSUHVHUGlOZERUN0JiR3FCbTNTMkhURkgxU0lHTzFvaDRUSnd1WUVIUHd2Tk1pWVZHMGJIKzVTYlk2TjJYUDJYTlM0a0ltRXkraHNoU1ZHbGZoUlAyRDMzSEttY3RVem1mZmdYUWtSNDh1ZmxlRHhNeUl1Q01QOXhSZUk3OFphRDVSTG96am9GV0lXbFpod1lWK04xakJ1TlJweC8vNzdLY21hZW9CUGUwdkVBRUsvNUJkYUhFS3R3c3NIOTlVcTFWUmFXWWIwaDZtd3NNbW9MTHQxN3BUV2N3TmdBcktSK1NiZTc2SkJWdDd6NnFJVEwwK2tRdHZBK0gwamFNUVVYbHlwd1B2bEpLK1Yvdjd2bDFHa2ZUbTczdnBvOUZxMFRWMUkvaWRtREh1cTdBS2pyWkFNVEw4VkZMbzM3dHZBZWZ4bGVuT043bFgrTDF4a0JCQWd0L09GY2FrcjBVZHcxUDBybjhrR3lOcGRrWHhKRnFnWkpRZnpxN1dzMWVyZGR5UUVmemh2a2NSWWhiL3dzZklhdWRvQ1RtSnlVTE4zRFR0dmNIRURyUGhKTkRQQ05EMFdmOGF6QVFteitITUNuM2hYUlU2QnpOejNSVlljdGZJZkk4eFQ3YnB0MzJjZmNUdUVTMks2QjdiMnBpaStMazdSTU9raTdkRDRCNXRxaVI2K0pyZmZBYjYvTm9keXd2WjN1Q0NDYnhyeVcwaEVsVjE3VElOdFZkUlFJSml1clVzS0NHZGtZc1lPd2ZRNktKRW1QN1loK09pYmpYbVR2MiswYSs4NGwzV0UrR0FCNU81RVBya1lrRUdta09aemJwbEtNRFAxaC9kVVRGWjBhWFdPS3did21yZE4wUHczYUVoRjBWMktYS3UvSVgxNVBtZWhvU040dlBELzcyRUs3Y1QvSGFXR0h1NkdUSisydGxtV3ZpWXUxbk95dDl1b1RqY0NDUUpwRFpGV0dkVm1UV2lXckFUSmpPSjdNVjNNQ2lEV285UzJ0YUpxTkNJVkZTV2ZiQSszck9XRlhMbXdYT0VDSFg4SjdCOFVFMmV4K2xobzhXc21hb1dxYXN1eENyaS9ZdjlqOS9XeWZTazZYNXlhdFZ0andzcDEyRnZCSnp0UU54OUROclhvSi9TaS9sRDJUM1VhN2VFVFZPUDU5RW0wSkVqTFE0dmhiaGdBazBlN2cwdjh6aFUydDBjaU16Y1Bvc2hQMENuWWJXYUx5bzRXbUFqL2Z3M2VIbWpUZHF1Y3YxR0FDRzRvMjI0UGRQUUFkU01jeno3WWJNTkZOb3A3ZEdCUk8yTGRVbUljZGttR3pBRmxmbktXZFhVVk5CY3d4ODFpZFZoLzJjQzczNHFMTEttd1RxOTBkcXRMNFpEME1aNmJQN2tDVXBUUUloYzFVb1o5WnowQTM2UHdKM0NRbnB0SlJCMGp2QjhpdnJucFVXMGFFblM0Z3JML2NyajV2aFJyZVIvR0VCbkthUGhvWEFHZHdldHlLd21YMlJENmtLSDZaZFAweGUwbHJxeE5lZGFaYWw5ODJBWmxZMVlYcDdsQ2NuWWNxUkV2eXFnTUM1bW5HUHRzZnh3dnlYak9BdFBWcUVrbkJ3WGJIWXFZcmpFYTF3dDA4N0t4NVNCWGlpV1UxeklhRFlRczgzdEZZaEZVb203SzlGSGI2cmdwV0tGK1hJVlR0M3RvekRrODJzZVkyVkNmYS9UejgrRDljT0U3bVRDTGNET095S3ZNbXZYYWJwYTFFL1h3SUlXbmJndlU2Uk5wS2h6eWFaN1FBaXNwbTlpN3NaOGVrcGxSdVpIMnA3dHdXN1pIeVhhOEdUcm9UUGkyQVU4SGxuOC9LeDVWMmRjS0FRdHNLbXFQV3BEeEMrVDNvOStFRUxEUUZTV3M5Ly9YUWs5VWswaG9sNWd6SS9ZOGF1MzJoRWdCNnJaNHNVZ2pxbTc5cDQxQm1OVzZiTVZ1c3cxS2FtYXFKNnB6YmpyeW9CZG9BSE1xMGdheU5tb1NHZFRSaGVxWGlqS2FvYlVkVnJtQXdzTU50TmZmNnZCRWZTdlpocFlURzJMRFBIa3BBWUNxZVMzSWhJd0tlcFgrQ3lzTDNLdnBnWFJUQmJXT2xubVoxU2lyTDk1ZW9CQTNSOUpUay9QNFNlTFNqeDNnZjA3ajZFbFRZbGVSWUVmQUUyZlE3dHdPRUhFNDBGWmRUT09KbHVqYzRROVBwbmVBRGZHOG5KSzUyWncySnYrVnAzdWRETXBxcm5UM01yNGpRbnhvekV0d1MxS0Yyd2FnRzd4MGhSZ2JSbWlROHBtTjJoYVZYUmsyK2JSQ0RLK1ZxSGwyNlovQ0hDTEtYeXl3MnJ2cW9IU2FBTm5mNVhWVkUwYUdNdEFBbXpLNytOZ1phRGpRVUt1RmpvU1BTWGJFS3Q3M09qRVpTQnpoWUYwMWNxOC9wSGM1azA0clVEdXlaTU1NQUFXUXNONDFDWEZTMUlrakoxaUNxeUE2UUJUTDd4YllPYm1OazFEMFdGYVpoTkU5NE9PZzhkK3hzQnc3azRiSmY1UHNudUtVWEg3d0Mza2ZCNTZhaXVHUVBTQktMb1lyT1RhV2dCMWlEdkRBcGVhQlorK3VqYTk1VCtHbElPV2VESXUxZkh1MmhsVVF0Q0tDTWJGSHp6NTdSQmtCcTdSYlpBc1JFN2ZudlBOQXZua1NUZGNqVCtvSTQzOWwranlaS25XTzJ2Zzk2RS9sTHV6NnV2Sm9PdDdHUzczd1h4M1lhV045MmRXci9qUzR4VU92RGcyYURRNktWZElCMGFGbGoxaHhpd1RnOTVIV1R1K1laMldWODJHNTI2QVBJVklFQlZkUytHMTg1NXZLY1M0TUh0WW9NYktQV0l6MzhMTFR2YlVyTUZyVytPa2d6YnVNeXprK05FbWFnalJVcndTSktMODBGUVg2Vno4Zm44S1BHdlJFOVhESzFoeUx2N2p2SVdmQXcwbmtPRW5iMlNlNFVFVEczdGFFdm1Qc1FKSGRMNEFVdUtGOFE0UFNmYmcvSnpiR1RwaUdmTTJ0b1ZNZzE5ellKYVlGd0ZtQlhYb0JOOG9EK2J3S0RkOFBlR3RJNHRHdmxQTUwvZXRDdis1M0MwTWRjRUtuZlppMmFhRjFDcjY1ZlBhV3BTeWdhUWEyaENvM2MrN3dJOGkzaHVUR0trL0xrU3YvSEJHelQwNU9LYkZlV3ltWXVjL3gwMFRQbVdseWZUL1puaHpxcG4zb0JoVFR0RWdiQU1FeVVaRytmZVRrZm13WStCNHV0RkY5Wi9TT2t0UDg1MDFGdFZVeXA3RHlueXQvUHdvbmlMZks1THVPK0hQSmtMZ3pJOFlETmN5TG1la1FrREdWd3NLdXR5UFVJdlhlYVQ2eWtiNnBpNUdXS0NKTko4U3o5cHdBaVlkVzZRc0N0QXhsMmdQZExDVzdMNmVGc29vQkxEZmtaMHR6MFliNEZVN21vS2tjd29BSENNakw2SkE3RUxMWW5VcjZ0VlFKN1hLYjJ3VXJONEtJQXNYY0RhMHozN3hRYjJiR3ovRjljOFFRL2RWUlBvK0RPVlFRNGpjLzZCWTRiM3pyKzRzTkg0ZWV6RWZydmhiOXU1T3ZmSGt3VFlnSnZlWTN1Q2ttTitRVzZpTnNWZ0VTaHpBYXpmd1VmeVlORVYvN2xvSkViMURLaWZuS2thWnlJQVhCaWlCVUNXL05jNWM1YkNjelV3ZEhzN0I1Y0tDN1l6UDlwUW5DMjBraGpiejF5MitpdHRBVWRjSWovS0tqL0Y3VWRWWVVNTXQzWkhXUUJpdmJoM002enBJY1pOSDQxaDhGT2VibE1ESGNGajdGVXova1YvcjdXcFNpQlZaQndDZ3NBeTE0RlNDNEVKazNWSkVhZkEzVUdQOC8xeHFycExNTW9nWFNTYTFVOEVvbzhYbmc3TkxwdUdjc2RNVkdhQ240S2w1d3R6YUhaQ05SMVQyUmUrcEJHaXRXbnZIeU9EeDhGZGkyekZ2eU5rZVBTRGJwdmdyamFmemp0a1BtZFI0VDlzV3V1dmdFWW9Yb3VlK1V6QlRLbWV1a2JNb0J5UTR4aTh0NExuWUd4TngvTlphakFLTkNVajdGNUd0NUwwL2c0REd5a1loQVFvcFFvQXN2V0RScWxmSFZOQS8vajBHMkkxRHo2RWdIaDFQaHludmJ1aU5GM3dhMHp3bXd2S2c2cEdGamVNWmRqclljdFY1QlFnZmhTZmg0MGdITFIxUi81R2Z5KzlwdThKOHpwb2EyYXZwSGlzTjM1K1VKRlp5SFhKZnJVb3FZUEtLc1BralJiTHh3RURNMmhJTXhyMVdadUNDZW9ENWQrMTRzNzZZUVU2bWZHM2RQQk5oQUF6MG9PWVZHS0FKdUpUWVB5UUtCRnZraHZlSUdOaG9tTkRsNEtYb0Zad0hnUW5HS1JFSkVYUDFRRUxOeEFtL3FIS3RtK0dwSERNSG9PaUNZajJFYXZ6RXFuWWpTM3FDSU1taHdYTzFVb1VoajVSRU9zK0ZPSDB6TXJkNkVIZ3RncVFKM3ptWmdiS1VjUTFFZjF3L25JQktpdEZSZ3VUeW1DMGwrOUVKMTBtdlZVSG1ZV0V5a0NzUHkvVi9GVWhLNitlRGJaYW1yd1l0NTJoT3VMeS9UUVRxWWsvYUdGMEN0NmtlZTNPdkVPZ2lpQWw2QWtUY1B4a3VUbUhaUmJCQlE5WGkvaWl2WDdIdXg1d1N4Z1FvTmNLRWhIVEVHb0ZoWVNxVG9YZU9GT0pVQ3VEZGU1bWY1R29QcnNnM1Y3QURQYnBaTzA5V2JoNjNqOXEyTVFiN3p4bm1Rb1J6MDNNSkNTNE9ENkNBS3BiKzk0UWVyMUFpUjBudW8vRkdETFJxZTRjdURoTXJUdzV4R0I2T0ZOSEpvOXlrSnRPdlM1by9yMWxieFd0cGQ2RjhPWmhLRjlxdVFQMm9TZGZXVHNrVTJ5OTlLTEp0VFlBQUsvNW5OTTVneGdnbzc1V3RrS2hHNHpqMHZUZHBkK1BkVHZKWkhoK2RUQXEwQlZyaXpvU3UyUHduS3ZNZVRRWElPMGhMTFJRSjhVQnRseGtHRVJ3RlNDRjAzRXNwM1JYUnE2azFlTGo4UTZiZ3UzbGJwUStZNzJ3enBBNUgrdjkveDJLRFFUbjA0UGtJKzFFTTZ0OHNKUE10cktYRkIwMEJ1N0l0TWFmR0RVaEtnVGlhMFhDYzQ3UEc2eUhBTTcwckFxTnBZTGZtMXhNeUduZnJCK3I1T01ZQThlVGxtYTdOenFReEh3a3FMSUt5c0lqZUUvaDcvT0JhYTBxYlNlZTU4bGdUazlLUUl6akw4ZnIwREtuMzR0ZlNocmpjSnV1WWZtY1NEUVFqOXo4bGhUUjRzeG1QZnFBTURpeUY0Um5Md3NUYXBWT0J0NE53Q0Z0cUJaZCtHWnJqQ1hWNS9KdlNtdml3ZjNpMDVoMDQwUkhnRnl2eVExbll5MThpMDZ3aEhZTW9SeG1jQkZoeWg3TVp1TjhmYXorL2F6eHZhWnk1ZUVKN3pmSlQ4ZDIxa253ZkMyWVQ4YUhwZ1VXY3hSVnZIS3ZhMFF3RHJ5TUU2VVllck1teUFSRitqK3VjQ0hRUTNKK0trNkJUdW5MR0xlaEZvR2Q5eUdMZzZ6cWRsdnlRaGozelNCc21nV0FrcXpSRzJYWTFhTXpNMzk1dmNrd2Z5TURXeFhUZWd6K3Q4d0Q4cWI2aFhBditUalFCbmhTeXVPdWlRTDlLeDErTnd5dVFKeXpGcGE4WUpHMnFqdEp1Z2Z4dUJJOHFJSFZpb0JRejVPM2NhWFlxRTFyMXdXRVFpeXp0eG4xZENucVBvUmJJRTIySHk5M0xjZmxFV3lvNi85aUh0VmFyMlMrYW5OTTQzOGh6MjliaFJrMXo3cmhOOGkybkpMZGFhY044UGRZOWN2QkZlV3pjMVNxRWFBVExwMk9ZcFlSNW40Skx6QUhhNlk2bmZVUHV4bWZNQjE3c3gwaXR5S3BQbzYrUi8vL09TRlZ0SHdDdVpMVklabElQMnBFSk9sN1cwYVB1MVlSSjlZVmdFSklUYWN0U1MySkc4QStLa1FTQy9HTFlIcDg4TVhoUzhlSElEeXYwMFVEa0MxTkRNbXR0TmlnT09uQlVLS2tsWWZkVUM0eGRKZkhybGpCRTBhQXpyVDVIRHNSV0xyM3lTZTdUVGM5YnJNNzh0UGxCMzRVWm1IenFzblQvbDVYM1o2WmRJTkNXODB5RlA3OVc1YU9DVWNNNlF5OEtJell5YUhmVFBicHRpbU45dVRlNEdpWlhJdnZlZVk4VkszWmk2ckY5L3dac005UDkxVXRWdzRWYWorWU1Lc295czk4VXZXTTE3dnV0Rmx5T1BvVytoM0NqTEZiS2FVNGVvMWFQU0hrNkdOUmJ5amRKMGJxZ0YrdisyWFpOZzVQUHgzSWt6c0loUnpaNHF3NkN5M1RoTURLMmNpb0F3NUJKcndBTlR0bUVFOXMvdUxXdllzZVhJbVp1THlJMXZQeHFWNHBRa0krc0prK0EwTjMxMnA1eXNsNWNPVjI1TmFucGprV293Z3MycU9aOU11TGpLWXlZQ00zL0d2RktiTzZsL2orMjJnWTdmcDJMV1JoL2RreEFkTzkyVnpXNVUrSHpEMTBVMHhtbUxtWk5tVGdPbmtTR1hVNlVLRWFaRFhHU3BnQ1lHb3BYTnhNMWlyeVVmamJzSW5MYVlHSjRjaFNiZzBldEJ2emV3Kzkxc09hYitHMEp5azNqMENSMmRMLy9FbHp6NHNPeUxYMTUwUVM1cHNxT1pMQXJnMUxYUyt2WVliUE5KTVhNN2E0ekQyRTNhanpOTFFYS29nZW5UM2s0UStNS3h1ZDYxMVM5ZXJ1Y1FnNVRhK29qZjZwVWFob0tYWFlBWFRhNVBYcExiaEpPQldUVlZDcFVkY1M3UmdieGdoVVFQL0ZBVi9HZWxtWk1hdnB5T1dNeEJiRU9lYzhlM0RSNHlIcElEWlRPa1NBZWwwT3pYTEhLbUttQkgyeVBvTUJtK2hVanA2SUZQNXNZbTdUUi9DWEdMUnpVV2Q2TldTSTc0RUZFNTVzVGcxc21oOUcyZE9IT0tBcWIwSncxUFlhVG1LZVFWZ0UzNGZHWmV1Nk1Ta3J6djJEMHBMblZDNmpiUEFJMm9XN0NSbHUyM0JjSXRpZmhKdmF4blRaclZvK3dYUFcvUTYzOTRpbWVvbkFuSUorZFh6QlBacm1xaCtCTEVqeHlNWm9ZMzV3Z2NwMlVlREV1djBkVENGc21lamoxNlB3TGlBVURkdFk0aFVIdFU5VWRBVnNia2pCT1UrS0oyeG8wYnpmcUp5eGtIdExqcGFSd0RxY1B1NG05SE9VUjJzWG91NlA5dUp4Njk2dnozNzhEelQ1UVpnWW9oVVI5NjRkNk5VeVAyVUJpamdBYkZ5ZUdnVU5oOFBqa2NtNm01UTB3YlFOK3JlMlhTYzFIbHlSRzlEWUxMNFhLRE5LSExncWRrRktxc2RscGRKamVCWWxTWHg0dWlEK0V2aDEzRndManhUMnc1TFhETDhOMkJ4aHJKU20yQUVHdEZ0UHhaYzlVajF4OGFHMjBRMU1NVVJzMGdST3YwN1pZNytLYStPdmZrb1ZneUYyeXQ2K1o5MkgzVkNTTUM1OUVkM3JJUEU1cG12MzR1bFNvemwydjYwTkNFM2psZkR5NG5udmdZcFBrZS9jRlk0aktmaGZKVktDVHdUMlFtcTB3dVkxY3FmNHdyQUovd3VnOVJxQmNQWjRpMUlYdHYyTWlMMFN6Q1l3WEtrTnhCMmUvM3Z5S1h1dERzUFZLY2o1MEhycUdZdHhmL2lQWkhBcHQxK3VtWFEwS2R6WTMwNTFRZDJQMjd1M2g2Vm1FekRWa2ZlbjF2MXZVSHRCVE55NjlCMFNrN3k5amlKVHcxeGdVUldiVjBMMkJBOGtZQy9XZGNPdCsvdTNaeG0vaTBuU3pRc0dDNTF1RVNsMXpzSXNaUDM1eEJyWUFRWFE2Z2xJd0xlUVJkSXdTTGs1UGE4Q0ZXWjh0b2hobGk5YUdaRkxZSzhrcHdhNEFkbFk5MnptVWFVcWluYTFtUnhhZW94Sk1HZkZGdnJlVVhqL0RHd1AwK0NtZnFsQlJ2ZUNyUHBOSnBIT3l4dVYrNDZmZnJmRUZZREhvYXhrVm9ZRW1zTTBpcG5WOEQyT1ptMEhheFl0ZVp3VEIzeTR5S1RocDhKUzZiOGwwd050TyttS0Y2TGVaMnV5eHJHWDN5c1p1WFl5cERjdnlidWRmSGRxaHByd1N5cklBOGpBS0JSNkNhL3hsQjJoZzA4RTgwWXR4S2lQWEx1OERsZkM3OStkeTZMSC8weTYrd3M0NlFlNEoxb3RkcFg3L3hmMUVWVFBmcjRDeStUbTZ4VU5zSnpkUXdLSVVncllMRDJkTjJwc3lTMHVSVkZQWTNsQXRWa2N6eHN4L0FBb0VBZkdmUEh3bWE4TmhRVnpSOENoSXVYMXVybnNnQ2REdGZZMUpqdy85SFc4WGhFSzhjVm1jL0RFOUFkMlpCVnRPSFk3RWlsRkdBbTEyTnF5Ly9PMWxpWTBUQ3VqTjRPNlArckpZZDVKdlBJK29uY1ZFOTNESXdCTHVVbEZTRWQvUjkvTE1hR1YzYWt3bTRWckY0S04xMHN3ZndFcWFiK01uNXB1T1IySkFDQ3pIYU5PK2N0N2dZcTZwVXNVNWM4M1Y4WkRlck5NOFkrdExjWm5wNWZQTjI3VHpPN3JVRFY0cG9NOG1zd3JsVHI0eHVCWTBqbEk2ajhIYVBXZTh3NzhPdjJ6eFVGVzd3REpMVk9FUlhCTXV6R0ltZGRrTXcwWURRYTFEdHFVeTVmVzBLWjN0MGp5Qk1NM2lneEwyWUhnak41d3lHNFFkMFJDZGFYY0xLWkFvVXIrRzJKZTJLbE03Z3dDTFloQUFvQkE0TW56S0JCdDEyUGVQaVd1MmN3VkkwZzl5LzgyT082V01jTlkvUHE0eUtZRDUvcWd3RnNzUUpXcXE0V01MSlhYUHhHZFA0bFc4ekF1aVVldFRINktKaUh1OEFFV2ZwSmhvYVdjeCtoOEFwOUVCelAwMENXV2xXY1QzVE9VVDNBcmRtSVRJUmJOMENaaFZMaGlVM1FXdnBxUkpvRmFCT3diN2NkY0pEdDRuSmVaZnVOaE03RGJZN0lUZFlaUytSU05uMkRlYWJFUjhsbWl1bTBIMm40MVlPTEVCZ1dLa0xyUFhwSk45b0R6T1dsdGs5V1ZlcSs2cGdsNFE5VXV0b3VOcE1uaHEyN2FPbTJzTmxUV1phQndVSSs4VnZjZ21RakJ2WkxHMHFpVmNrY2YwdFNJT1U2SHJiSGZRc253ZGpLQk1NWVFMSUxjQW11elZRUDRpWklxeWdCUEVBQkJjdlliaTRwZlRKbVRnSEcwMHptVGVyK3dkN09KV0c4MG5jTllBZWd2R2NKYWxscnJ6QlQ4VmVaeHhDY2pHbklEdzVodEVQVTErbTF3Y2hTbEVhTENlUjA2NUFjZHVhNTVYT0FRakI1Y2R2WmZrVXVWSWNzekJlQ0ROUjRiUGRPN1U4d1VJUjFBYlBpUXV4RUoydG1weVJhbTRTOU0velpBTks2V0RXaW9qaDN0ZGNJNXBhRk9PUjBYTERWMElCR3dudndrSzNMNjZmRkRIcWtTM3J3NkxUSWdmSWpkUWlLNGVaYzFFUnM0cEw5NHgrK05YaTdreWtMcWtsMWJtNVhDOVJyMUFzWVUrMTFZRTRBcW5uRkxVZjFpeXVLL0xZb3VKNEtVUVN3MzFsYkFGM1Z3bUFxTi9tVGxnakQ1RFR4cEVKSjlQTDNYR0lpUHp3ZWNRdU9yUHdjS0xnWk5WUzZoanpaVGVGUzlJcTAzYXJXaFREZFk5VERYTFY4ZmFma3FvOXN4OGN6elpMUHRtWTd5MzVvclAxRlNXOGpkUEdBWXhjRTM2NzlNUnpzL0k4NFlsTXNmb3RoTDlkMU9KbkFsdWZ0S0RXWnd6dTBlajdDKzhYQTRTR3BzMjZESEpieHV0TTZWTFdaakp0dnVvN00xcTV1aVVmT0czckxGZEd2VVhtWGZDZm5XbEhpa1hjSWZzbkUrdHR5bXBjUW9WdUZVRi9HbFJyVGVtbWlYbFZvQmdiN1Z5NWJPaXR4K0pJWVBaU2JadnhnYklRTE45MjZBOTdleGxVNWtraHRsYVFhZGRraTZmTWIzTVpiVFdqYmpoRmZBZ21mSVNSc0lZZ3ROYy91dU9NMGUvZ3JrRDc4Q0Urcks0OE1WcEJYZ3VaN240UDhRYklSU0ZVK29nb0JGdnhoRHh6S2NGSGp5ZnRaMVduTXRhUlkyUHMxQVZYRUlGMElRNFdlOGN0VXdVakZnTC9uTFZSVUFIaVZxdktLbDdMWUdGLytVbERQbXhlc20vVU1DdWI2c1BXTFRUT1RJOThDdCtrWnllellUOWVtVURqN3VIdEdLSExyWTNQMjRJMStkeTdhUlBJbHBLY0NXOTBuK25teEVBbm12NGIvUG03VVdHYUlJUERlWXRFaDQ5Y2U0Qk5TTmNmUnZUNTN1c3Y3Z3VIa01FMUVMTHdOUTAwSHIrc3oxVjdzRjJoYytyN2l0amlhemppSWZzb05GMjFid0V0SnE4ZE1yMllJbXc1bDMrTnRMU3JnVCsrV0tJWEdtaGJMd3JYUDVvbGYzckR1QkhiRFMwTjhXMDQ3VmtOR3BQRmZ6bXFYMUhlSkErbG43Mi9hN3BONG0wYnBvUEhpOWVlK2NJbGRYUG9CS2l5VVpqSWhPZkdHeXArQWp4emVDL2dXZ1M4bkNIdmhKQnhSZzBDb2NzK0RqeGdaRitWT0VlT1ZhdW5hb254ckVZdDE4TGZtWklLL2duQ1o1akFicUp4UnJmSXFjUTJmdGZtd0lHZHdTclRzVHFBNlJ3Sm5lR1pYMEtqR1pzUUxzc1RnZi9VZEFqemFUKzg1dUk4SGtqZVljQ095NVRMRGxwSmIxdmNLbnBMN1A4dVBDeGxZamkycVlwNllIaUxxS0lXdTlseWFvN3ArcDNwcVN6SkxWNFFVb21qVGpKTWhxZ0c2Z3ZPd3hkS2ZnelpRamdwbHErTzRNU1lXMWJIditHYVZDWGEvVGEwR2VVaWNCVFVIYVZPMTlBTGp3YVAwMi8wVngvdGFNQk9uYlgydFk4b1JraGdjOGFTYjk5QWwrTzhBTCsyQ2ZYUjdMZUhjMkhCYmVSUllVbVFlalA1ODJYT24yaFo0WU5hK1Z6eFdZZmxZWW1lY0JlOHhxdWQrNTd0SjNkeHJqdmF1WUJNL3ZvNmQ5YnRBOG1ySW5UU0V2aTJYWjM2V241Q283VFhMYlRNbmhFaGFaV0VWR3I2cXhlV0FxUEFzTzNqejc5bVhSMWtua2M3Z2tQU0llTmZNNncyRVQyV1NGVGR0Wk9YZ3k1dFl4dThZSDhIYWJKQUFhejBjQVliOHN4NXdNR3VTRnJWREZoRFJuUFNBMHBFRWRRVlQzOURqMlhzQ2NqUzhnMk1YY1VxdnRVQ0RMekpZVjRKUVlEY0JUSldKUThPQ1VQakx6ZmZ6R2l5Y1ZubkY4NWpIaDVQc2YvY3VFOWZvc1pZdlBXRnhhV1JKOFBBb0ZmbnlZQVcrV1NvbjFqeGxrK3R1dGozNEpYbEhzbUM2WUdjazVYWGlkK3F4dE1sSXZjTjlnZldtR0JBSjNkcGJON2Jia3A4Q2tPZnlhenZQdnJPOG1WNHRKZFVCOTJlSy9QdjAzVU1lK2FCRkxOdjNoRW1RUThDZkdWSVRFL1g4dlkwWG1icTNDVy8rbm0zY0p6dTN2Q3lxNys3SkZBbTBZMmgvelNSVmNBNnlrMXpVcHJoRjFaQWxXdXNtYTFaMU5pNHZ2Q1N6YTQ1OVlneWtKSkxlZHdJTStpWUZoZk1GZFBWSFlORjRlZXF3ZWR2dlE1OENLY1hsdDM0R1V3cXlycmNQYkdSQ2pvMmR3MjFrWFZKeEg5b1lZSlhacXNkVTZ4ajJOaHQxOFRRUGlxM1Jsd0tNTlhoTFlxT0l0VC9sVFE0WVFMbVhEZG9SZm56Sm5la1dweFg5dDlzbzJDZWw5dFk0Z2dlVi83NWlBekVPNTRuT09FNEIyQldWSUJZUHFEWTJNc1AwNkgxWGFDUWIySUhzNVVhREcwbWQ4VGhXWDQ1NU9Ka3UvTHZ4WFFmeW5EVlhCVi9uaENUSzVGNWRFWkQ4aS91ek1vd2VCNjZBbXJ3bkNTNnh5djdqc3ZQRnVUQU1Ud3FRQ3hjRXJzNzhnVmRONVlzanVaNGxvQXlRbVNSUWN0dWErNHJMY0RPODBiTlVhT3l1c1FFd2J6ZEk0SHd5M291VmNFUGJxVUFtcmYwZzJjOEdRUHJUMnlDQW9RYmdpWDNudkNrc1R6Z2hDVDNKb1FHWC9WNi81a2wreEhWNk9HcnRhc0hkOTN1MkRCL0tDVjM2R05UMC9acUl5Rk1BYmRmWllhQ2s1emdLUldJQWtoMGZmRTN1M3MvYWdCcmFjaTBTQnYxclhQT2x4UG5xYTVhaG92R0VDcitORzA5ZHNQcFpIaTBvOXdMVkRlSTBlVjdRTmhVQkVOTGlFQ3NUejBOcGljRk9IYXFUbEo3Z2hURk12R1lGUTRudzIvZE9TVzlBVW10TnIzdzQ2Skg4VVFyZGNmZ0Q1VHl0MnRtVkl4SjZIT2h6S29ueDhkN3hpNGIwa2dEQmIzdUFOTFpFSC9PM2g3bXhWSmg0UEltbEEwajJBc0pMM0tST1B6U1RtelNnajhqSTJWWU1DZXlJd3NSUER0cEJ6WXNHTHVObm50M2VLZkFpVHJ3WDNjb2lDRHZqVzcwdm9XcE8wMmVOdUt1QldYR3ZPaUk2YW4vNU1KR0JaNEZ0czdXS05pcTdGdjFFclRBQW1jRjlzZVlXaXJVb3lvVGYyT2NZQkVQWU1iaUlTNHREeC9FVVdMKzJVL2crMkxKUU1MM3dGV2pSTi9DRUZneCsrTlNuT0JvMlRYU0ZpRE9TeERoSXN4ZkhqN21GNmRiZE5tZnNGZmJpWGJPaUdETjRIWU1mWjlRWjAydCt3K090TnB5T29oa3hHci9YYTdRK3NnNHRMdDh0YzN2YXRQMjlwRWxVZ2tjbFZDY2pjaVBETENHVko5K1lpRVN2c0FFcEVscHAydnRsN0VyRzZxQjhSVXF4N2JHLys4dE1GdTNKbDU1VWlGNDA2VkhPYTR4UzNHMDdkcWhzV3k5aFhjeE5zZUhsM01tWG5VTGtUQjU0RGQ5NnFPTVpLVm9aSWQwWHFDb0FwZitLdk1rM3Y4d3NUWFpIOHY4VGJrWkQ1V1ZwR3dsT3JGM2JnelRjSFk1QXdRcDVaSUN6OEx2ako2N0FqeklyNDdwelR1YXVIZVI1dS9nWXg4WE9aOVZiK0RIRk52QVdBa2ZYOWxyT1hsUEJaNWJnOHZSZDJXQ1ZoT2xPcTF2Tjd2VFpMaVFEdDIyNjZFeE8wMnJHNmxCT055elV4RFhBWmpDZUtVQ3Bod05mMEZ5bTd6VGhIUDBpMFRTZjFZZUJWUk11blJFRExBeDhhYjVOMHRtbUhnQTBDRzBIOGRGRzlSVThRbmpNRzFJd3JFVHBhaG5WNWFueXdJdmlWWXFzT3ZCMHp3SGloYmlGOGNpTXJEL1dMM1FycTRFZ0xzZmdaV3FxclJoN2wvb043U3AwMmxVWjlISXVEZ04rS0tUSXJJaGR5dGdNMU9URHJEaGkvT3hocXJ2MlFaZzNlZGtBU1Q3R1JGMDJqL0J1c2Z3blpLSzllMzIzb0ZkSHNYUXB3NkVzOEZKMHJibi84RnpnK2taZVRpdDZxRjU4ejg3dUFvc3M4OGR0WHBzMTZwaEtEQ1JJc3dKU3VOOHVrNWNQQlYwQ1YyMzl6cTJpMFVuWkowT3lMalAyMWp5T2lmN3RIQXpwVGZkeWJ4RU9tdmpQcjlQdTFRTUFnTTRJRXZXbFpqN2gycFhreDF4UlFiU0xLdFZ3Z1pacExNYVQ0S09LZU5nUDZmVytjQ3JpRXMydnZyemd4OU1lakZtL2ZTNUtOSDJROElRMmJ3UkNVVHdrRWNTM3pkUnhPdUFwSFRaUTVIK0lFWkRTUGk1dVErc3duanVpaWtFRHZJVEhZRXQrQmpUcVNFU2JFZUYvMm40UHhSMEV2MGtKY3FnQmV3V1BkOFBvQ3BZMkJjOHFiRDEvNmpaVit5aWtLQ1FCb0RLVGRFYzdVcit6Q1l3eDVwN3ZFUkgyczh6VThNRXA5SFhTNW5uZVRkdHJjQnlLbGJ3eEs5VjRmbzBHblltdXlaeEQrNitJL2lWSlZpK2lVOUpUVkdjd2JHdXg1cTRIYURoUExSZk9aNjJnMmxXdU55RGUrb3VQQmkxV1lBSXU5TEtsRjJDWWtySTk0SjhrMEtzV1BxREZ0TlRVUk5PYmVHKzY2bkY0QzZqbU1iZzVQVVFhbnREd3ZXZmp3NG1qa0pjVmJJQWtoalhJVkZGOWtZcDBQc2hBcFc1Z0NmeEh4RWZQV01BdzJEYThKL2RkcFJydXpVYmc0a0JrR2dJMkpYWVZEYWZFMFFKTzF1WDBvUG1mUTR6TDhkRkVoZ0FrQ2djMWZIZkp1RnZBK2FBSk5hbnpVVGJEa3ZjOTBXUk1EQktwcGw5aHQ3cXc1bTBUaThCYTl0RW5IWCtld2pYdm5hRUZ3TW1aWGtKRmF3R00wcmp4MGtkblhITXlzSWJybUFZS1k1YXQybU10cHMxRHpmR3NqUjQ0Z2ljNGIxdjBHRGFEUWh2d1lsQnZLSGk2djJRcnB4Q0wwYTNqUjJXdzliMG12TG13RDR3b2krQUxoUDlaVjZHeUlEUGF0TGt0a1NKQWI5ditLVFdweDRRR245NmRFSGduQjBFelVuUzFTZUoxZjB2cWdBSjhJdVJLeW5YRUU5bTFxTHhrNXNpWkFkenhFcTFIeDYxZlhsV0ZBK1N1ckUwRGI1OGwveEVVU09XL3JvbGM1amNHQzZON1dyUWFnWjkvd09nTUxsYWoyMVhYdTR0eHJEUlBHdXljMStvNVBPLy92OVZkY3cyK1BidVdhbEFCQ3NxQmM4N1IvK3VhRWhOb09jU1FHYU44ZE95KzNQS0NkMGc2NnRWN211czFhSVhvbjhBTVlCT1ZUUFJDcThXQ1hCNkU4SU9qWWxrcVNsd1NDU0FsYXB5cmtPN0VvUU5WVjhsN1RsS0RkQ0NwcGlXRkp3Nm5RczQxMVprQnR2ZE9EQmRTL0Z6TUhNTzU0akdBZlNBRFRlZ0h3a3FjS3lWUjhlSi9yc1lkN3RXRVhRSFErNk51S25GN0lNWjFBV0RtUEcxUlJ4TW1NREhpV2V0TEo2dW5VbmllWUpoUnNZNWFDOGM4MGtud09SU3M2bWQ5bTROMUJuZExiMzE1Nnh5ZnE0MHFVZlFienluVUgyWTF6Z2dmc1NpSUJyejIvdXRoY3NxMGp6ZEsvd3h2UGRuQi9JTFg0REJPeXFGMkUwdEVMcldZSUtrN09QUmpZZTl5eFBDRVIrUUcyb2MwR1hDZjN1T2puRjRpNEo1bHRicTFja05yNFovOU90dWtWKzNiZXBmS1hhakpDczBqNSs0OXVGR0d3WXFnaGdCbDJ5bHIzdTFEWDNkaytmSUhaRHJ4b25tTTNPR2Rqc1NZSzJjZGNFcG9na0hWNTRKdFlBb043ZG5CRk8ya2dpbDljNEp4VldZcXJLMGJCKzdYVVFSNFZsam5zU3g2bDVmLzhyamE5YVFxcllONG5EZ1RQN3c4T016NTkvU1gxSmJtSVN0d2FNdVV2OTFmQjY3UjFwZGFQOWdIOXVOTVoxZXAwWk8zV25MUFNQRWo3U3A0VUpnWnlWNVQ1WTZNU3A2T0ZzOXJyTGxXT0MxTUdFL1pxUnI3WnMzRk9KK2dHOUlGWUJXZVBLMTU2VzBNeUE2TitmMzJWOHBDR0xObWVJbDBIclNsL2wyNVREd2J5dStWeTdIRTdrVjZxZlc4Y0JPang5K1k3cXRxM1ZqYk9jaWI5L2JjTy9jbWxqdDJKeXpLZzBCaEhmN0xpVmdaRjNld2FaTDJmLzQvODIrT2ZhaVFUL3QxMUJyUHpscHFlV3gzNDFMcktuWUNyZHRRU2RINWVPNno0VGY0RjdYd21HUW04NERRUU94VjAzL2I0a0E0NWx5YVNVVDNqbDNZSWREeFpsK1BDVFRuaE5NZTJhSWFCS05XZ3dGaUVNSXAveXhrcnovTHRJM0h6c2RMQmxUcldiYU1QSlhURURkSnNGb3ZnODB2djhUdDIrUTlUSnpiNDF2STFvRnQzSEdRUFNQSEkyOUFZSFBzYlJXYWhkK05EU1BxME5jNWNKVnRuL1lWK0toTllmbUExejY4RWdFSjlCTjVVR3Y1Wmt2cnl0R3J5c1pOamwvY0tqN1k5bzE3c2Y5azJheXgzVjAvOUJnNWxLMzIyODdDdlByWll0RXVkWjhOdzcvSWJaaFpFVHJ0SnN5WDIvNFMrZkxCbkxYVnZkcllucGVNeEtOSUs3YmZiaHIxenIxNWN6YUJmUUxYY1RBaExyMUlhZXduVjJtdlh1ZHQ5dEMyVGdYbUdNTGZTUzkyT0ZjQnBuRU9mNkh4d1hNYndJTlh0RFJHVWpvRkF5RHc2djQzcm1vT3RDZDdSRDY0SktaeTBJL2F6anVBT3dBcTY4YktVMjdIOFdVV1kxSHc0Q3FvWUNzTTBPU25DbVEyUkU2ZkN5cjBrd3gxY3N0MmxKZzE3cjRYeDhkd2RvRTUvdC80cTgwOTJ4KzE2NVovcytvL0M4bVoydFRTcU9ZdS9jNUZGWVptVVNrakN5V3FRamdDWjFHQXRJUUNpcGxGMXNrUHVrMkhlRElUa1FodE9DTWZVT2JraG84Y2dMQ1ZuTHpuV095bXVkZDhWSm45QlRWU1FLOHJucXlrWmM0Mjd6R0xSUmxxSE5tZVZXSUZkSlYrYUZPOGFUWlJpSFAxMnRCMzVwR1hiUXI0dzZNTC9SblN2c3F5U253ZmN1UWRHc096eWt5NjdScTczQzVSdyt1RmJ2eFVXN0F2U2Y0MGd1VHlBL2ZSOFd0VEdhVVpqNXRBRmJsRnA4UmN2TkE1K3lNdlEzOGtSYnlMdEE5RGtOemhTYlBJU1QzU1UyUGdudnNtUmJpcXh1bm5vQVhkdkJXUHBwQUFBMFJyaDJyTDNPMVdUaXFvMTBUTGRvakcwVy9WOGpqa29TU0ZPc0hMQzVGblNZSHpOSzk5RlQweEF6aHZJdjR3ekNzL1NuS2wzUGFDUDVSNDZYaEZka3VrSXRoVUx1UWh6ckZKSXNnOFZ4aVQrR0tTQXhiazAwSkxKSkZCL0FQNm5aRWh1Y2duMG1UZVVUdld2UG1iR1VOaW1mV1I3eDNocEpYYVhIRFB0OHRqeXU4QUY4TlU0bmJSc0huS3ZXblZpaDlUQlhZcTlQNTJSR2UwNUd2aGtBMk9mSFZjcG90RE1ybzZPYkV6d0RVa0JBbEMvMGZzck1yM1lDMSs5djczTkd2ZEd0VzBJdjh0WUxmazQ3OWxiTk5FNE1yODBCdVE5anpYZEdEb0syUDR2ZjlQS3MrYTg4ZzFHVjRtRWVVK0c2cXBzcjgzY0pTRHQ0ZUJ3SnU4dms5ZThzNlgxVHkwMk1LWm5IVEdXMmd4NEFiMGUrbkNWVFlSb3Y5RDFxa3Vrc2VBU2d6R2FRZTNYVThJZXFEN3c2RVlEeTNhNUxONnh1eDRBdmlSNXlJMmhyNWxNdVVMZVRxYTgxM1l5ZDhFbDcwYWpsUytpcXQ1MEEwdHpZSThMdEVxUStOM1dDOEJ1Y3JOYjhqczNKc3BxK3ZFLzJwSWlzVzdWTnpmZlFKR2N2bGlpYThkazBCa3pweFNRZ1NqWHpwTWZ6MlhIdm9DbnZxU3E5cVVUbThvcGhzRmo2a25jZW05NVUrenpvVUlZY2lvNHJuVTBFdzNQVEw4QWlvUG1UZ21PY3F0bm4yeDlCVTErMTcyZkdEazFyL0VZSjlWMEhTYTJGRDdSaVBQUXc5TmMrbHkybnRTSDFncENvZ1BZM1Q4aUpHbHhGTzlTc3ZYZHNwei8rOGdjamJaTjArQUQzM2FWTDFxRGlHL0NjbnVIeTRxQkxzV3cvWTVMaWVLNS9jQStFYVVzNDJQWGxEdzEwdEVRaEQzU3hwUVhhUGpJTTBGa251Sk5HMWhXd21iN2R5eFY5ejJoTE1EQVpPRXJxTUFXQkdwWW5peUVmR2ZZWHkxSlg5Z3ZLcWNLdDBMM2M4UktXbkUzNEFEdno5ZGU0Y1ZWYUlXMnJnQjUrcGRhSW9wdXU4c0sreG9uUnBIdWtvQzFOMzNUK09vTGRsazVhVEhUOEJWYUtISzZuM1A3U2U5L25QV1loSXBlbk53U05PSzVma3lyOEw1WFZoMUVWSU5pWm5mM0VFa2hSeEFqY0w0Q0xnTmtEdHZSUnhobFBxcjlsSWhmUWxHN0RaQWdRbzU5akxKa2FTT1hENkk4YU5yWlh5VENObHVLY0N4NmZ1bGNKdWZKbC8zWTNKVFlYcDZyMmx0TnlIckg1bEIxM0d4QS9VZi9kYVhLQ0J6VTJ0angvVGM2S2dnbmlLTGV0UGkraW5Wd2kxdVVTNFRLQUFyS1VMMlBCNnNQeXgvRFE2SkFCU01rZXpaQm1IMmtxS25Eb1I3S1B5endqdXVUWHpiRjBVamNDMHhFSUJteTc1SXYvRzBuRnJGQWRpTjZ4Q1J2SElVV3ZYYkdqNHRZVVdOUDRUUlZSeXpMVzNWdHphaTNYWXVlV0xNc3VJbnZSMmovT1dheEhaSUE0b0tRSVk2RzErVXFSZEU2TktiUTZFTDFxWDNZcGw1Nm1BUjBKSFVVbmJ1WGtvcHB3emJXTENoLytPRXpSMGk2ZFp1b2hUV0dLSFkzK3pHRzNyUVFkTlcybEY3QkdxU0ZCcmVMU1hmRyt2MStzOWFTM2dYcmVqVnBlRk9mK3hXN1lIVWoxMFh1Zml3RXVhb0RaWGYwR0dyaWxPSE1MeFgvQk1DenhuazcwVFpmTTl6eDkrOWd2ck9QQzdZeXg2YXJsWmVSMy8vNUZ2Z2J5VjIraEdqNFJyTUxoaVRnb2xiRzFHZXFSL2hCaVB5UU1ubThQQS93R1lRaWhsL2l6b2pKZHlhTlM3ZFZUbXltdTBHUTZUY2J6OGlUVlNBaGpLY1Q5dm43bUhkQzkwMmhIK2FZZnhkRkdwckM2dS9qeHJmLytzaHJzdmQxTnl0VHhpU3VjeHZDbEZQUUtLRGVMd0VqRjRRVlpkS25OS3JlbjlsMkM3bGZybS9lRUdOcnRTR0trMHYxLzVVOTlGNVZza0ZKOHJXb21pTDZnRzVyd3FMVmtINGw2dUc2ekxSaE96eUpWMmdMMEhGNGtOcUlFSVM4c3lpbXdvSzBWSjhnczRtUWZHK2ducnIzVUNQMWdKeElwVEF6V1hRbENRMlFWRHVTUlpFdVF0Rmo1Q0dkOFlXSTJhOXkyS0JTN0oxaUtKb3ZGbm5oSjZkbkNKTUgvSVZvemhRU2w1QUpRQTBiU3ZJbVBxTUd6KzVhampXN1laYkQ0U0JlanhOZlF1K3BBdVl5blcxdkNzVGxpdEgzWkNMS1VCaWY5WWgxZHVvc0pYaEhvRUc3NldsSmpNVm9FalBWMm5CVStXVlpDY2VZZS9ySC9nSzNVYlFPMG5qZFBDcTc4bXkvbzZTTE1FVTNQME1lOUo3dzF5SytSSzdUMG1CY2loS3ZRK0JNMXFDSGxyUkkxTXpuN3A5MW1OWVd5MEIxUGt5VVp3NktlZDVrUElmbmlzMnFSNkxlT1g1NkdpUlM1cVk3MUVKb0NiTlJzY0ZzZTl2YlE4d0JUVHZKWVdrNTFQMGJTbFFzbmZPQ1VaQlRhSWNXUFUvMER0b1JIaDhSV3p6QjdtZkZ4SHQyR0l4b3hBbVA5TXE1OFluZE14cTZicWxNbzh1SkE5RkQ1T1cwRlBHNCtCUk9hZlV5NmVrMi94OWd3cEtzNHE5dUhLQzlBeVZ6UzNrU1ZlcFR6aFNmZjJ6SWgwK1d5dElRajVjK25uWVA3MHVoQnIyOHhzUW85VG9YYjNFR1pyTXVzcmUvR0tSVm5ZK2tGd2RoV0VPUlVJa1Iwc0RzM1U2L2RsN2xRYmNZL2EybGY2b2ZYSEpPOEVMZVJ4SERmUURtUEN4ampQcU9JbkpHR24vSnFXYkpIMzVsTnJmNzg2SWZjb1hkcHJOcTJ1RXdNbGREZ3l5UURSNHI0TTg3WkJoS1V0aUZsVkRNUzFOUURaRGo0V1Y0TWovd1d1QlJPeWlENm5lOTVTTEU2dHREQkV2Qk13VFZtRVV5WENvV1Q4dHQ5Tk1RUmtNa1ptSHVKSHA4R2NWMlNlSUNzRzI5a3RWQmlmcEFCU1AvZnJQcnk3c2NpeEZJVnJMMytralZtL1FwUXRBU0ZlVmJTVzdUYkVZcUY5ckVDdGVpV1hSR2F4cWxVd2dackRaSnJ2RUNLc01MeXJjODlDNVJ1UlVZWkhENmdRbGc1dk1GclRoWHRRL2xycHQyK0ZleStyYVg3cUVaTHR6b1NvV2IrU2FJeVVhUkhZQVpjNnh1V25tbDc5ZEdDT3dyYktJODhxTXV6bUovTjI3R1cxb3R0Rm5ocGl1YlQwc2RvK01JYVlDSGhBa2tJRnI3eTZmNWU0Ri9iUVpLaWxZdS9DQzhHK0U1cWxrR2RoN2NhNFpDTWtuaTd3SEtpUkNBdVl0RGU3dEdGOFhhY1JOWGtQSTVGUGtRelU4cVRYZFpPMm01bVBlNUlQUlVuVkE4c2p2Y0pwQlJ4cTdlZ1NKTlNxQUMrSkV2TjBzU0V4dHh3UlZwbnVVOXZhd29PU2dQUlBiVmJzVk0wd1c0WDF6eE5JRDFjNGZicFdIVmN0SnpGd3JuZTY3cXArWi9SeEVZSW4zclF4SCtoanh1MXptdnBNWWJ4djRFZlpUVVF1UllxdnA0MjRaWlBWR1lrMTRPNUlsR25XYjVxaGZqamRNM0IwdndlWWJXRXdBOEdxZEJtOXN4a3hvakZTRVAvSmcvczFCckJMMTFnT20yWklieHppb3pqdGNKRGNsSmNJMWM3eFFGTGxwN1RTdndMb3FDUThCdHRteU5MTFFZbVdaU2tlQVhKWnh2K1NQNG1nOHU5TERqQ0poZ2tTOEdnVmM3WEkwajE4a2FSZGV2Smc5S1pYNnlJR1Z1bHFkOFJvUm8rU2Nhd0NRUnVPQkcxNmc1MmhCL2xCSDhaTERsTTZGWWlJVnNBU1NMUlloRUZ1ck50Ky9tbmRZNGl0WUc5ZDg3TU0vUWhsbDZHMkhKUG1pdUdKR09sekQzSDl2dVVCVk1sSW5ST1RTeS96amZ3UDA4bUthOW1EY2YvTzlCSzR0RTRmREFnNi9QN0JFS3pORklNNm1QOUNoNVNaNmZhbitzcFBiQWxkL09RZ3FuVWF4SGtzS3QvaWUyd3A0QUIxbS9rWDdGbFZ6NTU4eEVJZFlmVzVkam5ZeExGNDJZMTVwcEhZZ2R4aU52b3hjR1dXcEJXQlJiNTM1ZTNHaTN4YkNFWEhBaGRSMkdyOFJvOGNzTldVTTdURndUcW9ONWJNemlLbmJncVBQTVFSczRUOFNLZnVORzNwblRtMEwzbGRiSTA5YWk5RTloWStGdS9zWEMvNHh3MW03bHhxTW5lUFY3ZjRreUVvQVM3WTcwRnJzd3l0RmJKMmVzcjJMRnhxU2JWS0l2Vzc2QUw0Z3RUbENIcnNPaTFOWEU3US9RamNyZk1aYXZXdUlKS3pwR0c5bEFFQURWNExBTXFIWmJqeDJHWlNZeXBINnU3Yjk5clZxOTVNZU9tT0I1eWs3bmZOZncxMlRoaVdSVjBNTHpnei9PZExucGpwQ1YwUTFWN1lCeVZMbVFNckkyWlJGaDB6NDhVNURjUnRmaHRRbkdiVThaOGRsb09seGpFY2FkZ2N1TjkxMWZnUmJMemY3ME5ib3JMNUIzYVFQZ0xtU3l2U0lGcHRWUTZ1UjJYM3ExK2o4YVJOdG5ZaFpaQlB6MFVNdTNwYys0VytrVDEyTkRCV0k0T2YrNlFmc1k0ZTVBdkRQcTRxbDR1M3FLRUV0QkdlUm1oNm0xcWpTai83ems1cVZVMjgrZ2xJNW1LMkQ5dGc3dlB3RFVLd3oxNTk2VXUrNTBML2xpYWQ0T1I5M2hMOUdlWlpOajBwWE9lUGhmaWNYREEwbWhKd3RkY2dpbk40c0hJandqNDZKNkQ0NTgwN2dQczQzOHJUZ1NRZHdoRlZwR056d1ZWS1BTTHJnQXFsVU9UYVNWTUxwMGkweitLVzhwMWxPQUZ0OEpERmsyMktZdDJmaFlxaTVpM3lDSDZzWDFXSlNIa3VjTzYwNXdQcDMrT3NEOTZGTi9IZE9aYUdaS2puZWFnQzcwMzdnakFGNlJBYTF5aFFaMEwzQlFVVGJmSGdXNFNDTlJjekVZZ2dCR0dwMFFBZEEvbUJzTEFRQXpKc3FNYmc5Qm5PYzNheUJDUjA5dEsvaEF0SUxEM3ZBMmg5eVlzUmh0a0RWV0ZZUWMreW1xck5aTERDWjVlYXBtRG45NytrTUdObW8wbDNZWmJiQU5Wam9NTzhsekxGK0VGRUtJMGxmVVhhTXVCNi9UNGd2Q0ZOQVFha2Rob1Bwdm84UGgyb012S05Cd2p0MjRDc2lvaTljcFJwd0RRZ29Fdk1wdS9FZzV6VDU5a3hhZXZKenA2U2VYRzJNa0h2dnpFUTllblY3NllObVlBbldsdk52ZFRjVEdwZXUza3lYaHFZSk9ueWdMTk1QZkd5MEtlanEvTWJFTU9sK1ZNcGRoQzNTaSttM0NneitEajJWMjI4NXd2OEdmb3dJL3ZqWVBhY1lvNitWZ1lqMW44YnNRMmNBdjZwUGtnajJaMmViVUVSODhyNENYRGwvYm1IRmJFc25XdkZaeEFYcWw1Snk3TnpLR3hpOE96cWpORlVpSGxqUTZqTEE5VmVIRkVOWTVCVGpSMXgzWE5GQVZYdXFySjR1R0lMTERNdTl6REFlQ2pIRVg0NXczU3pnaENwbGM4ZldHSitHWmtrOVFqaXhDWG1BWW9TZE81eng3MEdNeWxvK2VTWnhPTi9xbDVuZFg1WmIwSDFSUUNINjJBd2U4K280L0R5bzA0WlR1SGJ4YkxqbzBTR2NwMUFzMEEzNjF1MTRzQ2hOenpoVFBBaXhDRkl2ZWlOeUN1TEJyMHhlbVdHSVpVNjJuZTFFQS8rS0YxN2hWT0NEQWN3REwwTUpWNTN2MDJtN0FsMi9Cd1hTZk9SUW8rckNkaHZ0Sm1KUG9CNGMzbDNXZXJUU294UFI5M0NtYmdFK0NSQjFSSjgrY1VMSjJWNmNaeC9VTXVPT1hDdi9XOFRnL29UUzFuUy93eGFudFhPTVAyaHZGcGpFTExoYTRqL3ZqNzE5Ly9DMUhiRzMvczhzaEt3YlpzQlpCcVNpT2FRdERlV0NudkphMjJKTCtlZ3BWNzloNXZFTWVWWDZvWVFQK0xOTDQvYXZUUUlrUnZpRTIrdEJNSnE0czBUemxkNzhyRXZCMFhzZkdsU3lRaW1Da05mQzlyNE43Tng5NDUwLzlkREZWL3U2Ni9JelBxNkRWcjdSSXBzNkk1K0hWUnJtK0tMb3B6cFhyWmVMaTRSUTVPVEt2WE5GbDMxVjVxT21SOG9EMEFqS0VjOFh5Z1NmZ0JWRmNRWU1wVXlXRWlRdlZJQlgrV1YzQUhtZ1hrZ3hyNW1mbEM2V0huaGdDK1AvNWdiWklaNE90RUNXZFY5WXlCVnZ6NnY2OEtWRWk0Yks3aU1MNFBreWdnQjZBTWUzcm5OR0JmUHdKRXFVbW1sRGt3cE1laUVIYzJlZDJyV0Q3cWkxeVc1UTVQMytPeXF6QXFiYzN4anZNNmg1Z1Z5YkVKK2d4QjUvNjVXYVozRzRlUEdoOWJOaWVoaVIxTGVTZXlOeUVVZStYaHNhVHpFY3pYWHZZNWtMUERoT2REWDVOMkVucXpmMXRTUnB4QjY3QTc5ZTAycml6MlVhclNTWW9wS1ZuaG9RbVc2Um83UWJYSEJmWkhUdnBFaU5PbmJNZE42ckpuOUxwVmlHbjZIOU1vOEwrdlJxNktROTllMDcvLy9IeElkUGpyajcwZXAzWEcybW1sWGhGWVFYeUltY0orNmVyZnBER1ZmUFMrdEtVUXRYMkk3WFpFMm4xMEttNkNPbHk4VW01TVhqYlN5clBDakpIaWlkcURNRG1PZXNoaVY2KzNpQjhJb1FabkhaZU9tUkpaRjV4MDJVVUhleVV6cTVZMkQ5UEcvRWszSXlqNlNyRkh3VWJ4dW50YVRWZkM1NHNHM3B5eDN5SS92RlZpS2pTeENHWmlYK2lDdThFQTRma2tOZGxoSmJOaDA2NE9obXo2aGY1QnVHWnVHbVZlRlZYUUZsM2ZlWHkxWUlQdk0vOGJCdVNQWkZCVmxZYXlJYXViK3FJa0taMEN6TGhnWVhsSzhGMk42dVo3MloycGtMLzFxL2dyQmVuSHFPb2ZNeURiM2c5aFdBYU1sMllmTThXSWlKclVWNGtJWE5wMGFmRkIyT0drcTFtMHVXTEFkUm1nVk5GNHJmdy9qN3hLSzFuT0hXTUdVakk0ckYwSjlqTGducytZc0dvTVFBNzFjT2NFNjhKWTAvbFVLODYzTTVHaytQcEFNR3cxa2FmY3pQWkN1V2FNb1pnbS9SQ2RuVVJYV0E0aExIRnN1Y1gxMlRzM01QSHhmL1Jpa1BBcHFRZWMzYXUzWW9LZ2RRNVpUdlNyL0h3K0h4azExUXdWN25BMFRMM2g5bjF4eEVURzFzTm9laU1UT1M3UUt0cUV4TGR4N3hDNTh0NDc0VXRqYjhld1JlMk0yL0J3Z0h2QThtNEZaR0x1UW9qREFqZm0vMDlkYVVYMGlhOUF5a2lxVU0yUko0L01BQksxQ3U1d1JTcHFyL0NQMHE4UnBnSktzTUVML2JlNkxYVSttQm1pZ0xSYWtYZE1EMXNBRjRqa1ljZzB6UXB1NTRYM3ptQkRFWVAvd2lJZDRlMHNqanRreVpRa25uZkpvZ0ZYM3pFUTAvanZ4ZEIrNWtMTVU3QlQ3RjFGN0N6eUhsQUxFeDFwaHJzR1dwVUp2L280R09VYmNoR3BVNDdmWDJFMUNpT1IzQTZkOU9KZTdiZ25TbklkOTkxYVBqZHBKZEFZQllOd0F2cGp3cXhXc3l6aS80dTY4UVBsQXBQZmlqbEFrR3Zkbi9zVjFQMlU5d1hDUHl5RThUMm05Y3VrUWF6blJ0SkZBK0NsQ0QrdVpEL3ZVb2ZsZDVWMFo1cmhDSWlXamJGNHRwQm43VUFObFJWcERZQlB1Z211andZZlBpRTNzUXlEMjROb1lBNDZ2K3RVRVEwMmNuQ0dhRzJmMG4rdWJBSktaeGxvMHVHVDRrNlZDRU5wZjFCYmhNK1VLME5jaTdBcTVlaUtjbktaL1ZpUFBGTVA0T3NXb21lSFh5cVZOYXZ5b21QR210c2lQc015dnJvR0VObDhsOU5kVy9yRVF1RE0waEsrei84UE56VXp0OG9YU2xwQ0FkZ2RxQXBnaWlIN2dBVW5PRURRT1NoMnVNaFFLcXNqZzMxU0pjZXBtQWc0cDh6SVRpbHpSeXJFZU1CVmg5dElZcitLZ3lCaHhLWW50Z2NGc3B2MHEvK0M4Ym5rU25MRisydXlFYTRqQi9qb1NZY3Zrd3F6d2RlK2hOdnprNHUwT2UyNGhrU1dkRmFudDRLcCt5Y256c1JRa25vcFhZcnpwcVY1SEdlQmRlVnlFSXNtRHlxNlVTcitVcDMrNHd6b1NMbmhMQU5tZzIxbmVWSWN5cUUzLzgrWDFFRkdxVTFpKzc5U2s5Y095TmVnTTl5L3lpSWZpc0FZRDhCT0tLZE1GWXNhZVBpS2Y5SnVjUkwvYXp3L0NPc3B4NmpYNUFKWUkxQnlCVUpncnpCdFVtU3lrRUNUVi9CbHoxQ2tlcEp0bjVVamNFWWJNcWZHN1YvVFoxdzNSc3F6blpDdVoxM1IyNG1henRabkUzSyt4V2g0NUhLS0pnQmI3KytlYUVFVlRXSTAzMjlQbG14RzNJN3R3YmRpaXFRcGJzMk1tRElQNkk3dkZLTW1SbkRzWHVxcTFab3lGcTJ4ek9RZzBwSlpGUVcwb2Fhb1lBNkR1d2JjbXBJWi94dE1aa09RaDBhY3Z5ZGE4bGdRaXl4WDRGRkJteTFkNnA4TXdxQzlKSGlIc0s5M1NmNGl6dVRRQ3VZaUFJUS9YbTVIV3dCV1ZQR3FiaWhwbktURnlNcXV1U2ZCUzRHN1JLNzh1b0tFa2krNjRvbXRNRGxKZng5TnpFWU9OenQ3cDl4RGZqMU1CTTB0RTE0VWlaRzJ0dWVnRFoxeko0NkdmbWJhaE80VXl4YjNwL1Jrd21UOHlxWUF2YzFrVFYwc04xc21OTGVXZWpNdXRMUmIvMXR5clIwNnRQYnlIY25oNGdOdUwzTWFEOVNVMEkvY2hBbEdtektxODJXQUI4K2w5SWtNeWw4MExvZXlLV1UxeWUyYk01TFpiSnhxY3dkaGNvNGhzZWJlRGI1dkFDWTlIREJZU2ZYb0ZjbENZTEJ6S3NRc0FXRmt3VnVmbW1jQjduTUdkeGhxNHZlZi9JSVVUM2kxNUt6bjJlU2pzaDJVRGpRQVBSVHllYm1CWEIyL0M0ZVlFM0h5ajE3MDZlYng2S1lRdU5sTVo1Q0hrcU9Vakl4NHdLakRWQXo3aFJnUWtOd3g1REdKNjJVZlNuWmwrTmlYSjhpckI1YnVlTFRNRVlIKzB1ZzI5WVVqNm5nQ0x0WDd0RmpRQmpqOXNyWnJVcEU1eFVYSytmZHp1V2lWS1NWc2o0bmZEZ1c4ZStrekFhUXoyWENMY3ZsZ1N5UzJLNXYwdjRjNWMyUDUwdUVNTnFlZldKM0haVC9lWmlXTk05ZnpDelZQTGM3eUZwcWdlK1BmbzZqZ21OWk5DRW1RK2J3UldLVnNUZHBTbkFzdkVTYVBPbkZOaTdmbFZSTk1FVzNyekpJeGdHQXpNRG5yRXF0eEpKMkUvVGdKUWtYQnh6UE9qNE1kTW01TFRRTWhab0V5NVM5WW52TnFEVXBueXlLVUV0dlltM2M1aG83akcycW5Sa28xWmFsbzRUbTBWdmk4VHJ5UE5QbXAwMmc3ZTZPSEdZRGtFV1NRMTl4ZnNwVi8vZWlNVEJjVFdvM0NaR0x0anE4Z3M5TDgzejkrNkFMTkJwMytsbG9kb3QvakNIbHk0WWIvc2lJbFUzZUNHVTBZNUE2UVhZd3RBWDdqblRDVy85KzZ2WEJXakdPenpMWm5Mb3piTm1oYUZDN2JyWVpNOXdZNEQ1YVZVWTdhdkExTEFsRzYxQjc4NU4yR1RBNDQ0amlhaHpuR3pFcU1EYlJXdUJWaTFzNmpVOXBhT1IwaWhjVjE3SkpJR2hZNFNoVTZDNlZ3NjZPaGNQa0ZwTXIxRjFjZSt3M3k1aHVMVWJadkpwdlFSRkxJV3dBZGxoVUZFUjg1bzZzZkluWi91SW9BOERNV2JlMHFHZ3hucVgvU2NPbTRTZHp5cnA3QjNxdUFDaThXZEtWNnljTFRxZFA2Q2JGczdjdGk2OHhXWlZYV08rT1JmVWFMaGYzNHJiU0RuNlkvdmxxeXp6emhrYnVLbjJKSVpXOW1pRm85QmF3dGdzWGJ5UE5WVU5WZHZSYVhFdTlMYjdXS0VvNS9iUVdCZkpNYmdkWjMvclZoMTV1ekRRVk9SZ05BOVpyR2huUEFjbDZ2bVN2ZFBMRDEyM1JUbTJpN0tNQWhBR1B3bDYxano3ZW5yVUJMZVFhWHRpZjI4ZVBKeEc4NDluaFlraVNGclBWZFJBR1d2ZjF0TW1RU2pZa1l4UmtFQ2pCdlRjZTA4NWNWc0lyOHlkbzZSbm4xWExTKzcxd3lhT0F3WElNekVacUloQ2FBY29DUU5ScVhQVm1Ka1ltR3ZxZHozL1RQVUd5YXVjenNFcG1CT2NRWXlpMHBQempwKzZUYkdZN3VWemVTOEZGbk9YOFRQRE0wWGQ2K3JyS0o2SGRCdS9ZdFkxL2h4eUEvVkJsRXpJZHp3RWw1b2UzY0k5Ym1XRm44b0VIeG1CUW1VT0xESDZDV2x2V1IvVDI3VTJOaFZkQ2VISllRZmdreDdZeW9VVExYZ3VydW1vMlJVQkJTR3ViTlNIakV0Qnk0dCtONTZ1U0lCQmJraS9WSTQwNEsyNE9kVFVsWi9OSEZ0a1VPL1hoODBTeUhHUU5YNzFZMXVJTUtiK0hqRGdSbEVmWVpxSkZpTFBWUXlzV1RQdSt5UmpFZWlLd3pLTEFJNEtDS3B6U3hCOXR0U2VuWHowZE1qNnhrOEhoaVpwSTQ0dzFGV1pkRWlnZDVrNnZoQVkyanhQOWFmdThMcVVjK05vWnY3dE12M0hEVmZnM2orSWpnUHRYUktpSEFZUlhwZ1pSZjAwbDRMYm9sakQveWV4VjRxREd1ZVVxRWNwcEJwbGttWTJ4NXFUUmFiWUM1TXoxNDVGdGxrOGxQOEVNVnlLTEx2NDhXRG1RYU1XdDdTR2svVVVBVVlFcWtLS0VseTFiQWJNVHVNRkVrQnlhUlRyekc4d2xBdks4M0k5ZTV5czJxOEY2aTV0MnQ4c1RLQmhScUFuZjFOQ3VpTWFyT1RhSzI4TTNJdllJOXpyTjdVVmdvejlQRWdteHhuVjFWbjM0Nzd3NFgzMzB6ZmlhUmlVTXNzeXZMT3pQbWtobFB4QmhCbDIvM0Fzem1LYjZxZ0xEbko2dUhKU1VWWFdWOURUczRjRm1SU3I3RVNrWkwyYzFPZzBhaHBtQ3ArZU1UanAwN1gyaWFvWUFTUUl1ZFRBSHZnbHBrZVIrd2MzTTJSTXVlTkR0TndqbFltVXZmTTRuMi91V21ocjF4RHBHcFc0VEVPcDVMR3RqRmZrWEd5RkZ2cSswSjlScVNLRkpBL216NWhWQkpDeXJwdnBwQkZ4L2VXZ2s5RmpiOHhKSkQzQi8xVWZjOW05UjJCUHhjdzE1ZTQxckVlN1lIWDhOMEo1b3lqTGRPYlRmWFVlNEJvMmpOb01xbDdXMGpLa2ZkREpyTVVuNWVBTncrelRJdldTVTl1UWI4VVBaeEtsZWRiWmhZOWpEOWhTelMyUzVMZmFOcTFocUtKdzhvNTRYOW51S1RiUFJFcExOTW5HSFY1UWE1UHdKUnJiblBuWDNVOG1pUFdUcVJKV0laZGx2M2FmejlXOXNaSDRGVTFVVG5qaXFDSUI3OWpaMUQ1ckwvVlAxNk9TdEN0eEdwVkdHVU9WN0ZaODI2TWwzOEE1K0RpdWtWZEJ6MElTTkZidElNMndzeHlBTWREcEIvRjRsVkhCRXlHNjNXSlkvQzZoeEplajlRWCt5Q3lYZ3l5K0dFU1pvSzdncDZvRkRPVlM5b05HZ3ZldFVYVTlkRnlWZ29yTWhVa3ZKNkxua09YSjN0YnRsRUN6WHF1VHZsWG1nRDFSczNaZ2lwTkd6dlZlczMway9WbmQweXdJSG5JQTllMk1NbmRaajN4RDNNM1Y1RnB3bjgrUUdNOUJCcWE5TjNLa1I2ZzRVZVhGT05OMVFxUkhhaXhUeGxSSUNRYUFWY0lPUHo0RVpyS04rbVI0TmZXWWpVeE01K25wSGZoYVkyRkFyUkZWaEdsSlJ1RkV0M2lmT0g1RWlJejRYajJFcXpyRE13YWJqNzFQNXZHRXZHMlJRYTRvMnkxWlBLTW1YMEFuZFlyN3hRVVRMajBnUW1tNnVyMXZMQjlWQXlEeDltUEh6T0VENDI1ZmtkdmNBZnBCYWJuNjFTQng3UFVON0hOS2djUlVPczljOERLalV4RXZjRUREblN6VXlDZUFKR2xDVnVrZkxRWDUxejRiUjdLQjhsVkRIMVBkdFJ5dkkweW5LL0hiUjFEajNWdkpiS2MydDNiUStnMXcraDloTmVOelNSdEVTdExPWm1mWm1YdGRWMnl6Z2hDSE1GVWpBbDRYY3NHSVVRSG00Rk9mQy9BMGpDdUdnWmVHTGcwUWZsZTJYSm9GeHhBYTJkYUUyS0Nmbyt2aUJaMEZadHNNcnRnc3VzZDVNVEJEaXl2S0hETFlmQ2RRVnhZV29EUC9sQUpnck91MUlSR2w4SzRkb1VTUEw1Q0lTTFpWOTRaaDRiQ2p4YzVWOUFTZEg1QWQzR3M1cEwvNzNMeXV1Q24xNVBLeThLREQzUEhmekRRM2NFaUpwanFEckFSQXdWNVkxUmRJVk52LzNIOENhYnc4Qm04bDFqOUxGbGhkZFVNZFI0aXpLS1ZQNnNQNXVaNGpsQVppaHFBWlJ1K2xJVEQ4QVVNd3dOVVoxODlnS2RPWlNDM0ZGNGxLRmdEN1NnT2R3UE1yd003bkNrNlF6T2Z5Rm84ejdTbEdOeElFZWg0b1B4dy9qaUZoR0t4TFVmcUF0UmNteDZydEZEa0NKTUpIaWl0d0Z5a2xVbTFkcUExc0pJZmhpMm9sN0haNmU3ajZVTzVxQ0E1Tlpnemh0TUMyNkdWQXJzM1dRNm9ESi80ZCtpMEZBelUzaXQrYTArYVhjLzJsOUZ6QnpyemVLOGp1QWQ2WXdsV2ROM2xrYWdMQllVU2w4NzhMTFZoM3ZzQXFSc25MNU1JZ2FxR3EyY09tQm42ZVdveUtvSXJITEJlZFNJQ0VPa1ltNWM1SE4zSWZpWWFLNmVqVHRmTzBydUxhWEZ4bWsxTVpidWozdFNwS2lWbS8wcS82dVRMS2dPYUs5Z3BtNDMvem5KUkk0clpKVkE2YVFlVnJiVy8vSHJWeEVKQVpHeEJ5d0VONVJmVld3SERDMTVLVkgvNEtpbTQzYllqNjQybVFSdEtoaFpLcDA1MjhzNW80U3d6YUx3STNPRVdvSlFicERGaVVrekM0QjFHb2ZYeEFkUDdMMFBySmcxbVA0TT0=', '', '04 Jul, 2021');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(10) NOT NULL,
  `bookingid` varchar(10) NOT NULL,
  `payment_mode` varchar(100) NOT NULL,
  `payment_amount` varchar(100) NOT NULL,
  `slip_no` varchar(100) NOT NULL,
  `remark` varchar(500) NOT NULL,
  `payment_date` varchar(100) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `charges` varchar(1001) NOT NULL,
  `chargeamount` varchar(100) NOT NULL,
  `discounts` varchar(100) NOT NULL,
  `discountamount` varchar(100) NOT NULL,
  `net_paid` varchar(100) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `emi_ids` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `bookingid`, `payment_mode`, `payment_amount`, `slip_no`, `remark`, `payment_date`, `created_at`, `charges`, `chargeamount`, `discounts`, `discountamount`, `net_paid`, `payment_type`, `emi_ids`) VALUES
(1, '1', 'cash', '100000', '', '', '2024-10-15', '2024-10-15 07:10:50 PM', '', '', '', '', '100000', 'BOOKING', ''),
(2, '2', 'cash', '10000', '', '', '2024-10-21', '2024-10-21 12:10:24 PM', '', '', '', '', '10000', 'BOOKING', ''),
(3, '2', 'cash', '344375', '', '', '2024-10-22', '2024-10-22 07:10:26 AM', '', '', 'DIWALI OFFER', '100000', '244375', 'MONTH EMI', ''),
(4, '2', 'cash', '250000', '', '', '2024-10-22', '2024-10-22 08:10:10 AM', 'LATE FEE', '5000', '', '', '255000', 'MONTH EMI', '');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `Projects_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_title` varchar(500) NOT NULL,
  `project_type` varchar(100) NOT NULL,
  `project_descriptions` varchar(2000) NOT NULL,
  `project_area` varchar(100) NOT NULL,
  `project_measure_unit` varchar(100) NOT NULL,
  `project_status` varchar(10) NOT NULL DEFAULT 'ACTIVE',
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`Projects_id`, `company_id`, `project_title`, `project_type`, `project_descriptions`, `project_area`, `project_measure_unit`, `project_status`, `created_at`, `updated_at`) VALUES
(1, 1, 'TITANIA RESIDENCY', 'Residential Flats', 'TITANIA RESIDENCY <br>\r\nSector PHI-4 Near Vanice Mall, Greater Noida', '20698.73', 'sq Yards', '1', '2024-10-04 12:10:54 PM', '2024-10-14 06:10:06 PM');

-- --------------------------------------------------------

--
-- Table structure for table `projects_floors`
--

CREATE TABLE `projects_floors` (
  `projects_floors_id` int(10) NOT NULL,
  `project_main_id` int(10) NOT NULL,
  `projects_floor_name` varchar(30) NOT NULL,
  `projects_floors_tag` varchar(255) NOT NULL,
  `project_floors_desc` varchar(725) NOT NULL,
  `projects_floors_block_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects_floors`
--

INSERT INTO `projects_floors` (`projects_floors_id`, `project_main_id`, `projects_floor_name`, `projects_floors_tag`, `project_floors_desc`, `projects_floors_block_id`) VALUES
(1, 1, 'Ground Floor', 'parking floor', 'bVkxL1ZDUXZOTU1PMkpZdzY1K1Q0QUUwL1YwTi8rOUJkcHVkeXJQM1YybnNBMy93dUErMk1WME5XUUU1QWdTMDY4OXp0VWJHejBrTFNUTGJRWUZMTkE9PQ==', 1),
(2, 1, '1st Floor', 'premium floor', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 1),
(6, 1, '1st FLOOR', 'premium', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 2),
(8, 1, '2nd FLOOR', '2bhk, 3bhk, 5bhk rooms', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 2);

-- --------------------------------------------------------

--
-- Table structure for table `project_blocks`
--

CREATE TABLE `project_blocks` (
  `project_block_id` int(10) NOT NULL,
  `project_main_id` int(10) NOT NULL,
  `project_block_name` varchar(255) NOT NULL,
  `project_block_descriptions` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_blocks`
--

INSERT INTO `project_blocks` (`project_block_id`, `project_main_id`, `project_block_name`, `project_block_descriptions`) VALUES
(1, 1, 'BLOCK A', 'a1ZpY1duQnVRQTlUQVJPUWMyN3QwQ3JIbzJzT1Q4YlhWOUpUdkNKTERpRVBxbGt0c2xoeXB2L0ErVG5SSTNGUw=='),
(2, 1, 'BLOCK B', 'RHphOU5SMFd4NHBBdVZTbTYwN1VDZz09');

-- --------------------------------------------------------

--
-- Table structure for table `project_media_files`
--

CREATE TABLE `project_media_files` (
  `ProjectMediaFileId` int(100) NOT NULL,
  `ProjectMainProjectId` int(100) NOT NULL,
  `ProjectMediaFileType` varchar(100) NOT NULL,
  `ProjectMediaFileAttachements` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_stages`
--

CREATE TABLE `project_stages` (
  `ProjectStageId` int(100) NOT NULL,
  `ProjectStageMainProjectId` varchar(100) NOT NULL,
  `ProjectStageName` varchar(1000) NOT NULL,
  `ProjectStageCreatedAt` varchar(50) NOT NULL,
  `ProjectStageUpdatedAt` varchar(50) NOT NULL,
  `ProjectStagePaymentPercentage` varchar(10) NOT NULL,
  `ProjectStageDescriptions` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_types`
--

CREATE TABLE `project_types` (
  `project_type_id` int(11) NOT NULL,
  `company_id` varchar(11) NOT NULL,
  `project_type_name` varchar(100) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `udpated_at` varchar(100) NOT NULL,
  `project_type_status` varchar(10) NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_types`
--

INSERT INTO `project_types` (`project_type_id`, `company_id`, `project_type_name`, `created_at`, `udpated_at`, `project_type_status`) VALUES
(1, '1', 'Residential Plots', '2024-10-11 06:10:25 PM', '', 'ACTIVE'),
(2, '1', 'Residential Flats', '2024-10-11 06:10:46 PM', '', 'ACTIVE'),
(3, '1', 'Shops', '2024-10-11 06:10:51 PM', '', 'ACTIVE'),
(4, '1', 'Commercial Spaces', '2024-10-11 06:10:17 PM', '', 'ACTIVE'),
(5, '1', 'Office Spaces', '2024-10-11 06:10:26 PM', '', 'ACTIVE'),
(6, '1', 'Villas ', '2024-10-11 06:10:43 PM', '', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `project_units`
--

CREATE TABLE `project_units` (
  `project_units_id` int(11) NOT NULL,
  `project_id` int(10) NOT NULL,
  `project_block_id` int(10) NOT NULL,
  `project_floor_id` int(10) NOT NULL,
  `projects_unit_type` varchar(10) NOT NULL,
  `projects_unit_name` varchar(100) NOT NULL,
  `project_unit_description` varchar(1000) NOT NULL,
  `project_unit_area` varchar(100) NOT NULL,
  `project_unit_bhk_type` varchar(20) NOT NULL,
  `project_unit_highlights` varchar(255) NOT NULL,
  `project_unit_measurement_unit` varchar(10) NOT NULL,
  `project_unit_status` varchar(10) NOT NULL,
  `project_unit_price` int(10) NOT NULL,
  `unit_per_price` int(100) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL,
  `unit_broker_rate` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_units`
--

INSERT INTO `project_units` (`project_units_id`, `project_id`, `project_block_id`, `project_floor_id`, `projects_unit_type`, `projects_unit_name`, `project_unit_description`, `project_unit_area`, `project_unit_bhk_type`, `project_unit_highlights`, `project_unit_measurement_unit`, `project_unit_status`, `project_unit_price`, `unit_per_price`, `created_at`, `updated_at`, `unit_broker_rate`) VALUES
(1, 1, 1, 1, 'PARKING', 'PARKING', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '1500', 'PARKING', '', 'sq. ft', 'ACTIVE', 9000000, 6000, '', '', '5700'),
(5, 1, 2, 6, 'FLAT', '101', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '1350', '2BHK', '', 'sq. ft', 'SOLD', 8100000, 6000, '', '', '5500'),
(6, 1, 2, 6, 'FLAT', '102', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '1350', '3BHK', '', 'sq. ft', 'ACTIVE', 810000, 600, '', '', ''),
(9, 1, 2, 6, 'FLAT', '103', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '1350', '2BHK', '', 'sq. ft', 'ACTIVE', 810000, 600, '', '', ''),
(10, 1, 1, 2, 'FLAT', '103', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '1450', '2BHK', '', 'sq. ft', 'ACTIVE', 8700000, 6000, '', '', ''),
(11, 1, 2, 8, 'FLAT', '201', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '1450', '3BHK', '2 side open balcony', 'sq. ft', 'ACTIVE', 8700000, 6000, '', '', '5500'),
(12, 1, 2, 8, 'FLAT', '202', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '1450', '2BHK', '', 'sq. ft', 'ACTIVE', 8700000, 6000, '', '', '5500'),
(13, 1, 2, 8, 'FLAT', '203', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '1450', '2BHK', '', 'sq. ft', 'ACTIVE', 8700000, 6000, '', '', '5500'),
(14, 1, 2, 8, 'FLAT', '204', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '1450', '2BHK', '', 'sq. ft', 'ACTIVE', 8700000, 6000, '', '', '5500'),
(15, 1, 2, 8, 'FLAT', '205', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '1450', '2BHK', '', 'sq. ft', 'ACTIVE', 8700000, 6000, '', '', '5500'),
(16, 1, 2, 8, 'FLAT', '206', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '1450', '2BHK', '', 'sq. ft', 'ACTIVE', 8700000, 6000, '', '', '5500'),
(17, 1, 2, 8, 'FLAT', '207', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '1450', '2BHK', '', 'sq. ft', 'ACTIVE', 8700000, 6000, '', '', '5500'),
(18, 1, 2, 8, 'FLAT', '208', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '1450', '2BHK', '', 'sq. ft', 'ACTIVE', 8700000, 6000, '', '', '5500'),
(19, 1, 2, 8, 'FLAT', '209', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '1450', '2BHK', '', 'sq. ft', 'ACTIVE', 8700000, 6000, '', '', '5500'),
(20, 1, 2, 8, 'FLAT', '210', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '1450', '2BHK', '', 'sq. ft', 'ACTIVE', 8700000, 6000, '', '', '5500'),
(21, 1, 2, 8, 'FLAT', '211', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '1450', '2BHK', '', 'sq. ft', 'ACTIVE', 8700000, 6000, '', '', '5500');

-- --------------------------------------------------------

--
-- Table structure for table `project_unit_attributes`
--

CREATE TABLE `project_unit_attributes` (
  `ProjectUnitAttributeId` int(255) NOT NULL,
  `ProjectUnitListId` varchar(1000) NOT NULL,
  `ProjectUnitAttributeName` varchar(1000) NOT NULL,
  `ProjectUnitAttributeValue` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `sliderid` int(10) NOT NULL,
  `slidertitle` varchar(100) NOT NULL,
  `sliderdesc` varchar(10000) NOT NULL,
  `sliderimg` varchar(200) NOT NULL,
  `CreatedAt` varchar(100) NOT NULL,
  `UpdatedAt` varchar(100) NOT NULL,
  `Status` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`sliderid`, `slidertitle`, `sliderdesc`, `sliderimg`, `CreatedAt`, `UpdatedAt`, `Status`) VALUES
(41, 'YASH VIHAR PROJECT', 'QVlaZDc5dTZoNEZUSU1wWVJjQmt4bmhldlFFTUxxZXl5Mmw0YU9HU3dPRT0=', 'SliderImg_YASH_VIHAR_PROJECT_24_Sep_2022_06_09_57_29078909571_.jpg', '2022-09-24 06:09:57 PM', '2022-11-21 05:11:27 PM', '1'),
(42, 'YASH VIHAR LIVE', 'U08zK2hQb3BRV2VwQ3VIZzdoZFpQWjFLN2tyNGpwSEJXZ1N1aGd2a3U4QT0=', 'SliderImg_YASH_VIHAR_LIVE_24_Sep_2022_06_09_28_29146228406_.jpeg', '2022-09-24 06:09:28 PM', '2022-09-24 06:09:28 PM', '1'),
(43, 'Deen Dayal Jan Awas Yojna ', 'eTIwTHZZcXd4ZUZaVjFLQ1gvQThKS0ZGWDNqbndqWkJvWWVxc1kzL1N6Zz0=', 'SliderImg_Deen_Dayal_Jan_Awas_Yojna__24_Sep_2022_06_09_54_96421971170_.jpeg', '2022-09-24 06:09:54 PM', '2022-09-24 06:09:07 PM', '1'),
(44, 'Affordable Project ', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 'SliderImg_Affordable_Project__24_Sep_2022_06_09_22_82198963034_.jpeg', '2022-09-24 06:09:22 PM', '2022-09-24 06:09:22 PM', '1'),
(45, 'YASH VIHAR ', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 'SliderImg_Pataudi_Road__24_Sep_2022_06_09_38_95849915933_.jpeg', '2022-09-24 06:09:38 PM', '2022-09-24 06:09:21 PM', '1');

-- --------------------------------------------------------

--
-- Table structure for table `sociallinks`
--

CREATE TABLE `sociallinks` (
  `linkid` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `status` varchar(2) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `mother_name` varchar(100) NOT NULL,
  `company_relation` varchar(10) NOT NULL,
  `agent_relation` varchar(10) NOT NULL,
  `user_profile_img` varchar(1000) NOT NULL DEFAULT 'user.png',
  `email` varchar(255) NOT NULL,
  `phone` varchar(1000) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` varchar(100) DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `alert_sound` varchar(15) NOT NULL DEFAULT 'ON',
  `user_status` varchar(10) NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_role_id`, `name`, `father_name`, `mother_name`, `company_relation`, `agent_relation`, `user_profile_img`, `email`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `alert_sound`, `user_status`) VALUES
(1, 1, 'Navix Admin', 'T/E GAURAV SINGH', '', '1', '286', 'PLotX_customers_13_Oct_2024_09_10_16_62902777140_.jpg', 'gauravsinghigc@gmail.com', '9876543210', '0000-00-00 00:00:00', '9810', NULL, NULL, 'Sun 13 Oct, 2024 09:10:06 pm', 'ON', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `usertypes`
--

CREATE TABLE `usertypes` (
  `UserTypeId` int(10) UNSIGNED NOT NULL,
  `UserTypeName` varchar(50) NOT NULL,
  `CreatedAt` varchar(100) NOT NULL,
  `UpdatedAt` varchar(100) NOT NULL,
  `AccessType` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usertypes`
--

INSERT INTO `usertypes` (`UserTypeId`, `UserTypeName`, `CreatedAt`, `UpdatedAt`, `AccessType`) VALUES
(1, 'ADMINISTRATOR', 'Sun 02 May, 2021 10:05:49 am', '', 'all');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `user_address_id` int(11) NOT NULL,
  `user_street_address` varchar(500) NOT NULL,
  `user_area_locality` varchar(100) NOT NULL,
  `user_city` varchar(100) NOT NULL,
  `user_state` varchar(100) NOT NULL,
  `user_pincode` varchar(100) NOT NULL,
  `user_country` varchar(100) NOT NULL,
  `user_id` varchar(11) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`user_address_id`, `user_street_address`, `user_area_locality`, `user_city`, `user_state`, `user_pincode`, `user_country`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Y6-11, 2nd floor, Gali No 6, Y Block', 'Sector 76', 'Faridabad', 'Haryana', '121004', 'India', '1', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_attandances`
--

CREATE TABLE `user_attandances` (
  `UserAttandanceId` int(100) NOT NULL,
  `UserAttandanceMainUserId` int(100) NOT NULL,
  `UserAttandanceStartDate` varchar(100) NOT NULL,
  `UserAttandanceStatus` varchar(100) NOT NULL,
  `UserAttandanceStartTime` varchar(100) NOT NULL,
  `UserAttandanceNotes` varchar(10000) NOT NULL,
  `UserAttandanceCreatedAt` varchar(1000) NOT NULL,
  `UserAttandanceCreatedBy` varchar(1000) NOT NULL,
  `UserAttandanceMonth` varchar(100) NOT NULL,
  `UserAttandanceEndDate` varchar(100) NOT NULL DEFAULT 'null',
  `UserAttandanceEndTime` varchar(100) NOT NULL DEFAULT 'null',
  `UserAttandanceStartIP` varchar(1000) NOT NULL,
  `UserAttandanceEndIP` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_attributes`
--

CREATE TABLE `user_attributes` (
  `user_attribute_id` int(11) NOT NULL,
  `user_attribute_name` varchar(100) NOT NULL,
  `user_attirbute_type` varchar(100) NOT NULL,
  `uset_attribute_value` varchar(10000) NOT NULL,
  `user_attribute_status` varchar(10) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_bank_details`
--

CREATE TABLE `user_bank_details` (
  `UserBankDetailsId` int(100) NOT NULL,
  `UserBankMainUserId` varchar(100) NOT NULL,
  `UserBankName` varchar(200) NOT NULL,
  `UserBankAccounHolderName` varchar(100) NOT NULL,
  `UserBankAccountNumber` varchar(100) NOT NULL,
  `UserBankAccountIFSC` varchar(100) NOT NULL,
  `UserBankOtherDetails` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_documents`
--

CREATE TABLE `user_documents` (
  `document_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `document_name` varchar(100) NOT NULL,
  `document_file` varchar(1000) NOT NULL,
  `document_status` varchar(100) NOT NULL DEFAULT 'UNVERiFIED',
  `document_created_at` varchar(100) NOT NULL,
  `document_updated_at` varchar(100) NOT NULL,
  `user_documents_no` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_employments`
--

CREATE TABLE `user_employments` (
  `UserEmploymentsId` int(100) NOT NULL,
  `UserEmpMainUserId` varchar(100) NOT NULL,
  `UserEmpWorkDays` varchar(100) NOT NULL,
  `UserEmpWorkHours` varchar(100) NOT NULL,
  `UserWorkFeilds` varchar(100) NOT NULL,
  `UserDepartment` varchar(100) NOT NULL,
  `UserDesignation` varchar(100) NOT NULL,
  `UserJoinningDate` varchar(100) NOT NULL,
  `UserempUpdateDate` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_pay_scale`
--

CREATE TABLE `user_pay_scale` (
  `UserPayScaleId` int(100) NOT NULL,
  `UserMainUserId` int(100) NOT NULL,
  `UserPayScale` varchar(100) NOT NULL,
  `UserPayFrequency` varchar(100) NOT NULL,
  `UserPayType` varchar(100) NOT NULL,
  `UserPayStartFrom` varchar(100) NOT NULL,
  `UserPayDate` varchar(100) NOT NULL,
  `UserPayScaleUpdatedAt` varchar(100) NOT NULL,
  `UserPayNotes` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(15) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`role_id`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 'administrator', '2021-05-16 12:16:17.000000', '2021-05-16 12:16:17.000000'),
(2, 'admin', '2021-05-16 12:16:43.000000', '0000-00-00 00:00:00.000000'),
(3, 'partner', '2021-05-16 12:16:57.000000', '0000-00-00 00:00:00.000000'),
(4, 'customer', '2021-05-16 12:17:12.000000', '0000-00-00 00:00:00.000000'),
(5, 'Employee', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `user_transactions`
--

CREATE TABLE `user_transactions` (
  `UserTxnid` int(100) NOT NULL,
  `UserTxnMainUserId` varchar(100) NOT NULL,
  `UserTxnType` varchar(100) NOT NULL,
  `UserTxnAmount` varchar(100) NOT NULL,
  `UserTxnDetails` varchar(10000) NOT NULL,
  `UserTxnDate` varchar(100) NOT NULL,
  `UserTxnCreatedAt` varchar(100) NOT NULL,
  `UserTxnUpdatedAt` varchar(100) NOT NULL,
  `UserTxnCreatedBy` varchar(100) NOT NULL,
  `UserTxnStatus` varchar(100) NOT NULL,
  `UserTxnDocuments` varchar(100) NOT NULL,
  `TxnCustomRefId` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `vendor_id` int(10) NOT NULL,
  `vendor_company_name` varchar(155) NOT NULL,
  `vendor_display_name` varchar(725) NOT NULL,
  `vendor_person_name` varchar(255) NOT NULL,
  `vendor_person_phone` varchar(15) NOT NULL,
  `vendor_highlight_details` varchar(725) NOT NULL,
  `vendor_person_email_id` varchar(255) NOT NULL,
  `vendor_person_street_address` varchar(725) NOT NULL,
  `vendor_person_area_locality` varchar(155) NOT NULL,
  `vendor_person_city` varchar(75) NOT NULL,
  `vendor_person_state` varchar(55) NOT NULL,
  `vendor_person_country` varchar(55) NOT NULL,
  `vendor_person_pincode` varchar(10) NOT NULL,
  `vendor_gst_no` varchar(50) NOT NULL,
  `vendor_created_at` varchar(45) NOT NULL,
  `vendor_updated_at` varchar(45) NOT NULL,
  `vendor_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`vendor_id`, `vendor_company_name`, `vendor_display_name`, `vendor_person_name`, `vendor_person_phone`, `vendor_highlight_details`, `vendor_person_email_id`, `vendor_person_street_address`, `vendor_person_area_locality`, `vendor_person_city`, `vendor_person_state`, `vendor_person_country`, `vendor_person_pincode`, `vendor_gst_no`, `vendor_created_at`, `vendor_updated_at`, `vendor_status`) VALUES
(1, 'GAURAVSINGHIGC', 'GAURAV SINGH GAURAVSINGHIGC', 'GAURAV SINGH', '9318310565', 'IT SERVICES', 'gauravsinghigc@gmail.com', 'Y6-11/2nd floor, gali no 6, Y Block, BPTP', 'Sector 76', 'Faridabad', '27', 'INDIA', '121004', 'NO', '2024-10-20', '', 1),
(2, 'NAVIX CONSULATNC SERVICES', 'VIKASH ARYA NAVIX CONSULATNC SERVICES', 'VIKASH ARYA', '9911229504', 'IT SERVICES', 'navix365@gmail.com', 'A119', 'Secto 63', 'NODIA', '27', 'INDIA', '121004', 'NO', '2024-10-21', '2024-10-29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vendor_materials`
--

CREATE TABLE `vendor_materials` (
  `vendor_material_id` int(10) NOT NULL,
  `vendor_main_id` int(10) NOT NULL,
  `vendor_material_bill_no` varchar(30) NOT NULL,
  `vendor_material_remarks` varchar(725) NOT NULL,
  `vendor_material_created_by` int(10) NOT NULL,
  `vendor_material_updated_by` int(10) NOT NULL,
  `vendor_material_created_at` varchar(45) NOT NULL,
  `vendor_material_updated_at` varchar(45) NOT NULL,
  `vendor_material_receive_date` varchar(45) NOT NULL,
  `vendor_material_uploaded_bill` varchar(725) NOT NULL,
  `vendor_material_net_amount` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor_materials`
--

INSERT INTO `vendor_materials` (`vendor_material_id`, `vendor_main_id`, `vendor_material_bill_no`, `vendor_material_remarks`, `vendor_material_created_by`, `vendor_material_updated_by`, `vendor_material_created_at`, `vendor_material_updated_at`, `vendor_material_receive_date`, `vendor_material_uploaded_bill`, `vendor_material_net_amount`) VALUES
(1, 1, '', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 1, 1, '2024-11-08', '2024-11-08', '2024-11-08', 'Vendor_Material_Record_08_Nov_2024_04_11_06_14477615198_.pdf', '100000'),
(2, 2, '', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 1, 1, '2024-11-08', '2024-11-08', '2024-11-08', 'Vendor_Material_Record_08_Nov_2024_04_11_54_2825773128_.jpg', '12000');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_material_items`
--

CREATE TABLE `vendor_material_items` (
  `vendor_material_item_id` int(10) NOT NULL,
  `vendor_material_main_id` varchar(10) NOT NULL,
  `vendor_material_item_name` varchar(255) NOT NULL,
  `vendor_material_item_serial_no` varchar(55) NOT NULL,
  `vendor_material_item_sos_number` varchar(55) NOT NULL,
  `vendor_material_item_unit_rate` varchar(10) NOT NULL,
  `vendor_material_item_qty` varchar(10) NOT NULL,
  `vendor_material_item_qty_type` varchar(75) NOT NULL,
  `vendor_material_item_net_price` varchar(10) NOT NULL,
  `vendor_material_item_desc` varchar(725) NOT NULL,
  `vendor_material_added_at` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor_material_items`
--

INSERT INTO `vendor_material_items` (`vendor_material_item_id`, `vendor_material_main_id`, `vendor_material_item_name`, `vendor_material_item_serial_no`, `vendor_material_item_sos_number`, `vendor_material_item_unit_rate`, `vendor_material_item_qty`, `vendor_material_item_qty_type`, `vendor_material_item_net_price`, `vendor_material_item_desc`, `vendor_material_added_at`) VALUES
(1, '1', 'sand', '1234', '134', '4500', '45', 'TON', '202500', '', '2024-11-08'),
(2, '2', 'sand', '1234', '2344', '4500', '45', 'TON', '202500', '', '2024-11-08'),
(3, '2', 'rodi', '1230', '677', '3400', '65', 'TON', '221000', '', '2024-11-08');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_transactions`
--

CREATE TABLE `vendor_transactions` (
  `vendor_transactions_id` int(10) NOT NULL,
  `vendor_main_id` int(10) NOT NULL,
  `vendor_material_id` int(10) NOT NULL,
  `vendor_paid_amount` varchar(12) NOT NULL,
  `vendor_pay_mode` varchar(50) NOT NULL,
  `vendor_pay_ref_no` varchar(30) NOT NULL,
  `vendor_payment_details` varchar(1000) NOT NULL,
  `vendor_payment_date` varchar(45) NOT NULL,
  `vendor_payment_created_at` varchar(45) NOT NULL,
  `vendor_payment_updated_at` varchar(45) NOT NULL,
  `vendor_payment_created_by` int(10) NOT NULL,
  `vendor_payment_updated_by` int(10) NOT NULL,
  `vendor_payment_have_receipt` varchar(725) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor_transactions`
--

INSERT INTO `vendor_transactions` (`vendor_transactions_id`, `vendor_main_id`, `vendor_material_id`, `vendor_paid_amount`, `vendor_pay_mode`, `vendor_pay_ref_no`, `vendor_payment_details`, `vendor_payment_date`, `vendor_payment_created_at`, `vendor_payment_updated_at`, `vendor_payment_created_by`, `vendor_payment_updated_by`, `vendor_payment_have_receipt`) VALUES
(1, 2, 0, '10000', 'Cash', 'cash', 'eVVYdld6L216VCtZbFlGV2dzMUxadz09', '2024-11-08', '2024-11-08', '2024-11-08', 1, 1, ''),
(2, 2, 0, '12000', 'Cash', 'RG', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2024-11-08', '2024-11-08', '2024-11-08', 1, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `walkins`
--

CREATE TABLE `walkins` (
  `walkinsid` int(100) NOT NULL,
  `WalkinName` varchar(100) NOT NULL,
  `WalkinPhone` varchar(100) NOT NULL,
  `WalkinAddress` varchar(100) NOT NULL,
  `WalkinEmailid` varchar(100) NOT NULL,
  `WalkinTypes` varchar(100) NOT NULL,
  `WalkinsRemarks` varchar(1000) NOT NULL,
  `WalkinCreatedAt` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `walkins`
--

INSERT INTO `walkins` (`walkinsid`, `WalkinName`, `WalkinPhone`, `WalkinAddress`, `WalkinEmailid`, `WalkinTypes`, `WalkinsRemarks`, `WalkinCreatedAt`) VALUES
(1, 'N0FyaEYzRVZJTU8raGVPZndaam8rdz09', 'bHo2SlF2cDZUNUE0S3NYeXArV3NhQT09', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 'Y1lhcThjMGpPRXBqVE5jNHJMQm1HY21yVlZTbFk2WDE5YnFXc1NETjVQUT0=', 'YVVQMUcyMEtuc3hEdDJTZ01pcnRGUT09', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '14 Oct, 2024'),
(2, 'Montana Rivera', '+1 (457) 381-4845', 'At iure animi irure', 'rirabodaf@mailinator.com', 'Marketings', 'OUNHWHRoeXVacnBGOE9IMTMrU3ZZMFJNenVsWEpQY0VrWldicTFoNzF6dz0=', '14 Oct, 2024'),
(3, 'Jamalia Stafford', '+1 (114) 419-8616', 'Non laudantium dele', 'fugyf@mailinator.com', 'Maintenance', 'aUs4b2VpWlNXTWZxc3FNdmd2ZGlxb2FWZ2hjb1ZmVG5oZHNuS2VmNHBjND0=', '14 Oct, 2024');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activitytrack`
--
ALTER TABLE `activitytrack`
  ADD PRIMARY KEY (`ActivityId`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`AssetsId`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`bookingid`);

--
-- Indexes for table `booking_alloties`
--
ALTER TABLE `booking_alloties`
  ADD PRIMARY KEY (`BookingAllotyId`);

--
-- Indexes for table `booking_alloty_documents`
--
ALTER TABLE `booking_alloty_documents`
  ADD PRIMARY KEY (`BookingAlloteeDocId`);

--
-- Indexes for table `booking_cancelled`
--
ALTER TABLE `booking_cancelled`
  ADD PRIMARY KEY (`BookingCancelledId`);

--
-- Indexes for table `booking_emis`
--
ALTER TABLE `booking_emis`
  ADD PRIMARY KEY (`emi_id`);

--
-- Indexes for table `booking_loans`
--
ALTER TABLE `booking_loans`
  ADD PRIMARY KEY (`booking_loan_id`);

--
-- Indexes for table `booking_pay_req`
--
ALTER TABLE `booking_pay_req`
  ADD PRIMARY KEY (`PaymentRequestId`);

--
-- Indexes for table `booking_refund`
--
ALTER TABLE `booking_refund`
  ADD PRIMARY KEY (`BookingRefundId`);

--
-- Indexes for table `booking_resales`
--
ALTER TABLE `booking_resales`
  ADD PRIMARY KEY (`booking_resale_id`);

--
-- Indexes for table `cash_payments`
--
ALTER TABLE `cash_payments`
  ADD PRIMARY KEY (`cash_payments`);

--
-- Indexes for table `check_payments`
--
ALTER TABLE `check_payments`
  ADD PRIMARY KEY (`check_payments`);

--
-- Indexes for table `commission`
--
ALTER TABLE `commission`
  ADD PRIMARY KEY (`commission_id`);

--
-- Indexes for table `commission_payouts`
--
ALTER TABLE `commission_payouts`
  ADD PRIMARY KEY (`commission_payout_id`);

--
-- Indexes for table `commission_temps`
--
ALTER TABLE `commission_temps`
  ADD PRIMARY KEY (`TempCommissionId`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `company_attributes`
--
ALTER TABLE `company_attributes`
  ADD PRIMARY KEY (`company_attribute_id`);

--
-- Indexes for table `company_branches`
--
ALTER TABLE `company_branches`
  ADD PRIMARY KEY (`company_branch_id`);

--
-- Indexes for table `configurations`
--
ALTER TABLE `configurations`
  ADD PRIMARY KEY (`ConfigurationId`);

--
-- Indexes for table `developmentchargepayments`
--
ALTER TABLE `developmentchargepayments`
  ADD PRIMARY KEY (`devchargepaymentid`);

--
-- Indexes for table `developmentcharges`
--
ALTER TABLE `developmentcharges`
  ADD PRIMARY KEY (`devchargesid`);

--
-- Indexes for table `emi_lists`
--
ALTER TABLE `emi_lists`
  ADD PRIMARY KEY (`emi_list_id`);

--
-- Indexes for table `equiries`
--
ALTER TABLE `equiries`
  ADD PRIMARY KEY (`enquiryid`);

--
-- Indexes for table `expanses`
--
ALTER TABLE `expanses`
  ADD PRIMARY KEY (`expanses_id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`LeadsId`);

--
-- Indexes for table `leads_calls`
--
ALTER TABLE `leads_calls`
  ADD PRIMARY KEY (`LeadCallId`);

--
-- Indexes for table `lead_call_reschedules`
--
ALTER TABLE `lead_call_reschedules`
  ADD PRIMARY KEY (`LeadCallRescheduleId`);

--
-- Indexes for table `lead_requirements`
--
ALTER TABLE `lead_requirements`
  ADD PRIMARY KEY (`LeadRequirementID`);

--
-- Indexes for table `lead_stages`
--
ALTER TABLE `lead_stages`
  ADD PRIMARY KEY (`LeadStageId`);

--
-- Indexes for table `loginlogs`
--
ALTER TABLE `loginlogs`
  ADD PRIMARY KEY (`LogId`);

--
-- Indexes for table `module_controls`
--
ALTER TABLE `module_controls`
  ADD PRIMARY KEY (`modulecontrolid`);

--
-- Indexes for table `module_list`
--
ALTER TABLE `module_list`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notificationid`);

--
-- Indexes for table `online_payments`
--
ALTER TABLE `online_payments`
  ADD PRIMARY KEY (`online_payments_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`PagesId`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`Projects_id`);

--
-- Indexes for table `projects_floors`
--
ALTER TABLE `projects_floors`
  ADD PRIMARY KEY (`projects_floors_id`);

--
-- Indexes for table `project_blocks`
--
ALTER TABLE `project_blocks`
  ADD PRIMARY KEY (`project_block_id`);

--
-- Indexes for table `project_media_files`
--
ALTER TABLE `project_media_files`
  ADD PRIMARY KEY (`ProjectMediaFileId`);

--
-- Indexes for table `project_stages`
--
ALTER TABLE `project_stages`
  ADD PRIMARY KEY (`ProjectStageId`);

--
-- Indexes for table `project_types`
--
ALTER TABLE `project_types`
  ADD PRIMARY KEY (`project_type_id`);

--
-- Indexes for table `project_units`
--
ALTER TABLE `project_units`
  ADD PRIMARY KEY (`project_units_id`);

--
-- Indexes for table `project_unit_attributes`
--
ALTER TABLE `project_unit_attributes`
  ADD PRIMARY KEY (`ProjectUnitAttributeId`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`sliderid`);

--
-- Indexes for table `sociallinks`
--
ALTER TABLE `sociallinks`
  ADD PRIMARY KEY (`linkid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usertypes`
--
ALTER TABLE `usertypes`
  ADD PRIMARY KEY (`UserTypeId`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`user_address_id`);

--
-- Indexes for table `user_attandances`
--
ALTER TABLE `user_attandances`
  ADD PRIMARY KEY (`UserAttandanceId`);

--
-- Indexes for table `user_attributes`
--
ALTER TABLE `user_attributes`
  ADD PRIMARY KEY (`user_attribute_id`);

--
-- Indexes for table `user_bank_details`
--
ALTER TABLE `user_bank_details`
  ADD PRIMARY KEY (`UserBankDetailsId`);

--
-- Indexes for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `user_employments`
--
ALTER TABLE `user_employments`
  ADD PRIMARY KEY (`UserEmploymentsId`);

--
-- Indexes for table `user_pay_scale`
--
ALTER TABLE `user_pay_scale`
  ADD PRIMARY KEY (`UserPayScaleId`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `user_transactions`
--
ALTER TABLE `user_transactions`
  ADD PRIMARY KEY (`UserTxnid`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`vendor_id`);

--
-- Indexes for table `vendor_materials`
--
ALTER TABLE `vendor_materials`
  ADD PRIMARY KEY (`vendor_material_id`);

--
-- Indexes for table `vendor_material_items`
--
ALTER TABLE `vendor_material_items`
  ADD PRIMARY KEY (`vendor_material_item_id`);

--
-- Indexes for table `vendor_transactions`
--
ALTER TABLE `vendor_transactions`
  ADD PRIMARY KEY (`vendor_transactions_id`);

--
-- Indexes for table `walkins`
--
ALTER TABLE `walkins`
  ADD PRIMARY KEY (`walkinsid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activitytrack`
--
ALTER TABLE `activitytrack`
  MODIFY `ActivityId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `AssetsId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `bookingid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `booking_alloties`
--
ALTER TABLE `booking_alloties`
  MODIFY `BookingAllotyId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_alloty_documents`
--
ALTER TABLE `booking_alloty_documents`
  MODIFY `BookingAlloteeDocId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_cancelled`
--
ALTER TABLE `booking_cancelled`
  MODIFY `BookingCancelledId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `booking_emis`
--
ALTER TABLE `booking_emis`
  MODIFY `emi_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `booking_loans`
--
ALTER TABLE `booking_loans`
  MODIFY `booking_loan_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `booking_pay_req`
--
ALTER TABLE `booking_pay_req`
  MODIFY `PaymentRequestId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_refund`
--
ALTER TABLE `booking_refund`
  MODIFY `BookingRefundId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `booking_resales`
--
ALTER TABLE `booking_resales`
  MODIFY `booking_resale_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_payments`
--
ALTER TABLE `cash_payments`
  MODIFY `cash_payments` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `check_payments`
--
ALTER TABLE `check_payments`
  MODIFY `check_payments` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commission`
--
ALTER TABLE `commission`
  MODIFY `commission_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `commission_payouts`
--
ALTER TABLE `commission_payouts`
  MODIFY `commission_payout_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `commission_temps`
--
ALTER TABLE `commission_temps`
  MODIFY `TempCommissionId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_attributes`
--
ALTER TABLE `company_attributes`
  MODIFY `company_attribute_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `company_branches`
--
ALTER TABLE `company_branches`
  MODIFY `company_branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `configurations`
--
ALTER TABLE `configurations`
  MODIFY `ConfigurationId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `developmentchargepayments`
--
ALTER TABLE `developmentchargepayments`
  MODIFY `devchargepaymentid` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `developmentcharges`
--
ALTER TABLE `developmentcharges`
  MODIFY `devchargesid` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emi_lists`
--
ALTER TABLE `emi_lists`
  MODIFY `emi_list_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `equiries`
--
ALTER TABLE `equiries`
  MODIFY `enquiryid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expanses`
--
ALTER TABLE `expanses`
  MODIFY `expanses_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `LeadsId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leads_calls`
--
ALTER TABLE `leads_calls`
  MODIFY `LeadCallId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_call_reschedules`
--
ALTER TABLE `lead_call_reschedules`
  MODIFY `LeadCallRescheduleId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_requirements`
--
ALTER TABLE `lead_requirements`
  MODIFY `LeadRequirementID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_stages`
--
ALTER TABLE `lead_stages`
  MODIFY `LeadStageId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loginlogs`
--
ALTER TABLE `loginlogs`
  MODIFY `LogId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_controls`
--
ALTER TABLE `module_controls`
  MODIFY `modulecontrolid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `module_list`
--
ALTER TABLE `module_list`
  MODIFY `module_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notificationid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_payments`
--
ALTER TABLE `online_payments`
  MODIFY `online_payments_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `PagesId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `Projects_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `projects_floors`
--
ALTER TABLE `projects_floors`
  MODIFY `projects_floors_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `project_blocks`
--
ALTER TABLE `project_blocks`
  MODIFY `project_block_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `project_media_files`
--
ALTER TABLE `project_media_files`
  MODIFY `ProjectMediaFileId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_stages`
--
ALTER TABLE `project_stages`
  MODIFY `ProjectStageId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_types`
--
ALTER TABLE `project_types`
  MODIFY `project_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `project_units`
--
ALTER TABLE `project_units`
  MODIFY `project_units_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `project_unit_attributes`
--
ALTER TABLE `project_unit_attributes`
  MODIFY `ProjectUnitAttributeId` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `sliderid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `sociallinks`
--
ALTER TABLE `sociallinks`
  MODIFY `linkid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `user_address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_attandances`
--
ALTER TABLE `user_attandances`
  MODIFY `UserAttandanceId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_attributes`
--
ALTER TABLE `user_attributes`
  MODIFY `user_attribute_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_bank_details`
--
ALTER TABLE `user_bank_details`
  MODIFY `UserBankDetailsId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_documents`
--
ALTER TABLE `user_documents`
  MODIFY `document_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_employments`
--
ALTER TABLE `user_employments`
  MODIFY `UserEmploymentsId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_pay_scale`
--
ALTER TABLE `user_pay_scale`
  MODIFY `UserPayScaleId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_transactions`
--
ALTER TABLE `user_transactions`
  MODIFY `UserTxnid` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `vendor_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vendor_materials`
--
ALTER TABLE `vendor_materials`
  MODIFY `vendor_material_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vendor_material_items`
--
ALTER TABLE `vendor_material_items`
  MODIFY `vendor_material_item_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vendor_transactions`
--
ALTER TABLE `vendor_transactions`
  MODIFY `vendor_transactions_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `walkins`
--
ALTER TABLE `walkins`
  MODIFY `walkinsid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
