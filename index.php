<?PHP
ini_set('display_errors',1);
error_reporting(E_ALL);

$DAYS = array(
	'Monday' => FALSE,
	'Tuesday' => FALSE,
	'Wednesday' => FALSE,
	'Thursday' => FALSE,
	'Friday' => FALSE,
	'Saturday' => FALSE,
	'Sunday' => FALSE,
);
$PAXES = array(
	array("name" => "PAX Prime 2014","timezone" => "America/Los_Angeles","xml" => "http://hw1.pa-cdn.com/pax/resources/xml/GuidebookSchedule.xml"),
	array("name" => "PAX Dev 2014","timezone" => "America/Los_Angeles","xml" => "http://hw1.pa-cdn.com/pax/resources/xml/DevGuidebookSchedule.xml"),
	//array("name" => "PAX South 2015","timezone" => "America/Chicago","xml" => "http://hw1.pa-cdn.com/pax/resources/xml/SouthGuidebookSchedule.xml"),
  //array("name" => "PAX Australia 2014","timezone" => "Australia/Melbourne","xml" => "http://hw1.pa-cdn.com/pax/resources/xml/AusGuidebookSchedule.xml"),
  //array("name" => "PAX East 2015","timezone" => "America/Montreal","xml" => "http://hw1.pa-cdn.com/pax/resources/xml/EastGuidebookSchedule.xml"),
);


include("Event.php");
include("functions.php");
include("cache.php");

$action = isset($_GET["action"]) ? $_GET["action"] : null;

$cache = new Cache();


switch($action){
	case "allEvents":
		if($cache->exists("ical" . $_GET['paxID'])){
			echo outputICal($cache->get("ical") . $paxes[$_get['paxid']]['name']);
		}else{
			$ical = makeICal(parseEvents($_GET['paxID']));
			$cache->setCache("ical" . $_GET['paxID'],$ical);
			echo outputICal($ical);
		}
		break;
	case "form":
		echo form(parseEvents($_GET['paxID']),$_GET['paxID']);
		break;
	case "formSubmit":
		$selectedEvents = formSubmit(parseEvents($_GET['paxID']));
		outputICal(makeICal($selectedEvents));
		break;
	case "about":
		echo about();
		break;
	default:
		echo landing();
}
?>
