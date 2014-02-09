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
			echo "had it";
			echo $cache->get("ical");
		}else{
			echo "set it";
			$ical = iCalOut(parseEvents());
			$cache->setCache("ical",$ical);
			echo $ical;
		}
		break;
	case "form":
		echo form(parseEvents());
		break;
	case "formSubmit":
		$selectedEvents = formSubmit(parseEvents());
		iCalOut($selectedEvents);
		break;
	default:
		echo landing();
}
?>