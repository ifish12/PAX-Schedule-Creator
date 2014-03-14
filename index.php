<?PHP
ini_set('display_errors',1); 
error_reporting(E_ALL);

include("Event.php");
include("functions.php");
include("cache.php");

$action = isset($_GET["action"]) ? $_GET["action"] : null;

$cache = new Cache();


switch($action){
	case "allEvents":
		if($cache->exists("ical")){
			echo outputICal($cache->get("ical"));
		}else{
			$ical = makeICal(parseEvents());
			$cache->setCache("ical",$ical);
			echo outputICal($ical);
		}
		break;
	case "form":
		echo form(parseEvents());
		break;
	case "formSubmit":
		$selectedEvents = formSubmit(parseEvents());
		outputICal(makeICal($selectedEvents));
		break;
	case "about":
		echo about();
		break;
	default:
		echo landing();
}
?>