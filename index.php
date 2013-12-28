<?PHP
include("Event.php");
include("functions.php");

$xmlLocation = "http://hw1.pa-cdn.com/pax/resources/guidebookschedule.xml";
$scheduleData = new SimpleXMLElement($xmlLocation, NULL, TRUE);

$events = array();
foreach($scheduleData->panel as $event){
	$events[] = new Event($event);
}

$action = isset($_GET["action"]) ? $_GET["action"] : null;

switch($action){
	case "allEvents":
		iCalOut($events);
		break;
	case "form":
		echo form($events);
		break;
	case "formSubmit":
		$selectedEvents = formSubmit($events);
		iCalOut($selectedEvents);
		break;
	default:
		echo landing();
}
?>