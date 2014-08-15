<?PHP
ini_set('display_errors',1); 
error_reporting(E_ALL);


$MONDAY = FALSE;
$PAXES = array(
	array("name" => "PAX Prime","timezone" => "America/Los_Angeles","xml" => "http://hw1.pa-cdn.com/pax/resources/xml/GuidebookSchedule.xml"),
	array("name" => "PAX Dev","timezone" => "America/Los_Angeles","xml" => "http://hw1.pa-cdn.com/pax/resources/xml/DevGuidebookSchedule.xml"),
);


include("Event.php");
include("functions.php");
include("cache.php");

$action = isset($_GET["action"]) ? $_GET["action"] : null;

$cache = new Cache();


switch($action){
	case "allEvents":
		//if($cache->exists("ical")){
		//	echo outputICal($cache->get("ical"));
		//}else{
			$ical = makeICal(parseEvents($_GET['paxID']));
		//	$cache->setCache("ical",$ical);
			echo outputICal($ical);
		//}
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
