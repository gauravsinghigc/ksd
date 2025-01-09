<?php
//foreach loop html tag attribute display
function LOOP_TagsAttributes($data)
{
  foreach ($data as $key => $values) {
    echo "$key='$values'";
  }
}

//remove space
function RemoveSpace($string)
{
  $string = str_replace(' ', '-', $string);
  if ($string == null) {
    return null;
  } else {
    return $string;
  }
}

//lowercase all words
function LowerCase($string)
{
  $string = strtolower($string);
  if ($string == null) {
    return null;
  } else {
    return $string;
  }
}
//lowercase all words
function UpperCase($string)
{
  $string = strtoupper($string);
  if ($string == null) {
    return null;
  } else {
    return $string;
  }
}

//display data null or data
function Data($data)
{
  if ($data == null || $data == "" || $data == " " || $data == "  ") {
    return "";
  } else {
    return $data;
  }
}


//getworkdays
function CountWorkingDays($startdate, $endate)
{

  $workingDays = 0;
  $startTimestamp = strtotime($startdate);
  $endTimestamp = strtotime($endate);
  for ($i = $startTimestamp; $i <= $endTimestamp; $i = $i + (60 * 60 * 24)) {
    if (date("N", $i) <= 5) $workingDays = $workingDays + 1;
  }
  return $workingDays;
}

//get weekend days
function CountNonWorkingDays($startDate, $endDate)
{
  $weekendDays = 0;
  $startTimestamp = strtotime($startDate);
  $endTimestamp = strtotime($endDate);
  for ($i = $startTimestamp; $i <= $endTimestamp; $i = $i + (60 * 60 * 24)) {
    if (date("N", $i) > 5) $weekendDays = $weekendDays + 1;
  }
  return $weekendDays;
}


//function GetDays from current date
function GetDays($fromdate)
{
  $ProjectDueDate = $fromdate;
  $TodayDate = strtotime(RequestDataTypeDate());
  $ProjectDaysLefts = strtotime($ProjectDueDate);
  $DaysLeft = (int)$ProjectDaysLefts - (int)$TodayDate;
  $TimeLeft = round($DaysLeft / (60 * 60 * 24));

  return $TimeLeft;
}

//get hours
function GetHours($starttime, $endtime)
{
  $hours = round((strtotime($endtime) - strtotime($starttime)) / 3600, 1);

  return $hours;
}


//GET numbers from strings
function GetNumbers($strings)
{
  if ($strings == null) {
    $return = 0;
  } else {
    // Use regular expression to remove non-numeric and non-decimal characters and convert to float
    $return = floatval(preg_replace('/[^0-9.]+/', '', $strings));
  }

  return $return;
}

//All bank names
define(
  "BANK_LIST",
  [
    "SELECT BANK ",
    "ABHYUDAYA CO-OP BANK LTD",
    "ABU DHABI COMMERCIAL BANK",
    "AKOLA DISTRICT CENTRAL CO-OPERATIVE BANK",
    "AKOLA JANATA COMMERCIAL COOPERATIVE BANK",
    "ALLAHABAD BANK",
    "ALMORA URBAN CO-OPERATIVE BANK LTD.",
    "ANDHRA BANK",
    "ANDHRA PRAGATHI GRAMEENA BANK",
    "APNA SAHAKARI BANK LTD",
    "AUSTRALIA AND NEW ZEALAND BANKING GROUP LIMITED.",
    "AXIS BANK",
    "BANK INTERNASIONAL INDONESIA",
    "BANK OF AMERICA",
    "BANK OF BAHRAIN AND KUWAIT",
    "BANK OF BARODA",
    "BANK OF CEYLON",
    "BANK OF INDIA",
    "BANK OF MAHARASHTRA",
    "BANK OF TOKYO-MITSUBISHI UFJ LTD.",
    "BARCLAYS BANK PLC",
    "BASSEIN CATHOLIC CO-OP BANK LTD",
    "BHARATIYA MAHILA BANK LIMITED",
    "BNP PARIBAS",
    "CALYON BANK",
    "CANARA BANK",
    "CAPITAL LOCAL AREA BANK LTD.",
    "CATHOLIC SYRIAN BANK LTD.",
    "CENTRAL BANK OF INDIA",
    "CHINATRUST COMMERCIAL BANK",
    "CITIBANK NA",
    "CITIZENCREDIT CO-OPERATIVE BANK LTD",
    "CITY UNION BANK LTD",
    "COMMONWEALTH BANK OF AUSTRALIA",
    "CORPORATION BANK",
    "CREDIT SUISSE AG",
    "DBS BANK LTD",
    "DENA BANK",
    "DEUTSCHE BANK",
    "DEUTSCHE SECURITIES INDIA PRIVATE LIMITED",
    "DEVELOPMENT CREDIT BANK LIMITED",
    "DHANLAXMI BANK LTD",
    "DICGC",
    "DOMBIVLI NAGARI SAHAKARI BANK LIMITED",
    "FIRSTRAND BANK LIMITED",
    "GOPINATH PATIL PARSIK JANATA SAHAKARI BANK LTD",
    "GURGAON GRAMIN BANK",
    "HDFC BANK LTD",
    "HSBC",
    "ICICI BANK LTD",
    "IDBI BANK LTD",
    "IDRBT",
    "INDIAN BANK",
    "INDIAN OVERSEAS BANK",
    "INDUSIND BANK LTD",
    "INDUSTRIAL AND COMMERCIAL BANK OF CHINA LIMITED",
    "ING VYSYA BANK LTD",
    "JALGAON JANATA SAHKARI BANK LTD",
    "JANAKALYAN SAHAKARI BANK LTD",
    "JANASEVA SAHAKARI BANK (BORIVLI) LTD",
    "JANASEVA SAHAKARI BANK LTD. PUNE",
    "JANATA SAHAKARI BANK LTD (PUNE)",
    "JPMORGAN CHASE BANK N.A",
    "KALLAPPANNA AWADE ICH JANATA S BANK",
    "KAPOL CO OP BANK",
    "KARNATAKA BANK LTD",
    "KARNATAKA VIKAS GRAMEENA BANK",
    "KARUR VYSYA BANK",
    "KOTAK MAHINDRA BANK",
    "KURMANCHAL NAGAR SAHKARI BANK LTD",
    "MAHANAGAR CO-OP BANK LTD",
    "MAHARASHTRA STATE CO OPERATIVE BANK",
    "MASHREQBANK PSC",
    "MIZUHO CORPORATE BANK LTD",
    "MUMBAI DISTRICT CENTRAL CO-OP. BANK LTD.",
    "NAGPUR NAGRIK SAHAKARI BANK LTD",
    "NATIONAL AUSTRALIA BANK",
    "NEW INDIA CO-OPERATIVE BANK LTD.",
    "NKGSB CO-OP BANK LTD",
    "NORTH MALABAR GRAMIN BANK",
    "NUTAN NAGARIK SAHAKARI BANK LTD",
    "OMAN INTERNATIONAL BANK SAOG",
    "ORIENTAL BANK OF COMMERCE",
    "PARSIK JANATA SAHAKARI BANK LTD",
    "PRATHAMA BANK",
    "PRIME CO OPERATIVE BANK LTD",
    "PUNJAB AND MAHARASHTRA CO-OP BANK LTD.",
    "PUNJAB AND SIND BANK",
    "PUNJAB NATIONAL BANK",
    "RABOBANK INTERNATIONAL (CCRB)",
    "RAJGURUNAGAR SAHAKARI BANK LTD.",
    "RAJKOT NAGARIK SAHAKARI BANK LTD",
    "RESERVE BANK OF INDIA",
    "SBERBANK",
    "SHINHAN BANK",
    "SHRI CHHATRAPATI RAJARSHI SHAHU URBAN CO-OP BANK LTD",
    "SOCIETE GENERALE",
    "SOLAPUR JANATA SAHKARI BANK LTD.SOLAPUR",
    "SOUTH INDIAN BANK",
    "STANDARD CHARTERED BANK",
    "STATE BANK OF BIKANER AND JAIPUR",
    "STATE BANK OF HYDERABAD",
    "STATE BANK OF INDIA",
    "STATE BANK OF MAURITIUS LTD",
    "STATE BANK OF MYSORE",
    "STATE BANK OF PATIALA",
    "STATE BANK OF TRAVANCORE",
    "SUMITOMO MITSUI BANKING CORPORATION",
    "SYNDICATE BANK",
    "TAMILNAD MERCANTILE BANK LTD",
    "THANE BHARAT SAHAKARI BANK LTD",
    "THE A.P. MAHESH CO-OP URBAN BANK LTD.",
    "THE AHMEDABAD MERCANTILE CO-OPERATIVE BANK LTD.",
    "THE ANDHRA PRADESH STATE COOP BANK LTD",
    "THE BANK OF NOVA SCOTIA",
    "THE BANK OF RAJASTHAN LTD",
    "THE BHARAT CO-OPERATIVE BANK (MUMBAI) LTD",
    "THE COSMOS CO-OPERATIVE BANK LTD.",
    "THE DELHI STATE COOPERATIVE BANK LTD.",
    "THE FEDERAL BANK LTD",
    "THE GADCHIROLI DISTRICT CENTRAL COOPERATIVE BANK LTD",
    "THE GREATER BOMBAY CO-OP. BANK LTD",
    "THE GUJARAT STATE CO-OPERATIVE BANK LTD",
    "THE JALGAON PEOPLES CO-OP BANK",
    "THE JAMMU AND KASHMIR BANK LTD",
    "THE KALUPUR COMMERCIAL CO. OP. BANK LTD.",
    "THE KALYAN JANATA SAHAKARI BANK LTD.",
    "THE KANGRA CENTRAL CO-OPERATIVE BANK LTD",
    "THE KANGRA COOPERATIVE BANK LTD",
    "THE KARAD URBAN CO-OP BANK LTD",
    "THE KARNATAKA STATE APEX COOP. BANK LTD.",
    "THE LAKSHMI VILAS BANK LTD",
    "THE MEHSANA URBAN COOPERATIVE BANK LTD",
    "THE MUNICIPAL CO OPERATIVE BANK LTD MUMBAI",
    "THE NAINITAL BANK LIMITED",
    "THE NASIK MERCHANTS CO-OP BANK LTD. NASHIK",
    "THE RAJASTHAN STATE COOPERATIVE BANK LTD.",
    "THE RATNAKAR BANK LTD",
    "THE ROYAL BANK OF SCOTLAND N.V",
    "THE SAHEBRAO DESHMUKH CO-OP. BANK LTD.",
    "THE SARASWAT CO-OPERATIVE BANK LTD",
    "THE SEVA VIKAS CO-OPERATIVE BANK LTD (SVB)",
    "THE SHAMRAO VITHAL CO-OPERATIVE BANK LTD",
    "THE SURAT DISTRICT CO OPERATIVE BANK LTD.",
    "THE SURAT PEOPLES CO-OP BANK LTD",
    "THE SUTEX CO.OP. BANK LTD.",
    "THE TAMILNADU STATE APEX COOPERATIVE BANK LIMITED",
    "THE THANE DISTRICT CENTRAL CO-OP BANK LTD",
    "THE THANE JANATA SAHAKARI BANK LTD",
    "THE VARACHHA CO-OP. BANK LTD.",
    "THE VISHWESHWAR SAHAKARI BANK LTD. PUNE",
    "THE WEST BENGAL STATE COOPERATIVE BANK LTD",
    "TJSB SAHAKARI BANK LTD.",
    "TUMKUR GRAIN MERCHANTS COOPERATIVE BANK LTD.",
    "UBS AG",
    "UCO BANK",
    "UNION BANK OF INDIA",
    "UNITED BANK OF INDIA",
    "UNITED OVERSEAS BANK",
    "VASAI VIKAS SAHAKARI BANK LTD.",
    "VIJAYA BANK",
    "WEST BENGAL STATE COOPERATIVE BANK",
    "WESTPAC BANKING CORPORATION",
    "WOORI BANK",
    "YES BANK LTD",
    "ZILA SAHKARI BANK LTD GHAZIABAD",
  ]
);
DEFINE("DEFAULT_RECORD_LISTING", 30);
//function get serial nos
function SerialNo()
{
  $SerialNo = 0;
  if (isset($_GET['view_page'])) {
    $view_page = $_GET['view_page'];
    if ($view_page == 1) {
      $SerialNo = 0;
    } else {
      $SerialNo = DEFAULT_RECORD_LISTING * ($view_page - 1);
    }
  } else {
    $SerialNo = $SerialNo;
  }

  return $SerialNo;
}
//pagination Headers
function listingstartfrom($Return = null)
{
  $RecordLimit = (int)DEFAULT_RECORD_LISTING;

  $page = 1;
  // Get current page number
  if (isset($_GET["view_page"])) {
    $page = $_GET["view_page"];
  } else {
    $page = 1;
  }
  $value = $page - 1;
  $start = $value * $RecordLimit;

  if ($Return == null) {
    return null;
  } else {
    if ($Return == "start") {
      return $start;
    } elseif ($Return == "end") {
      return $RecordLimit;
    }
  }
}

//pagination footers
function PaginationFooter(int $TotalItems = 0, $RedirectForAll = "index.php")
{

  $RecordLimit = DEFAULT_RECORD_LISTING;

  // Get current page number
  if (isset($_GET["view_page"])) {
    $page = $_GET["view_page"];
  } else {
    $page = 1;
  }


  $next_page = ($page + 1);
  $previous_page = ($page - 1);
  $NetPages = round(($TotalItems / $RecordLimit) + 0.5);
  if ($NetPages == 1) {
    $next_page = 1;
  }

  if ($previous_page == 0) {
    $previous_page = 1;
  }

  //prepare url parameter and pass with pagination
  $UrlParameters = "";
  if (!empty($_GET)) {
    foreach ($_GET as $key => $value) {
      if ($key != "view_page") {
        $UrlParameters .= "&$key=$value";
      }
    }
  }
?>
  <div class="col-md-12 flex-s-b mt-2 mb-1 pl-0 pr-0">
    <div class="">
      <h6 class="mb-0 mt-1" style="font-size:0.85rem;">Page <b><?php echo IfRequested("GET", "view_page", $page, false); ?></b> from <b><?php echo $NetPages; ?> </b> pages <br>Total <b><?php echo $TotalItems; ?></b> entries</h6>
    </div>
    <div class="flex-s-b">
      <span class="mr-1">
        <a href="?view_page=<?php echo $previous_page . $UrlParameters; ?>" class="btn btn-xs btn-primary"><i class="fa fa-angle-double-left"></i></a>
      </span>
      <form>
        <input type="number" name="view_page" onchange="form.submit()" class="form-control mb-0 fs-12" min="1" max="<?php echo $NetPages; ?>" value="<?php echo IfRequested("GET", "view_page", 1, false); ?>">
      </form>
      <span class="ml-1">
        <a href="?view_page=<?php echo $next_page . $UrlParameters; ?>" class="btn btn-xs btn-primary"><i class="fa fa-angle-double-right"></i></a>
      </span>
      <?php if (isset($_GET['view_page'])) { ?>
        <span class="ml-1">
          <a href="<?php echo $RedirectForAll; ?>" class="btn btn-xs btn-danger mb-0"><i class="fa fa-times"></i></a>
        </span>
      <?php } ?>
    </div>
  </div>
<?php
}

//define constants
define("SERIAL_NO", SerialNo());
define("START_FROM", listingstartfrom("start"));


//show only limited characters
function LimitText($text, $start, $end)
{
  $LimitText = substr($text, $start, $end) . "...";
  $TotalStringVarChar = strlen($LimitText);
  if ($TotalStringVarChar >= $end) {
    $LimitText = substr($text, $start, $end) . "...";
  } else {
    $LimitText = substr($text, $start, $end);
  }
  return $LimitText;
}

//get first word of string
function FirstWord($string)
{
  $start = 0;
  $end = 1;

  $LimitText = substr($string, $start, $end);
  $TotalStringVarChar = strlen($LimitText);
  if ($TotalStringVarChar > $end) {
    $LimitText = substr($string, $start, $end);
  } elseif ($TotalStringVarChar == 0 || $TotalStringVarChar == null || $TotalStringVarChar == "." || $TotalStringVarChar == " ") {
    $LimitText = "O";
  } else {
    $LimitText = substr($string, $start, $end);
  }
  return $LimitText;
}
